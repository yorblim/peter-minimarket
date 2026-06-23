@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/ventas.css') }}">
@endsection

@section('content')
<div class="admin-container">
    <h1><i class="bi bi-receipt"></i> Gestión de Pedidos</h1>

    <form method="GET" action="{{ route('ventas.index') }}" class="filtros-form">
        <div class="filtros-grid">
            <div class="filtro-item">
                <label>Estado</label>
                <select name="estado" class="form-select">
                    <option value="">Todos</option>
                    @foreach(App\Models\Venta::ESTADOS as $estado)
                        <option value="{{ $estado }}" {{ request('estado') === $estado ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $estado)) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="filtro-item">
                <label>Buscar</label>
                <input type="text" name="buscar" class="form-input" placeholder="Pedido #, cliente o email" value="{{ request('buscar') }}">
            </div>
            <div class="filtro-item">
                <label>Desde</label>
                <input type="date" name="fecha_desde" class="form-input" value="{{ request('fecha_desde') }}">
            </div>
            <div class="filtro-item">
                <label>Hasta</label>
                <input type="date" name="fecha_hasta" class="form-input" value="{{ request('fecha_hasta') }}">
            </div>
            <div class="filtro-item">
                <label>Ordenar</label>
                <select name="orden" class="form-select">
                    <option value="reciente" {{ request('orden') === 'reciente' ? 'selected' : '' }}>Más recientes</option>
                    <option value="antiguo" {{ request('orden') === 'antiguo' ? 'selected' : '' }}>Más antiguos</option>
                </select>
            </div>
            <div class="filtro-item filtro-btns">
                <label>&nbsp;</label>
                <button type="submit" class="btn-admin-filter"><i class="bi bi-funnel"></i> Filtrar</button>
                <a href="{{ route('ventas.index') }}" class="btn-admin-clear"><i class="bi bi-x-circle"></i> Limpiar</a>
            </div>
        </div>
    </form>

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Cliente</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ventas as $venta)
                    <tr>
                        <td>{{ $venta->id }}</td>
                        <td>
                            <strong>{{ $venta->user->name }}</strong><br>
                            <small class="text-muted">{{ $venta->user->email }}</small>
                        </td>
                        <td><strong>S/ {{ number_format($venta->total, 2) }}</strong></td>
                        <td>
                                <span class="estado-badge {{ App\Models\Venta::badgeClass($venta->estado) }}">
                                {{ App\Models\Venta::labelEstado($venta->estado) }}
                            </span>
                        </td>
                        <td>{{ $venta->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('ventas.show', $venta) }}" class="btn-admin-view">
                                <i class="bi bi-eye"></i> Ver
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">No se encontraron pedidos.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrapper">
        {{ $ventas->links() }}
    </div>
</div>
@endsection
