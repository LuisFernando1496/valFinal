<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->bigInteger('phone');
            $table->string('email')->unique();
            $table->unsignedBigInteger('address_id');
            $table->foreign('address_id')->references('id')->on('addresses');
            $table->unsignedBigInteger('office_id');
            $table->foreign('office_id')->references('id')->on('offices');
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
        Schema::dropIfExists('vendors');
    }
}
