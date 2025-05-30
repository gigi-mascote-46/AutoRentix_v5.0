<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Localizacao extends Model
{
    protected $table = 'localizacoes';
    protected $fillable = ['registo_unico_publico', 'cidade', 'filial', 'posicao'];
    public $timestamps = false;

    public function bemLocavel()
    {
        return $this->belongsTo(BemLocavel::class, 'registo_unico_publico', 'registo_unico_publico');
    }
}
