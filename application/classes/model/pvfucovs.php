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

   public function tramos($id)
   {
   	$sql = "select d.*,p.tipoviaje,IF(d.ida_vuelta = '0', 'No', 'Si') as ida_vuelta1 from pvfucovs d, pvtipoviajes p where d.id_documento = $id AND d.id_tipoviaje = p.id ORDER BY d.id ASC";
   	return db::query(Database::SELECT, $sql)->execute();
   }
}
?>