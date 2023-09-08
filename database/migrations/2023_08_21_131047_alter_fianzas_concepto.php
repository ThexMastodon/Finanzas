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
      Schema::table('fianza_cheques', function (Blueprint $table) {
        $table->text('concepto')->nullable()->change();
        $table->string('a_favor', 100)->nullable()->change();
        $table->string('licitación', 255)->nullable()->change();
        $table->dropColumn('fecha_oficio')->change();
        $table->dropColumn('oficio')->change();
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      Schema::table('fianza_cheques', function (Blueprint $table) {
        $table->string('concepto', 45)->nullable()->change();
        $table->string('a_favor', 45)->nullable()->change();
        $table->string('licitación', 45)->nullable()->change();
        $table->string('fecha_oficio', 45)->nullable()->change();
        $table->string('oficio', 45)->nullable()->change();
      });
    }
};
