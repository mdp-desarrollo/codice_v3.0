<?php
defined('SYSPATH') or die('Acceso denegado');
class Controller_Bandeja extends Controller_DefaultTemplate{
    protected $user;
    protected $menus;
    public function before() 
    {
        $auth =  Auth::instance();
        //si el usuario esta logeado entocnes mostramos el menu
        if($auth->logged_in())
        {
        //menu top de acuerdo al nivel
            $session=Session::instance();
            $this->user=$session->get('auth_user');
            $oNivel=New Model_niveles();
            $this->menus=$oNivel->menus($this->user->nivel);
        parent::before();
        $this->template->title='Bandeja';
        }
        else
        {
            $url= substr($_SERVER['REQUEST_URI'],1);
            $this->request->redirect('/login?url='.$url);
        }        
    }

 public function after() 
    {        
        $this->template->menutop = View::factory('templates/menutop')->bind('menus',$this->menus)->set('controller', 'bandeja');
        $oSM=New Model_menus();
        $submenus=$oSM->submenus('bandeja');
        $this->template->submenu = View::factory('templates/submenu')->bind('smenus',$submenus)->set('titulo','Bandeja de Entrada');        
        parent::after();
    }  
    //listar nuris generados por el usuario logeado
    public function action_index()
    {        
            $oSeg=New Model_Seguimiento();
            $entrada=$oSeg->estado(1,$this->user->id);
//            $id_doc =0;
//            foreach ($entrada as $e) {
//                $id_doc = $e->id_doc;
//            }
//            
//            $archivos = ORM::factory('archivos')
//    ->where('id_documento', '=', $id_doc)
//    ->find_all();
            
            $this->template->styles=array('media/css/tablas.css'=>'all','media/css/modal.css'=>'screen');
            $this->template->title     .= ' | Entrada'; 
            $this->template->content=View::factory('bandeja/entrada')
                                    ->bind('norecibidos', $entrada);
                                    //->bind('archivos', $archivos);
    }
    public function action_doa()    
    {
        if($_POST){
            if($_POST['accion']==0) // 0 = archivar correspondencia
            {
               $carpetas=ORM::factory('carpetas')->where('id_oficina','=',$this->user->id_oficina)->or_where('id_oficina','=','0')->find_all();
                
               //$carpetas=ORM::factory('carpetas')->find_all();
               $arrCarpetas=array();
                foreach($carpetas as $c)
                {
                    if ($c->nivel==2) {
                    $arrCarpetas[$c->id]=$c->carpeta;    
                    }
                    
                }
                //nurs
                $nurs=array();
                $oSeg=New Model_Seguimiento();                
                foreach($_POST['id_seg'] as $k=>$v)
                {
                    $nur=$oSeg->nur($v);
                    $id=$nur[0]['id'];
                    $nurs[$id]=$nur[0]['nur'];
                }                
                $this->template->title.=' | Archivar correspondencia';
                $this->template->content=View::factory('bandeja/archivar')
                                         ->bind('options',$arrCarpetas)
                                         ->bind('nurs', $nurs);
            }
            elseif ($_POST['accion']==1)    // 1 = agrupar correspondencia
            {
                $oSeg=New Model_Seguimiento();                
                foreach($_POST['id_seg'] as $k=>$v)
                {
                    $nur=$oSeg->nur($v);
                    $id=$nur[0]['id'];
                    $nurs[$id]=$nur[0]['nur'];
                }
                
                $this->template->title.=' | Archivar correspondencia';
                $this->template->content=View::factory('bandeja/agrupar')                                         
                                         ->bind('nurs', $nurs);
            } elseif ($_POST['accion']==2) {  // 2= recepcionar correspondencia
             foreach($_POST['id_seg'] as $k=>$id)
                {
                    if($id!=''){
                        $seguimiento=ORM::factory('seguimiento')->where('id','=',$id)->and_where('derivado_a','=',$this->user->id)->and_where('estado','=',1)->find();
                        if($seguimiento->loaded()){
                            $seguimiento->fecha_recepcion=date('Y-m-d H:i:s');
                            $seguimiento->estado=2; //2=pendiente oficial
                            $seguimiento->save();
            //guardamos en vitacora
                            $this->save($this->user->id_entidad,$this->user->id, $this->user->nombre.' | <b>'.$this->user->cargo.'</b> Recepciono la hoja de ruta '.$seguimiento->nur);
                        } else {
                        $this->template->content='No se pudo recepcionar correspondencia.';                    
                        }            
                    } else{
                        $this->template->content='No se pudo recepcionar correspondencia.';
                    }

                }
                $this->request->redirect('./bandeja');
            } elseif ($_POST['accion']==3) {  // 3= derivar varias hojas de ruta
                $nurs=array();
                $oSeg=New Model_Seguimiento();                
                foreach($_POST['id_seg'] as $k=>$v)
                {
                    $nur=$oSeg->nur_ref($v);
                    $id=$nur[0]['id'];
                    $nurs[$id][0]=$nur[0]['nur'];
                    $nurs[$id][1]=$nur[0]['referencia'];
                    $nurs[$id][2]=$nur[0]['oficial'];
                    $nurs[$id][3]=$nur[0]['hijo'];
                    $nurs[$id][4]=$nur[0]['id_doc'];
                }
                $acciones = $this->acciones();
                $destinatarios = $this->destinatarios($this->user->id, $this->user->superior);
                $this->template->styles=array('media/css/tablas.css'=>'all','media/css/modal.css'=>'screen');
                $this->template->title.=' | Derivar correspondencia';
                $this->template->content=View::factory('bandeja/derivar')
                                         ->bind('nurs',$nurs)
                                         ->bind('accion',$acciones)
                                         ->bind('destinatario', $destinatarios);
            }
        }        
    }

    

