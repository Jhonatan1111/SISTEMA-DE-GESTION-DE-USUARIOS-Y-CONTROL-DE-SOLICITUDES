<?php

namespace App\Http\Controllers;

use App\Models\Citolgia;
use Illuminate\Http\Request;

class CitolgiaController extends Controller
{
    public function index(Request $request)
    {
        $query = Citolgia::with(['doctor', 'paciente', 'mascota'])
            ->orderBy('fecha_recibida', 'desc');


        // Filtro por tipo de citología (normal/liquida)
        if ($request->has('tipo') && $request->tipo !== '') {
            $query->where('tipo', $request->tipo);
        }

        // Filtro por estado
        if ($request->has('estado') && $request->estado !== '') {
            if ($request->estado === 'activas') {
                $query->activas();
            } elseif ($request->estado === 'archivadas') {
                $query->archivadas();
            }
        }

        // Filtro por búsqueda
        if ($request->has('buscar') && $request->buscar !== '') {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('ncitologia', 'like', "%{$buscar}%")
                    ->orWhere('diagnostico_clinico', 'like', "%{$buscar}%")
                    ->orWhereHas('doctor', function ($subq) use ($buscar) {
                        $subq->where('nombre', 'like', "%{$buscar}%")
                            ->orWhere('apellido', 'like', "%{$buscar}%");
                    })
                    ->orWhereHas('paciente', function ($subq) use ($buscar) {
                        $subq->where('nombre', 'like', "%{$buscar}%")
                            ->orWhere('apellido', 'like', "%{$buscar}%")
                            ->orWhere('dui', 'like', "%{$buscar}%");
                    })
                    ->orWhereHas('mascota', function ($subq) use ($buscar) {
                        $subq->where('nombre', 'like', "%{$buscar}%")
                            ->orWhere('propietario', 'like', "%{$buscar}%");
                    });
            });
        }

        $citologias = $query->paginate(15);

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

        $totalLiquidas = Citolgia::activas()->where('tipo', 'liquida')->count();
        $totalEspeciales = Citolgia::activas()->where('tipo', 'especial')->count();
        $totalArchivadas = Citolgia::archivadas()->count();

        $estadisticas = [
            'total' => $totalActivas,
            'personas' => $totalPersonas,
            'mascotas' => $totalMascotas,
            'normales' => $totalNormales,
            'liquidas' => $totalLiquidas,
            'especiales' => $totalEspeciales,
            'archivadas' => $totalArchivadas,
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
}
