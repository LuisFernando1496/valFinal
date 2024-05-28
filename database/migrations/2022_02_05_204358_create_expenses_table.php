<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('description');
            $table->decimal('total',8,2);
            $table->timestamp('date');
            $table->boolean('status')->default(true);
            $table->unsignedBigInteger('category_of_expense_id');
            $table->foreign('category_of_expense_id')->references('id')->on('category_of_expenses');
            $table->unsignedBigInteger('owner_id')->nullable();
            $table->foreign('owner_id')->references('id')->on('owners');
            $table->unsignedBigInteger('user_empleado_id')->nullable();
            $table->foreign('user_empleado_id')->references('id')->on('users');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('expenses');
    }
}
