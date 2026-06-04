<?php

namespace App\Http\Controllers\Profesor;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AsignaturasProfesorController extends Controller{
    public function index(Request $request){
        $profesor = Auth::user()->profesor;
        $busqueda = $request->input('buscar', '');
        $cursoSeleccionado = $request->input('curso', '');

        if(!$profesor){
            $asignaturas = collect();
            $cursos = collect();
            return view('profesor.asignaturas.index', compact(
                'asignaturas',
                'busqueda',
                'cursoSeleccionado',
                'cursos'
            ));
        }
        
        $cursos = $profesor->asignaturas()
            ->select('curso')
            ->distinct()
            ->orderBy('curso')
            ->pluck('curso');
        $query = $profesor->asignaturas();

        if($busqueda){
            $query->where(function ($q) use ($busqueda) {
                $q->where('nombre', 'LIKE', "%$busqueda%")
                  ->orWhere('codigo', 'LIKE', "%$busqueda%");
            });
        }

        if($cursoSeleccionado){
            $query->where('curso', $cursoSeleccionado);
        }

        $asignaturas = $query->orderBy('nombre')->paginate(10);

        return view('profesor.asignaturas.index', compact(
            'asignaturas',
            'busqueda',
            'cursoSeleccionado',
            'cursos'
        ));
    }

    public function show($id){
        $profesor = Auth::user()->profesor;

        abort_if(!$profesor, 404);

        $asignatura = $profesor->asignaturas()
            ->where('asignaturas.id', $id)
            ->firstOrFail();
        $horarios = $profesor->horarios()
            ->where('asignatura_id', $id)
            ->orderBy('dia')
            ->orderBy('hora_inicio')
            ->get();

        return view('profesor.asignaturas.show', compact('asignatura', 'horarios'));
    }
}