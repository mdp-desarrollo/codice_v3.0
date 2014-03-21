<script type="text/javascript">
$(function(){
    $('#fuente').change(function(){
        ajaxppt();
        ajaxdetalle();
    });
    function ajaxppt()
    {
        var id = $('#fuente').val();
        if($('#total_pasaje').length){
            control = $('#saldoppt');
            //control.html('');
            if(id){
                var pasaje = $('#total_pasaje').val();
                var viatico = $('#total_viatico').val();
                var viaje = $('#id_tipoviaje').val();
                var gasto = $('#gasto_representacion').val();
                if(viaje > 2){
                    var cambio = $('#tipo_cambio').val();
                    viatico = (viatico * cambio).toFixed(2);
                    pasaje = (pasaje * cambio).toFixed(2);
                    gasto = (gasto * cambio).toFixed(2);
                } 
                $.ajax({
                    type: "POST",
                    data: { id: id, pasaje:pasaje, viatico:viatico, viaje:viaje, gasto:gasto},
                    url: "/pvajax/pptdisponibleuser",
                    dataType: "json",
                    success: function(item)
                    {
                        $(control).html(item);
                    },
                    error: $(control).html('Error')
                    });
            }
            else
                control.html('NO HAY FUENTE DE FINANCIMIENTO SELECCIONADA.');
        }
        else{
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
                        error: $('#partida').html('error')
                    });
                }
        }
    }
    function ajaxdetalle()
    {
        var id = $('#fuente').val();
        if(id){
            $.ajax({
                type: "POST",
                data: { id: id},
                url: "/pvajax/pptdetalle",
                dataType: "json",
                success: function(item)
                {
                    $("#sigla").html(item.sigla);
                    $("#cod_da").html(item.codigo_da);
                    $("#cod_ue").html(item.codigo_ue);
                    $("#cod_programa").html(item.codigo_prog);
                    $("#cod_proyecto").html(item.codigo_proy);
                    $("#cod_actividad").html(item.codigo_act);
                    $("#cod_org").html(item.codigo_fte);
                    $("#cod_fte").html(item.codigo_org);
                    
                    $("#entidad").html(item.entidad);
                    $("#da").html(item.da);
                    $("#ue").html(item.ue);
                    $("#programa").html(item.programa);
                    $("#proyecto").html(item.proyecto);
                    $("#actividad").html(item.actividad);
                    $("#org").html(item.org);
                    $("#fte").html(item.fte);
                }
            });
        }
        else{
            $("#sigla,#cod_da,#cod_ue,#cod_programa,#cod_proyecto,#cod_actividad,#cod_fte,#cod_org").html('');
            $("#entidad,#da,#ue,#programa,#proyecto,#actividad,#org,#fte").html('');
        }
        //alert('detalle');
    }
    
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
        if($('#fuente').val()!='' && $('#partida').val()!='' && $('#solicitado').val()!='' && $('#solicitado').val()!=0){
            var x,y;
            x=$("#x_tableMeta");
            y=$("#x_tableMeta tr");
            y=y.length;
            var id_partida = $('#partida').val();
            var partida = $("#partida option:selected").html();
            var disponible = $('#disponible').val();
            var solicitado = $('#solicitado').val();
            var saldo = $('#saldo').val();
            x.append("<tr><td><input type='hidden' size='2' name='x_id_partida[] id='x_id_partida_"+y+"' value='"+id_partida+"' readonly/><input type='text' size='35' name='x_partida[]' id='x_partida_"+y+"' value='"+partida+"' readonly/></td><td><input type='text' size='5' name='x_disponible[]' id='x_disponible_"+y+"' value='"+disponible+"' readonly/></td><td><input type='text' size='5' name='x_solicitado[]' id='x_solicitado_"+y+"' value='"+solicitado+"' readonly/></td><td><input type='text' size='5' name='x_saldo[]' id='x_saldo_"+y+"' value='"+saldo+"' readonly/></td></tr>");
            $('#partida').val('');
            $('#disponible').val(0);
            $('#solicitado').val(0);
            $('#saldo').val(0);
        }
        else
            alert('Seleccione Fuente, Partida y Cantidad Solicitada');
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

    
    $('#frmEditarPre').validate();
    $('.autorizar').live('click', function() {
        var answer = confirm("Esta seguro de aprobar el documento? ")
        if (answer)
            return true;
        return false;
});
});
</script>
<?php 
    if($pvfucov->tipo_moneda == '0')
        $moneda = 'Bs.';
    else
        $moneda = '$us.';
