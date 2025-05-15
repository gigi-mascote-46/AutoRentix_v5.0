<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BemLocavel extends Model
{
    protected $table = 'bens_locaveis';

    protected $fillable = [
        'nome', 'descricao', 'preco_dia', 'marca_id',
        'tipo_bem_id', 'localizacao_id', 'disponivel'
    ];

    public function marca()
    {
        return $this->belongsTo(Marca::class);
    }

    public function tipoBem()
    {
        return $this->belongsTo(TipoBem::class);
    }

    public function localizacao()
    {
        return $this->belongsTo(Localizacao::class);
    }

    public function caracteristicas()
    {
        return $this->belongsToMany(Caracteristica::class, 'bem_caracteristicas');
    }

    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }
}
