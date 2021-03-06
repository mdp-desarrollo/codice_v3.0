<?php

require_once('libs/tcpdf/config/lang/eng.php');
require_once('libs/tcpdf/tcpdf.php');
require_once('db/dbclass.php');
// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    //Page header
    public function Header() {
    }
}

$dbh=New db();
$i=0;
/////////////////////////////////////////////////////

  //  $id_segs=array_values($_POST['id_seg']);
//print_r($id_segs);
$sql="SELECT s.nur, s.a_oficina,s.nombre_receptor,cargo_receptor,s.fecha_emision,s.oficial,d.cite_original, d.referencia,s.proveido FROM seguimiento s 
INNER JOIN nurs_documentos n ON s.nur=n.nur
INNER JOIN documentos d ON n.id_documento=d.id
WHERE d.original='1'
AND  s.id IN (";
    foreach ($_POST['id_seg'] as $k=>$v):
        $sql.=$v.", ";
    endforeach;
    $sql=substr($sql,0, -2);
    $sql.=")";
$sql.=" ORDER BY s.fecha_emision ASC";
$stmt = $dbh->prepare($sql);
$stmt->execute();             
$oficial=array(0=>'Copia',1=>'Oficial');
////////////////////////////////////////////////////

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

//set margins
$pdf->SetMargins(10, 10, 5);
//$pdf->SetMargins(20, PDF_MARGIN_TOP, 20);
//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
//set auto page breaks
$pdf->SetAutoPageBreak(FALSE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray($l);

$pdf->SetFont('Helvetica', 'B', 18);

// add a page
$pdf->AddPage();

try {

    while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {   
        $tr=$i/6;
        if(($i/6)==1){
            $pdf->AddPage();
            $i=0;
        }
        $p=($i*42)+10;
        $pdf->SetTextColor(0);
        $pdf->SetFont('Helvetica', 'B', 11);   
        $pdf->SetY($p); 
        $pdf->Cell(45, 15, $rs->nur,'LTR',0,'C');  
        $pdf->ln();
        $pdf->SetFont('Helvetica', '', 8); 
        $fecha=date('d-m-Y H:i:s',  strtotime($rs->fecha_emision));
        $pdf->Cell(45, 10, $fecha,'LR',0,'C');
        $pdf->ln();     
        $pdf->SetFont('Helvetica', '', 8); 
        $pdf->Cell(45, 10, '','LBR',0,'C');
        $pdf->SetXY(55,$p);

    //     $pdf->MultiCell(115, 20, 'Proveido: '. $rs->proveido, 'TBR', 'L', 0, 1, '', '', true, 0, false, false, 20, 'M');
    //     $pdf->SetXY(55,$p+20);
    // //$pdf->MultiCell(115, 15, 'Derivado a: ',1,'L');
    //     $pdf->MultiCell(115, 15, 'Derivado a: ', 'R', 'L', 0, 1, '', '', true, 0, false, false, 15, 'M');

        
    
    $pdf->MultiCell(115, 10, 'Referencia: '. $rs->referencia, 'TBR', 'L', 0, 1, '', '', true, 0, false, false, 11, 'M');
    
    $pdf->SetXY(55,$p+10);
    $pdf->MultiCell(115, 10, 'Proveido: '. $rs->proveido, 'BR', 'L', 0, 1, '', '', true, 0, false, false, 11, 'M');
    $pdf->SetXY(55,$p+20);
    //$pdf->MultiCell(115, 15, 'Derivado a: ',1,'L');
    $pdf->MultiCell(115, 15, 'Derivado a: ', 'R', 'L', 0, 1, '', '', true, 0, false, false, 15, 'M');

        $pdf->SetXY(55,$p+20);
        $pdf->Cell(115, 5, $rs->a_oficina,0,1,'C');  
        $pdf->SetXY(55,$p+25);
        $pdf->SetFont('Helvetica', '', 8); 
        $pdf->Cell(115, 5, $rs->nombre_receptor,0,0,'C');
        $pdf->SetXY(55,$p+30);
        $pdf->SetFont('Helvetica', '', 7); 
        $pdf->Cell(115, 5, $rs->cargo_receptor,'BR',0,'C');
        $pdf->SetXY(170,$p);
        $pdf->Cell(40, 35, '','TBR',0,'C');


        $pdf->SetTextColor(243,249,255);
        $pdf->SetFontSize(18);
        $pdf->SetXY(170,$p);
        $pdf->Cell(40, 35, $oficial[$rs->oficial], 0,FALSE,'C');

        $i++;
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
