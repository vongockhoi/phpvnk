<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToAddressesTable extends Migration
{
    public function up()
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id', 'customer_fk_4894832')->references('id')->on('customers');
            $table->unsignedBigInteger('province_id');
            $table->foreign('province_id', 'province_fk_4880826')->references('id')->on('provinces');
            $table->unsignedBigInteger('district_id')->nullable();
            $table->foreign('district_id', 'district_fk_4880827')->references('id')->on('districts');
        });
    }
}
