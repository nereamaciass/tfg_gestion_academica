<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\CalendarioProfesor;
use App\Models\Profesor;
use Illuminate\Http\Request;

class CalendarioProfesorController extends Controller{
    public function index(){
        $eventos = CalendarioProfesor::with('profesor')->paginate(10);
        
        return view('admin.calendario_profesor.index', compact('eventos'));
    }

    public function create(){
        $profesores = Profesor::all();

        return view('admin.calendario_profesor.create', compact('profesores'));
    }

    public function store(Request $request){
        $request->validate([
            'profesor_id' => 'required|exists:profesores,id',
            'titulo' => 'required',
            'descripcion' => 'nullable',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        CalendarioProfesor::create($request->all());

        return redirect()->route('admin.calendario-profesor.index')
                         ->with('success', 'Evento creado correctamente.');
    }

    public function edit(CalendarioProfesor $evento){
        $profesores = Profesor::all();

        return view('admin.calendario_profesor.edit', compact('evento', 'profesores'));
    }

    public function update(Request $request, CalendarioProfesor $evento){
        $request->validate([
            'profesor_id' => 'required|exists:profesores,id',
            'titulo' => 'required',
            'descripcion' => 'nullable',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        $evento->update($request->all());
        
        return redirect()->route('admin.calendario-profesor.index')
                         ->with('success', 'Evento actualizado correctamente.');
    }

    public function destroy(CalendarioProfesor $evento){
        $evento->delete();

        return redirect()->route('admin.calendario-profesor.index')
                         ->with('success', 'Evento eliminado correctamente.');
    }
}