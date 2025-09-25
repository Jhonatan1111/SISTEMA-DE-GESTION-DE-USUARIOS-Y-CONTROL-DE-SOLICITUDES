<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mascota extends Model
{
    protected $table = 'mascotas';
    protected $fillable = ['nombre', 'edad', 'sexo', 'especie', 'raza', 'propietario', 'correo', 'celular',];

    protected $casts = ['edad' => 'integer', 'celular' => 'integer', 'sexo' => 'string',];
}
