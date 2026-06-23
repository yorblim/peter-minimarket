@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/usuarios.css') }}">
@endsection

@section('content')
<div class="admin-container">

    <h1><i class="bi bi-tag"></i> {{ $categoria->nombre }}</h1>

    <div style="margin-bottom:20px;">
        <a href="{{ route('categorias.edit', $categoria) }}" class="btn-admin-add" style="display:inline-flex;">
            <i class="bi bi-pencil"></i> Editar categoría
        </a>
        <a href="{{ route('categorias.index') }}" class="btn-admin-edit" style="padding:10px 25px; margin-left:8px;">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>

    <h2 style="font-size:1.1rem; color:#555; margin-bottom:12px;">
        Productos en esta categoría ({{ $categoria->productos->count() }})
    </h2>

    @if($categoria->productos->count() > 0)
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Marca</th>
                <th>Precio</th>
                <th>Stock</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categoria->productos as $p)
            <tr>
                <td>{{ $p->id }}</td>
                <td>{{ $p->nombre }}</td>
                <td>{{ $p->marca ?? '—' }}</td>
                <td>S/ {{ number_format($p->precio_oferta ?? $p->precio, 2) }}</td>
                <td>{{ $p->stock }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
        <p style="color:#888;">No hay productos en esta categoría.</p>
    @endif

</div>
@endsection
