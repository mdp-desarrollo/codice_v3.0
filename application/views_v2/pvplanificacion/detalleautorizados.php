<?php
    /*$fi = date('Y-m-d', strtotime($pvfucov->fecha_salida));
    $ff = date('Y-m-d', strtotime($pvfucov->fecha_arribo));
    $hi = date('H:i:s', strtotime($pvfucov->fecha_salida));
    $hf = date('H:i:s', strtotime($pvfucov->fecha_arribo));
    $diai = dia_literal(date("w", strtotime($fi)));
    $diaf = dia_literal(date("w", strtotime($ff)));*/
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
//calcular el numero de dias
/*$fecha1 = strtotime($pvfucov->fecha_salida);
$fecha2 = strtotime($pvfucov->fecha_arribo);
$diff =  $fecha2 - $fecha1;
if($diff <0)
    $diff = $diff*-1;
$hora = date('H:i:s', strtotime($pvfucov->fecha_arribo));
if ($diff==0)
    $dias = 1;
else{
    if($hora >'12:00:00')
        $dias = intval((($diff) / (60*60*24))+1);
    else
        $dias = intval((($diff) / (60*60*24))+0);
}
    if($pvfucov->tipo_moneda == '0')
        $moneda = 'Bs.';
    else
        $moneda = '$us.';
*/?>

