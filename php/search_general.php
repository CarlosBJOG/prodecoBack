<?php
	require_once "db.php";


  if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {

    	$module = $_POST["module"];


    	switch($module)
    	{

            case "credit_descriptivo":
            {
                $oconns = new database();

                $datas = $oconns->getRows("select * from productos where idkey="+$_POST["idkey"].";");


                echo $datas[0]['idkey']."|".$datas[0]['nombre']."|".$datas[0]['descripcion']."|".$datas[0]['limite_minimo_personas']."|".$datas[0]['limite_maximo_personas']."|".$datas[0]['tiempo_entrega']."|".$datas[0]['monto_maximo_inicial']."|".$datas[0]['monto_minimo']."|".$datas[0]['monto_maximo_alcanzable']."|".$datas[0]['plazo_minimo']."|".$datas[0]['plazo_maximo']."|".$datas[0]['tasa_interes']."|".$datas[0]['idkey_frecuencia']."|".$datas[0]['garantias'];



                break;
            }

            case "clients_for_credit":
            {
                if (isset($_POST["consulta"]))
                {


                    if (strlen($_POST["consulta"])>0)
                    {


                        $oconns = new database();

                        $datas = $oconns->getRows("select clientes.idkey,concat(generales.nombre,' ',generales.apellido_p,' ',generales.apellido_m) as nombre,UPPER(generales.rfc) as rfc from clientes,generales where clientes.idkey_generales=generales.idkey and (nombre like '%".$_POST["consulta"]."%' or  apellido_p like '%".$_POST["consulta"]."%' or apellido_m like '%".$_POST["consulta"]."%');");

                        if ($oconns->numberRows==0)
                        {
?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Informaci&oacute;n</th>    
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td align="center">No se han encontrado clientes que coinciden</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
<?php
                        }
                        else
                            {
?>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" style="width:100%">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col" width="75%" style="margin:10px">Nombre</th>
                                            <th scope="col" width="25%" style="margin:10px">RFC</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
                                    foreach ($datas as $items) 
                                    {
?>
                                        <tr>
                                            <td><a href="#" onclick="$.fn.getClients_to_credit('<?php echo $items["idkey"];?>');" style="text-decoration: none; color:black;"><?php echo $items["nombre"];?></a></td>
                                            <td align="center"><?php echo $items["rfc"];?></td>
                                        </tr>
<?php
                                   }
?>
                                    </tbody>
                                </table>
                            </div>
<?php
                            }
                    }
                }
                break;
            }
    		case "employee_search":    		
    		{
    			$busqueda = $_POST["busqueda"];

				$oconns = new database();

				
				$datas = $oconns->getRows("select empleados.idkey,generales.nombre,generales.apellido_p,generales.apellido_m from empleados,generales where empleados.idkey_generales=generales.idkey and (generales.nombre like '%".$busqueda."%' or generales.apellido_p like '%".$busqueda."%' or generales.apellido_m like '%".$busqueda."%');");


				if ($oconns->numberRows > 0)					
				{

?>
                                            <table border="0" class="table">
                                                <tr>
                                                    <th width="10%">#</th>
                                                    <th>Nombre</th>
                                                </tr>
<?php                                               
					foreach ($datas as $items)        
					{
?>

                                                <tr>
                                                    <td>
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-primary btn-sm rounded " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-bars"></i></button>
                                                            <div class="dropdown-menu">
                                                                <a href="empleados_ver.php?id=<?php echo $items["idkey"]; ?>&query=<?php echo $busqueda; ?>" id="ViewFamiliar" class="dropdown-item"><i class="fas fa-search"></i>&nbsp;Ver</a>
                                                                <a href="empleados_modificacion.php?id=<?php echo $items["idkey"]; ?>&query=<?php echo $busqueda; ?>" id="ViewFamiliar" class="dropdown-item"><i class="fas fa-edit"></i>&nbsp;Modificar</a>


                                                                <a href="#" onclick=""  class="dropdown-item"><i class="fas fa-trash-alt"></i>&nbsp;Eliminar</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><?php echo $items["nombre"]." ".$items["apellido_p"]." ".$items["apellido_m"]; ?></td>
                                                </tr>
<?php
					}
?>
                                            </table>
<?php




				}
				else
				{
?>
                                            <table border="0" class="table">
                                                <tr>
                                                    <th>No se encontro ninguna coincidencia con su busqueda</th>
                                                </tr>
                                            </table>
<?php

				}




				break;
    		}

            case "clients_search":         
            {
                $busqueda = $_POST["busqueda"];

                $oconns = new database();

                
                $datas = $oconns->getRows("select clientes.idkey,generales.nombre,generales.apellido_p,generales.apellido_m from clientes,generales where clientes.idkey_generales=generales.idkey and (generales.nombre like '%".$busqueda."%' or generales.apellido_p like '%".$busqueda."%' or generales.apellido_m like '%".$busqueda."%');");


                if ($oconns->numberRows > 0)                    
                {

?>
                                            <table border="0" class="table">
                                                <tr>
                                                    <th width="10%">#</th>
                                                    <th>Nombre</th>
                                                </tr>
<?php                                               
                    foreach ($datas as $items)        
                    {
?>

                                                <tr>
                                                    <td>
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-primary btn-sm rounded " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-bars"></i></button>
                                                            <div class="dropdown-menu">
                                                                <a href="clientes_ver.php?id=<?php echo $items["idkey"]; ?>&query=<?php echo $busqueda; ?>" id="ViewFamiliar" class="dropdown-item"><i class="fas fa-search"></i>&nbsp;Ver</a>
                                                                <a href="clientes_modificacion.php?id=<?php echo $items["idkey"]; ?>&query=<?php echo $busqueda; ?>" id="ViewFamiliar" class="dropdown-item"><i class="fas fa-edit"></i>&nbsp;Modificar</a>
                                                                <a href="#" onclick=""  class="dropdown-item"><i class="fas fa-trash-alt"></i>&nbsp;Eliminar</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><?php echo $items["nombre"]." ".$items["apellido_p"]." ".$items["apellido_m"]; ?></td>
                                                </tr>
<?php
                    }
?>
                                            </table>
<?php




                }
                else
                {
?>
                                            <table border="0" class="table">
                                                <tr>
                                                    <th>No se encontro ninguna coincidencia con su busqueda</th>
                                                </tr>
                                            </table>
<?php

                }




                break;
            }
            case "deparments_search":
            {

                $id = $_POST["id"];

                $oconns = new database();

                $datas = $oconns->getRows("select * from departamentos where idkey=".$id.";");

                if ($oconns->numberRows!=0)
                {
                    echo $datas[0]["nombre"]."|".$datas[0]["descripcion"];
                }



                break;
            }

            case "position_search":
            {

                $id = $_POST["id"];

                $oconns = new database();

                $datas = $oconns->getRows("select * from puestos where idkey=".$id.";");

                if ($oconns->numberRows!=0)
                {
                    echo $datas[0]["idkey"]."|".$datas[0]["idkey_departamentos"]."|".$datas[0]["nombre"]."|".$datas[0]["descripcion"];
                }

                break;
            }





            case "access_search":         
            {
                $busqueda = $_POST["busqueda"];

                $oconns = new database();

                
                $datas = $oconns->getRows("select empleados.idkey,generales.nombre,generales.apellido_p,generales.apellido_m from empleados,generales where empleados.idkey_generales=generales.idkey and (generales.nombre like '%".$busqueda."%' or generales.apellido_p like '%".$busqueda."%' or generales.apellido_m like '%".$busqueda."%');");


                if ($oconns->numberRows > 0)                    
                {

?>
                                            <table border="0" class="table">
                                                <tr>
                                                    <th width="10%">#</th>
                                                    <th>Nombre</th>
                                                    <th>Usuario</th>
                                                </tr>
<?php                                               
                    foreach ($datas as $items)        
                    {

                        $dtas=$oconns->getRows("select usuario_nombre from usuarios where idkey_empleados='".$items["idkey"]."';");
                        $final="Aun no asignado";
                        $rows = $oconns->numberRows;
                        if ($oconns->numberRows!=0)
                        {
                            $final =  $dtas[0]["usuario_nombre"];
                        }


?>

                                                <tr>
                                                    <td>


                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-primary btn-sm rounded " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-bars"></i></button>
                                                            <div class="dropdown-menu">                                                      
                                                                <a href="#" onclick="viewAccess('<?php echo $items["idkey"]; ?>');" class="dropdown-item"><i class="fas fa-user-edit"></i>&nbsp;Actualizar acceso</a>

                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><?php echo $items["nombre"]." ".$items["apellido_p"]." ".$items["apellido_m"]; ?></td>
                                                    <td><?php echo $final; ?></td>
                                                </tr>
<?php                    }
?>
                                            </table>
<?php
                }
                else
                {
?>
                                            <table border="0" class="table">
                                                <tr>
                                                    <th>No se encontro ninguna coincidencia con su busqueda</th>
                                                </tr>
                                            </table>
<?php
                }
                break;
            }

            case "access_datas":{

                $id = $_POST["id"];
                $oconns = new database();

                $datas = $oconns->getRows("select * from usuarios where idkey_empleados='".$id."';");
                if ($oconns->numberRows==0)
                {
                    echo "||".$id;
                }
                else
                {
                    echo $datas[0]["usuario_nombre"]."|". $oconns->desencriptar($datas[0]["usuario_contra"])."|".$id;
                }

                break;
            }






            case "select_clients":         
            {
                $busqueda = $_POST["busqueda"];

                $oconns = new database();

                
                $datas = $oconns->getRows("select clientes.idkey,generales.nombre,generales.apellido_p,generales.apellido_m from clientes,generales where clientes.idkey_generales=generales.idkey and (generales.nombre like '%".$busqueda."%' or generales.apellido_p like '%".$busqueda."%' or generales.apellido_m like '%".$busqueda."%');");


                if ($oconns->numberRows > 0)                    
                {

?>
                                            <table border="0" class="table">
                                                <tr>
                                                    <th width="10%">#</th>
                                                    <th>Nombre</th>
                                                </tr>
<?php                                               
                    foreach ($datas as $items)        
                    {
?>

                                                <tr>
                                                    <td>
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-primary btn-sm rounded " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-bars"></i></button>
                                                            <div class="dropdown-menu">
                                                                <a href="creditos_alta_1.php?id=<?php echo $items["idkey"]; ?>&query=<?php echo $busqueda; ?>"  class="dropdown-item"><i class="fas fa-file-alt"></i>&nbsp;Nuevo credito</a>
                                                                <a href="empleados_modificacion.php?id=<?php echo $items["idkey"]; ?>&query=<?php echo $busqueda; ?>" class="dropdown-item"><i class="fas fa-list-ol"></i>&nbsp;Listado de Creditos</a>                                                                
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><?php echo $items["nombre"]." ".$items["apellido_p"]." ".$items["apellido_m"]; ?></td>
                                                </tr>
<?php
                    }
?>
                                            </table>
<?php




                }
                else
                {
?>
                                            <table border="0" class="table">
                                                <tr>
                                                    <th>No se encontro ninguna coincidencia con su busqueda</th>
                                                </tr>
                                            </table>
<?php

                }




                break;
            }








    	}
  	}

?>