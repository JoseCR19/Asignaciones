<?php

namespace App\Http\Controllers;

use App\Proyectozona;
use App\Proyecto;
use App\AsignarEtapa;
use App\Rutaproyecto;
use App\Detalleruta;
use App\Elemento;
use App\tab_despacho;
use App\Agrupador;
use App\Etapa;
use App\TipoEtapas;
use App\Contratista;
use App\Componente;
use App\guia;
use App\Despacho;
use App\tab_docu;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ReportarAvanceController extends Controller {

    use \App\Traits\ApiResponser;

    // Illuminate\Support\Facades\DB;
    /**
     * eareate a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    /**
     * @OA\Post(
     *     path="/Asignaciones/public/index.php/repo_avance_serie",
     *     tags={"Reporte avance"},
     *     summary="",
     *     @OA\Parameter(
     *         description="Ingrese el id del proyecto",
     *         in="path",
     *         name="intIdProy",
     *       example="126",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="Ingrese el id del tipo producto",
     *         in="path",
     *         name="intIdTipoProducto",
     *       example="1",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="Ingrese el codigo del elemento",
     *         in="path",
     *         name="varCodiElemento",
     *       example="TB-1",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="Ingrese el id del proyecto paquete",
     *         in="path",
     *         name="intIdProyPaquete",
     *       example="1",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
     *     @OA\Parameter(
     *       description="Ingrese el id de la ruta",
     *         in="path",
     *         name="intIdRuta",
     *       example="2",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),

     *  @OA\Parameter(
     *         description="ingrese el id etapa anterior",
     *         in="path",
     *         name="intIdEtapaAnte",
     *       example="2",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
     * 
     * 
     *   @OA\Parameter(
     *         description="ingrese el id etapa siguiente",
     *         in="path",
     *         name="intIdEtapaSiguiente",
     *       example="7",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
     *   @OA\Parameter(
     *         description="ingrese el idproyecto tarea",
     *         in="path",
     *         name="intIdProyTarea",
     *       example="3",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
     *   @OA\Parameter(
     *         description="ingrese el idproyecto zona",
     *         in="path",
     *         name="intIdProyZona",
     *       example="3",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),

     *   @OA\Parameter(
     *         description="ingrese el la revision",
     *         in="path",
     *         name="intRevision",
     *       example="3",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
     *   @OA\Parameter(
     *         description="ingrese el id etapa",
     *         in="path",
     *         name="intIdEtapa",
     *       example="5",
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
     *                @OA\Property(
     *                     property="intIdTipoProducto",
     *                     type="string"
     *                 ) ,
     *                 @OA\Property(
     *                     property="varCodiElemento",
     *                     type="string"
     *                 ) ,
     *                @OA\Property(
     *                     property="intIdProyPaquete",
     *                     type="string"
     *                 ) ,
     *                @OA\Property(
     *                     property="intIdRuta",
     *                     type="string"
     *                 ) ,
     *                 @OA\Property(
     *                     property="intIdEtapaAnte",
     *                     type="string"
     *                 ) ,
     *                     @OA\Property(
     *                     property="intIdEtapaSiguiente",
     *                     type="string"
     *                 ) ,
     *                
     *                @OA\Property(
     *                     property="intIdProyTarea",
     *                     type="string"
     *                 ) ,
     *                   @OA\Property(
     *                     property="intIdProyZona",
     *                     type="string"
     *                 ) ,
     *                @OA\Property(
     *                     property="intRevision",
     *                     type="string"
     *                 ) ,
     *                @OA\Property(
     *                     property="intIdEtapa",
     *                     type="string"
     *                 ) ,
     *                 example={"intIdProy": "126","intIdTipoProducto":"1","varCodiElemento":"TB-1","intIdProyPaquete":"1",
     *                          "intIdRuta":"2","intIdEtapaAnte":"2","intIdEtapaSiguiente":"7", "intIdProyTarea":"3","intIdProyZona":"3","intRevision":"3","intIdEtapa":"5"
     *                        }
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="informacion del avance de la serie"
     *     ),
     *    
     *     @OA\Response(
     *         response=404,
     *         description="No se encuentra el metodo"
     *     )
     * )
     */
    public function repo_avance_serie(Request $request) {

        $regla = [
            'varCodiElemento' => 'required|max:255',
            'intIdProy' => 'required|max:255',
            'intIdTipoProducto' => 'required|max:255',
            'varDescripcion' => 'required|max:255',
            'intRevision' => 'required|max:255',
            'intCantRepro' => 'required|max:255',
            //'deciPrec'=>'required|max:255',
            'deciPesoNeto' => 'required|max:255',
            'deciPesoBruto' => 'required|max:255',
            'deciArea' => 'required|max:255',
            'deciLong' => 'required|max:255',
            'varPerfil' => 'required|max:255',
            'varModelo' => 'required|max:255',
            'intIdProyZona' => 'required|max:255',
            'intIdProyPaquete' => 'required|max:255',
            // 'intIdEtapaAnte'=>'required|max:255',
            // 'intIdEtapaSiguiente'=>'required|max:255',
            'intIdEtapa' => 'required|max:255',
            'intIdProyTarea' => 'required|max:255',
            'intIdRuta' => 'required|max:255',
            'intIdEsta' => 'required|max:255'
                // 'varValo1'=>'required|max:255',
                //'DocEnvioTS'=>'required|max:255'
        ];
        $this->validate($request, $regla);
        $intIdEsta = (int) $request->input('intIdEsta');
        $varCodiElemento = $request->input('varCodiElemento');
        $bulto = $request->input('bulto');
        $intIdProy = (int) $request->input('intIdProy');
        $intIdTipoProducto = (int) $request->input('intIdTipoProducto');
        $varDescripcion = $request->input('varDescripcion');
        $intRevision = (int) $request->input('intRevision');
        $intCantRepro = (int) $request->input('intCantRepro');
        $deciPrec = $request->input('deciPrec');
        $deciPesoNeto = $request->input('deciPesoNeto');
        $deciPesoBruto = $request->input('deciPesoBruto');
        $deciArea = $request->input('deciArea');
        $deciLong = $request->input('deciLong');
        $varPerfil = $request->input('varPerfil');
        $varModelo = $request->input('varModelo');
        $intIdProyZona = $request->input('intIdProyZona');
        $intIdProyPaquete = $request->input('intIdProyPaquete');
        $intIdEtapaAnte = $request->input('intIdEtapaAnte');
        $intIdEtapaSiguiente = $request->input('intIdEtapaSiguiente');
        $intIdEtapa = $request->input('intIdEtapa');
        $intIdProyTarea = $request->input('intIdProyTarea');
        $intIdRuta = $request->input('intIdRuta');
        $varValo1 = $request->input('Pintura');
        $IdContrAnt = $request->input('IdContrAnt');
        $Doc_Ant = $request->input('Doc_Ant');
        $FechaAvanAnt = $request->input('FechaAvanAnt');
        $numDocTratSup = $request->input('DocEnvioTS');
        $Obs1 = $request->input('Obs1');
        $obs2 = $request->input('obs2');
        $obs3 = $request->input('obs3');
        $obs4 = $request->input('obs4');
        if ($numDocTratSup == null || $numDocTratSup == "") {
            $numDocTratSup = '';
        } else {
            $numDocTratSup = $numDocTratSup;
        }
        $mostra_serie = DB::table('elemento')
                        ->leftJoin('proy_avan as AV', 'elemento.intIdEleme', '=', 'AV.intIdEleme', 'and', 'elemento.intIdEtapa', '=', 'AV.intIdEtapa')
                        ->leftJoin('contratista as emp', 'AV.intIdContr', '=', 'emp.intIdCont')
                        ->leftJoin('etapa as ETAA', 'elemento.intIdEtapa', '=', 'ETAA.intIdEtapa')
                        ->leftJoin('etapa as ETA', 'elemento.intIdEtapaAnte', '=', 'ETA.intIdEtapa')
                        ->leftJoin('etapa as ETS', 'elemento.intIdEtapaSiguiente', '=', 'ETS.intIdEtapa')
                        ->leftJoin('proyecto_zona as PZ', 'elemento.intIdProyZona', '=', 'PZ.intIdProyZona')
                        ->leftJoin('proyecto_paquetes as PG', 'elemento.intIdProyPaquete', '=', 'PG.intIdProyPaquete')
                        ->leftJoin('proyecto_tarea as PT', 'elemento.intIdProyTarea', '=', 'PT.intIdProyTarea')
                        ->leftJoin('proy_avan as AV1', 'elemento.intIdEleme', '=', 'AV1.intIdEleme', 'and', 'elemento.intIdEtapaAnte', '=', 'AV1.intIdEtapa', 'and', 'AV1.intMaxContaEtap', '=', 1)
                        ->leftJoin('contratista as emp1', 'AV1.intIdContr', '=', 'emp1.intIdCont')
                        ->where('elemento.intIdProy', '=', $intIdProy)
                        ->where('elemento.intIdTipoProducto', '=', $intIdTipoProducto)
                        ->where('elemento.intCantRepro', '=', $intCantRepro)
                        ->where('elemento.varCodiElemento', '=', $varCodiElemento)
                        ->where('elemento.intIdProyPaquete', '=', $intIdProyPaquete)
                        ->where('elemento.intIdProyZona', '=', $intIdProyZona)
                        ->where('elemento.intIdProyTarea', '=', $intIdProyTarea)
                        ->where('elemento.intIdEtapa', '=', $intIdEtapa)
                        ->where('elemento.intIdEsta', '=', $intIdEsta)
                        ->where('elemento.varValo1', '=', $varValo1)
                        ->where('elemento.numDocTratSup', '=', $numDocTratSup)
                        ->where('elemento.varBulto', '=', $bulto)
                        ->where('elemento.varValo2', '=', $Obs1)
                        ->where('elemento.varValo3', '=', $obs2)
                        ->where('elemento.varValo4', '=', $obs3)
                        ->where('elemento.varValo5', '=', $obs4)
                        ->where('elemento.intIdEsta', '<>', 2)
                        ->where('elemento.intIdEsta', '<>', 6)
                        ->select('elemento.varCodiElemento', 'elemento.varDescripcion', 'elemento.intSerie', 'elemento.intIdEleme', 'elemento.acti_usua', 'elemento.acti_hora', 'elemento.FechaUltimAvan', 'elemento.deciArea', 'elemento.deciPesoBruto', 'elemento.deciPesoNeto', 'elemento.intCantRepro', 'elemento.intRevision', 'ETAA.varDescEtap')->distinct('elemento.intIdEleme')->get();
        return $this->successResponse($mostra_serie);
    }

    /**
     * @OA\Post(
     *     path="/Asignaciones/public/index.php/store_regi_avance",
     *      tags={"Reporte avance"},
     *     summary="Permite registrar avance",
     *     @OA\Parameter(
     *         description="Ingrese el id del proyecto",
     *         in="path",
     *         name="v_intIdproy",
     *       example="126",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
     *    @OA\Parameter(
     *         description="Ingrese el id del tipo producto",
     *         in="path",
     *         name="v_intIdTipoProducto",
     *       example="1",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
      @OA\Parameter(
     *         description="Ingrese el id de la etapa actual",
     *         in="path",
     *         name="v_intIdEtapaActual",
     *       example="4",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
      @OA\Parameter(
     *         description="Ingrese el elemente",
     *         in="path",
     *         name="v_varCodiElemento",
     *       example="TB-2",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="Ingrese la cantidad",
     *         in="path",
     *         name="v_nCanti",
     *       example="23",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="Ingrese el id del contratista",
     *         in="path",
     *         name="v_intIdContr",
     *       example="21",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="Ingrese el numero de contrata",
     *         in="path",
     *         name="v_intNuConta",
     *       example="32",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="Ingrese el numero de revision",
     *         in="path",
     *         name="v_intNuRevis",
     *       example="4",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="Ingrese el id del supervisor",
     *         in="path",
     *         name="v_intIdSuper",
     *       example="15",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="Ingrese el id proyecto zona",
     *         in="path",
     *         name="v_intIdProyZona",
     *       example="1",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
     * 
     * *     @OA\Parameter(
     *         description="Ingrese el id proyecto tarea",
     *         in="path",
     *         name="v_intIdProyTarea",
     *       example="2",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
      @OA\Parameter(
     *         description="Ingrese el id proyecto paquete",
     *         in="path",
     *         name="v_intIdProyPaquete",
     *       example="3",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
     *      @OA\Parameter(
     *         description="Ingrese el id etapa anterior",
     *         in="path",
     *         name="v_intIdEtapaAnt",
     *       example="3",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
     *      @OA\Parameter(
     *         description="Ingrese el id etapa siguiente",
     *         in="path",
     *         name="v_intIdEtapaSig",
     *       example="5",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
     *      @OA\Parameter(
     *         description="Ingrese la observacion",
     *         in="path",
     *         name="v_strDeObser",
     *       example="",
     *         required=false,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),

      @OA\Parameter(
     *         description="Ingrese el id de la maquina",
     *         in="path",
     *         name="v_intIdMaqui",
     *         required=false,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="Ingrese el id del periodo valorizacion",
     *         in="path",
     *         name="v_intIdPeriValo",
     *       example="2",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="Ingrese el usuario que va realizar el proceso",
     *         in="path",
     *         name="v_usuario",
     *       example="usuario_usuario",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="ingrese el id de la inspeccion",
     *         in="path",
     *         name="v_intIdInspe",
     *       example="3",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
      @OA\Parameter(
     *         description="ingrese el id de la ruta",
     *         in="path",
     *         name="v_intIdRuta",
     *       example="5",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
      @OA\Parameter(
     *         description="ingrese el valor Etapa",
     *         in="path",
     *         name="v_varValoEtapa",
     *       example="SI",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
      @OA\Parameter(
     *         description="ingrese el codigo de la etapa",
     *         in="path",
     *         name="v_varCodiTipoEtap",
     *       example="SI",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
     *       @OA\Parameter(
     *         description="si va hacer despachado '1=si o 0=no'",
     *         in="path",
     *         name="v_boolDesp",
     *       example="",
     *         required=false,
     *         @OA\Schema(
     *           type="integer" 
     *         )
     *     ),
      @OA\Parameter(
     *         description="ingrese el id de asignacion etapa",
     *         in="path",
     *         name="v_intIdAsigEtapProy",
     *       example="9",
     *         required=false,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
      @OA\Parameter(
     *         description="ingrese el  la serie del elemento",
     *         in="path",
     *         name="v_Series",
     *       example="",
     *         required=false,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
      @OA\Parameter(
     *         description="ingrese el bulto",
     *         in="path",
     *         name="v_strBulto",
     *       example="",
     *         required=false,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="ingrese el numero de guia",
     *         in="path",
     *         name="v_varNumeroGuia",
     *       example="",
     *         required=false,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="v_intIdproy",
     *                     type="126"
     *                 ) ,
     *                @OA\Property(
     *                     property="v_intIdTipoProducto",
     *                     type="string"
     *                 ) ,
      @OA\Property(
     *                     property="v_intIdEtapaActual",
     *                     type="string"
     *                 ) ,
      @OA\Property(
     *                     property="v_varCodiElemento",
     *                     type="string"
     *                 ) ,
     *                  @OA\Property(
     *                     property="v_nCanti",
     *                     type="string"
     *                 ) ,
     *                  @OA\Property(
     *                     property="v_intIdContr",
     *                     type="string"
     *                 ) ,
      @OA\Property(
     *                     property="v_intNuConta",
     *                     type="string"
     *                 ) ,
     *                  @OA\Property(
     *                     property="v_intIdSuper",
     *                     type="string"
     *                 ) ,
     *                  @OA\Property(
     *                     property="v_intIdProyZona",
     *                     type="string"
     *                 ) ,
      @OA\Property(
     *                     property="v_intIdProyTarea",
     *                     type="string"
     *                 ) ,
     *                  @OA\Property(
     *                     property="v_intIdProyPaquete",
     *                     type="string"
     *                 ) ,
     *                  @OA\Property(
     *                     property="v_intIdEtapaAnt",
     *                     type="string"
     *                 ) ,
      @OA\Property(
     *                     property="v_intIdEtapaSig",
     *                     type="string"
     *                 ) ,
     *                  @OA\Property(
     *                     property="v_strDeObser",
     *                     type="string"
     *                 ) ,
     *                 
      @OA\Property(
     *                     property="v_Series",
     *                     type="string"
     *                 ) ,
     *                  @OA\Property(
     *                     property="v_strBulto",
     *                     type="string"
     *                 ) ,
     *                  @OA\Property(
     *                     property="v_intIdPeriValo",
     *                     type="string"
     *                 ) , 

     *    *                  @OA\Property(
     *                     property="v_usuario",
     *                     type="string"
     *                 ),
      @OA\Property(
     *                     property="v_intIdInspe",
     *                     type="string"
     *                 ) ,
     *                  @OA\Property(
     *                     property="v_intIdRuta",
     *                     type="string"
     *                 ) ,
     *                  @OA\Property(
     *                     property="v_varValoEtapa",
     *                     type="string"
     *                 ) , 
     *                  @OA\Property(
     *                     property="v_varCodiTipoEtap",
     *                     type="string"
     *                 ) , 

     *    *                  @OA\Property(
     *                     property="v_boolDesp",
     *                     type="string"
     *                 ),
      @OA\Property(
     *                     property="v_intIdAsigEtapProy",
     *                     type="string"
     *                 ) ,
     *                  @OA\Property(
     *                     property="v_varNumeroGuia",
     *                     type="string"
     *                 ) ,
     *                example={ "v_intIdproy":"126","v_intIdTipoProducto":"1","v_intIdEtapaActual":"4","v_varCodiElemento":"TB-2",
     *                        "v_nCanti":"23","v_intIdContr":"21","v_intNuConta":"32","v_intNuRevis":"4","v_intIdSuper":"15","v_intIdProyZona":"1",
     *                        "v_intIdProyTarea":"2","v_intIdProyPaquete":"3","v_intIdEtapaAnt":"3","v_intIdEtapaSig":"5",
     *                        "v_intIdPeriValo":"2","v_usuario":"usuario_usuario","v_intIdInspe":"3","v_intIdRuta":"5","v_varValoEtapa":"SI",
     *                            "v_varCodiTipoEtap":"25","v_intIdAsigEtapProy":"9"}
     *                
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Registrar avance"
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="La tabla temporal esta vacía, comuniquese con Sistemas"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No se encuentra el metodo"
     *     )
     * )
     */
    public function store_regi_avance(Request $request) {
        $validar = array('mensaje' => array(), 'mensaje_alternativo' => '');
        $regla = [
            'v_intIdproy' => 'required|max:255',
            'v_intIdTipoProducto' => 'required|max:255',
                // 'v_strDeObser'=>'required|max:255',
                //'v_intIdMaqui'=>'required|max:255',
                //'v_strBulto'=>'required|max:255',
                //'v_intIdPeriValo' => 'required|max:255',
                //'v_usuario' => 'required|max:255',
                //'v_intIdInspe' => 'required|max:255',
                //'v_varValoEtapa' => 'required|max:255',
                //'v_varCodiTipoEtap' => 'required|max:255',
                //'v_boolDesp' => 'required|max:255',
                //'v_intIdAsigEtapProy' => 'required|max:255',
                //'v_informacion' => 'required',
                //'v_varNumeroGuia'=>'required|max:255',
                //   'v_intIdSuper'=>'required|max:255',
                //'v_intIdSuper'=>'required|max:255',
        ];
        date_default_timezone_set('America/Lima'); // CDT

        $this->validate($request, $regla);

        $v_intIdproy = (int) $request->input('v_intIdproy'); //
        $v_intIdTipoProducto = (int) $request->input('v_intIdTipoProducto'); //
        $v_strDeObser = ""; //
        $v_intIdMaqui = ""; //
        $v_strBulto = ""; //
        $v_intIdPeriValo = (int) $request->input('v_intIdPeriValo'); //
        $v_usuario = $request->input('v_usuario'); //
        $v_intIdInspe = (int) $request->input('v_intIdInspe'); //
        $v_varValoEtapa = $request->input('v_varValoEtapa'); //

        $v_varCodiTipoEtap = $request->input('v_varCodiTipoEtap');
        //dd($v_varCodiTipoEtap);
        $v_boolDesp = (int) $request->input('v_boolDesp');
        $v_tinFlgConforForzosa = (int) $request->input('v_tinFlgConforForzosa');
        $v_strDefecto = trim($request->input('v_strDefecto'), ',');
        $v_strCausa = trim($request->input('v_strCausa'), ',');
        $strEstadoInspe = $request->input('strEstadoInspe');

        $v_intIdDespa = (int) $request->input('v_intIdDespa');
        $v_intIdAsigEtapProy = (int) $request->input('v_intIdAsigEtapProy');
        $v_informacion = json_decode($request->input('v_informacion'));
        $v_varNumeroGuia = "";
        $v_fech_avan = $current_date = date('Y-m-d H:i:s');

        $v_intIdContr = (int) $request->input('v_intIdContr');

        //  $todo_mensaje=[];

        if ($request->input('v_intIdSuper') == "NaN") {

            $v_intIdSuper = null;
        } else {

            $v_intIdSuper = (int) $request->input('v_intIdSuper');
        }


        if ($request->input('v_strDeObser') == '' || $request->input('v_strDeObser') == null) {
            $v_strDeObser = '';
        } else {
            $v_strDeObser = $request->input('v_strDeObser');
        }

        if ($request->input('v_intIdMaqui') == "NaN") {
            $v_intIdMaqui = null;
        } else {
            $v_intIdMaqui = (int) $request->input('v_intIdMaqui');
        }

        if ($request->input('v_strBulto') == "") {
            $v_strBulto = '';
        } else {
            $v_strBulto = $request->input('v_strBulto');
        }

        if ($request->input('v_varNumeroGuia') == "") {
            $v_varNumeroGuia = '';
        } else {
            $v_varNumeroGuia = $request->input('v_varNumeroGuia');
        }


        /* dd($v_intIdproy, 
          $v_intIdTipoProducto,
          $v_strDeObser,
          $v_intIdMaqui,
          $v_strBulto,
          $v_intIdPeriValo,
          $v_usuario,
          $v_intIdInspe,
          $v_varValoEtapa,
          $v_varCodiTipoEtap,
          $v_boolDesp,
          $v_intIdAsigEtapProy,
          $v_informacion,
          $v_varNumeroGuia,
          $v_tinFlgConforForzosa,
          $v_strDefecto,
          $v_strCausa ,
          $strEstadoInspe ,
          $v_intIdDespa,
          $v_intIdContr
          ); */
        $v_intIdEtapaActual = "";
        $v_varCodiElemento = "";
        $v_nCanti = "";


        $v_intNuRevis = "";

        $v_intIdProyZona = "";
        $v_intIdProyTarea = "";
        $v_intIdProyPaquete = "";
        $v_deciPrec = "";
        $v_intIdEtapaAnt = "";
        $v_intIdEtapaSig = "";
        $v_intIdRuta = "";
        $v_Series = "";
        $v_intNuConta = "";
        $array_guia = "";
        //dd($v_informacion);
        if ($array_guia === "") {
            
        } else {
            $array_unique = array_unique($array_guia);
        }
        //  dd(count($v_informacion));
        //dd($v_informacion);

        foreach ($v_informacion as $index) {

            $id_lot = (int) $index->{"intIdLotePintura"};
            $v_intIdEtapaActual = (int) $index->{"intidetapa"};
            //dd($v_intIdEtapaActual);
            $v_varCodiElemento = $index->{"varCodiElemento"};
            $Pintura = $index->{"Pintura"};
            $DocEnvioTS = $index->{"DocEnvioTS"};
            $v_nCanti = (int) $index->{'Canti'};
            //$v_intIdContr=(int)$index->{"intIdContr"};
            $v_intNuConta = (int) $index->{"intCantRepro"}; // incantrepro
            $tipo_reporte = (int) $index->{"tipo_reporte"};
            $v_intNuRevis = (int) $index->{"intRevision"};
            //$v_intIdSuper=$index[''];
            $v_intIdProyZona = (int) $index->{"intIdProyZona"};
            $v_intIdProyTarea = (int) $index->{"intIdProyTarea"};
            $v_intIdProyPaquete = (int) $index->{"intIdProyPaquete"};
            // $v_deciPrec=$index['deciPrec'];
            $v_intIdEtapaAnt = (int) $index->{"intIdEtapaAnte"};
            $v_intIdEtapaSig = (int) $index->{"intIdEtapaSiguiente"};
            $v_intIdRuta = (int) $index->{"intIdRuta"};
            $intIdEsta = (int) $index->{"intIdEsta"};
            //dd($index->{'Obs1'});
            $Obs1 = $index->{'Obs1'};
            $obs2 = $index->{'obs2'};
            $obs3 = $index->{'obs3'};
            $obs4 = $index->{'obs4'};
            //dd($intIdEsta);
            if ($index->{"deciPrec"} == 0) {
                $v_deciPrec = 0;
            } else {
                $v_deciPrec = $index->{"deciPrec"};
            }
            if (!isset($index->{"varcodelement"})) {

                $v_Series = '';
            } else {

                $v_Series = trim($index->{"varcodelement"}, ',');
            }
            /* dd($v_boolDesp); */
            /* dd($v_intIdproy, //
              $v_intIdTipoProducto, //
              $v_intIdEtapaActual, //
              $v_varCodiElemento, //
              $v_nCanti, //
              $v_fech_avan, //
              $v_intIdContr, //
              $v_intNuConta, $v_intNuRevis, //
              $v_intIdSuper, $v_intIdProyZona, //
              $v_intIdProyTarea, //
              $v_intIdProyPaquete, //
              $v_deciPrec, //
              $v_intIdEtapaAnt, //
              $v_intIdEtapaSig, //
              $v_strDeObser, //
              $v_intIdMaqui, //
              $v_Series, //
              $v_strBulto, //
              $v_intIdPeriValo, //
              $v_usuario, //
              $v_intIdInspe, //
              $v_intIdRuta, //
              $v_varValoEtapa, //
              $v_varCodiTipoEtap, //
              $v_boolDesp, //
              $v_intIdAsigEtapProy, //
              $v_varNumeroGuia, //
              $intIdEsta, $v_tinFlgConforForzosa, $v_strDefecto, $v_strCausa, $strEstadoInspe, $v_intIdDespa); */

            DB::select('CALL sp_avance_P02 (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@mensaje1)', array(
                $v_intIdproy, //
                $v_intIdTipoProducto, //
                $v_intIdEtapaActual, //
                $v_varCodiElemento, //
                $v_nCanti, //
                $v_fech_avan, //
                $v_intIdContr, //
                $v_intNuConta,
                $v_intNuRevis, //
                $v_intIdSuper,
                $v_intIdProyZona, //
                $v_intIdProyTarea, //
                $v_intIdProyPaquete, //
                $v_deciPrec, //
                $v_intIdEtapaAnt, //
                $v_intIdEtapaSig, //
                $v_strDeObser, //
                $v_intIdMaqui, //
                $v_Series, //
                $v_strBulto, //
                $v_intIdPeriValo, //
                $v_usuario, //
                $v_intIdInspe, //
                $v_intIdRuta, //
                $v_varValoEtapa, //
                $v_varCodiTipoEtap, //
                $v_boolDesp, //
                $v_intIdAsigEtapProy, //
                $v_varNumeroGuia, //
                $intIdEsta,
                $v_tinFlgConforForzosa,
                $v_strDefecto,
                $v_strCausa,
                $strEstadoInspe,
                $v_intIdDespa,
                $DocEnvioTS,
                $Pintura,
                $Obs1,
                $obs2,
                $obs3,
                $obs4,
                $id_lot
            ));
            $results = DB::select('select @mensaje1');
            // dd($results);
            if (count($results) == 0 || $results[0]->{"@mensaje1"} == null) {


                if ($v_varCodiTipoEtap === "ESTR") {
                    $mensagge = DB::select('CALL sp_paque_V02 (?,?,?,?,?)', array(
                                $v_intIdproy,
                                $v_intIdTipoProducto,
                                $v_intIdProyPaquete,
                                $v_usuario,
                                $v_fech_avan//$v_fecha,
                    ));
                }
                if ($v_intIdEtapaActual === 7 || $v_intIdEtapaActual === 8) {
                    DB::select('CALL sp_LotePintura_V01 (?,?,?,?,?,?)', array(
                        $v_intIdproy,
                        $v_intIdTipoProducto,
                        $id_lot,
                        $v_intIdEtapaActual,
                        $v_usuario,
                        $v_fech_avan//$v_fecha,
                    ));
                }

                //dd($results);
                //dd($tipo_reporte);
                if ($strEstadoInspe === 'N') {

                    $anterior = DB::select("select tipoetapa.varDescTipoEtap from etapa left join  tipoetapa  on etapa.intIdTipoEtap=tipoetapa.intIdTipoEtap where etapa.intIdEtapa=$v_intIdEtapaAnt");
                    /* dd($v_intIdproy,
                      $v_intIdTipoProducto,
                      $v_intIdProyPaquete,
                      $v_usuario,
                      $v_fech_avan); */
                    if ($anterior[0]->varDescTipoEtap === "ESTRUCTURADO") {
                        DB::select('CALL sp_paque_V02 (?,?,?,?,?)', array(
                            $v_intIdproy,
                            $v_intIdTipoProducto,
                            $v_intIdProyPaquete,
                            $v_usuario,
                            $v_fech_avan//$v_fecha,
                        ));
                    }
                }
                $results = "";
            } else {
                $results = $results[0]->{"@mensaje1"};
            }
            $validar['mensaje'][] .= $results;
            //dd($v_varCodiTipoEtap);
            // dd($results[0]->{"@mensaje"});
        }

        if (count($validar) > 0) {

            if ($validar['mensaje'][0] === "") {
                $id_etapa = (int) $v_informacion[0]->{'intidetapa'};

                $etapa = DB::select("select varDescEtap from etapa where intIdEtapa=$id_etapa");
                if ($etapa[0]->{'varDescEtap'} === "ENVIO TRAT. SUPERFICIAL") {
                    DB::select('CALL sp_Galvanizado_P01 (?,?,?,?)', array(
                        $v_intIdproy,
                        $v_intIdTipoProducto,
                        $v_varNumeroGuia,
                        $v_usuario
                    ));
                } else {
                    
                }
                $validar['mensaje_alternativo'] = 'sin error';
                return $this->successResponse($validar);
            } else {
                $validar['mensaje_alternativo'] = 'error';
                return $this->successResponse($validar);
            }
        }
    }

    public function guias_generadas(Request $request) {
        $regla = [
            'v_informacion'
        ];
        $this->validate($request, $regla);
        $validar = array('docu' => array(), 'cantidad' => '');
        $v_informacion = json_decode($request->input('v_informacion'));
        $id_guia = DB::select("select ifnull(max(intContaDocu),0)  as id,varSerieDocu   from tab_docu where intIdEsta=3 and intIdDocu=1");
        $array_nuevo = array_chunk($v_informacion, 32, false);
        $cantidad = count($array_nuevo);
        $validar['cantidad'] = $cantidad;
        $id_g = (int) $id_guia[0]->id;
        $serie_guia = $id_guia[0]->varSerieDocu;
        $idguia = str_pad($id_g, 7, '0', STR_PAD_LEFT);
        for ($i = 0; count($array_nuevo) > $i; $i++) {
            $id_g = $id_g + 1;
            $idguia = str_pad($id_g, 7, '0', STR_PAD_LEFT);
            $documento_guia = $serie_guia . '' . $idguia;
            $validar['docu'][] .= $documento_guia;
        }
        return $this->successResponse($validar);
    }

    public function crear_guia(Request $request) {
        DB::beginTransaction();
        try {
            $validar = array('id' => array(), 'mensaje_alternativo' => '');
            $regla = [
                'intIdDesp' => 'required|max:255',
                'intIdCliente' => 'required|max:255',
                'varIdDistrito' => 'required|max:255',
                'varIdProvincia' => 'required|max:255',
                'intIdEsta' => 'required|max:255',
                'varIdDepa' => 'required|max:255',
                'varNombChof' => 'required|max:255',
                'varNumeChof' => 'required|max:12',
                'varNumeLicen' => 'required|max:12',
                'intIdTrans' => 'required|max:255',
                'intIdProy' => 'required|max:255',
                'intIdTipoProducto' => 'required|max:255',
                'dateFechEmis' => 'required|max:255',
                'dateFechTras' => 'required',
                'varTipoGuia' => 'required|max:255',
                'intIdMoti' => 'required|max:255',
                'varPuntSali' => 'required|max:255',
                'varPuntLleg' => 'required|max:255',
                'varPlaca' => 'required|max:255',
                'acti_usua' => 'required|max:255',
                'intIdProyZona' => 'required|max:255',
                'varBulto' => 'required|max:255',
                'intIdTipoGrupo' => 'required|max:255',
                'varIdDistritoSali' => 'required|max:255',
                'varIdProvinciaSali' => 'required|max:255',
                'varIdDepaSali' => 'required|max:255',
                'codigos_label',
                'v_informacion'
            ];
            $this->validate($request, $regla);
            $intIdProyZona = (int) $request->input('intIdProyZona');
            $intIdTipoGrupo = (int) $request->input('intIdTipoGrupo');
            $varBulto = $request->input('varBulto');
            $intIdDesp = (int) $request->input('intIdDesp');
            $tipo_reporte = (int) $request->input('tipo_reporte');
            $intIdCliente = (int) $request->input('intIdCliente'); //
            $varIdDistrito = $request->input('varIdDistritoSali'); //
            $varIdProvincia = $request->input('varIdProvinciaSali'); //
            $varIdDepa = $request->input('varIdDepaSali'); //

            $varIdDistritoSali = $request->input('varIdDistrito'); //
            $varIdProvinciaSali = $request->input('varIdProvincia'); //
            $varIdDepaSali = $request->input('varIdDepa'); //
            //dd($varIdDepa,$varIdProvincia,$varIdDistrito,$varIdDepaSali,$varIdProvinciaSali,$varIdDistritoSali);
            $varNombChof = $request->input('varNombChof'); //
            $varNumeChof = $request->input('varNumeChof'); //
            $varNumeLicen = $request->input('varNumeLicen'); //
            $intIdTrans = (int) $request->input('intIdTrans'); //
            $intIdProy = (int) $request->input('intIdProy'); //
            $intIdTipoProducto = (int) $request->input('intIdTipoProducto'); //
            $dateFechEmis = $request->input('dateFechEmis'); //
            $dateFechTras = $request->input('dateFechTras'); //
            $varTipoGuia = $request->input('varTipoGuia'); //
            $intIdMoti = (int) $request->input('intIdMoti'); //
            $varPuntSali = $request->input('varPuntSali'); //
            $varRefe = $request->input('varRefe'); //
            $varPuntLleg = $request->input('varPuntLleg'); //
            $intIdEsta = (int) $request->input('intIdEsta');
            $varPlaca = $request->input('varPlaca'); //
            $acti_usua = $request->input('acti_usua'); //
            $items_codigo = trim($request->input('codigos_label'), ',');
            $v_informacion = json_decode($request->input('v_informacion'));
            //dd($v_informacion);
            $varMotiCome = $request->input('varMotiCome'); //

            $varTituGuia = $request->input('varTituGuia'); //coloco andy
            /* dd(
              $intIdDesp, $intIdCliente, $intIdDistrito, $intIdProvincia, $intIdDepa, $intIdChofer, $intIdTrans, $intIdProy, $intIdTipoProducto, $dateFechEmis, $dateFechTras, $varTipoGuia, $intIdMoti, $intIdPlanta, $varRefe, $varPuntLleg, $varPlaca, $acti_usua
              , $v_informacion); */

            date_default_timezone_set('America/Lima'); // CDT
            $v_fecha = $current_date = date('Y-m-d H:i:s');
            $cant = $v_informacion[0]->cantidad;
            $contador_variable = 0;
            $array_nuevo = "";
            $codigos = "";
            $id_guia = [];
            $cantidad_total = 0;
            $array_series_cant = [];
            /* REALIZAMOS EL CONTEO DE LOS ELEMENTOS SELECCIONADOS */
            for ($can = 0; count($v_informacion) > $can; $can++) {
                $cantidad_total = $cantidad_total + (int) $v_informacion[$can]->cantidad;
            }
            //dd($cantidad_total);
            /* VALIDAMOS EN QUE SITUACIÓN SE ENCUENTRA TERMINADO , PENDIENTE O PARCIAL */
            /* ESTADO PARCIAL */
            //dd($intIdEsta);

            if ($intIdEsta === 28) {
                $contar_de_despacho = DB::select("select count(e.varGuia) as cantidadtotal from tab_desp tb 
                                                inner join elemento e on tb.intIdDesp=e.intIdDespacho and 
                                                tb.intIdProy=e.intIdProy and tb.intIdTipoProducto=e.intIdTipoProducto 
                                                where e.varGuia='' and e.intIdDespacho=$intIdDesp and tb.intIdProy=$intIdProy and tb.intIdTipoProducto=$intIdTipoProducto");

                if ((int) $contar_de_despacho[0]->cantidadtotal === (int) $cantidad_total) {
                    $affected = DB::update("update tab_desp set intIdEsta =27 where intIdDesp =? and intIdProy=? and intIdTipoProducto=?", [$intIdDesp, $intIdProy, $intIdTipoProducto]);
                } else {
                    $affected = DB::update("update tab_desp set intIdEsta =28 where intIdDesp =? and intIdProy=? and intIdTipoProducto=?", [$intIdDesp, $intIdProy, $intIdTipoProducto]);
                }
            } else if ($intIdEsta === 26) {
                $contar_de_despacho = DB::select("select cantidadtotal from tab_desp where intIdDesp=$intIdDesp and intIdProy=$intIdProy and intIdTipoProducto=$intIdTipoProducto");

                if ((int) $contar_de_despacho[0]->cantidadtotal === (int) $cantidad_total) {
                    $affected = DB::update("update tab_desp set intIdEsta =27 where intIdDesp =? and intIdProy=? and intIdTipoProducto=?", [$intIdDesp, $intIdProy, $intIdTipoProducto]);
                } else {
                    $affected = DB::update("update tab_desp set intIdEsta =28 where intIdDesp =? and intIdProy=? and intIdTipoProducto=?", [$intIdDesp, $intIdProy, $intIdTipoProducto]);
                }
            }
            ///CODIGO PARA PODER SEPARAR LA INFORMACION SI SON MAS DE 32 FILAS
            $array_nuevo = array_chunk($v_informacion, 32, false);
            //dd($array_nuevo);
            /* VALIDAMOS SI ES PARCIAL TERMINADO O TERMINADO */
            //dd($array_nuevo);
            for ($x = 0; count($array_nuevo) > $x; $x++) {
                $id_guia = DB::select("select ifnull(max(intContaDocu),0)+1  as id,varSerieDocu   from tab_docu where intIdEsta=3 and intIdDocu=1");
                $id_g = (int) $id_guia[0]->id;
                $serie_guia = $id_guia[0]->varSerieDocu;
                $idguia = str_pad($id_g, 7, '0', STR_PAD_LEFT);
                $documento_guia = $serie_guia . '' . $idguia;
                $id = guia::create(['intIdDesp' => $intIdDesp,
                            'varContaDocu' => $documento_guia,
                            'intIdEsta' => 30,
                            'intIdCliente' => $intIdCliente,
                            'varIdDistrito' => $varIdDistrito,
                            'varIdProvincia' => $varIdProvincia,
                            'varIdDepa' => $varIdDepa,
                            'varIdDistritoSali' => $varIdDistritoSali,
                            'varIdProvinciaSali' => $varIdProvinciaSali,
                            'varIdDepaSali' => $varIdDepaSali,
                            'varNombChof' => $varNombChof,
                            'varNumeChof' => $varNumeChof,
                            'varNumeLicen' => $varNumeLicen,
                            'intIdTrans' => $intIdTrans,
                            'intIdProy' => $intIdProy,
                            'intIdTipoProducto' => $intIdTipoProducto,
                            'dateFechEmis' => $dateFechEmis,
                            'dateFechTras' => $dateFechTras,
                            'varTipoGuia' => $varTipoGuia,
                            'intIdMoti' => $intIdMoti,
                            'varPuntSali' => $varPuntSali,
                            'varPuntLleg' => $varPuntLleg,
                            'varPlaca' => $varPlaca,
                            'varRefe' => $varRefe,
                            'acti_usua' => $acti_usua,
                            'acti_hora' => $v_fecha,
                            'varMotiCome' => $varMotiCome,
                            'varTituGuia' => $varTituGuia]);
                $id_final = $id['intIdGuia'];
                $validar['id'][] .= $id_final;
                tab_docu::where('intIdDocu', '=', 1)->where('intIdEsta', '=', 3)->update(['intContaDocu' => $id_g]);
                if ($tipo_reporte === 1) {
                    for ($j = 0; count($array_nuevo[$x]) > $j; $j++) {
                        Elemento::where('intIdDespacho', '=', $array_nuevo[$x][$j]->intIdDesp)
                                ->where('varCodiElemento', '=', $array_nuevo[$x][$j]->varCodiElemento)
                                ->where('intIdProy', '=', $intIdProy)
                                ->where('intIdTipoProducto', '=', $intIdTipoProducto)
                                ->where('intIdProyTarea', '=', $array_nuevo[$x][$j]->intIdProyTarea)
                                ->where('intIdProyZona', '=', $array_nuevo[$x][$j]->intIdProyZona)
                                ->where('varModelo', '=', $array_nuevo[$x][$j]->varModelo)
                                ->where('varPerfil', '=', $array_nuevo[$x][$j]->varPerfil)
                                ->where('varGuia', '=', '')
                                ->where('varBulto', '=', $array_nuevo[$x][$j]->varBulto)
                                /* ->limit($array_nuevo[$x][$j]->cantidad) */
                                ->update(['varUnidMedi' => $array_nuevo[$x][$j]->Unidad_Medida, 'nume_guia' => $documento_guia, 'varGuia' => (int) $id_final]);
                    }
                } else {
                    for ($j = 0; count($array_nuevo[$x]) > $j; $j++) {
                        Elemento::where('intIdDespacho', '=', $array_nuevo[$x][$j]->intIdDesp)
                                ->where('intSerie', '=', $array_nuevo[$x][$j]->intSerie)
                                ->where('intIdProy', '=', $intIdProy)
                                ->where('intIdTipoProducto', '=', $intIdTipoProducto)
                                ->where('varCodiElemento', '=', $array_nuevo[$x][$j]->varCodiElemento)
                                ->where('intIdProyTarea', '=', $array_nuevo[$x][$j]->intIdProyTarea)
                                ->where('intIdProyZona', '=', $array_nuevo[$x][$j]->intIdProyZona)
                                ->where('varModelo', '=', $array_nuevo[$x][$j]->varModelo)
                                ->where('varPerfil', '=', $array_nuevo[$x][$j]->varPerfil)
                                ->where('varGuia', '=', '')
                                ->where('varBulto', '=', $array_nuevo[$x][$j]->varBulto)->update(['varUnidMedi' => $array_nuevo[$x][$j]->Unidad_Medida, 'nume_guia' => $documento_guia, 'varGuia' => (int) $id_final]);
                    }
                }
            }
            $validar['mensaje_alternativo'] = 'sin error';
            DB::commit();
            //dd($validar['id']);
            return $this->successResponse($validar);
        } catch (\Exception $e) {
            $validar = array('id' => array(), 'mensaje_alternativo' => '');
            DB::rollback();
            $validar['mensaje_alternativo'] = 'error';
            return $this->successResponse($validar);
        }
    }

    public function create_despacho(Request $request) {
        /* $regla = [
          'v_intIdproy' => 'required|max:255',
          'v_intIdTipoProducto' => 'required|max:255',
          ];

          $this->validate($request, $regla); */
        DB::beginTransaction();
        try {

            $validar = array('mensaje' => array(), 'mensaje_alternativo' => '');
            $regla = [
                'v_intIdproy' => 'required|max:255',
                'v_intIdTipoProducto' => 'required|max:255',
            ];
            date_default_timezone_set('America/Lima'); // CDT
            $this->validate($request, $regla);
            $v_usuario = $request->input('v_usuario');
            $v_intIdproy = (int) $request->input('v_intIdproy'); //
            $v_intIdTipoProducto = (int) $request->input('v_intIdTipoProducto'); //
            $v_strDeObser = ""; //
            $v_intIdMaqui = ""; //
            $v_strBulto = ""; //
            $v_intIdPeriValo = (int) $request->input('v_intIdPeriValo'); //
            $v_intIdInspe = (int) $request->input('v_intIdInspe'); //
            $v_varValoEtapa = $request->input('v_varValoEtapa'); //
            $v_varCodiTipoEtap = $request->input('v_varCodiTipoEtap');
            $v_boolDesp = (int) $request->input('v_boolDesp');
            $v_tinFlgConforForzosa = (int) $request->input('v_tinFlgConforForzosa');
            $v_strDefecto = trim($request->input('v_strDefecto'), ',');
            $v_strCausa = trim($request->input('v_strCausa'), ',');
            $strEstadoInspe = $request->input('strEstadoInspe');
            $v_intIdDespa = (int) $request->input('v_intIdDespa');
            $deciTotaPesoNeto = (float) $request->input('deciTotaPesoNeto');
            $deciTotaPesoBruto = (float) $request->input('deciTotaPesoBruto');
            $deciTotaArea = (float) $request->input('deciTotaArea');
            $cantidadtotal = (int) $request->input('cantidadtotal');
            $v_intIdAsigEtapProy = (int) $request->input('v_intIdAsigEtapProy');
            $v_informacion = json_decode($request->input('v_informacion'));
            //dd($v_informacion);
            $v_varNumeroGuia = "";
            $v_fech_avan = $current_date = date('Y-m-d H:i:s');
            $v_intIdContr = (int) $request->input('v_intIdContr');
            if ($request->input('v_intIdSuper') == "NaN") {
                $v_intIdSuper = null;
            } else {
                $v_intIdSuper = (int) $request->input('v_intIdSuper');
            }
            if ($request->input('v_strDeObser') == '' || $request->input('v_strDeObser') == null) {
                $v_strDeObser = '';
            } else {
                $v_strDeObser = $request->input('v_strDeObser');
            }
            if ($request->input('v_intIdMaqui') == "NaN") {
                $v_intIdMaqui = null;
            } else {
                $v_intIdMaqui = (int) $request->input('v_intIdMaqui');
            }
            if ($request->input('v_strBulto') == "") {
                $v_strBulto = '';
            } else {
                $v_strBulto = $request->input('v_strBulto');
            }
            if ($request->input('v_varNumeroGuia') == "") {
                $v_varNumeroGuia = '';
            } else {
                $v_varNumeroGuia = $request->input('v_varNumeroGuia');
            }
            $id_despacho = DB::select("select ifnull(max(intIdDesp),0)+1  as id   from tab_desp where intIdProy=$v_intIdproy and intIdTipoProducto=$v_intIdTipoProducto");
            $id = (int) $id_despacho[0]->id;
            $insert_causa = DB::insert('insert into tab_desp(intIdDesp,intIdProy,intIdTipoProducto,deciTotaPesoNeto,deciTotaPesoBruto,deciTotaArea,cantidadtotal,intIdEsta,acti_usua,acti_hora) values(?,?,?,?,?,?,?,?,?,?)', [$id, $v_intIdproy, $v_intIdTipoProducto, $deciTotaPesoNeto, $deciTotaPesoBruto, $deciTotaArea, $cantidadtotal, 26, $v_usuario, $v_fech_avan]);
            $v_intIdEtapaActual = "";
            $v_varCodiElemento = "";
            $v_nCanti = "";
            $v_intNuRevis = "";
            $v_intIdProyZona = "";
            $v_intIdProyTarea = "";
            $v_intIdProyPaquete = "";
            $v_deciPrec = "";
            $v_intIdEtapaAnt = "";
            $v_intIdEtapaSig = "";
            $v_intIdRuta = "";
            $v_Series = "";
            $v_intNuConta = "";
            foreach ($v_informacion as $index) {
                $Pintura = $index->{"Pintura"};
                $DocEnvioTS = $index->{"DocEnvioTS"};
                $v_intIdEtapaActual = (int) $index->{"intidetapa"};
                $v_varCodiElemento = $index->{"varCodiElemento"};
                $v_nCanti = (int) $index->{'Canti'};
                $v_intNuConta = (int) $index->{"intCantRepro"}; // incantrepro
                $tipo_reporte = (int) $index->{"tipo_reporte"};
                $v_intNuRevis = (int) $index->{"intRevision"};
                $v_intIdProyZona = (int) $index->{"intIdProyZona"};
                $v_intIdProyTarea = (int) $index->{"intIdProyTarea"};
                $v_intIdProyPaquete = (int) $index->{"intIdProyPaquete"};
                $v_intIdEtapaAnt = (int) $index->{"intIdEtapaAnte"};
                $v_intIdEtapaSig = (int) $index->{"intIdEtapaSiguiente"};
                $v_intIdRuta = (int) $index->{"intIdRuta"};
                $intIdEsta = (int) $index->{"intIdEsta"};
                if ($index->{"deciPrec"} == 0) {
                    $v_deciPrec = 0;
                } else {
                    $v_deciPrec = $index->{"deciPrec"};
                }
                if (!isset($index->{"varcodelement"})) {

                    $v_Series = '';
                } else {

                    $v_Series = trim($index->{"varcodelement"}, ',');
                }
                $Obs1 = $index->{'Obs1'};
                $obs2 = $index->{'obs2'};
                $obs3 = $index->{'obs3'};
                $obs4 = $index->{'obs4'};
                /* dd($v_intIdproy, //
                  $v_intIdTipoProducto, //
                  $v_intIdEtapaActual, //
                  $v_varCodiElemento, //
                  $v_nCanti, //
                  $v_fech_avan, //
                  $v_intIdContr, //
                  $v_intNuConta,
                  $v_intNuRevis, //
                  $v_intIdSuper,
                  $v_intIdProyZona, //
                  $v_intIdProyTarea, //
                  $v_intIdProyPaquete, //
                  $v_deciPrec, //
                  $v_intIdEtapaAnt, //
                  $v_intIdEtapaSig, //
                  $v_strDeObser, //
                  $v_intIdMaqui, //
                  $v_Series, //
                  $v_strBulto, //
                  $v_intIdPeriValo, //
                  $v_usuario, //
                  $v_intIdInspe, //
                  $v_intIdRuta, //
                  $v_varValoEtapa, //
                  $v_varCodiTipoEtap, //
                  $v_boolDesp, //
                  $v_intIdAsigEtapProy, //
                  $v_varNumeroGuia, //
                  $intIdEsta,
                  $v_tinFlgConforForzosa,
                  $v_strDefecto,
                  $v_strCausa,
                  $strEstadoInspe,
                  $id,
                  $DocEnvioTS,
                  $Pintura,
                  $Obs1,
                  $obs2,
                  $obs3,
                  $obs4); */
                DB::select('CALL sp_avance_P02(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,@mensaje1)', array(
                    $v_intIdproy, //
                    $v_intIdTipoProducto, //
                    $v_intIdEtapaActual, //
                    $v_varCodiElemento, //
                    $v_nCanti, //
                    $v_fech_avan, //
                    $v_intIdContr, //
                    $v_intNuConta,
                    $v_intNuRevis, //
                    $v_intIdSuper,
                    $v_intIdProyZona, //
                    $v_intIdProyTarea, //
                    $v_intIdProyPaquete, //
                    $v_deciPrec, //
                    $v_intIdEtapaAnt, //
                    $v_intIdEtapaSig, //
                    $v_strDeObser, //
                    $v_intIdMaqui, //
                    $v_Series, //
                    $v_strBulto, //
                    $v_intIdPeriValo, //
                    $v_usuario, //
                    $v_intIdInspe, //
                    $v_intIdRuta, //
                    $v_varValoEtapa, //
                    $v_varCodiTipoEtap, //
                    $v_boolDesp, //
                    $v_intIdAsigEtapProy, //
                    $v_varNumeroGuia, //
                    $intIdEsta,
                    $v_tinFlgConforForzosa,
                    $v_strDefecto,
                    $v_strCausa,
                    $strEstadoInspe,
                    $id,
                    $DocEnvioTS,
                    $Pintura,
                    $Obs1,
                    $obs2,
                    $obs3,
                    $obs4,
                    0
                ));

                $results = DB::select('select @mensaje1');
                //dd($results);
                if (count($results) == 0) {
                    $results = "";
                } else {
                    $results = $results[0]->{"@mensaje1"};
                }
                //dd($results);
                $validar['mensaje'][] .= $results;
            }
            //
            //dd(count($validar));
            if (count($validar) > 0) {
                if ($validar['mensaje'][0] === "" || $validar['mensaje'][0] === null) {
                    $validar['mensaje_alternativo'] = 'sin error';
                    DB::commit();
                    return $this->successResponse($validar);
                } else {
                    throw new \Exception('error forzoso');
                }
            }
        } catch (\Exception $e) {
            DB::rollback();
            $validar['mensaje_alternativo'] = 'error';
            $validar['mensaje'][] .= 'No se registro el Avance';
            return $this->successResponse($validar);
        }
    }

    /**
     * @OA\Post(
     *      path="/Asignaciones/public/index.php/envi_valo_cod",
     *      tags={"Reporte avance"},
     *     summary="obtiene datos del usuario a través del dni",
     *     @OA\Parameter(
     *         description="ingrese el id etapa",
     *         in="path",
     *         name="intIdEtapa",
     *       example="1",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="ingrese el id etapa",
     *         in="path",
     *         name="intIdProy",
     *       example="126",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
      @OA\Parameter(
     *         description="ingrese el id del tipo producto",
     *         in="path",
     *         name="intIdTipoProducto",
     *       example="1",
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
     *                 @OA\Property(
     *                     property="intIdTipoProducto",
     *                     type="string"
     *                 ) ,
     *                 @OA\Property(
     *                     property="intIdProy",
     *                     type="string"
     *                 ) ,
     *                 example={"intIdEtapa": "1","intIdTipoProducto":"1","intIdProy":"126"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Enviar Codigo Tipo Etapa"
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
    public function envi_valo_cod(Request $request) {
        $regla = [
            'intIdEtapa' => 'required|max:255',
            'intIdProy' => 'required|max:255',
            'intIdTipoProducto' => 'required|max:255'
        ];
        $this->validate($request, $regla);
        $intIdEtapa = $request->input('intIdEtapa');
        $intIdProy = $request->input('intIdProy');
        $intIdTipoProducto = $request->input('intIdTipoProducto');
        $valida_etapa = Etapa::join('tipoetapa', 'tipoetapa.intIdTipoEtap', '=', 'etapa.intIdTipoEtap')
                ->join('asig_etap_proy', 'asig_etap_proy.intIdEtapa', '=', 'etapa.intIdEtapa')
                ->select('etapa.intIdEtapa', 'etapa.varDescEtap', 'etapa.intIdTipoEtap', 'tipoetapa.varCodiTipoEtap', 'tipoetapa.varDescTipoEtap', 'etapa.varValoEtapa', 'etapa.boolDesp', 'asig_etap_proy.intIdAsigEtapProy')
                ->where('asig_etap_proy.intIdEtapa', '=', $intIdEtapa)
                ->where('asig_etap_proy.intIdProy', '=', $intIdProy)
                ->where('asig_etap_proy.intIdTipoProducto', '=', $intIdTipoProducto)
                ->get();
        return $this->successResponse($valida_etapa);
    }

    /**
     * @OA\Post(
     *     path="/Asignaciones/public/index.php/store_camb_esta_proc_term",
     *    tags={"Reporte avance"},
     *     summary="cambio el estado del proceso a terminado",
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
     *     @OA\Parameter(
     *         description="Ingrese el id tipo del producto",
     *         in="path",
     *         name="v_intIdTipoProducto",
     *     example="1",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
      @OA\Parameter(
     *         description="Ingrese el id tipo del producto",
     *         in="path",
     *         name="v_intIdPaque",
     *     example="1",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
     *  @OA\Parameter(
     *         description="Ingrese el usuario que va realizar el proceso",
     *         in="path",
     *         name="v_usuario",
     *     example="usuarios_usuario",
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
      @OA\Property(
     *                     property="v_intIdTipoProducto",
     *                     type="string"
     *                 ) ,
     * 
     *                 @OA\Property(
     *                     property="v_intIdPaque",
     *                     type="string"
     *                 ) ,
      @OA\Property(
     *                     property="v_usuario",
     *                     type="string"
     *                 ) ,
     *                 example={"v_intIdproy": "126","v_intIdTipoProducto":"1","v_intIdPaque":"1","v_usuario":"usuarios_usuario"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sin Mensaje"
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
    public function store_camb_esta_proc_term(Request $request) {
        $regla = [
            'v_intIdproy' => 'required|max:255',
            'v_intIdTipoProducto' => 'required|max:255',
            'v_intIdPaque' => 'required|max:255',
            'v_usuario' => 'required|max:255',
        ];
        $this->validate($request, $regla);
        date_default_timezone_set('America/Lima');


        $v_intIdproy = (int) $request->input('v_intIdproy');
        $v_intIdTipoProducto = (int) $request->input('v_intIdTipoProducto');
        $v_intIdPaque = $request->input('v_intIdPaque');
        $v_usuario = $request->input('v_usuario');
        $v_fecha = $current_date = date('Y-m-d H:i:s');





        $result = DB::select('CALL sp_paque_V02 (?,?,?,?,?)', array($v_intIdproy,
                    $v_intIdTipoProducto,
                    $v_intIdPaque,
                    $v_usuario,
                    $v_fecha,
        ));
        return $this->successResponse($result);
    }

    /**
     * @OA\Post(
     *     path="/Asignaciones/public/index.php/etapa_obte_cola",
     *     tags={"Reporte avance"},
     *     summary="permite obtener el colaborador mediante el idetapa",
     *     @OA\Parameter(
     *         description="Ingrese el idEtapa",
     *         in="path",
     *         name="intIdEtapa",
     *       example="1",
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
     *                 example={"intIdEtapa": "1"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description=" obtener el colaborador mediante el idetapa"
     *     ),
     *     
     *     @OA\Response(
     *         response=404,
     *         description="No se encuentra el metodo"
     *     )
     * )
     */
    public function etapa_obte_cola(Request $request) {
        $regla = [
            'intIdEtapa' => 'required|max:255'
        ];
        $this->validate($request, $regla);
        $intIdEtapa = $request->input('intIdEtapa');
        $obtne_colaborador = Agrupador::join('deta_agru_supe', 'agrupador.intIdAgru', '=', 'deta_agru_supe.intIdAgru')
                ->join('colaborador', 'colaborador.intIdColaborador', '=', 'deta_agru_supe.intIdColaborador')
                ->leftjoin('tipoetapa', 'agrupador.intIdAgru', '=', 'tipoetapa.intIdAgru')
                ->leftjoin('etapa', 'etapa.intIdTipoEtap', '=', 'tipoetapa.intIdTipoEtap')
                ->where('etapa.intIdEtapa', '=', $intIdEtapa)
                ->select('deta_agru_supe.intIdColaborador', DB::raw('CONCAT(colaborador.varNombColabo," ",colaborador.varApelColabo) AS nombre'))
                ->get();

        return $this->successResponse($obtne_colaborador);
    }

    /**
     * @OA\Post(
     *     path="/Asignaciones/public/index.php/etapa_obte_cont",
     *     tags={"Reporte avance"},
     *     summary="permite obtener le contratista mediante el idetapa",
     *     @OA\Parameter(
     *         description="Ingrese el id del tipo etapa",
     *         in="path",
     *         name="intIdTipoEtap",
     *       example="1",
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
     *                     property="intIdTipoEtap",
     *                     type="string"
     *                 ) ,
     *                 example={"intIdTipoEtap": "1"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description=" obtener el colaborador mediante el idetapa"
     *     ),
     *     
     *     @OA\Response(
     *         response=404,
     *         description="No se encuentra el metodo"
     *     )
     * )
     */
    public function etapa_obte_cont(Request $request) {
        $regla = [
            'intIdTipoEtap' => 'required|max:255'
        ];
        $this->validate($request, $regla);
        $intIdTipoEtap = $request->input('intIdTipoEtap');
        $obtner_descrip = TipoEtapas::where('intIdTipoEtap', '=', $intIdTipoEtap)
                ->first(['varDescTipoEtap', 'intIdTipoEtap']);
        // dd($obtner_descrip['varDescTipoEtap']);
        if ($obtner_descrip['varDescTipoEtap'] == "ESTRUCTURADO") {
            $obtne_colaborador = TipoEtapas::join('agrupador', 'tipoetapa.intIdAgru', '=', 'agrupador.intIdAgru')
                    ->join('deta_agru_cont', 'agrupador.intIdAgru', '=', 'deta_agru_cont.intIdAgru')
                    ->join('contratista', 'deta_agru_cont.intIdCont', '=', 'contratista.intIdCont')
                    ->where('tipoetapa.intIdTipoEtap', '=', $intIdTipoEtap)
                    ->select('contratista.intIdCont', 'contratista.varRazCont')
                    ->get();
        } else {
            $obtne_colaborador = Contratista::select('intIdCont', 'varRazCont')->get();
        }

        return $this->successResponse($obtne_colaborador);
    }

    /**
     * @OA\Post(
     *     path="/Asignaciones/public/index.php/store_obte_peri_valo",
     *     tags={"Reporte avance"},
     *     summary="obtener periodo valorizacion",
     *     @OA\Parameter(
     *         description="Ingrese el id del tipo etapa",
     *         in="path",
     *         name="acti_usua",
     *       example="andy_ancajima",
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
     *                     property="acti_usua",
     *                     type="string"
     *                 ) ,
     *                 example={"acti_usua": "andy_ancajima"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description=" obtener el colaborador mediante el idetapa"
     *     ),
     *     
     *     @OA\Response(
     *         response=404,
     *         description="No se encuentra el metodo"
     *     )
     * )
     */
    public function store_obte_peri_valo(Request $request) {
        $regla = [
            'acti_usua' => 'required|max:255',
        ];
        $this->validate($request, $regla);
        date_default_timezone_set('America/Lima');
        $acti_usua = $request->input('acti_usua');

        $date = date('Y-m-d');
        $datetime = $current_date = date('Y-m-d H:i:s');


        DB::select('CALL sp_PeriodoValorizacion_V01(?,?,?,@v_Existe,@v_idPeriodo,@v_estado)', array($date,
            $acti_usua,
            $datetime
        ));

        $results = DB::select('select @v_Existe,@v_idPeriodo,@v_estado');
        return $this->successResponse($results);
    }

    /* public function store_repo_libe(Request $request) {
      $regla = [
      'v_intIdproy' => 'required|max:255',
      'v_intIdTipoProducto' => 'required|max:255',
      'v_intIdZona' => 'required|max:255',
      'v_intIdTarea' => 'required|max:255',
      'v_intIdEtapaInspeccion' => 'required|max:255',
      'v_strCodigo' => 'required|max:255',
      'v_intIdInspector' => 'required|max:255',
      'v_dttFechaIni' => 'required|max:255',
      'v_dttFechaFin' => 'required|max:255',
      'v_TipoInspec' => 'required|max:255',
      'v_Contratista' => 'required|max:255',
      'v_TipoReporte' => 'required|max:255'
      ];
      //dd($regla);
      $this->validate($request, $regla);

      $v_intIdproy = (int) $request->input('v_intIdproy');
      $v_intIdTipoProducto = (int) $request->input('v_intIdTipoProducto');
      $v_intIdZona = (int) $request->input('v_intIdZona');
      $v_intIdTarea = (int) $request->input('_intIdTarea');
      $v_intIdEtapaInspeccion = (int) $request->input('v_intIdEtapaInspeccion');
      $v_strCodigo = $request->input('v_strCodigo');
      $v_intIdInspector = (int) $request->input('v_intIdInspector');
      $v_dttFechaIni = $request->input('v_dttFechaIni');
      $v_dttFechaFin = $request->input('v_dttFechaFin');
      $v_TipoInspec = (int) $request->input('v_TipoInspec');
      $v_Contratista = (int) $request->input('v_Contratista');
      $v_TipoReporte = (int) $request->input('v_TipoReporte');

      dd( $v_intIdproy,
      $v_intIdTipoProducto,
      $v_intIdZona,
      $v_intIdTarea,
      $v_intIdEtapaInspeccion,
      $v_strCodigo,
      $v_intIdInspector,
      $v_dttFechaIni,
      $v_dttFechaFin,
      $v_TipoInspec,
      $v_Contratista,
      $v_TipoReporte);


      $results = DB::select('CALL sp_Inspecciones_Q01(?,?,?,?,?,?,?,?,?,?,?,?)', array(
      $v_intIdproy,
      $v_intIdTipoProducto,
      $v_intIdZona,
      $v_intIdTarea,
      $v_intIdEtapaInspeccion,
      $v_strCodigo,
      $v_intIdInspector,
      $v_dttFechaIni,
      $v_dttFechaFin,
      $v_TipoInspec,
      $v_Contratista,
      $v_TipoReporte
      ));


      return $this->successResponse($results);
      } */
}
