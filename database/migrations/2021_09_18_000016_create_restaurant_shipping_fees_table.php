<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantShippingFeesTable extends Migration
{
    public function up()
    {
        Schema::create('restaurant_shipping_fees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('shipping_fee', 15, 2);
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
