<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    @session_start(); 
    $idkey_usuario = $_SESSION['idkey']; 

    require_once 'clases/conversor.php';
    require_once './modelos/FacturacionModelo.php';
    
    //instancia de clase gastosModelo
    $modelo = new FacturacionModelo();
    //datos recibidos por ajax
    if( isset($_POST['fecha_inicio']) && isset($_POST['fecha_final']) ){
        $fecha_inicio = $_POST['fecha_inicio'];
        $fecha_fin = $_POST['fecha_final'];
        ( isset($_POST['idkey_credito'])) ?$idkey_credito = $_POST['idkey_credito'] : '' ;
    
        
    
    }elseif( isset($_POST['idkey_credito'])){
        $idkey_credito = $_POST['idkey_credito'];

    }

    // tipo de operación
    $funcion = $_POST["funcion"];
    
    switch($funcion){

        case "buscar_datos":
            //consulta
            if(empty($fecha_inicio) || empty($fecha_fin)){
                $datos =[];
            }else{
                $datos = $modelo->cargar_datos($fecha_inicio, $fecha_fin);
            }
            $response = $datos;
                    
            echo json_encode($response);

            break;

        case "cargarInfoCliente":
            
            if(empty($idkey_credito)){
                $datos =[];
            }else{
                $datos = $modelo->cargarInfoClienteCredito($idkey_credito);
            }
            $response = $datos;

            echo json_encode($response);
            break;

        case "cargar_pago":
               //consulta
            if(empty($fecha_inicio) || empty($fecha_fin)){
                $datos =[];
            }else{
                $datos = $modelo->cargar_pagos($fecha_inicio, $fecha_fin, $idkey_credito);
              
            }
            $response = $datos;
                    

            echo json_encode($response);
            break;
        
    }

}
?>
