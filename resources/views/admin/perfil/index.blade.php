@extends('layouts.admin')
@section('title', 'Mi Perfil')
@section('content')

<h1 class="text-3xl font-bold text-gray-800 mb-6">Mi Perfil</h1>

<div class="max-w-6xl space-y-5">
    <div class="bg-white rounded-lg shadow p-6 flex items-center justify-between">
        <div class="flex items-center gap-5">
            <div class="relative">
                <img id="previewImg" src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=e5e7eb&color=111827&size=128' }}" class="w-20 h-20 rounded-full object-cover border shadow-sm">

                <label class="absolute -bottom-1 -right-1 bg-blue-600 hover:bg-blue-700 text-white w-8 h-8 rounded-full flex items-center justify-center cursor-pointer shadow">
                    <span class="text-sm">✎</span>
                    <input type="file" name="profile_photo" id="imageInput" form="perfilForm" class="hidden" accept="image/*">
                </label>
            </div>

            <div>
                <h2 class="text-2xl font-bold text-gray-800">{{ Auth::user()->name }}</h2>
                <p class="text-gray-500">{{ Auth::user()->email }}</p>

                <span class="inline-block mt-3 bg-blue-100 text-blue-700 text-sm px-3 py-1 rounded-full">
                    Administrador
                </span>
            </div>
        </div>

        <a href="{{ route('admin.dashboard') }}" class="bg-gray-800 hover:bg-black text-white px-4 py-2 rounded-lg">
            Volver al panel
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Información del perfil</h2>

            <form id="perfilForm" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-1">Nombre</label>
                    <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" class="w-full border px-3 py-2 rounded-lg">
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-semibold mb-1">Correo electrónico</label>
                    <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" class="w-full border px-3 py-2 rounded-lg">
                </div>

                <button class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">
                    Guardar cambios
                </button>
            </form>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Cambiar contraseña</h2>

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="block text-sm font-semibold mb-1">Contraseña actual</label>
                    <input type="password" name="current_password" class="w-full border px-3 py-2 rounded-lg">
                </div>

                <div class="mb-3">
                    <label class="block text-sm font-semibold mb-1">Nueva contraseña</label>
                    <input type="password" name="password" class="w-full border px-3 py-2 rounded-lg">
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-semibold mb-1">Confirmar contraseña</label>
                    <input type="password" name="password_confirmation" class="w-full border px-3 py-2 rounded-lg">
                </div>

                <button class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">
                    Actualizar contraseña
                </button>
            </form>
        </div>
    </div>

    <div class="bg-white p-5 rounded-lg shadow border border-red-200 flex items-center justify-between">
        <div>
            <h2 class="text-xl font-semibold text-red-600">Zona peligrosa</h2>
            <p class="text-sm text-gray-500 mt-1">Acciones irreversibles</p>
        </div>

        <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('¿Seguro que deseas eliminar tu cuenta?')">
            @csrf
            @method('DELETE')

            <button class="bg-red-100 hover:bg-red-200 text-red-700 px-4 py-2 rounded-lg">
                Eliminar cuenta
            </button>
        </form>
    </div>
</div>

@endsection

@push('scripts')
    <script>
        document.getElementById('imageInput').addEventListener('change', function(e){
            const file = e.target.files[0];

            if(file){
                document.getElementById('previewImg').src = URL.createObjectURL(file);
            }
        });
    </script>
@endpush