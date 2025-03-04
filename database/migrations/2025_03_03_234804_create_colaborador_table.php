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
        Schema::create('colaborador', function (Blueprint $table) {
            $table->id(); // Columna 'id' como PRIMARY KEY
            $table->unsignedBigInteger('id_horario')->nullable(); // Asegúrate de que sea unsignedBigInteger
            $table->string('tipo_contrato', 255)->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->string('tipo_colaborador', 255)->nullable();
            $table->string('estado', 3);
            $table->unsignedBigInteger('id_usuario')->nullable();
            $table->unsignedBigInteger('creado_por')->nullable();

            // Claves foráneas
            $table->foreign('id_horario')->references('id')->on('horario')->onDelete('set null');
            $table->foreign('id_usuario')->references('id')->on('usuario')->onDelete('set null');
            $table->foreign('creado_por')->references('id')->on('usuario')->onDelete('set null');

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colaborador');
    }
};
