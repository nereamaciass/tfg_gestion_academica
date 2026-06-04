<?php

namespace App\Http\Controllers\Profesor;
use App\Http\Controllers\Controller;
use App\Models\CalendarioProfesor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendarioProfesorController extends Controller{
    public function index(){
        $profesor = Auth::user()->profesor;
        $asignaturas = $profesor
            ? $profesor->asignaturas()->orderBy('nombre')->get()
            : collect();
        $eventos = $profesor
            ? CalendarioProfesor::where('profesor_id', $profesor->id)
                ->with('asignatura')
                ->orderBy('fecha')
                ->orderBy('hora_inicio')
                ->get()
            : collect();

        return view('profesor.calendario.index', compact(
            'eventos',
            'asignaturas'
        ));
    }

    public function store(Request $request){
        $request->validate([
            'titulo' => 'required',
            'tipo' => 'nullable|string|max:50',
            'descripcion' => 'nullable',
            'asignatura_id' => 'nullable|exists:asignaturas,id',
            'fecha' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha',
            'hora_inicio' => 'nullable',
            'hora_fin' => 'nullable|after_or_equal:hora_inicio',
        ]);

        CalendarioProfesor::create([
            'profesor_id' => Auth::user()->profesor->id,
            'asignatura_id' => $request->asignatura_id,
            'tipo' => $request->tipo,
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'fecha' => $request->fecha,
            'fecha_fin' => $request->fecha_fin,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
        ]);

        return redirect()
            ->route('profesor.calendario.index')
            ->with('success', 'Evento añadido correctamente.');
    }

    public function update(Request $request, CalendarioProfesor $evento){
        $request->validate([
            'titulo' => 'required',
            'tipo' => 'nullable|string|max:50',
            'descripcion' => 'nullable',
            'asignatura_id' => 'nullable|exists:asignaturas,id',
            'fecha' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha',
            'hora_inicio' => 'nullable',
            'hora_fin' => 'nullable|after_or_equal:hora_inicio',
        ]);

        $evento->update([
            'asignatura_id' => $request->asignatura_id,
            'tipo' => $request->tipo,
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'fecha' => $request->fecha,
            'fecha_fin' => $request->fecha_fin,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
        ]);

        return redirect()
            ->route('profesor.calendario.index')
            ->with('success', 'Evento actualizado correctamente.');
    }

    public function destroy(CalendarioProfesor $evento){
        $evento->delete();

        return redirect()
            ->route('profesor.calendario.index')
            ->with('success', 'Evento eliminado.');
    }
}