<input type="hidden" id="id_fucov" value="<?php //echo $pvfucov->id;?>" />
<div style="width: 800px;">
            <div id="comision" style="border-bottom: 1px solid #ccc; background: #FCFCFC; display: block; padding: 10px 0;   width: 100%;">
                <h2 class="subtitulo"><?php echo $documento->codigo; ?> - <b><?php echo $documento->nur; ?></b><br />&nbsp;</h2>
                <br/>
                <h2 style="text-align: center;"><b>CERTIFICACI&Oacute;N POA N° <?php echo $poa->nro_poa?></b></h2>                
                            <?php if(sizeof($poa)>0):?>
                <table width="100%" border="0" cellpadding="10">
                            <tr>
                                <td colspan="2"><hr /></td>
                            </tr>
                            <tr>
                                <td style=" width: 17%"><b>Objetivo de Gesti&oacute;n:</b>&nbsp;&nbsp;&nbsp;</td>
                                <td><?php echo $gestion->codigo?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><?php echo $gestion->objetivo?></td>
                            </tr>
                            <tr>
                                <td><br />&nbsp;<br /></td>
                            </tr>
                            <tr>
                                <td><b>Objetivo Espec&iacute;fico:</b>&nbsp;&nbsp;&nbsp;</td>
                                <td><?php echo $especifico->codigo?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><?php echo $especifico->objetivo?></td>
                            </tr>
                            <tr>
                                <td><br />&nbsp;<br /></td>
                            </tr>
                            <tr>
                                <td><b>Actividad:</b>&nbsp;&nbsp;&nbsp;</td>
                                <td><?php echo $actividad->codigo?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><?php echo $actividad->actividad?></td>
                            </tr>
                            <tr>
                                <td colspan="2"><hr /></td>
                            </tr>
                            <tr>
                                <td><b>Oficina Solicitante:</b></td>
                                <td><?php echo $of_solicita->oficina?></td>
                            </tr>
                            <tr>
                                <td><b>Resp. Solicitud:</b></td>
                                <td><?php echo $documento->nombre_remitente?><br /><b><?php echo $documento->cargo_remitente?></b></td>
                            </tr>
                            <tr>
                                <td colspan="2"><hr /></td>
                            </tr>
                            <tr>
                                <td><b>Tipo Actividad:</b></td>
                                <td><?php echo $poa->tipo_actividad?></td>
                            </tr>
                            <tr>
                                <td><b>Tipo de Contratacion:</b></td>
                                <td><?php echo $tipo_con->nombre.' | '.$poa->otro_tipocontratacion?></td>
                            </tr>
                            <?php if(sizeof($pvfucov)>0):?>
                            <tr>
                                <td colspan="2"><hr /><br /></td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <table class="classy" border="1" style=" width: 45%">
                                        <thead>
                                            <th>RECURSOS</th>
                                            <th>ORG. FINANCIADOR</th>
                                            <th>%</th>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Internos</td>
                                                <td><?php echo $poa->ri_financiador?></td>
                                                <td><?php echo $poa->ri_porcentaje?></td>
                                            </tr>
                                            <tr>
                                                <td>Externos</td>
                                                <td><?php echo $poa->re_financiador?></td>
                                                <td><?php echo $poa->re_porcentaje?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <table class="classy" border="1">
                                        <thead>
                                            <th>PROCESO DE CONTRATACION/ADQUISICION (Descripci&oacute;n espec&iacute;fica.)</th>
                                            <th>CANTIDAD</th>
                                            <th>MONTO TOTAL(BS)</th>
                                            <th>PLAZO DE EJECUCION</th>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><?php echo $poa->proceso_con?></td>
                                                <td><?php echo $poa->cantidad?></td>
                                                <td><?php echo $poa->monto_total?></td>
                                                <td><?php echo $poa->plazo_ejecucion?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <?php endif?>
                </table>
                            <?php else:?>
                                <div id="msg3" class="info2">
                                <b>!!!NO HAY ACTIVIDAD POA ASIGNADO.</b>
                                </div>
                                <br />
                            <?php endif;?>
                    <?php /*?>
                    <tr>
                        <td><b>Autoriza el Viaje:</b></td>
                        <td colspan="2"><?php echo $memo->nombre_remitente;?><br/><b><?php echo $memo->cargo_remitente;?></b></td>
                    </tr>
                    <tr> 
                        <td><b>Funcionario en Comisi&oacute;n:</b><br/> </td>
                        <td colspan="2"><br /><?php echo $memo->nombre_destinatario;?><br/><b><?php echo $memo->cargo_destinatario;?></b></td>
                    </tr>
                    <tr> 
                        <td><b>Fecha de Creación:</b><br/> </td>
                        <td colspan="2"><br /><?php echo Date::fecha($memo->fecha_creacion);?></td>
                    </tr>
                    <tr> 
                        <td><b>Referencia:</b><br/> </td>
                        <td colspan="2"><br /><?php echo $memo->referencia;?></td>
                    </tr>
                    <tr>
                        <td colspan="3"><br /><hr /><br /></td>
                    </tr>
                    <?php */?>
                    <?php /*?>
                    <tr> 
                        <td colspan="3">
                    <center><b><h2>INFORMACION DE LA COMISI&Oacute;N</h2></b></center>
                            <table border="1" width="100%" class="classy" >
                                <thead>
                                    <tr>
                                        <th style="text-align:center;">Orígen</th>
                                        <th style="text-align:center;">Destino</th>
                                        <th style="text-align:center;">Fecha y Hora <br>Salida</th>
                                        <th style="text-align:center;">Fecha y Hora <br>Retorno</th>
                                        <th style="text-align:center;">Transporte</th>
                                        <th style="text-align:center;">Viaticos</th>
                                        <th style="text-align:center;">Desc. IVA</th> 
                                        <th style="text-align:center;">Gastos<br>Repres.</th>

                                    </tr>
                                </thead>
                                <?php
                                if ($pvfucov->cancelar == 'Hospedaje y alimentacion' || $pvfucov->cancelar == 'Hospedaje') {
                                    $cancelar = "<b>Financiado por:</b><br>" . $pvfucov->financiador . "<br><br> * " . $pvfucov->cancelar;
                                } else {
                                    $cancelar = "* " . $pvfucov->cancelar;
                                }

                                $tipo_moneda="Bs.";
                                if($pvfucov->tipo_moneda==1){
                                    $tipo_moneda='$us.';
                                }
                                ?>
                                <tbody>
                                    <tr style="text-align:center">
                                        <td><?php echo $pvfucov->origen ?></td>
                                        <td><?php echo $pvfucov->destino ?></td>
                                        <td><?php echo $diai . ' ' . $fi; ?> <br><?php echo $hi ?></td>
                                        <td><?php echo $diaf . ' ' . $ff; ?> <br><?php echo $hf ?></td>
                                        <td><?php echo $pvfucov->transporte ?></td>
                                        <td><?php echo $cancelar ?></td>
                                        <td><?php echo $pvfucov->impuesto ?></td>
                                        <td><?php echo $pvfucov->representacion ?></td>

                                    </tr>
                                </tbody>

                            </table>
                        </td>
                    </tr>
                    <?php */?>
                </table>
            <div class="info" style="text-align:center;margin-top: 20px;">
                <p><span style="float: left; margin-right: .3em;" class=""></span>    
                &larr;<a onclick="javascript:history.back(); return false;" href="#" style="font-weight: bold; text-decoration: underline;  " > Regresar<a/></p>    
            </div>
        </div>
</div>


                