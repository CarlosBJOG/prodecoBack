<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    @session_start(); 
    $idkey_usuario = $_SESSION['idkey']; 

    require_once 'clases/conversor.php';
    require_once 'modelos/ctasModelo.php';
    
    //instancia de clase gastosModelo
    $modelo = new ctaModelo();

    //datos recibidos por ajax
    if(isset( $_POST["id"])){
        $idkey = $_POST['id'];
    }elseif(isset($_POST["array"])){
        $datos = $_POST['array'];
    }
    // tipo de operación
    $funcion = $_POST["funcion"];
 
    
    switch($funcion){

        case "cargar_tabla":

            $response = $modelo->cargar_cuentas();

            echo json_encode($response);
            break;

        case "cargar_cuenta":
            $datos = $modelo->cargar_cta($idkey);

            if(count($datos) > 0){
                $response = $datos;
            }else{
                $response['error'] = 1; // array vacio
            }
            echo json_encode($datos);
            break;

        case "actualizar_cuenta":
            if(empty($datos)){
                $response['error'] = 0; // 
            }else{
                $modelo->update_cuenta($datos);
                $response['error'] = 1; 
            }
            
            echo json_encode($response);
            break;
        case "agregar_cuenta":
            if(empty($datos)){
                $response['error'] = 0; // 
            }else{
                $modelo->agregar_cuenta($datos);
                $response['error'] = 1; 
            }

            echo json_encode($response);
            break;
    }

}
?>
