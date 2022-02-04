<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fileEmployee', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('hashName');
            $table->integer('fkEmployee');
            $table->integer('fkFileType');
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
        Schema::dropIfExists('contract');
    }
}
