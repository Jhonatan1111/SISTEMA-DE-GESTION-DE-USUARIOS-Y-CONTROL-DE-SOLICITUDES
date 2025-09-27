<?php

namespace App\Http\Controllers;

use App\Models\Biopsia;
use Illuminate\Http\Request;

class BiopsiaController extends Controller
{
    // VISTA GENERAL DE TODAS LAS BIOPSIAS (PERSONAS Y MASCOTAS)
    public function index(Request $request)
    {
        $query = Biopsia::with(['paciente', 'mascota', 'doctor'])
            ->activas()
            ->orderBy('fecha_recibida', 'desc');

        // Filtro por tipo si se especifica
        if ($request->has('tipo') && $request->tipo !== '') {
            if ($request->tipo === 'personas') {
                $query->personas();
            } elseif ($request->tipo === 'mascotas') {
                $query->mascotas();
            }
        }

        // Filtro por búsqueda
        if ($request->has('buscar') && $request->buscar !== '') {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('nbiopsia', 'like', "%{$buscar}%")
                    ->orWhere('diagnostico_clinico', 'like', "%{$buscar}%")
                    ->orWhereHas('paciente', function ($subq) use ($buscar) {
                        $subq->where('nombre', 'like', "%{$buscar}%")
                            ->orWhere('apellido', 'like', "%{$buscar}%");
                    })
                    ->orWhereHas('mascota', function ($subq) use ($buscar) {
                        $subq->where('nombre', 'like', "%{$buscar}%")
                            ->orWhere('propietario', 'like', "%{$buscar}%");
                    })
                    ->orWhereHas('doctor', function ($subq) use ($buscar) {
                        $subq->where('nombre', 'like', "%{$buscar}%")
                            ->orWhere('apellido', 'like', "%{$buscar}%");
                    });
            });
        }

        $biopsias = $query->paginate(15);

        // Estadísticas simples
        $totalBiopsias = Biopsia::activas()->count();
        $biopsiaPersonas = Biopsia::activas()->personas()->count();
        $biopsiaMascotas = Biopsia::activas()->mascotas()->count();

        $estadisticas = [
            'total' => $totalBiopsias,
            'personas' => $biopsiaPersonas,
            'mascotas' => $biopsiaMascotas
        ];

        return view('biopsias.index', compact('biopsias', 'estadisticas'));
    }

    // VER DETALLES DE UNA BIOPSIA
    public function show($nbiopsia)
    {
        $biopsia = Biopsia::with(['paciente', 'mascota', 'doctor', 'listaBiopsia'])
            ->where('nbiopsia', $nbiopsia)
            ->firstOrFail();

        return view('biopsias.show', compact('biopsia'));
    }
}
