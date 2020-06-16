<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class tab_despacho extends Model {

    public $timestamps = false;
    protected $table = 'tab_desp';
    protected $primaryKey = 'intIdDesp';
    protected $fillable = [
        'intIdDesp',
        'intIdProy',
        'intIdTipoProducto',
        'deciTotaPesoNeto',
        'deciTotaPesoBruto',
        'deciTotaArea',
        'cantidadtotal',
        'intIdEsta',
        'acti_usua',
        'acti_hora'
    ];

}
