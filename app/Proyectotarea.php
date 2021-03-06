<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class Proyectotarea extends Model 
{
    

    public $timestamps = false;

   protected $table = 'proyecto_tarea';
   protected $primaryKey = 'intIdProyTarea';
   protected $fillable = [
      'intIdProyZona',
      'intIdProy',
      'intIdTipoProducto',
      'varDescripTarea',
      'acti_usua',
      'acti_hora',
  
  ];
}
