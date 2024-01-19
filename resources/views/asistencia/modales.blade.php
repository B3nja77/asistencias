{{-- MODAL DE REPORTE EXCEL --}}
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-4">Generar Reporte</h1>
            </div>
            <div class="modal-body">
                <form action="{{ route('asistencia.diariopdf') }}" method="POST" class="mt-4" id="excel-form" target="_blank">
                    @csrf
                    <div class="form-group">
                        <label for="start_date">Fecha de Inicio:</label>
                        <input type="date" id="start_date" name="start_date" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="end_date">Fecha de Fin:</label>
                        <input type="date" id="end_date" name="end_date" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="gradoSeccion">Escribe un Grado y Sección:</label>
                        <input type="text" id="gradoSeccion" name="gradoSeccion" class="form-control" style="background-color: #F8FCFC; color: black; border-radius: 10px;" required>
                        <span id="error-message" style="color: red;"></span>
                    </div>
                
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-outline-success btn-sm" id="generate-button" disabled>
                            <i class="fa-regular fa-file"></i> Generar Reporte
                        </button>
                    </div>
                </form>
                
            </div>

            <script>
                const gradoSeccionInput = document.getElementById('gradoSeccion');
                const errorMessage = document.getElementById('error-message');
                const generateButton = document.getElementById('generate-button');

                gradoSeccionInput.addEventListener('input', () => {
                    // Limpiar el mensaje de error
                    errorMessage.textContent = "";

                    // Obtener el valor del campo "Grado y Sección"
                    const gradoSeccionValue = gradoSeccionInput.value.trim();

                    // Verifica si se han ingresado al menos dos palabras
                    if (gradoSeccionValue.split(' ').length < 2) {
                        // Muestra un mensaje de error y deshabilita el botón "Generar Reporte"
                        errorMessage.textContent = "Te faltó poner la Sección";
                        generateButton.setAttribute('disabled', 'disabled');
                    } else {
                        // Habilita el botón "Generar Reporte"
                        generateButton.removeAttribute('disabled');
                    }
                });

                document.getElementById('excel-form').addEventListener('submit', (event) => {
                    // Obtener el valor del campo "Grado y Sección"
                    const gradoSeccionValue = gradoSeccionInput.value.trim();

                    // Divide el valor en palabras
                    const words = gradoSeccionValue.split(' ');

                    // Verifica si se han ingresado al menos dos palabras
                    if (words.length < 2) {
                        // Muestra un mensaje de error y evita que se envíe el formulario
                        errorMessage.textContent = "Te faltó poner la Sección";
                        event.preventDefault();
                    } else {
                        // Limpia el mensaje de error si los dos campos están presentes
                        errorMessage.textContent = "";
                    }
                });
            </script>
        </div>
    </div>
</div>




