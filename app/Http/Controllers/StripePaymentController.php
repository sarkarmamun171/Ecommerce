<?php

namespace App\Http\Controllers;

use App\Models\StripeOrder;
use Illuminate\Http\Request;
use Session;
use Stripe;

use DB;
use App\Library\SslCommerz\SslCommerzNotification;
use App\Models\Sslorder;
use App\Mail\InvoiceMail;
use App\Models\Billing;
use App\Models\Cart;
use App\Models\City;
use App\Models\Country;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Shipping;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class StripePaymentController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe()
    {
        $data = session('data');
            if (!isset($data['ship_check'])) {
                $ship = 1;
            }
            if (isset($data['ship_check'])) {
                $ship = 0;
            }
        // print_r($data);
        // die();
        $stripe_id = StripeOrder::insertGetId([
            'fname' => $data['fname'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'total' => $data['sub'] +  $data['charge'] - $data['discount'] ,

            'address' => $data['address'],

            'lname' => $data['lname'],
            'customer_id' => $data['customer_id'],
            'country' => $data['country'],
            'city' => $data['city'],
            'zip' => $data['zip'],
            'company' => $data['company'],
            'message' => $data['message'],

            'ship_fname' => $data['ship_fname'],
            'ship_lname' => $data['ship_lname'],
            'ship_country' => $data['ship_country'],
            'ship_city' => $data['ship_city'],
            'ship_zip' => $data['ship_zip'],
            'ship_company' => $data['ship_company'],
            'ship_email' => $data['ship_email'],
            'ship_phone' => $data['ship_phone'],
            'ship_address' => $data['ship_address'],
            'charge' => $data['charge'],
            'discount' => $data['discount'],
            'sub_total' => $data['sub'],

            'ship_check' => $ship,



        ]);
        return view('frontend.invoice.stripe',[
            'stripe_id' => $stripe_id,
        ]);
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $stripe_id = $request->stripe_id;



        $data = StripeOrder::find($stripe_id);
        $total = $data->total;
        // print_r($data);
        // echo "<br>";
        // echo str($data->fname);
        // die();
        $order_id = '#'.uniqid().'-'.Carbon::now()->format('Y-m-d');

        Order::insert([
            'order_id' => $order_id,
            'customer_id' => $data->customer_id,
            'discount' => $data->discount,
            'charge' => $data->charge,
            'payment_method' => 3,
            'sub_total' => $data->sub_total,
            'total' => $total,
            'created_at'=>Carbon::now(),
        ]);

        Billing::insert([
            'order_id' => $order_id,
            'customer_id' => $data->customer_id,
            'fname' => $data->fname,
            'lname' => $data->lname,
            'country_id' => $data->country,
            'city_id' => $data->city,
            'zip' => $data->zip,
            'company' => $data->company,
            'email' => $data->email,
            'phone' => $data->phone,
            'address' => $data->address,
            'message' => $data->message,
            'created_at'=>Carbon::now(),
        ]);

        // if($data->first()->ship_check == 1){ //ship to different address
        //     Shipping::insert([
        //         'order_id' => $order_id,
        //         'ship_fname' => $data->first()->ship_fname,
        //         'ship_lname' => $data->first()->ship_lname,
        //         'ship_country_id' => $data->first()->ship_country,
        //         'ship_city_id' => $data->first()->ship_city,
        //         'ship_zip' => $data->first()->ship_zip,
        //         'ship_company' => $data->first()->ship_company,
        //         'ship_email' => $data->first()->ship_email,
        //         'ship_phone' => $data->first()->ship_phone,
        //         'ship_address' => $data->first()->ship_address,
        //         'status' => $data->first()->ship_check,
        //         'created_at'=>Carbon::now(),
        //     ]);
        // }
        if($data->first()->ship_check == 0){//Same Address as Billing
            Shipping::insert([
                'order_id' => $order_id,
                'ship_fname' => $data->first()->fname,
                'ship_lname' => $data->first()->lname,
                'ship_country_id' => $data->first()->country,
                'ship_city_id' => $data->first()->city,
                'ship_zip' => $data->first()->zip,
                'ship_company' => $data->first()->company,
                'ship_email' => $data->first()->email,
                'ship_phone' => $data->first()->phone,
                'ship_address' => $data->first()->address,
                'status' => 0,
                'created_at'=>Carbon::now(),
            ]);
        }else{
            Shipping::insert([
                'order_id' => $order_id,
                'ship_fname' => $data->first()->ship_fname,
                'ship_lname' => $data->first()->ship_lname,
                'ship_country_id' => $data->first()->ship_country,
                'ship_city_id' => $data->first()->ship_city,
                'ship_zip' => $data->first()->ship_zip,
                'ship_company' => $data->first()->ship_company,
                'ship_email' => $data->first()->ship_email,
                'ship_phone' => $data->first()->ship_phone,
                'ship_address' => $data->first()->ship_address,
                'status' => $data->first()->ship_check,
                'created_at'=>Carbon::now(),
            ]);
        }

        $carts = Cart::where('customer_id', Auth::guard('cutomer')->id())->get();
        foreach($carts as $cart){
            OrderProduct::insert([
                'order_id' => $order_id,
                'customer_id' => $data->first()->customer_id,
                'product_id' => $cart->product_id,
                'price' => $cart->rel_to_product->after_discount,
                'color_id' => $cart->color_id,
                'size_id' => $cart->size_id,
                'quantity' => $cart->quantity,
                'created_at' => Carbon::now(),
            ]);

            Inventory::where('product_id', $cart->product_id)->where('color_id', $cart->color_id)->where('size_id', $cart->size_id)->decrement('quantity', $cart->quantity);

            Cart::find($cart->id)->delete();
        }

        Mail::to($data->first()->email)->send(new InvoiceMail($order_id));

        Stripe\Charge::create ([
                "amount" => 100 * $total,
                "currency" => "bdt",
                "source" => $request->stripeToken,
                "description" => "Test payment from itsolutionstuff.com."
        ]);



            return redirect()->route('order.success');
    }
}
