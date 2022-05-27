<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Membership;

class AddColoumnsIntoMembershipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('memberships', function (Blueprint $table) {
            $table->integer("level_up_points")->nullable();
            $table->integer("next_membership_id")->nullable();
        });

        Membership::where("id", 1)->update(["level_up_points" => 100, "next_membership_id" => 2]);
        Membership::where("id", 2)->update(["level_up_points" => 200, "next_membership_id" => 3]);
        Membership::where("id", 3)->update(["level_up_points" => 400, "next_membership_id" => 4]);
        Membership::where("id", 4)->update(["level_up_points" => 600]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('memberships', function (Blueprint $table) {
            $table->dropColumn('level_up_points');
            $table->dropColumn('next_membership_id');
        });
    }
}
