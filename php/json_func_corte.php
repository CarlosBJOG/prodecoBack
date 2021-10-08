<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    @session_start(); 
    $idkey_usuario = $_SESSION['idkey']; 
    $nombre_usuario = $_SESSION['nombre'];

    require_once './modelos/CorteModelo.php';
    
    //instancia de clase gastosModelo
    $modelo = new CorteModelo();
    //datos recibidos por ajax
    if(isset($_POST['datos'])){
        $array = $_POST['datos'];
    
    }elseif( isset($_POST['valor']) ){
        $idkey_caja = $_POST['valor'];
    }elseif( isset($_POST['idkey']) ){
        $idkey_corte = $_POST['idkey'];
    }

    // tipo de operación
    $funcion = $_POST["funcion"];
      
    switch($funcion){

        case "ultimo_corte": 
            $datos = $modelo->ultimo_registro($idkey_usuario);
            $response = $datos;       
            echo json_encode($response);
            break;

        case "cargar_usuario":
            $jsonArrayObject = array( 
                "usuario" => $idkey_usuario,
                "nombre_usuario" => $nombre_usuario
            );
            
            $response = $jsonArrayObject; 
            echo json_encode($response);
            break;

        case "abrir_corte": 
            if(empty($array)){
                $response['error'] = 0;//datos vacios
            }else{
                array_push($array, $idkey_usuario);
                $modelo->abrir_corte($array);
                $response['error'] = 1;
            }
           
            echo json_encode($response);
            break; 

        case "cargarTableCorte":
            $datos = $modelo->cargar_corte($idkey_usuario);
            echo json_encode($datos);
            break; 

        case "guardarCorte" : 

            if(empty($array)) {
                $response = 0;
            }else{
                array_push($array, $idkey_usuario);
                $modelo->guardarCorte($array);
                $response = 1;
            }

            echo json_encode( $response );
            break;

        case "cargarTiposUsuario" : 

            $response = $modelo->cargarTiposUsuario();
            echo json_encode( $response );
            break;

        case "encriptar" : 

            $response = $modelo->encriptarPass($idkey_corte);

            echo json_encode( $response );
            break;

        case "updateTraficoCorte": 
            $datos = [$idkey_corte];
            array_push($datos, $idkey_usuario);
            $response = $modelo->updateCorte($datos);

            echo json_encode( $datos );
            break;

        case "cargarFondo" : 
            $response = $modelo->cargarFondo($idkey_usuario);
            echo json_encode( $response);
            break;

        case 'cargarHistorial' : 

            
            $response = $modelo->cargarHistorial( $idkey_usuario );

            echo json_encode( $response );
            break;

        case 'cargarHistorialCompleto': 

        
            $response = $modelo->cargarHistorialCompleto( );

            echo json_encode( $response );
            break;

        case "cargarPagosCorte":

            $response = $modelo->cargarPagosCorte( $idkey_corte );

            echo json_encode( $response );
            break;

            

 


    }

}
?>
