@extends('adminlte::page')

@section('content_header')
    @if (Session::has('mensaje'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('mensaje') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">

                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('LISTA DE ALUMNOS') }}
                            </span>

                            <div class="float-right">

                                <a class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#alumno">
                                    <i class="fas fa-user"></i> Registrar Alumno
                                </a>

                                <a href="{{ route('secciones.create') }}" class="btn btn-outline-primary"
                                    data-placement="left">
                                    <i class="fa-solid fa-school"></i> {{ __('Registar Nueva Sección') }}
                                </a>

                                <a class="btn btn-outline-warning me-2" data-bs-toggle="modal"
                                    data-bs-target="#staticBackdrop">
                                    <i class="fa fa-2x fa-qrcode"></i> Generar Carnets QR
                                </a>

                            </div>

                        </div>
                    </div>
                    {{-- LINK PARA ICONO --}}
                    <link rel="stylesheet"
                        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

                    {{-- SCRIPT funcion MODALES --}}
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

                    {{-- ESTILOS --}}
                    <style>
                        .centered-message {
                            text-align: center;
                            position: fixed;
                            top: 50%;
                            left: 50%;
                            transform: translate(-50%, -50%);
                            z-index: 1000;
                            /* Asegura que esté en la parte superior de todos los elementos */
                            background-color: #28a745;
                            /* Color de fondo */
                            color: #fff;
                            /* Color del texto */
                            padding: 10px 20px;
                            /* Espaciado interior del mensaje */
                            border-radius: 5px;
                            /* Bordes redondeados */
                            font-size: 2.5rem;
                            /* Tamaño de texto mediano (ajusta según tus preferencias) */
                            animation: fadeOut 5s ease-in-out forwards;
                            /* Animación de desvanecimiento de 3 segundos */
                        }

                        @keyframes fadeOut {
                            to {
                                opacity: 0;
                                transform: translate(-50%, -50%) scale(0.8);
                            }
                        }
                    </style>

                    {{-- MENSAJE DE CONFIRMACION DE REGISTROS --}}
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success centered-message">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body">

                        <div class="table-responsive">
                            <table id="categorias" class="table table-striped shadow-lg mt-4">
                                <thead class="thead">
                                    <tr>
                                        <th>N°</th>
                                        <th>NOMBRE</th>
                                        <th>APELLIDOS</th>
                                        <th>DNI</th>
                                        <th>GRADO</th>
                                        <th>SECCION</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $contador = 1;
                                    @endphp
                                    @foreach ($alumnos as $alumno)
                                        <tr>
                                            <td>{{ $contador }}</td>
                                            <td>{{ $alumno->nombre }}</td>
                                            <td>{{ $alumno->apellidos }}</td>
                                            <td>{{ $alumno->DNI }}</td>
                                            <td>{{ $alumno->grado->nombre }}</td>
                                            <td>{{ $alumno->seccione->nombre }}</td>
                                            <td>
                                                <form action="{{ route('alumnos.destroy', $alumno->id) }}" method="POST">

                                                    <a class="btn btn-sm btn-success"
                                                        href="{{ route('alumnos.edit', $alumno->id) }}"><i
                                                            class="fa fa-fw fa-edit"></i>
                                                        {{ __('Editar Registro') }}</a>

                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                        data-target="#confirmModal{{ $alumno->id }}">
                                                        <i class="fa fa-fw fa-trash"></i> Dar de Baja
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @php
                                            $contador++;
                                        @endphp
                                    @endforeach
                                </tbody>
                            </table>
                            @foreach ($alumnos as $alumno)
                                <!-- Modal de confirmación para cada alumno -->
                                <div class="modal fade" id="confirmModal{{ $alumno->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="confirmModalLabel{{ $alumno->id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="confirmModalLabel{{ $alumno->id }}">Confirmar
                                                    Eliminación</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                ¿Estás seguro de que deseas dar de baja a {{ $alumno->nombre }}
                                                {{ $alumno->apellidos }}?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Cancelar</button>
                                                <form action="{{ route('alumnos.destroy', $alumno->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Confirmar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <span id="card_title">
                            {{ __('System Developed by  Benjamin L.V - Copyright © 2023') }}
                        </span>
                    </div>

                    <!-- Incluye la librería DataTables -->
                    <link rel="stylesheet" type="text/css" href="ruta/a/dataTables.bootstrap4.min.css">
                    <script type="text/javascript" src="ruta/a/jquery.dataTables.min.js"></script>
                    <script type="text/javascript" src="ruta/a/dataTables.bootstrap4.min.js"></script>

                    <!-- Incluye la traducción al español -->
                    <script type="text/javascript" src="ruta/a/dataTables.es.min.js"></script>
                </div>
                <!-- Asegúrate de incluir jQuery y el script de DataTables -->
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
                <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
                {{-- scripts para buscador de tablas --}}
                <script>
                    $(document).ready(function() {
                        $('#dt-filter-select').dataTable({

                            initComplete: function() {
                                this.api().columns().every(function() {
                                    var column = this;
                                    var select = $(
                                            '<select class="browser-default custom-select form-control-sm"><option value="" selected>Search</option></select>'
                                        )
                                        .appendTo($(column.footer()).empty())
                                        .on('change', function() {
                                            var val = $.fn.dataTable.util.escapeRegex($(this).val());

                                            column
                                                .search(val ? '^' + val + '$' : '', true, false)
                                                .draw();
                                        });

                                    column.data().unique().sort().each(function(d, j) {
                                        select.append('<option value="' + d + '">' + d +
                                            '</option>')
                                    });
                                });
                            }
                        });
                    });
                </script>

            </div>
            @include('alumno.modales')



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
                        "search": "Buscar",
                        "lengthMenu": "",
                        "info": "",
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
