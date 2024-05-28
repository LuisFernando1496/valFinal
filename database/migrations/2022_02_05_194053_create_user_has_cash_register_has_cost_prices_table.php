<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserHasCashRegisterHasCostPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_has_cash_register_has_cost_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_cash_id');
            $table->foreign('user_cash_id')->references('id')->on('user_has_cash_registers');
            $table->unsignedBigInteger('cost_price_id')->nullable();
            $table->foreign('cost_price_id')->references('id')->on('cost_prices');
            $table->unsignedBigInteger('service_id')->nullable();
            $table->foreign('service_id')->references('id')->on('services');
            $table->integer('quantity');
            $table->decimal('discount',8,2);
            $table->decimal('percent',8,2);
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
        Schema::dropIfExists('user_has_cash_register_has_cost_prices');
    }
}
