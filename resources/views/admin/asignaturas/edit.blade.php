@extends('layouts.admin')
@section('title', 'Editar Asignatura')
@section('content')

<h1 class="text-3xl font-bold mb-6">Editar Asignatura</h1>

<div class="bg-white p-6 rounded-lg shadow w-full max-w-xl">
    <form method="POST" action="{{ route('admin.asignaturas.update', $asignatura) }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="font-semibold">Nombre</label>
            <input type="text" name="nombre" value="{{ old('nombre', $asignatura->nombre) }}" class="w-full border px-3 py-2 rounded-lg @error('nombre') border-red-500 @enderror">
            @error('nombre')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="font-semibold">Código</label>
            <input type="text" name="codigo" value="{{ old('codigo', $asignatura->codigo) }}" class="w-full border px-3 py-2 rounded-lg @error('codigo') border-red-500 @enderror" required>
            @error('codigo')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="font-semibold">Curso</label>
            <input type="text" name="curso" value="{{ old('curso', $asignatura->curso) }}" class="w-full border px-3 py-2 rounded-lg @error('curso') border-red-500 @enderror" required>
            @error('curso')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="font-semibold">Asignar profesores</label>
            <select name="profesores[]" multiple class="w-full border px-3 py-2 rounded-lg" size="5">
                @foreach ($profesores as $prof)
                    <option value="{{ $prof->id }}" {{ in_array($prof->id, old('profesores', $profesoresAsignados)) ? 'selected' : '' }}>
                        {{ $prof->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="font-semibold">Color de la asignatura</label>

            @php
                $colorInicial = old('color', $asignatura->color ?: '#004d80');
            @endphp

            <div class="flex items-center gap-3">
                <input type="color" name="color" id="colorInput" class="w-16 h-10 border rounded" value="{{ $colorInicial }}">

                <span id="previewColor" class="px-3 py-1 rounded text-sm" style="background-color: {{ $colorInicial }};">
                    Vista previa
                </span>
            </div>
        </div>

        <div class="flex justify-between">
            <a href="{{ route('admin.asignaturas.index') }}" class="text-gray-600 hover:underline">
                Volver
            </a>

            <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                Actualizar
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function (){
            const input = document.getElementById('colorInput');
            const preview = document.getElementById('previewColor');

            function getContrastColor(hex){
                hex = hex.replace('#', '');

                const r = parseInt(hex.substr(0,2),16);
                const g = parseInt(hex.substr(2,2),16);
                const b = parseInt(hex.substr(4,2),16);
                const luminancia = (0.299*r + 0.587*g + 0.114*b);

                return luminancia > 186 ? '#000000' : '#ffffff';
            }

            function actualizarPreview(color){
                preview.style.backgroundColor = color;
                preview.style.color = getContrastColor(color);
            }

            actualizarPreview(input.value);

            input.addEventListener('input', function(){
                actualizarPreview(input.value);
            });
        });
    </script>
@endpush