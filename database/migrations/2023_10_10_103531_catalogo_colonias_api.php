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
      Schema::create('catalogo_colonias_api', function (Blueprint $table) {
        $table->id();
        $table->string('descripcion', 255)->nullable(false);
        $table->string('codigo_postal', 7)->nullable(true);
        $table->boolean('activo')->default(true);

        $table->unsignedBigInteger('municipio_id');
        $table->foreign('municipio_id')->references('id')->on('catalogo_municipios_api');

        $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    Schema::dropIfExists('catalogo_colonias_api');
    }
};
