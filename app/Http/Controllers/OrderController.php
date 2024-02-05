<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    function orders(){
        $orders = Order::latest()->get();
        return view('admin.orders.order',[
            'orders' => $orders,
        ]);
    }

    function order_status_update(Request $request){
        Order::where('order_id', $request->order_id)->update([
            'status'=>$request->status,
        ]);

        if(Order::where('order_id', $request->order_id)->where('cancel_status', 1)){
            Order::where('order_id', $request->order_id)->where('cancel_status', 1)->update([
                'cancel_status' => 2,
            ]);
        }

        $products = OrderProduct::where('order_id', $request->order_id)->get();
        foreach($products as $product){
            Inventory::where('product_id', $product->product_id)->where('color_id', $product->color_id)->where('size_id', $product->size_id)->increment('quantity', $product->quantity);
        }

        return back();
    }

    function order_cancel_req(){
        $cancel_orders = Order::where('cancel_status', 1)->get();
        return view('admin.orders.order_cancel',[
            'cancel_orders' => $cancel_orders,
        ]);


    }
}
