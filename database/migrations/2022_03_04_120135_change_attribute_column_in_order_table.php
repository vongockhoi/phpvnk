<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeAttributeColumnInOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal("price_ship", 15, 2)->nullable()->change();
            $table->decimal("price_original", 15, 2)->nullable()->change();
            $table->decimal("discount_coupon", 15, 2)->nullable()->change();
            $table->decimal("discount_membership", 15, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->integer("price_ship")->nullable()->change();
            $table->integer("price_original")->nullable()->change();
            $table->integer("discount_coupon")->nullable()->change();
            $table->integer("discount_membership")->nullable()->change();
        });
    }
}
