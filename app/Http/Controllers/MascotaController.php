<?php

namespace App\Http\Controllers;

use App\Models\Mascota;
use Illuminate\Http\Request;

class MascotaController extends Controller
{

    // MOSTRANDO PACIENTES
    public function index()
    {
        $mascotas = Mascota::orderBy('nombre')->paginate(10);
        return view('mascotas.index', compact('mascotas'));
    }
    // CREANDO PACIENTE
    public function create()
    {
        return view('mascotas.create');
    }
    // GUARDANDO MASCOTA
    public function store(Request $request)
    {
        // VALIDANDO INFORMACION ANTES DE CREAR
        $request->validate([
            'nombre' => 'required|string|max:255',
            'edad' => 'required|integer',
            'sexo' => 'required|string|in:macho,hembra',
            'especie' => 'string|max:255',
            'raza' => 'string|max:255',
            'propietario' => 'string|max:255',
            'correo' => 'string|email|unique:mascotas,correo',
            'celular' => 'required|digits:8|unique:mascotas,celular',

        ]);

        Mascota::create([
            'nombre' => $request->nombre,
            'edad' => $request->edad,
            'sexo' => $request->sexo,
            'especie' => $request->especie,
            'raza' => $request->raza,
            'propietario' => $request->propietario,
            'correo' => $request->correo,
            'celular' => $request->celular,
        ]);

        return redirect()->route('mascotas.index')->with('success', 'Mascota creada exitosamente.');
    }

    // EDITAR MASCOTA
    public function edit($id)
    {
        $mascota = Mascota::findOrFail($id);
        return view('mascotas.edit', compact('mascota'));
    }
    // ACTUALIZAR MASCOTA
    public function update(Request $request, $id)
    {
        $mascota = Mascota::findOrFail($id);

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

        $mascota->update([
            'nombre' => $request->nombre,
            'edad' => $request->edad,
            'sexo' => $request->sexo,
            'especie' => $request->especie,
            'raza' => $request->raza,
            'propietario' => $request->propietario,
            'correo' => $request->correo,
            'celular' => $request->celular,
        ]);

        return redirect()->route('mascotas.index')->with('success', 'Mascota actualizada exitosamente.');
    }

    // ELIMINAR MASCOTA
    public function destroy($id)
    {
        $mascota = Mascota::findOrFail($id);
        try {
            $mascota->delete();
            return redirect()->route('mascotas.index')
                ->with('success', 'Mascota eliminada exitosamente');
        } catch (\Exception $e) {
            return redirect()->route('mascotas.index')
                ->with('error', 'No se puede eliminar la mascota porque tiene registros asociados');
        }
    }
}
