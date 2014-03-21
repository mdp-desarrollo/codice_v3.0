<?php defined('SYSPATH') or die('No direct script access.'); ?>

2013-12-18 10:26:38 --- ERROR: Database_Exception [ 0 ]: [1064] You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ') GROUP BY u.id' at line 4 ( SELECT u.id, u.nombre,u.cargo,COUNT(*) as  pendientes FROM users u
    INNER JOIN seguimiento s ON s.derivado_a=u.id
    WHERE s.estado='2'
    AND s.derivado_a IN  ) GROUP BY u.id ) ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
<<<<<<< HEAD
2013-12-18 11:17:06 --- ERROR: ErrorException [ 8 ]: Undefined variable: obj_est ~ APPPATH/views/documentos/edit.php [ 644 ]
=======
2013-12-18 10:37:38 --- ERROR: ErrorException [ 8 ]: Trying to get property of non-object ~ APPPATH/views/documentos/edit.php [ 750 ]
2013-12-18 10:38:57 --- ERROR: ErrorException [ 8 ]: Trying to get property of non-object ~ APPPATH/views/documentos/edit.php [ 750 ]
2013-12-18 10:38:58 --- ERROR: ErrorException [ 8 ]: Trying to get property of non-object ~ APPPATH/views/documentos/edit.php [ 750 ]
2013-12-18 10:39:17 --- ERROR: ErrorException [ 8 ]: Undefined variable: uejecutorapre ~ APPPATH/views/documentos/edit.php [ 755 ]
2013-12-18 10:39:55 --- ERROR: ErrorException [ 8 ]: Undefined variable: uejecutorapre ~ APPPATH/views/documentos/edit.php [ 755 ]
2013-12-18 10:41:59 --- ERROR: ErrorException [ 8 ]: Undefined variable: uejecutorapre ~ APPPATH/views/documentos/edit.php [ 755 ]
2013-12-18 10:42:12 --- ERROR: ErrorException [ 8 ]: Undefined variable: fuente ~ APPPATH/views/documentos/edit.php [ 759 ]
2013-12-18 10:42:22 --- ERROR: ErrorException [ 8 ]: Undefined variable: x_partida ~ APPPATH/views/documentos/edit.php [ 771 ]
2013-12-18 10:55:13 --- ERROR: Database_Exception [ 0 ]: [1064] You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ') GROUP BY u.id' at line 4 ( SELECT u.id, u.nombre,u.cargo,COUNT(*) as  pendientes FROM users u
    INNER JOIN seguimiento s ON s.derivado_a=u.id
    WHERE s.estado='2'
    AND s.derivado_a IN  ) GROUP BY u.id ) ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2013-12-18 11:08:17 --- ERROR: ErrorException [ 8 ]: Undefined index: x_id_partida ~ APPPATH/classes/controller/documento.php [ 601 ]
2013-12-18 11:10:31 --- ERROR: ErrorException [ 8 ]: Undefined index: x_id_partida ~ APPPATH/classes/controller/documento.php [ 601 ]
2013-12-18 11:12:37 --- ERROR: ErrorException [ 8 ]: Undefined index: x_solicitado ~ APPPATH/classes/controller/documento.php [ 602 ]
2013-12-18 11:19:39 --- ERROR: Database_Exception [ 0 ]: [1064] You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ') GROUP BY u.id' at line 4 ( SELECT u.id, u.nombre,u.cargo,COUNT(*) as  pendientes FROM users u
    INNER JOIN seguimiento s ON s.derivado_a=u.id
    WHERE s.estado='2'
    AND s.derivado_a IN  ) GROUP BY u.id ) ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2013-12-18 11:20:00 --- ERROR: ErrorException [ 8 ]: Undefined index: x_solicitado ~ APPPATH/classes/controller/documento.php [ 602 ]
2013-12-18 11:20:32 --- ERROR: ErrorException [ 8 ]: Undefined index: x_id_partida ~ APPPATH/classes/controller/documento.php [ 601 ]
2013-12-18 11:23:22 --- ERROR: ErrorException [ 8 ]: Undefined index: x_id_partida ~ APPPATH/classes/controller/documento.php [ 601 ]
2013-12-18 11:24:02 --- ERROR: ErrorException [ 8 ]: Undefined index: x_solicitado ~ APPPATH/classes/controller/documento.php [ 603 ]
2013-12-18 11:24:17 --- ERROR: ErrorException [ 8 ]: Undefined index: x_solicitado ~ APPPATH/classes/controller/documento.php [ 603 ]
2013-12-18 11:26:01 --- ERROR: ErrorException [ 8 ]: Undefined variable: id_partida ~ APPPATH/classes/controller/documento.php [ 609 ]
2013-12-18 11:27:14 --- ERROR: ErrorException [ 8 ]: Undefined variable: id_partida ~ APPPATH/classes/controller/documento.php [ 618 ]
2013-12-18 11:29:54 --- ERROR: ErrorException [ 8 ]: Undefined variable: id_partida ~ APPPATH/classes/controller/documento.php [ 618 ]
>>>>>>> ecfde573421cdf175193267bd4b0977880d7c30d

2013-12-18 11:50:51 --- ERROR: ErrorException [ 8 ]: Undefined variable: obj_est ~ APPPATH/views/documentos/edit.php [ 776 ]