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
      Schema::create('catalogo_municipios_api', function (Blueprint $table) {
        $table->id();
        $table->string('clave', 12)->nullable(true);
        $table->string('descripcion', 255)->nullable(false);
        $table->boolean('activo')->default(true);

        $table->unsignedBigInteger('estado_id');
        $table->foreign('estado_id')->references('id')->on('catalogo_estados_api');

        $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    Schema::dropIfExists('catalogo_municipios_api');
    }
};
