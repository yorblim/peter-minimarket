<x-guest-layout>
    <x-auth-session-status class="status" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="auth-form">
        @csrf

        <div class="form-group">
            <label for="email"><i class="bi bi-envelope"></i> Correo electrónico</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="tucorreo@ejemplo.com">
            <x-input-error :messages="$errors->get('email')" class="error" />
        </div>

        <div class="form-group">
            <label for="password"><i class="bi bi-lock"></i> Contraseña</label>
            <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••">
            <x-input-error :messages="$errors->get('password')" class="error" />
        </div>

        <div class="checkbox-group">
            <input id="remember_me" type="checkbox" name="remember">
            <label for="remember_me">Recordar sesión</label>
        </div>

        <button type="submit" class="btn-submit">
            <i class="bi bi-box-arrow-in-right"></i> Iniciar sesión
        </button>

        <div class="auth-links">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
                <br><br>
            @endif
            ¿No tienes cuenta? <a href="{{ route('register') }}">Regístrate aquí</a>
        </div>
    </form>
</x-guest-layout>
