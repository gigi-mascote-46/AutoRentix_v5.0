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
        // Correção para SQLite: Remover índice que depende da coluna a ser apagada
        try {
            Schema::table('bens_locaveis', function (Blueprint $table) {
                $table->dropIndex('idx_preco_disponivel');
            });
        } catch (\Exception $e) {
            // Continua se o índice não existir
        }

        Schema::table('bens_locaveis', function (Blueprint $table) {
            // Remover a coluna antiga 'preco_por_dia' se existir, pois causa conflito de NOT NULL
            if (Schema::hasColumn('bens_locaveis', 'preco_por_dia')) {
                $table->dropColumn('preco_por_dia');
            }

            if (!Schema::hasColumn('bens_locaveis', 'preco_diario')) {
                $table->decimal('preco_diario', 8, 2)->nullable()->after('ano');
            }
            if (!Schema::hasColumn('bens_locaveis', 'numero_passageiros')) {
                $table->integer('numero_passageiros')->default(5)->after('preco_diario');
            }
            if (!Schema::hasColumn('bens_locaveis', 'combustivel')) {
                $table->string('combustivel')->nullable()->after('numero_passageiros');
            }
            if (!Schema::hasColumn('bens_locaveis', 'transmissao')) {
                $table->string('transmissao')->nullable()->after('combustivel');
            }
            if (!Schema::hasColumn('bens_locaveis', 'manutencao')) {
                $table->boolean('manutencao')->default(false)->after('transmissao');
            }
            if (!Schema::hasColumn('bens_locaveis', 'foto_url')) {
                $table->string('foto_url')->nullable()->after('manutencao');
            }
            // Tentar tornar 'nome' nullable se existir, pois os formulários não o enviam
            if (Schema::hasColumn('bens_locaveis', 'nome')) {
                $table->string('nome')->nullable()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bens_locaveis', function (Blueprint $table) {
            $table->dropColumn([
                'preco_diario',
                'numero_passageiros',
                'combustivel',
                'transmissao',
                'manutencao',
                'foto_url'
            ]);
        });
    }
};
