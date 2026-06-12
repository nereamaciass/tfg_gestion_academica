@extends('layouts.admin')
@section('title', 'Editar Profesor')
@section('content')

<h1 class="text-3xl font-bold mb-6">Editar Profesor</h1>

<div class="bg-white p-6 rounded-lg shadow-lg max-w-xl">
    <form method="POST" action="{{ route('admin.profesores.update', $profesor->id) }}" novalidate>
        @csrf
        @method('PUT')

        <label class="block mb-4">
            <span>Nombre</span>
            <input type="text" name="nombre" value="{{ old('nombre', $profesor->nombre) }}" class="w-full border px-3 py-2 rounded @error('nombre') border-red-500 @enderror">

            @error('nombre')
                <p class="text-red-500 text-sm mt-1">
                    {{ $message }}
                </p>
            @enderror
        </label>

        <label class="block mb-4">
            <span>Email</span>

            <input type="email" name="email" value="{{ old('email', $profesor->email) }}" class="w-full border px-3 py-2 rounded @error('email') border-red-500 @enderror">

            @error('email')
                <p class="text-red-500 text-sm mt-1">
                    {{ $message }}
                </p>
            @enderror
        </label>

        <label class="block mb-4">
            <span>Teléfono</span>

            <input type="text" name="telefono" value="{{ old('telefono', $profesor->telefono) }}" class="w-full border px-3 py-2 rounded">
        </label>

        <label class="block mb-4">
            <span>Departamento</span>

            <select name="departamento" id="departamento" class="w-full border px-3 py-2 rounded">
                <option value="">Selecciona o escribe un departamento</option>

                @foreach($departamentos as $dep)
                    <option value="{{ $dep }}"
                        {{ old('departamento', $profesor->departamento) == $dep ? 'selected' : '' }}>
                        {{ $dep }}
                    </option>
                @endforeach
            </select>
        </label>

        <label class="block mb-4">
            <span>Asignaturas que imparte</span>

            <select name="asignaturas[]" id="asignaturas" class="w-full border px-3 py-2 rounded" multiple>
                @foreach($asignaturas->groupBy('curso') as $curso => $grupo)
                    <optgroup label="Curso {{ $curso }}">
                        @foreach($grupo as $asignatura)
                            <option value="{{ $asignatura->id }}"
                                {{ in_array($asignatura->id, $asignaturasAsignadas) ? 'selected' : '' }}>
                                {{ $asignatura->nombre }}
                            </option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>
        </label>

        @if($profesor->user)
            <div class="border border-green-200 bg-green-50 rounded-lg p-4 mb-4">
                <p class="font-semibold text-green-700">
                    Usuario conectado
                </p>

                <p class="text-gray-700 mt-2">
                    {{ $profesor->user->email }}
                </p>
            </div>
        @endif

        <label class="block mb-4">
            <span>Nueva contraseña (opcional)</span>

            <input type="password" name="password" class="w-full border px-3 py-2 rounded @error('password') border-red-500 @enderror">

            @error('password')
                <p class="text-red-500 text-sm mt-1">
                    {{ $message }}
                </p>
            @enderror
        </label>

        <div class="flex justify-between mt-6">
            <a href="{{ route('admin.profesores.index') }}" class="px-5 py-3 rounded-2xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold transition">
                Volver
            </a>

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded">
                Actualizar
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
                allowClear: true
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

            if(checkbox){

                checkbox.addEventListener('change', function(){

                    if(checkbox.checked){
                        bloque.classList.remove('hidden');
                    }else{
                        bloque.classList.add('hidden');
                    }
                });
            }
        });
    </script>
@endpush