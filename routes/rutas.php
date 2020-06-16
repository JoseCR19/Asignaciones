<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$router->post('/list_tipo_prodxproy','AsignacionController@list_tipo_prodxproy');


$router->post('/obte_tipo_prod','AsignacionController@obte_tipo_prod');


$router->post('/vali_OT','AsignacionController@vali_OT');




$router->post('/vali_proy_tipo_pro','AsignacionController@vali_proy_tipo_pro');


//Asignar Estapa
$router->post('/mostr_asig_etap','AsignacionController@mostr_asig_etap');
$router->post('/asig_etap_proy','AsignacionController@asig_etap_proy');

$router->post('/regi_otra_inte','AsignacionController@regi_otra_inte');

$router->post('/regi_asig_etap','AsignacionController@regi_asig_etap');
$router->post('/actu_asig_etapa','AsignacionController@actu_asig_etapa');
$router->post('/elim_asig_etap','AsignacionController@elim_asig_etap');
$router->post('/obte_cont_con_id_etap','AsignacionController@obte_cont_con_id_etap');

$router->post('/obte_supe_con_id_etap','AsignacionController@obte_supe_con_id_etap');





//Asignacion de Grupo
$router->post('/sele_los_codi_paqu_gril','AsignarGrupoController@sele_los_codi_paqu_gril');
$router->post('/most_filt_asig_grup','AsignarGrupoController@most_filt_asig_grup');

$router->post('/sele_los_codi_paqu_camp','AsignarGrupoController@sele_los_codi_paqu_camp');

$router->post('/guar_asig_grupo','AsignarGrupoController@guar_asig_grupo');

$router->post('/vali_ante_edit','AsignarGrupoController@vali_ante_edit');

$router->get('/esta_paqu','AsignarGrupoController@esta_paqu');



$router->post('/vali_plan_id_etap','AsignarGrupoController@vali_plan_id_etap');
$router->post('/vali_arma_id_etap','AsignarGrupoController@vali_arma_id_etap');
$router->post('/vali_cont_id_arma','AsignarGrupoController@vali_cont_id_arma');


$router->post('/vali_arma_con_proy_paqu','AsignarGrupoController@vali_arma_con_proy_paqu');
$router->post('/visu_repo_comp','AsignarGrupoController@visu_repo_comp');



//Store Grupo controller
$router->post('/conv_store_en_micro','StoreGrupoController@conv_store_en_micro');

$router->post('/store_list_codi_grup_sele_visu_plan','AsignarGrupoController@store_list_codi_grup_sele_visu_plan');
$router->post('/store_avan','StoreGrupoController@store_avan');

//ReporteAvance

$router->post('/repo_avance_serie','ReportarAvanceController@repo_avance_serie');
$router->post('/store_regi_avance','ReportarAvanceController@store_regi_avance');
$router->post('/envi_valo_cod','ReportarAvanceController@envi_valo_cod');
$router->post('/store_camb_esta_proc_term','ReportarAvanceController@store_camb_esta_proc_term');
$router->post('/etapa_obte_cola','ReportarAvanceController@etapa_obte_cola');
$router->post('/etapa_obte_cont','ReportarAvanceController@etapa_obte_cont');
$router->post('/store_obte_peri_valo','ReportarAvanceController@store_obte_peri_valo');

$router->post('/create_despacho','ReportarAvanceController@create_despacho');
$router->post('/crear_guia','ReportarAvanceController@crear_guia');
$router->post('/guias_generadas','ReportarAvanceController@guias_generadas'); 

// COLOCO ANDY 
$router->post('/comb_despacho','StoreGrupoController@comb_despacho');
$router->post('/update_despacho','StoreGrupoController@update_despacho');



