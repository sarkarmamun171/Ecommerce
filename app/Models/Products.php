<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $guarded=['id'];

    function rel_to_category(){
        return $this->belongsTo(Category::class,'category_id');
    }
    function rel_to_subcategory(){
        return $this->belongsTo(Subcategory::class,'subcategory_id');
    }
    function rel_to_brand(){
        return $this->belongsTo(Brand::class,'brand_id');
    }
    function rel_to_inventory(){
        return $this->hasMany(Inventory::class,'product_id');
    }
}
