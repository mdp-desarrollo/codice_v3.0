<?php
defined('SYSPATH') or die ('no tiene acceso');
//descripcion del modelo poatipocontrataciones
class Model_Poatipocontrataciones extends ORM{
    protected $_table_names_plural = false;
    protected $_sorting=array('id'=>'ASC');
    
    protected $_has_many=array(
        'poas'=>array(
            'model'=>'poas',
            'foreign_key' => 'id__tipocontratacion',
        ),
    );
}
?>
