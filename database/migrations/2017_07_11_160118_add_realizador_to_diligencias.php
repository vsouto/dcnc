<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRealizadorToDiligencias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('diligencias', function (Blueprint $table) {

            $table->boolean('realizado_sucesso')->default('0'); // realizado com sucesso?
            $table->string('realizador_nome')->nullable(); // realizador
            $table->string('realizador_telefone')->nullable();
            $table->string('realizador_email')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
