<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mascota extends Model
{
    protected $table = 'mascotas';
    protected $fillable = [
        'nombre',
        'edad',
        'sexo',
        'especie',
        'raza',
        'propietario',
        'correo',
        'celular',
    ];

    protected $casts = [
        'edad' => 'integer',
        'celular' => 'integer',
        'sexo' => 'string',
    ];

    // Relacion uno a muchos con biopsias en donde 1 mascota puede tener muchas biopsias
    public function biopsias()
    {
        return $this->hasMany(Biopsia::class, 'mascota_id');
    }
}
