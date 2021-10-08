<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    @session_start(); 
    $idkey_usuario = $_SESSION['idkey']; 
    $nombre_usuario = $_SESSION['nombre'];

    require_once './modelos/GarantiasModelo.php';
    
    //instancia de clase gastosModelo
    $modelo = new GarantiasModelo();
    //datos recibidos por ajax
    if(isset($_POST['datos'])){
        $datos = $_POST['datos'];
    
    }
    // tipo de operación
    $funcion = $_POST["funcion"];
      
    switch($funcion){

        case "cargarCreditos": 

            $response = $modelo->cargarCreditos();

            echo json_encode($response);
            break;

        
        case "cargarCredito": 

            $response = $modelo->cargarCredito($datos);

            echo json_encode($response);
            break;

        case "guardarSeguro":
            array_push($datos, $idkey_usuario);

            $modelo->guardarSeguro($datos);
            $response['error'] = 0;

            echo json_encode($response);
            break;

        case "movEfectivo":
            array_push($datos, $idkey_usuario);

            $modelo->guardarMovContableEfectivo($datos);
            $response['error'] = 0;

            echo json_encode($response);
            break;
        case "movEfectivoHaber":
            array_push($datos, $idkey_usuario);

            $modelo->guardarMovContableEfectivoHaber($datos);
            $response['error'] = 0;

            echo json_encode($response);
            break;


        case "movBanco":
            array_push($datos, $idkey_usuario);

            $modelo->guardarMovContableBanco($datos);
            $response['error'] = 0;

            echo json_encode($response);
            break;
        case "movBancoHaber":
            array_push($datos, $idkey_usuario);

            $modelo->guardarMovContableBancoHaber($datos);
            $response['error'] = 0;

            echo json_encode($response);
            break;

        case "cargarSeguros":

            $response = $modelo->cargarSeguros($datos);

            echo json_encode($response);
            break;

        case "cargarCreditosGrupales":
            $response = $modelo->cargarCreditosGrupales();

            echo json_encode($response);
            break;
            
        case "cargarCreditoGrupal":

            $response = $modelo->cargarCreditoGrupal($datos);

            echo json_encode($response);
            break;

        case "cargarMaxSeguros":
            $idkey_cliente = $datos[0];
            $idkey_credito = $datos[1];

            $response = $modelo->cargarMaxSeguro($idkey_credito, $idkey_cliente);

            echo json_encode($response);
            break;

        case "cargarSeguroActual":
            $idkey_cliente = $datos[0];
            $idkey_credito = $datos[1];

            $response = $modelo->cargarSeguroActual($idkey_credito, $idkey_cliente);

            echo json_encode($response);
            break;

        case "guardarRetiro":
            array_push($datos, $idkey_usuario);

            $modelo->guardarRetiro($datos);
            $response['error'] = 0;

            echo json_encode($response);
            break;

        case "updateSeguros":
            

            $modelo->updateSeguros($datos);
            $response['error'] = 0;

            echo json_encode($response);
            break;

        case "cargarCreditoGarantia":
            $response = $modelo->cargarCreditoGarantia($datos);

            echo json_encode($response);
            break;

        case "guardarGarantia":
            array_push($datos, $idkey_usuario);
            $modelo->guardarGarantia($datos);
            $response['error'] = 0;
            echo json_encode($response);
            break;

        case "cargarGarantias":

            $response = $modelo->cargarGarantias();

            echo json_encode($response);
            break;

        case "cargarGarantiaCliente": 
            $response = $modelo->cargarGarantia($datos);

            echo json_encode($response);
            break;

        case "guardarGarantiaRetiro":

            array_push($datos, $idkey_usuario);
            $modelo->guardarGarantiaRetiro($datos);
            $response['error'] = 0;
            echo json_encode($response);
            break;

        case "updateGarantiaRetiro":

            $modelo->updategarantias($datos);
            $response['error'] = 0;
            echo json_encode($response);
            break;




            
            

    }

}
?>
