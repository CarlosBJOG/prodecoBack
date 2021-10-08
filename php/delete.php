
<?php
	require_once "db.php";


  if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {

    	$module = $_POST["module"];


    	switch($module)
    	{   
			case "borrar_relacion":{
				if(isset($_POST['id'])){
				$idkey = $_POST["id"];

    			$oconns = new database();
    			//$coincidencia = $oconns->getSimple("select * from clientes_relaciones where idkey='".$idkey."';");

    			$oconns->ShotSimple("delete from clientes_relaciones where idkey='".$idkey."';");
    			echo 1;
				exit;
                }
                echo 0;
				break;
             }
    		
			case "borrar_contacto":{
				if(isset($_POST['id'])){
				$idkey = $_POST["id"];

    			$oconns = new database();
    			//$coincidencia = $oconns->getSimple("select * from clientes_relaciones where idkey='".$idkey."';");
    			
    			$oconns->ShotSimple("delete from clientes_contacto where idkey='".$idkey."';");
    			echo 1;
				exit;
                }
                echo 0;
				break;
             }
             
            case "borrar_ingreso":{
				if(isset($_POST['id'])){
				$idkey = $_POST["id"];

    			$oconns = new database();
    			//$coincidencia = $oconns->getSimple("select * from clientes_relaciones where idkey='".$idkey."';");
    			
    			$oconns->ShotSimple("delete from clientes_ingresos where idkey='".$idkey."';");
    			echo 1;
				exit;
                }
                echo 0;
				break;
             }
             
            case "borrar_egreso":{
				if(isset($_POST['id'])){
				$idkey = $_POST["id"];

    			$oconns = new database();
    			//$coincidencia = $oconns->getSimple("select * from clientes_relaciones where idkey='".$idkey."';");
    			
    			$oconns->ShotSimple("delete from clientes_egresos where idkey='".$idkey."';");
    			echo 1;
				exit;
                }
                echo 0;
				break;
             }
            case "borrar_mueble":{
				if(isset($_POST['id'])){
				$idkey = $_POST["id"];

    			$oconns = new database();
    			//$coincidencia = $oconns->getSimple("select * from clientes_relaciones where idkey='".$idkey."';");
    			
    			$oconns->ShotSimple("delete from garantias_mueble where idkey='".$idkey."';");
    			echo 1;
				exit;
                }
                echo 0;
				break;
             }
		} 
    }

?>

