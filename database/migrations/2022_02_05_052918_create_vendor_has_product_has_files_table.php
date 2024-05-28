<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorHasProductHasFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_has_product_has_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendor_product_id');
            $table->foreign('vendor_product_id')->references('id')->on('vendor_has_products');
            $table->unsignedBigInteger('file_id');
            $table->foreign('file_id')->references('id')->on('files');
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
        Schema::dropIfExists('vendor_has_product_has_files');
    }
}
