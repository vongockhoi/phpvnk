<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCartDetailsTable extends Migration
{
    public function up()
    {
        Schema::table('cart_details', function (Blueprint $table) {
            $table->unsignedBigInteger('cart_id');
            $table->foreign('cart_id', 'cart_fk_4872603')->references('id')->on('carts');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id', 'product_fk_4872234')->references('id')->on('products');
            $table->unsignedBigInteger('free_one_product_parent_id')->nullable();
            $table->foreign('free_one_product_parent_id', 'free_one_product_parent_fk_4899163')->references('id')->on('products');
        });
    }
}
