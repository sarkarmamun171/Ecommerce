<?php

namespace App\Http\Controllers;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
// use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Validation\Validator;
use Illuminate\Validation\Rules\Password;

class HomeController extends Controller
{
    function dashboard(){
        return view('dashboard');
    }
    function user_profile(){
        return view('admin.user.user');
    }
    function user_profile_update(Request $request){

        $request->validate([
            'name' => 'required',
            'email' => 'email:rfc,dns | required',
        ]);

        User::find(Auth::id())->update([
            'name'=> $request->user_name,
            'email'=> $request->user_email
        ]);

        return back();
    }
    function password_update(Request $request){

        $request->validate([
            'current_password' => 'required',
            // 'password' => ['required', 'confirmed', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]+$/'],
            'password' => ['required', 'confirmed', Password::defaults()
            ->letters()
            ->numbers()
            ->mixedCase()
            ->numbers()
            ->symbols()
        ],

            'password_confirmation' => 'required',
        ]);

        $user = User::find(Auth::id());
        if(password_verify($request->current_password, $user->password)){
            User::find(Auth::id())->update([
                'password'=>bcrypt($request->password)
            ]);
            return back()->with('pass-update', 'Password Updated!');
        }
        else{
            return back()->with('current-pass', 'Wrong Current Password');
        }

        // return back();
    }//end method



    function user_photo_update(Request $request){

        Validator::validate($request->all(), [
            'photo' => [
                'required',
                File::image()
                    ->types(['png', 'jpg', 'jpeg'])
                    ->min(50)
                    ->max(500)
                    ->dimensions(
                        Rule::dimensions()
                            ->maxWidth(1000)
                            ->maxHeight(1000)
                    )
            ]
        ]);

        // $request->validate([
        //     'photo'=>'required | mimes:png,jpg ',

        // ]);


        if(Auth::user()->photo == null){
            $photo = $request->photo;
            $extension = $photo->extension();
            $filename = Auth::id().".".$extension;
            $image = Image::make($photo)->resize(300, 200)->save(public_path('uploads/user/'.$filename));

            User::find(Auth::id())->update([
                'photo'=> $filename,
            ]);
            return back()->with('photo-update', 'Photo Updated Successfully!');
        }
        else{
            $present_photo = public_path(('uploads/user/').Auth::user()->photo);
            unlink($present_photo);

            $photo = $request->photo;
            $extension = $photo->extension();
            $filename = Auth::id().".".$extension;
            $image = Image::make($photo)->resize(300, 200)->save(public_path('uploads/user/'.$filename));

            User::find(Auth::id())->update([
                'photo'=> $filename,
            ]);
            return back()->with('photo-update', 'Photo Updated Successfully!');
        }




   }





}
