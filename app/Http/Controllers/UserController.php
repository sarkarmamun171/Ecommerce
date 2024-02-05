<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    function user_list(Request $request){

        // $users = User::all();
        $users = User::where('id', '!=', Auth::id())->get();
        return view('admin.user.user_list', compact('users'));
    }

    function user_remove($user_id){
        User::find($user_id)->delete();
        return back()->with('delete', 'User Deleted Successfully!');
    }

    function custom_register(Request $request){
        User::insert([
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=> bcrypt($request->password),
            'created_at'=> Carbon::now(),
        ]);
        return back()->with('success','New User Added');
    }
}
