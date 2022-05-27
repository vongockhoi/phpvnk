<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToOperatingTimesTable extends Migration
{
    public function up()
    {
        Schema::table('operating_times', function (Blueprint $table) {
            $table->unsignedBigInteger('restaurant_id');
            $table->foreign('restaurant_id', 'restaurant_fk_4904420')->references('id')->on('restaurants');
        });
    }
}
