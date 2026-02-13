<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $categorias = Categoria::withCount('productos')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('categorias.index', compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('categorias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'nombre' => 'required|unique:categorias,nombre|max:255',
            'descripcion' => 'nullable|string',
            'activo' => 'boolean',
        ]);
        //Crear la categoria
        Categoria::create($validated);
        //Redireccionar al index con mensaje de éxito
        return redirect()->route('categorias.index')->with('success', 'Categoria creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Categoria $categoria)
    {
        //
        return view('categorias.show', compact('categoria'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categoria $categoria)
    {
        //
        return view('categorias.edit', compact('categoria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categoria $categoria)
    {
        $validated = $request->validate([
            'nombre' => 'required|unique:categorias,nombre,' . $categoria->id . '|max:255',
            'descripcion' => 'nullable|string',
            'activo' => 'boolean',
        ]);
        //Actualizar la categoria
        $categoria->update($validated);
        //Redireccionar al index con mensaje de éxito
        return redirect()->route('categorias.index')->with('success', 'Categoria actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categoria $categoria)
    {
        //
        //Verificar si la categoria tiene productos asociados
        if ($categoria->productos()->count() > 0) {
            return redirect()->route('categorias.index')->with('error', 'No se puede eliminar la categoria porque tiene productos asociados.');
        }
        //Eliminar la categoria
        $categoria->delete();
        return redirect()->route('categorias.index')->with('success', 'Categoria eliminada exitosamente.');
    }
}
