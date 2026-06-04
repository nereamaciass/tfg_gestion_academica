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
        Schema::create('profesor_asignatura', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('profesor_id');
            $table->unsignedBigInteger('asignatura_id');

            $table->foreign('profesor_id')->references('id')->on('profesores')->onDelete('cascade');
            $table->foreign('asignatura_id')->references('id')->on('asignaturas')->onDelete('cascade');

            $table->unique(['profesor_id', 'asignatura_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profesor_asignatura');
    }
};
