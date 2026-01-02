<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBensLocaveisTable extends Migration
{
    public function up()
    {
        Schema::create('bens_locaveis', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 255);
            $table->text('descricao')->nullable();
            $table->string('registo_unico_publico', 20)->unique()->nullable();
            $table->decimal('preco_por_dia', 8, 2);
            $table->boolean('disponivel')->default(true);
            $table->foreignId('tipo_bem_id')->constrained('tipo_bens')->onDelete('cascade');
            $table->foreignId('marca_id')->constrained('marca')->onDelete('cascade');
            $table->string('modelo', 100)->nullable();
            $table->integer('ano')->nullable();
            $table->string('matricula', 20)->nullable();
            $table->string('combustivel', 20)->nullable();
            $table->string('transmissao', 20)->nullable();
            $table->integer('lugares')->nullable();
            $table->integer('portas')->nullable();
            $table->index(['preco_por_dia', 'disponivel'], 'idx_preco_disponivel');
            $table->timestamps(0);
        });
    }

    public function down()
    {
        Schema::dropIfExists('bens_locaveis');
    }
}
