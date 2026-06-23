@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/ventas.css') }}">
@endsection

@section('content')
<div class="admin-container">
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h1><i class="bi bi-receipt"></i> Pedido #{{ $venta->id }}</h1>
            <p class="text-muted">{{ $venta->created_at->format('d/m/Y H:i') }}</p>
        </div>
        <a href="{{ route('ventas.index') }}" class="btn-admin-back">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>

    <div class="venta-grid">
        <div class="venta-card">
            <h3><i class="bi bi-person"></i> Cliente</h3>
            <p><strong>Nombre:</strong> {{ $venta->user->name }}</p>
            <p><strong>Email:</strong> {{ $venta->user->email }}</p>
            <p><strong>ID Usuario:</strong> {{ $venta->user_id }}</p>
        </div>

        <div class="venta-card">
            <h3><i class="bi bi-info-circle"></i> Estado</h3>
            <p>
                <span class="estado-badge {{ App\Models\Venta::badgeClass($venta->estado) }}" style="font-size:1rem;">
                    {{ App\Models\Venta::labelEstado($venta->estado) }}
                </span>
            </p>

            @if($venta->estado !== 'entregado' && $venta->estado !== 'cancelado')
                <form action="{{ route('ventas.updateEstado', $venta) }}" method="POST" class="mt-3">
                    @csrf
                    @method('PATCH')
                    <div class="d-flex gap-2">
                        <select name="estado" class="form-select" style="flex:1;">
                            @foreach(App\Models\Venta::TRANSICIONES[$venta->estado] ?? [] as $transicion)
                                <option value="{{ $transicion }}">
                                    {{ ucfirst(str_replace('_', ' ', $transicion)) }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn-admin-update">
                            <i class="bi bi-arrow-right-circle"></i> Cambiar
                        </button>
                    </div>
                </form>
            @endif
        </div>

        <div class="venta-card">
            <h3><i class="bi bi-currency-dollar"></i> Resumen</h3>
            <table class="resumen-table">
                <tr>
                    <td>Subtotal:</td>
                    <td>S/ {{ number_format($venta->subtotal, 2) }}</td>
                </tr>
                <tr>
                    <td>IGV (18%):</td>
                    <td>S/ {{ number_format($venta->igv, 2) }}</td>
                </tr>
                <tr>
                    <td>Delivery:</td>
                    <td>
                        @if($venta->delivery > 0)
                            S/ {{ number_format($venta->delivery, 2) }}
                        @else
                            Gratis
                        @endif
                    </td>
                </tr>
                <tr class="resumen-total">
                    <td><strong>Total:</strong></td>
                    <td><strong>S/ {{ number_format($venta->total, 2) }}</strong></td>
                </tr>
            </table>
        </div>
    </div>

    <div class="venta-card mt-4">
        <h3><i class="bi bi-cart-check"></i> Productos ({{ count($venta->items) }})</h3>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unit.</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($venta->items as $item)
                    <tr>
                        <td>{{ $item['nombre'] }}</td>
                        <td>{{ $item['cantidad'] }}</td>
                        <td>S/ {{ number_format($item['precio_unitario'], 2) }}</td>
                        <td>S/ {{ number_format($item['subtotal'], 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
