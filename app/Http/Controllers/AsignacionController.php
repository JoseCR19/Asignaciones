<?php

namespace App\Http\Controllers;

use App\Proyectozona;
use App\Proyecto;
use App\AsignarEtapa;
use App\Rutaproyecto;
use App\Detalleruta;
use App\Etapa;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AsignacionController extends Controller {

    use \App\Traits\ApiResponser;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    /**
     * @OA\Info(title="Asignaciones", version="1",
     * @OA\Contact(
     *     email="antony.rodriguez@mimco.com.pe"
     *   )
     * )
     */

    /**
     * @OA\Post(
     *     path="/Asignaciones/public/index.php/vali_OT",
     *     tags={"Asignacion"},
     *     summary="obtiene datos del usuario a través del dni",
     *     @OA\Parameter(
     *         description="Ingresar la OT",
     *         in="path",
     *         name="varCodiProy",
     *            example="19-0071PI",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
     *        
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="Exitoso varCodiProy",
     *                     type="string"
     *                 ) ,
     *                 example={"varCodiProy": "19-0071PI"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sin Mensaje"
     *     ),
     *     @OA\Response(
     *         response=203,
     *         description="Error."
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No se encuentra el metodo"
     *     )
     * )
     */
    //validamos  la ot que el usuario ingresa 
    public function vali_OT(Request $request) {

        $regla = [
            'varCodiProy' => 'required|max:255',
        ];
        $this->validate($request, $regla);


        $vali_PrOt = Proyecto::where('varCodiProy', $request->input('varCodiProy'))->first(['intIdProy', 'varCodiProy']);
        if ($vali_PrOt['varCodiProy'] == ($request->input('varCodiProy'))) {
            $mensaje = [
                'mensaje' => "Exitoso",
                'id' => $vali_PrOt['intIdProy']
            ];
            return $this->successResponse($mensaje);
        } else {
            $mensaje = [
                'mensaje' => "Error."
            ];
            return $this->successResponse($mensaje);
        }
        //return $this->successResponse($vali_PrOt);
    }

    // Final validar OT




    /**
     * @OA\Post(
     *     path="/Asignaciones/public/index.php/obte_tipo_prod",
     *     tags={"Asignacion"},
     *     summary="obtiene datos del usuario a través del dni",
     *     @OA\Parameter(
     *         description="Ingrese el codigo del proyecto",
     *         in="path",
     *         name="varCodiProy",
     *          example="19-0071PI",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
     *        
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="varCodiProy",
     *                     type="string"
     *                 ) ,
     *                 example={"varCodiProy": "19-0071PI"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="CODIGO OT  NO EXISTE"
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="CODIGO OT NO CUENTA CON PRODUCTOS ASOCIADOS."
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No se encuentra el metodo"
     *     )
     * )
     */

    /** la funcion empieza  cuando el usuario ingresa el numero OT :  obtenemos intIdTipoProducto , varDescTipoProd  y idProy
     * Modulo Partlist (Falta documentarlo)
     */
    public function obte_tipo_prod(Request $request) {
        $regla = [
            'varCodiProy' => 'required|max:255'
        ];
        $this->validate($request, $regla);

        $vali_proy = Proyecto::where('varCodiProy', $request->input('varCodiProy'))->first(['intIdProy']);
        //dd($vali_proy['intIdProy']);
        if (!isset($vali_proy)) {
            $mensaje = [
                'mensaje' => "CODIGO OT " . $request->input('varCodiProy') . " NO EXISTE"
            ];
            return $this->successResponse($mensaje);
        } else {

            $vali_zona = Proyectozona::where('intIdProy', $vali_proy['intIdProy'])->first(['intIdProy']);

            if (!isset($vali_zona)) {
                $mensaje = [
                    'mensaje' => "CODIGO OT " . $request->input('varCodiProy') . " NO CUENTA CON PRODUCTOS ASOCIADOS."
                ];
                return $this->successResponse($mensaje);
            } else {
                $obte_tipo_pro = DB::table('proyecto_zona')
                        ->join('tipo_producto', 'proyecto_zona.intIdTipoProducto', '=', 'tipo_producto.intIdTipoProducto')
                        ->where('proyecto_zona.intIdProy', $vali_proy["intIdProy"])
                        ->select('proyecto_zona.intIdTipoProducto', 'tipo_producto.varDescTipoProd', 'proyecto_zona.intIdProy')
                        ->groupBy('proyecto_zona.intIdTipoProducto', 'tipo_producto.varDescTipoProd', 'proyecto_zona.intIdProy')
                        ->get();
                return $this->successResponse($obte_tipo_pro);
            }
        }
    }

    /* fin del modulo parlist obtener intIdTipoProducto , varDescTipoProd  y idProy */

    /**
     * @OA\Post(
     *     path="/Asignaciones/public/index.php/mostr_asig_etap",
     *     tags={"Asignacion"},
     *     summary="Mostrar la etapa en la asignacion",
     *     @OA\Parameter(
     *         description="Ingrese el ID del proyecto",
     *         in="path",
     *         name="intIdProy",
     *          example="126",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
     * 
     *     @OA\Parameter(
     *         description="Ingrese el ID del tipo producto",
     *         in="path",
     *         name="intIdTipoProducto",
     *          example="1",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
     *        
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="intIdProy",
     *                     type="string"
     *                 ) ,
     *                     @OA\Property(
     *                     property="intIdTipoProducto",
     *                     type="string"
     *                 ) ,  
     *                 example={"intIdProy":"126","intIdTipoProducto": "1"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="MUESTRA LAS ASIGNACIONES DE LAS ETAPA"
     *     ),

     *     @OA\Response(
     *         response=404,
     *         description="No se encuentra el metodo"
     *     )
     * )
     */
    // Mostrar la etapa en la asignacion   http://localhost/Asignaciones/public/index.php/mostr_asig_etap 
    public function mostr_asig_etap(Request $request) {
        $regla = [
            'intIdProy' => 'required|max:255',
            'intIdTipoProducto' => 'required|max:255'
        ];
        $this->validate($request, $regla);
        $intIdTipoProducto = $request->input('intIdTipoProducto');
        $codigo_id_ot = Proyecto::where('varCodiOt', '=', $request->input('intIdProy'))
                ->first(['intIdProy']);

        //todas las etapas asignadas a un proyecto
        // die($codigo_id_ot);
        $vali_asig_etapa = AsignarEtapa::where('intIdProy', '=', $codigo_id_ot['intIdProy'])
                        ->where('intIdTipoProducto', $request->input('intIdTipoProducto'))->get(['intIdEtapa']);

        //die("".$vali_asig_etapa);  
        $query = "";
        $cont_condi = count($vali_asig_etapa);

        // SI LA VALIDACION ES MAYOR A CERO ENTONCES , SE REALIZA UN FOR CON LA CANTIDAD DE ID QUE SE HAN ENCONTRADO
        if ($cont_condi > 0) {
            for ($i = 0; $i < count($vali_asig_etapa); $i++) {


                $query .= " and  etapa.intIdEtapa !=" . $vali_asig_etapa[$i]['intIdEtapa'];
            }
        }

        $result = DB::select("SELECT etapa.intIdEtapa,
                                                etapa.varDescEtap,
                                                 etapa.intIdPlan,
                                                 planta.varDescPlanta
                                                  FROM etapa INNER JOIN planta ON etapa.intIdPlan = planta.intIdPlanta 
                                                    where etapa.varEstaEtap = 'ACT' and etapa.intIdTipoProducto='$intIdTipoProducto'  " . $query);

        return $this->successResponse($result);
    }

    // Final Mostrar la etapa en la asignacion

    /**
     * @OA\Post(
     *     path="/Asignaciones/public/index.php/asig_etap_proy",
     *     tags={"Asignacion"},
     *     summary="Obtener los asignar etapa",
     *     @OA\Parameter(
     *         description="Ingrese el ID del proyecto",
     *         in="path",
     *         name="varCodiProy",
     *          example="19-0071PI",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
     * 
     *     @OA\Parameter(
     *         description="Ingrese el ID del tipo producto",
     *         in="path",
     *         name="intIdTipoProducto",
     *          example="1",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
     *        
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="varCodiProy",
     *                     type="string"
     *                 ) ,
     *                     @OA\Property(
     *                     property="intIdTipoProducto",
     *                     type="string"
     *                 ) ,  
     *                 example={"varCodiProy":"19-0071PI","intIdTipoProducto": "1"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OBTENER LOS  ASIGNAR ETAPA "
     *     ),

     *     @OA\Response(
     *         response=404,
     *         description="No se encuentra el metodo"
     *     )
     * )
     */
    //OBTENER LOS  ASIGNAR ETAPA  
    public function asig_etap_proy(Request $request) {
        $regla = [
            'varCodiProy' => 'required|max:255',
            'intIdTipoProducto' => 'required|max:255'
        ];
        $this->validate($request, $regla);

        $vali_proy = Proyecto::where('varCodiProy', $request->input('varCodiProy'))->first(['intIdProy']);

        if (!isset($vali_proy)) {
            $mensaje = [
                'mensaje' => "No existe la OT: " . $request->input('varCodiProy')
            ];
            return $this->successResponse($mensaje);
        } else {

            $list_todo = DB::table('asig_etap_proy')->join('etapa', 'etapa.intIdEtapa', '=', 'asig_etap_proy.intIdEtapa') // junto las tablas etapa y asig_etap_proy
                            ->join('planta', 'planta.intIdPlanta', '=', 'etapa.intIdPlan') //junto las tablas planta y etapa
                            ->join('proyecto', 'proyecto.intIdProy', '=', 'asig_etap_proy.intIdProy') //junto las tablas proyecto y  asig_etap_proy
                            ->where('proyecto.varCodiProy', $request->input('varCodiProy'))
                            ->where('asig_etap_proy.intIdTipoProducto', $request->input('intIdTipoProducto'))
                            ->select(
                                    'asig_etap_proy.intIdAsigEtapProy', 'asig_etap_proy.intOrden', 'asig_etap_proy.intIdEtapa', 'etapa.varDescEtap', 'etapa.intIdPlan', 'planta.varDescPlanta'
                            )
                            ->orderBy('asig_etap_proy.intOrden', 'ASC')->get();

            if (count($list_todo) == 0) {
                $mensaje = [
                    'mensaje' => "No existe"
                ];
                return $this->successResponse($mensaje);
            } else {
                //  die("adas".$list_todo);
                return $this->successResponse($list_todo);
            }
        }
    }

    /**
     * @OA\Post(
     *     path="/Asignaciones/public/index.php/regi_asig_etap",
     *     tags={"Asignacion"},
     *     summary="Registrar  el asignar etapa ",
     *     @OA\Parameter(
     *         description="Ingrese el codigo de la OT",
     *         in="path",
     *         name="varCodiOt",
     *          example="0073099",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
     * 
     *     @OA\Parameter(
     *         description="Ingrese el ID del tipo producto",
     *         in="path",
     *         name="intIdTipoProducto",
     *          example="1",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
     *      
     *       @OA\Parameter(
     *         description="Ingrese el id orden",
     *         in="path",
     *         name="intOrden",
     *          example="1",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
     * 
     *          @OA\Parameter(
     *         description="Ingrese el id etapa",
     *         in="path",
     *         name="intIdEtapa",
     *          example="4",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
     * 
     *    *          @OA\Parameter(
     *         description="Ingrese el usuario que va realizar el registrado",
     *         in="path",
     *         name="acti_usua",
     *          example="jose_usaurio",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
     * 
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="varCodiProy",
     *                     type="string"
     *                 ) ,
     *                     @OA\Property(
     *                     property="intIdTipoProducto",
     *                     type="string"
     *                 ) ,  
     *                    @OA\Property(
     *                     property="intOrden",
     *                     type="string"
     *                 ) ,  
     * 
     *                @OA\Property(
     *                     property="intIdEtapa",
     *                     type="string"
     *                 ) , 
     *                     @OA\Property(
     *                     property="acti_usua",
     *                     type="string"
     *                 ) ,   
     *                 example={"varCodiOt":"19-0071PI","intIdTipoProducto": "1","intOrden":"1","intIdEtapa":"4","acti_usua":"usuario"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Registrar  el asignar etapa"
     *     ),

     *     @OA\Response(
     *         response=404,
     *         description="No se encuentra el metodo"
     *     )
     * )
     */
    //Registrar  EL ASIGNAR ETAPA  (Falta algunas modificaciones )  $input = $request->input('intIdProg');
    public function regi_asig_etap(Request $request) {
        $regla = [
            'varCodiOt' => 'required|max:255', //
            'intIdTipoProducto' => 'required|max:255',
            'intOrden' => 'required|max:255',
            'intIdEtapa' => 'required|max:255',
            'acti_usua' => 'required|max:255'
        ];
        $this->validate($request, $regla);

        date_default_timezone_set('America/Lima'); // CDT

        $codigo_id_ot = Proyecto::where('varCodiOt', '=', $request->input('varCodiOt'))
                ->first(['intIdProy']);
        // $input = $request->input('intOrden');

        $agre_asig_etap = AsignarEtapa::create([
                    'intIdProy' => $codigo_id_ot['intIdProy'],
                    'intIdTipoProducto' => $request->input('intIdTipoProducto'),
                    'intIdEtapa' => $request->input('intIdEtapa'),
                    'intOrden' => $request->input('intOrden'),
                    'acti_usua' => $request->input('acti_usua'),
                    'acti_hora' => $current_date = date('Y/m/d H:i:s')
        ]);

        $mensaje = [
            'mensaje' => 'Guardado con exito.'
        ];
        return $this->successResponse($mensaje);
    }

    /**
     * @OA\Post(
     *     path="/Asignaciones/public/index.php/regi_otra_inte",
     *     tags={"Asignacion"},
     *     summary="obtener laotra interfaces  el asignar etapa ",
     *     @OA\Parameter(
     *         description="Ingrese el codigo de la OT",
     *         in="path",
     *         name="varCodiOt",
     *          example="0073099",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
     * 
     *     @OA\Parameter(
     *         description="Ingrese el ID del tipo producto",
     *         in="path",
     *         name="intIdTipoProducto",
     *          example="1",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
     *      
     *      
     * 
     *          @OA\Parameter(
     *         description="Ingrese el id de la etapa",
     *         in="path",
     *         name="intIdEtapa",
     *          example="4",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
     * 
     *    *          @OA\Parameter(
     *         description="Ingrese el usuario que va realizar el registrado",
     *         in="path",
     *         name="acti_usua",
     *          example="jose_usaurio",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
     * 
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="varCodiOt",
     *                     type="string"
     *                 ) ,
     *                     @OA\Property(
     *                     property="intIdTipoProducto",
     *                     type="string"
     *                 ) ,  
     *                    @OA\Property(
     *                     property="intIdEtapa",
     *                     type="string"
     *                 ) ,  
     * 
     *                @OA\Property(
     *                     property="acti_usua",
     *                     type="string"
     *                 ) ,
     *                 example={"varCodiOt":"0073099","intIdTipoProducto": "1","intIdEtapa":"4","acti_usua":"jose_usaurio"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Registrar  el asignar etapa"
     *     ),

     *     @OA\Response(
     *         response=404,
     *         description="No se encuentra el metodo"
     *     )
     * )
     */
    //poner a la otra interface
    public function regi_otra_inte(Request $request) {
        $regla = [
            'varCodiOt' => 'required|max:255', //
            'intIdTipoProducto' => 'required|max:255',
            'intIdEtapa' => 'required|max:255',
            'acti_usua' => 'required|max:255'
        ];
        $this->validate($request, $regla);

        date_default_timezone_set('America/Lima'); // CDT

        $codigo_id_ot = Proyecto::where('varCodiOt', '=', $request->input('varCodiOt'))
                ->first(['intIdProy']);

        $input = $request->input('intIdEtapa');
        //  die("".count($input));
        for ($i = 0; $i < count($input); $i++) {
            $agre_asig_etap = AsignarEtapa::create([
                        'intIdProy' => $codigo_id_ot['intIdProy'],
                        'intIdTipoProducto' => $request->input('intIdTipoProducto'),
                        'intIdEtapa' => $input[$i],
                        'acti_usua' => $request->input('acti_usua'),
                        'acti_hora' => $current_date = date('Y/m/d H:i:s')
            ]);
        }
        $mensaje = [
            'mensaje' => 'Guardado.'
        ];
        return $this->successResponse($mensaje);
    }

    /**
     * @OA\Post(
     *    path="/Asignaciones/public/index.php/actu_asig_etapa",
     *    tags={"Asignacion"},
     *    summary="Actualizar asignacion etapa",
     *     @OA\Parameter(
     *         description="ingrese el id de asignar etapa proyecto",
     *         in="path",
     *         name="intIdAsigEtapProy",
     *          example="100",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
     *     
     *    @OA\Parameter(
     *         description="Ingrese el codigo de la OT",
     *         in="path",
     *         name="varCodiOt",
     *           example="0073099",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
     * @OA\Parameter(
     *         description="Ingrese el id tipo producto",
     *         in="path",
     *         name="intIdTipoProducto",
     *           example="1",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
      @OA\Parameter(
     *         description="Ingrese el id de la orden",
     *         in="path",
     *         name="intOrden",
     *           example="120",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
     * @OA\Parameter(
     *         description="Ingrese el usuario",
     *         in="path",
     *         name="usua_modi",
     *           example="usuario_usuario",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *   ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(
     *                     property="intIdAsigEtapProy",
     *                     type="string"
     *                 ) ,
     *                   @OA\Property(
     *                     property="varCodiOt",
     *                     type="string"
     *                 ) ,
     *                @OA\Property(
     *                     property="intIdTipoProducto",
     *                     type="string"
     *                 ) ,
     *                     @OA\Property(
     *                     property="intOrden",
     *                     type="string"
     *                 ) ,
      @OA\Property(
     *                     property="usua_modi",
     *                     type="string"
     *                 ) ,
     *                 example={"intIdAsigEtapProy": "100","varCodiOt":"0073099","intIdTipoProducto":"1","intOrden":"120","usua_modi":"usuario_usuario"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Actualizar la etapa asignada"
     *     ),
     *     @OA\Response(
     *         response=407,
     *         description="El Documento de identidad ingresado no se encuentra registrado."
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No se encuentra el metodo"
     *     )
     * )
     */
    public function actu_asig_etapa(Request $request) {
        $regla = [
            'intIdAsigEtapProy' => 'required|max:255',
            'varCodiOt' => 'required|max:255',
            'intIdTipoProducto' => 'required|max:255',
            'intOrden' => 'required|max:255',
            'usua_modi' => 'required|max:255'
        ];
        $this->validate($request, $regla);

        date_default_timezone_set('America/Lima'); // CDT

        $codigo_id_ot = Proyecto::where('varCodiOt', '=', $request->input('intIdProy'))
                ->first(['intIdProy']);


        /*
          $sele=AsignarEtapa::where('intIdProy','=',$codigo_id_ot['intIdProy'])
          ->where('intIdTipoProducto',$request->input('intIdTipoProducto'))
          ->where('intIdAsigEtapProy',$request->input('intIdAsigEtapProy'))
          ->first(['intIdProy','intIdTipoProducto','intIdAsigEtapProy','intIdEtapa']);


          if(!isset($sele)){

          $mensaje=[
          'mensaje'=>'Error.No se encuentra registrado'
          ];
          return $this->successResponse($mensaje);

          }else { */

        $actual_asig_etap = AsignarEtapa::where('intIdAsigEtapProy', $request->input('intIdAsigEtapProy'))
                ->update([
            'intOrden' => $request->input('intOrden'),
            'usua_modi' => $request->input('usua_modi'),
            'hora_modi' => $current_date = date('Y/m/d H:i:s')
        ]);

        $mensaje = [
            'mensaje' => 'Actualizacion Satisfactoria.'
        ];
        return $this->successResponse($mensaje);
    }

    /**
     * @OA\Post(
     *     path="/Asignaciones/public/index.php/elim_asig_etap",
     *     tags={"Asignacion"},
     *     summary="Eliminar la asignacion de la etapa",
     *     @OA\Parameter(
     *         description="ingrese el id de asignar proyecto",
     *         in="path",
     *         name="intIdAsigEtapProy",
     *        example="100",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
      @OA\Parameter(
     *         description="ingrese el id del proyecto",
     *         in="path",
     *         name="intIdProy",
     *        example="126",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
      @OA\Parameter(
     *         description="Ingrese el id tipo producto",
     *         in="path",
     *         name="intIdTipoProducto",
     *        example="1020",
     *    
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
     *        
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="intIdAsigEtapProy",
     *                     type="string"
     *                 ) ,
     *                 @OA\Property(
     *                     property="intIdProy",
     *                     type="string"
     *                 ) ,
     *                   @OA\Property(
     *                     property="intIdTipoProducto",
     *                     type="string"
     *                 ) ,
     *                 example={"intIdAsigEtapProy": "100","intIdProy":"126","intIdTipoProducto":"1020"}
     *             )
     *         )
     *     ),
     *  @OA\Response(
     *         response=200,
     *         description="('') quiere decir que asido exitoso."
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="No se puede eliminar. Ya que esta asignado a una ruta"
     *     ),
     *     @OA\Response(
     *         response=407,
     *         description="El Documento de identidad ingresado no se encuentra registrado."
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No se encuentra el metodo"
     *     )
     * )
     */
    public function elim_asig_etap(Request $request) {
        $validar = array('mensaje' => '');
        $regla = [
            'intIdAsigEtapProy' => 'required|max:255',
            'intIdProy' => 'required|max:255',
            'intIdTipoProducto' => 'required|max:255'
        ];
        $this->validate($request, $regla);

        $intIdAsigEtapProy = $request->input('intIdAsigEtapProy');
        $intIdProy = $request->input('intIdProy');
        $intIdTipoProducto = $request->input('intIdTipoProducto');

        $obte_idru = Rutaproyecto::join('deta_ruta', 'deta_ruta.intIdRuta', '=', 'ruta.intIdRuta')
                ->where('ruta.intIdProy', '=', $intIdProy)
                ->where('ruta.intIdTipoProducto', '=', $intIdTipoProducto)
                ->where('deta_ruta.intIdAsigEtapProy', '=', $intIdAsigEtapProy)
                ->first(['deta_ruta.intIdAsigEtapProy']);
        if (isset($obte_idru['intIdAsigEtapProy'])) {
            $validar['mensaje'] = "No se puede eliminar. Ya que esta asignado a una ruta";
            return $this->successResponse($validar);
        } else {
            $elim_asig_etap_proy = AsignarEtapa::where('intIdAsigEtapProy', '=', $intIdAsigEtapProy)
                    ->where('intIdProy', '=', $intIdProy)
                    ->where('intIdTipoProducto', '=', $intIdTipoProducto)
                    ->delete();
            $validar['mensaje'] = "";
            return $this->successResponse($validar);
        }
    }

    /**
     * @OA\Post(
     *     path="/Asignaciones/public/index.php/obte_cont_con_id_etap",
     *     tags={"Asignacion"},
     *     summary="obtener contratista mediante el idEtapa",
     *     @OA\Parameter(
     *         description="Ingrese el id etapa",
     *         in="path",
     *         name="intIdEtapa",
     *          example="5",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
     *        
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="intIdEtapa",
     *                     type="string"
     *                 ) ,
     *                 example={"intIdEtapa": "5"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="lista el contratista que tiene esa etapa"
     *     ),
     *     
     *     @OA\Response(
     *         response=404,
     *         description="No se encuentra el metodo"
     *     )
     * )
     */
    public function obte_cont_con_id_etap(Request $request) {
        $validar = array('mensaje' => '');
        $regla = [
            'intIdEtapa' => 'required|max:255',
        ];
        $this->validate($request, $regla);
        $intIdEtapa = $request->input('intIdEtapa');

        $vali_cont = Etapa::join('tipoetapa', 'tipoetapa.intIdTipoEtap', '=', 'etapa.intIdTipoEtap')
                        ->join('agrupador', 'tipoetapa.intIdAgru', '=', 'agrupador.intIdAgru')
                        ->leftJoin('deta_agru_cont', 'deta_agru_cont.intIdAgru', '=', 'agrupador.intIdAgru')
                        ->join('contratista', 'deta_agru_cont.intIdCont', '=', 'contratista.intIdCont')
                        ->where('etapa.intIdEtapa', '=', $intIdEtapa)->select('contratista.intIdCont', 'contratista.varRazCont')->get();

        return $this->successResponse($vali_cont);
    }

    /**
     * @OA\Post(
     *     path="/Asignaciones/public/index.php/obte_supe_con_id_etap",
     *     tags={"Asignacion"},
     *     summary="obtener colaborador mediante el idEtapa",
     *     @OA\Parameter(
     *         description="Ingrese el id etapa",
     *         in="path",
     *         name="intIdEtapa",
     *          example="5",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
     *        
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="intIdEtapa",
     *                     type="string"
     *                 ) ,
     *                 example={"intIdEtapa": "5"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="lista el colaboradores que tiene esa etapa"
     *     ),
     *     
     *     @OA\Response(
     *         response=404,
     *         description="No se encuentra el metodo"
     *     )
     * )
     */
    public function obte_supe_con_id_etap(Request $request) {
        $validar = array('mensaje' => '');
        $regla = [
            'intIdEtapa' => 'required|max:255',
        ];
        $this->validate($request, $regla);
        $intIdEtapa = $request->input('intIdEtapa');
        $vali_cola = DB::select("select colaborador.intIdColaborador,concat(colaborador.varNombColabo,' ' ,colaborador.varApelColabo) as nombre, usuario.varCodiUsua from  etapa 
                                inner join tipoetapa on etapa.intIdTipoEtap=tipoetapa.intIdTipoEtap
                                inner join agrupador on agrupador.intIdAgru=tipoetapa.intIdAgru
                                inner join deta_agru_supe  on deta_agru_supe.intIdAgru=agrupador.intIdAgru
                                inner join colaborador on deta_agru_supe.intIdColaborador=colaborador.intIdColaborador
                                inner join usuario on usuario.varNumeDni=colaborador.varNumeIden
                                where etapa.intIdEtapa=$intIdEtapa order by colaborador.varApelColabo asc");
        /*$vali_cola = Etapa::join('tipoetapa', 'tipoetapa.intIdTipoEtap', '=', 'etapa.intIdTipoEtap')
                        ->join('agrupador', 'tipoetapa.intIdAgru', '=', 'agrupador.intIdAgru')
                        ->leftJoin('deta_agru_supe', 'deta_agru_supe.intIdAgru', '=', 'agrupador.intIdAgru')
                        ->join('colaborador', 'deta_agru_supe.intIdColaborador', '=', 'colaborador.intIdColaborador')
                        ->where('etapa.intIdEtapa', '=', $intIdEtapa)
                        ->select('colaborador.intIdColaborador', DB::raw("CONCAT(colaborador.varNombColabo, ' ', colaborador.varApelColabo) as nombre"))->get();*/

        return $this->successResponse($vali_cola);
    }

}
