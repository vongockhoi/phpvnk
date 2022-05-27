<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToOrdersTable extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id', 'customer_fk_4881623')->references('id')->on('customers');
            $table->unsignedBigInteger('address_id');
            $table->foreign('address_id', 'address_fk_4898227')->references('id')->on('addresses');
            $table->unsignedBigInteger('status_id');
            $table->foreign('status_id', 'status_fk_4881637')->references('id')->on('order_statuses');
            $table->unsignedBigInteger('reservation_id')->nullable();
            $table->foreign('reservation_id', 'reservation_fk_4881752')->references('id')->on('reservations');
            $table->unsignedBigInteger('coupon_customer_id')->nullable();
            $table->foreign('coupon_customer_id', 'coupon_customer_fk_4900786')->references('id')->on('coupon_customers');
        });
    }
}
