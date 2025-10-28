<?php

namespace App\Http\Controllers;

use App\Models\ListaCitologia;
use Illuminate\Http\Request;

class ListaCitologiaController extends Controller
{
    // Listar citologías
    public function index()
    {
        // Obtener todas las citologías ordenadas por código
        $listaCitologia = ListaCitologia::orderBy('codigo')
            ->paginate(10);
        // Pasar la lista de citologías a la vista
        return view('listas.citologias.index', compact('listaCitologia'));
    }

    // Mostrar formulario para crear citología
    public function create()
    {
        // Generar un nuevo código para la citología
        $codigoGenerado = ListaCitologia::generarCodigoLista();
        // Pasar el código generado a la vista
        return view('listas.citologias.create', compact('codigoGenerado'));
    }

    // Creacion de una lista de citologia
    public function store(Request $request)
    {
        // obtener codigo generado en la ruta create
        $codigoGenerado = ListaCitologia::generarCodigoLista();

        // validar la informacion obtenida como datos del tipo correcto
        $validated = $request->validate([
            'descripcion' => 'nullable|string',
            'diagnostico' => 'nullable|string',

        ]);

        // capturado de errores para no crashear la aplicacion
        try {
            // Crear la lista de citologia en insertarla en la base de datos usando eloquent
            ListaCitologia::create([
                'codigo' => $codigoGenerado,
                'descripcion' => $validated['descripcion'] ?? null,
                'diagnostico' => $validated['diagnostico'] ?? null,
            ]);
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error al crear la lista: ' . $e->getMessage());
        }
        // redireccionar a la ruta index con un mensaje de exito
        return redirect()->route('listas.citologias.index')->with('success', 'Lista creada exitosamente.');
    }


    // Vista de edicion de una lista de citologia
    public function edit(ListaCitologia $listaCitologia)
    {
        // Pasar la lista de citologia a la vista
        return view('listas.citologias.edit', compact('listaCitologia'));
    }

    // Actualizacion de una lista de citologia
    public function update(Request $request, ListaCitologia $listaCitologia)
    {
        // validar la informacion obtenida como datos del tipo correcto
        $validated = $request->validate([
            'descripcion' => 'nullable|string',
            'diagnostico' => 'nullable|string',
        ]);

        try {
            // actualizar la lista de biopsia en la base de datos usando eloquent
            $listaCitologia->update($validated);
            return redirect()->route('listas.citologias.index')->with('success', 'Citología actualizada exitosamente.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error al actualizar la citología: ' . $e->getMessage());
        }
    }

    // eliminacion de lista de citologia, usando el modelado eloquent de lista de citologia para la sincronizacion de dato
    public function destroy(ListaCitologia $listaCitologia)
    {
        // eliminacion de la lista de citologia en la base de datos usando eloquent
        try {
            $listaCitologia->delete();
            return redirect()->route('listas.citologias.index')
                ->with('success', 'Citología eliminada exitosamente.');
        }
        // excepcion de error y muestreo de causa
        catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar la citología: ' . $e->getMessage());
        }
    }
}
