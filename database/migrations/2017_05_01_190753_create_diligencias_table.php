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
            $table->string('num_integracao')->nullable();
            $table->dateTime('prazo');
            //$table->unsignedInteger('tipo_id')->default('1'); // (A)udiencia, (D)iligência
            $table->unsignedInteger('status_id')->default(1); // current status
            $table->unsignedInteger('advogado_id'); // autor
            $table->string('solicitante'); // advogado solicitante
            $table->string('autor');
            $table->unsignedInteger('correspondente_id')->nullable(); //
            $table->unsignedInteger('comarca_id')->nullable(); //
            $table->text('reu'); // infos do reu
            $table->string('num_processo'); //
            $table->string('orgao'); //
            $table->string('local_orgao')->nullable(); //
            $table->string('vara')->nullable(); //
            $table->text('orientacoes'); //
            $table->string('urgencia')->default('Normal'); //
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

        Schema::create('diligencia_servico', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('diligencia_id');
            $table->unsignedInteger('servico_id');
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
        Schema::dropIfExists('diligencia_servico');
    }
}
