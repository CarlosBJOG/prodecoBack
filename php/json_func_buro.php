<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    @session_start(); 
    $idkey_usuario = $_SESSION['idkey']; 

    require_once './modelos/BuroModelo.php';
    
    //instancia de clase gastosModelo
    $modelo = new BuroModelo();
    //datos recibidos por ajax
    if(isset($_POST['datos'])){
        $array = $_POST['datos'];
    
    }elseif(isset($_POST['idkey'])){
        $idkey = $_POST['idkey'];
    }

    // tipo de operación
    $funcion = $_POST["funcion"];
    
    switch($funcion){

        case "guardar":
            
            $costoUnitario = $array[0];
            $totalRegistros = $array[1];
            $monto = $array[2];
            $observaciones = $array[3];

            $modelo->guardar_datos($totalRegistros, $costoUnitario, $monto, $idkey_usuario, $observaciones);
            $response['error'] = 0;
            echo json_encode($response);
    
            break;

        case "cargar_tabla":

            //cargamos datos de la tabla gastos cobranza
            $datos = $modelo->listar();
            $rows = array();

            foreach($datos as $item){

                $jsonArrayObject = (array(
                    'idkey' => $item['idkey'],
                    'num_registros' => $item['num_registros'],
                    'costo_unitario' => $item['costo_unitario'],
                    'monto' => $item['monto'],
                    'fecha_registro' => $item['fecha_registro'],
                    'fecha_alta' => $item['fecha_alta'],
                    'observaciones' => $item['observaciones'],
                    'estatus' => $item['estatus'],
                    'desc_estatus' => $item['desc_estatus']
                ));
                $rows[] = $jsonArrayObject;

            }

            echo json_encode($rows);
            break;

        case "aprobar":

            if(empty($array)){
                $response['error'] = 1;
            }else{
                $response['error'] = 0;
           
                $modelo->aprobar_pago($array, $idkey_usuario);
            }     
          
            echo json_encode($response);

            break;
        

    }

}
?>
