<?php

namespace Fieroo\Bootstrapper\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Fieroo\Bootstrapper\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Auth;
use DB;
use Hash;
use Mail;
use Validator;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation_data = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255', 'unique:users,email'],
            'role_id' => ['required', 'exists:roles,id'],
        ];

        $validator = Validator::make($request->all(), $validation_data);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $password = uniqid();
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($password)
            ]);

            $role = Role::findOrFail($request->role_id);
            $user->assignRole($role->name);
            if($role->name == 'grafico') {
                $user->givePermissionTo(['graphic']);
            } elseif($role->name == 'amministrazione') {
                $user->givePermissionTo(['admin']);
            }

            $data = [
                'name' => $user->name,
                'email' => $user->email,
                'role' => $role->name,
                'password' => $password
            ];

            $email_from = env('MAIL_FROM_ADDRESS');
            $email_to = $user->email;

            Mail::send('emails.new-user', ['data' => $data], function ($m) use ($email_from, $email_to) {
                $m->from($email_from, env('MAIL_FROM_NAME'));
                $m->to($email_to)->subject('Nuova Utenza');
            });

            $entity_name = trans('entities.users');
            return redirect('admin/users')->with('success', trans('forms.created_success',['obj' => $entity_name]));
        } catch(\Exception $e) {
            return redirect()
                ->back()
                ->withErrors($e->getMessage())
                ->withInput();
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validation_data = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255', 'unique:users,email,'.$id],
            'role_id' => ['required', 'exists:roles,id'],
        ];

        $validator = Validator::make($request->all(), $validation_data);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $user = User::findOrFail($id);
            $user_roles = $user->roles->all();
            foreach($user_roles as $role) {
                if($request->role_id != $role->id) {
                    $role_obj = Role::findOrFail($request->role_id);
                    DB::table('model_has_roles')->where('model_id', '=', $id)->delete();
                    DB::table('model_has_permissions')->where('model_id', '=', $id)->delete();
                    $user->assignRole($role_obj->name);
                    if($request->role_id == 6) {
                        $user->givePermissionTo(['graphic']);
                    } else {
                        $user->givePermissionTo(['admin']);
                    }
                }
            }
            $user->name = $request->name;
            $user->email = $request->email;
            
            $user->save();

            $entity_name = trans('entities.users');
            return redirect('admin/users')->with('success', trans('forms.updated_success',['obj' => $entity_name]));
        } catch(\Exception $e) {
            return redirect()
                ->back()
                ->withErrors($e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        $entity_name = trans('entities.user');
        return redirect('admin/users')->with('success', trans('forms.deleted_success',['obj' => $entity_name]));
    }
}
