<?php

defined('SYSPATH') or die('Acceso denegado');

class Controller_Hojaruta extends Controller_DefaultTemplate {

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
            $this->template->title = 'Hojas de ruta';
        } else {
            $url = substr($_SERVER['REQUEST_URI'], 1);
            $this->request->redirect('/login?url=' . $url);
        }
    }

    public function after() {
        $this->template->menutop = View::factory('templates/menutop')->bind('menus', $this->menus)->set('controller', 'hojaruta');
        $oSM = New Model_menus();
        $submenus = $oSM->submenus('hojaruta');
        $this->template->submenu = View::factory('templates/submenu')->bind('smenus', $submenus)->set('titulo', 'Hojas de ruta');
        parent::after();
    }

    //listar nuris generados por el usuario logeado
    public function action_index() {
        $count = ORM::factory('documentos')->where('original', '=', 1)->and_where('id_user', '=', $this->user->id)->count_all();
        $pagination = Pagination::factory(array(
            'total_items' => $count,
            'current_page' => array('source' => 'query_string', 'key' => 'page'),
            'items_per_page' => 50,
            'view' => 'pagination/floating',
            ));
        $oNur = New Model_Hojasruta();
        $result = $oNur->hojasruta($this->user->id, $pagination->offset, $pagination->items_per_page);
        $page_links = $pagination->render();
        $oDoc = New Model_Tipos();
        $documentos = $oDoc->misTipos($this->user->id);
        $options = array();
        foreach ($documentos as $d) {
            $options[$d->id] = $d->tipo;
        }
        $this->template->title .= ' | Lista de HR creadas';
        $this->template->styles = array('media/css/tablas.css' => 'all', 'media/css/modal.css' => 'screen');
        $this->template->scripts = array('media/js/jquery.tablesorter.min.js');
        $this->template->content = View::factory('hojaruta/index')
        ->bind('result', $result)
        ->bind('page_links', $page_links)
        ->bind('count', $count)
        ->bind('options', $options);
    }

    /* Function que me permite generar una respuesta 
     * 
     * 
     * 
     */

    public function action_responder() {
        $info = Array();
        if ($_POST['aceptar']) {
            $id_seg = Arr::get($_POST, 'id_seg');
            $nur = Arr::get($_POST, 'nur');
            $id_tipo = Arr::get($_POST, 'documento');
            
            
            $doc_idmemo = ORM::factory('documentos')->where('nur','=',$nur)->and_where('fucov','=',1)->find();
            if ($doc_idmemo->loaded() and  $id_tipo==13) {
                $id_memo = $doc_idmemo->id;
                $fucov = 1;
            }  else {
                $id_memo = Arr::get($_POST, 'id_documento');
                $fucov = Arr::get($_POST, 'fucov');
                
            }
            
            $seguimiento = ORM::factory('seguimiento', $id_seg);
            if ($seguimiento->loaded()) {
                //Freddy Validamos si el memo ya tiene un fucov asignado

                $pvfucov = ORM::factory('pvfucovs')->where('id_memo', '=', $id_memo)->find();
                // $doc_fucov = ORM::factory('documentos')->where('id','=',$id_memo)->find();
                
                // if ($pvfucov->loaded() && $id_tipo==13 && $doc_fucov->fucov=='0') {
                if ($pvfucov->loaded() && $id_tipo==13 ) {

                    $info['info'] = '<b>Mensaje!: </b>El siguiente documento ' . $nur . ' ya tiene asignado un fucov o No es un memorandum de viaje';
                    $oSeg = New Model_Seguimiento();
                    $entrada = $oSeg->pendiente($this->user->id);
                    $carpetas = ORM::factory('carpetas')->where('id_oficina', '=', $this->user->id_oficina)->find_all();
                    $arrCarpetas = array();
                    foreach ($carpetas as $c) {
                        $arrCarpetas[$c->id] = $c->carpeta;
                    }
                    $oDoc = New Model_Tipos();
                    $documentos = $oDoc->misTipos($this->user->id);
                    $options = array();
                    foreach ($documentos as $d) {
                        $options[$d->id] = $d->tipo;
                    }
                    $this->template->styles = array('media/css/tablas.css' => 'all', 'media/css/modal.css' => 'screen');
                    $this->template->title .= ' | Pendientes';
                    $this->template->content = View::factory('bandeja/pendientes')
                    ->bind('entrada', $entrada)
                    ->bind('carpetas', $arrCarpetas)
                    ->bind('info', $info)
                    ->bind('options', $options);
                } else {

                    if($id_tipo=='13'){
                        $tipo_doc = array('15','14','13');
                    }else{
                        $tipo_doc = array($id_tipo);
                    }

                    if ($id_tipo=='16') {
                        $referencia = 'DOCUMENTACIÓN QUE DEBE ADJUNTAR PARA SU FILE PERSONAL';
                        $contenidoRH = '<!DOCTYPE html>
<html>
<head>
</head>
<body>
<p align="JUSTIFY"><span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;">De mi mayor consideraci&oacute;n:</span></p>
<p style="text-align: justify;"><span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;">Con la finalidad de dar cumplimiento al Registro de Personal del Sistema de Administraci&oacute;n de Personal (SAP), la Unidad de Recursos Humanos solicita que en el plazo de 5 d&iacute;as, remita a esta Unidad la documentaci&oacute;n esencial para conformar su file personal de acuerdo al siguiente detalle:</span></p>
<ul>
<li><span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;">Hoja de Vida actualizada, con sus respectivos respaldos.</span></li>
<li><span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;">Fotocopia de Cedula de Identidad</span></li>
<li><span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;">Fotocopia de Libreta de Servicio Militar (varones)</span></li>
<li><span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;">Fotocopia de N&uacute;mero de Cuenta (Banco Uni&oacute;n)</span></li>
<li><span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;">Registro/Carnet de N&uacute;mero &Uacute;nico de Afiliado AFP (NUA)</span></li>
<li><span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;">Documentaci&oacute;n para afiliaci&oacute;n Caja Nacional de Salud</span><span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;"><br /></span></li>
</ul>
<table style="height: 124px;" border="1" width="730" cellspacing="0" cellpadding="7"><colgroup><col width="310" /> <col width="268" /> </colgroup>
<tbody>
<tr valign="TOP">
<td width="310">
<p align="CENTER"><em><span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;">AFILIACI&Oacute;N - PRIMERA VEZ</span></em></p>
</td>
<td width="268">
<p align="CENTER"><em><span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;">AFILIACI&Oacute;N - REINGRESO</span></em></p>
</td>
</tr>
<tr valign="TOP">
<td width="310" height="13">
<p align="JUSTIFY"><span style="font-family: arial,helvetica,sans-serif; font-size: 8pt;">Certificado de Nacimiento Original<br /></span></p>
</td>
<td width="268">
<p><span style="font-family: arial,helvetica,sans-serif; font-size: 8pt;">Formulario AVC 04 de afiliaci&oacute;n y AVC 07 de baja anterior instituci&oacute;n (original) </span></p>
</td>
</tr>
<tr valign="TOP">
<td width="310">
<p><span style="font-family: arial,helvetica,sans-serif; font-size: 8pt;">Fotocopia &uacute;ltima boleta de pago o memor&aacute;ndum de designaci&oacute;n</span></p>
</td>
<td width="268">
<p><span style="font-family: arial,helvetica,sans-serif; font-size: 8pt;">Fotocopia &uacute;ltima boleta de pago o memor&aacute;ndum de designaci&oacute;n</span></p>
</td>
</tr>
<tr valign="TOP">
<td width="310" height="8">
<p><span style="font-family: arial,helvetica,sans-serif; font-size: 8pt;">Fotocopia Carnet de Identidad</span></p>
</td>
<td width="268">
<p><span style="font-family: arial,helvetica,sans-serif; font-size: 8pt;">Fotocopia Carnet de Identidad</span></p>
</td>
</tr>
</tbody>
</table>
<p align="JUSTIFY">&nbsp;</p>
<p align="JUSTIFY"><span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;">Al mismo tiempo se deben llenar los formularios de:</span></p>
<ul>
<li>Registro de Ficha Personal con fotograf&iacute;a 4x4 fondo azul</li>
<li>Declaraci&oacute;n de Incompatibilidad y Conflictos de Intereses</li>
<li>Declaraci&oacute;n Jurada de Incompatibilidad por la Funci&oacute;n P&uacute;blica</li>
<li>Declaraci&oacute;n Jurada de Incompatibilidad por la Funci&oacute;n P&uacute;blica para abogados</li>
</ul>
<p align="JUSTIFY">&nbsp;<span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;">(Disponibles en la p&aacute;gina web: intranet.produccion.gob.bo)</span></p>
<p><span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;">Sin otro particular saludo a usted con la mayor atenci&oacute;n.</span></p>
<hr />
<p align="JUSTIFY"><span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;"><strong><span lang="es-MX">REF.: &nbsp; &nbsp; </span></strong><span lang="es-MX">COMUNICACI&Oacute;N INTERNA</span></span></p>
<p style="text-align: justify;"><span lang="es-MX" style="font-family: arial,helvetica,sans-serif; font-size: 10pt;">A efecto de dar cumplimiento con el Art&iacute;culo 15 del Reglamento Espec&iacute;fico del Sistema de Administraci&oacute;n de Personal, referente al Proceso de Inducci&oacute;n o Integraci&oacute;n, mediante la presente se le comunica que de forma OBLIGATORIA debe informarse sobre:</span></p>
<p><span lang="es-MX" style="font-family: arial,helvetica,sans-serif; font-size: 10pt;">1. Objetivos y funciones del Ministerio de Desarrollo Productivo en los siguientes enl&aacute;celes:</span></p>
<p><span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;"><a href="http://www.produccion.gob.bo/contenido/id/4">http://www.produccion.gob.bo/contenido/id/4</a></span></p>
<p align="JUSTIFY"><span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;"><a href="http://www.produccion.gob.bo/contenido/id/3"><span style="text-decoration: underline;">http://www.produccion.gob.bo/contenido/id/3</span></a></span></p>
<p style="text-align: justify;" align="JUSTIFY"><span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;"><span lang="es-MX">2. L</span><span lang="es-MX">a Normativa especifica de la Entidad en el enlace <a href="http://www.produccion.gob.bo/documentos/reglamentos">http://www.produccion.gob.bo/documentos/reglamentos</a> con el siguiente contenido:</span></span></p>
<ul>
<li><span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;">Procedimiento para el Cumplimiento Oportuno de la Declaraci&oacute;n Jurada de Bienes y Rentas (PCO-DJBR)</span></li>
<li><span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;">Reglamento Interno de Personal</span></li>
<li><span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;">Reglamento interno de pasant&iacute;as profesionales, universitarias y de trabajos dirigidos</span></li>
<li><span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;">Reglamento de Pasajes y Vi&aacute;ticos</span></li>
<li><span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;">Reglamento Especifico del Sistema de Administraci&oacute;n de Bienes y Servicios</span></li>
<li><span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;">Reglamento Espec&iacute;fico del Sistema de Tesorer&iacute;a</span></li>
<li><span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;">Reglamento Espec&iacute;fico del Sistema de Programaci&oacute;n de Operaciones</span></li>
<li><span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;">Reglamento Espec&iacute;fico del Sistema de Presupuesto</span></li>
<li><span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;">Reglamento Espec&iacute;fico del Sistema de Organizaci&oacute;n Administrativa</span></li>
<li><span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;">Reglamento Espec&iacute;fico del Sistema de Contabilidad Integrada</span></li>
<li><span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;">Reglamento Espec&iacute;fico del Sistema de Administraci&oacute;n de Personal</span></li>
<li><span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;">Manual de Uso del Sistema CODICE de Correspondencia, (<a href="http://intranet.produccion.gob.bo/">http://intranet.produccion.gob.bo/</a>) carpeta <br />Manuales&nbsp;</span></li>
</ul>
<p style="text-align: justify;" align="JUSTIFY"><span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;">Asimismo, adjunto a la presente el POAI correspondiente al puesto de trabajo designado, para el conocimiento de las funciones a desarrollar y su respectiva suscripci&oacute;n.</span></p>
<p><span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;">Sin otro particular, saludo a usted atentamente.<br /></span></p>
</body>
</html>';
                    }
                    
                    foreach ($tipo_doc as $value) {
                        $id_tipo = $value;
                        $tipo = ORM::factory('tipos', $id_tipo);
                        $oOficina = New Model_Oficinas();
                        $correlativo = $oOficina->correlativo($this->user->id_oficina, $tipo->id);
                        $abre = $oOficina->tipo($tipo->id);
                        $sigla = $oOficina->sigla($this->user->id_oficina);
                        if ($abre != '')
                            $abre = $abre . '/';
                        $codigo = $abre . $sigla . ' Nº ' . $correlativo . '/' . date('Y');
                        //obtenemos el id_proceso del documento original
                        $proceso = ORM::factory('documentos')->where('nur', '=', $nur)->and_where('original', '=', 1)->find();

                        //Modificado por freddy
                        $odoc = new Model_Documentos();
                        $odoc->updateEstado($nur);
                        $memo = ORM::factory('documentos', $id_memo);
                        $pvcomision = ORM::factory('pvcomisiones')->where('id_documento', '=', $id_memo)->find();
                        /////////////////////////////////////////////
                        //generamos el documento
                        $documento = ORM::factory('documentos');
                        $documento->id_user = $this->user->id;
                        $documento->codigo = $codigo;
                        $documento->cite_original = $codigo;
                        $documento->id_tipo = $tipo->id;
                        $documento->nombre_destinatario = $seguimiento->nombre_emisor;
                        $documento->cargo_destinatario = $seguimiento->cargo_emisor;
                        $documento->nombre_remitente = $this->user->nombre;
                        $documento->cargo_remitente = $this->user->cargo;
                        $documento->mosca_remitente = $this->user->mosca;
                        if ($fucov == 1 && $tipo->id=='13') {
                            $documento->referencia = $memo->referencia;
                        }
                        if ($fucov == 1 && $tipo->id=='14') {
                            $documento->referencia = 'CERT. POA PASAJES y VIATICOS '.$nur;
                        }
                        if ($fucov == 1 && $tipo->id=='15') {
                            $documento->referencia = 'CERT. PRESUPUESTARIA PASAJES y VIATICOS '.$nur;
                        }
                        if ($tipo->id=='16') {
                            $documento->referencia = $referencia;
                            $documento->contenido = $contenidoRH;
                        }
                        $documento->fecha_creacion = date('Y-m-d H:i:s');
                        $documento->nur = $nur;
                        $documento->id_seguimiento = $id_seg;
                        $documento->original = 0; //important !!                
                        $documento->id_proceso = $proceso->id_proceso;
                        $documento->id_oficina = $this->user->id_oficina;
                        $documento->id_entidad = $this->user->id_entidad;
                        $documento->fucov = 0;
                        $documento->save();

                        if ($documento->id && $fucov == 1 && $id_tipo==13) {

                        //Modificado por freddy
                            $entidad = ORM::factory('entidades', $this->user->id_entidad);
                                $pvfucov = ORM::factory('pvfucovs');
                                $pvfucov->id_documento = $documento->id;
                                $pvfucov->origen = $pvcomision->origen;
                                $pvfucov->destino = $pvcomision->destino;
                                $pvfucov->fecha_salida = $pvcomision->fecha_inicio;
                                $pvfucov->fecha_arribo = $pvcomision->fecha_fin;
                                $pvfucov->cancelar = $entidad->sigla;
                                $pvfucov->transporte = 'Aereo';
                                $pvfucov->representacion = 'No';
                                $pvfucov->impuesto = 'No';
                                $pvfucov->id_tipoviaje = 0;
                                $pvfucov->id_programatica = 0;
                                $pvfucov->id_memo = $id_memo;
                                $pvfucov->etapa_proceso = 0;
                                $pvfucov->tipo_cambio = 0;
                                $pvfucov->tipo_moneda = 0;
                                $pvfucov->fecha_creacion = date('Y-m-d H:i:s');
                                $pvfucov->fecha_modificacion = date('Y-m-d H:i:s');
                                $pvfucov->estado = 1;
                                $pvfucov->save();    
                        
                        /////////end////////////
                        //cazamos al documento con el nur asignado
                        $rs = $documento->has('nurs', $nur);
                        $documento->add('nurs', $nur);
                        $_POST = array();
                        
                        }
                        if($documento->id && $id_tipo==14) {
                        //Modificado por freddy
                                $poa = ORM::factory('poas');
                                $poa->id_documento = $documento->id;
                                $poa->fecha_creacion = date('Y-m-d H:i:s');
                                $poa->id_documento = $documento->id;
                                $poa->fecha_modificacion = date('Y-m-d H:i:s');
                                $poa->tipo_actividad = 'FUNCIONAMIENTO';
                                $poa->id_tipocontratacion = 5;
                                $poa->otro_tipocontratacion = 'Pago de Viaticos';
                                $poa->id_memo = $id_memo;
                                $poa->save();
                        /////////end////////////
                        //cazamos al documento con el nur asignado
                        $rs = $documento->has('nurs', $nur);
                        $documento->add('nurs', $nur);
                        $_POST = array();
                        }
                        if($documento->id && $id_tipo==15){///modificado por Rodrigo
                            $pre = ORM::factory('presupuestos');
                            $pre->id_documento = $documento->id;
                            $pre->fecha_creacion = date('Y-m-d H:i:s');
                            $pre->fecha_modificacion = date('Y-m-d H:i:s');
                            $pre->id_memo = $id_memo;
                            $pre->save();
                        /////////end////////////
                        //cazamos al documento con el nur asignado
                        $rs = $documento->has('nurs', $nur);
                        $documento->add('nurs', $nur);
                        $_POST = array();
                        }

                }
                $this->request->redirect('documento/editar/' . $documento->id);

            }
        } else {
            echo 'Error: no se pudo generar el documento';
        }
    } else {
        $this->template->content = View::factory('');
    }
}

