<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'user_id', 'bem_locavel_id', 'data_inicio', 'data_fim', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bemLocavel()
    {
        return $this->belongsTo(BemLocavel::class, 'bem_locavel_id');
    }
}
