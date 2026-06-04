<?php

namespace App\Http\Controllers\Profesor;
use App\Http\Controllers\Controller;
use App\Models\Horario;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class HorarioProfesorController extends Controller{
    public function index(){
        $profesor = Auth::user()->profesor;
        $dias = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes"];
        $horas = [
            "08:00",
            "09:00",
            "10:00",
            "11:30",
            "12:30",
            "13:30",
            "14:30",
        ];

        $horarios = Horario::where('user_id', Auth::id())
            ->with('asignatura')
            ->get();
        return view('profesor.horario.index', compact(
            'profesor',
            'dias',
            'horas',
            'horarios'
        ));
    }

    public function pdf(){
        $profesor = Auth::user()->profesor;
        $dias = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes"];
        $horas = [
            "08:00",
            "09:00",
            "10:00",
            "11:30",
            "12:30",
            "13:30",
            "14:30",
        ];

        $horarios = Horario::where('user_id', Auth::id())
            ->with('asignatura')
            ->get();
        $pdf = Pdf::loadView('profesor.horario.pdf',[
            'profesor' => $profesor,
            'horarios' => $horarios,
            'dias' => $dias,
            'horas' => $horas,
        ]);

        return $pdf->download("Horario_{$profesor->nombre}.pdf");
    }
}