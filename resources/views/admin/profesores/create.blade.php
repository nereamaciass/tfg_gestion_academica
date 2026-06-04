@extends('layouts.admin')
@section('title', 'Crear Profesor')
@section('content')
<h1 class="text-2xl font-bold mb-4">Añadir Profesor</h1>

<div class="bg-white shadow rounded-lg p-6 w-full max-w-2xl">
    <form action="{{ route('admin.profesores.store') }}" method="POST" class="space-y-4" novalidate>
        @csrf
        <label class="block">
            <span>Nombre</span>

            <input type="text" name="nombre" value="{{ old('nombre') }}" class="w-full rounded border p-2 @error('nombre') border-red-500 @enderror">
          
            @error('nombre')
                <p class="text-red-500 text-sm mt-1">
                    {{ $message }}
                </p>
            @enderror
        </label>

        <label class="block">
            <span>Email</span>

            <input type="email" name="email" value="{{ old('email') }}" class="w-full rounded border p-2 @error('email') border-red-500 @enderror">

            @error('email')
                <p class="text-red-500 text-sm mt-1">
                    {{ $message }}
                </p>
            @enderror
        </label>

        <label class="block">
            <span>Teléfono</span>

            <input type="text" name="telefono" value="{{ old('telefono') }}" class="w-full rounded border p-2 @error('telefono') border-red-500 @enderror">

            @error('telefono')
                <p class="text-red-500 text-sm mt-1">
                    {{ $message }}
                </p>
            @enderror
        </label>

        <label class="block">
            <span>Departamento</span>

            <select name="departamento" id="departamento" class="w-full rounded border p-2">
                <option value="">Selecciona o escribe...</option>

                @foreach($departamentos as $dep)
                    <option value="{{ $dep }}"
                        {{ old('departamento') == $dep ? 'selected' : '' }}>
                        {{ $dep }}
                    </option>
                @endforeach
            </select>
        </label>

        <label class="block">
            <span>Asignaturas que imparte</span>

            <select name="asignaturas[]" id="asignaturas" class="w-full rounded border p-2" multiple>
                @foreach($asignaturas->groupBy('curso') as $curso => $grupo)
                    <optgroup label="Curso {{ $curso }}">
                        @foreach ($grupo as $asignatura)
                            <option value="{{ $asignatura->id }}">
                                {{ $asignatura->nombre }} – Curso {{ $asignatura->curso }}
                            </option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>
        </label>

        <div class="border rounded-lg p-4 bg-gray-50">
            <label class="flex items-center gap-2 mb-3">
                <input type="checkbox" name="crear_usuario" id="crear_usuario">

                <span class="font-semibold">
                    Crear también cuenta de usuario
                </span>
            </label>

            <div id="bloquePassword" class="hidden">
                <label class="block">
                    <span>Contraseña</span>

                    <input type="password" name="password" class="w-full rounded border p-2 mt-1">
                </label>
            </div>
        </div>

        <div class="flex justify-between mt-6">
            <a href="{{ route('admin.profesores.index') }}" class="text-gray-600">
                Volver
            </a>

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded">
                Guardar
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            $('#departamento').select2({
                tags: true,
                placeholder: "Selecciona o escribe un departamento",
                allowClear: true,
                width: '100%'
            });

            $('#asignaturas').select2({
                placeholder: "Selecciona asignaturas",
                allowClear: true,
                width: '100%'
            });
        });

        document.addEventListener('DOMContentLoaded', function(){
            const checkbox = document.getElementById('crear_usuario');
            const bloque = document.getElementById('bloquePassword');

            checkbox.addEventListener('change', function(){
                if(checkbox.checked){
                    bloque.classList.remove('hidden');
                }else{
                    bloque.classList.add('hidden');
                }
            });
        });
    </script>
@endpush