<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Color;
use App\Models\Inventory;
use App\Models\Size;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    function variation(){
        $colors = Color::all();
        $categories = Category::all();
        // $sizes = Size::all();
        return view('admin.product.variation',[
            'colors'=>$colors,
            'categories'=>$categories,
            // 'sizes'=>$sizes,
        ]);
    }

    function color_store(Request $request){
        Color::insert([
            'color_name'=>$request->color_name,
            'color_code'=>$request->color_code,
            'created_at'=>Carbon::now(),
        ]);

        return back()->with('color','Color Added Successfully!');
    }
    function size_store(Request $request){
        if(Size::where('category_id',$request->category_id)->where('size_name',$request->size_name)->exists()){
            return back()->with('size','Size Already Exists for this category!');
        }else{
            Size::insert([
                'category_id'=>$request->category_id,
                'size_name'=>$request->size_name,
                'created_at'=>Carbon::now(),
            ]);
            return back()->with('size','Size Added Successfully!');
        }

    }

    function color_remove($id){
        Color::find($id)->delete();
        return back()->with('delete_color','Color Deleted Successfully!');
    }
    function size_remove($id){
        Size::find($id)->delete();
        return back()->with('delete_size','Size Deleted Successfully!');
    }
    function inventory_delete($id){
        Inventory::find($id)->delete();
        return back();
    }



}
