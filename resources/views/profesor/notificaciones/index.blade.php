@extends('layouts.profesor')
@section('title', 'Notificaciones')
@section('content')

<div class="mb-8">
    <h1 class="text-4xl font-bold text-gray-900">
        Notificaciones
    </h1>

    <p class="text-gray-500 mt-2">
        Gestiona avisos, mensajes y novedades del sistema.
    </p>
</div>

<div class="space-y-5">
    @forelse($notificaciones as $notificacion)
        <div class="bg-white border border-gray-200 rounded-3xl shadow-sm hover:shadow-md transition overflow-hidden">
            <div class="p-6 flex items-start justify-between gap-6">
                <div class="flex items-start gap-5 flex-1">
                    <div class="w-14 h-14 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11 a6.002 6.002 0 00-4-5.659V5 a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159 c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1 a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </div>

                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-3">
                            <h2 class="text-lg font-semibold text-gray-900">
                                {{ $notificacion->titulo }}
                            </h2>

                            @if(!$notificacion->leida)
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-700">
                                    Nueva
                                </span>
                            @else
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-500">
                                    Leída
                                </span>
                            @endif
                        </div>

                        <div class="flex items-center gap-2 mt-3">
                            <span class="text-sm text-gray-500">
                                Enviado por:
                            </span>

                            <span class="text-sm font-semibold text-blue-600">
                                {{ $notificacion->emisor->name ?? 'Administrador' }}
                            </span>
                        </div>

                        <p class="text-gray-600 mt-3 leading-relaxed">
                            {{ $notificacion->mensaje }}
                        </p>

                        <div class="flex items-center gap-2 mt-4 text-sm text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3 a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>

                            {{ $notificacion->created_at->format('d/m/Y H:i') }}
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-3 shrink-0">
                    <button onclick="mostrarDetalle('{{ $notificacion->titulo }}', '{{ $notificacion->mensaje }}', '{{ $notificacion->created_at->format('d/m/Y H:i') }}', '{{ $notificacion->emisor->name ?? 'Administrador' }}' )" class="px-5 py-2 rounded-xl border border-gray-200 hover:bg-gray-100 transition text-gray-700 font-medium">
                        Ver detalles
                    </button>

                    @if(!$notificacion->leida)
                        <form action="{{ route('profesor.notificaciones.leer', $notificacion->id) }}" method="POST">
                            @csrf
                            <button class="px-5 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 transition text-white font-medium shadow-sm">
                                Marcar como leída
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="bg-white border border-dashed border-gray-300 rounded-3xl p-16 text-center">
            <div class="w-20 h-20 rounded-full bg-gray-100 mx-auto flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11 a6.002 6.002 0 00-4-5.659V5 a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159 c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1 a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
            </div>

            <h2 class="text-2xl font-semibold text-gray-800 mt-6">
                No tienes notificaciones
            </h2>

            <p class="text-gray-500 mt-2">
                Cuando recibas avisos aparecerán aquí.
            </p>
        </div>
    @endforelse
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function mostrarDetalle(titulo, mensaje, fecha, emisor){
        Swal.fire({
            title: titulo,
            html: `
                <div class="text-left">
                    <div class="mb-4">
                        <span class="text-sm text-gray-500">
                            Enviado por:
                        </span>

                        <span class="text-sm font-semibold text-blue-600">
                            ${emisor}
                        </span>
                    </div>

                    <p class="text-gray-700 leading-relaxed">
                        ${mensaje}
                    </p>

                    <div class="mt-5 text-sm text-gray-400">
                        ${fecha}
                    </div>
                </div>
            `,
            confirmButtonText: 'Cerrar',
            confirmButtonColor: '#2563eb',
            width: 600
        });
    }
</script>
@endsection