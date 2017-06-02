<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBankToCorrespondentes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('correspondentes', function (Blueprint $table) {

            $table->smallInteger('bank')->nullable();
            $table->string('tipo_conta')->nullable();
            $table->string('ag')->nullable();
            $table->string('conta')->nullable();
            $table->string('cnpj')->nullable();
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
