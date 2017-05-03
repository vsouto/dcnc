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
            $table->string('slug');
            $table->unsignedInteger('comarca_id');
            $table->smallInteger('rating');
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
            $table->double('valor');
            $table->double('max'); // valor maximo
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
        Schema::dropIfExists('correspondentes_servico');
    }
}
