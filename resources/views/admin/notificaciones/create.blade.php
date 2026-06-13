@extends('layouts.admin')
@section('title', 'Crear Notificación')
@section('content')

<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Crear Notificación</h1>

    <p class="text-gray-500 mt-3 text-lg">
        Envía avisos importantes a los profesores.
    </p>
</div>

<div class="bg-white rounded-[32px] border border-gray-200 shadow-sm overflow-hidden max-w-4xl">
    <div class="p-8">
        <form action="{{ route('admin.notificaciones.store') }}" method="POST" class="space-y-8">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    Profesor
                </label>

                <select name="profesor_id" required class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-5 py-4 text-gray-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                    <option value="">Seleccionar profesor...</option>

                    @foreach($profesores as $profesor)
                        <option value="{{ $profesor->id }}">
                            {{ $profesor->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    Título
                </label>

                <input type="text" name="titulo" required placeholder="Ej: Cambio de horario" class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-5 py-4 text-gray-800 placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    Mensaje
                </label>

                <textarea name="mensaje" rows="6" required placeholder="Escribe el mensaje de la notificación..." class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-5 py-4 text-gray-800 placeholder-gray-400 resize-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"></textarea>
            </div>

            <div class="flex items-center justify-between pt-2">
                <a href="{{ route('admin.notificaciones.index') }}" class="px-5 py-3 rounded-2xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold transition">
                    Volver
                </a>

                <button type="submit" class="px-8 py-4 bg-[#2563EB] hover:bg-blue-700 text-white rounded-2xl font-bold shadow-lg shadow-blue-200 transition">
                    Enviar notificación
                </button>
            </div>
        </form>
    </div>
</div>
@endsection