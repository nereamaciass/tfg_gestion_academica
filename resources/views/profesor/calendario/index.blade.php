@extends('layouts.profesor')
@section('title', 'Calendario')
@section('content')

<div class="p-3" x-data="{ modal:false, editModal:false }">
    <style>
        #calendar{
            font-size: 13px;
        }

        #calendar .fc-toolbar{
            margin-bottom: 10px;
        }

        #calendar .fc-toolbar-title{
            font-size: 26px;
            font-weight: 600;
        }

        #calendar .fc-button{
            padding: 6px 12px;
            font-size: 14px;
        }

        #calendar .fc-col-header-cell{
            padding: 2px 0;
        }

        #calendar .fc-daygrid-day-frame{
            min-height: 55px;
        }

        #calendar .fc-daygrid-day-number{
            font-size: 13px;
            padding: 4px;
        }
    </style>

    <div class="flex justify-between items-start mb-3">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Calendario</h1>
            <p class="text-gray-600 mt-1 text-sm">
                Gestiona tareas, exámenes y eventos.
            </p>
        </div>

        <button @click="modal = true" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg shadow font-semibold text-sm">
            + Añadir Evento
        </button>
    </div>

    <div class="bg-white rounded-xl shadow-md border border-gray-200 p-3">
        <div id="calendar"></div>
    </div>

    <div x-show="modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="display:none;">
        <div @click.outside="modal = false" class="bg-white rounded-xl shadow-xl w-full max-w-2xl p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold text-gray-800">
                    Añadir Evento
                </h2>

                <button @click="modal = false" class="text-gray-500 hover:text-gray-800 text-2xl">
                    ×
                </button>
            </div>

            <form method="POST" action="{{ route('profesor.calendario.store') }}">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Título</label>
                        <input type="text" name="titulo" required class="w-full border border-gray-300 rounded-lg px-4 py-2">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Tipo</label>
                        <select name="tipo" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                            <option value="">Sin tipo</option>
                            <option value="Tarea">Tarea</option>
                            <option value="Examen">Examen</option>
                            <option value="Recordatorio">Recordatorio</option>
                            <option value="Entrega">Entrega</option>
                            <option value="Reunión">Reunión</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Asignatura</label>
                        <select name="asignatura_id" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                            <option value="">Sin asignatura</option>

                            @foreach($asignaturas as $asignatura)
                                <option value="{{ $asignatura->id }}">
                                    {{ $asignatura->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Fecha Inicio</label>
                        <input type="date" name="fecha" required class="w-full border border-gray-300 rounded-lg px-4 py-2">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Fecha Fin</label>
                        <input type="date" name="fecha_fin" required class="w-full border border-gray-300 rounded-lg px-4 py-2">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Hora Inicio</label>
                        <input type="time" name="hora_inicio" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Hora Fin</label>
                        <input type="time" name="hora_fin" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Descripción</label>
                        <textarea name="descripcion" rows="3" class="w-full border border-gray-300 rounded-lg px-4 py-2"></textarea>
                    </div>

                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" @click="modal = false" class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg">
                        Cancelar
                    </button>

                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">
                        Guardar Evento
                    </button>
                </div>
            </form>
        </div>
    </div>

    @foreach($eventos as $evento)
        <div id="modal-editar-{{ $evento->id }}" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
            <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-bold text-gray-800">Editar Evento</h2>

                    <button type="button" onclick="cerrarModalEditar({{ $evento->id }})" class="text-gray-500 hover:text-gray-800 text-2xl">
                        ×
                    </button>
                </div>

                <form method="POST" action="{{ route('profesor.calendario.update', $evento) }}">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Título</label>
                            <input type="text" name="titulo" value="{{ $evento->titulo }}" required class="w-full border border-gray-300 rounded-lg px-4 py-2">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Tipo</label>
                            <select name="tipo" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                                <option value="" {{ !$evento->tipo ? 'selected' : '' }}>Sin tipo</option>
                                <option value="Tarea" {{ $evento->tipo == 'Tarea' ? 'selected' : '' }}>Tarea</option>
                                <option value="Examen" {{ $evento->tipo == 'Examen' ? 'selected' : '' }}>Examen</option>
                                <option value="Recordatorio" {{ $evento->tipo == 'Recordatorio' ? 'selected' : '' }}>Recordatorio</option>
                                <option value="Entrega" {{ $evento->tipo == 'Entrega' ? 'selected' : '' }}>Entrega</option>
                                <option value="Reunión" {{ $evento->tipo == 'Reunión' ? 'selected' : '' }}>Reunión</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Asignatura</label>
                            <select name="asignatura_id" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                                <option value="">Sin asignatura</option>

                                @foreach($asignaturas as $asignatura)
                                    <option value="{{ $asignatura->id }}"
                                        {{ $evento->asignatura_id == $asignatura->id ? 'selected' : '' }}>
                                        {{ $asignatura->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Fecha Inicio</label>
                            <input type="date" name="fecha" value="{{ $evento->fecha }}" required class="w-full border border-gray-300 rounded-lg px-4 py-2">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Fecha Fin</label>
                            <input type="date" name="fecha_fin" value="{{ $evento->fecha_fin }}" required class="w-full border border-gray-300 rounded-lg px-4 py-2">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Hora Inicio</label>
                            <input type="time" name="hora_inicio" value="{{ $evento->hora_inicio ? substr($evento->hora_inicio, 0, 5) : '' }}" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Hora Fin</label>
                            <input type="time" name="hora_fin" value="{{ $evento->hora_fin ? substr($evento->hora_fin, 0, 5) : '' }}" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Descripción</label>
                            <textarea name="descripcion" rows="3" class="w-full border border-gray-300 rounded-lg px-4 py-2">{{ $evento->descripcion }}</textarea>
                        </div>

                    </div>

                    <div class="flex justify-between mt-6">
                        <button type="button" onclick="confirmarEliminarEvento({{ $evento->id }})" class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-lg">
                            Eliminar
                        </button>

                        <div class="flex gap-3">
                            <button type="button" onclick="cerrarModalEditar({{ $evento->id }})" class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg">
                                Cancelar
                            </button>

                            <button class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">
                                Guardar cambios
                            </button>
                        </div>
                    </div>
                </form>

                <form id="form-eliminar-evento-{{ $evento->id }}" method="POST" action="{{ route('profesor.calendario.destroy', $evento) }}">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    @endforeach
</div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/locales/es.global.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function(){
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl,{
                initialView: 'dayGridMonth',
                locale: 'es',
                allDayText: 'Todo el día',

                height: 520,
                contentHeight: 500,
                aspectRatio: 2.8,

                handleWindowResize: true,
                stickyHeaderDates: false,

                firstDay: 1,

                expandRows: true,
                dayMaxEventRows: 2,

                headerToolbar:{
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,listWeek'
                },

                buttonText:{
                    today: 'Hoy',
                    month: 'Mes',
                    list: 'Lista'
                },

                noEventsContent: 'No hay eventos para mostrar',

                events:[
                    @foreach($eventos as $evento){
                            id: @json($evento->id),
                            title: @json(($evento->tipo ? $evento->tipo . ': ' : '') . $evento->titulo),
                            start: @json($evento->fecha . ($evento->hora_inicio ? 'T' . $evento->hora_inicio : '')),
                            end: @json(($evento->fecha_fin ?? $evento->fecha) . ($evento->hora_fin ? 'T' . $evento->hora_fin : '')),
                            description: @json($evento->descripcion),
                            asignatura: @json($evento->asignatura?->nombre),
                            tipo: @json($evento->tipo),
                            backgroundColor: @json($evento->asignatura?->color ?? '#2563eb'),
                            borderColor: @json($evento->asignatura?->color ?? '#2563eb'),
                            textColor: '#ffffff',
                        },
                    @endforeach
                ],

                eventClick: function(info){
                    Swal.fire({
                        title: info.event.title,
                        html:
                            '<p><strong>Tipo:</strong> ' + (info.event.extendedProps.tipo ?? 'Sin tipo') + '</p>' +
                            '<p><strong>Asignatura:</strong> ' + (info.event.extendedProps.asignatura ?? 'Sin asignatura') + '</p>' +
                            '<p><strong>Descripción:</strong> ' + (info.event.extendedProps.description ?? 'Sin descripción') + '</p>' +
                            '<br><p>¿Qué quieres hacer?</p>',
                        icon: 'info',
                        showCancelButton: true,
                        showDenyButton: true,
                        confirmButtonText: 'Editar',
                        denyButtonText: 'Eliminar',
                        cancelButtonText: 'Cerrar',
                        confirmButtonColor: '#2563eb',
                        denyButtonColor: '#dc2626',
                        cancelButtonColor: '#6b7280'
                    }).then((result)=>{
                        if(result.isConfirmed){
                            abrirModalEditar(info.event.id);
                        }

                        if(result.isDenied){
                            confirmarEliminarEvento(info.event.id);
                        }
                    });
                }
            });
            calendar.render();
        });

        function abrirModalEditar(id){
            const modal = document.getElementById('modal-editar-' + id);
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function cerrarModalEditar(id){
            const modal = document.getElementById('modal-editar-' + id);
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function confirmarEliminarEvento(id){
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Esta acción no se puede deshacer',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e3342f',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result)=>{
                if (result.isConfirmed){
                    document.getElementById('form-eliminar-evento-' + id).submit();
                }
            });
        }
    </script>
@endpush