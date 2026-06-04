<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Asignatura;
use App\Models\Profesor;
use Illuminate\Http\Request;

class AsignaturaController extends Controller{
    public function index(Request $request){
        $buscar = $request->input('buscar');
        $curso = $request->input('curso');
        $sort = $request->get('sort');
        $direction = $request->get('direction');

        if($direction === 'default'){
            $sort = null;
            $direction = null;
        }

        $allowedSorts = ['nombre', 'codigo', 'curso'];

        if ($sort && !in_array($sort, $allowedSorts)) {
            $sort = null;
        }

        if($direction && !in_array($direction, ['asc', 'desc'])){
            $direction = null;
        }

        $query = Asignatura::with('profesores')
            ->when($buscar, function ($query, $buscar){
                $query->where(function ($q) use ($buscar){
                    $q->where('nombre', 'like', "%$buscar%")
                    ->orWhere('codigo', 'like', "%$buscar%");
                });
            })

            ->when($curso, function ($query, $curso){
                $query->where('curso', $curso);
            });

        if($sort && $direction){
            $query->orderBy($sort, $direction);
        }else{
            $query->orderBy('id', 'asc');
        }

        $asignaturas = $query
            ->paginate(10)
            ->appends($request->query());

        $cursos = Asignatura::select('curso')
            ->distinct()
            ->orderBy('curso')
            ->pluck('curso');

        return view('admin.asignaturas.index',[
            'asignaturas' => $asignaturas,
            'cursos' => $cursos,
            'sort' => $sort,
            'direction' => $direction
        ]);
    }

    public function create(){
        $profesores = Profesor::orderBy('nombre')->get();

        return view('admin.asignaturas.create', compact(
            'profesores'
        ));
    }

    public function store(Request $request){
        $request->validate([
            'nombre' => 'required',
            'codigo' => 'required',
            'curso' => 'required',
            'color' => 'nullable',
            'profesores' => 'array'
        ], [
            'nombre.required' => 'Debes introducir el nombre de la asignatura.',
            'codigo.required' => 'Debes introducir un código.',
            'curso.required'  => 'Debes indicar el curso.'
        ]);

        $asignatura = Asignatura::create(
            $request->only(
                'nombre',
                'codigo',
                'curso',
                'color'
            )
        );

        $asignatura->profesores()->sync(
            $request->profesores ?? []
        );

        return redirect()
            ->route('admin.asignaturas.index')
            ->with(
                'success',
                'Asignatura creada correctamente.'
            );
    }

    public function show(Asignatura $asignatura){
        $asignatura->load('profesores');

        return view('admin.asignaturas.show', compact(
            'asignatura'
        ));
    }

    public function edit(Asignatura $asignatura){
        $profesores = Profesor::orderBy('nombre')->get();
        $profesoresAsignados = $asignatura->profesores
            ->pluck('id')
            ->toArray();
            
        return view('admin.asignaturas.edit', compact(
            'asignatura',
            'profesores',
            'profesoresAsignados'
        ));
    }

    public function update(Request $request, Asignatura $asignatura){
        $request->validate([
            'nombre' => 'required',
            'codigo' => 'required',
            'curso' => 'required',
            'color' => 'nullable',
            'profesores' => 'array'
        ], [
            'nombre.required' => 'Debes introducir el nombre de la asignatura.',
            'codigo.required' => 'Debes introducir un código.',
            'curso.required'  => 'Debes indicar el curso.'
        ]);

        $asignatura->update(
            $request->only(
                'nombre',
                'codigo',
                'curso',
                'color'
            )
        );
        
        $asignatura->profesores()->sync(
            $request->profesores ?? []
        );

        return redirect()
            ->route('admin.asignaturas.index')
            ->with(
                'success',
                'Asignatura actualizada.'
            );
    }

    public function destroy(Asignatura $asignatura){
        if(method_exists($asignatura, 'horarios')){
            $asignatura->horarios()->delete();
        }

        $asignatura->profesores()->detach();
        $asignatura->delete();
        
        return redirect()
            ->route('admin.asignaturas.index')
            ->with(
                'success',
                'Asignatura eliminada.'
            );
    }
}