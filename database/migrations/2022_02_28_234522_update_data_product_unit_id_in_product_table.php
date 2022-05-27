<?php

use App\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateDataProductUnitIdInProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $products = DB::table("products")->where("type","!=",0)->get(['id', 'type']);
        foreach ($products as $product) {
            #Bán theo phần = 1,
            #Bán theo con = 2,
            #Bán theo kg = 3,
            DB::table("products")->where("id", $product->id)->update(
                [
                    'product_unit_id' => $product->type
                ]
            );
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product', function (Blueprint $table) {
            //
        });
    }
}
