<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Presenters\ModelPresenter;

class Ruta extends Model
{
    use \Laracasts\Presenter\PresentableTrait;
    
    protected $connection = 'sca';
    protected $table = 'rutas';
    protected $primaryKey = 'IdRuta';
    protected $fillable = [
        'IdProyecto', 
        'IdTipoRuta', 
        'IdOrigen', 
        'IdTiro', 
        'PrimerKm', 
        'KmSubsecuentes', 
        'KmAdicionales', 
        'TotalKM', 
        'FechaAlta', 
        'Registra', 
        'HoraAlta'
        ];
    protected $presenter = ModelPresenter::class;
    
    public $timestamps = false;
    
    public function proyectoLocal() {
        return $this->belongsTo(ProyectoLocal::class, 'IdProyecto');
    }
    
    public function tipoRuta() {
        return $this->belongsTo(TipoRuta::class, 'IdTipoRuta');
    }
    
    public function origen() {
        return $this->belongsTo(Origen::class, 'IdOrigen');
    }
    
    public function tiro() {
        return $this->belongsTo(Tiro::class, 'IdTiro');
    }
    
    public function user() {
        return $this->belongsTo(\App\User::class, 'Registra');
    }
    
    public function cronometria() {
        return $this->hasOne(Cronometria::class, 'IdRuta');
    }
    
    public function archivo() {
        return $this->hasOne(ArchivoRuta::class, 'IdRuta');
    }
}