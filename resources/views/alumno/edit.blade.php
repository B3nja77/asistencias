@extends('adminlte::page')

@section('content_header')
    @if (Session::has('mensaje'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('mensaje') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button </div>
    @endif

    {{-- LINK PARA ICONO --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    {{-- SCRIPT funcion MODALES --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

    {{-- FUNCION PARA VALIDACION DE DNI --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card">

                    <div class="card-header">
                        <span class="card-title">{{ __('Actualizar Registro de ') }} Alumno</span>
                    </div>

                    <div class="card-body">

                        <!-- Formulario de edición -->
                        <form method="POST" action="{{ route('alumnos.update', $alumno->id) }}" role="form"
                            enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            <style>
                                .invalid-feedback {
                                    color: red;
                                }
                            </style>

                            {{-- CAMPO DE DNI --}}
                            <div class="form-group">
                                {{ Form::label('DNI') }}
                                {{ Form::text('DNI', $alumno->DNI, ['id' => 'dni-input', 'class' => 'form-control', 'placeholder' => 'Ingrese DNI']) }}

                                <div id="dni-too-short" class="invalid-feedback" style="display: none;">Debes ingresar al
                                    menos 8 caracteres.
                                </div>
                                <div id="dni-too-long" class="invalid-feedback" style="display: none;">Has introducido más
                                    de 8 caracteres.
                                </div>
                            </div>

                            {{-- SCRIPT DE VALIDACION DNI --}}
                            <script>
                                $(document).ready(function() {
                                    $('#dni-input').on('input', function() {
                                        var dniValue = $(this).val();
                                        var isValid = dniValue.length === 8;

                                        if (dniValue.length < 8) {
                                            $('#dni-warning').hide();
                                            $('#dni-too-short').show();
                                            $('#dni-too-long').hide();
                                        } else if (dniValue.length === 8) {
                                            $('#dni-warning').hide();
                                            $('#dni-too-short').hide();
                                            $('#dni-too-long').hide();
                                        } else {
                                            $('#dni-warning').hide();
                                            $('#dni-too-short').hide();
                                            $('#dni-too-long').show();
                                        }
                                    });
                                });
                            </script>

                            {{-- CAMPO DE NOMBRE --}}
                            <div class="form-group">
                                {{ Form::label('nombre') }}
                                {{ Form::text('nombre', $alumno->nombre, ['class' => 'form-control' . ($errors->has('nombre') ? ' is-invalid' : ''), 'placeholder' => 'Ingrese Nombre']) }}
                                {!! $errors->first('nombre', '<div class="invalid-feedback">:message</div>') !!}
                            </div>

                            {{-- CAMPO DE APELLIDOS --}}
                            <div class="form-group">
                                {{ Form::label('apellidos') }}
                                {{ Form::text('apellidos', $alumno->apellidos, ['class' => 'form-control' . ($errors->has('apellidos') ? ' is-invalid' : ''), 'placeholder' => 'Ingrese Apellidos']) }}
                                {!! $errors->first('apellidos', '<div class="invalid-feedback">:message</div>') !!}
                            </div>

                            {{-- CAMPO DE GRADOS --}}
                            <div class="form-group">
                                {{ Form::label('grado') }}
                                {{ Form::select('grado_id', $grados, $alumno->grado_id, ['class' => 'form-control' . ($errors->has('grado_id') ? ' is-invalid' : ''), 'placeholder' => 'Ingrese Grado']) }}
                                {!! $errors->first('grado_id', '<div class="invalid-feedback">:message</div>') !!}
                            </div>

                            {{-- CAMPO DE SECCION --}}
                            <div class="form-group">
                                {{ Form::label('seccion') }}
                                {{ Form::select('seccion_id', $secciones, $alumno->seccion_id, ['class' => 'form-control' . ($errors->has('seccion_id') ? ' is-invalid' : ''), 'placeholder' => 'Ingrese Sección']) }}
                                {!! $errors->first('seccion_id', '<div class="invalid-feedback">:message</div>') !!}
                            </div>

                            <div class="box-footer mt20">

                                <button type="button" class="btn btn-primary" id="openConfirmationModal">
                                    {{ __('Confirmar Edicion') }}
                                </button>

                                <button type="button" class="btn btn-secondary"
                                    onclick="window.location.href='{{ route('alumnos.index') }}'">Regresar
                                </button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        </section>

        <!-- Modal de Confirmación -->
        <div class="modal fade" id="confirmacionModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h4 class="modal-title">Confirmación de Edición</h4>
                    </div>

                    <div class="modal-body">
                        ¿Estás seguro de editar a este alumno?
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                        <!-- Agrega un botón para confirmar la edición -->
                        <button type="button" class="btn btn-primary" id="confirmarEdicion">Confirmar</button>
                    </div>

                </div>
            </div>
        </div>

        <!-- Script para manejar el modal de confirmación -->
        <script>
            $(document).ready(function() {
                let formData; // Almacenar temporalmente los datos del formulario

                // Abrir el modal de confirmación al hacer clic en el botón
                $("#openConfirmationModal").click(function(event) {
                    // Prevenir el envío del formulario por defecto
                    event.preventDefault();

                    // Mostrar el modal de confirmación
                    $("#confirmacionModal").modal("show");
                });

                // Manejar la confirmación de edición
                $("#confirmarEdicion").click(function() {
                    // Ocultar el modal
                    $("#confirmacionModal").modal("hide");

                    // Enviar el formulario de edición
                    $("form").submit();
                });
            });
        </script>


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
