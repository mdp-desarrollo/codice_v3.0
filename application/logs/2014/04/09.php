<?php defined('SYSPATH') or die('No direct script access.'); ?>

2014-04-09 09:26:32 --- ERROR: ErrorException [ 8 ]: Undefined index: observacion ~ APPPATH/classes/controller/ajax.php [ 15 ]
2014-04-09 09:38:58 --- ERROR: ErrorException [ 8 ]: Undefined property: stdClass::$carpeta ~ APPPATH/views/hojaruta/seguimiento.php [ 121 ]
2014-04-09 09:44:38 --- ERROR: ErrorException [ 8 ]: Undefined property: stdClass::$carpeta ~ APPPATH/views/hojaruta/seguimiento.php [ 121 ]
2014-04-09 10:53:25 --- ERROR: ErrorException [ 8 ]: Undefined variable: rs ~ APPPATH/views/hojaruta/seguimiento.php [ 166 ]
2014-04-09 10:54:37 --- ERROR: Database_Exception [ 0 ]: [1064] You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ' IF(e.id=10,(SELECT carpetas.carpeta FROM archivados, carpetas WHERE archivados.' at line 3 ( SELECT s.id as id, s.padre,s.nur, s.derivado_por,s.derivado_a,s.nombre_emisor,s.nombre_receptor,s.cargo_emisor,s.cargo_receptor,s.de_oficina,s.a_oficina,s.fecha_emision,s.fecha_recepcion,
s.adjuntos, s.archivos, c.accion,e.id as id_estado,e.estado,s.oficial,s.hijo,s.proveido, s.observacion, 
, IF(e.id=10,(SELECT carpetas.carpeta FROM archivados, carpetas WHERE archivados.nur=s.nur AND archivados.id_user=s.derivado_a AND archivados.id_carpeta=carpetas.id),'') as carpeta 
            FROM seguimiento s
            INNER JOIN acciones c ON s.accion=c.id
            INNER JOIN estados e ON s.estado=e.id
            WHERE s.nur='MDPyEP/2014-00002'
            ORDER BY s.id ) ~ MODPATH/database/classes/kohana/database/mysql.php [ 181 ]
2014-04-09 10:55:44 --- ERROR: ErrorException [ 8 ]: Undefined variable: rs ~ APPPATH/views/hojaruta/seguimiento.php [ 166 ]
2014-04-09 17:38:49 --- ERROR: ErrorException [ 1 ]: Call to undefined method Controller_Bandeja::acciones() ~ APPPATH/classes/controller/bandeja.php [ 118 ]
2014-04-09 17:45:25 --- ERROR: ErrorException [ 1 ]: Call to undefined method Controller_Bandeja::acciones() ~ APPPATH/classes/controller/bandeja.php [ 120 ]
2014-04-09 17:48:20 --- ERROR: ErrorException [ 4096 ]: Argument 1 passed to Kohana_Controller::__construct() must be an instance of Request, none given, called in /var/www/codice_v3.0/application/classes/controller/bandeja.php on line 119 and defined ~ SYSPATH/classes/kohana/controller.php [ 43 ]
2014-04-09 18:03:40 --- ERROR: ErrorException [ 4096 ]: Argument 1 passed to Kohana_Controller::__construct() must be an instance of Request, none given, called in /var/www/codice_v3.0/application/classes/controller/bandeja.php on line 119 and defined ~ SYSPATH/classes/kohana/controller.php [ 43 ]