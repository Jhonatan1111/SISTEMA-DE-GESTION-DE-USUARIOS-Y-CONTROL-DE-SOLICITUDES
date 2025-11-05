<?php

namespace App\Http\Controllers;

use App\Models\Biopsia;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

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
                            ->orWhere('propietario', 'like', "%{$buscar}%");
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
        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha_recibida', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha_recibida', '<=', $request->fecha_hasta);
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

    // EXPORTAR BIOPSIAS A PDF
    public function exportarPdf(Request $request)
    {
        $query = Biopsia::with(['paciente', 'mascota', 'doctor']);

        // Aplicar filtros
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
                            ->orWhere('propietario', 'like', "%{$buscar}%");
                    })
                    ->orWhereHas('doctor', function ($q) use ($buscar) {
                        $q->where('nombre', 'like', "%{$buscar}%")
                            ->orWhere('apellido', 'like', "%{$buscar}%");
                    });
            });
        }

        if ($request->filled('categoria')) {
            if ($request->categoria === 'persona') {
                $query->whereNotNull('paciente_id');
            } elseif ($request->categoria === 'mascota') {
                $query->whereNotNull('mascota_id');
            }
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('doctor')) {
            $query->where('doctor_id', $request->doctor);
        }
        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha_recibida', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha_recibida', '<=', $request->fecha_hasta);
        }

        $biopsias = $query->orderBy('fecha_recibida', 'desc')->get();

        // Capturar filtros aplicados para mostrarlos en el PDF
        $filtros = $request->only(['buscar', 'categoria', 'tipo', 'estado', 'doctor']);
        $doctorNombre = null;
        if ($request->filled('doctor')) {
            $doc = Doctor::find($request->doctor);
            if ($doc) {
                $doctorNombre = 'Dr. ' . $doc->nombre . ' ' . $doc->apellido;
            }
        }

        // Preparar datos para el PDF
        $data = [
            'biopsias' => $biopsias,
            'fecha' => now()->format('d/m/Y'),
            'hora' => now()->format('H:i:s'),
            'total' => $biopsias->count(),
            'filtros' => $filtros,
            'doctorNombre' => $doctorNombre,
        ];

        $pdf = Pdf::loadView('biopsias.pdf.reporte', $data);

        return $pdf->download('reporte_biopsias_' . now()->format('Y-m-d') . '.pdf');
    }
}