?>
<h2 style="text-align: center;"> REGISTRO DE EJECUCIÓN DE GASTOS</h2>
<div class="formulario">
<form id="frmEditarPre" action="/pvpresupuesto/modificarpre/<?php echo $pre->id?>" method="post" enctype="multipart/form-data">


<b>FOCOV:</b> 
TOTAL PASAJES: <?php echo Form::input('total_pasaje', $pvfucov->total_pasaje, array('id' => 'total_pasaje', 'size' => 8,'readonly')); echo $moneda?>&nbsp;&nbsp;&nbsp;
TOTAL VIATICOS: <?php echo Form::input('total_viatico', $pvfucov->total_viatico, array('id' => 'total_viatico', 'size' => 8,'readonly')); echo $moneda?>&nbsp;&nbsp;&nbsp;
GASTO REP: <?php echo Form::input('gasto_representacion', $pvfucov->gasto_representacion, array('id' => 'gasto_representacion', 'size' => 8,'readonly')); echo $moneda?>
<?php echo Form::hidden('id_tipoviaje', $pvfucov->id_tipoviaje, array('id' => 'id_tipoviaje'))?>
<?php echo Form::hidden('tipo_cambio', $tipo_cambio->cambio_venta, array('id' => 'tipo_cambio'))?>

        <div style="border-bottom: 1px solid #ccc; background: #F2F7FC; display: block; padding: 10px 0;   width: 100%;  ">
        <hr/>
        <table>
        <tr>            
    <?php if(isset($archivo->id)):?>
    <td>
        <a href="/descargar.php?id=<?php echo $archivo->id;?>" style="color: #1C4781; text-decoration: underline;  "><?php echo substr($archivo->nombre_archivo,13);?></a>
        <input type="hidden" value="<?php echo $archivo->id;?>" name="id_archivo"/>    
    </td>
    <td colspan="2">        
        <label for="" style=" font-weight: bold; color:#333;">Cambiar documento escaneado (.pdf < 20M)</label>
        <input type="file" name="archivo"/>
    </td>
    <?php else:?>
    <td colspan="2">   
        <input type="hidden" value="0" name="id_archivo"/>
        <label for="" style=" font-weight: bold; color:#333;">Subir documento escaneado (.pdf < 20M)</label>
        <input type="file" name="archivo"/>
    </td>
    <?php endif;?>    
    
        </tr>    
        </table>
        
        <input type="submit" value="Modificar documento" class="uibutton" name="submit" id="crear" title="Actualizar"/>    
        </div>
        
</form>
    
    <center>
        <a href="/pdf/pre.php?id=<?php echo $pre->id_documento;?>" class="link pdf" target="_blank" title="Imprimir Certificacion Presupuestaria" >Imprimir Presupuesto</a>
        <?php if($pre->auto_pre == 0):?>
            <a href="/pvpresupuesto/aprobarpre/<?php echo $pre->id?>" class="autorizar" title="Aprobar Presupuesto" ><img src="/media/images/tick.png"/>Aprobar Presupuesto</a>
        <?php endif;?>
        <?php if($pre->auto_pre == 1):?>
            <a href="/hojaruta/derivar/?id_doc=<?php echo $pre->id_documento; ?>" class="link derivar" title="Derivar a partir del documento, si ya esta derivado muestra el seguimiento" >Derivar</a>
        <?php endif;?>
        <br />
    </center>
<br />
<br />
&nbsp;
</div>