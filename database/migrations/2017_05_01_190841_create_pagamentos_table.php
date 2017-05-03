<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagamentos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('diligencia_id');
            $table->unsignedInteger('authorized_id'); // who autorized?
            $table->unsignedInteger('receiver_id')->nullable(); // who received?
            $table->char('tipo',1); // (D)ebito, (C)redito
            $table->boolean('efetivada')->default(0); // done?
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
        Schema::dropIfExists('pagamentos');
    }
}
