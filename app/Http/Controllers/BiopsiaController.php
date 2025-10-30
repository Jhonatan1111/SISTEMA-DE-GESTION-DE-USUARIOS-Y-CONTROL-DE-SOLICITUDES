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
            ->orderBy('fecha_recibida', 'desc');

        // Búsqueda general
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('diagnostico_clinico', 'like', "%{$buscar}%")
                    ->orWhereHas('paciente', function ($q) use ($buscar) {
                        $q->where('nombre', 'like', "%{$buscar}%")
                            ->orWhere('apellido', 'like', "%{$buscar}%")
                            ->orWhere('dui', 'like', "%{$buscar}%");
                    })
                    ->orWhereHas('mascota', function ($q) use ($buscar) {
                        $q->where('nombre', 'like', "%{$buscar}%")
                            ->orWhere('dueno', 'like', "%{$buscar}%");
                    })
                    ->orWhereHas('doctor', function ($q) use ($buscar) {
                        $q->where('nombre', 'like', "%{$buscar}%")
                            ->orWhere('apellido', 'like', "%{$buscar}%");
                    });
            });
        }

        // Filtro por categoría (persona/mascota)
        if ($request->filled('categoria')) {
            if ($request->categoria === 'persona') {
                $query->whereNotNull('paciente_id');
            } elseif ($request->categoria === 'mascota') {
                $query->whereNotNull('mascota_id');
            }
        }

        // Filtro por tipo
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        // Filtro por estado
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        // Filtro por doctor
        if ($request->filled('doctor')) {
            $query->where('doctor_id', $request->doctor);
        }
        $biopsias = $query->paginate(10);

        // Estadísticas simples
        $totalBiopsias = Biopsia::activas()->count();
        $biopsiaPersonas = Biopsia::activas()->personas()->count();
        $biopsiaMascotas = Biopsia::activas()->mascotas()->count();
        $archivadasPersonas = Biopsia::archivadas()->personas()->count();
        $archivadasMascotas = Biopsia::archivadas()->mascotas()->count();

        $estadisticas = [
            'total' => $totalBiopsias,
            'personas' => $biopsiaPersonas,
            'mascotas' => $biopsiaMascotas,
            'archivadas' => $archivadasPersonas + $archivadasMascotas
        ];

        return view('biopsias.index', compact('biopsias', 'estadisticas'));
    }

    // VER DETALLES DE UNA BIOPSIA
    public function show($nbiopsia)
    {
        $biopsia = Biopsia::with(['paciente', 'mascota', 'doctor'])
            ->where('nbiopsia', $nbiopsia)
            ->firstOrFail();

        return view('biopsias.show', compact('biopsia'));
    }
}
