<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bens_locaveis', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->decimal('preco_por_dia', 8, 2);
            $table->boolean('disponivel')->default(true);
            $table->foreignId('tipo_bem_id')->constrained('tipo_bens')->onDelete('cascade');
            $table->foreignId('marca_id')->constrained('marca')->onDelete('cascade');
            $table->foreignId('localizacao_id')->constrained('localizacoes')->onDelete('cascade');
            $table->string('modelo')->nullable();
            $table->integer('ano')->nullable();
            $table->string('matricula')->nullable();
            $table->string('combustivel')->nullable();
            $table->string('transmissao')->nullable();
            $table->integer('lugares')->nullable();
            $table->integer('portas')->nullable();
            $table->boolean('ar_condicionado')->default(false);
            $table->boolean('gps')->default(false);
            $table->boolean('bluetooth')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bens_locaveis');
    }
};
