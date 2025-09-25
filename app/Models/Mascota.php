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

<<<<<<< HEAD
    protected $casts = [
        'edad' => 'integer',
        'celular' => 'integer',
        'sexo' => 'string',
    ];
=======
    protected $casts = ['edad' => 'integer', 'celular' => 'integer', 'sexo' => 'string',];
>>>>>>> de1c (se creo migracion de biopsia, controlador y vistas, siendo asi funciona la logica de crear y vista de login pero se seguira trabajando mas en la logica)

    // Relacion uno a muchos con biopsias en donde 1 mascota puede tener muchas biopsias
    public function biopsias()
    {
        return $this->hasMany(Biopsia::class, 'mascota_id');
    }
}
