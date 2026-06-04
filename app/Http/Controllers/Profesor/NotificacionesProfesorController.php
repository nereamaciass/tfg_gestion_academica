<?php

namespace App\Http\Controllers\Profesor;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotificacionesProfesorController extends Controller{
    public function index(){
        $profesor = Auth::user()->profesor;
        $notificaciones = $profesor
            ? $profesor->notificaciones()
                ->orderBy('created_at', 'desc')
                ->get()
            : collect();

        return view('profesor.notificaciones.index', compact('notificaciones'));
    }

    public function marcarLeida($id){
        $profesor = Auth::user()->profesor;

        abort_if(!$profesor, 404);

        $notificacion = $profesor->notificaciones()
            ->where('id', $id)
            ->firstOrFail();
        $notificacion->update([
            'leida' => true
        ]);

        return back();
    }
}