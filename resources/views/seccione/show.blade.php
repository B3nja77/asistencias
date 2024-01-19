@extends('layouts.app')

@section('template_title')
    {{ $seccione->name ?? "{{ __('Show') Seccione" }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Seccione</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('secciones.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Nombre:</strong>
                            {{ $seccione->nombre }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
