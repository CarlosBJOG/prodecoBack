<?php

//modelo de la tabla categoria
require_once "db.php";



class CorteModelo {
   
    public $mysql;
    //constructor de clase 
    public function __construct(){
        $this->mysql = new database();
    }

    public function ultimo_registro($idkey_usuario){
        $query = "SELECT * FROM corte_caja WHERE idkey_usuario = '$idkey_usuario' ORDER BY idkey DESC LIMIT 1 ";

        return $this->mysql->getRows($query);
    }

    public function abrir_corte($array) {

        $query = "INSERT INTO corte_caja (fecha_inicio, monto, fondo, idkey_usuario) VALUES(CURRENT_TIMESTAMP(), '" .$array[0]. "', '".$array[1]."', '".$array[2]."' ) ";


        return $this->mysql->ShotSimple($query);

    }

    public function loadPago ($idkey_pago) {
        $query = "SELECT pago, fecha_aprobacion, idkey_usuario, idkey  FROM amortizaciones_dinamicas WHERE idkey = '$idkey_pago' and aprobado = 1 ";

        return $this->mysql->getRows($query);
    }

    public function savePago($datos) {
        $query = "INSERT INTO trafico_corte (monto, fecha_aplicacion, idkey_usuario, idkey_pago) VALUES ('".$datos[0]."', '".$datos[1]."', '".$datos[2]."', '".$datos[3]."') ";
        

        return $this->mysql->ShotSimple($query);
    }

    public function cargar_corte($idkey_usuario) {
        $query = "SELECT * from trafico_corte WHERE idkey_usuario = $idkey_usuario AND estatus = 0";

        return $this->mysql->getRows($query);
    }

    public function guardarCorte ( $datos ) {

        $query = " UPDATE corte_caja SET fecha_cierre = CURRENT_TIMESTAMP(), estatus = '1' , monto = '".$datos[0]."', fondo = '".$datos[1]."', total = '".$datos[2]."' WHERE idkey_usuario = '".$datos[3]."' AND estatus = '0' ";


        return $this->mysql->ShotSimple($query);

    }

    public function cargarTiposUsuario () {

        $query = " SELECT idkey_tipo_usuario, usuario_nombre, usuario_contra FROM usuarios WHERE idkey_tipo_usuario = 6 OR idkey_tipo_usuario = 1"; 

        return $this->mysql->getRows($query);

    }

    public function encriptarPass ($pass) {

        return $this->mysql->encriptar($pass);

    }

    public function updateCorte ( $datos ) {

        $query = "UPDATE trafico_corte SET estatus = '1', idkey_corte = '".$datos[0]."' WHERE idkey_usuario = '".$datos[1]."' AND  estatus= '0'";

        return $this->mysql->ShotSimple($query);

    } 

    public function cargarFondo ( $idkey ) {

        $query = "SELECT idkey,fondo FROM corte_caja WHERE idkey_usuario = '".$idkey."' ORDER BY idkey DESC LIMIT 1 ";

        return $this->mysql->getRows($query);

    }

    public function cargarHistorial( $idkeyUsuario ) {

        $query = "SELECT idkey, fecha_inicio, fecha_cierre, monto, fondo FROM corte_caja WHERE idkey_usuario = '".$idkeyUsuario."' AND estatus = '1' ";

        return $this->mysql->getRows($query);

    }

    public function cargarHistorialCompleto(  ) {

        $query = "SELECT idkey, fecha_inicio, fecha_cierre, monto, fondo FROM corte_caja WHERE estatus = '1' ";

        return $this->mysql->getRows($query);

    }

    public function cargarPagosCorte ( $idkey_corte ) {

        $query = " SELECT monto, fecha_aplicacion, idkey_pago FROM trafico_corte WHERE idkey_corte = '$idkey_corte' ";

        return $this->mysql->getRows($query);
    }


    
}

?>