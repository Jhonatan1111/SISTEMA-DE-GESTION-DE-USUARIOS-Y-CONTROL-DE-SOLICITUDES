<?php

namespace App\Http\Controllers;

use App\Models\Citolgia;
use App\Models\Doctor;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class CitolgiaController extends Controller
{
    public function index(Request $request)
    {
        $query = Citolgia::with(['paciente', 'mascota', 'doctor'])
            ->orderBy('fecha_recibida', 'desc');

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

        // if ($request->filled('categoria')) {
        //     if ($request->categoria === 'persona') {
        //         $query->whereNotNull('paciente_id');
        //     } elseif ($request->categoria === 'mascota') {
        //         $query->whereNotNull('mascota_id');
        //     }
        // }

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

        $citologias = $query->paginate(10);

        // Estadísticas generales
        $totalActivas = Citolgia::activas()->count();
        $totalPersonas = Citolgia::activas()->personas()->count();
        $totalMascotas = Citolgia::activas()->mascotas()->count();

        // Contar normales (incluye NULL como normal por defecto)
        $totalNormales = Citolgia::activas()
            ->where(function ($q) {
                $q->where('tipo', 'normal')->orWhereNull('tipo');
            })
            ->count();

        $archivadasPersonas = Citolgia::archivadas()->personas()->count();
        $archivadasMascotas = Citolgia::archivadas()->mascotas()->count();

        $estadisticas = [
            'total' => $totalActivas,
            'personas' => $totalPersonas,
            'mascotas' => $totalMascotas,
            'archivadas' => $archivadasPersonas + $archivadasMascotas,
        ];


        return view('citologias.index', compact('citologias', 'estadisticas'));
    }

    public function show($ncitologia)
    {
        $citologia = Citolgia::with(['paciente', 'mascota', 'doctor'])
            ->where('ncitologia', $ncitologia)
            ->firstOrFail();

        return view('citologias.show', compact('citologia'));
    }

    public function exportarPdf(Request $request)
    {
        $query = Citolgia::with(['paciente', 'mascota', 'doctor']);

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

        $citologias = $query->orderBy('fecha_recibida', 'desc')->get();

        $filtros = $request->only(['buscar', 'categoria', 'tipo', 'estado', 'doctor']);
        $doctorNombre = null;
        if ($request->filled('doctor')) {
            $doc = Doctor::find($request->doctor);
            if ($doc) {
                $doctorNombre = 'Dr. ' . $doc->nombre . ' ' . $doc->apellido;
            }
        }

        $data = [
            'citologias' => $citologias,
            'fecha' => now()->format('d/m/Y'),
            'hora' => now()->format('H:i:s'),
            'total' => $citologias->count(),
            'filtros' => $filtros,
            'doctorNombre' => $doctorNombre,
        ];

        $pdf = Pdf::loadView('citologias.pdf', $data);

        return $pdf->download('reporte_citologias_' . now()->format('Y-m-d') . '.pdf');
    }
}
