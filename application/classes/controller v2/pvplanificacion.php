<?php

defined('SYSPATH') or die('Acceso denegado');

class Controller_Pvplanificacion extends Controller_DefaultTemplate {

    protected $user;
    protected $menus;

    public function before() {
        $auth = Auth::instance();
        //si el usuario esta logeado entonces mostramos el menu
        if ($auth->logged_in()) {
            //menu top de acuerdo al nivel
            $session = Session::instance();
            $this->user = $session->get('auth_user');
            $oNivel = New Model_niveles();
            $this->menus = $oNivel->menus($this->user->nivel);
            parent::before();
            $this->template->title = 'Pasajes';
        } else {
            $url = substr($_SERVER['REQUEST_URI'], 1);
            $this->request->redirect('/login?url=' . $url);
        }
    }

    public function after() {
        $this->template->menutop = View::factory('templates/menutop')->bind('menus', $this->menus)->set('controller', 'pvplanificacion');
        $oSM = New Model_menus();
        $submenus = $oSM->submenus('pvplanificacion');
        $docs = FALSE;
        if ($this->user->nivel == 4) {
            $docs = TRUE;
        }
        $this->template->submenu = View::factory('templates/submenu')->bind('smenus', $submenus)->bind('doc', $docs)->set('titulo', 'PLANIFICACION');
        parent::after();
    }

    public function action_index() {
        $this->request->redirect('pvplanificacion/lista');
        /*$oAut = new Model_Pvpoas();
        $autorizados = $oAut->listaautorizados($this->user->id, $this->user->id_entidad);//lista de solicitudes autorizadas
        $this->template->styles = array('media/css/tablas.css' => 'all');
        $this->template->scripts = array('media/js/jquery.tablesorter.min.js');
        $this->template->content = View::factory('pvplanificacion/index')
                                        ->bind('autorizados', $autorizados)
                                        ;  */  
    }
    
    public  function action_lista(){
        $mensajes=array();
        $userpoa = $this->user;
        $ofi = ORM::factory('oficinas')->where('id_entidad','=',$this->user->id_entidad)->find_all();
        $oficinas[''] = 'TODAS LAS OFICINAS';
        foreach($ofi as $o)
            $oficinas [$o->id] = $o->oficina;
        if(isset($_POST['submit']))
        {
            $fecha1=$_POST['fecha1'].' 00:00:00';
            $fecha2=$_POST['fecha2'].' 23:59:00';
            if(strtotime($fecha1)>strtotime($fecha2))
            {
                $fecha1=$_POST['fecha2'].' 23:59:00';
                $fecha2=$_POST['fecha1'].' 00:00:00';
            }
            $o_poas=New Model_Poas();
            $results=$o_poas->avanzada($this->user->id, $this->user->id_entidad, $_POST['funcionario'],$_POST['oficina'],$fecha1,$fecha2);
            if(!sizeof($results)>0)
                $mensajes['No Encontrado!'] = 'La búsqueda no produjo resultados.';
            $this->template->styles = array('media/css/jquery-ui-1.8.16.custom.css' => 'screen', 'media/css/tablas.css' => 'screen');
            $this->template->scripts = array('tinymce/tinymce.min.js', 'media/js/jquery-ui-1.8.16.custom.min.js', 'media/js/jquery.timeentry.js','media/js/jquery.tablesorter.min.js'); ///
            $this->template->content=View::factory('pvplanificacion/lista')
                                        ->bind('autorizados',$results)
                                        ->bind('oficinas', $oficinas)
                    ->bind('mensajes', $mensajes)
                    ->bind('userpoa', $userpoa)
                     ;
        }
        else{
            $oAut = new Model_Poas();
            $autorizados = $oAut->listaautorizados($this->user->id, $this->user->id_entidad);//lista de solicitudes autorizadas
            $this->template->styles = array('media/css/jquery-ui-1.8.16.custom.css' => 'screen', 'media/css/tablas.css' => 'screen');
            $this->template->scripts = array('tinymce/tinymce.min.js', 'media/js/jquery-ui-1.8.16.custom.min.js', 'media/js/jquery.timeentry.js','media/js/jquery.tablesorter.min.js'); ///
            $this->template->content = View::factory('pvplanificacion/lista')
                    ->bind('autorizados', $autorizados)
                    ->bind('oficinas', $oficinas)
                    ->bind('mensajes', $mensajes)
                    ->bind('userpoa', $userpoa)
                ;
        }
    }
    
