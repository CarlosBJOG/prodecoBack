<?php

//modelo de la tabla categoria
require_once "db.php";



class ctaModelo {
   
    public $mysql;
    //constructor de clase 
    public function __construct(){
        $this->mysql = new database();
    }

    public function cargar_cuentas(){
        $query = "SELECT * FROM cuentas_contables";

        return $this->mysql->getRows($query);
    }

    public function cargar_cta($idkey){
        $idkey = floatval($idkey);
        $query = "SELECT * FROM cuentas_contables WHERE no_cuenta=". $idkey ;

        return $this->mysql->getRows($query);

    }

    public function update_cuenta($array){
        $array[0] = floatval($array[0]);
        $query = "UPDATE cuentas_contables SET no_cuenta ='$array[0]',   cta_acumulable ='".$array[1]."' , nombre = '".$array[2]."',  rubro= '".$array[3]."', 
        tipo= '".$array[4]."', naturaleza='".$array[5]."',  nivel='".$array[6]."' WHERE no_cuenta = ". $array[0];

        return $this->mysql->ShotSimple($query);
    }

    public function agregar_cuenta($array){
        $array[0] = floatval($array[0]);
        $query = "INSERT INTO cuentas_contables (no_cuenta, cta_acumulable, nombre, rubro, tipo, naturaleza, nivel) VALUES  
        ('$array[0]',  '$array[1]' , '$array[2]', '$array[3]',  '$array[4]' , '$array[5]', '$array[6]') "; 
      

        return $this->mysql->ShotSimple($query);
    }



    
}

?>