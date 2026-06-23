<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\DashboardController;


Route::post('/categorias/store-ajax', [CategoriaController::class, 'storeAjax'])
    ->middleware(['auth', 'role:admin'])
    ->name('categorias.store.ajax');


Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/clientes', [UserController::class, 'clientes'])->name('clientes.index');
});


// 🔥 Rutas protegidas SOLO para Admin (Usuarios / Trabajadores)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('usuarios', UserController::class);
});


// 🛒 Carrito (solo usuarios logeados)
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
});


// 🧾 Checkout (solo usuarios logueados)
Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
});


// 🛍️ Página principal (tienda pública)
Route::get('/', [ProductoController::class, 'publicIndex'])->name('tienda.index');


// 📌 Dashboard con estadísticas (admin y empleado)
Route::middleware(['auth', 'role:admin,empleado'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});


// 🔥 Rutas protegidas para Admin y Empleado (Productos)
Route::middleware(['auth', 'role:admin,empleado'])->group(function () {
    Route::resource('productos', ProductoController::class);
});

// 🔥 Rutas protegidas para Admin y Empleado (Categorías)
Route::middleware(['auth', 'role:admin,empleado'])->group(function () {
    Route::resource('categorias', CategoriaController::class)->except(['storeAjax']);
});


// 📦 Gestión de pedidos (admin y empleado)
Route::middleware(['auth', 'role:admin,empleado'])->group(function () {
    Route::get('/ventas', [VentaController::class, 'index'])->name('ventas.index');
    Route::get('/ventas/{venta}', [VentaController::class, 'show'])->name('ventas.show');
    Route::patch('/ventas/{venta}/estado', [VentaController::class, 'updateEstado'])->name('ventas.updateEstado');
});


// 👤 Mis pedidos (cliente)
Route::middleware('auth')->group(function () {
    Route::get('/mis-pedidos', [VentaController::class, 'misPedidos'])->name('ventas.mis-pedidos');
    Route::patch('/mis-pedidos/{venta}/cancelar', [VentaController::class, 'cancelar'])->name('ventas.cancelar');
});


// 👤 Perfil de Usuario
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';
