<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee', function (Blueprint $table) {
            $table->id();
            $table->string('firstName');
            $table->string('name');
            $table->string('birthDate');
            $table->string('birthPlace');
            $table->string('mail');
            $table->string('greenNumber');
            $table->string('phone');
            $table->string('adress');
            $table->string('zipCode');
            $table->string('city');
            $table->string('startDate');
            $table->string('endDate');
            $table->engine = 'innoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee');
    }
}