    //archivar correspondencia final
    public function action_agruparf()
    {
        if($_POST)
        {
                $principal=$_POST['principal'];
                $padre=ORM::factory('seguimiento',$principal);
                if($padre->loaded())
                {                            
                    foreach($_POST['seg'] as $k=>$v)
                    {
                        $hijo=ORM::factory('seguimiento',$v);
                        if($padre->nur!=$hijo->nur)
                        {
                            $agrupar=ORM::factory('agrupaciones');
                            $agrupar->padre=$padre->nur;
                            $agrupar->hijo=$hijo->nur;
                            $agrupar->id_seguimiento=$hijo->id;
                            $agrupar->id_user=$this->user->id;
                            $agrupar->nombre=$this->user->nombre;
                            $agrupar->cargo=$this->user->cargo;                            
                            $agrupar->fecha=date('Y-m-d H:i:s');
                            $agrupar->save(); 
                            if($agrupar->id>0) //si se agrupo! entonces cambiamos el estado del hijo
                            {
                                $hijo->estado=6;
                                $hijo->save();
                            }
                        }                     
                    }
                    //por le decimos al seguimiento del padre que tiene hijos jiji                    
                    $padre->hijo=1;
                    $padre->save();                    
                    $_POST=array(); 
                    $this->request->redirect('bandeja/agrupado?nur='.$padre->nur);
                }
        }        
    }
    //archivar correspondencia final
    public function action_archivarf()
    {
        if($_POST)
        {            
                foreach($_POST['seg'] as $k=>$v)
                {
                    $seg=ORM::factory('seguimiento',$v);
                    if($seg->loaded())
                    {                       
                        $carpeta=ORM::factory('archivados');
                        $carpeta->id_user=$this->user->id;
                        $carpeta->nur=$seg->nur;
                        $carpeta->id_carpeta=$_POST['carpeta_lista'];
                        $carpeta->fecha=date('Y-m-d H:i:s');
                        $carpeta->observaciones=$_POST['observaciones'];
                        $carpeta->save();
                        $seg->estado=10;
                        $seg->id_archivo=$carpeta->id;
                        $seg->save();
                    }
                }
                $_POST=array();            
            $this->request->redirect('bandeja/archivos');
        }        
    }

