<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpenseHasSaleHasCostPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expense_has_sale_has_cost_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('expense_id');
            $table->foreign('expense_id')->references('id')->on('expenses');
            $table->unsignedBigInteger('sale_has_cost_price_id');
            $table->foreign('sale_has_cost_price_id')->references('id')->on('sale_has_cost_prices');
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
        Schema::dropIfExists('expense_has_sale_has_cost_prices');
    }
}
