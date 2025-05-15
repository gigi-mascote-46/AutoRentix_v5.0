<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $table = 'reservas';

    protected $fillable = ['user_id', 'bem_locavel_id', 'data_inicio', 'data_fim', 'estado'];

    public function utilizador()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function bemLocavel()
    {
        return $this->belongsTo(BemLocavel::class);
    }

    public function pagamento()
    {
        return $this->hasOne(Pagamento::class);
    }
}
