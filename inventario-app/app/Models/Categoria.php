<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    //
    use HasFactory;

    //Nombre de la tabla en la base de datos
    protected $table = 'categorias';

    //Campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'descripcion',
        'activo',
    ];

    //Campos que se castean automaticamente
    protected $casts = [
        'activo' => 'boolean',
    ];


    /*
    Relacion con productos (1 a muchos)
    */

    public function productos()
    {
        return $this->hasMany(Producto::class, 'categoria_id');
    }

    //Algunas consultas, categorias activas
    public function scopeActivas($query)
    {
        return $query->where('activo', true);
    }

}
