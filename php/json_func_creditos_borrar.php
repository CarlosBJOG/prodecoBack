
<?php
/* Funciones para responder a peticiones de JQuery del módulo Cartera */
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $funcion = $_POST["funcion"]; // tipo de operación
    $idkey_cliente = $_POST['idkey_cliente']; 
    //Conexión a la BD
    require_once "db.php";
    $oconns = new database();

    switch($funcion){
		
		//obtener datos de cliente
		case "datos_perfil_cliente":
            $query = "SELECT vc.idkey_cliente,vc.nombre,vc.fecha_creacion,vc.rfc,cc.email,cc.telefono FROM view_clientes vc inner join clientes_contacto cc on cc.idkey_clientes=vc.idkey_cliente WHERE vc.idkey_cliente=".$idkey_cliente;
            $data = $oconns->getRows($query);
			$rows = array();
			foreach ($data as $item){ 
                $jsonArrayObject = (array(
					 'nombre' => $item["nombre"],
					 'idkey_cliente' => $item["idkey_cliente"],
					 'fecha_creacion' => $item["fecha_creacion"],
					 'rfc' => $item["rfc"],
					 'email'=> $item["email"],
					 'telefono' => $item["telefono"]
				 ));
				$rows[] = $jsonArrayObject;
            }
            echo json_encode($rows);
        break;
		
        //Función recuepra creditos individuales de un cliente
        case "creditos_clientes_individual":
            $query = "SELECT idkey_clientes,idkey_credito,folio,desc_tipo,tipo_credito FROM creditos.view_creditos where estatus=1 and tipo_credito=1 and idkey_clientes=".$idkey_cliente;
            $data = $oconns->getRows($query);
            $rows = array();
            foreach ($data as $item){ 
                $jsonArrayObject = (array(
                    'idkey_cliente' => $item["idkey_clientes"],
                    'idkey_credito' => $item["idkey_credito"],
                    'folio' => $item["folio"],
                    'desc_tipo' => $item["desc_tipo"]
                ));
                $rows[] = $jsonArrayObject;
            }
            echo json_encode($rows);
        break;
		
		//obtener datos de credito individual
		case "info_creditos":
			
            $query = "SELECT vc.*, f.nombre as desc_frec, p.nombre as desc_producto FROM view_creditos vc inner join frecuencia f on vc.idkey_frecuencia=f.idkey inner join productos p on p.idkey=vc.idkey_productos where vc.idkey_credito=".$idkey_cliente;
            $data = $oconns->getRows($query);
			$rows = array();
			foreach ($data as $item){ 
                $jsonArrayObject = (array(
					 'nombre' => $item["nombre"],
					 'idkey_cliente' => $item["idkey_clientes"],
					 'idkey_credito' => $item["idkey_credito"],
					 'folio' => $item["folio"],
					 'monto' => $item["monto"],
					 'plazo' => $item["plazo"],
					 'numero_pagos' => $item["numero_pagos"],
					 'desc_frec' => $item["desc_frec"],
					 'finalidad' => $item["finalidad"],
					 'desc_producto' => $item["desc_producto"],
					 'tipo_credito' => $item["tipo_credito"],
				 ));
				$rows[] = $jsonArrayObject;
            }
            echo json_encode($rows);
        break;
        
		//Función recuepra creditos grupales en los que participa un cliente
        case "creditos_clientes_grupal":
            $query = "SELECT idkey_grupo as idkey_cliente,idkey_credito,folio,desc_tipo FROM creditos.view_clientes_grupo where idkey_cliente=".$idkey_cliente;
            $data = $oconns->getRows($query);
            $rows = array();
            foreach ($data as $item){ 
                $jsonArrayObject = (array(
                    'idkey_cliente' => $item["idkey_cliente"],
                    'idkey_credito' => $item["idkey_credito"],
                    'folio' => $item["folio"],
                    'desc_tipo' => $item["desc_tipo"]
                ));
                $rows[] = $jsonArrayObject;
            }

            echo json_encode($rows);
        break;
		
		 //Lista de clientes que conforman un grupo
        case "socios_cred_grupal":
			$query = "select * from view_clientes_porcentajes where prefolio='".$idkey_cliente."' order by nombre";
            $data = $oconns->getRows($query);
            $rows = array();
            foreach ($data as $item){ 
                $jsonArrayObject = (array(
                    'idkey_cliente' => $item["idkey_cliente"],
                    'nombre' => $item["nombre"],
					'porcentaje' => $item["porcentaje"]
					//'nombre_grupo' => $item["nombre_grupo"]
                ));
                $rows[] = $jsonArrayObject;
            }
			
            echo json_encode($rows);
        break;
        
        case "creditos_pago_progreso":
            /*$query1 = "SELECT count(idkey) as pagados FROM pagos where idkey_creditos=".$idkey_cliente;
            $query2 = "select count(idkey) as total from amortizaciones where idkey_creditos =".$idkey_cliente;
            $data1 = $oconns->getRows($query1);
            $n = $oconns->numberRows();
            $data2 = $oconns->getRows($query2);
            $m = $oconns->numberRows();
            if($n>0 && $m>0)
                $response["Pagos"] = ($data1[0]["pagados"]*100)/$data2[0]["total"];
            else
                $response["Pagos"] = "Error: ".$n."-".$m;*/
            $response["error"] = "Error:";
            echo json_encode($response);
        break;
        
        case "grafica_perfil_cliente":
            $query = "select * from view_pagos_progreso where idkey_clientes=".$idkey_cliente;
            $data = $oconns->getRows($query);
            $rows = array();
            foreach ($data as $item){
                $query2 = "SELECT idkey_credito,idkey_clientes,folio,fecha_pago,fecha_valor,dias,MONTH(fecha_pago) as mes_pago,DAY(fecha_valor) as dia_pago from view_pagos_progreso where idkey_credito=".$item["idkey_credito"]." and idkey_clientes=".$item["idkey_clientes"];
                $data2 = $oconns->getRows($query2);
                //$rows[] = $data2;
            }
            echo json_encode($data2);
        break;
    }
}

?>
