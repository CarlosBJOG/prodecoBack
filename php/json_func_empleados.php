<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    @session_start(); 
    $idkey_usuario = $_SESSION['idkey']; 

    require_once 'clases/conversor.php';
    require_once 'modelos/EmpleadosModelo.php';
    
    //instancia de clase gastosModelo
    $modelo = new EmpleadosModelo();

    //datos recibidos por ajax
    if(isset( $_POST["valor"])){
        $valor = $_POST['valor'];
    }elseif (isset($_POST["datos"])){
        $datos_empleado = $_POST['datos'];
    }elseif (isset($_POST["id"])){
        $idkey_empleado = $_POST['id'];
    }elseif (isset($_POST["array"])){
        $datos_usuario = $_POST['array'];
    }elseif (isset($_POST["idkey"])){
        $idkey = $_POST['idkey'];
    }
    // tipo de operación
    $funcion = $_POST["funcion"];
 
    
    switch($funcion){

        case "cargar_sexo":

            $datos = $modelo->sexo();
            $rows = [];
            if(empty($datos)){
                $response['error'] = 1;
            }else{
                $response = $datos;
            }
         
            echo json_encode($response);
    
            break;

        case "cargar_estados":

            $estados = $modelo->estados();
            if(empty($estados)){
                $response['error'] = 1;
            }else{
                $response = $estados;
            }
            echo json_encode($response);
            break;

        case "cargar_delegacion":

            $municipios = $modelo->delegacion($valor);
            if(empty($municipios)){
                $response['error'] = 1;
            }else{
                $response = $municipios;
                
            }

            echo json_encode($response);
            break;
        
        case "cargar_localidad":
            $localidades = $modelo->localidad($valor);

            if(empty($localidades)){
                $response['error'] = 1;
            }else{
                $response = $localidades;
                
            }
            echo json_encode($localidades);
            break;

        case "cargar_cp":
            $codigo = $modelo->cp($valor);

            if(empty($codigo)){
                $response['error'] = 1;
            }else{
                $response = $codigo;
            }

            echo json_encode($codigo);

            break;
        
        case "guardar_empleado":

            if(empty($datos_empleado)){
                $response['error'] = 1;
            }else{
             
                $modelo->guardar_empleado($datos_empleado);
                $response['error'] = 0;
            }

            echo json_encode($response);

            break; 

        case "cargar_rfc":

            $response = $modelo->cargar_rfc();
            echo json_encode($response);

            break;
        
        case "cargar_tabla": 
            $datos = $modelo->cargar_empleados();

            if(empty($datos)){
                $response['error'] = 1;
            }else{

                $response = $datos;

            }
            echo json_encode($response);

            break;

        case "permisos": 

            $permisos = $modelo->cargar_permisos();

            if(empty($permisos)){
                    $response = 1;
            }else {
                    $response = $permisos;
            }
            echo json_encode($response);
            
            
            break;

        case "guardar_usuario": 
            $idkey_usuario = $datos_usuario[0];
            $nombre = $datos_usuario[1];
            $pass = $datos_usuario[2];
            $permiso = $datos_usuario[3];

            $modelo->guardar_usuario($nombre, $pass, $idkey_usuario, $permiso);
            $response = 0;
            echo json_encode($response);

            break;
        
        
        case "cargar_usuario":
            $usuario = $modelo->cargar_info_usuario($idkey);
            $response = $usuario;
            echo json_encode($usuario);

            break;

        case "guardar_edicion":

            (empty($datos_usuario))
                ?    $response = 0
                :
                $idkey = $datos_usuario[0];
                $perfil = $datos_usuario[1];
                $usuario = $datos_usuario[2];
                if (empty($idkey) || empty($perfil) || empty($usuario)){
                     
                     $response = 0;
                }else{
                    $modelo->update_user($idkey, $perfil, $usuario);
                    $response = 1;
                }    

            echo json_encode($response);
            
            break;
        

        case "delete":
            if(empty($idkey)){
                $response = 0;
            }else{
                $modelo->delete_user($idkey);
                $response = 1;

            }

            echo json_encode($response);

            break;

        case "cargar_empleado":
            $datos = $modelo->cargar_empleado($idkey);

            $response = $datos;
            echo json_encode($response);
            break;

        case "ultimo_empleado":

            $idkey = $modelo->ulti_registro();
            $response = $idkey[0]['idkey'];
            
            echo json_encode($response);
            break;

        case "guardar_edit_empleado":
            if(empty($datos_empleado)){
                $response['error'] = 1;
            }else{
                $modelo->guardar_edit_empleado($datos_empleado);
                $response['error'] = 2;
            }

      
            echo json_encode($response);
            break;

        case "cargar_parentesco":
            $datos = $modelo->cargar_parentesco();

            if(empty($datos)){
                $response['error'] = 1;
            }else{
                $response = $datos;
            }
         
            echo json_encode($response);

            break; 

        case "guardar_familiar":

            if(empty($datos_empleado)){
                $response['error'] = 1;
            }else{
             
                $modelo->guardar_familiar($datos_empleado);
                $response['error'] = 0;
            }

            echo json_encode($response);

            break;
        
        case "validar_fam":

            if(empty($idkey)){
                $response['error'] = 1;
            }else{
                $num = $modelo->contar_familiar($idkey);
                $response = $num;
            }
            echo json_encode($response);
            break;

        case "cargar_fam":

            $response = array();
            $data = $modelo->cargar_familiares($idkey);

            if (empty($data)){
                $response['error'] = 1;
            }else{
                foreach ($data as $item){ 
                    $idkey_contacto = $item["idkey"];
                    $acciones =  '<a href="#" class="btn radius-1 btn-sm btn-brc-tp btn-outline-default btn-h-outline-primary btn-a-outline-primary btn-text-primary" onclick="editar_familiar('.$idkey_contacto.');" title="Editar" onclick="cargar_contacto();"><i class="fa fa-pencil-alt"></i></a>'.
                        '<a href="#" class="btn radius-1 btn-sm btn-brc-tp btn-outline-default btn-h-outline-danger btn-a-outline-danger btn-text-danger" title="Eliminar" onclick="eliminar_familiar('.$idkey_contacto.');"><i class="fas fa-eraser"></i></a>';
                  
                    $jsonArrayObject = (array(
                        'id' => $item["idkey"], 
                        'nombre' => $item["nombre"], 
                        'fecha' => $item["fecha_registro"],
                        'ine' => $item["ine"],
                        'celular' => $item["num_cel"], 
                        'empleado' => $item["empleado"], 
                        'parentesco' => $item["familiar"],
                        'domicilio' => $item["domicilio"],
                        'acciones' => $acciones
                    ));
                    $response[] = $jsonArrayObject;
                }
            }

            echo json_encode($response);
            break;

        case "delete_fam":
            if(empty($idkey)){
                $response['error'] = 1;
            }else{
                $modelo->eliminar_familiar($idkey);
                $response['error'] = 0;
            }

            echo json_encode($response);
            break;

        case "cargar_info_fam":
            if(empty($idkey)){
                $response['error'] = 1;
            }else{
                $datos = $modelo->cargar_familiar($idkey);
                $response = $datos;
            }

            echo json_encode($response);
            break;

        case "actualizar_fam":
      
                if (empty($datos_empleado) ){
                    
                    $response['error'] = 1;
                }else{
                    $modelo->update_fam($datos_empleado);
                    $response = 1;
                }    
        


            echo json_encode($response);
            break;

    }

}
?>