    public function action_detalleautorizados($id = ''){
        /*$memo = ORM::factory('documentos',$id);
        $pvfucov = ORM::factory('pvfucovs')->where('id_memo','=',$id)->find();
        $pvpoas = ORM::factory('pvpoas')->where('id_fucov','=',$pvfucov->id)->find();
        $pvgestion = ORM::factory('pvogestiones',$pvpoas->id_obj_gestion);
        $pvespecifico = ORM::factory('pvoespecificos',$pvpoas->id_obj_esp);
        $pvactividad = ORM::factory('pvactividades',$pvpoas->id_actividad);
        $this->template->styles = array('media/css/jquery-ui-1.8.16.custom.css' => 'screen', 'media/css/tablas.css' => 'screen');
        $this->template->scripts = array('tinymce/tinymce.min.js', 'media/js/jquery-ui-1.8.16.custom.min.js', 'media/js/jquery.timeentry.js','media/js/jquery.tablesorter.min.js'); ///
        $this->template->content = View::factory('pvplanificacion/detalleautorizados')
                ->bind('memo',$memo)
                ->bind('pvfucov', $pvfucov)
                ->bind('pvpoas', $pvpoas)
                ->bind('pvgestion',$pvgestion)
                ->bind('pvespecifico',$pvespecifico)
                ->bind('pvactividad',$pvactividad)
                ;*/
        
        $poas = ORM::factory('poas')->where('id_documento','=',$id)->find();
        $documento = ORM::factory('documentos',$id);
        $of_solicita = ORM::factory('oficinas',$documento->id_oficina);
        $gestion = ORM::factory('pvogestiones',$poas->id_obj_gestion);
        $especifico = ORM::factory('pvoespecificos',$poas->id_obj_esp);
        $actividad = ORM::factory('pvactividades',$poas->id_actividad);
        ///tipo de contratacion
        $tipo_con = ORM::factory('poatipocontrataciones',$poas->id_tipocontratacion);
        ///verificar si es de pasajes y viaticos
        $pvfucov = ORM::factory('pvfucovs')->where('id_memo', '=', $poas->id_memo)->find();
        $this->template->styles = array('media/css/jquery-ui-1.8.16.custom.css' => 'screen', 'media/css/tablas.css' => 'screen');
        $this->template->scripts = array('tinymce/tinymce.min.js', 'media/js/jquery-ui-1.8.16.custom.min.js', 'media/js/jquery.timeentry.js','media/js/jquery.tablesorter.min.js'); ///
        $this->template->content = View::factory('pvplanificacion/detalleautorizados')
                ->bind('poa', $poas)
                ->bind('gestion',$gestion)
                ->bind('especifico',$especifico)
                ->bind('actividad',$actividad)
                ->bind('documento',$documento)
                ->bind('of_solicita',$of_solicita)
                ->bind('pvfucov',$pvfucov)
                ->bind('tipo_con',$tipo_con)
                ;
    }
    
    public function action_unidades(){
        $oUnid = new Model_oficinas();
        $unidades = $oUnid->listaunidades($this->user->id_entidad);
        $this->template->styles = array('media/css/tablas.css' => 'all');
        $this->template->scripts = array('media/js/jquery.tablesorter.min.js');
        $this->template->content = View::factory('pvplanificacion/listaunidades')
                                        ->bind('unidades', $unidades)
                                        ;
    }
    
