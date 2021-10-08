<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    @session_start(); 
    $idkey_usuario = $_SESSION['idkey']; 

    require_once 'clases/conversor.php';
    require_once 'DacionModelo.php';
    
    //instancia de clase gastosModelo
    $modelo = new DacionModelo();

    

    // tipo de operación
    $funcion = $_POST["funcion"];

    if(isset($_POST['idkey'])){
        $idkey_credito = $_POST['idkey'];
    }elseif(isset($_POST['array'])){
        $array = $_POST['array'];
    }elseif(isset($_POST['idkey_mueble'])){
        $idkey_mueble = $_POST['idkey_mueble'];
    }

function ultimo_pago_credito($idkey_credito){//Ultimo pago diferente de 0 amort dinámica
    $oconns = new database();
    $data = $oconns->getRows("select * from amortizaciones_dinamicas where pago<>0 and idkey_creditos = '".$idkey_credito."' order by no_pago desc ,fecha_valor desc limit 1");
    if($oconns->numberRows >0){
        $res["n"] = 1;
        $res["fecha_ultimo_pago"] = $data[0]["fecha_valor"];
        $res["no_ultimo_pago"] = $data[0]["no_pago"];
    }
    else
        $res["n"] = 0;
    return $res;

    
}

function ultimo_pago_credito1($idkey_credito){//Ultimo pago amort dinámica
    $oconns = new database();
    //Consultar última fila de la amortización dinámica
    $data = $oconns->getRows("select * from amortizaciones_dinamicas where idkey_creditos = '".$idkey_credito."' order by no_pago desc ,fecha_valor desc limit 1 ");//Para obtener el último pago realizado 
    if($oconns->numberRows >0){
        $res["n"] = 1;
        $res["saldo_insoluto"] = $data[0]["saldo_insoluto"];
        $res["no_ultimo_pago"] = $data[0]["no_pago"];
    }
    else
        $res["n"] = 0;
    return $res;
}

