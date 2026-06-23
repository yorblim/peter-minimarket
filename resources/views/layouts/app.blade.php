<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Peter Market</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/menu.css') }}">
    @vite('resources/css/app.css')
    @yield('styles')
    @stack('styles')
</head>
<body>

    {{-- TOP BAR --}}
    <div class="top-bar">
        <span><i class="bi bi-truck"></i> Delivery gratis desde S/45</span>
        <span><i class="bi bi-clock"></i> Lun–Sáb 8:00am – 9:00pm</span>
        <span><i class="bi bi-telephone"></i> (084) 123-456</span>
    </div>

    {{-- NAVBAR --}}
    <nav class="navbar">
        <div class="nav-container">
            <a href="{{ route('tienda.index') }}" class="nav-logo">
                <i class="bi bi-shop"></i> Peter Market
            </a>

            <ul class="nav-links">
                <li><a href="{{ route('tienda.index') }}"><i class="bi bi-grid"></i> Productos</a></li>
                @auth
                <li>
                    <a href="{{ route('cart.index') }}" class="cart-link">
                        <i class="bi bi-cart3"></i> Carrito
                        @php
                            $cartCount = Auth::user() ? \App\Models\CarritoItem::where('user_id', Auth::id())->count() : 0;
                        @endphp
                        @if($cartCount > 0)
                            <span class="cart-badge">{{ $cartCount }}</span>
                        @endif
                    </a>
                </li>
                @endauth
                @auth
                    @if(auth()->user()->rol === 'admin')
                        <li><a href="{{ route('clientes.index') }}"><i class="bi bi-people"></i> Clientes</a></li>
                        <li><a href="{{ route('productos.index') }}"><i class="bi bi-box-seam"></i> Productos</a></li>
                        <li><a href="{{ route('usuarios.index') }}"><i class="bi bi-person-gear"></i> Usuarios</a></li>
                    @endif
                    @if(auth()->user()->rol === 'worker')
                        <li><a href="{{ route('productos.index') }}"><i class="bi bi-box"></i> Inventario</a></li>
                    @endif
                @endauth
            </ul>

            <ul class="nav-right">
                @guest
                    <li><a href="{{ route('login') }}" class="btn-login-nav"><i class="bi bi-box-arrow-in-right"></i> Ingresar</a></li>
                    <li><a href="{{ route('register') }}" class="btn-register-nav"><i class="bi bi-person-plus"></i> Registrarse</a></li>
                @else
                    <li>
                        <a href="{{ route('profile.edit') }}">
                            <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                        </a>
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" style="display:inline">
                            @csrf
                            <button class="btn-logout"><i class="bi bi-box-arrow-right"></i> Salir</button>
                        </form>
                    </li>
                @endguest
            </ul>
        </div>
    </nav>

    {{-- CONTENT --}}
    <div class="page-content">
        @if(session('success'))
            <div class="alert-success"><i class="bi bi-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-error"><i class="bi bi-exclamation-circle"></i> {{ session('error') }}</div>
        @endif
        @yield('content')
    </div>

    {{-- FOOTER --}}
    <footer class="site-footer">
        <div class="footer-container">
            <div class="footer-col">
                <h4><i class="bi bi-shop"></i> Peter Market</h4>
                <p>Tu tienda de confianza con los mejores productos frescos y de calidad. ¡Aquí encuentras todo para tu hogar!</p>
            </div>
            <div class="footer-col">
                <h4>Horario</h4>
                <p><i class="bi bi-calendar"></i> Lun – Sáb: 8:00am – 9:00pm</p>
                <p><i class="bi bi-calendar"></i> Domingos: 9:00am – 2:00pm</p>
                <p><i class="bi bi-geo-alt"></i> Jr. Espinar y Progreso, Cusco</p>
            </div>
            <div class="footer-col">
                <h4>Contacto</h4>
                <p><i class="bi bi-telephone"></i> (084) 123-456</p>
                <p><i class="bi bi-whatsapp"></i> 999 888 777</p>
                <p><i class="bi bi-envelope"></i> contacto@minimarketbears.pe</p>
            </div>
            <div class="footer-col">
                <h4>Enlaces</h4>
                <a href="{{ route('tienda.index') }}"><i class="bi bi-chevron-right"></i> Tienda</a>
                <a href="{{ route('cart.index') }}"><i class="bi bi-chevron-right"></i> Carrito</a>
                @guest
                <a href="{{ route('login') }}"><i class="bi bi-chevron-right"></i> Iniciar sesión</a>
                @endguest
            </div>
        </div>
        <div class="footer-bottom">
            &copy; {{ date('Y') }} Peter Market. Todos los derechos reservados.
        </div>
    </footer>

    @stack('scripts')
    @yield('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
