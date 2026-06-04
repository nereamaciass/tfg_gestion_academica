<?php

namespace App\Http\Controllers;
use App\Events\MensajeEnviado;
use App\Models\Mensaje;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller{
    public function indexAdmin(){
        $usuarios = User::where('role', 'profesor')
            ->get()
            ->map(function ($usuario){
                $ultimoMensaje = Mensaje::where(function($q) use($usuario){
                        $q->where('emisor_id', Auth::id())
                          ->where('receptor_id', $usuario->id);
                    })->orWhere(function ($q) use ($usuario) {
                        $q->where('emisor_id', $usuario->id)
                          ->where('receptor_id', Auth::id());

                    })
                    ->latest()
                    ->first();
                $noLeidos = Mensaje::where('emisor_id', $usuario->id)
                    ->where('receptor_id', Auth::id())
                    ->where('leido', false)
                    ->count();
                $usuario->ultimo_mensaje = $ultimoMensaje;
                $usuario->no_leidos = $noLeidos;
                return $usuario;

            })
            ->sortByDesc(function($usuario){
                return optional($usuario->ultimo_mensaje)->created_at;
            });
            
        return view('admin.chat.index', compact('usuarios'));
    }

    public function indexProfesor(){
        $usuarios = User::where('id', '<>', Auth::id())
            ->get()
            ->map(function ($usuario){
                $ultimoMensaje = Mensaje::where(function ($q) use ($usuario) {
                        $q->where('emisor_id', Auth::id())
                          ->where('receptor_id', $usuario->id);
                    })->orWhere(function ($q) use ($usuario) {
                        $q->where('emisor_id', $usuario->id)
                          ->where('receptor_id', Auth::id());
                    })
                    ->latest()
                    ->first();
                $noLeidos = Mensaje::where('emisor_id', $usuario->id)
                    ->where('receptor_id', Auth::id())
                    ->where('leido', false)
                    ->count();
                $usuario->ultimo_mensaje = $ultimoMensaje;
                $usuario->no_leidos = $noLeidos;
                return $usuario;
            })
            ->sortByDesc(function($usuario){
                return optional($usuario->ultimo_mensaje)->created_at;
            });

        return view('profesor.chat.index', compact('usuarios'));
    }

    public function conversacion($id){
        Mensaje::where('emisor_id', $id)
            ->where('receptor_id', Auth::id())
            ->where('leido', false)
            ->update([
                'leido' => true
            ]);

        $mensajes = Mensaje::where(function($q) use($id){
            $q->where('emisor_id', Auth::id())
              ->where('receptor_id', $id);
        })->orWhere(function($q) use($id){
            $q->where('emisor_id', $id)
              ->where('receptor_id', Auth::id());
        })
        ->orderBy('created_at', 'asc')
        ->get();
        $destinatario = User::findOrFail($id);
        $usuarios = User::where('id', '<>', Auth::id())
            ->get();
        return view('chat.conversacion', compact(
            'mensajes',
            'destinatario',
            'usuarios'
        ));
    }

    public function enviarMensaje(Request $request){
        $request->validate([
            'receptor_id' => 'required|exists:users,id',
            'mensaje' => 'nullable|string',
            'archivo' => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf,doc,docx,xls,xlsx|max:20480',
        ]);

        if(!$request->mensaje && !$request->hasFile('archivo')){
            return back();
        }
        $archivoPath = null;

        if ($request->hasFile('archivo')) {
            $archivoPath = $request->file('archivo')
                ->store('chat_archivos', 'public');
        }

        $mensaje = Mensaje::create([
            'emisor_id' => Auth::id(),
            'receptor_id' => $request->receptor_id,
            'mensaje' => $request->mensaje ?? '',
            'archivo' => $archivoPath,
            'leido' => false,
        ]);

        broadcast(new MensajeEnviado($mensaje))->toOthers();

        return back();
    }

    public function eliminarMensaje($id){
        $mensaje = Mensaje::findOrFail($id);

        if ($mensaje->emisor_id != Auth::id()){
            abort(403);
        }

        if ($mensaje->archivo){
            $ruta = public_path('storage/' . $mensaje->archivo);
            if (file_exists($ruta)){
                unlink($ruta);
            }
        }

        $mensaje->delete();

        return back();
    }
}