<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\Request;

class PacienteController extends Controller
{

    // MOSTRANDO PACIENTES
    public function index()
    {
        $pacientes = Paciente::orderBy('nombre')->paginate(10);
        return view('pacientes.index', compact('pacientes'));
    }
    // CREANDO PACIENTE
    public function create()
    {
        return view('pacientes.create');
    }
    // GUARDANDO PACIENTE
    public function store(Request $request)
    {
        // VALIDANDO INFORMACION ANTES DE CREAR
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'dui' => 'string|unique:pacientes',
            'edad' => 'required|integer',
            'sexo' => 'required|string|in:masculino,femenino',
            'fecha_nacimiento' => 'date',
            'estado_civil' => 'string',
            'ocupacion' => 'string',
            'correo' => 'string|email|unique:pacientes',
            'direccion' => 'nullable|string|max:500',
            'celular' => 'required|digits:8|unique:pacientes',
        ]);

        Paciente::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'dui' => $request->dui,
            'edad' => $request->edad,
            'sexo' => $request->sexo,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'estado_civil' => $request->estado_civil,
            'ocupacion' => $request->ocupacion,
            'correo' => $request->correo,
            'direccion' => $request->direccion,
            'celular' => $request->celular,
        ]);

        return redirect()->route('pacientes.index')->with('success', 'Paciente creado exitosamente.');
    }

    // EDITAR PACIENTE
    public function edit($id)
    {
        $paciente = Paciente::findOrFail($id);
        return view('pacientes.edit', compact('paciente'));
    }
    // ACTUALIZAR PACIENTE
    public function update(Request $request, $id)
    {
        $paciente = Paciente::findOrFail($id);

        // VALIDANDO INFORMACION ANTES DE ACTUALIZAR
        // $request->validate([
        //     'nombre' => 'required|string|max:255',
        //     'apellido' => 'required|string|max:255',
        //     'dui' => 'digits:9|unique:pacientes,dui,' . $paciente->id,
        //     'edad' => 'required|integer',
        //     'sexo' => 'required|string|in:masculino,femenino',
        //     'fecha_nacimiento' => 'date',
        //     'estado_civil' => 'string',
        //     'ocupacion' => 'string',
        //     'correo' => 'nullable|string|email|max:255|unique:pacientes,correo,' . $paciente->id,
        //     'direccion' => 'nullable|string|max:500',
        //     'celular' => 'required|digits:8|unique:pacientes,celular,' . $paciente->id,
        // ]);

        $paciente->update([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'dui' => $request->dui, // Asegúrate de que el DUI sea único
            'edad' => $request->edad,
            'sexo' => $request->sexo,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'estado_civil' => $request->estado_civil,
            'ocupacion' => $request->ocupacion,
            'correo' => $request->correo,
            'direccion' => $request->direccion,
            'celular' => $request->celular,
        ]);

        return redirect()->route('pacientes.index')->with('success', 'Paciente actualizado exitosamente.');
    }

    // ELIMINAR PACIENTE
    public function destroy($id)
    {
        $paciente = Paciente::findOrFail($id);
        try {
            $paciente->delete();
            return redirect()->route('pacientes.index')
                ->with('success', 'Paciente eliminado exitosamente');
        } catch (\Exception $e) {
            return redirect()->route('pacientes.index')
                ->with('error', 'No se puede eliminar el paciente porque tiene registros asociados');
        }
    }
}
