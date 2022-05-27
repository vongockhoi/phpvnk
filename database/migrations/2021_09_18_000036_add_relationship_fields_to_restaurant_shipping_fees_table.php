<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToRestaurantShippingFeesTable extends Migration
{
    public function up()
    {
        Schema::table('restaurant_shipping_fees', function (Blueprint $table) {
            $table->unsignedBigInteger('restaurant_id');
            $table->foreign('restaurant_id', 'restaurant_fk_4901277')->references('id')->on('restaurants');
            $table->unsignedBigInteger('district_id');
            $table->foreign('district_id', 'district_fk_4901278')->references('id')->on('districts');
        });
    }
}
