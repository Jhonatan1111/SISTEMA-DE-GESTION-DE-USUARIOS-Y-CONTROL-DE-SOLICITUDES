<?php

namespace App\Models;

<<<<<<< HEAD
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Biopsia extends Model
{
    use HasFactory;
    protected $table = 'biopsias';


=======
use Illuminate\Database\Eloquent\Model;

class Biopsia extends Model
{
    //
    protected $table = 'biopsias';
>>>>>>> de1c (se creo migracion de biopsia, controlador y vistas, siendo asi funciona la logica de crear y vista de login pero se seguira trabajando mas en la logica)
    protected $fillable = [
        'nbiopsia',
        'diagnostico_clinico',
        'fecha_recibida',
<<<<<<< HEAD
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
=======
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
>>>>>>> de1c (se creo migracion de biopsia, controlador y vistas, siendo asi funciona la logica de crear y vista de login pero se seguira trabajando mas en la logica)
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

<<<<<<< HEAD
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
=======
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
>>>>>>> de1c (se creo migracion de biopsia, controlador y vistas, siendo asi funciona la logica de crear y vista de login pero se seguira trabajando mas en la logica)
    }
}
