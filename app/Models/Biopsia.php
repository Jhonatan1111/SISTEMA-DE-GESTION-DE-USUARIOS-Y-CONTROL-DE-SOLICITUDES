<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Biopsia extends Model
{
    protected $table = 'biopsias';
    protected $primaryKey = 'nbiopsia';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nbiopsia',
        'diagnostico_clinico',
        'fecha_recibida',
        'paciente_id',
        'mascota_id',
        'doctor_id',
        'list_result_biopsia_id'
    ];

    protected $casts = [
        'fecha_recibida' => 'date'
    ];

    // Relaciones
    public function paciente(): BelongsTo
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }

    public function mascota(): BelongsTo
    {
        return $this->belongsTo(Mascota::class, 'mascota_id');
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    // Nota: list_result_biopsia_id se manejará después cuando se cree esa funcionalidad

    // Atributos calculados
    public function getNombrePacienteAttribute()
    {
        // Determinar automáticamente si es humano o mascota
        if ($this->paciente_id && $this->paciente) {
            return $this->paciente->nombre . ' ' . $this->paciente->apellido;
        } elseif ($this->mascota_id && $this->mascota) {
            return $this->mascota->nombre . ' (Mascota - ' . $this->mascota->especie . ')';
        }
        return 'Sin asignar';
    }

    public function getTipoPacienteAttribute()
    {
        if ($this->paciente_id) {
            return 'humano';
        } elseif ($this->mascota_id) {
            return 'mascota';
        }
        return null;
    }

    public function getEsHumanoAttribute()
    {
        return !is_null($this->paciente_id);
    }

    public function getEsMascotaAttribute()
    {
        return !is_null($this->mascota_id);
    }

    public function getNombreDoctorAttribute()
    {
        return $this->doctor ? $this->doctor->nombre . ' ' . $this->doctor->apellido : 'Sin asignar';
    }

    public function getEstadoAttribute()
    {
        // Por ahora solo indicar si está completa o pendiente
        return $this->list_result_biopsia_id ? 'Completada' : 'Pendiente';
    }

    // Métodos estáticos
    public static function generarNumeroBiopsia()
    {
        $año = date('Y');
        $mes = date('m');

        // Buscar el último número del mes actual
        $ultimo = static::where('nbiopsia', 'like', "B{$año}{$mes}%")
            ->orderBy('nbiopsia', 'desc')
            ->first();

        if ($ultimo) {
            $ultimoNumero = (int)substr($ultimo->nbiopsia, -4);
            $nuevoNumero = $ultimoNumero++;
        } else {
            $nuevoNumero = 1;
        }

        return sprintf("B%s%s%04d", $año, $mes, $nuevoNumero);
    }

    // Scopes
    public function scopeHumanos($query)
    {
        return $query->whereNotNull('paciente_id');
    }

    public function scopeMascotas($query)
    {
        return $query->whereNotNull('mascota_id');
    }

    public function scopePendientes($query)
    {
        return $query->whereNull('list_result_biopsia_id');
    }

    public function scopeCompletadas($query)
    {
        return $query->whereNotNull('list_result_biopsia_id');
    }

    public function scopeDelMes($query, $mes = null, $año = null)
    {
        $mes = $mes ?? now()->month;
        $año = $año ?? now()->year;

        return $query->whereMonth('fecha_recibida', $mes)
            ->whereYear('fecha_recibida', $año);
    }

    public function scopeDelDoctor($query, $doctorId)
    {
        return $query->where('doctor_id', $doctorId);
    }
}
