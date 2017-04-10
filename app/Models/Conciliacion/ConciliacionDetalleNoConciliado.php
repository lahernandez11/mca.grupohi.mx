<?php

namespace App\Models\Conciliacion;

use App\Models\Material;
use App\Models\Viaje;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use App\Models\ViajeNeto;

class ConciliacionDetalleNoConciliado extends Model
{
    protected $connection = 'sca';
    protected $table = 'conciliacion_detalle_no_conciliado';

    public $timestamps = false;

    protected $fillable = [
        'idconciliacion',
        'idmotivo',
        'idviaje_neto',
        'idviaje',
        'Code',
        'detalle',
        'timestamp',
        'estado',
    ];

    public function viaje() {
        return $this->belongsTo(Viaje::class, 'idviaje');
    }
    public function viaje_neto() {
        return $this->belongsTo(ViajeNeto::class,'IdViajeNeto', 'idviaje_neto');
    }
    public function conciliacion() {
        return $this->belongsTo(Conciliacion::class, 'idconciliacion');
    }
    
    public function save(array $options = array()) {
        if($this->conciliacion->estado != 0 && $this->estado != -1 ){
            throw new \Exception("No se pueden relacionar más viajes fallidos a la conciliación.");
        }else{
            $preexistente = $this->conciliacion->ConciliacionDetallesNoConciliados->where('idmotivo',$this->idmotivo)
                    ->where('Code', $this->Code)
                    ->where('idviaje_neto', $this->idviaje_neto)
                    ->first();
            if(!$preexistente){
                parent::save($options);
            }
        }
    }
   
}