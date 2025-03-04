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
        Schema::create('evento', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_periodo')->nullable();
            $table->unsignedBigInteger('id_usuario')->nullable();
            $table->date('fecha')->nullable();
            $table->text('descripcion')->nullable();
            $table->foreign('id_periodo')->references('id')->on('periodo')->onDelete('set null');
            $table->foreign('id_usuario')->references('id')->on('usuario')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evento');
    }
};
