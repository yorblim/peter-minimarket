@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/productos.css') }}">
@endsection

@section('content')
<div class="admin-container">
    <h1><i class="bi bi-box-seam"></i> Lista de Productos</h1>

    <a href="{{ route('productos.create') }}" class="btn-admin-add">
        <i class="bi bi-plus-circle"></i> Agregar producto
    </a>

    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Marca</th>
                <th>Categoría</th>
                <th>Precio</th>
                <th>Oferta</th>
                <th>Stock</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productos as $producto)
                <tr>
                    <td>{{ $producto->id_producto }}</td>
                    <td>{{ $producto->nombre }}</td>
                    <td>{{ $producto->marca ?? '—' }}</td>
                    <td>{{ $producto->categoria->nombre ?? 'Sin categoría' }}</td>
                    <td>S/ {{ number_format($producto->precio, 2) }}</td>
                    <td>
                        @if($producto->precio_oferta)
                            <span style="color:#dc3545;font-weight:600;">S/ {{ number_format($producto->precio_oferta, 2) }}</span>
                        @else
                            —
                        @endif
                    </td>
                    <td>{{ $producto->stock }}</td>
                    <td>
                        <a href="{{ route('productos.edit', $producto) }}" class="btn-admin-edit">
                            <i class="bi bi-pencil"></i> Editar
                        </a>
                        @if(auth()->user()->rol === 'admin')
                        <form action="{{ route('productos.destroy', $producto) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-admin-delete" onclick="return confirm('¿Eliminar este producto?')">
                                <i class="bi bi-trash3"></i> Eliminar
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
