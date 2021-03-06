<?php

//Catalogos->Materiales

Breadcrumbs::register('materiales.index', function($breadcrumbs){
    $breadcrumbs->push('MATERIALES', route('materiales.index'));
});

Breadcrumbs::register('materiales.show', function($breadcrumbs, $material){
    $breadcrumbs->parent('materiales.index');
    $breadcrumbs->push(strtoupper($material->Descripcion), route('materiales.show', $material));
});

Breadcrumbs::register('materiales.create', function($breadcrumbs){
    $breadcrumbs->parent('materiales.index');
    $breadcrumbs->push('NUEVO MATERIAL', route('materiales.create'));
});

Breadcrumbs::register('materiales.edit', function($breadcrumbs, $material){
    $breadcrumbs->parent('materiales.show', $material);
    $breadcrumbs->push('EDITAR', route('materiales.edit', $material));
});

//Catalogos->Marcas

Breadcrumbs::register('marcas.index', function($breadcrumbs){
    $breadcrumbs->push('MARCAS', route('marcas.index'));
});

Breadcrumbs::register('marcas.show', function($breadcrumbs, $marca){
    $breadcrumbs->parent('marcas.index');
    $breadcrumbs->push(strtoupper($marca->Descripcion), route('marcas.show', $marca));
});

Breadcrumbs::register('marcas.create', function($breadcrumbs){
    $breadcrumbs->parent('marcas.index');
    $breadcrumbs->push('NUEVA MARCA', route('marcas.create'));
});

Breadcrumbs::register('marcas.edit', function($breadcrumbs, $marca){
    $breadcrumbs->parent('marcas.show', $marca);
    $breadcrumbs->push('EDITAR', route('marcas.edit', $marca));
});

//Catalogos->Sindicatos

Breadcrumbs::register('sindicatos.index', function($breadcrumbs){
    $breadcrumbs->push('SINDICATOS', route('sindicatos.index'));
});

Breadcrumbs::register('sindicatos.show', function($breadcrumbs, $sindicato){
    $breadcrumbs->parent('sindicatos.index');
    $breadcrumbs->push(strtoupper($sindicato->NombreCorto), route('sindicatos.show', $sindicato));
});

Breadcrumbs::register('sindicatos.create', function($breadcrumbs){
    $breadcrumbs->parent('sindicatos.index');
    $breadcrumbs->push('NUEVO SINDICATO', route('sindicatos.create'));
});

Breadcrumbs::register('sindicatos.edit', function($breadcrumbs, $sindicato){
    $breadcrumbs->parent('sindicatos.show', $sindicato);
    $breadcrumbs->push('EDITAR', route('sindicatos.edit', $sindicato));
});

//Catalogos->Origenes

Breadcrumbs::register('origenes.index', function($breadcrumbs){
    $breadcrumbs->push('ORIGENES', route('origenes.index'));
});

Breadcrumbs::register('origenes.show', function($breadcrumbs, $origen){
    $breadcrumbs->parent('origenes.index');
    $breadcrumbs->push(strtoupper($origen->Descripcion), route('origenes.show', $origen));
});

Breadcrumbs::register('origenes.create', function($breadcrumbs){
    $breadcrumbs->parent('origenes.index');
    $breadcrumbs->push('NUEVO ORIGEN', route('origenes.create'));
});

Breadcrumbs::register('origenes.edit', function($breadcrumbs, $origen){
    $breadcrumbs->parent('origenes.show', $origen);
    $breadcrumbs->push('EDITAR', route('origenes.edit', $origen));
});

//Catalogos->Tiros

Breadcrumbs::register('tiros.index', function($breadcrumbs){
    $breadcrumbs->push('TIROS', route('tiros.index'));
});

Breadcrumbs::register('tiros.show', function($breadcrumbs, $tiro){
    $breadcrumbs->parent('tiros.index');
    $breadcrumbs->push(strtoupper($tiro->Descripcion), route('tiros.show', $tiro));
});

