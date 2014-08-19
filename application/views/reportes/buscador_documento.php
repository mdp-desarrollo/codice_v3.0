<script type="text/javascript">   

$(function(){


$('#frmEditar').validate();

        $('#btnword').click(function(){
            $('#word').val(1);
            return true

        });
        $('#save').click(function(){
            $('#frmEditar').submit();
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

    });
</script>
<h2 class="subtitulo">Generar reporte Documentos Creados por Usuario<br/><span>Elija las opciones</span></h2>
<form action="" method="get" id="frmEditar" name="frmEditar">
    <table>
        <tr>
            <td>Entidad: </td>
            <td colspan="3">
               <?php echo Form::select('id_entidad',$sel_entidad,$id_entidad, array('id' => 'id_entidad', 'class' => 'required'));?>
           </td>
       </tr>
       <tr>
        <td>Hoja de Ruta: </td>
        <td colspan="3">
            <?php echo Form::input('nur','',array('id' => 'nur', 'size'=>'80'));?>
        </td>
    </tr>
    <tr>
        <td>Cite: </td>
        <td colspan="3">
           <?php echo Form::input('codigo','',array('id'=>'codigo', 'size'=>'80')) ?>
       </td>
   </tr>
   <tr>
        <td>Remitente: </td>
        <td colspan="3">
           <?php echo Form::input('remitente','',array('id'=>'remitente', 'size'=>'80')) ?>
       </td>
   </tr>
   <tr>
        <td>Cargo Remitente: </td>
        <td colspan="3">
           <?php echo Form::input('cargo_remitente','',array('id'=>'cargo_remitente', 'size'=>'80')) ?>
       </td>
   </tr>
   <tr>
        <td>Destinatario: </td>
        <td colspan="3">
           <?php echo Form::input('destinatario','',array('id'=>'destinatario', 'size'=>'80')) ?>
       </td>
   </tr>
   <tr>
        <td>Cargo Destinatario: </td>
        <td colspan="3">
           <?php echo Form::input('cargo_destinatario','',array('id'=>'cargo_destinatario', 'size'=>'80')) ?>
       </td>
   </tr>
   <tr>
        <td>Referencia: </td>
        <td colspan="3">
           <?php echo Form::input('referencia','',array('id'=>'referencia', 'size'=>'80')) ?>
       </td>
   </tr>
   <tr>
            <td>De fecha:</td>
            <?php 
            $fecha = new DateTime();
            $fecha->modify('first day of this month');
            ?>
            <td><input type="text" name="fecha1" id="fecha1" value="<?php echo $fecha->format('Y-m-d');?>" /></td>
            <td>A fecha:</td>
            <td><input type="text" name="fecha2" id="fecha2" value="<?php echo date('Y-m-d');?>" /></td>
        </tr>
   <tr>
    <td></td>
    <td colspan="5">
        <hr/><br/>
        <input type="submit" name="submit" value="Realizar Busqueda"/>
    </td>
</tr>
</table>
</form>