<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListaCitologia extends Model
{
    protected $table = 'lista_citologias';
    
    protected $fillable = [
        'codigo',
        'diagnostico',
        'macroscopico',
        'microscopico'
    ];

    /**
     * Genera un código único para citología
     * Formato: C001, C002, C003...
     */
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
