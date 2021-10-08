<?php

//modelo de la tabla categoria
require_once "db.php";



class GastosModelo {
   
    public $mysql;
    //constructor de clase 
    public function __construct(){
        $this->mysql = new database();
    }

    public function datosCreditos() {
        $query = "SELECT folio, nombre, nombre_producto, idkey_credito, idkey_clientes FROM view_creditos";

        return $this->mysql->getRows($query);
    }

    public function cargarCredito($idkey) {
        $query = "SELECT folio, nombre, nombre_producto, idkey_credito, idkey_clientes FROM view_creditos where idkey_credito = $idkey";

        return $this->mysql->getRows($query);
    }
 
    public function aplicarCobranza ($datos){

        $query = "INSERT INTO gastos_cobranza (idkey_credito, fecha_registro, monto, folio_operacion, banco, id_operacion, desc_operacion, estatus, desc_estatus, idkey_usuario) 
        VALUES('".$datos[0]."', CURRENT_TIMESTAMP(), '".$datos[1]."', '".$datos[2]."', '".$datos[3]."', '".$datos[4]."', '".$datos[5]."', '0', 'Pendiente', '".$datos[6]."') ";

        return $this->mysql->ShotSimple($query);
    }

    public function cargarCobranza() {

        $query = "SELECT * FROM gastos_cobranza";

        return $this->mysql->getRows($query);
    }

    public function tablaCajero() {

        $query = "SELECT gc.idkey, gc.idkey_credito, gc.fecha_registro, gc.fecha_valor, gc.monto, gc.estatus, gc.desc_estatus, gc.id_operacion, vc.nombre, vc.nombre_producto FROM 
                    gastos_cobranza AS gc INNER JOIN view_creditos AS vc ON vc.idkey_credito = gc.idkey_credito ";

        return $this->mysql->getRows($query);
    }

    public function actualizarCobranza($idkey) {

        $query = "UPDATE gastos_cobranza SET fecha_valor = CURRENT_TIMESTAMP(), estatus ='1', desc_estatus = 'Aplicado' WHERE idkey = $idkey" ;

        return $this->mysql->ShotSimple($query);
    }

}

?>