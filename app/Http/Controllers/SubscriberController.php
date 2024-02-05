<?php

namespace App\Http\Controllers;

use App\Mail\Newsletter;
use App\Models\Subscriber;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SubscriberController extends Controller
{
    public function subscriber_store(Request $request ){
        Subscriber::insert([
            'email' => $request->email,
            'created_at' => Carbon::now(),
        ]);

        return redirect()->route('index', '#subs')->with('subs', "Subscribed Successfully");
    }

    function subscriber(){
        $subscribers = Subscriber::all();
        return view("admin.subscriber.subs_list",[
            'subscribers' => $subscribers,
        ]);
    }

    function send_newsletter($id){
        $subs = Subscriber::find($id);
        Mail::to($subs->email)->send(new Newsletter($subs));
        return back()->with('success', "Newsletter Sent Successfully to $subs->email");
    }

}
