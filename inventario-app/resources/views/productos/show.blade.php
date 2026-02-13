@extends('layouts.app')

@section('title', 'Detalle del Producto')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h2>Detalle del Producto: {{ $producto->nombre }}</h2>
            </div>
            <div class="card-body">
                <p><strong>Código:</strong> {{ $producto->codigo }}</p>
                <p><strong>Nombre:</strong> {{ $producto->nombre }}</p>
                <p><strong>Descripción:</strong> {{ $producto->descripcion ?? 'N/A' }}</p>
                <p><strong>Precio:</strong> ${{ number_format($producto->precio, 2) }}</p>
                <p><strong>Categoría:</strong> {{ $producto->categoria ? $producto->categoria->nombre : 'Sin categoría' }}</p>
                <p><strong>Stock:</strong> {{ $producto->stock }}</p>
                <p><strong>Estado:</strong> {{ $producto->activo ? 'Activo' : 'Inactivo' }}</p>
                <a href="{{ route('productos.edit', $producto) }}" class="btn btn-primary">Editar</a>
                <form action="{{ route('productos.destroy', $producto) }}" method="POST" class="d-inline-block" onsubmit="return confirm('¿Estás seguro de eliminar este producto?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
                <a href="{{ route('productos.index') }}" class="btn btn-secondary">Volver al listado</a>
            </div>
        </div>
    </div>
</div>
@endsection