<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBemLocavelPhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bem_locavel_photos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bem_locavel_id');
            $table->string('photo_path');
            $table->timestamps();

            $table->foreign('bem_locavel_id')->references('id')->on('bens_locaveis')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bem_locavel_photos');
    }
}
