@extends('layout')

@section('content')
<h1>{{ $material->Descripcion }}
    <a href="{{ route('materiales.edit', $material) }}" class="btn btn-info pull-right"><i class="fa fa-edit"></i> {{ trans('strings.edit_material') }}</a>
    <a href="{{ route('materiales.destroy', $material) }}" class="btn btn-danger pull-right materiales_destroy" style="margin-right: 5px"><i class="fa fa-close"></i> {{ trans('strings.delete_material') }}</a>
</h1>
{!! Breadcrumbs::render('materiales.show', $material) !!}
<hr>
<div class="form-horizontal col-md-6 col-md-offset-3 rcorners">
    <div class="form-group">
        {!! Form::label('Descripcion', 'Descripción', ['class' => 'control-label col-sm-3']) !!}
        <div class="col-sm-9">
            {!! Form::text('Descripcion', $material->Descripcion, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('Estatus', 'Estatus', ['class' => 'control-label col-sm-3']) !!}
        <div class="col-sm-9">
            {!! Form::text('Estatus', $material->present()->estatus, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
        </div>
    </div>
</div>
@stop