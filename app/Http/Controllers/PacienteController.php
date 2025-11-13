<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\Request;

class PacienteController extends Controller
{

    // MOSTRANDO PACIENTES
    public function index(Request $request)
    {
        $q = trim($request->input('q', ''));

        $query = Paciente::query();

        if ($q !== '') {
            $term = "%{$q}%";
            $query->where(function ($builder) use ($term) {
                $builder->where('dui', 'like', $term)
                    ->orWhere('nombre', 'like', $term)
                    ->orWhere('apellido', 'like', $term)
                    ->orWhere('sexo', 'like', $term)
                    ->orWhere('celular', 'like', $term)
                    ->orWhere('correo', 'like', $term)
                    ->orWhere('direccion', 'like', $term);
            });
        }

        $pacientes = $query->orderBy('nombre')->paginate(10)->withQueryString();
        return view('pacientes.index', compact('pacientes'));
    }

    public function show(Paciente $paciente)
    {
        return view('pacientes.show', compact('paciente'));
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
            'dui' => 'nullable|string|digits:9|unique:pacientes',
            'sexo' => 'nullable|string|in:masculino,femenino',
            'fecha_nacimiento' => 'nullable|date',
            'estado_civil' => 'nullable|string',
            'ocupacion' => 'nullable|string',
            'correo' => 'nullable|string|email|max:255',
            'direccion' => 'nullable|string|max:500',
            'celular' => 'nullable|digits:8|unique:pacientes',
        ]);

        Paciente::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'dui' => $request->dui,
            'estado' => true,
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

        $paciente->update([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'dui' => $request->dui, // Asegúrate de que el DUI sea único
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
    public function toggleEstado(Request $request, $id)
    {
        $paciente = Paciente::findOrFail($id);
        $paciente->estado = !$paciente->estado;
        $paciente->save();
        $estado = $paciente->estado ? 'activado' : 'desactivado';
        return redirect()->back()
            ->with('success', "Paciente {$estado} exitosamente");
    }
}
