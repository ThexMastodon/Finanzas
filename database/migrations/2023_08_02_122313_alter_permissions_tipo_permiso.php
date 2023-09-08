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
    Schema::table('permissions', function (Blueprint $table) {
      // Agregar la columna para la clave foránea de tipo_permiso_id
      $table->unsignedBigInteger('tipo_permiso_id')->nullable();

      // Agregar la restricción de clave foránea
      $table->foreign('tipo_permiso_id')->references('id')->on('tipo_permiso');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('permissions', function (Blueprint $table) {
      // Eliminar la restricción de clave foránea antes de eliminar la columna
      $table->dropForeign(['tipo_permiso_id']);

      // Eliminar la columna de la clave foránea
      $table->dropColumn('tipo_permiso_id');
    });
  }
};
