<?php

namespace App\Http\Controllers;

use App\Models\Biopsia;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BiopsiaArchivarController extends Controller
{
    // Mostrar biopsias archivadas
    public function index(Request $request)
    {
        $query = Biopsia::with(['paciente', 'mascota', 'doctor'])
            ->where('estado', false) // Biopsias archivadas/inactivas
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

        // Calcular estadísticas
        $estadisticas = [
            'total' => Biopsia::where('estado', false)->count(),
            'personas' => Biopsia::where('estado', false)->personas()->count(),
            'mascotas' => Biopsia::where('estado', false)->mascotas()->count(),
        ];

        return view('biopsias.archivadas.index', compact('biopsias', 'estadisticas'));
    }

    // Archivar una biopsia específica (cambiar estado a false)
    public function archivar($nbiopsia)
    {
        $biopsia = Biopsia::where('nbiopsia', $nbiopsia)->firstOrFail();
        
        $biopsia->update(['estado' => false]);

        return redirect()->back()->with('success', 'Biopsia archivada exitosamente: ' . $biopsia->nbiopsia);
    }

    // Restaurar una biopsia archivada (cambiar estado a true)
    public function restaurar($nbiopsia)
    {
        $biopsia = Biopsia::where('nbiopsia', $nbiopsia)->firstOrFail();
        
        $biopsia->update(['estado' => true]);

        return redirect()->back()->with('success', 'Biopsia restaurada exitosamente: ' . $biopsia->nbiopsia);
    }

    // Archivar biopsias antiguas masivamente
    public function archivarAntiguas(Request $request)
    {
        $years = $request->input('years', 5);
        $fechaLimite = Carbon::now()->subYears($years);

        $biopsias = Biopsia::where('fecha_recibida', '<', $fechaLimite)
            ->where('estado', true)
            ->get();

        $contador = 0;
        foreach ($biopsias as $biopsia) {
            $biopsia->update(['estado' => false]);
            $contador++;
        }

        return redirect()->back()->with('success', "Se archivaron {$contador} biopsias anteriores a " . $fechaLimite->format('Y-m-d'));
    }
}
