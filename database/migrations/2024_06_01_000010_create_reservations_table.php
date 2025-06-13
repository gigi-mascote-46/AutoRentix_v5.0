<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('vehicle_id')->constrained('bens_locaveis')->onDelete('cascade');
            $table->date('data_inicio');
            $table->date('data_fim');
            $table->foreignId('localizacao_entrega')->constrained('localizacoes');
            $table->foreignId('localizacao_recolha')->constrained('localizacoes');
            $table->enum('status', ['pendente', 'confirmada', 'cancelada'])->default('pendente');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}
