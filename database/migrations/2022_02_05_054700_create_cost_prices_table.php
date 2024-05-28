<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCostPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cost_prices', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('cost',8,2);
            $table->decimal('price',8,2);
            $table->unsignedBigInteger('vendor_product_id');
            $table->foreign('vendor_product_id')->references('id')->on('vendor_has_products');
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
        Schema::dropIfExists('cost_prices');
    }
}
