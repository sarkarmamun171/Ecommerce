<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class BrandController extends Controller
{
    function brand(){
        $brands = Brand::all();
        return view('admin.brand.brand',[
            'brands'=>$brands,
        ]);
    }

    function brand_store(Request $request){
        $request->validate([
            'brand_name'=>'required',
            'brand_logo'=>'required | image'
        ]);

        if(Brand::where('brand_name',$request->brand_name)->exists()){
            return back()->with('brand', 'Brand Already Existed');
        }else{
            $logo = $request->brand_logo;
            $extesion = $logo->extension();
            $file_name = Str::lower(str_replace(' ', '_', $request->brand_name)).'.'.$extesion;
            Image::make($logo)->save(public_path('uploads/brand/'.$file_name));

            Brand::insert([
                'brand_name'=>$request->brand_name,
                'brand_logo'=>$file_name,
                'created_at'=>Carbon::now(),
            ]);
            return back()->with('brand', 'New Brand Added!');
        }


    }

    function brand_edit($brand_id){
        $brand_info = Brand::find($brand_id);
        // return $category_info;
        return view('admin.brand.edit',[
            'brand_info'=>$brand_info,
        ]);
    }

    function brand_update(Request $request){
        $brand = Brand::find($request->brand_id);
        // $img = $brand->brand_logo;

        if($request->brand_logo == ''){
            Brand::find($request->brand_id)->update([
                'brand_name'=>$request->brand_name,
                'updated_at'=>Carbon::now(),
            ]);

            return back()->with('success','Brand updated Successfully!');
        }else{
            $current_img = public_path('uploads/brand/'.$brand->brand_logo);
            unlink($current_img);

            $logo = $request->brand_logo;
            $extnesion = $logo->extension();
            $file_name = Str::lower(str_replace(' ', '_', $request->brand_name)).'.'.$extnesion;
            Image::make($logo)->save(public_path('uploads/brand/'.$file_name));

            Brand::find($request->brand_id)->update([
                'brand_name'=>$request->brand_name,
                'brand_logo'=>$file_name,
                'updated_at'=>Carbon::now(),
            ]);
            return back()->with('success','Brand updated Successfully!');
        }
    }

    function brand_delete($brand_id){
        $brand = Brand::find($brand_id);
        $current_img = public_path('uploads/brand/'.$brand->brand_logo);
        unlink($current_img);

        Brand::find($brand_id)->delete();
        return back()->with('delete','Brand deleted Successfully!');
    }
}
