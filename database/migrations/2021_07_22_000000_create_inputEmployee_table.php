<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInputEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inputEmployee', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->string('placeholder');
            $table->string('name');
            $table->string('icon');
            $table->string('formHandlerVerify');
            $table->string('formOrder');
            $table->string('minLength');
            $table->string('maxLength');
            $table->string('code')->unique();
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
        Schema::dropIfExists('contractType');
    }
}
