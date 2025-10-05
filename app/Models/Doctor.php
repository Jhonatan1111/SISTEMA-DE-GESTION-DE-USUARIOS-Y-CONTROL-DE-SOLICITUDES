<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $table = 'doctores';

    protected $fillable = [
        'jvpm',
        'nombre',
        'apellido',
        'direccion',
        'celular',
        'fax',
        'correo',
        'activo',
    ];

    // Casts de atributos
    protected function casts(): array
    {
        return [
            'celular' => 'integer',
            'fax' => 'integer',
            'estado_servicio' => 'boolean',
        ];
    }

    public function scopeActivos($query)
    {
        return $query->where('estado_servicio', true);
    }

    public function scopeInactivos($query)
    {
        return $query->where('estado_servicio', false);
    }

    // Relacion uno a muchos con citologias en donde 1 doctor puede tener muchas citologias
    // public function citologias(){
    //     return $this->hasMany(Citologia::class, 'doctor_id');
    // }

    // Relacion uno a muchos con biopsias en donde 1 doctor puede tener muchas biopsias
    public function biopsias(){
        return $this->hasMany(Biopsia::class, 'doctor_id');
    }

}
