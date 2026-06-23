@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/usuarios.css') }}">
@endsection

@section('content')
<div class="admin-container">

    <h1><i class="bi bi-person-badge"></i> Detalle del Usuario</h1>

    <div style="background:#fff; padding:30px; border-radius:16px; box-shadow:0 2px 10px rgba(0,0,0,0.05); max-width:600px;">
        <table class="admin-table" style="margin:0;">
            <tr>
                <th style="width:120px;">ID</th>
                <td>{{ $usuario->id }}</td>
            </tr>
            <tr>
                <th>Nombre</th>
                <td>{{ $usuario->name }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $usuario->email }}</td>
            </tr>
            <tr>
                <th>Rol</th>
                <td>
                    <span class="rol-badge
                        @if($usuario->rol === 'admin') rol-admin
                        @elseif($usuario->rol === 'empleado') rol-empleado
                        @else rol-cliente
                        @endif
                    ">{{ $usuario->rol }}</span>
                </td>
            </tr>
            <tr>
                <th>Registrado</th>
                <td>{{ $usuario->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            <tr>
                <th>Actualizado</th>
                <td>{{ $usuario->updated_at->format('d/m/Y H:i') }}</td>
            </tr>
        </table>

        <div style="margin-top:25px; display:flex; gap:10px;">
            <a href="{{ route('usuarios.edit', $usuario) }}" class="btn-admin-edit" style="padding:10px 25px;">
                <i class="bi bi-pencil"></i> Editar
            </a>
            <a href="{{ route('usuarios.index') }}" class="btn-admin-cancel" style="padding:10px 25px;">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
        </div>
    </div>

</div>
@endsection
