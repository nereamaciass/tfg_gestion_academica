@extends('layouts.admin')

@section('content')

<h1 class="text-3xl font-bold text-gray-800 mb-6">Mi Perfil</h1>

<div class="space-y-6 max-w-2xl">

    <div class="bg-white p-6 rounded-lg shadow">

        <h2 class="text-lg font-semibold mb-4">Información del perfil</h2>

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PATCH')

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Nombre</label>
                <input type="text" name="name"
                       value="{{ old('name', auth()->user()->name) }}"
                       class="w-full border px-3 py-2 rounded-lg"
                       required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Correo electrónico</label>
                <input type="email" name="email"
                       value="{{ old('email', auth()->user()->email) }}"
                       class="w-full border px-3 py-2 rounded-lg"
                       required>
            </div>

            <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                Guardar cambios
            </button>

        </form>
    </div>

    <div class="bg-white p-6 rounded-lg shadow">

        <h2 class="text-lg font-semibold mb-4">Cambiar contraseña</h2>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Contraseña actual</label>
                <input type="password" name="current_password"
                       class="w-full border px-3 py-2 rounded-lg">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Nueva contraseña</label>
                <input type="password" name="password"
                       class="w-full border px-3 py-2 rounded-lg">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Confirmar contraseña</label>
                <input type="password" name="password_confirmation"
                       class="w-full border px-3 py-2 rounded-lg">
            </div>

            <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                Actualizar contraseña
            </button>

        </form>
    </div>

    {{-- ELIMINAR CUENTA --}}
    <div class="bg-white p-6 rounded-lg shadow border border-red-200">

        <h2 class="text-lg font-semibold text-red-600 mb-4">Eliminar cuenta</h2>

        <p class="text-sm text-gray-600 mb-4">
            Esta acción es irreversible. Se eliminarán todos tus datos.
        </p>

        <form method="POST" action="{{ route('profile.destroy') }}">
            @csrf
            @method('DELETE')

            <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg">
                Eliminar cuenta
            </button>
        </form>

    </div>

</div>

@endsection