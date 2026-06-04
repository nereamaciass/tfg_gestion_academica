<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profesor extends Model{
    use HasFactory;

    protected $table = 'profesores';
    protected $fillable = [
        'nombre',
        'email',
        'telefono',
        'departamento',
        'user_id',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function asignaturas(){
        return $this->belongsToMany(Asignatura::class, 'profesor_asignatura', 'profesor_id', 'asignatura_id');
    }

    public function horarios(){
        return $this->hasMany(Horario::class, 'profesor_id');
    }

    public function notificaciones(){
        return $this->hasMany(Notificacion::class, 'profesor_id');
    }

    public function calendario(){
        return $this->hasMany(CalendarioProfesor::class);
    }
}