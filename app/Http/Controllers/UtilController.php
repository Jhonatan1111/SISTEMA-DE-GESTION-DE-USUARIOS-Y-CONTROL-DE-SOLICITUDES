<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class UtilController extends Controller
{
    //
    public function credits()
    {
        return view('utils.credits');
    }

    private function descargarManual(string $filename, string $downloadName)
    {
        $path = public_path('manuales/' . $filename);
        if (file_exists($path)) {
            return response()->file($path, ['Content-Type' => 'application/pdf']);
        }
        $html = "<h1 style='font-family: DejaVu Sans; font-size: 22px;'>Manual no disponible</h1><p>El archivo <strong>{$filename}</strong> no se encontró en <code>public/manuales</code>. Este PDF es un reemplazo temporal.</p>";
        $pdf = Pdf::loadHTML($html);
        return $pdf->stream($downloadName);
    }

    // CENTRO DE APOYO
    public function help()
    {
        return view('utils.help');
    }

    public function descargarUsuario()
    {
        return $this->descargarManual('usuario.pdf', 'manual-usuario.pdf');
    }

    public function descargarAdministrador()
    {
        return $this->descargarManual('administrador.pdf', 'manual-administrador.pdf');
    }

    public function descargarCapacitacion()
    {
        return $this->descargarManual('capacitacion.pdf', 'manual-capacitacion.pdf');
    }

    public function descargarImplementacion()
    {
        return $this->descargarManual('implementacion.pdf', 'manual-implementacion.pdf');
    }
}
