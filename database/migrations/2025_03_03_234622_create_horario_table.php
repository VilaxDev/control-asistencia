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
        Schema::create('horario', function (Blueprint $table) {
            $table->id();  // Crea la columna 'id' como PRIMARY KEY
            $table->string('nom_horario', 255)->nullable();
            $table->time('hora_entrada')->nullable();
            $table->time('hora_salida')->nullable();
            $table->timestamp('fecha_creacion')->nullable();
            $table->longText('dias_laborales');

            // Asegúrate de usar unsignedBigInteger para el campo 'id_usuario'
            $table->unsignedBigInteger('id_usuario')->nullable();

            // Definir la clave foránea
            $table->foreign('id_usuario')->references('id')->on('usuario')->onDelete('set null');

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horario');
    }
};
