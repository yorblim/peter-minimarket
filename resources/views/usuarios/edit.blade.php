@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/create.css') }}">
@endsection

@section('content')
<div class="admin-container">

    <h1><i class="bi bi-pencil"></i> Editar Usuario</h1>

        <form action="{{ route('usuarios.update', $usuario) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Nombre completo</label>
                <input type="text" name="name" value="{{ $usuario->name }}" required>
            </div>

            <div class="form-group">
                <label>Correo electrónico</label>
                <input type="email" name="email" value="{{ $usuario->email }}" required>
            </div>

            <div class="form-group">
                <label>Nueva contraseña <small style="color:#888;">— dejar vacío para mantener actual</small></label>
                <input type="password" name="password" placeholder="••••••••">
            </div>

            <div class="form-group">
                <label>Rol</label>
                <select name="rol" required>
                    <option value="admin" {{ $usuario->rol == 'admin' ? 'selected' : '' }}>Administrador</option>
                    <option value="worker" {{ $usuario->rol == 'worker' ? 'selected' : '' }}>Trabajador</option>
                    <option value="cliente" {{ $usuario->rol == 'cliente' ? 'selected' : '' }}>Cliente</option>
                </select>
            </div>

        <div class="form-actions">
            <button class="btn-admin-save"><i class="bi bi-check-lg"></i> Actualizar usuario</button>
            <a href="{{ route('usuarios.index') }}" class="btn-admin-cancel">Volver</a>
        </div>
    </form>
</div>
@endsection