Breadcrumbs::register('tiros.create', function($breadcrumbs){
    $breadcrumbs->parent('tiros.index');
    $breadcrumbs->push('NUEVO TIRO', route('tiros.create'));
});

Breadcrumbs::register('tiros.edit', function($breadcrumbs, $tiro){
    $breadcrumbs->parent('tiros.show', $tiro);
    $breadcrumbs->push('EDITAR', route('tiros.edit', $tiro));
});

//Catalogos->Rutas

Breadcrumbs::register('rutas.index', function($breadcrumbs){
    $breadcrumbs->push('RUTAS', route('rutas.index'));
});

Breadcrumbs::register('rutas.show', function($breadcrumbs, $ruta){
    $breadcrumbs->parent('rutas.index');
    $breadcrumbs->push(strtoupper($ruta->present()->claveRuta), route('rutas.show', $ruta));
});

Breadcrumbs::register('rutas.create', function($breadcrumbs){
    $breadcrumbs->parent('rutas.index');
    $breadcrumbs->push('NUEVA RUTA', route('rutas.create'));
});

Breadcrumbs::register('rutas.edit', function($breadcrumbs, $ruta){
    $breadcrumbs->parent('rutas.show', $ruta);
    $breadcrumbs->push('EDITAR', route('rutas.edit', $ruta));
});

//Catalogos->Camiones

Breadcrumbs::register('camiones.index', function($breadcrumbs){
    $breadcrumbs->push('CAMIONES', route('camiones.index'));
});

Breadcrumbs::register('camiones.show', function($breadcrumbs, $camion){
    $breadcrumbs->parent('camiones.index');
    $breadcrumbs->push($camion->present()->datosCamion, route('camiones.show', $camion));
});

Breadcrumbs::register('camiones.create', function($breadcrumbs){
    $breadcrumbs->parent('camiones.index');
    $breadcrumbs->push('NUEVO CAMIÓN', route('camiones.create'));
});

Breadcrumbs::register('camiones.edit', function($breadcrumbs, $camion){
    $breadcrumbs->parent('camiones.show', $camion);
    $breadcrumbs->push('EDITAR', route('camiones.edit', $camion));
});

//Catalogos->Tarifas por Material

Breadcrumbs::register('tarifas_material.index', function($breadcrumbs){
    $breadcrumbs->push('TARIFAS POR MATERIAL', route('tarifas_material.index'));
});
Breadcrumbs::register('tarifas_material.create', function($breadcrumbs){
    $breadcrumbs->parent('tarifas_material.index');
    $breadcrumbs->push('NUEVA TARIFA POR MATERIAL', route('tarifas_material.create'));
});

//Catalogos->Tarifas por Peso

Breadcrumbs::register('tarifas_peso.index', function($breadcrumbs){
    $breadcrumbs->push('TARIFAS POR PESO', route('tarifas_peso.index'));
});

//Catalogos->Tarifas por Tipo de Ruta

Breadcrumbs::register('tarifas_tiporuta.index', function($breadcrumbs){
    $breadcrumbs->push('TARIFAS POR TIPO DE RUTA', route('tarifas_tiporuta.index'));
});

//Catalogos->Materiales

Breadcrumbs::register('operadores.index', function($breadcrumbs){
    $breadcrumbs->push('OPERADORES', route('operadores.index'));
});

Breadcrumbs::register('operadores.show', function($breadcrumbs, $operador){
    $breadcrumbs->parent('operadores.index');
    $breadcrumbs->push(strtoupper($operador->Nombre), route('operadores.show', $operador));
});

Breadcrumbs::register('operadores.create', function($breadcrumbs){
    $breadcrumbs->parent('operadores.index');
    $breadcrumbs->push('NUEVO OPERADOR', route('operadores.create'));
});

Breadcrumbs::register('operadores.edit', function($breadcrumbs, $operador){
    $breadcrumbs->parent('operadores.show', $operador);
    $breadcrumbs->push('EDITAR', route('operadores.edit', $operador));
});

