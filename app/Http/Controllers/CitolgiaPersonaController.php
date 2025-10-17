<?php

namespace App\Http\Controllers;

use App\Models\Citolgia;
use App\Models\Paciente;
use App\Models\Doctor;
use App\Models\ListaCitologia;

use Illuminate\Http\Request;

class CitolgiaPersonaController extends Controller
{
    // MOSTRAR CITOLOGÍAS DE PERSONAS
    public function index()
    {
        $citologias = Citolgia::with(['paciente', 'doctor', 'lista_citologia'])
            ->personas()
            ->orderBy('fecha_recibida',  'asc')
            ->paginate(10);

        return view('citologias.personas.index', compact('citologias'));
    }

    // Mostrar formulario para crear citología de paciente humano
    public function create()
    {
        $pacientes = Paciente::orderBy('nombre')
            ->get();
        $doctores = Doctor::where('estado_servicio', true)
            ->get();
        $listas = ListaCitologia::orderBy('codigo')
            ->get();
        $numeroGenerado = Citolgia::generarNumeroCitologia();
        return view('citologias.personas.create', compact('doctores', 'pacientes', 'listas', 'numeroGenerado'));
    }

    // Guardar nueva citología de paciente humano
    public function store(Request $request)
    {
        $request->validate([
            'diagnostico_clinico' => 'required|string',
            'fecha_recibida' => 'required|date|before_or_equal:today',
            'doctor_id' => 'required|exists:doctores,id',
            'paciente_id' => 'required|exists:pacientes,id'
        ], [
            'fecha_recibida.before_or_equal' => 'La fecha no puede ser futura',
            'diagnostico_clinico.required' => 'El diagnóstico clínico es obligatorio',
            'doctor_id.required' => 'Debe seleccionar un doctor',
            'paciente_id.required' => 'Debe seleccionar un paciente'
        ]);

        $numeroGenerado = Citolgia::generarNumeroCitologia();
        $datos = [
            'ncitologia' => $numeroGenerado,
            'diagnostico_clinico' => $request->diagnostico_clinico,
            'fecha_recibida' => $request->fecha_recibida,
            'doctor_id' => $request->doctor_id,
            'paciente_id' => $request->paciente_id,
            'estado' => true,
            'mascota_id' => null,
            'lista_id' => $request->lista_id ?? null,
        ];

        if ($request->lista_id) {
            $lista = ListaCitologia::find($request->lista_id);
            if ($lista) {
                $datos['diagnostico'] = $lista->diagnostico;
                $datos['macroscopico'] = $lista->macroscopico;
                $datos['microscopico'] = $lista->microscopico;
            }
        } else {
            // Sin lista, usar campos manuales (si vienen)
            $datos['diagnostico'] = $request->diagnostico;
            $datos['macroscopico'] = $request->macroscopico;
            $datos['microscopico'] = $request->microscopico;
        }

        Citolgia::create($datos);
        return redirect()->route('citologias.personas.index')->with('success', 'Citología creada exitosamente');
    }

    // Ver detalles de citología de paciente
    public function show($ncitologia)
    {
        $citologia = Citolgia::with(['paciente', 'doctor'])
            ->personas()
            ->where('ncitologia', $ncitologia)
            ->firstOrFail();

        return view('citologias.personas.show', compact('citologia'));
    }

    // Mostrar formulario para editar citología de paciente
    public function edit($ncitologia)
    {
        $citologia = Citolgia::with(['paciente', 'doctor'])
            ->where('ncitologia', $ncitologia)
            ->firstOrFail();

        $pacientes = Paciente::orderBy('nombre')->get();
        $doctores = Doctor::where('estado_servicio', true)
            ->orderBy('nombre')
            ->get();
        $listas = ListaCitologia::orderBy('codigo')->get();

        return view('citologias.personas.edit', compact('citologia', 'doctores', 'pacientes', 'listas'));
    }

