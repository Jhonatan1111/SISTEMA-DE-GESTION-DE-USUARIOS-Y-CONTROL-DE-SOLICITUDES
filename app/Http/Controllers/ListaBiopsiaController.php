<?php

namespace App\Http\Controllers;

use App\Models\ListaBiopsia;
use Illuminate\Http\Request;

class ListaBiopsiaController extends Controller
{
    // vistas de las listas de biopsias
    public function index()
    {
        //
        $listaBiopsia = ListaBiopsia::orderBy('codigo')
            ->paginate(10);
        return view('listas.biopsias.index', compact('listaBiopsia'));
    }

    //capturador de datos ingresados y enviados para la creacion de una lista de biopsia
    public function create()
    {
        //generacion de codigo para la lista de biopsia
        $codigoGenerado = ListaBiopsia::generarCodigoLista();
        // redireccion de la pagina hacia la vista de creacion de la lista de biopsia con el codigo generado previamente
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
            // Crear la lista de biopsia en insertarla en la base de datos usando eloquent
            ListaBiopsia::create([
                'codigo' => $codigoGenerado,
                'descripcion' => $validated['descripcion'] ?? null,
                'macroscopico' => $validated['macroscopico'] ?? null,
            ]);
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

    // capturador de datos para la obtencion de lo escrito, tambien se toma de parametro la lista con eloquent usando el modelado
    public function edit(ListaBiopsia $listaBiopsia)
    {
        // redireccion de la pagina hacia el controlador del metodo update para la actualizacion de la lista de biopsia
        return view('listas.biopsias.edit', compact('listaBiopsia'));
    }

    // capturador de datos de la ruta de edicion para la actualizacion de la lista de biopsia
    public function update(Request $request, ListaBiopsia $listaBiopsia)
    {
        // validar la informacion obtenida como datos del tipo correcto
        $validated = $request->validate([
            'descripcion' => 'nullable|string',
            'macroscopico' => 'nullable|string',
        ]);

        try {
            // actualizar la lista de biopsia en la base de datos usando eloquent
            $listaBiopsia->update([
                'descripcion' => $validated['descripcion'] ?? null,
                'macroscopico' => $validated['macroscopico'] ?? null,
            ]);
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
        }
        // excepcion de error y muestreo de causa
        catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar la lista: ' . $e->getMessage());
        }
        // redireccion de el proceso hacia la vista principal con un mensaje exitoso
        return redirect()->route('listas.biopsias.index')->with('success', 'Biopsia eliminada exitosamente.');
    }

    // obtencion de la lista de biopsia por su codigo, usando el modelado eloquent de lista de biopsia para la sincronizacion de dato
    public function getByCodigo($codigo)
    {
        // script para convertir el codigo a mayusculas para la busqueda en la base de datos y evitar errores de busqueda
        try {
            $listaBiopsia = ListaBiopsia::where('codigo', strtoupper($codigo))->firstOrFail();
            // redireccion de vista por causa de no encontrarse la lista de biopsia
            if (!$listaBiopsia) {
                return redirect()->route('listas.biopsias.index')->with('error', 'Biopsia no encontrada.');
            }
        }
        // capturador de errores para no crashear la aplicacion y lanzar mensaje de error para conocer su causa
        catch (\Exception $e) {
            return redirect()->route('listas.biopsias.index')->with('error', 'Error al obtener la lista: ' . $e->getMessage());
        }
    }

    public function getList(ListaBiopsia $listaBiopsia)
    {
        // obtencion de la lista de biopsia por su id, usando el modelado eloquent de lista de biopsia para la sincronizacion de dato
        $listaBiopsia = ListaBiopsia::findOrFail($listaBiopsia->id);
        // redireccion de vista por causa de no encontrarse la lista de biopsia
        if (!$listaBiopsia) {
            return redirect()->route('listas.biopsias.index')->with('error', 'Biopsia no encontrada.');
        }
    }
}
