<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Admin\ProfesorController;
use App\Http\Controllers\Admin\UsuarioController;
use App\Http\Controllers\Admin\AsignaturaController;
use App\Http\Controllers\Admin\HorarioController;
use App\Http\Controllers\Admin\NotificacionController;
use App\Http\Controllers\AdminController;

use App\Http\Controllers\Profesor\DashboardProfesorController;
use App\Http\Controllers\Profesor\AsignaturasProfesorController;
use App\Http\Controllers\Profesor\HorarioProfesorController;
use App\Http\Controllers\Profesor\NotificacionesProfesorController;
use App\Http\Controllers\Profesor\PerfilProfesorController;
use App\Http\Controllers\Profesor\CalendarioProfesorController;

use App\Http\Controllers\ChatController;

use App\Models\User;
use App\Models\Asignatura;
use App\Models\Horario;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {

    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    if (auth()->user()->role === 'profesor') {
        return redirect()->route('profesor.dashboard');
    }

    return redirect('/');

})->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

});

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('admin.dashboard', [
                'totalProfesores' => User::where('role', 'profesor')->count(),
                'totalAsignaturas' => Asignatura::count(),
                'totalUsuarios' => User::count(),
                'totalHorarios' => Horario::count(),
            ]);
        })->name('dashboard');

        Route::get('/perfil', function () {
            return view('admin.perfil.index');
        })->name('perfil.index');

        Route::get('/reordenar-ids', [AdminController::class, 'reordenarIDs'])
            ->name('reordenar.ids');

        Route::resource('/profesores', ProfesorController::class)
            ->names('profesores')
            ->parameters(['profesores' => 'profesor']);

        Route::resource('/usuarios', UsuarioController::class);

        Route::resource('/asignaturas', AsignaturaController::class);

        Route::resource('/horarios', HorarioController::class);

        Route::resource('/notificaciones', NotificacionController::class);

        Route::get('/chat', [ChatController::class, 'indexAdmin'])
            ->name('chat.index');

        Route::get('/chat/{id}', [ChatController::class, 'conversacion'])
            ->name('chat.conversacion');

        Route::post('/chat/enviar', [ChatController::class, 'enviarMensaje'])
            ->name('chat.enviar');

        Route::delete('/chat/mensaje/{mensaje}', [ChatController::class, 'eliminarMensaje'])
            ->name('chat.eliminar');

        Route::get('/horarios/pdf/{profesor}', [HorarioController::class, 'pdf'])
            ->name('horarios.pdf');

    });

Route::middleware(['auth', 'profesor'])
    ->prefix('profesor')
    ->name('profesor.')
    ->group(function () {

        Route::get('/dashboard', [DashboardProfesorController::class, 'index'])
            ->name('dashboard');

        Route::get('/asignaturas', [AsignaturasProfesorController::class, 'index'])
            ->name('asignaturas.index');

        Route::get('/asignaturas/{id}', [AsignaturasProfesorController::class, 'show'])
            ->name('asignaturas.show');

        Route::get('/asignaturas/pdf/descargar', [AsignaturasProfesorController::class, 'descargarPDF'])
            ->name('asignaturas.pdf');

        Route::get('/horario', [HorarioProfesorController::class, 'index'])
            ->name('horario.index');

        Route::get('/horario/pdf/descargar', [HorarioProfesorController::class, 'pdf'])
            ->name('horario.pdf');

        Route::get('/calendario', [CalendarioProfesorController::class, 'index'])
            ->name('calendario.index');

        Route::post('/calendario', [CalendarioProfesorController::class, 'store'])
            ->name('calendario.store');

        Route::put('/calendario/{evento}', [CalendarioProfesorController::class, 'update'])
            ->name('calendario.update');

        Route::delete('/calendario/{evento}', [CalendarioProfesorController::class, 'destroy'])
            ->name('calendario.destroy');

        Route::get('/notificaciones', [NotificacionesProfesorController::class, 'index'])
            ->name('notificaciones.index');

        Route::post('/notificaciones/{id}/leer', [NotificacionesProfesorController::class, 'marcarLeida'])
            ->name('notificaciones.leer');

        Route::get('/perfil', [PerfilProfesorController::class, 'index'])
            ->name('perfil.index');

        Route::patch('/perfil', [PerfilProfesorController::class, 'update'])
            ->name('perfil.update');

        Route::post('/perfil/password', [PerfilProfesorController::class, 'actualizarPassword'])
            ->name('perfil.password');

        Route::get('/chat', [ChatController::class, 'indexProfesor'])
            ->name('chat.index');

        Route::get('/chat/{id}', [ChatController::class, 'conversacion'])
            ->name('chat.conversacion');

        Route::post('/chat/enviar', [ChatController::class, 'enviarMensaje'])
            ->name('chat.enviar');

        Route::delete('/chat/mensaje/{mensaje}', [ChatController::class, 'eliminarMensaje'])
            ->name('chat.eliminar');

    });

require __DIR__.'/auth.php';