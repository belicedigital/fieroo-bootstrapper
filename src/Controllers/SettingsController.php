<?php

namespace Fieroo\Bootstrapper\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Fieroo\Bootstrapper\Models\Setting;
use Illuminate\Support\Facades\App;
use Auth;
use Validator;
use DB;
use Carbon\Carbon;

class SettingsController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $settings = Setting::take(1)->first();
        return view('bootstrapper::settings', ['settings' => $settings]);
    }

    private function _updateData($data)
    {
        return DB::table('settings')->where('id','=',1)->update($data);
    }

    public function saveSettingsGenerals(Request $request)
    {
        $validation_data = [
            'file' => ['mimes:jpeg,bmp,png,gif'],
            'iva' => ['numeric'],
        ];

        $validator = Validator::make($request->all(), $validation_data);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $data = [
                'iva' => $request->iva,
                'updated_at' => DB::raw('NOW()')
            ];
            if($request->hasFile('file')) {
                $settings = Setting::take(1)->first();
                if(file_exists(public_path($settings->logo_path))) {
                    unlink(public_path($settings->logo_path));
                }
                $image = $request->file('file');
                $rename_file = time().'.'.$request->file->getClientOriginalExtension();
                $request->file->move(public_path('/img'), $rename_file);
                $data['logo_path'] = 'img/'.$rename_file;
            }
            self::_updateData($data);
            return redirect()->back()->with('success', trans('forms.saved_success'));

        } catch(\Exception $e) {
            return redirect()
                ->back()
                ->withErrors($e->getMessage())
                ->withInput();
        }
    }

    public function saveSettingsEmails(Request $request)
    {
        $validation_data = [
            'email_pending_admit_exhibitor_it' => ['required'],
            'email_pending_admit_exhibitor_en' => ['required'],
            'email_to_admin_pending_notification_admit' => ['required'],
            'email_admit_exhibitor_it' => ['required'],
            'email_admit_exhibitor_en' => ['required'],
            'email_to_admin_notification_admit' => ['required'],
            'email_confirm_order_it' => ['required'],
            'email_confirm_order_en' => ['required'],
            'email_to_admin_notification_confirm_order' => ['required'],
            'email_event_subscription_it' => ['required'],
            'email_event_subscription_en' => ['required'],
            'email_registration_it' => ['required'],
            'email_registration_en' => ['required'],
            'email_remarketing_it' => ['required'],
            'email_remarketing_en' => ['required'],
        ];

        $validator = Validator::make($request->all(), $validation_data);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            self::_updateData([
                'email_pending_admit_exhibitor_it' => $request->email_pending_admit_exhibitor_it,
                'email_pending_admit_exhibitor_en' => $request->email_pending_admit_exhibitor_en,
                'email_to_admin_pending_notification_admit' => $request->email_to_admin_pending_notification_admit,
                'email_admit_exhibitor_it' => $request->email_admit_exhibitor_it,
                'email_admit_exhibitor_en' => $request->email_admit_exhibitor_en,
                'email_to_admin_notification_admit' => $request->email_to_admin_notification_admit,
                'email_confirm_order_it' => $request->email_confirm_order_it,
                'email_confirm_order_en' => $request->email_confirm_order_en,
                'email_to_admin_notification_confirm_order' => $request->email_to_admin_notification_confirm_order,
                'email_event_subscription_it' => $request->email_event_subscription_it,
                'email_event_subscription_en' => $request->email_event_subscription_en,
                'email_registration_it' => $request->email_registration_it,
                'email_registration_en' => $request->email_registration_en,
                'email_remarketing_it' => $request->email_remarketing_it,
                'email_remarketing_en' => $request->email_remarketing_en,
                'updated_at' => DB::raw('NOW()')
            ]);
            return redirect()->back()->with('success', trans('forms.saved_success'));
        } catch(\Exception $e) {
            return redirect()
                ->back()
                ->withErrors($e->getMessage())
                ->withInput();
        }
    }
}
