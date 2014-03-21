<?php

require_once('../libs/tcpdf/config/lang/eng.php');
require_once('../libs/tcpdf/tcpdf.php');
require_once('../db/dbclass.php');
$id = $_GET['id'];
// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
    
    //Page header
    public function Header() {
        
        
        
        $id = $_GET['id'];
        $dbh = New db();
        $stmt = $dbh->prepare("SELECT c.logo,c.id FROM documentos AS a INNER JOIN oficinas AS b ON a.id_oficina = b.id
INNER JOIN entidades AS c ON b.id_entidad = c.id WHERE a.id = '$id'");
        $stmt->execute();
        //echo "<B>outputting...</B><BR>";
        $image_file = 'logo.jpg';
        while ($rs2 = $stmt->fetch(PDO::FETCH_OBJ)) {
            if ($rs2->logo) {
                $image_file = '../media/logos/' . $rs2->logo;
            }
            $id_entidad=$rs2->id;
        }
        if($id_entidad<>2 && $id_entidad<>4){
        $this->Image($image_file, 89, 5, 40, 23, 'PNG');
        }
        $this->SetFont('helvetica', 'B', 20);        
    }

    // Page footer
    public function Footer() {
        $id = $_GET['id'];
        $dbh = New db();
        $stmt = $dbh->prepare("SELECT e.pie_1,e.pie_2,e.id FROM documentos d 
                               INNER JOIN tipos t ON d.id_tipo=t.id
                               INNER JOIN oficinas o ON d.id_oficina=o.id
                               INNER JOIN entidades e ON o.id_entidad=e.id
                               WHERE d.id='$id'");
        $stmt->execute();
        while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
            $pie1 = $rs->pie_1;
            $pie2 = $rs->pie_2;
            $id_entidad=$rs->id;
        }
        if($id_entidad<>2){
        // Linea vertical negra
            
        $style = array('width' => 1.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0));
        $this->Line(140, 257, 140, 272, $style);
        // logo quinua
        $this->Image('../media/logos/logo_quinua.jpg', 140, 253, 40, 22, 'JPG');
        // Pie de pagina
        $this->SetFont('helvetica', 'I', 7);
        $this->MultiCell(85, 0, $pie1, 0, 'R', false, 1, 50, 260, true, 0, false, true, 0, 'T', false);
        $this->MultiCell(90, 0, $pie2, 0, 'R', false, 1, 45, 266, true, 0, false, true, 0, 'T', false);
        $this->SetY(30);
        }
    }

}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'LETTER', true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle('DOCUMENTO');
$pdf->SetSubject('TCPDF');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));


// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
//$pdf->SetMargins(20, 33, 20);
//$pdf->SetMargins(20, PDF_MARGIN_TOP, 20);
$pdf->SetMargins(20, PDF_MARGIN_TOP, 15);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray($l);

$pdf->SetFont('Helvetica', 'B', 18);

