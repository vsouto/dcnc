<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiligenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diligencias', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titulo');
            $table->text('descricao');
            $table->string('num_integracao');
            $table->dateTime('prazo');
            $table->unsignedInteger('tipo_id'); // Audiencia?
            $table->unsignedInteger('advogado_id'); // autor
            $table->unsignedInteger('solicitante_id'); // solicitante
            $table->unsignedInteger('correspondente_id'); //
            $table->text('reu'); // infos do reu
            $table->string('num_processo'); //
            $table->string('orgao'); //
            $table->string('local_orgao'); //
            $table->string('vara'); //
            $table->text('orientacoes'); //
            $table->timestamps();
        });

        Schema::create('diligencia_file', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('diligencia_id');
            $table->unsignedInteger('file_id');
            $table->timestamps();
        });

        Schema::create('diligencia_email', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('diligencia_id');
            $table->unsignedInteger('email_id');
            $table->boolean('enviado');
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
        Schema::dropIfExists('diligencias');
        Schema::dropIfExists('diligencia_file');
        Schema::dropIfExists('diligencia_email');
    }
}
