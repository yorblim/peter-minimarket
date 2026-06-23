<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    // 📋 LISTA DE PRODUCTOS (admin)
    public function index()
    {
        $productos = Producto::with('categoria')->get();
        return view('productos.index', compact('productos'));
    }

    // ➕ FORMULARIO CREAR PRODUCTO
    public function create()
    {
        $categorias = Categoria::all();
        return view('productos.create', compact('categorias'));
    }

    // 💾 GUARDAR PRODUCTO
    public function store(Request $request)
    {
        $request->validate([
            'nombre'       => 'required|string|max:255',
            'marca'        => 'nullable|string|max:100',
            'precio'       => 'required|numeric',
            'precio_oferta'=> 'nullable|numeric|lt:precio',
            'stock'        => 'required|integer',
            'descripcion'  => 'nullable|string',
            'categoria_id' => 'nullable|exists:categorias,id',
            'imagen'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->except('imagen');

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        Producto::create($data);

        return redirect()->route('productos.index')->with('success', 'Producto creado con éxito.');
    }

    // ✏️ EDITAR PRODUCTO
    public function edit(Producto $producto)
    {
        $categorias = Categoria::all();
        return view('productos.edit', compact('producto', 'categorias'));
    }

    // 🔄 ACTUALIZAR PRODUCTO
    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'nombre'       => 'required|string|max:255',
            'marca'        => 'nullable|string|max:100',
            'precio'       => 'required|numeric',
            'precio_oferta'=> 'nullable|numeric|lt:precio',
            'stock'        => 'required|integer',
            'descripcion'  => 'nullable|string',
            'categoria_id' => 'nullable|exists:categorias,id',
            'imagen'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->except('imagen');

        if ($request->hasFile('imagen')) {
            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }
            $data['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        $producto->update($data);

        return redirect()->route('productos.index')->with('success', 'Producto actualizado con éxito.');
    }

    // 🗑 ELIMINAR PRODUCTO
    public function destroy(Producto $producto)
    {
        if ($producto->imagen) {
            Storage::disk('public')->delete($producto->imagen);
        }
        $producto->delete();
        return redirect()->route('productos.index')->with('success', 'Producto eliminado con éxito.');
    }


    // 🛍️ TIENDA PÚBLICA CON FILTROS
    public function publicIndex(Request $request)
    {
        $query = Producto::with('categoria');

        // Buscar por nombre
        if ($request->filled('buscar')) {
            $query->where('nombre', 'like', '%' . $request->buscar . '%');
        }

        // Filtrar por categoría (soporta múltiples)
        if ($request->filled('categoria')) {
            $categorias = $request->categoria;
            $query->whereIn('categoria_id', (array) $categorias);
        }

        // Filtrar por marcas (checkboxes)
        if ($request->filled('marca')) {
            $marcas = $request->marca;
            $query->whereIn('marca', (array) $marcas);
        }

        // Precio mínimo
        if ($request->filled('precio_min')) {
            $query->where(function ($q) use ($request) {
                $q->where('precio', '>=', $request->precio_min)
                  ->orWhere('precio_oferta', '>=', $request->precio_min);
            });
        }

        // Precio máximo
        if ($request->filled('precio_max')) {
            $query->where(function ($q) use ($request) {
                $q->where('precio', '<=', $request->precio_max)
                  ->orWhere('precio_oferta', '<=', $request->precio_max);
            });
        }

        // Solo ofertas
        if ($request->boolean('ofertas')) {
            $query->whereNotNull('precio_oferta');
        }

        // Ordenar
        $sort = $request->get('orden', 'relevancia');
        switch ($sort) {
            case 'precio_asc':
                $query->orderBy('precio', 'asc');
                break;
            case 'precio_desc':
                $query->orderBy('precio', 'desc');
                break;
            case 'nombre_asc':
                $query->orderBy('nombre', 'asc');
                break;
            default:
                $query->orderBy('nombre', 'asc');
                break;
        }

        $productos = $query->paginate(12)->withQueryString();

        $categorias = Categoria::all();
        $marcas = Producto::whereNotNull('marca')->distinct()->orderBy('marca')->pluck('marca');

        return view('productos.tienda', compact('productos', 'categorias', 'marcas'));
    }
}
