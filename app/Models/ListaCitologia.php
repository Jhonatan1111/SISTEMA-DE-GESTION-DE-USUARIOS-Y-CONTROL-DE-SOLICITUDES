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
        'descripcion',
        'diagnostico',

    ];

    public static function generarCodigoLista()
    {
        // Buscar el último código que empiece con 'LC'
        $ultimo = static::where('codigo', 'like', 'LC%')
            ->orderBy('codigo', 'desc')
            ->first();

        if ($ultimo) {
            // Extraer el número del código (ej: LC003 -> 3)
            $ultimoNumero = (int)substr($ultimo->codigo, 2);
            $nuevoNumero = $ultimoNumero + 1;
        } else {
            $nuevoNumero = 1;
        }

        // Formato: LC001, LC002, LC003...
        return sprintf("LC%03d", $nuevoNumero);
    }
}
