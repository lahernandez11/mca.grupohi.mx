<?php

namespace App\Models;

use App\Models\Conciliacion\Conciliacion;
use App\Models\Conciliacion\ConciliacionDetalle;
use DaveJamesMiller\Breadcrumbs\Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Viaje extends Model
{
    protected $connection = 'sca';
    protected $table = 'viajes';
    protected $primaryKey = 'IdViaje';
    public $timestamps = false;

    public function conciliacionDetalles() {
        return $this->hasMany(ConciliacionDetalle::class, 'idviaje','IdViaje');
    }

    public function camion() {
        return $this->belongsTo(Camion::class, 'IdCamion');
    }

    public function origen() {
        return $this->belongsTo(Origen::class, 'IdOrigen');
    }

    public function tiro() {
        return $this->belongsTo(Tiro::class, 'IdTiro');
    }

    public function scopePorConciliar($query) {
        return $query->leftJoin('conciliacion_detalle', 'viajes.IdViaje', '=', 'conciliacion_detalle.idviaje')
            ->where(function($query){
                $query->whereNull('conciliacion_detalle.idviaje')
                    ->orWhere('conciliacion_detalle.estado', '=', '-1');
            });
    }

    public function scopeConciliados($query) {
        return $query->leftJoin('conciliacion_detalle', 'viajes.IdViaje', '=', 'conciliacion_detalle.idviaje')
            ->where(function($query){
                $query->whereNotNull('conciliacion_detalle.idviaje')
                    ->orWhere('conciliacion_detalle.estado', '!=', '-1');
            });
    }

    public function material() {
        return $this->belongsTo(Material::class, 'IdMaterial');
    }

    public function disponible() {
        foreach ($this->conciliacionDetalles as $conciliacionDetalle) {
            if ($conciliacionDetalle->estado == 1) {
                return false;
            }
        }
        return true;
    }

    public function cambiarCubicacion(Request $request) {

        DB::connection('sca')->beginTransaction();
        try {

            $conciliacion = Conciliacion::find($request->get('id_conciliacion'));
            if($conciliacion->estado != 0) {
                throw  new \Exception("No se puede cambiar la cubicación del viaje debido al estdo de la conciliación (" . $this->conciliacionDetalles->where('estado', 1)->first()->conciliacion->estado_str . ")");
            }

            DB::connection('sca')->table('cambio_cubicacion')->insertGetId([
                'IdViaje'      => $this->IdViaje,
                'IdViajeNeto'      => $this->IdViajeNeto,
                'VolumenViejo' => $this->CubicacionCamion,
                'VolumenNuevo' => $request->get('cubicacion'),
                'FechaRegistro' => Carbon::now()
            ]);

            $this->CubicacionCamion = $request->get('cubicacion');
            $viaje_neto = $this->viajeNeto;
            $viaje_neto->CubicacionCamion = $request->get('cubicacion');
            $viaje_neto->save();
            $this->save();

            DB::connection("sca")->statement("call calcular_Volumen_Importe(".$this->IdViajeNeto.");");
            DB::connection('sca')->commit();

            return true;

        } catch (\Exception $e) {
            DB::connection('sca')->rollback();
            throw $e;
        }

    }

    public function viajeNeto() {
        return $this->belongsTo(ViajeNeto::class, 'IdViajeNeto');
    }

    public static function scopeParaRevertir() {
        return DB::connection('sca')->table('viajes')
            ->leftJoin('tiros', 'viajes.IdTiro', '=', 'tiros.IdTiro')
            ->leftJoin('camiones', 'viajes.IdCamion', '=', 'camiones.IdCamion')
            ->leftJoin('origenes', 'viajes.IdOrigen', '=', 'origenes.IdOrigen')
            ->leftJoin('materiales', 'viajes.IdMaterial', '=', 'materiales.IdMaterial')
            ->select(
                "viajes.*",
                "tiros.Descripcion as Tiro",
                "camiones.Economico as Camion",
                "viajes.CubicacionCamion as Cubicacion",
                "origenes.Descripcion as Origen",
                "materiales.Descripcion as Material",
                "viajes.code as Codigo"
            )
            ->whereIn('viajes.Estatus', [0,10,20]);
    }
    public static function scopeParaRevertirPeriodo($tipo,$inicial, $final, $codigo)
    {
        if($tipo == 0){
            $dato = "and viajes.FechaLlegada between '{$inicial}' and '{$final}'";
        }else if($tipo == 1){
            $dato ="and viajes.code ='{$codigo}'";
        }
        $sql = "SELECT viajes.*, tiros.Descripcion AS Tiro,
                camiones.Economico AS Camion,
                viajes.CubicacionCamion AS Cubicacion,
                origenes.Descripcion AS Origen,
                materiales.Descripcion AS Material,
                viajes.code AS Codigo,
                c.anio as anio,
                c.mes as mes
                from viajes
                left join tiros on viajes.IdTiro = tiros.IdTiro
                left join camiones on viajes.IdCamion = camiones.IdCamion
                left join origenes on viajes.IdOrigen = origenes.IdOrigen
                left join materiales on viajes.IdMaterial = materiales.IdMaterial
                left join cierres_periodo as c on c.mes = DATE_FORMAT(viajes.FechaLlegada, '%m') and DATE_FORMAT(viajes.FechaLlegada, '%Y')  = c.anio
                where viajes.Estatus in (0, 10, 20)".$dato;

        return DB::connection('sca')->select(DB::raw($sql));


    }

    public function revertir() {
        DB::connection('sca')->beginTransaction();

        try {
            if(count($this->conciliacionDetalles->where('estado', 1))) {
                $conciliacion = $this->conciliacionDetalles->where('estado', 1)->first()->conciliacion;
                throw new \Exception('No se puede revertir el viaje ya que se encuentra relacionado en la conciliación ' . $conciliacion->idconciliacion);
            }
//            if(count($this->conciliacionDetalles->where('estado', -1))) {
//               $this->conciliacionDetalles('estado',-1)->delete();
//            }
            $this->Elimino = auth()->user()->idusuario;
            $this->save();
            $this->delete();

            DB::connection('sca')->commit();
        } catch (Exception $e) {
            DB::connection('sca')->rollback();
            throw $e;
        }
    }
    public function getTipoAttribute(){
        if($this->Estatus>=0 && $this->Estatus<=9){
             return 'Móvil';
        }else{
            return 'Manual';
        }
    }
}
