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
        Schema::create('funcionario_intervalo_inicio_poligonos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inicio_id');
            $table->unsignedBigInteger('poligono_id');
            $table->foreign('inicio_id')->references('id')->on('func_intervalo_inicios');
            $table->foreign('poligono_id')->references('id')->on('bateponto_poligonos');
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
        Schema::dropIfExists('funcionario_intervalo_inicio_poligonos');
    }
};
