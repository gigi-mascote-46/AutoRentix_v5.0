<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bens_locaveis', function (Blueprint $table) {
            // Adiciona a coluna cor se não existir
            if (!Schema::hasColumn('bens_locaveis', 'cor')) {
                $table->string('cor')->nullable()->after('modelo');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bens_locaveis', function (Blueprint $table) {
            $table->dropColumn('cor');
        });
    }
};
