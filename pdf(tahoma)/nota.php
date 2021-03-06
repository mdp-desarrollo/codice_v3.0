<?php

require_once('../libs/tcpdf/config/lang/eng.php');
require_once('../libs/tcpdf/tcpdf.php');
include('../db/dbclass.php');
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
            $this->Image($image_file, 80, 5, 60, 25, 'PNG');
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
            $id_entidad=$rs->id;
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
        /*if($id_entidad<>2 && $id_entidad<>4){
        // Linea vertical negra
            
        $style = array('width' => 1.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0));
        $this->Line(140, 257, 140, 272, $style);
        // logo quinua
        $this->Image('../media/logos/logo_quinua.jpg', 140, 253, 40, 22, 'JPG');
        // Pie de pagina
        $this->SetFont('tahoma', 'I', 7);
        $this->MultiCell(85, 0, $pie1, 0, 'R', false, 1, 50, 260, true, 0, false, true, 0, 'T', false);
        $this->MultiCell(90, 0, $pie2, 0, 'R', false, 1, 45, 266, true, 0, false, true, 0, 'T', false);
        $this->SetY(30);
        }*/
    }

}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'LETTER', true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Ivan Marcelo Chacolla');
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
$sql="SELECT d.id_entidad FROM documentos d WHERE d.id='$id'";
$stmt = $dbh->prepare($sql);
$stmt->execute();
while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
            $id_entidad=$rs->id_entidad;
        } 
$margin_top=33;
if($id_entidad==2){
    $margin_top=33;
}elseif ($id_entidad==4) {
    $margin_top=60;
}

//set margins
$pdf->SetMargins(25, $margin_top, 20);
//$pdf->SetMargins(20, PDF_MARGIN_TOP, 20);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray($l);

$pdf->SetFont('tahoma', 'B', 18);

// add a page
$pdf->AddPage();
$nombre = 'nota';
try {
    $dbh = New db();
    $stmt = $dbh->prepare("SELECT * FROM documentos d 
                               INNER JOIN tipos t ON d.id_tipo=t.id
                               WHERE d.id='$id'");
    // call the stored procedure
    $stmt->execute();
    //echo "<B>outputting...</B><BR>";
    //$pdf->Ln(7);
    while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
        $pdf->SetFont('tahoma', 'B', 16);
        $pdf->Write(0, strtoupper($rs->tipo), '', 0, 'C');
        $pdf->Ln();
        $pdf->SetFont('tahoma', '', 12);
        $pdf->Write(0, strtoupper($rs->codigo), '', 0, 'C');
        $pdf->Ln();
        $pdf->SetFont('tahoma', 'B', 14);
        $pdf->Write(0, strtoupper($rs->nur), '', 0, 'C');
        $pdf->Ln(10);
        $pdf->SetFont('tahoma', 'B', 11);
        $pdf->Cell(15, 5, 'A:');
        //$pdf->SetFont('tahoma', '', 10);
        //$pdf->Write(0, utf8_encode($rs->nombre_destinatario), '', 0, 'L');
        $destinatario = explode(',',$rs->nombre_destinatario);
        $cargo_dest = explode(',',$rs->cargo_destinatario);
        $i = 0;
        $pdf->SetFont('tahoma', '', 11);
        $pdf->Write(0, utf8_encode($rs->titulo), '', 0, 'L');
        $html='<table>';
        foreach( $destinatario as $dest) {
            $html .= '<tr><td>'.ltrim(utf8_encode($dest)).'</td></tr><tr><td><b>'.ltrim(utf8_encode($cargo_dest[$i])).'</b></td></tr>';
            $i++;
        }
        $html .='</html>';
        $pdf->writeHTML($html);
//        $pdf->Ln();
//        $pdf->Cell(15, 5, '');
//        $pdf->SetFont('tahoma', 'B', 10);
//        $pdf->Write(0, utf8_encode($rs->cargo_destinatario), '', 0, 'L');
        //$pdf->Ln(10);
        if (($rs->via != 0) && (trim($rs->nombre_via) != '')) {
//            $pdf->SetFont('tahoma', 'B', 10);
//            $pdf->Cell(15, 5, 'Via:');
//            $pdf->SetFont('tahoma', '', 10);
//            $pdf->Write(0, utf8_encode($rs->nombre_via), '', 0, 'L');
//            $pdf->Ln();
//            $pdf->Cell(15, 5, '');
//            $pdf->SetFont('tahoma', 'B', 10);
//            $pdf->Write(0, utf8_encode($rs->cargo_via), '', 0, 'L');
//            $pdf->Ln(10);
            //$pdf->Ln(10);
        $pdf->SetFont('tahoma', 'B', 11);
        $pdf->Ln(10);
        $pdf->Cell(15, 5, 'Via:');
                $vias = explode(',',$rs->nombre_via);
                $cargo_vias = explode(',',$rs->cargo_via);
                $i = 0;
                $pdf->SetFont('tahoma', '', 11);
                //$pdf->Write(0, utf8_encode($rs->titulo), '', 0, 'L');
                $html='<table border = "0">';
                foreach( $vias as $v) {
                    if( $i != 0)
                        $salto = '<br /><br /><br /><br />';
                    else
                        $salto = '';
                    $html .= '<tr><td>'.$salto.ltrim(utf8_encode($v)).'</td></tr><tr><td><b>'.ltrim(utf8_encode($cargo_vias[$i])).'</b></td></tr>';
                    $i++;
                }
                $html .='</table>';
                $pdf->writeHTML($html);
        }
        $pdf->SetFont('tahoma', 'B', 11);
        $pdf->Ln(5);
        $pdf->Cell(15, 5, 'De:');
        $pdf->SetFont('tahoma', '', 11);
        $pdf->Write(0, utf8_encode($rs->nombre_remitente), '', 0, 'L');
        $pdf->Ln();
        $pdf->Cell(15, 5, '');
        $pdf->SetFont('tahoma', 'B', 11);
        $pdf->Write(0, utf8_encode($rs->cargo_remitente), '', 0, 'L');
        $pdf->Ln(10);
        $pdf->Cell(15, 5, 'Fecha:');
        $pdf->SetFont('tahoma', '', 11);
        $mes = (int) date('m', strtotime($rs->fecha_creacion));
        $meses = array(1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril', 5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto', 9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre');
        $fecha = date('d', strtotime($rs->fecha_creacion)) . ' de ' . $meses[$mes] . ' de ' . date('Y', strtotime($rs->fecha_creacion));
        $pdf->Write(0, $fecha, '', 0, 'L');
        $pdf->Ln(10);
        $pdf->SetFont('tahoma', 'B', 11);
        $pdf->Cell(15, 5, 'Ref.:');
        $pdf->SetFont('tahoma', '', 11);
        $pdf->MultiCell(150, 5, utf8_encode($rs->referencia), 0, 'L');
        $pdf->Ln(-3);
        $pdf->writeHTML('<table></table>');
        $pdf->writeHTML($rs->contenido);
        $pdf->Ln();
        $pdf->SetFont('tahoma', '', 6);
        if($rs->copias != '')
            $pdf->writeHTML('cc. ' . strtoupper(utf8_encode ($rs->copias)));
        if($rs->adjuntos != '')
            $pdf->writeHTML('Adj. ' . strtoupper(utf8_encode ($rs->adjuntos)));
        if($rs->mosca_remitente != '')
            $pdf->writeHTML(strtoupper(utf8_encode ($rs->mosca_remitente)));
        /*   $pdf->SetY(-5);
          // Set font
          $pdf->SetFont('tahoma', 'I', 7);
          $pdf->Write(0, $fecha,'',0,'L');
         * */

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
