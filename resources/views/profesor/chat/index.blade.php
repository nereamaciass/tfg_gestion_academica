@extends('layouts.profesor')
@section('title', 'Chat')
@section('content')

<div class="h-[100dvh] flex flex-col">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">
            Chat
        </h1>

        <p class="text-gray-500 mt-1">
            Conversaciones disponibles
        </p>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-200 overflow-hidden flex flex-col mb-10">
        <div class="p-5 border-b border-gray-200">
            <div class="relative">
                <input type="text" id="buscarUsuario" placeholder="Buscar conversación..." class="w-full bg-[#f5f7fb] border border-gray-200 rounded-2xl pl-12 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500" >

                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400 absolute left-4 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto">
            @forelse ($usuarios as $u)
                <div class="usuario-item" id="usuario-{{ $u->id }}" data-nombre="{{ strtolower($u->name) }}">
                    <a href="{{ route('profesor.chat.conversacion', $u->id) }}" class="flex items-center gap-4 px-6 py-5 border-b border-gray-100 hover:bg-blue-50 transition">
                        <div class="relative shrink-0">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($u->name) }}&background=0B3C63&color=ffffff&size=128" class="w-14 h-14 rounded-full object-cover border border-gray-200">

                            <span class="absolute bottom-0 right-0 w-4 h-4 bg-green-500 border-2 border-white rounded-full"></span>
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <h2 class="font-semibold text-gray-900 truncate text-lg">
                                        {{ $u->name }}
                                    </h2>
                                <div class="preview-mensaje text-sm text-gray-500 truncate mt-1">
                                        @if($u->ultimo_mensaje)
                                            @if($u->ultimo_mensaje->mensaje)
                                                {{ Str::limit($u->ultimo_mensaje->mensaje, 40) }}
                                            @elseif($u->ultimo_mensaje->archivo)
                                                @php
                                                    $extension = strtolower(pathinfo($u->ultimo_mensaje->archivo, PATHINFO_EXTENSION));
                                                    $nombreArchivo = basename($u->ultimo_mensaje->archivo);
                                                    $esImagen = in_array($extension, ['jpg', 'jpeg', 'png', 'webp']);
                                                @endphp

                                                @if($esImagen)
                                                    <div class="flex items-center gap-2 mt-1">
                                                        <img src="{{ asset('storage/' . $u->ultimo_mensaje->archivo) }}" class="w-10 h-10 rounded-lg object-cover border border-gray-200">

                                                        <span class="text-sm text-gray-500">
                                                            Imagen
                                                        </span>
                                                    </div>
                                                @else
                                                    <div class="flex items-center gap-2 mt-1">
                                                        <span class="text-lg">
                                                            @if($extension == 'pdf')
                                                                📕
                                                            @elseif(in_array($extension, ['doc', 'docx']))
                                                                📝
                                                            @elseif(in_array($extension, ['xls', 'xlsx']))
                                                                📊
                                                            @else
                                                                📎
                                                            @endif
                                                        </span>

                                                        <span class="text-sm text-gray-500 truncate max-w-[180px]">
                                                            {{ $nombreArchivo }}
                                                        </span>
                                                    </div>
                                                @endif
                                            @endif
                                        @else
                                            No hay mensajes todavía
                                        @endif
                                    </div>
                                </div>

                                <div class="flex flex-col items-end gap-2 shrink-0">
                                    @if($u->ultimo_mensaje)
                                        <span class="hora-mensaje text-xs text-gray-400">
                                            {{ $u->ultimo_mensaje->created_at->format('H:i') }}
                                        </span>
                                    @endif

                                    @if($u->no_leidos > 0)
                                        <span class="min-w-[22px] h-[22px] px-2 rounded-full bg-blue-600 text-white text-xs flex items-center justify-center font-semibold">
                                            {{ $u->no_leidos }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="h-full flex items-center justify-center text-gray-500 py-20">
                    No hay usuarios disponibles.
                </div>
            @endforelse
        </div>
    </div>
</div>

<script>
    const buscador = document.getElementById('buscarUsuario');

    if(buscador){
        buscador.addEventListener('input', function(){
            const valor = this.value.toLowerCase();

            document.querySelectorAll('.usuario-item').forEach(usuario=>{
                const nombre = usuario.dataset.nombre;

                if(nombre.includes(valor)){
                    usuario.style.display = '';
                }else{
                    usuario.style.display = 'none';
                }
            });
        });
    }
</script>

<script>
    window.userId = {{ auth()->id() }};
</script>
@endsection