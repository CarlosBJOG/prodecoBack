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
      
        case "datatable_bitacoras_creditos":
            $folio = $_POST["folio"];
            //$data = $oconns->getRows("select folio, descripcion, fecha, concat(g.apellido_p,' ', g.apellido_m, ' ', g.nombre) as usuario from bitacora_creditos bc inner join creditos c on (c.idkey=bc.idkey_credito) inner join usuarios u on (u.idkey=bc.idkey_usuario) inner join empleados e on (e.idkey=u.idkey_empleados) inner join generales g on (g.idkey=e.idkey_generales) where folio = '$folio' order by fecha asc");
            $data = $oconns->getRows("select c.folio, bc.descripcion, bc.fecha, concat(de.apellido_p, ' ',de.apellido_m, ' ', de.nombre) as usuario from creditos c INNER JOIN bitacora_creditos bc ON bc.idkey_credito = c.idkey INNER JOIN usuarios u on (u.idkey_empleados = bc.idkey_usuario) INNER JOIN datos_empleados de ON ( de.idkey = u.idkey_empleados) where folio = '$folio' ORDER BY bc.fecha ASC ");
            
            $rows = array();
            foreach ($data as $item){ 
                $jsonArrayObject = (array(
                    'folio' => $item["folio"], 
                    'descripcion' => "<small>".$item["descripcion"]."</small>",
                    'fecha' => "<pre>".$item["fecha"]."</pre>",
                    'usuario' => "<pre>".$item["usuario"]."</pre>"
                ));
                $rows[] = $jsonArrayObject;
            }
            echo json_encode($rows);
        break;

    }
}



?>
