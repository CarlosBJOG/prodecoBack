<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $funcion = $_POST["funcion"]; // tipo de operación
    @session_start(); 
    $idkey_usuario = $_SESSION['idkey']; 
    require_once 'clases/conversor.php';
    require_once 'json_func_movimientos_contables.php';
    
    require_once './modelos/CorteModelo.php';
    
    //instancia de clase gastosModelo
    $modelo = new CorteModelo();


    //Conexión a la BD
    require_once "db.php";
    $oconns = new database();

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
      
        case "consultar_creditos_like_BORRAR":
            $busqueda = $_POST["busqueda"];
            if(empty($busqueda))
                $response["creditos"] = "";
            else{
                $query = "select idkey_credito, folio, nombre from view_creditos where idkey_credito = '".$busqueda."' OR folio like '%".$busqueda."%' OR nombre like '%".$busqueda."%'";
                $data = $oconns->getRows($query);
                $res = "";
                foreach ($data as $item){
                    $res.= "<option onclick='cargar_credito(".$item["idkey_credito"].")' value='".$item["folio"]."'>".$item["nombre"]."</option>";
                }
                $response["creditos"] = $res;
            }
           
            echo json_encode($response);
        break;

        case "consultar_caja_transito"://SUPERVISOR DE CAJERO
            $query = "select vc.folio, vc.idkey_credito, vc.nombre, vc.fecha_desembolso, vc.tipo_desembolso, vc.monto, vc.desc_tipo, vc.idkey_clientes, de.nombre as desc_estatus_desembolso, vc.estatus_desembolso as estatus_desembolso, vc.idkey_tipo_desembolso  FROM view_creditos vc  inner join desembolso_estatus de on (vc.estatus_desembolso=de.idkey) where vc.estatus=1 order by vc.idkey_credito asc";
            $data = $oconns->getRows($query);
            $rows = array();
            foreach ($data as $item){ 
                $m = $oconns->getRows("select monto_solicitado from caja_transito where idkey_credito=".$item["idkey_credito"]);
                if($oconns->numberRows==0)
                    $monto_solicitado =0;
                else
                    $monto_solicitado = $m[0]["monto_solicitado"];

                //estatus
                $color = color_desembolso($item["estatus_desembolso"]);
                $estatus = "<span class='badge badge-sm bgc-".$color."-l2 text-".$color."-d2 border-1 brc-".$color.
                "-m3'>".$item["desc_estatus_desembolso"]."</span>";

                if($item["estatus_desembolso"] == 1 && $item["idkey_tipo_desembolso"] == 1)
                    $botones ='<a href="#" class="btn radius-1 btn-sm btn-brc-tp btn-outline-default btn-h-outline-success btn-a-outline-success btn-text-success" title="En tránsito" onclick="confirmar_estatus_caja(2, \''.$item["idkey_credito"].'\', \''.$item["monto"].'\')"><i class="fa fa-check-circle"></i></a><a href="#" class="btn radius-1 btn-sm btn-brc-tp btn-outline-default btn-h-outline-primary btn-a-outline-primary btn-text-primary" title="Solicitado" onclick="confirmar_estatus_caja(3, \''.$item["idkey_credito"].'\', \''.$item["monto"].'\')"><i class="fa fa-send"></i></a>';
                else $botones ='';
                
                $jsonArrayObject = (array(
                    'folio' => $item["folio"], 
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
                    'opciones' => '<div><pre>'.$botones.'<a href="#" class="btn radius-1 btn-sm btn-brc-tp btn-outline-default btn-h-outline-warning btn-a-outline-warning btn-text-warning"><i class="fa fa-flag"></i></a></pre></div>'
                ));
                $rows[] = $jsonArrayObject;
            }
            echo json_encode($rows);
        break;

        case "consultar_caja_transito_cajero"://CAJERO --> creditos en efectivo, en tránsito && transferencia, pendiente
            //$query = "select vc.folio, vc.idkey_credito, vc.nombre, vc.fecha_desembolso, vc.tipo_desembolso, vc.monto, vc.desc_tipo, vc.idkey_clientes, de.nombre as desc_estatus_desembolso, vc.estatus_desembolso as estatus_desembolso  FROM view_creditos vc  inner join desembolso_estatus de on (vc.estatus_desembolso=de.idkey) where vc.estatus=1 and ( (vc.idkey_tipo_desembolso = 1 AND (vc.estatus_desembolso=2 OR vc.estatus_desembolso=5 OR vc.estatus_desembolso=6)) OR (vc.idkey_tipo_desembolso = 2 AND vc.estatus_desembolso=1) OR (vc.estatus_desembolso=5)) order by vc.idkey_credito asc";
            //Todos los créditos autorizados para que visualice su progreso
            $query = "select vc.folio, vc.idkey_credito, vc.nombre, vc.fecha_desembolso, vc.tipo_desembolso, vc.idkey_tipo_desembolso, vc.monto, vc.desc_tipo, vc.idkey_clientes, de.nombre as desc_estatus_desembolso, vc.estatus_desembolso as estatus_desembolso  FROM view_creditos vc  inner join desembolso_estatus de on (vc.estatus_desembolso=de.idkey) where vc.estatus=1  order by vc.idkey_credito asc";
            $data = $oconns->getRows($query);
            $rows = array();
            foreach ($data as $item){ 
                //estatus
                $color = color_desembolso($item["estatus_desembolso"]);
                $estatus = "<span class='badge badge-sm bgc-".$color."-l2 text-".$color."-d2 border-1 brc-".$color.
                "-m3'>".$item["desc_estatus_desembolso"]."</span>";

                $botones ='';
                if($item["estatus_desembolso"] == 1 && $item["idkey_tipo_desembolso"]==2)//Pendiente, Transferencia => en tránsito
                    $botones .='<a href="#" class="btn radius-1 btn-sm btn-brc-tp btn-outline-default btn-h-outline-success btn-a-outline-success btn-text-success" title="En tránsito" onclick="confirmar_estatus_caja_cajero(2, \''.$item["idkey_credito"].'\')"><i class="fas fa-sync"></i></a>';
                else if($item["estatus_desembolso"] == 2 && ($item["idkey_tipo_desembolso"]==1 || $item["idkey_tipo_desembolso"]==3) )//En tránsito, (efectivo, cheque) => desembolsado
                    $botones .='<a href="#" class="btn radius-1 btn-sm btn-brc-tp btn-outline-primary btn-h-outline-primary btn-a-outline-primary btn-text-primary" title="Retiro/Desembolsar" onclick="confirmar_estatus_caja_cajero(5, \''.$item["idkey_credito"].'\')"><i class="fas fa-hand-holding-usd"></i></a>';
                else if($item["estatus_desembolso"] == 5 || $item["estatus_desembolso"] == 6)//Desembolsado o Recibido, cualquiera => imprimir recibo
                    $botones .='<a href="../pdf/recibo_desembolso.php?idkey_credito='.$item["idkey_credito"].'" class="btn radius-1 btn-sm btn-brc-tp btn-outline-default btn-h-outline-purple btn-a-outline-purple btn-text-purple" title="Imprimir Recibo" target="_blank"><i class="fas fa-receipt"></i></a>';
                
                $jsonArrayObject = (array(
                    'folio' => $item["folio"], 
                    'idkey_credito' => $item["idkey_credito"],
                    'nombre' => $item["nombre"], 
                    'fecha_desembolso' => $item["fecha_desembolso"],
                    'tipo_desembolso' => $item["tipo_desembolso"],
                    'tipo' => $item["desc_tipo"],
                    'monto' => "$".number_format($item["monto"],2),
                    'estatus' => $estatus,
                    'idkey_clientes' => $item["idkey_clientes"],
                    'opciones' => '<div><pre>'.$botones.'<a href="#" class="btn radius-1 btn-sm btn-brc-tp btn-outline-default btn-h-outline-warning btn-a-outline-warning btn-text-warning"><i class="fa fa-flag"></i></a></pre></div>'
                ));
                $rows[] = $jsonArrayObject;
            }
            echo json_encode($rows);
        break;

        case "cambiar_estatus_caja": //Cambia el esatus de los desembolsos
            /**Estatus
            1: pendiente
            2: en tránsito
            3: solicitado
            4: en colocación
            5: desembolsado
            6: recibido*/
            $idkey_estatus = $_POST["idkey_estatus"];
            $idkey_credito = $_POST["idkey_credito"];
            $monto_solicitado = $_POST["monto_solicitado"];
            $response["error"] = 0;
            if($monto_solicitado != 0){
                $data1 = $oconns->ShotSimple("insert into caja_transito (monto_solicitado, idkey_credito) values ('$monto_solicitado', '$idkey_credito')");
                if($oconns->last_id=="") $response["error"] = 1;
            }
            $data2 = $oconns->ShotSimple("update creditos set estatus_desembolso='$idkey_estatus' where idkey='$idkey_credito'");
            //Bitácora
            $data = $oconns->getRows("select nombre from desembolso_estatus where idkey=$idkey_estatus");
            $oconns->ShotSimple("insert into bitacora_creditos(idkey_credito, idkey_usuario, descripcion) values ($idkey_credito, $idkey_usuario, 'Cambio de estatus de desembolso a ".$data[0]["nombre"]."')");
            //Movimientos contables
            movcont_desembolso($idkey_credito, $idkey_estatus, $monto_solicitado, $idkey_usuario);
            echo json_encode($response);
        break;

        case "cambiar_estatus_caja_cajero":
            $idkey_estatus = $_POST["idkey_estatus"];
            $idkey_credito = $_POST["idkey_credito"];
            $response["error"] = 0;
            $oconns->ShotSimple("update creditos set estatus_desembolso='$idkey_estatus' where idkey='$idkey_credito'");
            //Bitácora
            $data = $oconns->getRows("select nombre from desembolso_estatus where idkey=$idkey_estatus");
            $oconns->ShotSimple("insert into bitacora_creditos(idkey_credito, idkey_usuario, descripcion) values ($idkey_credito, $idkey_usuario, 'Cambio de estatus de desembolso a ".$data[0]["nombre"]."')");
            //Movimientos contables
            movcont_desembolso($idkey_credito, $idkey_estatus, 0, $idkey_usuario);
            echo json_encode($response);
        break;

         case "datatable_credito_pago":
            //Consulta de pagos no aprobados
            $query = "select ad.idkey as idkey_pago, vc.idkey_credito, vc.folio, vc.nombre, ad.fecha_valor, ad.pago as monto, ad.idkey_clasif_pago, cp.nombre as tipo, ad.referencia from view_creditos vc inner join amortizaciones_dinamicas ad on (vc.idkey_credito=ad.idkey_creditos) inner join clasificacion_pagos cp on (ad.idkey_clasif_pago=cp.idkey) where aprobado=0 ";
            $data = $oconns->getRows($query);
            $rows = array();
            foreach ($data as $item){ 
                $jsonArrayObject = (array(
                    'folio' => $item["folio"], 
                    'idkey_pago' => $item["idkey_pago"], 
                    'idkey_credito' => $item["idkey_credito"],
                    'nombre' => $item["nombre"], 
                    'fecha_valor' => $item["fecha_valor"],
                    'tipo' => $item["tipo"],
                    'referencia' => $item["referencia"],
                    'monto' => "$".number_format($item["monto"],2),
                    'opciones' => '<pre><a href="#" class="btn radius-1 btn-sm btn-brc-tp btn-outline-default btn-h-outline-success btn-a-outline-success btn-text-success" title="Aplicar Pago" onclick="confirmar_aplicar_pago(\''.$item["idkey_pago"].'\', \''.$item["folio"].'\')"><i class="fas fa-check-square"></i></a>'.
                        '<a href="#" class="btn radius-1 btn-sm btn-brc-tp btn-outline-default btn-h-outline-warning btn-a-outline-warning btn-text-warning"><i class="fa fa-flag"></i></a></pre>'
                ));
                $rows[] = $jsonArrayObject;
            }
            echo json_encode($rows);
        break;

        case "aplicar_pago":
            $idkey_pago = $_POST["idkey_pago"];
            $response["error"] = 0;
            $oconns->ShotSimple("update amortizaciones_dinamicas set aprobado=1, idkey_usuario = '$idkey_usuario', fecha_aprobacion= CURRENT_TIMESTAMP() where idkey='$idkey_pago'");
            echo json_encode($response);
        break;

        case "loadPago":
            $idkey_pago = $_POST["idkey_pago"];
            $response = $modelo->loadPago($idkey_pago);

            echo json_encode($response);

            break;
        
        case "savePago":

            $datos = $_POST["datos"];
            $modelo->savePago($datos);
            $response['error'] = 0;

            echo json_encode($response);
            

            break;


    }
}



?>
