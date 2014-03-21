<?php
defined('SYSPATH') or die ('no tiene acceso');
//descripcion del modelo productos
class Model_Pvoestrategicos extends ORM{
    protected $_table_names_plural = false;
    
    public function objetivosestrategico(){
        $sql = "select og.id, og.codigo, og.objetivo
                from pvoestrategicos og 
                where og.estado = 1";
        //return DB::query(1, $sql)->execute();
        return $this->_db->query(Database::SELECT, $sql, TRUE);    
    }
}
?>