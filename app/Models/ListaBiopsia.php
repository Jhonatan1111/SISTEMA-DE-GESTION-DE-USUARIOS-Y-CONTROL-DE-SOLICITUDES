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
    //
}
