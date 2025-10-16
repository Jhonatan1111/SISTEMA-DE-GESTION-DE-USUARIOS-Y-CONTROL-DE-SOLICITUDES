<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ListaCitologia extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'lista_citologias';

    protected $fillable = [
        'codigo',
        'diagnostico',
        'macroscopico',
        'microscopico'
    ];

    public static function generarCodigoLista()
    {
        // Buscar el último código que empiece con 'C'
        $ultimo = static::where('codigo', 'like', 'C%')
            ->orderBy('codigo', 'desc')
            ->first();

        if ($ultimo) {
            // Extraer el número del código (ej: C003 -> 3)
            $ultimoNumero = (int)substr($ultimo->codigo, 1);
            $nuevoNumero = $ultimoNumero + 1;
        } else {
            $nuevoNumero = 1;
        }

        // Formato: C001, C002, C003...
        return sprintf("C%03d", $nuevoNumero);
    }
}
