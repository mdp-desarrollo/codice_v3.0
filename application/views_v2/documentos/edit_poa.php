<script type="text/javascript">   

    $(function(){

        var tabContainers=$('div.tabs > div');
        tabContainers.hide().filter(':first').show();
        $('div.tabs ul.tabNavigation a').click(function(){
            tabContainers.hide();
            tabContainers.filter(this.hash).show();
            $('div.tabs ul.tabNavigation a').removeClass('selected');
            $(this).addClass('selected');
            return false;
        }).filter(':first').click();


        $('#frmEditar').validate();
        
        $('#insertarImagen').click(function(){
            var left=screen.availWidth;
            var top=screen.availHeight;
            left=(left-700)/2;
            top=(top-500)/2;
            var r=window.showModalDialog("../otros/imagenes","","center:0;dialogWidth:600px;dialogHeight:450px;scroll=yes;resizable=yes;status=yes;"+"dialogLeft:"+left+"px;dialogTop:"+top+"px");
            InsertHTML(r[0]);
        });
        $('#subirImagen').click(function(){
            var left=screen.availWidth;
            var top=screen.availHeight;
            left=(left-700)/2;
            top=(top-500)/2;
            var r=window.showModalDialog("../otros/subirImagen","","center:0;dialogWidth:600px;dialogHeight:450px;scroll=yes;resizable=yes;status=yes;"+"dialogLeft:"+left+"px;dialogTop:"+top+"px");
            InsertHTML(r[0]);
        });

        $('#cambiarImagen').click(function(){
            var left=screen.availWidth;
            var top=screen.availHeight;
            left=(left-700)/2;
            top=(top-500)/2;
            var r=window.showModalDialog("../otros/imagenes2","","center:0;dialogWidth:600px;dialogHeight:450px;scroll=yes;resizable=yes;status=yes;"+"dialogLeft:"+left+"px;dialogTop:"+top+"px");
            $('#foto').val(r[0]);
            $('#fotox').attr('src',r[0]);
        });
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


// Modificado por Freddy Velasco
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
        ///Fin


        $('#btnword').click(function(){
            $('#word').val(1);
            return true

        });
        $('#save').click(function(){
            $('#frmEditar').submit();        
        });
        $('#subir').click(function(){
            var id=$(this).attr('rel');
            var left=screen.availWidth;
            var top=screen.availHeight;
            left=(left-700)/2;
            top=(top-500)/2;
            var r=window.showModalDialog("/archivo/add/"+id,"","center:0;dialogWidth:600px;dialogHeight:450px;scroll=yes;resizable=yes;status=yes;"+"dialogLeft:"+left+"px;dialogTop:"+top+"px");
            alert(r);
            return false;
        });        
        $("input.file").si();




    });
</script>
<style type="text/css">
    form#frmCreate{ padding: 0 5px; margin: 0;}
    .cke_contents{height: 500px;}
    cke_skin_kama{border: none;}
    div.si label.cabinet {
        width: 156px;
        height: 34px;
        display: block;
        overflow: hidden;
        position: relative;
        z-index: 3;
        float: left;
        cursor: pointer; 
    }
    div.si label.cabinet input {
        position: relative;
        left: -140px;
        top: 0;
        height: 100%;
        width: auto !important;
        z-index: 2;
        opacity: 0;
        -moz-opacity: 0;
        filter:progid:DXImageTransform.Microsoft.Alpha(opacity=0);
    }
    div.si div.uploadButton {
        position: relative;
        float: left;
    }
    div.si div.uploadButton div {
        width: 156px;
        height: 34px;
        background: url(/media/images/examinar.png) 0 0 no-repeat;
        left: -156px;
        position: absolute;
        z-index: 1;

    }
    div.si label.selectedFile {
        margin-left: 5px;
        line-height: 34px;
    }

</style>

