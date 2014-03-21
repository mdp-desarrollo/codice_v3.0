<?php
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
?>
<input type="hidden" id="id_fucov" value="<?php //echo $pvfucov->id;?>" />
<div style="width: 800px;">
            <div id="comision" style="border-bottom: 1px solid #ccc; background: #FCFCFC; display: block; padding: 10px 0;   width: 100%;">
                <h2 class="subtitulo"><?php echo $documento->codigo; ?> - <b><?php echo $documento->nur; ?></b></h2>
                <table border ="0" width="100%">
                    <tr>
                        <td colspan="3">
                            <?php if(sizeof($pre)>0):?>
                <center><b><h2><br /> EJECUCI&Oacute;N PRESUPUETARIA </h2></b></center>
                <br />
                <table border="0" width="100%">
                    <tr>
                        <td><b>Entidad:</b></td>
                        <td><?php echo $detalle->sigla;?></td>
                        <td><?php echo $detalle->entidad;?></td>
                    </tr>
                    <tr>
                        <td><b>DA:</b></td>
                        <td><?php echo $detalle->codigo_da;?></td>
                        <td><?php echo $detalle->da;?></td>
                    </tr>
                    <tr>
                        <td><b>UE:</b></td>
                        <td><?php echo $detalle->codigo_ue;?></td>
                        <td><?php echo $detalle->ue;?></td>
                    </tr>
                    <tr>
                        <td><b>Cat. Prog.:</b></td>
                        <td><?php echo $detalle->codigo_prog.' &nbsp '.$detalle->codigo_proy.' &nbsp '.$detalle->codigo_act;?></td>
                        <td><?php echo $detalle->actividad;?></td>
                    </tr>
                    <tr>
                        <td><b>Fuente:</b></td>
                        <td><?php echo $detalle->codigo_fte;?></td>
                        <td><?php echo $detalle->fte;?></td>
                    </tr>
                    <tr>
                        <td><b>Organismo:</b></td>
                        <td><?php echo $detalle->codigo_org;?></td>
                        <td><?php echo $detalle->org;?></td>
                    </tr>
                </table>
                <br />
                <h2 class="subtitulo"><span><center>Lista de Partidas de Gastos</center></span></h2>
                <table border="1" class="classy">
                            <thead>
                                <th>Codigo</th>
                                <th>Partida</th>
                                <th>Disponible</th>
                                <th>Solicitado</th>
                                <th>Saldo</th>
                            </thead>
                            <tbody>
                                <?php for($f=0;$f<count($x_partida);$f++):?>
                                <tr>
                                    <td><?php echo $x_codigo[$f]?></td>
                                    <td><?php echo $x_partida[$f]?></td>
                                    <td><?php echo $x_disponible[$f]?></td>
                                    <td><?php echo $x_solicitado[$f]?></td>
                                    <td><?php echo $x_disponible[$f] - $x_solicitado[$f]?></td>
                                </tr>
                                <?php endfor?>
                            </tbody>
                        </table>
                            <?php else:?>
                                <div id="msg3" class="info2">
                                <b>!!!NO HAY ACTIVIDAD POA ASIGNADO.</b>
                                </div>
                                <br />
                            <?php endif;?>
                        </td>
                    </tr>
                </table>
                
            <div class="info" style="text-align:center;margin-top: 20px;">
                <p><span style="float: left; margin-right: .3em;" class=""></span>    
                &larr;<a onclick="javascript:history.back(); return false;" href="#" style="font-weight: bold; text-decoration: underline;  " > Regresar<a/></p>    
            </div>
        </div>
</div>


                