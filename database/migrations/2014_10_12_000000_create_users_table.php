<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->string('email')->unique();
            $table->string('password');
            $table->tinyInteger('level')->default('1'); // 1 - correspondente , 2 - cliente,
                                        // 3 - operador, 4- negociador, 5 - coordenador,
                                        // 6 - financeiro, 9 - admin
            $table->string('phone')->nullable();
            $table->string('avatar')->default('user-default.jpg');
            $table->text('endereco')->nullable();
            $table->unsignedInteger('cliente_id')->nullable(); // se tiver vinculo com adv/cliente
            $table->unsignedInteger('correspondente_id')->nullable(); // se for um correspondente

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
