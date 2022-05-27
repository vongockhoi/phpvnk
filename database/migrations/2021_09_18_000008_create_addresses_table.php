<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('address');
            $table->longText('note')->nullable();
            $table->boolean('is_default')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
