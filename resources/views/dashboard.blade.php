@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/ventas.css') }}">
<style>
.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-bottom: 2rem;
}
.dashboard-card {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 0.5rem;
    padding: 1.25rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    text-align: center;
}
.dashboard-card .card-icon {
    font-size: 2rem;
    margin-bottom: 0.5rem;
}
.dashboard-card .card-number {
    font-size: 1.75rem;
    font-weight: 700;
    color: #2d3748;
}
.dashboard-card .card-label {
    font-size: 0.85rem;
    color: #718096;
    margin-top: 0.25rem;
}
.card-blue .card-icon { color: #4299e1; }
.card-green .card-icon { color: #48bb78; }
.card-orange .card-icon { color: #ed8936; }
.card-red .card-icon { color: #fc8181; }
.card-purple .card-icon { color: #9f7aea; }
.card-teal .card-icon { color: #38b2ac; }

.dashboard-section {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 0.5rem;
    padding: 1.25rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}
.dashboard-section h3 {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 1rem;
    color: #2d3748;
    border-bottom: 1px solid #f0f0f0;
    padding-bottom: 0.5rem;
}
.stock-bajo-item {
    display: flex;
    justify-content: space-between;
    padding: 0.4rem 0;
    border-bottom: 1px solid #f7fafc;
    font-size: 0.9rem;
}
.stock-bajo-item .stock-count {
    font-weight: 600;
    color: #e53e3e;
}
.estados-bar {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}
.estado-count {
    background: #f7fafc;
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    font-size: 0.85rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.estado-count .count {
    font-weight: 700;
    font-size: 1.1rem;
}
</style>
@endsection

@section('content')
<div class="admin-container">
    <h1><i class="bi bi-speedometer2"></i> Dashboard</h1>

    <div class="dashboard-grid">
        <div class="dashboard-card card-blue">
            <div class="card-icon"><i class="bi bi-cart-check"></i></div>
            <div class="card-number">{{ $ventasHoy }}</div>
            <div class="card-label">Ventas hoy</div>
        </div>
        <div class="dashboard-card card-green">
            <div class="card-icon"><i class="bi bi-currency-dollar"></i></div>
            <div class="card-number">S/ {{ number_format($ingresosHoy, 0) }}</div>
            <div class="card-label">Ingresos hoy</div>
        </div>
        <div class="dashboard-card card-blue">
            <div class="card-icon"><i class="bi bi-calendar-check"></i></div>
            <div class="card-number">{{ $ventasMes }}</div>
            <div class="card-label">Ventas del mes</div>
        </div>
        <div class="dashboard-card card-green">
            <div class="card-icon"><i class="bi bi-graph-up"></i></div>
            <div class="card-number">S/ {{ number_format($ingresosMes, 0) }}</div>
            <div class="card-label">Ingresos del mes</div>
        </div>
        <div class="dashboard-card card-orange">
            <div class="card-icon"><i class="bi bi-clock-history"></i></div>
            <div class="card-number">{{ $pendientes }}</div>
            <div class="card-label">Pedidos activos</div>
        </div>
        <div class="dashboard-card card-green">
            <div class="card-icon"><i class="bi bi-check-circle"></i></div>
            <div class="card-number">{{ $entregadas }}</div>
            <div class="card-label">Entregados</div>
        </div>
        <div class="dashboard-card card-red">
            <div class="card-icon"><i class="bi bi-x-circle"></i></div>
            <div class="card-number">{{ $canceladas }}</div>
            <div class="card-label">Cancelados</div>
        </div>
        <div class="dashboard-card card-purple">
            <div class="card-icon"><i class="bi bi-people"></i></div>
            <div class="card-number">{{ $totalClientes }}</div>
            <div class="card-label">Clientes</div>
        </div>
    </div>

    <div class="dashboard-section">
        <h3><i class="bi bi-pie-chart"></i> Pedidos por Estado</h3>
        <div class="estados-bar">
            @foreach(App\Models\Venta::ESTADOS as $estado)
                <div class="estado-count">
                    <span>{{ App\Models\Venta::labelEstado($estado) }}:</span>
                    <span class="count">{{ $ventasPorEstado[$estado] ?? 0 }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <div class="dashboard-section">
        <h3><i class="bi bi-exclamation-triangle"></i> Productos con Stock Bajo</h3>
        @if($stockBajo->count() > 0)
            @foreach($stockBajo as $producto)
                <div class="stock-bajo-item">
                    <span>{{ $producto->nombre }}</span>
                    <span class="stock-count">{{ $producto->stock }} unidades</span>
                </div>
            @endforeach
        @else
            <p style="color:#718096;">No hay productos con stock bajo.</p>
        @endif
    </div>

    <div class="dashboard-section">
        <h3><i class="bi bi-clock"></i> Últimos Pedidos</h3>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Cliente</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($ultimasVentas as $venta)
                    <tr>
                        <td>{{ $venta->id }}</td>
                        <td>{{ $venta->user->name }}</td>
                        <td>S/ {{ number_format($venta->total, 2) }}</td>
                        <td>
                                <span class="estado-badge {{ App\Models\Venta::badgeClass($venta->estado) }}">{{ App\Models\Venta::labelEstado($venta->estado) }}</span>
                        </td>
                        <td>{{ $venta->created_at->format('d/m/Y H:i') }}</td>
                        <td><a href="{{ route('ventas.show', $venta) }}" class="btn-admin-view"><i class="bi bi-eye"></i></a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
