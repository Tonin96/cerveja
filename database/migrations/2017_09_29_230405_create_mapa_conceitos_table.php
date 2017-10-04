<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMapaConceitosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relacao_mapa_conceito', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mapa_id')
                ->nullable();
            $table->integer('conceito_origem_id')
                ->nullable();
            $table->integer('conceito_destino_id')
                ->nullable();
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
        Schema::dropIfExists('relacao_mapa_conceito');
    }
}
