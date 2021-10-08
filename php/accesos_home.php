<?php 
//Comprobar accesos
  $cartera = "";
  $seguimiento = "";
  $caja = "";
  $facturacion = "";
  $contabilidad = "";
  $administracion = "";
  $ingresos = "";
  $garantiasyseguros = "";
  $c_vencidos = "";
  $balance = "";
  $cortes_caja = '';
  $reportes = '';


  
  if($_SESSION["tipo_usuario"] == "1"){//Administrador: acceso total
  }
  else if($_SESSION["tipo_usuario"] == "2"){ //Promotor: Solo cartera y seguimiento
    $caja = "hidden";
    $facturacion = "hidden";
    $contabilidad = "hidden";
    $administracion = "hidden";
    $garantiasyseguros = "hidden";
    $c_vencidos = "hidden";
    $balance = "hidden";
    $cortes_caja = 'hidden';
    $reportes = 'hidden';
    
  }
  else if($_SESSION["tipo_usuario"] == "3"){ //Supervisor: Solo cartera y seguimiento
    $caja = "hidden";
    $facturacion = "hidden";
    $contabilidad = "hidden";
    $administracion = "hidden";
    $ingresos = "hidden";
    $garantiasyseguros = "hidden";
    $c_vencidos = "hidden";
    $balance = "hidden";
    $cortes_caja = 'hidden';
  }
  else if($_SESSION["tipo_usuario"] == "4"){ //Cajero: Solo caja
    $cartera = "hidden";
    $seguimiento = "hidden";
    $facturacion = "hidden";
    $contabilidad = "hidden";
    $administracion = "hidden";
    $balance = "hidden";
    $reportes = 'hidden';
  }
  else if($_SESSION["tipo_usuario"] == "5"){ //Contador: Solo caja y contabilidad
    $cartera = "hidden";
    $seguimiento = "hidden";
    $administracion = "hidden";
    $ingresos = "hidden";
    $garantiasyseguros = "hidden";
    $c_vencidos = "hidden";
    $caja = "hidden";
    $cortes_caja = 'hidden';
    $reportes = 'hidden';
  }
   else if($_SESSION["tipo_usuario"] == "6"){ //Supervisor de caja
    $cartera = "hidden";
    $seguimiento = "hidden";
    $facturacion = "hidden";
    $contabilidad = "hidden";
    $administracion = "hidden";  
    // $garantiasyseguros = "hidden";
    //$c_vencidos = "hidden";
    $balance = "hidden";
    $reportes = 'hidden';
    
  }
  else{//Default: todo oculto
    $cartera = "hidden";
    $seguimiento = "hidden";
    $caja = "hidden";
    $facturacion = "hidden";
    $contabilidad = "hidden";
    $administracion = "hidden";
    $ingresos = "hidden";
    $garantiasyseguros = "hidden";
    $c_vencidos = "hidden";
    $balance = "hidden";
    $cortes_caja = 'hidden';
    $reportes = 'hidden';
  }
?>