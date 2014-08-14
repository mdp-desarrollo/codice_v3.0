<?php

require_once('../libs/tcpdf/config/lang/eng.php');
require_once('../libs/tcpdf/tcpdf.php');
require_once('../db/dbclass.php');
$id = $_GET['id'];

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    //Page header
    public function Header() {

        // codigo de freddy
        // dir logos /codice/media/logos/
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
            $id_entidad = $rs2->id;
        }
        if($id_entidad<>2 && $id_entidad<>4 && $id_entidad<>5 && $id_entidad<>6){
            $this->Image($image_file, 70, 5, 80, 30, 'PNG');
            
        }
        if ($id_entidad==5 || $id_entidad==6) {
            $image_file2='../media/logos/logo_MDPyEP.png';
            $this->Image($image_file, 150, 5, 50, 20, 'PNG');
            $this->Image($image_file2, 20, 5, 60, 25, 'PNG');
        }


        $this->SetFont('Helvetica', 'B', 20);
        //$this->Ln(120);
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
            $id_entidad = $rs->id;
        }
        if ($id_entidad <> 2 && $id_entidad <> 4) {

            // Position at 15 mm from bottom
            $this->SetY(-15);
        // Set font
            $this->SetFont('Helvetica', 'I', 7);

            $this->Cell(0, 10, utf8_encode($pie1), 'T', false, 'C', 0, '', 0, false, 'T', 'M');
            $this->Ln(2);
            $this->Cell(0, 15, utf8_encode($pie2), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        }
    }

}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'legal', true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('');
$pdf->SetTitle('DOCUMENTO');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));


// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

$dbh = New db();
$sql = "SELECT d.id_entidad FROM documentos d WHERE d.id='$id'";
$stmt = $dbh->prepare($sql);
$stmt->execute();
while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
    $id_entidad = $rs->id_entidad;
}
$margin_top = 38;
if ($id_entidad == 2) {
    $margin_top = 33;
} elseif ($id_entidad == 4) {
    $margin_top = 60;
}

