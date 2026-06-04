<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class GrupoChat extends Model{
    protected $fillable = ['nombre'];
    public function usuarios(){
        return $this->belongsToMany(User::class, 'grupo_chat_usuario');
    }

    public function mensajes(){
        return $this->hasMany(Mensaje::class, 'grupo_id');
    }
}