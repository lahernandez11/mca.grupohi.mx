@extends('layout')

@section('content')
<h1>{{ strtoupper(trans('strings.new_sindicato')) }}</h1>
{!! Breadcrumbs::render('sindicatos.create') !!}
<hr>
@include('partials.errors')

{!! Form::open(['route' => 'sindicatos.store']) !!}
<input name="usuario_registro" type="hidden" value="{{ auth()->user()->idusuario }}">
<div class="form-horizontal col-md-6 col-md-offset-3 rcorners">
    <div class="form-group">
        {!! Form::label('Descripcion', 'Descripción', ['class' => 'control-label col-sm-3']) !!}
        <div class="col-sm-9">
            {!! Form::text('Descripcion', null, ['class' => 'form-control', 'placeholder' => 'Descripción...']) !!}
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('NombreCorto', 'Nombre Corto', ['class' => 'control-label col-sm-3']) !!}
        <div class="col-sm-9">
            {!! Form::text('NombreCorto', null, ['class' => 'form-control', 'placeholder' => 'Nombre Corto...']) !!}
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('RFC', 'RFC', ['class' => 'control-label col-sm-3']) !!}
        <div class="col-sm-9">
            {!! Form::text('rfc', null, ['class' => 'form-control', 'placeholder'=>'AAAA999999XXX']) !!}
        </div>
    </div>
</div>
<div class="form-group col-md-12" style="text-align: center; margin-top: 20px">
    <a class="btn btn-info" href="{{ URL::previous() }}">Regresar</a>        
    {!! Form::submit('Guardar', ['class' => 'btn btn-success']) !!}
</div>
{!! Form::close() !!}
@stop