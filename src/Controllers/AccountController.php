<?php

namespace Fieroo\Bootstrapper\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Fieroo\Bootstrapper\Models\Setting;
use Fieroo\Bootstrapper\Models\User;
use Spatie\Permission\Models\Permission;
use Fieroo\Exhibitors\Models\Exhibitor;
use Fieroo\Exhibitors\Models\Category;
use Session;
use Validator;
use Hash;
use Auth;
use Mail;
use App;

class AccountController extends Controller
{
    public function confirmAccount($id)
    {
        Auth::logout();
        $user = User::find($id);

        if(strlen($user->email_verified_at) > 0) {
            return view('auth.confirm-error')->with('error', 'Questo utente è già stato verificato');
        }

        return view('auth.confirm', ['user' => $user]);
    }

    public function setPassword(Request $request)
    {
        $user = User::findOrFail($request->id);

        $validator = Validator::make($request->all(), [
            'password' => ['required', 'string', 'min:8'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed', 'different:password'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user->update(['password'=> Hash::make($request->new_password), 'email_verified_at' => now()]);

        return redirect('login');
    }

    public function switchLang($lang) {
        App::setLocale($lang);
        Session::put('locale', $lang);
        return redirect()->back();
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email:rfc,dns', 'exists:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $user = User::where('email', '=', $request->email)->first();
            $user->password = Hash::make($request->password);
            $user->save();
            return redirect('login')->with('success', trans('messages.password_changed'));
        } catch(\Exception $e) {
            return redirect()
                ->back()
                ->withErrors($e->getMessage());
        }
    }

    public function registerExhibitor(Request $request)
    {
        try {
            $validation_data = [
                'email' => ['required', 'email', 'unique:exhibitors_data,email_responsible', 'unique:users,email'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'localization' => ['required', 'string', 'max:2'],
            ];
    
            $validator = Validator::make($request->all(), $validation_data);
    
            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            if(!env('UNLIMITED')) {
                // check events limit for subscription
                $request_to_api = Http::get('https://manager-fieroo.belicedigital.com/api/stripe/'.env('CUSTOMER_EMAIL').'/check-limit/max_exhibitors');
                if (!$request_to_api->successful()) {
                    throw new \Exception('API Error on get latest subscription '.$request_to_api->body());
                }
                $result_api = $request_to_api->json();
                if(isset($result_api['value']) && Exhibitor::all()->count() >= $result_api['value']) {
                    throw new \Exception('Non è possibile eseguire la richiesta, il limite di Espositori attivi in piattaforma è stato superato. Contattare l\'Amministrazione per chiarimenti.');
                }
            }

            // create user & relative exhibitor
            $user = User::create([
                'name' => $request->email,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
            $category = Category::where('slug', $request->category)->first();
            dd($category);
            $category_id = null;
            if(is_object($category)) {
                $category_id = $category->id;
            }
            $exhibitor = Exhibitor::create([
                'user_id' => $user->id,
                'locale' => $request->localization,
                'category_id' => $category_id,
            ]);
            $user->assignRole('espositore') && $user->givePermissionTo('expo');

            if(!env('UNLIMITED')) {
                // notify admin for reaching the limit of exhibitors
                if(Exhibitor::all()->count() == $result_api['value']) {
                    $email_from = env('MAIL_FROM_ADDRESS');
                    $email_to = env('CUSTOMER_EMAIL');
                    $subject = trans('emails.exhibitors_limit', [], $request->localization);
                    Mail::send('bootstrapper::emails.notify-to-exhibitors-limit', [], function ($m) use ($email_from, $email_to, $subject) {
                        $m->from($email_from, env('MAIL_FROM_NAME'));
                        $m->to($email_to)->subject(env('APP_NAME').' '.$subject);
                    });
                }
            }
            
            $setting = Setting::take(1)->first();
            $body = formatDataForEmail([
                'name' => $request->email,
                'admin_url' => env('ADMIN_URL'),
            ], $request->localization == 'it' ? $setting->email_registration_it : $setting->email_registration_en);

            $data = [
                'body' => $body
            ];

            $subject = trans('emails.register', [], $request->localization);
            $email_from = env('MAIL_FROM_ADDRESS');
            $email_to = $request->email;
            Mail::send('bootstrapper::emails.form-data', ['data' => $data], function ($m) use ($email_from, $email_to, $subject) {
                $m->from($email_from, env('MAIL_FROM_NAME'));
                $m->to($email_to)->subject(env('APP_NAME').' '.$subject);
            });

            return redirect()->route('login');

        } catch(\Exception $e) {
            return redirect()
                    ->back()
                    ->withErrors($e->getMessage());
        }
    }

    public function registerAdmin(Request $request)
    {
        try {
            $validation_data = [
                'email' => ['required', 'email', 'unique:users,email'],
                'password' => ['required', 'string', 'min:8', 'confirmed']
            ];
    
            $validator = Validator::make($request->all(), $validation_data);
    
            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $user = User::create([
                'name' => $request->email,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
            $user->assignRole('super-admin') && $user->givePermissionTo(Permission::all());

            return redirect()->route('login');

        } catch(\Exception $e) {
            return redirect()
                    ->back()
                    ->withErrors($e->getMessage());
        }
    }
}
