<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Support\Facades\DB;
class DashboardController extends Controller
{
    public function index()
    {
        $hoy = now()->toDateString();
        $mes = now()->month;
        $anio = now()->year;

        $stats = Venta::selectRaw("
            COUNT(*) as total_ventas,
            COALESCE(SUM(CASE WHEN estado NOT IN ('pendiente','cancelado') THEN total ELSE 0 END), 0) as ingresos
        ")->whereDate('created_at', $hoy)->first();

        $statsMes = Venta::selectRaw("
            COUNT(*) as total_ventas,
            COALESCE(SUM(CASE WHEN estado NOT IN ('pendiente','cancelado') THEN total ELSE 0 END), 0) as ingresos
        ")->whereMonth('created_at', $mes)
          ->whereYear('created_at', $anio)
          ->first();

        $ventasPorEstado = Venta::selectRaw('estado, COUNT(*) as total')
            ->groupBy('estado')
            ->pluck('total', 'estado');

        $pendientes = ($ventasPorEstado['pendiente'] ?? 0)
                    + ($ventasPorEstado['confirmado'] ?? 0)
                    + ($ventasPorEstado['en_preparacion'] ?? 0)
                    + ($ventasPorEstado['en_envio'] ?? 0);

        $canceladas = $ventasPorEstado['cancelado'] ?? 0;
        $entregadas = $ventasPorEstado['entregado'] ?? 0;

        $ultimasVentas = Venta::with('user')->latest()->take(5)->get();

        return view('dashboard', compact(
            'stats', 'statsMes',
            'ventasPorEstado',
            'pendientes', 'canceladas', 'entregadas',
            'ultimasVentas'
        ))->with([
            'ventasHoy' => $stats->total_ventas,
            'ingresosHoy' => $stats->ingresos,
            'ventasMes' => $statsMes->total_ventas,
            'ingresosMes' => $statsMes->ingresos,
            'totalClientes' => User::where('rol', 'cliente')->count(),
            'stockBajo' => Producto::where('stock', '<', 5)->orderBy('stock')->get(),
        ]);
    }
}
