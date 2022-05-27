<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->integer('price_ship')->nullable()->after('id');
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->integer('price_ship')->nullable()->after('id');
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
            $table->dropColumn("price_ship");
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn("price_ship");
        });
    }
}
