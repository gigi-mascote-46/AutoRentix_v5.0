<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BemLocavelPhoto extends Model
{
    protected $table = 'bem_locavel_photos';

    protected $fillable = [
        'bem_locavel_id',
        'photo_path',
    ];

    public function bemLocavel()
    {
        return $this->belongsTo(BemLocavel::class, 'bem_locavel_id');
    }
}
