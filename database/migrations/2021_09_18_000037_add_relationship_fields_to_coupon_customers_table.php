<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCouponCustomersTable extends Migration
{
    public function up()
    {
        Schema::table('coupon_customers', function (Blueprint $table) {
            $table->unsignedBigInteger('coupon_id');
            $table->foreign('coupon_id', 'coupon_fk_4900758')->references('id')->on('coupons');
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id', 'customer_fk_4900759')->references('id')->on('customers');
            $table->unsignedBigInteger('status_id');
            $table->foreign('status_id', 'status_fk_4900760')->references('id')->on('coupon_customer_statuses');
        });
    }
}
