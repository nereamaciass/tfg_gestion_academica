@extends('layouts.admin')
@section('title', 'Gestión de Asignaturas')
@section('content')

<h1 class="text-3xl font-bold text-gray-800 mb-6">Gestión de Asignaturas</h1>

<div class="flex justify-between mb-4">
    <form method="GET" class="flex gap-3">
        <input type="text" name="buscar" placeholder="Buscar asignatura..." value="{{ request('buscar') }}" class="border px-3 py-2 rounded-lg">

        <select name="curso" class="border px-3 py-2 rounded-lg">
            <option value="">Todos los cursos</option>
            @foreach($cursos as $curso)
                <option value="{{ $curso }}" {{ request('curso') == $curso ? 'selected' : '' }}>
                    Curso {{ $curso }}
                </option>
            @endforeach
        </select>

        <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
            Filtrar
        </button>
    </form>

    <a href="{{ route('admin.asignaturas.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow">
        + Añadir Asignatura
    </a>
</div>

<div class="bg-white shadow rounded-lg p-6">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="border-b text-gray-600">
                <th class="py-3 px-4">
                    <a href="{{ request()->fullUrlWithQuery(['sort' => $direction === 'desc' && $sort === 'nombre' ? null : 'nombre', 'direction' => $sort !== 'nombre' ? 'asc' : ($direction === 'asc' ? 'desc' : ($direction === 'desc' ? 'default' : 'asc'))]) }}" class="flex items-center gap-1 hover:text-blue-600">
                        Nombre
                        @if($sort === 'nombre' && $direction === 'asc') ↑ @endif
                        @if($sort === 'nombre' && $direction === 'desc') ↓ @endif
                    </a>
                </th>
                <th class="py-3 px-4">
                    <a href="{{ request()->fullUrlWithQuery(['sort' => $direction === 'desc' && $sort === 'codigo' ? null : 'codigo', 'direction' => $sort !== 'codigo' ? 'asc' : ($direction === 'asc' ? 'desc' : ($direction === 'desc' ? 'default' : 'asc'))]) }}" class="flex items-center gap-1 hover:text-blue-600">
                        Código
                        @if($sort === 'codigo' && $direction === 'asc') ↑ @endif
                        @if($sort === 'codigo' && $direction === 'desc') ↓ @endif
                    </a>
                </th>
                <th class="py-3 px-4">
                    <a href="{{ request()->fullUrlWithQuery(['sort' => $direction === 'desc' && $sort === 'curso' ? null : 'curso', 'direction' => $sort !== 'curso' ? 'asc' : ($direction === 'asc' ? 'desc' : ($direction === 'desc' ? 'default' : 'asc'))]) }}" class="flex items-center gap-1 hover:text-blue-600">
                    Curso
                    @if($sort === 'curso' && $direction === 'asc') ↑ @endif
                    @if($sort === 'curso' && $direction === 'desc') ↓ @endif
                </a>
            </th>
                <th class="py-3 px-4">Color</th>
                <th class="py-3 px-4">Profesores</th>
                <th class="py-3 px-4">Acciones</th>
            </tr>
        </thead>

        <tbody class="text-gray-800">
        @foreach($asignaturas as $asig)
            <tr class="border-b hover:bg-gray-50">
                <td class="py-3 px-4">{{ $asig->nombre }}</td>
                <td class="py-3 px-4">{{ $asig->codigo }}</td>
                <td class="py-3 px-4">Curso {{ $asig->curso }}</td>

                <td class="py-3 px-4">
                    <span class="inline-block w-6 h-6 rounded" style="background-color: {{ $asig->color ?? '#004d80' }}">
                    </span>
                </td>

                <td class="py-3 px-4">
                    @if($asig->profesores->count())
                        @foreach($asig->profesores as $prof)
                            <span class="text-sm text-gray-700">
                                {{ $prof->nombre }}
                            </span><br>
                        @endforeach
                    @else
                        <span class="text-gray-400 italic">Sin profesores</span>
                    @endif
                </td>

                <td class="py-3 px-4 flex gap-4 items-center">
                    <a href="{{ route('admin.asignaturas.show', $asig) }}" class="text-gray-600 hover:text-blue-600" title="Ver">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943  9.542 7-1.274 4.057-5.065 7-9.542  7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </a>

                    <a href="{{ route('admin.asignaturas.edit', $asig) }}" class="text-gray-600 hover:text-yellow-500" title="Editar">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 11l6-6 3 3-6 6H9v-3z"/>
                        </svg>
                    </a>

                    <form id="form-eliminar-asignatura-{{ $asig->id }}" action="{{ route('admin.asignaturas.destroy', $asig) }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <button type="button" onclick="confirmarEliminacionAsignatura({{ $asig->id }})" class="text-gray-600 hover:text-red-600" title="Eliminar">
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
</div>

<div class="mt-4">
    {{ $asignaturas->links() }}
</div>
@endsection

@push('scripts')
    <script>
        function confirmarEliminacionAsignatura(id){
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Esta acción no se puede deshacer',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e3342f',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true,
                scrollbarPadding: false,
            heightAuto: false
            }).then((result)=>{
                if (result.isConfirmed){
                    document.getElementById('form-eliminar-asignatura-' + id).submit();
                }
            });
        }
    </script>
@endpush