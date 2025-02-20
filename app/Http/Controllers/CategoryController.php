<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File; 
// use Image;

class CategoryController extends Controller
{
    function category(){
        // $categories = Category::simplePaginate(3);
        $categories = Category::Paginate(3);
        return view('admin.category.category', [
            'categories'=>$categories,
        ]);
    }

    function category_store(Request $request){
        $request->validate([
            'category_name'=>'required|unique:categories',
            'category_img' => [
                'required',
                'image',
                File::image()
                    ->types(['png','jpg','jpeg'])
                    ->min(1)
                    ->max(500)
                    ->dimensions(
                        Rule::dimensions()
                            ->maxWidth(1000)
                            ->maxHeight(1000)
                    )
            ]
        ]);

        $img = $request->category_img;
        $extension = $img->extension();
        $file_name = Str::lower(str_replace(' ','-',$request->category_name))."-".random_int(100000, 900000)."." .$extension;
        Image::make($img)->save(public_path('uploads/category/'.$file_name));

        Category::insert([
            'category_name'=>$request->category_name,
            'category_img'=>$file_name,
            'created_at'=>Carbon::now(),
            // 'reviews'=>'good',
        ]);

        return back()->with('success','Category Added Successfully!');

    }

    function category_edit($category_id){
        $category_info = Category::find($category_id);
        // return $category_info;
        return view('admin.category.edit',[
            'category_info'=>$category_info,
        ]);
    }

    function category_update(Request $request){

        $category = Category::find($request->category_id);
        // print_r($id);
        if($request->category_img == ''){
            Category::find($request->category_id)->update([
                'category_name'=>$request->category_name,
                'created_at'=>Carbon::now(),
                // 'updated_at'=>Carbon::now(),
            ]);

            // return redirect()->route('category.edit')->with('update-success','Category Updated Successfully!');
            return back()->with('success','Category update Successfully!');
        }
        else{
            $current_img = public_path('uploads/category/'.$category->category_img);
            unlink($current_img);

            $img = $request->category_img;
            $extension = $img->extension();
            $file_name = Str::lower(str_replace(' ','-',$request->category_name))."-".random_int(100000, 900000)."." .$extension;
            Image::make($img)->save(public_path('uploads/category/'.$file_name));

            Category::find($request->category_id)->update([
                'category_img'=>$file_name,
                // 'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
            ]);
            // return redirect()->route('category.edit')->with('success','Category Updated Successfully!');
            return back()->with('success','Category update Successfully!');

        }
    }

    function category_delete($category_id){
        Category::find($category_id)->delete();
        return back();
    }

    function category_trash(){
        $trash_categories = Category::onlyTrashed()->get();
        return view('admin.category.trash', [
            'categories'=>$trash_categories,
        ]);
    }

    function category_restore($id){
        Category::onlyTrashed()->find($id)->restore();
        return back();
    }

    function category_hard_delete($category_id){

        $category = Category::onlyTrashed()->find($category_id);
        $current_img = public_path('uploads/category/'.$category->category_img);
        unlink($current_img);


        Category::onlyTrashed()->find($category_id)->forceDelete();
        Subcategory::where('category_id',  $category_id)->update([
            'category_id'=>21,
        ]);

        return back();

        // return Subcategory::where('category_id',  $category_id)->get();
    }

    function delete_checked(Request $request){
        foreach($request->category_id as $category){
            Category::find($category)->delete();
            // Subcategory::where('category_id',  $category)->update([
            //     'category_id'=>21,
            // ]);
        }
        return back();
    }

    // function restore_checked(Request $request){
    //     foreach($request->category_id as $category){
    //         Category::onlyTrashed()->find($category)->restore();
    //     }
    //     return back();
    // }

    function restore_checked(Request $request){
        // Check if $request->category_id is null before processing the data
        if ($request->category_id) {
            foreach($request->category_id as $category){
                Category::onlyTrashed()->find($category)->restore();
                // Subcategory::where('category_id',  $category)->update([
                //     'category_id'=>21,
                // ]);
            }
        }
        return back();
    }

    // function delete_checked_permanent(Request $request){
    //     if ($request->category_id) {
    //         foreach($request->category_id as $category){
    //             Category::onlyTrashed()->find($category)->forceDelete();
    //         }
    //     }
    //     return back();
    // }

    function delete_checked_permanent(Request $request){
        if ($request->category_id) {
            foreach($request->category_id as $category_id){
                $category = Category::onlyTrashed()->find($category_id);

                // Delete the image from the folder
                $imagePath = public_path('uploads/category') . '/' . $category->category_img;
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }

                // Permanently delete the category
                $category->forceDelete();
            }
            Subcategory::where('category_id',  $category_id)->update([
                'category_id'=>21,
            ]);
        }
        return back();
    }

}
