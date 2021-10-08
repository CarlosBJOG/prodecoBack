<?php

//modelo de la tabla categoria
require_once "db.php";



class perfilesModelo {
   
    public $mysql;
    //constructor de clase 
    public function __construct(){
        $this->mysql = new database();
    }

    public function infoPersonal ( $idkey_usuario ) {
        
        $query = "sELECT concat( de.nombre,' ',de.apellido_p,' ',de.apellido_m ) AS nombre, de.edad, de.email, de.tel_casa, de.celular, de.fecha_registro, concat(de.domicilio,' ',est.nombre,' ', mun.nombre,' ',loc.nombre) as direccion, cp.nombre as cp, us.usuario_nombre FROM datos_empleados AS de INNER JOIN usuarios AS us ON us.idkey_empleados = de.idkey INNER JOIN estados AS est ON (est.idkey = de.estado) INNER JOIN municipios AS mun ON ( mun.idkey = de.ciudad )
         INNER JOIN localidad AS loc ON ( loc.idkey = de.localidad ) INNER JOIN codigo_postal AS cp ON ( cp.idkey = de.cp ) WHERE us.idkey = '".$idkey_usuario."' ";

        return $this->mysql->getRows( $query );

    }

    public function clientesPromotor ( $idkey_usuario ) {

        $query = "SELECT COUNT(idkey_cliente) FROM `view_clientes` WHERE idkey_usuario = $idkey_usuario";

        return $this->mysql->getRows( $query );

    }
    public function creditosPromotor ( $idkey_usuario ) {

        
        $query = "SELECT COUNT(idkey_credito) FROM `view_creditos` WHERE idkey_usuario = $idkey_usuario ";

        return $this->mysql->getRows( $query );
    }

    public function creditosPromotorComp ( $idkey_usuario ) {

        
        $query = "SELECT folio, idkey_credito, nombre, nombre_producto, monto, fecha_creacion FROM view_creditos WHERE idkey_usuario = $idkey_usuario  ORDER BY fecha_creacion DESC";

        return $this->mysql->getRows( $query );
    }

    public function clientesPromotorComp( $idkey_usuario ) {

 
        $query = "SELECT nombre, fecha_creacion, idkey_cliente FROM view_clientes WHERE idkey_usuario = $idkey_usuario ORDER BY fecha_creacion desc";

        return $this->mysql->getRows( $query );

    } 

    public function polizaIngreso( $idkey_usuario ) {

 
        $query = "SELECT COUNT(idkey) as ingreso FROM poliza_ingreso WHERE idkey_usuario ='$idkey_usuario' ";

        return $this->mysql->getRows( $query );

    } 

    public function polizaEgreso( $idkey_usuario ) {

 
        $query = "SELECT count(idkey) as egreso FROM poliza_egreso WHERE idkey_usuario = '$idkey_usuario' ";

        return $this->mysql->getRows( $query );

    } 

    public function polizaOrden( $idkey_usuario ) {

 
        $query = "SELECT COUNT(idkey) as orden FROM poliza_orden WHERE idkey_usuario ='$idkey_usuario' ";

        return $this->mysql->getRows( $query );

    } 

    public function polizaDiario( $idkey_usuario ) {

 
        $query = "SELECT COUNT(idkey) as diario FROM poliza_diario WHERE idkey_usuario = '$idkey_usuario' ";

        return $this->mysql->getRows( $query );

    } 


    
}

?>
