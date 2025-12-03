<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Citolgia extends Model
{

    use HasFactory;
    protected $table = "citologias";
    protected $primaryKey = 'ncitologia';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'ncitologia',
        'diagnostico_clinico',
        'fecha_recibida',
        'estado',
        'remitente_especial',
        'celular_remitente_especial',
        'tipo',
        'descripcion',
        'diagnostico',
        'doctor_id',
        'paciente_id',
        'mascota_id',
        'lista_id',
    ];

    protected $casts = [
        'fecha_recibida' => 'date',
        'estado' => 'boolean',
        'tipo' => 'string',
        'descripcion' => 'string',
        'doctor_id' => 'integer',
        'lista_id' => 'integer',
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

    public function lista_citologia()
    {
        return $this->belongsTo(ListaCitologia::class, 'lista_id');
    }
    // Métodos estáticos
    public function scopePersonas($query)
    {
        return $query->whereNotNull('paciente_id');
    }
    public function scopeListaCitologias($query)
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
    // Generar número de citología según tipo
    public static function generarNumeroCitologia($tipo = 'normal')
    {
        return DB::transaction(function () use ($tipo) {
            $prefijo = match ($tipo) {
                'liquida' => 'CEL',
                'especial' => 'CEE',
                default => 'CEN',
            };

            $ultimo = static::where('ncitologia', 'like', "{$prefijo}%")
                ->whereRaw('LENGTH(ncitologia) = ?', [strlen($prefijo) + 4])
                ->lockForUpdate()
                ->orderBy('ncitologia', 'desc')
                ->first();

            if ($ultimo) {
                $ultimoNumero = (int) substr($ultimo->ncitologia, strlen($prefijo));
                $nuevoNumero = $ultimoNumero + 1;
            } else {
                $nuevoNumero = 1;
            }

            return sprintf("%s%04d", $prefijo, $nuevoNumero);
        });
    }

    public function scopeActivas($query)
    {
        return $query->where('estado', true);
    }

    public function scopeArchivadas($query)
    {
        return $query->where('estado', false);
    }
}
