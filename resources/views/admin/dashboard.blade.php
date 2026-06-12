@extends('layouts.admin')
@section('title', 'Panel de Administración')

@section('content')

<link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

<h1 class="text-3xl font-bold text-gray-800 mb-4">
    Panel de Control
</h1>

<p class="text-gray-600 mb-10">
    Bienvenido, {{ Auth::user()->name }}. Desde aquí podrá gestionar el sistema académico del centro educativo.
</p>

<div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
    <a href="{{ route('admin.profesores.index') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition text-center">
        <div class="text-5xl mb-3">👨‍🏫</div>

        <h3 class="text-xl font-semibold text-gray-800">
            Profesores
        </h3>

        <p class="text-4xl font-bold text-blue-700 mt-4">
            {{ $totalProfesores }}
        </p>

        <p class="text-gray-500 text-sm mt-1">
            Registrados
        </p>
    </a>

    <a href="{{ route('admin.asignaturas.index') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition text-center">
        <div class="text-5xl mb-3">📚</div>

        <h3 class="text-xl font-semibold text-gray-800">
            Asignaturas
        </h3>

        <p class="text-4xl font-bold text-blue-700 mt-4">
            {{ $totalAsignaturas }}
        </p>

        <p class="text-gray-500 text-sm mt-1">
            Registradas
        </p>
    </a>

    <a href="{{ route('admin.usuarios.index') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition text-center">
        <div class="text-5xl mb-3">👥</div>

        <h3 class="text-xl font-semibold text-gray-800">
            Usuarios
        </h3>

        <p class="text-4xl font-bold text-blue-700 mt-4">
            {{ $totalUsuarios }}
        </p>

        <p class="text-gray-500 text-sm mt-1">
            Registrados
        </p>
    </a>

    <a href="{{ route('admin.horarios.index') }}"
       class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition text-center">
        <div class="text-5xl mb-3">🕒</div>

        <h3 class="text-xl font-semibold text-gray-800">
            Horarios
        </h3>

        <p class="text-4xl font-bold text-blue-700 mt-4">
            {{ $totalHorarios }}
        </p>

        <p class="text-gray-500 text-sm mt-1">
            Registros
        </p>
    </a>
</div>

<div class="mt-10">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">
        Accesos Rápidos
    </h2>

    <div class="grid md:grid-cols-4 gap-4">
        <a href="{{ route('admin.profesores.create') }}" class="bg-blue-600 hover:bg-blue-700 hover:-translate-y-1 hover:shadow-xl text-white p-6 rounded-lg shadow text-center transition duration-200">
            <div class="text-3xl mb-2">👨‍🏫</div>
            <div class="font-semibold">Nuevo Profesor</div>
        </a>

        <a href="{{ route('admin.asignaturas.create') }}" class="bg-green-600 hover:bg-green-700 hover:-translate-y-1 hover:shadow-xl text-white p-6 rounded-lg shadow text-center transition duration-200">
            <div class="text-3xl mb-2">📚</div>
            <div class="font-semibold">Nueva Asignatura</div>
        </a>

        <a href="{{ route('admin.horarios.create') }}" class="bg-purple-600 hover:bg-purple-700 hover:-translate-y-1 hover:shadow-xl text-white p-6 rounded-lg shadow text-center transition duration-200">
            <div class="text-3xl mb-2">🕒</div>
            <div class="font-semibold">Nuevo Horario</div>
        </a>

        <a href="{{ route('admin.notificaciones.create') }}" class="bg-orange-600 hover:bg-orange-700 hover:-translate-y-1 hover:shadow-xl text-white p-6 rounded-lg shadow text-center transition duration-200">
            <div class="text-3xl mb-2">📢</div>
            <div class="font-semibold">Nueva Notificación</div>
        </a>

    </div>
</div>
@endsection