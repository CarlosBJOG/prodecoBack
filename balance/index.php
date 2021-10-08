<?php
//Redirección dependiendo el tipo de usuario
@session_start(); 

if($_SESSION["tipo_usuario"] == "5" ) //
	header('Location: balance.php');
else 
	header('Location: balance.php');
exit;

?>