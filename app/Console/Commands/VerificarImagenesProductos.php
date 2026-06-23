<?php

namespace App\Console\Commands;

use App\Models\Producto;
use Illuminate\Console\Command;

class VerificarImagenesProductos extends Command
{
    protected $signature = 'productos:verificar-imagenes';
    protected $description = 'Verifica que cada producto tenga su archivo de imagen en el almacenamiento local';

    public function handle(): void
    {
        $productos = Producto::all();
        $storagePath = storage_path('app/public');
        $errores = 0;
        $ok = 0;

        $bar = $this->output->createProgressBar($productos->count());
        $bar->start();

        foreach ($productos as $producto) {
            $rutaCompleta = $storagePath . '/' . $producto->imagen;

            if (!file_exists($rutaCompleta)) {
                $bar->clear();
                $this->error("Falta: {$producto->imagen} (ID {$producto->id}: {$producto->nombre})");
                $bar->display();
                $errores++;
            } else {
                $ok++;
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        $total = $productos->count();
        $this->info("Resumen: {$ok}/{$total} imágenes OK, {$errores} faltantes.");

        if ($errores > 0) {
            $this->warn("Ejecuta 'php artisan productos:descargar-imagenes' para descargar las imágenes faltantes.");
        }
    }
}
