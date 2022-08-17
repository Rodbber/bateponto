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
        Schema::create('bateponto_circulos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empresa_user_id');
            $table->foreign('empresa_user_id')->references('id')->on('empresa_users');
            $table->string('nome');
            $table->string('ponto');
            $table->float('raio');
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
        Schema::dropIfExists('bateponto_circulos');
    }
};
