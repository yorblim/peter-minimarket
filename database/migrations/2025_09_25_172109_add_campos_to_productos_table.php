<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            if (!Schema::hasColumn('productos', 'nombre')) {
                $table->string('nombre');
            }
            if (!Schema::hasColumn('productos', 'precio')) {
                $table->decimal('precio', 8, 2);
            }
            if (!Schema::hasColumn('productos', 'stock')) {
                $table->integer('stock');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            if (Schema::hasColumn('productos', 'nombre')) {
                $table->dropColumn('nombre');
            }
            if (Schema::hasColumn('productos', 'precio')) {
                $table->dropColumn('precio');
            }
            if (Schema::hasColumn('productos', 'stock')) {
                $table->dropColumn('stock');
            }
        });
    }
};
