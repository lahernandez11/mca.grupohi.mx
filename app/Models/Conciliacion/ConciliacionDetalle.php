<?php

namespace App\Models\Conciliacion;

use App\Models\Viaje;
use Illuminate\Database\Eloquent\Model;

class ConciliacionDetalle extends Model
{
    protected $connection = 'sca';
    protected $table = 'conciliacion_detalle';
    protected $primaryKey = 'idconciliacion_detalle';

    public $timestamps = false;

    protected $fillable = [
        'idconciliacion',
        'idviaje',
        'timestamp',
        'estado'
    ];

    public function viaje() {
        return $this->belongsTo(Viaje::class, 'idviaje');
    }
}