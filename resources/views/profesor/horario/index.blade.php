@extends('layouts.profesor')
@section('title', 'Mi Horario')
@section('content')

<h1 class="text-4xl font-black text-[#0B1B3C] mb-6">
    Mi Horario
</h1>

<div class="mb-6">
    <a href="{{ route('profesor.horario.pdf') }}" class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-5 py-3 rounded-xl shadow transition">
        Descargar PDF
    </a>
</div>

<div id="tablaHorario" class="overflow-x-auto rounded-2xl shadow-sm">
    <table class="min-w-[1100px] w-full bg-white rounded-2xl overflow-hidden border border-gray-200">
        <thead class="bg-gray-100 sticky top-0 z-10">
            <tr>
                <th class="w-44 px-4 py-4 border text-center font-bold text-gray-700">
                    Hora
                </th>

                @foreach($dias as $dia)
                    <th class="px-4 py-4 border text-center font-bold text-gray-700">
                        {{ $dia }}
                    </th>
                @endforeach
            </tr>
        </thead>

        <tbody>
            @foreach($horas as $i => $hora)
                @php
                    $inicio = $hora;
                    $fin = $horas[$i + 1] ?? null;

                    if (!$fin) continue;

                    $rango = $inicio . '-' . $fin;
                @endphp

                <tr>
                    <td class="w-44 border px-4 py-3 font-semibold text-center bg-gray-50">
                        {{ $rango }}
                    </td>

                    @foreach($dias as $dia)
                        @php
                            $clase = $horarios->first(function($h) use ($dia, $inicio) {
                                return $h->dia === $dia &&
                                    substr($h->hora_inicio, 0, 5) === $inicio;
                            });

                            $asignatura = $clase?->asignatura;
                            $color = $asignatura?->color ?? '#f9fafb';
                        @endphp

                        @if($clase && $asignatura)
                            <td class="border px-4 py-3 text-center transition-all duration-200 hover:brightness-95" style="background-color: {{ $color }}">
                                <div class="font-bold text-base text-gray-900">
                                    {{ $asignatura->nombre }}
                                </div>

                                @if($asignatura->curso)
                                    <div class="text-xs text-gray-700 mt-0.5">
                                        {{ $asignatura->curso }}
                                    </div>
                                @endif
                            </td>
                        @else
                            <td class="border px-4 py-3 text-center bg-gray-50 text-gray-400">
                                —
                            </td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    let contenidoAnterior =
        document.getElementById('tablaHorario').innerHTML;

    setInterval(()=>{
        fetch(window.location.href)
            .then(response=>response.text())
            .then(html=>{
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');

                const nuevaTabla =
                    doc.getElementById('tablaHorario');

                if (!nuevaTabla) return;

                if (contenidoAnterior !== nuevaTabla.innerHTML){
                    document.getElementById('tablaHorario').innerHTML =
                        nuevaTabla.innerHTML;
                    contenidoAnterior =
                        nuevaTabla.innerHTML;
                }
            })
            .catch(error => console.error(error));
    }, 5000);
</script>
@endsection