<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Profesor;

class Notificacion extends Model{
    protected $table = 'notificaciones';
    protected $fillable = [
        'profesor_id',
        'titulo',
        'mensaje',
        'leida',
    ];

    protected $casts = [
        'leida' => 'boolean',
    ];

    public function profesor(){
        return $this->belongsTo(Profesor::class, 'profesor_id');
    }
}