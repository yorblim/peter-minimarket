<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="auth-form">
        @csrf

        <div class="form-group">
            <label for="name"><i class="bi bi-person"></i> Nombre completo</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Tu nombre">
            <x-input-error :messages="$errors->get('name')" class="error" />
        </div>

        <div class="form-group">
            <label for="email"><i class="bi bi-envelope"></i> Correo electrónico</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="tucorreo@ejemplo.com">
            <x-input-error :messages="$errors->get('email')" class="error" />
        </div>

        <div class="form-group">
            <label for="password"><i class="bi bi-lock"></i> Contraseña</label>
            <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Mínimo 8 caracteres">
            <x-input-error :messages="$errors->get('password')" class="error" />
        </div>

        <div class="form-group">
            <label for="password_confirmation"><i class="bi bi-lock-fill"></i> Confirmar contraseña</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Repite tu contraseña">
            <x-input-error :messages="$errors->get('password_confirmation')" class="error" />
        </div>

        <button type="submit" class="btn-submit">
            <i class="bi bi-person-plus"></i> Crear cuenta
        </button>

        <div class="auth-links">
            ¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión</a>
        </div>
    </form>
</x-guest-layout>
