<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Localizacao extends Model
{
    protected $table = 'localizacoes';
    protected $fillable = ['vehicle_id', 'cidade', 'filial', 'posicao'];
    public $timestamps = false;

    public function bemLocavel()
    {
        return $this->belongsTo(BemLocavel::class, 'vehicle_id');
    }
}
