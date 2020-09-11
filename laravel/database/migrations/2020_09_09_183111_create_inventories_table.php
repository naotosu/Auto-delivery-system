<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('item_id');
            $table->string('order_number',7);
            $table->string('charge_number',4);
            $table->string('manufacturing_number',8);
            $table->Integer('bundle_number');
            $table->Integer('weight');
            $table->Integer('quantity');
            $table->Integer('status');
            $table->date('production_date')->nullable();
            $table->date('factory_warehousing_date')->nullable();
            $table->date('warehouse_receipt_date')->nullable();
            $table->date('ship_date')->nullable();
            $table->Integer('destination_id')->nullable();
            $table->bigInteger('input_user_id');
            $table->bigInteger('output_user_id')->nullable();
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
        Schema::dropIfExists('inventories');
    }
}
