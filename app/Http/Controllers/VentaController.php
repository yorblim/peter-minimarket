<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VentaController extends Controller
{
    public function index(Request $request)
    {
        $query = Venta::with('user');

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('id', $buscar)
                  ->orWhereHas('user', function ($uq) use ($buscar) {
                      $uq->where('name', 'like', "%{$buscar}%")
                         ->orWhere('email', 'like', "%{$buscar}%");
                  });
            });
        }

        if ($request->filled('fecha_desde')) {
            $query->whereDate('created_at', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('created_at', '<=', $request->fecha_hasta);
        }

        $sort = $request->get('orden', 'reciente');
        if ($sort === 'antiguo') {
            $query->oldest();
        } else {
            $query->latest();
        }

        $ventas = $query->paginate(15)->withQueryString();

        return view('ventas.index', compact('ventas'));
    }

    public function show(Venta $venta)
    {
        $venta->load('user');
        return view('ventas.show', compact('venta'));
    }

    public function updateEstado(Request $request, Venta $venta)
    {
        $request->validate([
            'estado' => 'required|string|in:' . implode(',', Venta::ESTADOS),
        ]);

        $nuevoEstado = $request->estado;

        if (!$venta->puedeTransicionA($nuevoEstado)) {
            return back()->with('error', "No se puede cambiar de '{$venta->estado}' a '{$nuevoEstado}'.");
        }

        if ($nuevoEstado === 'cancelado' && $venta->estado !== 'cancelado') {
            foreach ($venta->items as $item) {
                Producto::where('id_producto', $item['producto_id'])
                    ->increment('stock', $item['cantidad']);
            }
        }

        $venta->update(['estado' => $nuevoEstado]);

        return back()->with('success', "Pedido #{$venta->id} actualizado a '{$nuevoEstado}'.");
    }

    public function misPedidos()
    {
        $ventas = Venta::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('ventas.mis-pedidos', compact('ventas'));
    }

    public function cancelar(Venta $venta)
    {
        if ($venta->user_id !== Auth::id()) {
            abort(403, 'Este pedido no te pertenece.');
        }

        if (!$venta->puedeCancelar()) {
            return back()->with('error', "No puedes cancelar un pedido en estado '{$venta->estado}'.");
        }

        foreach ($venta->items as $item) {
            Producto::where('id_producto', $item['producto_id'])
                ->increment('stock', $item['cantidad']);
        }

        $venta->update(['estado' => 'cancelado']);

        return back()->with('success', 'Tu pedido ha sido cancelado correctamente.');
    }
}
