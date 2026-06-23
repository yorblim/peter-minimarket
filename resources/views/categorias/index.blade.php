@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/usuarios.css') }}">
@endsection

@section('content')
<div class="admin-container">

    <h1><i class="bi bi-tags"></i> Categorías</h1>

    <a href="{{ route('categorias.create') }}" class="btn-admin-add">
        <i class="bi bi-plus-circle"></i> Nueva Categoría
    </a>

    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Productos</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categorias as $cat)
            <tr>
                <td>{{ $cat->id }}</td>
                <td>{{ $cat->nombre }}</td>
                <td>{{ $cat->productos_count }}</td>
                <td>
                    <a href="{{ route('categorias.show', $cat) }}" class="btn-admin-edit">
                        <i class="bi bi-eye"></i> Ver
                    </a>
                    <a href="{{ route('categorias.edit', $cat) }}" class="btn-admin-edit">
                        <i class="bi bi-pencil"></i> Editar
                    </a>
                    <form action="{{ route('categorias.destroy', $cat) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn-admin-delete" onclick="return confirm('¿Eliminar esta categoría?')">
                            <i class="bi bi-trash3"></i> Eliminar
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection
