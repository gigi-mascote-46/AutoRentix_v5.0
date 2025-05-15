<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pagamento extends Model
{
    protected $table = 'pagamentos';

    protected $fillable = ['reserva_id', 'valor', 'metodo', 'estado'];

    public function reserva()
    {
        return $this->belongsTo(Reserva::class);
    }
}
