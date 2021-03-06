@extends('layout')

@section('content')
<h1>{{ $sindicato->Descripcion }}
    @permission('editar-sindicatos')
    <a href="{{ route('sindicatos.edit', $sindicato) }}" class="btn btn-info pull-right"><i class="fa fa-edit"></i> {{ trans('strings.edit') }}</a>
    @endpermission
    @permission('consultar-historico')
    <button type="button" id="ver_historico" class="btn btn-primary pull-right"><i class="fa fa-calendar"></i>
        Historico
    </button>
    @endpermission
</h1>
{!! Breadcrumbs::render('sindicatos.show', $sindicato) !!}
<hr>
{!! Form::model($sindicato) !!}
<div class="form-horizontal col-md-6 col-md-offset-3 rcorners">
    <div class="form-group">
        {!! Form::label('Descripcion', 'Descripción', ['class' => 'control-label col-sm-3']) !!}
        <div class="col-sm-9">
            {!! Form::text('Descripcion', null, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('NombreCorto', 'Nombre Corto', ['class' => 'control-label col-sm-3']) !!}
        <div class="col-sm-9">
            {!! Form::text('NombreCorto', null, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('RFC', 'RFC', ['class' => 'control-label col-sm-3']) !!}
        <div class="col-sm-9">
            {!! Form::text('rfc', null, ['class' => 'form-control', 'disabled' => 'disabled','place-holder'=>'AAAA999999XXX']) !!}
        </div>
    </div>
</div>
{!! Form::close() !!}
<div class="form-group col-md-12" style="text-align: center; margin-top: 20px">
    {!! link_to_route('sindicatos.index', 'Regresar', [],  ['class' => 'btn btn-info'])!!}
</div>
<div id="modal_historico">
</div>
@stop
@section('scripts')
    <script>
        $('#ver_historico').off().on('click', function (e) {
            e.preventDefault();
            $.ajax({
                type: 'GET',
                url: App.host + '/historico/sindicatos/{{$sindicato->IdSindicato}}',
                success: function (response) {
                    $('#modal_historico').html(response);
                    $('#historicoModal').modal('show');
                }
            })
        });
    </script>
@endsection