<?php
//Redirección dependiendo el tipo de usuario
@session_start(); 

if($_SESSION["tipo_usuario"] == "5" || $_SESSION["tipo_usuario"] == "1" ) //
	header('Location: facturacion.php');
else 
	header('Location: buro_credito_cajero.php');
exit;

?>