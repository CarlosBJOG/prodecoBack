<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    @session_start(); 
    $idkey_usuario = $_SESSION['idkey']; 
    require_once 'clases/conversor.php';
    require_once './modelos/GastosModelo.php';
    
    //instancia de clase gastosModelo
    $gastos = new GastosModelo();

    if(isset($_POST['datos'])){

        $datos = $_POST['datos'];

    }
    $funcion = $_POST["funcion"];
    
    switch($funcion){
        case "cargarCreditos":
            $response = $gastos->datosCreditos();
            echo json_encode($response);
            break;

        case "cargarCredito":
            $idkeyCredito = $datos;
            $response = $gastos->cargarCredito($idkeyCredito);

            echo json_encode($response);
            break;

        case "guardarCobranza": 
            if(empty($datos)){
                $response['error'] = 1;
            }else {

                array_push($datos, $idkey_usuario);
                $gastos->aplicarCobranza($datos);
                $response['error'] = 0;
            }
            echo json_encode($response);
            break;

        case "cargarCobranza": 
            $datos = $gastos->cargarCobranza();
            echo json_encode($datos);
            break; 

        case "tablaCobranza": 
            $datos = $gastos->tablaCajero();
            echo json_encode($datos);
            break; 

        case "updateCobranza":
            $gastos->actualizarCobranza($datos);
            $response['error'] = 0;
            echo json_encode($response);
            break;
         
           
    }

}
?>
