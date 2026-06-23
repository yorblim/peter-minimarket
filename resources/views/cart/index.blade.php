@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/cart.css') }}">
@endsection

@section('content')
<div class="cart-container">

    <h1 class="cart-title"><i class="bi bi-cart3"></i> Carrito de Compras</h1>

    @if(session('success'))
        <div class="cart-alert"><i class="bi bi-check-circle"></i> {{ session('success') }}</div>
    @endif

    @if($carrito->count() > 0)
    <div class="cart-layout">

        <div class="cart-items">
            @foreach($carrito as $item)
                    <div class="cart-item">
                    <div class="cart-item-left">
                        @php
                            $imgSrc = $item->producto->imagen
                                ? (str_starts_with($item->producto->imagen, 'http') ? $item->producto->imagen : asset('storage/' . $item->producto->imagen))
                                : 'https://via.placeholder.com/80';
                        @endphp
                        <img src="{{ $imgSrc }}" class="cart-img" onerror="this.src='https://via.placeholder.com/80'">
                        <div class="cart-info">
                            <h3 class="cart-name">{{ $item->producto->nombre }}</h3>
                            <p class="cart-price">Precio: S/ {{ number_format($item->producto->precio,2) }}</p>
                            <form action="{{ route('cart.update', $item->id) }}" method="POST" class="cart-qty-form">
                                @csrf
                                @method('PATCH')
                                <label>Cantidad:</label>
                                <input type="number" name="cantidad" value="{{ $item->cantidad }}" min="0" class="cart-qty-input">
                                <button class="cart-update-btn" title="Actualizar cantidad"><i class="bi bi-arrow-repeat"></i></button>
                            </form>
                            <p class="cart-subtotal">
                                @php
                                    $precio = $item->producto->precio_oferta ?? $item->producto->precio;
                                @endphp
                                Subtotal: S/ {{ number_format($precio * $item->cantidad, 2) }}
                            </p>
                        </div>
                    </div>
                    <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="cart-remove"><i class="bi bi-trash3"></i> Eliminar</button>
                    </form>
                </div>
            @endforeach
        </div>

        <div class="cart-summary">
            <h2 class="summary-title">Resumen del pedido</h2>

            <div class="summary-line">
                <span>Subtotal</span>
                <span>S/ {{ number_format($subtotal,2) }}</span>
            </div>
            <div class="summary-line">
                <span>IGV (18%)</span>
                <span>S/ {{ number_format($igv,2) }}</span>
            </div>
            <div class="summary-line">
                <span>Delivery</span>
                <span>
                    @if($delivery === null)
                        <span class="delivery-na">No disponible</span>
                    @elseif($delivery == 0)
                        <span class="delivery-free"><i class="bi bi-truck"></i> GRATIS</span>
                    @else
                        S/ {{ number_format($delivery,2) }}
                    @endif
                </span>
            </div>

            <hr class="summary-divider">

            <div class="summary-total">
                <span>Total</span>
                <span>S/ {{ number_format($total,2) }}</span>
            </div>

            @if($delivery === null)
                <div class="min-order-msg">
                    <i class="bi bi-exclamation-triangle"></i>
                    Pedido mínimo para delivery: S/ 35.00
                </div>
                <a href="{{ route('tienda.index') }}" class="btn-shop">
                    <i class="bi bi-plus-circle"></i> Agregar más productos
                </a>
            @else
                <form action="{{ route('checkout.index') }}" method="GET">
                    <button class="btn-checkout"><i class="bi bi-credit-card"></i> Proceder al pago</button>
                </form>
                <a href="{{ route('tienda.index') }}" class="btn-shop">
                    <i class="bi bi-arrow-left"></i> Seguir comprando
                </a>
            @endif
        </div>

    </div>
    @else
    <div class="cart-empty">
        <i class="bi bi-cart-x"></i>
        <h3>Tu carrito está vacío</h3>
        <p style="color:#888; margin-bottom:20px;">Agrega productos desde nuestra tienda</p>
        <a href="{{ route('tienda.index') }}" class="btn-checkout" style="display:inline-block; width:auto; padding:12px 30px;">
            <i class="bi bi-shop"></i> Ir a la tienda
        </a>
    </div>
    @endif

</div>
@endsection
