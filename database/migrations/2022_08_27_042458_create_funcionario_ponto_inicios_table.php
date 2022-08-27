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
        Schema::create('funcionario_ponto_inicios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empresa_funcionario_id');
            $table->foreign('empresa_funcionario_id')->references('id')->on('empresa_funcionarios');
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
        Schema::dropIfExists('funcionario_ponto_inicios');
    }
};
