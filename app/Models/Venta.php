<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'ventas';

    protected $fillable = [
        'user_id',
        'subtotal',
        'igv',
        'delivery',
        'total',
        'items',
        'estado',
    ];

    protected function casts(): array
    {
        return [
            'items' => 'array',
            'subtotal' => 'decimal:2',
            'igv' => 'decimal:2',
            'delivery' => 'decimal:2',
            'total' => 'decimal:2',
            'estado' => 'string',
        ];
    }

    const ESTADOS = [
        'pendiente',
        'confirmado',
        'en_preparacion',
        'en_envio',
        'entregado',
        'cancelado',
    ];

    const TRANSICIONES = [
        'pendiente'      => ['confirmado', 'cancelado'],
        'confirmado'     => ['en_preparacion', 'cancelado'],
        'en_preparacion' => ['en_envio', 'cancelado'],
        'en_envio'       => ['entregado'],
        'entregado'      => [],
        'cancelado'      => [],
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function puedeTransicionA(string $nuevoEstado): bool
    {
        return in_array($nuevoEstado, self::TRANSICIONES[$this->estado] ?? []);
    }

    public function puedeCancelar(): bool
    {
        return in_array($this->estado, ['pendiente', 'confirmado', 'en_preparacion']);
    }

    public static function calcularIgv(float $subtotal): float
    {
        return round($subtotal * 0.18, 2);
    }

    public static function calcularDelivery(float $subtotal): ?float
    {
        if ($subtotal < 35) return null;
        if ($subtotal >= 45) return 0;
        return 5;
    }

    public static function calcularTotal(float $subtotal, ?float $delivery, float $igv): ?float
    {
        if ($delivery === null) return null;
        return round($subtotal + $igv + $delivery, 2);
    }

    public static function badgeClass(string $estado): string
    {
        return match ($estado) {
            'pendiente'      => 'badge-warning',
            'confirmado'     => 'badge-info',
            'en_preparacion'  => 'badge-primary',
            'en_envio'       => 'badge-secondary',
            'entregado'      => 'badge-success',
            'cancelado'      => 'badge-danger',
            default          => 'badge-light',
        };
    }

    public static function labelEstado(string $estado): string
    {
        return ucfirst(str_replace('_', ' ', $estado));
    }
}
