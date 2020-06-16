<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class Componente extends Model 
{
    
   public $timestamps = false;
   
   protected $table = 'componente';
   protected $primaryKey = 'intIdComponente';
   protected $fillable = [
      'intIdProy',
      'intIdTipoProducto',
      'varCodiElemento',
       'varComponente',
       'intCantidad',
       'varMaterial',
       'varPerfil',
       'deciLong',
       'varDescripcion',
       'deciPesoNeto',
       'deciPesoBruto',
       'deciPesoContr',
       'deciArea',
       
      'acti_usua',
      'acti_hora',
   
   
  ];
}
