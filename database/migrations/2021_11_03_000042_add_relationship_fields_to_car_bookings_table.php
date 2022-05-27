<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCarBookingsTable extends Migration
{
    public function up()
    {
        Schema::table('car_bookings', function (Blueprint $table) {
            $table->unsignedBigInteger('status_id');
            $table->foreign('status_id', 'status_fk_5259318')->references('id')->on('car_booking_statuses');
        });
    }
}
