<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';
    protected $primaryKey = 'id_producto'; // 👈 Muy importante

    protected $fillable = [
        'nombre',
        'marca',
        'precio',
        'precio_oferta',
        'stock',
        'descripcion',
        'imagen',
        'categoria_id',
    ];

    public $timestamps = false; // 👈 Si quitaste created_at y updated_at

    public function categoria()
{
    return $this->belongsTo(Categoria::class, 'categoria_id');
}

}
