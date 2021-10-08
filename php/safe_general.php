<?php
	require_once "db.php";


  if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {

    	$module = $_POST["module"];


    	switch($module)
    	{
            //Casos administración de empleados 
            
    		case "employee_new":
    		{
				$nombre=$_POST["nombre"];
				$apellido_p=$_POST["apellido_p"];
				$apellido_m=$_POST["apellido_m"];
				$edad=$_POST["edad"];
				$sexo=$_POST["sexo"];
				$domicilio=$_POST["domicilio"];


				$domicilio = preg_replace("/[\r\n|\n|\r]+/", PHP_EOL, $domicilio);
				$estados=$_POST["estados"];
				$municipios=$_POST["municipios"];
				$localidad=$_POST["localidad"];
				$codigo_postal=$_POST["codigo_postal"];
				$ine=$_POST["ine"];
				$rfc=$_POST["rfc"];
				$telefono1=$_POST["telefono1"];
				$telefono2=$_POST["telefono2"];
				$telefono3=$_POST["telefono3"];
				$email=$_POST["email"];
				$familiares = $_POST["familiares"];
				$departamentos=$_POST["departamentos"];
				$puestos = $_POST["puestos"];

				$oconns = new database();				
				$oconns->ShotSimple("insert into direcciones(domicilio,idkey_estados,idkey_municipios,idkey_localidad,idkey_codigo_postal) values('".$domicilio."','".$estados."','".$municipios."','".$localidad."','".$codigo_postal."');");
				$idkey_direccion = $oconns->last_id;
				

				
				$oconns->ShotSimple("insert into generales(nombre,apellido_p,apellido_m,edad,idkey_sexo,ine,rfc,idkey_direcciones,telefono1,telefono2,telefono3,email) values('".$nombre."','".$apellido_p."','".$apellido_m."','".$edad."','".$sexo."','".$ine."','".$rfc."','".$idkey_direccion."','".$telefono1."','".$telefono2."','".$telefono3."','".$email."');");
				$idkey_datos_generales=$oconns->last_id;
				
				$oconns->ShotSimple("insert into empleados(idkey_generales,idkey_departamentos,idkey_puestos) values('".$idkey_datos_generales."',
					'".$departamentos."','".$puestos."');");				
				$idkey_empleados=$oconns->last_id;


				if (strlen($familiares)>0)
				{
					$bigs= explode("/",$familiares);
					for($i=0;$i<count($bigs);$i++)
					{


						
						$temp = explode("|",$bigs[$i]);
						if ($temp[11]=="0")
						{							
							$oconns->ShotSimple("insert into direcciones(domicilio,idkey_estados,idkey_municipios,idkey_localidad,idkey_codigo_postal) values('".$temp[6]."','".$temp[7]."','".$temp[8]."','".$temp[9]."','".$temp[10]."');");
							$idkey_direccions = $oconns->last_id;
						}
						else
						{
							$idkey_direccions = $idkey_direccion;
						}

						$oconns->ShotSimple("insert into generales(nombre,apellido_p,apellido_m,edad,idkey_sexo,ine,rfc,idkey_direcciones,telefono1,telefono2,telefono3,email) values('".$temp[0]."','".$temp[1]."','".$temp[2]."','".$temp[3]."','".$temp[4]."','".$temp[12]."','".$temp[13]."','".$idkey_direccions."','".$temp[14]."','".$temp[15]."','".$temp[16]."','".$temp[17]."');");
						$idkey_general_familiares= $oconns->last_id;


						$oconns->ShotSimple("insert into familiares(idkey_empleados,idkey_generales,idkey_parentesco) values('".$idkey_empleados."','".$idkey_general_familiares."','".$temp[5]."');");
						$idkey_general_familiares= $oconns->last_id;
					}
				}
				echo "OK";
				break;
    		}
    		case "employee_delete":{

    			$param1 = $_POST["param1"];
    			$param2 = $_POST["param2"];

    			


    			$datas = explode("/",$param2);
    			$final = "";
				for($i=0;$i<count($datas);$i++)
				{


					if ($param1!=$i)
					{
						$final=$final.$datas[$i]."/";
					}


				}

				if ($final=="/") $final="";

				if (strlen($final)>0) $final= substr($final,0,strlen($final)-1);

				echo $final;

    			break;
    		}

    		case "employee_update":
    		{
    			$idkey=$_POST["idkey"];
    			$idkey_generales = $_POST["idkey_generales"];
    			$idkey_direcciones = $_POST["idkey_direcciones"];
				$nombre=$_POST["nombre"];
				$apellido_p=$_POST["apellido_p"];
				$apellido_m=$_POST["apellido_m"];
				$edad=$_POST["edad"];
				$sexo=$_POST["sexo"];
				$domicilio=$_POST["domicilio"];


				$domicilio = preg_replace("/[\r\n|\n|\r]+/", PHP_EOL, $domicilio);
				$estados=$_POST["estados"];
				$municipios=$_POST["municipios"];
				$localidad=$_POST["localidad"];
				$codigo_postal=$_POST["codigo_postal"];
				$ine=$_POST["ine"];
				$rfc=$_POST["rfc"];
				$telefono1=$_POST["telefono1"];
				$telefono2=$_POST["telefono2"];
				$telefono3=$_POST["telefono3"];
				$email=$_POST["email"];
				$familiares = $_POST["familiares"];
				$departamentos=$_POST["departamentos"];
				$puestos = $_POST["puestos"];



				$oconns = new database();


				echo ("update direcciones set domicilio='".$domicilio."',idkey_estados='".$estados."',idkey_municipios='".$municipios."',idkey_localidad='".$localidad."',idkey_codigo_postal='".$codigo_postal."' where idkey='".$idkey_direcciones."';");

				$oconns->ShotSimple("update direcciones set domicilio='".$domicilio."',idkey_estados='".$estados."',idkey_municipios='".$municipios."',idkey_localidad='".$localidad."',idkey_codigo_postal='".$codigo_postal."' where idkey='".$idkey_direcciones."';");
				$idkey_direccion = $idkey_direcciones;
				
				echo ("update generales set nombre='".$nombre."',apellido_p='".$apellido_p."',apellido_m='".$apellido_m."',edad='".$edad."',idkey_sexo='".$sexo."',ine='".$ine."',rfc='".$rfc."',telefono1='".$telefono1."',telefono2='".$telefono2."',telefono3='".$telefono3."',email='".$email."' where idkey='".$idkey_generales."';");

				$oconns->ShotSimple("update generales set nombre='".$nombre."',apellido_p='".$apellido_p."',apellido_m='".$apellido_m."',edad='".$edad."',idkey_sexo='".$sexo."',ine='".$ine."',rfc='".$rfc."',telefono1='".$telefono1."',telefono2='".$telefono2."',telefono3='".$telefono3."',email='".$email."' where idkey='".$idkey_generales."';");
				$idkey_datos_generales=$idkey_generales;

				$oconns->ShotSimple("update empleados set idkey_departamentos='".$departamentos."',idkey_puestos='".$puestos."' where idkey='".$idkey."';");


				echo ("delete from familiares where familiares.idkey_empleados=".$idkey.";");
				$oconns->ShotSimple("delete from familiares where familiares.idkey_empleados=".$idkey.";");				
				$idkey_empleados=$idkey;
				if (strlen($familiares)>0)
				{
					$bigs= explode("/",$familiares);
					for($i=0;$i<count($bigs);$i++)
					{
						
						$temp = explode("|",$bigs[$i]);
						if ($temp[11]=="0")
						{
							echo ("insert into direcciones(domicilio,idkey_estados,idkey_municipios,idkey_localidad,idkey_codigo_postal) values('".$temp[6]."','".$temp[7]."','".$temp[8]."','".$temp[9]."','".$temp[10]."');");						
							$oconns->ShotSimple("insert into direcciones(domicilio,idkey_estados,idkey_municipios,idkey_localidad,idkey_codigo_postal) values('".$temp[6]."','".$temp[7]."','".$temp[8]."','".$temp[9]."','".$temp[10]."');");
							$idkey_direccions = $oconns->last_id;
						}
						else
						{
							$idkey_direccions = $idkey_direccion;
						}						
						echo ("insert into generales(nombre,apellido_p,apellido_m,edad,idkey_sexo,ine,rfc,idkey_direcciones,telefono1,telefono2,telefono3,email) values('".$temp[0]."','".$temp[1]."','".$temp[2]."','".$temp[3]."','".$temp[4]."','".$temp[12]."','".$temp[13]."','".$idkey_direccions."','".$temp[14]."','".$temp[15]."','".$temp[16]."','".$temp[17]."');");
						$oconns->ShotSimple("insert into generales(nombre,apellido_p,apellido_m,edad,idkey_sexo,ine,rfc,idkey_direcciones,telefono1,telefono2,telefono3,email) values('".$temp[0]."','".$temp[1]."','".$temp[2]."','".$temp[3]."','".$temp[4]."','".$temp[12]."','".$temp[13]."','".$idkey_direccions."','".$temp[14]."','".$temp[15]."','".$temp[16]."','".$temp[17]."');");
						$idkey_general_familiares= $oconns->last_id;
						echo ("insert into familiares(idkey_empleados,idkey_generales,idkey_parentesco) values('".$idkey_empleados."','".$idkey_general_familiares."','".$temp[5]."');");
						$oconns->ShotSimple("insert into familiares(idkey_empleados,idkey_generales,idkey_parentesco) values('".$idkey_empleados."','".$idkey_general_familiares."','".$temp[5]."');");
						$idkey_general_familiares= $oconns->last_id;
					}
				}
				echo "OK";
				break;
    		}
            
            case "deparments_new":
    		{
    			$nombre = $_POST["nombre"];
    			$descripcion = $_POST["descripcion"];
    			$oconns = new database();
    			$oconns->ShotSimple("insert into departamentos(nombre,descripcion) values('".$nombre."','".$descripcion."');");

    			if ($oconns->last_id==0)
    			{
    				echo "ERROR";
    			}
    			else
    				echo "OK";


    			break;
    		}
    		case "deparments_update":
    		{

    			$nombre = $_POST["nombre"];
    			$descripcion = $_POST["descripcion"];
    			$idkey=$_POST["idkey"];

    			$oconns = new database();
    			$oconns->ShotSimple("update departamentos set nombre='".$nombre."',descripcion='".$descripcion."' where idkey='".$idkey."';");
    			echo("update departamentos set nombre='".$nombre."',descripcion='".$descripcion."' where idkey='".$idkey."';");
				echo "OK";


    			break;
    		}

    		case "position_new":
    		{
    			$idkey_departamento=$_POST["idkey_departamento"];
    			$nombre = $_POST["nombre"];
    			$descripcion = $_POST["descripcion"];
    			$oconns = new database();
    			$oconns->ShotSimple("insert into puestos(nombre,descripcion,idkey_departamentos) values('".$nombre."','".$descripcion."','".$idkey_departamento."');");    		

    			if ($oconns->last_id==0)
    			{
    				echo "ERROR";
    			}
    			else
    				echo "OK";


    			break;
    		}

	  		case "position_update":
    		{


    			$nombre = $_POST["nombre"];
    			$descripcion = $_POST["descripcion"];
    			$idkey=$_POST["idkey"];

    			$oconns = new database();
    			$oconns->ShotSimple("update puestos set nombre='".$nombre."',descripcion='".$descripcion."' where idkey='".$idkey."';");
				echo "OK";


    			break;
    		}
            
              // Guardar grupo
            
            case "guardar_grupo":{
				if (isset($_POST["idkey_cliente"])){
					$idkey_cliente = $_POST["idkey_cliente"];
				}else{
					$idkey_cliente = 0;
				}              
                $nombre_grupo = $_POST["nombre_grupo"];
                $clientes=$_POST["clientes"];
                $idkey_promotor = $_POST["promotor"];
                
                $oconns = new database();
    			
                if (floatval($idkey_cliente)==0){
                    $coincidencia = $oconns->getSimple("select count(idkey) from grupos_nombre where nombre='".strtoupper($nombre_grupo)."';");
                    
                    if (floatval($coincidencia)==0)
					{				
                        $oconns->ShotSimple("insert into grupos_nombre (nombre,idkey_promotor)values('".strtoupper($nombre_grupo)."','".$idkey_promotor."');");
                    
                        $idkey_grupo=$oconns->last_id;
                        
                    
                        foreach($clientes as $one){
                    
                            $oconns->ShotSimple("insert into grupos_clientes (idkey_grupo,idkey_clientes)values('".$idkey_grupo."','".$one."');");
							
							$oconns->ShotSimple("insert into grupo_porcentajes (idkey_grupo,idkey_cliente)values('".$idkey_grupo."','".$one."');");
                        }
                                        
                    echo $idkey_grupo;
                    }
                else 
                    echo 0;
                }
                   
    			break;
            }
            
             case "actualizar_grupo":{
                $idkey_cliente = $_POST["idkey_cliente"];
                $clientes=$_POST["clientes"];
                $oconns = new database();
                    
                foreach($clientes as $one)
                {
                   
                        //$oconns->ShotSimple("insert into grupos_clientes(idkey_grupo,idkey_clientes)values('.$idkey_cliente.','.$one.');");
						$oconns->ShotSimple("insert into grupo_porcentajes(idkey_grupo,idkey_cliente)values(".$idkey_cliente.",".$one.");");
                    
                }
                $existentes = $oconns->getRows("select idkey_clientes from grupos_clientes where idkey_grupo='".$idkey_cliente."';");
                        foreach($existentes as $e)
                        {
                            $value = $e["idkey_clientes"];
                            if(in_array($value,$clientes))
                            {
                                //echo "Existe.".$value;
                            }
                            else
                            {
                                $oconns->ShotSimple("delete from grupos_clientes where idkey_grupo='".$idkey_cliente."' and idkey_clientes='".$value."';");
                            }
                        }
                break;
                }
            
             case "guardar_porcentajes":{
                $idkey_cliente = $_POST["idkey_cliente"];
				$folio = $_POST["folio"];
                $socios = $_POST["post_settings"];
                
                $oconns = new database();
				
                foreach($socios as $socio){
					$oconns->ShotSimple("update grupo_porcentajes set prefolio='".$folio."', porcentaje='".$socio["porcentaje"]."' where idkey_grupo='".$idkey_cliente."' and idkey_cliente='".$socio["idkey_socio"]."' and prefolio=0;");
                    }
                break;
            }
            
            // Casos guardar registro usuario

    		case "clients_new":
    		{
    			//generales 
    			$idkey_cliente = $_POST["idkey_cliente"];
				$nombre=$_POST["nombre"];
				$apellido_p=$_POST["apellido_p"];
				$apellido_m=$_POST["apellido_m"];
				$nacimiento=$_POST["nacimiento"];
				$temp = explode("/",$_POST["nacimiento"]);
				$nacimiento = $temp[2]."-".$temp[1]."-".$temp[0];
				$sexo=$_POST["sexo"];
				$rfc=$_POST["rfc"];
				$curp=$_POST["curp"];
                // domicilios
				$domicilio = preg_replace("/[\r\n|\n|\r]+/", PHP_EOL, $_POST["domicilio"]);
				$exterior=$_POST["exterior"];
				$interior=$_POST["interior"];
				$temp2 = explode("/",$_POST["inicia_habitar"]);
				$inicia_habitar = $temp2[2]."-".$temp2[1]."-".$temp2[0];
				$entrecalles=$_POST["entrecalles"];
				$referencia=$_POST["referencia"];
				$observaciones=$_POST["observaciones"];
				$estados=$_POST["estados"];
				$municipios=$_POST["municipios"];
				$localidad=$_POST["localidad"];
				$codigo_postal=$_POST["codigo_postal"];
                // identificaciones By Moshe Ramz
                $identif = $_POST["identificacion"];
                $num_id = $_POST["num_id"];
                $valor = explode("/",$_POST["vigencia"]);
                $vigencia = $valor[2]."-".$valor[1]."-".$valor[0];
                //Promotor
                $idkey_promotor = $_POST["idkey_promotor"];
                
				$oconns = new database();


				if (floatval($idkey_cliente)==0)
				{
					$coincidencia = $oconns->getSimple("select count(clientes.idkey) from clientes,generales where clientes.idkey_generales=generales.idkey and generales.rfc='".strtoupper($rfc)."';");					

					if (floatval($coincidencia)==0)
					{						
						$oconns->ShotSimple("insert into direcciones(domicilio,exterior,interior,idkey_estados,idkey_municipios,idkey_localidad,idkey_codigo_postal,fecha_habita,entrecalles,referencia,observacion) values('".$domicilio."','".$exterior."','".$interior."','".$estados."','".$municipios."','".$localidad."','".$codigo_postal."','".$inicia_habitar."','".$entrecalles."','".$referencia."','".$observaciones."');");
                        //insert a direcciones
						$idkey_datos_direcciones=$oconns->last_id;

						$oconns->ShotSimple("insert into generales(nombre,apellido_p,apellido_m,fecha_nacimiento,idkey_sexo,rfc,curp,idkey_direcciones) values('".$nombre."','".$apellido_p."','".$apellido_m."','".$nacimiento."','".$sexo."','".strtoupper($rfc)."','".strtoupper($curp)."','".$idkey_datos_direcciones."');");
                        
						//insert a generales 
						$idkey_datos_generales=$oconns->last_id;
                        
                        //insert a clientes
						$oconns->ShotSimple("insert into clientes(idkey_generales,idkey_promotor)values('".$idkey_datos_generales."','".$idkey_promotor."');");				
                        
						$idkey_clientes_generado=$oconns->last_id;
                        
                        // insert a identificaciones
                        $oconns->ShotSimple("insert into clientes_identificaciones(idkey_identificacion, numero, vigencia, idkey_clientes)values('".$identif."', '".$num_id."', '".$vigencia."', '".$idkey_clientes_generado."');");
                        
						echo $idkey_clientes_generado;
					}
					else
						echo "0";
				}
				else
				{

					$rfc_g = $oconns->getSimple("select generales.rfc from clientes,generales where clientes.idkey='".$idkey_cliente."' and clientes.idkey_generales=generales.idkey;");

					if ($rfc_g==$rfc)
					{	
                        $oconns->ShotSimple("update clientes_identificaciones set idkey_identificacion='".$identif."',numero='".$num_id."',vigencia='".$vigencia."' where idkey_clientes='".$idkey_cliente."';");
                        	
						$oconns->ShotSimple("update clientes,generales,direcciones set domicilio='".$domicilio."',exterior='".$exterior."',interior='".$interior."',idkey_estados='".$estados."',idkey_municipios='".$municipios."',idkey_localidad='".$localidad."',idkey_codigo_postal='".$codigo_postal."',fecha_habita='".$inicia_habitar."',entrecalles='".$entrecalles."',referencia='".$referencia."',observacion='".$observaciones."' where clientes.idkey=".$idkey_cliente." and clientes.idkey_generales=generales.idkey and generales.idkey_direcciones=direcciones.idkey;");				

						$oconns->ShotSimple("update clientes,generales set generales.nombre='".$nombre."',generales.apellido_p='".$apellido_p."',generales.apellido_m='".$apellido_m."',generales.idkey_sexo='".$sexo."',generales.fecha_nacimiento='".$nacimiento."',generales.curp='".$curp."',generales.rfc='".$rfc."' where clientes.idkey=".$idkey_cliente." and clientes.idkey_generales=generales.idkey;");
						echo $idkey_cliente;
					}
					else
						echo "-1";

				}
    
				break;
    		}
            
           case "add_relacion_to_clients":
			{
				$oconns = new database();
                //$coincidencia = $oconns->getSimple("select count(idkey) from clientes_relaciones where idkey_clientes='".$_POST["idkey_cliente"]."' and idkey_parentesco='".$_POST["parentesco"]."';");
                
                //if ($coincidencia==0){
                $oconns->ShotSimple("insert into clientes_relaciones (idkey_clientes,idkey_relaciones,idkey_parentesco,porcentaje,nombre,aval_hist,aval_capacidad,aval_solvencia, aval_hist_desc, aval_capacidad_desc, aval_solvencia_desc, idkey_cliente_rel)values('".$_POST["idkey_cliente"]."','".$_POST["relaciones"]."','".$_POST["parentesco"]."','".$_POST["porcentaje"]."','".$_POST["nombre"]."','".$_POST["aval_hist"]."','".$_POST["aval_capacidad"]."','".$_POST["aval_solvencia"]."','".$_POST["aval_hist_desc"]."','".$_POST["aval_capacidad_desc"]."','".$_POST["aval_solvencia_desc"]."','".$_POST["idkey_cliente_rel"]."');");
                //} 
                //else {
                //$oconns->ShotSimple("update clientes_relaciones set idkey_relaciones='".$_POST["relaciones"]."', porcentaje='".$_POST["porcentaje"]."', aval_hist='".$aval_hist."', aval_capacidad='".$aval_capacidad."', aval_solvencia='".$aval_solvencia."',where  idkey_clientes='".$_POST["idkey_cliente"]."' and idkey_parentesco='".$_POST["parentesco"]."';");
                //}
                break;
			}

    		case "clients_update":
    		{
    			$idkey=$_POST["idkey"];
    			$idkey_generales = $_POST["idkey_generales"];
    			$idkey_direcciones = $_POST["idkey_direcciones"];
				$nombre=$_POST["nombre"];
				$apellido_p=$_POST["apellido_p"];
				$apellido_m=$_POST["apellido_m"];
				$edad=$_POST["edad"];
				$sexo=$_POST["sexo"];
				$domicilio=$_POST["domicilio"];


				$domicilio = preg_replace("/[\r\n|\n|\r]+/", PHP_EOL, $domicilio);
				$estados=$_POST["estados"];
				$municipios=$_POST["municipios"];
				$localidad=$_POST["localidad"];
				$codigo_postal=$_POST["codigo_postal"];
				$ine=$_POST["ine"];
				$rfc=$_POST["rfc"];
				$telefono1=$_POST["telefono1"];
				$telefono2=$_POST["telefono2"];
				$telefono3=$_POST["telefono3"];
				$email=$_POST["email"];

				$oconns = new database();


				$oconns->ShotSimple("update direcciones set domicilio='".$domicilio."',idkey_estados='".$estados."',idkey_municipios='".$municipios."',idkey_localidad='".$localidad."',idkey_codigo_postal='".$codigo_postal."' where idkey='".$idkey_direcciones."';");
				$idkey_direccion = $idkey_direcciones;				

				$oconns->ShotSimple("update generales set nombre='".$nombre."',apellido_p='".$apellido_p."',apellido_m='".$apellido_m."',edad='".$edad."',idkey_sexo='".$sexo."',ine='".$ine."',rfc='".$rfc."',telefono1='".$telefono1."',telefono2='".$telefono2."',telefono3='".$telefono3."',email='".$email."' where idkey='".$idkey_generales."';");
				$idkey_datos_generales=$idkey_generales;

				echo "OK";
				break;
    		}

    		case "access_safe":
    		{

    			$id = $_POST["id"];
    			$uname=$_POST["uname"];
    			$upass=$_POST["upass"];

    			$oconns = new database();
    			$oconns->getRows("select * from usuarios where idkey_empleados='".$id."';");

    			if ($oconns->numberRows==0)
    			{

    				$oconns->getRows("select idkey from usuarios where usuario_nombre='".$uname."';");
    				if ($oconns->numberRows!=0)
    				{
    					echo "ERROR";
    				}
    				else
    				{
    					$oconns->ShotSimple("insert into usuarios(usuario_nombre,usuario_contra,idkey_empleados) values('".$uname."','".$oconns->encriptar($upass)."','".$id."');");
    					echo "OK";
    				}
    			}
    			else
    			{
    				$oconns->ShotSimple("update usuarios set usuario_contra='".$oconns->encriptar($upass)."' where idkey_empleados='".$id."';");
    				echo "OK";
    			}

    			break;
    		}      
            
            //Clientes Ingresos By Moshe Ramz
			case "clientes_ingresos":{

                $idkey_cliente = $_POST["idkey_cliente"];
				$principal = $_POST["principal"];
				$ingreso_tipo = $_POST["ingreso_tipo"];
				$ingreso_frec = $_POST["ingreso_frec"];
				$monto = $_POST["monto"];
                $empleador = $_POST["id_empleador"];
                $temp_1 = explode("/",$_POST["f_inicio"]);
                $fecha_inicio = $temp_1[2]."-".$temp_1[1]."-".$temp_1[0];
                $temp_2 = explode("/",$_POST["f_fin"]);
                $fecha_fin = $temp_2[2]."-".$temp_2[1]."-".$temp_2[0];
                $profesion = $_POST["profesion"];
                $ocupacion = $_POST["ocupacion"];
                $jefe_directo = $_POST["jefe_directo"];
                $bajo_contrato = $_POST["bajo_contrato"];
                $ingreso_desc = $_POST["ingreso_desc"];
                $id_comicilio_empleador = $_POST["domicilio_empleador"];
                $id_siti = $_POST["actividad_siti"];
                $ingreso_comprobable = $_POST["ingreso_comprobable"];
				
    			$oconns = new database();
    			$coincidencia = $oconns->getSimple("select count(idkey) from clientes_ingresos where id_empleador='".$empleador."' and idkey_clientes='".$idkey_cliente."';");

    			if ($coincidencia==0)
    			{
                    $oconns->ShotSimple("insert into clientes_ingresos
                    (principal,id_tipo_ingreso,id_frecuencia,monto,id_empleador,inicio,fin,profesion,ocupacion,jefe_directo,bajo_contrato,idkey_clientes,ingreso_desc,id_siti,id_comicilio_empleador,comprobacion)
                    values
                    ('".$principal."','".$ingreso_tipo."','".$ingreso_frec."','".$monto."','".$empleador."','".$fecha_inicio."','".$fecha_fin."','".$profesion."','".$ocupacion."','".$jefe_directo."','".$bajo_contrato."','".$idkey_cliente."','".$ingreso_desc."','".$id_siti."','".$id_comicilio_empleador."','".$ingreso_comprobable."');");
    			}
                else
    			{
                    $oconns->ShotSimple("update clientes_ingresos set 
                    principal='".$principal."', 
                    id_tipo_ingreso='".$ingreso_tipo."',
                    id_frecuencia='".$ingreso_frec."',
                    monto='".$monto."',
                    id_empleador='".$empleador."',
                    inicio='".$fecha_inicio."',
                    fin='".$fecha_fin."',
                    profesion='".$profesion."',
                    ocupacion='".$ocupacion."',
                    jefe_directo='".$jefe_directo."',
                    bajo_contrato='".$bajo_contrato."',
                    ingreso_desc= '".$ingreso_desc."',
                    id_siti='".$id_siti."',
                    comprobacion='".$ingreso_comprobable."'
                    where id_empleador='".$empleador."' and idkey_clientes='".$idkey_cliente."';");
    			}

    			break;
			}
            
            //Clientes Egresos By Moshe Ramz
			case "clientes_egresos":{

                $idkey_cliente = $_POST["idkey_cliente"];
				$tipo_egreso = $_POST["tipo_egreso"];
				$frecuencia_egreso = $_POST["frecuencia_egreso"];
				$monto_egreso = $_POST["monto_egreso"];
                $temp_e1 = explode("/",$_POST["inicio_egreso"]);
                $inicio_egreso = $temp_e1[2]."-".$temp_e1[1]."-".$temp_e1[0];
                $temp_e2 = explode("/",$_POST["fin_egreso"]);
                $fin_egreso = $temp_e2[2]."-".$temp_e2[1]."-".$temp_e2[0];
                $desc_egreso = $_POST["descripcion_egreso"];
                $tipo_pago = $_POST["tipo_pago"];
                
                				
    			$oconns = new database();
    			$coincidencia = $oconns->getSimple("select count(idkey) from clientes_egresos where id_tipo_egreso='".$tipo_egreso."' and idkey_clientes='".$idkey_cliente."';");

    			if ($coincidencia==0)
    			{
                    $oconns->ShotSimple("insert into clientes_egresos(id_tipo_egreso,id_frecuencia,monto,inicio,fin,observaciones,tipo_pago,idkey_clientes)
                    values
                    ('".$tipo_egreso."','".$frecuencia_egreso."','".$monto_egreso."','".$inicio_egreso."','".$fin_egreso."','".$desc_egreso."','".$tipo_pago."','".$idkey_cliente."');");
    			}
                else
    			{
                    $oconns->ShotSimple("update clientes_egresos set 
                    id_frecuencia='".$frecuencia_egreso."', 
                    monto='".$monto."',
                    inicio='".$inicio_egreso."',
                    fin='".$fin_egreso."',
                    obervaciones='".$desc_egreso."',
                    tipo_pago='".$tipo_pago."' 
                    where id_tipo_egreso='".$tipo_egreso."' and idkey_clientes='".$idkey_cliente."';");
    			}

    			break;
			}
            
            //Clientes Contactos By Moshe Ramz
			case "clientes_contacto":{

				$email = $_POST["contacto_email"];
				$telefono = $_POST["contacto_telefono"];
				$descripcion = $_POST["contacto_descripcion"];
				$idkey_contacto_prioridad = $_POST["contacto_prioridad"];
				$idkey_cliente = $_POST["idkey_cliente"];

    			$oconns = new database();

    			$oconns->ShotSimple("insert into clientes_contacto(email,telefono,idkey_contacto_prioridad,descripcion,idkey_clientes) values('".$email."','".$telefono."','".$idkey_contacto_prioridad."','".$descripcion."','".$idkey_cliente."');");

    			/*
    			$coincidencia = $oconns->getSimple("select count(idkey) from clientes_contacto where idkey_contacto_prioridad='".$idkey_contacto_prioridad."' and idkey_clientes='".$idkey_cliente."';");

    			if ($coincidencia==0)
    			{
    				//$oconns->ShotSimple("insert into clientes_contacto(email,telefono,idkey_contacto_prioridad,descripcion,idkey_clientes) values('".$_POST["email"]."','$_POST["telefono"]','".$_POST["idkey_contacto_prioridad"]."','".$_POST["descripcion"]."','".$_POST["idkey_cliente"]."');");
                    $oconns->ShotSimple("insert into clientes_contacto(email,telefono,idkey_contacto_prioridad,descripcion,idkey_clientes) values('".$email."','".$telefono."','".$idkey_contacto_prioridad."','".$descripcion."','".$idkey_cliente."');");
    			}
                elseif ($coincidencia==1)
    			{
                    //$oconns->ShotSimple("update clientes_contacto set email='".$_POST["email"]."',telefono='".$_POST["telefono"]."',idkey_contacto_prioridad='".$_POST["idkey_contacto_prioridad"]."',descripcion='".$_POST["descripcion"]."' where idkey_contacto_prioridad='".$_POST["idkey_contacto_prioridad"]."' and idkey_clientes='".$_POST["idkey_cliente"]."';");
    				$oconns->ShotSimple("update clientes_contacto set email='".$email."',telefono='".$telefono."',descripcion='".$descripcion."' where idkey_contacto_prioridad='".$idkey_contacto_prioridad."' and idkey_clientes='".$idkey_cliente."';");
    			}
                else
                {
                    $oconns->ShotSimple("insert into clientes_contacto(email,telefono,idkey_contacto_prioridad,descripcion,idkey_clientes) values('".$email."','".$telefono."','".$idkey_contacto_prioridad."','".$descripcion."','".$idkey_cliente."');");
                }*/
				

    			break;
			}
            // Clientes factores By Moshe Ramz
            
            case "guardar_factores":{
                
                $idkey_cliente = $_POST["idkey_cliente"];
                $referencias=$_POST["referencias"];
                $veracidad=$_POST["veracidad"];
                $garantia_liquida=$_POST["garantia_liquida"];
                $conocimiento=$_POST["conocimiento"];
                $capacidad_pago=$_POST["capacidad_pago"];
                $solvencia=$_POST["solvencia"];
                $experiencia_crediticia=$_POST["experiencia_crediticia"];
                $historial_interno=$_POST["historial_interno"];
                $historial_buro=$_POST["historial_buro"];
                $bienes_declarados=$_POST["bienes_declarados"];
                $cobertura=$_POST["cobertura"];
                $aforo=$_POST["aforo"];
                $edad=$_POST["edad"];
                $ocupacion=$_POST["ocupacion"];
                $arraigo_laboral=$_POST["arraigo_laboral"];
                $arraigo_domiciliario=$_POST["arraigo_domiciliario"];
                $tipo_vivienda=$_POST["tipo_vivienda"];
                $comprobante=$_POST["comprobante"];
                
                $oconns = new database();
    			                
                $factores = $oconns->getSimple("select count(idkey) from clientes_factores where idkey_clientes='".$idkey_cliente."';");
                
                if ($factores==0)
                {
                    $oconns->ShotSimple("insert into clientes_factores(historial_interno,historial_buro,experiencia_crediticia,capacidad_pago,comprobación_ingresos,tipo_vivienda,arraigo_domiciliario,arraigo_laboral,referencias,ocupacion,conocimiento_actividad,edad,veracidad,hipotecaria,mobiliaria,garantia_liquida,solvencia,bienes_declarados,idkey_clientes)values('".$historial_interno."','".$historial_buro."','".$experiencia_crediticia."','".$capacidad_pago."','".$comprobante."','".$tipo_vivienda."','".$arraigo_domiciliario."','".$arraigo_laboral."','".$referencias."','".$ocupacion."','".$conocimiento."','".$edad."','".$veracidad."','".$aforo."','".$cobertura."','".$garantia_liquida."','".$solvencia."','".$bienes_declarados."','".$idkey_cliente."');");
                }
                else
                {
                    $oconns->ShotSimple("update clientes_factores set historial_interno = '".$historial_interno."',historial_buro = '".$historial_buro."',experiencia_crediticia = '".$experiencia_crediticia."',capacidad_pago = '".$capacidad_pago."',comprobación_ingresos = '".$comprobante."',tipo_vivienda = '".$tipo_vivienda."',arraigo_domiciliario = '".$arraigo_domiciliario."',arraigo_laboral = '".$arraigo_laboral."',referencias = '".$referencias."',ocupacion = '".$ocupacion."',conocimiento_actividad = '".$conocimiento."',edad = '".$edad."',veracidad = '".$veracidad."',hipotecaria = '".$aforo."',mobiliaria = '".$cobertura."',garantia_liquida = '".$garantia_liquida."',solvencia = '".$solvencia."',bienes_declarados = '".$bienes_declarados."' where idkey_clientes = '".$idkey_cliente."'
                    ;");
                }
              

    			break;
			}
            
            // Clientes Nuevo Credito By Moshe Ramz
            
            case "guardar_credito":{
                $idkey_cliente = $_POST["idkey_cliente"];
                $folio=$_POST["folio"];
                $tipo_producto=$_POST["producto"];
                $monto=$_POST["monto"];
                $plazo=$_POST["plazo"];
                $frecuencia_pagos=$_POST["frecuencia"];
                $numero_pagos=$_POST["pagos"];
                $tasa_interes=$_POST["interes"];
                $temp = explode("/", $_POST["pago_1"]);
                $primer_pago= $temp[2]."-".$temp[1]."-".$temp[0];
                $finalidad=$_POST["finalidad"];
                $tipo_credito=$_POST["tipo_credito"];
                
                $oconns = new database();
    			//$creditos = $oconns->getSimple("select count(idkey) from creditos where idkey_clientes='".$idkey_cliente."' and tipo_credito='".$tipo_credito."';");
                
                //if ($creditos==0)
    			//{
                    $oconns->ShotSimple("insert into creditos(idkey_clientes,idkey_productos,plazo,idkey_frecuencia,monto,tasa_interes,folio,numero_pagos,primer_pago,finalidad,tipo_credito)values('".$idkey_cliente."','".$tipo_producto."','".$plazo."','".$frecuencia_pagos."','".$monto."','".$tasa_interes."','".$folio."','".$numero_pagos."','".$primer_pago."','".$finalidad."','".$tipo_credito."');");
    			/*}
                else
                {
                    //$oconns->ShotSimple("update clientes_factores set historial_interno = '".$historial_interno."',historial_buro = '".$historial_buro."',experiencia_crediticia = '".$experiencia_crediticia."',capacidad_pago = '".$capacidad_pago."',comprobación_ingresos = '".$comprobante."',tipo_vivienda = '".$tipo_vivienda."',arraigo_domiciliario = '".$arraigo_domiciliario."',arraigo_laboral = '".$arraigo_laboral."',referencias = '".$referencias."',ocupacion = '".$ocupacion."',conocimiento_actividad = '".$conocimiento."',edad = '".$edad."',veracidad = '".$veracidad."',hipotecaria = '".$aforo."',mobiliaria = '".$cobertura."',garantia_liquida = '".$garantia_liquida."',solvencia = '".$solvencia."',bienes_declarados = '".$bienes_declarados."' where idkey_clientes = '".$idkey_cliente."';");
                }*/
    			break;
			}
            
            //Actualizar estatus credito
            case "actualizar_credito":{
                $idkey_cliente = $_POST["idkey_cliente"];
                $idkey_credito=$_POST["idkey_credito"];
                $observacion=$_POST["observacion"]; 
                $estatus_id=$_POST["estatus_id"];  
                
                $oconns = new database();
                
                $coincidencia = $oconns->getSimple("select count(idkey) from creditos_observaciones where idkye_credito=".$idkey_credito.";");
                
                if ($coincidencia == 0){
                    $oconns->ShotSimple("insert into creditos_observaciones(idkye_credito,observacion)values(".$idkey_credito.",'".$observacion."');");
                } else {
                    $oconns->ShotSimple("update creditos_observaciones set observacion='".$observacion."' where idkye_credito = ".$idkey_credito.";");
                }
    			
                $oconns->ShotSimple("update creditos set estatus = '".$estatus_id."' where idkey_clientes = '".$idkey_cliente."' and idkey = '".$idkey_credito."';");
                
                if($estatus_id != 1){
                    $oconns->ShotSimple("delete from amortizaciones where idkey_creditos='".$idkey_credito."';");
                }

    			break;
			}
            
            case "registrar_pago":{
                $credito_id = $_POST["idkey_credito"];
                $tipo_pago = $_POST["tipo_pago"];
                $referencia = $_POST["referencia"];
                $temp = explode("/",$_POST["fecha_valor"]);
                $fecha_valor = $temp[2]."-".$temp[1]."-".$temp[0];
                $pago_valor = $_POST["pago_valor"];
                $fila_id = $_POST["fila_id"];
                //$saldo_insoluto_2 = 454545;
                $oconns = new database();
                $pago_cons = $oconns->getSimple("select count(idkey) from pagos where idkey_amortizaciones=".$fila_id.";");
                $datos = $oconns->getRows("select a.*,DATEDIFF(a.fecha_pago, p.fecha_valor) as dias,p.referencia,p.monto,p.monto,p.fecha_valor,p.idkey_clasificacion_pagos,p.idkey_amortizaciones,p.saldo_insoluto_2 from amortizaciones a left join pagos p on p.idkey_amortizaciones=a.idkey where p.idkey_amortizaciones=".$fila_id."-1;");
                $insoluto_anterior = $datos[0]["saldo_insoluto_2"];
                
                $datos = $oconns->getRows("select * from creditos where idkey=".$credito_id.";");
                $insoluto_anterior_b = $datos[0]["monto"];
                $x = $datos[0]["idkey_frecuencia"];
                if($x==1){
                    $frec_id=7;
                }elseif($x==2){
                    $frec_id=15;
                }elseif($x==3){
                    $frec_id=30;
                }
                
                $datas = $oconns->getRows("select * from amortizaciones where idkey=".$fila_id.";");
                
                $pago = $datas[0]["pago"];
                $doble = $datas[0]["total"] * 2;
                $fecha_pago = $datas[0]["fecha_pago"];
                    
                if($pago==1){
                    $insoluto_anterior_a = $insoluto_anterior_b;
                }else{
                    $insoluto_anterior_a = $insoluto_anterior;
                }
                
                $intereses = round($insoluto_anterior_a * $datas[0]["interes_diario"]/1.16,2);
                $iva = round($intereses * 0.16,2);
                $date1 = new DateTime($fecha_valor);
                $date2 = new DateTime($datas[0]["fecha_pago"]);
                $diff = $date1->diff($date2);
                $dias = $diff->days;
                $int_diario = $datas[0]["interes_diario"];
                $monto_sum = round($intereses + $iva,2);
                $int_x_dia = round($insoluto_anterior_a * $int_diario/$frec_id,2);
                if($pago_valor >= $doble){
                    $int_acum = $int_x_dia * $dias;
                    $amortizacion = round($pago_valor-$monto_sum,2);
                }else{
                    $int_acum = $int_x_dia * $dias;
                    $amortizacion = round($pago_valor-$monto_sum+$int_acum,2);
                }
                if ($insoluto_anterior_a < $datas[0]["total"]){
                    $y = round($insoluto_anterior_a+$intereses);
                    $z = round($insoluto_anterior_a * $int_diario); 
                    $nuevo_pago = round($insoluto_anterior_a + $z);
                    $saldo_insoluto = round($insoluto_anterior_a-$amortizacion,2);
                    $oconns->ShotSimple("update pagos set monto='".$nuevo_pago."');");
                }else{
                    $saldo_insoluto = round($insoluto_anterior_a-$amortizacion,2);
                }
                
                
                    /*else{
                        $intereses = $datas[0]["intereses"];
                        $iva = $datas[0]["iva"];
                        $date1 = new DateTime($fecha_valor);
                        $date2 = new DateTime($fecha_pago);
                        $diff = $date1->diff($date2);
                        $dias = $diff->days;
                        $int_diario = $datas[0]["interes_diario"];
                        $monto_sum = round($intereses + $iva,2);
                        $int_x_dia = round($insoluto_anterior_a * $int_diario/$frec_id,2);
                        $amortizacion = round($pago_valor-$monto_sum,2);
                        $int_acum = $int_x_dia * $dias;
                        $saldo_insoluto = round($insoluto_anterior_a-$amortizacion,2);
                    }
                    
                    if($fecha_valor < $fecha_pago && $dias <= $limite){
                        $monto_sum = round($intereses + $iva,2);
                        $int_x_dia = round($insoluto_anterior_a * $int_diario/$frec_id,2);
                        $int_acum = $int_x_dia * $dias*(-1);
                        $amortizacion = round($pago_valor-$monto_sum+$int_acum,2);
                        if ($insoluto_anterior_a < $datas[0]["total"]){
                            $y = round($insoluto_anterior_a+$intereses);
                            $z = round($insoluto_anterior_a * $int_diario); 
                            $nuevo_pago = round($insoluto_anterior_a + $z);
                            $saldo_insoluto = round($insoluto_anterior_a-$amortizacion,2);
                            $oconns->ShotSimple("update pagos set monto='".$nuevo_pago."');");
                        }else{
                        $saldo_insoluto = round($insoluto_anterior_a-$amortizacion,2);
                        }
                        echo $monto."-".$int_x_dia."-".$int_acum."-".$amortizacion."-".$limite;
                    }*/
         
                
                
                if($pago_cons==0){
                    $oconns->ShotSimple("insert into pagos(referencia,monto,fecha_valor,idkey_clasificacion_pagos,idkey_amortizaciones,
                    saldo_insoluto_2,intereses,iva,suma_int_iva,dias,interes_diario,interes_acumulado,amortizacion,idkey_creditos)
                    values('".$referencia."',".$pago_valor.",'".$fecha_valor."',".$tipo_pago.",".$fila_id.",
                    ".$saldo_insoluto.",".$intereses.",".$iva.",".$monto_sum.",".$dias.",".$int_x_dia.",".$int_acum.",".$amortizacion.",".$credito_id.");");
                }else{
                    $oconns->ShotSimple("update pagos set referencia='".$referencia."',monto=".$pago_valor.",fecha_valor='".$fecha_valor."',idkey_clasificacion_pagos=".$tipo_pago.",idkey_amortizaciones=".$fila_id.",saldo_insoluto_2=".$saldo_insoluto.",intereses=".$intereses.",iva=".$iva.",suma_int_iva=".$monto_sum.",dias=".$dias.",interes_diario=".round($int_x_dia,2).",interes_acumulado=".$int_acum.",amortizacion=".$amortizacion.",idkey_creditos=".$credito_id." where idkey_amortizaciones=".$fila_id.";");
                }
            }
            
            case "buscar_nombre":{
                
                if(!empty($_POST["nombre_grupo"])) {
                    
                    $oconns = new database();
                    $grupo = $oconns->getSimple("SELECT count(idkey) FROM grupos_nombre WHERE nombre='".$_POST["nombre_grupo"]."';");
                    
                    if($grupo>0) {
                        echo '<div class="alert alert-danger"><strong>Oh no!</strong> Nombre de usuario no disponible.</div>';
                        }
                    else
                        {
                        echo '<div class="alert alert-success"><strong>Enhorabuena!</strong> Usuario disponible.</div>';
                        }
                    }
				break;
                }
            
            // Clientes mueble By Moshe Ramz
            
            case "cliente_mueble":{
                
                $idkey_cliente = $_POST["idkey_cliente"];
				$valor_comercial = $_POST["valor_comercial"];
                $modelo = $_POST["modelo"];
                $marca = $_POST["marca"];
                $temp = explode("/",$_POST["fecha_adquisicion"]);
                $fecha_adq=$temp[2]."-".$temp[1]."-".$temp[0];
                $referencia_factura = $_POST["referencia_factura"];
                $mueble_observaciones = $_POST["mueble_observaciones"];
                $garantias_categorias = $_POST["garantias_categorias"];
                $garantias_tipos = $_POST["garantias_tipos"];
                $cobertura = $_POST["cobertura"];
                
                $oconns = new database();
    			$coincidencia = $oconns->getSimple("select count(idkey) from garantias_mueble where marca='".$modelo."' and idkey_garantia_categoria='".$garantias_categorias."' and idkey_clientes='".$idkey_cliente."';");
                
    			if ($coincidencia==0)
    			{
    				$oconns->ShotSimple("insert into garantias_mueble(valor_comercial, modelo, marca,fecha_adquisicion, referencia_factura, observaciones, idkey_garantia_categoria,idkey_clientes,cobertura)values('".$valor_comercial."','".$modelo."','".$marca."','".$fecha_adq."','".$referencia_factura."','".$mueble_observaciones."','".$garantias_categorias."','".$idkey_cliente."','".$cobertura."');");
    			}
                else
    			{
    				$oconns->ShotSimple("update garantias_mueble set valor_comercial='".$valor_comercial."',modelo='".$modelo."',marca='".$marca."',fecha_adquisicion='".$fecha_adq."',referencia_factura='".$referencia_factura."',observaciones='".$mueble_observaciones."' where marca='".$modelo."' and idkey_garantia_categoria='".$garantias_categorias."' and idkey_clientes='".$idkey_cliente."';");
    			}

    			break;
			}
            
            // Clientes Inmueble By Moshe Ramz
            
            case "cliente_inmueble":{
                
                $garantia_categoria =  $_POST["garantias_categorias"];
                //$garantia_tipo =  $_POST["garantias_tipos"];
                $inmueble_medidas =  $_POST["inmueble_medidas"];
                $inmueble_observaciones =  $_POST["inmueble_observaciones"];
                $inmueble_descripcion =  $_POST["inmueble_descripcion"];
                $hipoteca =  $_POST["hipoteca"];
                $gravamen =  $_POST["gravamen"];
                $registro =  $_POST["registro"];
                $escritura =  $_POST["escritura"];
                $valor_catastral =  $_POST["valor_catastral"];
                $valor_fiscal =  $_POST["valor_fiscal"];
                $valor_comercial =  $_POST["valor_comercial_2"];
                $idkey_cliente =  $_POST["idkey_cliente"];
                $aforo = $_POST["aforo"];
                $conescritura=["con_escritura"];

                
                $oconns = new database();
    			//$coincidencia = $oconns->getSimple("select count(idkey) from garantias_inmueble where idkey_clientes='".$idkey_cliente."';");

    			/*if ($coincidencia==0)
    			{*/
                    $oconns->ShotSimple("insert into garantias_inmueble(valor_comercial,valor_fiscal,valor_catastral,escritura,registro,medidas_colindacia,gravamen,hipoteca,descripcion,observaciones,idkey_clientes,idkey_garantia_categoria,aforo)values('".$valor_comercial."','".$valor_fiscal."','".$valor_catastral."','".$escritura."','".$registro."','".$inmueble_medidas."','".$gravamen."','".$hipoteca."','".$inmueble_descripcion."','".$inmueble_observaciones."','".$idkey_cliente."','".$garantia_categoria."','".$aforo."');");
    			/*}
                else
    			{   
    				$oconns->ShotSimple("update garantias_inmueble set 
                    valor_comercial='".$valor_comercial."',valor_fiscal='".$valor_fiscal."',valor_catastral='".$valor_catastral."',escritura='".$escritura."',
                    registro='".$registro."',medidas='".$inmueble_medidas."',vaor_catastral='".$valor_catastral."',gravamen='".$gravamen."',hipoteca='".$valor_catastral."',
                     where idkey_contacto_prioridad='".$idkey_contacto_prioridad."' and idkey_clientes='".$idkey_cliente."';");
    			}*/

    			break;
			}
            
            case "guardar_socio_economico":{
                
                $idkey_cliente=$_POST["idkey_cliente"];
                $agua = $_POST["agua"];
				$electri = $_POST["electri"];
				$telefono = $_POST["telefono"];
				$drenaje = $_POST["drenaje"];
				$ant_cable = $_POST["ant_cable"];
				//electros
				$estufa=$_POST["estufa"];
				$lavadora=$_POST["lavadora"];
				$refri=$_POST["refri"];
				$tele = $_POST["tele"];
				$estereo=$_POST["estereo"];
				$compu=$_POST["compu"];
				//habitaicones
				$sala=$_POST["sala"];
				$comedor=$_POST["comedor"];
				$cocina=$_POST["cocina"];
				$bano_p=$_POST["bano_p"];
				//Detalles
				$servicios_detalle=$_POST["servicios_detalle"];
				$electro_detalle=$_POST["electro_detalle"];
				$habitaciones_detalle=$_POST["habitaciones_detalle"];
				$vivienda_detalle=$_POST["vivienda_detalle"];
				$hacinamiento_detalle=$_POST["hacinamiento_detalle"];
				$techo_detalle=$_POST["techo_detalle"];
				$material_detalle=$_POST["material_detalle"];
				$piso_detalle=$_POST["piso_detalle"];
				//
                $residentes=$_POST["residentes"];
				$observaciones=$_POST["observaciones"];
				$vivienda=$_POST["vivienda"];
				$hacinamiento=$_POST["hacinamiento"];
				$techo=$_POST["techo"];
				$material=$_POST["material"];
				$piso=$_POST["piso"];
                
                $oconns = new database();
    			$coincidencia = $oconns->getSimple("select count(idkey) from clientes_socio_economico where idkey_clientes='".$idkey_cliente."';");


    			if ($coincidencia==0)
                    {
                        $oconns->ShotSimple("insert into clientes_socio_economico
                        (servicios_agua,         
                        servicios_electricidad ,
                        servicios_telefono,     
                        servicios_drenaje,      
                        servicios_antena,       
                        servicios_detalle,      
                        idkey_tipo_vivienda,    
                        tipo_vivienda_detalle,
                        idkey_material,         
                        material_detalle,       
                        electro_estufa,         
                        electro_lavadora,
                        electro_refri,          
                        electro_tele,           
                        electro_estereo,        
                        electro_compu,          
                        electro_detalle,        
                        idkey_hacinamiento,     
                        hacinamiento_detalle,   
                        idkey_piso,             
                        piso_detalle,           
                        habitacion_sala,        
                        habitacion_comedor,     
                        habitacion_cocina,      
                        habitacion_bano,        
                        habitacion_detalle,     
                        residentes,             
                        idkey_techo,            
                        techo_detalle,          
                        observaciones,          
                        idkey_clientes)
                        values
                        ('".$agua."','".$electri."','".$telefono."','".$drenaje."','".$ant_cable."','".$servicios_detalle."','".$vivienda."','".$vivienda_detalle."','".$material."','".$material_detalle."','".$estufa."','".$lavadora."','".$refri."','".$tele."','".$estereo."','".$compu."','".$electro_detalle."','".$hacinamiento."','".$hacinamiento_detalle."','".$piso."','".$piso_detalle."','".$sala."','".$comedor."','".$cocina."','".$bano_p."','".$habitaciones_detalle."','".$residentes."','".$techo."','".$techo_detalle."','".$observaciones."','".$idkey_cliente."');");
                    }
    			else
                    {
                        $oconns->ShotSimple("update clientes_socio_economico set 
                        servicios_agua='".$agua."',
                        servicios_electricidad ='".$electri."',
                        servicios_telefono='".$telefono."',     
                        servicios_drenaje='".$drenaje."',      
                        servicios_antena='".$ant_cable."',
                        servicios_detalle='".$servicios_detalle."',    
                        idkey_tipo_vivienda='".$vivienda."',    
                        tipo_vivienda_detalle='".$vivienda_detalle."',
                        idkey_material='".$material."',         
                        material_detalle = '".$material_detalle."',       
                        electro_estufa ='".$estufa."',
                        electro_lavadora='".$lavadora."',
                        electro_refri ='".$refri."',       
                        electro_tele='".$tele."',           
                        electro_estereo='".$estereo."',
                        electro_compu='".$compu."',          
                        electro_detalle='".$electro_detalle."',
                        idkey_hacinamiento='".$hacinamiento."',     
                        hacinamiento_detalle='".$hacinamiento_detalle."',   
                        idkey_piso='".$piso."',             
                        piso_detalle='".$piso_detalle."',
                        habitacion_sala='".$sala."',        
                        habitacion_comedor='".$comedor."',     
                        habitacion_cocina='".$cocina."',      
                        habitacion_bano='".$bano_p."',        
                        habitacion_detalle='".$habitaciones_detalle."',
                        residentes='".$residentes."',
                        idkey_techo='".$techo."',            
                        techo_detalle='".$techo_detalle."',
                        observaciones='".$observaciones."'
                        where idkey_clientes='".$idkey_cliente."'
                        ;");
                    }
				

    			break;
                
                }         
            
            
            // Funcion datos adicionales
            
			case "clientes_datos_adicionales":{

				$idkey_cliente = $_POST["idkey_cliente"];
				$estado_civil = $_POST["estado_civil"];
				$nivel_academico = $_POST["nivel_academico"];
				$indigena = $_POST["indigena"];
				$penales = $_POST["penales"];
				$politica = $_POST["politica"];
				$dependientes = $_POST["dependientes"];
				$regimen_fiscal=$_POST["regimen_fiscal"];
				$temp =explode("/",$_POST["fecha_sat"]);
				$fecha_sat=$temp[2]."-".$temp[1]."-".$temp[0];
				$email_facturacion=$_POST["email_facturacion"];
				$domicilio_fiscal=$_POST["domicilio_fiscal"];
				$fiel=$_POST["fiel"];
				$cedula=$_POST["cedula"];
                $id_cargo=$_POST["id_cargo"];
                $temp1=explode("/",$_POST["inicio_cargo"]);
                $inicio_cargo = $temp1[2]."-".$temp1[1]."-".$temp1[0];
                $temp2=explode("/",$_POST["fin_cargo"]);
                $fin_cargo = $temp2[2]."-".$temp2[1]."-".$temp2[0];

    			$oconns = new database();
    			$coincidencia = $oconns->getSimple("select count(idkey) from clientes_datos_adicionales where idkey_clientes='".$idkey_cliente."';");


    			if ($coincidencia==0)
                    {
                        $oconns->ShotSimple("insert into clientes_datos_adicionales
                        (idkey_estado_civil,idkey_nivel_academico,indigena,penales,politica,dependientes,idkey_clientes,idkey_regimen_fiscal,fecha_sat,
                        correo_facturacion,domicilio_fiscal,fiel,cedula,id_cargo,inicio_cargo,fin_cargo)values('".$estado_civil."','".$nivel_academico."','".$indigena."','".$penales."','".$politica."','".$dependientes."','".$idkey_cliente."','".$regimen_fiscal."','".$fecha_sat."','".$email_facturacion."','".$domicilio_fiscal."','".$fiel."','".$cedula."','".$id_cargo."','".$inicio_cargo."','".$fin_cargo."');");
                    }
    			else
                    {
                        $oconns->ShotSimple("update clientes_datos_adicionales set 
                        idkey_estado_civil='".$estado_civil."',
                        idkey_nivel_academico='".$nivel_academico."',
                        indigena='".$indigena."',
                        penales='".$penales."',
                        politica='".$politica."',
                        dependientes='".$dependientes."',
                        idkey_regimen_fiscal='".$regimen_fiscal."',
                        fecha_sat='".$fecha_sat."',
                        correo_facturacion='".$email_facturacion."',
                        domicilio_fiscal='".$domicilio_fiscal."',
                        fiel='".$fiel."',
                        cedula='".$cedula."',
                        inicio_cargo='".$inicio_cargo."',
                        id_cargo='".$id_cargo."',
                        fin_cargo='".$fin_cargo."' where idkey_clientes='".$idkey_cliente."';");
                    }
				

    			break;
			} // Fin datos adicionales
        }
  	}

?>

