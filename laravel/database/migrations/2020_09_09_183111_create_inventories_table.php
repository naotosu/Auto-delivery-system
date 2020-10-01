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
            $table->unique(['manufacturing_code', 'bundle_number'],
                       'manufacturing_codebundle_number');
            $table->bigIncrements('id');
            $table->string('item_code', 11);
            $table->string('order_code',7);
            $table->string('charge_code',5);
            $table->string('manufacturing_code',8);
            $table->Integer('bundle_number');
            $table->Integer('weight');
            $table->Integer('quantity');
            $table->Integer('status');
            $table->date('production_date')->nullable();
            $table->date('factory_warehousing_date')->nullable();
            $table->date('warehouse_receipt_date')->nullable();
            $table->bigInteger('order_item_id')->nullable()->unsigned();
            $table->date('ship_date')->nullable();
            $table->Integer('destination_id')->nullable();
            $table->bigInteger('input_user_id')->unsigned();
            $table->bigInteger('output_user_id')->nullable()->unsigned();
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
