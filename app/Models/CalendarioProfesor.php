<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CalendarioProfesor extends Model{
    protected $table = 'calendario_profesor';
    protected $fillable = [
        'profesor_id',
        'asignatura_id',
        'tipo',
        'titulo',
        'descripcion',
        'fecha',
        'fecha_fin',
        'hora_inicio',
        'hora_fin'
    ];

    public function profesor(){
        return $this->belongsTo(Profesor::class);
    }

    public function asignatura(){
        return $this->belongsTo(Asignatura::class, 'asignatura_id');
    }
}