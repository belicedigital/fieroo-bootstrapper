<?php

namespace Fieroo\Bootstrapper\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use Fieroo\Bootstrapper\Rules\MatchOldPassword;
use App\Rules\MatchOldPassword;
use Fieroo\Bootstrapper\Models\User;
use Validator;
use Hash;
use Auth;
use DB;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userData = DB::table('users')->where('id','=',auth()->user()->id)->first();
        
        if(auth()->user()->roles->first()->name == 'espositore') {
            $userData = DB::table('exhibitors_data')
                ->leftJoin('exhibitors', 'exhibitors_data.exhibitor_id', '=', 'exhibitors.id')
                ->leftJoin('users', 'exhibitors.user_id', '=', 'users.id')
                ->where('users.id', '=', auth()->user()->id)
                ->select('exhibitors_data.*', 'users.email')
                ->first();
        }
        return view('bootstrapper::profile', ['userData' => $userData]);
    }

    public function changePassword(Request $request)
    {
        $response = [
            'status' => false,
            'message' => trans('api.error_general')
        ];

        try {
            $id = Auth::user()->id;
            $validator = Validator::make($request->all(), [
                'password' => ['required', 'string', 'min:8', new MatchOldPassword],
                'new_password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);
    
            if ($validator->fails()) {
                $response['message'] = trans('api.error_validation');
                return response()->json($response);
            }

            User::find($id)->update(['password'=> Hash::make($request->new_password)]);

            $response['message'] = trans('messages.password_changed');
            $response['status'] = true;
            return response()->json($response);
        } catch(\Exception $e){
            $response['message'] = $e->getMessage();
            return response()->json($response);
        }
    }

    public function saveData(Request $request)
    {
        $response = [
            'status' => false,
            'message' => trans('api.error_general')
        ];

        try {
            $id = Auth::user()->id;
            $exhibitor = DB::table('exhibitors')->where('user_id', '=', $id)->first();
            $obj = trans('entities.exhibitor');
            if(!is_object($exhibitor)) {
                $response['message'] = trans('api.obj_not_found', ['obj' => $obj]);
                return response()->json($response);
            }
            $exhibitor_data_q = DB::table('exhibitors_data')->where('exhibitor_id', '=', $exhibitor->id);
            $exhibitor_data = $exhibitor_data_q->first();
            if(!is_object($exhibitor_data)) {
                $response['message'] = trans('api.obj_not_found', ['obj' => $obj.' data']);
                return response()->json($response);
            }

            // start userData validation
            $validation_data = [
                'email' => ['required', 'email:rfc,dns', 'unique:users,email,'.$id],
                'company' => ['required', 'string', 'max:255'],
                'address' => ['required', 'string', 'max:255'],
                'civic_number' => ['required', 'string', 'max:255'],
                'city' => ['required', 'string', 'max:255'],
                'cap' => ['required', 'string', 'max:255'],
                'province' => ['required', 'string', 'max:255'],
                'phone' => ['required', 'string', 'max:255'],
                'responsible' => ['required', 'string', 'max:255'],
                'phone_responsible' => ['required', 'string', 'max:255'],
                'diff_billing' => ['required', 'boolean'],
                'vat_number' => ['required', 'unique:exhibitors_data,vat_number,'.$exhibitor_data->id]
            ];
    
            $validator = Validator::make($request->all(), $validation_data);
    
            if ($validator->fails()) {
                $response['message'] = trans('api.error_validation');
                return response()->json($response);
            }
            // end userData validation

            $exhibitor_data_q->update([
                'company' => $request->company,
                'address' => $request->address,
                'civic_number' => $request->civic_number,
                'city' => $request->city,
                'cap' => $request->cap,
                'province' => $request->province,
                'phone' => $request->phone,
                'fax' => $request->fax,
                'web' => $request->web,
                'responsible' => $request->responsible,
                'phone_responsible' => $request->phone_responsible,
                'email_responsible' => $request->email,
                'fiscal_code' => $request->fiscal_code,
                'vat_number' => $request->vat_number,
                'uni_code' => $request->uni_code,
                'receiver' => $request->receiver,
                'receiver_address' => $request->receiver_address,
                'receiver_civic_number' => $request->receiver_civic_number,
                'receiver_city' => $request->receiver_city,
                'receiver_cap' => $request->receiver_cap,
                'receiver_province' => $request->receiver_province,
                'receiver_fiscal_code' => $request->receiver_fiscal_code,
                'receiver_vat_number' => $request->receiver_vat_number,
                'receiver_uni_code' => $request->receiver_uni_code,
                'diff_billing' => $request->diff_billing,
                'updated_at' => DB::raw('NOW()')
            ]);

            // start validate password
            if(strlen($request->new_password) > 0) {
                $p_validator = Validator::make($request->all(), [
                    'password' => ['required', 'string', 'min:8', new MatchOldPassword],
                    'new_password' => ['required', 'string', 'min:8', 'confirmed'],
                ]);
        
                if ($p_validator->fails()) {
                    $response['message'] = trans('api.error_validation');
                    return response()->json($response);
                }

                User::find($id)->update(['password'=> Hash::make($request->new_password)]);
            }
            // end validate password

            // update email
            User::find($id)->update(['email'=> $request->email]);

            $response['message'] = trans('api.task_success', ['task' => trans('generals.saving')]);
            $response['status'] = true;
            return response()->json($response);
        } catch(\Exception $e){
            $response['message'] = $e->getMessage();
            return response()->json($response);
        }
    }
}
