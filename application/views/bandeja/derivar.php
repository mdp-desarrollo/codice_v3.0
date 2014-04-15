<script type="text/javascript">
    $(function(){
        $('table.classy tbody tr:odd').addClass('odd'); 
    });
</script>
<form method="post" action="/bandeja/derivarf" id="frmDerivar"> 
<table class="classy">
    <thead>
        <tr>
            <th>#</th>
            <th>NUR</th>
            <th>Referencia</th>
        </tr>
    </thead>
    <tbody>
<?php foreach($nurs as $k=>$v): ?>
        <tr>
            <td width="150" align="center" valign="top" class="nurd<?php echo $v[2]; ?>">
            <!-- <img src="/media/images/oficial.gif" width="50" height="50"> -->
            </td>
            <td><?php echo $v[0];?></td>
            <td><?php echo $v[1];?></td>
        </tr>
        <input type="hidden" value="<?php echo $k;?>" name="id_seg[]"/>
        <input type="hidden" value="<?php echo $v[0];?>" name="nur[]"/>
        <input type="hidden" value="<?php echo $v[2];?>" name="oficial[]"/>
        <input type="hidden" value="<?php echo $v[3];?>" name="hijo[]"/>
        <input type="hidden" value="<?php echo $v[4];?>" name="id_doc[]"/>
<?php endforeach;?>

        
    </tbody>
</table>
<br>
<table>
<tr>
<td>
    
    <?php if(sizeof($destinatario)>0){?>
    <div id="lista">
    <hr/><br>  
    Derivar a:
     <?php  echo Form::select('destino', $destinatario); ?>
     <br>
     Accion:&nbsp;&nbsp;&nbsp;&nbsp;
     <?php  echo Form::select('accion', $accion); ?>
     <br>
     Proveido:
     <textarea name="proveido" style="width:500px;" ROWS="2"></textarea>
     <br/>
    </div>
    <?php } ?>
   
</td>
</tr>
<tr>
    <td style="float: left; padding-left: 10px; ">
    <?php  echo Form::input('submit', 'Derivar',array('type'=>'submit','class'=>'uiButton','id'=>'btnLista')); ?> 
    </td>    
</tr>
</table>
</form>