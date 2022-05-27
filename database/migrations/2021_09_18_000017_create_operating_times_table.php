<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOperatingTimesTable extends Migration
{
    public function up()
    {
        Schema::create('operating_times', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->time('open_time');
            $table->time('close_time');
            $table->boolean('monday')->default(0)->nullable();
            $table->boolean('tuesday')->default(0)->nullable();
            $table->boolean('wednesday')->default(0)->nullable();
            $table->boolean('thursday')->default(0)->nullable();
            $table->boolean('friday')->default(0)->nullable();
            $table->boolean('saturday')->default(0)->nullable();
            $table->boolean('sunday')->default(0)->nullable();
            $table->date('day_off')->nullable();
            $table->time('time_off')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
