@extends('layouts.admin')
@section('title', 'Detalles del Usuario')
@section('content')

<h1 class="text-3xl font-bold mb-6">Detalle Usuario</h1>

<div class="bg-white p-6 rounded-lg shadow-lg max-w-xl">
    <div class="mb-4">
        <label class="block font-semibold">Nombre</label>
        <p class="w-full border px-3 py-2 rounded bg-gray-50">
            {{ $usuario->name }}
        </p>
    </div>

    <div class="mb-4">
        <label class="block font-semibold">Email</label>
        <p class="w-full border px-3 py-2 rounded bg-gray-50">
            {{ $usuario->email }}
        </p>
    </div>

    <div class="mb-4">
        <label class="block font-semibold">Rol</label>
        <p class="w-full border px-3 py-2 rounded bg-gray-50">
            {{ ucfirst($usuario->role) }}
        </p>
    </div>

    <div class="flex justify-between mt-6">
        <a href="{{ route('admin.usuarios.index') }}" class="text-gray-600">
            Volver
        </a>

        <a href="{{ route('admin.usuarios.edit', $usuario) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2 rounded">
            Editar
        </a>
    </div>
</div>
@endsection