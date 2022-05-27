<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCartsTable extends Migration
{
    public function up()
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id', 'customer_fk_4871636')->references('id')->on('customers');
            $table->unsignedBigInteger('address_id');
            $table->foreign('address_id', 'address_fk_4898226')->references('id')->on('addresses');
            $table->unsignedBigInteger('coupon_customer_id')->nullable();
            $table->foreign('coupon_customer_id', 'coupon_customer_fk_4900764')->references('id')->on('coupon_customers');
        });
    }
}
