<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTraceContractTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('traceContrat', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('hashName');
            $table->integer('fkContractType');
            $table->integer('fkContrat');
            $table->integer('fkEmployee');
            //what to add ?
            $table->string('traceDate');
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
        Schema::dropIfExists('contract');
    }
}
