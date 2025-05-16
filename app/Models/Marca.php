<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    protected $table = 'marca';
    protected $fillable = ['tipo_bem_id', 'nome', 'observacao'];
    public $timestamps = false;

    public function tipoBem()
    {
        return $this->belongsTo(TipoBem::class, 'tipo_bem_id');
    }

    public function bensLocaveis()
    {
        return $this->hasMany(BemLocavel::class, 'marca_id');
    }
}
