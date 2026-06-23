{{-- resources/views/productos/public.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 style="font-size: 1.875rem; font-weight: 700; margin-bottom: 1.5rem; text-align: center;">🛍️ Nuestra Tienda</h1>

    @if($productos->count() > 0)
        <div class="row g-4">
            @foreach($productos as $producto)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div style="background: #bf360c; border-radius: 1rem; box-shadow: 0 4px 6px rgba(0,0,0,0.1); padding: 1rem; display: flex; flex-direction: column; height: 100%;">
                        <img src="{{ $producto->imagen ?? 'https://via.placeholder.com/300x200' }}" 
                             alt="{{ $producto->nombre }}" 
                             style="width: 100%; height: 10rem; object-fit: cover; border-radius: 0.75rem; margin-bottom: 1rem;">
                        
                        <h2 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 0.5rem; color: #fff;">{{ $producto->nombre }}</h2>
                        <p style="color: rgba(255,255,255,0.8); margin-bottom: 0.5rem;">Precio: <span style="font-weight: 700;">S/ {{ number_format($producto->precio, 2) }}</span></p>
                        <p style="color: rgba(255,255,255,0.6); font-size: 0.875rem; margin-bottom: 1rem;">Stock: {{ $producto->stock }}</p>
                        
                        <button class="btn btn-light w-100" style="margin-top: auto; border-radius: 0.75rem; font-weight: 600;">
                            Agregar al carrito 🛒
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p style="text-align: center; color: #718096;">No hay productos disponibles por el momento 😔</p>
    @endif
</div>
@endsection
