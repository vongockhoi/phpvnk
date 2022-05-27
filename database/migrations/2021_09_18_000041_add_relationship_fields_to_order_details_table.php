<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToOrderDetailsTable extends Migration
{
    public function up()
    {
        Schema::table('order_details', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id', 'order_fk_4881683')->references('id')->on('orders');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id', 'product_fk_4881684')->references('id')->on('products');
        });
    }
}
