<?php

namespace App\Http\Controllers\Profesor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PerfilProfesorController extends Controller{
    public function index(){
        $user = Auth::user();
        $profesor = $user->profesor;

        return view('profesor.perfil.index', compact('user', 'profesor'));
    }

    public function update(Request $request){
        $user = Auth::user();
        $profesor = $user->profesor;
        $request->validate([
            'telefono' => 'nullable|string|max:20',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if($request->hasFile('profile_photo')) {
            if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            $user->profile_photo = $request->file('profile_photo')->store('profile_photos', 'public');
            $user->save();
        }

        if ($profesor) {
            $profesor->telefono = $request->telefono;
            $profesor->save();
        }

        return back()->with('success', 'Perfil actualizado correctamente.');
    }

    public function actualizarPassword(Request $request){
        $request->validate([
            'password_actual' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        if(!Hash::check($request->password_actual, $user->password)) {
            return back()->with('error', 'La contraseña actual no es correcta.');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Contraseña actualizada correctamente.');
    }
}