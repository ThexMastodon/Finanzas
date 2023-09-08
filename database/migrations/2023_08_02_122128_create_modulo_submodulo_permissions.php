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
    Schema::create('modulo_submodulo_permissions', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('modulo_id')->nullable();
      $table->unsignedBigInteger('submodulo_id')->nullable();
      $table->unsignedBigInteger('permission_id');
      $table->timestamps();

      $table->foreign('modulo_id')->references('id')->on('modulos')->onDelete('cascade');
      $table->foreign('submodulo_id')->references('id')->on('submodulos')->onDelete('cascade');
      $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');

    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('modulo_submodulo_permissions');
  }
};
