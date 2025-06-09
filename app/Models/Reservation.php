<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'vehicle_id', 'data_inicio', 'data_fim', 'localizacao_entrega', 'localizacao_recolha', 'status'
    ];

    protected $casts = [
        'data_inicio' => 'datetime',
        'data_fim' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bemLocavel()
    {
        return $this->belongsTo(BemLocavel::class, 'vehicle_id');
    }

    public function localizacaoEntrega()
    {
        return $this->belongsTo(Localizacao::class, 'localizacao_entrega');
    }

    public function localizacaoRecolha()
    {
        return $this->belongsTo(Localizacao::class, 'localizacao_recolha');
    }
}
