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
    Schema::table('direcciones', function (Blueprint $table) {
      $table->dropForeign(['municipio_id']);
      $table->dropForeign(['estado_id']);
      $table->dropForeign(['colonia_id']);

      $table->unsignedBigInteger('municipio_id')->nullable()->change();
      $table->unsignedBigInteger('estado_id')->nullable()->change();
      $table->unsignedBigInteger('colonia_id')->nullable()->change();

      $table->foreign('municipio_id')->references('id')->on('catalogo_municipios_api');
      $table->foreign('estado_id')->references('id')->on('catalogo_estados_api');
      $table->foreign('colonia_id')->references('id')->on('catalogo_colonias_api');
    });
  }

  public function down(): void
  {
    Schema::table('direcciones', function (Blueprint $table) {
      $table->dropForeign(['municipio_id']);
      $table->dropForeign(['estado_id']);
      $table->dropForeign(['colonia_id']);
    });
  }

};
