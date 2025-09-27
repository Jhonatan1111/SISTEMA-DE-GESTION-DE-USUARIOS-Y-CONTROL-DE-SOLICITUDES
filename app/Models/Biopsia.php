<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Biopsia extends Model
{
    use HasFactory;
    protected $table = 'biopsias';
    
    // Configurar nbiopsia como clave primaria
    protected $primaryKey = 'nbiopsia';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nbiopsia',
        'diagnostico_clinico',
        'fecha_recibida',
        'estado',
        'paciente_id',
        'mascota_id',
        'doctor_id'
    ];

    protected $casts = [
        'estado' => 'boolean',
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
            $nuevoNumero = $ultimoNumero + 1;
        } else {
            $nuevoNumero = 1;
        }

        return sprintf("B%s%s%04d", $año, $mes, $nuevoNumero);
    }
    public function scopeActivas($query)
    {
        return $query->where('estado', true);
    }

    public function scopeArchivadas($query)
    {
        return $query->where('estado', false);
    }

    public function scopePersonas($query)
    {
        return $query->whereNotNull('paciente_id');
    }

    // Scope para biopsias de mascotas
    public function scopeMascotas($query)
    {
        return $query->whereNotNull('mascota_id');
    }

    // Método para archivar biopsia
    public function archivar()
    {
        return $this->update(['estado' => false]);
    }

    // Método para restaurar biopsia
    public function restaurar()
    {
        return $this->update(['estado' => true]);
    }

    // Verificar si está archivada
    public function estaArchivada()
    {
        return !$this->estado;
    }

    // Verificar si está activa
    public function estaActiva()
    {
        return $this->estado;
    }
}
