<?php defined('SYSPATH') or die ('no tiene acceso');
class Model_Pvpasajes extends ORM{
    protected $_table_names_plural = false;
    
    public function pasajesautorizados($id){
        $sql = "select fcv.id_memo id_memo, doc.codigo, doc.nur, doc.nombre_remitente nombre, doc.cargo_remitente cargo,fcv.fecha_salida, fcv.fecha_creacion, fcv.fecha_arribo, of.oficina, doc.id id_documento
                from documentos doc
                inner join pvfucovs fcv on doc.id = fcv.id_documento
                inner join oficinas of on doc.id_oficina = of.id
                where doc.id_tipo = 13
                and fcv.id_memo <> 0
                and fcv.auto_pasaje = 1
                and of.id_entidad = $id";
        return $this->_db->query(Database::SELECT, $sql, TRUE);    
    }
    
    public function avanzada($entidad, $nombre, $numero, $oficina, $f1, $f2){
        $sql = "select distinct f.id_memo, d.codigo, d.nur, d.nombre_remitente nombre, d.cargo_remitente cargo, f.fecha_salida, f.fecha_arribo,  o.oficina, f.fecha_creacion, d.id id_documento
                from pvfucovs f 
                inner join documentos d on f.id_documento = d.id
                inner join oficinas o on d.id_oficina = o.id";
        if($numero != '')
            $sql .= " inner join pvpasajes p on f.id = p.id_fucov";
        $sql .=" where d.id_tipo = 13 and f.auto_pasaje = 1 ";
        if($entidad != '')
            $sql .= " and d.id_entidad = $entidad ";
        if($oficina != '')
            $sql .= " and d.id_oficina = $oficina ";
        if($numero != '')
            $sql .= " and p.nro_boleto = '$numero' ";
        if($f1 != '' && $f2 != '')
            $sql .= " and (f.fecha_salida between '$f1' and '$f2' or f.fecha_arribo between '$f1' and '$f2')";
        if($nombre != '')
            $sql .= " and d.nombre_remitente like '%$nombre%'";
        return $this->_db->query(Database::SELECT, $sql, TRUE);
    }
    
    public function informependiente($entidad){
        $sql = "select doc.id, fcv.id_memo, fcv.fecha_salida, fcv.fecha_arribo, o.oficina, doc.nombre_destinatario nombre, doc.cargo_destinatario cargo, doc.nur, doc.codigo, DATEDIFF( CURDATE(),fcv.fecha_arribo) dias
                from documentos doc
                inner join poas poa on doc.id = poa.id_memo
                inner join presupuestos pre on doc.id = pre.id_memo
                inner join pvfucovs fcv on doc.id = fcv.id_memo
		inner join oficinas o on doc.id_oficina = o.id
                where poa.auto_poa = 1
                and pre.auto_pre = 1
                and fcv.auto_pasaje =1
                and doc.fucov = 1
                and doc.id_entidad = $entidad
        	and doc.auto_informe = 0
                and DATEDIFF( CURDATE(),fcv.fecha_arribo)>8";
        return $this->_db->query(Database::SELECT, $sql, TRUE);
    }
    
    public function pendienteavanzado($entidad, $nombre, $oficina, $f1, $f2){
        $sql = "select doc.id, fcv.id_memo, fcv.fecha_salida, fcv.fecha_arribo, o.oficina, doc.nombre_destinatario nombre, doc.cargo_destinatario cargo, doc.nur, doc.codigo, DATEDIFF( CURDATE(),fcv.fecha_arribo) dias
                from documentos doc
                inner join poas poa on doc.id = poa.id_memo
                inner join presupuestos pre on doc.id = pre.id_memo
                inner join pvfucovs fcv on doc.id = fcv.id_memo
		inner join oficinas o on doc.id_oficina = o.id
                where poa.auto_poa = 1
                and pre.auto_pre = 1
                and fcv.auto_pasaje =1
                and doc.fucov = 1
                and doc.id_entidad = $entidad
        	and doc.auto_informe = 0
                and DATEDIFF( CURDATE(),fcv.fecha_arribo)>8";
        if($oficina != '')
            $sql .= " and d.id_oficina = $oficina ";
        if($f1 != '' && $f2 != '')
            $sql .= " and (f.fecha_salida between '$f1' and '$f2' or f.fecha_arribo between '$f1' and '$f2')";
        if($nombre != '')
            $sql .= " and d.nombre_remitente like '%$nombre%'";
        return $this->_db->query(Database::SELECT, $sql, TRUE);
    }
    
    public function descargo($id, $entidad){
        $sql = "select doc.id id_memo, doc.id_user, doc.nur, DATEDIFF( CURDATE(),fcv.fecha_arribo) dias
                from documentos doc
                inner join poas poa on doc.id = poa.id_memo
                inner join presupuestos pre on doc.id = pre.id_memo
                inner join pvfucovs fcv on doc.id = fcv.id_memo
                where poa.auto_poa = 1
                and pre.auto_pre = 1
                and fcv.auto_pasaje
                and doc.fucov = 1
                and doc.id = $id
                and doc.id_entidad = $entidad
                #and DATEDIFF( CURDATE(),fcv.fecha_arribo)<=8";
        return $this->_db->query(Database::SELECT, $sql, TRUE);
    }
            
    public function rep_boletos_focov($f1, $f2, $id_entidad){
        $sql = "SELECT d.id,d.codigo,d.nur,f.id as id_focov, p.* 
FROM pvfucovs f 
INNER JOIN documentos d ON f.id_documento= d.id 
LEFT JOIN pvpasajes p ON f.id = p.id_fucov 
WHERE f.fecha_salida BETWEEN '$f1' AND '$f2' AND d.id_entidad = '$id_entidad'
ORDER BY nur ASC";
        return $this->_db->query(Database::SELECT, $sql, TRUE);
    }

/*
    public function recepcionado($oficina,$id_user,$fecha1,$fecha2)
    {
        $sql="SELECT s.nur,s.nombre_receptor,s.cargo_receptor,s.nombre_emisor,s.cargo_emisor,s.fecha_emision, s.fecha_recepcion,s.proveido,d.codigo FROM seguimiento s
        INNER JOIN documentos d ON s.nur=d.nur
        WHERE s.id_de_oficina='$oficina'
        AND s.derivado_a='$id_user'
        AND s.estado BETWEEN '2' and '4'   
        and d.original=1
        AND s.fecha_recepcion BETWEEN '$fecha1' AND '$fecha2'";
        return db::query(Database::SELECT, $sql)->execute();
    }
*/
}
?>