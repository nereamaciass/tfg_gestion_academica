@extends('layouts.admin')
@section('title', 'Editar horario')
@section('content')

<div class="mb-8">
    <h1 class="text-5xl font-black text-[#0B1B3C] leading-none">
        Editar horario
    </h1>
    <p class="text-gray-500 mt-3 text-lg">
        Modifica la asignatura asignada a esta franja horaria.
    </p>
</div>

<div class="bg-white rounded-[32px] border border-gray-200 shadow-sm overflow-hidden max-w-3xl">
    <div class="p-8">
        <div class="space-y-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    Profesor
                </label>

                <input type="text" readonly value="{{ $horario->profesor->nombre }}" class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-5 py-4 text-gray-800">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    Franja horaria
                </label>

                <input type="text" readonly value="{{ $horario->dia }} | {{ $horario->hora_inicio }} - {{ $horario->hora_fin }}" class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-5 py-4 text-gray-800">
            </div>
        </div>

        <form method="POST" action="{{ route('admin.horarios.update', $horario->id) }}" class="mt-6">
            @csrf
            @method('PUT')

            <input type="hidden" name="profesor_id" value="{{ $horario->profesor_id }}">

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    Asignatura
                </label>

                @if ($asignaturasProfesor->count() === 0)
                    <select disabled class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-5 py-4 text-gray-500">
                        <option>
                            No hay asignaturas asignadas a este profesor
                        </option>
                    </select>
                @else
                    <select name="asignatura_id" class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-5 py-4 text-gray-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                        @foreach ($asignaturasProfesor as $asignatura)
                            <option value="{{ $asignatura->id }}"
                                {{ $asignatura->id == $horario->asignatura_id ? 'selected' : '' }}>

                                {{ $asignatura->nombre }}
                                @if($asignatura->curso)
                                    — {{ $asignatura->curso }}
                                @endif
                            </option>
                        @endforeach
                    </select>
                @endif
            </div>

            <div class="flex justify-between items-center mt-10">
                <a href="{{ route('admin.horarios.index', ['profesor' => $horario->user_id]) }}" class="px-5 py-3 rounded-2xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold transition">
                    Volver
                </a>

                <button type="submit" class="px-8 py-4 bg-[#2563EB] hover:bg-blue-700 text-white rounded-2xl font-bold shadow-lg shadow-blue-200 transition">
                    Guardar cambios
                </button>
            </div>
        </form>

        <div class="border-t border-gray-100 mt-8 pt-8">
            <form method="POST" action="{{ route('admin.horarios.destroy', $horario->id) }}">
                @csrf
                @method('DELETE')

                <button onclick="return confirm('¿Seguro que quieres eliminar este horario?')" class="px-6 py-3 bg-red-50 hover:bg-red-100 text-red-600 rounded-2xl font-semibold transition">
                    Eliminar horario
                </button>
            </form>
        </div>
    </div>
</div>
@endsection