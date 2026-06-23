<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Peter Market') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f8f6f0 0%, #fff3e0 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .auth-container {
            background: #fff;
            border-radius: 24px;
            padding: 40px 35px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.08);
            width: 100%;
            max-width: 420px;
        }
        .auth-logo {
            text-align: center;
            margin-bottom: 25px;
        }
        .auth-logo a {
            font-size: 1.6rem;
            font-weight: 800;
            color: #e65100;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .auth-logo a i {
            font-size: 2rem;
            color: #e85d04;
        }
        .auth-form label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: #555;
            margin-bottom: 5px;
        }
        .auth-form input[type="text"],
        .auth-form input[type="email"],
        .auth-form input[type="password"] {
            width: 100%;
            padding: 11px 14px;
            border: 2px solid #e8e5d9;
            border-radius: 10px;
            font-size: 0.92rem;
            background: #faf9f6;
            transition: all 0.3s;
            outline: none;
            margin-bottom: 5px;
        }
        .auth-form input:focus {
            border-color: #e65100;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(230,81,0,0.1);
        }
        .auth-form .error { color: #dc3545; font-size: 0.8rem; margin-top: 3px; }
        .auth-form .form-group { margin-bottom: 16px; }
        .auth-form .checkbox-group {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 10px 0;
        }
        .auth-form .checkbox-group label {
            font-size: 0.85rem;
            color: #666;
            margin: 0;
        }
        .auth-form .btn-submit {
            width: 100%;
            padding: 13px;
            background: #e65100;
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
        }
        .auth-form .btn-submit:hover {
            background: #8d2e00;
            transform: translateY(-1px);
        }
        .auth-links {
            text-align: center;
            margin-top: 18px;
            font-size: 0.88rem;
            color: #888;
        }
        .auth-links a {
            color: #e65100;
            font-weight: 600;
            text-decoration: none;
        }
        .auth-links a:hover {
            text-decoration: underline;
        }
        .auth-back {
            text-align: center;
            margin-top: 15px;
        }
        .auth-back a {
            color: #888;
            text-decoration: none;
            font-size: 0.85rem;
        }
        .auth-back a:hover {
            color: #e65100;
        }
        .auth-form .status {
            background: #d4edda;
            color: #155724;
            padding: 10px 14px;
            border-radius: 10px;
            margin-bottom: 15px;
            font-size: 0.85rem;
            border-left: 4px solid #28a745;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-logo">
            <a href="{{ route('tienda.index') }}">
                <i class="bi bi-shop"></i> Peter Market
            </a>
        </div>

        {{ $slot }}
    </div>

    <div class="auth-back">
        <a href="{{ route('tienda.index') }}"><i class="bi bi-arrow-left"></i> Volver a la tienda</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
