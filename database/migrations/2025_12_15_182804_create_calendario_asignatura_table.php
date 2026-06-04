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
        Schema::create('calendario_asignatura', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('asignatura_id');

            $table->string('evento');
            $table->text('descripcion')->nullable();
            $table->date('fecha');
            $table->time('hora_inicio')->nullable();
            $table->time('hora_fin')->nullable();
            $table->enum('tipo', ['actividad', 'evaluacion', 'entrega', 'otro'])->default('otro');
            $table->enum('trimestre', ['1', '2', '3'])->nullable();

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
        Schema::dropIfExists('calendario_asignatura');
    }
};
