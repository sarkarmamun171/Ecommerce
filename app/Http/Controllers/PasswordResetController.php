<?php

namespace App\Http\Controllers;

use App\Models\Cutomer;
use App\Models\PasswordReset;
use App\Notifications\PasswordResetNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class PasswordResetController extends Controller
{
    function password_reset(){
        return view('frontend.customer.password_reset_req');
    }

    function passwordreset_request_sent(Request $request){
        // print_r($request->all());
        if(Cutomer::where('email', $request->email)->exists()){
            $customer = Cutomer::where('email', $request->email)->first();
            PasswordReset::where('customer_id', $customer->id)->delete();
            $resetinfo = PasswordReset::create([
                'customer_id' => $customer->id,
                'token'=>uniqid(),
                'created_at' => Carbon::now(),
            ]);

            Notification::send($customer, new PasswordResetNotification($resetinfo));
            return back()->with('success',"Password Reset Request Sent to $request->email");
        }
        else{
            return back()->with('dontexist','Email Does not Exist');
        }
    }

    function passwordreset_form($token){
        return view('frontend.customer.password_reset_form',[
            'token'=> $token,
        ]);
    }

    function password_reset_confirm(Request $request, $token){
        $request->validate([
            'password'=> 'required|confirmed',
            'password_confirmation'=> 'required',
        ]);

        $customer = PasswordReset::where('token', $token)->first();
        if($customer != ''){
            Cutomer::find($customer->customer_id)->update([
                'password'=>bcrypt($request->password),
                'updated_at' => Carbon::now(),
            ]);
        }else{
            return back()->with('reset_already',"Already Reset by this link");
         }

        PasswordReset::where('token', $token)->delete();
        return back()->with('success',"Password Reset Successfully");
    }

}
