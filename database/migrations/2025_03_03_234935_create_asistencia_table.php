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
        Schema::create('asistencia', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_justificacion')->nullable();
            $table->unsignedBigInteger('id_colaborador')->nullable();
            $table->date('fecha')->nullable();
            $table->time('hora_entrada')->nullable();
            $table->time('hora_salida')->nullable();
            $table->boolean('inasistencia')->nullable();
            $table->boolean('tardanza')->nullable();
            $table->string('justificada', 255)->nullable();
            $table->foreign('id_justificacion')->references('id')->on('justificacion')->onDelete('set null');
            $table->foreign('id_colaborador')->references('id')->on('colaborador')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistencia');
    }
};
