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
        Schema::create('tipo_colaborador', function (Blueprint $table) {
            $table->id();  // Columna id como PRIMARY KEY
            $table->string('nombre', 255)->nullable();
            $table->text('imagen');
            $table->text('descripcion')->nullable();
            $table->unsignedBigInteger('id_usuario')->nullable(); // Asegúrate de usar unsignedBigInteger para id_usuario
            
            // Clave foránea
            $table->foreign('id_usuario')->references('id')->on('usuario')->onDelete('set null');
            
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_colaborador');
    }
};
