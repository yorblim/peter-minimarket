<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            if (!Schema::hasColumn('productos', 'marca')) {
                $table->string('marca', 100)->nullable()->after('nombre');
            }
            if (!Schema::hasColumn('productos', 'precio_oferta')) {
                $table->decimal('precio_oferta', 8, 2)->nullable()->after('precio');
            }
        });
    }

    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->dropColumn(['marca', 'precio_oferta']);
        });
    }
};
