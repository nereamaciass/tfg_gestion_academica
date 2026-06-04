<?php

namespace App\Http\Controllers\Profesor;
use App\Http\Controllers\Controller;
use App\Models\CalendarioProfesor;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardProfesorController extends Controller{
    public function index(){
        $profesor = Auth::user()->profesor;
        $totalAsignaturas = $profesor
            ? $profesor->asignaturas()->count()
            : 0;
        $notificacionesNuevas = $profesor
            ? $profesor->notificaciones()->where('leida', false)->count()
            : 0;
        $diaHoy = ucfirst(Carbon::now()->locale('es')->dayName);
        $horaActual = now()->format('H:i:s');
        $horarioHoy = $profesor
            ? $profesor->horarios()
                ->where('dia', $diaHoy)
                ->where('hora_fin', '>', $horaActual)
                ->with('asignatura')
                ->orderBy('hora_inicio')
                ->get()
            : collect();
        $clasesHoy = $horarioHoy->count();
        $proximaClase = $profesor
            ? $profesor->horarios()
                ->where('dia', $diaHoy)
                ->where('hora_inicio', '>=', $horaActual)
                ->with('asignatura')
                ->orderBy('hora_inicio')
                ->first()
            : null;
        $diasSemana = [
            'Lunes',
            'Martes',
            'Miércoles',
            'Jueves',
            'Viernes'
        ];

        $indiceHoy = array_search($diaHoy, $diasSemana);
        $totalClasesSemana = 0;

        if($profesor){
            $horarios = $profesor->horarios()->get();

            foreach($horarios as $horario){
                $indiceClase = array_search($horario->dia, $diasSemana);
                if($indiceClase === false){
                    continue;
                }

                if($indiceClase > $indiceHoy){
                    $totalClasesSemana++;
                }elseif(
                    $indiceClase == $indiceHoy &&
                    $horario->hora_fin > $horaActual
                ){
                    $totalClasesSemana++;
                }
            }
        }

        $diasConClase = $profesor
            ? $profesor->horarios()
                ->select('dia')
                ->distinct()
                ->count('dia')
            : 0;
        $eventosCalendario = $profesor
            ? CalendarioProfesor::where('profesor_id', $profesor->id)
                ->with('asignatura')
                ->whereDate('fecha', '>=', now()->toDateString())
                ->orderBy('fecha')
                ->orderBy('hora_inicio')
                ->take(5)
                ->get()
            : collect();
        return view('profesor.dashboard', compact(
            'profesor',
            'totalAsignaturas',
            'notificacionesNuevas',
            'horarioHoy',
            'proximaClase',
            'clasesHoy',
            'totalClasesSemana',
            'diasConClase',
            'eventosCalendario'
        ));
    }
}