<?php defined('SYSPATH') or die('No direct script access.'); ?>

2014-02-19 12:07:25 --- ERROR: Database_Exception [ 0 ]: [1054] Unknown column 'd.id_oficina' in 'where clause' ( select doc.id, fcv.id_memo, fcv.fecha_salida, fcv.fecha_arribo, o.oficina, doc.nombre_destinatario nombre, doc.cargo_destinatario cargo, doc.nur, doc.codigo, DATEDIFF( CURDATE(),fcv.fecha_arribo) dias
                from documentos doc
                inner join poas poa on doc.id = poa.id_memo
                inner join presupuestos pre on doc.id = pre.id_memo
                inner join pvfucovs fcv on doc.id = fcv.id_memo
		inner join oficinas o on doc.id_oficina = o.id
                where poa.auto_poa = 1
                and pre.auto_pre = 1
                and fcv.auto_pasaje =1
                and doc.fucov = 1
                and doc.id_entidad = 1
        	and doc.auto_informe = 0
                and DATEDIFF( CURDATE(),fcv.fecha_arribo)>8 and d.id_oficina = 97  and (f.fecha_salida between '2014-02-01 00:00:00' and '2014-02-19 23:59:00' or f.fecha_arribo between '2014-02-01 00:00:00' and '2014-02-19 23:59:00') ) ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2014-02-19 15:35:52 --- ERROR: ErrorException [ 1 ]: Call to undefined method Controller_Pvpasajes::oficinas() ~ APPPATH/classes/controller/pvpasajes.php [ 261 ]
2014-02-19 15:37:00 --- ERROR: ErrorException [ 1 ]: Call to undefined method Controller_Pvpasajes::oficinas() ~ APPPATH/classes/controller/pvpasajes.php [ 261 ]
2014-02-19 15:37:04 --- ERROR: ErrorException [ 1 ]: Call to undefined method Controller_Pvpasajes::oficinas() ~ APPPATH/classes/controller/pvpasajes.php [ 261 ]
2014-02-19 16:55:59 --- ERROR: Kohana_Exception [ 0 ]: Invalid method rep_boletos_focov called in Model_Pvpasajes ~ MODPATH/orm/classes/kohana/orm.php [ 606 ]
2014-02-19 16:56:49 --- ERROR: ErrorException [ 8 ]: Undefined variable: oficina ~ APPPATH/views/pvpasajes/rep_boletos_vista.php [ 6 ]
2014-02-19 16:57:27 --- ERROR: ErrorException [ 1 ]: Cannot use object of type stdClass as array ~ APPPATH/views/pvpasajes/rep_boletos_vista.php [ 26 ]
2014-02-19 17:01:22 --- ERROR: ErrorException [ 1 ]: Cannot use object of type stdClass as array ~ APPPATH/views/pvpasajes/rep_boletos_vista.php [ 26 ]
2014-02-19 17:15:54 --- ERROR: ErrorException [ 1 ]: Cannot use object of type stdClass as array ~ APPPATH/views/pvpasajes/rep_boletos_vista.php [ 26 ]
2014-02-19 17:16:44 --- ERROR: ErrorException [ 1 ]: Cannot use object of type stdClass as array ~ APPPATH/views/pvpasajes/rep_boletos_vista.php [ 27 ]
2014-02-19 17:19:27 --- ERROR: ErrorException [ 1 ]: Cannot use object of type stdClass as array ~ APPPATH/views/pvpasajes/rep_boletos_vista.php [ 27 ]
2014-02-19 17:45:32 --- ERROR: ErrorException [ 4 ]: syntax error, unexpected '}', expecting ',' or ';' ~ APPPATH/views/pvpasajes/rep_boletos_vista.php [ 33 ]