<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuoteCostServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quote_cost_services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quote_id');
            $table->foreign('quote_id')->references('id')->on('quotes');
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
        Schema::dropIfExists('quote_cost_services');
    }
}