<h2 class="subtitulo">Editar <?php echo $documento->codigo; ?> - <b><?php echo $documento->nur; ?></b><br/><span> Editar documento <?php echo $documento->codigo; ?> </span></h2>
<div class="tabs">
    <ul class="tabNavigation">
        <li><a href="#editar">Edición</a></li>
        <li><a href="#adjuntos">Adjuntos</a></li>        
    </ul>
    <div id="editar"> 

        <div class="formulario"  >  
            <div style="border-bottom: 1px solid #ccc; background: #F2F7FC; display: block; padding: 10px 0;   width: 100%;  ">    
                <a href="#" class="link save" id="save" title="Guardar cambios hechos al documento" > Guardar</a>
                | <a href="/pdf/<?php echo $tipo->action ?>.php?id=<?php echo $documento->id; ?>" class="link pdf" target="_blank" title="Imprimir PDF" >PDF</a>
                |  
                <?php if ($documento->estado == 1): ?> 
                    <a href="/seguimiento/?nur=<?php echo $documento->nur; ?>" class="link derivar" title="Ver seguimiento" >Derivado</a>      
                <?php else: ?>
                    <a href="/hojaruta/derivar/?id_doc=<?php echo $documento->id; ?>" class="link derivar" title="Derivar a partir del documento, si ya esta derivado muestra el seguimiento" >Derivar</a>      
                <?php endif; ?>
                <?php
                $session = Session::instance();
                if ($session->get('super') == 1):
                    ?>
                |  <a href="/word/print.php?id=<?php echo $documento->id; ?>" class="link word" target="_blank" title="Editar este documento en word" >Editar en Word</a>       
            <?php endif; ?>
        </div>
        <form action="/documento/editar/<?php echo $documento->id; ?>" method="post" id="frmEditar" >  
            <?php if (sizeof($mensajes) > 0): ?>
                <div class="info">
                    <p><span style="float: left; margin-right: .3em;" class="ui-icon-info"></span>
                        <?php foreach ($mensajes as $k => $v): ?>
                            <strong><?= $k ?>: </strong> <?php echo $v; ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>        
                <br/>
                <?php
                if ($documento->id_tipo == 5):
                    echo Form::hidden('proceso', 1);
                else:
                    ?>        
                <fieldset> <legend>Proceso: <?php echo Form::select('proceso', $options, $documento->id_proceso); ?>
                </legend>
            <?php endif; ?>            
            <table width="100%">
                <tr>
                    <td style=" border-right:1px dashed #ccc; padding-left: 5px;">
                        <input type="hidden" name="titulo" />   
                        <p>
                            <?php
                            echo Form::hidden('id_doc', $documento->id);
                            echo Form::hidden('descripcion', '');
                            echo Form::label('destinatario', 'Nombre del destinatario:', array('class' => 'form'));
                            echo Form::input('destinatario', $documento->nombre_destinatario, array('id' => 'destinatario', 'size' => 45, 'class' => 'required'));
                            ?>
                        </p>
                        <p>
                            <?php
                            echo Form::label('destinatario', 'Cargo Destinatario:', array('class' => 'form'));
                            echo Form::input('cargo_des', $documento->cargo_destinatario, array('id' => 'cargo_des', 'size' => 45, 'class' => 'required'));
                            ?>
                        </p> 
                        <?php if ($tipo->via == 0): ?>
                            <p>
                                <label>Institución Destinatario</label>
                                <input type="text" size="40" value="<?php echo $documento->institucion_destinatario; ?>" name="institucion_des" />    
                            </p>
                            <input type="hidden" size="40" value="" name="via" />    
                            <input type="hidden" size="40" value="" name="cargovia" />    
                        <?php else: ?>
                            <input type="hidden" size="40" value="" name="institucion_des" />    

                            <p>
                                <?php
                                echo Form::label('via', 'Via:', array('class' => 'form'));
                                echo Form::input('via', $documento->nombre_via, array('id' => 'via', 'size' => 45/* ,'class'=>'required' */));
                                ?>
                                <?php
                                echo Form::label('cargovia', 'Cargo Via:', array('class' => 'form'));
                                echo Form::input('cargovia', $documento->cargo_via, array('id' => 'cargovia', 'size' => 45/* ,'class'=>'required' */));
                                ?>
                            <?php endif; ?>

                        </p>
                    </td>
                    <td style=" border-right:1px dashed #ccc; padding-left: 5px;">
                        <p>
                            <?php
                            echo Form::label('remitente', 'Nombre del remitente: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mosca', array('class' => 'form'));
                            echo Form::input('remitente', $documento->nombre_remitente, array('id' => 'remitente', 'size' => 32, 'class' => 'required'));
                            ?>            
                            <?php
                                    //  echo Form::label('mosca','Mosca:');
                            echo Form::input('mosca', $documento->mosca_remitente, array('id' => 'mosca', 'size' => 4));
                            ?>
                            <?php
                            echo Form::label('cargo', 'Cargo Remitente:', array('class' => 'form'));
                            echo Form::input('cargo_rem', $documento->cargo_remitente, array('id' => 'cargo_rem', 'size' => 45, 'class' => 'required'));
                            ?>
                            <?php
                            echo Form::label('adjuntos', 'Adjunto:', array('class' => 'form'));
                            echo Form::input('adjuntos', $documento->adjuntos, array('id' => 'adjuntos', 'size' => 45/* ,'class'=>'required','title'=>'Ejemplo: Lo citado' */));
                            ?>
                            <?php
                            echo Form::label('copias', 'Con copia a:', array('class' => 'form'));
                            echo Form::input('copias', $documento->copias, array('id' => 'adjuntos', 'size' => 45/* ,'class'=>'required' */));
                            ?>
                        </p>
                    </td>



                    <td rowspan="2" style="padding-left: 5px;">
                        <?php echo Form::label('dest', 'Mis destinatarios:'); ?>
                        <div id="vias">
                            <ul>
                                <!-- Destinatario -->    
                                <?php foreach ($vias as $v): ?>
                                    <li class="<?php echo $v['genero'] ?>"><?php echo HTML::anchor('#', $v['nombre'], array('class' => 'destino', 'nombre' => $v['nombre'], 'title' => $v['cargo'], 'cargo' => $v['cargo'], 'via' => $v['via'], 'cargo_via' => $v['cargo_via'])); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </td>


                </tr>
                <tr>
                    <td colspan="3"><hr /><br/></td>
                </tr>
                <tr>
                    <td colspan="3">
                        <table>
                            <tr>
                                <td><b><?php echo Form::label('obj_gestion', 'Objetivo de Gesti&oacute;n:', array('class' => 'form')); ?></b></td>
                                <td><?php echo Form::select('obj_gestion', $obj_gestion, $poa->id_obj_gestion, array('class' => 'form', 'name' => 'obj_gestion', 'id' => 'obj_gestion', 'class' => 'required')); ?></td>
                            </tr>
                            <tr>
                                <td><b><?php echo Form::label('detalle_obj_gestion', 'Detalle:', array('class' => 'form')); ?></b>    </td>
                                <td><br><textarea name="det_obj_gestion" id="det_obj_gestion" style="width: 600px;" readonly ><?php echo $det_obj_gestion; ?></textarea></td>
                            </tr>
                            <tr>
                                <td><b><?php echo Form::label('obj_esp', 'Objetivo Espec&iacute;fico:', array('class' => 'form')); ?></b></td>
                                <td><?php echo Form::select('obj_esp', $obj_esp,$poa->id_obj_esp, array('class' => 'form', 'class' => 'required', 'id' => 'obj_esp', 'name' => 'obj_esp')); ?></td>
                            </tr>
                            <tr>
                                <td><b><?php echo Form::label('det_obj_esp', 'Detalle:', array('class' => 'form')); ?></b></td>
                                <td><br /><textarea name="det_obj_esp" id="det_obj_esp" style="width: 600px;" readonly ><?php echo $det_obj_esp; ?></textarea></td>
                            </tr>
                            <tr>
                                <td><b><?php echo Form::label('actividad', 'Actividad', array('class' => 'form')); ?></b></td>
                                <td><?php echo Form::select('actividad', $actividad, $poa->id_actividad, array('class' => 'form', 'class' => 'required', 'id' => 'actividad', 'name' => 'actividad')); ?></td>
                            </tr>
                            <tr>
                                <td><b><?php echo Form::label('det_act', 'Detalle:', array('class' => 'form')); ?></b></td>
                                <td><br><textarea name="det_act" id="det_act" style="width: 600px;" readonly ><?php echo $det_act; ?></textarea></td>
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
                                <td><?php echo Form::select('id_tipocontratacion', $tipocontratacion, $poa->id_tipocontratacion, array('class' => 'form', 'name' => 'id_tipocontratacion', 'id' => 'id_tipocontratacion', 'class' => 'required')); ?><br></td>
                                <td id="id_label_otro_tc"><b><?php echo Form::label('otro_tc', 'Otro:', array('class' => 'form')); ?></b></td>
                                <td id="id_otro_tipocontracion"><?php echo Form::input('otro_tipocontratacion',$poa->otro_tipocontratacion,array('id'=>'otro_tipocontratacion')); ?><br></td>
                            </tr>
                        </table>
                    </td>
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


            <div style="clear:both; display: block;"></div>
            <input type="hidden" id="con" value="<?php echo strlen($documento->contenido . $documento->referencia); ?> "/>
            <p>
                <hr/>
                <input type="submit" name="documento" value="Modificar documento" class="uibutton" />   
            </p>
        </fieldset>

    </form>
