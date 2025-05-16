<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BemLocavel extends Model
{
    protected $table = 'bens_locaveis';
    protected $fillable = [
        'marca_id', 'modelo', 'registo_unico_publico', 'cor',
        'numero_passageiros', 'combustivel', 'numero_portas',
        'transmissao', 'ano', 'manutencao', 'preco_diario', 'observacao'
    ];
    public $timestamps = false;

    public function marca()
    {
        return $this->belongsTo(Marca::class, 'marca_id');
    }

    public function localizacao()
    {
        return $this->hasOne(Localizacao::class, 'bem_locavel_id');
    }

    public function caracteristicas()
    {
        return $this->belongsToMany(Caracteristica::class, 'bem_caracteristicas', 'bem_locavel_id', 'caracteristica_id');
    }

    public function reservas()
    {
        return $this->hasMany(Reservation::class, 'bem_locavel_id');
    }
}