    public function action_editarpoa($id = '') {
        $pvfucov = ORM::factory('pvfucovs')->where('id','=',$id)->find();
        if ($pvfucov->loaded()) {
            if($pvfucov->etapa_proceso <= 2){
                $pvpoas = ORM::factory('pvpoas')->where('id_fucov','=',$id)->find();
                $pvpoas->id_obj_gestion = $_POST['obj_gestion'];
                $pvpoas->id_obj_esp = $_POST['obj_esp'];
                $pvpoas->id_actividad = $_POST['actividad'];
                $pvpoas->fecha_modificacion = date('Y-m-d H:i:s');
                $pvpoas->save();
                $this->request->redirect('documento/detalle/'.$pvfucov->id_memo);
                }
            else
                $this->template->content = '<b>EL DOCUMENTO YA FUE AUTORIZADO Y NO SE PUEDE MODIFICAR.</b><div class="info" style="text-align:center;margin-top: 50px; width:800px">
                                        <p><span style="float: left; margin-right: .3em;" class=""></span>    
                                        &larr;<a onclick="javascript:history.back(); return false;" href="#" style="font-weight: bold; text-decoration: underline;  " > Regresar<a/></p></div>';
        }
        else
                $this->template->content = 'El FUCOV no existe';
    }
    
    public function action_autorizarfucov($id = '') {
        $pvfucov = ORM::factory('pvfucovs')->where('id','=',$id)->find();
        if ($pvfucov->loaded()) {
            $pvfucov->etapa_proceso = 3;
            $pvfucov->save();
            $pvpoas = ORM::factory('pvpoas')->where('id_fucov','=',$id)->find();
            if($pvpoas->loaded()){
                $pvpoas->auto_poa = 1;
                $pvpoas->fecha_certificacion = date('Y-m-d H:i:s');
                $pvpoas->id_user_auto = $this->user->id;
                $pvpoas->save();
                $this->request->redirect('documento/detalle/'.$pvfucov->id_memo);
            }
            else
                $this->template->content = 'No hay POA Asignado';
        }
    }
    
    public function action_objetivogestion($id = ''){
        $oficina = ORM::factory('oficinas')->where('id','=',$id)->find();
        $objetivos = ORM::factory('pvogestiones')->where('id_oficina','=',$id)->and_where('estado','=',1)->order_by('id','asc')->find_all();
        $this->template->styles = array('media/css/tablas.css' => 'all');
        $this->template->scripts = array('media/js/jquery.tablesorter.min.js');
        $this->template->content = View::factory('pvplanificacion/listaogestion')
                                        ->bind('objetivos', $objetivos)
                                        ->bind('oficina', $oficina)
                                        ;
    }
    
    public function action_addobjgestion($id = ''){
        $mensajes=array();
        $oficina = ORM::factory('oficinas')->where('id','=',$id)->find();
        $entidad = ORM::factory('entidades')->where('id','=',$oficina->id_entidad)->find();
        $oest = ORM::factory('pvoestrategicos')->where('estado','=',1)->find_all();
        $estrategico = array();
        foreach($oest as $e)
            $estrategico[$e->id] = $e->codigo." - ".substr ($e->objetivo, 0,110);
        if (isset($_POST['submit'])) {
            $objetivo = ORM::factory('pvogestiones');
            $objetivo->codigo = trim($_POST['codigo']);
            $objetivo->objetivo = trim($_POST['objetivo']);
            $objetivo->id_obj_est = trim($_POST['estrategico']);
            $objetivo->id_oficina = $id;
            $objetivo->estado = 1;
            $objetivo->save();
            //$this->request->redirect('pvplanificacion/objetivogestion/'.$id);
            $mensajes['Modificado!'] = 'El Objetivo se adiciono correctamente.';
        }
        //$objetivos = ORM::factory('pvogestiones')->where('id_oficina','=',$id)->find_all();
        $this->template->styles = array('media/css/tablas.css' => 'all');
        $this->template->scripts = array('media/js/jquery.tablesorter.min.js');
        $this->template->content = View::factory('pvplanificacion/addobjgestion')
                                        //->bind('objetivos', $objetivos)
                                        ->bind('oficina', $oficina)
                                        ->bind('entidad', $entidad)
                                        ->bind('mensajes', $mensajes)
                                        ->bind('estrategico', $estrategico)
                                        ;
    }
    
