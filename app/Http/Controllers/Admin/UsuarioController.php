<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Profesor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller{

    public function index(Request $request){
        $buscar = $request->input('buscar');
        $rol = $request->input('rol');
        $sort = $request->get('sort');
        $direction = $request->get('direction');

        if($direction === 'default'){
            $sort = null;
            $direction = null;
        }

        $allowedSorts = ['name', 'email', 'role'];

        if($sort && !in_array($sort, $allowedSorts)){
            $sort = null;
        }

        if($direction && !in_array($direction, ['asc', 'desc'])){
            $direction = null;
        }

        $query = User::query();

        if($buscar){
            $query->where(function ($q) use ($buscar){
                $q->where('name', 'LIKE', "%{$buscar}%")
                ->orWhere('email', 'LIKE', "%{$buscar}%");
            });
        }

        if($rol){
            $query->where('role', $rol);
        }

        if($sort && $direction){
            $query->orderBy($sort, $direction);
        }else{
            $query->orderBy('id', 'asc');
        }

        $usuarios = $query
            ->paginate(10)
            ->appends($request->query());

        return view('admin.usuarios.index',[
            'usuarios' => $usuarios,
            'buscar' => $buscar,
            'rol' => $rol,
            'sort' => $sort,
            'direction' => $direction
        ]);
    }

    public function create(){
        return view('admin.usuarios.create');
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email|unique:profesores,email',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,profesor',
        ], [
            'name.required' => 'Debes introducir un nombre.',
            'email.required' => 'Debes introducir un correo electrónico.',
            'email.email' => 'Debes introducir un correo electrónico válido.',
            'email.unique' => 'Ese correo electrónico ya está registrado.',
            'password.required' => 'Debes introducir una contraseña.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
            'role.required' => 'Debes seleccionar un rol.',
            'role.in' => 'El rol seleccionado no es válido.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        if($request->role === 'profesor'){
            Profesor::create([
                'nombre' => $request->name,
                'email' => $request->email,
                'telefono' => null,
                'departamento' => null,
                'user_id' => $user->id,
            ]);
        }

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario creado correctamente.');
    }

    public function show(User $usuario){
        return view('admin.usuarios.show', compact('usuario'));
    }

    public function edit(User $usuario){
        return view('admin.usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, User $usuario){
        $profesor = $usuario->profesor;
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $usuario->id . '|unique:profesores,email,' . ($profesor?->id ?? 'NULL'),
            'role' => 'required|in:admin,profesor',
            'password' => 'nullable|min:6',
        ],[
            'name.required' => 'Debes introducir un nombre.',
            'email.required' => 'Debes introducir un correo electrónico.',
            'email.email' => 'Debes introducir un correo electrónico válido.',
            'email.unique' => 'Ese correo electrónico ya está registrado.',
            'role.required' => 'Debes seleccionar un rol.',
            'role.in' => 'El rol seleccionado no es válido.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
        ]);
        
        $usuario->name  = $request->name;
        $usuario->email = $request->email;
        $usuario->role  = $request->role;
        
        if($request->filled('password')){
            $usuario->password = Hash::make($request->password);
        }

        $usuario->save();

        if($usuario->role === 'profesor'){
            if($profesor){
                $profesor->update([
                    'nombre' => $request->name,
                    'email' => $request->email,
                ]);
            }else{
                Profesor::create([
                    'nombre' => $request->name,
                    'email' => $request->email,
                    'telefono' => null,
                    'departamento' => null,
                    'user_id' => $usuario->id,
                ]);
            }
        }else{
            if($profesor){
                $profesor->user_id = null;
                $profesor->save();
            }
        }

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(User $usuario){
        if($usuario->profesor) {
            $usuario->profesor->delete();
        }

        $usuario->delete();

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }
}