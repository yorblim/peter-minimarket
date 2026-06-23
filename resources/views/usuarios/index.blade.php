@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/usuarios.css') }}">
@endsection

@section('content')
<div class="admin-container">

    <h1><i class="bi bi-people"></i> Lista de Usuarios</h1>

    <a href="{{ route('usuarios.create') }}" class="btn-admin-add">
        <i class="bi bi-plus-circle"></i> Crear Usuario
    </a>

    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($usuarios as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <span class="rol-badge
                        @if($user->rol === 'admin') rol-admin
                        @elseif($user->rol === 'worker') rol-worker
                        @else rol-cliente
                        @endif
                    ">{{ $user->rol }}</span>
                </td>
                <td>
                    <a href="{{ route('usuarios.edit', $user) }}" class="btn-admin-edit">
                        <i class="bi bi-pencil"></i> Editar
                    </a>
                    <form action="{{ route('usuarios.destroy', $user) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn-admin-delete" onclick="return confirm('¿Eliminar este usuario?')">
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
