namespace App\Http\Controllers;
use App\Models\Biopsia;
use App\Models\Paciente;
use App\Models\Doctor;
use Illuminate\Http\Request;

class BiopsiaPacienteController extends Controller
{
// Listar biopsias de pacientes humanos
public function index(Request $request)
{
$query = Biopsia::with(['paciente', 'doctor'])
->humanos(); // Solo pacientes humanos

// Filtros específicos para humanos
if ($request->doctor_id) {
$query->where('doctor_id', $request->doctor_id);
}

if ($request->estado) {
if ($request->estado === 'completadas') {
$query->completadas();
} else {
$query->pendientes();
}
}

if ($request->paciente_id) {
$query->where('paciente_id', $request->paciente_id);
}

if ($request->fecha_desde) {
$query->where('fecha_recibida', '>=', $request->fecha_desde);
}

if ($request->fecha_hasta) {
$query->where('fecha_recibida', '<=', $request->fecha_hasta);
    }

    // Búsqueda por nombre o DUI
    if ($request->buscar) {
    $query->whereHas('paciente', function($q) use ($request) {
    $q->where('nombre', 'like', '%' . $request->buscar . '%')
    ->orWhere('apellido', 'like', '%' . $request->buscar . '%')
    ->orWhere('DUI', 'like', '%' . $request->buscar . '%');
    });
    }

    $biopsias = $query->orderBy('fecha_recibida', 'desc')
    ->orderBy('nbiopsia', 'desc')
    ->paginate(15);

    $doctores = Doctor::where('estado_servicio', true)->get();
    $pacientes = Paciente::orderBy('nombre')->get();

    return view('biopsias.pacientes.index', compact('biopsias', 'doctores', 'pacientes'));
    }

    // Mostrar formulario para crear biopsia de paciente humano
    public function create()
    {
    $doctores = Doctor::where('estado_servicio', true)->get();
    $pacientes = Paciente::orderBy('nombre')->get();

    return view('biopsias.pacientes.create', compact('doctores', 'pacientes'));
    }

    // Guardar nueva biopsia de paciente humano
    public function store(Request $request)
    {
    $request->validate([
    'diagnostico_clinico' => 'required|string|max:1000',
    'fecha_recibida' => 'required|date|before_or_equal:today',
    'doctor_id' => 'required|exists:doctores,id',
    'paciente_id' => 'required|exists:pacientes,id'
    ], [
    'fecha_recibida.before_or_equal' => 'La fecha no puede ser futura',
    'diagnostico_clinico.required' => 'El diagnóstico clínico es obligatorio',
    'doctor_id.required' => 'Debe seleccionar un doctor',
    'paciente_id.required' => 'Debe seleccionar un paciente'
    ]);

    try {
    // Crear biopsia para humano
    $biopsia = Biopsia::create([
    'nbiopsia' => Biopsia::generarNumeroBiopsia(),
    'diagnostico_clinico' => $request->diagnostico_clinico,
    'fecha_recibida' => $request->fecha_recibida,
    'doctor_id' => $request->doctor_id,
    'paciente_id' => $request->paciente_id,
    'mascota_id' => null, // Siempre null para humanos
    'list_result_biopsia_id' => null // Se asignará después
    ]);

    return redirect()->route('biopsias.pacientes.index')
    ->with('success', 'Biopsia creada exitosamente: ' . $biopsia->nbiopsia);

    } catch (\Exception $e) {
    return back()->with('error', 'Error al crear la biopsia: ' . $e->getMessage())
    ->withInput();
    }
    }

    // Ver detalles de biopsia de paciente
    public function show($nbiopsia)
    {
    $biopsia = Biopsia::with(['paciente', 'doctor'])
    ->humanos()
    ->findOrFail($nbiopsia);

    return view('biopsias.pacientes.show', compact('biopsia'));
    }

    // Mostrar formulario para editar biopsia de paciente
    public function edit($nbiopsia)
    {
    $biopsia = Biopsia::humanos()->findOrFail($nbiopsia);

    $doctores = Doctor::where('estado_servicio', true)->get();
    $pacientes = Paciente::orderBy('nombre')->get();

    return view('biopsias.pacientes.edit', compact('biopsia', 'doctores', 'pacientes'));
    }

    // Actualizar biopsia de paciente
    public function update(Request $request, $nbiopsia)
    {
    $biopsia = Biopsia::humanos()->findOrFail($nbiopsia);

    $request->validate([
    'diagnostico_clinico' => 'required|string|max:1000',
    'fecha_recibida' => 'required|date|before_or_equal:today',
    'doctor_id' => 'required|exists:doctores,id',
    'paciente_id' => 'required|exists:pacientes,id'
    ], [
    'fecha_recibida.before_or_equal' => 'La fecha no puede ser futura',
    'diagnostico_clinico.required' => 'El diagnóstico clínico es obligatorio'
    ]);

    try {
    $biopsia->update([
    'diagnostico_clinico' => $request->diagnostico_clinico,
    'fecha_recibida' => $request->fecha_recibida,
    'doctor_id' => $request->doctor_id,
    'paciente_id' => $request->paciente_id
    ]);

    return redirect()->route('biopsias.pacientes.show', $nbiopsia)
    ->with('success', 'Biopsia actualizada exitosamente');

    } catch (\Exception $e) {
    return back()->with('error', 'Error al actualizar: ' . $e->getMessage())
    ->withInput();
    }
    }

    // Eliminar biopsia
    public function destroy($nbiopsia)
    {
    $biopsia = Biopsia::humanos()->findOrFail($nbiopsia);

    try {
    $numeroBiopsia = $biopsia->nbiopsia;
    $biopsia->delete();

    return redirect()->route('biopsias.pacientes.index')
    ->with('success', 'Biopsia eliminada exitosamente: ' . $numeroBiopsia);

    } catch (\Exception $e) {
    return back()->with('error', 'Error al eliminar: ' . $e->getMessage());
    }
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
    ->whereHas('paciente', function($q) { $q->where('edad', '<', 18); })
        ->whereBetween('fecha_recibida', [$fechaInicio, $fechaFin])
        ->count(),
        '18-30' => Biopsia::humanos()
        ->whereHas('paciente', function($q) { $q->whereBetween('edad', [18, 30]); })
        ->whereBetween('fecha_recibida', [$fechaInicio, $fechaFin])
        ->count(),
        '31-50' => Biopsia::humanos()
        ->whereHas('paciente', function($q) { $q->whereBetween('edad', [31, 50]); })
        ->whereBetween('fecha_recibida', [$fechaInicio, $fechaFin])
        ->count(),
        '51-70' => Biopsia::humanos()
        ->whereHas('paciente', function($q) { $q->whereBetween('edad', [51, 70]); })
        ->whereBetween('fecha_recibida', [$fechaInicio, $fechaFin])
        ->count(),
        '70+' => Biopsia::humanos()
        ->whereHas('paciente', function($q) { $q->where('edad', '>', 70); })
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

            $callback = function() use ($biopsias) {
            $file = fopen('php://output', 'w');

            // Encabezados CSV
            fputcsv($file, [
            'Número Biopsia', 'Fecha Recibida', 'Paciente', 'DUI', 'Edad',
            'Sexo', 'Doctor', 'Diagnóstico Clínico', 'Estado', 'Fecha Registro'
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
            }