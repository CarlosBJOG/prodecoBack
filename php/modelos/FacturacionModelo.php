<?php

//modelo de la tabla categoria
require_once "db.php";



class FacturacionModelo {
   
    public $mysql;
    //constructor de clase 
    public function __construct(){
        $this->mysql = new database();
    }

    public function cargar_datos($fecha_inicio, $fecha_fin){
        $query = "SELECT ad.no_pago, ad.fecha_valor, ad.fecha_aprobacion, ad.idkey_creditos, c.monto, c.numero_pagos, p.nombre,
         concat(g.nombre,' ', g.apellido_p, ' ', g.apellido_m)as nombre_cliente, g.rfc FROM amortizaciones_dinamicas AS ad INNER JOIN creditos AS c ON c.idkey = ad.idkey_creditos 
         INNER JOIN productos AS p ON p.idkey = c.tipo_credito INNER JOIN clientes AS cl ON cl.idkey = c.idkey_clientes INNER JOIN generales AS g ON g.idkey = cl.idkey_generales
            WHERE ad.fecha_aprobacion BETWEEN '$fecha_inicio' AND '$fecha_fin' ";

        return $this->mysql->getRows($query);
    }

    public function cargarInfoClienteCredito ($idkey_credito){

        $query = "SELECT vcr.nombre as nom_cliente, vcr.nombre_producto , vcr.monto, vcl.curp, vcl.rfc, vcl.no_identificacion, vcl.nombre_identificacion, vdr.direccion_completa, clc.email, clc.telefono, cda.correo_facturacion, cda.domicilio_fiscal
         FROM view_creditos AS vcr INNER JOIN view_clientes as vcl ON vcl.idkey_cliente = vcr.idkey_clientes INNER JOIN view_direcciones vdr ON vdr.idkey_cliente = vcl.idkey_cliente
          INNER JOIN clientes_contacto clc ON clc.idkey_clientes = vcl.idkey_cliente INNER JOIN clientes_datos_adicionales cda ON cda.idkey_clientes = vcl.idkey_cliente WHERE vcr.idkey_credito ='$idkey_credito' AND clc.idkey_contacto_prioridad = 1 ";

        return $this->mysql->getRows($query);
    }

    public function cargar_pagos($fecha_inicio, $fecha_fin, $idkey){

        $query = "SELECT no_pago, pago, interes, iva, monto, amortizacion, saldo_insoluto, fecha_valor FROM amortizaciones_dinamicas WHERE fecha_aprobacion BETWEEN '$fecha_inicio' AND '$fecha_fin' AND idkey_creditos = '$idkey'";

        return $this->mysql->getRows($query);

    }
    
}

?>

