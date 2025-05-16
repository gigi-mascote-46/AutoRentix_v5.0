<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarcaTable extends Migration
{
    public function up()
    {
        Schema::create('marca', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_bem_id')->constrained('tipo_bens')->onDelete('cascade');
            $table->string('nome', 100);
            $table->text('observacao')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('marca');
    }
}
