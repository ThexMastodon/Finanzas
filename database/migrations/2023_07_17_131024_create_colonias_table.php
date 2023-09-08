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
        Schema::create('colonias', function (Blueprint $table) {
          $table->id();
          $table->string('codigo_postal');
          $table->string('colonia');
          $table->unsignedBigInteger('estado_id');
          $table->unsignedBigInteger('municipio_id')->nullable();
          $table->boolean('activo')->default(true);

          $table->foreign('estado_id')->references('id')->on('estados');
          $table->foreign('municipio_id')->references('id')->on('municipios');
          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colonias');
    }
};
