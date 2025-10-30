<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class Biopsia extends Model
{
    use HasFactory;
    protected $table = 'biopsias';
    protected $primaryKey = 'nbiopsia';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nbiopsia',
        'tipo',
        'estado',
        'diagnostico_clinico',
        'fecha_recibida',
        'macroscopico',
        'microscopico',
        'diagnostico',
        'doctor_id',
        'paciente_id',
        'mascota_id',
    ];

    protected $casts = [
        'tipo' => 'string',
        'estado' => 'boolean',
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


    // Métodos estáticos
    public function scopePersonas($query)
    {
        return $query->whereNotNull('paciente_id');
    }
    public function scopeListaBiopsias($query)
    {
        return $query->whereNotNull('lista_id');
    }
    public function scopeMascotas($query)
    {
        return $query->whereNotNull('mascota_id');
    }
    public function scopeDelDoctor($query, $doctorId)
    {
        return $query->where('doctor_id', $doctorId);
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
    public function scopeDelMes($query, $mes = null, $año = null)
    {
        $mes = $mes ?? now()->month;
        $año = $año ?? now()->year;

        return $query->whereMonth('fecha_recibida', $mes)
            ->whereYear('fecha_recibida', $año);
    }
    public function scopeActivas($query)
    {
        return $query->where('estado', true);
    }
    public function scopeArchivadas($query)
    {
        return $query->where('estado', false);
    }
    public static function generarNumeroBiopsia($tipoBiopsia)
    {
        return DB::transaction(function () use ($tipoBiopsia) {
            // Determinar prefijo según el tipo
            $prefijo = match ($tipoBiopsia) {
                'persona-normal' => 'BPN',
                'persona-liquida' => 'BPL',
                'mascota-normal' => 'BMN',
                'mascota-liquida' => 'BML',
                default => 'BP' // Fallback
            };

            // Bloquear para evitar duplicados
            $ultimo = static::where('nbiopsia', 'like', "{$prefijo}%")
                ->lockForUpdate()
                ->orderBy('nbiopsia', 'desc')
                ->first();

            if ($ultimo) {
                // Extraer el número completo después del prefijo
                $ultimoNumero = (int)substr($ultimo->nbiopsia, strlen($prefijo));
                $nuevoNumero = $ultimoNumero + 1;
            } else {
                // Primera biopsia del tipo
                $nuevoNumero = 1;
            }

            // Formato: BPN0001 (4 dígitos con ceros a la izquierda)
            return sprintf("%s%04d", $prefijo, $nuevoNumero);
        });
    }
}
