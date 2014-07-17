<script type="text/javascript">
   //  $(function(){
   //      $('#boton').click(function()
   //      {            
   //          var hs=$('#nur').val().replace(/^\s+|\s+$/g, "");;            
   //          if(hs=="")
   //          {
   //              alert('Escriba la hoja de ruta por favor');                
   //          }
   //          else
   //          { 
   //          $.ajax({
	  //           type: "POST",
	  //           data: { nur : hs },
	  //           url: "/ajax/print_hs",
	  //           dataType: "json",
	  //           success: function(data)
	  //           {                    
   //                      if(data.nur>0)
   //                      {
   //                           window.location.href='/print_hr.php?nur='+hs;
   //                      }    
   //                      else
   //                      {
   //                          alert('La hoja de ruta '+hs+' no existe');
   //                      }                        
	  //           }
   //                  });                                    
   //          }   
   //          return false;
   //      });
   //      $('#nur').focus();
   // }); 
</script>

<script type="text/javascript">
    $(function(){
        $('table.classy tbody tr:odd').addClass('odd'); 
        $("#imprime").click(function(){
            window.print();
            return false;
        });
    });
</script>

<h2 class="subtitulo">Imprimir hoja de ruta<br/><span>a continuaci&oacute;n escriba la hoja de ruta y presione imprimir</span></h2>
<style type="text/css">
    #nur{ line-height: 25px; font-size: 18px; height: 30px; font-weight: bold;   }
    #boton{ line-height: 25px;height: 35px;    }
</style>
<form action="" method="post" >
<?php echo Form::input('nur', Arr::get($_POST,'nur',''), array('id'=>'nur'))?>
<input type="submit" name="submit" value="Buscar" class="uibutton" />
<?php // echo Form::input('boton','Buscar',array('type'=>'submit','id'=>'boton'));?>
</form>

<?php 
if ($msm!=''){
    echo $msm;
} else { ?>
<table class="classy" style="width:20%">
    <thead>
        <tr>
            <th>#</th>
            <th>HOJA RUTA</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php $i=1; foreach($documento as $r):?>
        <tr>
            <td><?php echo $i;?></td>
            <td><?php echo $r->nur;?></td>
            <td><a href="/print_hr.php?nur=<?php echo $r->nur;?>&sw=1" target='_blank'>Imprimir</a></td>            
        </tr>
        <?php $i++; endforeach;?>
        
    </tbody>
</table>
<?php } ?>