    public function action_editobjgestion($id = ''){
        $objetivo = ORM::factory('pvogestiones')->where('id','=',$id)->find();
        if (isset($_POST['submit'])) {
            $objetivo->codigo = trim($_POST['codigo']);
            $objetivo->objetivo = trim($_POST['objetivo']);
            $objetivo->id_obj_est = trim($_POST['estrategico']);
            $objetivo->save();
            $this->request->redirect('pvplanificacion/objetivogestion/'.$_POST['id_oficina']);
        }
        $oest = ORM::factory('pvoestrategicos')->where('estado','=',1)->find_all();
        $estrategico = array();
        foreach($oest as $e)
            $estrategico[$e->id] = $e->codigo." - ".substr ($e->objetivo, 0,110);
        $oficina = ORM::factory('oficinas')->where('id','=',$objetivo->id_oficina)->find();
        $entidad = ORM::factory('entidades')->where('id','=',$oficina->id_entidad)->find();
        $this->template->styles = array('media/css/tablas.css' => 'all');
        $this->template->scripts = array('media/js/jquery.tablesorter.min.js');
        $this->template->content = View::factory('pvplanificacion/editobjgestion')
                                        ->bind('objetivo', $objetivo)
                                        ->bind('oficina', $oficina)
                                        ->bind('entidad', $entidad)
                                        ->bind('estrategico', $estrategico)
                                        ;
    }
    
    public function action_eliminarobjgestion($id = ''){
        $objetivo = ORM::factory('pvogestiones')->where('id','=',$id)->find();
        if ($objetivo->loaded()) {
            $objetivo->estado = 0;
            $objetivo->save();
            $this->request->redirect('pvplanificacion/objetivogestion/'.$objetivo->id_oficina);
        }
        else{
            $this->template->content = 'El Objetivo No Existe.';
        }
    }
    
    public function action_objetivoespecifico($id = ''){
        $ogestion = ORM::factory('pvogestiones')->where('id','=',$id)->find();
        $especificos = ORM::factory('pvoespecificos')->where('id_obj_gestion','=',$id)->and_where('estado','=',1)->find_all();
        $oficina = ORM::factory('oficinas')->where('id','=',$ogestion->id_oficina)->find();
        $this->template->styles = array('media/css/tablas.css' => 'all');
        $this->template->scripts = array('media/js/jquery.tablesorter.min.js');
        $this->template->content = View::factory('pvplanificacion/listaoespecificos')
                                        ->bind('objetivos', $especificos)
                                        ->bind('ogestion', $ogestion)
                                        ->bind('oficina', $oficina)
                                        ;
    }
    
    public function action_addobjespecifico($id = ''){
        $mensajes=array();
        if (isset($_POST['submit'])) {
            $objetivo = ORM::factory('pvoespecificos');
            $objetivo->codigo = trim($_POST['codigo']);
            $objetivo->objetivo = trim($_POST['objetivo']);
            $objetivo->id_obj_gestion = $id;
            $objetivo->estado = 1;
            $objetivo->save();
            $mensajes['Adidionado!'] = 'El Objetivo se adiciono correctamente.';
        }
        $ogestion = ORM::factory('pvogestiones')->where('id','=',$id)->find();
        $oficina = ORM::factory('oficinas')->where('id','=',$ogestion->id_oficina)->find();
        $entidad = ORM::factory('entidades')->where('id','=',$oficina->id_entidad)->find();
        $this->template->styles = array('media/css/tablas.css' => 'all');
        $this->template->scripts = array('media/js/jquery.tablesorter.min.js');
        $this->template->content = View::factory('pvplanificacion/addobjespecifico')
                                        ->bind('ogestion', $ogestion)
                                        ->bind('oficina', $oficina)
                                        ->bind('entidad', $entidad)
                                        ->bind('mensajes', $mensajes)
                                        ;
    }
    
