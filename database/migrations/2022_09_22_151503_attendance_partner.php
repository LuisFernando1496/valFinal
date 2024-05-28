<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AttendancePartner extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance__partners', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->bigInteger('num_socio');
            $table->string('name');
            $table->string('lastname');
            $table->string('second_lastname');
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
        Schema::dropIfExists('attendance__partners');
    }
}
