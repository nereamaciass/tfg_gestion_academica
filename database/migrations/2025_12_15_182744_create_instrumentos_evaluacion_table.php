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
        Schema::create('instrumentos_evaluacion', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('asignatura_id');

            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->integer('porcentaje')->default(0);
            $table->date('fecha')->nullable();

            $table->timestamps();

            $table->foreign('asignatura_id')
                ->references('id')->on('asignaturas')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instrumentos_evaluacion');
    }
};
