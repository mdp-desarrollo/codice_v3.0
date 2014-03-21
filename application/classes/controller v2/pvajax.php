<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Pvajax extends Controller {
    public function action_proyectoppt()
    {   
        $id = $_POST['id'];
        $proyecto = ORM::factory('pvproyectos')->where('id_programa','=',$id)->or_where('id_programa','=',0)->and_where('estado','=',1)->find_all();
        $obj = '<option value = "" selected>Seleccione un Proyecto</option>';
        if($proyecto->count() > 0)
        {
            foreach($proyecto as $p){
                $obj = $obj.'<option value="'.$p->id.'">'.$p->codigo.' - '.$p->proyecto.'</option>';
            }
        }
        echo json_encode($obj);
    }
    
    public function action_actividadppt()
    {
        $id = $_POST['id'];
        $actividad = ORM::factory('pvpptactividades')->where('id_programa','=',$id)->or_where('id_programa','=',0)->and_where('estado','=',1)->find_all();
        $obj = '<option value = "" selected>Seleccione una Actividad</option>';
        
        if($actividad->count() > 0)
        {
            foreach($actividad as $a){
                $obj = $obj.'<option value="'.$a->id.'">'.$a->codigo.' - '.$a->actividad.'</option>';
            }
        }
        else
        {
            $obj .= '<option value = "1" selected>000</option>';
        }
        echo json_encode($obj);
    }


public function action_detobjestrategico()
    {       
        $id = $_POST['id'];
        $objetivo = ORM::factory('pvoestrategicos')->where('id','=',$id)->find();
        $desc = $objetivo->objetivo;
        echo json_encode($desc);
    }


public function action_objgestion()
    {       
        
        $id = $_POST['id'];
        $id_ofi = $_POST['id_oficina'];

        $uEjepoa = New Model_oficinas();
        $uejecutorapoa = $uEjepoa->uejecutorapoa($id_ofi);

        $objetivo = ORM::factory('pvogestiones')->where('id_obj_est','=',$id)->and_where('id_oficina','=',$uejecutorapoa->id)->find_all();
        $obj = '<option value = "" selected>(Seleccione)</option>';
        foreach($objetivo as $o){
            $obj = $obj.'<option value="'.$o->id.'">'.$o->codigo.'</option>';
        }        
        echo json_encode($obj);
    }
public function action_detobjgestion()
    {       
        $id = $_POST['id'];
        $objetivo = ORM::factory('pvogestiones')->where('id_obj_est','=',$id)->find();
        $desc = $objetivo->objetivo;
        echo json_encode($desc);
    }

public function action_objespecifico()
    {       
        $id = $_POST['id'];
        $objetivo = ORM::factory('pvoespecificos')->where('id_obj_gestion','=',$id)->find_all();
        $obj = '<option value = "" selected>(Seleccione)</option>';
        foreach($objetivo as $o){
            $obj = $obj.'<option value="'.$o->id.'">'.$o->codigo.'</option>';
        }        
        echo json_encode($obj);
    }
    
public function action_detobjespecifico()
    {       
        $id = $_POST['id'];
        $objetivo = ORM::factory('pvoespecificos')->where('id','=',$id)->find();
        $desc = $objetivo->objetivo;
        echo json_encode($desc);
    }

public function action_actividad()
    {       
        $id = $_POST['id'];
        $actividades = ORM::factory('pvactividades')->where('id_objespecifico','=',$id)->find_all();
        $obj = '<option value = "" selected>(Seleccione)</option>';
        foreach($actividades as $a){
            $obj = $obj.'<option value="'.$a->id.'">'.$a->codigo.'</option>';
        }        
        echo json_encode($obj);
    }
public function action_detactividad()
    {       
        $id = $_POST['id'];
        $actividad = ORM::factory('pvactividades')->where('id','=',$id)->find();
        $desc = $actividad->actividad;
        echo json_encode($desc);
    }

  public function action_pptdisponibleuser(){
        $id = $_POST['id'];
        $pasaje = $_POST['pasaje'];
        $viatico = $_POST['viatico'];
        $viaje = $_POST['viaje'];
        $gasto = $_POST['gasto'];///el tipo de cambio para viaje al esterior ya esta cargado desde la aplicacion
        
        $oDisp = new Model_Pvprogramaticas();
        $disp = $oDisp->saldopresupuesto($id);
        $result = "<table class='classy' border='1px'><thead><th>Partida</th><th><!--Disponible--></th><th>Solicitado (Bs.)</th><th><!--Nuevo Saldo--></th></thead><tbody>";///titulos de tabla comentados
        $sw = 0;
        $resp = 0;
        $c=0;$cont=0;
        foreach($disp as $d){///variables ocultas
            if( $viaje <= 2){
                if( $d['codigo'] == '22110'){///pasaje al interio del pais
                    $resp = round($d['saldo_devengado'] - $pasaje,2);
                    $solicitado = $pasaje;
                    $result .= "<tr><td><input type='hidden' name='x_id_partida[]' readonly size='2' id='x_id_partida_".$c."' value='".$d['id_partida']."'/><input type='text' name='x_codigo[]' readonly size='5' id='x_codigo_".$c."' value='".$d['codigo']."'/><input type='text' name='x_partida[]' readonly size='35' id='x_partida_".$c."' value='".$d['partida']."'/></td><td>".""/*$d['saldo_devengado']*/."</td><td><input type='text' size='5' name='x_solicitado[]' id='x_solicitado_".$c."' value='".$solicitado."' readonly/></td><td>".""/*$resp*/."</td></tr>";
                }
                if( $d['codigo'] == '22210'){///viatico al interior
                    $resp = round($d['saldo_devengado'] - $viatico,2);
                    $solicitado = $viatico;
                    $result .= "<tr><td><input type='hidden' name='x_id_partida[]' readonly size='2' id='x_id_partida_".$c."' value='".$d['id_partida']."'/><input type='text' name='x_codigo[]' readonly size='5' id='x_codigo_".$c."' value='".$d['codigo']."'/><input type='text' name='x_partida[]' readonly size='35' id='x_partida_".$c."' value='".$d['partida']."'/></td><td>".""/*$d['saldo_devengado']*/."</td><td><input type='text' size='5' name='x_solicitado[]' id='x_solicitado_".$c."' value='".$solicitado."' readonly/></td><td>".""/*$resp*/."</td></tr>";
                }
            }
            else
            {
                if( $d['codigo'] == '22120'){///pasaje al exterior
                    $resp = round($d['saldo_devengado'] - $pasaje,2);
                    $solicitado = $pasaje;
                    $result .= "<tr><td><input type='hidden' name='x_id_partida[]' readonly size='2' id='x_id_partida_".$c."' value='".$d['id_partida']."'/><input type='text' name='x_codigo[]' readonly size='5' id='x_codigo_".$c."' value='".$d['codigo']."'/><input type='text' name='x_partida[]' readonly size='35' id='x_partida_".$c."' value='".$d['partida']."'/></td><td>".""/*$d['saldo_devengado']*/."</td><td><input type='text' size='5' name='x_solicitado[]' id='x_solicitado_".$c."' value='".$solicitado."' readonly/></td><td>".""/*$resp*/."</td></tr>";
                }
                if( $d['codigo'] == '22220'){///viaticos al exterior
                    $resp = round($d['saldo_devengado'] - $viatico,2);
                    $solicitado = $viatico;
                    $result .= "<tr><td><input type='hidden' name='x_id_partida[]' readonly size='2' id='x_id_partida_".$c."' value='".$d['id_partida']."'/><input type='text' name='x_codigo[]' readonly size='5' id='x_codigo_".$c."' value='".$d['codigo']."'/><input type='text' name='x_partida[]' readonly size='35' id='x_partida_".$c."' value='".$d['partida']."'/></td><td>".""/*$d['saldo_devengado']*/."</td><td><input type='text' size='5' name='x_solicitado[]' id='x_solicitado_".$c."' value='".$solicitado."' readonly/></td><td>".""/*$resp*/."</td></tr>";
                }                    
                if( $d['codigo'] == '26910'){///gastos de representacion
                    $resp = round($d['saldo_devengado'] - $gasto,2);
                    $solicitado = $gasto;
                    $result .= "<tr><td><input type='hidden' name='x_id_partida[]' readonly size='2' id='x_id_partida_".$c."' value='".$d['id_partida']."'/><input type='text' name='x_codigo[]' readonly size='5' id='x_codigo_".$c."' value='".$d['codigo']."'/><input type='text' name='x_partida[]' readonly size='35' id='x_partida_".$c."' value='".$d['partida']."'/></td><td>".""/*$d['saldo_devengado']*/."</td><td><input type='text' size='5' name='x_solicitado[]' id='x_solicitado_".$c."' value='".$solicitado."' readonly/></td><td>".""/*$resp*/."</td></tr>";
                }
            }
            if($resp < 0)
                $sw = 1;
            $c++;            
        }
        $result .= "</tbody></table>";
        //if($sw == 1)
        //    $result .="<br /><font color=\"red\" size=\"4\"><center>PRESUPUESTO INSUFICIENTE!!!</center></font>";
        echo json_encode($result);
  }
        
    public function action_feriados()
    {
        $f1 = $_POST['fecha1'];
        $f2 = $_POST['fecha2'];
        $oFer = new Model_Pvferiados();
        $fer = $oFer->feriados($f1, $f2);
        $obj = '';
        foreach($fer as $f)            
            $obj = $obj.' '.$f['detalle'].': '.date("d-m-Y",strtotime($f['fecha']));        
        echo json_encode($obj);     
    }
    
    public function action_pptdetalle()
    {
        $id = $_POST['id'];
        $oFuente = New Model_Pvprogramaticas();
        $det = $oFuente->detallesaldopresupuesto($id);
        foreach ($det as $d)
            $detalle = $d;
        $result = array(
            "sigla"=>$detalle->sigla,
            "entidad"=>$detalle->entidad,
            "codigo_ue"=>$detalle->codigo_ue,
            "ue"=>$detalle->ue,
            "codigo_da"=>$detalle->codigo_da,
            "da"=>$detalle->da,
            "codigo_prog"=>$detalle->codigo_prog,
            "programa"=>$detalle->programa,
            "codigo_proy"=>$detalle->codigo_proy,
            "proyecto"=>$detalle->proyecto,
            "codigo_act"=>$detalle->codigo_act,
            "actividad"=>$detalle->actividad,
            "codigo_fte"=>$detalle->codigo_fte,
            "fte"=>$detalle->fte,
            "codigo_org"=>$detalle->codigo_org,
            "org"=>$detalle->org,
            );
        echo json_encode($result);
    }

/*

public function action_adicionpasaje()
    {   
        $id_fucov = $_POST['id_fucov'];
        $origen = $_POST['origen'];
        $destino = $_POST['destino'];
        $fecha_salida = $_POST['fecha_salida'];
        $fecha_arribo = $_POST['fecha_arribo'];
        $transporte = $_POST['transporte'];
        $nro_boleto = $_POST['nro_boleto'];
        $costo = $_POST['costo'];
        $empresa = $_POST['empresa'];
        
        $pasajes = ORM::factory('pvpasajes');
        $pasajes->id_fucov = $id_fucov;
        $pasajes->origen = $origen;
        $pasajes->destino = $destino;
        $pasajes->fecha_salida = $fecha_salida;
        $pasajes->fecha_arribo = $fecha_salida;
        $pasajes->transporte = $transporte;
        $pasajes->nro_boleto = $nro_boleto;
        $pasajes->costo = $costo;
        $pasajes->empresa = $empresa;
        $pasajes->etapa_proceso = 0;
        $pasajes->save();
        if($pasajes->id)
        {
            $obj = "<table class = \"classy\">
                        <thead>
                            <th>TRAMO</th>
                            <th>ORIGEN</th>
                            <th>DESTINO</th>
                            <th>FECHA Y HORA<br /> DE SALIDA</th>
                            <th>FECHA Y HORA<br /> DE ARRIBO</th>
                            <th>TRANSPORTE</th>
                            <th>N. BOLETO</th>
                            <th>COSTO</th>
                            <th>EMPRESA</th>
                        </thead>
                    ";
            $pasajes=ORM::factory('pvpasajes')->where('id_fucov','=',$id_fucov)->find_all();
            $c = 1;
            foreach($pasajes as $p):
                $obj .= "<tbody>
                    <tr>
                        <td>".$c."</td>
                        <td>".$p->origen."</td>
                        <td>".$p->destino."</td>
                        <td>".$p->fecha_salida."</td>
                        <td>".$p->fecha_arribo."</td>
                        <td>".$p->transporte."</td>
                        <td>".$p->nro_boleto."</td>
                        <td>".$p->costo."</td>
                        <td>".$p->empresa."</td>
                    </tr>";
                $c++;
            endforeach;
            $obj .='</tbody></table>';
        }
        else
        {
            $obj = "<b>No se pudo guardar.</b>";
            $obj = "3";
        }
        echo json_encode($obj);
    }

*/
    ///modificado por rodrigo - 29-11-13 - lista de partidas para una fuenta de financiamiento
    public function action_partidas(){
        $id = $_POST['id'];
        $oPart = new Model_Pvprogramaticas();
        $partidas = $oPart->partidas($id);
        $part = '<option value = "" selected>Seleccione una Partida</option>';        
        foreach($partidas as $p){
                $part .= '<option value="'.$p->id.'">'.$p->codigo.' - '.$p->partida.'</option>';
        }
        echo json_encode($part);
  }
    
    public function action_saldopartida(){
        $id_programatica = $_POST['f'];
        $id_partida = $_POST['p'];
        $saldo = ORM::factory('pvejecuciones')->where('id_programatica','=',$id_programatica)->and_where('id_partida','=',$id_partida)->and_where('estado','=',1)->find();
        $result = array(
        "saldo"=>$saldo->saldo_devengado);
        echo json_encode($result);
  }
}