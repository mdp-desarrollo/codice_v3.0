<?php
defined('SYSPATH') or die ('no tiene acceso');
//descripcion del modelo poas
class Model_Poas extends ORM{
    protected $_table_names_plural = false;
    protected $_sorting=array('id'=>'ASC');
    
	protected $_belogn_to=array(
        'pvogestiones'=>array(
            'model'=>'pvogestiones',
            'foreign_key'=>'id_obj_gestion'
        ),
        'pvoespecificos'=>array(
            'model'=>'pvoespecificos',
            'foreign_key'=>'id_obj_esp'
        ),
        'pvactividades'=>array(
            'model'=>'pvactividades',
            'foreign_key'=>'id_actividad'
        ),
        'documentos'=>array(
            'model'=>'documentos',
            'foreign_key'=>'id_documento'
        ),
        'poatipocontrataciones'=>array(
            'model'=>'poatipocontrataciones',
            'foreign_key'=>'id_tipocontratacion'
        )
    );

    public function listaautorizados($id_user, $id_entidad){
        $sql = "select doc.id, doc.codigo, doc.nur, doc.nombre_remitente nombre, doc.cargo_remitente cargo, doc.fecha_creacion
                ,poa.fecha_aprobacion, ofi.oficina
                from documentos doc 
                inner join poas poa on doc.id = poa.id_documento
                inner join oficinas ofi on doc.id_oficina = ofi.id
                where doc.id_entidad = $id_entidad
                and doc.id_tipo = 14
                and poa.auto_poa = 1";
        return $this->_db->query(Database::SELECT, $sql, TRUE);    
    }
    
       public function avanzada($id_user,$id_entidad, $nombre, $oficina, $f1, $f2){
        $sql = "select doc.id, doc.codigo, doc.nur, doc.nombre_remitente nombre, doc.cargo_remitente cargo, doc.fecha_creacion
                ,poa.fecha_aprobacion, ofi.oficina
                from documentos doc 
                inner join poas poa on doc.id = poa.id_documento
                inner join oficinas ofi on doc.id_oficina = ofi.id
                where doc.id_entidad = $id_entidad
                and doc.id_tipo = 14
                and poa.auto_poa = 1";
        if($oficina != '')
            $sql .= " and doc.id_oficina = '$oficina' ";
        if($f1 != '' && $f2 != '')
            $sql .= " and (poa.fecha_aprobacion between '$f1' and '$f2')";
        if($nombre != '')
            $sql .= " and doc.nombre_remitente like '%$nombre%'";
        return $this->_db->query(Database::SELECT, $sql, TRUE);
    }
}
?>
