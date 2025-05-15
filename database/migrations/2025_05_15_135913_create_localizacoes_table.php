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
            $table->foreignId('bem_locavel_id')->constrained('bens_locaveis')->onDelete('cascade')->nullable(false);
            $table->string('cidade', 100);
            $table->string('filial', 100)->nullable();
            $table->string('posicao', 100);
            $table->timestamps();

            $table->unique(['filial', 'posicao']); // Restrição UNIQUE
        });
    }

    public function down()
    {
        Schema::dropIfExists('localizacoes');
    }
}
