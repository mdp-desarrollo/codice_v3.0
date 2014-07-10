<script type="text/javascript">
$(function(){
    $('#replace').click(function(){ 
       $(this).hide();
       $('#file-word').fadeIn();
       $('#archivo').trigger('click');       
   });
    $('#cancelar').click(function(){ 
       $('#replace').show();
       $('#file-word').hide();       
   });
    
});
</script>
<style>
#file-word{ display: none;  }
*{ font-size: 13px; }
</style>

<?php 
$label_destinatario = 'Destinatario';
$label_Remitente = 'Remitente';
$label_referencia = 'Referencia';

if($d->id_tipo==13){
    $label_destinatario = 'Autoriza el Viaje';
    $label_Remitente = 'Funcionario en Comisión';
    $label_referencia = 'Objetivo del Viaje';
}
 ?>

<h2 style="text-align: center;"><?php // echo strtoupper($d->id_tipo);?></h2>
<h2 style="text-align: center; color: #23599B;"><?php echo $d->cite_original;?></h2>
<h2 style="text-align: center;"><?php echo $d->nur;?></h2>
<hr/>
<table border="0">
    <tr>
        <td><b><?php echo $label_destinatario ?>:</b></td>
        <td colspan="2"><?php echo $d->nombre_destinatario;?><br/><b><?php echo $d->cargo_destinatario;?></b></td>
    </tr>
    <?php if(trim($d->nombre_via)!=''){ ?>
    <tr> 
        <td><b>Via:</b><br/> </td>
        <td colspan="2"><?php echo $d->nombre_via;?><br/><b><?php echo $d->cargo_via;?></b></td>
    </tr>
    <?php } ?>
    <tr> 
        <td><b><?php echo $label_Remitente ?>:</b><br/> </td>
        <td colspan="2"><?php echo $d->nombre_remitente;?><br/><b><?php echo $d->cargo_remitente;?></b></td>
    </tr>
    <tr> 
        <td><b>Fecha de Creación:</b><br/> </td>
        <td colspan="2"><?php echo Date::fecha($d->fecha_creacion);?></td>
    </tr>
    <?php
    echo Form::open('documentos/detalle/?id='.$d->id,array('id'=>'frmDerivar','enctype'=>'multipart/form-data'));
    echo Form::hidden('id_doc', $d->id);
    if($archivo->id){ ?>
    <tr> 
        <td><b>Archivo:</b><br/></td>
        <td colspan="2"><?php echo HTML::anchor('/descargar.php?id='.$archivo->id,substr($archivo->nombre_archivo,13));?><br/></td>
    </tr>    
    <?php }    
    echo Form::close();
    ?>
    <tr> <td><b><?php echo $label_referencia ?>:</b><br/> </td>
     <td colspan="2"><?php echo $d->referencia;?></td>
 </tr>

 <tr><td colspan="3"><hr/></td></tr>
 <?php if(trim($d->contenido)!=''){ ?>
 <tr> <td><br/> </td>
    <td colspan="3">
        <div style="overflow:auto; width: 650px; height: 300px;">
            <?php echo $d->contenido;?>
        </div></td>
    </tr>
    <?php } ?>
    
    </table>
