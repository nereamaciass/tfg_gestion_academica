@extends('layouts.profesor')
@section('content')

<div class="p-6">
    <h2 class="text-3xl font-bold text-gray-800">
        Bienvenid@, {{ ucfirst(auth()->user()->name) }}
    </h2>

    <p class="text-gray-600 mt-1">
        Hoy es {{ now()->translatedFormat('l, d F Y') }}.
    </p>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
        <div class="bg-white p-5 rounded-xl shadow-md border border-gray-200">
            <h3 class="text-xl font-semibold text-gray-800">Mis Asignaturas</h3>

            <p class="text-gray-600 mt-2">
                Total: <strong>{{ $totalAsignaturas }}</strong>
            </p>

            <a href="{{ route('profesor.asignaturas.index') }}" class="mt-3 inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                Ver asignaturas
            </a>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-md border border-gray-200">
            <h3 class="text-xl font-semibold text-gray-800">Notificaciones</h3>

            <p class="text-gray-600 mt-2">
                Nuevas: <strong>{{ $notificacionesNuevas }}</strong>
            </p>

            <a href="{{ route('profesor.notificaciones.index') }}" class="mt-3 inline-block bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg transition">
                Revisar notificaciones
            </a>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-md border border-gray-200">
            <h3 class="text-xl font-semibold text-gray-800">Chat</h3>

            <p class="text-gray-600 mt-2">
                Habla con el administrador o compañeros.
            </p>

            <a href="{{ route('profesor.chat.index') }}" class="mt-3 inline-block bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                Ir al chat
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mt-6">
        <div class="bg-white p-5 rounded-xl shadow-md border border-gray-200">
            <h3 class="text-sm font-semibold text-gray-500">Clases hoy</h3>

            <p class="text-3xl font-bold text-green-600 mt-2">
                {{ $clasesHoy }}
            </p>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-md border border-gray-200">
            <h3 class="text-sm font-semibold text-gray-500">Clases esta semana</h3>

            <p class="text-3xl font-bold text-purple-600 mt-2">
                {{ $totalClasesSemana }}
            </p>
        </div>

        <div class="lg:col-span-2 bg-white p-5 rounded-xl shadow-md border border-gray-200">
            <h3 class="text-xl font-bold text-gray-800 mb-3">Próxima Clase</h3>

            @if($proximaClase)
                <div class="flex justify-between items-center bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div>
                        <p class="font-bold text-blue-800">
                            {{ $proximaClase->asignatura?->nombre ?? 'Sin asignatura' }}
                        </p>

                        <p class="text-sm text-gray-600">
                            {{ $proximaClase->dia }}
                        </p>
                    </div>

                    <div class="text-right">
                        <p class="text-xl font-bold text-blue-700">
                            {{ substr($proximaClase->hora_inicio, 0, 5) }}
                        </p>

                        <p class="text-sm text-gray-500">
                            hasta {{ substr($proximaClase->hora_fin, 0, 5) }}
                        </p>
                    </div>
                </div>
            @else
                <p class="text-gray-600">
                    No quedan más clases para hoy.
                </p>
            @endif
        </div>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
        <div class="bg-white p-5 rounded-xl shadow-md border border-gray-200">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-2xl font-bold text-gray-800">
                    Mini Calendario de Eventos
                </h3>

                <a href="{{ route('profesor.calendario.index') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-xl shadow transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Ver calendario
                </a>
            </div>

            @if($eventosCalendario->isEmpty())
                <p class="text-gray-600">
                    No tienes próximos eventos.
                </p>
            @else

                @php
                    $hoy = now()->startOfDay();
                    $semana = now()->copy()->addDays(7);
                @endphp

                <div class="space-y-3">
                    @foreach($eventosCalendario->sortBy('fecha')->take(3) as $evento)
                        @php
                            $fechaEvento = \Carbon\Carbon::parse($evento->fecha);

                            $clasesEvento = 'border border-gray-200';

                            if($fechaEvento->isToday()){
                                $clasesEvento = 'border-2 border-blue-400 bg-blue-50';
                            }elseif($fechaEvento->between($hoy, $semana)) {
                                $clasesEvento = 'border-2 border-amber-300 bg-amber-50';
                            }
                        @endphp

                        <div onclick="mostrarEvento( '{{ $evento->titulo }}', '{{ $evento->tipo ?? 'Sin tipo' }}', '{{ $evento->asignatura?->nombre ?? 'Sin asignatura' }}', '{{ \Carbon\Carbon::parse($evento->fecha)->format('d/m/Y') }}', '{{ $evento->fecha_fin ? \Carbon\Carbon::parse($evento->fecha_fin)->format('d/m/Y') : '' }}', '{{ $evento->hora_inicio }}', '{{ $evento->hora_fin }}', `{{ $evento->descripcion ?: 'Sin descripción' }}`)" class="{{ $clasesEvento }} rounded-2xl p-4 hover:shadow-md hover:scale-[1.01] cursor-pointer transition">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-3 h-3 rounded-full"
                                        style="background-color: {{ $evento->asignatura?->color ?? '#2563EB' }}">
                                    </div>

                                    <div>
                                        <div class="flex items-center gap-2">
                                            <p class="font-bold text-gray-800">
                                                {{ $evento->titulo }}
                                            </p>

                                            @if($fechaEvento->isToday())
                                                <span class="text-xs px-2 py-1 rounded-full bg-blue-100 text-blue-700 font-semibold">
                                                    Hoy
                                                </span>
                                            @elseif($fechaEvento->between($hoy, $semana))
                                                <span class="text-xs px-2 py-1 rounded-full bg-amber-100 text-amber-700 font-semibold">
                                                    Próximamente
                                                </span>
                                            @endif
                                        </div>

                                        <p class="text-sm text-gray-500">
                                            {{ $evento->asignatura?->nombre ?? 'Sin asignatura' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="text-right">
                                    <p class="text-sm font-semibold text-blue-700"> {{ \Carbon\Carbon::parse($evento->fecha)->format('d/m/Y') }}
                                        @if($evento->fecha_fin)
                                            → {{ \Carbon\Carbon::parse($evento->fecha_fin)->format('d/m/Y') }}
                                        @endif
                                    </p>

                                    @if($evento->hora_inicio)
                                        <p class="text-xs text-gray-500"> {{ substr($evento->hora_inicio,0,5) }}
                                            @if($evento->hora_fin)
                                                - {{ substr($evento->hora_fin,0,5) }}
                                            @endif
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach

                    @if($eventosCalendario->count() > 3)
                        <a href="{{ route('profesor.calendario.index') }}" class="block mt-4 text-center bg-[#0B1B3C] text-white py-3 rounded-xl font-semibold hover:bg-[#132a57] transition">
                            Ver todos los eventos ({{ $eventosCalendario->count() }})
                        </a>
                    @endif
                </div>
            @endif
        </div>

        <div class="bg-white p-5 rounded-xl shadow-md border border-gray-200">
            <h3 class="text-2xl font-bold text-gray-800">
                Horario de Hoy
            </h3>

            @if($horarioHoy->isEmpty())
                <p class="text-gray-600 mt-3">
                    Has finalizado tu jornada del día de hoy.
                </p>
            @else

            <div class="mt-4 space-y-3">
                @foreach($horarioHoy as $clase)
                    <div class="flex items-center justify-between rounded-lg border px-3 py-2 transition hover:shadow-sm" style="border-left: 6px solid {{ $clase->asignatura?->color ?? '#2563eb' }}">
                        <div>
                            <div class="flex items-center gap-2">
                                <div class="w-2.5 h-2.5 rounded-full"
                                    style="background-color: {{ $clase->asignatura?->color ?? '#2563eb' }}">
                                </div>

                                <span class="font-medium text-gray-900 text-sm">
                                    {{ $clase->asignatura?->nombre ?? 'Sin asignatura' }}
                                </span>
                            </div>
                        </div>

                        <div class="text-right">
                            <div class="font-bold text-gray-800"> {{ substr($clase->hora_inicio, 0, 5) }} - {{ substr($clase->hora_fin, 0, 5) }} </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function mostrarEvento(
        titulo,
        tipo,
        asignatura,
        fecha,
        fechaFin,
        horaInicio,
        horaFin,
        descripcion
    ){
        let horario = 'Todo el día';

        if(horaInicio){
            horario = horaInicio;

            if(horaFin){
                horario += ' - ' + horaFin;
            }
        }

        Swal.fire({
            title: titulo,
            html: `
                <div style="text-align:left">
                    <div style=" display:grid; grid-template-columns:140px 1fr; row-gap:14px; column-gap:10px; ">

                        <strong>Tipo</strong>
                        <span>${tipo}</span>

                        <strong>Asignatura</strong>
                        <span>${asignatura}</span>

                        <strong>Fecha</strong>
                        <span>
                            ${fecha}
                            ${fechaFin ? ' → ' + fechaFin : ''}
                        </span>

                        <strong>Horario</strong>
                        <span>${horario}</span>
                    </div>

                    <div style="margin-top:20px; padding-top:16px; border-top:1px solid #e5e7eb;">
                        <div style=" font-weight:600; margin-bottom:8px;">
                            Descripción
                        </div>

                        <div style="color:#4b5563; line-height:1.6;">
                            ${descripcion}
                        </div>
                    </div>
                </div>
            `,
            confirmButtonText: 'Cerrar',
            confirmButtonColor: '#2563eb',
            width: 700
        });
    }
</script>
@endsection