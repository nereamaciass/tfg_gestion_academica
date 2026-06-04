@extends('layouts.profesor')
@section('title', 'Mi Perfil')
@section('content')

<div class="p-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">
        Mi Perfil
    </h1>

    @if(session('success'))
        <div class="mb-6 bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-5">
                <div class="relative">
                    <img src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=e5e7eb&color=111827&size=128' }}" class="w-20 h-20 rounded-full object-cover">

                    <form method="POST" action="{{ route('profesor.perfil.update') }}" enctype="multipart/form-data" class="absolute -bottom-1 -right-1">
                        @csrf
                        @method('PATCH')

                        <label class="bg-blue-600 hover:bg-blue-700 text-white w-8 h-8 rounded-full flex items-center justify-center cursor-pointer shadow">
                            ✎
                            <input type="file" name="profile_photo" class="hidden" onchange="this.form.submit()">
                        </label>
                    </form>
                </div>

                <div>
                    <h2 class="text-2xl font-bold text-gray-800">
                        {{ Auth::user()->name }}
                    </h2>

                    <p class="text-gray-500">
                        {{ Auth::user()->email }}
                    </p>

                    <span class="inline-block mt-2 bg-blue-100 text-blue-700 text-sm px-3 py-1 rounded-full">
                        Profesor
                    </span>
                </div>
            </div>

            <a href="{{ route('profesor.dashboard') }}" class="bg-slate-900 hover:bg-slate-800 text-white px-5 py-3 rounded-lg shadow transition">
                Volver al panel
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">
                Información del perfil
            </h2>
            
            <form method="POST" action="{{ route('profesor.perfil.update') }}">
                @csrf
                @method('PATCH')
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Nombre
                    </label>

                    <input type="text" value="{{ Auth::user()->name }}" disabled class="w-full border border-gray-300 rounded-lg px-4 py-3 bg-gray-100 text-gray-700">
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Correo electrónico
                    </label>

                    <input type="email" value="{{ Auth::user()->email }}" disabled class="w-full border border-gray-300 rounded-lg px-4 py-3 bg-gray-100 text-gray-700">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Departamento
                        </label>

                        <input type="text" value="{{ Auth::user()->profesor?->departamento ?? 'No asignado' }}" disabled class="w-full border border-gray-300 rounded-lg px-4 py-3 bg-gray-100 text-gray-700">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Teléfono
                        </label>

                        <input type="text" name="telefono" value="{{ old('telefono', Auth::user()->profesor?->telefono) }}" placeholder="Introduce tu teléfono" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>
                </div>

                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg shadow transition">
                    Guardar cambios
                </button>
            </form>
        </div>

        <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">
                Cambiar contraseña
            </h2>

            <form method="POST" action="{{ route('profesor.perfil.password') }}">
                @csrf
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Contraseña actual
                    </label>

                    <input type="password" name="current_password" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Nueva contraseña
                    </label>

                    <input type="password" name="password" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Confirmar contraseña
                    </label>

                    <input type="password" name="password_confirmation" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg shadow transition">
                    Actualizar contraseña
                </button>
            </form>
        </div>
    </div>
</div>
@endsection