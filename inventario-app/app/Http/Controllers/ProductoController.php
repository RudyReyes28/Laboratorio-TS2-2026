<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $productos = Producto::with('categoria')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('productos.index', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $categorias = Categoria::activas()->get();
        return view('productos.create', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'codigo' => 'required|unique:productos,codigo|max:50',
            'nombre' => 'required|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categoria_id' => 'required|exists:categorias,id',
            'activo' => 'boolean',
        ]);

        

        //Crear el producto
        Producto::create($validated);

        //Redireccionar al index con mensaje de éxito
        return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Producto $producto)
    {
        //
        return view('productos.show', compact('producto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $producto)
    {
        //
        $categorias = Categoria::activas()->get();
        return view('productos.edit', compact('producto', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $producto)
    {
        //
        $validated = $request->validate([
            'codigo' => 'required|unique:productos,codigo,' . $producto->id . '|max:50',
            'nombre' => 'required|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categoria_id' => 'required|exists:categorias,id',
            'activo' => 'boolean',
        ]);

        //Actualizar el producto
        $producto->update($validated);
        //Redireccionar al index con mensaje de éxito
        return redirect()->route('productos.index')->with('success', 'Producto actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
        //
        $producto->delete();
        return redirect()->route('productos.index')->with('success', 'Producto eliminado exitosamente.');
    }
}