<br><br>
<?php if ($pvfucovgeneral->loaded()) { ?>
    <table border="1" cellpadding="2" width='50%'>
        <tr style="text-align:left;background-color: #F4F4F4;">
            <td colspan="2"><b>PARTE I. DECLARATORIA EN COMISION</b></td>
        </tr>
        <tr>
            <td width="35%">NOMBRES Y APELLIDOS DEL SERVIDOR PUBLICO</td>
            <td width="65%"><?php echo $d->nombre_remitente;?></td>
        </tr>
        <tr>
            <td>CARGO</td>
            <td><?php echo $d->cargo_remitente;?></td>
        </tr>
        <tr>
            <td>OBJETIVO DEL VIAJE</td>
            <td><?php echo $d->referencia;?></td>
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
            <td><?php echo $unidad->oficina; ?></td>
        </tr>
        <tr>
            <td>NOMBRE DE QUIEN AUTORIZA EL VIAJE</td>
            <td><?php echo $d->nombre_destinatario;?></td>
        </tr>
        <tr>
            <td>CARGO</td>
            <td><?php echo $d->cargo_destinatario;?></td>
        </tr>
        <tr>
            <td>FECHA DE AUTORIZACION DE VIAJE</td>
            <td><?php echo $fecha_autorizacion; ?></td>
        </tr>
        
        <tr style="text-align:left;background-color: #F4F4F4;">
            <td colspan="2"><b>PARTE III. SOLICITUD DE PASAJES Y VIATICOS</b></td>
        </tr>
    </table>
    <table border="1" cellpadding="2" width='50%'>
    <thead>
        <tr style="text-align:center;background-color: #666666;color: #FFFFFF;">
            <th rowspan="2">Tramo</th>
            <th >Origen</th>
            <th >Fecha<br>Salida</th>
            <th >Viatico</th> 
            <th >% Viatico</th>
            <th >Viatico Parcial</th>
            <th >Nro Boleto</th>
            <th rowspan="2">Ida y Vuelta</th>
        </tr>
        <tr style="text-align:center;background-color: #666666;color: #FFFFFF;">
            <th >Destino</th>
            <th >Fecha<br>Arribo</th>
            <th >Transporte</th> 
            <th >Nro Dias</th>
            <th >Costo Pasaje</th>
            <th >Empresa</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $n=0;
        $desc_iva=0;
        $gasto_rep=0;
        $tp=0;
        $tv=0;
//        foreach ($fte as $f){$fuente[$f->id] = $f->actividad;}

        foreach ($pvfucov as $v) {
            if($n%2==1)
                $color="#E8E8E3";
            else
                $color="#FFFFFF";
            if ($v['cancelar'] == 'Hospedaje y alimentacion' || $v['cancelar'] == 'Hospedaje') {
                $cancelar = "<b>Financiado por:</b> " . $v['financiador'] . "<br> * " . $v['cancelar'];
            } else {
                $cancelar = "* " . $v['cancelar'];
            }
            if ($v['tipo_moneda']==0) {
                $tipo_moneda = 'Bs.';
            } else{
                $tipo_moneda = '$us.';
            }

            $fi = date('Y-m-d', strtotime($v['fecha_salida']));
            $ff = date('Y-m-d', strtotime($v['fecha_arribo']));
            $hi = date('H:i:s', strtotime($v['fecha_salida']));
            $hf = date('H:i:s', strtotime($v['fecha_arribo']));
            $diai = dia_literal(date("w", strtotime($fi)));
            $diaf = dia_literal(date("w", strtotime($ff)));
        ?>
            <tr style="text-align:center;" >
                <td rowspan="2"><?php echo $v['tipoviaje']?></td>
                <td ><?php echo $v['origen']?></td>
                <td ><?php echo $diai . ' ' . $fi; ?></td>
                <td ><?php echo $cancelar ?></td>
                <td ><?php echo $v['porcentaje_viatico'] ?> % </td>
                <td ><?php echo $v['total_viatico']. ' '. $tipo_moneda; ?></td>
                <td ><?php echo $v['nro_boleto'] ?></td>
                <td rowspan="2"><?php echo $v['ida_vuelta1'] ?></td>
            </tr>
            <tr style="text-align:center;" >
                <td ><?php echo $v['destino'] ?></td>
                <td ><?php echo  $diaf . ' ' . $ff; ?></td>
                <td ><?php echo $v['transporte'] ?></td>
                <td ><?php echo $v['nro_dia'] ?></td>
                <td ><?php echo $v['total_pasaje'].'  '.$tipo_moneda; ?> </td>
                <td ><?php echo $v['empresa']; ?></td>
            </tr>

         <?php 
            $desc_iva+=$v['gasto_imp'];
            $gasto_rep+=$v['gasto_representacion'];
            $tipo_cambio=$v['tipo_cambio'];
            $tv+=$v['total_viatico'];
            $tp+=$v['total_pasaje'];
            $n++;
        }
          ?>   
    </tbody>
    </table><br>

    <table border="1" cellpadding="2" width='50%'>
    <tr>
        <td width="14%">CATEGORIA</td>
        <td width="86%"><?php echo $pvcategoria->categoria; ?></td>
    </tr>
</table>
<?php  
$fi = date('Y-m-d', strtotime($pvfucovgeneral->fecha_salida));
$ff = date('Y-m-d', strtotime($pvfucovgeneral->fecha_arribo));
$hi = date('H:i:s', strtotime($pvfucovgeneral->fecha_salida));
$hf = date('H:i:s', strtotime($pvfucovgeneral->fecha_arribo));
$diai = dia_literal(date("w", strtotime($fi)));
$diaf = dia_literal(date("w", strtotime($ff)));
$tv = $tv-$pvfucovgeneral->dua;
?>

<table border="1" cellpadding="2" width='50%'>
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
        <td width="110"><?php echo $pvfucovgeneral->origen ?></td>
        <td width="100" rowspan="2"><?php echo $diai . ' ' . $fi;?></td>
        <td width="100" rowspan="2"><?php echo $diaf . ' ' . $ff;?></td>
        <td width="55" rowspan="2"><?php echo $pvfucovgeneral->nro_dia ?></td>
        <td width="55" rowspan="2"><?php echo  $desc_iva . ' '.$tipo_moneda; ?></td>
        
        <td width="70" rowspan="2"><?php echo $tv.' '.$tipo_moneda; ?></td>
        <td width="70" rowspan="2"><?php echo $gasto_rep . ' '.$tipo_moneda; ?></td>
        <td width="63" rowspan="2"><?php echo $tipo_cambio .' Bs.'; ?> </td>
    </tr>
    <tr style="text-align:center;">
        <td width="110"><?php echo $pvfucovgeneral->destino ?></td>
    </tr>
</tbody>
</table>

<?php 
$lp_bs = $tv+$gasto_rep;
$lp_dolar = 0;
$cont_dolar = '';
if($tipo_moneda=='$us.'){
    $lp_dolar = ($tv+$gasto_rep);
    $cont_dolar = '<br><b>LIQUIDO PAGABLE DOLARES:</b> ' .number_format($lp_dolar,2). ' $us.';
    $lp_bs = $lp_bs*$tipo_cambio;
}
?>
<table border="1" cellpadding="2" width='50%'>
    <tr><td><b>LIQUIDO PAGABLE:</b><?php echo number_format($lp_bs,2). ' Bs. '.$cont_dolar?> </td><td><b>TOTAL PASAJES:</b><?php echo  number_format($tp,2). ' '.$tipo_moneda; ?> </td></tr>
</table>
<?php  if ($pvfucovgeneral->justificacion_finsem  != ''){ ?>
    <table border="1" cellpadding="2" width='50%'>
    <tr>
    <td width="35%">JUSTIFICACION DE VIAJE EN FIN DE SEMANA O FERIADO</td>
    <td width="65%"><?php echo $pvfucovgeneral->justificacion_finsem ?></td>
    </tr>
    </table>
<?php } ?>    
<?php } ?>        
    <?php function dia_literal($n) {
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
    ?>