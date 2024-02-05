<?php

namespace App\Http\Controllers;

use App\Models\Cutomer;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use PDF;

class CustomerController extends Controller
{
    function customer_profile(){
        return view('frontend.customer.profile');
    }
    function customer_logout(){
        Auth::guard('cutomer')->logout();
        return redirect('/');
    }

    function customer_profile_update(Request $request){

        if($request->password == ''){
            if($request->image == ''){
                Cutomer::find(Auth::guard('cutomer')->id())->update([
                    'fname'=>$request->fname,
                    'lname'=>$request->lname,
                    'email'=>$request->email,
                    'phone'=>$request->phone,
                    'country'=>$request->country,
                    'zip'=>$request->zip,
                    'address'=>$request->address,
                    'updated_at'=>Carbon::now(),
                ]);
                return back()->with('success','Profile Updated Successfully');
            }else{

                if(Auth::guard('cutomer')->user()->photo != null){
                    $delete_from = public_path('uploads/customer/'.Auth::guard('cutomer')->user()->photo);
                    unlink($delete_from);
                }

                $image = $request->image;
                $extension = $image->extension();
                $file_name = Auth::guard('cutomer')->id().'.'.$extension;
                image::make($image)->save(public_path('uploads/customer/'.$file_name));

                Cutomer::find(Auth::guard('cutomer')->id())->update([
                    'fname'=>$request->fname,
                    'lname'=>$request->lname,
                    'email'=>$request->email,
                    'phone'=>$request->phone,
                    'country'=>$request->country,
                    'zip'=>$request->zip,
                    'address'=>$request->address,
                    'photo'=>$file_name,
                    'updated_at'=>Carbon::now(),
                ]);
                return back()->with('success','Profile Updated Successfully');
            }
        }else{
            if($request->image == ''){
                Cutomer::find(Auth::guard('cutomer')->id())->update([
                    'fname'=>$request->fname,
                    'lname'=>$request->lname,
                    'email'=>$request->email,
                    'phone'=>$request->phone,
                    'password'=>bcrypt('$request->password') ,
                    'country'=>$request->country,
                    'zip'=>$request->zip,
                    'address'=>$request->address,
                    'updated_at'=>Carbon::now(),
                ]);
                return back()->with('success','Profile Updated Successfully');
            }else{

                if(Auth::guard('cutomer')->user()->photo != null){
                    $delete_from = public_path('uploads/customer/'.Auth::guard('cutomer')->user()->photo);
                    unlink($delete_from);
                }

                $image = $request->image;
                $extension = $image->extension();
                $file_name = Auth::guard('cutomer')->id().'.'.$extension;
                image::make($image)->save(public_path('uploads/customer/'.$file_name));

                Cutomer::find(Auth::guard('cutomer')->id())->update([
                    'fname'=>$request->fname,
                    'lname'=>$request->lname,
                    'email'=>$request->email,
                    'password'=>bcrypt('$request->password') ,
                    'phone'=>$request->phone,
                    'country'=>$request->country,
                    'zip'=>$request->zip,
                    'address'=>$request->address,
                    'photo'=>$file_name,
                    'updated_at'=>Carbon::now(),
                ]);

                return back()->with('success','Profile Updated Successfully');
            }
        }
    }

    function order_success(){
        return view('frontend.customer.order_success');
    }

    function customer_order(){
        $myorders = Order::where('customer_id', Auth::guard('cutomer')->id())->latest()->paginate(5);
        return view('frontend.customer.order',[
            'myorders' => $myorders,
        ]);
    }

    function order_invoice_download($id){
        $order_info = Order::find($id);
        $pdf = PDF::loadView('frontend.invoice.invoice', [
            'order_id' => $order_info,
        ]);
        return $pdf->download('itsolutionstuff.pdf');
    }

    function cancel_myorder($id){
        Order::where('id', $id)->update([
            'cancel_status' => 1,
        ]);
        return back();
    }
}
