<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{


    // listar doctores - Tanto admin como empleado pueden ver
    public function index()
    {
        $doctores = Doctor::orderBy('nombre')->paginate(10);
        return view('doctores.index', compact('doctores'));
    }

    // crear doctor - Solo admin
    public function create()
    {
        return view('doctores.create');
    }

    // guardar doctor en la base de datos - Solo admin
    public function store(Request $request)
    {
        $request->validate([
            'jvpm' => 'required|string|max:10|unique:doctores',
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'direccion' => 'nullable|string|max:500',
            'celular' => 'required|digits:8|unique:doctores',
            'fax' => 'nullable|digits:11|unique:doctores',
            'correo' => 'nullable|string|email|max:255|unique:doctores',
        ]);

        Doctor::create([
            'jvpm' => $request->jvpm,
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'direccion' => $request->direccion,
            'celular' => $request->celular,
            'fax' => $request->fax,
            'correo' => $request->correo,
            'estado_servicio' => true,
        ]);

        return redirect()->route('doctores.index')->with('success', 'Doctor creado exitosamente.');
    }

    // editar doctor llamado desde la vista - Solo admin
    public function edit($id)
    {
        $doctor = Doctor::findOrFail($id);
        return view('doctores.edit', compact('doctor'));
    }

    // actualizar doctor obteniendo datos del formulario - Solo admin
    public function update(Request $request, $id)
    {
        $doctor = Doctor::findOrFail($id);

        $request->validate([
            'jvpm' => 'required|string|max:10|unique:doctores,jvpm,' . $doctor->id,
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'direccion' => 'nullable|string|max:500',
            'celular' => 'required|digits:8|unique:doctores,celular,' . $doctor->id,
            'fax' => 'nullable|digits:11|unique:doctores,fax,' . $doctor->id,
            'correo' => 'nullable|string|email|max:255|unique:doctores,correo,' . $doctor->id,
        ]);

        $doctor->update([
            'jvpm' => $request->jvpm,
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'direccion' => $request->direccion,
            'celular' => $request->celular,
            'fax' => $request->fax,
            'correo' => $request->correo,
            'estado_servicio' => $request->input('estado_servicio') == '1',
        ]);

        return redirect()->route('doctores.index')->with('success', 'Doctor actualizado exitosamente.');
    }

    // Eliminar doctor de manera protegida - Solo admin
    public function destroy($id)
    {
        $doctor = Doctor::findOrFail($id);
        try {
            $doctor->delete();
            return redirect()->route('doctores.index')
                ->with('success', 'Doctor eliminado exitosamente');
        } catch (\Exception $e) {
            return redirect()->route('doctores.index')
                ->with('error', 'No se puede eliminar el doctor porque tiene registros asociados');
        }
    }

    // Cambiar estado del doctor (activar/desactivar) - Solo admin
    public function toggleEstado(Request $request, $id)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->estado_servicio = !$doctor->estado_servicio;
        $doctor->save();
        $estado = $doctor->estado_servicio ? 'activado' : 'desactivado';
        return redirect()->route('doctores.index')
            ->with('success', "Doctor {$estado} exitosamente");
    }
}