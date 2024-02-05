<?php

namespace App\Http\Controllers;

use App\Models\Cutomer;
use App\Models\EmailVerify;
use App\Notifications\CustomerEmailVerifyNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Notification;




class CustomerAuthController extends Controller
{
    function cutomer_login(){

        return view('frontend.customer.customer_login');

    }
    function cutomer_register(){

        return view('frontend.customer.register');

    }
    function customer_store(Request $request){

       $request->validate([
        // 'fname' => 'required',
        // 'email' => 'required',
        // 'current_password' => 'required',
        // 'password' => ['required', 'confirmed', Password::defaults()
        //     ->letters()
        //     ->numbers()
        //     ->mixedCase()
        //     ->symbols()
        // ],
        // 'password_confirmation' => 'required',
        'captcha' => 'required|captcha',
       ]);
    if(Cutomer::where('email', $request->email)->exists()){
        return back()->with('success',"$request->email already exist");
    }else{

        $customer_id = Cutomer::insertGetId([
         'fname'=>$request->fname,
         'lname'=>$request->lname,
         'email'=>$request->email,
         'password'=>bcrypt($request->password),
         'created_at'=>Carbon::now(),
        ]);
        $customer = Cutomer::find($customer_id);
        EmailVerify::where('customer_id', $customer_id)->delete();

        $emailverify_info = EmailVerify::create([
         'customer_id'=>$customer_id,
         'token'=>uniqid(),
         'created_at'=>Carbon::now(),
        ]);

        Notification::send($customer, new CustomerEmailVerifyNotification($emailverify_info));
        return back()->with('success',"Registered Successfully, A Verification link sent to $request->email please verify to login");
    }


    //    if(Auth::guard('cutomer')->attempt(['email' => $request->email, 'password' => $request->password])){
    //        return redirect()->route('index');
    //     }
        //    return back()->with('success', 'Customer Registered Successfully!');

    }

    public function reloadCaptcha()
    {
        return response()->json(['captcha'=> captcha_img()]);
    }

    function customer_login_confirm(Request $request){

        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if(Cutomer::where('email', $request->email)->exists()){
            if(Auth::guard('cutomer')->attempt(['email' => $request->email, 'password' => $request->password])){
                if(Auth::guard('cutomer')->user()->email_verified_at == null){
                    Auth::guard('cutomer')->logout();
                    return back()->with('notverified','Please verify Your Email');
                }else{
                    return redirect()->route('index');
                }
            }
            else{
                return back()->with('exist', 'Wrong Password');
            }
        }
        else{
            return back()->with('exist', 'Email doest not exist');
        }
    }

    function customer_email_verify($token){
        $customer_id = EmailVerify::where('token',$token)->first()->customer_id;
        Cutomer::find($customer_id)->update([
            'email_verified_at' => Carbon::now(),
        ]);
        EmailVerify::where('token', $token)->delete();
        return redirect()->route('cutomer.register')->with('verified','Congratulation Your Email has been verified');
    }


}