//Catálogos->centros_costo

Breadcrumbs::register('centroscostos.index', function($breadcrumbs){
    $breadcrumbs->push('CENTROS DE COSTO', route('centroscostos.index'));
});
Breadcrumbs::register('centroscostos.show', function ($breadcrumbs, $centro) {
    $breadcrumbs->parent('centroscostos.index');
    $breadcrumbs->push($centro->IdCentroCosto, route('centroscostos.show', $centro));
});

//Origenes por Usuario
Breadcrumbs::register('origenes_usuarios.index', function($breadcrumbs){
    $breadcrumbs->push('ORIGENES POR USUARIO', route('origenes_usuarios.index'));
});

//Empresas
Breadcrumbs::register('empresas.index', function($breadcrumbs){
    $breadcrumbs->push('EMPRESAS', route('empresas.index'));
});

Breadcrumbs::register('empresas.show', function($breadcrumbs, $empresa){
    $breadcrumbs->parent('empresas.index');
    $breadcrumbs->push(strtoupper($empresa->razonSocial), route('empresas.show', $empresa));
});

Breadcrumbs::register('empresas.create', function($breadcrumbs){
    $breadcrumbs->parent('empresas.index');
    $breadcrumbs->push('NUEVA EMPRESA', route('empresas.create'));
});

Breadcrumbs::register('empresas.edit', function($breadcrumbs, $empresa){
    $breadcrumbs->parent('empresas.show', $empresa);
    $breadcrumbs->push('EDITAR', route('empresas.edit', $empresa));
});

//Factores de Abundamiento
Breadcrumbs::register('fda_banco_material.index', function($breadcrumbs) {
    $breadcrumbs->push('BANCO - MATERIAL', route('fda_banco_material.index'));
});

Breadcrumbs::register('fda_material.index', function($breadcrumbs) {
    $breadcrumbs->push('MATERIAL', route('fda_material.index'));    
});

//Etapas de Proyecto
Breadcrumbs::register('etapas.index', function($breadcrumbs) {
    $breadcrumbs->push('ETAPAS DE PROYECTO', route('etapas.index'));
});

Breadcrumbs::register('etapas.create', function($breadcrumbs) {
    $breadcrumbs->parent('etapas.index');
    $breadcrumbs->push('NUEVA ETAPA', route('etapas.create'));
});

Breadcrumbs::register('etapas.show', function($breadcrumbs, $etapa) {
    $breadcrumbs->parent('etapas.index');
    $breadcrumbs->push(strtoupper($etapa->Descripcion), route('etapas.show', $etapa));
});

Breadcrumbs::register('etapas.edit', function($breadcrumbs, $etapa) {
    $breadcrumbs->parent('etapas.show', $etapa);
    $breadcrumbs->push('EDITAR', route('etapas.edit', $etapa));
});

//ViajesNetos
Breadcrumbs::register('viajes_netos.index', function ($breadcrumbs) {
    $breadcrumbs->push('VIAJES', route('viajes_netos.index'));
});

Breadcrumbs::register('viajes_netos.carga_manual', function($breadcrumbs) {
    $breadcrumbs->parent('viajes_netos.index');
    $breadcrumbs->push('REGISTRO MANUAL DE VIAJES', route('viajes_netos.create', ['action' => 'create']));
});

Breadcrumbs::register('viajes_netos.carga_manual_completa', function($breadcrumbs) {
    $breadcrumbs->push('CARGA MANUAL COMPLETA', route('viajes_netos.create', ['action' => 'completa']));
});

Breadcrumbs::register('viajes_netos.autorizar', function($breadcrumbs) {
    $breadcrumbs->push('AUTORIZACIÓN DE VIAJES', route('viajes_netos.edit', ['action' => 'autorizar']));
});

Breadcrumbs::register('viajes_netos.validar', function($breadcrumbs) {
    $breadcrumbs->push('VALIDAR VIAJES', route('viajes_netos.edit', ['action' => 'validar']));
});

