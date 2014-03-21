
<script type="text/javascript">  

$(function(){
    $("#frmCreate").validate();


    var config={
        toolbar : [ ['Maximize','Preview','SelectAll','Cut', 'Copy','Paste', 'Pagebreak','PasteFromWord','PasteText','-','Bold','Italic','Underline','FontSize','Font','TextColor','BGColor',,'NumberedList','BulletedList'],
        ['Undo','Redo','-','SpellChecker','Scayt','-','Find','Replace','-','Table','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock']],
        language: 'es'
    }
    
//incluir destinatario
$('a.destino').click(function(){
    var nombre=$(this).attr('nombre');   
    var cargo=$(this).attr('cargo');   
    var via=$(this).attr('via');   
    var cargo_via=$(this).attr('cargo_via');
    
    $('#destinatario').val(nombre);
    $('#cargo_des').val(cargo);
    if(via==undefined)
        $('#via').val("");
    else $('#via').val(via);
    if(cargo_via==undefined)
        $('#cargovia').val("");
    else $('#cargovia').val(cargo_via);
    $('#referencia').focus();
    return false;
});

///Modificado Freddy Velasco
$('#obj_gestion').change(function(){
    var id = $('#obj_gestion').val();
    $('#det_obj_gestion').html('');
    $('#obj_esp').html('');
    $('#det_obj_esp').html('');
    $('#actividad').html('');
    $('#det_act').html('');
            var act = 'detobjgestion';///detalle del Objetivo de Gestion 
            var ctr = $('#det_obj_gestion');
            ajaxs(id, act, ctr);
            act = 'objespecifico';
            ctr = $('#obj_esp');
            ajaxs(id, act, ctr);
        });
$('#obj_esp').change(function(){
    var id = $('#obj_esp').val();
    $('#det_obj_esp').html('');
    $('#actividad').html('');
    $('#det_act').html('');
            var act = 'detobjespecifico';///detalle del Objetivo Especifico 
            var ctr = $('#det_obj_esp');
            ajaxs(id, act, ctr);
            act = 'actividad';///actividades 
            ctr = $('#actividad');
            ajaxs(id, act, ctr);
        });
$('#actividad').change(function(){
    var id = $('#actividad').val();
    $('#det_act').html('');
            var act = 'detactividad';///detalle del Objetivo Especifico 
            var ctr = $('#det_act');
            ajaxs(id, act, ctr);
            
        });

function ajaxs(id, accion, control)
{        
    $.ajax({
        type: "POST",
        data: { id: id},
        url: "/pvajax/"+accion,
        dataType: "json",
        success: function(item)
        {
            $(control).html(item);
        },
        error: $(control).html('')
    });
}

        ///Fin

        $('#btnword').click(function(){
            $('#word').val(1);
            return true

        });
        $('#crear').click(function(){
            $('#word').val(0);
            return true
        });

// Modificado por Freddy Velasco
$('#label_contenido').hide();
$('#contenido2').hide();

$('#id_label_otro_tc').hide();
$('#id_otro_tipocontracion').hide();

$('#id_tipocontratacion').change(function(){
     var valor = $('#id_tipocontratacion option:selected').html();
     if(valor =='Otros'){
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

$("#asignar_nur").fcbkcomplete({
    json_url: "/ajax/documentos_nur",
    addontab: true,                   
    maxitems: 1,
    height: 5,
    cache: true
});

});
</script>
<h2 class="subtitulo">Crear <?php echo $documento->tipo;?> <br/><span>LLENE CORRECTAMENTE LOS DATOS EN EL FORMULARIO</span></h2>
<div class="formulario">
    <form action="/documento/crear/<?php echo $documento->action;?>" method="post" id="frmCreate">
        <br/>
        <fieldset>
            <legend>Proceso: <?php echo Form::select('proceso', $options, NULL);?>
            </legend>
            <hr/>
            ASIGNAR HOJA DE RUTA: <select id="asignar_nur" name="asignar_nur" >                                    
        </select>
        <table width="100%">
            <tr>
                <td style=" border-right:1px dashed #ccc; padding-left: 5px;">
                    <input type="hidden" name="titulo" />
                    <input type="hidden" name="descripcion">
                    <p>
                        <?php
                        echo Form::label('destinatario', 'Nombre del destinatario:',array('class'=>'form'));
                        echo Form::input('destinatario','',array('id'=>'destinatario','size'=>40,'class'=>'required'));
                        ?>
                    </p>
                    <p>
                        <?php
                        echo Form::label('destinatario', 'Cargo Destinatario:',array('class'=>'form'));
                        echo Form::input('cargo_des','',array('id'=>'cargo_des','size'=>40,'class'=>'required'));
                        ?>
                    </p>   
                    <?php if($tipo->via==0):?>
                    <p>
                        <label>Institución Destinatario</label>
                        <input type="text" size="40" name="institucion_des" />    
                        <input type="hidden" name="via" />   
                        <input type="hidden" name="cargovia" />   
                    </p>
                <?php else:?>
                <input type="hidden" size="40" name="institucion_des" />   
                <?php
                echo Form::label('via', 'Via:',array('class'=>'form'));
                echo Form::input('via','',array('id'=>'via','size'=>40));
                ?>
                <?php
                echo Form::label('cargovia', 'Cargo Via:',array('class'=>'form'));
                echo Form::input('cargovia','',array('id'=>'cargovia','size'=>40));
                ?>
            <?php endif;?>
        </p>
    </td>
    <td style=" border-right:1px dashed #ccc; padding-left: 5px;">
        <p>
            <?php
            echo Form::label('remitente', 'Responsable de Solicitud:',array('class'=>'form'));
            echo Form::input('remitente',$user->nombre,array('id'=>'remitente','size'=>35,'class'=>'required'));            
            ?>            
            <?php
   //echo Form::label('mosca','Mosca:');
            echo Form::input('mosca',$user->mosca,array('id'=>'mosca','size'=>5));
            ?>
            <?php
            echo Form::label('cargo', 'Cargo:',array('class'=>'form'));
            echo Form::input('cargo_rem',$user->cargo,array('id'=>'cargo_rem','size'=>40,'class'=>'required'));
            ?>
            <?php
            echo Form::label('adjuntos', 'Adjunto:',array('class'=>'form'));
            echo Form::input('adjuntos','',array('id'=>'adjuntos','size'=>40,'title'=>'Ejemplo: Lo citado'));
            ?>
            <?php
            echo Form::label('copias', 'Con copia a:',array('class'=>'form'));
            echo Form::input('copias','',array('id'=>'adjuntos','size'=>40));
            ?>
        </p>
    </td>
    <?php if($documento->via>-10){ ?>
    <td style="padding-left: 5px;">
        <?php  echo Form::label('dest','Mis destinatarios:');?>
        <div id="vias">
            <ul>
                <!-- Destinatario -->    
                <?php foreach($destinatarios  as $v): ?>
                <li class="<?php echo $v['genero']?>"><?php echo HTML::anchor('#',$v['nombre'],array('class'=>'destino','nombre'=>$v['nombre'],'title'=>$v['cargo'],'cargo'=>$v['cargo'],'via'=>$v['via'],'cargo_via'=>$v['cargo_via']));?></li>
            <?php endforeach; ?>
        </ul>
    </div>
</td>
<?php 
}
?>
</tr>

<tr>
    <td colspan="3"><hr /><br/></td>
</tr>
<tr>
    <td colspan="3">
        <table>
            <tr>
                <td><b><?php echo Form::label('obj_gestion', 'Objetivo de Gesti&oacute;n:', array('class' => 'form')); ?></b></td>
                <td><?php echo Form::select('obj_gestion', $obj_gestion, '', array('class' => 'form', 'name' => 'obj_gestion', 'id' => 'obj_gestion', 'class' => 'required')); ?></td>
            </tr>
            <tr>
                <td><b><?php echo Form::label('detalle_obj_gestion', 'Detalle:', array('class' => 'form')); ?></b>    </td>
                <td><br><textarea name="det_obj_gestion" id="det_obj_gestion" style="width: 600px;" readonly ></textarea></td>
            </tr>
            <tr>
                <td><b><?php echo Form::label('obj_esp', 'Objetivo Espec&iacute;fico:', array('class' => 'form')); ?></b></td>
                <td><?php echo Form::select('obj_esp', $obj_esp,'', array('class' => 'form', 'class' => 'required', 'id' => 'obj_esp', 'name' => 'obj_esp')); ?></td>
            </tr>
            <tr>
                <td><b><?php echo Form::label('det_obj_esp', 'Detalle:', array('class' => 'form')); ?></b></td>
                <td><br /><textarea name="det_obj_esp" id="det_obj_esp" style="width: 600px;" readonly ></textarea></td>
            </tr>
            <tr>
                <td><b><?php echo Form::label('actividad', 'Actividad', array('class' => 'form')); ?></b></td>
                <td><?php echo Form::select('actividad', $actividad, '', array('class' => 'form', 'class' => 'required', 'id' => 'actividad', 'name' => 'actividad')); ?></td>
            </tr>
            <tr>
                <td><b><?php echo Form::label('det_act', 'Detalle:', array('class' => 'form')); ?></b></td>
                <td><br><textarea name="det_act" id="det_act" style="width: 600px;" readonly ></textarea></td>
            </tr>

        </table>
    </td>
</tr>
<tr>
    <td colspan="3"><hr /><br /></td>
</tr>
<tr>
    <td colspan="3">
        <table>
            <tr>
                <td><b><?php echo Form::label('tipo_contratacion', 'Tipo de Contrataci&oacute;n:', array('class' => 'form')); ?></b></td>
                <td><?php echo Form::select('id_tipocontratacion', $tipocontratacion, '', array('class' => 'form', 'name' => 'id_tipocontratacion', 'id' => 'id_tipocontratacion', 'class' => 'required')); ?><br></td>
                <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td id="id_label_otro_tc"><b><?php echo Form::label('otro_tc', 'Otro:', array('class' => 'form')); ?></b></td>
                <td id="id_otro_tipocontracion"><?php echo Form::input('otro_tipocontratacion','',array('id'=>'otro_tipocontratacion')); ?><br></td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td colspan="3"><hr /><br /></td>
</tr>
<tr>
    <br>
    <td colspan="3">
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
                                <td><input type="radio" name="tipo_actividad" value="INVERSION"></td>
                                        
                            </tr>
                            <tr>
                                <td>FUNCIONAMIENTO</td>
                                <td><input type="radio" name="tipo_actividad" value="FUNCIONAMIENTO" checked></td>
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
                                <td><?php echo Form::input('ri_financiador','',array('id'=>'ri_financiador')); ?></td>
                                <td><?php echo Form::input('ri_porcentaje','',array('id' => 'ri_porcentaje','size'=>'6','class'=>'number','max'=>100, 'min'=>0)); ?> %</td>
                            </tr>
                            <tr>
                                <td>Externos</td>
                                <td><?php echo Form::input('re_financiador','',array('id'=>'re_financiador')); ?></td>
                                <td><?php echo Form::input('re_porcentaje','',array('id' => 're_porcentaje','size'=>'6','class'=>'number','max'=>100, 'min'=>0)); ?> %</td>
                            </tr>
                        </TBODY>
                    </table>
                </td>
            </tr>
        </table>

    </td>
</tr>
<tr>
    <td colspan="3"><hr /><br /></td>
</tr>
<tr>
        <td colspan="3">
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
                                <td><textarea name="referencia" id="referencia" style="width: 380px;" ></textarea></td>
                                <td><?php echo Form::input('cantidad','',array('id'=>'cantidad','size'=>'4','class'=>'number')); ?></td>
                                <td><?php echo Form::input('monto_total','',array('id'=>'monto_total','size'=>'8','class'=>'number')); ?></td>
                                <td><?php echo Form::input('plazo_ejecucion','',array('id'=>'plazo_ejecucion','size'=>'15')); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>

    </td>
</tr>

<tr>
    <td colspan="3">
        <div style="clear:both; display: block;"></div>
       <hr/>
       <p>
        <input type="submit" value="Crear documento" class="uibutton" name="submit" id="crear" title="Crear documento nuevo" />    
    </p>
</td>
<td></td>
</tr>
</table>
</fieldset>
</form>
</div>