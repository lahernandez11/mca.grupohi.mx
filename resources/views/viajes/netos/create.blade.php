@extends('layout')

@section('content')
@if($action == 'completa')
@include('viajes.netos.partials.carga_manual_completa')
@elseif($action == 'manual')
@include('viajes.netos.partials.carga_manual')
@endif
@stop