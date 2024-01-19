{{-- MODAL DE CARNET QR --}}
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <div class="modal-header">
                <h1 class="modal-title fs-4">Generar Carnets QR</h1>
            </div>

            <div class="modal-body">
                <form id="pdf-form" action="{{ route('alumno.pdf') }}" method="GET" target="_blank">
                    <div class="form-group">
                        <label for="gradoSeccion">Escribe un Grado y Sección:</label>
                        <input type="text" name="gradoSeccion" id="gradoSeccion" class="form-control" style="background-color: #F8FCFC; color: black; border-radius: 10px;" required>
                        <span id="error-message" style="color: red;"></span>
                    </div>
                
                    <div class="d-flex justify-content-between mt-3">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-outline-warning" data-placement="left">
                            <i class="fas fa-qrcode"></i> {{ __('Generar Carnets QR') }}
                        </button>
                    </div>
                </form>
                
                
            </div>

        </div>
    </div>
</div>
{{-- script de seleccion de secciones --}}
<script>
    const gradoSelect = document.getElementById('grado');
const seccionSelect = document.getElementById('seccion');

// Obtener todas las secciones de la base de datos
const secciones = Seccione::all();

// Llenar el select de secciones con todas las secciones
secciones.forEach(seccion => {
    const option = document.createElement('option');
    option.value = seccion.nombre;
    option.textContent = seccion.nombre;
    seccionSelect.appendChild(option);
});

gradoSelect.addEventListener('change', () => {});

// Detecta cuando se envía el formulario y restablece el valor del select de grado
document.getElementById('pdf-form').addEventListener('submit', () => {
    setTimeout(() => {
        gradoSelect.value = '';
        seccionSelect.value = '';
    }, 0);
});

</script>
<script>
    const gradoSeccionInput = document.getElementById('gradoSeccion');
    const errorMessage = document.getElementById('error-message');

    document.getElementById('pdf-form').addEventListener('submit', (event) => {
        // Obtén el valor del campo "Grado y Sección"
        const gradoSeccionValue = gradoSeccionInput.value.trim();

        // Divide el valor en palabras
        const words = gradoSeccionValue.split(' ');

        // Verifica si se han ingresado al menos dos palabras
        if (words.length < 2) {
            // Muestra un mensaje de error y evita que se envíe el formulario
            errorMessage.textContent = "Te falto poner la Sección";
            event.preventDefault();
        } else {
            // Limpia el mensaje de error si los dos campos están presentes
            errorMessage.textContent = "";
        }
    });
</script>



{{-- MODAL PARA REGISTRAR ALUMNOS --}}

<div class="modal fade" id="alumno" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-4">Registrar Alumno</h1>
            </div>
            <div class="modal-body">

                <form id="registroForm" action="{{ route('alumnos.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        {{ Form::label('DNI') }}
                        {{ Form::text('DNI', '', ['id' => 'dni-input', 'class' => 'form-control', 'placeholder' => 'Ingrese DNI', 'required']) }}
                        <span id="dni-error" class="invalid-feedback" style="display: none;"></span>
                    </div>

                    <div class="form-group">
                        {{ Form::label('nombre') }}
                        {{ Form::text('nombre', '', ['class' => 'form-control', 'placeholder' => 'Ingrese Nombre', 'required']) }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('apellidos') }}
                        {{ Form::text('apellidos', '', ['class' => 'form-control' . ($errors->has('apellidos') ? ' is-invalid' : ''), 'placeholder' => 'Ingrese Apellidos', 'required']) }}
                        {!! $errors->first('apellidos', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                    <div class="form-group">
                        {{ Form::label('grado') }}
                        {{ Form::select('grado_id', $grados, null, ['class' => 'form-control' . ($errors->has('grado_id') ? ' is-invalid' : ''), 'placeholder' => 'Seleccione un Grado', 'required' => 'required']) }}
                        {!! $errors->first('grado_id', '<div class="invalid-feedback">:message</div>') !!}
                    </div>

                    <div class="form-group">
                        {{ Form::label('seccion') }}
                        {{ Form::select('seccion_id', $secciones, null, ['class' => 'form-control' . ($errors->has('seccion_id') ? ' is-invalid' : ''), 'placeholder' => 'Selecciona una Sección', 'required' => 'required']) }}
                        {!! $errors->first('seccion_id', '<div class="invalid-feedback">:message</div>') !!}
                    </div>

                    <div class="d-flex justify-content-between mt-3">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" id="registroButton"
                            class="btn btn-primary">{{ __('Registrar') }}</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
{{-- VALIDACION DE NUMEROS DEL DNI --}}
<script>
    $(document).ready(function() {
        $('#dni-input').on('input', function() {
            var dniValue = $(this).val();
            var isValid = dniValue.length === 8;

            if (dniValue.length < 8) {
                // Mensaje de error para menos de 8 dígitos
                $('#dni-error').text('Te faltan números.').show();
            } else if (dniValue.length > 8) {
                // Mensaje de error para más de 8 dígitos
                $('#dni-error').text('Te pasaste de números.').show();
            } else {
                // Oculta el mensaje de error si es válido
                $('#dni-error').hide();
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        // Obtener todos los campos de entrada y select del formulario
        var $formInputs = $('#registroForm :input');

        // Obtener el botón de "Registrar"
        var $registroButton = $('#registroButton');

        // Función para verificar si todos los campos están llenos
        function checkFields() {
            var allFieldsFilled = true;

            $formInputs.each(function() {
                if ($(this).prop('required') && $(this).val() === '') {
                    allFieldsFilled = false;
                    return false; // Salir del bucle si encontramos un campo vacío
                }
            });

            return allFieldsFilled;
        }

        // Deshabilitar el botón de "Registrar" al cargar la página
        $registroButton.prop('disabled', true);

        // Habilitar o deshabilitar el botón de "Registrar" según los campos
        $formInputs.on('input change', function() {
            if (checkFields()) {
                $registroButton.prop('disabled', false);
            } else {
                $registroButton.prop('disabled', true);
            }
        });
    });
</script>




<div class="modal fade" id="confirmacionModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Confirmación de Registro</h4>
               
            </div>
            <div class="modal-body">
                ¿Estás seguro de registrar a este alumno?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="confirmarRegistro">Confirmar</button>
            </div>
        </div>
    </div>
</div>

{{-- MANEJO DE MODAL DE CONFIRMACION --}}
<script>
    $(document).ready(function() {
        let formData; // Almacenar temporalmente los datos del formulario

        $("#registroButton").click(function(event) {
            // Prevenir el envío del formulario por defecto
            event.preventDefault();

            // Almacenar los datos del formulario
            formData = $("#registroForm").serializeArray();

            // Mostrar el modal de confirmación
            $("#confirmacionModal").modal("show");
        });

        // Manejar la confirmación de registro
        $("#confirmarRegistro").click(function() {
            // Ocultar el modal
            $("#confirmacionModal").modal("hide");

            // Recuperar los datos del formulario y enviar el formulario
            if (formData) {
                formData.forEach(function(field) {
                    $(`[name="${field.name}"]`).val(field.value);
                });

                $("#registroForm").submit();
            }
        });
    });
</script>

