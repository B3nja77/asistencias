@extends('adminlte::page')

@section('content_header')
    @if (Session::has('mensaje'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('mensaje') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button </div>
    @endif


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Registrar') }} Nueva Seccion</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('secciones.store') }}" role="form"
                            enctype="multipart/form-data">
                            @csrf

                            @include('seccione.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
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

