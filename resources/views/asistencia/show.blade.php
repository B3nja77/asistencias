@extends('adminlte::page')
@extends('layouts.app')


@section('template_title')
    {{ $asistencia->name ?? "{{ __('Show') Asistencia" }}}}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Asistencia</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('asistencias.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Alumno Id:</strong>
                            {{ $asistencia->alumno_id }}
                        </div>
                        <div class="form-group">
                            <strong>Grado Id:</strong>
                            {{ $asistencia->grado_id }}
                        </div>
                        <div class="form-group">
                            <strong>Seccion Id:</strong>
                            {{ $asistencia->seccion_id }}
                        </div>
                        <div class="form-group">
                            <strong>Fecha:</strong>
                            {{ $asistencia->fecha }}
                        </div>
                        <div class="form-group">
                            <strong>Hora:</strong>
                            {{ $asistencia->hora }}
                        </div>
                        <div class="form-group">
                            <strong>Fecha Inicio:</strong>
                            {{ $asistencia->fecha_inicio }}
                        </div>
                        <div class="form-group">
                            <strong>Fecha Fin:</strong>
                            {{ $asistencia->fecha_fin }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
