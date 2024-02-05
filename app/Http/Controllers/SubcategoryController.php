<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;
use Carbon\Carbon;

class SubcategoryController extends Controller
{

    function subcategory(){
        $categories = Category::all();
        return view('admin.subcategory.subcategory',[
            'categories'=>$categories,
        ]);
    }

    function subcategory_store(Request $request){
        $request->validate([
            'category'=>'required',
            'subcategory_name'=>'required',
        ]);

        if(Subcategory::where('category_id', $request->category)->where('subcategory_name', $request->subcategory_name)->exists()){
            return back()->with('exist','Subcategory Already Exist in this Category!');
        }else{
            Subcategory::insert([
                'category_id'=>$request->category,
                'subcategory_name'=>$request->subcategory_name,
            ]);
        }


        return back()->with('success','Subcategory added!');
    }

    function subcategory_edit($id){
        $categories = Category::all();
        $subcategories = Subcategory::find($id);
        return view('admin.subcategory.edit',[
            'categories'=>$categories,
            'subcategories'=>$subcategories,
        ]);
    }

    function subcategory_update(Request $request, $id){

        if(Subcategory::where('category_id', $request->category)->where('subcategory_name', $request->subcategory_name)->exists()){
            return back()->with('exist','Subcategory Already Exist in this Category!');
        }else{

            Subcategory::find($id)->update([

                'category_id'=>$request->category,
                'subcategory_name'=>$request->subcategory_name,
                'updated_at'=>Carbon::now(),
            ]);
            return back()->with('updated','Subcategory Updated!');
        }
    }

    function subcategory_delete($id){
        Subcategory::find($id)->delete();
        return back()->with('deleted','Subcategory Deleted!');
    }
}
