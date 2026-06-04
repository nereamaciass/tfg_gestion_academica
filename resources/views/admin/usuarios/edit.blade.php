@extends('layouts.admin')
@section('title', 'Editar Usuario')
@section('content')

<h1 class="text-3xl font-bold text-gray-800 mb-6">Editar Usuario</h1>

<div class="bg-white shadow rounded-lg p-6 w-full max-w-2xl">
    <form action="{{ route('admin.usuarios.update', $usuario) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold">Nombre</label>
            <input type="text" name="name" value="{{ old('name', $usuario->name) }}" class="w-full border px-3 py-2 rounded-lg @error('name') border-red-500 @enderror">
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold">Email</label>
            <input type="email" name="email" value="{{ old('email', $usuario->email) }}" required class="w-full border px-3 py-2 rounded-lg @error('email') border-red-500 @enderror">
            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold">Nueva Contraseña (opcional)</label>
            <input type="password" name="password" class="w-full border px-3 py-2 rounded-lg @error('password') border-red-500 @enderror">
            @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold">Rol</label>
            <select name="role" class="w-full p-2 border rounded">
                <option value="admin" {{ $usuario->role == 'admin' ? 'selected' : '' }}>Administrador</option>
                <option value="profesor" {{ $usuario->role == 'profesor' ? 'selected' : '' }}>Profesor</option>
            </select>
        </div>

        <div class="flex justify-between mt-6">
            <a href="{{ route('admin.usuarios.index') }}" class="text-gray-600">Volver</a>
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded">
                Actualizar
            </button>
        </div>
    </form>
</div>
@endsection