<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListaBiopsia extends Model
{
    protected $table = "lista_biopsias";
    protected $fillable = [
        'codigo',
        'descripcion',
        'macroscopico'
    ];

    public static function generarCodigoLista()
    {
        // Buscar el último código que empiece con 'LB'
        $ultimo = static::where('codigo', 'like', 'LB%')
            ->orderBy('codigo', 'desc')
            ->first();

        // Si no hay registros, empezar con LB001
        if ($ultimo) {
            // Extraer el número del código (ej: LB003 -> 3)
            $ultimoNumero = (int)substr($ultimo->codigo, 2);
            $nuevoNumero = $ultimoNumero + 1;
        } else {
            $nuevoNumero = 1;
        }

        // Formato: LB001, LB002, LB003
        return sprintf("LB%03d", $nuevoNumero);
    }
    //
}
