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
        Schema::create('func_intervalo_fins', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empresa_funcionario_id');
            $table->foreign('empresa_funcionario_id')->references('id')->on('empresa_funcionarios');
            $table->unsignedBigInteger('func_intervalo_inicio_id');
            $table->foreign('func_intervalo_inicio_id')->references('id')->on('func_intervalo_inicios');
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
        Schema::dropIfExists('func_intervalo_fins');
    }
};
