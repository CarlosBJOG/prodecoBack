<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    @session_start(); 
    $idkey_usuario = $_SESSION['idkey']; 
    require_once 'clases/conversor.php';
    require_once 'QuitarpagoModelo.php';
    
    //instancia de clase gastosModelo
    $modelo = new QuitarpagoModelo();
    //datos recibidos por ajax
    if(isset($_POST['datos'])){
        $idkey_credito = $_POST['datos'];
    
    }elseif(isset($_POST['value'])){
        $idkey = $_POST['value'];

    }elseif(isset($_POST['idkey'])){
        $id = $_POST['idkey'];

    }elseif(isset($_POST['fecha'])){
        $fecha = $_POST['fecha'];
    }elseif(isset($_POST['array'])){
        $array = $_POST['array'];
    }

    // tipo de operación
    $funcion = $_POST["funcion"];
    
    switch($funcion){

        case "cargar_clientes":
            //informacion que viene de js
            $datos = $modelo->cargar($idkey_credito);
            $rows = array();

            foreach ($datos as $item){ 
                $jsonArrayObject = (array(
                    'idkey_credito' => mb_strtoupper($item["idkey_credito"]),
                    'nombre' => mb_strtoupper($item["nombre"])
                ));
                $rows[] = $jsonArrayObject;
            }

            
            echo json_encode($rows);
            break;
        
        case "cargar_no_pagos":

            $data = $modelo->cargar_datos($idkey);
            $rows[] = array();
            if(empty($data)){
                $response['error'] = 1;
            }else{
                $data = $modelo->cargar_saldos($idkey);

                if(empty($data)){
                    $response['error'] = 1;
                }else{
                    foreach($data as $item){

                        $jsonArrayObject = (array(
                            'saldo_est' => $item['saldo_estatico'],
                            'saldo_din' => $item['saldo_dinamico'],
                            'no_pago' => $item['no_pago'],
                            'nombre' => $item['nombre'],
                            'dias' => $modelo->dias_transcurridos($item['fecha_valor']),
                            'frecuencia' => $item['idkey_frecuencia']        
                        ));
                        $rows[] = $jsonArrayObject;
                        $response['error'] = 0;
                        $response['datos'] = $rows;
        
                    }
                    
                }
                
            }             
            echo json_encode($response);
            break;

        case "comprobar_monto":
            //cargamos el monto actual
            $data = $modelo->cargar_saldos($id);
            if(empty($data)){
                $response['error'] = 1;
            }else{
                $response['datos'] = $data[0]['saldo_dinamico'];
                $response['error'] = 0;
            }

            echo json_encode($response);
            break;

        case 'dias_transcurridos':
            $dias = $modelo->dias_transcurridos($fecha);

            if(empty($dias)){
                $response['error'] = 1;
            }else{
                $response['fecha'] = $dias;
                $response['error'] = 0;
            }

            echo json_encode($response);
            break;
        
        case 'guardar_datos':

            $idkey_credito =(int) $array[0];
            $num_pago = (int) $array[1];
            $folio = $array[2];
            //fecha 
            $fecha_registro = $array[3];
            $temp = explode("/", $fecha_registro);
            $fecha_registro = $temp[2].'-'.$temp[1].'-'.$temp[0];
            $monto = (float) $array[4];

            if(!empty($idkey_credito) && !empty($num_pago) && !empty($folio) && !empty($fecha_registro) && !empty($monto)){
                $modelo->guardar_datos($idkey_credito, $num_pago, $folio, $fecha_registro, $monto, $idkey_usuario);
                $modelo->actualizar_capital($idkey_credito, $monto, $num_pago);
                $response['error'] = 0;
            }else{
                $response['error'] = 1;
            }
            
            echo json_encode($response);
            break;
    }

}
?>
