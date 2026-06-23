<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DescargarImagenesProductos extends Command
{
    protected $signature = 'productos:descargar-imagenes';
    protected $description = 'Descarga imágenes de productos desde Pixabay al almacenamiento local';

    private array $productos = [
        ['nombre' => 'leche-gloria',           'url' => 'https://images.unsplash.com/photo-1563636619-e9143da7973b?w=600'],
        ['nombre' => 'yogurt-gloria',          'url' => 'https://images.unsplash.com/photo-1488477181946-6428a0291777?w=600'],
        ['nombre' => 'queso-don-jorge',        'url' => 'https://images.unsplash.com/photo-1634487359989-3e90c9432133?w=600'],
        ['nombre' => 'pechuga-pollosf',        'url' => 'https://images.unsplash.com/photo-1604503468506-a8da13d82791?w=600'],
        ['nombre' => 'carne-molida-sf',        'url' => 'https://images.unsplash.com/photo-1607623814075-e51df1bdc82f?w=600'],
        ['nombre' => 'chuletas-cerdo-sf',      'url' => 'https://images.unsplash.com/photo-1602491453631-e2a5ad90a131?w=600'],
        ['nombre' => 'manzana-israel',         'url' => 'https://images.unsplash.com/photo-1560806887-1e4cd0b6cbd6?w=600'],
        ['nombre' => 'platano-seda',           'url' => 'https://images.unsplash.com/photo-1571771894821-ce9b6c11b08e?w=600'],
        ['nombre' => 'tomate-italiano',        'url' => 'https://images.unsplash.com/photo-1592924357228-91a4daadcfea?w=600'],
        ['nombre' => 'papa-amarilla',          'url' => 'https://images.unsplash.com/photo-1518977676601-b53f82aba655?w=600'],
        ['nombre' => 'arroz-costeno',          'url' => 'https://images.unsplash.com/photo-1591814468924-caf88d1232e1?w=600'],
        ['nombre' => 'aceite-primor',          'url' => 'https://images.unsplash.com/photo-1474979266404-7eaacbcd87c5?w=600'],
        ['nombre' => 'azucar-cartavio',        'url' => 'https://images.unsplash.com/photo-1585238342024-78d387f4a707?w=600'],
        ['nombre' => 'fideos-don-vittorio',    'url' => 'https://images.unsplash.com/photo-1569562211093-4ed0d0758f12?w=600'],
        ['nombre' => 'lentejas-costeno',       'url' => 'https://images.unsplash.com/photo-1512626120412-faf41adb4874?w=600'],
        ['nombre' => 'atun-florida',           'url' => 'https://images.unsplash.com/photo-1534604973900-c43ab4c2e0ab?w=600'],
        ['nombre' => 'cocacola',               'url' => 'https://images.unsplash.com/photo-1622483767028-3f66f32aef97?w=600'],
        ['nombre' => 'agua-san-luis',          'url' => 'https://images.unsplash.com/photo-1548839140-29a749e1cf4d?w=600'],
        ['nombre' => 'jugo-cifrut',            'url' => 'https://images.unsplash.com/photo-1621506289937-a8e4df240d0b?w=600'],
        ['nombre' => 'lejia-patito',           'url' => 'https://images.unsplash.com/photo-1607613009820-a29f7bb81c04?w=600'],
        ['nombre' => 'detergente-ace',         'url' => 'https://images.unsplash.com/photo-1585421514284-efb74c2b69ba?w=600'],
        ['nombre' => 'lavavajillas-ayudin',    'url' => 'https://images.unsplash.com/photo-1601049541289-9b1b7bbbfe19?w=600'],
        ['nombre' => 'desinfectante-sapolio',  'url' => 'https://images.unsplash.com/photo-1581578731548-c64695cc6952?w=600'],
    ];

    public function handle(): void
    {
        $destino = storage_path('app/public/productos');
        $this->info("Descargando " . count($this->productos) . " imágenes a {$destino}");

        $bar = $this->output->createProgressBar(count($this->productos));
        $bar->start();

        foreach ($this->productos as $item) {
            $archivo = $destino . '/' . $item['nombre'] . '.jpg';

            if (file_exists($archivo)) {
                $bar->advance();
                continue;
            }

            try {
                $context = stream_context_create([
                    'http' => [
                        'timeout' => 15,
                        'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                        'follow_location' => true,
                    ],
                    'ssl' => ['verify_peer' => false, 'verify_peer_name' => false],
                ]);

                $imagen = @file_get_contents($item['url'], false, $context);

                if ($imagen !== false) {
                    file_put_contents($archivo, $imagen);
                } else {
                    $this->warn("\nFalló: {$item['nombre']}");
                }
            } catch (\Exception $e) {
                $this->warn("\nError descargando {$item['nombre']}: {$e->getMessage()}");
            }

            $bar->advance();
            usleep(300000);
        }

        $bar->finish();
        $this->newLine(2);
        $this->info('Descarga completada.');
    }
}
