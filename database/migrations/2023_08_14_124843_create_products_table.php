<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id');
            $table->integer('status')->nullable();
            $table->integer('subcategory_id');
            $table->integer('brand_id')->nullable();
            $table->string('product_name',100);
            $table->integer('price');
            $table->integer('discount')->nullable();
            $table->integer('after_discount')->nullable();
            $table->string('tags')->nullable();
            $table->string('short-desp')->nullable();
            $table->string('long-desp')->nullable();
            $table->string('additional_info')->nullable();
            $table->string('preview');
            $table->string('slug');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
