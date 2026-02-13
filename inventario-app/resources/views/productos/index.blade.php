@extends('layouts.app')

@section('title', 'Lista de Productos')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Productos</h1>
    <a href="{{ route('productos.create') }}" class="btn btn-primary">
        Nuevo Producto
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($productos as $producto)
                        <tr>
                            <td>{{ $producto->codigo }}</td>
                            <td>{{ $producto->nombre }}</td>
                            <td>
                                <span class="badge bg-info">
                                    {{ $producto->categoria->nombre ?? 'Sin categoría' }}
                                </span>
                            </td>
                            <td>${{ number_format($producto->precio, 2) }}</td>
                            <td>
                                <span class="badge {{ $producto->stock < 10 ? 'bg-danger' : 'bg-success' }}">
                                    {{ $producto->stock }}
                                </span>
                            </td>
                            <td>
                                @if($producto->activo)
                                    <span class="badge bg-success">Activo</span>
                                @else
                                    <span class="badge bg-secondary">Inactivo</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('productos.show', $producto) }}" 
                                       class="btn btn-sm btn-info">
                                        Ver
                                    </a>
                                    <a href="{{ route('productos.edit', $producto) }}" 
                                       class="btn btn-sm btn-warning">
                                        Editar
                                    </a>
                                    <form action="{{ route('productos.destroy', $producto) }}" 
                                          method="POST" 
                                          style="display: inline;"
                                          onsubmit="return confirm('¿Estás seguro de eliminar este producto?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No hay productos registrados</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <div class="d-flex justify-content-center">
            {{ $productos->links() }}
        </div>
    </div>
</div>
@endsection
