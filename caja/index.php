<?php
//Redirección provisional

@session_start(); 

if($_SESSION["tipo_usuario"] == "6" || $_SESSION["tipo_usuario"] =="1")
	header('Location: cartera_transito_sup.php');
else if($_SESSION["tipo_usuario"] == "4")
	header('Location: cartera_transito_cajero.php');
else
	echo "<script>alert('Usted no tiene permisos para acceder a este apartado!".$_SESSION["tipo_usuario"] ."'); 
      window.location.href='../home.php'; </script>";
exit;

?>