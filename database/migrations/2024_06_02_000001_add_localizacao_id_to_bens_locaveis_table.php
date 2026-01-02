<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLocalizacaoIdToBensLocaveisTable extends Migration
{
    public function up()
    {
        Schema::table('bens_locaveis', function (Blueprint $table) {
            $table->foreignId('localizacao_id')->nullable()->constrained('localizacoes')->onDelete('set null')->after('marca_id');
        });
    }

    public function down()
    {
        Schema::table('bens_locaveis', function (Blueprint $table) {
            $table->dropForeign(['localizacao_id']);
            $table->dropColumn('localizacao_id');
        });
    }
}
