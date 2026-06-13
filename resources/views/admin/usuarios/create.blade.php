@extends('layouts.admin')
@section('title', 'Crear Usuario')
@section('content')

<h1 class="text-3xl font-bold text-gray-800 mb-6">Crear Usuario</h1>

<div class="bg-white shadow rounded-lg p-6 w-full max-w-2xl">
    <form action="{{ route('admin.usuarios.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold">Nombre</label>
            <input type="text" name="name" value="{{ old('name') }}" class="w-full border px-3 py-2 rounded-lg @error('name') border-red-500 @enderror">
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="w-full border px-3 py-2 rounded-lg @error('email') border-red-500 @enderror">
            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold">Contraseña</label>
            <input type="password" name="password" class="w-full border px-3 py-2 rounded-lg @error('password') border-red-500 @enderror">
            @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold">Rol</label>
            <select name="role" class="w-full p-2 border rounded">
                <option value="profesor">Profesor</option>
                <option value="admin">Administrador</option>
            </select>
        </div>

        <div class="flex justify-between mt-6">
            <a href="{{ route('admin.usuarios.index') }}" class="px-5 py-3 rounded-2xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold transition">
                Volver
            </a>
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded">
                Guardar
            </button>
        </div>
    </form>
</div>
@endsection