Breadcrumbs::register('viajes_netos.modificar', function($breadcrumbs) {
    $breadcrumbs->push('MODIFICAR VIAJES', route('viajes_netos.edit', ['action' => 'modificar']));
});

//Conciliaciones

Breadcrumbs::register('conciliaciones.index', function($breadcrumbs) {
    $breadcrumbs->push('CONCILIACIONES', route('conciliaciones.index'));
});

Breadcrumbs::register('conciliaciones.show', function($breadcrumbs, $conciliacion) {
    $breadcrumbs->parent('conciliaciones.index');
    $breadcrumbs->push($conciliacion->idconciliacion, route('conciliaciones.show', $conciliacion));
});

Breadcrumbs::register('conciliaciones.create', function($breadcrumbs) {
    $breadcrumbs->parent('conciliaciones.index');
    $breadcrumbs->push('NUEVA CONCILIACIÓN', route('conciliaciones.create'));
});

Breadcrumbs::register('conciliaciones.edit', function($breadcrumbs, $conciliacion) {
    $breadcrumbs->parent('conciliaciones.show', $conciliacion);
    $breadcrumbs->push('EDITAR CONCILIACIÓN', route('conciliaciones.edit', $conciliacion));
});

Breadcrumbs::register('viajes.revertir', function($breadcrumbs) {
    $breadcrumbs->push('REVERTIR VIAJES', route('viajes.edit', ['action' => 'revertir']));
});

//Reportes
Breadcrumbs::register('reportes.viajes_netos', function($breadcrumbs) {
    $breadcrumbs->push('VIAJES NETOS', route('reportes.viajes_netos.create'));
});
Breadcrumbs::register('reportes.inicio_viajes', function($breadcrumbs) {
    $breadcrumbs->push('INICIO VIAJES', route('reportes.inicio_viajes.create'));
});
Breadcrumbs::register('reportes.conciliacion_detalle', function($breadcrumbs) {
    $breadcrumbs->push('CONCILIACIÓN DETALLE', route('reportes.conciliacion_detalle.create'));
});


//Corte de Checador
Breadcrumbs::register('corte.index', function($breadcrumbs) {
    $breadcrumbs->push('CORTES DE CHECADOR', route('corte.index'));
});

Breadcrumbs::register('corte.create', function($breadcrumbs) {
    $breadcrumbs->parent('corte.index');
    $breadcrumbs->push('CORTE DEL DÍA', route('corte.create'));
});

Breadcrumbs::register('corte.show', function ($breadcrumbs, $corte) {
    $breadcrumbs->parent('corte.index');
    $breadcrumbs->push("CORTE {$corte->id}", route('corte.show', $corte));
});

Breadcrumbs::register('corte.edit', function ($breadcrumbs, $corte) {
    $breadcrumbs->parent('corte.show', $corte);
    $breadcrumbs->push("MODIFICAR CORTE", route('corte.edit', $corte));
});

//Configuración diaria
Breadcrumbs::register('configuracion-diaria.index', function ($breadcrumbs) {
    $breadcrumbs->push("CONFIGURACIÓN DE CHECADORES");
});



//Catálogos->Teléfonos
Breadcrumbs::register('telefonos.index', function ($breadcrumbs) {
    $breadcrumbs->push('LISTA DE TELÉFONOS', route('telefonos.index'));
});

Breadcrumbs::register('telefonos.show', function ($breadcrumbs, $telefono) {
    $breadcrumbs->parent('telefonos.index');
    $breadcrumbs->push($telefono->imei, route('telefonos.show', $telefono));
});

Breadcrumbs::register('telefonos.edit', function ($breadcrumbs, $telefono) {
    $breadcrumbs->parent('telefonos.show', $telefono);
    $breadcrumbs->push('EDITAR', route('telefonos.edit', $telefono));
});

Breadcrumbs::register('telefonos.create', function ($breadcrumbs) {
    $breadcrumbs->parent('telefonos.index');
    $breadcrumbs->push('NUEVO TELÉFONO', route('telefonos.create'));
});


