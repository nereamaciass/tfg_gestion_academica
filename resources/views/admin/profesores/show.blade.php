@extends('layouts.admin')
@section('title', 'Detalles del Profesor')
@section('content')

<h1 class="text-3xl font-bold mb-6">Detalle del Profesor</h1>

<div class="bg-white p-6 rounded-lg shadow-lg max-w-2xl">
    <div class="flex items-center gap-5 mb-6 border-b pb-6">
        @if($profesor->user && $profesor->user->profile_photo)
            <img src="{{ asset('storage/' . $profesor->user->profile_photo) }}" class="w-20 h-20 rounded-full object-cover border shadow-sm">
        @else
            <img src="https://ui-avatars.com/api/?name={{ urlencode($profesor->nombre) }}&background=e5e7eb&color=111827&size=128" class="w-20 h-20 rounded-full object-cover border shadow-sm">
        @endif

        <div>
            <h2 class="text-2xl font-bold text-gray-800">
                {{ $profesor->nombre }}
            </h2>

            <p class="text-gray-500">
                {{ $profesor->email }}
            </p>

            @if($profesor->user)
                <span class="inline-block mt-2 bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">
                    Cuenta de usuario vinculada
                </span>
            @else
                <span class="inline-block mt-2 bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-sm font-semibold">
                    Sin cuenta de usuario
                </span>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <span class="font-semibold">Nombre:</span>
            <p class="text-gray-700">{{ $profesor->nombre }}</p>
        </div>

        <div>
            <span class="font-semibold">Email:</span>
            <p class="text-gray-700">{{ $profesor->email }}</p>
        </div>

        <div>
            <span class="font-semibold">Teléfono:</span>
            <p class="text-gray-700">{{ $profesor->telefono ?? '—' }}</p>
        </div>

        <div>
            <span class="font-semibold">Departamento:</span>
            <p class="text-gray-700">{{ $profesor->departamento ?? '—' }}</p>
        </div>

        <div>
            <span class="font-semibold">Usuario vinculado:</span>
            <p class="text-gray-700">
                {{ $profesor->user ? 'Sí' : 'No' }}
            </p>
        </div>

        <div>
            <span class="font-semibold">Rol:</span>
            <p class="text-gray-700">
                {{ $profesor->user ? ucfirst($profesor->user->role) : '—' }}
            </p>
        </div>

    </div>

    <div class="mt-6">
        <span class="font-semibold">Asignaturas:</span>

        <ul class="list-disc ml-5 text-gray-700 mt-2">
            @forelse($profesor->asignaturas as $asignatura)
                <li>{{ $asignatura->nombre }} – Curso {{ $asignatura->curso }}</li>
            @empty
                <li>No tiene asignaturas asignadas</li>
            @endforelse
        </ul>
    </div>

    <div class="flex justify-between mt-6">
        <a href="{{ route('admin.profesores.index') }}" class="px-5 py-3 rounded-2xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold transition">
            Volver
        </a>

        <a href="{{ route('admin.profesores.edit', $profesor) }}"
           class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2 rounded">
            Editar
        </a>
    </div>
</div>
@endsection