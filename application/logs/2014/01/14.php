<?php defined('SYSPATH') or die('No direct script access.'); ?>

2014-01-14 12:06:04 --- ERROR: ErrorException [ 8 ]: Undefined index: fuente ~ APPPATH/classes/controller/pvpresupuesto.php [ 331 ]
2014-01-14 12:06:49 --- ERROR: ErrorException [ 8 ]: Undefined index: archivo ~ APPPATH/classes/controller/pvpresupuesto.php [ 336 ]
2014-01-14 16:15:08 --- ERROR: Database_Exception [ 0 ]: [1064] You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ') GROUP BY u.id' at line 4 ( SELECT u.id, u.nombre,u.cargo,COUNT(*) as  pendientes FROM users u
    INNER JOIN seguimiento s ON s.derivado_a=u.id
    WHERE s.estado='2'
    AND s.derivado_a IN  ) GROUP BY u.id ) ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2014-01-14 16:30:58 --- ERROR: Database_Exception [ 0 ]: [1064] You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ') GROUP BY u.id' at line 4 ( SELECT u.id, u.nombre,u.cargo,COUNT(*) as  pendientes FROM users u
    INNER JOIN seguimiento s ON s.derivado_a=u.id
    WHERE s.estado='2'
    AND s.derivado_a IN  ) GROUP BY u.id ) ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2014-01-14 16:57:59 --- ERROR: Database_Exception [ 0 ]: [1064] You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ') GROUP BY u.id' at line 4 ( SELECT u.id, u.nombre,u.cargo,COUNT(*) as  pendientes FROM users u
    INNER JOIN seguimiento s ON s.derivado_a=u.id
    WHERE s.estado='2'
    AND s.derivado_a IN  ) GROUP BY u.id ) ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2014-01-14 17:15:26 --- ERROR: ErrorException [ 8 ]: Undefined variable: id_partida ~ APPPATH/classes/controller/documento.php [ 636 ]
2014-01-14 17:18:31 --- ERROR: ErrorException [ 8 ]: Undefined property: Database_MySQL_Result::$loaded ~ APPPATH/classes/controller/documento.php [ 626 ]
2014-01-14 17:19:41 --- ERROR: ErrorException [ 1 ]: Call to undefined method Database_MySQL_Result::loaded() ~ APPPATH/classes/controller/documento.php [ 626 ]
2014-01-14 17:43:34 --- ERROR: ErrorException [ 8 ]: Undefined variable: documento ~ APPPATH/classes/controller/documento.php [ 1288 ]
2014-01-14 17:43:42 --- ERROR: ErrorException [ 8 ]: Undefined variable: documento ~ APPPATH/classes/controller/documento.php [ 1288 ]
2014-01-14 17:46:56 --- ERROR: Database_Exception [ 0 ]: [1064] You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ') GROUP BY u.id' at line 4 ( SELECT u.id, u.nombre,u.cargo,COUNT(*) as  pendientes FROM users u
    INNER JOIN seguimiento s ON s.derivado_a=u.id
    WHERE s.estado='2'
    AND s.derivado_a IN  ) GROUP BY u.id ) ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2014-01-14 18:01:13 --- ERROR: ErrorException [ 8 ]: Undefined variable: documento ~ APPPATH/classes/controller/documento.php [ 1288 ]
2014-01-14 18:01:41 --- ERROR: ErrorException [ 8 ]: Undefined variable: documento ~ APPPATH/classes/controller/documento.php [ 1288 ]