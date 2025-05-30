<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateLocalizacoesTableFix extends Migration
{
    public function up()
    {
        Schema::table('localizacoes', function (Blueprint $table) {
            // Add new column without foreign key
            $table->string('registo_unico_publico', 20)->nullable()->after('id');
        });

        // Populate new column based on existing bem_locavel_id
        DB::statement('
            UPDATE localizacoes l
            JOIN bens_locaveis b ON l.bem_locavel_id = b.id
            SET l.registo_unico_publico = b.registo_unico_publico
        ');

        Schema::table('localizacoes', function (Blueprint $table) {
            // Make new column not nullable
            $table->string('registo_unico_publico', 20)->nullable(false)->change();

            // Drop old column without dropping foreign key
            $table->dropColumn('bem_locavel_id');

            // Add foreign key constraint on new column
            $table->foreign('registo_unico_publico')->references('registo_unico_publico')->on('bens_locaveis')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('localizacoes', function (Blueprint $table) {
            // Drop new foreign key and column
            $table->dropForeign(['registo_unico_publico']);
            $table->dropColumn('registo_unico_publico');

            // Add old column back
            $table->unsignedBigInteger('bem_locavel_id')->after('id');

            // Add foreign key constraint on old column
            $table->foreign('bem_locavel_id')->references('id')->on('bens_locaveis')->onDelete('cascade');
        });
    }
}
