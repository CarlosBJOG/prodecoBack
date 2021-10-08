<?php

//modelo de la tabla categoria
require_once "db.php";



class CorteModelo {
   
    public $mysql;
    //constructor de clase 
    public function __construct(){
        $this->mysql = new database();
    }

    public function cargar_tabla(){
        $query = "SELECT * FROM corte_registro";

        return $this->mysql->getRows($query);

    }

    public function cargar_cajas(){

        $query = "SELECT idkey from corte_cajas";

        return $this->mysql->getRows($query);

    }

    public function ultimo_registro($idkey_caja){
        $query = " SELECT idkey, saldo_inicial, saldo_actual, saldo_final, fecha, idkey_usuario from saldo_corte where idkey = (SELECT MAX(idkey) from saldo_corte where idkey_caja = '$idkey_caja') AND estatus = 0 and idkey_caja = '$idkey_caja'";
        

        return $this->mysql->getRows($query);
    }
    
}

?>