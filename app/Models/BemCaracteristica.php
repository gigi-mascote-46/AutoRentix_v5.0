<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BemCaracteristica extends Model
{
    protected $table = 'bem_caracteristicas';

    protected $fillable = ['bem_locavel_id', 'caracteristica_id'];

    public function bemLocavel()
    {
        return $this->belongsTo(BemLocavel::class);
    }

    public function caracteristica()
    {
        return $this->belongsTo(Caracteristica::class);
    }
}
