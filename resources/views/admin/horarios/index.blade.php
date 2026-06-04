@extends('layouts.admin')
@section('title', 'Gestión de Horarios')
@section('content')

<h1 class="text-3xl font-bold text-gray-800 mb-6">Horarios</h1>

<form method="GET" action="{{ route('admin.horarios.index') }}" class="flex gap-4 mb-6">
    <select name="profesor" class="border px-3 py-2 rounded-lg">
        <option value="">Seleccione un profesor</option>

        @foreach ($profesores as $prof)
            <option value="{{ $prof->id }}"
                {{ $profesorSeleccionado == $prof->id ? 'selected' : '' }}>
                {{ $prof->name }}
            </option>
        @endforeach
    </select>

    <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
        Ver horario
    </button>
</form>

@if (!$profesorSeleccionado)
    <p class="text-gray-600">
        Seleccione un profesor para ver o gestionar su horario.
    </p>
@else

    <div class="mb-4">
        <a href="{{ route('admin.horarios.pdf', ['profesor' => $profesorSeleccionado]) }}" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg shadow">
            Descargar PDF
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full bg-white shadow rounded-lg border">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-3 border text-center">Hora</th>
                    @foreach ($dias as $dia)
                        <th class="px-4 py-3 border text-center">
                            {{ $dia }}
                        </th>
                    @endforeach
                </tr>
            </thead>

            <tbody>
                @foreach ($horasRango as $hora)
                    @php
                        [$inicio, $fin] = explode('-', $hora);
                    @endphp

                    <tr>
                        <td class="border px-4 py-2 font-semibold text-center">
                            {{ $hora }}
                        </td>

                        @foreach ($dias as $dia)
                            @php
                                $celda = $horarios[$dia]->firstWhere('hora_inicio', $inicio) ?? null;

                                $asignatura = $celda?->asignatura;

                                $color = $asignatura?->color ?? '#d1fae5';
                            @endphp

                            @if ($celda)
                                <td class="border px-4 py-2 text-center" style="background-color: {{ $color }}">
                                    <div onclick="gestionarHorario({{ $celda->id }})" class="cursor-pointer block w-full h-full py-2 text-gray-900 font-semibold">
                                        <div>
                                            {{ $asignatura?->nombre }}
                                        </div>

                                        @if($asignatura?->curso)
                                            <div class="text-xs text-gray-800 font-normal mt-1">
                                                {{ $asignatura->curso }}
                                            </div>
                                        @endif
                                    </div>

                                    <form id="delete-{{ $celda->id }}" action="{{ route('admin.horarios.destroy', $celda->id) }}" method="POST" style="display:none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>

                            @else
                                <td class="border px-4 py-2 text-center bg-gray-100 hover:bg-gray-200">
                                    <a href="{{ route('admin.horarios.create', [ 'user_id' => $profesorSeleccionado, 'profesor_id' => $profesorSeleccionado, 'dia' => $dia, 'hora_inicio' => $inicio,'hora_fin' => $fin ]) }}" class="block w-full h-full py-2 text-gray-500">
                                        —
                                    </a>
                                </td>
                            @endif
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function gestionarHorario(id){
        Swal.fire({
            title: 'Horario ya asignado',
            text: '¿Qué deseas hacer con esta asignatura?',
            icon: 'question',

            showCancelButton: true,
            showDenyButton: true,

            confirmButtonText: 'Editar',
            denyButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar',

            confirmButtonColor: '#2563eb',
            denyButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280'

        }).then((result)=>{
            if(result.isConfirmed){
                window.location.href = '/admin/horarios/' + id + '/edit';
            }else if(result.isDenied){
                Swal.fire({
                    title: '¿Eliminar horario?',
                    text: 'Esta acción no se puede deshacer.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true,
                    scrollbarPadding: false,
                }).then((confirmacion)=>{
                    if(confirmacion.isConfirmed){
                        document.getElementById('delete-' + id).submit();
                    }
                });
            }
        });
    }
</script>
@endsection