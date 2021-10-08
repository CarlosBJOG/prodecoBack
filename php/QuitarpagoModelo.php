<?php

//modelo de la tabla categoria
require_once "db.php";



class QuitarpagoModelo {
   
    public $mysql;
    //constructor de clase 
    public function __construct(){
        $this->mysql = new database();
    }


    //cargar creditos para el datalist
    public function cargar($idkey_credito){

        $query = "SELECT idkey_credito, nombre FROM view_creditos where estatus = 1 and idkey_credito like '%".$idkey_credito."%' ";
        
        return $this->mysql->getRows($query);

    }

    //cargar saldos para alerta 
    public function cargar_saldos($idkey_credito){

        $query = "SELECT ad.saldo_insoluto AS saldo_dinamico, ad.no_pago, ad.fecha_valor, a.saldo_insoluto AS saldo_estatico, vc.nombre, vc.idkey_frecuencia  FROM amortizaciones_dinamicas as ad INNER JOIN amortizaciones AS a INNER JOIN view_creditos AS vc ON ad.idkey_creditos = a.idkey_creditos and ad.idkey_creditos = vc.idkey_credito WHERE ad.idkey_creditos = '$idkey_credito' AND ad.no_pago = (SELECT MAX(no_pago) FROM amortizaciones_dinamicas WHERE idkey_creditos = '$idkey_credito') AND a.pago = (SELECT MAX(no_pago) from amortizaciones_dinamicas WHERE idkey_creditos = '$idkey_credito') ";
        
        return $this->mysql->getRows($query);
    }

    public function cargar_datos($idkey_credito){
        
        $query = "SELECT no_pago FROM `amortizaciones_dinamicas` WHERE idkey_creditos = '$idkey_credito' and no_pago = (select MAX(no_pago) from amortizaciones_dinamicas where idkey_creditos = '$idkey_credito') ";
    
        return $this->mysql->getRows($query);
    }

    public function dias_transcurridos( $fecha_valor){
        
        $query = "select DATEDIFF('".$fecha_valor."', NOW()) as dias_transcurridos;";

        return $this->mysql->getSimple($query);
    }

    public function guardar_datos($idkey_credito, $num_pago, $folio, $fecha_registro, $monto, $idkey_usuario){
        $query = "INSERT INTO quitar_pago (idkey_credito, num_pago, folio, fecha_registro, monto, idkey_usuario) 
        values ('$idkey_credito', '$num_pago', '$folio', '$fecha_registro', '$monto', '$idkey_usuario')";

        return $this->mysql->ShotSimple($query);

    }

    public function actualizar_capital($idkey_credito, $monto, $num_pago){
        $query =" UPDATE amortizaciones_dinamicas SET saldo_insoluto = (saldo_insoluto - $monto), estatus_quitarpago = '1' where no_pago = '$num_pago' and idkey_creditos = '$idkey_credito'"; 

        return $this->mysql->ShotSimple($query);
    }
    
}

?>