<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('type')->nullable();
            $table->integer('type_id')->nullable();
            $table->string('title')->nullable();
            $table->text('body')->nullable();
            $table->boolean('app_notification')->default(0);
            $table->dateTime('app_notification_at')->nullable();
            $table->dateTime('last_read_at')->nullable();
            $table->integer('customer_id')->nullable();
            $table->integer('status')->default(0);
            $table->integer('created_by_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
