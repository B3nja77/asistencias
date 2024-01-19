@extends('layouts.app')

@section('template_title')
    {{ $alumno->name ?? "{{ __('Show') Alumno" }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Alumno</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('alumnos.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Nombre:</strong>
                            {{ $alumno->nombre }}
                        </div>
                        <div class="form-group">
                            <strong>Apellidos:</strong>
                            {{ $alumno->apellidos }}
                        </div>
                        <div class="form-group">
                            <strong>Dni:</strong>
                            {{ $alumno->DNI }}
                        </div>
                        <div class="form-group">
                            <strong>Grado Id:</strong>
                            {{ $alumno->grado_id }}
                        </div>
                        <div class="form-group">
                            <strong>Seccion Id:</strong>
                            {{ $alumno->seccion_id }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
