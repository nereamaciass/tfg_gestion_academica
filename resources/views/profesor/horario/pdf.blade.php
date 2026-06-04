<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body{
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        h1{
            text-align: center;
            color: #003366;
            margin-bottom: 5px;
        }

        .sub{
            text-align: center;
            margin-bottom: 20px;
            font-size: 13px;
        }

        table{
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th{
            background: #003366;
            color: white;
            padding: 8px;
            border: 1px solid #333;
            text-align: center;
        }

        td{
            padding: 10px;
            border: 1px solid #333;
            text-align: center;
        }

        .footer{
            text-align: center;
            margin-top: 25px;
            font-size: 11px;
            color: #555;
        }
    </style>
</head>

<body>
<h1>Horario Semanal</h1>

<div class="sub">
    <strong>Profesor/a:</strong> {{ $profesor->nombre }} <br>
    <strong>Email:</strong> {{ $profesor->email }}
</div>

<table>
    <thead>
        <tr>
            <th>Hora</th>
            @foreach ($dias as $dia)
                <th>{{ $dia }}</th>
            @endforeach
        </tr>
    </thead>

    <tbody>
        @foreach ($horas as $i => $hora)
            @php
                $inicio = $hora;
                $fin = $horas[$i+1] ?? null;
                if (!$fin) continue;
                $rango = $inicio . '-' . $fin;
            @endphp

            <tr>
                <td>{{ $rango }}</td>
                @foreach ($dias as $dia)
                    @php
                        $celda = $horarios->first(function($h) use ($dia, $inicio) {
                            return $h->dia === $dia && substr($h->hora_inicio, 0, 5) === $inicio;
                        });
                    @endphp

                    @if ($celda && $celda->asignatura)
                        <td style="background-color: {{ $celda->asignatura->color }};">
                            <strong>{{ $celda->asignatura->nombre }}</strong><br>
                            <small>{{ $celda->asignatura->curso }}</small>
                        </td>
                    @else
                        <td>—</td>
                    @endif
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>

<div class="footer">
    Documento generado automáticamente — {{ date('d/m/Y') }}
</div>
</body>
</html>