<?php
defined('SYSPATH') or die('Acceso denegado');
class Controller_ventanilla extends Controller_DefaultTemplate{
    protected $user;
    protected $menus;
    public function before() 
    {
        $auth =  Auth::instance();
        //si el usuario esta logeado entocnes mostramos el menu
        if($auth->logged_in()){
        //menu-top de acuerdo al nivel
            $session=Session::instance();
            $this->user=$session->get('auth_user'); 
            $oNivel=New Model_niveles();
            $this->menus=$oNivel->menus($this->user->nivel); 
        parent::before();    
        $this->template->title='Ventanilla ';
        }
        else{
            
            $url= substr($_SERVER['REQUEST_URI'],1);
            $this->request->redirect('/login?url='.$url);
        }        
    }
    public function after() 
    {
        $this->template->menutop = View::factory('templates/menutop')->bind('menus',$this->menus)->set('controller', 'ventanilla');
        $oSM=New Model_menus();
        $submenus=$oSM->submenus('ventanilla');
        $docs=FALSE;
        if($this->user->nivel==4)
        {
            $docs=TRUE;
        }
        $this->template->submenu = View::factory('templates/submenu')->bind('smenus',$submenus)->bind('doc',$docs)->set('titulo','recepcion externa');        
        parent::after();                
    }  
    public function action_principal()
    {
        $user=ORM::factory('users',array('id'=>$this->user->id));
        $oficina=$user->oficina->oficina;        
        $recepcionados=ORM::factory('documentos')->where('id_user','=',$this->user->id)->count_all();
        $derivados=ORM::factory('documentos')->where('id_user','=',$this->user->id)
                                              ->and_where('estado','=',1)
                                              ->count_all();
        $pendientes=ORM::factory('documentos')->where('id_user','=',$this->user->id)
                                              ->and_where('estado','=',0)
                                              ->count_all();
        $this->template->title  ='Ventanilla | Pendientes';
        $this->template->styles=array('media/css/tablas.css'=>'screen');
        $this->template->content=View::factory('ventanilla/menu')
                                ->bind('user',$user)
                                ->bind('oficina', $oficina)
                                ->bind('pendientes',$pendientes)
                                ->bind('recepcionados',$recepcionados)
                                ->bind('derivados',$derivados);        
    }
    public function action_listar()
    {
        $count=ORM::factory('documentos')->where('id_user','=',$this->user->id)->count_all();        
        $pagination = Pagination::factory(array(
  		'total_items'    => $count,
                'current_page'   => array('source' => 'query_string', 'key' => 'page'),
                'items_per_page' => 40,
                'view'           => 'pagination/floating',            
                ));  		                    
        $results=ORM::factory('documentos')
                                   ->where('id_user','=',$this->user->id)
                                   ->order_by('fecha_creacion','DESC')
                                   ->limit($pagination->items_per_page)
                                   ->offset($pagination->offset)
                                   ->find_all();                                   
      // Render the pagination links
  	$page_links = $pagination->render();
        
        $this->template->title  ='Ventanilla | Recepcionada';
        $this->template->styles=array('media/css/tablas.css'=>'screen');
        $this->template->content=View::factory('ventanilla/lista_documentos')
                                ->bind('results',$results)
                                ->bind('page_links',$page_links)
                                ->bind('count',$count);
    }
    public function action_pendientes()
    {
        $oVentanilla=New Model_documentos();
        $pendientes=$oVentanilla->pendiente_ventanilla($this->user->id);
        $this->template->title  ='Ventanilla | Pendientes';
        $this->template->styles=array('media/css/tablas.css'=>'screen');
        $this->template->content=View::factory('ventanilla/lista_pendientes')
                                ->bind('pendientes',$pendientes);
    }
    //modulo para ventanilla    
    public function action_index()
    {
            //solo usuarios nivel 4 (ventanilla) pueden realizar esta accion
            if($this->user->nivel==4){
                $errors=array();
            // si se envio datos mediante el metodo post creamos el documento
            $tipo=ORM::factory('tipos')->where('id','=',6)->find();
            if($_POST){                
               /* $oOficina = New Model_Oficinas();    
                $correlativo=$oOficina->correlativo($this->user->id_oficina, $tipo->id);
                $abre=$oOficina->tipo($tipo->id);
                $sigla=$oOficina->sigla($this->user->id_oficina);
                             if($abre!='') $abre=$abre.'/';
                $codigo=$abre.$sigla.' Nº '.$correlativo.'/'.date('Y');                
               */
                $entidad=$this->user->id_entidad; 
                $entidad=ORM::factory('entidades',$entidad);
                
                $oExt=New Model_nurs();  
                // entidad/
                $codigo=$oExt->correlativo(-3, $entidad->doc_externo,$entidad->id);
                //CREAMOS UN NUEVO DOCUMENTO                
                $documento = ORM::factory('documentos');                
                $documento->codigo= $codigo;
                $documento->cite_original= $_POST['cite'];
                $documento->id_tipo=6;
                $documento->nombre_destinatario=$_POST['destinatario'];
                $documento->cargo_destinatario=$_POST['cargodes'];
                $documento->institucion_destinatario=$_POST['instituciondes'];
               // $fecha=strtotime($_POST['year'].'-'.$_POST['mes'].'-'.$_POST['dia']);
                $documento->nombre_remitente=$_POST['remitente'];
                $documento->cargo_remitente=$_POST['cargorem'];
                $documento->institucion_remitente=$_POST['institucionrem'];
                $documento->referencia=  strtoupper($_POST['descripcion']);
                $documento->adjuntos=$_POST['adjunto'];
                $documento->original=1;
                $documento->hojas=$_POST['hojas'];
               // $documento->id_proceso=Arr::get($_POST,'proceso',1);
                $documento->fecha_creacion = date('Y-m-d H:i:s');
                $documento->id_user=$this->user->id;                
                $documento->id_oficina=$this->user->id_oficina;                
                $documento->id_proceso=1;                
                $documento->id_entidad=$this->user->id_entidad;                
                $documento->save();
                if($documento->id){
                    $oNur=New Model_nurs();     
                    $nur=$oNur->correlativo(-1, $entidad->sigla2.'/',$this->user->id_entidad);
                    //anterior $nur=$oNur->correlativo(-2, $entidad->nur_externo,$entidad);                                   
                    $nur_asignado=$oNur->asignarNur($nur, $this->user->id,$this->user->nombre);
                    $documento->nur=$nur_asignado;
                    $documento->save();
                    //cazamos al documento con el nur asignado
                    $rs=$documento->has('nurs', $nur_asignado);
                    $documento->add('nurs', $nur_asignado);  
                    //descripcion el documento
                    $descripcion=ORM::factory('descripcion');
                    $descripcion->id_documento=$documento->id;
                    //$descripcion->id_grupo=$_POST['grupo'];
                    $descripcion->id_motivo=$_POST['motivo'];
                   // $descripcion->id_proceso=Arr::get($_POST,'proceso',1);
                    $descripcion->id_user=$this->user->id;
                    $descripcion->fecha=$_POST['year'].'-'.$_POST['mes'].'-'.$_POST['dia'].' '.date('H:i:s');
                    $descripcion->save();
                    /*
                    $post = Validation::factory ( $_FILES )
                                ->rule('archivo', 'Upload::not_empty')
                                ->rule('archivo', 'Upload::type', array(':value', array('pdf')))
                                ->rule('archivo', 'Upload::size', array(':value', '20M'));
						//si pasa la validacion guardamamos 
                    if ($post->check ()) 
                        {		
                        $path='archivos/'.date('Y_m');
                            if(!is_dir($path)) 
                            { 
                            // Creates the directory 
                            if(!mkdir($path, 0777, TRUE)) 
                                { 
                                // On failure, throws an error 
                                throw new Exception("No se puedo crear el directorio!");
                                exit;
                                } 
                            }                       
                            $filename = upload::save ( $_FILES ['archivo'],uniqid().substr($documento->nur,-10).'.pdf',$path );												
                            $archivo = ORM::factory ( 'archivos' ); //instanciamos el modelo						
                            $archivo->nombre_archivo = basename($filename);
                            $archivo->extension = $_FILES ['archivo'] ['type'];
                            $archivo->tamanio = $_FILES ['archivo'] ['size'];
                            $archivo->id_user = $this->user->id;
                            $archivo->id_documento = $documento->id;
                            $archivo->sub_directorio = date('Y_m');
                            $archivo->fecha = date('Y-m-d H:i:s');
                            $archivo->save ();
                        }                     
                     */
                    $_POST=array();
                    $_FILES=array();
                    $this->request->redirect('ventanilla/editar/'.$documento->id);                
               }
            }
        
        
        
            $days=array();
            for($i=1;$i<32;$i++){
                $days[$i]=$i;
            }
            $months=array(1=>'Enero',2=>'Febrero',3=>'Marzo',4=>'Abril',5=>'Mayo',6=>'Junio',7=>'Julio',8=>'Agosto',9=>'Septiembre',10=>'Octubre',11=>'Noviembre',12=>'Diciembre');
            $years=array();
            $year=date('Y');            
            for($i=($year-1);$i<=$year;$i++){
                $years[$i]=$i;
            }
            $grupos=array();
            //GRUPOS
            $result=ORM::factory('grupos')->where('activo','=',1)->find_all();
            foreach ($result as $r) {
                $grupos[$r->id]=$r->grupo;
                
            }
            $motivos=array();
            //GRUPOS
            $result=ORM::factory('motivos')->where('activo','=',1)->find_all();
            foreach ($result as $r) {
                $motivos[$r->id]=$r->motivo;
                
            }
            //PROCESOS
            $procesos=array();            
            $result=ORM::factory('procesosx')->where('activo','=',1)->find_all();
            foreach ($result as $r) {
                $procesos[$r->id]=$r->proceso;
                
            }
            //destinatarios            
            $oDestinatario=New Model_Destinatarios();
            $destinos=$oDestinatario->destinos($this->user->id);
            $oficina=$this->user->id_oficina;
            //$this->template->scripts    = array('ckeditor/adapters/jquery.js','ckeditor/ckeditor.js');            
            $this->template->title      .= ' | Recepción de documentos externos';                 
            $this->template->content    =View::factory('ventanilla/reception')
                                        ->bind('days', $days)
                                        ->bind('months', $months)
                                        ->bind('years', $years)
                                        ->bind('grupos', $grupos)
                                        ->bind('motivos', $motivos)
                                        ->bind('procesos', $procesos)
                                        ->bind('destinos', $destinos)
                                        ->bind('oficina', $oficina);
            
            }
    }
    
    
    
    
   //editar recepcion de documentos mediante vetanilla
    public function action_editar($id){  
        $error=array();
        $info=array();
            if(isset($_POST['submit']))
            {
                $documento = ORM::factory('documentos',$id);                
                $documento->cite_original= $_POST['cite'];
                $documento->id_tipo=6;
                $documento->nombre_destinatario=$_POST['destinatario'];
                $documento->cargo_destinatario=$_POST['cargodes'];
                $documento->institucion_destinatario=$_POST['instituciondes'];
               // $fecha=strtotime($_POST['year'].'-'.$_POST['mes'].'-'.$_POST['dia']);
                $documento->nombre_remitente=$_POST['remitente'];
                $documento->cargo_remitente=$_POST['cargorem'];
                $documento->institucion_remitente=$_POST['institucionrem'];
                $documento->referencia=  strtoupper($_POST['descripcion']);
                $documento->adjuntos=$_POST['adjunto'];
                $documento->hojas=$_POST['hojas'];
               // $documento->id_proceso=Arr::get($_POST,'proceso',1);
                $documento->id_proceso=1;                
                $documento->save();     
                if($_FILES['archivo']['name']!='')
                {
                $post = Validation::factory ( $_FILES )
                                ->rule('archivo', 'Upload::not_empty')
                                ->rule('archivo', 'Upload::type', array(':value', array('pdf')))
                                ->rule('archivo', 'Upload::size', array(':value', '20M'));
						//si pasa la validacion guardamamos 
                    if ($post->check ()) 
                        {				                   
                            $path='archivos/'.date('Y_m');
                            if(!is_dir($path)) 
                            { 
                            // Creates the directory 
                            if(!mkdir($path, 0777, TRUE)) 
                                { 
                                // On failure, throws an error 
                                throw new Exception("No se puedo crear el directorio!");
                                exit;
                                } 
                            }       
                            $filename = upload::save ( $_FILES ['archivo'],uniqid().substr($documento->nur,-10).'.pdf',$path );											                            
                            $archivo = ORM::factory ( 'archivos',$_POST['id_archivo'] ); //intanciamos el modelo proveedor							
                            $archivo->nombre_archivo = basename($filename);
                            $archivo->extension = $_FILES ['archivo'] ['type'];
                            $archivo->tamanio = $_FILES ['archivo'] ['size'];
                            $archivo->id_user = $this->user->id;
                            $archivo->id_documento = $documento->id;
                            $archivo->sub_directorio = date('Y_m');
                            $archivo->fecha = date('Y-m-d H:i:s');
                            $archivo->save ();     
                            $info['Documento escaneado: ']='Documento subido con exito'; 
                        }
                      else{
                          $error['Documento escaneado: ']='El documento debe ser pdf y de un tamaño no mayor a 20M';                            
                        }
               }               
            $_POST=array();
            $_FILES=array();
               
            }        
            $documento=ORM::factory('documentos')->where('id','=',$id)->and_where('id_user','=',$this->user->id)->find();            
            if($documento->loaded())
            {
             $days=array();
            for($i=1;$i<32;$i++){
                $days[$i]=$i;
            }
            $months=array(1=>'Enero',2=>'Febrero',3=>'Marzo',4=>'Abril',5=>'Mayo',6=>'Junio',7=>'Julio',8=>'Agosto',9=>'Septiembre',10=>'Octubre',11=>'Noviembre',12=>'Diciembre');
            $years=array();
            $year=date('Y');            
            for($i=($year-1);$i<=$year;$i++){
                $years[$i]=$i;
            }
            $grupos=array();
            //GRUPOS
            $result=ORM::factory('grupos')->where('activo','=',1)->find_all();
            foreach ($result as $r) {
                $grupos[$r->id]=$r->grupo;
                
            }
            $motivos=array();
            //GRUPOS
            $result=ORM::factory('motivos')->where('activo','=',1)->find_all();
            foreach ($result as $r) {
                $motivos[$r->id]=$r->motivo;
                
            }
            //PROCESOS
            $procesos=array();            
            $result=ORM::factory('procesosx')->where('activo','=',1)->find_all();
            foreach ($result as $r) {
                $procesos[$r->id]=$r->proceso;
                
            }
            $archivo=ORM::factory('archivos')->where('id_documento','=',$id)
                        ->find();
            //destinatarios            
            $oDestinatario=New Model_Destinatarios();
            $destinos=$oDestinatario->destinos($this->user->id);
            $this->template->title.=' | Editar'.$documento->codigo;
            $this->template->content=View::factory('ventanilla/editar')
                                            ->bind('documento', $documento)
                                            ->bind('days', $days)
                                            ->bind('months', $months)
                                            ->bind('years', $years)
                                            ->bind('grupos', $grupos)
                                            ->bind('motivos', $motivos)
                                            ->bind('procesos', $procesos)
                                            ->bind('archivo', $archivo)
                                            ->bind('destinos', $destinos)
                                            ->bind('error', $error)
                                            ->bind('info', $info);
            }
    }


