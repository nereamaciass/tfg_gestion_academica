@extends('layouts.admin')
@section('title', 'Notificaciones')
@section('content')

<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Notificaciones</h1>

        <p class="text-gray-500 mt-3 text-lg">
            Gestiona todas las notificaciones enviadas a los profesores.
        </p>
    </div>

    <a href="{{ route('admin.notificaciones.create') }}" class="px-8 py-4 bg-[#2563EB] hover:bg-blue-700 text-white rounded-2xl font-bold shadow-lg shadow-blue-200 transition flex items-center gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">

            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Nueva notificación
    </a>
</div>

<div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
    @forelse($notificaciones as $notificacion)
        <div class="bg-white rounded-[28px] border border-gray-200 shadow-sm p-6 flex items-start justify-between hover:shadow-md transition">
            <div class="flex items-start gap-5">
                <div class="w-14 h-14 rounded-2xl bg-blue-100 flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11 a6.002 6.002 0 00-4-5.659V5 a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159 c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1 a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </div>

                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <h2 class="text-3xl font-black text-[#0B1B3C]">
                            {{ $notificacion->titulo }}
                        </h2>

                        @if($notificacion->leida)
                            <span class="px-4 py-1 rounded-full text-sm font-bold bg-green-100 text-green-700">
                                Leída
                            </span>
                        @else
                            <span class="px-4 py-1 rounded-full text-sm font-bold bg-yellow-100 text-yellow-700">
                                Pendiente
                            </span>
                        @endif
                    </div>

                    <p class="text-gray-500 text-lg">
                        Enviada a:
                        <span class="font-bold text-[#0B1B3C]">
                            {{ $notificacion->profesor->nombre ?? 'Profesor eliminado' }}
                        </span>
                    </p>

                    <div class="text-gray-400 text-lg mt-2">
                        {{ $notificacion->created_at->format('d/m/Y H:i') }}
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <button onclick="abrirModal('{{ addslashes($notificacion->titulo) }}','{{ addslashes($notificacion->mensaje) }}', '{{ $notificacion->created_at->format('d/m/Y H:i') }}','{{ addslashes($notificacion->profesor->nombre ?? 'Profesor eliminado') }}' )" class="px-5 py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold text-sm transition">
                    Ver detalles
                </button>

                <form action="{{ route('admin.notificaciones.destroy', $notificacion->id) }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-red-50 hover:bg-red-100 text-red-600 font-semibold text-sm transition">
                        Eliminar
                    </button>
                </form>
            </div>
        </div>
    @empty

        <div class="col-span-full py-24 text-center">
            <div class="text-7xl mb-5">
                🔔
            </div>

            <h2 class="text-3xl font-black text-[#0B1B3C] mb-3">
                No hay notificaciones
            </h2>

            <p class="text-gray-500 text-lg">
                Las notificaciones enviadas aparecerán aquí.
            </p>
        </div>
    @endforelse
</div>

<div id="modalNotificacion" class="fixed inset-0 bg-black/40 backdrop-blur-sm hidden items-center justify-center z-50">
    <div class="bg-white w-full max-w-2xl rounded-[28px] shadow-2xl p-10 relative animate-fadeIn">
        <div class="text-center mb-8">
            <h2 id="modalTitulo"
                class="text-5xl font-black text-[#0B1B3C] leading-none">
            </h2>
        </div>

        <div class="space-y-6">
            <div class="flex items-center gap-2 text-gray-500 text-lg">
                <span>Enviada a:</span>
                <span id="modalProfesor" class="font-bold text-blue-600"></span>
            </div>

            <div id="modalMensaje" class="text-gray-700 text-2xl leading-relaxed whitespace-pre-line"></div>

            <div id="modalFecha" class="text-gray-400 text-lg pt-2"></div>
        </div>

        <div class="flex justify-center mt-10">
            <button onclick="cerrarModal()" class="px-8 py-4 bg-[#2563EB] hover:bg-blue-700 text-white rounded-2xl font-bold shadow-lg shadow-blue-200 transition">
                Cerrar
            </button>
        </div>
    </div>
</div>

<script>
    function abrirModal(titulo, mensaje, fecha, profesor){
        document.getElementById('modalTitulo').innerText = titulo;
        document.getElementById('modalMensaje').innerText = mensaje;
        document.getElementById('modalFecha').innerText = fecha;
        document.getElementById('modalProfesor').innerText = profesor;

        const modal = document.getElementById('modalNotificacion');

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function cerrarModal(){
        const modal = document.getElementById('modalNotificacion');

        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }
</script>

<style>
    @keyframes fadeIn{
        from{
            opacity: 0;
            transform: scale(.95);
        }

        to{
            opacity: 1;
            transform: scale(1);
        }
    }

    .animate-fadeIn{
        animation: fadeIn .2s ease;
    }
</style>
@endsection