    // Actualizar citología de paciente
    public function update(Request $request, $ncitologia)
    {
        $citologia = Citolgia::where('ncitologia', $ncitologia)->firstOrFail();

        $request->validate([
            'diagnostico_clinico' => 'required|string',
            'fecha_recibida' => 'required|date|before_or_equal:today',
            'paciente_id' => 'required|exists:pacientes,id',
            'doctor_id' => 'required|exists:doctores,id',
        ], [
            'fecha_recibida.before_or_equal' => 'La fecha no puede ser futura',
            'diagnostico_clinico.required' => 'El diagnóstico clínico es obligatorio',
            'doctor_id.required' => 'Debe seleccionar un doctor',
            'paciente_id.required' => 'Debe seleccionar un paciente'
        ]);

        $citologia->update([
            'diagnostico_clinico' => $request->diagnostico_clinico,
            'fecha_recibida' => $request->fecha_recibida,
            'paciente_id' => $request->paciente_id,
            'doctor_id' => $request->doctor_id,
            'lista_id' => $request->lista_id ?? null,
            'diagnostico' => $request->diagnostico,
            'macroscopico' => $request->macroscopico,
            'microscopico' => $request->microscopico,
            'mascota_id' => null,
        ]);

        $citologia->save();
        return redirect()->route('citologias.personas.index')
            ->with('success', 'Citología de persona actualizada exitosamente.');
    }

    // Ver historial de citologías de un paciente específico
    public function historialPaciente($pacienteId)
    {
        $paciente = Paciente::findOrFail($pacienteId);

        $citologias = Citolgia::with(['doctor'])
            ->where('paciente_id', $pacienteId)
            ->orderBy('fecha_recibida', 'desc')
            ->paginate(10);

        return view('citologias.pacientes.historial', compact('paciente', 'citologias'));
    }

    // Estadísticas de citologías de pacientes humanos
    public function estadisticas(Request $request)
    {
        $fechaInicio = $request->fecha_inicio ?? now()->startOfMonth();
        $fechaFin = $request->fecha_fin ?? now()->endOfMonth();

        $estadisticas = [
            'total_citologias' => Citolgia::personas()
                ->whereBetween('fecha_recibida', [$fechaInicio, $fechaFin])
                ->count(),
            'activas' => Citolgia::personas()
                ->activas()
                ->whereBetween('fecha_recibida', [$fechaInicio, $fechaFin])
                ->count(),
            'archivadas' => Citolgia::personas()
                ->archivadas()
                ->whereBetween('fecha_recibida', [$fechaInicio, $fechaFin])
                ->count(),
            'pacientes_unicos' => Citolgia::personas()
                ->whereBetween('fecha_recibida', [$fechaInicio, $fechaFin])
                ->distinct('paciente_id')
                ->count('paciente_id')
        ];

        // Citologías por doctor
        $citologiasPorDoctor = Citolgia::with('doctor')
            ->personas()
            ->whereBetween('fecha_recibida', [$fechaInicio, $fechaFin])
            ->get()
            ->groupBy('doctor_id')
            ->map(function ($citologias) {
                return [
                    'doctor' => $citologias->first()->doctor->nombre . ' ' . $citologias->first()->doctor->apellido,
                    'cantidad' => $citologias->count()
                ];
            })
            ->sortByDesc('cantidad');

        // Citologías por rango de edad del paciente
        $citologiasPorEdad = [
            '0-17' => Citolgia::personas()
                ->whereHas('paciente', function ($q) {
                    $q->where('edad', '<', 18);
                })
                ->whereBetween('fecha_recibida', [$fechaInicio, $fechaFin])
                ->count(),
            '18-30' => Citolgia::personas()
                ->whereHas('paciente', function ($q) {
                    $q->whereBetween('edad', [18, 30]);
                })
                ->whereBetween('fecha_recibida', [$fechaInicio, $fechaFin])
                ->count(),
            '31-50' => Citolgia::personas()
                ->whereHas('paciente', function ($q) {
                    $q->whereBetween('edad', [31, 50]);
                })
                ->whereBetween('fecha_recibida', [$fechaInicio, $fechaFin])
                ->count(),
            '51-70' => Citolgia::personas()
                ->whereHas('paciente', function ($q) {
                    $q->whereBetween('edad', [51, 70]);
                })
                ->whereBetween('fecha_recibida', [$fechaInicio, $fechaFin])
                ->count(),
            '70+' => Citolgia::personas()
                ->whereHas('paciente', function ($q) {
                    $q->where('edad', '>', 70);
                })
                ->whereBetween('fecha_recibida', [$fechaInicio, $fechaFin])
                ->count()
        ];

        return view('citologias.pacientes.estadisticas', compact(
            'estadisticas',
            'citologiasPorDoctor',
            'citologiasPorEdad',
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
            'total_citologias' => $paciente->citologias()->count(),
            'citologias_activas' => $paciente->citologias()->activas()->count(),
            'citologias_archivadas' => $paciente->citologias()->archivadas()->count()
        ]);
    }

