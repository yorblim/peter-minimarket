<nav class="navbar">
    <div class="navbar-left">
        
        <h2 class="navbar-title">Dashboard</h2>
    </div>

    <div class="navbar-right">
        @auth
            <div class="dropdown">
                <button class="dropdown-btn">
                    {{ Auth::user()->name }} ▼
                </button>
                <div class="dropdown-content">
                    <a href="{{ route('profile.edit') }}">Perfil</a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="logout-btn">Cerrar sesión</button>
                    </form>
                </div>
            </div>
        @else
            <a href="{{ route('login') }}" class="login-link">Iniciar sesión</a>
        @endauth
    </div>
</nav>
