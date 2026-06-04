@extends('profesor.layout')
@section('title', 'Detalles de la Asignatura')
@section('content')

<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-5xl font-black text-[#0B1B3C]">
            Detalles de la Asignatura
        </h1>
    </div>
</div>

<div class="grid md:grid-cols-3 gap-6">
    <div class="bg-white rounded-3xl p-6 border border-gray-200 shadow-sm">
        <div class="text-gray-500 text-sm">
            Asignatura
        </div>
        <div class="font-bold text-xl text-[#0B1B3C] mt-2">
            {{ $asignatura->nombre }}
        </div>
    </div>

    <div class="bg-white rounded-3xl p-6 border border-gray-200 shadow-sm">
        <div class="text-gray-500 text-sm">
            Código
        </div>
        <div class="font-bold text-xl text-[#0B1B3C] mt-2">
            {{ $asignatura->codigo }}
        </div>
    </div>

    <div class="bg-white rounded-3xl p-6 border border-gray-200 shadow-sm">
        <div class="text-gray-500 text-sm">
            Curso
        </div>
        <div class="mt-3">
            <span class="px-4 py-2 bg-blue-100 text-blue-700 rounded-full font-semibold">
                {{ $asignatura->curso }}
            </span>
        </div>
    </div>
</div>

<div class="bg-white rounded-3xl p-8 border border-gray-200 shadow-sm mt-8">
    <h2 class="text-2xl font-bold text-[#0B1B3C] mb-6">
        Horario de la asignatura
    </h2>

    @php
        $profesor = auth()->user()->profesor;
        $horarios = $profesor
            ? $profesor->horarios()
                ->where('asignatura_id', $asignatura->id)
                ->orderBy('dia')
                ->orderBy('hora_inicio')
                ->get()
            : collect();
    @endphp

    @if($horarios->count() === 0)
        <div class="bg-gray-50 border border-gray-200 rounded-2xl p-6 text-gray-500">
            No tienes clases asignadas para esta asignatura.
        </div>
    @else
        <table class="w-full overflow-hidden rounded-2xl">
            <thead>
                <tr class="bg-gray-100 text-gray-700">
                    <th class="p-4 text-left rounded-l-2xl">
                        Día
                    </th>
                    <th class="p-4 text-left">
                        Hora inicio
                    </th>
                    <th class="p-4 text-left rounded-r-2xl">
                        Hora fin
                    </th>
                </tr>
            </thead>

            <tbody>
                @foreach($horarios as $h)
                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                        <td class="p-4 font-semibold text-gray-800">
                            {{ ucfirst($h->dia) }}
                        </td>
                        <td class="p-4 text-gray-700">
                            {{ $h->hora_inicio }}
                        </td>
                        <td class="p-4 text-gray-700">
                            {{ $h->hora_fin }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

<div class="mt-8">
    <a href="{{ route('profesor.asignaturas.index') }}" class="inline-flex items-center px-5 py-3 bg-gray-100 hover:bg-gray-200 rounded-2xl font-semibold transition">
        Volver
    </a>
</div>
@endsection