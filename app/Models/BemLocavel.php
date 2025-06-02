<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BemLocavel extends Model
{
    use HasFactory;

    protected $table = 'bens_locaveis';

    protected $fillable = [
        'nome',
        'descricao',
        'preco_por_dia',
        'disponivel',
        'tipo_bem_id',
        'marca_id',
        'localizacao_id',
        'modelo',
        'ano',
        'matricula',
        'combustivel',
        'transmissao',
        'lugares',
        'portas',
        'ar_condicionado',
        'gps',
        'bluetooth',
    ];

    protected $casts = [
        'disponivel' => 'boolean',
        'preco_por_dia' => 'decimal:2',
        'ar_condicionado' => 'boolean',
        'gps' => 'boolean',
        'bluetooth' => 'boolean',
    ];

    // Relationships
    public function tipoBem()
    {
        return $this->belongsTo(TipoBem::class, 'tipo_bem_id');
    }

    public function marca()
    {
        return $this->belongsTo(Marca::class, 'marca_id');
    }

    public function localizacao()
    {
        return $this->belongsTo(Localizacao::class, 'localizacao_id');
    }

    public function caracteristicas()
    {
        return $this->belongsToMany(Caracteristica::class, 'bem_caracteristicas', 'bem_locavel_id', 'caracteristica_id');
    }

    public function photos()
    {
        return $this->hasMany(BemLocavelPhoto::class, 'bem_locavel_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'bem_locavel_id');
    }

    // Accessors
    public function getFirstPhotoAttribute()
    {
        return $this->photos()->first()?->url ?? '/images/default-vehicle.jpg';
    }

    public function getFormattedPriceAttribute()
    {
        return number_format($this->preco_por_dia, 2, ',', '.') . '€';
    }

    // Scopes
    public function scopeAvailable($query)
    {
        return $query->where('disponivel', true);
    }

    public function scopeByType($query, $typeId)
    {
        return $query->where('tipo_bem_id', $typeId);
    }

    public function scopeByLocation($query, $locationId)
    {
        return $query->where('localizacao_id', $locationId);
    }
}
