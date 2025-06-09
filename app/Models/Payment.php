<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_id', 'metodo', 'montante', 'status', 'referencia', 'comprovativo_path'
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
