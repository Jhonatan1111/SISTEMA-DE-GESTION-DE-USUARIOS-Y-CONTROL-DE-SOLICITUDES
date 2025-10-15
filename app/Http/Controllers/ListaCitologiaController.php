<?php

namespace App\Http\Controllers;

use App\Models\ListaCitologia;
use Illuminate\Http\Request;

class ListaCitologiaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listaCitologia = ListaCitologia::orderBy('codigo')
            ->paginate(10);
        return view('listas.citologias.index', compact('listaCitologia'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $codigoGenerado = ListaCitologia::generarCodigoLista();
        return view('listas.citologias.create', compact('codigoGenerado'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Cambiar la validación para permitir actualización de registros existentes
        $validated = $request->validate([
            'codigo' => 'required|string|max:255',
            'diagnostico' => 'required|string',
            'macroscopico' => 'nullable|string',
            'microscopico' => 'nullable|string'
        ]);

        try {
            // Usar updateOrCreate para evitar duplicados
            // Si existe un registro con el mismo código, lo actualiza
            // Si no existe, crea uno nuevo
            $citologia = ListaCitologia::updateOrCreate(
                ['codigo' => $validated['codigo']], // Condición de búsqueda
                [
                    'diagnostico' => $validated['diagnostico'],
                    'macroscopico' => $validated['macroscopico'] ?? null,
                    'microscopico' => $validated['microscopico'] ?? null,
                ]
            );

            if ($citologia->wasRecentlyCreated) {
                $mensaje = 'Citología creada exitosamente.';
            } else {
                $mensaje = 'Citología actualizada exitosamente (refrescada con nuevos datos).';
            }

            return redirect()->route('listas.citologias.index')->with('success', $mensaje);
            
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error al procesar la citología: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ListaCitologia $listaCitologia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ListaCitologia $listaCitologia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ListaCitologia $listaCitologia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ListaCitologia $listaCitologia)
    {
        //
    }
}
