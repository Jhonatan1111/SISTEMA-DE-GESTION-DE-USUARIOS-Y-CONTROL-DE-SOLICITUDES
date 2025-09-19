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

    // Mostrar formulario de creación
    public function create()
    {
        return view('admin.usuarios.create');
    }

    // Guardar nuevo usuario
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required|min:6|confirmed',
            'rol' => 'required|in:admin,empleado'
        ]);

        User::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol' => $request->rol,
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
            'email' => ['required', 'email', Rule::unique('usuarios')->ignore($usuario->id)],
            'password' => 'nullable|min:6|confirmed',
            'rol' => 'required|in:admin,empleado'
        ]);

        $data = [
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'rol' => $request->rol,
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