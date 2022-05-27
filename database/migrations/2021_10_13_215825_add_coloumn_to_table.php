<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColoumnToTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->integer('restaurant_id')->nullable();
            $table->boolean('is_delivery')->default(0);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->integer('restaurant_id')->nullable();
            $table->boolean('is_delivery')->default(0);
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
            $table->dropColumn("restaurant_id");
            $table->dropColumn("is_delivery");
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn("restaurant_id");
            $table->dropColumn("is_delivery");
        });
    }
}
