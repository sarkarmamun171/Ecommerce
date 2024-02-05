<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    function coupon(){
        $coupons = Coupon::all();
        return view('admin.coupon.coupon',[
            'coupons'=>$coupons,
        ]);
    }
    function coupon_store(Request $request){

        $request->validate([
            'coupon'=>'required',
            'type'=>'required',
            'amount'=>'required',
            'limit'=>'required',
            'validity'=>'required',
        ]);

        if(Coupon::where('coupon',$request->coupon)->exists()){
            return back()->with('coupon', 'Coupon already created');
        }else{

            Coupon::insert([
                'coupon'=>$request->coupon,
                'type'=>$request->type,
                'amount'=>$request->amount,
                'limit'=>$request->limit,
                'validity'=>$request->validity,
                'created_at'=>Carbon::now(),
            ]);
            return back()->with('coupon', 'Coupon created successfully');
        }

    }

    function CouponchangeStatus(Request $request){
        Coupon::find($request->coupon_id)->update([
            'status'=>$request->status,
        ]);
    }

    function coupon_delete($id){
        Coupon::find($id)->delete();
        return back();
    }
}
