@extends('layouts.profesor')
@section('title', 'Mis Asignaturas')
@section('content')

<h1 class="text-3xl font-bold text-gray-800 mb-8">Mis Asignaturas</h1>

<div class="bg-white rounded-lg shadow p-6 mb-8">
    <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <input type="text" name="buscar" value="{{ $busqueda }}" placeholder="Buscar asignatura..." class="border px-4 py-2 rounded-lg w-full">

        <select name="curso" class="border px-4 py-2 rounded-lg w-full">
            <option value="">Todos los cursos</option>
            @foreach($cursos as $curso)
                <option value="{{ $curso }}"
                    {{ $cursoSeleccionado == $curso ? 'selected' : '' }}>
                    Curso {{ $curso }}
                </option>
            @endforeach
        </select>

        <button class="bg-blue-600 text-white px-4 py-2 rounded-lg">
            Filtrar
        </button>
    </form>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse ($asignaturas as $asig)
        <div class="bg-white rounded-lg shadow p-6 border">
            <h2 class="text-xl font-semibold text-gray-800">
                {{ $asig->nombre }}
            </h2>

            <p class="text-gray-600 mt-2">
                Código: <strong>{{ $asig->codigo }}</strong>
            </p>

            <p class="text-gray-600">
                Curso: {{ $asig->curso }}
            </p>

            <a href="{{ route('profesor.asignaturas.show', $asig->id) }}" class="mt-4 inline-block bg-green-600 text-white px-4 py-2 rounded-lg text-center">
                Ver detalles
            </a>
        </div>
    @empty
        <p class="text-gray-600">No tienes asignaturas registradas.</p>
    @endforelse
</div>

<div class="mt-6">
    {{ $asignaturas->links() }}
</div>
@endsection