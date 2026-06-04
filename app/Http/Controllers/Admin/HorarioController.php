<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Profesor;
use App\Models\Horario;
use App\Models\Asignatura;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class HorarioController extends Controller{
    public function index(Request $request){
        $profesores = User::where('role', 'profesor')
            ->orderBy('name')
            ->get();
        $profesorSeleccionado = $request->profesor;

        if(!$profesorSeleccionado){
            return view('admin.horarios.index',[
                'profesores' => $profesores,
                'profesorSeleccionado' => null,
                'dias' => [],
                'horasRango' => [],
                'horarios' => collect(),
            ]);
        }

        $dias = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes"];
        $horasRango = [
            "08:00-09:00",
            "09:00-10:00",
            "10:00-11:00",
            "11:30-12:30",
            "12:30-13:30",
            "13:30-14:30",
        ];

        $horariosPlano = Horario::where('user_id', $profesorSeleccionado)
            ->with('asignatura')
            ->get();
        $horarios = [];

        foreach ($dias as $dia){
            $horarios[$dia] = $horariosPlano->where('dia', $dia);
        }

        return view('admin.horarios.index',[
            'profesores' => $profesores,
            'profesorSeleccionado' => $profesorSeleccionado,
            'dias' => $dias,
            'horasRango' => $horasRango,
            'horarios' => $horarios,
        ]);
    }

    public function create(Request $request){
        $user_id = $request->user_id ?? $request->profesor_id;
        $profesor = Profesor::where('user_id', $user_id)->first();
        $asignaturas = collect();

        if($profesor){
            $asignaturas = Asignatura::whereHas('profesores', function ($q) use ($profesor){
                $q->where('profesores.id', $profesor->id);
            })->orderBy('nombre')->get();
        }

        return view('admin.horarios.create',[
            'user_id' => $user_id,
            'profesor_id' => $profesor?->id,
            'dia' => $request->dia,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
            'asignaturas' => $asignaturas
        ]);
    }

    public function store(Request $request){
        $request->validate([
            'user_id'       => 'required|exists:users,id',
            'asignatura_id' => 'required|exists:asignaturas,id',
            'dia'           => 'required|string',
            'hora_inicio'   => 'required|string',
            'hora_fin'      => 'required|string',
        ]);

        $profesor = Profesor::where('user_id', $request->user_id)->firstOrFail();

        Horario::create([
            'profesor_id' => $profesor->id,
            'user_id' => $request->user_id,
            'asignatura_id' => $request->asignatura_id,
            'dia' => $request->dia,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
        ]);

        return redirect()->route('admin.horarios.index',[
            'profesor' => $request->user_id
        ])->with('success', 'Horario creado correctamente.');
    }

    public function edit(Horario $horario){
        $profesor = Profesor::where('user_id', $horario->user_id)->first();
        $asignaturasProfesor = collect();

        if ($profesor) {
            $asignaturasProfesor = Asignatura::whereHas('profesores', function ($q) use ($profesor) {
                $q->where('profesores.id', $profesor->id);
            })->orderBy('nombre')->get();
        }

        return view('admin.horarios.edit',[
            'horario' => $horario,
            'asignaturasProfesor' => $asignaturasProfesor
        ]);
    }

    public function update(Request $request, Horario $horario){
        $request->validate([
            'asignatura_id' => 'required|exists:asignaturas,id'
        ]);

        $horario->update([
            'asignatura_id' => $request->asignatura_id
        ]);

        return redirect()->route('admin.horarios.index',[
            'profesor' => $horario->user_id
        ])->with('success', 'Horario actualizado correctamente.');
    }

    public function destroy(Horario $horario){
        $user = $horario->user_id;
        $horario->delete();

        return redirect()->route('admin.horarios.index',[
            'profesor' => $user
        ])->with('success', 'Horario eliminado correctamente.');
    }

    public function pdf($user_id){
        $profesor = User::findOrFail($user_id);
        $horarios = Horario::where('user_id', $user_id)
            ->with('asignatura')
            ->get();
        $dias = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes"];
        $horas = [
            "08:00",
            "09:00",
            "10:00",
            "11:30",
            "12:30",
            "13:30",
            "14:30"
        ];

        $pdf = Pdf::loadView('admin.horarios.pdf',[
            'profesor' => $profesor,
            'horarios' => $horarios,
            'dias' => $dias,
            'horas' => $horas
        ]);
        
        return $pdf->download("Horario_{$profesor->name}.pdf");
    }
}