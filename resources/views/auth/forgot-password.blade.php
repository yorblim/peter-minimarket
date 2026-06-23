<x-guest-layout>
    <x-auth-session-status class="status" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="auth-form">
        @csrf

        <p style="color:#666; font-size:0.88rem; margin-bottom:20px; text-align:center;">
            ¿Olvidaste tu contraseña? Ingresa tu correo y te enviaremos un enlace para restablecerla.
        </p>

        <div class="form-group">
            <label for="email"><i class="bi bi-envelope"></i> Correo electrónico</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="tucorreo@ejemplo.com">
            <x-input-error :messages="$errors->get('email')" class="error" />
        </div>

        <button type="submit" class="btn-submit">
            <i class="bi bi-send"></i> Enviar enlace
        </button>

        <div class="auth-links" style="margin-top:15px;">
            <a href="{{ route('login') }}"><i class="bi bi-arrow-left"></i> Volver al inicio de sesión</a>
        </div>
    </form>
</x-guest-layout>
