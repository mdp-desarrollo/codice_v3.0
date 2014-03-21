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
    $("#frmCreate").validate();
    var config={
        toolbar : [ ['Maximize','Preview','SelectAll','Cut', 'Copy','Paste', 'Pagebreak','PasteFromWord','PasteText','-','Bold','Italic','Underline','FontSize','Font','TextColor','BGColor',,'NumberedList','BulletedList'],
        ['Undo','Redo','-','SpellChecker','Scayt','-','Find','Replace','-','Table','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock']],
        language: 'es'
    }
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
$('#contenido3').hide();
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
            $('#otro_nur').hide();
        } else {
            //$('#label_referencia').text('Referencia');
            $('#label_contenido').hide();
            $('#contenido1').show();
            $('#contenido2').hide();
            $('#otro_nur').show();
            
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


$("#asignar_nur").fcbkcomplete({
    json_url: "/ajax/documentos_nur",
                    addontab: true,                   
                    maxitems: 1,
                    height: 5,
                    cache: true
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
                dayNamesShort: ['Dom','Lun','Mar','Mie','Juv','Vie','Sab'],
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
var pickerOpts  = { changeMonth: true, minDate: 0, changeYear: true, yearRange: "-10:+1", dateFormat: 'D yy-mm-dd'};
$('#fecha_inicio,#fecha_fin').datepicker(pickerOpts,$.datepicker.regional['es']);
$('#hora_inicio,#hora_fin').timeEntry({show24Hours: true, showSeconds: true});
///////////////////end//////////////////////////
///Modificado por rodrigo
    $('#nota').click(function(){
        if($('#nota').is(':checked')) {
            $('#destinatario').html('');
            $('#asignar_nur').html('');
            $('#otro_nur').hide();
        }else{
            $('#otro_nur').show();
        }
});
});
</script>
<h2 class="subtitulo">Crear <?php echo $documento->tipo;?> <br/><span>LLENE CORRECTAMENTE LOS DATOS EN EL FORMULARIO</span></h2>
<div class="formulario">
    <form action="/documento/crear/<?php echo $documento->action;?>" method="post" id="frmCreate">
        <br/>
        <fieldset>
            <?php if($tipo->tipo=='Carta' || $tipo->id == '16'):
            echo Form::hidden('proceso',1);
            ?>
            <div id="otro_nur"><br><br>ASIGNAR HOJA DE RUTA: <select id="asignar_nur" name="asignar_nur" ></select></div>
            <?php else: ?>
            <legend>Proceso: <?php echo Form::select('proceso', $options, NULL);?>
                &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                <?php if ($documento->tipo == 'Memorandum'){?>FOCOV: <?php echo Form::checkbox('fucov',1,FALSE,array('id'=>'fucov','name'=>'fucov','title'=>'seleccione si quiere habilitar un memoramdum de viaje'))?><?php }?>
                <?php if ($tipo->id == '11'){?>Viaje Fin Semana: <?php echo Form::checkbox('viaje_semana',1,FALSE,array('id'=>'viaje_semana','name'=>'viaje_semana','title'=>'seleccione si quiere habilitar Resolucion Administrativa viaje fin de semana'))?><?php }?>    
                <?php // if ($documento->tipo == 'Nota Interna'){?>
                <!-- Certificaci&oacute;n POA-PRE:  -->
                <?php // echo Form::checkbox('nota',1,FALSE,array('id'=>'nota','name'=>'nota','title'=>'seleccione si quiere habilitar certificacón POA y Presupuestaria')) } ?>    
                <div id="otro_nur"><br><br>ASIGNAR HOJA DE RUTA: <select id="asignar_nur" name="asignar_nur" ></select></div>
            </legend>
            <hr/>
        <?php endif; ?>
        <?php 
        $referencia='';
        $contenidoRH='';
        if ($tipo->id==16) {
            $referencia = 'DOCUMENTACIÓN QUE DEBE ADJUNTAR PARA SU FILE PERSONAL';
            $contenidoRH = '<!DOCTYPE html>
<html>
<head>
</head>
<body>
<p align="JUSTIFY"><span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;">De mi mayor consideraci&oacute;n:</span></p>
<p style="text-align: justify;"><span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;">Con la finalidad de dar cumplimiento al Registro de Personal del Sistema de Administraci&oacute;n de Personal (SAP), la Unidad de Recursos Humanos solicita que en el plazo de 5 d&iacute;as, remita a esta Unidad la documentaci&oacute;n esencial para conformar su file personal de acuerdo al siguiente detalle:</span></p>
<ul>
<li><span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;">Hoja de Vida actualizada, con sus respectivos respaldos.</span></li>
<li><span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;">Fotocopia de Cedula de Identidad</span></li>
<li><span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;">Fotocopia de Libreta de Servicio Militar (varones)</span></li>
<li><span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;">Fotocopia de N&uacute;mero de Cuenta (Banco Uni&oacute;n)</span></li>
<li><span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;">Registro/Carnet de N&uacute;mero &Uacute;nico de Afiliado AFP (NUA)</span></li>
<li><span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;">Documentaci&oacute;n para afiliaci&oacute;n Caja Nacional de Salud</span><span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;"><br /></span></li>
</ul>
<table style="height: 124px;" border="1" width="730" cellspacing="0" cellpadding="7"><colgroup><col width="310" /> <col width="268" /> </colgroup>
<tbody>
<tr valign="TOP">
<td width="310">
<p align="CENTER"><em><span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;">AFILIACI&Oacute;N - PRIMERA VEZ</span></em></p>
</td>
<td width="268">
<p align="CENTER"><em><span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;">AFILIACI&Oacute;N - REINGRESO</span></em></p>
</td>
</tr>
<tr valign="TOP">
<td width="310" height="13">
<p align="JUSTIFY"><span style="font-family: arial,helvetica,sans-serif; font-size: 8pt;">Certificado de Nacimiento Original<br /></span></p>
</td>
<td width="268">
<p><span style="font-family: arial,helvetica,sans-serif; font-size: 8pt;">Formulario AVC 04 de afiliaci&oacute;n y AVC 07 de baja anterior instituci&oacute;n (original) </span></p>
</td>
</tr>
<tr valign="TOP">
<td width="310">
<p><span style="font-family: arial,helvetica,sans-serif; font-size: 8pt;">Fotocopia &uacute;ltima boleta de pago o memor&aacute;ndum de designaci&oacute;n</span></p>
</td>
<td width="268">
<p><span style="font-family: arial,helvetica,sans-serif; font-size: 8pt;">Fotocopia &uacute;ltima boleta de pago o memor&aacute;ndum de designaci&oacute;n</span></p>
</td>
</tr>
<tr valign="TOP">
<td width="310" height="8">
<p><span style="font-family: arial,helvetica,sans-serif; font-size: 8pt;">Fotocopia Carnet de Identidad</span></p>
</td>
<td width="268">
<p><span style="font-family: arial,helvetica,sans-serif; font-size: 8pt;">Fotocopia Carnet de Identidad</span></p>
</td>
</tr>
</tbody>
</table>
<p align="JUSTIFY">&nbsp;</p>
<p align="JUSTIFY"><span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;">Al mismo tiempo se deben llenar los formularios de:</span></p>
<ul>
<li>Registro de Ficha Personal con fotograf&iacute;a 4x4 fondo azul</li>
<li>Declaraci&oacute;n de Incompatibilidad y Conflictos de Intereses</li>
<li>Declaraci&oacute;n Jurada de Incompatibilidad por la Funci&oacute;n P&uacute;blica</li>
<li>Declaraci&oacute;n Jurada de Incompatibilidad por la Funci&oacute;n P&uacute;blica para abogados</li>
</ul>
<p align="JUSTIFY">&nbsp;<span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;">(Disponibles en la p&aacute;gina web: intranet.produccion.gob.bo)</span></p>
<p><span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;">Sin otro particular saludo a usted con la mayor atenci&oacute;n.</span></p>
<hr />
<p align="JUSTIFY"><span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;"><strong><span lang="es-MX">REF.: &nbsp; &nbsp; </span></strong><span lang="es-MX">COMUNICACI&Oacute;N INTERNA</span></span></p>
<p style="text-align: justify;"><span lang="es-MX" style="font-family: arial,helvetica,sans-serif; font-size: 10pt;">A efecto de dar cumplimiento con el Art&iacute;culo 15 del Reglamento Espec&iacute;fico del Sistema de Administraci&oacute;n de Personal, referente al Proceso de Inducci&oacute;n o Integraci&oacute;n, mediante la presente se le comunica que de forma OBLIGATORIA debe informarse sobre:</span></p>
<p><span lang="es-MX" style="font-family: arial,helvetica,sans-serif; font-size: 10pt;">1. Objetivos y funciones del Ministerio de Desarrollo Productivo en los siguientes enl&aacute;celes:</span></p>
<p><span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;"><a href="http://www.produccion.gob.bo/contenido/id/4">http://www.produccion.gob.bo/contenido/id/4</a></span></p>
<p align="JUSTIFY"><span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;"><a href="http://www.produccion.gob.bo/contenido/id/3"><span style="text-decoration: underline;">http://www.produccion.gob.bo/contenido/id/3</span></a></span></p>
<p style="text-align: justify;" align="JUSTIFY"><span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;"><span lang="es-MX">2. L</span><span lang="es-MX">a Normativa especifica de la Entidad en el enlace <a href="http://www.produccion.gob.bo/documentos/reglamentos">http://www.produccion.gob.bo/documentos/reglamentos</a> con el siguiente contenido:</span></span></p>
<ul>
<li><span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;">Procedimiento para el Cumplimiento Oportuno de la Declaraci&oacute;n Jurada de Bienes y Rentas (PCO-DJBR)</span></li>
<li><span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;">Reglamento Interno de Personal</span></li>
<li><span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;">Reglamento interno de pasant&iacute;as profesionales, universitarias y de trabajos dirigidos</span></li>
<li><span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;">Reglamento de Pasajes y Vi&aacute;ticos</span></li>
<li><span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;">Reglamento Especifico del Sistema de Administraci&oacute;n de Bienes y Servicios</span></li>
<li><span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;">Reglamento Espec&iacute;fico del Sistema de Tesorer&iacute;a</span></li>
<li><span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;">Reglamento Espec&iacute;fico del Sistema de Programaci&oacute;n de Operaciones</span></li>
<li><span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;">Reglamento Espec&iacute;fico del Sistema de Presupuesto</span></li>
<li><span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;">Reglamento Espec&iacute;fico del Sistema de Organizaci&oacute;n Administrativa</span></li>
<li><span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;">Reglamento Espec&iacute;fico del Sistema de Contabilidad Integrada</span></li>
<li><span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;">Reglamento Espec&iacute;fico del Sistema de Administraci&oacute;n de Personal</span></li>
<li><span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;">Manual de Uso del Sistema CODICE de Correspondencia, (<a href="http://intranet.produccion.gob.bo/">http://intranet.produccion.gob.bo/</a>) carpeta <br />Manuales&nbsp;</span></li>
</ul>
<p style="text-align: justify;" align="JUSTIFY"><span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;">Asimismo, adjunto a la presente el POAI correspondiente al puesto de trabajo designado, para el conocimiento de las funciones a desarrollar y su respectiva suscripci&oacute;n.</span></p>
<p><span style="font-family: arial,helvetica,sans-serif; font-size: 10pt;">Sin otro particular, saludo a usted atentamente.<br /></span></p>
</body>
</html>';
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
        <table width="100%">
            <tr>
                <td style=" border-right:1px dashed #ccc; padding-left: 5px;">
                    <?php if($documento->tipo=='Carta' || $documento->id==16):?>
                    <p>
                        <label>Titulo:</label>
                        <select name="titulo" class="required">
                            <option></option>
                            <option>Señor</option>
                            <option>Señora</option>
                            <option>Señores</option>    
                        </select>
                    </p>
                <?php else:?>
                <input type="hidden" name="titulo" />   
            <?php endif;?>
            <p>
                <?php
                echo Form::label('destinatario', 'Nombre del destinatario:',array('class'=>'form'));
                echo Form::input('destinatario','',array('id'=>'destinatario','size'=>40,'class'=>'required'));
                ?>
            </p>
            <p>
                <?php
                echo Form::label('destinatario', 'Cargo Destinatario:',array('class'=>'form'));
                echo Form::input('cargo_des','',array('id'=>'cargo_des','size'=>40));
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
        echo Form::label('remitente', 'Remitente:',array('class'=>'form'));
        echo Form::input('remitente',$user->nombre,array('id'=>'remitente','size'=>35,'class'=>'required'));            
        ?>            
        <?php
   //echo Form::label('mosca','Mosca:');
        echo Form::input('mosca',$user->mosca,array('id'=>'mosca','size'=>5));
        ?>
        <?php
        echo Form::label('cargo', 'Cargo Remitente:',array('class'=>'form'));
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
<td rowspan="2" style="padding-left: 5px;">
    <?php  echo Form::label('dest','Mis destinatarios:');?>
    <div id="vias">
        <ul>
            <!-- Vias -->    
            <!-- Destinatario -->    
            <?php foreach($destinatarios  as $v): ?>
            <li class="<?php echo $v['genero']?>"><?php echo HTML::anchor('#',$v['nombre'],array('class'=>'destino','nombre'=>$v['nombre'],'title'=>$v['cargo'],'cargo'=>$v['cargo'],'via'=>$v['via'],'cargo_via'=>$v['cargo_via']));?></li>
        <?php endforeach; ?>
        <!-- Inmediato superior -->    
        <?php //foreach($superior  as $v){ ?>
        <li class="<?php //echo $v['genero']?>"><?php //echo HTML::anchor('#',$v['nombre'],array('class'=>'destino','nombre'=>$v['nombre'],'title'=>$v['cargo'],'cargo'=>$v['cargo'],'via'=>'','cargo_via'=>''));?></li>
        <?php //} ?>
        <!-- dependientes -->    
        <?php // foreach($dependientes  as $v){ ?>
        <li class="<?php // echo $v['genero']?>"><?php //echo HTML::anchor('#',$v['nombre'],array('class'=>'destino','nombre'=>$v['nombre'],'title'=>$v['cargo'],'cargo'=>$v['cargo'],'via'=>'','cargo_via'=>''));?></li>
        <?php //} ?>
    </ul>
</div>
</td>
<?php 
}
?>
</tr>

<tr>
    <td colspan="2" style="padding-left: 5px;">
        <?php
        echo Form::label('referencia', 'Referencia:',array('id'=>'label_referencia','class'=>'form'));?> 
        <textarea name="referencia" id="referencia" style="width: 500px;" class="required"><?php echo $referencia ?></textarea>

    </td>
</tr>
<tr>
    <td colspan="3">
        <input type="hidden" id="word" value="0" name="word"  />
        <div class="descripcion" style="width: 800px; float: left; ">
            <?php echo Form::label('contenido', 'Contenido:',array('id'=>'label_contenido','class'=>'form'));?> 
            <div id='contenido1'>
             <?php
            echo Form::textarea('descripcion',$contenidoRH,array('id'=>'descripcion','cols'=>50,'rows'=>10,'name'=>'descripcion'));
            ?>
            </div>
            <div id='contenido2' style="width: 780px;">
                <br>
                <p>Por medio del presente Memorándum se autoriza a su persona trasladarse desde:</p><br> 
                <p align='justify;'>La ciudad (origen)
                <?php echo Form::input('origen','',array('id'=>'origen')); ?> 
                hasta la ciudad (destino)
                <?php echo Form::input('destino','',array('id'=>'destino')); ?></p><br>
                <p>con el objeto de (detalle de comision)</p>
                <p>
                    <textarea name="detalle_comision" id="detalle_comision" style="width: 775px;" ></textarea>
                </p>
                desde el 
                <input type="text" id="fecha_inicio" name="fecha_inicio" size='16'/> a Hrs. <input type="text" name="hora_inicio" id="hora_inicio" value="00:00:00" size='6'/>
                    hasta el
                <input type="text" id="fecha_fin" name="fecha_fin" size='16'/> a Hrs. <input type="text" id="hora_fin" name="hora_fin" value="00:00:00" size='6'/><br>
                <p style="text-align: justify;">Sírvase tramitar ante la Dirección General de Asuntos Administrativos la asignación de pasajes y viáticos de acuerdo a escala autorizada para lo cual su persona deberá coordinar la elaboración del FOCOV.
                Una vez completada la comisión sírvase hacer llegar el informe de descargo dentro de los próximos 8 días hábiles de concluída la comisión de acuerdo al artículo 28 del reglamento interno de Pasajes y viáticos del Ministerio de Desarrollo Productivo y Economía Plural.</p>
                <?php echo Form::label('observacion', 'Observacion:',array('id'=>'label_observacion','class'=>'form'));?> 
                <textarea name="observacion" id="observacion" style="width: 775px;" ></textarea>
            </div>

            <div id='contenido3'>
             <?php
            echo Form::textarea('descripcion3',$contenido_ra,array('id'=>'descripcion3','cols'=>50,'rows'=>10,'name'=>'descripcion3'));
            ?>
            </div>
            
        </div>
<div id="op"><!--
    <a href="#" class="link imagen" id="insertarImagen">Insertar nueva Imagen</a><br/>
    <a href="#" class="link imagen" id="insertarImagen2">Insertar imagen existente</a><br/>
-->
</div>
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