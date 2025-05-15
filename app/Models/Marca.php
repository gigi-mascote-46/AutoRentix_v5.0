<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    protected $fillable = ['nome'];

    public function bensLocaveis()
    {
        return $this->hasMany(BemLocavel::class);
    }
}
