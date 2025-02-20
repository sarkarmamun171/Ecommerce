<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Color;
use App\Models\Inventory;
use App\Models\OrderProduct;
use App\Models\Products;
use App\Models\Size;
use App\Models\Subcategory;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

// use App\Http\Controllers\FrontendController;

class FrontendController extends Controller
{
    function index(){
        // return view('welcome');
        return view('frontend.master');
        $categories = Category::all();
        $products = Products::where('status', 1)->latest()->get();

        return view('frontend.index',[
           'categories'=>$categories,
           'products'=>$products,
        ]);
    }
    function about(){
        return view('about');
    }
    function contact(){
        return view('contact');
    }
    function service(){
        return view('abc.service');
    }

    function category_products($id){
        $categories = Category::find($id);
        $category_products = Products::where('category_id', $id)->where('status', 1)->get();

        return view('frontend.category_product',[
            'category_products'=>$category_products,
            'categories'=>$categories,
        ]);
    }
    function subcategory_products($id){
        $subcategories = Subcategory::find($id);
        $subcategory_products = Products::where('subcategory_id', $id)->get();

        return view('frontend.subcategory_product',[
            'subcategory_products'=>$subcategory_products,
            'subcategories'=>$subcategories,
        ]);
    }
    function product_details($slug){
        $product_id = Products::where('slug', $slug)->first()->id;

        $reviews = OrderProduct::where('product_id', $product_id)->whereNotNull('review')->get();

        $total_stars = OrderProduct::where('product_id', $product_id)->whereNotNull('review')->sum('star');

        $product_details = Products::find($product_id);

        $available_colors = Inventory::where('product_id',$product_id)
        ->groupBy('color_id')
        ->selectRaw('count(*) as total, color_id')
        ->get();
        $available_sizes = Inventory::where('product_id',$product_id)
        ->groupBy('size_id')
        ->selectRaw('count(*) as total, size_id')
        ->get();

        //recent view
        $cookie_info = Cookie::get('recent_view');
        if(!$cookie_info){
            $cookie_info = "[]";
        }
        $all_info = json_decode($cookie_info, true);
        $all_info = Arr::prepend($all_info, $product_id);
        $recent_viewed_id = json_encode($all_info);
        Cookie::queue('recent_view',$recent_viewed_id, 1000);
        // return Cookie::get('recent_view');

        return view('frontend.product_details',[
            'product_details'=>$product_details,
            'available_colors'=>$available_colors,
            'available_sizes'=>$available_sizes,
            'reviews'=>$reviews,
            'total_stars'=>$total_stars,
        ]);
    }

    function getSize(Request $request){
        $str = '';
        $sizes = Inventory::where('product_id', $request->product_id)->where('color_id', $request->color_id)->get();
        foreach($sizes as $size){
            $str .= '<li class="color"><input class="size_id" id="'.$size->size_id.'" type="radio" name="size_id" value="'.$size->size_id.'">
                        <label for="'.$size->size_id.'"> '.$size->rel_to_size->size_name.' </label>
                    </li>';
        }
        echo $str;
    }
    // function getColor(Request $request){
    //     $str = '';
    //     $colors = Inventory::where('product_id', $request->product_id)->where('size_id', $request->size_id)->get();
    //     foreach($colors as $color){
    //         $str .= '<li class="color"><input class="color_id" id="'.$color->color_id.'" type="radio" name="color_id" value="'.$color->color_id.'">
    //                         <label style="background-color: '.$color->rel_to_color->color_code.'" for="{{ $colors->color_id }}"></label>
    //                 </li>';
    //         // echo $color;
    //     }
    //     echo $str;

    // }


    function getQuantity(Request $request){
        $str = '';
        $quantity = Inventory::where('product_id', $request->product_id)->where('color_id', $request->color_id)->where('size_id', $request->size_id)->first()->quantity;
        if($quantity==0){
            $quantity = '<button class="btn btn-danger abc" value="'.$quantity.'">Out of Stock</button>';
        }
        else{
            $quantity = '<button class="btn btn-success">'.$quantity.' In Stock</button>';
        }
        echo $quantity;
    }

    function aboutus(){
        return view('frontend.about');
    }

    function contactus(){
        return view('frontend.contact');
    }


