<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->unique(['order_id', 'item_code', 'ship_date', 'weight' ],    // []内にunique制約を付けたいカラム名を並べる
                       'order_id_item_code_ship_date_quantity');
            $table->bigIncrements('id');
            $table->Integer('order_id');
            $table->string('item_code', 11)->index();
            $table->date('ship_date');
            $table->Integer('weight');
            $table->boolean('temporary_flag')->default(false);
            $table->boolean('done_flag')->default(false);
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
        Schema::dropIfExists('order_items');
    }
}
