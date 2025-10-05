<?php

namespace App\Http\Controllers;

use App\Models\ListaBiopsia;
use Illuminate\Http\Request;

class ListaBiopsiaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $listaBiopsia = ListaBiopsia::orderBy('codigo')
            ->paginate(10);
        return view('listas.biopsias.index', compact('listaBiopsia'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $codigoGenerado = ListaBiopsia::generarCodigoLista();
        return view('listas.biopsias.create', compact('codigoGenerado'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $codigoGenerado = ListaBiopsia::generarCodigoLista();

        $validated = $request->validate([
            'diagnostico' => 'required|string',
            'macroscopico' => 'nullable|string',
            'microscopico' => 'nullable|string',
            'descripcion' => 'nullable|string',
        ]);

        try {
            ListaBiopsia::create([
                'codigo' => $codigoGenerado,
                'diagnostico' => $validated['diagnostico'],
                'macroscopico' => $validated['macroscopico'] ?? null,
                'microscopico' => $validated['microscopico'] ?? null,
                'descripcion' => $validated['descripcion'] ?? null,
            ]);

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error al crear la lista: ' . $e->getMessage());
        }

        return redirect()->route('listas.biopsias.index')->with('success', 'Biopsia creada exitosamente.');
    }

    public function edit(ListaBiopsia $listaBiopsia)
    {
        //
        return view('listas.biopsias.edit', compact('listaBiopsia'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ListaBiopsia $listaBiopsia)
    {
        //
        $request->validate([
            'descripcion' => 'required|string',
            'diagnostico' => 'required|string',
            'macroscopico' => 'required|string',
            'microscopico' => 'required|string',
        ]);

        $listaBiopsia->update($request->only([
            'descripcion',
            'diagnostico', 
            'macroscopico',
            'microscopico'
        ]));

        return redirect()->route('listas.biopsias.index')->with('success', 'Biopsia actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ListaBiopsia $listaBiopsia)
    {
        //
        $listaBiopsia->delete();
        return redirect()->route('listas.biopsias.index')->with('success', 'Biopsia eliminada exitosamente.');
    }

    public function getByCodigo($codigo)
    {
        $listaBiopsia = ListaBiopsia::where('codigo', strtoupper($codigo))->firstOrFail();
        if (!$listaBiopsia) {
            return redirect()->route('listas.biopsias.index')->with('error', 'Biopsia no encontrada.');
        }
    }
    public function getCodigos()
    {
        $codigos = ListaBiopsia::select('codigo', 'descripcion')
            ->orderBy('codigo')
            ->get();
        return response()->json($codigos);
    }
}
