<script type="text/javascript">

$(function(){
    $('#frmCreate').validate();
    $("#codigo").focus();
});
</script>
<style>
    #file-word{ display: none;  }
    td{padding:5px;}    
</style>
<div style="width: 800px;"><h2 class="subtitulo">ADICIONAR OBJETIVO ESPECIFICO<br/><span>Llene correctamente los datos en el formulario</span></h2>
<table border="0">
    <tr>
        <td style="width: 20%;"><b>Entidad:</b></td>
        <td><?php echo $entidad->entidad;?></td>
    </tr>
    <tr>
        <td><b>Unidad Ejecutora:</b></td>
        <td><?php echo $oficina->oficina;?></td>
    </tr>
    <tr>
        <td><b>Objetivo de Gestion : </b><?PHP echo $ogestion->codigo?></td>
        <td><?php echo $ogestion->objetivo;?></td>
    </tr>
</table>
                <?php if (sizeof($mensajes) > 0): ?>
                    <div class="info">
                        <p><span style="float: left; margin-right: .3em;" class="ui-icon-info"></span>
                            <?php foreach ($mensajes as $k => $v): ?>
                                <strong><?= $k ?>: </strong> <?php echo $v; ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?> 
</div>
<br />
<div class="formulario">
<form action="/pvplanificacion/addobjespecifico/<?php echo $ogestion->id;?>" method="post" id="frmCreate">

<table>
    <tr>
        <td><?php echo Form::label('codigo','Codigo')?></td>
        <td><?php echo Form::input('codigo',$ogestion->codigo.'.',array('name'=>'codigo','id'=>'codigo','class'=>'required')) ?></td>
    </tr>
    <tr>
        <td><?php echo Form::label('objetivo','Objetivo Especifico')?></td>
        <td><textarea id="objetivo" name="objetivo" class="required" rows="10"></textarea></td>
    </tr>
</table>

<input type="submit" value="Adicionar" class="uibutton" name="submit" id="crear" title="Adicionar Objetivo Especific."  />
</form>
<div class="info" style="text-align:center;margin-top: 20px;">
    <p><span style="float: left; margin-right: .3em;" class=""></span>    
      &larr;<a href="/pvplanificacion/objetivoespecifico/<?php echo $ogestion->id;?>" class="uibutton" title="Regresar" >Regresar</a></p>    
</div>
</div>