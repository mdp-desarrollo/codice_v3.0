<script type="text/javascript">
$(function(){      
    $('#cancelar').click(function(){
        $('#replace').show();
        $('#file-word').hide();       
    });
    $('.autorizar').live('click', function() {
        var answer = confirm("Esta seguro de Aprobar el Informe de viaje? ");
        if (answer)
            return true;
        return false;
    });
});
</script>
<style>
#file-word{ display: none;  }
td{padding:5px;}    
</style>

<div  style="width: 800px;   border: 1px solid #eee; height: 800px;">
    <table style=" width: 100%;" border ="0">
        <tbody>
            <tr>
                <td colspan="2" align="center">
                    <h2><?php echo strtoupper($tipo->tipo)?></h2>
                    <h2 style="color: #23599B;"><?php echo $d->cite_original;?></h2>
                    <h2><?php echo $d->nur;?></h2>
                </td>
            </tr>
            <tr>
                <td><b>A: </b></td>
                <td colspan="2"> <?php echo $d->nombre_destinatario;?><br/><b><?php echo $d->cargo_destinatario;?></b></td>
            </tr>
            <?php if(trim($d->nombre_via)!=''){ ?>
            <tr> 
                <td><b>VIA: </b><br/> </td>
                <td colspan="2"><?php echo $d->nombre_via;?><br/><b><?php echo $d->cargo_via;?></b></td>
            </tr>
            <?php } ?>
            <tr> 
                <td><b>DE: </b><br/> </td>
                <td><?php echo $d->nombre_remitente;?><br/><b><?php echo $d->cargo_remitente;?></b></td>
            </tr>
            <tr>
                <td width="100"><b>FECHA DE CREACI&Oacute;N: </b><br/> </td>
                <td colspan="2"><?php echo  Date::fecha($d->fecha_creacion);?></td>
            </tr>
            <?php /* foreach($archivo as $a): ?>
            <tr> 
                <td><b>ARCHIVO:</b><br/></td>
                <td><?php echo HTML::anchor('/descargar.php?id='.$a->id,substr($a->nombre_archivo,13));?><br/></td>
            </tr>
                    <?php endforeach;*/?>
            <tr>
                <td><b>REFERENCIA:</b><br/> </td>
                <td colspan="2"><?php echo $d->referencia;?></td>
            </tr>
            <tr>
                <td colspan="3">
                    <div style="overflow:auto; width: 670px;">
                    <?php echo $d->contenido;?>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <hr />
    <br />
    <b>D&iacute;as desde el retorno del viaje: </b><?php if($descargo->dias <0) echo "A&uacute;n no retorna"; else echo $descargo->dias?>
    <hr />
    <br />
    <center>
    <a href="../../pdf/<?php echo strtolower($tipo->tipo)?>.php?id=<?php echo $d->id; ?>" class="link pdf" target="_blank" title="Imprimir informe" >Imprimir Informe</a>&nbsp;&nbsp;&nbsp;
    <?php if($memo->auto_informe == 0):?>
        <a href="/pvpasajes/aprobarinforme/<?php echo $memo->id; ?>" class="autorizar"  title="Aprobar" ><img src="/media/images/tick.png"/>Aprobar Informe</a>
    <?php else:?>
        <a href="/hojaruta/derivar/?id_doc=<?php echo $memo->id; ?>" class="link derivar" title="Derivar a partir del documento, si ya esta derivado muestra el seguimiento" >Derivar</a>
    <?php endif;?>
    </center>
        <br />
</div>