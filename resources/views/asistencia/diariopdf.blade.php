<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie-edge">
    <title>Registro de Asistencia Escolar</title>
    <style>
        /* Estilos para el encabezado */
        h2 {
            text-align: center;
            color: black;
        }
        body {
            margin: -20;
            padding: -20;
        }
        /* Estilos para la tabla */
        .styled-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            /* Reducir el tamaño de fuente */
            overflow-x: auto;
            /* Agregar desbordamiento horizontal */
        }

        .styled-table thead tr {
            background-color: #077CE9;
            color: #ffffff;
            text-align: left;
        }

        .styled-table th,
        .styled-table td {
            padding: 10px;
            text-align: center;
            white-space: nowrap;
            /* Evitar que el texto se divida en varias líneas */
        }

        .styled-table tbody tr {
            border-bottom: 1px solid #33B5FF;
        }

        .styled-table tbody tr:nth-of-type(even) {
            background-color: #f3f3f3;
        }

        .styled-table tbody tr:last-of-type {
            border-bottom: 2px solid #33B5FF;
        }

        .styled-table tbody tr.active-row {
            font-weight: bold;
            color: black;
        }

        /* Estilos condicionales para la hora de entrada */
        .Puntual {
            background-color: #00FF00;
            /* Verde para puntual */
            color: black;
        }

        .Tardanza {
            background-color: #FF0000;
            /* Rojo para tardanza */
            color: white;
        }
    </style>
</head>

<body>
    <h2>Registro de Asistencia Escolar</h2>
    @php
        $contador = 1;
        $currentDate = clone $startDate;
    @endphp
    @php
        $mesesEnEspañol = [
            'January' => 'enero',
            'February' => 'febrero',
            'March' => 'marzo',
            'April' => 'abril',
            'May' => 'mayo',
            'June' => 'junio',
            'July' => 'julio',
            'August' => 'agosto',
            'September' => 'septiembre',
            'October' => 'octubre',
            'November' => 'noviembre',
            'December' => 'diciembre',
        ];
    @endphp
    <table class="styled-table">
        <thead class="thead">
            <tr>
                <th>N°</th>
                <th>Apellidos</th>
                <th>Nombre</th>
                
                <th>Grado / Sección</th>
                <th>Día</th>
                <th>Fecha</th>
                <th>Hora de Entrada</th>
            </tr>
        </thead>
        <tbody>
            @while ($currentDate->lte($endDate))
                @foreach ($alumnos as $alumno)
                    @php
                        $asistenciaEnFecha = $alumno->asistencias->first(function ($asistencia) use ($currentDate) {
                            return \Carbon\Carbon::parse($asistencia->fecha)->isSameDay($currentDate);
                        });

                        // Validar la hora de entrada
                        $horaEntrada = $asistenciaEnFecha ? \Carbon\Carbon::parse($asistenciaEnFecha->hora) : null;
                        $tiempo = '';
                        $estilo = '';
                        if ($horaEntrada) {
                            if ($horaEntrada->greaterThan(\Carbon\Carbon::parse('07:45:59'))) {
                                $tiempo = 'Tardanza';
                                $estilo = 'class="Tardanza"';
                            } else {
                                $tiempo = 'Puntual';
                                $estilo = 'class="Puntual"';
                            }
                        }
                    @endphp
                    <tr class="{{ $asistenciaEnFecha ? 'active-row' : '' }}">
                        <td>{{ $contador }}</td>
                        <td>{{ $alumno->apellidos }}</td>
                        <td>{{ $alumno->nombre }}</td>
                      
                        <td>{{ $alumno->grado->nombre }} - {{ $alumno->seccione->nombre }}</td>
                        <td>{{ ucfirst(\Carbon\Carbon::parse($currentDate)->locale('es_ES')->isoFormat('dddd')) }}</td>
                        <td>{{ $currentDate->format('d') }} de {{ $mesesEnEspañol[$currentDate->format('F')] }}</td>
                        <td {!! $estilo !!}>
                            @if ($asistenciaEnFecha)
                                {{ $horaEntrada->format('h:i A') }} ({{ $tiempo }})
                            @else
                                No registrado
                            @endif
                        </td>
                    </tr>
                    @php
                        $contador++;
                    @endphp
                @endforeach
                @php
                    $currentDate->addDay();
                @endphp
            @endwhile
        </tbody>
    </table>
</body>

</html>
