<div class="box box-info padding-1">
    <div class="box-body">


        <style>
            .invalid-feedback {
                color: red;
            }
        </style>

        <div class="form-group">
            {{ Form::label('DNI') }}
            {{ Form::text('DNI', $alumno->DNI, ['id' => 'dni-input', 'class' => 'form-control', 'placeholder' => 'Ingrese DNI']) }}

            <div id="dni-too-short" class="invalid-feedback" style="display: none;">Debes ingresar al menos 8 caracteres.
            </div>
            <div id="dni-too-long" class="invalid-feedback" style="display: none;">Has introducido más de 8 caracteres.
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
        <div class="form-group">
            {{ Form::label('nombre') }}
            {{ Form::text('nombre', $alumno->nombre, ['class' => 'form-control' . ($errors->has('nombre') ? ' is-invalid' : ''), 'placeholder' => 'Ingrese Nombre']) }}
            {!! $errors->first('nombre', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('apellidos') }}
            {{ Form::text('apellidos', $alumno->apellidos, ['class' => 'form-control' . ($errors->has('apellidos') ? ' is-invalid' : ''), 'placeholder' => 'Ingrese Apellidos']) }}
            {!! $errors->first('apellidos', '<div class="invalid-feedback">:message</div>') !!}
        </div>



        <div class="form-group">
            {{ Form::label('grado') }}
            {{ Form::select('grado_id', $grados, $alumno->grado_id, ['class' => 'form-control' . ($errors->has('grado_id') ? ' is-invalid' : ''), 'placeholder' => 'Ingrese Grado']) }}
            {!! $errors->first('grado_id', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('seccion') }}
            {{ Form::select('seccion_id', $secciones, $alumno->seccion_id, ['class' => 'form-control' . ($errors->has('seccion_id') ? ' is-invalid' : ''), 'placeholder' => 'Ingrese Sección']) }}
            {!! $errors->first('seccion_id', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <br>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{ __('Confirmar') }}</button>

        <button type="button" class="btn btn-secondary"
            onclick="window.location.href='{{ route('alumnos.index') }}'">Regresar</button>

    </div>
</div>
