@extends('layout')

@section('content')
<h1>{{ $marca->Descripcion }}
    @permission('editar-marcas')
    <a href="{{ route('marcas.edit', $marca) }}" class="btn btn-info pull-right"><i class="fa fa-edit"></i> {{ trans('strings.edit') }}</a>
    @endpermission
</h1>
{!! Breadcrumbs::render('marcas.show', $marca) !!}
<hr>
{!! Form::model($marca) !!}
<div class="form-horizontal rcorners">
    <div class="form-group">
        {!! Form::label('Descripcion', 'Descripción', ['class' => 'control-label col-sm-3']) !!}
        <div class="col-sm-9">
            {!! Form::text('Descripcion', null, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
        </div>
    </div>
</div>
<div class="form-group col-md-12" style="text-align: center; margin-top: 20px">
    {!! link_to_route('marcas.index', 'Regresar', [],  ['class' => 'btn btn-info'])!!}
</div>
{!! Form::close() !!}
@stop