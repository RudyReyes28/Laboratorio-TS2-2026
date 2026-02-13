<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//Rutas adicionales para productos y categorias

//Ver productos por categoria
Route::get('/categorias/{categoria}/productos', [CategoriaController::class, 'productos'])->name('categorias.productos');

// Búsqueda de productos
Route::get('/productos/buscar', [ProductoController::class, 'buscar'])
     ->name('productos.buscar');

// API endpoint para stock
Route::get('/api/productos/{producto}/stock', [ProductoController::class, 'checkStock'])
     ->name('productos.stock');


//Rutas de recursos para productos y categorias
Route::resource('productos', ProductoController::class);
Route::resource('categorias', CategoriaController::class);