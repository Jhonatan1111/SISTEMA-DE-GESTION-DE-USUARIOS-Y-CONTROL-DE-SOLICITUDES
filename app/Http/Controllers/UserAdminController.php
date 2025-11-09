<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserAdminController extends Controller
{
    // Mostrar lista de usuarios
    public function index()
    {
        $usuarios = User::orderBy('created_at', 'desc')->get();
        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function show(User $usuario)
    {
        return view('admin.usuarios.show', compact('usuario'));
    }

    // Mostrar formulario de creación
    public function create()
    {
        return view('admin.usuarios.create');
    }

    // Guardar nuevo usuario
    public function store(Request $request)
    {
        $request->merge([
            'nombre' => trim($request->nombre),
            'apellido' => trim($request->apellido),
            'celular' => trim($request->celular),
            'email' => trim($request->email),
        ]);
        $request->validate([
            'nombre' => 'required|string|max:255|regex:/^[a-záéíóúñA-ZÁÉÍÓÚÑ\s]+$/',
            'apellido' => 'required|string|max:255|regex:/^[a-záéíóúñA-ZÁÉÍÓÚÑ\s]+$/',
            'celular' => 'nullable|digits:8|unique:usuarios,celular',
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required|min:4|confirmed',
            'role' => 'required|in:admin,empleado'
        ], [
            'nombre.regex' => 'El nombre solo puede contener letras y espacios',
            'apellido.regex' => 'El apellido solo puede contener letras y espacios',
            'celular.digits' => 'El celular debe tener exactamente 8 dígitos numéricos',
        ]);

        User::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'celular' => $request->celular,
        ]);

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario creado exitosamente');
    }

    // Mostrar formulario de edición
    public function edit(User $usuario)
    {
        return view('admin.usuarios.edit', compact('usuario'));
    }

    // Actualizar usuario
    public function update(Request $request, User $usuario)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'celular' => 'nullable|digits:8',
            'email' => ['required', 'email', Rule::unique('usuarios')->ignore($usuario->id)],
            'password' => 'nullable|min:4|confirmed',
            'role' => 'required|in:admin,empleado'
        ]);

        $data = [
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'role' => $request->role,
            'celular' => $request->celular,
        ];

        // Solo actualizar password si se proporcionó uno nuevo
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $usuario->update($data);

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario actualizado exitosamente');
    }

    // Eliminar usuario
    public function destroy(User $usuario)
    {
        // Evitar que el usuario se elimine a sí mismo
        // if ($usuario->id === auth()->id()) {
        //     return redirect()->route('admin.usuarios.index')
        //         ->with('error', 'No puedes eliminar tu propia cuenta');
        // }

        $usuario->delete();

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario eliminado exitosamente');
    }
}
