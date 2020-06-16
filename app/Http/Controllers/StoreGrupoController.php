<?php

namespace App\Http\Controllers;

use App\Proyectozona;
use App\Proyecto;
use App\AsignarEtapa;
use App\Rutaproyecto;
use App\Detalleruta;
use App\Elemento;
use App\Componente;
use App\Despacho;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StoreGrupoController extends Controller {

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
    //visu_repo_comp

    /**
     * @OA\Post(
     *     path="/Asignaciones/public/index.php/conv_store_en_micro",
     *     tags={"Store Grupo"},
     *     summary="convertir de store en microservicios",
     *     @OA\Parameter(
     *         description="ingrese el id proyectos",
     *         in="path",
     *         name="intIdProy",
     *        example="126",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="Ingrese el id tipo producto",
     *         in="path",
     *         name="intIdTipoProducto",
     *       example="1",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
     *     
     *  *     @OA\Parameter(
     *         description="Ingrese el id proyecto paquete",
     *         in="path",
     *         name="intIdProyPaquete",
     *       example="125",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="varNumeDni",
     *                     type="string"
     *                 ) ,
     *                 example={"intIdProy": "126","intIdTipoProducto":"1","intIdProyPaquete":"125"}
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
    public function conv_store_en_micro(Request $request) {

        $regla = [
            'intIdProy' => 'required|max:255',
            'intIdTipoProducto' => 'required|max:255',
            'intIdProyPaquete' => 'required|max:255'
        ];
        $this->validate($request, $regla);

        $intIdProy = $request->input('intIdProy');
        $intIdTipoProducto = $request->input('intIdTipoProducto');
        $intIdProyPaquete = $request->input('intIdProyPaquete');


        $store_en_eloquent = DB::select("select ELECANT.proyecto,
                                                ELECANT.Zona, 
                                                ELECANT.Programa,
                                                ELECANT.Grupo,
                                                ELECANT.Cod_elemento,
                                                ELECANT.Descripcion,
                                                ELECANT.canti,
                                                ELECANT.PesoNetoElemento,
                                                ELECANT.PesoBrutoElemento,
                                                ELECANT.AreaElemento,
                                                C.varComponente as Cod_Componente,
                                                C.varDescripcion as Nom_Componente,
                                                C.intCantidad * ELECANT.canti as Cant_Componente,
                                                C.varMaterial as Material,
                                                C.varPerfil as Perfil,
                                                C.deciLong as Longitud,
                                                C.deciPesoNeto as PesoNetoCompo,
                                                C.deciPesoBruto as PesoBrutoCompo,
                                                C.deciArea as AreaCompo,
                                                ELECANT.intIdProyPaquete
                                                from componente AS C  INNER JOIN 
                                                (SELECT concat_ws(' / ', P.varCodiProy, P.varAlias) AS proyecto ,
                                                PZ.varDescrip as Zona, 
                                                PT.varDescripTarea as Programa,
                                                PP.varCodigoPaquete as Grupo,
                                                E.varCodiElemento as Cod_elemento,
                                                E.varDescripcion as Descripcion,
                                                count(E.intIdEleme) as canti,
                                                E.deciPesoNeto as PesoNetoElemento,
                                                E.deciPesoBruto as PesoBrutoElemento,
                                                E.deciArea as AreaElemento,
                                                E.intIdProyPaquete
                                                FROM elemento E INNER JOIN proyecto as P on 
                                                E.intIdProy = P.intIdProy INNER JOIN proyecto_zona as PZ  on
                                                E.intIdProyZona = PZ.intIdProyZona INNER JOIN proyecto_tarea as PT on 
                                                E.intIdProyTarea = PT.intIdProyTarea INNER JOIN proyecto_paquetes AS PP on
                                                E.intIdProyPaquete = PP.intIdProyPaquete 
                                                WHERE E.intIdProy ='$intIdProy' AND E.intIdTipoProducto = '$intIdTipoProducto'  AND E.intIdProyPaquete = '$intIdProyPaquete'
                                                group by P.varCodiProy, varAlias, PZ.varDescrip, PT.varDescripTarea,
                                                PP.varCodigoPaquete, E.varCodiElemento, E.varDescripcion,E.deciPesoNeto, E.deciPesoBruto,E.deciArea ,
                                                E.intIdProyPaquete
                                                ) as ELECANT ON C.varCodiElemento = ELECANT.Cod_elemento
                                                WHERE C.intIdProy = '$intIdProy' AND C.intIdTipoProducto = '$intIdTipoProducto'  AND ELECANT.intIdProyPaquete = '$intIdProyPaquete'
                                                GROUP BY 
                                                ELECANT.proyecto,
                                                ELECANT.Zona, 
                                                ELECANT.Programa,
                                                ELECANT.Grupo,
                                                ELECANT.Cod_elemento,
                                                ELECANT.Descripcion,
                                                ELECANT.canti,
                                                ELECANT.PesoNetoElemento,
                                                ELECANT.PesoBrutoElemento,
                                                ELECANT.AreaElemento,
                                                C.varComponente,
                                                C.varDescripcion,
                                                 C.intCantidad * ELECANT.canti  ,
                                                C.varMaterial ,
                                                C.varPerfil  ,
                                                C.deciLong  ,
                                                C.deciPesoNeto  ,
                                                C.deciPesoBruto  ,
                                                C.deciArea ,
                                                ELECANT.intIdProyPaquete");

        return $this->successResponse($store_en_eloquent);
    }

    /**
     * @OA\Post(
     *     path="/Asignaciones/public/index.php/store_avan",
     *     tags={"Store Grupo"},
     *     summary="store de avance",
     *     @OA\Parameter(
     *         description="ingresar el id del proyecto",
     *         in="path",
     *         name="v_intIdproy",
     *    example="126",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="ingresar el id tipo producto",
     *         in="path",
     *         name="v_intIdTipoProducto",
     *       example="1",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
     *        
     * 
     *     @OA\Parameter(
     *         description="ingrese el id de la zona",
     *         in="path",
     *         name="v_intIdZona",
     *       example="112",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="ingrese el id de la zona",
     *         in="path",
     *         name="v_intIdTarea",
     *       example="10",
     *         required=true,
     *         @OA\Schema(
     *           type="string" 
     *         )
     *     ),

      @OA\Parameter(
     *         description="ingrese el id etapa",
     *         in="path",
     *         name="v_intIdEtapa",
     *       example="4",
     *         required=true,
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
     *                     type="string"
     *                 ) ,
     *                   @OA\Property(
     *                     property="v_intIdTipoProducto",
     *                     type="string"
     *                 ) ,
     *                 @OA\Property(
     *                     property="v_intIdZona",
     *                     type="string"
     *                 ) ,
      @OA\Property(
     *                     property="v_intIdTarea",
     *                     type="string"
     *                 ) ,
     *            @OA\Property(
     *                     property="v_intIdEtapa",
     *                     type="string"
     *                 ) ,
     *                 example={"v_intIdproy": "126","v_intIdTipoProducto":"1","v_intIdZona":"112","v_intIdTarea":"10","v_intIdEtapa":"4"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="store de avance"
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
    public function store_avan(Request $request) {
        $regla = [
            'v_intIdproy' => 'required|max:255',
            'v_intIdTipoProducto' => 'required|max:255',
            'v_intIdZona' => 'required|max:255',
            'v_intIdTarea' => 'required|max:255',
            'v_intIdEtapa' => 'required|max:255'
        ];
        $this->validate($request, $regla);
        $v_intIdproy = $request->input('v_intIdproy');
        $v_intIdTipoProducto = $request->input('v_intIdTipoProducto');
        $v_intIdZona = $request->input('v_intIdZona');
        $v_intIdTarea = $request->input('v_intIdTarea');
        $v_intIdEtapa = $request->input('v_intIdEtapa');
        
        $result = DB::select('CALL sp_avance_Q01(?,?,?,?,?)', array($v_intIdproy,
                    $v_intIdTipoProducto,
                    $v_intIdZona,
                    $v_intIdTarea,
                    $v_intIdEtapa));

       


        return $this->successResponse($result);
    }

    public function update_despacho(Request $request) {
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
            //dd($cantidadtotal);
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


            $id_despacho = DB::select("select * from tab_desp where intIdProy=$v_intIdproy and intIdTipoProducto=$v_intIdTipoProducto and intIdDesp=$v_intIdDespa");
            //dd($id_despacho);
            //dd($id_despacho[0]->deciTotaPesoNeto,$id_despacho[0]->deciTotaPesoBruto,$id_despacho[0]->deciTotaArea,$id_despacho[0]->cantidadtotal);
            $totalpesoneto = (float) $id_despacho[0]->deciTotaPesoNeto + $deciTotaPesoNeto;
            $totalpesobruto = (float) $id_despacho[0]->deciTotaPesoBruto + $deciTotaPesoBruto;
            $totalarea = (float) $id_despacho[0]->deciTotaArea + $deciTotaArea;
            $cantidadtotal_up = (float) $id_despacho[0]->cantidadtotal + $cantidadtotal;
            $estado_despacho = $id_despacho[0]->intIdEsta;
            // dd($estado_despacho);

            date_default_timezone_set('America/Lima'); // CDT
            //dd() $id = (int) $id_despacho[0]->id;
            // $insert_causa = DB::insert('insert into tab_desp(intIdDesp,intIdProy,intIdTipoProducto,deciTotaPesoNeto,deciTotaPesoBruto,deciTotaArea,cantidadtotal,intIdEsta,acti_usua,acti_hora) 
            // values(?,?,?,?,?,?,?,?,?,?)', [$id, $v_intIdproy, $v_intIdTipoProducto, $deciTotaPesoNeto, $deciTotaPesoBruto, $deciTotaArea, $cantidadtotal, 26, $v_usuario, $v_fech_avan]);

            if ($estado_despacho === 27) {
                Despacho::where('intIdproy', '=', $v_intIdproy)
                        ->where('intIdTipoProducto', '=', $v_intIdTipoProducto)
                        ->where('intIdDesp', '=', $v_intIdDespa)
                        ->update([
                            'deciTotaPesoNeto' => $totalpesoneto,
                            'deciTotaPesoBruto' => $totalpesobruto,
                            'deciTotaArea' => $totalarea,
                            'cantidadtotal' => $cantidadtotal_up,
                            'intIdEsta' => 28,
                            'usua_modi' => $v_usuario,
                            'hora_modi' => $current_date = date('Y/m/d H:i:s')
                ]);
            } else {
                Despacho::where('intIdproy', '=', $v_intIdproy)
                        ->where('intIdTipoProducto', '=', $v_intIdTipoProducto)
                        ->where('intIdDesp', '=', $v_intIdDespa)
                        ->update([
                            'deciTotaPesoNeto' => $totalpesoneto,
                            'deciTotaPesoBruto' => $totalpesobruto,
                            'deciTotaArea' => $totalarea,
                            'cantidadtotal' => $cantidadtotal_up,
                            'usua_modi' => $v_usuario,
                            'hora_modi' => $current_date = date('Y/m/d H:i:s')
                ]);
            }


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
                /*  dd($v_intIdproy, //
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
                  $Pintura); */
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
                    $v_intIdDespa, //$id
                    $DocEnvioTS,
                    $Pintura,
                    $Obs1,
                    $obs2,
                    $obs3,
                    $obs4,
                    0
                ));
                DB::commit();
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
                    return $this->successResponse($validar);
                } else {
                    DB::rollback();
                    $validar['mensaje_alternativo'] = 'error';
                    return $this->successResponse($validar);
                }
            }
        } catch (\Exception $e) {

            DB::rollback();
            $validar['mensaje_alternativo'] = 'error';
            $validar['mensaje'][] .= 'No se registro el Avance';
            return $this->successResponse($validar);
        }
    }

    // COLOCO ANDY 
    public function comb_despacho(Request $request) {

        $regla = [
            'intIdProy' => 'required|max:255',
            'intIdTipoProducto' => 'required|max:255',
        ];
        $this->validate($request, $regla);
        $intIdProy = $request->input('intIdProy');
        $intIdTipoProducto = $request->input('intIdTipoProducto');


        $comb_despacho = Despacho::where('intIdProy', '=', $intIdProy)
                        ->where('intIdTipoProducto', '=', $intIdTipoProducto)
                        ->select('intIdDesp', DB::raw('CONCAT("DESPACHO ", intIdDesp) AS name'))->get();






        return $this->successResponse($comb_despacho);
    }

}
