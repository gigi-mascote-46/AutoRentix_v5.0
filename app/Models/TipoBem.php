<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoBem extends Model
{
    protected $table = 'tipos_bens';

    protected $fillable = ['nome'];

    public function bensLocaveis()
    {
        return $this->hasMany(BemLocavel::class);
    }
}
