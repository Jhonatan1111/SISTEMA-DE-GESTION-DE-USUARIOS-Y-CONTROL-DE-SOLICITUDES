<?php

namespace App\Http\Controllers;

use App\Models\Biopsia;
use App\Models\Paciente;
use App\Models\Doctor;
use App\Models\ListaBiopsia;

use Illuminate\Http\Request;

class BiopsiaPacienteController extends Controller
{
    // MOSTRAR BIOPSIAS DE PERSONAS
    public function index(Request $request)
    {
        $query = Biopsia::with(['paciente', 'doctor', 'lista_biopsia'])
            ->whereNotNull('paciente_id')
            ->whereNull('mascota_id');

        // Filtro de búsqueda
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function($q) use ($buscar) {
                $q->where('nbiopsia', 'like', "%{$buscar}%")
                ->orWhere('diagnostico_clinico', 'like', "%{$buscar}%")
                ->orWhereHas('doctor', function($q) use ($buscar) {
                    $q->where('nombre', 'like', "%{$buscar}%")
                        ->orWhere('apellido', 'like', "%{$buscar}%")
                        ->orWhere('jvpm', 'like', "%{$buscar}%");
                })
                ->orWhereHas('paciente', function($q) use ($buscar) {
                    $q->where('nombre', 'like', "%{$buscar}%")
                        ->orWhere('apellido', 'like', "%{$buscar}%")
                        ->orWhere('DUI', 'like', "%{$buscar}%");
                })
                ->orWhereHas('lista_biopsia', function($q) use ($buscar) {
                    $q->where('codigo', 'like', "%{$buscar}%")
                        ->orWhere('diagnostico', 'like', "%{$buscar}%");
                });
            });
        }

        // Filtro de estado
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        // Filtro de doctor
        if ($request->filled('doctor')) {
            $query->where('doctor_id', $request->doctor);
        }

        $biopsias = $query->orderBy('fecha_recibida', 'asc')
            ->paginate(10)
            ->appends($request->all());

        return view('biopsias.personas.index', compact('biopsias'));
    }


    // Mostrar formulario para crear biopsia de paciente humano
    public function create()
    {
        $pacientes = Paciente::orderBy('nombre')
            ->get();
        $doctores = Doctor::where('estado_servicio', true)
            ->get();
        $listas = ListaBiopsia::orderBy('codigo')
            ->get();
        return view('biopsias.personas.create', compact('doctores', 'pacientes', 'listas'));
    }

    // Guardar nueva biopsia de paciente humano
    public function store(Request $request)
    {
        $request->validate([
            'diagnostico_clinico' => 'required|string',
            'fecha_recibida' => 'required|date|before_or_equal:today',
            'doctor_id' => 'required|exists:doctores,id',
            'paciente_id' => 'required|exists:pacientes,id',
            'tipo' => 'required|in:normal,liquida'
        ], [
            'fecha_recibida.before_or_equal' => 'La fecha no puede ser futura',
            'diagnostico_clinico.required' => 'El diagnóstico clínico es obligatorio',
            'doctor_id.required' => 'Debe seleccionar un doctor',
            'paciente_id.required' => 'Debe seleccionar un paciente',
            'tipo.required' => 'Debe seleccionar el tipo de biopsia'
        ]);

        // Generar número correlativo según el tipo
        $tipoBiopsia = 'persona-' . $request->tipo;
        $numeroGenerado = Biopsia::generarNumeroBiopsia($tipoBiopsia);

        $datos = [
            'nbiopsia' => $numeroGenerado,
            'diagnostico_clinico' => $request->diagnostico_clinico,
            'fecha_recibida' => $request->fecha_recibida,
            'tipo' => $request->tipo,
            'doctor_id' => $request->doctor_id,
            'paciente_id' => $request->paciente_id,
            'estado' => true,
            'mascota_id' => null,
            'lista_id' => $request->lista_id ?? null,
        ];

        // Si seleccionó una lista, copiar los datos
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

        $tipoTexto = $request->tipo === 'liquida' ? 'líquida' : 'normal';

        return redirect()->route('biopsias.personas.index')
            ->with('success', "Biopsia {$tipoTexto} creada exitosamente con número {$numeroGenerado}");
    }

    // Ver detalles de biopsia de paciente
    public function show($nbiopsia)
    {
        $biopsia = Biopsia::with(['paciente', 'doctor'])
            ->personas()
            ->where('nbiopsia', $nbiopsia)
            ->firstOrFail();

        return view('biopsias.personas.show', compact('biopsia'));
    }

    // Mostrar formulario para editar biopsia de paciente
    public function edit($nbiopsia)
    {
        // CORREGIR: Buscar por nbiopsia correctamente
        $biopsia = Biopsia::with(['paciente', 'doctor'])
            ->where('nbiopsia', $nbiopsia)  // Buscar por el campo nbiopsia
            ->firstOrFail();

        $pacientes = Paciente::orderBy('nombre')->get();
        $doctores = Doctor::where('estado_servicio', true)
            ->orderBy('nombre')
            ->get();
        $listas = ListaBiopsia::orderBy('codigo')->get();

        return view('biopsias.personas.edit', compact('biopsia', 'doctores', 'pacientes', 'listas'));
    }
    // Actualizar biopsia de paciente
    public function update(Request $request, $nbiopsia)
    {
        $biopsia = Biopsia::where('nbiopsia', $nbiopsia)->firstOrFail();

        $request->validate([
            'diagnostico_clinico' => 'required|string',
            'fecha_recibida' => 'required|date|before_or_equal:today',
            'paciente_id' => 'required|exists:pacientes,id',
            'doctor_id' => 'required|exists:doctores,id',
            // 'tipo' => 'required|in:normal,liquida'
        ], [
            'fecha_recibida.before_or_equal' => 'La fecha no puede ser futura',
            'diagnostico_clinico.required' => 'El diagnóstico clínico es obligatorio',
            'doctor_id.required' => 'Debe seleccionar un doctor',
            'paciente_id.required' => 'Debe seleccionar un paciente',
            // 'tipo.required' => 'Debe seleccionar el tipo de biopsia'
        ]);

        $biopsia->update([
            'diagnostico_clinico' => $request->diagnostico_clinico,
            'fecha_recibida' => $request->fecha_recibida,
            // 'tipo' => $request->tipo,
            'paciente_id' => $request->paciente_id,
            'doctor_id' => $request->doctor_id,
            'lista_id' => $request->lista_id ?? null,
            'diagnostico' => $request->diagnostico,
            'descripcion' => $request->descripcion,
            'microscopico' => $request->microscopico,
            'macroscopico' => $request->macroscopico,
            'mascota_id' => null,
        ]);

        return redirect()->route('biopsias.personas.index')
            ->with('success', 'Biopsia de persona actualizada exitosamente.');
    }

    // Ver historial de biopsias de un paciente específico
    public function historialPaciente($pacienteId)
    {
        $paciente = Paciente::findOrFail($pacienteId);

        $biopsias = Biopsia::with(['doctor'])
            ->where('paciente_id', $pacienteId)
            ->orderBy('fecha_recibida', 'desc')
            ->paginate(10);

        return view('biopsias.pacientes.historial', compact('paciente', 'biopsias'));
    }

    // Estadísticas de biopsias de pacientes humanos
    public function estadisticas(Request $request)
    {
        $fechaInicio = $request->fecha_inicio ?? now()->startOfMonth();
        $fechaFin = $request->fecha_fin ?? now()->endOfMonth();

        $estadisticas = [
            'total_biopsias' => Biopsia::humanos()
                ->whereBetween('fecha_recibida', [$fechaInicio, $fechaFin])
                ->count(),
            'pendientes' => Biopsia::humanos()
                ->pendientes()
                ->whereBetween('fecha_recibida', [$fechaInicio, $fechaFin])
                ->count(),
            'completadas' => Biopsia::humanos()
                ->completadas()
                ->whereBetween('fecha_recibida', [$fechaInicio, $fechaFin])
                ->count(),
            'pacientes_unicos' => Biopsia::humanos()
                ->whereBetween('fecha_recibida', [$fechaInicio, $fechaFin])
                ->distinct('paciente_id')
                ->count('paciente_id')
        ];

        // Biopsias por doctor
        $biopsiasPorDoctor = Biopsia::with('doctor')
            ->humanos()
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

        // Biopsias por rango de edad del paciente
        $biopsiasPorEdad = [
            '0-17' => Biopsia::humanos()
                ->whereHas('paciente', function ($q) {
                    $q->where('edad', '<', 18);
                })
                ->whereBetween('fecha_recibida', [$fechaInicio, $fechaFin])
                ->count(),
            '18-30' => Biopsia::humanos()
                ->whereHas('paciente', function ($q) {
                    $q->whereBetween('edad', [18, 30]);
                })
                ->whereBetween('fecha_recibida', [$fechaInicio, $fechaFin])
                ->count(),
            '31-50' => Biopsia::humanos()
                ->whereHas('paciente', function ($q) {
                    $q->whereBetween('edad', [31, 50]);
                })
                ->whereBetween('fecha_recibida', [$fechaInicio, $fechaFin])
                ->count(),
            '51-70' => Biopsia::humanos()
                ->whereHas('paciente', function ($q) {
                    $q->whereBetween('edad', [51, 70]);
                })
                ->whereBetween('fecha_recibida', [$fechaInicio, $fechaFin])
                ->count(),
            '70+' => Biopsia::humanos()
                ->whereHas('paciente', function ($q) {
                    $q->where('edad', '>', 70);
                })
                ->whereBetween('fecha_recibida', [$fechaInicio, $fechaFin])
                ->count()
        ];

        return view('biopsias.pacientes.estadisticas', compact(
            'estadisticas',
            'biopsiasPorDoctor',
            'biopsiasPorEdad',
            'fechaInicio',
            'fechaFin'
        ));
    }

    // API: Buscar pacientes para AJAX
    public function buscarPacientes(Request $request)
    {
        $term = $request->get('q') ?? $request->get('term');

        $pacientes = Paciente::where('nombre', 'like', "%{$term}%")
            ->orWhere('apellido', 'like', "%{$term}%")
            ->orWhere('DUI', 'like', "%{$term}%")
            ->select('id', 'nombre', 'apellido', 'DUI', 'edad', 'sexo')
            ->limit(10)
            ->get()
            ->map(function ($p) {
                return [
                    'id' => $p->id,
                    'text' => $p->nombre . ' ' . $p->apellido . ' - ' . $p->DUI . ' (' . $p->edad . ' años)',
                    'nombre_completo' => $p->nombre . ' ' . $p->apellido,
                    'dui' => $p->DUI,
                    'edad' => $p->edad,
                    'sexo' => $p->sexo === 'M' ? 'Masculino' : 'Femenino'
                ];
            });

        return response()->json([
            'results' => $pacientes
        ]);
    }

    // API: Obtener información de un paciente específico
    public function obtenerPaciente($id)
    {
        $paciente = Paciente::findOrFail($id);

        return response()->json([
            'id' => $paciente->id,
            'nombre_completo' => $paciente->nombre . ' ' . $paciente->apellido,
            'dui' => $paciente->DUI,
            'edad' => $paciente->edad,
            'sexo' => $paciente->sexo === 'M' ? 'Masculino' : 'Femenino',
            'correo' => $paciente->correo,
            'celular' => $paciente->celular,
            'total_biopsias' => $paciente->biopsias()->count(),
            'biopsias_pendientes' => $paciente->biopsias()->pendientes()->count(),
            'biopsias_completadas' => $paciente->biopsias()->completadas()->count()
        ]);
    }

    // Reporte PDF de biopsias por paciente (básico)
    public function reportePaciente($pacienteId)
    {
        $paciente = Paciente::findOrFail($pacienteId);
        $biopsias = $paciente->biopsias()
            ->with('doctor')
            ->orderBy('fecha_recibida', 'desc')
            ->get();

        return view('biopsias.pacientes.reporte-pdf', compact('paciente', 'biopsias'));
    }

    // Exportar lista de biopsias de pacientes a CSV
    public function exportarCsv(Request $request)
    {
        $query = Biopsia::with(['paciente', 'doctor'])->humanos();

        // Aplicar filtros si vienen en la request
        if ($request->fecha_desde) {
            $query->where('fecha_recibida', '>=', $request->fecha_desde);
        }
        if ($request->fecha_hasta) {
            $query->where('fecha_recibida', '<=', $request->fecha_hasta);
        }
        if ($request->doctor_id) {
            $query->where('doctor_id', $request->doctor_id);
        }

        $biopsias = $query->orderBy('fecha_recibida', 'desc')->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="biopsias_pacientes_' . now()->format('Y-m-d') . '.csv"',
        ];

        $callback = function () use ($biopsias) {
            $file = fopen('php://output', 'w');

            // Encabezados CSV
            fputcsv($file, [
                'Número Biopsia',
                'Fecha Recibida',
                'Paciente',
                'DUI',
                'Edad',
                'Sexo',
                'Doctor',
                'Diagnóstico Clínico',
                'Estado',
                'Fecha Registro'
            ]);

            // Datos
            foreach ($biopsias as $biopsia) {
                fputcsv($file, [
                    $biopsia->nbiopsia,
                    $biopsia->fecha_recibida->format('d/m/Y'),
                    $biopsia->paciente->nombre . ' ' . $biopsia->paciente->apellido,
                    $biopsia->paciente->DUI,
                    $biopsia->paciente->edad,
                    $biopsia->paciente->sexo === 'M' ? 'Masculino' : 'Femenino',
                    $biopsia->doctor->nombre . ' ' . $biopsia->doctor->apellido,
                    substr($biopsia->diagnostico_clinico, 0, 100) . '...',
                    $biopsia->estado,
                    $biopsia->created_at->format('d/m/Y H:i')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
    public function toggleEstado(Request $request, $nbiopsia)
    {
        $biopsia = Biopsia::where('nbiopsia', $nbiopsia)->firstOrFail();
        $biopsia->update(['estado' => !$biopsia->estado]);

        $estado = $biopsia->estado ? 'activada' : 'desactivada';
        return redirect()->route('biopsias.personas.index')
            ->with('success', "Biopsia {$estado} exitosamente.");
    }
    // Vista para imprimir biopsia
    // Vista para imprimir biopsia
    public function imprimir($nbiopsia)
    {
        $biopsia = Biopsia::with(['paciente', 'doctor'])
            ->where('nbiopsia', $nbiopsia)
            ->firstOrFail();

        return view('biopsias.personas.imprimir', compact('biopsia'));
    }

    // Descargar PDF (versión simple sin librería)
    public function descargarPdf($nbiopsia)
    {
        // Redirigir a imprimir y el usuario usa Ctrl+P para PDF
        return redirect()->route('biopsias.personas.imprimir', $nbiopsia);
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
    public function obtenerNumeroCorrelativo(Request $request)
    {
        $tipo = $request->tipo ?? 'normal';
        $tipoBiopsia = 'persona-' . $tipo;
        $numero = Biopsia::generarNumeroBiopsia($tipoBiopsia);

        return response()->json([
            'success' => true,
            'numero' => $numero,
            'tipo' => $tipo
        ]);
    }
}
