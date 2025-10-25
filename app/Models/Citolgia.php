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
        'macroscopico',
        'microscopico',
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
        $año = now()->year;

        // Prefijo según tipo: C para normal, L para líquida, E para especial
        $prefijo = match ($tipo) {
            'liquida' => 'CL',
            'especial' => 'CE',
            default => 'CN',
        };

        $ultimaCitologia = self::where('ncitologia', 'like', "{$prefijo}{$año}%")
            ->lockForUpdate()
            ->orderBy('ncitologia', 'desc')
            ->first();

        if ($ultimaCitologia) {
            $longitudPrefijo = 6; // CN2025 o CL2025 o CE2025
            $ultimoCorrelativo = intval(substr($ultimaCitologia->ncitologia, $longitudPrefijo));
            $nuevoNumero = $ultimoCorrelativo + 1;
        } else {
            $nuevoNumero = 1;
        }

        return sprintf("%s%s%05d", $prefijo, $año, $nuevoNumero);
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
