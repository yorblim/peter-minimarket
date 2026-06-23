@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
<div class="profile-card">

    <span class="profile-icon">👤</span>
    <h2 class="profile-title">Mi Perfil</h2>

    {{-- Mensajes de éxito --}}
    @if (session('status') === 'profile-updated')
        <div class="alert alert-success">Perfil actualizado correctamente.</div>
    @endif

    @if (session('status') === 'password-updated')
        <div class="alert alert-success">Contraseña actualizada correctamente.</div>
    @endif

    {{-- Error de contraseña incorrecta --}}
    @if (session('error_password'))
        <div class="alert alert-danger">
            {{ session('error_password') }}
        </div>
    @endif

    {{-- Errores de validación generales --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul style="margin:0; padding-left:20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    {{-- 🔹 Formulario de datos básicos (nombre / email) --}}
    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PATCH')

        <label class="form-label">Nombre completo</label>
        <input type="text" name="name" class="form-control"
               value="{{ old('name', $user->name) }}" required>

        <label class="form-label">Correo electrónico</label>
        <input type="email" name="email" class="form-control"
               value="{{ old('email', $user->email) }}" required>

        <label class="form-label">Rol</label>
        <input type="text" class="form-control" value="{{ $user->rol }}" readonly>

        <button class="btn-save">💾 Guardar cambios</button>
    </form>

    {{-- Botón para abrir modal de cambio de contraseña --}}
    <div style="margin-top: 1.5rem; text-align:center;">
        <button type="button" class="btn-change-pass" data-bs-toggle="modal" data-bs-target="#modalPassword">
            🔑 Cambiar contraseña
        </button>
    </div>

</div>


{{-- 🔥 MODAL CAMBIO DE CONTRASEÑA --}}
<div class="modal fade" id="modalPassword" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Cambiar contraseña</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PATCH')

                {{-- Marcador para que el controlador sepa que esto es un cambio de contraseña --}}
                <input type="hidden" name="change_password" value="1">

                {{-- También enviamos nombre y email actuales para que pase la ProfileUpdateRequest --}}
                <input type="hidden" name="name" value="{{ $user->name }}">
                <input type="hidden" name="email" value="{{ $user->email }}">

                <div class="modal-body">

                    <label class="form-label">Contraseña actual</label>
                    <input type="password" name="current_password" class="form-control" required>

                    <label class="form-label mt-3">Nueva contraseña</label>
                    <input type="password" name="password" class="form-control" required>

                    <label class="form-label mt-3">Confirmar nueva contraseña</label>
                    <input type="password" name="password_confirmation" class="form-control" required>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Guardar contraseña
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection
