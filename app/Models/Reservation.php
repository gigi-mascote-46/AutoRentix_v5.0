<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'registo_unico_publico', 'data_inicio', 'data_fim', 'status'
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
        return $this->belongsTo(BemLocavel::class, 'registo_unico_publico', 'registo_unico_publico');
    }
}
