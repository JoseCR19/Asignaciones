<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class ProyectoAvance extends Model {

    public $timestamps = false;
    protected $table = 'proy_avan';
    protected $primaryKey = 'intIdProyAvan';
    protected $fillable = [
        'intIdProy',
        'intIdTipoProducto',
        'intIdEleme',
        'intIdEtapa',
        'intIdProyZona',
        'intIdProyTarea',
        'intIdProyPaquete',
        'intNuConta',
        'intNuRevis',
        'intIdContr',
        'intIdSuper',
        'intIdPeriValo',
        'intIdMaqui',
        'intIdInspe',
        'deciNuAvanc',
        'deciPesoNetoAcum',
        'deciPesoBrutoAcum',
        'deciArea',
        'deciPrec',
        'varNoValor',
        'intMaxContaEtap',
        'varBulto',
        'fech_avan',
        'obse_avan',
        'acti_usua',
        'acti_hora',
        'usua_modi',
        'hora_modi'
    ];

}
