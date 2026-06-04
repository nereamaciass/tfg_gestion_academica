@extends('layouts.admin')
@section('title', 'Ver Notificación')
@section('content')

<div class="max-w-4xl">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-5xl font-black text-[#0B1B3C] leading-none">
                {{ $notificacion->titulo }}
            </h1>

            <p class="text-gray-500 mt-3 text-lg">
                Enviada a:
                <span class="font-semibold text-gray-700">
                    {{ $notificacion->profesor->nombre ?? 'Profesor eliminado' }}
                </span>
            </p>
        </div>

        <a href="{{ route('admin.notificaciones.index') }}" class="px-6 py-3 rounded-2xl bg-white border border-gray-200 text-gray-700 font-semibold hover:bg-gray-50 transition shadow-sm">
            Volver
        </a>
    </div>

    <div class="bg-white rounded-[32px] border border-gray-200 shadow-sm p-8">
        <div class="text-gray-700 leading-relaxed text-lg whitespace-pre-line">
            {{ $notificacion->mensaje }}
        </div>
    </div>
</div>
@endsection