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
    public function index(Request $request)
{
    $query = Citolgia::with(['paciente', 'doctor', 'lista_citologia'])
        ->personas();

    // Filtro de búsqueda por paciente o doctor
    if ($request->filled('buscar')) {
        $buscar = $request->buscar;
        $query->where(function($q) use ($buscar) {
            $q->whereHas('doctor', function($q) use ($buscar) {
                $q->where('nombre', 'like', "%{$buscar}%")
                    ->orWhere('apellido', 'like', "%{$buscar}%");
            })
            ->orWhereHas('paciente', function($q) use ($buscar) {
                $q->where('nombre', 'like', "%{$buscar}%")
                    ->orWhere('apellido', 'like', "%{$buscar}%")
                    ->orWhere('DUI', 'like', "%{$buscar}%");
            })
            // También buscar en remitente especial
            ->orWhere('remitente_especial', 'like', "%{$buscar}%");
        });
    }

    // Filtro por estado - CAMBIO AQUÍ: usar has() en lugar de filled()
    if ($request->has('estado') && $request->estado !== '') {
        $query->where('estado', $request->estado);
    }

    // Filtro por doctor específico
    if ($request->filled('doctor')) {
        $query->where('doctor_id', $request->doctor);
    }

    $citologias = $query->orderBy('fecha_recibida', 'asc')
        ->paginate(10)
        ->withQueryString(); // Mantiene los parámetros en la paginación

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
        return view('citologias.personas.create', compact('doctores', 'pacientes', 'listas'));
    }

    // Guardar nueva citología de paciente humano
    public function store(Request $request)
    {
        // Validación dinámica según tipo
        $rules = [
            'diagnostico_clinico' => 'required|string',
            'fecha_recibida' => 'required|date|before_or_equal:today',
            'paciente_id' => 'required|exists:pacientes,id',
            'tipo' => 'required|in:normal,liquida,especial'
        ];

        // Si es especial, requiere remitente_especial en lugar de doctor_id
        if ($request->tipo === 'especial') {
            $rules['remitente_especial'] = 'required|string|max:255';
            $rules['celular_remitente_especial'] = 'required|digits:8';
        } else {
            $rules['doctor_id'] = 'required|exists:doctores,id';
        }

        $request->validate($rules, [
            'fecha_recibida.before_or_equal' => 'La fecha no puede ser futura',
            'diagnostico_clinico.required' => 'El diagnóstico clínico es obligatorio',
            'doctor_id.required' => 'Debe seleccionar un doctor',
            'paciente_id.required' => 'Debe seleccionar un paciente',
            'tipo.required' => 'Debe seleccionar el tipo de citología',
            'remitente_especial.required' => 'Debe ingresar el remitente especial',
            'celular_remitente_especial.required' => 'Debe ingresar el celular del remitente especial',
            'celular_remitente_especial.digits' => 'El celular debe tener exactamente 8 dígitos'
        ]);

        // Generar número correlativo según el tipo
        $numeroGenerado = Citolgia::generarNumeroCitologia($request->tipo);

        $datos = [
            'ncitologia' => $numeroGenerado,
            'diagnostico_clinico' => $request->diagnostico_clinico,
            'fecha_recibida' => $request->fecha_recibida,
            'paciente_id' => $request->paciente_id,
            'tipo' => $request->tipo,
            'estado' => true,
            'mascota_id' => null,
            'lista_id' => $request->lista_id ?? null,
        ];

        // Asignar doctor_id o remitente_especial según el tipo
        if ($request->tipo === 'especial') {
            $datos['remitente_especial'] = $request->remitente_especial;
            $datos['celular_remitente_especial'] = $request->celular_remitente_especial;
            $datos['doctor_id'] = null; // O puedes asignar un doctor por defecto
        } else {
            $datos['doctor_id'] = $request->doctor_id;
            $datos['remitente_especial'] = null;
            $datos['celular_remitente_especial'] = null;
        }

        if ($request->lista_id) {
            $lista = ListaCitologia::find($request->lista_id);
            if ($lista) {
                $datos['diagnostico'] = $lista->diagnostico;
                $datos['descripcion'] = $lista->descripcion;
            }
        } else {
            // Sin lista, usar campos manuales (si vienen)
            $datos['diagnostico'] = $request->diagnostico;
            $datos['descripcion'] = $request->descripcion;
        }

        Citolgia::create($datos);

        $tipoTexto = match ($request->tipo) {
            'liquida' => 'líquida',
            'especial' => 'especial',
            default => 'normal'
        };

        return redirect()->route('citologias.personas.index')
            ->with('success', "Citología {$tipoTexto} creada exitosamente con número {$numeroGenerado}");
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

        // Validación dinámica según si es remitente especial o no
        $rules = [
            'diagnostico_clinico' => 'required|string',
            'fecha_recibida' => 'required|date|before_or_equal:today',
            'paciente_id' => 'required|exists:pacientes,id',
            'tipo' => 'required|in:normal,liquida'
        ];

        // Si es remitente especial, requiere remitente_especial en lugar de doctor_id
        if ($request->doctor_id === 'especial') {
            $rules['remitente_especial'] = 'required|string|max:255';
            $rules['celular_remitente_especial'] = 'required|digits:8';
        } else {
            $rules['doctor_id'] = 'required|exists:doctores,id';
        }

        $request->validate($rules, [
            'fecha_recibida.before_or_equal' => 'La fecha no puede ser futura',
            'diagnostico_clinico.required' => 'El diagnóstico clínico es obligatorio',
            'doctor_id.required' => 'Debe seleccionar un remitente',
            'paciente_id.required' => 'Debe seleccionar un paciente',
            'tipo.required' => 'Debe seleccionar el tipo de citología',
            'remitente_especial.required' => 'Debe ingresar el nombre del remitente especial',
            'celular_remitente_especial.required' => 'Debe ingresar el celular del remitente especial',
            'celular_remitente_especial.digits' => 'El celular debe tener exactamente 8 dígitos'
        ]);

        // Preparar datos para actualizar
        $updateData = [
            'diagnostico_clinico' => $request->diagnostico_clinico,
            'fecha_recibida' => $request->fecha_recibida,
            'paciente_id' => $request->paciente_id,
            'tipo' => $request->tipo,
            'lista_id' => $request->lista_id ?? null,
            'diagnostico' => $request->diagnostico,
            'descripcion' => $request->descripcion,
            'mascota_id' => null,
        ];

        // Manejar doctor_id y remitente_especial según el caso
        if ($request->doctor_id === 'especial') {
            $updateData['doctor_id'] = null;
            $updateData['remitente_especial'] = $request->remitente_especial;
            $updateData['celular_remitente_especial'] = $request->celular_remitente_especial;
        } else {
            $updateData['doctor_id'] = $request->doctor_id;
            $updateData['remitente_especial'] = null;
            $updateData['celular_remitente_especial'] = null;
        }

        $citologia->update($updateData);

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
            'normales' => Citolgia::personas()
                ->where('tipo', 'normal')
                ->whereBetween('fecha_recibida', [$fechaInicio, $fechaFin])
                ->count(),
            'liquidas' => Citolgia::personas()
                ->where('tipo', 'liquida')
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

        // Seleccionar la vista según el tipo de citología
        $vista = match ($citologia->tipo) {
            'normal' => 'citologias.personas.print.imprimir-normal',
            'liquida' => 'citologias.personas.print.imprimir-liquida',
            'especial' => 'citologias.personas.print.imprimir-especial',
            default => 'citologias.personas.print.imprimir-normal'
        };

        return view($vista, compact('citologia'));
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
    public function obtenerNumeroCorrelativo(Request $request)
    {
        $tipo = $request->tipo ?? 'normal';
        $numero = Citolgia::generarNumeroCitologia($tipo);

        return response()->json([
            'success' => true,
            'numero' => $numero,
            'tipo' => $tipo
        ]);
    }
}
