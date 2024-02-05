<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class OrderProduct extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    function rel_to_product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
    function rel_to_customer()
    {
        return $this->belongsTo(Cutomer::class, 'customer_id');
    }
}
