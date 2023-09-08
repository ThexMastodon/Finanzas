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
        Schema::create('fianza_cheques', function (Blueprint $table) {
            $table->id();
            $table->string('no_fianza_cheque', 255)->nullable();
            $table->string('nombre', 255)->nullable();
            $table->string('apellido_paterno', 255)->nullable();
            $table->string('apellido_materno', 255)->nullable();
            $table->string('tipo_persona', 20)->nullable();
            $table->date('fecha_expedicion')->nullable();
            $table->date('fecha_vencimiento')->nullable();
            $table->date('fecha_captura')->nullable();
            $table->string('expedido_por', 200)->nullable();
            $table->string('a_favor', 45)->nullable();
            $table->string('importe', 45)->nullable();
            $table->string('licitación', 45)->nullable();
            $table->string('concepto', 45)->nullable();
            $table->string('oficio', 45)->nullable();
            $table->string('fecha_oficio', 45)->nullable();
            $table->string('direccion_historico', 500)->nullable();
            $table->timestamps();

            $table->unsignedBigInteger('afianzadoras_id')->nullable();
            $table->foreign('afianzadoras_id')->references('id')->on('afianzadoras');

            $table->unsignedBigInteger('tipo_id');
            $table->foreign('tipo_id')->references('id')->on('tipo');

            $table->unsignedBigInteger('estatus_id')->nullable();
            $table->foreign('estatus_id')->references('id')->on('estatus');

            $table->unsignedBigInteger('direccion_id')->nullable();
            $table->foreign('direccion_id')->references('id')->on('direcciones');

            $table->index('no_fianza_cheque');
            $table->index('nombre');
            $table->index('apellido_paterno');
            $table->index('apellido_materno');
            $table->index('tipo_persona');
            $table->index('fecha_expedicion');
            $table->index('fecha_vencimiento');
            $table->index('fecha_captura');
            $table->index('expedido_por');
            $table->index('a_favor');
            $table->index('importe');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fianza_cheques');
    }
};
