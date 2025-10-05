<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListaBiopsia extends Model
{
    protected $table = "lista_biopsias";
    protected $fillable = [
        'codigo',
        'diagnostico',
        'macroscopico',
        'microscopico',
        'descripcion'
    ];
    protected $casts = [
        // 'codigo' => 'string',
        // 'diagnostico' => 'string',
    ];

    // RELACIONES
    public function biopsias()
    {
        return $this->hasMany(Biopsia::class, 'lista_id');
    }
    public static function generarCodigoLista()
    {
        // Buscar el último código que empiece con 'L'
        $ultimo = static::where('codigo', 'like', 'L%')
            ->orderBy('codigo', 'desc')
            ->first();

        if ($ultimo) {
            // Extraer el número del código (ej: L003 -> 3)
            $ultimoNumero = (int)substr($ultimo->codigo, 1);
            $nuevoNumero = $ultimoNumero + 1;
        } else {
            $nuevoNumero = 1;
        }

        // Formato: L001, L002, L003...
        return sprintf("L%03d", $nuevoNumero);
    }
    //
}