//set margins
$pdf->SetMargins(20, $margin_top, 20);
//$pdf->SetMargins(20, PDF_MARGIN_TOP, 20);
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
$nombre = 'focov';
try {
    $dbh = New db();
    $stmtp = $dbh->prepare("SELECT d.*,p.*,t.tipo,t.via FROM documentos d, pvfucovgenerales p, tipos t WHERE d.id='$id' AND d.id=p.id_documento AND d.id_tipo=t.id");
    // call the stored procedure
    $stmtp->execute();
    //echo "<B>outputting...</B><BR>";
    //$pdf->Ln(7);
    while ($rs = $stmtp->fetch(PDO::FETCH_OBJ)) {
        ///MEMO
        $stmtp = $dbh->prepare("select d.fecha_creacion, o.oficina from documentos d inner join oficinas o on d.id_oficina = o.id where d.id = $rs->id_memo ");
        $stmtp->execute();
        $memo = $stmtp->fetch(PDO::FETCH_OBJ);
        ///CATEGORIA DE VIAJE
        $stmtp = $dbh->prepare("select * from pvcategorias where id = $rs->id_categoria ");
        $stmtp->execute();
        $cat = $stmtp->fetch(PDO::FETCH_OBJ);
        if($cat)
            $categoria = $cat->categoria;
        else
            $categoria = "<b>NO SELECCIONADO</b>";
        ///TIPO DE VIAJE
        $stmtp = $dbh->prepare("select * from pvtipoviajes where id = $rs->id_tipoviaje ");
        $stmtp->execute();
        $viaje = $stmtp->fetch(PDO::FETCH_OBJ);
        if($viaje)
            $tipoviaje = $viaje->tipoviaje;
        else
            $tipoviaje = '<b>NO SELECCIONADO</b>';
        $pdf->SetFont('Helvetica', 'B', 15);
        $pdf->Write(0, 'FORMULARIO DE COMISION DE VIAJE ('.strtoupper($rs->tipo).')', '', 0, 'C');
        $pdf->Ln();
        $pdf->SetFont('Helvetica', '', 11);
        $pdf->Write(0, strtoupper($rs->codigo), '', 0, 'C');
        $pdf->Ln();
        $pdf->SetFont('Helvetica', 'B', 13);
        $pdf->Write(0, strtoupper($rs->nur), '', 0, 'C');
        $pdf->Ln();
        $pdf->SetFont('Helvetica', 'B', 8);
        //$pdf->Ln();
        $marca = '#DADADA';
        $padding = 2;
        if($rs->id_oficina>0){
            $stmtp = $dbh->prepare("select * from oficinas WHERE id=$rs->id_oficina");
            $stmtp->execute();
            $ofi = $stmtp->fetch(PDO::FETCH_OBJ);
            $unidad=$ofi->oficina;
        }else{
            $unidad = $memo->oficina;
        }


        $contenido='<table border="1" cellpadding="'.$padding.'">
        <tr style="text-align:left;background-color: #F4F4F4;">
            <td colspan="2"><b>PARTE I. DECLARATORIA EN COMISION</b></td>
        </tr>
        <tr>
            <td width="35%">NOMBRES Y APELLIDOS DEL SERVIDOR PUBLICO</td>
            <td width="65%">'.$rs->nombre_remitente.'</td>
        </tr>
        <tr>
            <td>CARGO</td>
            <td>'.$rs->cargo_remitente.'</td>
        </tr>
        <tr>
            <td>OBJETIVO DEL VIAJE</td>
            <td>'.$rs->referencia.'</td>
        </tr>
        <tr>
            <td ><span style="color:#6A6B6A; text-align:center; font-size: 80%;"><br /><br /><br /><br /><br />FIRMA</span></td>
            <td><span style="color:#6A6B6A; text-align:center; font-size: 80%;"><br /><br /><br /><br /><br />NOMBRE Y CARGO DEL COMISIONADO</span></td>
        </tr>
        <tr style="text-align:left;background-color: #F4F4F4;">
            <td colspan="2"><b>PARTE II. IDENTIFICACION DEL AREA QUE AUTORIZA EL VIAJE</b></td>
        </tr>
        <tr>
            <td>DIRECCION/UNIDAD</td>
            <td>'.$unidad.'</td>
        </tr>
        <tr>
            <td>NOMBRE DE QUIEN AUTORIZA EL VIAJE</td>
            <td>'.$rs->nombre_destinatario.'</td>
        </tr>
        <tr>
            <td>CARGO</td>
            <td>'.$rs->cargo_destinatario.'</td>
        </tr>
        
        
        <tr style="text-align:left;background-color: #F4F4F4;">
            <td colspan="2"><b>PARTE III. SOLICITUD DE PASAJES Y VIATICOS</b></td>
        </tr>
    </table>';

    function dia_literal($n) {
        switch ($n) {
            case 1: return 'Lun';
            break;
            case 2: return 'Mar';
            break;
            case 3: return 'Mie';
            break;
            case 4: return 'Jue';
            break;
            case 5: return 'Vie';
            break;
            case 6: return 'Sab';
            break;
            case 0: return 'Dom';
            break;
        }
    }




                        ///////////Reporete de tramos//////////
    $stmtp = $dbh->prepare("select d.*,p.tipoviaje,IF(d.ida_vuelta = '0', 'No', 'Si') as ida_vuelta1 from pvfucovs d, pvtipoviajes p where d.id_documento = $id AND d.id_tipoviaje = p.id ORDER BY d.id ASC");
    $stmtp->execute();

    $contenido .= ' <table border="1" cellpadding="'.$padding.'" width="100%">
    <thead>
        <tr style="text-align:center;background-color: #666666;color: #FFFFFF;">
            <th width="90" rowspan="2">Tramo</th>
            <th width="100">Origen</th>
            <th width="90">Fecha<br>Salida</th>
            <th width="110">Viatico</th> 
            <th width="50">% Viatico</th>
            <th width="70">Viatico Parcial</th>
            <th width="70">Nro Boleto</th>
            <th width="43" rowspan="2">Ida y Vuelta</th>
        </tr>
        <tr style="text-align:center;background-color: #666666;color: #FFFFFF;">
            <th width="100">Destino</th>
            <th width="90">Fecha<br>Arribo</th>
            <th width="110">Transporte</th> 
            <th width="50">Nro Dias</th>
            <th width="70">Costo Pasaje</th>
            <th width="70">Empresa</th>
        </tr>
    </thead>
    <tbody>';
        $n=0;
        $desc_iva=0;
        $gasto_rep=0;
        $tp=0;
        $tv=0;
        
        while ($v = $stmtp->fetch(PDO::FETCH_OBJ)) {
            if($n%2==1)
                $color="#E8E8E3";
            else
                $color="#FFFFFF";
            if ($v->cancelar == 'Hospedaje y alimentacion' || $v->cancelar == 'Hospedaje') {
                $cancelar = "<b>Financiado por:</b> " . $v->financiador . "<br> * " . $v->cancelar;
            } else {
                $cancelar = "* " . $v->cancelar;
            }
            if ($v->tipo_moneda==0) {
                $tipo_moneda = 'Bs.';
            } else{
                $tipo_moneda = '$us.';
            }

            $fi = date('Y-m-d', strtotime($v->fecha_salida));
            $ff = date('Y-m-d', strtotime($v->fecha_arribo));
            $hi = date('H:i:s', strtotime($v->fecha_salida));
            $hf = date('H:i:s', strtotime($v->fecha_arribo));
            $diai = dia_literal(date("w", strtotime($fi)));
            $diaf = dia_literal(date("w", strtotime($ff)));
            $contenido .='
            <tr style="text-align:center;" bgcolor="'.$color.'">
                <td width="90" rowspan="2">'. $v->tipoviaje .'</td>
                <td width="100">' . $v->origen . '</td>
                <td width="90">' . $diai . ' ' . $fi . '</td>
                <td width="110">'.$cancelar.'</td>
                <td width="50">'.$v->porcentaje_viatico.' % </td>
                <td width="70">'.$v->total_viatico.'  '.$tipo_moneda.'</td>
                <th width="70">'.$v->nro_boleto.'</th>
                <td width="43" rowspan="2">'.$v->ida_vuelta1.'</td>
            </tr>
            <tr style="text-align:center;" bgcolor="'.$color.'">
                <td width="100">' . $v->destino . '</td>
                <td width="90">' . $diaf . ' ' . $ff . '</td>
                <td width="110">'.$v->transporte.'</td>
                <td width="50">'.$v->nro_dia.'</td>
                <td width="70">'.$v->total_pasaje.'  '.$tipo_moneda.' </td>
                <td width="70">'.$v->empresa.'</td>
            </tr>';
            $desc_iva+=$v->gasto_imp;
            $gasto_rep+=$v->gasto_representacion;
            $tipo_cambio=$v->tipo_cambio;
            $tv+=$v->total_viatico;
            $tp+=$v->total_pasaje;
            $n++;
        }
        $contenido .=' </tbody>
    </table><br>';    


    $contenido .='<table border="1" cellpadding="'.$padding.'">
    <tr>
        <td width="14%">CATEGORIA</td>
        <td width="86%">'.$categoria.'</td>
    </tr>
</table>';
$fi = date('Y-m-d', strtotime($rs->fecha_salida));
$ff = date('Y-m-d', strtotime($rs->fecha_arribo));
$hi = date('H:i:s', strtotime($rs->fecha_salida));
$hf = date('H:i:s', strtotime($rs->fecha_arribo));
$diai = dia_literal(date("w", strtotime($fi)));
$diaf = dia_literal(date("w", strtotime($ff)));
$tv = $tv-$rs->dua;

$contenido .= ' <table border="1" cellpadding="'.$padding.'" width="100%">
<thead>
    <tr style="text-align:center;background-color: #666666;color: #FFFFFF;">
        <th width="110">Origen</th>
        <th width="100" rowspan="2">Fecha<br>Salida</th>
        <th width="100" rowspan="2">Fecha<br>Retorno</th>
        <th width="55" rowspan="2">Nro Dias</th> 
        <th width="55" rowspan="2">Desc. IVA</th> 
        
        <th width="70" rowspan="2">Total Viatico</th>
        <th width="70" rowspan="2">Gasto<br>Rep.</th>
        <th width="63" rowspan="2">Cambio</th>
    </tr>
    <tr style="text-align:center;background-color: #666666;color: #FFFFFF;">
        <th width="110">Destino</th>
    </tr>
</thead>
<tbody>
    <tr style="text-align:center;">
        <td width="110">' . $rs->origen . '</td>
        <td width="100" rowspan="2">' . $diai . ' ' . $fi . '</td>
        <td width="100" rowspan="2">' . $diaf . ' ' . $ff . '</td>
        <td width="55" rowspan="2">' . $rs->nro_dia . '</td>
        <td width="55" rowspan="2">' . $desc_iva . ' '.$tipo_moneda.'</td>
        
        <td width="70" rowspan="2">'.$tv.' '.$tipo_moneda.'</td>
        <td width="70" rowspan="2">' . $gasto_rep . ' '.$tipo_moneda.'</td>
        <td width="63" rowspan="2">'. $tipo_cambio .' Bs.</td>
    </tr>
    <tr style="text-align:center;">
        <td width="110">' . $rs->destino . '</td>
    </tr>
</tbody>
</table>';
$lp_bs = $tv+$gasto_rep;
$lp_dolar = 0;
$cont_dolar = '';
if($tipo_moneda=='$us.'){
    $lp_dolar = ($tv+$gasto_rep);
    //$tp = $tp;
    $cont_dolar = '<br><b>LIQUIDO PAGABLE DOLARES:</b> ' .number_format($lp_dolar,2). ' $us.';
    $lp_bs = $lp_bs*$tipo_cambio;
}

$contenido.='
<table border="1" cellpadding="'.$padding.'" width="100%">
    <tr><td><b>LIQUIDO PAGABLE:</b> ' .number_format($lp_bs,2). ' Bs. '.$cont_dolar.'</td><td><b>TOTAL PASAJES:</b> ' .number_format($tp,2). ' '.$tipo_moneda.'</td></tr>
</table>
';

// if ($rs->id_tipoviaje>=4) {
//     $lp_bs=($rs->total_viatico + $rs->gasto_representacion)*$rs->tipo_cambio;
//     $lp_dolar=$rs->total_viatico + $rs->gasto_representacion;
// }else{
//     $lp_bs=$rs->total_viatico + $rs->gasto_representacion;
//     $lp_dolar=0;
// }


if ($rs->justificacion_finsem != '')
    $contenido .='<table border="1" cellpadding="'.$padding.'">
<tr>
    <td width="35%">JUSTIFICACION DE VIAJE EN FIN DE SEMANA O FERIADO</td>
    <td width="65%">'.$rs->justificacion_finsem.'</td>
</tr>
</table>';

$contenido.='<table border="1" cellpadding="'.$padding.'">
    <tr>
        <td colspan="2"><b>RESPONSABLE O ENCARGADO DE PASAJES Y VIATICOS</b></td>
    </tr>
    <tr>
            <td ><span style="color:#6A6B6A; text-align:center; font-size: 80%;"><br /><br /><br /><br /><br />SELLO</span></td>
            <td><span style="color:#6A6B6A; text-align:center; font-size: 80%;"><br /><br /><br /><br /><br />FIRMA</span></td>
    </tr>
</table>';


$pdf->SetFont('Helvetica', '', 9);
$pdf->writeHTML(utf8_encode($contenido));

        //$con='<p style="text-align: justify;">Una vez completada la comisión sírvase hacer llegar el informe de descargo dentro de los próximos 8 días hábiles de acuerdo al artículo 25 del reglamento de Pasajes y Viáticos del Ministerio de Desarrollo Productivo y Economía Plural y el Artículo N° 7 del Decreto Supremo 1788.</p>';
$con='<p style="text-align: justify;">Una vez completada la comisión sirvase hacer llegar el informe de descargo dentro los proximos 8 dias hábiles de acuerdo al Art. 28 del reglamento interno de pasajes y viaticos del Ministerio de Desarrollo Productivo y Economía Plural, aprobado mediante Resolución Ministerial MDPYEP/DESPACHO/N° 255.2013 y el Art. N° 7 del Decreto Supremo 1788.</p>';
$contenido2='<table border="0" cellpadding="'.$padding.'">
<tr style="text-align:left;background-color: #F4F4F4;">
    <td colspan="2">'.utf8_decode($con).'</td>
</tr>
</table>';
$pdf->SetFont('Helvetica', '', 9);
$pdf->writeHTML(utf8_encode($contenido2));        

//$pdf->Ln();
$pdf->SetFont('Helvetica', '', 5);
$pdf->Write(0, ' cc.'.strtoupper($rs->copias), '', 0, 'L');
//$pdf->Ln();
$pdf->Write(0,' Adj.'.strtoupper($rs->adjuntos), '', 0, 'L');
//$pdf->Ln();
$pdf->Write(0, ' '.strtoupper($rs->mosca_remitente), '', 0, 'L');
//$pdf->writeHTML('cc. ' . strtoupper($rs->copias));
//$pdf->writeHTML('Adj. ' . strtoupper($rs->adjuntos));
//$pdf->writeHTML(strtoupper($rs->mosca_remitente));
$nombre.='_' . substr($rs->cite_original, -10, 6);
}
    //echo "<BR><B>".date("r")."</B>";
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
//Close and output PDF document
$pdf->Output($nombre . '.pdf', 'I');
//============================================================+
// END OF FILE                                                
//============================================================+
