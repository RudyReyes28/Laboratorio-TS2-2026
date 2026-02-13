<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    //
    use HasFactory;
    //Nombre de la tabla en la base de datos
    protected $table = 'productos';

    //Campos que se pueden asignar masivamente
    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'categoria_id',
        'activo',
    ];

    //Campos que se castean automaticamente
    protected $casts = [
        'precio' => 'decimal:2',
        'activo' => 'boolean',
        'stock' => 'integer',
    ];

    /*
    Relacion con categoria (muchos a 1)
    */
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    //Productos activos
    public function scopeActivos($query){
        return $query->where('activo', true);
    }

    public function scopeInactivos($query){
        return $query->where('activo', false);
    }

}
