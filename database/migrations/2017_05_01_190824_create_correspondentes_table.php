<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCorrespondentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('correspondentes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            //$table->string('email'); // email é do user
            $table->string('slug');
            $table->smallInteger('atrasos')->default(0);
            $table->smallInteger('rating')->default(3);
            $table->timestamps();
        });

        Schema::create('correspondente_sondagem', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('sondagem_id');
            $table->unsignedInteger('correspondente_id');
            $table->timestamps();
        });

        Schema::create('correspondente_servico', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('servico_id');
            $table->unsignedInteger('correspondente_id');
            $table->unsignedInteger('comarca_id');
            $table->double('valor');
            $table->timestamps();
        });

        Schema::create('comarca_correspondente', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('comarca_id');
            $table->unsignedInteger('correspondente_id');
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
        Schema::dropIfExists('correspondentes');
        Schema::dropIfExists('correspondente_sondagem');
        Schema::dropIfExists('correspondente_servico');
        Schema::dropIfExists('comarca_correspondente');
    }
}