     //Derivar varios documentos
    public function action_derivarf()
    {
        if($_POST)
        {            
            $session = Session::instance();
            $n=count($_POST['id_seg']);
            for ($i=0; $i < $n ; $i++) { 
            //$tipo = $_POST['oficial'];  // oficial inicial
            $oficial = $_POST['oficial'][$i];   // oficial final
            $id_seg = $_POST['id_seg'][$i];
            $destino = $_POST['destino'];
            $accion = $_POST['accion'];
            $proveido = strtoupper($_POST['proveido']);
            $observacion = "";
            $nur = $_POST['nur'][$i];
            $user = $this->user->id;
            $id_doc = $_POST['id_doc'][$i];
            $hijo = $_POST['hijo'][$i];
            $prioridad = 0;    
            $usuario[$destino] = $destino;
            if ($oficial > 0)
                $usuario['oficial'] = $oficial;

            $session->set('destino', $usuario);

            $adjunto = 0;
            if ($adjunto == 0)
                $adjunto = json_encode(array());
            else
                $adjunto = json_encode($adjunto);

            $destino = ORM::factory('users', $destino);
            $oficina_destino = ORM::factory('oficinas', $destino->id_oficina);
            $remite = ORM::factory('users', $user);
            $oficina_remite = ORM::factory('oficinas', $remite->id_oficina);

            // modificado por freddy
            if ($id_seg < 1) {
                $documentos = ORM::factory('documentos')->where('id', '=', $id_doc)->find();
                if ($documentos->loaded()) {
                    $id_seg = $documentos->id_seguimiento;
                    //Modificado por Freddy
                    $seg = ORM::factory('seguimiento')->where('id', '=', $id_seg)->find();
                    if($documentos->estado==0 && $documentos->id_seguimiento>0 && $seg->oficial==0){
                      $oficial2=0;   
                    }                    
                    ///////////////////////
                }
            }
            //////////////////////
            $seguimiento = ORM::factory('seguimiento');
            if ($id_seg > 0) {
                $seguimiento_actual = ORM::factory('seguimiento')
                        ->where('id', '=', $id_seg)
                        ->find();
                $seguimiento_actual->estado = 4;
                if ($seguimiento_actual->oficial == 1) {
                    $seguimiento_actual->oficial = 2;
                }
                
                $seguimiento_actual->save();
                //incrementado por freddy
                if (isset($usuario['oficial'])) {
                    $documento = ORM::factory('documentos', $id_doc);
                    $documento->estado = 1;
                    $documento->save();
                }
            } else {
                if (isset($usuario['oficial'])) {
                    $documento = ORM::factory('documentos', $id_doc);
                    $documento->estado = 1;
                    $documento->save();
                }
            }
            $seguimiento->id_seguimiento = $id_seg;
            $seguimiento->nur = $nur;
            $seguimiento->derivado_por = $remite->id;
            $seguimiento->nombre_emisor = $remite->nombre;
            $seguimiento->cargo_emisor = $remite->cargo;
            $seguimiento->fecha_emision = date('Y-m-d H:i:s');
            $seguimiento->derivado_a = $destino->id;
            $seguimiento->nombre_receptor = $destino->nombre;
            $seguimiento->cargo_receptor = $destino->cargo;
            $seguimiento->estado = 1;
            $seguimiento->accion = $accion;
            if (isset($oficial2)){
                $seguimiento->oficial = $oficial2;
            }else{
                $seguimiento->oficial = $oficial;
            }
            $seguimiento->hijo = $hijo;
            $seguimiento->proveido = $proveido;
            $seguimiento->adjuntos = $adjunto;
            $seguimiento->de_oficina = $oficina_remite->oficina;
            $seguimiento->a_oficina = $oficina_destino->oficina;
            $seguimiento->id_de_oficina = $oficina_remite->id;
            $seguimiento->id_a_oficina = $oficina_destino->id;
            $seguimiento->prioridad = $prioridad;
            $seguimiento->observacion = $observacion;
            $seguimiento->save();
            //Modificado por freddy
            if($seguimiento->id){
                DB::update(ORM::factory('documentos')->table_name())->set(array('id_seguimiento' => $seguimiento->id))->where('nur', '=', $nur)->and_where('original','=','0')->and_where('id_seguimiento','=','0')->and_where('estado','=','1')->execute();
            }
            //guardamo vitacora
            $this->save($remite->id_entidad, $seguimiento->derivado_por, $seguimiento->nombre_emisor . ' | <b>' . $seguimiento->cargo_emisor . '</b> Deriva la Hoja de Ruta ' . $seguimiento->nur . '(' . $oficial . ') a ' . $seguimiento->nombre_receptor . ' | <b>' . $seguimiento->cargo_receptor . '</b>');

            }

            
        }    
        $this->request->redirect('bandeja/pendientes');
    }
    
    
    //correlativo para un NURI -1=nuri / -2 = nur
    public function nuevo($type=-1)
    {
        $oCorrelativo=ORM::factory('correlativo')
                        ->where('id_tipo','=',$type)
                        ->find();
        $oCorrelativo->correlativo=$oCorrelativo->correlativo+1;
        $oCorrelativo->save();
        $codigo='000'.$oCorrelativo->correlativo;
        if($type==-1)
            $tipo='I/';
        else
            $tipo='';
        $codigo=$tipo.date('Y').'-'.substr($codigo, -4);
        return $codigo;
    }
 //nuris creados por el usuario
    public function action_listar()
    {
        $auth=Auth::instance();
        if($auth->logged_in()){
            $oNuri=New Model_Asignados();
            $count= $oNuri->count($auth->get_user());
            //$count2= $oNuri->count2($auth->get_user());           
            if($count){
              // echo $oNuri->count2($auth->get_user());
                $pagination = Pagination::factory(array(
  		'total_items'    => $count,
                'current_page'   => array('source' => 'query_string', 'key' => 'page'),
                'items_per_page' => 40,
                'view'           => 'pagination/floating',            
                ));  		                    
                 $result=$oNuri->nuris($auth->get_user(),$pagination->offset,$pagination->items_per_page);                                   
                 $page_links = $pagination->render();
                 $this->template->title='Hojas de Seguimiento';
                 $this->template->styles=array('media/css/tablas.css'=>'all');
                 $this->template->content=View::factory('nur/listar')
                                           ->bind('result', $result)
                                           ->bind('page_links', $page_links);
            }
            else{
                $this->template->content=View::factory('errors/general');
            }
        }
        else{
            $this->request->redirect('login');
        }
    }    
    /*Lista de pendientes*/   
    public function action_pendientes()
    {   $info=array();
        if(isset($_GET['id']))
        {
            $user=ORM::factory('users')
                    ->where('id','=',$_GET['id'])
                    ->and_where('superior','=',$this->user->id)
                    ->find();
            if($user->id)
            {
            $oSeg=New Model_Seguimiento();
            $entrada=$oSeg->pendiente($user->id);
            $carpetas=ORM::factory('carpetas')->where('id_oficina','=',$user->id_oficina)->find_all();
            $arrCarpetas=array();
            foreach($carpetas as $c)
            {
                $arrCarpetas[$c->id]=$c->carpeta;
            }
            $oDoc=New Model_Tipos();
            $documentos=$oDoc->misTipos($this->user->id);
            $options=array();
            foreach ($documentos as $d) 
            {
                $options[$d->id]=$d->tipo;
            }           
            $this->template->styles=array('media/css/tablas.css'=>'all','media/css/modal.css'=>'screen');           
            $this->template->title     .= ' | Pendientes '; 
            $this->template->content=View::factory('bandeja/lista_pendientes')
                                    ->bind('entrada', $entrada)
                                    ->bind('carpetas', $arrCarpetas)
                                    ->bind('user', $user)
                                    ->bind('options',$options);     
                
            }
            else
            {
                $this->template->content='No esta autorizado';
            }
        }    
        else
        {
            
//            $id_doc =0;
            $oSeg=New Model_Seguimiento();
            $entrada=$oSeg->pendiente($this->user->id);
//            foreach ($entrada as $e) {
//                $id_doc = $e->id_doc;
//            }
//            $archivos = ORM::factory('archivos')
//            ->where('id_documento', '=', $id_doc)
//            ->find_all();
            $carpetas=ORM::factory('carpetas')->where('id_oficina','=',$this->user->id_oficina)->find_all();
            $arrCarpetas=array();
            foreach($carpetas as $c)
            {
                $arrCarpetas[$c->id]=$c->carpeta;
            }
            $oDoc=New Model_Tipos();
            $documentos=$oDoc->misTipos($this->user->id);
            $options=array();
            foreach ($documentos as $d) 
            {
                $options[$d->id]=$d->tipo;
            }           
            $this->template->styles=array('media/css/tablas.css'=>'all','media/css/modal.css'=>'screen');           
            $this->template->title     .= ' | Pendientes'; 
            $this->template->content=View::factory('bandeja/pendientes')
                                    ->bind('entrada', $entrada)
                                    ->bind('carpetas', $arrCarpetas)
                                    ->bind('info', $info)
                                    ->bind('options',$options);     
        }
    }
    /*mis archivos*/   
    public function action_archivos()
    {
            $oCarpeta=New Model_Carpetas();
            $carpetas=$oCarpeta->archivadores($this->user->id);            
            $this->template->title.=' | Correspondencia archivada';
            $this->template->styles=array('media/css/tablas.css'=>'all'); 
            $this->template->content=View::factory('bandeja/archivadores')
                                    ->bind('carpetas', $carpetas);     
    }
    public function action_carpeta($id='')
    {
        $oArchivo=New Model_Archivados();
        $carpeta=$oArchivo->carpeta($id,$this->user->id);
        if(sizeof($carpeta)>0)
        {
            $user=$this->user;
            
            $this->template->styles=array('media/css/tablas.css'=>'all');
            $this->template->scripts    = array('media/js/jquery.tablesorter.min.js');
            $this->template->title.=' | '.$carpeta[0]['carpeta'];
            $this->template->content=View::factory('bandeja/carpeta')
                                        ->bind('carpeta',$carpeta)
                                        ->bind('user',$user);
        }
    }
    /*Lista de copias pendientes*/   
    public function action_copias()
    {
            $oSeg=New Model_Seguimiento();
            $entrada=$oSeg->estado(5,$this->user->id);            
            $oDoc=New Model_Tipos();
            $documentos=$oDoc->misTipos($this->user->id);
            $options=array();
            foreach ($documentos as $d) {
                $options[$d->id]=$d->tipo;
            }
           // echo sizeof($carpetas);
            $this->template->styles=array('media/css/tablas.css'=>'all');
           // $this->template->scripts=array('media/js/pendientes.js');
            $this->template->title     .= ' | Copias pendientes'; 
            $this->template->content=View::factory('bandeja/copias')
                                    ->bind('entrada', $entrada)
                                    ->bind('options',$options);     
    }
    public function action_recepcion()
    {        
            $oSeg=New Model_Seguimiento();
            $entrada=$oSeg->estado(1,$this->user->id);
            $this->template->styles=array('media/css/tablas.css'=>'all');
            $this->template->title     .= '<li><span>Entrada</span></li>'; 
            $this->template->content=View::factory('user/recepcionar')
                                    ->bind('norecibidos', $entrada);                    
    }
    public function action_recibir($id='')
    {        
        if($id!='')
        {
            $seguimiento=ORM::factory('seguimiento')->where('id','=',$id)->and_where('derivado_a','=',$this->user->id)->and_where('estado','=',1)->find();
            if($seguimiento->loaded()){
            $seguimiento->fecha_recepcion=date('Y-m-d H:i:s');
            $seguimiento->estado=2; //2=pendiente oficial
            $seguimiento->save();
            //guardamos en vitacora
            $this->save($this->user->id_entidad,$this->user->id, $this->user->nombre.' | <b>'.$this->user->cargo.'</b> Recepciono la hoja de ruta '.$seguimiento->nur);
            
            $this->request->redirect('./bandeja');
            }
            else
            {
                $this->template->content='No se pudo recepcionar correspondencia.';                    
            }            
        }
        else{
            $this->template->content='No se pudo recepcionar correspondencia.';
        }
    }  
    //detalle agrupado
    public function action_agrupado()
    {
        $nur=Arr::get($_GET,'nur');
        $hijos=array();
        $padre=ORM::factory('agrupaciones')->where('padre','=',$nur)->find_all();
        foreach($padre as $p)
        {                
                //obtenemos los hijos
                $hijo=ORM::factory('documentos')->where('nur','=',$p->hijo)->and_where('original','=',1)->find();
                if($hijo->loaded())
                {
                    $hijos[$hijo->nur]=array(
                     'id_nur'=>$hijo->nur,
                     'nur'=>$hijo->nur,
                     'documento'=>$hijo->codigo,
                     'referencia'=>$hijo->referencia,
                     'destinatario'=>$hijo->nombre_destinatario,
                     'cargo'=>$hijo->cargo_destinatario,
                    );                    
                }                
        }            
        if(sizeof($hijos)>0)
        {
            $padre=ORM::factory('documentos')->where('nur','=',$nur)->and_where('original','=',1)->find();
            $this->template->styles=array('media/css/tablas.css'=>'all');
            $this->template->content=View::factory('bandeja/agrupado')
                                        ->bind('hijos', $hijos)
                                        ->bind('padre', $padre);            
        }        
        else
        {
            $this->template->content='Error: el no agrupado !!!';
        }
    }
    public function action_desarchivar($id='')
    {
        $seguimiento=ORM::factory('seguimiento')->where('id','=',$id)->and_where('derivado_a','=',$this->user->id)->find();
        if($seguimiento->id)
        {
            //debemos eliminar de archivos
            $archivo=ORM::factory('archivados',array('id'=>$seguimiento->id_archivo));
            $archivo->delete();
            //cambiamos el estado a pendiente
            $seguimiento->estado=2;
            $seguimiento->id_archivo=0;
            $seguimiento->save();             
            $this->request->redirect('bandeja/pendientes');
        }
        else
        {
            $this->template->content=View::factory('acceso_denegado');
        }
    }
    //documentos enviados
    public function action_enviados()
    {
            $oSeg=New Model_Seguimiento();
            $entrada=$oSeg->enviados($this->user->id);                      
            $this->template->styles=array('media/css/tablas.css'=>'all','media/css/modal.css'=>'screen');           
            $this->template->title     .= ' | Correspondencia enviada'; 
            $this->template->content=View::factory('bandeja/enviados')
                                    ->bind('entrada', $entrada); 
    }
    //imprimir enviado
    public function action_printDeriv($id='')
    {
        $seg=ORM::factory('seguimiento',$id);
        if($seg->loaded())
        {
           if(($seg->derivado_por==$this->user->id)&&($seg->estado=='1'))
           {
               $oSeg=New Model_Seguimiento();
               $derivado=$oSeg->derivado($id);
               $this->template->content=View::factory('bandeja/print_deriv')
                                        ->bind('derivado',$derivado);               
           }
           else
           {
               echo 'no se puede';
           }
        }
    }    
    //imprimir enviado
    public function action_cancelar($id='')
    {   
        $info=array();
        $seg=ORM::factory('seguimiento',array('id'=>$id));
        $nur=$seg->nur;
        $control = '';
        if($seg->loaded())
        {
           //if(($seg->derivado_por==$this->user->id)&&($seg->estado=='1'))

           if($seg->estado=='1') 
           {               
               $padre   = $seg->id_seguimiento; //si tiene seguimiento anterior?
               $oficial = $seg->oficial;
               $seg->delete();
               //si tiene seguimiento
               if($padre>0)
               {
                   $oSeg=New Model_Seguimiento();
                   $oSeg->delete_deriv($padre);
                   $seguimiento=ORM::factory('seguimiento',array('id'=>$padre));                   
                    if($seguimiento->oficial==2)
                        $seguimiento->oficial=1;                    
                    $seguimiento->estado=2; //pendiente                   
                    $seguimiento->save();
                    
                    // Modificado por Freddy
                    $documentos = ORM::factory('documentos')->where('nur','=',$nur)->and_where('estado','=','1')->and_where('id_seguimiento','=',$padre)->order_by('id', 'desc')->find();
                    if($documentos->loaded()){
                    // $documento=ORM::factory('documentos')->where('nur','=',$nur)->and_where('original','=',1)->find();
                    $documento=ORM::factory('documentos')->where('nur','=',$nur)->and_where('id','=',$documentos->id)->find();  //modificado por freddy    
                    $documento->estado=0;
                    $documento->save();
                    $info['info']='<b>Restaurado!: </b>La hoja de ruta fue restaurada, para volver derivar busque el documento <a href="/documento/editar/'.$documentos->id.'">'.$documentos->codigo.'</a>';
                    
                    } else {
                        $info['info']='<b>Restaurado!: </b>La hoja de ruta fue restauradoa a sus <a href="/bandeja/pendientes">pendientes</a>';
                    }       
                    $info['info']='<b>Restaurado!: </b>La hoja de ruta fue restauradoa a sus <a href="/bandeja/pendientes">pendientes</a>';
                    
               }
               //primera derivacion
               else 
               {
                   if($oficial==1)
                   {                    
                    $documento=ORM::factory('documentos')->where('nur','=',$nur)->and_where('original','=',1)->find();
                    $documento->estado=0;
                    $documento->save();
                    $info['info']='<b>Restaurado!: </b>La hoja de ruta fue restaurada, para volver derivar busque el documento <a href="/documento/editar/'.$documento->id.'">'.$documento->codigo.'</a>';
                   }
               }                           
           }
           else
           {
               $error['error']='<b>Error!: </b>La hoja de ruta ya fue recibida por el destinatario o usted no lo tenia en su bandeja de salida';
           }
        }
            
            if ($seg->derivado_por==$this->user->id) {
               $oSeg=New Model_Seguimiento();
            $entrada=$oSeg->enviados($this->user->id);                      
            $this->template->styles=array('media/css/tablas.css'=>'all','media/css/modal.css'=>'screen');           
            $this->template->title     .= ' | Correspondencia enviada'; 
            $this->template->content=View::factory('bandeja/enviados')
                                    ->bind('entrada', $entrada)
                                    ->bind('info', $info) 
                                    ->bind('error', $error); 
            }else{
                $this->request->redirect('bandeja');
            }


            
        
    }
    