// add a page
$pdf->AddPage();
$nombre = 'cert_poa';
try {
    $dbh = New db();
    $stmt = $dbh->prepare("SELECT * FROM documentos d 
                               INNER JOIN tipos t ON d.id_tipo=t.id
                               WHERE d.id='$id'");
    $stmt->execute();
    $rs = $stmt->fetch(PDO::FETCH_OBJ);
    $mes = (int) date('m', strtotime($rs->fecha_creacion));
    $meses = array(1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril', 5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto', 9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre');
    $stmt = $dbh->prepare("SELECT * FROM documentos WHERE id=$id");
    $stmt->execute();
    $documento = $stmt->fetch(PDO::FETCH_OBJ);
    
    ///usuario solicitante
    $stmt = $dbh->prepare("SELECT * FROM users WHERE id = $documento->id_user");
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_OBJ);
        
    ///oficina solicitante
    $stmt = $dbh->prepare("SELECT * FROM oficinas WHERE id=$documento->id_oficina");
    $stmt->execute();
    $oficina = $stmt->fetch(PDO::FETCH_OBJ);
    
    ///Unidad Ejecutora
    $stmt = $dbh->prepare("SELECT * FROM oficinas WHERE id=$oficina->id");
    $stmt->execute();
    $oficina2 = $stmt->fetch(PDO::FETCH_OBJ);
    while($oficina2->ppt_unid_ejecutora == NULL || $oficina2->ppt_unid_ejecutora == 0){
        $stmt = $dbh->prepare("SELECT * FROM oficinas WHERE id=$oficina2->padre");
        $stmt->execute();
        $oficina2 = $stmt->fetch(PDO::FETCH_OBJ);
    }
    
   $stmt = $dbh->prepare("select p.*
        ,ot.codigo cod_est, ot.objetivo obj_est, ot.gestion
        ,og.codigo cod_ges, og.objetivo obj_ges, og.gestion
        ,oe.codigo cod_esp, oe.objetivo obj_esp
        ,ac.codigo cod_act, ac.actividad act
        ,t.nombre
        from poas p 
        inner join pvoestrategicos ot on p.id_obj_est = ot.id
				inner join pvogestiones og on p.id_obj_gestion = og.id
        inner join pvoespecificos oe on p.id_obj_esp = oe.id
        inner join pvactividades ac on p.id_actividad = ac.id
        inner join poatipocontrataciones t on p.id_tipocontratacion = t.id
        where p.id_documento = $id");
    $stmt->execute();
    $pvobjetivos = $stmt->fetch(PDO::FETCH_OBJ);
    
///presupuesto
    $stmt = $dbh->prepare("select * from presupuestos where id_memo = $pvobjetivos->id_memo");
    $stmt->execute();
    $pre = $stmt->fetch(PDO::FETCH_OBJ);
    
///verificar FOCOV
    $stmt = $dbh->prepare("select * from documentos where id = $pvobjetivos->id_memo");
    $stmt->execute();
    $memo = $stmt->fetch(PDO::FETCH_OBJ);
    
    if($pvobjetivos){
    ///verificar si esta aprobado
    if($pvobjetivos->auto_poa == 1){
        $stmt = $dbh->prepare("SELECT * FROM users WHERE id = $pvobjetivos->id_user_auto");
        $stmt->execute();
        $userppt = $stmt->fetch(PDO::FETCH_OBJ);
        $autoriza = $userppt->nombre;
        $fecha_aprobado = $pvobjetivos->fecha_aprobacion;
    }else{
        $autoriza = 'Certificacion no aprobada';
        $fecha_aprobado = "";
    }
    //$pdf->Ln(0);
    $pdf->SetFont('Helvetica', 'B', 14);
    $pdf->write(0,'CERTIFICACIÓN POA '.$pvobjetivos->gestion,'',0,'C');
    //$pdf->Cell(5, 6, 'D.N.I.:',0,0,'',$valign='M');
    //$pdf->SetFont('Helvetica', 'B', 9);
    $pdf->Ln();
    $pdf->SetFont('Helvetica', '', 13);
    $pdf->write(0,$rs->nur,'',0,'C');
    //$pdf->SetFont('Helvetica', 'B', 14);
    $tabla1 = "
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <table style=\" width: 156px;\"  border=\"1px\">
            <tr>
                <td style = \" width: 40px;\" colspan = \"3\"><b>N°</b></td>
                <td style = \" width: 116px;\"></td>
            </tr>
        </table>";
    $pdf->writeHTML($tabla1, false, false, false,false,'C');
    $pdf->SetFont('Helvetica', '', 7);
    $color = "#CBCBCB";
    $altura = "18 px";
    $altura2 = "16 px";
    if($pvobjetivos->tipo_actividad == 'INVERSION'){
        $tipo_inv = 'X';
        $tipo_fun = '';
    }
    else{
        $tipo_inv = '';
        $tipo_fun = 'X';
    }
    $tipo_con = array();
    $tipo_con[$pvobjetivos->id_tipocontratacion]='<b>X</b>';
    ///Solicitud, unidad solicitante
    $tabla1 = "
        <table style=\" width: 650px;\" border=\"0px\" frame=\"border\">";
    
    $tabla1 .= "<tr>
                <td style = \" width: 100%;\" colspan = \"3\" height =\"$altura\"></td>
            </tr>
            <tr>
                <td colspan = \"3\">
                    <table border = \"1px\" STYLE=\" width: 99%;\">
                        <tr>
                            <td style=\"width: 80%;\" colspan=\"2\"><b>I. SOLICITUD</b></td>
                            <td style=\"width: 20%;\" > Dependiencia:</td>
                        </tr>                        
                        <tr>
                            <td style=\"width: 25%;\" bgcolor=\"$color\" height =\"$altura\">UNIDAD SOLICITANTE:</td>
                            <td style=\"width: 55%;\">$oficina->oficina</td>
                            <td style=\"width: 20%;\">$oficina2->sigla</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style = \" width: 100%;\" colspan = \"3\">&nbsp;</td>
            </tr>";
    ///PL SECT. - PEI
    $tabla1 .= "
            <tr>
                <td colspan = \"3\">
                    <table border = \"1px\" style=\" width: 99%;\">";
    ///PLAN SECTORIAL
    ///verificar si es pasajes y viaticos
    if($memo->fucov != 1)
    {
        $tabla1 .= "    <tr>
                            <td rowspan=\"3\" bgcolor=\"$color\" style=\" width: 15%;\"><b>PLAN SECTORIAL. POLITICA</b></td>
                            <td bgcolor=\"$color\" style=\" width: 8%;\" height =\"$altura\"></td>
                            <td colspan=\"2\" bgcolor=\"$color\" style=\" width: 26%;\">POLITICA SECTORIAL</td>
                            <td bgcolor=\"$color\" style=\" width: 26%;\">ESTRATEGIA SECTORIAL</td>
                            <td bgcolor=\"$color\" style=\" width: 25%;\">PROGRAMA SECTORIAL</td>
                        </tr>                        
                        <tr>
                            <td bgcolor=\"$color\">CODIGO:</td>
                            <td colspan=\"2\">$pvobjetivos->cod_pol_sec</td>
                            <td>$pvobjetivos->cod_est_sec</td>
                            <td>$pvobjetivos->cod_prog_sec</td>
                        </tr>
                        <tr>
                            <td bgcolor=\"$color\" height =\"$altura\">DESC.<br /> TEXTUAL:</td>
                            <td colspan=\"2\" >$pvobjetivos->des_pol_sec</td>
                            <td>$pvobjetivos->des_est_sec</td>
                            <td>$pvobjetivos->des_prog_sec</td>
                        </tr>";
    }
    /// PEI 
        $tabla1 .= "    <tr>
                            <td bgcolor=\"$color\">PLAN ESTRATEGICO INSTITUCIONAL:</td>
                            <td bgcolor=\"$color\">CODIGO:</td>
                            <td>$pvobjetivos->cod_est</td>
                            <td bgcolor=\"$color\"><br />OBJETIVO ESTRATEGICO:</td>
                            <td colspan=\"2\">$pvobjetivos->obj_est</td>
                        </tr>";
        $tabla1 .= "</table>
                </td>
            </tr>
            <tr>
                <td style = \" width: 100%;\" colspan = \"3\">&nbsp;</td>
            </tr>";
    ///FIN -PEI 

    ///Actividad POA
    $tabla1 .="<tr>
                <!--<td>
                    <table border = \"1px\" style=\" width:580px;\">
                        <tr bgcolor=\"$color\">
                            <td style=\"width: 130px; text align:center\" height =\"$altura\">POA</td>
                            <td style=\"width: 60px;\" >CODIGO</td>
                        </tr>
                        <tr>
                            <td height =\"$altura2\">Objetivo de Gestion</td>
                            <td>$pvobjetivos->cod_ges</td>
                        </tr>
                        <tr>
                            <td height =\"$altura2\">Objetivo Especifico</td>
                            <td>$pvobjetivos->cod_esp</td>
                        </tr>
                    </table>
                </td>-->
                <td colspan =\"3\">
                    <table border = \"1px\" style=\" width:100%;\">
                        <tr bgcolor=\"$color\">
                            <td style=\"width: 10%;\" height =\"$altura\" >CODIGO</td>
                            <td style=\"width: 50%;\">ACTIVIDAD - DESCRIPCION SEGUN POA</td>
                            <td style=\"width: 39%;\">META(Textual)</td>
                        </tr>
                        <tr>
                            <td>$pvobjetivos->cod_act</td>
                            <td>$pvobjetivos->act</td>
                            <td></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style = \" width: 100%;\" colspan = \"3\">&nbsp;</td>
            </tr>";
///Inicio - Presupuesto
$tabla1 .=" <tr>
                <td colspan=\"3\">
                    <table border = \"1px\" style=\" width: 99%;\">
                        <tr bgcolor=\"$color\">
                            <td colspan=\"7\" height =\"$altura\" style=\"width: 80%;\">PRESUPUESTO PARA LA ACTIVIDAD: </td>
                            <td style=\"width: 20%;\" rowspan=\"2\">SALDO DISPONIBLE<br />A LA FECHA Bs.</td>
                        </tr>
                        <tr bgcolor=\"$color\">
                            <td style=\"width: 12%;\" height =\"$altura2\">D.A.</td>
                            <td style=\"width: 12%;\">U.E.</td>
                            <td style=\"width: 12%;\">PROGRAMA</td>
                            <td style=\"width: 12%;\">PROYECTO</td>
                            <td style=\"width: 12%;\">ACTIVIDAD</td>
                            <td style=\"width: 10%;\">FUENTE</td>
                            <td style=\"width: 10%;\">PARTIDA</td>
                        </tr>";
///Lista de Fuentes seleccionadas
    if($pre){
        $stmt = $dbh->prepare("select prog.codigo cod_programa, substring(prog.programa,1,9) programa, proy.codigo cod_proyecto, substring(proy.proyecto,1,9) proyecto, act.codigo cod_actividad, substring(act.actividad,1,15) actividad, fte.codigo cod_fuente, 
            fte.sigla fuente, org.codigo cod_organismo, org.sigla organismo,
            da.sigla da, da.ppt_cod_da cod_da, ue.sigla ue, ue.ppt_cod_ue cod_ue
            from pvprogramaticas p 
            inner join pvprogramas prog on p.id_programa = prog.id
            inner join pvproyectos proy on p.id_proyecto = proy.id
            inner join pvpptactividades act on p.id_actividadppt = act.id
            inner join pvorganismos org on p.id_organismo = org.id
            inner join pvfuentes fte on p.id_fuente = fte.id
            inner join oficinas da on p.id_da = da.id
            inner join oficinas ue on p.id_ue = ue.id
            where p.id = $pre->id_programatica");
        $stmt->execute();
        $detalle_pre = $stmt->fetch(PDO::FETCH_OBJ);///detalle de la estructura programatica
        $stmt = $dbh->prepare("select * from pvliquidaciones where id_presupuesto = $pre->id");
        $stmt->execute();
        $grupo2 = "";
        while ($liq = $stmt->fetch(PDO::FETCH_OBJ)) {///si la ejecucion presupuestaria tiene partidas seleccionadas
            if ($liq->id) {
                $tabla1 .= "<tr>
                            <td>$detalle_pre->cod_da $detalle_pre->da</td>
                            <td>$detalle_pre->cod_ue $detalle_pre->ue</td>
                            <td>$detalle_pre->cod_programa $detalle_pre->programa</td>";
                if($detalle_pre->cod_proyecto != '0000')///en caso de no haber proyecto
                    $tabla1 .="<td>$detalle_pre->cod_proyecto $detalle_pre->proyecto</td>";
                else
                    $tabla1 .="<td></td>";
                $tabla1 .=" <td>$detalle_pre->cod_actividad $detalle_pre->actividad</td>
                            <td>$detalle_pre->cod_fuente $detalle_pre->fuente</td>
                            <td>$liq->cod_partida </td>";
                if($pre->auto_pre == 1)///en caso de que el presupuesto aun no fue autorizado
                    $tabla1 .= "<td>$liq->cs_saldo_devengado</td>";
                else
                    $tabla1 .= "<td>No Aprobado</td>";
                $tabla1 .= "</tr>";
            }
        }
    }
        $tabla1 .= "</table>
                        </td>
                    </tr>
                    <tr>
                        <td style = \" width: 100%;\" colspan = \"3\">&nbsp;</td>
                    </tr>";
///Fin - Presupuesto

//$tabla1 .="";
///TIPO actividad, Tipo Contratacion, Recursos
    $tabla1 .= "
            <tr>
                <td>
                    <table border = \"1px\" style=\" width:190px;\">
                        <tr bgcolor=\"$color\">
                            <td colspan=\"2\" height =\"$altura\">TIPO DE ACTIVIDAD</td>
                        </tr>
                        <tr>
                            <td style=\"width: 130px;\" height =\"$altura2\">INVERSION</td>
                            <td style=\"width: 60px;\"><b>$tipo_inv</b></td>
                        </tr>
                        <tr>
                            <td height =\"$altura2\">FUNCIONAMIENTO</td>
                            <td><b>$tipo_fun</b></td>
                        </tr>
                    </table>
                </td>
                <td rowspan=\"3\" colspan=\"2\">
                    <table border = \"1px\" style=\" width:98.5%;\">
                        <tr bgcolor=\"$color\">
                            <td colspan=\"4\" height =\"$altura\">TIPO DE CONTRATACION</td>
                        </tr>
                        <tr bgcolor=\"$color\">
                            <td height =\"$altura2\" style=\"width: 10%;\">Grupo Gasto</td>
                            <td style=\"width: 18%;\">Descripcion</td>
                            <td style=\"width: 12%;\">Partida</td>
                            <td style=\"width: 60%;\">Descripcion</td>
                        </tr>
                        <tr>
                            <td bgcolor=\"$color\" height =\"$altura2\">10000</td>
                            <td bgcolor=\"$color\">Servicios Personales</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td bgcolor=\"$color\" height =\"$altura2\">20000</td>
                            <td bgcolor=\"$color\">Servicios No Personales</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td bgcolor=\"$color\" height =\"$altura2\">30000</td>
                            <td bgcolor=\"$color\">Materiales y Suministros</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td bgcolor=\"$color\" height =\"$altura2\">40000</td>
                            <td bgcolor=\"$color\">Activos Reales</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td bgcolor=\"$color\" height =\"$altura2\"></td>
                            <td bgcolor=\"$color\">Otros</td>
                            <td colspan=\"2\">$pvobjetivos->otro_tipocontratacion</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>
                    <table border = \"1px\" style=\" width:190px;\">
                        <tr bgcolor=\"$color\">
                            <td height =\"$altura2\"  style=\"width: 40%;\">RECURSO</td>
                            <td style=\"width: 36%;\">ORG. FIN.</td>
                            <td style=\"width: 24%;\">%</td>
                        </tr>
                        <tr>
                            <td height =\"$altura2\">INTERNOS</td>
                            <td>$pvobjetivos->ri_financiador</td>
                            <td>$pvobjetivos->ri_porcentaje</td>
                        </tr>
                        <tr>
                            <td height =\"$altura2\">EXTERNOS</td>
                            <td>$pvobjetivos->re_financiador</td>
                            <td>$pvobjetivos->re_porcentaje</td>
                        </tr>
                    </table>
                </td>                
            </tr>
            <tr>
                <td style = \" width: 100%;\" colspan = \"3\">&nbsp;</td>
            </tr>";
    ///verificar si es pasajes y viaticos
    if($memo->fucov != 1)
    {
        $tabla1 .="<tr>
                            <td colspan = \"3\">
                                <table border = \"1px\" style=\" width:100%;\">
                                    <tr bgcolor=\"$color\">
                                        <td style=\"width: 51%;\"  height =\"$altura\">PROCESO DE CONTRATACION / ADQUISICION:</td>
                                        <td style=\"width: 10%;\">Cantidad</td>
                                        <td style=\"width: 18%;\">Monto Total(Bs)</td>
                                        <td style=\"width: 20%;\">Plazo de ejecucion</td>
                                    </tr>
                                    <tr>
                                        <td>$pvobjetivos->proceso_con</td>
                                        <td>$pvobjetivos->cantidad</td>
                                        <td>$pvobjetivos->monto_total</td>
                                        <td>$pvobjetivos->plazo_ejecucion</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>";
    }
    ///REsponsable SOlicitud
            $tabla1 .="<tr>
                <td style = \" width: 100%;\" colspan = \"3\">Responsable de Solicitud:</td>
            </tr>            
            <tr>
                <td colspan = \"3\">
                    <table border = \"1px\" style=\" width:99%;\">
                        <tr bgcolor=\"$color\">
                            <td style=\"width: 32%;\" height =\"$altura\">NOMBRE</td>
                            <td style=\"width: 35%;\">CARGO</td>
                            <td style=\"width: 20%;\">FIRMA Y SELLO</td>
                            <td style=\"width: 13%;\">FECHA</td>
                        </tr>
                        <tr>
                            <td  height =\"$altura2\"><br /><br />$user->nombre</td>
                            <td><br /><br />$user->cargo</td>
                            <td height =\"40\"></td>
                            <td><br /><br />$documento->fecha_creacion</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style = \" width: 100%;\" colspan = \"3\">&nbsp;</td>
            </tr>";
    $tabla1 .= "</table>";
    $pdf->Ln(-5);
    //$pdf->Cell(169.5,111,'',1,0,'C');
    //$pdf->Ln(1);
    $pdf->writeHTML(utf8_encode($tabla1), false, false, false);
    
    $tabla2 = " &nbsp;&nbsp;
    <table style=\"width: 100%;\"  border=\"1px\" >
            <tr bgcolor = \"$color\">
                <td style = \" width: 100%;\" height =\"$altura\"><b>II. CERTIFICACI&Oacute;N (A ser llenado por la DGP)</b></td>
            </tr>
            <tr>
                <td style = \" width: 100%;\">
                    <center>
                    <table border = \"1px\" style=\" width:99%;\" >
                        <tr>
                            <td>En cumplimiento de los reglamentos Específicos del Sistema de Programación de Operaciones y del Sistema de 
                            Administración de Bienes y servicios del MDPyEP, la Dirección General de Planificación <b>Certifica</b> que la actividad solicitada
                            se encuentra inscrita en el POA $pvobjetivos->gestion del MDPyEP.
                            </td>
                        </tr>
                    </table>
                    </center>
                    
                </td>
            </tr>
            <tr>
                <td style = \" width: 100%;\" bgcolor = \"$color\" height =\"$altura\"><b>Responsable de la certificación</b></td>
            </tr>
            <tr>
                <td><p>
                    <table border = \"1px\" style=\" width:99%;\" >
                        <tr>
                            <td style=\"width: 15%;\" bgcolor = \"$color\">Responsable Verificación POA</td>
                            <td style=\"width: 35%;\"><span style=\"color:#DADADA; text-align:center; font-size: 60%;\"><br /><br /><br /><br /><span style=\"color:#000000; text-align:center; font-size: 120%;\">$autoriza</span><br />FIRMA</span></td>
                            <td style=\"width: 35%;\"><span style=\"color:#DADADA; text-align:center; font-size: 60%;\"><br /><br /><br /><br /><br />SELLO</span></td>
                            <td style=\"width: 15%;\" bgcolor = \"$color\">FECHA $fecha_aprobado</td>
                        </tr>
                        <tr>
                            <td bgcolor = \"$color\">Dirección General de Planificación</td>
                            <td><span style=\"color:#DADADA; text-align:center; font-size: 60%;\"><br /><br /><br /><br /><br />FIRMA</span></td>
                            <td><span style=\"color:#DADADA; text-align:center; font-size: 60%;\"><br /><br /><br /><br /><br />SELLO</span></td>
                            <td><span style=\"text-align:center;\"><br /></span></td>
                        </tr>
                    </table>                
                    </p>
                </td>
            </tr>
    </table>
    ";
    //$pdf->Ln(10);
    //$pdf->Cell(169.5,70,'',1,0,'C');
    //$pdf->Ln(5);
    $pdf->writeHTML($tabla2, false, false, false);
    
    $pdf->SetFont('Helvetica', '', 5);
    $pdf->writeHTML('cc. ' . strtoupper($rs->copias));
    $pdf->writeHTML('Adj. ' . strtoupper($rs->adjuntos));
    }
    else{         
        $pdf->SetFont('Helvetica', '', 10);
        $pdf->writeHTML('ERROR AL GENERAR EL DOCUMENTO.', false, false, false);
    }
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
//Close and output PDF document
$pdf->Output($nombre . '.pdf', 'I');
//============================================================+
// END OF FILE                                                
//============================================================+
