<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransferInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfer_inventories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transfer_id');
            $table->foreign('transfer_id')->references('id')->on('transfers')->onDelete('cascade');
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
        Schema::dropIfExists('transfer_inventories');
    }
}
