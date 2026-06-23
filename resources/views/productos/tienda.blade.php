@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/tienda.css') }}">
@endsection

@section('content')

    {{-- HERO CARRUSEL (intacto) --}}
    <div id="heroCarousel" class="carousel slide hero-carousel" data-bs-ride="carousel" data-bs-interval="5000">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="hero-banner">
                    <div class="hero-text">
                        <h1>Bienvenido a Peter Market 🛒</h1>
                        <p>Los mejores productos frescos al mejor precio, directo a tu puerta</p>
                    </div>
                    <div class="hero-icon">
                        <i class="bi bi-basket2"></i>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="hero-banner">
                    <div class="hero-text">
                        <h1>🚚 Delivery gratis</h1>
                        <p>¿Llenaste la canasta? ¡Tu envío es GRATIS a todo Cusco por compras mayores a S/45!</p>
                        <a href="#productos" class="btn btn-warning mt-3 fw-bold" style="color:#bf360c;">Ver abarrotes</a>
                    </div>
                    <div class="hero-icon">
                        <i class="bi bi-truck"></i>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="hero-banner">
                    <div class="hero-text">
                        <h1>🌿 Miércoles de Verduras</h1>
                        <p>15% de descuento en todos los frescos. ¡Aprovecha la oferta de la semana!</p>
                        <a href="#productos" class="btn btn-warning mt-3 fw-bold" style="color:#bf360c;">Ver ofertas</a>
                    </div>
                    <div class="hero-icon">
                        <i class="bi bi-flower1"></i>
                    </div>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Siguiente</span>
        </button>
    </div>

    {{-- CONTENEDOR PRINCIPAL (Tailwind) --}}
    <div class="max-w-7xl mx-auto px-4 py-8" id="productos">

        {{-- Cabecera de la tienda --}}
        <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
            <h1 class="text-2xl font-bold text-gray-800"><i class="bi bi-grid"></i> Nuestros Productos</h1>
            <div class="flex items-center gap-2">
                <a href="{{ route('cart.index') }}" class="inline-flex items-center gap-2 bg-orange-700 hover:bg-orange-800 text-white font-semibold px-5 py-2.5 rounded-xl text-sm transition-all hover:-translate-y-0.5">
                    <i class="bi bi-cart3"></i> Ver Carrito
                </a>
                @auth
                    @if(auth()->user()->rol === 'admin')
                        <a href="{{ route('usuarios.index') }}" class="inline-flex items-center gap-2 bg-amber-700 hover:bg-amber-800 text-white font-semibold px-4 py-2.5 rounded-xl text-sm transition-all">
                            <i class="bi bi-person-gear"></i> Gestionar
                        </a>
                    @endif
                @endauth
            </div>
        </div>

        {{-- LAYOUT DOS COLUMNAS --}}
        <div class="flex flex-col md:flex-row gap-7 items-start">

            {{-- SIDEBAR FILTROS — oculto en móvil, 25% en desktop --}}
            <aside class="w-full md:w-1/4 lg:w-1/5 hidden md:block sticky top-24">
                <form method="GET" class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100" id="filter-form">
                    <h3 class="font-bold text-gray-800 pb-3 border-b-2 border-gray-100 flex items-center gap-2 mb-5">
                        <i class="bi bi-funnel"></i> Filtros
                    </h3>

                    <div class="space-y-5">

                        {{-- Buscar --}}
                        <div class="w-full">
                            <label for="buscar" class="text-xs font-semibold text-gray-500 flex items-center gap-1.5">
                                <i class="bi bi-search"></i> Buscar producto
                            </label>
                            <input type="text" id="buscar" name="buscar" value="{{ request('buscar') }}"
                                   placeholder="Buscar productos..."
                                   class="w-full mt-1.5 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 text-sm">
                        </div>

                        {{-- Categorías --}}
                        <div>
                            <label class="text-xs font-semibold text-gray-500 flex items-center gap-1.5 mb-1.5">
                                <i class="bi bi-tags"></i> Categorías
                            </label>
                            <div class="flex flex-col gap-0.5 max-h-52 overflow-y-auto">
                                <label class="flex items-center gap-2 px-2.5 py-1.5 rounded-lg text-sm font-medium cursor-pointer transition-all
                                       {{ !request('categoria') ? 'bg-orange-50 text-orange-700 font-semibold' : 'text-gray-500 hover:bg-gray-50' }}">
                                    <input type="radio" name="categoria" value="" {{ !request('categoria') ? 'checked' : '' }}
                                           onchange="this.form.submit()" class="size-4 accent-orange-700 shrink-0">
                                    Todas
                                </label>
                                @foreach($categorias as $cat)
                                    <label class="flex items-center gap-2 px-2.5 py-1.5 rounded-lg text-sm font-medium cursor-pointer transition-all
                                           {{ request('categoria') == $cat->id ? 'bg-orange-50 text-orange-700 font-semibold' : 'text-gray-500 hover:bg-gray-50' }}">
                                        <input type="radio" name="categoria" value="{{ $cat->id }}"
                                               {{ request('categoria') == $cat->id ? 'checked' : '' }}
                                               onchange="this.form.submit()" class="size-4 accent-orange-700 shrink-0">
                                        {{ $cat->nombre }}
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Marcas --}}
                        @if($marcas->count())
                        <div>
                            <label class="text-xs font-semibold text-gray-500 flex items-center gap-1.5 mb-1.5">
                                <i class="bi bi-building"></i> Marcas
                            </label>
                            <div class="flex flex-col gap-0.5 max-h-52 overflow-y-auto">
                                @foreach($marcas as $marca)
                                    @php $checked = in_array($marca, (array) request('marca', [])); @endphp
                                    <label class="flex items-center gap-2 px-2.5 py-1.5 rounded-lg text-sm font-medium cursor-pointer transition-all
                                           {{ $checked ? 'bg-orange-50 text-orange-700 font-semibold' : 'text-gray-500 hover:bg-gray-50' }}">
                                        <input type="checkbox" name="marca[]" value="{{ $marca }}"
                                               {{ $checked ? 'checked' : '' }}
                                               onchange="this.form.submit()" class="size-4 accent-orange-700 shrink-0">
                                        {{ $marca }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        {{-- Precio rango --}}
                        <div>
                            <label class="text-xs font-semibold text-gray-500 flex items-center gap-1.5 mb-1.5">
                                <i class="bi bi-coin"></i> Precio
                            </label>
                            <div class="mt-2 flex items-center gap-2 w-full">
                                <input type="number" name="precio_min" value="{{ request('precio_min') }}"
                                       placeholder="Min" min="0" step="0.5" onchange="this.form.submit()"
                                       class="w-1/2 px-2 py-1.5 bg-white border border-gray-300 rounded-md text-sm text-center focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500">
                                <span class="text-gray-400 text-xs shrink-0">-</span>
                                <input type="number" name="precio_max" value="{{ request('precio_max') }}"
                                       placeholder="Max" min="0" step="0.5" onchange="this.form.submit()"
                                       class="w-1/2 px-2 py-1.5 bg-white border border-gray-300 rounded-md text-sm text-center focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500">
                            </div>
                        </div>

                        {{-- Ofertas toggle --}}
                        <div>
                            <label class="flex items-center gap-2.5 px-3 py-2 rounded-lg bg-gray-50 border border-gray-200 cursor-pointer transition-all text-sm font-semibold select-none
                                   {{ request()->boolean('ofertas') ? 'bg-orange-50 border-orange-500 text-orange-700' : 'text-gray-500 hover:bg-gray-100' }}">
                                <input type="hidden" name="ofertas" value="0">
                                <input type="checkbox" name="ofertas" value="1"
                                       {{ request()->boolean('ofertas') ? 'checked' : '' }}
                                       onchange="this.form.submit()" class="hidden">
                                <span class="relative w-9 h-5 rounded-full transition-all duration-300 shrink-0
                                             {{ request()->boolean('ofertas') ? 'bg-orange-500' : 'bg-gray-300' }}">
                                    <span class="absolute top-0.5 left-0.5 size-4 bg-white rounded-full transition-all duration-300
                                                 {{ request()->boolean('ofertas') ? 'translate-x-4' : '' }}"></span>
                                </span>
                                <i class="bi bi-lightning"></i> Solo ofertas
                            </label>
                        </div>

                        <button type="submit" class="w-full bg-orange-600 hover:bg-orange-700 text-white font-semibold py-2.5 px-5 rounded-lg text-sm transition-all cursor-pointer flex items-center justify-center gap-2 shadow-sm">
                            <i class="bi bi-search"></i> Aplicar filtros
                        </button>
                        <a href="{{ route('tienda.index') }}" class="flex items-center justify-center gap-1.5 py-2 px-3.5 rounded-lg text-sm font-medium text-gray-400 border border-gray-200 transition-all hover:bg-gray-50 hover:text-gray-500 no-underline">
                            <i class="bi bi-x-circle"></i> Limpiar filtros
                        </a>

                    </div>
                </form>
            </aside>

            {{-- CONTENIDO PRINCIPAL — 75% --}}
            <main class="w-full md:w-3/4 lg:w-4/5">
                @if($productos->count())
                    {{-- Barra superior --}}
                    <div class="flex flex-wrap items-center justify-between gap-4 mb-5 bg-white rounded-xl px-4 py-3 shadow-xs border border-gray-100">
                        <p class="text-sm text-gray-500 font-medium m-0">
                            Mostrando {{ $productos->firstItem() }}–{{ $productos->lastItem() }} de {{ $productos->total() }} productos
                        </p>
                        <div class="flex items-center gap-2">
                            <label for="orden" class="text-xs font-semibold text-gray-500 flex items-center gap-1 m-0 whitespace-nowrap">
                                <i class="bi bi-arrow-up-down"></i> Ordenar
                            </label>
                            <select name="orden" id="orden" form="filter-form"
                                    onchange="document.getElementById('filter-form').submit()"
                                    class="px-3 py-1.5 border-2 border-gray-200 rounded-lg text-sm bg-gray-50 outline-none transition-all focus:border-orange-700 appearance-none cursor-pointer font-medium text-gray-700 min-w-[150px]"
                                    style="background-image: url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2210%22 height=%226%22%3E%3Cpath d=%22M0 0l5 6 5-6z%22 fill=%22%23999%22/%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 10px center; padding-right: 30px;">
                                <option value="relevancia" {{ request('orden') == 'relevancia' ? 'selected' : '' }}>Relevancia</option>
                                <option value="nombre_asc" {{ request('orden') == 'nombre_asc' ? 'selected' : '' }}>A–Z</option>
                                <option value="precio_asc" {{ request('orden') == 'precio_asc' ? 'selected' : '' }}>Precio: menor a mayor</option>
                                <option value="precio_desc" {{ request('orden') == 'precio_desc' ? 'selected' : '' }}>Precio: mayor a menor</option>
                            </select>
                        </div>
                    </div>

                    {{-- Grid de productos --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                        @foreach($productos as $producto)
                            <x-producto-card :producto="$producto" />
                        @endforeach
                    </div>

                    {{-- Paginación --}}
                    <div class="mt-10 flex justify-center">
                        {{ $productos->links('pagination::bootstrap-5') }}
                    </div>
                @else
                    <div class="text-center text-gray-400 py-16 px-5 bg-white rounded-2xl shadow-xs">
                        <i class="bi bi-emoji-frown text-4xl block mb-2.5"></i>
                        No se encontraron productos con esos filtros
                        <br>
                        <a href="{{ route('tienda.index') }}" class="inline-block mt-2.5 text-orange-700 font-semibold no-underline">
                            <i class="bi bi-arrow-left"></i> Ver todos los productos
                        </a>
                    </div>
                @endif
            </main>

        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('filter-form').querySelectorAll('select[onchange]').forEach(function (sel) {
            sel.removeAttribute('onchange');
            sel.addEventListener('change', function () { document.getElementById('filter-form').submit(); });
        });
    });
    </script>

@endsection
