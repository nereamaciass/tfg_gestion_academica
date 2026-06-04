@extends('layouts.admin')
@section('title', 'Chat')
@section('content')

<div class="h-[85vh] flex flex-col">
    <div class="mb-6">
        <h1 class="text-4xl font-bold text-gray-900">
            Chat
        </h1>

        <p class="text-gray-500 mt-1">
            Conversaciones disponibles
        </p>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-200 overflow-hidden flex flex-col mb-10">
        <div class="p-6 border-b border-gray-100">
            <div class="relative">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 absolute left-5 top-1/2 -translate-y-1/2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>

                <input type="text" id="buscadorConversaciones" placeholder="Buscar conversación..." class="w-full pl-14 pr-5 py-4 rounded-2xl border border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 outline-none text-gray-700 transition">
            </div>
        </div>

        <div class="overflow-y-auto flex-1">
            @foreach ($usuarios as $u)
                <a href="{{ route('admin.chat.conversacion', $u->id) }}" class="usuario-chat flex items-center justify-between px-7 py-6 hover:bg-gray-50 transition border-b border-gray-100">
                    <div class="flex items-center gap-5">
                        <div class="relative">
                            @if($u->profile_photo)
                                <img src="{{ asset('storage/' . $u->profile_photo) }}" class="w-16 h-16 rounded-full object-cover border border-gray-200" >
                            @else
                                <div class="w-16 h-16 rounded-full bg-[#0B3C63] text-white flex items-center justify-center text-3xl font-semibold">
                                    {{ strtoupper(substr($u->name, 0, 2)) }}
                                </div>
                            @endif

                            <div class="absolute bottom-0 right-0 w-5 h-5 bg-green-500 border-4 border-white rounded-full"></div>
                        </div>

                        <div>
                            <h2 class="text-2xl font-semibold text-gray-900">
                                {{ $u->name }}
                            </h2>

                            <p class="text-gray-500 text-lg mt-1">
                                @if($u->ultimo_mensaje)
                                    {{ Str::limit($u->ultimo_mensaje->mensaje, 40) }}
                                @else
                                    No hay mensajes todavía
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-col items-end gap-2">
                        @if($u->ultimo_mensaje)
                            <span class="text-sm text-gray-400">
                                {{ $u->ultimo_mensaje->created_at->format('H:i') }}
                            </span>
                        @endif

                        @if($u->no_leidos > 0)
                            <div class="bg-blue-600 text-white text-xs font-bold rounded-full px-3 py-1">
                                {{ $u->no_leidos }}
                            </div>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>

<script>
    document.getElementById('buscadorConversaciones')
    .addEventListener('input', function(){
        let valor = this.value.toLowerCase();

        document.querySelectorAll('.usuario-chat').forEach(chat=>{
            let texto = chat.innerText.toLowerCase();

            chat.style.display = texto.includes(valor)
                ? 'flex'
                : 'none';
        });
    });
</script>
@endsection