    public function action_editobjespecifico($id = ''){
        $oespecifico = ORM::factory('pvoespecificos')->where('id','=',$id)->find();
        if (isset($_POST['submit'])) {
            $oespecifico->codigo = trim($_POST['codigo']);
            $oespecifico->objetivo = trim($_POST['objetivo']);
            $oespecifico->save();
            $this->request->redirect('pvplanificacion/objetivoespecifico/'.$oespecifico->id_obj_gestion);
        }
        $ogestion = ORM::factory('pvogestiones')->where('id','=',$oespecifico->id_obj_gestion)->find();
        $oficina = ORM::factory('oficinas')->where('id','=',$ogestion->id_oficina)->find();
        $entidad = ORM::factory('entidades')->where('id','=',$oficina->id_entidad)->find();
        $this->template->styles = array('media/css/tablas.css' => 'all');
        $this->template->scripts = array('media/js/jquery.tablesorter.min.js');
        $this->template->content = View::factory('pvplanificacion/editobjespecifico')
                                        ->bind('ogestion', $ogestion)
                                        ->bind('oespecifico', $oespecifico)
                                        ->bind('oficina', $oficina)
                                        ->bind('entidad', $entidad)
                                        ;
    }    
    
    public function action_eliminarobjesp($id = ''){
        $objetivo = ORM::factory('pvoespecificos')->where('id','=',$id)->find();
        if ($objetivo->loaded()) {
            $objetivo->estado = 0;
            $objetivo->save();
            $this->request->redirect('pvplanificacion/objetivoespecifico/'.$objetivo->id_obj_gestion);
        }
        else{
            $this->template->content = 'El Objetivo No Existe.';
        }
    }
    
    public function action_gestion(){
        //$oficina = ORM::factory('oficinas')->where('id','=',$id)->find();
        $entidad = ORM::factory('entidades')->where('id','=',$this->user->id_entidad)->find();
        $oGestion = new Model_Pvogestiones();        
        $ogestion = $oGestion->objetivosgestion($this->user->id_entidad);
        $this->template->styles = array('media/css/tablas.css' => 'all');
        $this->template->scripts = array('media/js/jquery.tablesorter.min.js');
        $this->template->content = View::factory('pvplanificacion/objetivosgestion')
                                        ->bind('objetivos', $ogestion)
                                        ->bind('entidad', $entidad)
                                        ;
    }
    
    public function action_especificos(){
        $entidad = ORM::factory('entidades')->where('id','=',$this->user->id_entidad)->find();
        $oEspecifico = new Model_Pvoespecificos();
        $oespecifico = $oEspecifico->objetivosespecificos($this->user->id_entidad);
        $this->template->styles = array('media/css/tablas.css' => 'all');
        $this->template->scripts = array('media/js/jquery.tablesorter.min.js');
        $this->template->content = View::factory('pvplanificacion/objetivosespecificos')
                                        ->bind('objetivos', $oespecifico)
                                        ->bind('entidad', $entidad)
                                        ;
    }
    