    function review_store(Request $request){
        // print_r($request->all());
        OrderProduct::where('customer_id', Auth::guard('cutomer')->user()->id)->where('product_id', $request->product_id)->first()->update([
            'review' => $request->review,
            'star' => $request->stars,
            'updated_at' => Carbon::now(),
        ]);
        return back();
    }
    function shop(Request $request){
        $data = $request->all();

        // $min = 1;
        // $max = Products::max('after_discount');


        // if(!empty($data['min']) && $data['min'] != '' && $data['min']!='undefined'){
        //     $min = $data['min'];
        // }
        // if(!empty($data['max']) && $data['max'] != '' && $data['max']!='undefined'){
        //     $max = $data['max'];
        // }

        $sorting = 'created_at';
        $type = 'DESC';

        if(!empty($data['sorting']) && $data['sorting'] != '' && $data['sorting']!='undefined'){
            if($data['sorting'] == '1'){
                $sorting = 'after_discount';
                $type = 'ASC';
            }
            if($data['sorting'] == '2'){
                $sorting = 'after_discount';
                $type = 'DESC';
            }
            if($data['sorting'] == '3'){
                $sorting = 'product_name';
                $type = 'ASC';
            }
            if($data['sorting'] == '4'){
                $sorting = 'product_name';
                $type = 'DESC';
            }
        }

        $products = Products::where('status',1)->where(function($q) use ($data){
            if(!empty($data['search_input']) && $data['search_input'] != '' && $data['search_input']!='undefined'){
                $q->where(function($q) use ($data){
                    $q->where('product_name', 'like', '%' .$data['search_input'].'%');
                    $q->orWhere('tags', 'like', '%' .$data['search_input'].'%');
                    $q->orWhere('long_desp', 'like', '%' .$data['search_input'].'%');
                    $q->orWhere('additional_info', 'like', '%' .$data['search_input'].'%');
                });
            }


            $min = 1;
            $max = Products::max('after_discount');

            if(!empty($data['min']) && $data['min'] != '' && $data['min']!='undefined'){
                $min = $data['min'];
            }
            if(!empty($data['max']) && $data['max'] != '' && $data['max']!='undefined'){
                $max = $data['max'];
            }

            if(!empty($data['min']) && $data['min'] != '' && $data['min']!='undefined' || !empty($data['max']) && $data['max'] != '' && $data['max']!='undefined'){
                $q->whereBetween('after_discount', [[$min], [$max]]);
            }
            if(!empty($data['color_id']) && $data['color_id'] != '' && $data['color_id']!='undefined' ){
                $q->whereHas('rel_to_inventory',function($q) use ($data){
                    if(!empty($data['color_id']) && $data['color_id'] != '' && $data['color_id']!='undefined' ){
                        $q->whereHas('rel_to_color', function($q) use ($data){
                            $q->where('colors.id', $data['color_id']);
                        });
                    }
                });
            }
            if(!empty($data['color_id']) && $data['color_id'] != '' && $data['color_id']!='undefined' && !empty($data['size_id']) && $data['size_id'] != '' && $data['size_id']!='undefined'){
                $q->whereHas('rel_to_inventory',function($q) use ($data){
                    if(!empty($data['color_id']) && $data['color_id'] != '' && $data['color_id']!='undefined' ){
                        $q->whereHas('rel_to_color', function($q) use ($data){
                            $q->where('colors.id', $data['color_id']);
                        });
                    }
                    if(!empty($data['size_id']) && $data['size_id'] != '' && $data['size_id']!='undefined' ){
                        $q->whereHas('rel_to_size', function($q) use ($data){
                            $q->where('sizes.id', $data['size_id']);
                        });
                    }
                });
            }
            if(!empty($data['category_id']) && $data['category_id'] != '' && $data['category_id']!='undefined' ){
                $q->where(function($q) use ($data){
                    $q->where('category_id', $data['category_id']);
                });
            }
            if(!empty($data['tag_id']) && $data['tag_id'] != '' && $data['tag_id']!='undefined' ){
                $q->where(function($q) use ($data){
                    $all = '';
                    foreach(Products::all() as $pro){
                        $explode = explode(',', $pro->tags);
                        if(in_array($data['tag_id'], $explode)){
                            $all .= $pro->id.',';
                        }
                    }
                    $explode2 = explode(',',$all);
                    $q->find($explode2);
                });
            }
            if(!empty($data['top_catid']) && $data['top_catid'] != '' && $data['top_catid']!='undefined'){
                $q->where(function($q) use ($data){
                    $q->where('category_id', $data['top_catid']);
                });
            }
        })->orderBy($sorting,$type)->get();

        // $products = Products::all();
        $categories = Category::all();
        $sizes = Size::all();
        $colors = Color::all();
        $tags = Tag::all();
        return view('frontend.invoice.shop',[
            'products'=>$products,
            'categories'=>$categories,
            'sizes'=>$sizes,
            'colors'=>$colors,
            'tags'=>$tags,
        ]);
    }

    function recent_view(){
        $recent_view = json_decode(Cookie::get('recent_view'));//recent_view is the cookie name
        if($recent_view == NULL){
            $recent_view = [];
            $after_unique = array_unique($recent_view);
        }
        else{
            $after_unique = array_reverse(array_unique($recent_view));
        }
        // $recent_viewed_product = Products::find($after_unique);
        $recent_viewed_product = Products::whereIn('id', $after_unique)->paginate(3);
        // return $recent_viewed_product;
        // return Cookie::get('recent_view');
        return view('frontend.invoice.recent_view',[
            'recent_viewed_product' => $recent_viewed_product,
        ]);
    }

}
