@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/create.css') }}">
@endsection

@section('content')
<div class="admin-container">

    <h1><i class="bi bi-person-plus"></i> Crear Usuario</h1>

    <form action="{{ route('usuarios.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Nombre completo</label>
            <input type="text" name="name" required>
        </div>

        <div class="form-group">
            <label>Correo electrónico</label>
            <input type="email" name="email" required>
        </div>

        <div class="form-group">
            <label>Contraseña</label>
            <input type="password" name="password" required>
        </div>

        <div class="form-group">
            <label>Rol</label>
            <select name="rol" required>
                <option value="admin">Administrador</option>
                <option value="worker">Trabajador</option>
            </select>
        </div>

        <div class="form-actions">
            <button class="btn-admin-save"><i class="bi bi-check-lg"></i> Guardar usuario</button>
            <a href="{{ route('usuarios.index') }}" class="btn-admin-cancel">Volver</a>
        </div>
    </form>
</div>
@endsection
