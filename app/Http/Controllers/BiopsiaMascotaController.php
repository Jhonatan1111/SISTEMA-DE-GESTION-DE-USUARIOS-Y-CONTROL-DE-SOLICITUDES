<?php

namespace App\Http\Controllers;

use App\Models\Biopsia;
use App\Models\Mascota;
use App\Models\Doctor;
use App\Models\ListaBiopsia;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Http\Request;

class BiopsiaMascotaController extends Controller
{
    // MOSTRAR BIOPSIAS DE MASCOTAS
    public function index(Request $request)
    {
        $query = Biopsia::with(['mascota', 'doctor'])
            ->whereNotNull('mascota_id')
            ->whereNull('paciente_id');

        // Filtro de búsqueda
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('nbiopsia', 'like', "%{$buscar}%")
                    ->orWhere('diagnostico_clinico', 'like', "%{$buscar}%")
                    ->orWhereHas('mascota', function ($q) use ($buscar) {
                        $q->where('nombre', 'like', "%{$buscar}%")
                            ->orWhere('especie', 'like', "%{$buscar}%")
                            ->orWhere('raza', 'like', "%{$buscar}%")
                            ->orWhere('propietario', 'like', "%{$buscar}%");
                    })
                    ->orWhereHas('doctor', function ($q) use ($buscar) {
                        $q->where('nombre', 'like', "%{$buscar}%")
                            ->orWhere('apellido', 'like', "%{$buscar}%")
                            ->orWhere('jvpm', 'like', "%{$buscar}%");
                    });
            });
        }

        // Filtro por tipo (NUEVO)
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }
        // Filtro de estado
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        // Filtro de doctor
        if ($request->filled('doctor')) {
            $query->where('doctor_id', $request->doctor);
        }
        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha_recibida', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha_recibida', '<=', $request->fecha_hasta);
        }

        $biopsias = $query->orderBy('fecha_recibida', 'desc')
            ->paginate(10)
            ->appends($request->all());

        return view('biopsias.mascotas.index', compact('biopsias'));
    }

    // Formulario para crear biopsia de mascota
    public function create()
    {
        $mascotas = Mascota::orderBy('nombre')->get();
        $doctores = Doctor::where('estado_servicio', true)->get();
        $listas = ListaBiopsia::orderBy('codigo')->get();

        return view('biopsias.mascotas.create', compact('doctores', 'mascotas', 'listas'));
    }

    // Guardar nueva biopsia de mascota
    public function store(Request $request)
    {
        $request->validate([
            'tipo' => 'required|in:normal,liquida',
            'diagnostico_clinico' => 'required|string',
            'fecha_recibida' => 'required|date|before_or_equal:today',
            'microscopico' => 'nullable|string',
            'diagnostico' => 'nullable|string',
            'doctor_id' => 'required|exists:doctores,id',
            'mascota_id' => 'required|exists:mascotas,id',
        ], [
            'fecha_recibida.before_or_equal' => 'La fecha no puede ser futura',
            'diagnostico_clinico.required' => 'El diagnóstico clínico es obligatorio',
            'doctor_id.required' => 'Debe seleccionar un doctor',
            'mascota_id.required' => 'Debe seleccionar una mascota',
            'tipo.required' => 'Debe seleccionar el tipo de biopsia',
        ]);

        // Generar número correlativo según el tipo
        $tipoBiopsia = 'mascota-' . $request->tipo;
        $numeroGenerado = Biopsia::generarNumeroBiopsia($tipoBiopsia);

        $datos = [
            'nbiopsia' => $numeroGenerado,
            'tipo' => $request->tipo,
            'estado' => true,
            'diagnostico_clinico' => $request->diagnostico_clinico,
            'fecha_recibida' => $request->fecha_recibida,
            'microscopico' => $request->microscopico,
            'diagnostico' => $request->diagnostico,
            'doctor_id' => $request->doctor_id,
            'mascota_id' => $request->mascota_id,
            'paciente_id' => null,
        ];

        // Manejar el campo macroscópico
        if ($request->lista_id) {
            $lista = ListaBiopsia::find($request->lista_id);
            if ($lista) {
                $contenidoPlantilla = $lista->macroscopico;
                $contenidoAdicional = $request->macroscopico;

                if (!empty($contenidoAdicional) && $contenidoAdicional !== $contenidoPlantilla) {
                    if (strpos($contenidoAdicional, $contenidoPlantilla) !== false) {
                        $datos['macroscopico'] = $contenidoAdicional;
                    } else {
                        $datos['macroscopico'] = $contenidoPlantilla . "\n\n" . $contenidoAdicional;
                    }
                } else {
                    $datos['macroscopico'] = $contenidoPlantilla;
                }
            }
        } else {
            $datos['macroscopico'] = $request->macroscopico;
        }

        Biopsia::create($datos);

        $tipoTexto = $request->tipo === 'liquida' ? 'líquida' : 'normal';

        return redirect()->route('biopsias.mascotas.index')
            ->with('success', "Biopsia {$tipoTexto} creada exitosamente con número {$numeroGenerado}");
    }

    // Ver detalles de biopsia de mascota
    public function show($nbiopsia)
    {
        $biopsia = Biopsia::with(['mascota', 'doctor'])
            ->mascotas()
            ->where('nbiopsia', $nbiopsia)
            ->firstOrFail();

        return view('biopsias.mascotas.show', compact('biopsia'));
    }

    // Formulario para editar biopsia de mascota
    public function edit($nbiopsia)
    {
        $biopsia = Biopsia::with(['mascota', 'doctor'])
            ->where('nbiopsia', $nbiopsia)
            ->firstOrFail();

        $mascotas = Mascota::orderBy('nombre')->get();
        $doctores = Doctor::where('estado_servicio', true)
            ->orderBy('nombre')
            ->get();
        $listas = ListaBiopsia::orderBy('codigo')->get();

        return view('biopsias.mascotas.edit', compact('biopsia', 'doctores', 'mascotas', 'listas'));
    }

    // Actualizar biopsia de mascota
    public function update(Request $request, $nbiopsia)
    {
        $biopsia = Biopsia::where('nbiopsia', $nbiopsia)->firstOrFail();

        $request->validate([
            'diagnostico_clinico' => 'required|string',
            'fecha_recibida' => 'required|date|before_or_equal:today',
            'mascota_id' => 'required|exists:mascotas,id',
            'doctor_id' => 'required|exists:doctores,id',
        ], [
            'fecha_recibida.before_or_equal' => 'La fecha no puede ser futura',
            'diagnostico_clinico.required' => 'El diagnóstico clínico es obligatorio',
            'doctor_id.required' => 'Debe seleccionar un doctor',
            'mascota_id.required' => 'Debe seleccionar una mascota',
        ]);

        $datos = [
            'diagnostico_clinico' => $request->diagnostico_clinico,
            'fecha_recibida' => $request->fecha_recibida,
            'mascota_id' => $request->mascota_id,
            'doctor_id' => $request->doctor_id,
            'diagnostico' => $request->diagnostico,
            'microscopico' => $request->microscopico,
            'paciente_id' => null,
        ];

        // Manejar el campo macroscópico
        if ($request->lista_id) {
            $lista = ListaBiopsia::find($request->lista_id);
            if ($lista) {
                $contenidoPlantilla = $lista->macroscopico;
                $contenidoAdicional = $request->macroscopico;

                if (!empty($contenidoAdicional) && $contenidoAdicional !== $contenidoPlantilla) {
                    if (strpos($contenidoAdicional, $contenidoPlantilla) !== false) {
                        $datos['macroscopico'] = $contenidoAdicional;
                    } else {
                        $datos['macroscopico'] = $contenidoPlantilla . "\n\n" . $contenidoAdicional;
                    }
                } else {
                    $datos['macroscopico'] = $contenidoPlantilla;
                }
            }
        } else {
            $datos['macroscopico'] = $request->macroscopico;
        }

        $biopsia->update($datos);

        return redirect()->route('biopsias.mascotas.index')
            ->with('success', 'Biopsia actualizada exitosamente');
    }

    // Cambiar estado de la biopsia
    public function toggleEstado(Request $request, $nbiopsia)
    {
        $biopsia = Biopsia::where('nbiopsia', $nbiopsia)->firstOrFail();
        $biopsia->update(['estado' => !$biopsia->estado]);

        $estado = $biopsia->estado ? 'activada' : 'desactivada';
        return redirect()->route('biopsias.mascotas.index')
            ->with('success', "Biopsia {$estado} exitosamente.");
    }

    // Vista para imprimir biopsia
    public function imprimir($nbiopsia)
    {
        $biopsia = Biopsia::with(['mascota', 'doctor'])
            ->where('nbiopsia', $nbiopsia)
            ->firstOrFail();

        // Seleccionar la vista según el tipo de biopsia
        $vista = match ($biopsia->tipo) {
            'normal' => 'biopsias.mascotas.print.imprimir-normal',
            'liquida' => 'biopsias.mascotas.print.imprimir-liquida',
            default => 'biopsias.mascotas.print.imprimir-normal'
        };

        return view($vista, compact('biopsia'));
    }

    // Descargar PDF
    public function descargarPdf($nbiopsia)
    {
        $biopsia = Biopsia::with(['mascota', 'doctor'])
            ->where('nbiopsia', $nbiopsia)
            ->firstOrFail();

        // Seleccionar la vista según el tipo de biopsia
        $vista = match ($biopsia->tipo) {
            'normal' => 'biopsias.mascotas.pdf.pdf-normal',
            'liquida' => 'biopsias.mascotas.pdf.pdf-liquida',
            default => 'biopsias.mascotas.pdf.pdf-normal'
        };

        $pdf = Pdf::loadView($vista, compact('biopsia'));

        return $pdf->download('biopsia_mascota_' . $nbiopsia . '.pdf');
    }

    // API: Buscar mascotas para AJAX
    public function buscarMascotas(Request $request)
    {
        $term = $request->get('q') ?? $request->get('term');

        $mascotas = Mascota::where('nombre', 'like', "%{$term}%")
            ->orWhere('especie', 'like', "%{$term}%")
            ->orWhere('raza', 'like', "%{$term}%")
            ->orWhere('propietario', 'like', "%{$term}%")
            ->select('id', 'nombre', 'especie', 'raza', 'propietario', 'edad', 'sexo')
            ->limit(10)
            ->get()
            ->map(function ($m) {
                return [
                    'id' => $m->id,
                    'text' => $m->nombre . ' - ' . $m->especie . ' (' . $m->propietario . ')',
                    'nombre' => $m->nombre,
                    'especie' => $m->especie,
                    'raza' => $m->raza,
                    'propietario' => $m->propietario,
                    'edad' => $m->edad,
                    'sexo' => $m->sexo === 'M' ? 'Macho' : 'Hembra'
                ];
            });

        return response()->json([
            'results' => $mascotas
        ]);
    }

    // API: Obtener información de una mascota específica
    public function obtenerMascota($id)
    {
        $mascota = Mascota::findOrFail($id);

        return response()->json([
            'id' => $mascota->id,
            'nombre' => $mascota->nombre,
            'especie' => $mascota->especie,
            'raza' => $mascota->raza,
            'propietario' => $mascota->propietario,
            'edad' => $mascota->edad,
            'sexo' => $mascota->sexo === 'M' ? 'Macho' : 'Hembra',
            'total_biopsias' => $mascota->biopsias()->count()
        ]);
    }

    // Buscar lista de biopsia por ID
    public function buscarLista($id)
    {
        $lista = ListaBiopsia::find($id);
        return response()->json($lista);
    }

    // Buscar lista por código
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

    // Obtener número correlativo
    public function obtenerNumeroCorrelativo(Request $request)
    {
        $tipo = $request->tipo ?? 'normal';
        $tipoBiopsia = 'mascota-' . $tipo;
        $numero = Biopsia::generarNumeroBiopsia($tipoBiopsia);

        return response()->json([
            'success' => true,
            'numero' => $numero,
            'tipo' => $tipo
        ]);
    }
    // EXPORTAR BIOPSIAS DE MASCOTAS A PDF
    public function exportarPdf(Request $request)
    {
        $query = Biopsia::with(['mascota', 'doctor'])
            ->whereNotNull('mascota_id')
            ->whereNull('paciente_id');

        // Aplicar filtros
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('nbiopsia', 'like', "%{$buscar}%")
                    ->orWhere('diagnostico_clinico', 'like', "%{$buscar}%")
                    ->orWhereHas('mascota', function ($q) use ($buscar) {
                        $q->where('nombre', 'like', "%{$buscar}%")
                            ->orWhere('especie', 'like', "%{$buscar}%")
                            ->orWhere('raza', 'like', "%{$buscar}%")
                            ->orWhere('dueno', 'like', "%{$buscar}%");
                    })
                    ->orWhereHas('doctor', function ($q) use ($buscar) {
                        $q->where('nombre', 'like', "%{$buscar}%")
                            ->orWhere('apellido', 'like', "%{$buscar}%")
                            ->orWhere('jvpm', 'like', "%{$buscar}%");
                    });
            });
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

        $data = [
            'biopsias' => $biopsias,
            'fecha' => now()->format('d/m/Y'),
            'total' => $biopsias->count(),
            'tipo' => 'Mascotas'
        ];

        $pdf = Pdf::loadView('biopsias.mascotas.pdf.reporte', $data);

        return $pdf->download('reporte_biopsias_mascotas_' . now()->format('Y-m-d') . '.pdf');
    }
}
