<?php
    require_once('db.php');

    $usuarios = $_POST["uname1"];
    $passwords = $_POST["pwds1"];
  


    $oconns = new database();
     //$dats = $oconns->getRows("select u.idkey, u.idkey_tipo_usuario, t.color, u.usuario_nombre, g.nombre, g.apellido_p, g.apellido_m from usuarios u, empleados e, generales g, usuarios_tipo t where usuario_nombre='".$usuarios."' and usuario_contra='".$oconns->encriptar($passwords)."' and u.idkey_empleados=e.idkey and e.idkey_generales=g.idkey and u.idkey_tipo_usuario=t.idkey;");
     $dats = $oconns->getRows("select u.idkey, u.idkey_tipo_usuario, t.color, u.usuario_nombre, de.nombre, de.apellido_p, de.apellido_m, de.imagen from usuarios u, datos_empleados de, usuarios_tipo t where usuario_nombre='".$usuarios."' and usuario_contra= '".$oconns->encriptar($passwords)."' and u.idkey_empleados= de.idkey and u.idkey_tipo_usuario=t.idkey and u.activo = '1' ");
  
    if (($oconns->numberRows)==0)
    {
        echo 0;
    }
    else
        {
            session_start();
            $_SESSION["usuario_nombre"] = $dats[0]["usuario_nombre"];
            $_SESSION["nombre"] = $dats[0]["nombre"];
            $_SESSION["apellido_p"] = $dats[0]["apellido_p"];
            $_SESSION["apellido_m"] = $dats[0]["apellido_m"];            
            $_SESSION["idkey"] = $dats[0]["idkey"];        
            $_SESSION["tipo_usuario"] = $dats[0]["idkey_tipo_usuario"];     
            $_SESSION["color"] = $dats[0]["color"];     
            $_SESSION["imagen"] = $dats[0]["imagen"];  
            $_SESSION['tiempo'] = time();

            echo 1;
        }
?>
