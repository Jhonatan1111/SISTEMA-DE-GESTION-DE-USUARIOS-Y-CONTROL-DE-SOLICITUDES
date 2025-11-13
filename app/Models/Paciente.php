<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    protected $table = "pacientes";
    protected $fillable = [
        "nombre",
        "apellido",
        "dui",
        "estado",
        "sexo",
        "fecha_nacimiento",
        "estado_civil",
        "ocupacion",
        "correo",
        "direccion",
        "celular"
    ];

    protected $casts = [
        "estado" => "boolean",
        "sexo" => "string",
        "fecha_nacimiento" => "date",
        "celular" => "integer",
    ];

    // Relacion uno a muchos con biopsias en donde 1 paciente puede tener muchas biopsias
    public function biopsias()
    {
        return $this->hasMany(Biopsia::class, 'paciente_id');
    }
}
