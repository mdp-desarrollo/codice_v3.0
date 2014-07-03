<script>
    tinymce.init({
        selector: "textarea#descripcion, #descripcion3, .descripcion4",
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



$('#comision').change(function(){
    codigo_memo = $('#codigo_memo').val();
    fecha_memo = $('#fecha_memo').val();
    cargo_destinatario_memo = $('#cargo_destinatario_memo').val();
    nombre_destinatario_memo = $('#nombre_destinatario_memo').val();
    nombre_remitente_memo = $('#nombre_remitente_memo').val();
    cargo_remitente_memo = $('#cargo_remitente_memo').val();
    destino_memo = $('#destino_memo').val();
    objetivo_memo = $('#objetivo_memo').val();
    fi_memo = $('#fecha_inicio_memo').val();
    ff_memo = $('#fecha_fin_memo').val();

    estado = $('#comision').val();
    if (estado == 1) {
        $("#referencia").val('AUTORIZACION DE PAGO DE VIATICOS COMISION FIN DE SEMANA, EN FAVOR DE '+nombre_destinatario_memo+', '+cargo_destinatario_memo);
    } else if(estado == 2) {
        $("#referencia").val('AUTORIZACION DE PAGO DE VIATICOS COMISION FERIADO, EN FAVOR DE '+nombre_destinatario_memo+', '+cargo_destinatario_memo);
    } else if(estado == 3) {
        $("#referencia").val('AUTORIZACION DE PAGO DE VIATICOS DE COMISION QUE SUPERA LOS SEIS DIAS HABILES Y CONTINUOS DE TRABAJO, EN FAVOR DE '+nombre_destinatario_memo+', '+cargo_destinatario_memo);
    } else if(estado == 4) {
        $("#referencia").val('AUTORIZACION DE PAGO DE VIATICOS EN "FIN DE SEMANA" O "FERIADO" POR RAZONES DE ITINERARIO, EN FAVOR DE '+nombre_destinatario_memo+', '+cargo_destinatario_memo);
    }
    else{
        $("#referencia").val('');
    };

    html = comision_viaje(codigo_memo,fecha_memo,nombre_destinatario_memo,cargo_destinatario_memo,estado,cargo_remitente_memo,nombre_remitente_memo,destino_memo,objetivo_memo,fi_memo,ff_memo);
    tinyMCE.get('descripcion').setContent(html);
    
});


function comision_viaje(codigo_memo,fecha_memo,nombre,cargo,estado,cargo_autoriza,nombre_autoriza,destino,objetivo,fi_memo,ff_memo){
    var inicio, vistos, considerando,portanto,articulo,fin;
    inicio = '<!DOCTYPE html><html><head></head><body><p style="text-align: justify;"><strong>VISTOS:</strong></p>';
    considerando = '<p style="text-align: justify;"><strong>CONSIDERANDO:</strong></p><p style="text-align: justify;">Que el Decreto Supremo No. 29894, de 7 de febrero de 2009, aprueba la Estructura Organizativa del Organo Ejecutivo del Estado Plurinacional, disponiendo en su Art&iacute;culo 118, la estructura com&uacute;n de apoyo a los Ministerios, integrada por las Direcciones y Unidades, entre ellas la Direcci&oacute;n General de Asuntos Administrativos, la cual por disposici&oacute;n del Art&iacute;culo 122 inciso e) de la citada norma, tiene la funci&oacute;n de emitir Resoluciones Administrativas para resolver asuntos de su competencia.</p><p style="text-align: justify;">Que el Decreto Supremo No. 1788, de 6 de noviembre de 2013, tiene por objeto establecer la escala de vi&aacute;ticos, categor&iacute;as y pasajes para los servidores p&uacute;blicos, acorde a la nueva estructura del Estado Plurinacional; definiendo en su Art&iacute;culo 4, la escala de vi&aacute;ticos al interior y exterior del pa&iacute;s seg&uacute;n la categor&iacute;a del servidor p&uacute;blico. Asimismo, el Art&iacute;culo 6 Par&aacute;grafo I, proh&iacute;be el pago de vi&aacute;ticos correspondientes a fin de semana o feriado, excepto cuando: las actividades p&uacute;blicas justifiquen la presencia y funci&oacute;n espec&iacute;fica de un servidor p&uacute;blico en fin de semana o feriado; por razones de itinerario que demande la presencia del servidor p&uacute;blico, previo al evento; cuando la comisi&oacute;n exceda los seis 6 d&iacute;as h&aacute;biles y continuos de trabajo; los mismos que ser&aacute;n autorizados mediante Resoluci&oacute;n expresa de la autoridad competente.</p><p style="text-align: justify;">Que el Reglamento Interno de Pasajes y Vi&aacute;ticos del Ministerio de Desarrollo Productivo y Econom&iacute;a Plural,aprobado mediante Resoluci&oacute;n Ministerial MDPyEP/DESPACHO/No. 255.2013, de 7 de noviembre de 2013,concordante con lo establecido en el Decreto Supremo No. 1788, de 6 de noviembre de 2013,establece que las causas de excepcionalidad a la prohibici&oacute;n de pago de vi&aacute;ticos de fin de semana o feriado, ser&aacute;n previamente autorizados mediante Resoluci&oacute;n Administrativa expresa.</p>';
    if(estado == 1){
    vistos = '<p style="text-align: justify;">El Memor&aacute;ndum de Comisi&oacute;n de Viaje '+codigo_memo+', de '+fecha_memo+', y todo lo que convino ver y se tuvo presente.</p>';
    considerando += '<p style="text-align: justify;">Que mediante Memor&aacute;ndum de Comisi&oacute;n de Viaje '+codigo_memo+' de '+fecha_memo+' el '+cargo_autoriza+', autoriza el viaje del señor '+nombre+', '+cargo+' a la ciudad de '+destino+' con el objetivo de '+objetivo+' los dias '+fi_memo+' al '+ff_memo+' .</p><p style="text-align: justify;">Que el referido Memor&aacute;ndum, justifica la comisi&oacute;n en fin de semana correspondiente al d&iacute;a&hellip;&hellip;&hellip;&hellip;, en este sentido de acuerdo a la normativa vigente corresponde la autorizaci&oacute;n mediante Resoluci&oacute;n Administrativa expresa.</p>';
    articulo = '<p style="text-align: justify;"><strong>ARTICULO UNICO.-</strong> Autorizar el pago de vi&aacute;ticos de fin de semana, en favor de '+nombre+', '+cargo+', correspondiente a los d&iacute;as&hellip;&hellip;.. (Fecha de los d&iacute;as de fin de semana), de conformidad a lo establecido en la normativa vigente.</p>';
    } else if(estado==2){
        vistos = '<p style="text-align: justify;">El Memor&aacute;ndum de Comisi&oacute;n de Viaje '+codigo_memo+', de '+fecha_memo+', y todo lo que convino ver y se tuvo presente.</p>';
        considerando += '<p style="text-align: justify;">Que mediante Memor&aacute;ndum de Comisi&oacute;n de Viaje '+codigo_memo+' de '+fecha_memo+' el '+cargo_autoriza+', autoriza el viaje del señor '+nombre+', '+cargo+' a la ciudad de '+destino+' con el objetivo de '+objetivo+' los dias '+fi_memo+' al '+ff_memo+' .</p><p style="text-align: justify;">Que el referido Memor&aacute;ndum, justifica la comisi&oacute;n en feriado y corresponden a los d&iacute;as &hellip;&hellip;&hellip;&hellip;, corresponde que el mismo sea autorizado mediante Resoluci&oacute;n Administrativa expresa.</p>';
        articulo = '<p style="text-align: justify;"><strong>ARTICULO UNICO.-</strong> Autorizar el pago de vi&aacute;ticos en d&iacute;a feriado, en favor de '+nombre+', '+cargo+', correspondiente a los d&iacute;as &hellip;&hellip;.. (Fecha del d&iacute;a feriado), de conformidad a lo establecido en la normativa vigente.</p>';
    }else if(estado==3){
        vistos = '<p style="text-align: justify;">El Memor&aacute;ndum de Comisi&oacute;n de Viaje '+codigo_memo+', de '+fecha_memo+', y todo lo que convino ver y se tuvo presente.</p>';
        considerando += '<p style="text-align: justify;">Que mediante Memor&aacute;ndum de Comisi&oacute;n de Viaje '+codigo_memo+' de '+fecha_memo+' el '+cargo_autoriza+', autoriza el viaje del señor '+nombre+', '+cargo+' a la ciudad de '+destino+' con el objetivo de '+objetivo+' los dias '+fi_memo+' al '+ff_memo+' .</p><p style="text-align: justify;">Que el referido Memor&aacute;ndum, justifica que los d&iacute;as de viaticos solicitados superan los seis d&iacute;as habilies y continuos de trabajo, en este entendido corresponde que el pago de viaticos por los d&iacute;as &hellip;&hellip;&hellip;&hellip;, sea autorizado mediante Resoluci&oacute;n Administrativa expresa.</p>';
        articulo = '<p style="text-align: justify;"><strong>ARTICULO UNICO.-</strong> Autorizar el pago de vi&aacute;ticos que supera los seis d&iacute;as habiles y continuos de trabajo, en favor de '+nombre+', '+cargo+', correspondiendo pagar los d&iacute;as &hellip;&hellip;.. (Fecha del d&iacute;a feriado), de conformidad a lo establecido en la normativa vigente.</p>';
    }else if(estado==4){
    vistos = '<p style="text-align: justify;">El Memor&aacute;ndum de Comisi&oacute;n de Viaje '+codigo_memo+', de '+fecha_memo+', y todo lo que convino ver y se tuvo presente.</p>';
    considerando += '<p style="text-align: justify;">Que mediante Memor&aacute;ndum de Comisi&oacute;n de Viaje '+codigo_memo+' de '+fecha_memo+' el '+cargo_autoriza+', autoriza el viaje del señor '+nombre+', '+cargo+' a la ciudad de '+destino+' con el objetivo de '+objetivo+' los dias '+fi_memo+' al '+ff_memo+' .</p><p style="text-align: justify;">Que las actividades a realizar son de caracter urgente, y demandan la presencia del servidor p&uacute;blico previo al evento; misma que corresponden a un fin de semana o feriado d&iacute;a&hellip;&hellip;&hellip;&hellip;(señalar el d&iacute;a) por razones de itinerario; en este entendido se debe autorizar el pago de viaticos mediante Resoluci&oacute;n Administrativa expresa.</p>';
    articulo = '<p style="text-align: justify;"><strong>ARTICULO UNICO.-</strong> Autorizar el pago de vi&aacute;ticos por razon de itinerario previo al evento, en favor de '+nombre+', '+cargo+', correspondiente a los d&iacute;as&hellip;&hellip;.. (Fecha), de conformidad a lo establecido en la normativa vigente.</p>';
    }    
    else{
    vistos = '<p style="text-align: justify;">El Memor&aacute;ndum de Comisi&oacute;n de Viaje ............. , de (fecha)........, y todo lo que convino ver y se tuvo presente.</p>';
    considerando += '<p style="text-align: justify;">Que mediante Memor&aacute;ndum de Comisi&oacute;n de Viaje &hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.(Descripci&oacute;n Memor&aacute;ndum).</p><p style="text-align: justify;">Que el referido Memor&aacute;ndum, justifica la comisi&oacute;n en fin de semana correspondiente al d&iacute;a&hellip;&hellip;&hellip;&hellip;, en este sentido de acuerdo a la normativa vigente corresponde la autorizaci&oacute;n mediante Resoluci&oacute;n Administrativa expresa.</p>';
    articulo = '<p style="text-align: justify;"><strong>ARTICULO UNICO.-</strong> Autorizar el pago de vi&aacute;ticos de fin de semana, en favor de&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;..(nombre del servidor p&uacute;blico),&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;.. (Cargo del servidor p&uacute;blico), correspondiente a los d&iacute;as&hellip;&hellip;.. (Fecha de los d&iacute;as de fin de semana), de conformidad a lo establecido en la normativa vigente.</p>';
    }
    portanto = '<p style="text-align: justify;"><strong>POR TANTO:</strong></p><p style="text-align: justify;">El Director General de Asuntos Administrativos del Ministerio de Desarrollo Productivo y Econom&iacute;a Plural, en ejercicio de sus funciones conferidas por ley;</p><p style="text-align: justify;"><strong>RESUELVE:</strong></p>';
    fin = '<p style="text-align: justify;">Reg&iacute;strese, comun&iacute;quese, c&uacute;mplase y arch&iacute;vese.</p></body></html>';
    return (inicio+vistos+considerando+portanto+articulo+fin);
    
}


$('#proceso').change(function(){
    if($('#proceso').val()==18 && $('#id_tipo').val()=='3' && $('#doc_memo').val()=='1') {
            $('#contenido1').hide();
            $('#contenido3').show();
            $('#referencia').text('INFORME DE VIAJE');
            $('#sw_contenido').val(1);
        } else {
            $('#contenido1').show();
            $('#contenido3').hide();
            $('#referencia').text('');
            $('#sw_contenido').val(0);
        }  
});

function calculo_feriados(){
            $("#observacion").removeAttr("class");
            var fecha_s = $("#fecha_inicio").val();
            fecha_s = fecha_s.substring(fecha_s.length-10,fecha_s.length);
            var fecha_a = $("#fecha_fin").val();
            fecha_a = fecha_a.substring(fecha_a.length-10,fecha_a.length);
            
            //validamos fin de semana
            var sw = 0;
            var f1= new Date(fecha_s);
            var f2= new Date(fecha_a);
            while (f1<=f2){
                //alert(f1.getUTCDay());
                if(f1.getUTCDay()==6 || f1.getUTCDay()==0){
                    $("#observacion").attr("class", "required");
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
                                        $("#observacion").attr("class", "required");
                                    }
                                    else{
                                         $("#observacion").removeAttr("class");
                                    }
                           }
                        });
                
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
                dayNamesShort: ['domingo','lunes','martes','miércoles','jueves','viernes','sábado'],
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
var pickerOpts  = { changeMonth: true, minDate: 0, changeYear: true, yearRange: "-10:+1", dateFormat: 'D yy-mm-dd',onSelect: function(){ calculo_feriados();}};
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


$('#proceso').change(function(){
        //alert(this.value);
        if (this.value==18) {
            $('#referencia').val('INFORME DE VIAJE');
            $('descripcion').val('<!DOCTYPE html><html><head></head><body><p>De mi consideracion:</p></body></html>');
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
        case 1: return 'lunes'; break;
        case 2: return 'martes'; break;
        case 3: return 'miércoles'; break;
        case 4: return 'jueves'; break;
        case 5: return 'viernes'; break;
        case 6: return 'sábado'; break;
        case 0: return 'domingo'; break;
    }
}

function fecha_literal($fecha) {
    $mes=array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
    $num_mes = date('n',strtotime($fecha));
    $f=date('d',strtotime($fecha)).' de '.$mes[$num_mes-1].' de '.date('Y',strtotime($fecha));
    return $f;
    
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

if($tipo->id==3 && strlen($documento->contenido)<70 && $doc_memo->fucov==1){
//if($tipo->id==3 && $doc_memo->fucov==1){    
$fi = date('Y-m-d', strtotime($pvcomision_memo->fecha_inicio));
$ff = date('Y-m-d',  strtotime($pvcomision_memo->fecha_fin));
$diai=  dia_literal(date("w", strtotime($fi)));
$diaf=  dia_literal(date("w", strtotime($ff)));


$contenido_ra = '
<!DOCTYPE html>
<html>
<head>
</head>
<body>
<p style="text-align: justify;">De mi consideraci&oacute;n:</p>
<p style="text-align: justify;">En atenci&oacute;n a memorandum N&deg; '.$doc_memo->codigo.' elevo a su autoridad el presente informe administrativo de descargo del viaje realizado a la ciudad de '.$pvcomision_memo->destino.' desde el '.$diai.' '.$fi.' hasta el '.$diaf.' '.$ff.', correspondiendo informar lo siguiente:</p>
<p style="text-align: justify;"><strong>I.&nbsp;&nbsp;&nbsp; OBJETIVO DEL VIAJE</strong></p>
<p style="text-align: justify;"><strong>II.&nbsp; DESARROLLO</strong></p>
<p style="text-align: justify;"><strong>III. CONCLUSI&Oacute;N</strong></p>
<p style="text-align: justify;"><strong>IV.&nbsp; RECOMENDACIONES U OBSERVACIONES </strong>(<em>SI CORRESPONDE</em>)</p>
</body>
</html>
';
}


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
                <?php if ($documento->anulado == 0): ?> 
                <?php if ($documento->estado == 1): ?> 
                    <a href="/seguimiento/?nur=<?php echo $documento->nur; ?>" class="link derivar" title="Ver seguimiento" >Derivado</a>      
                <?php else: ?>
                    <a href="/hojaruta/derivar/?id_doc=<?php echo $documento->id; ?>" class="link derivar" title="Derivar a partir del documento, si ya esta derivado muestra el seguimiento" >Derivar</a>      
                <?php endif; ?>
                <a href="/documento/anular/?id_doc=<?php echo $documento->id; ?>" class="link anulado" title="Anular Documento" >Anular</a>      
                <?php else: ?>
                    <a href="/documento/habilitar/?id_doc=<?php echo $documento->id; ?>" class="link habilitar" title="Habilitara el Documento anulado" >Habilitar</a>      
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
                    <fieldset> <legend>Proceso: <?php echo Form::select('proceso', $options, $documento->id_proceso,array('id'=>'proceso')); ?>
                            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                            <?php if ($documento->id_tipo == '2'){?>FOCOV: <?php echo Form::checkbox('fucov',1,FALSE,array('id'=>'fucov','name'=>'fucov','title'=>'seleccione si quiere habilitar un memoramdum de viaje',$checked))?><?php }?>    
                            <?php if ($tipo->id == '11'){?>
                            Comisión de Viaje:   <select id="comision" name='comision'>
                                            <option value=''>(Seleccionar...)</option>
                                            <option value='1'>Fin de Semana</option>
                                            <option value='2'>Feriado</option>
                                            <option value='3'>Mayor a 6 dias</option>
                                            <option value='4'>Cambio de Itinerario</option>
                                        </select>
                                        <?php }?>    
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
                        <?php echo Form::hidden('sw_contenido', '',array('id'=>'sw_contenido')); ?>
                        <?php echo Form::hidden('id_tipo', $tipo->id,array('id'=>'id_tipo')); ?>
                        <?php echo Form::hidden('doc_memo', $doc_memo->fucov,array('id'=>'doc_memo')); ?>
                        <?php echo Form::hidden('codigo_memo', $doc_memo->codigo,array('id'=>'codigo_memo')); ?>
                        <?php echo Form::hidden('fecha_memo', fecha_literal($doc_memo->fecha_creacion),array('id'=>'fecha_memo')); ?>
                        <?php echo Form::hidden('nombre_destinatario_memo', $doc_memo->nombre_destinatario,array('id'=>'nombre_destinatario_memo')); ?>
                        <?php echo Form::hidden('cargo_destinatario_memo', $doc_memo->cargo_destinatario,array('id'=>'cargo_destinatario_memo')); ?>
                        <?php echo Form::hidden('nombre_remitente_memo', $doc_memo->nombre_destinatario,array('id'=>'nombre_remitente_memo')); ?>
                        <?php echo Form::hidden('cargo_remitente_memo', $doc_memo->cargo_remitente,array('id'=>'cargo_remitente_memo')); ?>
                        <?php echo Form::hidden('destino_memo', $pvcomision_memo->destino,array('id'=>'destino_memo')); ?>
                        <?php echo Form::hidden('objetivo_memo', $pvcomision_memo->detalle_comision,array('id'=>'objetivo_memo')); ?>
                        <?php echo Form::hidden('fecha_inicio_memo', fecha_literal($pvcomision_memo->fecha_inicio),array('id'=>'fecha_inicio_memo')); ?>
                        <?php echo Form::hidden('fecha_fin_memo', fecha_literal($pvcomision_memo->fecha_fin),array('id'=>'fecha_fin_memo')); ?>


                        
                        <?php echo Form::label('contenido', 'Contenido:', array('id' => 'label_contenido', 'class' => 'form')); ?> 
                        <div id='contenido1'>
                            <p>
                            <?php
                            echo Form::textarea('descripcion', $documento->contenido, array('id' => 'descripcion', 'cols' => 50, 'rows' => 20));
                            ?>
                            </p>
                            
                        </div>
                        
                        
                        <div id='contenido2' style="width: 780px;">
                            <br>
                            <p>De mi consideración:</p>
                            <p align='justify;'>A través del presente memorándum, se comisiona a su persona realizar el viaje desde la <br>
                            ciudad (origen)
                            <?php echo Form::input('origen', $origen, array('id' => 'origen')); ?> 
                            hasta la ciudad (destino)
                            <?php echo Form::input('destino', $destino, array('id' => 'destino')); ?></p>
                            desde el 
                            <input type="text" id="fecha_inicio" name="fecha_inicio" size='16' value="<?php echo $diai.' '.$fi;?>"/> a Hrs. <input type="text" name="hora_inicio" id="hora_inicio" value="<?php echo $hi; ?>" size='6'/>
                            hasta el
                            <input type="text" id="fecha_fin" name="fecha_fin" size='16' value="<?php echo $diaf.' '.$ff?>"/> a Hrs. <input type="text" id="hora_fin" name="hora_fin" value="<?php echo $hf; ?>" size='6'/><br>
                            <p>con el objetivo de (describir en detalle actividades a realizarse)</p>
                            <p>
                                <textarea name="detalle_comision" id="detalle_comision" style="width: 775px;" ><?php echo $detalle_comision; ?></textarea>
                            </p>
                            
                            <p style="text-align: justify;">En este sentido, sírvase tramitar ante la instancia administrativa pertinente las gestiones correspondientes para tal efecto.</p>
                            <?php echo Form::label('observacion', 'Justificación Fin de Semana o Feriado:', array('id' => 'label_observacion', 'class' => 'form')); ?> 
                            <textarea name="observacion" id="observacion" style="width: 775px;" minlength='20'><?php echo $obs; ?></textarea>
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