    public function action_agrupados()
    {
        $count=ORM::factory('agrupaciones')->where('id_user','=',$this->user->id)->count_all();
        $pagination = Pagination::factory(array(
  		'total_items'    => $count,
                'current_page'   => array('source' => 'query_string', 'key' => 'page'),
                'items_per_page' => 50,
                'view'           => 'pagination/floating',            
                ));  		                                
        $page_links = $pagination->render();        
        $oDocumentos = New Model_Documentos();
        $agrupados=$oDocumentos->agrupaciones($this->user->id,$pagination->offset,$pagination->items_per_page);
        $this->template->title.='| Agrupados';
        $this->template->styles=array('media/css/tablas.css'=>'all','media/css/modal.css'=>'screen');
        $this->template->scripts    = array('media/js/jquery.tablesorter.min.js');
        $this->template->content=View::factory('bandeja/agrupados')
                                ->bind('result',$agrupados)
                                ->bind('count',$count)
                                ->bind('page_links',$page_links);
    }


    public function action_createcarpetas()
    {
        $oCarpetas = New Model_Carpetas();
        $carpetas = $oCarpetas->lista_carpetas($this->user->id_oficina);
        $this->template->title.=' | Carpetas';
        $this->template->styles=array('media/css/tablas.css'=>'all','media/css/modal.css'=>'screen');
        $this->template->scripts    = array('media/js/jquery.tablesorter.min.js');
        $this->template->content = View::factory('bandeja/lista_carpetas')
                ->bind('carpetas', $carpetas);
    }
    
