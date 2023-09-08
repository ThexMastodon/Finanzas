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
        Schema::create('direcciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('municipio_id')->nullable();
            $table->unsignedBigInteger('estado_id')->nullable();
            $table->unsignedBigInteger('colonia_id')->nullable();
            $table->string('calle', 255)->nullable();
            $table->string('codigo_postal', 5)->nullable();
            $table->string('no_interior', 10)->nullable();
            $table->string('no_exterior', 10)->nullable();
            $table->mediumText('referencia')->nullable();
            $table->timestamps();

            $table->foreign('municipio_id')->references('id')->on('municipios');
            $table->foreign('estado_id')->references('id')->on('estados');
            $table->foreign('colonia_id')->references('id')->on('colonias');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('direcciones');
    }
};
