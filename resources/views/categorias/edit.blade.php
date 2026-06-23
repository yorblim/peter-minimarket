@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/usuarios.css') }}">
<style>
    .form-group { margin-bottom: 18px; }
    .form-group label { display: block; font-weight: 600; color: #2d3748; margin-bottom: 5px; font-size: 0.9rem; }
    .form-group input { width: 100%; padding: 10px 14px; border: 1.5px solid #d0d0d0; border-radius: 10px; font-size: 0.9rem; outline: none; }
    .form-group input:focus { border-color: #e65100; }
    .btn-admin-save { background: #e65100; color: #fff; padding: 10px 25px; border: none; border-radius: 10px; font-weight: 600; cursor: pointer; }
    .btn-admin-save:hover { background: #8d2e00; }
    .btn-admin-cancel { display: inline-block; background: #f0ede4; color: #555; padding: 10px 25px; border-radius: 10px; text-decoration: none; font-weight: 600; margin-left: 8px; }
    .btn-admin-cancel:hover { background: #e0dcd0; color: #333; }
</style>
@endsection

@section('content')
<div class="admin-container">

    <h1><i class="bi bi-tag"></i> Editar Categoría</h1>

    <form action="{{ route('categorias.update', $categoria) }}" method="POST" style="max-width:450px;">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nombre de la categoría</label>
            <input type="text" name="nombre" value="{{ old('nombre', $categoria->nombre) }}" required>
            @error('nombre') <small style="color:#dc3545;">{{ $message }}</small> @enderror
        </div>

        <div>
            <button class="btn-admin-save"><i class="bi bi-check-lg"></i> Actualizar</button>
            <a href="{{ route('categorias.index') }}" class="btn-admin-cancel">Cancelar</a>
        </div>
    </form>

</div>
@endsection
