<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuyInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buy_inventories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('buy_id');
            $table->foreign('buy_id')->references('id')->on('buys')->onDelete('cascade');
            $table->unsignedBigInteger('inventory_id');
            $table->foreign('inventory_id')->references('id')->on('inventories')->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('subtotal',8,2);
            $table->decimal('percent',8,2);
            $table->decimal('discount',8,2);
            $table->decimal('total',8,2);
            $table->dateTime('date');
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
        Schema::dropIfExists('buy_inventories');
    }
}
