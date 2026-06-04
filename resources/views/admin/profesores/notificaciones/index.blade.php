@extends('layouts.profesor')
@section('title', 'Notificaciones')
@section('content')

<div class="px-8 py-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">
        Notificaciones
    </h1>

    @foreach($notificaciones as $n)
    <div class="bg-white p-5 shadow-sm border rounded mb-4 {{ $n->leida ? '' : 'bg-blue-50' }}">
        <h2 class="text-xl font-semibold text-gray-800">
            {{ $n->titulo }}
        </h2>

        <p class="text-gray-700 mt-2">
            {{ $n->mensaje }}
        </p>

        <p class="text-gray-500 text-sm mt-3">
            {{ $n->created_at->format('d/m/Y H:i') }}
        </p>

        @if(!$n->leida)
        <form method="POST" action="{{ route('profesor.notificaciones.leer', $n->id) }}" class="mt-3">
            @csrf
            <button class="text-blue-600">Marcar como leída</button>
        </form>
        @endif
    </div>
    @endforeach
</div>
@endsection