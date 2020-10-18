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
            $table->string('item_code', 11)->index();
            $table->string('order_code',7);
            $table->string('charge_code',5);
            $table->string('manufacturing_code',8);
            $table->Integer('bundle_number')->unsigned();
            $table->Integer('weight')->unsigned();
            $table->Integer('quantity')->unsigned();
            $table->Integer('status')->unsigned();
            $table->date('production_date')->nullable();
            $table->date('factory_warehousing_date')->nullable();
            $table->date('warehouse_receipt_date')->nullable();
            $table->bigInteger('order_item_id')->nullable()->unsigned();
            $table->bigInteger('order_id')->nullable()->unsigned();
            $table->boolean('temporary_flag')->default(false);
            $table->date('ship_date')->nullable();
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