    public function action_form($id = '') {
        $options = array();
        if ($this->user->nivel == 5) {
            $oficinas = ORM::factory('oficinas')->find_all();
        }else{
            $oficinas = ORM::factory('oficinas')->where('id','=',$this->user->id_oficina)->find_all();    
        }

        foreach ($oficinas as $o) {
            $options[$o->id] = $o->oficina . ' | ' . $o->sigla;
        }
        $valor = ORM::factory('carpetas', $id);
        $this->template->title.=' | Crear Carpeta';
        $this->template->content = View::factory('bandeja/add_carpeta')
                ->bind('options', $options)
                ->bind('carpeta', $valor)
                ->bind('error', $error)
                ->bind('info', $info);
        
    }

    public function action_savecarpeta(){
        //echo "todo esta bien";
        //$error = array();
        $info = array();
        if (isset($_POST['create'])) {
            $carpeta = ORM::factory('carpetas',$_POST['id']);
            unset($_POST['id']);
            $carpeta->id_oficina = $_POST['id_oficina'];
            $carpeta->carpeta = $_POST['carpeta'];
            $carpeta->fecha_creacion = date("Y-m-d H:i:s");
            $carpeta->nivel = 2;
            $carpeta->save();
            if ($carpeta->id) {
                //ahora guardamos por defecto el cite para los tipos de documentos
                $info['Exito!'] = 'Se creo correctamente la carpeta <b>' . $carpeta->carpeta . '</b>';
                //$_POST = array();
            }
        }
        
        $this->request->redirect('bandeja/createcarpetas');
    }
    
