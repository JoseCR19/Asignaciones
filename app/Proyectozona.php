<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class Proyectozona extends Model 
{
    

    public $timestamps = false;

   protected $table = 'proyecto_zona';
   protected $primaryKey = 'intIdProyZona';
   protected $fillable = [
      'intIdProy',
      'intIdTipoProducto',
      'varDescrip',
      'acti_usua',
      'acti_hora',
      'usua_modi',
      'hora_modi'
  ];
}
