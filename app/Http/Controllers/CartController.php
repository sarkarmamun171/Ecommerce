<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Inventory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    function cart_store(Request $request){
        $request->validate([
            'color_id'=>'required',
            'size_id'=>'required',
        ]);

        $quantity = Inventory::where('product_id', $request->product_id)->where('color_id', $request->color_id)->where('size_id',$request->size_id)->first()->quantity;
        $quantity_cart = Cart::where('product_id', $request->product_id)->where('color_id', $request->color_id)->where('size_id',$request->size_id)->first()->quantity;
        if($quantity >= ($request->quantity + $quantity_cart)){
            if(Cart::where('customer_id', Auth::guard('cutomer')->id())->where('product_id', $request->product_id)->where('color_id', $request->color_id)->where('size_id',$request->size_id)->exists()){

            Cart::where('customer_id', Auth::guard('cutomer')->id())->where('product_id', $request->product_id)->where('color_id', $request->color_id)->where('size_id',$request->size_id)->increment('quantity', $request->quantity);
            return back()->with('cart_added', 'Cart Incremented Successfully');
        }else{
            Cart::insert([
                'customer_id'=>Auth::guard('cutomer')->id(),
                'product_id'=>$request->product_id,
                'color_id'=>$request->color_id,
                'size_id'=>$request->size_id,
                'quantity'=>$request->quantity,
                'created_at'=>Carbon::now(),
            ]);
            return back()->with('cart_added', 'Cart Added Successfully');
        }
        }else{
            return back()->with('cart_added', 'Sorry!! available stock is = '. $quantity);
        }
    }


    function cart_remove($id){
        Cart::find($id)->delete();
        return back();
    }
    function cart(Request $request){

        $msg = '';
        $type = '';
        $discount = 0;

        $coupon = $request->coupon;

        if(isset($coupon)){
            if(Coupon::where('coupon', $coupon)->exists()){
                if(Carbon::now()->format('Y-m-d') <= Coupon::where('coupon', $coupon)->first()->validity){
                    if(Coupon::where('coupon', $coupon)->first()->limit){
                        $type = Coupon::where('coupon', $coupon)->first()->type;
                        $discount = Coupon::where('coupon', $coupon)->first()->amount;
                    }else{
                        $msg = 'Coupon Code Limit Exceed';
                    }
                }else{
                    $msg = 'Coupon date has expired!';
                    $discount = 0;
                }
            }else{
                $msg = 'Invalid Coupon Code!';
                $discount = 0;
            }

        }

        $carts = Cart::where('customer_id', Auth::guard('cutomer')->id())->get();
        return view('frontend.customer.cart',[
            'carts'=>$carts,
            'msg'=>$msg,
            'discount'=>$discount,
            'type'=>$type,
        ]);
    }
    function cart_update(Request $request){
        foreach($request->quantity as $cart_id=>$quantity){
            Cart::find($cart_id)->update([
                'quantity' => $quantity,
            ]);
        }
        return back();
    }
}
