<?php
defined('SYSPATH') or die ('no tiene acceso');
//descripcion del modelo productos
class Model_Pvfucovs extends ORM{
    protected $_table_names_plural = false;
    protected $_sorting = array('id' => 'asc');
    
   public function sqlconsulta($sql)
   {
           return db::query(Database::SELECT, $sql)->execute();
           
   }
}
?>