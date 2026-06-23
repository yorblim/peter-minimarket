@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/usuarios.css') }}">
@endsection

@section('content')
<div class="admin-container">

    <h1><i class="bi bi-people"></i> Clientes Registrados</h1>

    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre completo</th>
                <th>Email</th>
                <th>Fecha de registro</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clientes as $cliente)
            <tr>
                <td>{{ $cliente->id }}</td>
                <td>{{ $cliente->name }}</td>
                <td>{{ $cliente->email }}</td>
                <td>{{ $cliente->created_at->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection
