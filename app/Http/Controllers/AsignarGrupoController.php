<?php

namespace App\Http\Controllers;

use App\Proyectozona;
use App\Proyecto;
use App\AsignarEtapa;
use App\Rutaproyecto;
use App\Detalleruta;
use App\Proyectopaquete;
use App\Planta;
use App\Estado;
use App\Elmento;
use App\Etapa;
use App\Armadores;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AsignarGrupoController extends Controller {

    use \App\Traits\ApiResponser;

    // Illuminate\Support\Facades\DB;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    //  date_default_timezone_set('America/Lima'); // CDT
    //'acti_hora'=>$current_date = date('Y/m/d H:i:s')



    /*     * ************************PROCEDIMIENTO ALMACENADO*********************************************** */

    /**
     * @OA\Post(
     *     path="/Asignaciones/public/index.php/most_filt_asig_grup",
     *     tags={"Asignar grupo"},
     *     summary="mostrar el filtro asignado al grupo",
     *     @OA\Parameter(
     *         description="ingrese el id del proyecto",
     *         in="path",
     *         name="v_intIdproy",
     *     example="126",
     *         required=true,
     *         @OA\Schema(
     *           type="integer" 
     *         )
     *     ),
      @OA\Parameter(
     *         description="ingrese el id del tipo producto",
     *         in="path",
     *         name="v_intIdTipoProducto",
     *     example="1",
     *         required=true,
     *         @OA\Schema(
     *           type="integer" 
     *         )
     *     ),
      @OA\Parameter(
     *         description="ingrese el id de la planta",
     *         in="path",
     *         name="v_intIdPlanta",
     *     example="1",
     *         required=true,
     *         @OA\Schema(
     *           type="integer" 
     *         )
     *     ),
      @OA\Parameter(
     *         description="ingrese el id de la zona",
     *         in="path",
     *         name="v_intIdZona",
     *     example="1",
     *         required=true,
     *         @OA\Schema(
     *           type="integer" 
     *         )
     *     ),
     *       @OA\Parameter(
     *         description="ingrese el id de la tarea",
     *         in="path",
     *         name="v_intIdTarea",
     *     example="1",
     *         required=true,
     *         @OA\Schema(
     *           type="integer" 
     *         )
     *     ), 
      @OA\Parameter(
     *         description="ingrese el id del paquete",
     *         in="path",
     *         name="v_intIdPaque",
     *     example="1",
     *         required=true,
     *         @OA\Schema(
     *           type="integer" 
     *         )
     *     ),

      @OA\Parameter(
     *         description="ingrese el id del estado",
     *         in="path",
     *         name="v_intIdEstado",
     *     example="4",
     *         required=true,
     *         @OA\Schema(
     *           type="integer" 
     *         )
     *     ),  
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="v_intIdproy",
     *                     type="integer"
     *                 ) ,
     *              @OA\Property(
     *                     property="v_intIdTipoProducto",
     *                     type="integer"
     *                 ) ,
     *                @OA\Property(
     *                     property="v_intIdPlanta",
     *                     type="integer"
     *                 ) ,
     *              @OA\Property(
     *                     property="v_intIdTarea",
     *                     type="integer"
     *                 ) ,
     *               @OA\Property(
     *                     property="v_intIdPaque",
     *                     type="integer"
     *                 ) ,
     *              @OA\Property(
     *                     property="v_intIdEstado",
     *                     type="integer"
     *                 ) ,
     *                 example={"v_intIdproy":"126","v_intIdTipoProducto":"1","v_intIdPlanta":"1","v_intIdZona":"1",
     *                      "v_intIdTarea":"1","v_intIdPaque":"1","v_intIdEstado":"4"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="muestra el filtro segunla asignacion de grupo."
      ),
     *     @OA\Response(
     *         response=404,
     *         description="No se encuentra el metodo"
     *     )
     * )
     */
    public function most_filt_asig_grup(Request $request) {
        $regla = [
            'v_intIdproy' => 'required|max:255',
            'v_intIdTipoProducto' => 'required|max:255',
            'v_intIdPlanta' => 'required|max:255',
            'v_intIdZona' => 'required|max:255',
            'v_intIdTarea' => 'required|max:255',
            'v_intIdPaque' => 'required|max:255',
            'v_intIdEstado' => 'required|max:255'
        ];
        $this->validate($request, $regla);


        $intIdProy = $request->input('v_intIdproy');
        $v_intIdTipoProducto = $request->input('v_intIdTipoProducto');
        $v_intIdPlanta = $request->input('v_intIdPlanta');
        $v_intIdZona = $request->input('v_intIdZona');
        $v_intIdTarea = $request->input('v_intIdTarea');
        $v_intIdPaque = $request->input('v_intIdPaque');
        $v_intIdEstado = $request->input('v_intIdEstado');

        //Paque MAYUSCULA 

        $result = DB::select('CALL sp_Paque_Q01(?,?,?,?,?,?,?)', array($intIdProy,
                    $v_intIdTipoProducto,
                    $v_intIdPlanta,
                    $v_intIdZona,
                    $v_intIdTarea,
                    $v_intIdPaque,
                    $v_intIdEstado
        ));

        return $this->successResponse($result);
    }

    /**
     * @OA\Post(
     *     path="/Asignaciones/public/index.php/sele_los_codi_paqu_gril",
     *     tags={"Asignar grupo"},
     *     summary="Selecciona los codigos del paquete seleccionado en la grilla",
     *     @OA\Parameter(
     *         description="ingrese el id del paquete",
     *         in="path",
     *         name="v_intIdProyPaquete",
     *      example="1",
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
     *                     property="v_intIdProyPaquete",
     *                     type="integer"
     *                 ) ,
     *                 example={"v_intIdProyPaquete": "1"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Selecciona los codigos del paquete seleccionado"
     *     ),
     *   
     *     @OA\Response(
     *         response=404,
     *         description="No se encuentra el metodo"
     *     )
     * )
     */
    //Selecciona los codigos del paquete seleccionad (Grilla) 
    public function sele_los_codi_paqu_gril(Request $request) {
        $regla = [
            'v_intIdProyPaquete' => 'required|max:255',
        ];
        $this->validate($request, $regla);


        $v_intIdProyPaquete = $request->input('v_intIdProyPaquete');



        $result = DB::select('CALL sp_Paque_Q02(?)', array($v_intIdProyPaquete));

        return $this->successResponse($result);
    }

    /**
     * @OA\Post(
     *     path="/Asignaciones/public/index.php/sele_los_codi_paqu_camp",
     *     tags={"Asignar grupo"},
     *     summary="Selecciona los codigos del paquete seleccionado en el campo",
     *     @OA\Parameter(
     *         description="ingrese el id del paquete",
     *         in="path",
     *         name="v_intIdProyPaquete",
     *      example="1",
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
     *                     property="v_intIdProyPaquete",
     *                     type="integer"
     *                 ) ,
     *                 example={"v_intIdProyPaquete": "1"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Selecciona los codigos del paquete seleccionado"
     *     ),
     *   
     *     @OA\Response(
     *         response=404,
     *         description="No se encuentra el metodo"
     *     )
     * )
     */
    public function sele_los_codi_paqu_camp(Request $request) {
        $regla = [
            'v_intIdProyPaquete' => 'required|max:255',
        ];
        $this->validate($request, $regla);

        $v_intIdProyPaquete = $request->input('v_intIdProyPaquete');


        $result = DB::select('CALL sp_Paque_Q03(?)', array($v_intIdProyPaquete));

        return $this->successResponse($result);
    }

    /**
     * @OA\Post(
     *     path="/Asignaciones/public/index.php/guar_asig_grupo",
     *     tags={"Asignar grupo"},
     *     summary="Guardar la asignacion de grupo",
     *     @OA\Parameter(
     *         description="ingrese el id del proyecto",
     *         in="path",
     *         name="v_intIdproy",
     *     example="126",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),

      @OA\Parameter(
     *         description="ingrese el id del tipo producto",
     *         in="path",
     *         name="v_intIdTipoProducto",
      example="1023",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),

      @OA\Parameter(
     *         description="ingrese el id del paquete",
     *         in="path",
     *         name="v_intIdPaque",
      example="120",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),

      @OA\Parameter(
     *         description="ingrese el id del armador",
     *         in="path",
     *         name="v_intIdArmad",
      example="80",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
      @OA\Parameter(
     *         description="ingrese la fecha de inicio",
     *         in="path",
     *         name="v_dttFeInici",
      example="2019-10-21",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),

      @OA\Parameter(
     *         description="ingrese la fecha final",
     *         in="path",
     *         name="v_dttFeFin",
      example="2019-10-29",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
     *     
      @OA\Parameter(
     *         description="ingrese el usuario realiza el procesos",
     *         in="path",
     *         name="v_Usuario",
      example="usuarios_usuarios",
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
     *                     property="v_intIdproy",
     *                     type="string"
     *                 ) ,
     *             @OA\Property(
     *                     property="v_intIdTipoProducto",
     *                     type="string"
     *                 ) ,
     *              @OA\Property(
     *                     property="v_intIdPaque",
     *                     type="string"
     *                 ) ,
      @OA\Property(
     *                     property="v_intIdArmad",
     *                     type="string"
     *                 ) ,
      @OA\Property(
     *                     property="v_dttFeInici",
     *                     type="string"
     *                 ) ,
      @OA\Property(
     *                     property="v_dttFeFin",
     *                     type="string"
     *                 ) ,
     *             @OA\Property(
     *                     property="v_Usuario",
     *                     type="string"
     *                 ) ,
     *                 example={"v_intIdproy": "126","v_intIdTipoProducto":"1023","v_intIdPaque":"120","v_intIdArmad":"80",
     *                      "v_dttFeInici":"2019-10-21","v_dttFeFin":"2019-10-29","v_Usuario":"suarios_usuarios"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Guarda la asignacion del grupo"
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
    public function guar_asig_grupo(Request $request) {
        $validar = array('mensaje' => '');
        $regla = [
            'v_intIdproy' => 'required|max:255',
            'v_intIdTipoProducto' => 'required|max:255',
            'v_intIdPaque' => 'required|max:255',
            'v_intIdArmad' => 'required|max:255',
            'v_dttFeInici' => 'required|max:255',
            'v_dttFeFin' => 'required|max:255',
            'v_Usuario' => 'required|max:255'
        ];
        $this->validate($request, $regla);

        $v_intIdproy = $request->input('v_intIdproy');
        $v_intIdTipoProducto = $request->input('v_intIdTipoProducto');
        $v_intIdPaque = $request->input('v_intIdPaque');
        $v_intIdArmad = $request->input('v_intIdArmad');
        $v_dttFeInici = $request->input('v_dttFeInici');
        $v_dttFeFin = $request->input('v_dttFeFin');
        $v_usuario = $request->input('v_Usuario');

        //Paque MINUSCULA 
        date_default_timezone_set('America/Lima'); // CDT
        $v_fech_avan = $current_date = date('Y-m-d H:i:s');

        $result = DB::select('CALL sp_paque_P01(?,?,?,?,?,?,?,?)', array($v_intIdproy,
                    $v_intIdTipoProducto,
                    $v_intIdPaque,
                    $v_intIdArmad,
                    $v_dttFeInici,
                    $v_dttFeFin,
                    $v_fech_avan,
                    $v_usuario));


        return $this->successResponse($validar);
    }

    /**
     * @OA\Post(
     *     path="/Asignaciones/public/index.php/vali_ante_edit",
     *     tags={"Asignar grupo"},
     *     summary="validar antes  editar",
     *     @OA\Parameter(
     *         description="Ingrese el id del proyecto",
     *         in="path",
     *         name="v_intIdproy",
     *     example="126",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
      @OA\Parameter(
     *         description="ingrese el id del tipo producto",
     *         in="path",
     *         name="v_intIdTipoProducto",
     *     example="1",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),

      @OA\Parameter(
     *         description="ingrese el id del paquete",
     *         in="path",
     *         name="v_intIdPaque",
     *     example="133",
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
     *                     property="v_intIdproy",
     *                     type="string"
     *                 ) ,
     *              @OA\Property(
     *                     property="v_intIdTipoProducto",
     *                     type="string"
     *                 ) ,
      @OA\Property(
     *                     property="v_intIdPaque",
     *                     type="string"
     *                 ) ,
     *                 example={"v_intIdproy": "126","v_intIdTipoProducto":"1","v_intIdPaque":"133"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="valida ante de editar"
     *     ),
     *     
     *     @OA\Response(
     *         response=404,
     *         description="No se encuentra el metodo"
     *     )
     * )
     */
    public function vali_ante_edit(Request $request) {
        $regla = [
            'v_intIdproy' => 'required|max:255',
            'v_intIdTipoProducto' => 'required|max:255',
            'v_intIdPaque' => 'required|max:255',
        ];
        $this->validate($request, $regla);
        $v_intIdproy = $request->input('v_intIdproy');
        $v_intIdPaque = $request->input('v_intIdPaque');
        $v_intIdTipoProducto = $request->input('v_intIdTipoProducto');

        DB::select('CALL sp_paque_V01(?,?,?,@mensaje,@v_intIdEtapa,@v_desEtapa)', array(
            $v_intIdproy,
            $v_intIdTipoProducto,
            $v_intIdPaque,
        ));
        $results = DB::select('select @mensaje as mensaje,@v_intIdEtapa as intIdEtapa,@v_desEtapa as desEtapa');

        return $this->successResponse($results);
    }

    /**
     * @OA\Get(
     *     path="/Asignaciones/public/index.php/esta_paqu",
     *     tags={"Asignar grupo"},
     *     summary="lista los estados del paquete",
     *     
     *     @OA\Response(
     *         response=200,
     *         description="lista los estados del paquete"
     *     )
     * )
     */
    public function esta_paqu() {
        $esta_paque = Estado::where('intIdProcEsta', '=', 7)
                        ->select('intIdEsta', 'varDescEsta')->get();


        $dato_todo = ['intIdEsta' => -1, 'varDescEsta' => 'TODOS'];
        $esta_paque->push($dato_todo);
        return $this->successResponse($esta_paque);
    }

    /**
     * @OA\Post(
     *     path="/Asignaciones/public/index.php/vali_plan_id_etap",
     *     tags={"Asignar grupo"},
     *     summary="valida el plan del id etapa",
     *     @OA\Parameter(
     *         description="ingrese el id de la etapa",
     *         in="path",
     *         name="intIdEtapa",
     *      example="1",
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
     *                     type="integer"
     *                 ) ,
     *                 example={"intIdEtapa": "1"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="valida el planta del id etapa"
     *     ),
     *   
     *     @OA\Response(
     *         response=404,
     *         description="No se encuentra el metodo"
     *     )
     * )
     */
    public function vali_plan_id_etap(Request $request) {
        $regla = [
            'intIdEtapa' => 'required|max:255'
        ];
        $this->validate($request, $regla);
        $intIdEtapa = $request->input('intIdEtapa');

        $vali_plan = Etapa::join('planta', 'planta.intIdPlanta', '=', 'etapa.intIdPlan')
                ->where('etapa.intIdEtapa', '=', $intIdEtapa)
                ->select('etapa.varDescEtap', 'planta.intIdPlanta', 'planta.varDescPlanta')
                ->get();

        return $this->successResponse($vali_plan);
    }

    /**
     * @OA\Post(
     *     path="/Asignaciones/public/index.php/vali_arma_id_etap",
     *     tags={"Asignar grupo"},
     *     summary="valida armador id etapa",
     *     @OA\Parameter(
     *         description="ingrese el id de la etapa",
     *         in="path",
     *         name="intIdEtapa",
     *      example="1",
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
     *                     type="integer"
     *                 ) ,
     *                 example={"intIdEtapa": "1"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="valida el armador del id etapa"
     *     ),
     *   
     *     @OA\Response(
     *         response=404,
     *         description="No se encuentra el metodo"
     *     )
     * )
     */
    public function vali_arma_id_etap(Request $request) {
        $validar = array('mensaje' => '');
        $regla = [
            'intIdEtapa' => 'required|max:255'
        ];
        $this->validate($request, $regla);
        $intIdEtapa = $request->input('intIdEtapa');

        $vali_arma = Armadores::rightJoin('etapa', 'etapa.intIdEtapa', '=', 'armadores.intIdEtapa')
                ->where('etapa.intIdEtapa', '=', $intIdEtapa)
                ->where('armadores.varEstaArma', '!=','INA')
                ->select('armadores.intIdArmadores', DB::raw('CONCAT(armadores.varNombArma," ",armadores.varApelArma) as nombre'), 'armadores.intIdEtapa')
                ->orderBy('armadores.varNombArma','DESC')->get();
               

        if (count($vali_arma) == 0) {
            $validar['mensaje'] = "No hay armadores para esa etapa.";
            return $this->successResponse($validar);
        } else {
            return $this->successResponse($vali_arma);
        }
    }

    /**
     * @OA\Post(
     *     path="/Asignaciones/public/index.php/vali_cont_id_arma",
     *     tags={"Asignar grupo"},
     *     summary="valida armador id etapa",
     *     @OA\Parameter(
     *         description="Ingrese el id del armador",
     *         in="path",
     *         name="intIdArmadores",
     *      example="1",
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
     *                     property="intIdArmadores",
     *                     type="integer"
     *                 ) ,
     *                 example={"intIdArmadores": "1"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="valida el armador del id etapa"
     *     ),
     *   
     *     @OA\Response(
     *         response=404,
     *         description="No se encuentra el metodo"
     *     )
     * )
     */
    public function vali_cont_id_arma(Request $request) {
        $regla = [
            'intIdArmadores' => 'required|max:255'
        ];
        $this->validate($request, $regla);
        $intIdArmadores = $request->input('intIdArmadores');

        $vali_cont = Armadores::join('contratista', 'contratista.intIdCont', '=', 'armadores.intIdCont')
                ->where('armadores.intIdArmadores', '=', $intIdArmadores)
                ->select('armadores.intIdCont', 'contratista.varRazCont')
                ->get();

        return $this->successResponse($vali_cont);
    }

    /**
     * @OA\Post(
     *     path="/Asignaciones/public/index.php/vali_arma_con_proy_paqu",
     *     tags={"Asignar grupo"},
     *     summary="valida el armador con periodo paquete",
     *     @OA\Parameter(
     *         description="Ingrese el id del armador",
     *         in="path",
     *         name="intIdProyPaquete",
     *      example="1",
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
     *                     property="intIdProyPaquete",
     *                     type="integer"
     *                 ) ,
     *                 example={"intIdProyPaquete": "1"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="valida arma con proyecto pauqte"
     *     ),
     *   
     *     @OA\Response(
     *         response=404,
     *         description="No se encuentra el metodo"
     *     )
     * )
     */
    public function vali_arma_con_proy_paqu(Request $request) {
        $regla = [
            'intIdProyPaquete' => 'required|max:255'
        ];
        $this->validate($request, $regla);


        $intIdProyPaquete = $request->input('intIdProyPaquete');


        $vali_paque = Proyectopaquete::join('armadores', 'armadores.intIdArmadores', '=', 'proyecto_paquetes.intIdArmadores')
                ->where('proyecto_paquetes.intIdProyPaquete', '=', $intIdProyPaquete)
                ->select('proyecto_paquetes.intIdArmadores', DB::raw('CONCAT(armadores.varNombArma," ",armadores.varApelArma) as nombre'), 'proyecto_paquetes.intIdProyPaquete')
                ->get();
        return $this->successResponse($vali_paque);
    }

    /**
     * @OA\Post(
     *     path="/Asignaciones/public/index.php/visu_repo_comp",
     *     tags={"Asignar grupo"},
     *     summary="visualizar reporte campo",
     *     @OA\Parameter(
     *         description="ingrese el id del proyecto",
     *         in="path",
     *         name="v_intIdProy",
     *       example="126",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
      @OA\Parameter(
     *         description="ingrese el id del proyecto",
     *         in="path",
     *         name="v_intIdTipoProducto",
     *       example="1",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
      @OA\Parameter(
     *         description="ingrese el id del proyecto",
     *         in="path",
     *         name="v_intIdProyPaquete",
     *       example="69",
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
     *                     property="v_intIdProy",
     *                     type="string"
     *                 ) ,
     *                          @OA\Property(
     *                     property="v_intIdTipoProducto",
     *                     type="string"
     *                 ) ,
     *               @OA\Property(
     *                     property="v_intIdProyPaquete",
     *                     type="string"
     *                 ) ,
     *                 example={"v_intIdProy": "126","v_intIdTipoProducto":"1","v_intIdProyPaquete":"69"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="visualizar el reporte  de los campos"
     *     ),
     *    
     *     @OA\Response(
     *         response=404,
     *         description="No se encuentra el metodo"
     *     )
     * )
     */
    public function visu_repo_comp(Request $request) {
        $regla = [
            'v_intIdProy' => 'required|max:255',
            'v_intIdTipoProducto' => 'required|max:255',
            'v_intIdProyPaquete' => 'required|max:255'
        ];
        $this->validate($request, $regla);

        $v_intIdProy = (int)$request->input('v_intIdProy');
        $v_intIdTipoProducto = (int) $request->input('v_intIdTipoProducto');
        $v_intIdProyPaquete =(int) $request->input('v_intIdProyPaquete');

        //dd($v_intIdProy,$v_intIdTipoProducto,$v_intIdProyPaquete);
        $result = DB::select('CALL sp_Componentes_Q01(?,?,?)', array($v_intIdProy, $v_intIdTipoProducto, $v_intIdProyPaquete));

        return $this->successResponse($result);
    }

    /**
     * @OA\Post(
     *     path="/Asignaciones/public/index.php/store_list_codi_grup_sele_visu_plan",
     *     tags={"Asignar grupo"},
     *     summary="listar los códigos del grupo seleccionado para visualizar los planos",
     *     @OA\Parameter(
     *         description="Ingrese el id del paquete",
     *         in="path",
     *         name="intIdProyPaquete",
     *      example="1",
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
     *                     property="intIdProyPaquete",
     *                     type="integer"
     *                 ) ,
     *                 example={"intIdProyPaquete": "1"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Este store listar los códigos del grupo seleccionado para visualizar los planos"
     *     ),
     *   
     *     @OA\Response(
     *         response=404,
     *         description="No se encuentra el metodo"
     *     )
     * )
     */
    //Este store listar los códigos del grupo seleccionado para visualizar los planos.  
    //sp_Paque_Q04(v_intIdProyPaquete)
    public function store_list_codi_grup_sele_visu_plan(Request $request) {
        $regla = [
            'intIdProyPaquete' => 'required|max:255',
        ];
        $this->validate($request, $regla);

        $v_intIdProyPaquete = $request->input('intIdProyPaquete');
        $result = DB::select('CALL  sp_Paque_Q04(?)', array($v_intIdProyPaquete));
        return $this->successResponse($result);
    }

}