    public function action_doa_ventanilla()    
    {
        if($_POST){
           if ($_POST['accion']==3) {  // 3= derivar varias hojas de ruta
                $nurs=array();
                $oSeg=New Model_Seguimiento();                
                foreach($_POST['id_doc'] as $k=>$v)
                {
                    $nur=$oSeg->nur_ref_doc($v);
                    $id=$nur[0]['id'];
                    $nurs[$id][0]=$nur[0]['nur'];
                    $nurs[$id][1]=$nur[0]['referencia'];
                    $nurs[$id][2]=1;   // oficial 
                    $nurs[$id][3]=0;      //hijo
                    //$nurs[$id][4]=$nur[0]['id_doc'];
                }
                $acciones = $this->acciones();
                $destinatarios = $this->destinatarios($this->user->id, $this->user->superior);
                $this->template->styles=array('media/css/tablas.css'=>'all','media/css/modal.css'=>'screen');
                $this->template->title.=' | Derivar correspondencia';
                $this->template->content=View::factory('ventanilla/derivar')
                                         ->bind('nurs',$nurs)
                                         ->bind('accion',$acciones)
                                         ->bind('destinatario', $destinatarios);
            }
        }        
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
        $this->request->redirect('ventanilla/pendientes');
    }
   
}
?>
