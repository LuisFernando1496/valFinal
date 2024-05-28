<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('num_socio');
            $table->string('name');
            $table->string('last_name');
            $table->string('second_lastname')->nullable();
            $table->string('age');
            $table->bigInteger('phone');
            $table->bigInteger('phone_emergency');
            $table->string('email')->nullable();
            $table->string('certification')->nullable();
            $table->string('photo')->nullable();
            $table->string('sign')->nullable();
            $table->date('date');
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
        Schema::dropIfExists('partners');
    }
}
