@php
    $rutaActual = request()->path();
@endphp

<div class="w-64 h-screen bg-[#0B3C63] text-white flex flex-col py-6 shadow-lg">
    <h2 class="text-2xl font-bold text-center mb-10">
        Profesor
    </h2>

    <nav class="flex flex-col text-sm px-4 space-y-1">
        @if($rutaActual != 'profesor/dashboard')
            <a href="{{ route('profesor.dashboard') }}" class="py-3 px-4 rounded hover:bg-[#092F4A] transition">
                Panel de Control
            </a>
        @endif

        @if(!request()->is('profesor/asignaturas*'))
            <a href="{{ route('profesor.asignaturas.index') }}" class="py-3 px-4 rounded hover:bg-[#092F4A] transition">
                Mis Asignaturas
            </a>
        @endif

        @if(!request()->is('profesor/horario*'))
            <a href="{{ route('profesor.horario.index') }}" class="py-3 px-4 rounded hover:bg-[#092F4A] transition">
                Mi Horario
            </a>
        @endif

        @if(!request()->is('profesor/calendario*'))
            <a href="{{ route('profesor.calendario.index') }}" class="py-3 px-4 rounded hover:bg-[#092F4A] transition">
                Calendario
            </a>
        @endif

        @if(!request()->is('profesor/notificaciones*'))
            <a href="{{ route('profesor.notificaciones.index') }}" class="py-3 px-4 rounded hover:bg-[#092F4A] transition">
                Notificaciones
            </a>
        @endif

        @if(!request()->is('profesor/chat*'))
            <a href="{{ route('profesor.chat.index') }}" class="py-3 px-4 rounded hover:bg-[#092F4A] transition">
                Chat
            </a>
        @endif
    </nav>

    <div class="mt-auto px-4 pb-4" x-data="{ open:false }">
        <button @click="open = !open" class="w-full bg-[#0F4C81] hover:bg-[#0c3a63] transition text-white px-4 py-3 rounded flex items-center justify-between shadow">
            <div class="flex items-center gap-3 min-w-0">
                <img src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=e5e7eb&color=111827&size=128' }}" class="w-8 h-8 rounded-full object-cover border border-white flex-shrink-0">

                <span class="truncate">
                    {{ Auth::user()->name }}
                </span>
            </div>

            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        <div x-show="open" @click.outside="open = false" x-transition class="mt-2 bg-white text-gray-800 rounded shadow-lg overflow-hidden">
            @if(!request()->is('profesor/perfil*'))
                <a href="{{ route('profesor.perfil.index') }}" class="block px-4 py-2 hover:bg-gray-100">
                    Mi Perfil
                </a>

                <div class="border-t"></div>
            @endif

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full text-left px-4 py-2 hover:bg-gray-100 font-semibold text-[#0F4C81]">
                    Cerrar Sesión
                </button>
            </form>
        </div>
    </div>
</div>