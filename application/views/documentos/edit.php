<script>
    tinymce.init({
        selector: "textarea#descripcion, #descripcion3",
        theme: "modern",
        language : "es",
        // width: 595,
        height: 350,
        plugins: [
                "advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker",
                "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                "table contextmenu directionality emoticons template textcolor paste fullpage textcolor"
        ],
        content_css: "css/content.css",
        toolbar1: "bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | styleselect formatselect fontselect fontsizeselect",
        toolbar2: "undo redo | searchreplace | bullist numlist | outdent indent | forecolor backcolor | table | hr removeformat | pagebreak | fullscreen",
        style_formats: [
            {title: 'Bold text', inline: 'b'},
            {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
            {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
            {title: 'Example 1', inline: 'span', classes: 'example1'},
            {title: 'Example 2', inline: 'span', classes: 'example2'},
            {title: 'Table styles'},
            {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
        ]
    }); 
</script>
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
    
//Modificaod por freddy Velasco
<?php if($documento->fucov==1){ ?>
$('#contenido1').hide();
//$('#label_referencia').text('Motivo');
//adicionar atributos
$("#origen").attr("class", "required");
$("#destino").attr("class", "required");
$("#fecha_inicio").attr("class", "required");
$("#fecha_fin").attr("class", "required");
$("#hora_inicio").attr("class", "required");
$("#hora_fin").attr("class", "required");
$("#detalle_comision").attr("class","required");
<?php } else { ?>
    $('#label_contenido').hide();
    $('#contenido2').hide();
    
<?php } ?>    
    $('#fucov').click(function(){
    if($('#fucov').is(':checked')) {
            //$('#label_referencia').text('Motivo');
            $('#label_contenido').show();
            $('#contenido1').hide();
            $('#contenido2').show();
            //adicionar atributos
            $("#origen").attr("class", "required");
            $("#destino").attr("class", "required");
            $("#fecha_inicio").attr("class", "required");
            $("#fecha_fin").attr("class", "required");
            $("#hora_inicio").attr("class", "required");
            $("#hora_fin").attr("class", "required");
            $("#detalle_comision").attr("class","required");
        } else {
            //$('#label_referencia').text('Referencia');
            $('#label_contenido').hide();
            $('#contenido1').show();
            $('#contenido2').hide();
            //elimar atribuitos
             $("#origen").removeAttr("class");
             $("#destino").removeAttr("class");
             $("#fecha_inicio").removeAttr("class");
             $("#fecha_fin").removeAttr("class");
             $("#hora_inicio").removeAttr("class");
             $("#hora_fin").removeAttr("class");
             $("#detalle_comision").removeAttr("class");
        }  
});
$('#contenido3').hide();
$('#viaje_semana').click(function(){
    if($('#viaje_semana').is(':checked')) {
            $('#contenido1').hide();
            $('#contenido3').show();

            $('#referencia').text('AUTORIZAR EL PAGO DE VIÁTICOS DE FIN DE SEMANA, A FAVOR DEL SEÑOR [...INGRESE NOMBRE...], [...INGRESE CARGO...] DEL MINISTERIO DE DESARROLLO PRODUCTIVO Y ECONOMÍA PLURAL.');
        } else {
            $('#contenido1').show();
            $('#contenido3').hide();
            $('#referencia').text('');
        }  
});

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
var pickerOpts  = { changeMonth: true, minDate: 0, changeYear: true, yearRange: "-10:+1", dateFormat: 'D yy-mm-dd',onSelect: function(){ feriados('fecha');}};
$('#fecha_inicio,#fecha_fin').datepicker(pickerOpts,$.datepicker.regional['es']);
$('#hora_inicio,#hora_fin').timeEntry({show24Hours: true, showSeconds: true});


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
        //$("input.file").si();

/////////////////////POA////////////////////
///Modificado Freddy Velasco
$('#obj_est').change(function(){
    var id = $('#obj_est').val();
    var id_oficina = $('#id_oficina').val();
    $('#det_obj_est').html('');
    
    $('#obj_gestion').html('');
    $('#det_obj_gestion').html('');
    $('#obj_esp').html('');
    $('#det_obj_esp').html('');
    $('#actividad').html('');
    $('#det_act').html('');

            var act = 'detobjestrategico';///detalle del Objetivo estrategico
            var ctr = $('#det_obj_est');
            ajaxs(id, act, ctr,0);
            act = 'objgestion';
            ctr = $('#obj_gestion');
            ajaxs(id, act, ctr,id_oficina);
});

$('#obj_gestion').change(function(){
    var id = $('#obj_gestion').val();
    $('#det_obj_gestion').html('');
    $('#obj_esp').html('');
    $('#det_obj_esp').html('');
    $('#actividad').html('');
    $('#det_act').html('');
            var act = 'detobjgestion';///detalle del Objetivo de Gestion 
            var ctr = $('#det_obj_gestion');
            ajaxs(id, act, ctr,0);
            act = 'objespecifico';
            ctr = $('#obj_esp');
            ajaxs(id, act, ctr,0);
        });
$('#obj_esp').change(function(){
    var id = $('#obj_esp').val();
    $('#det_obj_esp').html('');
    $('#actividad').html('');
    $('#det_act').html('');
            var act = 'detobjespecifico';///detalle del Objetivo Especifico 
            var ctr = $('#det_obj_esp');
            ajaxs(id, act, ctr,0);
            act = 'actividad';///actividades 
            ctr = $('#actividad');
            ajaxs(id, act, ctr,0);
        });
$('#actividad').change(function(){
    var id = $('#actividad').val();
    $('#det_act').html('');
            var act = 'detactividad';///detalle del Objetivo Especifico 
            var ctr = $('#det_act');
            ajaxs(id, act, ctr,0);
            
        });

function ajaxs(id, accion, control,id_oficina)
{        
    $.ajax({
        type: "POST",
        data: { id: id, id_oficina: id_oficina},
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
/////////////////////PRESUPUESTO//////////////////////
///Modificado Rodrigo
$('#fuente').change(function(){///fuente = id_programatica 
        var id = $('#fuente').val();
        $('#partida').html('');
        $('#disponible').val(0);
        $('#saldo').val(0);
        $("#x_tableMeta").html("<table id='x_tableMeta' border='1' class='classy'><thead><th>Partida</th><th><!--Disponible--></th><th>Solicitado</th><th><!--Saldo--></th></thead><tbody></tbody></table>");
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
            x.append("<tr><td><input type='hidden' size='2' name='x_id_partida[]' id='x_id_partida_"+y+"' value='"+id_partida+"' readonly/><input type='text' size='5' name='x_codigo[]' id='x_codigo_"+y+"' value='"+part[0]+"' readonly/> <input type='text' size='35' name='x_partida[]' id='x_partida_"+y+"' value='"+part[1]+"' readonly/></td><td><input type='hidden' size='5' name='x_disponible[]' id='x_disponible_"+y+"' value='"+disponible+"' readonly/></td><td><input type='text' size='5' name='x_solicitado[]' id='x_solicitado_"+y+"' value='"+solicitado+"' readonly/></td><td><input type='hidden' size='5' name='x_saldo[]' id='x_saldo_"+y+"' value='"+saldo+"' readonly/></td></tr>");
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
//////////end//////////////  
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
$origen =  '';
$destino = '';
$detalle_comision = '';
$fi = '';
$ff = '';
$hi = '';
$hf = '';
$obs = '';
$checked = '';
$diai = '';
$diaf = '';

if($documento->fucov==1) {
$origen =  $pvcomision->origen;
$destino = $pvcomision->destino;
$detalle_comision = $pvcomision->detalle_comision;
$fi = date('Y-m-d', strtotime($pvcomision->fecha_inicio));
$ff = date('Y-m-d',  strtotime($pvcomision->fecha_fin));
$hi = date('H:i:s', strtotime($pvcomision->fecha_inicio));
$hf = date('H:i:s',  strtotime($pvcomision->fecha_fin));
$diai=  dia_literal(date("w", strtotime($fi)));
$diaf=  dia_literal(date("w", strtotime($ff)));
$obs = $pvcomision->observacion;
$checked = 'checked';
} 

function dia_literal($n) {
    switch ($n) {
        case 1: return 'Lun'; break;
        case 2: return 'Mar'; break;
        case 3: return 'Mie'; break;
        case 4: return 'Jue'; break;
        case 5: return 'Vie'; break;
        case 6: return 'Sab'; break;
        case 0: return 'Dom'; break;
    }
}

$contenido_ra = '';
if ($tipo->id==11) {
$contenido_ra = '<!DOCTYPE html>
<html>
<head>
</head>
<body>
<p lang="es-ES" align="JUSTIFY"><strong>VISTOS:</strong></p>
<p lang="es-ES" align="JUSTIFY">La solicitud del <span style="color: #ff0000;">[ingrese cargo del superior]</span>, <span style="color: #ff0000;">[ingrese nombre del superior]</span>, de autorizaci&oacute;n de pago de vi&aacute;ticos en fin de semana a favor del se&ntilde;or <span style="color: #ff0000;">[ingrese nombre del funcionario en comision]</span>, emitida mediante Memor&aacute;ndum de Viaje <span style="color: #ff0000;">[ingrese cite del memorandum]</span>, de <span style="color: #ff0000;">[ingrese fecha]</span> y todo lo que convino ver y se tuvo presente.</p>
<p lang="es-ES" align="JUSTIFY"><strong>CONSIDERANDO:</strong></p>
<p lang="es-ES" align="JUSTIFY">Que el Decreto Supremo N&deg; 29894, de 7 de febrero de 2009, aprueba la Estructura Organizativa del &Oacute;rgano Ejecutivo del Estado Plurinacional, disponiendo en su art&iacute;culo 118, la estructura com&uacute;n de apoyo a los Ministerios, integrada por las Direcciones y Unidades, entre ellas la Direcci&oacute;n General de Asuntos Administrativos, la cual por disposici&oacute;n del art&iacute;culo 122 inciso e) de la citada norma, tiene la funci&oacute;n de emitir Resoluciones Administrativas para resolver asuntos de su competencia.</p>
<p lang="es-ES" align="JUSTIFY">Que el Decreto Supremo N&deg; 1788, de 6 de noviembre de 2013, tiene por objeto establecer la escala de vi&aacute;ticos, categor&iacute;as y pasajes para los servidores p&uacute;blicos, acorde a la nueva estructura del Estado Plurinacional; definiendo en su art&iacute;culo 4, la escala de vi&aacute;ticos al interior y exterior del pa&iacute;s seg&uacute;n la categor&iacute;a del servidor p&uacute;blico. Asimismo, el art&iacute;culo 6 Par&aacute;grafo I, proh&iacute;be el pago de vi&aacute;ticos correspondientes a fin de semana o feriado, excepto cuando: las actividades p&uacute;blicas justifiquen la presencia y funci&oacute;n espec&iacute;fica de un servidor p&uacute;blico en fin de semana o feriado; por razones de itinerario que demande la presencia del servidor p&uacute;blico, previo al evento; cuando la comisi&oacute;n exceda los seis 6 d&iacute;as h&aacute;biles y continuos de trabajo; los mismos que ser&aacute;n autorizados mediante Resoluci&oacute;n expresa de la autoridad competente.</p>
<p lang="es-ES" align="JUSTIFY">Que el Reglamento Interno de Pasajes y Vi&aacute;ticos del Ministerio de Desarrollo Productivo y Econom&iacute;a Plural,aprobado mediante Resoluci&oacute;n Ministerial MDPyEP/DESPACHO/N&deg; 255.2013, de 7 de noviembre de 2013,concordante con lo establecido en el Decreto Supremo N&deg; 1788, de 6 de noviembre de 2013, establece las causas de excepcionalidad a la prohibici&oacute;n de pago de vi&aacute;ticos de fin de semana o feriado, cuya aprobaci&oacute;n deber&aacute; ser autorizada a trav&eacute;s de Resoluci&oacute;n expresa.</p>
<p lang="es-ES" align="JUSTIFY">Que mediante el Formulario de Comisi&oacute;n de Viaje (FOCOV) <span style="color: #ff0000;">[ingrese cite focov]</span>, de <span style="color: #ff0000;">[ingrese fecha FOCOV]</span>, del <span style="color: #ff0000;">[ingrese cargo superior]</span>, <span style="color: #ff0000;">[ingrese nombre superior]</span>, declara en comisi&oacute;n y autoriza el viaje del se&ntilde;or <span style="color: #ff0000;">[ingrese Nombre Funcionario en comision]</span>, <span style="color: #ff0000;">[ingrese cargo funcionario en comusion]</span>, a la ciudad de <span style="color: #ff0000;">[ingrese nombre de la ciudad]</span>, los d&iacute;as <span style="color: #ff0000;">[ingrese fecha inicial a fecha final]</span>; a objeto <span style="color: #ff0000;">[ingrese objetivo del viaje]</span>.</p>
<p lang="es-ES" align="JUSTIFY"><strong>POR TANTO:</strong></p>
<p lang="es-ES" align="JUSTIFY">El Director General de Asuntos Administrativos del Ministerio de Desarrollo Productivo y Econom&iacute;a Plural, en ejercicio de sus funciones conferidas por ley;</p>
<p lang="es-ES" align="JUSTIFY"><strong>RESUELVE: </strong></p>
<p lang="es-ES" align="JUSTIFY"><strong>ART&Iacute;CULO &Uacute;NICO.-</strong> Autorizar el pago de vi&aacute;ticos de fin de semana, a favor del se&ntilde;or <span style="color: #ff0000;">[ingrese nombre del funcionario en comision]</span>, <span style="color: #ff0000;">[ingrese cargo del funsionario en comision]</span>, correspondiente al d&iacute;a <span style="color: #ff0000;">[ingrese fecha]</span>, de conformidad a lo establecido en el Formulario de Comisi&oacute;n de Viaje (FOCOV) <span style="color: #ff0000;">[ingrese cite FOCOV]</span>, de <span style="color: #ff0000;">[ingrese fecha FOCOV]</span>.</p>
<p lang="es-ES" align="JUSTIFY">Reg&iacute;strese, comun&iacute;quese, c&uacute;mplase y arch&iacute;vese.</p>
</body>
</html>';}


?>

<h2 class="subtitulo">Editar <?php echo $documento->codigo; ?> - <b><?php echo $documento->nur; ?></b><br/><span> Editar documento <?php echo $documento->codigo; ?> </span></h2>
<form action="/documento/editar/<?php echo $documento->id; ?>" method="post" id="frmEditar" >  
<div class="tabs">
    <ul class="tabNavigation">
        <li><a href="#editar">Edición</a></li>
        <?php if($documento->fucov == 2):?>
        <li><a href="#poa">POA</a></li>
        <li><a href="#pre">PRE</a></li>
        <?php endif;?>
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
<!--<form action="/documento/editar/<?php echo $documento->id; ?>" method="post" id="frmEditar" >-->
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
                $mv='';
                $checked='';
                if($documento->fucov == '1') { 
                    $mv = "<b>MEMOR&Aacute;NDUM DE VIAJE </b>";
                    $checked = 'checked';
                }

                if ($documento->id_tipo == 5 || $documento->id_tipo==16):
                    echo Form::hidden('proceso', 1);
                else:
                    ?>        
                    <fieldset> <legend>Proceso: <?php echo Form::select('proceso', $options, $documento->id_proceso); ?>
                            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                            <?php if ($documento->id_tipo == '2'){?>FOCOV: <?php echo Form::checkbox('fucov',1,FALSE,array('id'=>'fucov','name'=>'fucov','title'=>'seleccione si quiere habilitar un memoramdum de viaje',$checked))?><?php }?>    
                            <?php if ($tipo->id == '11'){?>Viaje Fin Semana: <?php echo Form::checkbox('viaje_semana',1,FALSE,array('id'=>'viaje_semana','name'=>'viaje_semana','title'=>'seleccione si quiere habilitar Resolucion Administrativa viaje fin de semana'))?><?php }?>    
                                &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                            <?php echo $mv; ?>
                        </legend>
                    <?php endif; ?>            
                    <table width="100%">
                        <tr>
                            <td style=" border-right:1px dashed #ccc; padding-left: 5px;">
                                <?php if ($documento->id_tipo == '5' || $documento->id_tipo == '16'): ?>
                                    <p>
                                        <label>Titulo:</label>
                                        <select name="titulo" class="required">
                                            <option></option>
                                            <option <?php
                                if ($documento->titulo == 'Señor') {
                                    echo 'selected';
                                }
                                    ?> >Señor</option>
                                            <option <?php
                                            if ($documento->titulo == 'Señora') {
                                                echo 'selected';
                                            }
                                    ?>>Señora</option>
                                            <option <?php
                                            if ($documento->titulo == 'Señores') {
                                                echo 'selected';
                                            }
                                    ?>>Señores</option>    
                                        </select>
                                    </p>
                                <?php else: ?>
                                    <input type="hidden" name="titulo" />   
                                <?php endif; ?>    
                                <p>
                                    <?php
                                    echo Form::hidden('id_doc', $documento->id);
                                    echo Form::hidden('id_oficina', $documento->id_oficina,array('id'=>'id_oficina'));
                                    echo Form::label('destinatario', 'Nombre del destinatario:', array('class' => 'form'));
                                    echo Form::input('destinatario', $documento->nombre_destinatario, array('id' => 'destinatario', 'size' => 45, 'class' => 'required'));
                                    ?>
                                </p>
                                <p>
                                    <?php
                                    echo Form::label('destinatario', 'Cargo Destinatario:', array('class' => 'form'));
                                    echo Form::input('cargo_des', $documento->cargo_destinatario, array('id' => 'cargo_des', 'size' => 45));
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

                                        <!-- Vias -->    

                                        <!-- Destinatario -->    
                                        <?php foreach ($vias as $v): ?>
                                            <li class="<?php echo $v['genero'] ?>"><?php echo HTML::anchor('#', $v['nombre'], array('class' => 'destino', 'nombre' => $v['nombre'], 'title' => $v['cargo'], 'cargo' => $v['cargo'], 'via' => $v['via'], 'cargo_via' => $v['cargo_via'])); ?></li>
                                        <?php endforeach; ?>

                                        <!-- Inmediato superior -->    
                                        <?php //foreach($superior  as $v){    ?>
                                        <li class="<?php //echo $v['genero']    ?>"><?php //echo HTML::anchor('#',$v['nombre'],array('class'=>'destino','nombre'=>$v['nombre'],'title'=>$v['cargo'],'cargo'=>$v['cargo'],'via'=>'','cargo_via'=>''));    ?></li>
                                        <?php //}    ?>
                                        <!-- dependientes -->    
                                        <?php // foreach($dependientes  as $v){    ?>
                                        <li class="<?php // echo $v['genero']    ?>"><?php //echo HTML::anchor('#',$v['nombre'],array('class'=>'destino','nombre'=>$v['nombre'],'title'=>$v['cargo'],'cargo'=>$v['cargo'],'via'=>'','cargo_via'=>''));    ?></li>
                                        <?php //}    ?>
                                    </ul>
                                </div>
                            </td>


                        </tr>

                        <tr>
                            <td colspan="2" style="padding-left: 5px;">
                                <?php echo Form::label('referencia', 'Referencia:', array('id' => 'label_referencia', 'class' => 'form')); ?> 
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
                        <?php echo Form::label('contenido', 'Contenido:', array('id' => 'label_contenido', 'class' => 'form')); ?> 
                        <div id='contenido1'>
                            <?php
                            echo Form::textarea('descripcion', $documento->contenido, array('id' => 'descripcion', 'cols' => 50, 'rows' => 20));
                            ?>
                        </div>
                        
                        
                        <div id='contenido2' style="width: 780px;">
                            <br>
                            Por medio del presente Memorándum se autoriza a su persona trasladarse desde:<br> 
                            La ciudad (origen)
                            <?php echo Form::input('origen', $origen, array('id' => 'origen')); ?> 
                            hasta la ciudad (destino)
                            <?php echo Form::input('destino', $destino, array('id' => 'destino')); ?><br>
                            con el objeto de (detalle de comision)
                            <p>
                                <textarea name="detalle_comision" id="detalle_comision" style="width: 775px;" ><?php echo $detalle_comision; ?></textarea>
                            </p>
                            desde el 
                            <input type="text" id="fecha_inicio" name="fecha_inicio" size='16' value="<?php echo $diai.' '.$fi;?>"/> a Hrs. <input type="text" name="hora_inicio" id="hora_inicio" value="<?php echo $hi; ?>" size='6'/>
                            hasta el
                            <input type="text" id="fecha_fin" name="fecha_fin" size='16' value="<?php echo $diaf.' '.$ff?>"/> a Hrs. <input type="text" id="hora_fin" name="hora_fin" value="<?php echo $hf; ?>" size='6'/><br>
                            <p style="text-align: justify;">Sírvase tramitar ante la Dirección General de Asuntos Administrativos la asignación de pasajes y viáticos de acuerdo a escala autorizada para lo cual su persona deberá coordinar la elaboración del FOCOV.
                            Una vez completada la comisión sírvase hacer llegar el informe de descargo dentro de los próximos 8 días hábiles de concluída la comisión de acuerdo al artículo 28 del reglamento interno de Pasajes y viáticos del Ministerio de Desarrollo Productivo y Economía Plural.</p>
                            <?php echo Form::label('observacion', 'Observacion:', array('id' => 'label_observacion', 'class' => 'form')); ?> 
                            <textarea name="observacion" id="observacion" style="width: 775px;" ><?php echo $obs; ?></textarea>
                        </div>

                        <div id='contenido3'>
                        <?php
                        echo Form::textarea('descripcion3',$contenido_ra,array('id'=>'descripcion3','cols'=>50,'rows'=>10,'name'=>'descripcion3'));
                        ?>
                        </div>


                    </div>  
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

            <!--</form>-->
        </div>
    </div>
    <?php if($documento->fucov == 2){?>
    <div id="poa">
        <div class="formulario"  >  
            
        <!--<form action="/documento/editar/<?php echo $documento->id; ?>" method="post" id="frmEditar" >  -->
                
            <table width="100%">
                
                <tr>
                                                <td><b>Unidad Ejecutora:</b></td>
                                                <td colspan="2"><?php echo $uejecutorapoa->oficina?></td>
                                            </tr>
                <tr>
                    <td colspan="3"><hr /><br/></td>
                </tr>
                <tr>
                    <td colspan="3">
                     <div><b><?php echo Form::label('label_plansectorial', 'PLAN SECTORIAL - POLITICA', array('id' => 'label_plansectorial', 'class' => 'form')); ?> </b></div>   
                        <table class="classy" border="1">
                                        <thead>
                                            <tr>
                                                <th></th>
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
                    <td colspan="3">
                        <table>
                            <tr>
                                <td><b><?php echo Form::label('obj_est', 'Objetivo Estrategico:', array('class' => 'form')); ?></b></td>
                                <td><?php echo Form::select('obj_est', $obj_est, $poa->id_obj_est, array('class' => 'form', 'name' => 'obj_est', 'id' => 'obj_est', 'class' => 'required')); ?></td>
                            </tr>
                            <tr>
                                <td><b><?php echo Form::label('detalle_obj_est', 'Detalle:', array('class' => 'form')); ?></b>    </td>
                                <td><br><textarea name="det_obj_est" id="det_obj_est" style="width: 600px;" readonly ><?php echo $det_obj_est; ?></textarea></td>
                            </tr>
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
                                                <td><textarea name="proceso_con" id="proceso_con" style="width: 380px;" ><?php echo $poa->proceso_con; ?></textarea></td>
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
            <!--<p>
                <hr/>
                <input type="submit" name="documento" value="Modificar documento" class="uibutton" />   
            </p>-->
        </fieldset>

    <!--</form>-->
        </div>
    </div>
    <div id="pre">
        <div class="formulario"  >  
        <fieldset>

            <table border="0" width="100%">
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
                                <td><?php //echo Form::label('disponible','Saldo Actual Disponible')?></td>
                                <td><?php echo Form::hidden('disponible',0,array('size'=>10,'readonly','id'=>'disponible')) ?></td>
                            </tr>
                            <tr>
                                <td><?php echo Form::label('solicitado','Cantidad Solicitada')?></td>
                                <td><?php echo Form::input('solicitado',0,array('size'=>10,'id'=>'solicitado')) ?></td>
                            </tr>
                            <tr>
                                <td><?php //echo Form::label('saldo','Nuevo Saldo')?></td>
                                <td><?php echo Form::hidden('saldo',0,array('size'=>10,'readonly','id'=>'saldo')) ?></td>
                            </tr>
                            <tr>
                                <td colspan="2"><div style=" text-align: center" id="metaAdd" ><img src="/media/images/mail_ham2.png" style="border: none; cursor: pointer" />Adicionar Partida</div></td>
                            </tr>
                            <tr>
                                <td colspan="2"><hr /></td>
                            </tr>
                        </table>
            
                <div id="saldoppt">
                    <table id="x_tableMeta" border="1" class="classy">
                            <thead>
                                <th>Partida</th>
                                <th><!--Disponible--></th>
                                <th>Solicitado(Bs.)</th>
                                <th><!--Nuevo Saldo--></th>
                            </thead>
                            <tbody>
                                <?php for($f=0;$f<count($x_partida);$f++):?>
                                <tr>
                                    <td><?php echo Form::hidden('x_id_partida[]',$x_id_partida[$f],array('id'=>'x_id_partida_'.$f,'readonly','size'=>2))?>
                                        <?php echo Form::input('x_codigo[]',$x_codigo[$f],array('id'=>'x_codigo_'.$f,'readonly','size'=>5))?>
                                        <?php echo Form::input('x_partida[]',$x_partida[$f],array('id'=>'x_partida_'.$f,'readonly','size'=>35))?>
                                    </td>
                                    <td><?php echo Form::hidden('x_disponible[]',$x_disponible[$f],array('id'=>'x_disponible_'.$f,'readonly','size'=>5))?></td>
                                    <td><?php echo Form::input('x_solicitado[]',$x_solicitado[$f],array('id'=>'x_solicitado_'.$f,'readonly','size'=>5))?></td>
                                    <td><?php echo Form::hidden('x_saldo[]',$x_disponible[$f] - $x_solicitado[$f],array('id'=>'x_saldo_'.$f,'readonly','size'=>5))?></td>
                                </tr>
                                <?php endfor ?>
                            </tbody>
                        </table>
                </div>
                <div style="text-align: center;"><div style="text-align: center;" id="metaDelete" ><img src="/media/images/delete.png" style="border: none; cursor: pointer"/>Eliminar Partida</div></div>
                </fieldset>
        </div>
    </div>
    <?php }?>
</form>
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