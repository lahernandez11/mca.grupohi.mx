<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Presenters\ModelPresenter;

class Empresa extends Model
{
    use \Laracasts\Presenter\PresentableTrait;
    
    protected $connection = 'sca';
    protected $table = 'empresas';
    protected $primaryKey = 'idEmpresa';
    protected $fillable = [
        'razonSocial',
        'RFC',
        'Estatus'
    ];
    protected $presenter = ModelPresenter::class;
    public $timestamps = false;
    
    public function camiones() {
        return $this->hasMany(Camion::class, 'IdEmpresa');
    }
    
    public function __toString() {
        return $this->razonSocial;
    }

}