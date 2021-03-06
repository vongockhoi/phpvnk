<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->unique();
            $table->decimal('total_price', 15, 2);
            $table->boolean('is_prepay')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
