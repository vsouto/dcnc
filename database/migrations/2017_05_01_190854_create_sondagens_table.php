<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSondagensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sondagens', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('diligencia_id');
            $table->dateTime('prazo'); // Prazo que expira a sondagem
            $table->char('status',1); // (S)elecionada, (R)ecusada, (E)m andamento
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
        Schema::dropIfExists('sondagens');
    }
}
