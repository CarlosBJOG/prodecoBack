<?php
//Redirección dependiendo el tipo de usuario
@session_start(); 

if($_SESSION["tipo_usuario"] == "2")
	header('Location: ../perfiles/perfil-promotor.php');
else 
	header('Location: ../home.php');
exit;

?>