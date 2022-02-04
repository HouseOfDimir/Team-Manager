<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParamAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paramAdmin', function (Blueprint $table) {
            $table->id();
            $table->string('libelle', 50);
            $table->string('valeur', 100);
            $table->string('icon', 50);
            $table->string('code', 3)->unique();
            $table->char('startDate', 8);
            $table->char('endDate', 8);
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
        Schema::dropIfExists('paramAdmin');
    }
}
