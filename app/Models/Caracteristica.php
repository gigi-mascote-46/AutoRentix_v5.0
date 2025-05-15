<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Caracteristica extends Model
{
    protected $table = 'caracteristicas';

    protected $fillable = ['nome'];

    public function bensLocaveis()
    {
        return $this->belongsToMany(BemLocavel::class, 'bem_caracteristicas');
    }
}
