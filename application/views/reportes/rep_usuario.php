<script type="text/javascript">   

    $(function(){
        $('#id_oficina').change(function(){
            var id_oficina = $('#id_oficina').val();
//            alert(id_oficina);
$('#id_user').html('');
$.ajax({
    type: "POST",
    data: { id_oficina: id_oficina},
    url: "/ajax/ofiuser",
    dataType: "json",
    success: function(item)
    {

            //$('#id_user').val(item);
            $('#id_user').html(item);    
        },
        error: $('#id_user').html('')
    });

});

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
<h2 class="subtitulo">Generar reporte<br/><span>Elija las opciones</span></h2>
<form action="" method="post" id="frmEditar" name="frmEditar">
    <table>
        <tr>
            <td>Oficina: </td>
            <td colspan="3">
               <?php echo Form::select('id_oficina',$sel_ofi,'', array('id' => 'id_oficina', 'class' => 'required'));?>
           </td>
       </tr>
       <tr>
        <td>Usuario: </td>
        <td colspan="3">
            <?php echo Form::select('id_user',$sel_user,'', array('id' => 'id_user', 'class' => 'required'));?>
        </td>
    </tr>
    <tr>
        <td>Estado: </td>
        <td colspan="3">
           <?php echo Form::select('estado',$sel_estado);?>
       </td>
   </tr>
   <tr>
            <td>De fecha:</td>
            <td><input type="text" name="fecha1" id="fecha1" value="<?php echo date('Y-m-d');?>" /></td>
            <td>A fecha:</td>
            <td><input type="text" name="fecha2" id="fecha2" value="<?php echo date('Y-m-d');?>" /></td>
        </tr>
   <tr>
    <td></td>
    <td colspan="3">
        <hr/><br/>
        <input type="submit" name="submit" value="Generar Reporte"/>
    </td>
</tr>
</table>

</form>