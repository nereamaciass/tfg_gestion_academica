<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asignatura extends Model{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'codigo',
        'curso',
        'color',
    ];

    public function profesores(){
        return $this->belongsToMany(
            Profesor::class,
            'profesor_asignatura',
            'asignatura_id',
            'profesor_id'
        );
    }

    public function horarios(){
        return $this->hasMany(Horario::class);
    }

    public function instrumentos(){
        return $this->hasMany(InstrumentoEvaluacion::class);
    }

    public function tiempos(){
        return $this->hasOne(TiempoAsignatura::class);
    }

    public function calendario(){
        return $this->hasMany(CalendarioAsignatura::class);
    }
}