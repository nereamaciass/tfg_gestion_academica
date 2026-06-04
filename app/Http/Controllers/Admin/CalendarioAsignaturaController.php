<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\CalendarioAsignatura;
use App\Models\Asignatura;
use Illuminate\Http\Request;

class CalendarioAsignaturaController extends Controller{
    public function index(){
        $eventos = CalendarioAsignatura::with('asignatura')->paginate(10);

        return view('admin.calendario_asignatura.index', compact('eventos'));
    }

    public function create(){
        $asignaturas = Asignatura::all();

        return view('admin.calendario_asignatura.create', compact('asignaturas'));
    }

    public function store(Request $request){
        $request->validate([
            'asignatura_id' => 'required|exists:asignaturas,id',
            'titulo' => 'required',
            'descripcion' => 'nullable',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        CalendarioAsignatura::create($request->all());

        return redirect()->route('admin.calendario-asignatura.index')
                         ->with('success', 'Evento creado correctamente.');
    }

    public function edit(CalendarioAsignatura $evento){
        $asignaturas = Asignatura::all();

        return view('admin.calendario_asignatura.edit', compact('evento', 'asignaturas'));
    }

    public function update(Request $request, CalendarioAsignatura $evento){
        $request->validate([
            'asignatura_id' => 'required|exists:asignaturas,id',
            'titulo' => 'required',
            'descripcion' => 'nullable',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        $evento->update($request->all());

        return redirect()->route('admin.calendario-asignatura.index')
                         ->with('success', 'Evento actualizado correctamente.');
    }

    public function destroy(CalendarioAsignatura $evento){
        $evento->delete();
        
        return redirect()->route('admin.calendario-asignatura.index')
                         ->with('success', 'Evento eliminado correctamente.');
    }
}