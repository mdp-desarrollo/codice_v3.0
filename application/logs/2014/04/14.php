<?php defined('SYSPATH') or die('No direct script access.'); ?>

2014-04-14 12:38:11 --- ERROR: ErrorException [ 8 ]: Undefined index: anulado ~ APPPATH/views/documentos/index.php [ 48 ]
2014-04-14 15:05:31 --- ERROR: Database_Exception [ 0 ]: [1064] You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ') GROUP BY u.id' at line 4 ( SELECT u.id, u.nombre,u.cargo,COUNT(*) as  pendientes FROM users u
    INNER JOIN seguimiento s ON s.derivado_a=u.id
    WHERE s.estado='2'
    AND s.derivado_a IN  ) GROUP BY u.id ) ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2014-04-14 15:05:32 --- ERROR: Kohana_Exception [ 0 ]: The anulado property does not exist in the Model_Documentos class ~ MODPATH/orm/classes/kohana/orm.php [ 682 ]
2014-04-14 15:08:26 --- ERROR: Database_Exception [ 0 ]: [1064] You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ') GROUP BY u.id' at line 4 ( SELECT u.id, u.nombre,u.cargo,COUNT(*) as  pendientes FROM users u
    INNER JOIN seguimiento s ON s.derivado_a=u.id
    WHERE s.estado='2'
    AND s.derivado_a IN  ) GROUP BY u.id ) ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]