    public function action_listaactividades($id = ''){
        $oespecifico = ORM::factory('pvoespecificos')->where('id','=',$id)->and_where('estado','=',1)->find();
        $ogestion = ORM::factory('pvogestiones')->where('id','=',$oespecifico->id_obj_gestion)->find();
        $actividades = ORM::factory('pvactividades')->where('id_objespecifico','=',$oespecifico->id)->and_where('estado','=',1)->find_all();
        $oficina = ORM::factory('oficinas')->where('id','=',$ogestion->id_oficina)->find();
        $this->template->styles = array('media/css/tablas.css' => 'all');
        $this->template->scripts = array('media/js/jquery.tablesorter.min.js');
        $this->template->content = View::factory('pvplanificacion/listaactividades')
                                        ->bind('objetivos', $actividades)
                                        ->bind('oespecifico', $oespecifico)
                                        ->bind('ogestion', $ogestion)
                                        ->bind('actividades', $actividades)
                                        ->bind('oficina', $oficina)
                                        ;
    }
    
    public function action_addactividad($id = ''){
        $mensajes=array();
        if (isset($_POST['submit'])) {
            $actividad = ORM::factory('pvactividades');
            $actividad->codigo = trim($_POST['codigo']);
            $actividad->actividad = trim($_POST['actividad']);
            $actividad->id_objespecifico = $id;
            $actividad->estado = 1;
            $actividad->save();
            $mensajes['Adidionado!'] = 'La Actividad se adiciono correctamente.';
        }
        $actividades = ORM::factory('pvactividades')->where('id_objespecifico','=',$id)->find_all();
        $oespecifico = ORM::factory('pvoespecificos')->where('id','=',$id)->and_where('estado','=',1)->find();
        $ogestion = ORM::factory('pvogestiones')->where('id','=',$oespecifico->id_obj_gestion)->find();
        $oficina = ORM::factory('oficinas')->where('id','=',$ogestion->id_oficina)->find();
        $entidad = ORM::factory('entidades')->where('id','=',$oficina->id_entidad)->find();
        $this->template->styles = array('media/css/tablas.css' => 'all');
        $this->template->scripts = array('media/js/jquery.tablesorter.min.js');
        $this->template->content = View::factory('pvplanificacion/addactividad')
                ->bind('actividades', $actividades)                        
                ->bind('ogestion', $ogestion)
                ->bind('oespecifico', $oespecifico)
                ->bind('oficina', $oficina)
                ->bind('entidad', $entidad)
                ->bind('mensajes', $mensajes)
                                        ;
    }
    
    public function action_editactividad($id = ''){
        $mensajes = array();
        $actividad = ORM::factory('pvactividades')->where('id','=',$id)->find();
        if (isset($_POST['submit'])) {
            $actividad->codigo = trim($_POST['codigo']);
            $actividad->actividad = trim($_POST['actividad']);
            $actividad->save();
            $this->request->redirect('pvplanificacion/listaactividades/'.$actividad->id_objespecifico);
        }
        //$actividades = ORM::factory('pvactividades')->where('id_objespecifico','=',$id)->find_all();
        $oespecifico = ORM::factory('pvoespecificos')->where('id','=',$actividad->id_objespecifico)->and_where('estado','=',1)->find();
        $ogestion = ORM::factory('pvogestiones')->where('id','=',$oespecifico->id_obj_gestion)->find();
        $oficina = ORM::factory('oficinas')->where('id','=',$ogestion->id_oficina)->find();
        $entidad = ORM::factory('entidades')->where('id','=',$oficina->id_entidad)->find();
        $this->template->styles = array('media/css/tablas.css' => 'all');
        $this->template->scripts = array('media/js/jquery.tablesorter.min.js');
        $this->template->content = View::factory('pvplanificacion/editactividad')
                ->bind('actividad', $actividad)
                ->bind('ogestion', $ogestion)
                ->bind('oespecifico', $oespecifico)
                ->bind('oficina', $oficina)
                ->bind('entidad', $entidad)
                ->bind('mensajes', $mensajes)
                ;
    }


