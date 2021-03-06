<?php
/**
 * Created by PhpStorm.
 * User: JFEsquivel
 * Date: 05/04/2017
 * Time: 01:21 PM
 */

namespace App\Models\Transformers;

use Themsaid\Transformers\AbstractTransformer;
use Illuminate\Database\Eloquent\Model;

class ViajeNetoCorteTransformer extends AbstractTransformer
{
    public function transformModel(Model $viaje_neto) {

        $result =  [
            'id'                => $viaje_neto->IdViajeNeto,
            'camion'            => (String) $viaje_neto->camion,
            'codigo'            => $viaje_neto->Code,
            'cubicacion'        => $viaje_neto->CubicacionCamion,
            'estado'            => $viaje_neto->estado,
            'estatus'           => $viaje_neto->Estatus,
            'id_material'       => $viaje_neto->IdMaterial,
            'id_origen'         => $viaje_neto->IdOrigen,
            'id_tiro'           => $viaje_neto->IdTiro,
            'material'          => (String) $viaje_neto->material,
            'origen'            => (String) $viaje_neto->origen,
            'registro'          => $viaje_neto->registro,
            'registro_primer_toque' => $viaje_neto->registro_primer_toque,
            'timestamp_llegada' => $viaje_neto->FechaLlegada.' ('.$viaje_neto->HoraLlegada.')',
            'tipo'              => $viaje_neto->tipo,
            'tiro'              => (String) $viaje_neto->tiro,
            'importe'           => $viaje_neto->getImporte(),
            'corte_cambio'      => $viaje_neto->corte_cambio ? CorteCambioTransformer::transform($viaje_neto->corte_cambio) : null,
            'confirmed'         => $viaje_neto->corte_detalle->estatus == 2,
        ];

        return $result;

    }
}