//Catalogos->Impresoras
Breadcrumbs::register('impresoras.index', function($breadcrumbs){
    $breadcrumbs->push('LISTA DE IMPRESORAS', route('impresoras.index'));
});
Breadcrumbs::register('impresoras.create', function($breadcrumbs){
    $breadcrumbs->parent('impresoras.index');
    $breadcrumbs->push('NUEVA IMPRESORA', route('impresoras.create'));
});
Breadcrumbs::register('impresoras.show', function($breadcrumbs, $impresora){
    $breadcrumbs->parent('impresoras.index');
    $breadcrumbs->push($impresora->id, route('impresoras.show', $impresora));
});
Breadcrumbs::register('impresoras.edit', function($breadcrumbs, $impresora){
    $breadcrumbs->parent('impresoras.show',$impresora);
    $breadcrumbs->push('EDITAR', route('impresoras.edit', $impresora));
});

//Configuración diaria->Teléfonos e Impresoras

Breadcrumbs::register('telefonos-impresoras.index', function($breadcrumbs){
    $breadcrumbs->push('CONFIGURACIÓN TELEFONOS - IMPRESORAS', route('telefonos-impresoras.index'));
});
Breadcrumbs::register('telefonos-impresoras.create', function($breadcrumbs){
    $breadcrumbs->parent('telefonos-impresoras.index');
    $breadcrumbs->push('NUEVA CONFIGURACIÓN', route('telefonos-impresoras.create'));
});
Breadcrumbs::register('telefonos-impresoras.show', function($breadcrumbs, $telefono){
    $breadcrumbs->parent('telefonos-impresoras.index');
    $breadcrumbs->push($telefono->id, route('telefonos-impresoras.show', $telefono));
});

Breadcrumbs::register('telefonos-impresoras.edit', function($breadcrumbs, $telefono){
    $breadcrumbs->parent('telefonos-impresoras.show',$telefono);
    $breadcrumbs->push('EDITAR', route('telefonos-impresoras.edit', $telefono));
});


//Usuarios Proyectos
Breadcrumbs::register('usuario_proyecto.index', function ($breadcrumbs) {
    $breadcrumbs->push('LISTA DE USUARIOS', route('usuario_proyecto.index'));
});

Breadcrumbs::register('usuario_proyecto.show', function ($breadcrumbs, $usuario) {
    $breadcrumbs->parent('usuario_proyecto.index');
    $breadcrumbs->push($usuario, route('usuario_proyecto.show', $usuario));
});

Breadcrumbs::register('usuario_proyecto.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('usuario_proyecto.index');
    $breadcrumbs->push('EDITAR USUARIO', route('usuario_proyecto.edit'));
});


Breadcrumbs::register('usuario_proyecto.create', function ($breadcrumbs) {
    $breadcrumbs->parent('usuario_proyecto.index');
    $breadcrumbs->push('NUEVO USUARIO', route('usuario_proyecto.create'));
});    
Breadcrumbs::register('solicitud-reactivacion.index', function($breadcrumbs) {
    $breadcrumbs->push('LISTA DE SOLICITUDES', route('solicitud-reactivacion.index'));
});

Breadcrumbs::register('solicitud-reactivacion.show', function ($breadcrumbs, $solicitud) {
    $breadcrumbs->parent('solicitud-reactivacion.index');
    $breadcrumbs->push($solicitud->Economico, route('solicitud-reactivacion.show', $solicitud));
});

Breadcrumbs::register('solicitud-actualizacion.index', function($breadcrumbs) {
    $breadcrumbs->push('LISTA DE SOLICITUDES', route('solicitud-actualizacion.index'));
});

Breadcrumbs::register('solicitud-actualizacion.show', function ($breadcrumbs, $solicitud) {
    $breadcrumbs->parent('solicitud-actualizacion.index');
    $breadcrumbs->push($solicitud->Economico, route('solicitud-actualizacion.show', $solicitud));
});
