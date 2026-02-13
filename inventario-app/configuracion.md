# Implementación de CRUD en Laravel
## Arquitectura MVC y Patrones en N-Capas

---

## Tabla de Contenidos
1. [Introducción a Laravel y Arquitectura MVC](#introducción)
2. [Preparación del Entorno](#preparación-del-entorno)
3. [Creación del Proyecto Laravel](#creación-del-proyecto)
4. [Configuración de Base de Datos MySQL](#configuración-de-base-de-datos)
5. [Migraciones en Laravel](#migraciones)
6. [Seeders y Factories](#seeders-y-factories)
7. [Modelos y ORM Eloquent](#modelos-y-eloquent)
8. [Controladores](#controladores)
9. [Rutas](#rutas)
10. [Vistas](#vistas)
11. [CRUD Completo de Inventarios](#crud-completo)
12. [Arquitectura N-Capas en Laravel](#arquitectura-n-capas)

---

## 1. Introducción a Laravel y Arquitectura MVC {#introducción}

### ¿Qué es Laravel?
Laravel es un framework de PHP que sigue el patrón arquitectónico **MVC (Model-View-Controller)**, diseñado para facilitar el desarrollo de aplicaciones web robustas y escalables.

### Patrón MVC en Laravel

```
┌─────────────────────────────────────────┐
│          USUARIO (Navegador)            │
└────────────────┬────────────────────────┘
                 │
                 ▼
         ┌───────────────┐
         │     RUTAS     │ (routes/web.php)
         └───────┬───────┘
                 │
                 ▼
         ┌───────────────┐
         │  CONTROLLER   │ (Control de flujo)
         └───────┬───────┘
                 │
        ┌────────┴────────┐
        ▼                 ▼
   ┌─────────┐      ┌─────────┐
   │  MODEL  │◄────►│  VIEW   │
   └─────────┘      └─────────┘
   (Datos/BD)       (Interfaz)
```

**Componentes:**
- **Model (Modelo)**: Maneja la lógica de datos y la comunicación con la base de datos
- **View (Vista)**: Presenta la información al usuario (HTML, Blade templates)
- **Controller (Controlador)**: Coordina el flujo entre modelo y vista

---

## 2. Preparación del Entorno {#preparación-del-entorno}

### Requisitos previos

1. **PHP >= 8.1**
   ```bash
   php -v
   ```

2. **Composer** (Gestor de dependencias de PHP)
   - Descargar de: https://getcomposer.org/
   ```bash
   composer --version
   ```

3. **MySQL instalado localmente**
   ```bash
   mysql --version
   ```

4. **Editor de código** (VSCode recomendado)

### Verificación de instalación

```bash
# Verificar PHP
php -v

# Verificar Composer
composer -V

# Verificar MySQL
mysql -u root -p
```

---

## 3. Creación del Proyecto Laravel {#creación-del-proyecto}

### Paso 1: Crear el proyecto

```bash
# Navegar a la carpeta donde quieres crear el proyecto
cd C:\xampp\htdocs  # En Windows
# o
cd ~/Sites  # En Mac/Linux

# Crear proyecto Laravel
composer create-project laravel/laravel inventario-app

# Entrar al proyecto
cd inventario-app
```

### Paso 2: Estructura del proyecto

```
inventario-app/
├── app/
│   ├── Http/
│   │   └── Controllers/     # Controladores
│   ├── Models/              # Modelos Eloquent
│   └── ...
├── database/
│   ├── migrations/          # Migraciones
│   ├── seeders/            # Semillas de datos
│   └── factories/          # Factories para datos de prueba
├── public/                 # Punto de entrada público
├── resources/
│   └── views/              # Vistas Blade
├── routes/
│   └── web.php            # Rutas web
├── .env                   # Configuración del entorno
└── artisan               # CLI de Laravel
```

### Paso 3: Iniciar el servidor de desarrollo

```bash
php artisan serve
```

Acceder a: http://localhost:8000

---

## 4. Configuración de Base de Datos MySQL {#configuración-de-base-de-datos}

### Paso 1: Crear la base de datos

```bash
# Conectarse a MySQL
mysql -u root -p

# Una vez dentro de MySQL
CREATE DATABASE inventario_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

# Verificar que se creó
SHOW DATABASES;

# Salir de MySQL
EXIT;
```

### Paso 2: Configurar el archivo .env

Editar el archivo `.env` en la raíz del proyecto:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=inventario_db
DB_USERNAME=root
DB_PASSWORD=tu_contraseña
```

### Paso 3: Probar la conexión

```bash
php artisan migrate:status
```

Si la conexión es exitosa, no habrá errores.

---

## 5. Migraciones en Laravel {#migraciones}

### ¿Qué son las migraciones?

Las migraciones son como **control de versiones para tu base de datos**. Permiten definir y modificar la estructura de las tablas usando código PHP en lugar de SQL directo.

### Ventajas:
- Versionamiento de la estructura de BD
- Trabajo en equipo facilitado
- Reversibilidad (rollback)
- Portabilidad entre entornos

### Crear migración para tabla productos

```bash
php artisan make:migration create_productos_table
```

Este comando crea un archivo en `database/migrations/` con un timestamp.

### Editar la migración

Archivo: `database/migrations/2025_xx_xx_create_productos_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Este método se ejecuta cuando hacemos php artisan migrate
     */
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id(); // Crea campo id auto-incremental
            $table->string('codigo', 50)->unique(); // Código único
            $table->string('nombre', 255);
            $table->text('descripcion')->nullable(); // Puede ser NULL
            $table->decimal('precio', 10, 2); // 10 dígitos, 2 decimales
            $table->integer('stock')->default(0);
            $table->string('categoria', 100);
            $table->boolean('activo')->default(true);
            $table->timestamps(); // Crea created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     * Este método se ejecuta cuando hacemos php artisan migrate:rollback
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
```

### Tipos de datos comunes en migraciones

```php
// Numéricos
$table->integer('cantidad');
$table->bigInteger('id_grande');
$table->decimal('precio', 8, 2);
$table->float('peso');
$table->double('coordenada');

// Textos
$table->string('nombre', 255); // VARCHAR
$table->text('descripcion'); // TEXT
$table->longText('contenido'); // LONGTEXT
$table->char('codigo', 10); // CHAR fijo

// Fechas y horas
$table->date('fecha_nacimiento');
$table->time('hora_apertura');
$table->datetime('fecha_hora');
$table->timestamp('registro');
$table->timestamps(); // created_at y updated_at

// Booleanos
$table->boolean('activo');

// Especiales
$table->json('configuracion');
$table->enum('estado', ['pendiente', 'aprobado', 'rechazado']);
```

### Crear migración para tabla categorías

```bash
php artisan make:migration create_categorias_table
```

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100)->unique();
            $table->text('descripcion')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categorias');
    }
};
```

### Modificar migración de productos para agregar relación

```bash
php artisan make:migration add_categoria_id_to_productos_table
```

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            // Eliminar columna categoria antigua
            $table->dropColumn('categoria');
            
            // Agregar foreign key
            $table->foreignId('categoria_id')
                  ->nullable()
                  ->constrained('categorias')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->dropForeign(['categoria_id']);
            $table->dropColumn('categoria_id');
            $table->string('categoria', 100)->after('stock');
        });
    }
};
```

### Comandos principales de migraciones

```bash
# Ejecutar todas las migraciones pendientes
php artisan migrate

# Ver el estado de las migraciones
php artisan migrate:status

# Revertir la última migración
php artisan migrate:rollback

# Revertir todas las migraciones
php artisan migrate:reset

# Revertir y volver a ejecutar todas las migraciones
php artisan migrate:refresh

# Eliminar todas las tablas y ejecutar migraciones (CUIDADO: borra datos)
php artisan migrate:fresh

# Ejecutar migraciones con seeders
php artisan migrate --seed
```

---

## 6. Seeders y Factories {#seeders-y-factories}

### ¿Qué son los Seeders?

Los seeders permiten **poblar la base de datos con datos de prueba** de manera automática.

### Crear Seeder para Categorías

```bash
php artisan make:seeder CategoriaSeeder
```

Archivo: `database/seeders/CategoriaSeeder.php`

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            [
                'nombre' => 'Electrónica',
                'descripcion' => 'Dispositivos y componentes electrónicos',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Ropa',
                'descripcion' => 'Prendas de vestir y accesorios',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Alimentos',
                'descripcion' => 'Productos alimenticios',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Libros',
                'descripcion' => 'Libros físicos y digitales',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('categorias')->insert($categorias);
    }
}
```

### Crear Factory para Productos

```bash
php artisan make:factory ProductoFactory
```

Archivo: `database/factories/ProductoFactory.php`

```php
<?php

namespace Database\Factories;

use App\Models\Categoria;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'codigo' => strtoupper($this->faker->unique()->bothify('PROD-####-???')),
            'nombre' => $this->faker->words(3, true),
            'descripcion' => $this->faker->sentence(10),
            'precio' => $this->faker->randomFloat(2, 10, 1000),
            'stock' => $this->faker->numberBetween(0, 100),
            'categoria_id' => Categoria::inRandomOrder()->first()->id,
            'activo' => $this->faker->boolean(90), // 90% activos
        ];
    }
}
```

### Crear Seeder para Productos

```bash
php artisan make:seeder ProductoSeeder
```

```php
<?php

namespace Database\Seeders;

use App\Models\Producto;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        // Crear 50 productos usando el factory
        Producto::factory()->count(50)->create();
    }
}
```

### Configurar DatabaseSeeder principal

Archivo: `database/seeders/DatabaseSeeder.php`

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Llamar a los seeders en orden
        $this->call([
            CategoriaSeeder::class,
            ProductoSeeder::class,
        ]);
    }
}
```

### Ejecutar los Seeders

```bash
# Ejecutar todos los seeders
php artisan db:seed

# Ejecutar un seeder específico
php artisan db:seed --class=CategoriaSeeder

# Refrescar BD y ejecutar seeders
php artisan migrate:fresh --seed
```

---

## 7. Modelos y ORM Eloquent {#modelos-y-eloquent}

### ¿Qué es Eloquent?

**Eloquent** es el ORM (Object-Relational Mapping) de Laravel que permite interactuar con la base de datos usando objetos PHP en lugar de consultas SQL.

### Ventajas del ORM:
- Código más legible y mantenible
- Protección contra SQL Injection
- Relaciones entre modelos simplificadas
- Abstracción de la base de datos

### Crear modelo Categoria

```bash
php artisan make:model Categoria
```

Archivo: `app/Models/Categoria.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    // Nombre de la tabla (opcional si sigue convención)
    protected $table = 'categorias';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'descripcion',
        'activo',
    ];

    // Campos que se castean automáticamente
    protected $casts = [
        'activo' => 'boolean',
    ];

    /**
     * Relación: Una categoría tiene muchos productos
     */
    public function productos()
    {
        return $this->hasMany(Producto::class, 'categoria_id');
    }

    /**
     * Scope para obtener solo categorías activas
     */
    public function scopeActivas($query)
    {
        return $query->where('activo', true);
    }
}
```

### Crear modelo Producto

```bash
php artisan make:model Producto
```

Archivo: `app/Models/Producto.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';

    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'categoria_id',
        'activo',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'stock' => 'integer',
        'activo' => 'boolean',
    ];

    /**
     * Relación: Un producto pertenece a una categoría
     */
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    /**
     * Scope para productos activos
     */
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    /**
     * Scope para productos con stock bajo
     */
    public function scopeStockBajo($query, $limite = 10)
    {
        return $query->where('stock', '<=', $limite);
    }

    /**
     * Accessor: Formatear precio
     */
    public function getPrecioFormateadoAttribute()
    {
        return '$' . number_format($this->precio, 2);
    }

    /**
     * Mutator: Convertir nombre a mayúsculas al guardar
     */
    public function setNombreAttribute($value)
    {
        $this->attributes['nombre'] = ucwords(strtolower($value));
    }
}
```

### Ejemplos de uso de Eloquent

```php
// CREAR un producto
$producto = Producto::create([
    'codigo' => 'PROD-001',
    'nombre' => 'Laptop Dell',
    'descripcion' => 'Laptop para desarrollo',
    'precio' => 899.99,
    'stock' => 15,
    'categoria_id' => 1,
]);

// LEER todos los productos
$productos = Producto::all();

// LEER un producto por ID
$producto = Producto::find(1);

// LEER con condiciones
$productos = Producto::where('activo', true)
                     ->where('stock', '>', 0)
                     ->get();

// ACTUALIZAR un producto
$producto = Producto::find(1);
$producto->stock = 20;
$producto->save();

// O con update directo
Producto::where('id', 1)->update(['stock' => 20]);

// ELIMINAR un producto
$producto = Producto::find(1);
$producto->delete();

// O eliminación directa
Producto::destroy(1);

// USAR RELACIONES
$producto = Producto::with('categoria')->find(1);
echo $producto->categoria->nombre;

// Obtener productos de una categoría
$categoria = Categoria::find(1);
$productos = $categoria->productos;

// USAR SCOPES
$activos = Producto::activos()->get();
$stockBajo = Producto::stockBajo(5)->get();
```

---

## 8. Controladores {#controladores}

### ¿Qué son los Controladores?

Los controladores **manejan la lógica de negocio** y actúan como intermediarios entre las rutas, modelos y vistas.

### Crear Controlador de Recursos

```bash
# Crear controlador con métodos CRUD predefinidos
php artisan make:controller ProductoController --resource
```

Archivo: `app/Http/Controllers/ProductoController.php`

```php
<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     * Mostrar lista de productos
     */
    public function index()
    {
        // Obtener todos los productos con su categoría
        $productos = Producto::with('categoria')
                             ->orderBy('created_at', 'desc')
                             ->paginate(10);
        
        return view('productos.index', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     * Mostrar formulario de creación
     */
    public function create()
    {
        $categorias = Categoria::activas()->get();
        return view('productos.create', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     * Guardar nuevo producto
     */
    public function store(Request $request)
    {
        // Validar los datos
        $validated = $request->validate([
            'codigo' => 'required|string|max:50|unique:productos',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categoria_id' => 'required|exists:categorias,id',
            'activo' => 'boolean',
        ]);

        // Crear el producto
        Producto::create($validated);

        // Redireccionar con mensaje de éxito
        return redirect()->route('productos.index')
                         ->with('success', 'Producto creado exitosamente');
    }

    /**
     * Display the specified resource.
     * Mostrar un producto específico
     */
    public function show(Producto $producto)
    {
        // Laravel automáticamente busca el producto por ID (Route Model Binding)
        return view('productos.show', compact('producto'));
    }

    /**
     * Show the form for editing the specified resource.
     * Mostrar formulario de edición
     */
    public function edit(Producto $producto)
    {
        $categorias = Categoria::activas()->get();
        return view('productos.edit', compact('producto', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     * Actualizar producto
     */
    public function update(Request $request, Producto $producto)
    {
        $validated = $request->validate([
            'codigo' => 'required|string|max:50|unique:productos,codigo,' . $producto->id,
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categoria_id' => 'required|exists:categorias,id',
            'activo' => 'boolean',
        ]);

        $producto->update($validated);

        return redirect()->route('productos.index')
                         ->with('success', 'Producto actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     * Eliminar producto
     */
    public function destroy(Producto $producto)
    {
        $producto->delete();

        return redirect()->route('productos.index')
                         ->with('success', 'Producto eliminado exitosamente');
    }
}
```

### Crear Controlador para Categorías

```bash
php artisan make:controller CategoriaController --resource
```

Archivo: `app/Http/Controllers/CategoriaController.php`

```php
<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::withCount('productos')
                               ->orderBy('nombre')
                               ->paginate(10);
        
        return view('categorias.index', compact('categorias'));
    }

    public function create()
    {
        return view('categorias.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100|unique:categorias',
            'descripcion' => 'nullable|string',
            'activo' => 'boolean',
        ]);

        Categoria::create($validated);

        return redirect()->route('categorias.index')
                         ->with('success', 'Categoría creada exitosamente');
    }

    public function show(Categoria $categoria)
    {
        $categoria->load('productos');
        return view('categorias.show', compact('categoria'));
    }

    public function edit(Categoria $categoria)
    {
        return view('categorias.edit', compact('categoria'));
    }

    public function update(Request $request, Categoria $categoria)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100|unique:categorias,nombre,' . $categoria->id,
            'descripcion' => 'nullable|string',
            'activo' => 'boolean',
        ]);

        $categoria->update($validated);

        return redirect()->route('categorias.index')
                         ->with('success', 'Categoría actualizada exitosamente');
    }

    public function destroy(Categoria $categoria)
    {
        // Verificar si tiene productos asociados
        if ($categoria->productos()->count() > 0) {
            return redirect()->route('categorias.index')
                             ->with('error', 'No se puede eliminar una categoría con productos asociados');
        }

        $categoria->delete();

        return redirect()->route('categorias.index')
                         ->with('success', 'Categoría eliminada exitosamente');
    }
}
```

---

## 9. Rutas {#rutas}

### ¿Qué son las Rutas?

Las rutas **definen los endpoints de la aplicación** y mapean URLs a controladores.

### Configurar rutas de recursos

Archivo: `routes/web.php`

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;

// Ruta principal
Route::get('/', function () {
    return view('welcome');
});

// Rutas de recursos para Productos (genera automáticamente todas las rutas CRUD)
Route::resource('productos', ProductoController::class);

// Rutas de recursos para Categorías
Route::resource('categorias', CategoriaController::class);
```

### Rutas generadas automáticamente por resource

```bash
php artisan route:list
```

Para **Productos**:
```
GET     /productos              index    productos.index
GET     /productos/create       create   productos.create
POST    /productos              store    productos.store
GET     /productos/{producto}   show     productos.show
GET     /productos/{producto}/edit  edit productos.edit
PUT     /productos/{producto}   update   productos.update
DELETE  /productos/{producto}   destroy  productos.destroy
```

### Rutas personalizadas adicionales

```php
// Agregar rutas personalizadas ANTES de Route::resource

// Ver productos por categoría
Route::get('/categorias/{categoria}/productos', [CategoriaController::class, 'productos'])
     ->name('categorias.productos');

// Búsqueda de productos
Route::get('/productos/buscar', [ProductoController::class, 'buscar'])
     ->name('productos.buscar');

// API endpoint para stock
Route::get('/api/productos/{producto}/stock', [ProductoController::class, 'checkStock'])
     ->name('productos.stock');

// Luego las rutas de recursos
Route::resource('productos', ProductoController::class);
Route::resource('categorias', CategoriaController::class);
```

---

## 10. Vistas {#vistas}

### Sistema de Templates Blade

Laravel usa **Blade** como motor de plantillas que permite escribir HTML con lógica PHP de forma elegante.

### Crear layout principal

Archivo: `resources/views/layouts/app.blade.php`

```blade
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistema de Inventarios')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    @yield('styles')
</head>
<body>
    <!-- Navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="/">Inventario App</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('productos.index') }}">Productos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('categorias.index') }}">Categorías</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Mensajes de éxito/error -->
    <div class="container mt-3">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <!-- Contenido principal -->
    <main class="container my-4">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-light py-3 mt-5">
        <div class="container text-center">
            <p class="mb-0">&copy; 2024 Sistema de Inventarios - Taller MVC</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @yield('scripts')
</body>
</html>
```

### Vista index de productos

Crear carpeta: `resources/views/productos/`

Archivo: `resources/views/productos/index.blade.php`

```blade
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
                            <td>Q{{ number_format($producto->precio, 2) }}</td>
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
        <div class="mt-3">
            {{ $productos->links() }}
        </div>
    </div>
</div>
@endsection
```

### Vista create de productos

Archivo: `resources/views/productos/create.blade.php`

```blade
@extends('layouts.app')

@section('title', 'Crear Producto')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h2>Crear Nuevo Producto</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('productos.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="codigo" class="form-label">Código *</label>
                        <input type="text" 
                               class="form-control @error('codigo') is-invalid @enderror" 
                               id="codigo" 
                               name="codigo" 
                               value="{{ old('codigo') }}"
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
                               value="{{ old('nombre') }}"
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
                                  rows="3">{{ old('descripcion') }}</textarea>
                        @error('descripcion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="precio" class="form-label">Precio *</label>
                            <div class="input-group">
                                <span class="input-group-text">Q</span>
                                <input type="number" 
                                       class="form-control @error('precio') is-invalid @enderror" 
                                       id="precio" 
                                       name="precio" 
                                       step="0.01"
                                       value="{{ old('precio') }}"
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
                                   value="{{ old('stock', 0) }}"
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
                                        {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
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
                               {{ old('activo', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="activo">
                            Producto activo
                        </label>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('productos.index') }}" class="btn btn-secondary">
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            Guardar Producto
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
```

### Vista edit de productos

Archivo: `resources/views/productos/edit.blade.php`

```blade
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
                                <span class="input-group-text">Q</span>
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
```

---

## 11. CRUD Completo de Inventarios {#crud-completo}

### Resumen del flujo completo

```
1. Usuario visita /productos
   ↓
2. Ruta: Route::get('/productos', [ProductoController::class, 'index'])
   ↓
3. Controlador: ProductoController@index
   - Consulta productos con Eloquent
   - Pasa datos a la vista
   ↓
4. Vista: productos/index.blade.php
   - Muestra tabla con productos
   - Renderiza en HTML
   ↓
5. Usuario ve la página
```

### Arquitectura N-Capas en Laravel

```
┌─────────────────────────────────────────┐
│     CAPA DE PRESENTACIÓN (Views)        │
│  - Blade Templates                      │
│  - HTML/CSS/JavaScript                  │
└────────────────┬────────────────────────┘
                 │
┌────────────────▼────────────────────────┐
│   CAPA DE CONTROL (Controllers)         │
│  - Lógica de flujo                      │
│  - Validación                           │
│  - Coordinación                         │
└────────────────┬────────────────────────┘
                 │
┌────────────────▼────────────────────────┐
│   CAPA DE NEGOCIO (Models)              │
│  - Lógica de dominio                    │
│  - Reglas de negocio                    │
│  - Eloquent ORM                         │
└────────────────┬────────────────────────┘
                 │
┌────────────────▼────────────────────────┐
│   CAPA DE DATOS (Database)              │
│  - MySQL                                │
│  - Migraciones                          │
│  - Relaciones                           │
└─────────────────────────────────────────┘
```

---

## 12. Arquitectura N-Capas en Laravel {#arquitectura-n-capas}

### Separación de Responsabilidades

#### 1. Capa de Presentación (Views)
- **Responsabilidad**: Mostrar información al usuario
- **Ubicación**: `resources/views/`
- **Tecnología**: Blade, HTML, CSS, JavaScript
- **Principio**: Solo presentación, sin lógica de negocio

#### 2. Capa de Aplicación (Controllers)
- **Responsabilidad**: Orquestar el flujo de la aplicación
- **Ubicación**: `app/Http/Controllers/`
- **Tareas**:
  - Recibir requests
  - Validar datos
  - Llamar a modelos
  - Retornar respuestas

#### 3. Capa de Dominio (Models)
- **Responsabilidad**: Lógica de negocio y datos
- **Ubicación**: `app/Models/`
- **Tareas**:
  - Definir entidades
  - Relaciones entre modelos
  - Reglas de negocio
  - Interacción con BD

#### 4. Capa de Persistencia (Database)
- **Responsabilidad**: Almacenamiento de datos
- **Ubicación**: MySQL + Migraciones
- **Tareas**:
  - Estructura de datos
  - Integridad referencial
  - Consultas

### Ventajas de N-Capas

1. **Mantenibilidad**: Cambios en una capa no afectan otras
2. **Escalabilidad**: Fácil agregar funcionalidades
3. **Testabilidad**: Cada capa se puede probar independientemente
4. **Reutilización**: Código modular y reutilizable
5. **Claridad**: Código organizado y fácil de entender

---

## Comandos Artisan Útiles

```bash
# Ver todas las rutas
php artisan route:list

# Limpiar caché
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Crear modelo con migración y controlador
php artisan make:model Producto -mc

# Crear modelo completo (migración, factory, seeder, controller)
php artisan make:model Producto -mfsc

# Ver estado de migraciones
php artisan migrate:status

# Ejecutar seeders
php artisan db:seed

# Refrescar BD completa
php artisan migrate:fresh --seed

# Modo mantenimiento
php artisan down
php artisan up

# Generar clave de aplicación
php artisan key:generate

# Ver lista de comandos
php artisan list
```

