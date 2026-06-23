<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Producto; // 👈 FALTABA ESTO

class Categoria extends Model
{
    protected $table = 'categorias'; // opcional pero recomendado

    protected $fillable = ['nombre'];

    public function productos()
    {
        return $this->hasMany(Producto::class, 'categoria_id');
    }
}
