@extends('layouts.admin')
@section('title', 'Crear horario')
@section('content')

<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-5xl font-black text-[#0B1B3C] leading-none">
            Añadir asignatura al horario
        </h1>
    </div>
</div>

@php
    $profesor = \App\Models\Profesor::find($profesor_id);
@endphp

<div class="bg-white rounded-[32px] border border-gray-200 shadow-sm overflow-hidden max-w-3xl">
    <div class="p-8">
        <form method="POST" action="{{ route('admin.horarios.store') }}">
            @csrf
            <input type="hidden" name="user_id" value="{{ $user_id }}">
            <input type="hidden" name="profesor_id" value="{{ $profesor_id }}">
            <input type="hidden" name="dia" value="{{ $dia }}">
            <input type="hidden" name="hora_inicio" value="{{ $hora_inicio }}">
            <input type="hidden" name="hora_fin" value="{{ $hora_fin }}">

            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                        Profesor
                    </label>

                    <input type="text" readonly value="{{ $profesor ? $profesor->nombre : 'Profesor no encontrado' }}" class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-5 py-4 text-gray-800">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                        Asignatura
                    </label>

                    <select name="asignatura_id" required class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-5 py-4 text-gray-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                        @forelse($asignaturas as $asignatura)
                            <option value="{{ $asignatura->id }}">
                                {{ $asignatura->nombre }}
                                @if($asignatura->curso)
                                    — Curso {{ $asignatura->curso }}
                                @endif
                            </option>
                        @empty
                            <option disabled>
                                No hay asignaturas asignadas a este profesor
                            </option>
                        @endforelse
                    </select>
                </div>
            </div>

            <div class="flex justify-between items-center mt-10">
                <a href="{{ route('admin.horarios.index', ['profesor' => $user_id]) }}" class="text-gray-600 hover:text-gray-900 font-medium transition">
                    Volver
                </a>

                <button type="submit" class="px-8 py-4 bg-[#2563EB] hover:bg-blue-700 text-white rounded-2xl font-bold shadow-lg shadow-blue-200 transition">
                    Añadir asignatura
                </button>
            </div>
        </form>
    </div>
</div>
@endsection