</div>
</div>
<div id="adjuntos">
    <div class="formulario">        
        <form method="post" enctype="multipart/form-data" action="" >
            <label>Selecione un archivo para subir...</label>
            <input type="file" class="file" name="archivo"/>                 
            <input type="hidden" name="id_doc" value="<?php echo $documento->id; ?>"/>
            <input type="submit" name="adjuntar" value="subir"/>
        </form>        
        <div style="clear: both;">

        </div>
        <h2 style="text-align:center;">Archivos Adjuntos </h2><hr/>
        <table id="theTable">
            <thead>
                <tr>
                    <th>NOMBRE ARCHIVO</th>
                    <th>TAMA&Ntilde;O</th>
                    <th>FECHA DE SUBIDA</th>
                    <th>ACCION</th>
                </tr>
            </thead>
            <tbody>                
                <?php foreach ($archivos as $a): ?>
                    <tr>
                        <td><a href="/descargar.php/?id=<?php echo $a->id; ?>"><?php echo substr($a->nombre_archivo, 13) ?></a></td>
                        <td align="center"><?php echo number_format(($a->tamanio / 1024) / 1024, 2) . ' MB'; ?></td>
                        <td align="center"><?php echo $a->fecha ?></td>
                        <td align="center"><a href="/archivo/eliminar/<?php echo $a->id; ?>" class="link delete">Eliminar</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>    
    </div>
</div>
</div>