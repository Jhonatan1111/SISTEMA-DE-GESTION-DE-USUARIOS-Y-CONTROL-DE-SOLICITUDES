<?php

namespace App\Http\Controllers;

use App\Models\Biopsia;
use App\Models\Doctor;
use App\Models\ListaBiopsia;
use App\Models\Mascota;
use Illuminate\Http\Request;

class BiopsiaMascotaController extends Controller
{
    public function index()
    {
        $biopsias = Biopsia::with('mascota', 'doctor', 'lista_biopsia')
            ->mascotas()
            // ->ListaBiopsias()
            ->orderBy('fecha_recibida', 'asc')
            ->paginate(10);
        return view('biopsias.mascotas.index', compact('biopsias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mascotas = Mascota::orderBy('nombre')->get();
        $doctores = Doctor::where('estado_servicio', true)->get();
        $listas = ListaBiopsia::orderBy('codigo')->get();
        $numeroGenerado = Biopsia::generarNumeroBiopsia();
        return view('biopsias.mascotas.create', compact('mascotas', 'doctores', 'listas', 'numeroGenerado'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([

            'diagnostico_clinico' => 'required|string',
            'fecha_recibida' => 'required|date|before_or_equal:today',
            'doctor_id' => 'required|exists:doctores,id',
            'mascota_id' => 'required|exists:mascotas,id'
        ], [
            'fecha_recibida.before_or_equal' => 'La fecha no puede ser futura',
            'diagnostico_clinico.required' => 'El diagnóstico clínico es obligatorio',
            'doctor_id.required' => 'Debe seleccionar un doctor',
            'mascota_id.required' => 'Debe seleccionar una mascota'
        ]);
        $numeroGenerado = Biopsia::generarNumeroBiopsia();
        $datos = [
            'nbiopsia' => $numeroGenerado,
            'diagnostico_clinico' => $request->diagnostico_clinico,
            'fecha_recibida' => $request->fecha_recibida,
            'doctor_id' => $request->doctor_id,
            'mascota_id' => $request->mascota_id,
            'estado' => true,
            'lista_id' => $request->lista_id ?? null,
        ];
        if ($request->lista_id) {
            $lista = ListaBiopsia::find($request->lista_id);
            if ($lista) {
                $datos['diagnostico'] = $lista->diagnostico;
                $datos['descripcion'] = $lista->descripcion;
                $datos['microscopico'] = $lista->microscopico;
                $datos['macroscopico'] = $lista->macroscopico;
            }
        } else {
            // Sin lista, usar campos manuales (si vienen)
            $datos['diagnostico'] = $request->diagnostico;
            $datos['descripcion'] = $request->descripcion;
            $datos['microscopico'] = $request->microscopico;
            $datos['macroscopico'] = $request->macroscopico;
        }
        Biopsia::create($datos);
        return redirect()->route('biopsias.mascotas.index')->with('success', 'Biopsia creada exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show($nbiopsia)
    {
        $biopsia = Biopsia::with(['mascota', 'doctor'])
            ->mascotas()
            ->where('nbiopsia', $nbiopsia)
            ->firstOrFail();

        return view('biopsias.mascotas.show', compact('biopsia'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($nbiopsia)
    {
        // CORREGIR: Buscar por nbiopsia correctamente
        $biopsia = Biopsia::with(['mascota', 'doctor'])
            ->mascotas()
            ->where('nbiopsia', $nbiopsia)  // Buscar por el campo nbiopsia
            ->firstOrFail();

        $mascotas = Mascota::orderBy('nombre')->get();
        $doctores = Doctor::where('estado_servicio', true)
            ->orderBy('nombre')
            ->get();
        $listas = ListaBiopsia::orderBy('codigo')->get();

        return view('biopsias.mascotas.edit', compact('biopsia', 'doctores', 'mascotas', 'listas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $nbiopsia)
    {

        $biopsia = Biopsia::where('nbiopsia', $nbiopsia)->firstOrFail();

        $request->validate([
            // 'nbiopsia' => 'required|string|max:15|unique:biopsias,nbiopsia,' . $biopsia->nbiopsia . ',nbiopsia',
            'diagnostico_clinico' => 'required|string',
            'fecha_recibida' => 'required|date|before_or_equal:today',
            'mascota_id' => 'required|exists:mascotas,id',
            'doctor_id' => 'required|exists:doctores,id',
        ], [
            'fecha_recibida.before_or_equal' => 'La fecha no puede ser futura',
            'diagnostico_clinico.required' => 'El diagnóstico clínico es obligatorio',
            'doctor_id.required' => 'Debe seleccionar un doctor',
            'mascota_id.required' => 'Debe seleccionar una mascota'
        ]);
        $biopsia->update([
            'diagnostico_clinico' => $request->diagnostico_clinico,
            'fecha_recibida' => $request->fecha_recibida,
            'mascota_id' => $request->mascota_id,
            'doctor_id' => $request->doctor_id,
            'lista_id' => $request->lista_id ?? null,
            'diagnostico' => $request->diagnostico,
            'descripcion' => $request->descripcion,
            'microscopico' => $request->microscopico,
            'macroscopico' => $request->macroscopico,
            'persona_id' => null,
        ]);
        $biopsia->save();
        return redirect()->route('biopsias.mascotas.index')
            ->with('success', 'Biopsia de mascota actualizada exitosamente.');
    }
    public function toggleEstado(Request $request, $nbiopsia)
    {
        $biopsia = Biopsia::where('nbiopsia', $nbiopsia)->firstOrFail();
        $biopsia->update(['estado' => !$biopsia->estado]);

        $estado = $biopsia->estado ? 'activada' : 'desactivada';
        return redirect()->route('biopsias.mascotas.index')
            ->with('success', "Biopsia {$estado} exitosamente.");
    }
    public function imprimir($nbiopsia)
    {
        $biopsia = Biopsia::with(['mascota', 'doctor'])
            ->where('nbiopsia', $nbiopsia)
            ->firstOrFail();

        return view('biopsias.mascotas.imprimir', compact('biopsia'));
    }
    public function estadisticas(Request $request)
    {
        $fechaInicio = $request->fecha_inicio ?? now()->startOfMonth();
        $fechaFin = $request->fecha_fin ?? now()->endOfMonth();

        $estadisticas = [
            'total_biopsias' => Biopsia::mascotas()
                ->whereBetween('fecha_recibida', [$fechaInicio, $fechaFin])
                ->count(),
            'pendientes' => Biopsia::mascotas()
                ->pendientes()
                ->whereBetween('fecha_recibida', [$fechaInicio, $fechaFin])
                ->count(),
            'completadas' => Biopsia::mascotas()
                ->completadas()
                ->whereBetween('fecha_recibida', [$fechaInicio, $fechaFin])
                ->count(),
            'mascotas_unicas' => Biopsia::mascotas()
                ->whereBetween('fecha_recibida', [$fechaInicio, $fechaFin])
                ->distinct('mascota_id')
                ->count('mascota_id')
        ];

        // Biopsias por doctor
        $biopsiasPorDoctor = Biopsia::with('doctor')
            ->mascotas()
            ->whereBetween('fecha_recibida', [$fechaInicio, $fechaFin])
            ->get()
            ->groupBy('doctor_id')
            ->map(function ($biopsias) {
                return [
                    'doctor' => $biopsias->first()->doctor->nombre . ' ' . $biopsias->first()->doctor->apellido,
                    'cantidad' => $biopsias->count()
                ];
            })
            ->sortByDesc('cantidad');

        // Biopsias por rango de edad de la mascota
        $biopsiasPorEdad = [
            '0-17' => Biopsia::mascotas()
                ->whereHas('mascota', function ($q) {
                    $q->where('edad', '<', 18);
                })
                ->whereBetween('fecha_recibida', [$fechaInicio, $fechaFin])
                ->count(),
            '18-30' => Biopsia::mascotas()
                ->whereHas('mascota', function ($q) {
                    $q->whereBetween('edad', [18, 30]);
                })
                ->whereBetween('fecha_recibida', [$fechaInicio, $fechaFin])
                ->count(),
            '31-50' => Biopsia::mascotas()
                ->whereHas('mascota', function ($q) {
                    $q->whereBetween('edad', [31, 50]);
                })
                ->whereBetween('fecha_recibida', [$fechaInicio, $fechaFin])
                ->count(),
            '51-70' => Biopsia::mascotas()
                ->whereHas('mascota', function ($q) {
                    $q->whereBetween('edad', [51, 70]);
                })
                ->whereBetween('fecha_recibida', [$fechaInicio, $fechaFin])
                ->count(),
            '70+' => Biopsia::mascotas()
                ->whereHas('mascota', function ($q) {
                    $q->where('edad', '>', 70);
                })
                ->whereBetween('fecha_recibida', [$fechaInicio, $fechaFin])
                ->count()
        ];

        return view('biopsias.mascotas.estadisticas', compact(
            'estadisticas',
            'biopsiasPorDoctor',
            'biopsiasPorEdad',
            'fechaInicio',
            'fechaFin'
        ));
    }
    public function buscarMascotas(Request $request)
    {
        $term = $request->get('q') ?? $request->get('term');

        $mascotas = Mascota::where('nombre', 'like', "%{$term}%")
            ->orWhere('raza', 'like', "%{$term}%")
            ->orWhere('propietario', 'like', "%{$term}%")
            ->select('id', 'nombre', 'raza', 'propietario', 'edad', 'sexo')
            ->limit(10)
            ->get()
            ->map(function ($m) {
                return [
                    'id' => $m->id,
                    'text' => $m->nombre . ' - ' . $m->raza . ' - ' . $m->propietario . ' (' . $m->edad . ' años)',
                    'nombre_completo' => $m->nombre,
                    'propietario' => $m->propietario,
                    'edad' => $m->edad,
                    'sexo' => $m->sexo === 'M' ? 'Masculino' : 'Femenino'
                ];
            });

        return response()->json([
            'results' => $mascotas
        ]);
    }
    public function obtenerMascota($id)
    {
        $mascota = Mascota::findOrFail($id);

        return response()->json([
            'id' => $mascota->id,
            'nombre_completo' => $mascota->nombre,
            'edad' => $mascota->edad,
            'sexo' => $mascota->sexo === 'M' ? 'Masculino' : 'Femenino',
            'especie' => $mascota->especie === 'M' ? 'Mascota' : 'Perro',
            'raza' => $mascota->raza,
            'propietario' => $mascota->propietario,
            'correo' => $mascota->correo,
            'celular' => $mascota->celular,
            'total_biopsias' => $mascota->biopsias()->count(),
            'biopsias_pendientes' => $mascota->biopsias()->pendientes()->count(),
            'biopsias_completadas' => $mascota->biopsias()->completadas()->count()
        ]);
    }

    public function reporteMascota($mascotaId)
    {
        $mascota = Mascota::findOrFail($mascotaId);
        $biopsias = $mascota->biopsias()
            ->with('doctor')
            ->orderBy('fecha_recibida', 'desc')
            ->get();

        return view('biopsias.mascotas.reporte-pdf', compact('mascota', 'biopsias'));
    }
    public function buscarLista($id)
    {
        $lista = ListaBiopsia::find($id);
        return response()->json($lista);
    }
    // Método AJAX para buscar por código
    public function buscarListaPorCodigo($codigo)
    {
        $lista = ListaBiopsia::where('codigo', $codigo)->first();

        if ($lista) {
            return response()->json([
                'success' => true,
                'data' => $lista
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Código no encontrado'
        ], 404);
    }
}
