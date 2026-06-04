@extends('layouts.admin')
@section('title', 'Panel de Administración')
@section('content')

<link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

<h1 class="text-3xl font-bold text-gray-800 mb-4">Panel de Control</h1>

<p class="text-gray-600 mb-10">
    Bienvenido, {{ Auth::user()->name }}. Desde aquí podrá gestionar el sistema académico del centro educativo.
</p>

<div class="grid md:grid-cols-3 gap-6">
    <a href="{{ route('admin.profesores.index') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition cursor-pointer">
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Profesores</h3>
        <p class="text-gray-600 text-sm">Gestión del personal docente.</p>
    </a>

    <a href="{{ route('admin.asignaturas.index') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition cursor-pointer">
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Asignaturas</h3>
        <p class="text-gray-600 text-sm">Gestión académica y cursos.</p>
    </a>

    <a href="{{ route('admin.usuarios.index') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition cursor-pointer">
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Usuarios</h3>
        <p class="text-gray-600 text-sm">Gestión de usuarios del sistema.</p>
    </a>

    <a href="{{ route('admin.horarios.index') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition cursor-pointer">
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Horarios</h3>
        <p class="text-gray-600 text-sm">Gestión de horarios del personal docente.</p>
    </a>
</div>
@endsection