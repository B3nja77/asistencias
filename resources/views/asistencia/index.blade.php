@extends('adminlte::page')

@section('content_header')
    @if (Session::has('mensaje'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('mensaje') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button </div>
    @endif

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">

                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('LISTA DE ASISTENCIAS') }}
                            </span>


                            <div>

                                <a href="{{ url('/camara') }}"class="btn btn-outline-warning me-2"><i
                                        class="fa fa-fw fas fa-plus-circle"></i> Registrar Asistencias</a>

                                <a class="btn btn-outline-success me-2" data-bs-toggle="modal"
                                    data-bs-target="#staticBackdrop">
                                    <i class="fa-regular fa-file"></i> Generar Reporte de Asistencia
                                </a>
                                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#filtro-fechas">
                                    <i class="fa-solid fa-calendar-days"></i> Filtrar Registros por Fecha
                                </button>



                                <div class="modal fade" id="filtro-fechas" data-bs-backdrop="static"
                                    data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Filtrar por Fecha</h4>

                                            </div>
                                            <div class="modal-body">
                                                <form id="filtro-form" action="{{ route('asistencia.index') }}"
                                                    method="GET">
                                                    <div class="form-group">
                                                        <label for="start_date">Fecha de Inicio:</label>
                                                        <input type="date" id="start_date" name="start_date"
                                                            class="form-control" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="end_date">Fecha de Fin:</label>
                                                        <input type="date" id="end_date" name="end_date"
                                                            class="form-control" required>
                                                    </div>
                                                    <button type="button" class="btn btn-danger"
                                                        data-bs-dismiss="modal">Cancelar</button>
                                                    <button type="submit" class="btn btn-primary">Filtrar</button>
                                                    <button type="button" class="btn btn-secondary"
                                                        id="reset-view">Restablecer Vista</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <script>
                                document.getElementById('reset-view').addEventListener('click', function() {
                                    // Redirige a la misma página sin los parámetros de filtro
                                    window.location.href = "{{ route('asistencia.index') }}";
                                });
                            </script>

                        </div>
                    </div>

                    {{-- LINK PARA ICONO --}}
                    <link rel="stylesheet"
                        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

                    {{-- SCRIPT funcion MODALES --}}
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

                    {{-- Mensaje de CONFIRMACION DE REGISTRO/UPDATE/DELETE --}}
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif


                    {{-- ESTILOS --}}
                    <style>
                        /* Estilos generales */
                        body {
                            font-size: 16px;
                            margin: 0;
                            padding: 0;
                        }

                        /* Tabla */
                        #mi-tabla {
                            width: 100%;
                        }

                        #mi-tabla tfoot th {
                            display: none;
                        }

                        /* Clases para el color del texto */
                        .puntual {
                            color: green;
                        }

                        .tardanza {
                            color: red;
                        }
                    </style>

                    <div class="card-body">

                        {{-- SCRIPT FUNCION TABLA. --}}
                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

                        <!-- Incluye la hoja de estilos de DataTables -->
                        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

                        <!-- Incluye el script de DataTables -->
                        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>


                        <div class="table-responsive">
                            <table id="mi-tabla" class="table table-striped shadow-lg mt-4">
                                <thead class="thead">
                                    <tr>
                                        <th>N°</th>
                                        <TH>Apellidos</TH>
                                        <th>Nombres</th>
                                        <th>Grado / Sección</th>
                                        <th>Día</th>
                                        <th>Fecha</th>
                                        <th>Hora de Entrada</th>
                                    </tr>
                                </thead>
                                <tbody id="tabla-body">

                                    @foreach ($asistencias as $index => $asistencia)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $asistencia->alumno->apellidos }}</td>
                                            <td>{{ $asistencia->alumno->nombre }}</td>
                                            <td>{{ $asistencia->grado->nombre }} - {{ $asistencia->seccione->nombre }}</td>
                                            <td>{{ ucfirst(\Carbon\Carbon::parse($asistencia->fecha)->locale('es_ES')->isoFormat('dddd')) }}
                                            </td>

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

                                                $horaEntrada = \Carbon\Carbon::parse($asistencia->hora);
                                                $horaLimite = \Carbon\Carbon::parse('07:45:59');
                                                $tiempo = $horaEntrada->greaterThan($horaLimite) ? 'Tardanza' : 'Puntual';
                                                $claseTiempo = $tiempo === 'Tardanza' ? 'tardanza' : 'puntual';
                                            @endphp

                                            <td>{{ \Carbon\Carbon::parse($asistencia->fecha)->format('d') }} de
                                                {{ $mesesEnEspañol[\Carbon\Carbon::parse($asistencia->fecha)->format('F')] }}
                                            </td>
                                            <td class="{{ $claseTiempo }}">{{ $horaEntrada->format('h:i A') }}
                                                ({{ $tiempo }})
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Buscar</th>
                                        <th>Buscar</th>
                                        <th>Buscar</th>
                                        <th>Buscar</th>
                                        <th>Buscar</th>
                                        <th>Buscar</th>
                                        <th>Buscar</th>
                                    </tr>
                                </tfoot>
                            </table>

                        </div>
                        {{-- <span id="card_title">
                            {{ __('System Developed by Benjamin L.V - Copyright © 2023') }}
                        </span> --}}
                    </div>

                    {{-- Script para funcionamiento de filtro y buscador --}}
                    <script>
                        $(document).ready(function() {
                            var table = $('#mi-tabla').DataTable({
                                initComplete: function() {
                                    this.api().columns().every(function() {
                                        var column = this;
                                        var columnIndex = column.index();

                                        // Verificar si la columna es "Grado / Sección" o "Día"
                                        if (columnIndex === 3 || columnIndex === 4) {
                                            var select = $(
                                                    '<select class="browser-default custom-select form-control-sm"><option value="" selected>Buscar</option></select>'
                                                )
                                                .appendTo($(column.header()))
                                                .on('change', function() {
                                                    var val = $.fn.dataTable.util.escapeRegex(
                                                        $(this).val()
                                                    );
                                                    column
                                                        .search(val ? '^' + val + '$' : '', true, false)
                                                        .draw();
                                                });

                                            column.data().unique().sort().each(function(d, j) {
                                                select.append('<option value="' + d + '">' + d +
                                                    '</option>');
                                            });
                                        }
                                    });
                                },
                                // Eliminar la opción de "Show entries"
                                lengthChange: false
                            });

                            // Aplicar el filtrado en los campos de búsqueda personalizados
                            table.columns().every(function() {
                                var that = this;

                                $('input', this.footer()).on('keyup change', function() {
                                    if (that.search() !== this.value) {
                                        that
                                            .search(this.value)
                                            .draw();
                                    }
                                });
                            });
                        });
                    </script>


                </div>

                <!-- Incluye la librería DataTables -->
                <link rel="stylesheet" type="text/css" href="ruta/a/dataTables.bootstrap4.min.css">
                <script type="text/javascript" src="ruta/a/jquery.dataTables.min.js"></script>
                <script type="text/javascript" src="ruta/a/dataTables.bootstrap4.min.js"></script>

            </div>

            @include('asistencia.modales')

        </div>
    @section('css')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">
    @endsection

    @section('js')
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
        <script>
            $(document).ready(function() {
                table = $('#categorias').DataTable({
                    "language": {

                        "paginate": {
                            "previous": "Anterior",
                            "next": "Siguiente",
                            "first": "Primero",
                            "last": "Ultimo"

                        }
                    }
                })
            });
        </script>

    @endsection
@stop
