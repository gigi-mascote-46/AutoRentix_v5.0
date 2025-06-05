<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBemLocavelPhotosTable extends Migration
{
    public function up()
    {
        Schema::create('bem_locavel_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bem_locavel_id')->constrained('bens_locaveis')->onDelete('cascade');
            $table->string('photo_path');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bem_locavel_photos');
    }
}
