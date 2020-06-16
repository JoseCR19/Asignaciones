<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class Elemento extends Model {

    public $timestamps = false;
    protected $table = 'elemento';
    protected $primaryKey = 'intIdEleme';
    protected $fillable = [
        'intIdProy',
        'intIdTipoProducto',
        'intIdProyZona',
        'intIdProyTarea',
        'intIdProyPaquete',
        'intIdTipoEstru',
        'intIdEsta',
        'varCodiElemento',
        'intSerie',
        'intRevision',
        'deciLong',
        'varPerfil',
        'varDescripcion',
        'deciPesoNeto',
        'deciPesoBruto',
        'deciPesoContr',
        'deciArea',
        'deciAncho',
        'deciAlto',
        'varModelo',
        'varCodVal',
        'varValo1',
        'varValo2',
        'varValo3',
        'varValo4',
        'varValo5',
        'nume_guia',
        'acti_usua',
        'acti_hora',
        'usua_modi',
        'hora_modi',
        'intIdRuta',
        'intCantiTotal',
        'intCantiComp',
        'intSaldo',
        'varCodiElementoPadre',
        'IdContraAnt',
        'FechaUltimAvan',
        'varDocAnt',
        'numDocTratSup',
        'intCantiTotal',
        'intCantiComp',
        'intSaldo',
        'varCodiElementoPadre',
        'intIdDespacho',
        'varBulto',
        'varGuia',
        'varUnidMedi'
    ];

}
