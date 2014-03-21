<?php defined('SYSPATH') or die('No direct script access.'); ?>

2013-12-19 15:21:52 --- ERROR: ErrorException [ 8 ]: Undefined variable: obj_est ~ APPPATH/views/documentos/edit.php [ 776 ]
2013-12-19 15:28:49 --- ERROR: ErrorException [ 8 ]: Undefined variable: obj_est ~ APPPATH/views/documentos/edit.php [ 776 ]
2013-12-19 15:28:50 --- ERROR: ErrorException [ 8 ]: Undefined variable: obj_est ~ APPPATH/views/documentos/edit.php [ 776 ]
2013-12-19 15:31:09 --- ERROR: ErrorException [ 4096 ]: Argument 2 passed to Kohana_Form::select() must be of the type array, string given, called in /var/www/codice_pv2/application/views/documentos/edit.php on line 776 and defined ~ SYSPATH/classes/kohana/form.php [ 252 ]
2013-12-19 15:33:22 --- ERROR: ErrorException [ 8 ]: Undefined variable: obj_est ~ APPPATH/views/documentos/edit.php [ 776 ]
2013-12-19 15:35:55 --- ERROR: ErrorException [ 8 ]: Undefined variable: obj_est ~ APPPATH/views/documentos/edit.php [ 776 ]
2013-12-19 16:08:10 --- ERROR: ErrorException [ 8 ]: Undefined property: Controller_Pvajax::$user ~ APPPATH/classes/controller/pvajax.php [ 50 ]
2013-12-19 16:08:36 --- ERROR: ErrorException [ 8 ]: Undefined property: Controller_Pvajax::$user ~ APPPATH/classes/controller/pvajax.php [ 50 ]
2013-12-19 16:08:39 --- ERROR: ErrorException [ 8 ]: Undefined property: Controller_Pvajax::$user ~ APPPATH/classes/controller/pvajax.php [ 50 ]
2013-12-19 16:08:41 --- ERROR: ErrorException [ 8 ]: Undefined property: Controller_Pvajax::$user ~ APPPATH/classes/controller/pvajax.php [ 50 ]
2013-12-19 16:09:27 --- ERROR: ErrorException [ 8 ]: Undefined property: Controller_Pvajax::$user ~ APPPATH/classes/controller/pvajax.php [ 50 ]
2013-12-19 16:17:50 --- ERROR: ErrorException [ 8 ]: Undefined property: Controller_Pvajax::$user ~ APPPATH/classes/controller/pvajax.php [ 50 ]
2013-12-19 16:18:02 --- ERROR: ErrorException [ 8 ]: Undefined property: Controller_Pvajax::$user ~ APPPATH/classes/controller/pvajax.php [ 50 ]
2013-12-19 16:26:17 --- ERROR: ErrorException [ 4 ]: syntax error, unexpected ';' ~ APPPATH/classes/controller/pvajax.php [ 54 ]
2013-12-19 16:26:17 --- ERROR: ErrorException [ 4 ]: syntax error, unexpected ';' ~ APPPATH/classes/controller/pvajax.php [ 54 ]
2013-12-19 16:26:31 --- ERROR: ErrorException [ 8 ]: Undefined variable: 11 ~ APPPATH/classes/controller/pvajax.php [ 56 ]
2013-12-19 16:28:24 --- ERROR: Database_Exception [ 0 ]: [1064] You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ') GROUP BY u.id' at line 4 ( SELECT u.id, u.nombre,u.cargo,COUNT(*) as  pendientes FROM users u
    INNER JOIN seguimiento s ON s.derivado_a=u.id
    WHERE s.estado='2'
    AND s.derivado_a IN  ) GROUP BY u.id ) ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2013-12-19 17:20:16 --- ERROR: Kohana_Exception [ 0 ]: The des_pro_sec property does not exist in the Model_Poas class ~ MODPATH/orm/classes/kohana/orm.php [ 682 ]
2013-12-19 17:24:10 --- ERROR: ErrorException [ 8 ]: Undefined variable: des_pol_sec ~ APPPATH/views/documentos/edit.php [ 762 ]
2013-12-19 18:21:20 --- ERROR: ErrorException [ 8 ]: Undefined index: id_oficina ~ APPPATH/classes/controller/pvajax.php [ 51 ]
2013-12-19 18:21:23 --- ERROR: ErrorException [ 8 ]: Undefined index: id_oficina ~ APPPATH/classes/controller/pvajax.php [ 51 ]
2013-12-19 18:21:26 --- ERROR: ErrorException [ 8 ]: Undefined index: id_oficina ~ APPPATH/classes/controller/pvajax.php [ 51 ]
2013-12-19 18:21:27 --- ERROR: ErrorException [ 8 ]: Undefined index: id_oficina ~ APPPATH/classes/controller/pvajax.php [ 51 ]
2013-12-19 18:21:29 --- ERROR: ErrorException [ 8 ]: Undefined index: id_oficina ~ APPPATH/classes/controller/pvajax.php [ 51 ]