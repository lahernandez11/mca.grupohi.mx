@extends('layout')

@section('content')
<h1>NUEVA ETAPA</h1>
{!! Breadcrumbs::render('etapas.create') !!}
<hr>
@include('partials.errors')

{!! Form::open(['route' => 'etapas.store']) !!}
<input type="hidden" name="usuario_registro" value="{{auth()->user()->idusuario}}">
<div class="form-horizontal rcorners">
    <div class="form-group">
        {!! Form::label('Descripcion', 'Descripción', ['class' => 'control-label col-sm-3']) !!}
        <div class="col-sm-9">
            {!! Form::text('Descripcion', null, ['class' => 'form-control', 'placeholder' => 'Descripción...']) !!}
        </div>
    </div>
</div>
<div class="form-group col-md-12" style="text-align: center; margin-top: 20px">
    <a class="btn btn-info" href="{{ URL::previous() }}">Regresar</a>        
    {!! Form::submit('Guardar', ['class' => 'btn btn-success']) !!}
</div>

{!! Form::close() !!}
@stop