<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\Auth;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cancelados', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_cancelacion')->nullable();
            $table->string('oficio', 300)->nullable();
            $table->date('fecha_oficio')->nullable();
            $table->timestamps();

            $user_id = Auth::id();

            $table->unsignedBigInteger('users_id')->default($user_id)->nullable();
            $table->foreign('users_id')->references('id')->on('users');


            $table->unsignedBigInteger('afianzadoras_id')->nullable();
            $table->foreign('afianzadoras_id')->references('id')->on('afianzadoras');

            $table->unsignedBigInteger('fianza_cheque_id')->nullable();
            $table->foreign('fianza_cheque_id')->references('id')->on('fianza_cheques');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cancelados');
    }
};
