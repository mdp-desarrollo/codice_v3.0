<?php defined('SYSPATH') or die('No direct script access.'); ?>

2014-05-23 09:38:10 --- ERROR: Database_Exception [ 0 ]: [1064] You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ') GROUP BY u.id' at line 4 ( SELECT u.id, u.nombre,u.cargo,COUNT(*) as  pendientes FROM users u
    INNER JOIN seguimiento s ON s.derivado_a=u.id
    WHERE s.estado='2'
    AND s.derivado_a IN  ) GROUP BY u.id ) ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2014-05-23 09:38:17 --- ERROR: Database_Exception [ 0 ]: [1064] You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ') GROUP BY u.id' at line 4 ( SELECT u.id, u.nombre,u.cargo,COUNT(*) as  pendientes FROM users u
    INNER JOIN seguimiento s ON s.derivado_a=u.id
    WHERE s.estado='2'
    AND s.derivado_a IN  ) GROUP BY u.id ) ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2014-05-23 09:39:38 --- ERROR: Database_Exception [ 0 ]: [1064] You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ') GROUP BY u.id' at line 4 ( SELECT u.id, u.nombre,u.cargo,COUNT(*) as  pendientes FROM users u
    INNER JOIN seguimiento s ON s.derivado_a=u.id
    WHERE s.estado='2'
    AND s.derivado_a IN  ) GROUP BY u.id ) ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2014-05-23 11:05:36 --- ERROR: Database_Exception [ 0 ]: [1064] You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ') GROUP BY u.id' at line 4 ( SELECT u.id, u.nombre,u.cargo,COUNT(*) as  pendientes FROM users u
    INNER JOIN seguimiento s ON s.derivado_a=u.id
    WHERE s.estado='2'
    AND s.derivado_a IN  ) GROUP BY u.id ) ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2014-05-23 11:06:40 --- ERROR: Database_Exception [ 0 ]: [1064] You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ') GROUP BY u.id' at line 4 ( SELECT u.id, u.nombre,u.cargo,COUNT(*) as  pendientes FROM users u
    INNER JOIN seguimiento s ON s.derivado_a=u.id
    WHERE s.estado='2'
    AND s.derivado_a IN  ) GROUP BY u.id ) ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2014-05-23 11:17:09 --- ERROR: ErrorException [ 8 ]: Undefined variable: entidad ~ APPPATH/classes/controller/documento.php [ 610 ]
2014-05-23 11:45:23 --- ERROR: Database_Exception [ 0 ]: [1064] You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ') GROUP BY u.id' at line 4 ( SELECT u.id, u.nombre,u.cargo,COUNT(*) as  pendientes FROM users u
    INNER JOIN seguimiento s ON s.derivado_a=u.id
    WHERE s.estado='2'
    AND s.derivado_a IN  ) GROUP BY u.id ) ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2014-05-23 16:18:16 --- ERROR: Database_Exception [ 0 ]: [1064] You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '00:00:00 AND '2014-01-30' 00:00:00' at line 1 ( SELECT COUNT(*) as count  FROM documentos d  WHERE  ( d.cite_original LIKE '%viaje a cochabamba%' OR d.referencia LIKE '%viaje a cochabamba%' ) and d.fecha_creacion BETWEEN '2014-01-14' 00:00:00 AND '2014-01-30' 00:00:00 ) ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2014-05-23 16:20:03 --- ERROR: Database_Exception [ 0 ]: [1064] You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '00:00:00 AND '2014-01-30' 00:00:00' at line 1 ( SELECT COUNT(*) as count  FROM documentos d  WHERE  ( d.cite_original LIKE '%viaje a cochabamba%' OR d.referencia LIKE '%viaje a cochabamba%' ) and d.fecha_creacion BETWEEN '2014-01-14' 00:00:00 AND '2014-01-30' 00:00:00  ) ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]