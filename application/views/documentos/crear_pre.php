
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

$("#asignar_nur").fcbkcomplete({
    json_url: "/ajax/documentos_nur",
    addontab: true,                   
    maxitems: 1,
    height: 5,
    cache: true
});
///presupuesto
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
            x.append("<tr><td><input type='hidden' size='2' name='x_id_partida[]' id='x_id_partida_"+y+"' value='"+id_partida+"' readonly/><input type='text' size='5' name='x_codigo[]' id='x_codigo_"+y+"' value='"+part[0]+"' readonly/><input type='text' size='35' name='x_partida[]' id='x_partida_"+y+"' value='"+part[1]+"' readonly/></td><td><input type='text' size='5' name='x_disponible[]' id='x_disponible_"+y+"' value='"+disponible+"' readonly/></td><td><input type='text' size='5' name='x_solicitado[]' id='x_solicitado_"+y+"' value='"+solicitado+"' readonly/></td><td><input type='text' size='5' name='x_saldo[]' id='x_saldo_"+y+"' value='"+saldo+"' readonly/></td></tr>");
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
        <table width="100%" border ="0">
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
    <td colspan="2">
        <?php echo Form::label('referencia','Referencia')?>
        <textarea name="referencia" id="referencia" style="width: 600px;" class="required" ></textarea>
    </td>
</tr>
<tr>
    <td colspan="3"><hr /></td>
</tr>
<tr>
    <td colspan="3">
        <table border="0">
            <tr>
                <td colspan="2">
                    <?php echo Form::label('antecedentes','Antecedentes')?>
                    <textarea name="antecedente" id="antecedente" style="width: 600px;" >Mediante Hoja de Seguimiento [NUR], se remite el [CITE], del Sr(a). <?php echo $user->nombre.', '.$user->cargo.', solicitando [MOTIVO].' ?></textarea>
                </td>
            </tr>
            <tr>
                <td><br />Unidad Ejecutora de Presupuesto:<br />&nbsp;</td>
                <td><br/><b> <?php echo $uejecutorapre->oficina?></b><br />&nbsp;</td>
            </tr>
            <tr>
                <td style=" width: 35%"><?php echo Form::label('fuente','Fuentes de Financiamiento')?></td>
                <td><?php echo Form::select('fuente', $fuente, NULL, array('id' => 'fuente', 'class' => 'required')) ?></td>
            </tr>
            <tr>
                <td><?php echo Form::label('partida','Partida')?></td>
                <td><?php echo Form::select('partida', NULL, NULL, array('id' => 'partida')) ?></td>
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
            </tbody>
        </table>
        <div style="text-align: center;" id="metaDelete" ><img src="/media/images/delete.png" style="border: none; cursor: pointer"/>Eliminar Partida</div></div>
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