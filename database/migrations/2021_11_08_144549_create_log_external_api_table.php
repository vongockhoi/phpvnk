<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogExternalApiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_external_api', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('request_at')->nullable();
            $table->longText('request')->nullable();
            $table->longText('response')->nullable();
            $table->integer('provider')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_external_api');
    }
}
