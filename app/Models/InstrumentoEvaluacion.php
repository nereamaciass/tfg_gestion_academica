<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class InstrumentoEvaluacion extends Model{
    protected $table = 'instrumentos_evaluacion';
    protected $fillable = [
        'asignatura_id',
        'titulo',
        'descripcion',
        'porcentaje'
    ];

    public function asignatura(){
        return $this->belongsTo(Asignatura::class);
    }
}