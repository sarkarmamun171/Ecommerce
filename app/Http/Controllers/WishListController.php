<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Inventory;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class WishListController extends Controller
{
    function wishlist_store(Request $request){
        $quantity = Inventory::where('product_id', $request->product_id)->where('color_id', $request->color_id)->where('size_id',$request->size_id)->first()->quantity;
        $quantity_wish = Wishlist::where('product_id', $request->product_id)->where('color_id', $request->color_id)->where('size_id',$request->size_id)->first()->quantity;
        if($quantity >= ($request->quantity + $quantity_wish)){
            if(Wishlist::where('customer_id', Auth::guard('cutomer')->id())->where('product_id', $request->product_id)->where('color_id', $request->color_id)->where('size_id',$request->size_id)->exists()){

                Wishlist::where('customer_id', Auth::guard('cutomer')->id())->where('product_id', $request->product_id)->where('color_id', $request->color_id)->where('size_id',$request->size_id)->increment('quantity', $request->quantity);
                return back()->with('wish_added', 'Wish Incremented Successfully');

            }else{
                Wishlist::insert([
                    'customer_id'=>Auth::guard('cutomer')->id(),
                    'product_id'=>$request->product_id,
                    'color_id'=>$request->color_id,
                    'size_id'=>$request->size_id,
                    'quantity'=>$request->quantity,
                    'created_at'=>Carbon::now(),
                ]);
                return back()->with('wish_added', 'Wish Added Successfully');
        }

    }
        else{
                return back()->with('wish_added', 'Sorry available stock is ='. $quantity);
        }
    }

    function wish_remove($id){
        Wishlist::find($id)->delete();
        return back()->with('wish_removed', 'Wish Removed Successfully');

    }

    function wishlist(){
        $wishlists = Wishlist::where('customer_id', Auth::guard('cutomer')->id())->get();
        return view('frontend.invoice.wishlist',[
            'wishlists' => $wishlists,
        ]);
    }

    function wish_cart($id){
        $info = Wishlist::find($id);
        Cart::insert([
            'customer_id' => $info->customer_id,
            'product_id' => $info->product_id,
            'color_id' => $info->color_id,
            'size_id' => $info->size_id,
            'quantity' => $info->quantity,
            'created_at' => Carbon::now(),
        ]);
        Wishlist::find($id)->delete();
        return back()->with('cart_added', 'Cart Added Successfully');
    }
}


// if same customer, product, color, size are in wishlist table, then just increment quantity other wise insert newly
