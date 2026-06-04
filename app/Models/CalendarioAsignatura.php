<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CalendarioAsignatura extends Model{
    protected $table = 'calendario_asignatura';
    protected $fillable = [
        'asignatura_id',
        'titulo',
        'descripcion',
        'fecha_inicio',
        'fecha_fin'
    ];

    public function asignatura(){
        return $this->belongsTo(Asignatura::class);
    }
}
