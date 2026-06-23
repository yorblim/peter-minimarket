@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
@endpush

@section('content')
<div class="checkout-wrapper">

    <h2><i class="bi bi-credit-card"></i> Finalizar Compra</h2>

    @if($carrito->count() > 0 && $delivery !== null)
    <div class="checkout-card">
        <h3><i class="bi bi-bag-check"></i> Resumen de productos</h3>
        <table class="checkout-table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($carrito as $item)
                <tr>
                    <td>{{ $item->producto->nombre }}</td>
                    <td>{{ $item->cantidad }}</td>
                    <td>S/. {{ number_format($item->producto->precio, 2) }}</td>
                    <td>S/. {{ number_format($item->producto->precio * $item->cantidad, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="checkout-card">
        <h3><i class="bi bi-info-circle"></i> Información de entrega</h3>
        <div class="delivery-info">
            <i class="bi bi-geo-alt" style="font-size:1.3rem;"></i>
            <span>Zona de cobertura: Cusco centro (Jr. Espinar y Progreso) — Delivery gratis desde S/45</span>
        </div>

        <div class="totals-grid">
            <div class="total-line">
                <span>Subtotal</span>
                <span>S/. {{ number_format($subtotal, 2) }}</span>
            </div>
            <div class="total-line">
                <span>IGV (18%)</span>
                <span>S/. {{ number_format($igv, 2) }}</span>
            </div>
            <div class="total-line">
                <span>Delivery</span>
                <span>
                    @if($delivery == 0)
                        <span style="color:#e65100; font-weight:700;"><i class="bi bi-truck"></i> GRATIS</span>
                    @else
                        S/. {{ number_format($delivery, 2) }}
                    @endif
                </span>
            </div>
            <div class="total-line total-final">
                <span>Total a pagar</span>
                <span>S/. {{ number_format($total, 2) }}</span>
            </div>
        </div>
    </div>

    <div class="checkout-card">
        <h3><i class="bi bi-credit-card-2-front"></i> Datos de pago</h3>

        <form action="{{ route('checkout.process') }}" method="POST" class="payment-form">
            @csrf

            <div class="form-group">
                <label><i class="bi bi-person"></i> Nombre del titular</label>
                <input type="text" name="nombre" placeholder="Ej: Juan Pérez" required>
            </div>

            <div class="form-group">
                <label><i class="bi bi-credit-card"></i> Número de tarjeta</label>
                <input type="text" name="tarjeta" placeholder="1234 5678 9012 3456" maxlength="16" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label><i class="bi bi-calendar"></i> Vencimiento</label>
                    <input type="month" name="vencimiento" required>
                </div>
                <div class="form-group">
                    <label><i class="bi bi-lock"></i> CVV</label>
                    <input type="text" name="cvv" placeholder="123" maxlength="3" required>
                </div>
            </div>

            <button type="submit" class="btn-pay">
                <i class="bi bi-check-lg"></i> Pagar S/. {{ number_format($total, 2) }}
            </button>
        </form>
    </div>

    @elseif($carrito->count() > 0 && $delivery === null)
    <div class="checkout-card min-order-msg">
        <i class="bi bi-exclamation-triangle"></i>
        <h3>Pedido mínimo para delivery: S/ 35.00</h3>
        <p style="color:#666;">Agrega más productos a tu carrito para poder continuar</p>
        <a href="{{ route('tienda.index') }}" class="btn-secondary" style="margin-top:10px;">
            <i class="bi bi-arrow-left"></i> Agregar más productos
        </a>
    </div>
    @else
    <div class="checkout-card min-order-msg">
        <i class="bi bi-cart-x"></i>
        <h3>Tu carrito está vacío</h3>
        <a href="{{ route('tienda.index') }}" class="btn-secondary">
            <i class="bi bi-shop"></i> Ir a la tienda
        </a>
    </div>
    @endif

</div>
@endsection
