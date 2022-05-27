<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponRestaurantPivotTable extends Migration
{
    public function up()
    {
        Schema::create('coupon_restaurant', function (Blueprint $table) {
            $table->unsignedBigInteger('coupon_id');
            $table->foreign('coupon_id', 'coupon_id_fk_4857471')->references('id')->on('coupons')->onDelete('cascade');
            $table->unsignedBigInteger('restaurant_id');
            $table->foreign('restaurant_id', 'restaurant_id_fk_4857471')->references('id')->on('restaurants')->onDelete('cascade');
        });
    }
}
