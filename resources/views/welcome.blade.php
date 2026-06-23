<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Peter Market') }}</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="bg-light">
        <div class="container py-5 text-center">
            <h1 class="display-4 fw-bold">{{ config('app.name', 'Peter Market') }}</h1>
            <p class="lead text-muted">Bienvenido a tu tienda de confianza</p>
            <a href="{{ route('tienda.index') }}" class="btn btn-lg text-white mt-3" style="background: #e65100; border-color: #e65100;">Ir a la Tienda</a>
        </div>
    </body>
</html>
