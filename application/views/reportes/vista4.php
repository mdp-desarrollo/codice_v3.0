<script type="text/javascript">
    $(function(){
        $('table.classy tbody tr:odd').addClass('odd'); 
        $("#imprime").click(function(){
            window.print();
            return false;
        });
    });
</script>
<h2 class="subtitulo">Correspondencia Creada : <?php echo $tipo->plural;?>  <b><?php echo $oficina;?></b><br/><span>DE FECHA <b><?php echo date('d/m/Y',strtotime($fecha1));?></b> al  <b><?php echo date('d/m/Y',strtotime($fecha2));?></b>  </span></h2>
<p style="float: right;"><a href="javascript:void(0)" id="imprime" class="uibutton"><img src="/media/images/excel.png" align="absmiddle" alt=""/>Imprimir</a></p><br/></p><br/>
<table class="classy">
    <thead>
        <tr>
            <th>#</th>
            <th>HOJA RUTA</th>
            <th>documento</th>
            <th>TIPO</th>
            <th>REMITENTE</th> 
            <th>DESTINATARIO</th> 
            <th>REFERENCIA</th>
            <th>FECHA CREACION</th>
            <th>ESTADO</th>            
            
                       
        </tr>
    </thead>
    <tbody>
        <?php $i=1; foreach($results as $r):?>
        <tr>
            <td><?php echo $i;?></td>
            <?php if($r['anulado']==0):  $anulado='Activo';  ?>
                <td><a href="/seguimiento/?nur=<?php echo $r['nur'];?>"><?php echo $r['nur'];?></a></td>
              <?php else:  $anulado='Anulado';?>
                <td><a href="#" class='anular<?php echo $r['anulado'];?>'><?php echo $r['nur'];?></a></td>            
              <?php endif;?>  
            <td><?php echo $r['codigo'];?></td>            
            <td><?php echo $r['tipo'];?></td>            
            <td><?php echo $r['nombre_remitente'];?></br><b><?php echo $r['cargo_remitente'];?></b></td>            
            <td><?php echo $r['nombre_destinatario'];?></br><b><?php echo $r['cargo_destinatario'];?></b></td>            
            <td><?php echo $r['referencia'];?></td>
            <td><?php echo $r['fecha_creacion'];?></td>
            <td><?php echo $anulado;?></td>
        </tr>
        <?php $i++; endforeach;?>
        
    </tbody>
</table>
