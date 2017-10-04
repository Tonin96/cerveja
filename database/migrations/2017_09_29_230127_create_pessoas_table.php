<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePessoasTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('pessoas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome', 80)
                ->nullable();
            $table->string('email', 50)
                ->unique()
                ->nullable();
            $table->string('telefone', 11)
                ->unique()
                ->nullable();
            $table->string('cpf', 11)
                ->unique()
                ->nullable();
            $table->date('data_nascimento')
                ->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('pessoas');
    }
}
