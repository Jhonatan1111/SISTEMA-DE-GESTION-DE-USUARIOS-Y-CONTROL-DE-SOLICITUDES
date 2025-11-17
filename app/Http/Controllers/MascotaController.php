<?php

namespace App\Http\Controllers;

use App\Models\Mascota;
use Illuminate\Http\Request;

class MascotaController extends Controller
{

    // MOSTRANDO PACIENTES
    public function index(Request $request)
    {
        $q = trim($request->input('q', ''));

        $query = Mascota::query();

        if ($q !== '') {
            $term = "%{$q}%";
            $query->where(function ($builder) use ($term) {
                $builder->where('propietario', 'like', $term)
                    ->orWhere('nombre', 'like', $term)
                    ->orWhere('sexo', 'like', $term)
                    ->orWhere('especie', 'like', $term)
                    ->orWhere('correo', 'like', $term)
                    ->orWhere('raza', 'like', $term)
                    ->orWhere('edad', 'like', $term)
                    ->orWhere('celular', 'like', $term);
            });
        }


        $mascotas = $query->orderBy('nombre')->paginate(10)->withQueryString();
        return view('mascotas.index', compact('mascotas'));
    }
    // CREANDO MASCOTA
    public function create()
    {
        return view('mascotas.create');
    }
    public function show(Mascota $mascota)
    {
        return view('mascotas.show', compact('mascota'));
    }
    // GUARDANDO MASCOTA
    public function store(Request $request)
    {
        // VALIDANDO INFORMACION ANTES DE CREAR
        $request->validate([
            'nombre' => 'required|string|max:255',
            'edad' => 'nullable|integer',
            'sexo' => 'required|string|in:macho,hembra',
            'especie' => 'required|string|max:255',
            'raza' => 'required|string|max:255',
            'propietario' => 'required|string|max:255',
            'correo' => 'nullable|string|email|max:255|unique:mascotas,correo',
            'celular' => 'nullable|digits:8|unique:mascotas,celular',

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
            'estado' => true,
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
    public function toggleEstado(Request $request, $id)
    {
        $mascota = Mascota::findOrFail($id);
        $mascota->estado = !$mascota->estado;
        $mascota->save();
        $estado = $mascota->estado ? 'activado' : 'desactivado';
        return redirect()->back()
            ->with('success', "Mascota {$estado} exitosamente");
    }
}