    //MOdificado Freddy Velasco
    public function action_modificarpoa($id = '') {
        $poa = ORM::factory('poas')->where('id','=',$id)->find();
        if ($poa->loaded()) {
            if($poa->auto_poa == 0){
                    $poa->id_obj_est = $_POST['obj_est'];
                    $poa->id_obj_gestion = $_POST['obj_gestion'];
                    $poa->id_obj_esp = $_POST['obj_esp'];
                    $poa->id_actividad = $_POST['actividad'];
                    $poa->fecha_modificacion = date('Y-m-d H:i:s');
                    $poa->tipo_actividad = $_POST['tipo_actividad'];
                    $poa->id_tipocontratacion = $_POST['id_tipocontratacion'];
                    $poa->otro_tipocontratacion = $_POST['otro_tipocontratacion'];
                    $poa->ri_financiador = $_POST['ri_financiador'];
                    $poa->ri_porcentaje = $_POST['ri_porcentaje'];
                    $poa->re_financiador = $_POST['re_financiador'];
                    $poa->re_porcentaje = $_POST['re_porcentaje'];
                    $poa->proceso_con = $_POST['referencia'];
                    $poa->cantidad = $_POST['cantidad'];
                    $poa->monto_total = $_POST['monto_total'];
                    $poa->plazo_ejecucion = $_POST['plazo_ejecucion'];
                    $poa->cod_pol_sec = $_POST['cod_pol_sec'];
                    $poa->cod_est_sec = $_POST['cod_est_sec'];
                    $poa->cod_prog_sec = $_POST['cod_prog_sec'];
                    $poa->des_pol_sec = $_POST['des_pol_sec'];
                    $poa->des_est_sec = $_POST['des_est_sec'];
                    $poa->des_prog_sec = $_POST['des_prog_sec'];

                    $poa->obj_est = $_POST['det_obj_est'];
                    $poa->obj_gestion = $_POST['det_obj_gestion'];
                    $poa->obj_esp = $_POST['det_obj_esp'];
                    $poa->actividad = $_POST['det_act'];

                    $poa->nro_poa = $_POST['nro_poa'];

                    $poa->save();
                if($poa->id_memo)
                    $this->request->redirect('documento/detalle/'.$poa->id_memo);
                else
                    $this->request->redirect('documento/detalle/'.$poa->id_documento);
                }
            else
                $this->template->content = '<b>EL DOCUMENTO YA FUE AUTORIZADO Y NO SE PUEDE MODIFICAR.</b><div class="info" style="text-align:center;margin-top: 50px; width:800px">
                                        <p><span style="float: left; margin-right: .3em;" class=""></span>    
                                        &larr;<a onclick="javascript:history.back(); return false;" href="#" style="font-weight: bold; text-decoration: underline;  " > Regresar<a/></p></div>';
        }
        else
                $this->template->content = 'El documento no existe';
    }

    public function action_aprobarpoa($id = '',$nro_poa=0) {
        $poa = ORM::factory('poas')->where('id','=',$id)->find();
        if ($poa->loaded()) {

//            $oNur = New Model_nurs();
//            $nur=$oNur->correlativo(-4, '',$this->user->id_entidad);

            $poa->fecha_aprobacion = date('Y-m-d H:i:s');
            $poa->id_user_auto = $this->user->id;
            $poa->nro_poa = $nro_poa;
            $poa->auto_poa = 1;
            $poa->save();
            //$this->request->redirect('documento/detalle/'.$poa->id_documento);
            ///para redireccionar buscamos el documento al que pertenece(Nota o FOCOV)
            if($poa->id_memo != 0)
                $this->request->redirect('documento/detalle/'.$poa->id_memo);
            else
                $this->request->redirect('documento/detalle/'.$poa->id_documento);
        }
    }
    
    public function action_eliminaractividad($id = ''){
        $actividad = ORM::factory('pvactividades')->where('id','=',$id)->find();
        if ($actividad->loaded()) {
            $actividad->estado = 0;
            $actividad->save();
            $this->request->redirect('pvplanificacion/listaactividades/'.$actividad->id_objespecifico);
        }
        else{
            $this->template->content = 'La Actividad No Existe.';
        }
    }
    ///////////////////////end////
}

?>
