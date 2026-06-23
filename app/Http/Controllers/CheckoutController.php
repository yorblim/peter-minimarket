<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\CarritoItem;
use App\Models\Venta;

class CheckoutController extends Controller
{
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

        if ($subtotal < 35) {
            return redirect()->route('cart.index')
                ->with('error', 'El monto mínimo para delivery es S/35');
        }

        $igv = $subtotal * 0.18;
        $delivery = $subtotal >= 45 ? 0 : 5;
        $total = $subtotal + $igv + $delivery;

        return view('checkout.index', compact('carrito', 'subtotal', 'igv', 'delivery', 'total'));
    }

    public function process(Request $request)
    {
        $userId = Auth::id();

        $carrito = CarritoItem::where('user_id', $userId)
            ->with('producto')
            ->get();

        if ($carrito->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Tu carrito está vacío');
        }

        $subtotal = 0;
        foreach ($carrito as $item) {
            $precio = $item->producto->precio_efectivo;
            $subtotal += $precio * $item->cantidad;

            if ($item->cantidad > $item->producto->stock) {
                return redirect()->route('cart.index')
                    ->with('error', "Stock insuficiente para {$item->producto->nombre}. Disponible: {$item->producto->stock}");
            }
        }

        if ($subtotal < 35) {
            return redirect()->route('cart.index')
                ->with('error', 'El monto mínimo para delivery es S/35');
        }

        DB::transaction(function () use ($userId, $carrito) {
            $subtotal = 0;
            $itemsData = [];

            foreach ($carrito as $item) {
                $precio = $item->producto->precio_efectivo;
                $subtotal += $precio * $item->cantidad;

                $itemsData[] = [
                    'producto_id'  => $item->producto_id,
                    'nombre'       => $item->producto->nombre,
                    'cantidad'     => $item->cantidad,
                    'precio_unitario' => $precio,
                    'subtotal'     => $precio * $item->cantidad,
                ];

                $item->producto->decrement('stock', $item->cantidad);
            }

            $igv = $subtotal * 0.18;
            $delivery = $subtotal >= 45 ? 0 : 5;
            $total = $subtotal + $igv + $delivery;

            Venta::create([
                'user_id'  => $userId,
                'subtotal' => $subtotal,
                'igv'      => $igv,
                'delivery' => $delivery,
                'total'    => $total,
                'items'    => $itemsData,
            ]);

            CarritoItem::where('user_id', $userId)->delete();
        });

        return redirect()
            ->route('tienda.index')
            ->with('success', 'Pago procesado correctamente. ¡Gracias por tu compra!');
    }
}
