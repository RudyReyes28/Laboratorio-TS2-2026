@extends('layouts.app')

@section('title', 'Editar Producto')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h2>Editar Producto: {{ $producto->nombre }}</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('productos.update', $producto) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="codigo" class="form-label">Código *</label>
                        <input type="text" 
                               class="form-control @error('codigo') is-invalid @enderror" 
                               id="codigo" 
                               name="codigo" 
                               value="{{ old('codigo', $producto->codigo) }}"
                               required>
                        @error('codigo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre *</label>
                        <input type="text" 
                               class="form-control @error('nombre') is-invalid @enderror" 
                               id="nombre" 
                               name="nombre" 
                               value="{{ old('nombre', $producto->nombre) }}"
                               required>
                        @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                                  id="descripcion" 
                                  name="descripcion" 
                                  rows="3">{{ old('descripcion', $producto->descripcion) }}</textarea>
                        @error('descripcion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="precio" class="form-label">Precio *</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" 
                                       class="form-control @error('precio') is-invalid @enderror" 
                                       id="precio" 
                                       name="precio" 
                                       step="0.01"
                                       value="{{ old('precio', $producto->precio) }}"
                                       required>
                                @error('precio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="stock" class="form-label">Stock *</label>
                            <input type="number" 
                                   class="form-control @error('stock') is-invalid @enderror" 
                                   id="stock" 
                                   name="stock" 
                                   value="{{ old('stock', $producto->stock) }}"
                                   required>
                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="categoria_id" class="form-label">Categoría *</label>
                        <select class="form-select @error('categoria_id') is-invalid @enderror" 
                                id="categoria_id" 
                                name="categoria_id"
                                required>
                            <option value="">Seleccione una categoría</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}" 
                                        {{ old('categoria_id', $producto->categoria_id) == $categoria->id ? 'selected' : '' }}>
                                    {{ $categoria->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('categoria_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" 
                               class="form-check-input" 
                               id="activo" 
                               name="activo" 
                               value="1"
                               {{ old('activo', $producto->activo) ? 'checked' : '' }}>
                        <label class="form-check-label" for="activo">
                            Producto activo
                        </label>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('productos.index') }}" class="btn btn-secondary">
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            Actualizar Producto
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
