<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->string('folio')->unique();
            $table->date('date');
            $table->decimal('total',8,2);
            $table->decimal('discount',8,2);
            $table->decimal('percent',8,2);
            $table->string('method');
            $table->string('cliente')->nullable();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->foreign('client_id')->references('id')->on('clients');
            $table->unsignedBigInteger('user_cash_id');
            $table->foreign('user_cash_id')->references('id')->on('user_has_cash_registers');
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
        Schema::dropIfExists('quotes');
    }
}
