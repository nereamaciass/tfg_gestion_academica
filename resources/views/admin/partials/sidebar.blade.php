@php
    $rutaActual = request()->route()->getName(); 
@endphp

<aside class="w-64 bg-[#0B3C63] text-white flex flex-col py-6 shadow-lg">
    <h2 class="text-xl font-bold text-center mb-8">Administración</h2>

    <nav class="flex flex-col text-sm px-4">
        @if(!request()->routeIs('admin.dashboard'))
            <a href="{{ route('admin.dashboard') }}" class="py-3 px-4 rounded hover:bg-[#092F4A] transition">
                Panel de Control
            </a>
        @endif

        @if(!request()->routeIs('admin.profesores.*'))
            <a href="{{ route('admin.profesores.index') }}" class="py-3 px-4 rounded hover:bg-[#092F4A] transition">
                Gestionar Profesores
            </a>
        @endif

        @if(!request()->routeIs('admin.asignaturas.*'))
            <a href="{{ route('admin.asignaturas.index') }}" class="py-3 px-4 rounded hover:bg-[#092F4A] transition">
                Gestionar Asignaturas
            </a>
        @endif

        @if(!request()->routeIs('admin.usuarios.*'))
            <a href="{{ route('admin.usuarios.index') }}" class="py-3 px-4 rounded hover:bg-[#092F4A] transition">
                Gestionar Usuarios
            </a>
        @endif

        @if(!request()->routeIs('admin.horarios.*'))
            <a href="{{ route('admin.horarios.index') }}" class="py-3 px-4 rounded hover:bg-[#092F4A] transition">
                Gestionar Horarios
            </a>
        @endif

        @if(!request()->routeIs('admin.notificaciones.*'))
            <a href="{{ route('admin.notificaciones.index') }}" class="py-3 px-4 rounded hover:bg-[#092F4A] transition">
                Notificaciones
            </a>
        @endif

        @if(!request()->routeIs('admin.chat.*'))
            <a href="{{ route('admin.chat.index') }}" class="py-3 px-4 rounded hover:bg-[#092F4A] transition">
                Chat
            </a>
        @endif
    </nav>

    <div class="mt-auto px-4 pb-4" x-data="{ open:false }">
        <button @click="open = !open" class="w-full bg-[#0F4C81] hover:bg-[#0c3a63] transition text-white px-4 py-3 rounded flex items-center justify-between shadow">  
            <span>{{ Auth::user()->name }}</span>

            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        <div x-show="open" @click.outside="open = false" x-transition class="mt-2 bg-white text-gray-800 rounded shadow-lg overflow-hidden">
            <a href="{{ route('admin.perfil.index') }}" class="block px-4 py-2 hover:bg-gray-100">
                Mi Perfil
            </a>

            <div class="border-t"></div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full text-left px-4 py-2 hover:bg-gray-100 font-semibold text-[#0F4C81]">
                    Cerrar Sesión
                </button>
            </form>
        </div>
    </div>
</aside>