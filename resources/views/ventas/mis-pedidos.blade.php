@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/ventas.css') }}">
@endsection

@section('content')
<div class="admin-container">
    <h1><i class="bi bi-box"></i> Mis Pedidos</h1>

    @if(session('success'))
        <div class="alert-success"><i class="bi bi-check-circle"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert-error"><i class="bi bi-exclamation-circle"></i> {{ session('error') }}</div>
    @endif

    @forelse($ventas as $venta)
        <div class="pedido-card">
            <div class="pedido-header">
                <div>
                    <strong>Pedido #{{ $venta->id }}</strong>
                    <span class="text-muted">— {{ $venta->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="estado-badge {{ App\Models\Venta::badgeClass($venta->estado) }}">
                        {{ App\Models\Venta::labelEstado($venta->estado) }}
                    </span>
                </div>
            </div>
            <div class="pedido-body">
                <div class="pedido-items">
                    @foreach($venta->items as $item)
                        <div class="pedido-item">
                            <span>{{ $item['nombre'] }} <strong>x{{ $item['cantidad'] }}</strong></span>
                            <span>S/ {{ number_format($item['subtotal'], 2) }}</span>
                        </div>
                    @endforeach
                </div>
                <div class="pedido-total">
                    <span>Total:</span>
                    <strong>S/ {{ number_format($venta->total, 2) }}</strong>
                </div>
            </div>
            @if($venta->puedeCancelar())
                <div class="pedido-footer">
                    <form action="{{ route('ventas.cancelar', $venta) }}" method="POST"
                          onsubmit="return confirm('¿Estás seguro de cancelar este pedido?')">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn-admin-delete">
                            <i class="bi bi-x-circle"></i> Cancelar pedido
                        </button>
                    </form>
                </div>
            @endif
        </div>
    @empty
        <div class="empty-state">
            <i class="bi bi-inbox" style="font-size:3rem;"></i>
            <p>No tienes pedidos aún.</p>
            <a href="{{ route('tienda.index') }}" class="btn-admin-add">Ir a la tienda</a>
        </div>
    @endforelse

    <div class="pagination-wrapper">
        {{ $ventas->links() }}
    </div>
</div>
@endsection
