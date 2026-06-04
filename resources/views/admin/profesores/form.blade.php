<div class="grid grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-semibold">Nombre</label>
        <input type="text" name="nombre" value="{{ old('nombre', $profesor->nombre ?? '') }}" class="w-full border px-3 py-2 rounded">
    </div>

    <div>
        <label class="block text-sm font-semibold">Email</label>
        <input type="email" name="email" value="{{ old('email', $profesor->email ?? '') }}" class="w-full border px-3 py-2 rounded">
    </div>

    <div>
        <label class="block text-sm font-semibold">Teléfono</label>
        <input type="text" name="telefono" value="{{ old('telefono', $profesor->telefono ?? '') }}" class="w-full border px-3 py-2 rounded">
    </div>

    <div>
        <label class="block text-sm font-semibold">Departamento</label>
        <input type="text" name="departamento" value="{{ old('departamento', $profesor->departamento ?? '') }}" class="w-full border px-3 py-2 rounded">
    </div>
</div>