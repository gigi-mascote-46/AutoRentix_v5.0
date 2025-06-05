<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocalizacoesTable extends Migration
{
    public function up()
    {
        Schema::create('localizacoes', function (Blueprint $table) {
            $table->id();
            $table->string('registo_unico_publico', 20);
            $table->string('cidade', 100);
            $table->string('filial', 100)->nullable();
            $table->string('posicao', 100);
            $table->unique(['filial', 'posicao']);
            $table->foreign('registo_unico_publico')->references('registo_unico_publico')->on('bens_locaveis')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('localizacoes');
    }
}
