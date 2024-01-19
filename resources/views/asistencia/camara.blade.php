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
                                {{ __('REGISTRO DE ASISTENCIAS') }}
                            </span>
                            <a href="{{ route('asistencia.index') }}" class="btn btn-outline-danger" data-placement="left">
                                <i class="fa-regular fa-circle-xmark"></i> {{ __('') }}
                            </a>

                        </div>
                    </div>

                    {{-- Iconos y fuentes FontAwesome disponibles --}}
                    <link rel="stylesheet"
                        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

                    {{-- Carga Biblioteca Instascan --}}
                    <script type="text/javascript" src="https://cdn.rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

                    {{-- Carga Biblioteca jQuery --}}
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

                    {{-- ESTILOS --}}
                    <style>
                        /* Estilos generales */
                        body {
                            font-size: 16px;
                            margin: 0;
                            padding: 0;
                        }

                        #video {
                            width: 550px;
                            /* Ajusta el ancho del video según tus necesidades */
                            height: 320px;
                            /* Ajusta la altura del video según tus necesidades */
                            margin-left: 10px;
                            /* Agregado un margen izquierdo para separarlo del otro contenido */
                        }

                        #qrData {
                            margin-top: 5px;
                            /* border: 2px solid black; */
                            /* Cambiado a negro */
                            padding: 10px;
                            overflow: hidden;
                            text-align: center;
                            /* Alineación centrada del texto */
                            margin-left: 10px;
                            /* Ajustado para centrar debajo del video */
                        }

                        #qrData .message {
                            color: black;
                            /* Cambiado a negro */
                            display: none;
                            /* Inicialmente oculto */
                        }

                        #qrData .success {
                            color: #1DDF26;
                            /* Color de texto verde (opcional) */
                            font-weight: bold;
                            font-size: 45px;
                        }

                        #qrData .error {
                            color: red;
                            font-weight: bold;
                            font-size: 45px;
                        }
                    </style>



                    <div class="card-body">

                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <div>
                                <strong style="font-size: 50px;">HORA:</strong> <span id="hora"
                                    style="font-size: 50px;"></span><br>
                                <strong style="font-size: 45px;">FECHA:</strong> <span id="fecha"
                                    style="font-size: 35px;"></span>
                            </div>

                            <div>
                                <video id="video"></video>
                                <h2 id="qrData"></h2>
                            </div>

                        </div>

                        {{-- SCRIPT PARA HORA MOSTRADA --}}
                        <script>
                            function actualizarHora() {
                                const ahora = new Date();
                                const hora = ahora.toLocaleTimeString('es-ES', {
                                    hour12: true,
                                    hour: 'numeric',
                                    minute: 'numeric',
                                    second: 'numeric'
                                });

                                // Change the date format to day, year, month in Spanish
                                const fecha = ahora.toLocaleDateString('es-ES', {
                                    day: 'numeric',
                                    year: 'numeric',
                                    month: 'long' // 'long' will display the full month name
                                });

                                document.getElementById('hora').textContent = hora;
                                document.getElementById('fecha').textContent = fecha;
                            }

                            setInterval(actualizarHora, 1000); // Update every second (1000 milliseconds)
                            actualizarHora(); // Update immediately when the page loads
                        </script>



                        {{-- token CSRF en la página web, protege contra ataques CSRF --}}
                        <meta name="csrf-token" content="{{ csrf_token() }}">

                        {{-- SCRIPT CAMARA --}}
                        <script type="text/javascript">
                            const videoElement = document.getElementById('video');
                            const qrDataElement = document.getElementById('qrData');
                            const messageElement = document.createElement('div');
                            messageElement.className = 'message';
                            qrDataElement.appendChild(messageElement);

                            const scanner = new Instascan.Scanner({
                                video: videoElement
                            });

                            scanner.addListener('scan', function(content) {
                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    }
                                });
                                // Añadir un retraso de 1 segundo
                                setTimeout(function() {
                                    // Realizar la solicitud AJAX
                                    $.ajax({
                                        url: '/asistencias/public/asistencias',
                                        method: 'POST',
                                        data: {
                                            alumno_id: content
                                        },
                                        success: function(data) {
                                            // Mostrar el mensaje en qrDataElement
                                            messageElement.innerText = data.message;

                                            // Eliminar clases anteriores
                                            messageElement.classList.remove('success', 'error');

                                            if (data.success) {
                                                // Agregar clase para un mensaje de éxito
                                                messageElement.classList.add('success');
                                            } else {
                                                // Agregar clase para un mensaje de error
                                                messageElement.classList.add('error');
                                            }
                                            // Mostrar el elemento h2
                                            messageElement.style.display = 'block';
                                            // Configurar el temporizador para ocultar el elemento h2 después de 2 segundos
                                            setTimeout(function() {
                                                messageElement.style.display = 'none';
                                            }, 1410);
                                        },
                                        error: function(xhr, status, error) {
                                            // Manejar errores de la solicitud AJAX si es necesario
                                            console.error(xhr.responseText);
                                        }
                                    });
                                }, 1300); // 1 segundo de retraso
                            });

                            Instascan.Camera.getCameras().then(function(cameras) {
                                if (cameras.length > 0) {
                                    scanner.start(cameras[0]);
                                } else {
                                    console.error('No se encontraron cámaras en el dispositivo.');
                                }
                            }).catch(function(error) {
                                console.error(error);
                            });
                        </script>




                        {{-- <span id="card_title" style="font-size: 20px">
                            {{ __('System Developed by  Benjamin L.V - Copyright © 2023') }}
                        </span> --}}

                    </div>

                </div>

            </div>

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
