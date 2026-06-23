<?php

namespace App\Http\Controllers;

use App\Models\CarritoItem;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Mostrar carrito
    public function index()
{
    $userId = Auth::id();

    $carrito = CarritoItem::where('user_id', $userId)
                ->with('producto')
                ->get();

    $subtotal = 0;

    foreach ($carrito as $item) {
        $precio = $item->producto->precio_efectivo;
        $subtotal += $precio * $item->cantidad;
    }

    // IGV 18%
    $igv = $subtotal * 0.18;

    // DELIVERY (reglas Cusco)
    if ($subtotal < 35) {
        $delivery = null; // No disponible
    } elseif ($subtotal >= 45) {
        $delivery = 0; // Gratis
    } else {
        $delivery = 5; // Normal
    }

    $total = $delivery === null ? null : $subtotal + $igv + $delivery;

    return view('cart.index', compact('carrito', 'subtotal', 'igv', 'delivery', 'total'));
}



    // Agregar producto al carrito
    public function add(Request $request, $id)
    {
        $userId = Auth::id();
        $producto = Producto::findOrFail($id);

        if ($producto->stock < 1) {
            return back()->with('error', 'Este producto está agotado');
        }

        $item = CarritoItem::where('user_id', $userId)
                           ->where('producto_id', $id)
                           ->first();

        $cantidadSolicitada = $item ? $item->cantidad + 1 : 1;

        if ($cantidadSolicitada > $producto->stock) {
            return back()->with('error', "Solo hay {$producto->stock} unidades disponibles de {$producto->nombre}");
        }

        if ($item) {
            $item->cantidad = $cantidadSolicitada;
            $item->save();
        } else {
            CarritoItem::create([
                'user_id' => $userId,
                'producto_id' => $id,
                'cantidad' => 1
            ]);
        }

        return back()->with('success', 'Producto agregado al carrito');
    }

    // Actualizar cantidad de un producto
    public function update(Request $request, $id)
    {
        $request->validate([
            'cantidad' => 'required|integer|min:0',
        ]);

        $item = CarritoItem::where('id', $id)
                        ->where('user_id', Auth::id())
                        ->firstOrFail();

        if ($request->cantidad < 1) {
            $item->delete();
            return back()->with('success', 'Producto eliminado del carrito');
        }

        if ($request->cantidad > $item->producto->stock) {
            return back()->with('error', "Solo hay {$item->producto->stock} unidades disponibles de {$item->producto->nombre}");
        }

        $item->cantidad = $request->cantidad;
        $item->save();

        return back()->with('success', 'Cantidad actualizada');
    }

    // Eliminar producto del carrito
    public function remove($id)
    {
        $item = CarritoItem::where('id', $id)
                        ->where('user_id', Auth::id())
                        ->firstOrFail();

        $item->delete();

        return back()->with('success', 'Producto eliminado del carrito');
    }


    // Vaciar carrito
    public function clear()
    {
        $userId = Auth::id();
        CarritoItem::where('user_id', $userId)->delete();

        return back()->with('success', 'Carrito vaciado');
    }
}
