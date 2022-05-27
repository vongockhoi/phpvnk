<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarBookingsTable extends Migration
{
    public function up()
    {
        Schema::create('car_bookings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('fullname')->nullable();
            $table->string('phone');
            $table->string('pick_up_point')->nullable();
            $table->string('destination')->nullable();
            $table->datetime('time')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
