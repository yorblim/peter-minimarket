@props(['product'])

@php
    $id = $product->id_producto ?? $product->id;
    $name = $product->nombre ?? $product->name;
    $brand = $product->marca ?? $product->brand ?? null;
    $image = $product->imagen ?? $product->image ?? null;
    $price = $product->precio ?? $product->price ?? 0;
    $offerPrice = $product->precio_oferta ?? null;
    $stock = $product->stock ?? 0;
    $hasOffer = !is_null($offerPrice) && $offerPrice > 0;
    $discountPct = $hasOffer ? round((1 - $offerPrice / $price) * 100) : 0;
    $finalPrice = $hasOffer ? $offerPrice : $price;
    $outOfStock = $stock <= 0;

    $imagenSrc = $image
        ? (str_starts_with($image, 'http')
            ? $image
            : asset('storage/' . $image))
        : null;
@endphp

<div class="bg-white border border-gray-200 rounded-lg p-4 hover:shadow-lg transition-shadow flex flex-col h-full relative group">

    {{-- Discount badge --}}
    @if($hasOffer)
        <span class="absolute top-2 left-2 bg-red-600 text-white text-xs font-bold px-2 py-0.5 rounded z-10">
            -{{ $discountPct }}%
        </span>
    @endif

    {{-- Image --}}
    <div class="bg-white aspect-square w-full flex items-center justify-center overflow-hidden mb-3 rounded-lg">
        @if($imagenSrc)
            <img src="{{ $imagenSrc }}" alt="{{ $name }}"
                 class="h-full w-full object-contain p-3 transition-transform duration-300 group-hover:scale-105"
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

    {{-- Info area --}}
    <div class="flex-grow flex flex-col">

        {{-- Brand --}}
        @if($brand)
            <p class="text-xs text-gray-400 font-semibold tracking-wider uppercase mt-2">{{ $brand }}</p>
        @endif

        {{-- Name --}}
        <h3 class="text-sm font-semibold text-gray-800 leading-snug line-clamp-2 hover:underline mt-1">
            {{ $name }}
        </h3>

        {{-- Prices --}}
        <div class="mt-2">
            @if($hasOffer)
                <p class="text-xs text-gray-400 line-through mb-0.5">
                    S/ {{ number_format($price, 2) }}
                </p>
                <p class="text-lg font-bold text-red-600">
                    S/ {{ number_format($finalPrice, 2) }}
                </p>
            @else
                <p class="text-lg font-bold text-orange-600">
                    S/ {{ number_format($finalPrice, 2) }}
                </p>
            @endif
        </div>

        {{-- Add to cart --}}
        @if($outOfStock)
            <button disabled
                    class="w-full mt-4 bg-gray-100 border-2 border-gray-200 text-gray-400 rounded-full py-2.5 font-semibold text-sm tracking-wide cursor-not-allowed">
                AGOTADO
            </button>
        @else
            <form action="{{ route('cart.add', $id) }}" method="POST" class="mt-4 add-cart-form">
                @csrf
                <input type="hidden" name="id_producto" value="{{ $id }}">
                <input type="hidden" name="name" value="{{ $name }}">
                <input type="hidden" name="price" value="{{ $finalPrice }}">

                {{-- Quantity selector --}}
                <div class="flex items-center justify-center gap-2 mb-2">
                    <button type="button" class="qty-minus w-7 h-7 flex items-center justify-center rounded-md border border-gray-200 bg-gray-50 text-gray-500 font-bold text-sm hover:bg-gray-100 cursor-pointer select-none transition-colors"
                            tabindex="-1">−</button>
                    <input type="number" name="cantidad" value="1" min="1" max="{{ $stock }}"
                           class="qty-input w-10 h-7 text-center text-sm font-semibold text-gray-700 border border-gray-200 rounded-md bg-white outline-none
                                  [appearance:textfield] [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none"
                           readonly>
                    <button type="button" class="qty-plus w-7 h-7 flex items-center justify-center rounded-md border border-gray-200 bg-gray-50 text-gray-500 font-bold text-sm hover:bg-gray-100 cursor-pointer select-none transition-colors"
                            tabindex="-1">+</button>
                </div>

                <button type="submit"
                        class="w-full bg-white border-2 border-orange-600 text-orange-600 rounded-full py-2.5 font-semibold text-sm tracking-wide
                               hover:bg-orange-600 hover:text-white transition-all duration-200 cursor-pointer flex items-center justify-center gap-2">
                    <i class="bi bi-cart-plus"></i> AGREGAR
                </button>
            </form>
        @endif

    </div>
</div>

@once
    @push('scripts')
        <script>
        document.addEventListener('click', function (e) {
            const btn = e.target.closest('.qty-minus, .qty-plus');
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
