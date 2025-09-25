<?php

namespace App\Http\Controllers;

use App\Models\Biopsia;
use App\Models\Doctor;
use App\Models\Paciente;
use App\Models\Mascota;
use Illuminate\Http\Request;

class BiopsiaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todas las biopsias
        $biopsias = Biopsia::with(['doctor', 'paciente', 'mascota'])
            ->orderBy('fecha_recibida', 'desc')
            ->paginate(10);

        return view('biopsias.index', compact('biopsias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $doctores = Doctor::where('estado_servicio', true)
            ->orderBy('nombre')
            ->get();

        $pacientes = Paciente::orderBy('nombre')->get();
        $mascotas = Mascota::orderBy('nombre')->get();

        return view('biopsias.create', compact('doctores', 'pacientes', 'mascotas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de datos
        $request->validate([
            'nbiopsia' => 'required|string|max:15|unique:biopsias,nbiopsia',
            'diagnostico_clinico' => 'required|string|max:500',
            'fecha_recibida' => 'required|date',
            'doctor_id' => 'nullable|exists:doctores,id',
            'paciente_id' => 'nullable|exists:pacientes,id',
            'mascota_id' => 'nullable|exists:mascotas,id',
        ]);

        // Validar que al menos uno de los tres (doctor, paciente, mascota) esté seleccionado
        if (!$request->doctor_id && !$request->paciente_id && !$request->mascota_id) {
            return back()->withErrors(['general' => 'Debe seleccionar al menos un doctor, paciente o mascota.'])
                ->withInput();
        }

        Biopsia::create([
            'nbiopsia' => $request->nbiopsia,
            'diagnostico_clinico' => $request->diagnostico_clinico,
            'fecha_recibida' => $request->fecha_recibida,
            'doctor_id' => $request->doctor_id,
            'paciente_id' => $request->paciente_id,
            'mascota_id' => $request->mascota_id,
        ]);

        return redirect()->route('biopsias.index')
            ->with('success', 'Biopsia creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $nbiopsia)
    {
        $biopsia = Biopsia::with(['doctor', 'paciente', 'mascota'])
            ->where('nbiopsia', $nbiopsia)
            ->firstOrFail();

        return view('biopsias.show', compact('biopsia'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $nbiopsia)
    {
        $biopsia = Biopsia::where('nbiopsia', $nbiopsia)->firstOrFail();

        $doctores = Doctor::where('estado_servicio', true)
            ->orderBy('nombre')
            ->get();

        $pacientes = Paciente::orderBy('nombre')->get();
        $mascotas = Mascota::orderBy('nombre')->get();

        return view('biopsias.edit', compact('biopsia', 'doctores', 'pacientes', 'mascotas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $nbiopsia)
    {
        $biopsia = Biopsia::where('nbiopsia', $nbiopsia)->firstOrFail();

        // Validación de datos
        $request->validate([
            'nbiopsia' => 'required|string|max:15|unique:biopsias,nbiopsia,' . $biopsia->nbiopsia . ',nbiopsia',
            'diagnostico_clinico' => 'required|string|max:500',
            'fecha_recibida' => 'required|date',
            'doctor_id' => 'nullable|exists:doctores,id',
            'paciente_id' => 'nullable|exists:pacientes,id',
            'mascota_id' => 'nullable|exists:mascotas,id',
        ]);

        // Validar que al menos uno de los tres (doctor, paciente, mascota) esté seleccionado
        if (!$request->doctor_id && !$request->paciente_id && !$request->mascota_id) {
            return back()->withErrors(['general' => 'Debe seleccionar al menos un doctor, paciente o mascota.'])
                ->withInput();
        }

        $biopsia->update([
            'nbiopsia' => $request->nbiopsia,
            'diagnostico_clinico' => $request->diagnostico_clinico,
            'fecha_recibida' => $request->fecha_recibida,
            'doctor_id' => $request->doctor_id,
            'paciente_id' => $request->paciente_id,
            'mascota_id' => $request->mascota_id,
        ]);

        return redirect()->route('biopsias.index')
            ->with('success', 'Biopsia actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $nbiopsia)
    {
        $biopsia = Biopsia::where('nbiopsia', $nbiopsia)->firstOrFail();

        try {
            $biopsia->delete();
            return redirect()->route('biopsias.index')
                ->with('success', 'Biopsia eliminada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('biopsias.index')
                ->with('error', 'No se puede eliminar la biopsia porque tiene registros asociados.');
        }
    }
}
