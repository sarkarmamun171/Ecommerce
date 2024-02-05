<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
Use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;
    // protected $guarded = ['id'];
    protected $fillable = [
        'category_name',
        'category_img',
        'created_at',
        'updated_at',

    ];
}
