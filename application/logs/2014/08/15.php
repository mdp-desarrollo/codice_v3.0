<?php defined('SYSPATH') or die('No direct script access.'); ?>

2014-08-15 10:48:44 --- ERROR: Database_Exception [ 0 ]: [1062] Duplicate entry 'E-MDPyEP/2014-05428' for key 'PRIMARY' ( INSERT INTO `nurs` (`nur`, `id_user`, `fecha_creacion`, `username`) VALUES ('E-MDPyEP/2014-05428', '256', '2014-08-15 10:48:44', 'LEONARDO GARABITO') ) ~ MODPATH\database\classes\kohana\database\mysql.php [ 181 ]
2014-08-15 15:35:19 --- ERROR: ErrorException [ 1 ]: Class 'Model_Entidad' not found ~ MODPATH\orm\classes\kohana\orm.php [ 109 ]
2014-08-15 15:35:39 --- ERROR: ErrorException [ 1 ]: Class 'Model_Entidad' not found ~ MODPATH\orm\classes\kohana\orm.php [ 109 ]
2014-08-15 15:37:06 --- ERROR: ErrorException [ 8 ]: Undefined variable: 7 ~ APPPATH\classes\controller\reportes.php [ 450 ]
2014-08-15 18:23:47 --- ERROR: ErrorException [ 4 ]: syntax error, unexpected ',', expecting '&' or T_VARIABLE ~ APPPATH\classes\model\documentos.php [ 217 ]
2014-08-15 18:30:52 --- ERROR: ErrorException [ 8 ]: Undefined variable: text ~ APPPATH\classes\controller\reportes.php [ 448 ]
2014-08-15 18:32:56 --- ERROR: Kohana_Exception [ 0 ]: Invalid method buscarDocumento called in Model_Documentos ~ MODPATH\orm\classes\kohana\orm.php [ 606 ]
2014-08-15 19:04:30 --- ERROR: Database_Exception [ 0 ]: [1064] You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '00:00:00 AND 2014-08-15 23:59:00 LIMIT 0,20' at line 2 ( SELECT d.id, d.nur, d.cite_original, d.nombre_destinatario, d.cargo_destinatario, d.nombre_remitente,d.cargo_remitente,d.referencia,d.fecha_creacion, t.tipo        
        FROM documentos d INNER JOIN tipos t ON d.id_tipo=t.id WHERE id_entidad=1 AND (nur like '%5159%') AND d.fecha_creacion between 2014-08-01 00:00:00 AND 2014-08-15 23:59:00 LIMIT 0,20 ) ~ MODPATH\database\classes\kohana\database\mysql.php [ 181 ]
2014-08-15 19:09:39 --- ERROR: Database_Exception [ 0 ]: [1054] Unknown column 'd.fecha_creacion' in 'where clause' ( SELECT COUNT(*) as count  FROM documentos WHERE id_entidad=1 AND (nur like '%5159%') AND d.fecha_creacion between '2014-04-25 00:00:00' AND '2014-08-15 23:59:00' ) ~ MODPATH\database\classes\kohana\database\mysql.php [ 181 ]