    // Reporte PDF de citologías por paciente (básico)
    public function reportePaciente($pacienteId)
    {
        $paciente = Paciente::findOrFail($pacienteId);
        $citologias = $paciente->citologias()
            ->with('doctor')
            ->orderBy('fecha_recibida', 'desc')
            ->get();

        return view('citologias.pacientes.reporte-pdf', compact('paciente', 'citologias'));
    }

    // Exportar lista de citologías de pacientes a CSV
    public function exportarCsv(Request $request)
    {
        $query = Citolgia::with(['paciente', 'doctor'])->personas();

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

        $citologias = $query->orderBy('fecha_recibida', 'desc')->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="citologias_pacientes_' . now()->format('Y-m-d') . '.csv"',
        ];

        $callback = function () use ($citologias) {
            $file = fopen('php://output', 'w');

            // Encabezados CSV
            fputcsv($file, [
                'Número Citología',
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
            foreach ($citologias as $citologia) {
                fputcsv($file, [
                    $citologia->ncitologia,
                    $citologia->fecha_recibida->format('d/m/Y'),
                    $citologia->paciente->nombre . ' ' . $citologia->paciente->apellido,
                    $citologia->paciente->DUI,
                    $citologia->paciente->edad,
                    $citologia->paciente->sexo === 'M' ? 'Masculino' : 'Femenino',
                    $citologia->doctor->nombre . ' ' . $citologia->doctor->apellido,
                    substr($citologia->diagnostico_clinico, 0, 100) . '...',
                    $citologia->estado ? 'Activa' : 'Archivada',
                    $citologia->created_at->format('d/m/Y H:i')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function toggleEstado(Request $request, $ncitologia)
    {
        $citologia = Citolgia::where('ncitologia', $ncitologia)->firstOrFail();
        $citologia->update(['estado' => !$citologia->estado]);

        $estado = $citologia->estado ? 'activada' : 'archivada';
        return redirect()->route('citologias.personas.index')
            ->with('success', "Citología {$estado} exitosamente.");
    }

    // Vista para imprimir citología
    public function imprimir($ncitologia)
    {
        $citologia = Citolgia::with(['paciente', 'doctor'])
            ->where('ncitologia', $ncitologia)
            ->firstOrFail();

        return view('citologias.personas.imprimir', compact('citologia'));
    }

    // Descargar PDF (versión simple sin librería)
    public function descargarPdf($ncitologia)
    {
        // Redirigir a imprimir y el usuario usa Ctrl+P para PDF
        return redirect()->route('citologias.personas.imprimir', $ncitologia);
    }

    public function buscarLista($id)
    {
        $lista = ListaCitologia::find($id);
        return response()->json($lista);
    }

    // Método AJAX para buscar por código
    public function buscarListaPorCodigo($codigo)
    {
        $lista = ListaCitologia::where('codigo', $codigo)->first();

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
