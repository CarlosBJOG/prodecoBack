<?php
//Redirección dependiendo el tipo de usuario
@session_start(); 

if($_SESSION["tipo_usuario"] == "2" || $_SESSION["tipo_usuario"] == "1")
	header('Location: seguimiento-promotor.php');
else if($_SESSION["tipo_usuario"] == "3" )
	header('Location: seguimiento-supervisor.php');
exit;

?>