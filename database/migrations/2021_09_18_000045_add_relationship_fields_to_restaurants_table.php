<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToRestaurantsTable extends Migration
{
    public function up()
    {
        Schema::table('restaurants', function (Blueprint $table) {
            $table->unsignedBigInteger('province_id');
            $table->foreign('province_id', 'province_fk_4850815')->references('id')->on('provinces');
            $table->unsignedBigInteger('district_id');
            $table->foreign('district_id', 'district_fk_4850816')->references('id')->on('districts');
            $table->unsignedBigInteger('status_id')->nullable();
            $table->foreign('status_id', 'status_fk_4850818')->references('id')->on('restaurant_statuses');
        });
    }
}
