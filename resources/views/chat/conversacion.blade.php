@extends('layouts.' . auth()->user()->role)
@section('title', 'Chat - Conversación')
@section('content')

<div class="h-[100dvh] overflow-hidden flex min-w-0 bg-[#f5f7fb]">
    <div class="{{ isset($destinatario) ? 'hidden md:flex' : 'flex' }} w-full md:w-[340px] shrink-0 bg-white border-r border-gray-200 flex-col">
        <div class="p-5 border-b border-gray-200">
            <h2 class="text-2xl font-bold text-gray-900">
                Conversaciones
            </h2>
        </div>

        <div class="flex-1 overflow-y-auto">
            @foreach($usuarios as $u)
                <a href="{{ route(auth()->user()->role . '.chat.conversacion', $u->id) }}" class="flex items-center gap-4 px-5 py-4 transition border-b border-gray-100 hover:bg-blue-50 {{ request()->route('id') == $u->id ? 'bg-blue-50 border-r-4 border-blue-600' : '' }}">
                    <img src="{{ $u->profile_photo ? asset('storage/' . $u->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode($u->name) . '&background=0B3C63&color=ffffff&size=128' }}" class="w-14 h-14 rounded-full object-cover border border-gray-200" >

                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-gray-900 truncate">
                            {{ $u->name }}
                        </h3>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <div class="{{ isset($destinatario) ? 'flex' : 'hidden md:flex' }} flex-1 min-w-0 min-h-0 bg-[#f5f7fb] flex-col">
        <div class="bg-white/90 backdrop-blur-sm border-b border-gray-200 px-4 md:px-6 py-4 flex items-center gap-4 sticky top-0 z-20">
            <a href="{{ route(auth()->user()->role . '.chat.index') }}" class="w-11 h-11 rounded-xl border border-gray-200 hover:bg-gray-100 transition flex items-center justify-center text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>

            <img src="{{ isset($destinatario) && $destinatario->profile_photo ? asset('storage/' . $destinatario->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode($destinatario->name ?? 'Chat') . '&background=0B3C63&color=ffffff&size=128' }}" class="w-12 h-12 rounded-full object-cover border border-gray-200">

            <div>
                <h1 class="text-2xl font-bold text-gray-900 leading-tight">
                    {{ $destinatario->name ?? 'Selecciona una conversación' }}
                </h1>

                <div class="flex items-center gap-2 mt-1">
                    <span id="onlineDot" class="w-2.5 h-2.5 bg-gray-400 rounded-full transition"></span>
                    <p id="estadoUsuario" class="text-sm text-gray-500">
                        Desconectado
                    </p>
                </div>
            </div>
        </div>

        <div id="chatBox" class="flex-1 overflow-y-auto bg-slate-100 p-4 flex flex-col gap-3 min-h-0">
            @forelse ($mensajes as $m)
                @php
                    $esMio = $m->emisor_id == auth()->id();
                    $extension = $m->archivo ? strtolower(pathinfo($m->archivo, PATHINFO_EXTENSION)) : null;
                    $esImagen = in_array($extension, ['jpg', 'jpeg', 'png', 'webp']);
                @endphp

                <div class="flex {{ $esMio ? 'justify-end' : 'justify-start' }}">
                    <div class="relative group max-w-[180px] px-3 py-2 shadow-sm text-sm {{ $esMio ? 'bg-blue-600 text-white rounded-2xl rounded-br-md' : 'bg-white border border-gray-200 text-gray-900 rounded-2xl rounded-bl-md' }}">
                        @if($esMio)
                            <form id="formEliminar{{ $m->id }}" method="POST" action="{{ route(auth()->user()->role . '.chat.eliminar', $m->id) }}" class="absolute -top-3 -right-3 opacity-0 group-hover:opacity-100 transition">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmarEliminar({{ $m->id }})" class="bg-red-600 hover:bg-red-700 text-white w-8 h-8 rounded-full shadow flex items-center justify-center text-sm">
                                    ×
                                </button>
                            </form>
                        @endif

                        @if($m->mensaje)
                            <p class="whitespace-pre-line break-words">
                                {{ $m->mensaje }}
                            </p>
                        @endif

                        @if($m->archivo)
                            @if($esImagen)
                                <a href="{{ asset('storage/' . $m->archivo) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $m->archivo) }}" class="mt-3 rounded-xl max-w-full border border-gray-200">
                                </a>
                            @else
                                <a href="{{ asset('storage/' . $m->archivo) }}" target="_blank" class="mt-3 flex items-center justify-between gap-3 bg-black/10 rounded-xl px-4 py-3">
                                    <div>
                                        <p class="font-semibold">
                                            Archivo adjunto
                                        </p>

                                        <p class="text-sm opacity-80">
                                            Descargar archivo
                                        </p>
                                    </div>

                                    <span class="font-bold">
                                        ↓
                                    </span>
                                </a>
                            @endif
                        @endif

                        <div class="flex items-center justify-end gap-1 mt-2">
                            <span class="text-xs {{ $esMio ? 'text-blue-100' : 'text-gray-500' }}">
                                {{ $m->created_at->format('H:i') }}
                            </span>

                            @if($esMio)
                                <span class="text-xs text-blue-100">
                                    ✓✓
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="h-full flex items-center justify-center text-gray-500">
                    Todavía no hay mensajes.
                </div>
            @endforelse
        </div>

        @if($destinatario)
            <form action="{{ route(auth()->user()->role . '.chat.enviar') }}" method="POST" enctype="multipart/form-data" class="mx-6 mb-6 mt-3 p-4 border border-gray-200 rounded-[28px] bg-white shadow-xl shrink-0">
                @csrf
                <input type="hidden" name="receptor_id" value="{{ $destinatario->id ?? '' }}">

                <div id="previewArchivo" class="hidden mb-3 bg-gray-100 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-700 relative">
                    <span id="nombreArchivo"></span>
                    <button type="button" id="eliminarArchivo" class="absolute top-2 right-3 text-red-500 hover:text-red-700 font-bold">
                        ×
                    </button>
                </div>

                <div class="flex items-center gap-4">
                    <div class="flex-1 relative min-w-0">
                        <textarea name="mensaje" rows="1" id="mensajeInput" class="w-full bg-[#f5f7fb] border border-gray-200 rounded-2xl px-5 py-4 pr-16 focus:ring-2 focus:ring-blue-500 focus:outline-none resize-none overflow-hidden min-h-[56px] max-h-[140px]" placeholder="Escribe un mensaje..."></textarea>

                        <label class="absolute right-4 bottom-4 cursor-pointer text-gray-500 hover:text-blue-600 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.586-6.586a4 4 0 00-5.656-5.656L5.757 10.757a6 6 0 108.486 8.486L20 13.485" />
                            </svg>

                            <input type="file" name="archivo" id="archivoInput" class="hidden" accept="image/*,.pdf,.doc,.docx,.xls,.xlsx">
                        </label>
                    </div>

                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 active:scale-95 text-white px-8 h-[56px] rounded-2xl shadow-lg transition font-semibold shrink-0">
                        Enviar
                    </button>
                </div>
            </form>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    window.userId = {{ auth()->id() }};
    window.destinatarioId = {{ $destinatario->id ?? 'null' }};

    const textarea = document.getElementById('mensajeInput');

    if(textarea){
        textarea.addEventListener('input', function(){
            this.style.height = '56px';
            this.style.height = this.scrollHeight + 'px';
        });
    }

    const chatBox = document.getElementById('chatBox');

    if(chatBox){
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    const archivoInput = document.getElementById('archivoInput');
    const previewArchivo = document.getElementById('previewArchivo');
    const nombreArchivo = document.getElementById('nombreArchivo');
    const eliminarArchivo = document.getElementById('eliminarArchivo');

    if(archivoInput){
        archivoInput.addEventListener('change', function(){
            if (this.files.length > 0){
                nombreArchivo.textContent = this.files[0].name;
                previewArchivo.classList.remove('hidden');
            }
        });
    }

    if(eliminarArchivo){
        eliminarArchivo.addEventListener('click', function (){
            archivoInput.value = '';
            previewArchivo.classList.add('hidden');
            nombreArchivo.textContent = '';
        });
    }

    function confirmarEliminar(id){
        Swal.fire({
            title: '¿Eliminar mensaje?',
            text: 'Esta acción no se puede deshacer.',
            icon: 'warning',

            background: '#ffffff',
            color: '#111827',

            showCancelButton: true,

            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',

            confirmButtonColor: '#0f766e',
            cancelButtonColor: '#6b7280',

            reverseButtons: true,

            customClass: {
                popup: 'rounded-3xl shadow-2xl',
                confirmButton: 'rounded-xl px-5 py-2',
                cancelButton: 'rounded-xl px-5 py-2'
            }
        }).then((result) => {
            if(result.isConfirmed){
                Swal.fire({
                    title: 'Eliminando...',
                    text: 'Por favor espera',
                    allowOutsideClick: false,
                    showConfirmButton: false,

                    didOpen:()=>{
                        Swal.showLoading();
                    }
                });

                document.getElementById('formEliminar' + id).submit();
            }
        });
    }
</script>

<style>
    @keyframes aparecerMensaje{
        from{
            opacity: 0;
            transform: translateY(12px) scale(.98);
        }

        to{
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .animateMensaje{
        animation: aparecerMensaje .22s ease;
    }

    #chatBox::-webkit-scrollbar{
        width: 6px;
    }

    #chatBox::-webkit-scrollbar-track{
        background: transparent;
    }

    #chatBox::-webkit-scrollbar-thumb{
        background: #cbd5e1;
        border-radius: 999px;
    }
</style>
@endsection