<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->integer('price_original')->nullable()->after('id');
            $table->integer('discount_coupon')->nullable()->after('price_original');
            $table->integer('discount_membership')->nullable()->after('discount_coupon');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->integer('price_original')->nullable()->after('id');
            $table->integer('discount_coupon')->nullable()->after('price_original');
            $table->integer('discount_membership')->nullable()->after('discount_coupon');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropColumn("discount_coupon");
            $table->dropColumn("discount_membership");
            $table->dropColumn("price_original");
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn("discount_coupon");
            $table->dropColumn("discount_membership");
            $table->dropColumn("price_original");
        });
    }
}
