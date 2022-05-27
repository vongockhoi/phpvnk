<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToReservationsTable extends Migration
{
    public function up()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id', 'customer_fk_4881744')->references('id')->on('customers');
            $table->unsignedBigInteger('status_id');
            $table->foreign('status_id', 'status_fk_4881748')->references('id')->on('reservation_statuses');
        });
    }
}
