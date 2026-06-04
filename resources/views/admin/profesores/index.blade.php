@extends('layouts.admin')
@section('title', 'Gestión de Profesores')
@section('content')

<h1 class="text-3xl font-bold text-gray-800 mb-6">Gestión de Profesores</h1>

<div class="flex justify-between mb-4">
    <form method="GET" class="flex gap-3">
        <input type="text" name="buscar" placeholder="Buscar profesor..." value="{{ $buscar }}" class="border px-3 py-2 rounded-lg">

        <select name="departamento" class="border px-3 py-2 rounded-lg">
            <option value="">Todos los departamentos</option>
            @foreach($profesores->pluck('departamento')->filter()->unique() as $dep)
                <option value="{{ $dep }}" {{ ($departamento ?? '') == $dep ? 'selected' : '' }}>
                    {{ $dep }}
                </option>
            @endforeach
        </select>

        <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
            Filtrar
        </button>
    </form>

    <a href="{{ route('admin.profesores.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow">
        + Crear Profesor
    </a>
</div>

<div class="bg-white shadow rounded-lg p-6">
    @if($profesores->isEmpty())
        <p class="text-gray-600 text-center py-6">No hay profesores registrados.</p>
    @else

    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="border-b text-gray-600">
                <th class="py-3 px-4">Foto</th>
                <th class="py-3 px-4">
                    <a href="{{ request()->fullUrlWithQuery(['sort' => $direction === 'desc' && $sort === 'nombre' ? null : 'nombre', 'direction' => $sort !== 'nombre' ? 'asc' : ($direction === 'asc' ? 'desc' : ($direction === 'desc' ? 'default' : 'asc'))]) }}" class="flex items-center gap-1 hover:text-blue-600">
                        Nombre
                        @if($sort === 'nombre' && $direction === 'asc') ↑ @endif
                        @if($sort === 'nombre' && $direction === 'desc') ↓ @endif
                    </a>
                </th>
                <th class="py-3 px-4">
                    <a href="{{ request()->fullUrlWithQuery(['sort' => $direction === 'desc' && $sort === 'email' ? null : 'email', 'direction' => $sort !== 'email' ? 'asc' : ($direction === 'asc' ? 'desc' : ($direction === 'desc' ? 'default' : 'asc'))]) }}" class="flex items-center gap-1 hover:text-blue-600">
                        Email
                        @if($sort === 'email' && $direction === 'asc') ↑ @endif
                        @if($sort === 'email' && $direction === 'desc') ↓ @endif
                    </a>
                </th>
                <th class="py-3 px-4">Teléfono</th>
                <th class="py-3 px-4">
                    <a href="{{ request()->fullUrlWithQuery(['sort' => $direction === 'desc' && $sort === 'departamento' ? null : 'departamento', 'direction' => $sort !== 'departamento' ? 'asc' : ($direction === 'asc' ? 'desc' : ($direction === 'desc' ? 'default' : 'asc'))]) }}" class="flex items-center gap-1 hover:text-blue-600">
                        Departamento
                        @if($sort === 'departamento' && $direction === 'asc') ↑ @endif
                        @if($sort === 'departamento' && $direction === 'desc') ↓ @endif
                    </a>
                </th>
                <th class="py-3 px-4">Cuenta usuario</th>
                <th class="py-3 px-4">Acciones</th>
            </tr>
        </thead>

        <tbody class="text-gray-800">
            @foreach($profesores as $prof)
                @php
                    $user = $prof->user;
                    $nombreFoto = $user?->name ?? $prof->nombre;
                    $iniciales = collect(explode(' ', trim($nombreFoto)))
                        ->filter()
                        ->map(fn($p) => mb_substr($p, 0, 1))
                        ->take(2)
                        ->implode('');
                @endphp

                <tr class="border-b hover:bg-gray-50">
                    <td class="py-3 px-4">
                        @if($user && $user->profile_photo)
                            <img src="{{ asset('storage/' . $user->profile_photo) }}"
                                 class="w-10 h-10 rounded-full object-cover border shadow-sm">
                        @else
                            <div class="w-10 h-10 rounded-full bg-gray-200 text-gray-700 flex items-center justify-center text-sm font-semibold border">
                                {{ strtoupper($iniciales ?: 'P') }}
                            </div>
                        @endif
                    </td>

                    <td class="py-3 px-4">{{ $prof->nombre }}</td>
                    <td class="py-3 px-4">{{ $prof->email }}</td>
                    <td class="py-3 px-4">{{ $prof->telefono ?? '—' }}</td>
                    <td class="py-3 px-4">{{ $prof->departamento ?? '—' }}</td>

                    <td class="py-3 px-4">
                        @if($user)
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">
                                Sí
                            </span>
                        @else
                            <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-sm font-semibold">
                                No
                            </span>
                        @endif
                    </td>

                    <td class="py-3 px-4 flex gap-4 items-center">
                        <a href="{{ route('admin.profesores.show', $prof) }}" class="text-gray-600 hover:text-blue-600" title="Ver">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </a>

                        <a href="{{ route('admin.profesores.edit', $prof) }}" class="text-gray-600 hover:text-yellow-500" title="Editar">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 11l6-6 3 3-6 6H9v-3z"/>
                            </svg>
                        </a>

                        <form id="form-eliminar-{{ $prof->id }}" action="{{ route('admin.profesores.destroy', $prof->id) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <button type="button" onclick="confirmarEliminacion({{ $prof->id }})" class="text-gray-600 hover:text-red-600" title="Eliminar">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-6 4h8"/>
                                </svg>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-6">
        {{ $profesores->links() }}
    </div>

    @endif
</div>

@endsection

@push('scripts')
    <script>
        function confirmarEliminacion(id){
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Esta acción no se puede deshacer",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e3342f',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true,
                scrollbarPadding: false,
            }).then((result)=>{
                if (result.isConfirmed){
                    document.getElementById('form-eliminar-' + id).submit();
                }
            });
        }
    </script>
@endpush