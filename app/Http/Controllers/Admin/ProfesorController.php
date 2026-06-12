<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Profesor;
use App\Models\Asignatura;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfesorController extends Controller{
    public function index(Request $request){
        $buscar = $request->input('buscar');
        $departamento = $request->input('departamento');
        $sort = $request->get('sort');
        $direction = $request->get('direction');
        
        if($direction === 'default'){
            $sort = null;
            $direction = null;
        }

        $allowedSorts = ['nombre', 'email', 'departamento'];

        if($sort && !in_array($sort, $allowedSorts)){
            $sort = null;
        }

        if($direction && !in_array($direction, ['asc', 'desc'])){
            $direction = null;
        }

        $query = Profesor::with('user');

        if($buscar){
            $query->where(function($q) use($buscar){
                $q->where('nombre', 'LIKE', "%{$buscar}%")
                ->orWhere('email', 'LIKE', "%{$buscar}%");
            });
        }

        if($departamento){
            $query->where('departamento', $departamento);
        }

        if($sort && $direction){
            $query->orderBy($sort, $direction);
        }else{
            $query->orderBy('id', 'asc');
        }

        $profesores = $query
            ->paginate(10)
            ->appends($request->query());

        return view('admin.profesores.index',[
            'profesores' => $profesores,
            'buscar' => $buscar,
            'departamento' => $departamento,
            'sort' => $sort,
            'direction' => $direction
        ]);
    }

    public function create(){
        $departamentos = Profesor::select('departamento')
            ->whereNotNull('departamento')
            ->where('departamento', '!=', '')
            ->distinct()
            ->pluck('departamento');
        $asignaturas = Asignatura::orderBy('curso')
            ->orderBy('nombre')
            ->get();

        return view('admin.profesores.create', compact('departamentos', 'asignaturas'));
    }

    public function store(Request $request){
        $request->validate([
            'nombre' => 'required',
            'email' => ['required', 'email:rfc,dns', 'regex:/^[^\s@]+@[^\s@]+\.[^\s@]+$/', 'unique:profesores,email', 'unique:users,email'],
            'telefono' => ['nullable', 'regex:/^[^[67][0-9]{8}$/'],
            'departamento' => 'nullable',
            'crear_usuario' => 'nullable',
            'password' => 'nullable|min:6',
        ],[
            'nombre.required' => 'Debes introducir el nombre del profesor.',
            'email.required' => 'Debes introducir un correo electrónico.',
            'email.email' => 'El correo electrónico no tiene un formato válido.',
            'email.unique' => 'Ya existe un usuario o profesor con ese correo electrónico.',
            'telefono.regex' => 'El teléfono debe tener 9 cifras y comenzar por 6 o 7.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
        ]);

        $user = null;

        if($request->has('crear_usuario')){
            $request->validate([
                'password' => 'required|min:6',
            ],[
                'password.required' => 'Debes introducir una contraseña para crear la cuenta.',
                'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
            ]);

            $user = User::create([
                'name' => $request->nombre,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'profesor',
            ]);
        }

        $profesor = Profesor::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'departamento' => $request->departamento,
            'user_id' => $user?->id,
        ]);

        $asignaturas = array_filter($request->asignaturas ?? []);
        $profesor->asignaturas()->sync($asignaturas);

        return redirect()->route('admin.profesores.index')
            ->with('success', 'Profesor creado correctamente.');
    }

    public function show(Profesor $profesor){
        return view('admin.profesores.show', compact('profesor'));
    }

    public function edit(Profesor $profesor){
        $asignaturas = Asignatura::orderBy('curso')
            ->orderBy('nombre')
            ->get();
        $asignaturasAsignadas = $profesor->asignaturas->pluck('id')->toArray();
        $departamentos = Profesor::select('departamento')
            ->whereNotNull('departamento')
            ->where('departamento', '!=', '')
            ->distinct()
            ->pluck('departamento');

        return view('admin.profesores.edit', compact(
            'profesor',
            'asignaturas',
            'asignaturasAsignadas',
            'departamentos'
        ));
    }

    public function update(Request $request, Profesor $profesor){
        $userId = $profesor->user_id;
        $request->validate([
            'nombre' => 'required',
            'telefono' => 'nullable',
            'departamento' => 'nullable',
            'email' => 'required|email|unique:profesores,email,' . $profesor->id . '|unique:users,email,' . $userId,
            'password' => 'nullable|min:6',
        ],[
            'nombre.required' => 'Debes introducir el nombre del profesor.',
            'email.required' => 'Debes introducir un correo electrónico.',
            'email.email' => 'El correo electrónico no tiene un formato válido.',
            'email.unique' => 'Ya existe un usuario o profesor con ese correo electrónico.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
        ]);

        $profesor->update([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'departamento' => $request->departamento,
        ]);

        if($profesor->user){
            $profesor->user->name = $request->nombre;
            $profesor->user->email = $request->email;

            if($request->filled('password')){
                $profesor->user->password = Hash::make($request->password);
            }

            $profesor->user->save();
        }

        if (!$profesor->user && $request->has('crear_usuario')) {
            $request->validate([
                'password' => 'required|min:6',
            ],[
                'password.required' => 'Debes introducir una contraseña para crear la cuenta.',
                'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
            ]);

            $user = User::create([
                'name' => $request->nombre,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'profesor',
            ]);

            $profesor->user_id = $user->id;
            $profesor->save();
        }

        $asignaturas = array_filter($request->asignaturas ?? []);
        $profesor->asignaturas()->sync($asignaturas);

        return redirect()->route('admin.profesores.index')
            ->with('success', 'Profesor actualizado correctamente.');
    }

    public function destroy(Profesor $profesor){
        if($profesor->user){
            $profesor->user->delete();
        }

        $profesor->asignaturas()->detach();
        $profesor->delete();

        return redirect()->route('admin.profesores.index')
            ->with('success', 'Profesor eliminado correctamente.');
    }
}