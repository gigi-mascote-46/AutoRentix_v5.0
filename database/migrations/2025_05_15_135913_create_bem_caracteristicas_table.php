<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCaracteristicasTable extends Migration
{
    public function up()
    {
        Schema::create('caracteristicas', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 100)->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('caracteristicas');
    }
}

class CreateBemCaracteristicasTable extends Migration
{
    public function up()
    {
        Schema::create('bem_caracteristicas', function (Blueprint $table) {
            $table->foreignId('bem_locavel_id')->constrained('bens_locaveis')->onDelete('cascade');
            $table->foreignId('caracteristica_id')->constrained('caracteristicas')->onDelete('cascade');
            $table->primary(['bem_locavel_id', 'caracteristica_id']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bem_caracteristicas');
    }
}