function consulta_pago_credito($idkey_credito, $no_pago){//Siguiente pago amort estática
    $oconns = new database();
    $data = $oconns->getRows("select * from amortizaciones_contrato where pago = ".$no_pago." and idkey_creditos = '".$idkey_credito."'");
    if($oconns->numberRows >0){
        $res['pago'] = $no_pago;
        $res["n"] = 1;
        $res["idkey"] = $data[0]["idkey"];
        $res["fecha_pago"] = $data[0]["fecha_pago"];
        $res["cantidad_pagar"] = $data[0]["total"];
        $res["saldo_insoluto"] = $data[0]["saldo_insoluto"];
        $res["capital"] = $data[0]["renta"];
    }
    else
        $res["n"] = 0;
    return $res;
}

    switch($funcion){

        case "cargar_tabla":

            //cargamos datos de la tabla gastos cobranza
            $datos = $modelo->listar();
            $rows = array();

            foreach($datos as $item){
                $idkey_credito = $item["idkey_credito"];
                $ultimo_pago = ultimo_pago_credito($idkey_credito);

                if($ultimo_pago["n"] > 0){
                    $fecha_ultimo_pago = $ultimo_pago["fecha_ultimo_pago"];
                  
                }
                else{
                    $fecha_ultimo_pago = "Ninguno";
                  
                    
                }

                //Consultar último pago para sacar el saldo insoluto
                $ultimo_pago1 = ultimo_pago_credito1($idkey_credito);
                if($ultimo_pago1["n"] > 0){
                    $saldo_insoluto = strval(number_format($ultimo_pago1["saldo_insoluto"],2));
                    $ultimo_pago_dinamica = $ultimo_pago1["no_ultimo_pago"];
                }
                else{
                    $ultimo_pago_dinamica = 0;
                    $saldo_insoluto = strval(number_format($item["monto"],2));//Monto total
                }

                //Consultar siguiente pago en amort estática
                $sig_pago = consulta_pago_credito($idkey_credito, intval($ultimo_pago_dinamica)+1);
                if($sig_pago["n"] > 0){
                    $fecha_pago_temp = $sig_pago["fecha_pago"];
                    //$temp = explode("-",$fecha_pago_temp);
                    //$fecha_pago = $temp[2]."-".$temp[1]."-".$temp[0];
                    $fecha_pago  = $fecha_pago_temp;
                    $cantidad_pagar =  strval(number_format($sig_pago["cantidad_pagar"],2));
                }
                else{
                    $fecha_pago = "Crédito vencido";
                    $cantidad_pagar =  "Crédito vencido";
                }


                 //Para calcular días transcurridos
                 $oconns = new database();
                 $dias_transcurridos = $oconns->getSimple("select DATEDIFF('".$fecha_pago_temp."', NOW()) as dias_transcurridos;");
                 $alerta_revision ="";
                 if($dias_transcurridos > 0)
                        $estatus = "<span class='badge badge-sm bgc-success-l2 text-success-d2 border-1 brc-success-m3'>En tiempo</span>";
                    else if($dias_transcurridos == 0)
                        $estatus = "<pre>".$alerta_revision." <span class='badge badge-sm bgc-warning-l2 text-warning-d2 border-1 brc-warning-m3'>Día de pago</span></pre>";
                    else
                        $estatus = "<pre>".$alerta_revision." <span class='badge badge-sm bgc-danger-l2 text-danger-d2 border-1 brc-danger-m3'>Atrasado</span></pre>";

                $jsonArrayObject = (array(
                    'idkey'=>$item['idkey_credito'],
                    'folio' =>  $item["folio"],
                    'fecha_valor' => $fecha_ultimo_pago,
                    'nombre' => $item['nombre'],
                    'producto' => $item['producto'],
                    'saldo_insoluto' => $saldo_insoluto,
                    'estatus' => $estatus,
                    'desc_estatus' => $item['estatus']
              
                ));
                $rows[] = $jsonArrayObject;

            }

            echo json_encode($rows);
            break;


        case "cargar_datos":
            
                $data = $modelo->cargar_usuario($idkey_credito);
                //Consultar último pago para sacar el saldo insoluto
                foreach($data as $item){
                    $idkey_credito = $item["idkey_credito"];
                    $ultimo_pago = ultimo_pago_credito($idkey_credito);
    
                    if($ultimo_pago["n"] > 0){
                        $fecha_ultimo_pago = $ultimo_pago["fecha_ultimo_pago"];
                    }
                    else{
                        $fecha_ultimo_pago = "Ninguno";
                    }
                        //Consultar último pago para sacar el saldo insoluto
                    $ultimo_pago1 = ultimo_pago_credito1($idkey_credito);
                    if($ultimo_pago1["n"] > 0){
                        $saldo_insoluto = strval(number_format($ultimo_pago1["saldo_insoluto"],2));
                        $ultimo_pago_dinamica = $ultimo_pago1["no_ultimo_pago"];
                        $saldo_insoluto = str_replace(',',' ', $saldo_insoluto);
                    }
                    else{
                        $ultimo_pago_dinamica = 0;
                        $saldo_insoluto = strval(number_format($item["monto"],2));//Monto total
                        $saldo_insoluto = str_replace(',',' ', $saldo_insoluto);
            
                    }

                    $jsonArrayObject = (array(
                        'idkey'=>$item['idkey_credito'],
                        'nombre' =>  $item["nombre"],
                        'saldo' => $saldo_insoluto,
                        'producto' => $item['nombre_producto'],
                  
                    ));
                    $rows[] = $jsonArrayObject;


                }
               
    
                echo json_encode($rows);
    
             break;

        case "guardar_garantia": 

            
            if(empty($array)){
                $response['error'] = 1;
                
            }else{
                
                $idkey_credito = $array[0];
                $categoria = $array[1];
                $valor_comercial = $array[2];
                $marca = $array[3];
                $modelo_garantia = $array[4];
                $ref_factura = $array[5];
                $fecha_ad = $array[6];
                $temp = explode("/", $fecha_ad);
                $fecha_ad = $temp[2].'-'.$temp[1].'-'.$temp[0];
                $cobertura = $array[7];
                $observaciones = $array[8];
                $modelo->guardar_mueble($categoria, $valor_comercial, $marca, $modelo_garantia, $ref_factura, $fecha_ad, $cobertura, $observaciones, $idkey_credito, $idkey_usuario);
          
                $response['error'] = 0;

            
            }

            echo json_encode($response);

        break;

        case "guardar":
          


            if(empty($array)){
                $response['error'] = 1;
            }else{
                $idkey_credito = $array[0];

                $mueble = $modelo->comprobar_mueble($idkey_credito);
                $inmueble = $modelo->comprobar_inmueble($idkey_credito);

                if(empty($mueble) && empty($inmueble)){
                    $response['error'] = 3;
                }else{

                    $no_pago = $modelo->obtener_pago($idkey_credito);

                    if(empty($no_pago)){
                        $response['error'] = 2;
                    }else{
                        $no_pago = $no_pago[0][0];
                        $modelo->actualizar_pago($idkey_credito, $no_pago);
                        $modelo->cambiar_estatus($idkey_credito);
                        $monto = $array[1];
                        $tipo_garantia = $array[2];
                        $fecha_registro = $array[3];
                        $tipo_usuario = $idkey_usuario;

                        $temp = explode("/", $fecha_registro);
                        $fecha_registro = $temp[2].'-'.$temp[1].'-'.$temp[0];
                        
                        $modelo->guardar_datos($tipo_garantia, $idkey_credito, $monto, $fecha_registro, $tipo_usuario);
                        $response['error'] = 0;
                    }
                }

                
            }

           
            echo json_encode($response);
            break;
        
        case "guardar_garantia_inmueble":

            if(empty($array)){
                $response['error'] = 1;
                
            }else{
                
                $idkey_credito = $array[0];
                $categoria = $array[1];
                $valor_fiscal = $array[2];
                $valor_catastral = $array[3];
                $num_escritura = $array[4];
                $registro = $array[5];
                $gravamen = $array[6];
                $hipoteca = $array[7];
                $aforo = $array[8];
                $descripcion = $array[9];
                $observaciones = $array[10];
                $medidas = $array[11];
                $modelo->guardar_inmueble($categoria, $valor_fiscal, $valor_catastral, $num_escritura, $registro, $gravamen, $hipoteca, $aforo, $descripcion, $observaciones, $medidas, $idkey_credito, $idkey_usuario);
          
                $response['error'] = 0;

            
            }

            echo json_encode($response);
            break;

        case "datatable_inmuebles":
            $idkey_credito = $_POST["idkey_credito"];
            $data =$modelo->cargar_inmueble($idkey_credito);

            $response = array();
           
                foreach ($data as $item){ 
                    $idkey_inmueble = $item["idkey"];
                    $acciones =  '<a href="#" class="btn radius-1 btn-sm btn-brc-tp btn-outline-default btn-h-outline-danger btn-a-outline-danger btn-text-danger" title="Eliminar" onclick="eliminar_inmueble('.$idkey_inmueble.')">
                         <i class="fa fa-trash-alt"></i></a>';
                    if($item["numero_escritura"] !="") 
                        $escrituras = "Con escrituras";  
                    else 
                        $escrituras = "Sin escrituras";

                    $jsonArrayObject = (array(
                        'categoria' => $item["categoria"], 
                        'valor_fiscal' => $item["valor_fiscal"], 
                        'valor_catastral' => $item["valor_catastral"], 
                        'escrituras' => $escrituras,
                        'registro' => $item["registro"],  
                        'medidas' => $item["medidas"], 
                        'acciones' => $acciones
                    ));
                    $response[] = $jsonArrayObject;
                }
            
            echo json_encode($response);
            break;

        case "datatable_muebles":
            $idkey_credito = $_POST["idkey_credito"];
            $data =$modelo->cargar_mueble($idkey_credito);
            $response = array();
            if(!empty($data)){
                foreach ($data as $item){ 
                    $idkey_mueble = $item["idkey"];
                    $acciones = '<a href="#" class="btn radius-1 btn-sm btn-brc-tp btn-outline-default btn-h-outline-danger btn-a-outline-danger btn-text-danger" title="Eliminar" onclick="eliminar_mueble('.$idkey_mueble.')"><i class="fa fa-trash-alt"></i></a>';
                    $jsonArrayObject = (array(
                        'categoria' => $item["categoria"], 
                        'valor' => $item["valor_comercial"], 
                        'modelo' => $item["modelo"], 
                        'marca' => $item["marca"], 
                        'factura' => $item["ref_o_fact"], 
                        'fecha' => $item["fecha_adquisicion"],
                        'observaciones' => $item["observaciones"],   
                        'acciones' => $acciones
                    ));
                    $response[] = $jsonArrayObject;
                }
            }
            echo json_encode($response);
            break;

        case "borrar_mueble":
            if(!empty($idkey_mueble)){

                $modelo->eliminar_mueble($idkey_mueble);
                $response['error'] = 0;
            }
            else{ 
                $response['error'] = 1;
            }
            echo json_encode($response);
            break;

            
        case "borrar_inmueble":
            if(!empty($idkey_mueble)){

                $modelo->eliminar_inmueble($idkey_mueble);
                $response['error'] = 0;
            }
            else{ 
                $response['error'] = 1;
            }
            echo json_encode($response);
            break;

    }

}
?>
