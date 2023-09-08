<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('submodulos', function (Blueprint $table) {
      $table->id();
      $table->string('nombre');
      $table->string('ruta');
      $table->string('icono')->nullable();
      $table->string('color_icono')->nullable();
      $table->boolean('status');
      $table->unsignedBigInteger('modulo_id');
      $table->foreign('modulo_id')->references('id')->on('modulos');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('submodulos');
  }
};
