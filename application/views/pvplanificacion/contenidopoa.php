<script type="text/javascript">
    $(function(){

        <?php if($documento->fucov==1){ ?>
            $('#grupo1').hide();
            $('#grupo2').hide();
            $('#grupo3').hide();
            $('#grupo4').hide();
            $('#grupo5').hide();
            $('#grupo6').hide();
            $('#grupo7').hide();
        <?php } ?>

        $('#obj_est').change(function(){
            var id = $('#obj_est').val();
            var id_oficina = $('#id_oficina').val();
            
            $('#det_obj_est').val('');

            $('#obj_gestion').html('');
            $('#det_obj_gestion').val('');
            $('#obj_esp').html('');
            $('#det_obj_esp').val('');
            $('#actividad').html('');
            $('#det_act').val('');

            var act = 'detobjestrategico';///detalle del Objetivo estrategico
            var ctr = $('#det_obj_est');
            ajaxs(id, act, ctr,0,1);
            act = 'objgestion';
            ctr = $('#obj_gestion');
            ajaxs(id, act, ctr,id_oficina,0);
        });

        $('#obj_gestion').change(function(){
            var id = $('#obj_gestion').val();
            $('#det_obj_gestion').val('');
            $('#obj_esp').html('');
            $('#det_obj_esp').val('');
            $('#actividad').html('');
            $('#det_act').val('');
            var act = 'detobjgestion';///detalle del Objetivo de Gestion 
            var ctr = $('#det_obj_gestion');
            ajaxs(id, act, ctr,0,1);
            act = 'objespecifico';
            ctr = $('#obj_esp');
            ajaxs(id, act, ctr,0,0);
        });
        $('#obj_esp').change(function(){
            var id = $('#obj_esp').val();
            $('#det_obj_esp').val('');
            $('#actividad').html('');
            $('#det_act').val('');
            var act = 'detobjespecifico';///detalle del Objetivo Especifico 
            var ctr = $('#det_obj_esp');
            ajaxs(id, act, ctr,0,1);
            act = 'actividad';///actividades 
            ctr = $('#actividad');
            ajaxs(id, act, ctr,0,0);
            
        });
        $('#actividad').change(function(){
            var id = $('#actividad').val();
            $('#det_act').val('');
            var act = 'detactividad';///detalle del Objetivo Especifico 
            var ctr = $('#det_act');
            ajaxs(id, act, ctr,0,1);
            
        });
        
function ajaxs(id, accion, control,id_oficina,sel)
{        
    $.ajax({
        type: "POST",
        data: { id: id, id_oficina: id_oficina},
        url: "/pvajax/"+accion,
        dataType: "json",
        success: function(item)
        {
            if (sel==1) {
                $(control).val(item);
            }else{
                $(control).html(item);    
            }
            
        },
        error: $(control).html('')
    });
}

        // Modificado por Freddy Velasco
        var valor = $('#id_tipocontratacion option:selected').html();
        if(valor ==' - Otros'){
            $('#id_label_otro_tc').show();
            $('#id_otro_tipocontracion').show();
            $('#otro_tipocontratacion').attr('class','required');
        }else{
            $('#id_label_otro_tc').hide();
            $('#id_otro_tipocontracion').hide();
            $('#otro_tipocontratacion').removeAttr('class');
        }

        $('#id_tipocontratacion').change(function(){
           var valor = $('#id_tipocontratacion option:selected').html();
           if(valor ==' - Otros'){
            $('#id_label_otro_tc').show();
            $('#id_otro_tipocontracion').show();
            $('#otro_tipocontratacion').attr('class','required');
        }else{
            $('#id_label_otro_tc').hide();
            $('#id_otro_tipocontracion').hide();
            $('#otro_tipocontratacion').removeAttr('class');
        }
    });
//////////end////////////// 

$('#frmEditarpoa').validate();
$('.autorizar').live('click', function() {
    var answer = confirm("Esta seguro de Aprobar Certificacion POA? ")
    if (answer)
        return true;
    return false;
});
});
</script>
<?php 
?>
<div class="formulario" style="padding: 20px 0;">        
    <div style="border-bottom: 1px solid #ccc; background: #F2F7FC; display: block; padding: 0px 0;   width: 100%;  ">
        <h2 style="text-align:center;">Certificaci&oacute;n POA </h2><hr/><hr />
        <form action="/pvplanificacion/modificarpoa/<?php echo $poa->id; ?>" method="post" id="frmEditarpoa" >
            <fieldset>
                <table width="100%" border="0px">
                    <tr>
                        <td><?php echo Form::label('unidad_ejecutora', 'Unidad Ejecutora POA:', array('class' => 'form')); ?></td>
                        <td colspan="2"><?php echo $ue_poa->oficina ?></td>
                        <td>Nro.: <?php echo Form::input('nro_poa',$poa->nro_poa); ?></td>
                    </tr>
                    <tr id='grupo1'>
                        <td colspan="4">
                           <div><b><?php echo Form::label('label_plansectorial', 'PLAN SECTORIAL - POLITICA', array('id' => 'label_plansectorial', 'class' => 'form')); ?> </b></div>   
                           <table class="classy" border="1">
                            <thead>
                                <tr>
                                    <th><?php echo Form::hidden('id_oficina', $id_oficina,array('id'=>'id_oficina')); ?>
                                    </th>
                                    <th style="text-align:center;">Politica Sectorial</th>
                                    <th style="text-align:center;">Estrategia Sectorial</th>
                                    <th style="text-align:center;">Programa Sectorial</th>
                                </tr>
                            </thead>
                            <TBODY>
                                <tr> 
                                    <th>CODIGO</th>
                                    <td><?php echo Form::input('cod_pol_sec',$poa->cod_pol_sec,array('id'=>'cod_pol_sec')) ?></td>
                                    <td><?php echo Form::input('cod_est_sec',$poa->cod_est_sec,array('id'=>'cod_est_sec')) ?></td>
                                    <td><?php echo Form::input('cod_prog_sec',$poa->cod_prog_sec,array('id'=>'cod_prog_sec')) ?></td>
                                </tr>
                                <tr>
                                    <th>DESC.</th>
                                    <td><textarea name="des_pol_sec" id="des_pol_sec" style="width: 190px"><?php echo $poa->des_pol_sec; ?></textarea></td>
                                    <td><textarea name="des_est_sec" id="des_est_sec" style="width: 190px"><?php echo $poa->des_est_sec; ?></textarea></td>
                                    <td><textarea name="des_prog_sec" id="des_prog_sec" style="width: 190px"><?php echo $poa->des_prog_sec; ?></textarea></td>
                                </tr>
                            </TBODY>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td><?php echo Form::label('obj_est', 'C&oacute;digo Objetivo de Estrategico:', array('class' => 'form')); ?></td>
                    <td colspan="3"><br>
                    <?php // echo Form::select('obj_est', $obj_est, $poa->id_obj_est, array('class' => 'form', 'name' => 'obj_est', 'id' => 'obj_est', 'class' => 'required')); ?>
                    <?php echo Form::input('obj_est', $poa->id_obj_est, array('class' => 'form', 'name' => 'obj_est', 'class'=>'required')); ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo Form::label('detalle_obj_est', 'Detalle Objetivo Estrategico:', array('class' => 'form')); ?></td>
                    <td colspan="3"><br><textarea name="det_obj_est" id="det_obj_est" style="width: 600px;" class="required" ><?php echo $poa->obj_est; ?></textarea></td>
                </tr>
                <tr>
                    <td><?php echo Form::label('obj_gestion', 'C&oacute;digo Objetivo de Gesti&oacute;n:', array('class' => 'form')); ?></td>
                    <td colspan="3">
                    <?php // echo Form::select('obj_gestion', $obj_gestion, $poa->id_obj_gestion, array('class' => 'form', 'name' => 'obj_gestion', 'id' => 'obj_gestion', 'class' => 'required')); ?>
                    <?php echo Form::input('obj_gestion', $poa->id_obj_gestion, array('class' => 'form', 'name' => 'obj_gestion', 'class'=>'required')); ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo Form::label('detalle_obj_gestion', 'Detalle Objetivo de Gesti&oacute;n:', array('class' => 'form')); ?></td>
                    <td colspan="3"><br />
                        <textarea name="det_obj_gestion" id="det_obj_gestion" style="width: 600px;"  rows="2" class="required"><?php echo $poa->obj_gestion; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td><?php echo Form::label('obj_esp', 'C&oacute;digo Objetivo Espec&iacute;fico:', array('class' => 'form')); ?></td>
                    <td colspan="3">
                    <?php // echo Form::select('obj_esp', $obj_esp, $poa->id_obj_esp, array('class' => 'form', 'class' => 'required', 'id' => 'obj_esp', 'name' => 'obj_esp')); ?>
                    <?php echo Form::input('obj_esp', $poa->id_obj_esp, array('class' => 'form', 'name' => 'obj_esp', 'class'=>'required')); ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo Form::label('det_obj_esp', 'Detalle Objetivo Espec&iacutefico:', array('class' => 'form')); ?></td>
                    <td colspan="3"><textarea name="det_obj_esp" id="det_obj_esp" style="width: 600px;"  rows="2" class="required"><?php echo $poa->obj_esp; ?></textarea></td>
                </tr>
                <tr>
                    <td><b><?php echo Form::label('actividad', 'C&oacute;digo Actividad', array('class' => 'form')); ?></b></td>
                    <td colspan="3">
                    <?php // echo Form::select('actividad', $actividad, $poa->id_actividad, array('class' => 'form', 'class' => 'required', 'id' => 'actividad', 'name' => 'actividad')); ?>
                    <?php echo Form::input('actividad', $poa->id_actividad, array('class' => 'form', 'name' => 'actividad', 'class'=>'required')); ?>
                    </td>
                </tr>
                <tr>
                    <td><b><?php echo Form::label('det_act', 'Detalle:', array('class' => 'form')); ?></b></td>
                    <td colspan="3"><br />
                        <textarea name="det_act" id="det_act" style="width: 600px;"  rows="2" class="required"><?php echo $poa->actividad; ?></textarea>
                    </td>
                </tr>
                <tr id="grupo2">
                    <td colspan="4"><hr /><br /></td>
                </tr>
                <tr id="grupo3">
                    <td><b><?php echo Form::label('id_tipocontratacion', 'Tipo de Contratacion:', array('class' => 'form')); ?></b></td>
                    <td><?php echo Form::select('id_tipocontratacion', $tipocontratacion, $poa->id_tipocontratacion, array('class' => 'form', 'class' => 'required', 'id' => 'id_tipocontratacion', 'name' => 'id_tipocontratacion')); ?></td>
                    <td id="id_label_otro_tc"><b><?php echo Form::label('otro_tipocontratacion', 'Otro:', array('class' => 'form')); ?></b></td>
                    <td id="id_otro_tipocontracion"><?php echo Form::input('otro_tipocontratacion',$poa->otro_tipocontratacion,array('class'=>'form','id'=>'otro_tipocontratacion')); ?></td>
                </tr>
                <tr id="grupo4">
                    <td colspan="4"><hr /><br /></td>
                </tr>
                <tr id="grupo5">
                    <td colspan="4" align="center">
                        <table>
                            <tr>
                                <td>
                                    <table class="classy" border="1">
                                        <thead>
                                            <tr>
                                                <th style="text-align:center;" colspan="2">TIPO DE ACTIVIDAD</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>INVERSION</td>
                                                <td><input type="radio" name="tipo_actividad" value="INVERSION" <?php if($poa->tipo_actividad == "INVERSION") { echo 'checked';} ?> ></td>

                                            </tr>
                                            <tr>
                                                <td>FUNCIONAMIENTO</td>
                                                <td><input type="radio" name="tipo_actividad" value="FUNCIONAMIENTO" <?php if($poa->tipo_actividad == "FUNCIONAMIENTO") { echo 'checked';} ?>></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                <td>
                                    <table class="classy" border="1">
                                        <thead>
                                            <tr>
                                                <th style="text-align:center;">RECURSOS</th>
                                                <th style="text-align:center;">Organismo Financiador</th>
                                                <th style="text-align:center;">%</th>
                                            </tr>
                                        </thead>
                                        <TBODY>
                                            <tr>  
                                                <td>Internos</td>
                                                <td><?php echo Form::input('ri_financiador',$poa->ri_financiador,array('id'=>'ri_financiador')); ?></td>
                                                <td><?php echo Form::input('ri_porcentaje',$poa->ri_porcentaje,array('id' => 'ri_porcentaje','size'=>'6','class'=>'number','max'=>100, 'min'=>0)); ?> %</td>
                                            </tr>
                                            <tr>
                                                <td>Externos</td>
                                                <td><?php echo Form::input('re_financiador',$poa->re_financiador,array('id'=>'re_financiador')); ?></td>
                                                <td><?php echo Form::input('re_porcentaje',$poa->re_porcentaje,array('id' => 're_porcentaje','size'=>'6','class'=>'number','max'=>100, 'min'=>0)); ?> %</td>
                                            </tr>
                                        </TBODY>
                                    </table>
                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>
                <tr id="grupo6">
                    <td colspan="4"><hr /><br /></td>
                </tr>
                <tr id="grupo7">
                    <td colspan="4">
                        <table>
                            <tr>
                                <td>
                                    <table class="classy" border="1">
                                        <thead>
                                            <tr>
                                                <th style="text-align:center;">PROCESO DE CONTRATACI&Oacute;N / ADQUISICI&Oacute;N (descripci&oacute;n especifica)</th>
                                                <th style="text-align:center;">Cantidad</th>
                                                <th style="text-align:center;">Monto Total (Bs)</th>
                                                <th style="text-align:center;">Plazo de Ejecuci&oacute;n</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><textarea name="referencia" id="referencia" style="width: 380px;" ><?php echo $poa->proceso_con; ?></textarea></td>
                                                <td><?php echo Form::input('cantidad',$poa->cantidad,array('id'=>'cantidad','size'=>'4','class'=>'number')); ?></td>
                                                <td><?php echo Form::input('monto_total',$poa->monto_total,array('id'=>'monto_total','size'=>'8','class'=>'number')); ?></td>
                                                <td><?php echo Form::input('plazo_ejecucion',$poa->plazo_ejecucion,array('id'=>'plazo_ejecucion','size'=>'15')); ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>
            </table>
        </fieldset>
        <div style="text-align: center;"> <input type="submit" name="documento" value="Modificar documento" class="uibutton" /></div>
    </form>
</div>
<center>
    <a href="/pdf/poa.php?id=<?php echo $poa->id_documento;?>" class="link pdf" target="_blank" title="Imprimir Certificacion POA">Imprimir POA</a>
    <?php if($poa->auto_poa == 0):?>
        <a href="/pvplanificacion/aprobarpoa/<?php echo $poa->id; ?>" class="autorizar" title="Aprobar POA" ><img src="/media/images/tick.png"/>Aprobar POA</a>
    <?php endif;?>
    <?php if($poa->auto_poa == 1):?>
        <a href="/hojaruta/derivar/?id_doc=<?php echo $poa->id_documento; ?>" class="link derivar" title="Derivar a partir del documento, si ya esta derivado muestra el seguimiento" >Derivar</a>
    <?php endif;?>
    <br />
</center>
</div>