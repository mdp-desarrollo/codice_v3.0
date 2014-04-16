 <div class="inner-border">
  <div id="perfil">
  <span class="negro"><?php echo $titulo;?></span>
  </div>
 </div>
 <ul class="menu-correo">     
    <?php foreach($smenus as $s): ?>        
    <li><?php echo HTML::anchor($s->controlador.'/'.$s->accion,$s->submenu,array('title'=>$s->descripcion));?></li>
    <?php endforeach;?>    
</ul>
<!-- <div id="opciones" class="oculto archive">
            <ul>
                <li>
                <a href="#" id="derivar" ><img src="/media/images/derivar.png" align="absmiddle"   /> Derivar</a>         
                </li>
            </ul>
            <div id="seleciones" ></div>
</div> -->