    public function action_delete($id = ''){
        if($id){
        $carpeta = ORM::factory('carpetas',$id);
        $carpeta->nivel = 1;
        $carpeta->save();
        }
        
        $this->request->redirect('bandeja/createcarpetas');
    }

    public function acciones() {
        $acciones = array();
        $acc = ORM::factory('acciones')->find_all();
        foreach ($acc as $a) {
            $acciones [$a->id] = $a->accion;
        }
        return $acciones;
    }

    public function destinatarios($id_user, $id_superior) {

        $lista_derivacion = array();
        $oDestino = New Model_Destinatarios();
        //dependientes
        $lista_destinos = $oDestino->dependientes($id_user);
        foreach ($lista_destinos as $l) {
            $lista_derivacion [$l['id']] = $l['oficina'] . ' - ' . Text::limit_words($l['nombre'], 6, '');
        }
        //superior
        $lista_destinos = $oDestino->superior($id_superior);
        foreach ($lista_destinos as $l) {
            $lista_derivacion [$l['id']] = $l['oficina'] . ' - ' . Text::limit_words($l['nombre'], 6, '');
        }

        $lista_destinos = $oDestino->destinos($id_user);
        foreach ($lista_destinos as $l) {
            if (!array_key_exists($l->id, $lista_derivacion))
                $lista_derivacion [$l->id] = $l->oficina . ' - ' . Text::limit_words($l->nombre, 6, '');
        }

        //print_r($lista_destinos);
        //sort($lista_derivacion, true);
        //sort($lista_derivacion);
        return $lista_derivacion;
    }
    
}
?>
