<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Localizacao extends Model
{
    protected $table = 'localizacoes';

    protected $fillable = ['nome', 'endereco', 'cidade', 'codigo_postal'];

    public function bensLocaveis()
    {
        return $this->hasMany(BemLocavel::class);
    }
}
