<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePointHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('point_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('total_price', 15, 2);
            $table->unsignedBigInteger("customer_id");
            $table->integer("order_id")->unique();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('customer_id', 'customer_id_fk_from_point_histories')->references('id')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('point_histories');
    }
}