public function action_generar_doc() {
    if ($_POST['aceptar']) {
        $nur = Arr::get($_POST, 'nur');
        $id_tipo = Arr::get($_POST, 'documento');
        $tipo = ORM::factory('tipos', $id_tipo);
        $oOficina = New Model_Oficinas();
        $correlativo = $oOficina->correlativo($this->user->id_oficina, $tipo->id);
        $abre = $oOficina->tipo($tipo->id);
        $sigla = $oOficina->sigla($this->user->id_oficina);
        if ($abre != '')
            $abre = $abre . '/';
        $codigo = $abre . $sigla . ' Nº ' . $correlativo . '/' . date('Y');
            //obtenemos el id_proceso del documento original
        $proceso = ORM::factory('documentos')->where('nur', '=', $nur)->and_where('original', '=', 1)->find();
            //generamos el documento
        $documento = ORM::factory('documentos');
        $documento->id_user = $this->user->id;
        $documento->codigo = $codigo;
        $documento->cite_original = $codigo;
        $documento->id_tipo = $id_tipo;
        $documento->fecha_creacion = date('Y-m-d H:i:s');
        $documento->nur = $nur;
        $documento->id_seguimiento = 0;
            $documento->original = 0; //important !!                
            $documento->id_proceso = $proceso->id;
            $documento->id_oficina = $this->user->id_oficina;
            $documento->save();
            if ($documento->id) {
                //cazamos al documento con el nur asignado
                $rs = $documento->has('nurs', $nur);
                $documento->add('nurs', $nur);
                $_POST = array();
                $this->request->redirect('documento/editar/' . $documento->id);
            }
        } else {
            $this->template->content = View::factory('');
        }
    }

    //asignar nur o nuri
    public function action_asignar($id = '') {
        $auth = Auth::instance();
        if ($auth->logged_in()) {
            //propiedades del documento
            $documento = ORM::factory('documentos')
            ->where('id', '=', $id)
            ->and_where('id_user', '=', $this->user->id)
            ->find();
            if ($documento) {
                //si fue enviado por metodo post entonces lo guardamos
                if ($_POST) {
                    //generamos el codigo del correlativo
                    $codigo = $this->nuevo(-1);
                    //asignamos
                    $nuri = ORM::factory('asignados');
                    $nuri->codigo = $codigo;
                    $nuri->id_user = $this->user->id;
                    $nuri->fecha_creacion = date('Y-m-d H:i:s');
                    $nuri->tipo_id = -1;
                    $nuri->save();
                    //actualizamos propiedades del docuemtno

                    $documento->id_nuri = $nuri->id;
                    $documento->nuri = $codigo;
                    $documento->id_proceso = $_POST['proceso'];
                    $documento->save();
                    //enviamos al formulario de derivacion
                    $this->request->redirect(URL::base() . 'derivar/hs/?n=' . $documento->id_nuri);
                }
                $procesos = ORM::factory('procesos')->find_all();
                $arrP = array('' => '');
                foreach ($procesos as $p) {
                    $arrP[$p->id] = $p->proceso;
                }
                $this->template->content = View::factory('nur/create')
                ->bind('procesos', $arrP)
                ->bind('documento', $documento);
            } else {
                $mensaje = 'Usted no puede modificar/asignar documentos de otras personas';
                $this->template->content = View::factory('errors/general')
                ->bind('mensaje', $mensaje);
            }
        } else {
            $this->request->redirect(URL::base() . 'login');
        }
    }

    //correlativo para un NURI -1=nuri / -2 = nur
    public function nuevo($type = -1) {
        $oCorrelativo = ORM::factory('correlativo')
        ->where('id_tipo', '=', $type)
        ->find();
        $oCorrelativo->correlativo = $oCorrelativo->correlativo + 1;
        $oCorrelativo->save();
        $codigo = '000' . $oCorrelativo->correlativo;
        if ($type == -1)
            $tipo = 'I/';
        else
            $tipo = '';
        $codigo = $tipo . date('Y') . '-' . substr($codigo, -4);
        return $codigo;
    }

    //nuris creados por el usuario
    public function action_listar() {
        $auth = Auth::instance();
        if ($auth->logged_in()) {
            $oNuri = New Model_Asignados();
            $count = $oNuri->count($auth->get_user());
            //$count2= $oNuri->count2($auth->get_user());           
            if ($count) {
                // echo $oNuri->count2($auth->get_user());
                $pagination = Pagination::factory(array(
                    'total_items' => $count,
                    'current_page' => array('source' => 'query_string', 'key' => 'page'),
                    'items_per_page' => 40,
                    'view' => 'pagination/floating',
                    ));
                $result = $oNuri->nuris($auth->get_user(), $pagination->offset, $pagination->items_per_page);
                $page_links = $pagination->render();
                $this->template->title = 'Hojas de Seguimiento';
                $this->template->styles = array('media/css/tablas.css' => 'screen');
                $this->template->content = View::factory('nur/listar')
                ->bind('result', $result)
                ->bind('page_links', $page_links);
            } else {
                $this->template->content = View::factory('errors/general');
            }
        } else {
            $this->request->redirect('login');
        }
    }

    //nueva function para derivar
    public function action_derivar() {
        $id = Arr::get($_GET, 'id_doc', 0);
        $documento = ORM::factory('documentos')->where('id', '=', $id)
                //->and_where('original','=',1)
        ->find();

        // Modificado por Freddy
                // Obtenemos el id del via o destinatario
        if($documento->nombre_via!=''){
            $user_id = ORM::factory('users')->where('nombre','=',$documento->nombre_via)->find();
        }else{
            $user_id = ORM::factory('users')->where('nombre','=',$documento->nombre_destinatario)->find();
        }


        $nur = $documento->nur;
        if ($documento->loaded()) {
            $session = Session::instance();
            $session->delete('destino');

            $proceso = ORM::factory('procesos', $documento->id_proceso);
            $errors = array();
            $user = $this->user;
            if ($documento->estado == 0) {
                $acciones = $this->acciones();
                $destinatarios = $this->destinatarios($this->user->id, $this->user->superior);
                $id_seguimiento = 0;
                
                $oficial = 1;
//                $seguimiento = ORM::factory('seguimiento')->where('id','=',$documento->id_seguimiento)->find();
//                if($seguimiento->loaded()){
//                    $oficial=$seguimiento->oficial;
//                }
//                
                $hijo = 0;
                $this->template->title.=' | Derivar';
                $this->template->styles = array('media/css/tablas.css' => 'screen', 'media/css/fcbk.css' => 'screen', 'media/css/modal.css' => 'screen');
                $this->template->scripts = array('media/js/jquery.fcbkcomplete.min.js');
                $this->template->content = View::factory('hojaruta/frm_derivacion')
                ->bind('documento', $documento)
                ->bind('acciones', $acciones)
                ->bind('destinatarios', $destinatarios)
                ->bind('id_seguimiento', $id_seguimientos)
                ->bind('oficial', $oficial)
                ->bind('hijo', $hijo)
                ->bind('proceso', $proceso)
                ->bind('errors', $errors)
                ->bind('user', $user)
                ->bind('user_id', $user_id);
            } else {
                //verificamos que la hora de ruta esta en sus pendientes
                $pendiente = ORM::factory('seguimiento')
                ->where('nur', '=', $nur)
                ->and_where('derivado_a', '=', $this->user->id)
                ->and_where('estado', '=', 2)
                ->find();
                if ($pendiente->loaded()) {

                    $acciones = $this->acciones();
                    $destinatarios = $this->destinatarios($this->user->id, $this->user->superior);
                    $id_seguimiento = $pendiente->id;
                    $oficial = $pendiente->oficial;
                    $hijo = $pendiente->hijo;

                    $this->template->title.=' | Derivar';
                    $this->template->styles = array('media/css/tablas.css' => 'screen', 'media/css/fcbk.css' => 'screen', 'media/css/modal.css' => 'screen');
                    $this->template->scripts = array('media/js/jquery.fcbkcomplete.min.js');
                    $this->template->content = View::factory('hojaruta/frm_derivacion')
                    ->bind('documento', $documento)
                    ->bind('acciones', $acciones)
                    ->bind('destinatarios', $destinatarios)
                    ->bind('id_seguimiento', $id_seguimiento)
                    ->bind('oficial', $oficial)
                    ->bind('hijo', $hijo)
                    ->bind('proceso', $proceso)
                    ->bind('user', $user)
                    ->bind('user_id', $user_id)
                    ->bind('errors', $errors);
                } else {
                    $this->request->redirect('seguimiento/?nur=' . $nur);
                }
            }
        } else {
            $this->template->content = 'Nur inexistente';
        }
    }

    //imprimir
    public function action_imprimir() {
        $this->template->title.=' | imprimir';
        $this->template->content = View::factory('hojaruta/imprimir');
    }

    /*     * */

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
