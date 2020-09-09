<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('item_id');
            $table->string('name',20);
            $table->Integer('size');
            $table->string('shape',2);
            $table->string('spec',2);
            $table->bigInteger('end_user_id');
            $table->bigInteger('client_user_id');
            $table->bigInteger('delivery_user_id');
            $table->bigInteger('transport_id');
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
        Schema::dropIfExists('items');
    }
}
