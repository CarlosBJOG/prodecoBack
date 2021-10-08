<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $funcion = $_POST["funcion"]; // tipo de operación
    @session_start(); 
    $idkey_usuario = $_SESSION['idkey']; 
    require_once 'clases/conversor.php';

    //Conexión a la BD
    require_once "db.php";
    $oconns = new database();
    require_once 'json_func_movimientos_contables.php';


    function color_desembolso($estatus){
        $color = "";
        switch($estatus){
            case 1://Pendiente
                $color = "danger";
            break;
            case 2://En tránsito
                $color = "warning";
            break;
            case 3://Solicitado
                $color = "info";
            break;
            case 4://En colocación
                $color = "primary";
            break;
            case 5://Desembolsado
                $color = "success";
            break;
            case 6://Recibido
                $color = "success";
            break;
            default:
                $color = "danger";
            break;
        }
        return $color;
    }
    
    switch($funcion){

        case "datatable_colocacion":
            //1) EFECTIVO:::::: Solicitados
            //2) TRANSFERENCIA:::::: En tránsito
            //3) CHEQUE:::::: Pendientes
            $query = "select vc.folio, vc.idkey_credito, vc.nombre, vc.fecha_desembolso, vc.tipo_desembolso, vc.idkey_tipo_desembolso, vc.monto, vc.desc_tipo, vc.idkey_clientes, de.nombre as desc_estatus, vc.estatus_desembolso as estatus FROM view_creditos vc  inner join desembolso_estatus de on (vc.estatus_desembolso=de.idkey) WHERE vc.estatus=1 and ((vc.idkey_tipo_desembolso = 1 AND vc.estatus_desembolso =3) OR (vc.idkey_tipo_desembolso = 2 AND vc.estatus_desembolso =2) OR (vc.idkey_tipo_desembolso = 3 AND vc.estatus_desembolso =1)) order by vc.idkey_credito asc";
            $data = $oconns->getRows($query);
            $rows = array();
            foreach ($data as $item){ 
                $data1 = $oconns->getRows("select idkey as idkey_caja_transito, monto_solicitado from caja_transito where idkey_credito='".$item['idkey_credito']."'");
                if($oconns->numberRows>0) $monto_solicitado = $data1[0]["monto_solicitado"];
                else $monto_solicitado = 0;
                //estatus
                $color = color_desembolso($item["estatus"]);
                $estatus = "<span class='badge badge-sm bgc-".$color."-l2 text-".$color."-d2 border-1 brc-".$color.
                "-m3'>".$item["desc_estatus"]."</span>";

                //checkbox
                $checkbox = "";
                if($item["idkey_tipo_desembolso"] == 1)//Efectivo
                    $checkbox = '<input type="checkbox" name="cred_efectivo" id="cred_efectivo" autocomplete="off" value="'.$item["idkey_credito"].'"/>';
                else if($item["idkey_tipo_desembolso"] == 2)//Transferencia
                    $checkbox = '<input type="checkbox" name="cred_transferencia" id="cred_transferencia" autocomplete="off" value="'.$item["idkey_credito"].'"/>';
                else if($item["idkey_tipo_desembolso"] == 3)//Cheque
                    $checkbox = '<input type="checkbox" name="cred_cheque" id="cred_cheque" autocomplete="off" value="'.$item["idkey_credito"].'"/>';
                $jsonArrayObject = (array(
                    'folio' => $item["folio"], 
                    'checkbox' => $checkbox,
                    'idkey_credito' => $item["idkey_credito"], 
                    'nombre' => $item["nombre"], 
                    'fecha_desembolso' => $item["fecha_desembolso"],
                    'tipo_desembolso' => $item["tipo_desembolso"],
                    'tipo' => $item["desc_tipo"],
                    'monto' => "$".number_format($item["monto"],2),
                    'monto_number' => $item["monto"],
                    'estatus' => $estatus,
                    'monto_solicitado' => "$".number_format($monto_solicitado,2),
                    'idkey_clientes' => $item["idkey_clientes"],
                    'opciones' => '<div><pre><a href="#" class="btn radius-1 btn-sm btn-brc-tp btn-outline-default btn-h-outline-warning btn-a-outline-warning btn-text-warning"><i class="fa fa-flag"></i></a></pre></div>'
                ));
                $rows[] = $jsonArrayObject;
            }
            echo json_encode($rows);
        break;

        case "datatable_colocacion_egreso":
            $query = "select pe.idkey, no_poliza, fecha, concepto, monto, idkey_tipo_poliza,nombre as nombre_poliza  from poliza_egreso pe inner join tipo_poliza tp on(pe.idkey_tipo_poliza=tp.idkey) where idkey_tipo_poliza<>4";
            $data = $oconns->getRows($query);
            $rows = array();
            foreach ($data as $item){ 
                $data1 = $oconns->getRows("select idkey as idkey_poliza_diario from poliza_diario where idkey_poliza_egreso='".$item["idkey"]."'");
                $n = $oconns->numberRows;

                $botones ='<a href="../contabilidad/colocacion_detalle_poliza_egreso.php?idkey_poliza_egreso='.$item["idkey"].'" class="btn radius-1 btn-sm btn-brc-tp btn-outline-default btn-h-outline-success btn-a-outline-success btn-text-success" title="Ver Detalles"><i class="fa fa-eye"></i></a>';
                if($n== 0 && ($item["idkey_tipo_poliza"]==1 OR $item["idkey_tipo_poliza"]==3) )
                    $botones .= '<a href="#" class="btn radius-1 btn-sm btn-brc-tp btn-outline-default btn-h-outline-primary btn-a-outline-primary btn-text-primary" title="Generar Póliza Diario" onclick="cargar_datos_pdiario(\''.$item["idkey"].'\',\''.$item["monto"].'\',\''.$item["idkey_tipo_poliza"].'\')" data-toggle="modal" data-target="#modalPDiario"><i class="fa fa-file-pdf-o"></i></a>';
                $jsonArrayObject = (array(
                    'checkbox' => '<input type="checkbox" name="cred_poliza_diario" id="cred_poliza_diario" autocomplete="off" value="'.$item["idkey"].'"/>', 
                    'no_poliza' => $item["no_poliza"], 
                    'fecha' => $item["fecha"], 
                    'concepto' => $item["concepto"],
                    'monto' => "$".number_format($item["monto"],2),
                    'monto_cantidad' => $item["monto"],
                    'botones' => $botones,
                    'nombre_poliza' => $item["nombre_poliza"]
                ));
                $rows[] = $jsonArrayObject;
            }
            echo json_encode($rows);
        break;

        case "cargar_poliza_egreso":
            $creditos=$_POST["creditos"]; //Son los idkey de caja en transito
            $folios = "";
            $montos = "";
            $monto_total =0;
            foreach ($creditos as $idkey_credito) {
                $data = $oconns->getRows("select folio, c.idkey as idkey_credito, monto from creditos c  where c.idkey='$idkey_credito'");
                if($oconns->numberRows>0){
                    $data1 = $oconns->getRows("select monto_solicitado from caja_transito  where idkey_credito='$idkey_credito'");
                    if($oconns->numberRows>0) $monto = $data1[0]["monto_solicitado"];
                    else $monto = $data[0]["monto"];
                    $folios .= $data[0]["folio"]."<input hidden type='text' name='idkey_credito[]' value='".$data[0]["idkey_credito"]."'/><br>";
                    $montos .= "$".number_format($monto,2)."<br>";
                    $monto_total = $monto_total + floatval($monto);
                }
            }
            //Se cargan las cuentas contables
            $dats = $oconns->getRows("select no_cuenta, nombre from cuentas_contables order by no_cuenta asc;");
            $cuentas= "<option></option>";
            foreach ($dats as $items)
                $cuentas.= "<option value='".$items["no_cuenta"]."'>".$items["no_cuenta"]." - ".$items["nombre"]."</option>";
            $response["folios"]=$folios;
            $response["montos"]=$montos;
            $response["monto_total"]=$monto_total;
            $response["cuentas"]=$cuentas;
            $response["fecha_poliza"]=date('d/m/Y');
            echo json_encode($response);
        break;

        case "guardar_poliza_egreso":
            
            $temp = explode("/",$_POST["fecha_poliza"]);
            $fecha = $temp[2]."-".$temp[1]."-".$temp[0];
            $mes = $temp[2]."-".$temp[1];
            //Para el no de poliza
            $no_poliza = $oconns->getSimple("select max(no_poliza) from poliza_egreso where fecha LIKE '".$mes."%';");
            if($no_poliza =="")
                 $no_poliza = 1;
             else $no_poliza = intval($no_poliza) +1;
            $nuevo_estatus_desembolso = $_POST["nuevo_estatus_desembolso"];
            $tipo_poliza_egreso = $_POST["tipo_poliza_egreso"];
            $concepto = $_POST["concepto"];
            $monto = $_POST["monto"];
            $periodo = $_POST["periodo"];
            $serie = $_POST["serie"];
            $tipo = $_POST["tipo"];
            $idkey_cuenta_contable1 = $_POST["cuenta_contable1"];
            $referencia1 = $_POST["referencia1"];
            $debe1 = $_POST["debe1"];
            $haber1 = $_POST["haber1"];
            $idkey_cuenta_contable2 = $_POST["cuenta_contable2"];
            $referencia2 = $_POST["referencia2"];
            $debe2 = $_POST["debe2"];
            $haber2 = $_POST["haber2"];
            $idkey_creditos = $_POST["idkey_credito"];
            $oconns->ShotSimple("insert into poliza_egreso(no_poliza, fecha, concepto, monto, idkey_tipo_poliza, periodo, serie, tipo, idkey_usuario) values('".$no_poliza."', '".$fecha."', '".$concepto."', '".$monto."','".$tipo_poliza_egreso."','".$periodo."','".$serie."','".$tipo."','".$idkey_usuario."');");
            $response["idkey_poliza_egreso"]=$oconns->last_id;
            $response["no_poliza"]= $no_poliza;
            if($response["idkey_poliza_egreso"]!=""){
                $response["error"]=0;
                //Insertamos los movimientos de la póliza
                $oconns->ShotSimple("insert into poliza_egreso_movimientos(idkey_cuenta_contable, referencia, debe, haber, descripcion, idkey_poliza) values('".$idkey_cuenta_contable1."', '".$referencia1."', '".$debe1."', '".$haber1."', 'Movimiento de póliza de egreso para créditos', '".$response["idkey_poliza_egreso"]."'),('".$idkey_cuenta_contable2."', '".$referencia2."', '".$debe2."', '".$haber2."', 'Movimiento de póliza de egreso para créditos', '".$response["idkey_poliza_egreso"]."');");
                //Se actualizan los estatus
                foreach ($idkey_creditos as $item){
                    $oconns->ShotSimple("insert into poliza_egreso_creditos(idkey_poliza_egreso, idkey_credito) values ('".$response["idkey_poliza_egreso"]."', '".$item."')");
                    $oconns->ShotSimple("update creditos set estatus_desembolso='".$nuevo_estatus_desembolso."' where idkey='$item';");
                    //Bitácora
                    $data = $oconns->getRows("select nombre from desembolso_estatus where idkey=$nuevo_estatus_desembolso");
                    $oconns->ShotSimple("insert into bitacora_creditos(idkey_credito, idkey_usuario, descripcion) values ($item, $idkey_usuario, 'Generación de póliza de egreso no. ".$no_poliza.". Cambio de estatus de desembolso a ".$data[0]["nombre"]."')");
                }
                //Movimientos contables -- retorna la cadena del insert
                $response["mensaje"] = movcont_desembolso_poliza_egreso($response["idkey_poliza_egreso"], $tipo_poliza_egreso, $nuevo_estatus_desembolso, $monto, $idkey_usuario);
                $response["error"]=0;
                
            }
            else
                $response["error"]=1;
            echo json_encode($response);
        break;

        case "guardar_poliza_diario":
            $temp = explode("/",$_POST["fecha_poliza"]);
            $fecha = $temp[2]."-".$temp[1]."-".$temp[0];
            $mes = $temp[2]."-".$temp[1];
            //Para el no de poliza
            $no_poliza = $oconns->getSimple("select max(no_poliza) from poliza_diario where fecha LIKE '".$mes."%';");
            $response["select"]="select max(no_poliza) from poliza_diario where fecha LIKE '".$mes."%';";
            if($no_poliza =="")
                 $no_poliza = 1;
             else $no_poliza = intval($no_poliza) +1;
            $concepto = $_POST["concepto"];
            $idkey_tipo_poliza = $_POST["idkey_tipo_poliza"];
            $monto = $_POST["monto"];
            $periodo = $_POST["periodo"];
            $serie = $_POST["serie"];
            $tipo = $_POST["tipo"];
            $idkey_cuenta_contable1 = $_POST["cuenta_contable1"];
            $referencia1 = $_POST["referencia1"];
            $debe1 = $_POST["debe1"];
            $haber1 = $_POST["haber1"];
            $idkey_cuenta_contable2 = $_POST["cuenta_contable2"];
            $referencia2 = $_POST["referencia2"];
            $debe2 = $_POST["debe2"];
            $haber2 = $_POST["haber2"];
            $idkey_poliza_egreso = $_POST["idkey_poliza_egreso"];
            $oconns->ShotSimple("insert into poliza_diario(no_poliza, fecha, concepto, monto, idkey_poliza_egreso, idkey_tipo_poliza, periodo, serie, tipo, idkey_usuario) values('".$no_poliza."', '".$fecha."', '".$concepto."', '".$monto."', '".$idkey_poliza_egreso."', '".$idkey_tipo_poliza."','".$periodo."','".$serie."','".$tipo."','".$idkey_usuario."');");
            $response["idkey_poliza_diario"]=$oconns->last_id;
            $response["idkey_poliza_egreso"]=$idkey_poliza_egreso;
            $response["no_poliza"]= $no_poliza;
            if($response["idkey_poliza_diario"]!=""){
                $response["error"]=0;
                //Se guardan los movimientos
                $oconns->ShotSimple("insert into poliza_diario_movimientos(idkey_poliza, idkey_cuenta_contable, referencia, debe, haber, descripcion) values('".$response["idkey_poliza_diario"]."', '".$idkey_cuenta_contable1."', '".$referencia1."', '".$debe1."', '".$haber1."', 'Movimiento de póliza de diario para créditos'), ('".$response["idkey_poliza_diario"]."','".$idkey_cuenta_contable2."', '".$referencia2."', '".$debe2."', '".$haber2."','Movimiento de póliza de diario para créditos');");
                //Se actualizan los estatus de los creditos
                $nuevo_estatus_desembolso = 2; //En tránsito
                $oconns->ShotSimple("update poliza_egreso_creditos pec inner join creditos c on (c.idkey=pec.idkey_credito) set c.estatus_desembolso='".$nuevo_estatus_desembolso."' where pec.idkey_poliza_egreso='$idkey_poliza_egreso';");

                //Bitácora
                $data = $oconns->getRows("select idkey_credito from poliza_egreso_creditos where idkey_poliza_egreso=$idkey_poliza_egreso");
                foreach ($data as $item){
                    $oconns->ShotSimple("insert into bitacora_creditos(idkey_credito, idkey_usuario, descripcion) values (".$item["idkey_credito"].", $idkey_usuario, 'Generación de póliza de diario no. ".$no_poliza.". Cambio de estatus de desembolso a En tránsito')");
                }

                //Movimientos contables
                $response["insert"]=movcont_desembolso_poliza_diario($response["idkey_poliza_diario"], $idkey_tipo_poliza, $nuevo_estatus_desembolso, $monto, $idkey_usuario);
                $response["error"]=0;
            }
            else
                $response["error"]=1;
            echo json_encode($response);
        break;

        case "datatable_polizas":
            $query = "select pe.idkey, no_poliza, fecha, concepto, monto, idkey_tipo_poliza,nombre as nombre_poliza, 'Egreso' as tipo, cancelada  from poliza_egreso pe inner join tipo_poliza tp on(pe.idkey_tipo_poliza=tp.idkey)
            union all select pe.idkey, no_poliza, fecha, concepto, monto, idkey_tipo_poliza,nombre as nombre_poliza, 'Ingreso' as tipo, cancelada  from poliza_ingreso pe inner join tipo_poliza tp on(pe.idkey_tipo_poliza=tp.idkey)
            union all select pe.idkey, no_poliza, fecha, concepto, monto, idkey_tipo_poliza,nombre as nombre_poliza, 'Diario' as tipo, cancelada  from poliza_diario pe inner join tipo_poliza tp on(pe.idkey_tipo_poliza=tp.idkey)
            union all select pe.idkey, no_poliza, fecha, concepto, monto, idkey_tipo_poliza,nombre as nombre_poliza, 'Orden' as tipo, cancelada  from poliza_orden pe inner join tipo_poliza tp on(pe.idkey_tipo_poliza=tp.idkey)";
            $data = $oconns->getRows($query);
            $rows = array();
            foreach ($data as $item){ 
                if($item["cancelada"]==0) {
                    $checked ="";
                    $title = "Cancelar Póliza";
                }
                else {
                    $checked ="checked";
                    $title = "Activar Póliza";
                }
                //Para ver detalles de las pólizas
                //http://localhost/prodeco/contabilidad/colocacion_detalle_poliza_egreso.php?idkey_poliza_egreso=71
                //http://localhost/prodeco/contabilidad/colocacion_detalle_poliza_egreso.php?idkey_poliza_egreso=63
                //si es una póliza de crédito
                $boton_detalles ='<a class="btn ace-switch radius-1 btn-sm btn-brc-tp btn-outline-default btn-h-outline-success btn-a-outline-success btn-text-success" title="Ver Detalles" data-toggle="modal" data-target="#modalDetallesPolizas" onclick="cargar_detalle_poliza(\''.$item["idkey"].'\', \''.$item["tipo"].'\')"><i class="fa fa-eye"></i></a>';
                $jsonArrayObject = (array(
                    'checkbox' => '<input type="checkbox" name="cred_poliza_diario" id="cred_poliza_diario" autocomplete="off" value="'.$item["idkey"].'"/>', 
                    'folio' => $item["idkey"],
                    'no_poliza' => $item["no_poliza"], 
                    'fecha' => $item["fecha"], 
                    'concepto' => $item["concepto"],
                    'monto' => "$".number_format($item["monto"],2),
                    'nombre' => $item["nombre_poliza"],
                    'tipo' => $item["tipo"],
                    'opciones' => '<pre>'.$boton_detalles.'<input type="checkbox" class="ace-switch input-md ace-switch-bars-h  ace-switch-check ace-switch-times text-grey-l2 bgc-danger-d2 radius-2px" '.$checked.' id="'.$item["tipo"].$item["idkey"].'" title="'.$title.'" onclick="confirmar_cancelar_poliza(\''.$item["tipo"].'\', \''.$item["idkey"].'\', \''.$item["cancelada"].'\')">'.
                        '<a href="#" class="btn radius-1 btn-sm btn-brc-tp btn-outline-default btn-h-outline-warning btn-a-outline-warning btn-text-warning"><i class="fa fa-flag"></i></a></pre>'
                ));
                $rows[] = $jsonArrayObject;
            }
            echo json_encode($rows);
        break;

        case "guardar_poliza_general":
            $temp = explode("/",$_POST["fecha"]);
            $fecha = $temp[2]."-".$temp[1]."-".$temp[0];
            $mes = $temp[2]."-".$temp[1];

            $tipo = $_POST["tipo"];
            if($tipo == 1) $tipo_poliza="diario";
            else if($tipo == 2) $tipo_poliza="ingreso";
            else if($tipo == 3) $tipo_poliza="egreso";
            else if($tipo == 4) $tipo_poliza="orden";

            //Para obtener el no de poliza
            $no_poliza = $oconns->getSimple("select max(no_poliza) from poliza_".$tipo_poliza." where fecha LIKE '".$mes."%';");
            if($no_poliza =="")
                 $no_poliza = 1;
             else $no_poliza = intval($no_poliza) +1;

            $concepto = $_POST["concepto"];
            $periodo = $_POST["periodo"];
            $serie = $_POST["serie"];
            $idkey_tipo_poliza = 4; //General
            $monto = $_POST["total_d"];

            //Datos de los movimientos
            $cuentas = $_POST["cuentas"];
            $referencias = $_POST["referencias"];
            $deberes = $_POST["deberes"];
            $haberes = $_POST["haberes"];
            $descripciones = $_POST["descripciones"];
            
            $oconns->ShotSimple("insert into poliza_".$tipo_poliza."(no_poliza, fecha, concepto, idkey_tipo_poliza, periodo, serie, idkey_usuario, monto) values('".$no_poliza."', '".$fecha."', '".$concepto."', '".$idkey_tipo_poliza."','".$periodo."','".$serie."','".$idkey_usuario."', '".$monto."');");
            $response["idkey_poliza"]=$oconns->last_id;
            $response["no_poliza"]= $no_poliza;
            if($response["idkey_poliza"]!=""){
                $response["error"]=0;
                //Se guardan los movimientos
                for($i=0; $i<count($cuentas);$i++){
                    $oconns->ShotSimple("insert into poliza_".$tipo_poliza."_movimientos(idkey_cuenta_contable, referencia, debe, haber, descripcion, idkey_poliza) values('".$cuentas[$i]."','".$referencias[$i]."','".$deberes[$i]."','".$haberes[$i]."','".$descripciones[$i]."', '".$response["idkey_poliza"]."')");
                }
                
            }
            else
                $response["error"]=1;

            echo json_encode($response);
        break;

        case "cambiar_estatus_poliza":
            $idkey = $_POST["idkey"];
            $tipo = $_POST["tipo"];
            $estatus_nuevo = $_POST["estatus_nuevo"];
            $response["error"] = 0;
            $oconns->ShotSimple("update poliza_".$tipo." set cancelada='$estatus_nuevo' where idkey='$idkey'");
            echo json_encode($response);
        break;

        case "datatable_movimientos_poliza":
            $idkey_poliza = $_POST["idkey_poliza"];
            $tipo = $_POST["tipo"];
            $movimientos = array();
            //Datos generales de la póliza
            $data1 = $oconns->getRows("SELECT p.idkey, p.no_poliza, p.fecha, p.concepto, p.periodo, p.serie from poliza_".$tipo." p WHERE idkey = '$idkey_poliza'");
            if ($oconns->numberRows>0){
                $response["no_poliza"] = $data1[0]["no_poliza"];
                $response["fecha"] = $data1[0]["fecha"];
                $response["concepto"] = $data1[0]["periodo"];
                $response["serie"] = $data1[0]["serie"];
                $response["periodo"] = $data1[0]["periodo"];
                //Movimientos
                //Si es póliza General
                //.....................
                $data = $oconns->getRows("SELECT p.idkey, p.idkey_cuenta_contable, p.referencia, p.debe, p.haber, c.nombre as nombre_cuenta, p.descripcion from poliza_".$tipo."_movimientos p INNER JOIN cuentas_contables c ON (p.idkey_cuenta_contable=c.no_cuenta) WHERE idkey_poliza = '$idkey_poliza' order by p.idkey asc;");
                if ($oconns->numberRows>0){
                    foreach ($data as $item){ 
                        $jsonArrayObject = (array(
                            'cuenta_contable' => $item["nombre_cuenta"], 
                            'referencia' => $item["referencia"], 
                            'debe' => $item["debe"],
                            'haber' => $item["haber"],
                            'descripcion' => $item["descripcion"]
                        ));
                        $movimientos[] = $jsonArrayObject;
                    }
                }
                $response["movimientos"] = $movimientos;
                $response["error"] = 0;
            }
            else $response["error"] = 1;
            echo json_encode($response);
        break;



    }
}



?>
