@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/create.css') }}">
@endsection

@section('content')
<div class="admin-container">

    <h1><i class="bi bi-pencil"></i> Editar Producto</h1>

    <form action="{{ route('productos.update', $producto) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nombre del Producto</label>
            <input type="text" name="nombre" value="{{ $producto->nombre }}" required>
        </div>

        <div class="form-group">
            <label>Marca</label>
            <input type="text" name="marca" value="{{ $producto->marca }}" placeholder="Ej: Gloria, Don Vittorio...">
        </div>

        <div class="form-group">
            <label>Categoría</label>
            <select name="categoria_id" required>
                <option value="">Seleccionar categoría</option>
                @foreach($categorias as $cat)
                    <option value="{{ $cat->id }}" {{ $producto->categoria_id == $cat->id ? 'selected' : '' }}>
                        {{ $cat->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Precio regular (S/)</label>
            <input type="number" step="0.01" name="precio" value="{{ $producto->precio }}" required>
        </div>

        <div class="form-group">
            <label>Precio de oferta (S/) <small style="color:#888;">— opcional</small></label>
            <input type="number" step="0.01" name="precio_oferta" value="{{ $producto->precio_oferta }}" placeholder="Dejar vacío si no hay oferta">
        </div>

        <div class="form-group">
            <label>Stock</label>
            <input type="number" name="stock" value="{{ $producto->stock }}" required min="0">
        </div>

        <div class="form-group">
            <label>Imagen actual</label><br>
            @if($producto->imagen)
                @php
                    $src = str_starts_with($producto->imagen, 'http') ? $producto->imagen : asset('storage/' . $producto->imagen);
                @endphp
                <img src="{{ $src }}" alt="{{ $producto->nombre }}" style="max-height:100px; margin-bottom:8px;">
            @else
                <p style="color:#888;">Sin imagen</p>
            @endif
            <input type="file" name="imagen" accept="image/jpeg,image/png,image/webp">
            <small style="color:#888;">Dejar vacío para mantener la imagen actual</small>
        </div>

        <div class="form-actions">
            <button class="btn-admin-save"><i class="bi bi-check-lg"></i> Actualizar producto</button>
            <a href="{{ route('productos.index') }}" class="btn-admin-cancel">Cancelar</a>
        </div>
    </form>
</div>
@endsection
