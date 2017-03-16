@extends('layout')

@section('content')
<h1>{{ strtoupper(trans('strings.conciliaciones')) }}
  <a href="{{ route('conciliaciones.create') }}" class="btn btn-success pull-right"><i class="fa fa-plus"></i> {{ trans('strings.new_conciliacion') }}</a>
</h1>
<hr>
<div >
    <div class="row">
        <div class="col-md-6">
            @if(Request::get('buscar')!= "")
             <h4>
            Resultados para: <strong>{{Request::get('buscar')}}</strong>
        </h4>
            @endif
        </div>
        <div class="col-md-6 text-right" >
    <form class="form-inline" action="{{route("conciliaciones.index")}}">
       
        <div class="input-group">
            <input type="text" name="buscar" class='form-control input-sm' placeholder="buscar..." value="{{Request::get('buscar')}}" />
          <span class="input-group-btn">
            <button class="btn btn-sm btn-primary" type="submit">Buscar</button>
          </span>
        </div>
    </form>
        </div>
    </div>
  <br>
</div>
<div class="table-responsive">
  <table class="table table-hover table-bordered small">
      <thead>
     
      <tr>
        <th style="width: 20px">#</th>
        <th>Folio</th>
        <th>Sindicato</th>
        <th>Empresa</th>
        <th>Número de Viajes</th>
        <th>Vólumen</th>
        <th>Importe</th>
        <th>Registró</th>
        <th>Fecha/Hora Registro</th>
          <th>Editrar</th>
          <th>Cancelar</th>
      </tr>
    </thead>
    <tbody>
      @foreach($conciliaciones as $conciliacion)
        <tr>
            <td>
            {{$contador++}}
            </td>
             <td>
            {{$conciliacion->idconciliacion}}
            </td>
            <td>{{$conciliacion->sindicato->Descripcion}}</td>
            <td>{{$conciliacion->empresa}}</td>
            <td style="text-align: right">{{$conciliacion->conciliacionDetalles->count()}}</td>
            <td style="text-align: right">{{$conciliacion->volumen_f}}</td>
            <td style="text-align: right">{{$conciliacion->importe_f}}</td>
            <td>{{$conciliacion->usuario}}</td>
            <td>{{$conciliacion->fecha_hora_registro }}</td>
            <td>
                <a href="{{route('conciliaciones.edit', $conciliacion)}}" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>
            </td>
            <td>
                {!! Form::open(['route' => ['conciliaciones.destroy', $conciliacion]]) !!}
                @if($conciliacion->estado == -1 || $conciliacion->estado == -2)
                    <button disabled class="btn btn-danger btn-xs "><span class="glyphicon glyphicon-remove"></span></button>
                @else
                    <button class="btn btn-danger btn-xs cancelar_conciliacion"><span class="glyphicon glyphicon-remove"></span></button>
                @endif
                {!! Form::close() !!}
            </td>
        </tr>
      @endforeach
    </tbody>
  </table>
    <div class="text-center">
        {!! $conciliaciones->appends(['buscar' => Request::get('buscar')])->render() !!}
    </div>
</div>
@stop