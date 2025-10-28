<?php

namespace App\Http\Controllers;

use App\Models\ListaBiopsia;
use Illuminate\Http\Request;

class ListaBiopsiaController extends Controller
{
    // Listar biopsias
    public function index()
    {
        // Obtener todas las biopsias ordenadas por código
        $listaBiopsia = ListaBiopsia::orderBy('codigo')
            ->paginate(10);
        // Pasar la lista de biopsias a la vista
        return view('listas.biopsias.index', compact('listaBiopsia'));
    }

    // Mostrar formulario para crear biopsia
    public function create()
    {
        // Generar un nuevo código para la biopsia
        $codigoGenerado = ListaBiopsia::generarCodigoLista();
        // Pasar el código generado a la vista
        return view('listas.biopsias.create', compact('codigoGenerado'));
    }

    // Creacion de una lista de biopsia
    public function store(Request $request)
    {
        // obtener codigo generado en la ruta create
        $codigoGenerado = ListaBiopsia::generarCodigoLista();

        // validar la informacion obtenida como datos del tipo correcto
        $validated = $request->validate([
            'macroscopico' => 'nullable|string',
            'descripcion' => 'nullable|string',
        ]);

        // capturado de errores para no crashear la aplicacion
        try {
            // Usar updateOrCreate para mantener la secuencia de códigos LB001, LB002, etc.
            // aunque el ID no sea secuencial
            ListaBiopsia::updateOrCreate(
                ['codigo' => $codigoGenerado], // Buscar por código
                [
                    'descripcion' => $validated['descripcion'] ?? null,
                    'macroscopico' => $validated['macroscopico'] ?? null,
                ]
            );
        }
        // capturador de errores para no crashear la aplicacion y lanzar mensaje de error para conocer su causa
        catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error al crear la lista: ' . $e->getMessage());
        }

        // redireccion de la pagina a la lista de biopsias con un mensaje de exito y vista de creacion
        return redirect()->route('listas.biopsias.index')->with('success', 'Biopsia creada exitosamente.');
    }

    // Vista de edicion de una lista de biopsia
    public function edit(ListaBiopsia $listaBiopsia)
    {
        // Pasar la lista de biopsia a la vista
        return view('listas.biopsias.edit', compact('listaBiopsia'));
    }

    // Actualizacion de una lista de biopsia
    public function update(Request $request, ListaBiopsia $listaBiopsia)
    {
        // validar la informacion obtenida como datos del tipo correcto
        $validated = $request->validate([
            'descripcion' => 'nullable|string',
            'macroscopico' => 'nullable|string',
        ]);

        try {
            // actualizar la lista de biopsia en la base de datos usando eloquent
            $listaBiopsia->update($validated);
            return redirect()->route('listas.biopsias.index')->with('success', 'Biopsia actualizada exitosamente.');
        }
        // capturador de errores para no crashear la aplicacion y lanzar mensaje de error para conocer su causa
        catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error al actualizar la lista: ' . $e->getMessage());
        }

        // redireccion de ruta hacia la pagina principal de las listas conforme a su actualizacion exitosa
        return redirect()->route('listas.biopsias.index')->with('success', 'Biopsia actualizada exitosamente.');
    }

    // eliminacion de lista de biopsia, usando el modelado eloquent de lista de biopsia para la sincronizacion de dato
    public function destroy(ListaBiopsia $listaBiopsia)
    {
        // eliminacion de la lista de biopsia en la base de datos usando eloquent
        try {
            $listaBiopsia->delete();
            return redirect()->route('listas.biopsias.index')
                ->with('success', 'Biopsia eliminada exitosamente.');
        }
        // excepcion de error y muestreo de causa
        catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar la lista: ' . $e->getMessage());
        }
    }
}
