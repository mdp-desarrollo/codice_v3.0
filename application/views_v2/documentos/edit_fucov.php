<script type="text/javascript">   

    $(function(){
        calculo_dias();
        /*var id_tipoviaje = $('#id_tipoviaje').val();
        if(id_tipoviaje==1 || id_tipoviaje==2 || id_tipoviaje==3){
            $("#representacion_si").attr("disabled",true);
            $("#representacion_no").attr("checked",true);
        }*/
        $('table.classy tbody tr:odd').addClass('odd'); 
        
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
        //Modificado por Freddy//
        // $('#id_tipoviaje, #id_categoria').change(function(){
        //     var id_tipoviaje = $('#id_tipoviaje').val();
        //     var id_categoria = $('#id_categoria').val();
        //     //viaje al exterio habilitamos gastos de representacion
        //     /*if(id_tipoviaje==4 || id_tipoviaje==5){
        //         $("#representacion_si").removeAttr("disabled");

        //     }else{
        //         $("#representacion_si").attr("disabled",true);
        //         $("#representacion_no").attr("checked",true);
        //     }*/

        //     $.ajax({
        //         type: "POST",
        //         data: { id_tv: id_tipoviaje, id_ca:id_categoria},
        //         url: "/ajax/getmonto",
        //         dataType: "json",
        //         success: function(item)
        //         {
        //             if(item)
        //             {

        //                 if(item.moneda==0){
        //                     $('#viatico_dia').val(item.monto);
        //                     $('#id_viatico_dia').text(item.monto+ ' Bs.');
        //                     $('#idmoneda').text(' Bs.');
        //                     $('#tipo_moneda').val(0);
        //                 }
        //                 else{
        //                     $('#viatico_dia').val(item.monto);
        //                     $('#id_viatico_dia').text(item.monto+ ' $us.');
        //                     $('#idmoneda').text(' $us.');
        //                     $('#tipo_moneda').val(1);
        //                 }

        //             }
        //             calculo_viaticos();
        //         }
        //     });
        // });

$("input[name='cancelar']").click(function(){
    var cancelar = $("input[name='cancelar']:checked").val();
    if(cancelar =='Hospedaje' || cancelar == 'Hospedaje y alimentacion'){
        $("#financiador").attr("class", "required");
    }else{
        $("#financiador").removeAttr("class");
        $("#financiador").val("");
    }
    calculo_viaticos();
});

$("input[name='impuesto'], input[name='representacion']").click(function(){
    calculo_viaticos();
});

$("#hora_salida, #hora_arribo").keydown(function(event) {    
    calculo_dias();    
    calculo_viaticos();
});


function calculo_viaticos(){

    var porcentaje = $("input[name='cancelar']:checked").attr('porcentaje');
    var impuesto = $("input[name='impuesto']:checked").val(); //impuesto iva
    var representacion = $("input[name='representacion']:checked").val(); 
    var viatico_dia = $('#viatico_dia').val();
    var nro_dias = $('#nro_dias').val();
    var tipo_moneda = $('#tipo_moneda').val();
            //var h_arribo = $('#hora_arribo').val();

            if(tipo_moneda==0)
                tipo_moneda=' Bs.'
            else
                tipo_moneda=' $us.'

            var monto_parcial = ((parseFloat(porcentaje)*parseFloat(viatico_dia))/100)*parseFloat(nro_dias);
            //calculo
            //var monto_parcial = ((parseFloat(porcentaje)*parseFloat(viatico_dia))/100)*parseFloat(nro_dias);
            var gastos_rep=0;
            if(representacion == 'Si'){
                gastos_rep = (25*parseFloat(monto_parcial))/100;
            }
            var desc_iva_mp=0;
            var desc_iva_gr=0;
            if(impuesto == 'Si'){
                desc_iva_mp = (13*parseFloat(monto_parcial))/100;
                desc_iva_gr = ((13*parseFloat(gastos_rep))/100);
            }
            var desc_iva = parseFloat(desc_iva_mp)+parseFloat(desc_iva_gr);
            
            var total_viatico=parseFloat(monto_parcial)-parseFloat(desc_iva_mp);
            gastos_rep = parseFloat(gastos_rep)-parseFloat(desc_iva_gr);
            $('#gasto_imp').val(desc_iva.toFixed(2));
            $('#id_gasto_imp').text(desc_iva.toFixed(2)+tipo_moneda);
            $('#gasto_representacion').val(gastos_rep.toFixed(2));
            $('#id_gasto_representacion').text(gastos_rep.toFixed(2)+tipo_moneda);
            $('#total_viatico').val(total_viatico.toFixed(2));
            $('#id_total_viatico').text(total_viatico.toFixed(2)+tipo_moneda);
            $("#porcentaje_viatico").val(porcentaje);
            $("#id_porcentaje_viatico").text(porcentaje+' %');
            ///rodrigo fuente de presupuesto - 060813
            //ajaxppt();
            ///fin 060813
        }



        function calculo_dias(){
            $("#justificacion_finsem").removeAttr("class");
            var fecha_s = $("#fecha_salida").val();
            //var dia_s = fecha_s.substring(0, 3);
            fecha_s = fecha_s.substring(4, 14);
            var fecha_a = $("#fecha_arribo").val();
            //var dia_a = fecha_a.substring(0, 3);
            fecha_a = fecha_a.substring(4, 14);
            
            //validamos fin de semana
            var sw = 0;
            var f1= new Date(fecha_s);
            var f2= new Date(fecha_a);
            while (f1<=f2){
                //alert(f1.getUTCDay());
                if(f1.getUTCDay()==6 || f1.getUTCDay()==0){
                    $("#justificacion_finsem").attr("class", "required");
                    sw = 1;
                    break;
                }
                f1.setDate(f1.getDate()+1);
            }
            // validamos feriados
            if(sw==0){
                $.ajax({
                 type: "POST",
                 data: { fecha1:fecha_s, fecha2:fecha_a},
                 url: "/pvajax/feriados",
                 dataType: "json",
                 success: function(item)
                 {
                    if(item){
                                        //alert('Comision durante el feriado: '+item);
                                        $("#justificacion_finsem").attr("class", "required");
                                    }
                                    else{
                                     $("#justificacion_finsem").removeAttr("class");
                                 }
                             }
                         });
                
            }
            //calculo de viaticos
            if(fecha_s != '' && fecha_a !='') {
                var fecha2 = fecha_a.replace(/-/g, '/');
                var fecha1 = fecha_s.replace(/-/g, '/');
                var diferencia =  Math.floor(( Date.parse(fecha2) - Date.parse(fecha1) ) / 86400000);
                if(diferencia >= 0){
                    if(diferencia == 0){
                        diferencia = 1;
                    } else {
                        if($("#hora_arribo").val()>'12:00:00'){
                            diferencia +=1;
                        }
                    }
                    $('#nro_dia').val(diferencia);
                    //$('#id_nro_dias').text(diferencia);
                }
                else{
                    alert('la fecha de salida no puede ser mayor a la fecha de arribo.');
                    $('#fecha_salida').val($('#fecha_arribo').val());
                    $('#nro_dia').val(1);
                    //$('#id_nro_dias').text(1);
                }
            }
        }

        $.datepicker.regional['es'] = {
            closeText: 'Cerrar',
            prevText: '&#x3c;Ant',
            nextText: 'Sig&#x3e;',
            currentText: 'Hoy',
            monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
            'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
            monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun',
            'Jul','Ago','Sep','Oct','Nov','Dic'],
            dayNames: ['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'],
            dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
            dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
            weekHeader: 'Sm',
            dateFormat: 'dd/mm/yy',
            //dateFormat: 'Full - DD, d MM, yy',
            firstDay: 1,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ''
        };   
        $.datepicker.setDefaults($.datepicker.regional['es']);
        //var pickerOpts  = { changeMonth: true, minDate: 0, changeYear: true, yearRange: "-10:+1", dateFormat: 'D yy-mm-dd',onSelect: function(){ calculo_dias();calculo_viaticos();}};
        var pickerOpts  = { changeMonth: true, changeYear: true, yearRange: "-10:+1", dateFormat: 'D yy-mm-dd',onSelect: function(){ calculo_dias();calculo_viaticos();}};
        $('#fecha_salida,#fecha_arribo').datepicker(pickerOpts,$.datepicker.regional['es']);
        $('#hora_salida,#hora_arribo').timeEntry({show24Hours: true, showSeconds: true});


        /////////////end////////////////////
        
        

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

        /*Proceso de cambios para tramos*/
        $("#ver_tipoviaje").click(function(){
            $("#tabla_tipoviaje").toggle();
        })

        $("#id_tipoviaje1").change(function(){
            //alert(this.value);
            var tv=$("#id_tipoviaje1").val();
            if(tv!=''){
                var id_tipoviaje = $('#id_tipoviaje1').val();
                var id_categoria = $('#id_categoria').val();
                $.ajax({
                    type: "POST",
                    data: { id_tv: id_tipoviaje, id_ca:id_categoria},
                    url: "/ajax/getmonto",
                    dataType: "json",
                    success: function(item)
                    {
                        if(item)
                        {

                            if(item.moneda==0){
                                $('#viatico_dia1').val(item.monto);
                                $('.idmoneda1').text(' Bs.');
                                $('#tipo_moneda1').val(0);
                            }
                            else{
                                $('#viatico_dia1').val(item.monto);
                                $('.idmoneda1').text(' $us.');
                                $('#tipo_moneda1').val(1);
                            }

                        }
                        calculo_viaticos_tramos($("#viatico_dia1").val(),$("#nro_d1").val(),$("#tipo_moneda1").val(),$("#gasto_imp1"),$("#gasto_representacion1"),$("#total_viatico1"));
                    }
                });
}
});

$("#nro_d1").blur(function(){
            //alert(this.value);
            var tv=$("#id_tipoviaje1").val();
            if(tv!=''){
            //var id_tipoviaje = $('#id_tipoviaje1').val();
            //var id_categoria = $('#id_categoria').val();
            calculo_viaticos_tramos($("#viatico_dia1").val(),$("#nro_d1").val(),$("#tipo_moneda1").val(),$("#gasto_imp1"),$("#gasto_representacion1"),$("#total_viatico1"));
        }
    });

function calculo_viaticos_tramos(viatico_dia,nro_dias,tipo_moneda,gasto_imp,gasto_representacion,total_viatico){
    var porcentaje = $("input[name='cancelar']:checked").attr('porcentaje');
        var impuesto = $("input[name='impuesto']:checked").val(); //impuesto iva
        var representacion = $("input[name='representacion']:checked").val(); 
        // var viatico_dia = $('#viatico_dia1').val();
        // var nro_dias = $('#nro_d1').val();
        // var tipo_moneda = $('#tipo_moneda').val();

        if(tipo_moneda==0)
            tipo_moneda=' Bs.'
        else
            tipo_moneda=' $us.'

        var monto_parcial = ((parseFloat(porcentaje)*parseFloat(viatico_dia))/100)*parseFloat(nro_dias);
            //calculo
            //var monto_parcial = ((parseFloat(porcentaje)*parseFloat(viatico_dia))/100)*parseFloat(nro_dias);
            var gastos_rep=0;
            if(representacion == 'Si'){
                gastos_rep = (25*parseFloat(monto_parcial))/100;
            }
            var desc_iva_mp=0;
            var desc_iva_gr=0;
            if(impuesto == 'Si'){
                desc_iva_mp = (13*parseFloat(monto_parcial))/100;
                desc_iva_gr = ((13*parseFloat(gastos_rep))/100);
            }
            var desc_iva = parseFloat(desc_iva_mp)+parseFloat(desc_iva_gr);
            
            var total_via=parseFloat(monto_parcial)-parseFloat(desc_iva_mp);
            gastos_rep = parseFloat(gastos_rep)-parseFloat(desc_iva_gr);

            gasto_imp.val(desc_iva.toFixed(2));
            gasto_representacion.val(gastos_rep.toFixed(2));
            total_viatico.val(total_via.toFixed(2));
        }

        //$("input.file").si();

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

<?php
if($sw==0){
    $fi=date('Y-m-d');
    $ff=date('Y-m-d');
    $hi = date('H:i:s');
    $hf = date('H:i:s');
    // $transporte ='Aereo';
    // $cancelar = 'MDPyEP';
    $impuesto = 'No';
    $representacion = 'No';
    $dua = '';
    $nro_dia = '';
}else{
    $fi = date('Y-m-d', strtotime($pvfucovgeneral->fecha_salida));
    $ff = date('Y-m-d', strtotime($pvfucovgeneral->fecha_arribo));
    $hi = date('H:i:s', strtotime($pvfucovgeneral->fecha_salida));
    $hf = date('H:i:s', strtotime($pvfucovgeneral->fecha_arribo));    
    // $transporte = $pvfucov->transporte;
    // $cancelar =$pvfucov->cancelar;
    $impuesto = $pvfucovgeneral->impuesto;
    $representacion = $pvfucovgeneral->representacion;
    $dua = $pvfucovgeneral->dua;
    $nro_dia = $pvfucovgeneral->nro_dia;
}
$diai = dia_literal(date("w", strtotime($fi)));
$diaf = dia_literal(date("w", strtotime($ff)));

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

<h2 class="subtitulo">Editar <?php echo $documento->codigo; ?> - <b><?php echo $documento->nur; ?></b><br/><span> Editar documento <?php echo $documento->codigo; ?> </span></h2>
<form action="/documento/editar/<?php echo $documento->id; ?>" method="post" id="frmEditar" name="frmEditar" >
    <div class="tabs">
        <ul class="tabNavigation">
            <li><a href="#editar">Edición</a></li>
            <li><a href="#poa">POA</a></li>
            <li><a href="#pre">Presupuesto</a></li>
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
            
            <?php //echo Form::open('documento/editar/'.$documento->id, array('id'=>'frmEditar', 'method'=>'post'));?>
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
                <fieldset> 

                    <?php
                    //    echo Form::select('id_tipoviaje', $opt_tv, $pvfucov->id_tipoviaje, array('id' => 'id_tipoviaje','class'=>'required'));
                    echo Form::hidden('proceso', 1);
                    echo Form::hidden('id_tipo', $documento->id_tipo);
                    echo Form::hidden('titulo', '');
                    echo Form::hidden('tipo_cambio', $tipo_cambio,array('id'=>'tipo_cambio'));
                    echo Form::hidden('tipo_moneda', $pvfucov->tipo_moneda,array('id' => 'tipo_moneda'));
                    if($pvfucov->tipo_moneda==0)
                        $tipo_moneda="Bs.";
                    else
                        $tipo_moneda = '$us.';

                    ?>
                    <legend>
                        Categoria: <?php echo Form::select('id_categoria', $opt_cat, $pvfucovgeneral->id_categoria, array('id' => 'id_categoria','class'=>'required')); ?>
                    </legend>
                <?php endif; ?>
                <table width="100%">
                    <tr>
                        <td style=" border-right:1px dashed #ccc; padding-left: 5px;">
                            <p>
                                <?php
                                echo Form::hidden('id_doc', $documento->id);
                                echo Form::hidden('id_oficina', $documento->id_oficina,array('id'=>'id_oficina'));
                                echo Form::label('destinatario', 'Autoriza el Viaje:', array('class' => 'form'));
                                echo Form::input('destinatario', $documento->nombre_destinatario, array('id' => 'destinatario', 'size' => 45, 'class' => 'required'));
                                ?>
                            </p>
                            <p>
                                <?php
                                echo Form::label('destinatario', 'Cargo:', array('class' => 'form'));
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
                                    echo Form::input('via', $documento->nombre_via, array('id' => 'via', 'size' => 45));
                                    ?>
                                    <?php
                                    echo Form::label('cargovia', 'Cargo Via:', array('class' => 'form'));
                                    echo Form::input('cargovia', $documento->cargo_via, array('id' => 'cargovia', 'size' => 45));
                                    ?>
                                <?php endif; ?>

                            </p>
                        </td>
                        <td style=" border-right:1px dashed #ccc; padding-left: 5px;">
                            <p>
                                <?php
                                echo Form::label('remitente', 'Funcionario en Comisión: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mosca', array('class' => 'form'));
                                echo Form::input('remitente', $documento->nombre_remitente, array('id' => 'remitente', 'size' => 32, 'class' => 'required'));
                                ?>            
                                <?php
                                    //  echo Form::label('mosca','Mosca:');
                                echo Form::input('mosca', $documento->mosca_remitente, array('id' => 'mosca', 'size' => 4));
                                ?>
                                <?php
                                echo Form::label('cargo', 'Cargo Funcionario:', array('class' => 'form'));
                                echo Form::input('cargo_rem', $documento->cargo_remitente, array('id' => 'cargo_rem', 'size' => 45, 'class' => 'required'));
                                ?>
                                <?php
                                echo Form::label('adjuntos', 'Adjunto:', array('class' => 'form'));
                                echo Form::input('adjuntos', $documento->adjuntos, array('id' => 'adjuntos', 'size' => 45));
                                ?>
                                <?php
                                echo Form::label('copias', 'Con copia a:', array('class' => 'form'));
                                echo Form::input('copias', $documento->copias, array('id' => 'adjuntos', 'size' => 45));
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
                        <td colspan="2" style="padding-left: 5px;">
                            <?php echo Form::label('referencia', 'Motivo:', array('id' => 'label_referencia', 'class' => 'form')); ?> 
                            <textarea name="referencia" id="referencia" style="width: 510px;" class="required"><?php echo $documento->referencia ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <input type="hidden" id="word" value="0" name="word"  />
                        </td>
                    </tr>
                </table>

                <div style="width: 800px;float: left; ">
                    <?php echo Form::hidden('descripcion', $documento->contenido, array('id' => 'descripcion')); ?>
                    <table class="classy" border="1">
                        <thead>
                            <tr>
                                <th style="text-align:center;">Origén</th>
                                <th style="text-align:center;">Fecha y Hora <br>Salida</th>
                                <th style="text-align:center;">Desc. IVA</th> 
                                <th style="text-align:center;">Gastos<br>Repres.</th>
                                <th style="text-align:center;">Desc. DUA</th>
                                <th style="text-align:center;">Total Dias</th> 
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo Form::input('origen', $pvfucovgeneral->origen, array('id' => 'origen', 'size' => 15, 'class' => 'required')) ?></td>
                                <td><?php echo Form::input('fecha_salida', $diai . ' ' . $fi, array('id' => 'fecha_salida', 'size' => 12, 'class' => 'required')) ?><?php echo Form::input('hora_salida', $hi, array('id' => 'hora_salida', 'size' => 12, 'class' => 'required')) ?></td>

                                <td rowspan='3'>
                                    <input type="radio" name="impuesto" value="Si" <?php
                                    if ($impuesto == 'Si') {
                                       echo 'checked';
                                   }
                                   ?>> Si<br>
                                   <input type="radio" name="impuesto" value="No" <?php
                                   if ($impuesto == 'No') {
                                       echo 'checked';
                                   }
                                   ?>> No<br>            
                                </td>
                               <td rowspan='3'>
                                <input type="radio" name="representacion" value="Si" id="representacion_si" <?php if ($representacion == 'Si') {
                                   echo 'checked';
                               } ?>> Si<br>
                               <input type="radio" name="representacion" value="No" id="representacion_no" <?php if ($representacion == 'No') {
                                   echo 'checked';
                               } ?>> No<br>
                           </td>
                           <td rowspan='3'><?php echo Form::input('dua', $dua, array('id' => 'dua', 'size' => 2, 'class' => 'required')) ?></td>
                           <td rowspan='3'><?php echo Form::input('nro_dia', $nro_dia, array('id' => 'nro_dia', 'size' => 2, 'class' => 'required','readonly')) ?></td>
                       </tr>
                       <tr>
                        <th style="text-align:center; color:#ffffff; font-size: 11px; font-weight: bold;">DESTINO</th>
                        <th style="text-align:center; color:#ffffff; font-size: 11px; font-weight: bold;">FECHA Y HORA <br>RETORNO</th>
                    </tr>
                    <tr>
                        <td><?php echo Form::input('destino', $pvfucovgeneral->destino, array('id' => 'destino', 'size' => 15, 'class' => 'required')) ?></td>
                        <td><?php echo Form::input('fecha_arribo', $diaf . ' ' . $ff, array('id' => 'fecha_arribo', 'size' => 12, 'class' => 'required')) ?><?php echo Form::input('hora_arribo', $hf, array('id' => 'hora_arribo', 'size' => 12, 'class' => 'required')) ?></td>
                    </tr>   
                </tbody>
            </table>
            <br>
            <a href="#" id="ver_tipoviaje">Ver Tipo de Viajes <img src="/media/images/actions.gif"></a>
            <table class="classy" border="1" id="tabla_tipoviaje">
                <tbody>
                    <tr><td>T1 = Intradepartamental</td></tr>
                   <tr><td>T2 = Interdepartamentales</td></tr>
                   <tr><td>T3 = Franja de Frontera</td></tr>
                   <tr><td>T4 = Al Exterior - Centro y Sud America y el Caribe</td></tr>
                   <tr><td>T5 = Al Exterior - Norte America, Europa, Asia, Africa y Oceania</td></tr>
            </tbody>
        </table>
            <table class="classy" border="1" id="tabla_tramo">
                <tr>
                    <th style="text-align:center;">Tipo Viaje</th>
                    <th style="text-align:center;">Origén</th>
                    <th style="text-align:center;">Fecha y Hora de Salida</th>
                    <th style="text-align:center;">&nbsp;&nbsp;&nbsp;&nbsp;Transporte&nbsp;&nbsp;&nbsp;&nbsp;</th>
                    <th style="text-align:center;">Viaticos</th>
                    <th style="text-align:center;">Nro. Dias</th>
                    <th style="text-align:center;">Costo Pasajes</th> 
                    <th style="text-align:center;">Nro Boleto</th>
                    <th style="text-align:center;">Empresa</th>
                    <th style="text-align:center;">Ida y Vuelta</th>
                </tr>
                <tbody>
                    <tr>
                        <td rowspan="3"><?php echo Form::select('id_tipoviaje1[]', $opt_tv, $pvfucov->id_tipoviaje, array('id' => 'id_tipoviaje1','class'=>'required')); ?></td>
                        <td><?php echo Form::input('origen1[]', '', array('id' => 'origen1', 'size'=>'10')) ?></td>
                        <td><?php echo Form::input('fecha_salida1[]', $diai . ' ' . $fi, array('id' => 'fecha_salida1', 'size' => 12, 'class' => 'required')) ?><br><?php echo Form::input('hora_salida1[]', $hi, array('id' => 'hora_salida1', 'size' => 12, 'class' => 'required')) ?></td>
                        <td rowspan="3">
                            <input type="radio" name="transporte1[]" value="Aereo" checked> Aereo<br>
                            <input type="radio" name="transporte1[]" value="Terrestre"> Terrestre<br>
                            <input type="radio" name="transporte1[]" value="Vehiculo Oficial" > Vehiculo<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Oficial
                        </td>
                        <td rowspan="3">
                            <input type="radio" name="cancelar1[]" value="<?php  echo $session->get('sigla'); ?>" porcentaje="100" <?php
                            if ('MDPyEP' == $session->get('sigla')) {
                               echo 'checked';
                           }
                           ?>> <?php  echo $session->get('sigla'); ?><br><br>
                           Financiado por:
                           <?php echo Form::input('financiador1[]', $pvfucov->financiador, array('id' => 'financiador1', 'size' => 15)) ?><br>
                           Cubre:<br>
                            <input type="radio" name="cancelar1[]" value="Hospedaje" porcentaje="70" > Hospedaje<br>
                            <input type="radio" name="cancelar1[]" value="Hospedaje y alimentacion" porcentaje="25" > Hospedaje y<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;alimentacion<br>
                            <input type="radio" name="cancelar1[]" value="Renuncia de viaticos" porcentaje="0" > Renuncia de<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;viaticos
                        </td>
                        <td rowspan="3"><?php echo Form::input('nro_dia1[]', '', array('id' => 'nro_dia1', 'size'=>'2')) ?></td>
                        <td rowspan="3"><?php echo Form::input('total_pasaje1[]', '', array('id' => 'total_pasaje1', 'size'=>'6')) ?></td>
                        <td rowspan="3"><?php echo Form::input('nro_boleto1[]', '', array('id' => 'nro_boleto1', 'size'=>'6')) ?></td>
                        <td rowspan="3"><?php echo Form::input('empresa1[]', '', array('id' => 'empresa1', 'size'=>'6')) ?></td>
                        <td rowspan="3"><?php echo Form::checkbox('ida_vuelta1',1,FALSE,array('id'=>'id_vuelta1','name'=>'id_vuelta1','title'=>'Seleccione si el registro de viaje es de ida y vuelta','checked'))?></td>
                   </tr>
                   <tr>
                        <th style="text-align:center;">Destino</th>
                        <th style="text-align:center;">Fecha y Hora de Llegada</th>
                   </tr>
                   <tr>
                        <td><?php echo Form::input('destino1[]', '', array('id' => 'destino1', 'size'=>'10')) ?></td>
                        <td><?php echo Form::input('fecha_arribo1[]', $diai . ' ' . $fi, array('id' => 'fecha_arribo1', 'size' => 12, 'class' => 'required')) ?><br><?php echo Form::input('hora_arribo1[]', $hi, array('id' => 'hora_arribo1', 'size' => 12, 'class' => 'required')) ?></td>
                   </tr>
                
            </tbody>
        </table>
        <br>
        <table class="classy" border="1">
            <thead>
                <tr>
                    <th style="text-align:center;">Nro Dias</th>
                    <th style="text-align:center;">% Viaticos</th>
                    <th style="text-align:center;">Viatico x Dia</th>
                    <th style="text-align:center;">Desc. IVA 13%</th>
                    <th style="text-align:center;">Total Viaticos</th> 
                    <th style="text-align:center;">Gastos Repres.</th>
                    <th style="text-align:center;">Total Pasajes</th>
                </tr>
            </thead>
            <?php echo Form::hidden('nro_dias', '', array('id' => 'nro_dias')) ?>
            <?php echo Form::hidden('porcentaje_viatico', $pvfucov->porcentaje_viatico, array('id' => 'porcentaje_viatico')) ?>
            <?php echo Form::hidden('viatico_dia', $pvfucov->viatico_dia, array('id' => 'viatico_dia')) ?> 
            <?php echo Form::hidden('gasto_imp', $pvfucov->gasto_imp, array('id' => 'gasto_imp')) ?>
            <?php echo Form::hidden('total_viatico', $pvfucov->total_viatico, array('id' => 'total_viatico')) ?>
            <?php echo Form::hidden('gasto_representacion', $pvfucov->gasto_representacion, array('id' => 'gasto_representacion')) ?>
            <tbody>
                <tr align='center'>
                    <td id='id_nro_dias'></td>
                    <td id='id_porcentaje_viatico'><?php echo $pvfucov->porcentaje_viatico ?> %</td>
                    <td id='id_viatico_dia'><?php echo $pvfucov->viatico_dia ?> <?php echo $tipo_moneda;?></td>
                    <td id='id_gasto_imp'><?php echo $pvfucov->gasto_imp ?> <?php echo $tipo_moneda;?></td>
                    <td id='id_total_viatico'><?php echo $pvfucov->total_viatico ?> <?php echo $tipo_moneda;?></td>
                    <td id='id_gasto_representacion'><?php echo $pvfucov->gasto_representacion ?> <?php echo $tipo_moneda;?></td>
                    <td><?php echo Form::input('total_pasaje', $pvfucov->total_pasaje, array('id' => 'total_pasaje', 'size' => '8')) ?> <span id='idmoneda'><?php echo $tipo_moneda;?></span> </td>
                </tr>
            </tbody>
        </table>
    </div>
    <table width="100%">
        <tr>
            <td colspan="2" style="padding-left: 5px;">
                <?php echo Form::label('justificacion', 'Justificacion Fin de Semana:', array('id' => 'justificacion', 'class' => 'form')); ?> 
                <textarea name="justificacion_finsem" id="justificacion_finsem" style="width: 775px;" ><?php echo $pvfucov->justificacion_finsem ?></textarea>
            </td>
        </tr>
    </table>
    <div id="op">
                        <!-- <a href="#" class="link imagen">Insertar Imagen</a>
                        <a href="#" class="link imagen">Seleccionar todo</a>    -->
                    </div>
                    <div style="clear:both; display: block;"></div>
                    <input type="hidden" id="con" value="<?php echo strlen($documento->contenido . $documento->referencia); ?> "/>
                    <p>
                        <hr/>
                        <input type="submit" name="documento" value="Modificar documento" class="uibutton" />   
                    </p>
                </fieldset>


            </div>

        </div>

        <div id="poa">


        </div>
        <div id="pre">

        </div>
    </form>

    <?php // echo Form::close();?>
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