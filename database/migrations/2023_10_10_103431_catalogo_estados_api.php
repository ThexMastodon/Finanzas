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
      Schema::create('catalogo_estados_api', function (Blueprint $table) {
        $table->id();
        $table->string('estado_id', 3)->unique();
        $table->string('clave', 5)->unique();
        $table->string('descripcion', 255)->nullable(false);

        $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    Schema::dropIfExists('catalogo_estados_api');
    }
};
