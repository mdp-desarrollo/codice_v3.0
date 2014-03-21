<script type="text/javascript">
    $(function(){
        $('table.classy tbody tr:odd').addClass('odd'); 
    });
</script>
<h2 class="subtitulo">Reporte de Registro de Boletos<br/><span>Boletos Registrados DE FECHA <b><?php echo date('d/m/Y',strtotime($fecha1));?></b> al  <b><?php echo date('d/m/Y',strtotime($fecha2));?></b> </span></h2>
<table class="classy">
    <thead>
        <tr>
            <th>#</th>
            <th>HOJA RUTA</th>
            <th>CODIGO</th>
            <th>IDA y VUELTA</th>
            <th>ORIGEN</th>
            <th>DESTINO</th>            
            <th>FECHA Y HORA SALIDA</th>
            <th>FECHA Y HORA ARRIBO</th>
            <th>TRANSPORTE</th>
            <th>N° BOLETO</th> 
            <th>COSTO</th>
            <th>EMPRESA</th>
        </tr>
    </thead>
    <tbody>
        <?php $i=1; foreach($results as $r):?>

        <tr>
            <td></td>
            <td><a href="/seguimiento/?nur=<?php echo $r->nur;?>"><?php echo $r->nur;?></a></td>
            <td><?php echo $r->codigo;?></td>
            <td><?php if ($r->ida_vuelta==1) { echo 'SI';} else { echo 'NO';}?></td>
            <td><?php echo $r->origen;?></td>
            <td><?php echo $r->destino;?></td>
            <td><?php echo $r->fecha_salida;?></td>
            <td><?php echo $r->fecha_arribo;?></td>
            <td><?php echo $r->transporte;?></td>
            <td><?php echo $r->nro_boleto;?></td>
            <td><?php echo $r->costo;?></td>
            <td><?php echo $r->empresa;?></td>
        </tr>
        <?php $i++; endforeach;?>        
    </tbody>
</table>
