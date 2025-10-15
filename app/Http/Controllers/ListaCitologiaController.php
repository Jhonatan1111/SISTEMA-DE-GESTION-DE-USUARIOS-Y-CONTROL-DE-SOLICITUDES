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

        $codigoGenerado = ListaCitologia::generarCodigoLista();
        // Cambiar la validación para permitir actualización de registros existentes
        $validated = $request->validate([
            'diagnostico' => 'required|string',
            'macroscopico' => 'nullable|string',
            'microscopico' => 'nullable|string'
        ]);

        try {
            $citologia = ListaCitologia::create(
                [
                    'codigo' => $codigoGenerado,
                    'diagnostico' => $validated['diagnostico'],
                    'macroscopico' => $validated['macroscopico'] ?? null,
                    'microscopico' => $validated['microscopico'] ?? null,
                ]
                // [
                //     'diagnostico' => $validated['diagnostico'],
                //     'macroscopico' => $validated['macroscopico'] ?? null,
                //     'microscopico' => $validated['microscopico'] ?? null,
                // ]
            );

            if ($citologia->wasRecentlyCreated) {
                $mensaje = 'Citología creada exitosamente.';
            } else {
                $mensaje = 'Citología actualizada exitosamente (refrescada con nuevos datos).';
            }
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error al procesar la citología: ' . $e->getMessage());
        }
        return redirect()->route('listas.citologias.index')->with('success', $mensaje);
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
        return view('listas.citologias.edit', compact('listaCitologia'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ListaCitologia $listaCitologia)
    {
        $request->validate([
            'diagnostico' => 'required|string',
            'macroscopico' => 'nullable|string',
            'microscopico' => 'nullable|string'
        ]);

        $listaCitologia->update($request->only(
            'diagnostico',
            'macroscopico',
            'microscopico'
        ));
        return redirect()->route('listas.citologias.index')->with('success', 'Citología actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ListaCitologia $listaCitologia)
    {
        //
    }
    public function getCodigos()
    {
        $codigos = ListaCitologia::select('codigo', 'diagnostico')
            ->orderBy('codigo')
            ->get();
        return response()->json($codigos);
    }
}
