<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductRestaurantPivotTable extends Migration
{
    public function up()
    {
        Schema::create('product_restaurant', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id', 'product_id_fk_4894995')->references('id')->on('products')->onDelete('cascade');
            $table->unsignedBigInteger('restaurant_id');
            $table->foreign('restaurant_id', 'restaurant_id_fk_4894995')->references('id')->on('restaurants')->onDelete('cascade');
        });
    }
}
