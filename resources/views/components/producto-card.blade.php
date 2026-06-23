@props(['producto'])

@php
    $tieneOferta = !is_null($producto->precio_oferta) && $producto->precio_oferta > 0;
    $descuento = $tieneOferta ? round((1 - $producto->precio_oferta / $producto->precio) * 100) : 0;
    $precioActual = $tieneOferta ? $producto->precio_oferta : $producto->precio;
    $stockClass = $producto->stock > 5 ? 'stock-available' : ($producto->stock > 0 ? 'stock-low' : 'stock-out');
    $stockText = $producto->stock > 5 ? 'Disponible' : ($producto->stock > 0 ? 'Quedan pocos' : 'Agotado');

    $imagenSrc = $producto->imagen
        ? (str_starts_with($producto->imagen, 'http')
            ? $producto->imagen
            : asset('storage/' . $producto->imagen))
        : null;
@endphp

<div class="producto-card">
    {{-- Discount badge --}}
    @if($tieneOferta)
        <span class="card-discount-badge">-{{ $descuento }}%</span>
    @endif

    {{-- Image --}}
    <div class="bg-white aspect-square flex items-center justify-center overflow-hidden rounded-lg mb-3">
        @if($imagenSrc)
            <img src="{{ $imagenSrc }}" alt="{{ $producto->nombre }}"
                 class="h-full w-full object-contain p-3"
                 onerror="this.onerror=null;this.style.display='none';this.nextElementSibling.style.display='flex'">
            <div class="hidden h-full w-full bg-gray-100 flex items-center justify-center text-gray-300 text-4xl">
                <i class="bi bi-basket"></i>
            </div>
        @else
            <div class="h-full w-full bg-gray-100 flex items-center justify-center text-gray-300 text-4xl">
                <i class="bi bi-basket"></i>
            </div>
        @endif
    </div>

    {{-- Info --}}
    <div class="card-body">
        {{-- Marca --}}
        @if($producto->marca)
            <p class="card-marca">{{ $producto->marca }}</p>
        @endif

        {{-- Name --}}
        <h3 class="card-nombre">{{ $producto->nombre }}</h3>

        {{-- Category + Stock --}}
        <div class="card-meta">
            <span class="card-categoria">
                <i class="bi bi-tag"></i> {{ $producto->categoria->nombre ?? 'General' }}
            </span>
            <span class="card-stock {{ $stockClass }}">
                <i class="bi bi-box"></i> {{ $stockText }}
            </span>
        </div>

        {{-- Price --}}
        <div class="card-precios">
            @if($tieneOferta)
                <span class="precio-antiguo">S/ {{ number_format($producto->precio, 2) }}</span>
            @endif
            <span class="precio-actual {{ $tieneOferta ? 'en-oferta' : '' }}">
                S/ {{ number_format($precioActual, 2) }}
            </span>
        </div>

        {{-- Actions --}}
        <div class="card-actions">
            @if($producto->stock > 0)
                <form action="{{ route('cart.add', $producto->id_producto) }}" method="POST" class="add-cart-form">
                    @csrf
                    <input type="hidden" name="id_producto" value="{{ $producto->id_producto }}">
                    <div class="qty-selector">
                        <button type="button" class="qty-btn qty-minus" tabindex="-1">−</button>
                        <input type="number" name="cantidad" value="1" min="1" max="{{ $producto->stock }}" class="qty-input" readonly>
                        <button type="button" class="qty-btn qty-plus" tabindex="-1">+</button>
                    </div>
                    <button type="submit" class="btn-add-card">
                        <i class="bi bi-cart-plus"></i> Agregar
                    </button>
                </form>
            @else
                <button class="btn-add-card btn-disabled" disabled>
                    <i class="bi bi-x-circle"></i> Agotado
                </button>
            @endif
        </div>
    </div>
</div>

@once
    @push('scripts')
        <script>
        document.addEventListener('click', function (e) {
            const btn = e.target.closest('.qty-btn');
            if (!btn) return;

            const form = btn.closest('.add-cart-form');
            const input = form.querySelector('.qty-input');
            let val = parseInt(input.value) || 1;
            const max = parseInt(input.getAttribute('max')) || 999;

            if (btn.classList.contains('qty-plus')) {
                if (val < max) input.value = val + 1;
            } else if (btn.classList.contains('qty-minus')) {
                if (val > 1) input.value = val - 1;
            }
        });
        </script>
    @endpush
@endonce
