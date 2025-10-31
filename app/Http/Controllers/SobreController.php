<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Paciente;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class SobreController extends Controller
{
    /**
     * Muestra el formulario para ingresar datos manualmente
     */
    public function index()
    {
        return view('sobres.index');
    }

/**
 * Genera el PDF del sobre para doctor y paciente (nombre completo)
 */
    public function generar(Request $request)
    {
        $request->validate([
            'doctor_nombre' => 'required|string|max:255',
            'paciente_nombre' => 'nullable|string|max:255'
        ]);

        // Crear objetos temporales con los datos ingresados
        $doctor = (object)[
            'nombre' => $request->doctor_nombre,
            'apellido' => '' // Vacío porque el nombre completo va en 'nombre'
        ];

        $paciente = null;
        if ($request->paciente_nombre) {
            $paciente = (object)[
                'nombre' => $request->paciente_nombre,
                'apellido' => '' // Vacío porque el nombre completo va en 'nombre'
            ];
        }

        // Generar el PDF con orientación horizontal
        $pdf = Pdf::loadView('sobres.plantilla', [
            'doctor' => $doctor,
            'paciente' => $paciente
        ]);

        $pdf->setPaper('letter', 'landscape');

        $nombreArchivo = 'sobre_' . str_replace(' ', '_', $doctor->nombre);
        if ($paciente) {
            $nombreArchivo .= '_' . str_replace(' ', '_', $paciente->nombre);
        }
        $nombreArchivo .= '.pdf';

        return $pdf->stream($nombreArchivo);
    }

    /**
     * Genera el PDF del sobre para instituciones
     */
    public function generarManual(Request $request)
    {
        $request->validate([
            'institucion_nombre' => 'required|string|max:255'
        ]);

        // Crear objeto temporal con el nombre de la institución
        $institucion = (object)[
            'nombre' => $request->institucion_nombre,
            'apellido' => '' // Vacío para mantener compatibilidad con la plantilla
        ];

        // Generar el PDF con orientación horizontal
        $pdf = Pdf::loadView('sobres.plantilla-institucion', [
            'institucion' => $institucion
        ]);

        $pdf->setPaper('letter', 'landscape');

        $nombreArchivo = 'sobre_' . str_replace(' ', '_', $request->institucion_nombre) . '.pdf';

        return $pdf->stream($nombreArchivo);
    }
}
