<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCouponsTable extends Migration
{
    public function up()
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->unsignedBigInteger('discount_type_id')->nullable();
            $table->foreign('discount_type_id', 'discount_type_fk_4857533')->references('id')->on('discount_types');
            $table->unsignedBigInteger('coupon_type_id');
            $table->foreign('coupon_type_id', 'coupon_type_fk_4857481')->references('id')->on('coupon_types');
            $table->unsignedBigInteger('status_id');
            $table->foreign('status_id', 'status_fk_4857540')->references('id')->on('coupon_statuses');
        });
    }
}
