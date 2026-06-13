@extends('layouts.admin')
@section('title', 'Detalle de Asignatura')
@section('content')

<h1 class="text-3xl font-bold mb-6">Detalle de Asignatura</h1>

<div class="bg-white p-6 rounded-lg shadow w-full max-w-xl">

    <div class="mb-4">
        <p class="text-gray-500">Nombre</p>
        <p class="font-semibold text-lg">{{ $asignatura->nombre }}</p>
    </div>

    <div class="mb-4">
        <p class="text-gray-500">Código</p>
        <p class="font-semibold">{{ $asignatura->codigo }}</p>
    </div>

    <div class="mb-4">
        <p class="text-gray-500">Curso</p>
        <p class="font-semibold">Curso {{ $asignatura->curso }}</p>
    </div>

    <div class="mb-4">
        <p class="text-gray-500">Color</p>

        <span class="px-3 py-1 rounded text-white text-sm"
              style="background-color: {{ $asignatura->color ?? '#004d80' }}">
            {{ $asignatura->color ?? '#004d80' }}
        </span>
    </div>

    <div class="mb-4">
        <p class="text-gray-500">Profesores</p>

        @if($asignatura->profesores->count())
            <div class="flex flex-col gap-1 mt-1">
                @foreach($asignatura->profesores as $prof)
                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm w-fit">
                        {{ $prof->nombre }}
                    </span>
                @endforeach
            </div>
        @else
            <p class="text-gray-400 italic">Sin profesores asignados</p>
        @endif
    </div>

    <div class="flex justify-between mt-6">
        <a href="{{ route('admin.asignaturas.index') }}" class="px-5 py-3 rounded-2xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold transition">
            Volver
        </a>

        <a href="{{ route('admin.asignaturas.edit', $asignatura) }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
            Editar
        </a>
    </div>
</div>
@endsection