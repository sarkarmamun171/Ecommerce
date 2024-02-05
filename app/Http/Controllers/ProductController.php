<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Brand;
use App\Models\Inventory;
use App\Models\ProductGallery;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Color;
use App\Models\Products;
use App\Models\Size;
use App\Models\Subcategory;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;


class ProductController extends Controller
{
    function product(){
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $brands = Brand::all();
        $tags = Tag::all();
        return view('admin.product.index',[
            'categories'=>$categories,
            'subcategories'=>$subcategories,
            'brands'=>$brands,
            'tags'=>$tags,
        ]);
    }

    function getSubcategory(Request $request){
        $str = '<option value="">Select Sub Category</option>';
        $subcategories = Subcategory::where('category_id', $request->category_id)->get();
        foreach($subcategories as $subcategory){
            $str .= '<option value="'.$subcategory->id.'">'.$subcategory->subcategory_name.'</option>';
        }
        echo $str;
    }

    function getSubcategory2(Request $request){
        $str = '<option value="">Select Sub Category</option>';
        $subcategories = Subcategory::where('category_id', $request->category_id)->get();
        foreach($subcategories as $subcategory){
            $str .= '<option value="'.$subcategory->id.'">'.$subcategory->subcategory_name.'</option>';
        }
        echo $str;
    }

    function product_store(ProductRequest $request){
        $after_implode = implode(',', $request->tags);
        // $tags = $request->tags;

        $preview = $request->preview;
        $extension = $preview->extension();
        $file_name = Str::lower(str_replace(' ','-',$request->product_name))."-".random_int(100000, 900000)."." .$extension;
        Image::make($preview)->save(public_path('uploads/product/preview/'.$file_name));
        $product_id = Products::insertGetId([
            'category_id'=>$request->category,
            'subcategory_id'=>$request->subcategory,
            'brand_id'=>$request->brand,
            'product_name'=>$request->product_name,
            'price'=>$request->price,
            'discount'=>$request->discount,
            'after_discount'=>$request->price - ($request->price * $request->discount/100),
            // 'tags'=>str_replace('"', '', json_encode($tags)),
            'tags'=>$after_implode,
            'short_desp'=>$request->input('short_desp'),
            'long_desp'=>$request->input('long_desp'),
            'additional_info'=>$request->input('additional_info'),
            'preview'=>$file_name,
            'slug'=>Str::lower(str_replace(' ','-',$request->product_name))."-".random_int(10000000, 90000000),
            'created_at'=>Carbon::now(),
        ]);



        foreach($request->gallery as $gal){
            $extension = $gal->extension();
            $file_name = Str::lower(str_replace(' ','-',$request->product_name))."-".random_int(100000, 900000)."." .$extension;
            Image::make($gal)->save(public_path('uploads/product/gallery/'.$file_name));

            ProductGallery::insert([
                'product_id'=>$product_id,
                'gallery'=>$file_name,
            ]);
        }


        return back()->with('success','Product Added Successfully');




    }

    function product_list(){
        $products = Products::all();
        return view('admin.product.product_list',[
            'products'=>$products,

        ]);
    }

    function product_delete($products_id){
        $product = Products::find($products_id);
        $gallery = ProductGallery::where('product_id',$products_id)->get();
        $img_preview = public_path('uploads/product/preview/'.$product->preview);
        if (file_exists($img_preview)) {
            unlink($img_preview);
        }


        foreach ($gallery as $gal) {
            $gal_image = public_path('uploads/product/gallery/'.$gal->gallery);
            if (file_exists($gal_image)) {
                unlink($gal_image);
            }
            ProductGallery::find($gal->id)->delete();
        }

        Products::find($products_id)->delete();

        $inventories = Inventory::where('product_id', $products_id)->get();
        foreach ($inventories as $inventory) {
            Inventory::find($inventory->id)->delete();
        }

        return back()->with('delete','Product deleted Successfully!');
    }

    function product_show($products_id){
        $products = Products::find($products_id);
        $galleries = ProductGallery::where('product_id',$products_id)->get();
        return view('admin.product.product_show',[
            'products'=>$products,
            'galleries'=>$galleries,
        ]);
    }

    function inventory($product_id){
        $product = Products::find($product_id);
        $colors = Color::all();
        $inventory = Inventory::where('product_id', $product_id)->get();
        // $sizes = Size::all();
        return view('admin.product.inventory',[
            'product'=>$product,
            'colors'=>$colors,
            'inventories'=>$inventory,
            // 'sizes'=>$sizes,
        ]);
    }

    function inventory_store(Request $request, $id){

        if(Inventory::where('product_id', $id)->where('color_id', $request->color_id)->where('size_id', $request->size_id)->exists()){
            Inventory::where('product_id', $id)->where('color_id', $request->color_id)->where('size_id', $request->size_id)->increment('quantity', $request->quantity);
            return back()->with('success','Inventory incremented successfully!');
        }else{
            Inventory::insert([
                'product_id'=>$id,
                'color_id'=>$request->color_id,
                'size_id'=>$request->size_id,
                'quantity'=>$request->quantity,
                'created_at'=>Carbon::now(),
            ]);

            return back()->with('success','Inventory added successfully!');
        }


    }

    function product_edit($id){

        $products = Products::find($id);
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $brands = Brand::all();

        return view('admin.product.product_edit',[
            'products'=>$products,
            'categories'=>$categories,
            'subcategories'=>$subcategories,
            'brands'=>$brands,
        ]);
    }

    function changeStatus(Request $request){
        Products::find($request->product_id)->update([
            'status'=>$request->status,
        ]);
    }

}
