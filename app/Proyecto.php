<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class Proyecto extends Model 
{
    

    public $timestamps = false;

   protected $table = 'proyecto';
   protected $primaryKey = 'intIdProy';
   protected $fillable = [
      'IntAnioProy',
      'varIdTipOT',
      'varCodiOt',
      'varCodiProy',
      'varDescProy',
      'varUbicacionProy',
      'varAlias',
      'varRucClie',
      'dateFechInic',
      'dateFechFina',
      'intIdEsta',
      'acti_usua',
      'acti_hora',
      'usua_modi',
      'hora_modi'
  ];
}
