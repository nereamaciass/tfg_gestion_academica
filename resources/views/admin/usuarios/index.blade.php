@extends('layouts.admin')
@section('title', 'Gestión de Usuarios')
@section('content')

<h1 class="text-3xl font-bold text-gray-800 mb-6">Gestión de Usuarios</h1>

<div class="flex justify-between mb-4">
    <form method="GET" class="flex gap-3">
        <input type="text" name="buscar" placeholder="Buscar usuario..." value="{{ $buscar }}" class="border px-3 py-2 rounded-lg">

        <select name="rol" class="border px-3 py-2 rounded-lg">
            <option value="">Todos los roles</option>
            <option value="admin" {{ $rol=='admin'?'selected':'' }}>Admin</option>
            <option value="profesor" {{ $rol=='profesor'?'selected':'' }}>Profesor</option>
        </select>

        <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
            Filtrar
        </button>
    </form>

    <a href="{{ route('admin.usuarios.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow">
        + Crear Usuario
    </a>
</div>

<div class="bg-white shadow rounded-lg px-2 py-4 overflow-x-auto">
    <table class="w-full text-center border-collapse">
        <thead>
            <tr class="border-b text-gray-600">
                <th class="py-3 px-1 text-center">Foto</th>

                <th class="py-3 px-2 text-center">
                    <a href="{{ route('admin.usuarios.index', array_merge(request()->query(), ['sort' => 'name', 'direction' => ($sort !== 'name' ? 'asc' : ($direction === 'asc' ? 'desc' : ($direction === 'desc' ? 'default' : 'asc')))])) }}" class="flex justify-center items-center gap-1 hover:text-blue-600">
                        Nombre
                        @if($sort === 'name')
                            {{ $direction === 'asc' ? '↑' : ($direction === 'desc' ? '↓' : '') }}
                        @endif
                    </a>
                </th>

                <th class="py-3 px-2 text-center">
                    <a href="{{ route('admin.usuarios.index', array_merge(request()->query(), ['sort' => 'email', 'direction' => ($sort !== 'email' ? 'asc' : ($direction === 'asc' ? 'desc' : ($direction === 'desc' ? 'default' : 'asc')))])) }}" class="flex justify-center items-center gap-1 hover:text-blue-600">
                        Email
                        @if($sort === 'email')
                            {{ $direction === 'asc' ? '↑' : ($direction === 'desc' ? '↓' : '') }}
                        @endif
                    </a>
                </th>

                <th class="py-3 px-2 text-center">
                    <a href="{{ route('admin.usuarios.index', array_merge(request()->query(), ['sort' => 'role', 'direction' => ($sort !== 'role' ? 'asc' : ($direction === 'asc' ? 'desc' : ($direction === 'desc' ? 'default' : 'asc')))])) }}" class="flex justify-center items-center gap-1 hover:text-blue-600">
                        Rol
                        @if($sort === 'role')
                            {{ $direction === 'asc' ? '↑' : ($direction === 'desc' ? '↓' : '') }}
                        @endif
                    </a>
                </th>

                <th class="py-3 px-2 text-center">Acciones</th>
            </tr>
        </thead>

        <tbody class="text-gray-800">
        @foreach($usuarios as $usuario)
            <tr class="border-b hover:bg-gray-50">
                <td class="py-3 px-1 text-center align-middle">
                    <div class="flex justify-center items-center w-full">
                        <img src="{{ $usuario->profile_photo ? asset('storage/' . $usuario->profile_photo)  : 'https://ui-avatars.com/api/?name=' . urlencode($usuario->name) . '&background=e5e7eb&color=111827&size=128' }}"
                             class="w-9 h-9 rounded-full object-cover border">
                    </div>
                </td>

                <td class="py-3 px-2 text-center align-middle">
                    {{ $usuario->name }}
                </td>

                <td class="py-3 px-2 text-center align-middle">
                    {{ $usuario->email }}
                </td>

                <td class="py-3 px-2 text-center align-middle">
                    {{ ucfirst($usuario->role ?? 'sin rol') }}
                </td>

                <td class="py-3 px-2 text-center align-middle">
                    <div class="flex justify-center items-center gap-3">
                        <a href="{{ route('admin.usuarios.show', $usuario) }}" class="w-9 h-9 flex items-center justify-center text-gray-600 hover:text-blue-600" title="Ver">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5 c4.477 0 8.268 2.943 9.542 7 -1.274 4.057-5.065 7-9.542 7 -4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </a>

                        <a href="{{ route('admin.usuarios.edit', $usuario) }}" class="w-9 h-9 flex items-center justify-center text-gray-600 hover:text-yellow-500" title="Editar">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536 M9 11l6-6 3 3-6 6H9v-3z"/>
                            </svg>
                        </a>

                        <form id="form-eliminar-usuario-{{ $usuario->id }}" action="{{ route('admin.usuarios.destroy', $usuario) }}" method="POST" class="m-0 p-0 flex items-center">
                            @csrf
                            @method('DELETE')

                            <button type="button" onclick="confirmarEliminacionUsuario({{ $usuario->id }})" class="w-9 h-9 flex items-center justify-center text-gray-600 hover:text-red-600" title="Eliminar">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142 A2 2 0 0116.138 21H7.862 a2 2 0 01-1.995-1.858L5 7 m5-4h4m-6 4h8"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $usuarios->links() }}
</div>
@endsection

@push('scripts')
<script>
function confirmarEliminacionUsuario(id){
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción no se puede deshacer',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e3342f',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
    }).then((result)=>{
        if(result.isConfirmed){
            document.getElementById('form-eliminar-usuario-' + id).submit();
        }
    });
}
</script>
@endpush