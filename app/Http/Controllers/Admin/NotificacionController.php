<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Notificacion;
use App\Models\Profesor;
use Illuminate\Http\Request;

class NotificacionController extends Controller{
    public function index(){
        $notificaciones = Notificacion::with('profesor')
            ->latest()
            ->paginate(15);

        return view('admin.notificaciones.index', compact('notificaciones'));
    }

    public function create(){
        $profesores = Profesor::orderBy('nombre')->get();

        return view('admin.notificaciones.create', compact('profesores'));
    }

    public function store(Request $request){
        $request->validate([
            'profesor_id' => 'required|exists:profesores,id',
            'titulo' => 'required|string|max:255',
            'mensaje' => 'required|string',
        ]);

        Notificacion::create([
            'profesor_id' => $request->profesor_id,
            'titulo' => $request->titulo,
            'mensaje' => $request->mensaje,
            'leida' => false,
        ]);

        return redirect()
            ->route('admin.notificaciones.index')
            ->with('success', 'Notificación enviada correctamente.');
    }

    public function destroy($id){
        $notificacion = Notificacion::findOrFail($id);
        $notificacion->delete();

        return redirect()
            ->route('admin.notificaciones.index')
            ->with('success', 'Notificación eliminada correctamente.');
    }

    public function show($id){
        $notificacion = Notificacion::with('profesor')->findOrFail($id);
        
        return view('admin.notificaciones.show', compact('notificacion'));
    }
}