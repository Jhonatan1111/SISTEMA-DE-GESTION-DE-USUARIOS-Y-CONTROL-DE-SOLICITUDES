<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Biopsia extends Model
{
    //
    protected $table = 'biopsias';
    protected $fillable = [
        'nbiopsia',
        'diagnostico_clinico',
        'fecha_recibida',
        'doctor_id',
        'paciente_id',
        'mascota_id',
    ];

    protected $casts = [
        'fecha_recibida' => 'date',
        'doctor_id' => 'integer',
        'paciente_id' => 'integer',
        'mascota_id' => 'integer',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }

    public function mascota()
    {
        return $this->belongsTo(Mascota::class, 'mascota_id');
    }
    public function obtenerTipoPacienteAttribute()
    {
        if ($this->paciente_id) {
            return 'Humano';
        }
        if ($this->mascota_id) {
            return 'Mascota';
        }
        return 'Indefinido';
    }
}
