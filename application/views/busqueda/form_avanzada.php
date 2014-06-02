<script type="text/javascript">
    $(function(){
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
            dayNamesShort: ['Dom','Lun','Mar','Mi&eacute;','Juv','Vie','S&aacute;b'],
            dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
            weekHeader: 'Sm',
            dateFormat: 'dd/mm/yy',
            firstDay: 1,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ''};
        $.datepicker.setDefaults($.datepicker.regional['es']); 
        var pickerOpts = {
        changeMonth: true,
        changeYear: true,
        yearRange: "-10:+1",
        dateFormat:"yy-mm-dd"
        };
      $("#fecha1,#fecha2").datepicker(pickerOpts,$.datepicker.regional['es']);        
      $('#hoy').click(function(){
            var f = new Date();
            var mes=(f.getMonth() +1);
            if(mes<10)
                mes='0'+mes;
            var dia=f.getDate();
            if(dia<10)
                dia='0'+dia;
            var fecha=f.getFullYear() + "-" + mes  + "-" + dia; 
            $("#fecha1,#fecha2").val(fecha);
      });
    });
</script>

<script type="text/javascript">
 $(function(){
     $('#buscar').click(function(){
        var errors='';
        var l=$('input[type=checkbox]:checked').length;
        var texto=$('#texto').val();
        if(l==0)
          {
                errors+="Debe de elegir un campo.\n";                
          }
        if($.trim(texto)=='')
          {
                errors+="Escriba texto por favor";
          }
        if((l==0)||($.trim(texto)==''))
          {
              alert(errors);
            return false;        
          }
        else{
            return true;
        }
     })
     $('#texto').focus();   
 });
</script>
<h2 class="subtitulo">Formulario de Busqueda <br/><span>realizar busqueda en la base de datos</span></h2>
<?php ?>
<?php if(sizeof($mensajes)>0):?>
    <div class="message">
        <?php foreach($mensajes as $k=>$v):?>
        <p><span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-info"></span>
        <b><?php echo $k;?></b> <?php echo $v;?></p>
        <?php endforeach;?>
    </div>
<?php endif;?>


<div style="width: 550px; margin: 0 auto; border: 1px dotted #063765; padding: 40px; background: #EFF4FB;" >
    
<form action="" method="get">
    <table style="width: 100%;" >
        <tbody>
            <tr>                
                <td colspan="5"><input type="text" id="texto" name="texto"  value="<?php echo Arr::get($_GET,'texto','') ?>" style="line-height: 25px; height: 35px; padding: 5px;  font-size: 14px; width: 450px; " class="curved" /></td>                
                <td><input type="submit" name="buscar" id="buscar" value="Buscar" class="uibutton" style="line-height: 25px; height: 30px;" /></td>
            </tr>
            <tr>
                <td colspan="5"><br/></td>
            </tr>
            <tr>                
                <td><input type="checkbox" name="campo[]" value="nur" /><span class="sp"> Hoja de ruta </span></td>
                <td> | <input type="checkbox" name="campo[]" value="cite_original" /><span class="sp"> Cite documento </span></td>
                <td> | <input type="checkbox" name="campo[]" value="nombre_destinatario"  /><span class="sp"> Destinatario </span></td>
                <td> | <input type="checkbox" name="campo[]" value="nombre_remitente" /><span class="sp"> Remitente </span></td>
                <td> | <input type="checkbox" name="campo[]" value="referencia" checked="checked" /><span class="sp"> Referencia </span></td>                
            </tr>
            <tr>
                <td colspan="5"><br/></td>
            </tr>
            <tr>                
                <td colspan="2"><span class="sp"> De Fecha: </span><input type="text" name="fecha1" value="<?php echo date("Y-m-d");?>" id="fecha1"/></td>
                <td colspan="3"><span class="sp"> A Fecha: </span><input type="text" name="fecha2" value="<?php echo date("Y-m-d");?>" id="fecha2"/></td>
            </tr>
        </tbody>
    </table>
</form>
</div>
