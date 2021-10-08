<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    @session_start(); 
    $idkey_usuario = $_SESSION['idkey']; 
    $tipo_usuario = $_SESSION['tipo_usuario']; 

    require_once 'modelos/perfilesModelo.php';
    
    //instancia de clase gastosModelo
    $modelo = new perfilesModelo();


    //datos recibidos por ajax
    if(isset( $_POST["datos"])){
        $datos = $_POST['datos'];
    }
    // tipo de operación
    $funcion = $_POST["funcion"];
 
    
    switch($funcion){
        case "verificarUsuario":

            $response = $tipo_usuario;

            echo json_encode( $response );
            break;

        case "infoPersonalUsuario" :

            $response = $modelo->infoPersonal( $idkey_usuario );

            echo json_encode( $response );
            break; 
        
        case "infoPromotorClientes":

            $response = $modelo->clientesPromotor( $idkey_usuario );

            echo json_encode( $response );
            break;

        case "infoPromotorCreditos":

            $response = $modelo->creditosPromotor( $idkey_usuario );

            echo json_encode( $response );
            break;

        case "creditosPromotor":

            $rows = array();
            $datos = $modelo->creditosPromotorComp( $idkey_usuario );
            foreach($datos as $value) {
                $jsonArrayObject = (array(
                    'fecha_creacion' => $value["fecha_creacion"], 
                    'folio' => $value["folio"], 
                    'idkey_credito' => $value["idkey_credito"], 
                    'monto' => $value["monto"], 
                    'nombre' => $value["nombre"], 
                    'nombre_producto' => $value["nombre_producto"]
                ));
                $rows[] = $jsonArrayObject;
            }

            echo json_encode( $rows );
            break;

        case "clientesPromotor":

            $rows = array();
            $datos = $modelo->clientesPromotorComp( $idkey_usuario );
            foreach($datos as $value) {
                $jsonArrayObject = (array(
                    'fecha_creacion' => $value["fecha_creacion"], 
                    'idkey_cliente' => $value["idkey_cliente"], 
                    'nombre' => $value["nombre"], 
     
                ));
                $rows[] = $jsonArrayObject;
            }

            echo json_encode( $datos );
            break;

        case "polizaDiario":

            $response = $modelo->polizaDiario( $idkey_usuario );

            echo json_encode( $response );
            break;

        
        case "polizaIngreso":

            $response = $modelo->polizaIngreso( $idkey_usuario );

            echo json_encode( $response );
            break;

                
        case "polizaEgreso":

            $response = $modelo->polizaEgreso( $idkey_usuario );

            echo json_encode( $response );
            break;

            
        case "polizaOrden":

            $response = $modelo->polizaOrden( $idkey_usuario );

            echo json_encode( $response );
            break;


    }

}
?>
