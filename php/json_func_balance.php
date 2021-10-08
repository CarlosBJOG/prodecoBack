<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $funcion = $_POST["funcion"]; // tipo de operación
    @session_start(); 
    $idkey_usuario = $_SESSION['idkey']; 
    require_once 'clases/conversor.php';

    //Conexión a la BD
    require_once "db.php";
    $oconns = new database();

    switch($funcion){
      
        case "datatable_balance":
            $temp = explode("/",$_POST["fecha_inicio"]);
            $fecha_inicio = $temp[2]."-".$temp[1]."-".$temp[0];
            $temp = explode("/",$_POST["fecha_fin"]);
            $fecha_fin = $temp[2]."-".$temp[1]."-".$temp[0];
            $data = $oconns->getRows("select mc.idkey, mc.idkey_cuenta_contable, mc.debe, mc.haber, mc.idkey_credito, mc.observaciones, mc.fecha, mc.idkey_usuario, c.folio, cc.nombre from movimientos_contables mc INNER JOIN creditos c ON mc.idkey_credito = c.idkey INNER JOIN cuentas_contables cc ON mc.idkey_cuenta_contable = cc.no_cuenta WHERE mc.fecha BETWEEN '".$fecha_inicio." 00:00:00' AND '".$fecha_fin." 23:59:59'");
            $rows = array();
            foreach ($data as $item){ 
                $jsonArrayObject = (array(
                    'folio' => $item["folio"], 
                    'no_cuenta' => "<small>".$item["idkey_cuenta_contable"]."</small>",
                    'nombre_cuenta' => "<small>".$item["nombre"]."</small>",
                    'fecha' => "<pre>".$item["fecha"]."</pre>",
                    'debe' => "$".number_format($item["debe"],2),
                    'haber' => "$".number_format($item["haber"],2)
                ));
                $rows[] = $jsonArrayObject;
            }
            echo json_encode($rows);
        break;

    }
}



?>
