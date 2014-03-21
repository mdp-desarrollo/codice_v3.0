<script type="text/javascript">   

    $(function(){
        $('#frmEditar').validate();       
        
        var tabContainers=$('div.tabs > div');
        tabContainers.hide().filter(':first').show();
        $('div.tabs ul.tabNavigation a').click(function(){
            tabContainers.hide();
            tabContainers.filter(this.hash).show();
            $('div.tabs ul.tabNavigation a').removeClass('selected');
            $(this).addClass('selected');
            return false;
        }).filter(':first').click();

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
///Presupueto
$('#fuente').change(function(){///fuente = id_programatica 
        var id = $('#fuente').val();
        $('#partida').html('');
        $('#disponible').val(0);
        $('#saldo').val(0);
        $("#x_tableMeta").html("<table id='x_tableMeta' border='1' class='classy'><thead><th>Partida</th><th>Disponible</th><th>Solicitado</th><th>Saldo</th></thead><tbody></tbody></table>");
        if(id){
            $.ajax({
                type: "POST",
                data: { id: id},
                url: "/pvajax/partidas",
                dataType: "json",
                success: function(item){
                    $('#partida').html(item);
                },
                    error: $(partida).html('error')
                });
            }
        });
$('#partida').change(function(){
        var f = $('#fuente').val();///id_programatica
        var p = $('#partida').val();
        $('#disponible').val(0);
        $('#saldo').val(0);
        if(f && p){
            $.ajax({
                type: "POST",
                data: { f: f, p: p},
                url: "/pvajax/saldopartida",
                dataType: "json",
                success: function(item){
                    $('#disponible').val(item.saldo);
                    calculo();
                },
                    error: $('#disponible').text('error')
                });
            }
        
        });
function calculo(){
        var disp = $('#disponible').val();
        var solicitado = parseFloat($('#solicitado').val());
        $('#saldo').val(parseFloat(disp - solicitado));
    }
$('#solicitado').change(function(){
        var m = $('#solicitado').val();
        var expreg = /[0-9]$/;
        if(expreg.test(m)){
            calculo();
        }
        else{
            alert('Introduzca Un Numero en el campo "solicitado"');
            $('#solicitado').val(0);
            $('#solicitado').focus();
        }
    });
//adicionar las partidas a la tabla
var x;
x=$(document);
x.ready(inicializarEventos);
function inicializarEventos()
{
  var x,y;
    x=$("#indicadorAdd");
  x.click(anadirIndicadorFinal);
  x=$("#indicadorDelete");
  x.click(eliminarIndicadorFinal);
  // meta
  y=$("#metaAdd");
  y.click(anadirMetaFinal);
  y=$("#metaDelete");
  y.click(eliminarMetaFinal);

}
function anadirIndicadorFinal()
{
  var x,y;
  x=$("#x_tableIndicador");
  y=$("#x_tableIndicador tr");
 y=y.length;
 x.append("<tr><td><input name='x_indicador[]' id='x_indicador_"+y+"/></td></tr>");

 }
function eliminarIndicadorFinal()
{
  var x;
  x=$("#x_tableIndicador tr");
  var cantidad=x.length;
  if(cantidad>0){
  x=x.eq(cantidad-1);
  x.remove();
}
}
//metas
function anadirMetaFinal()
{
    var m = $('#solicitado').val();
        var expreg = /[0-9]$/;
    if(expreg.test(m)){
        if($('#fuente').val()!='' && $('#partida').val()!='' && $('#solicitado').val()!='' && $('#solicitado').val()!=0){
            var x,y;
            x=$("#x_tableMeta");
            y=$("#x_tableMeta tr");
            y=y.length;
            var id_partida = $('#partida').val();
            var partida = $("#partida option:selected").html();
            var part = partida.split(' - ');
            var disponible = $('#disponible').val();
            var solicitado = parseFloat($('#solicitado').val());
            var saldo = $('#saldo').val();
            x.append("<tr><td><input type='hidden' size='2' name='x_id_partida[]' id='x_id_partida_"+y+"' value='"+id_partida+"' readonly/><input type='text' size='5' name='x_codigo[]' id='x_codigo_"+y+"' value='"+part[0]+"' readonly/> <input type='text' size='35' name='x_partida[]' id='x_partida_"+y+"' value='"+part[1]+"' readonly/></td><td><input type='text' size='5' name='x_disponible[]' id='x_disponible_"+y+"' value='"+disponible+"' readonly/></td><td><input type='text' size='5' name='x_solicitado[]' id='x_solicitado_"+y+"' value='"+solicitado+"' readonly/></td><td><input type='text' size='5' name='x_saldo[]' id='x_saldo_"+y+"' value='"+saldo+"' readonly/></td></tr>");
            $('#partida').val('');
            $('#disponible').val(0);
            $('#solicitado').val(0);
            $('#saldo').val(0);
        }
        else
            alert('Seleccione Fuente, Partida y Cantidad Solicitada');
    }
}
function eliminarMetaFinal()
{
  var x;
  x=$("#x_tableMeta tr");
  var cantidad=x.length;
  if(cantidad>1){
  x=x.eq(cantidad-1);
  x.remove();
}
}


    
///Fin Presupuesto    
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
//        $("input.file").si();

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
                    <td colspan="2">
                        <?php echo Form::label('referencia','Referencia')?>
                        <textarea name="referencia" id="referencia" style="width: 600px;" class="required" ><?php echo $documento->referencia?></textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="3"><hr /><br/></td>
                </tr>
                <tr>
                    <td colspan="3">
                        <table border="0">
                            <tr>
                                <td colspan="2">
                                    <?php echo Form::label('referencia','Antecedentes')?>
                                    <textarea name="antecedente" id="antecedente" style="width: 600px;" ><?php echo $pre->antecedente?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td><br />Unidad Ejecutora de Presupuesto:<br />&nbsp;</td>
                                <td><br/><b> <?php echo $uejecutorapre->oficina?></b><br />&nbsp;</td>
                            </tr>
                            <tr>
                                <td style=" width: 35%"><?php echo Form::label('fuente','Fuentes de Financiamiento')?></td>
                                <td><?php echo Form::select('fuente', $fuente, $pre->id_programatica, array('id' => 'fuente', 'class' => 'required')) ?></td>
                            </tr>
                            <tr>
                                <td><?php echo Form::label('partida','Partida')?></td>
                                <td><?php echo Form::select('partida', $partidas, NULL, array('id' => 'partida')) ?></td>
                            </tr>
                            <tr>
                                <td><?php echo Form::label('disponible','Saldo Actual Disponible')?></td>
                                <td><?php echo Form::input('disponible',0,array('size'=>10,'readonly','id'=>'disponible')) ?></td>
                            </tr>
                            <tr>
                                <td><?php echo Form::label('solicitado','Cantidad Solicitada')?></td>
                                <td><?php echo Form::input('solicitado',0,array('size'=>10,'id'=>'solicitado')) ?></td>
                            </tr>
                            <tr>
                                <td><?php echo Form::label('saldo','Nuevo Saldo')?></td>
                                <td><?php echo Form::input('saldo',0,array('size'=>10,'readonly','id'=>'saldo')) ?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><div style=" text-align: center" id="metaAdd" ><img src="/media/images/mail_ham2.png" style="border: none; cursor: pointer" />Adicionar Partida</div></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="3"><hr /><br />Lista de partidas de Gasto Adicionadas</td>
                </tr>
                <tr>
                    <td colspan="3">
                        <table id="x_tableMeta" border="1" class="classy">
                            <thead>
                                <th>Partida</th>
                                <th>Disponible</th>
                                <th>Solicitado</th>
                                <th>Saldo</th>
                            </thead>
                            <tbody>
                                <?php for($f=0;$f<count($x_partida);$f++):?>
                                <tr>
                                    <td><?php echo Form::hidden('x_id_partida[]',$x_id_partida[$f],array('id'=>'x_id_partida_'.$f,'readonly','size'=>2))?>
                                        <?php echo Form::input('x_codigo[]',$x_codigo[$f],array('id'=>'x_codigo_'.$f,'readonly','size'=>5))?>
                                    <?php echo Form::input('x_partida[]',$x_partida[$f],array('id'=>'x_partida_'.$f,'readonly','size'=>35))?></td>
                                    <td><?php echo Form::input('x_disponible[]',$x_disponible[$f],array('id'=>'x_disponible_'.$f,'readonly','size'=>5))?></td>
                                    <td><?php echo Form::input('x_solicitado[]',$x_solicitado[$f],array('id'=>'x_solicitado_'.$f,'readonly','size'=>5))?></td>
                                    <td><?php echo Form::input('x_saldo[]',$x_disponible[$f] - $x_solicitado[$f],array('id'=>'x_saldo_'.$f,'readonly','size'=>5))?></td>
                                </tr>
                                <?php endfor?>
                            </tbody>
                        </table>
                        <div style="text-align: center;"><div style="text-align: center;" id="metaDelete" ><img src="/media/images/delete.png" style="border: none; cursor: pointer"/>Eliminar Partida</div></div>
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