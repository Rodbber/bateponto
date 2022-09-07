<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('func_intervalo_inicios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empresa_funcionario_id');
            $table->foreign('empresa_funcionario_id')->references('id')->on('empresa_funcionarios');
            $table->unsignedBigInteger('funcionario_ponto_inicio_id');
            $table->foreign('funcionario_ponto_inicio_id')->references('id')->on('funcionario_ponto_inicios');
            $table->unsignedBigInteger('funcionario_pausa_id');
            $table->foreign('funcionario_pausa_id')->references('id')->on('funcionario_pausas');
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
        Schema::dropIfExists('func_intervalo_inicios');
    }
};
