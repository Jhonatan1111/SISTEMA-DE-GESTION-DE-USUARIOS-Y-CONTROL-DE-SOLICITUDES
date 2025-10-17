<?php

namespace App\Http\Controllers;

use App\Models\Citolgia;
use Illuminate\Http\Request;

class CitolgiaController extends Controller
{
    public function index(Request $request)
    {
        $query = Citolgia::with(['doctor', 'paciente', 'mascota', 'lista_citologias'])
            ->orderBy('fecha_recibida', 'asc');


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
                $q->where('ncitologia', 'like', "%{$buscar}%")
                    ->orWhere('diagnostico_clinico', 'like', "%{$buscar}%")
                    ->orWhereHas('doctor', function ($subq) use ($buscar) {
                        $subq->where('nombre, apellido', 'like', "%{$buscar}%")
                            ->orWhere('jvpm', 'like', "%{$buscar}%");
                    })
                    ->orWhereHas('paciente', function ($subq) use ($buscar) {
                        $subq->where('nombre', 'like', "%{$buscar}%")
                            ->orWhere('apellido', 'like', "%{$buscar}%");
                    })
                    ->orWhereHas('mascota', function ($subq) use ($buscar) {
                        $subq->where('nombre', 'like', "%{$buscar}%")
                            ->orWhere('propietario', 'like', "%{$buscar}%");
                    })
                    ->orWhereHas('lista_citologias', function ($subq) use ($buscar) {
                        $subq->where('codigo', 'like', "%{$buscar}%")
                            ->orWhere('diagnostico', 'like', "%{$buscar}%");
                    });
            });
        }
        $citologias = $query->paginate(10);

        // Estadísticas simples
        $totalCitologias = Citolgia::activas()->count();
        $citologiaPersonas = Citolgia::activas()->personas()->count();
        $citologiaMascotas = Citolgia::activas()->mascotas()->count();
        $archivadasPersonas = Citolgia::archivadas()->personas()->count();
        $archivadasMascotas = Citolgia::archivadas()->mascotas()->count();

        $estadisticas = [
            'total' => $totalCitologias,
            'personas' => $citologiaPersonas,
            'mascotas' => $citologiaMascotas,
            'archivadas' => $archivadasPersonas + $archivadasMascotas
        ];

        return view('citologias.index', compact('citologias', 'estadisticas'));
    }
    public function show($nbiopsia)
    {
        $citologia = Citolgia::with(['paciente', 'mascota', 'doctor', 'lista_citologias'])
            ->where('ncitologia', $nbiopsia)
            ->firstOrFail();

        return view('citologias.show', compact('citologia'));
    }
    //
}
