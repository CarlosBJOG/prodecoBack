<?php

//modelo de la tabla categoria
require "db.php";


class GarantiasModelo {
   
    public $mysql;
    //constructor de clase 
    public function __construct(){
        $this->mysql = new database();
    }

    public function cargarCreditos(){
        $query = "select vc.* from view_creditos as vc where vc.idkey_productos != 6 and vc.idkey_productos !=7 ";

        return $this->mysql->getRows($query);

    }
    public function cargarCredito($idkeyCredito){
        $query = "SELECT * FROM view_creditos WHERE idkey_credito = $idkeyCredito";

        return $this->mysql->getRows($query);

    }

    public function guardarSeguro($datos){
        $query = "INSERT INTO seguros_deposito (idkey_cliente, idkey_credito, monto, fecha_registro, folio_operacion, banco, idkey_usuario) VALUES 
                ('".$datos[0]."', '".$datos[1]."', '".$datos[2]."', CURRENT_TIMESTAMP(), '".$datos[3]."', '".$datos[4]."', '".$datos[5]."' )";

        return $this->mysql->ShotSimple($query);

    }

    
    public function guardarMovContableEfectivo($datos){
        $query = "INSERT INTO movimientos_contables (idkey_cuenta_contable, debe, haber, idkey_credito, idkey_cliente, observaciones, fecha, estatus, idkey_usuario) VALUES 
                ('1010102', '".$datos[0]."', '0', '".$datos[1]."', '".$datos[2]."', '".$datos[3]."',CURRENT_TIMESTAMP(), '0', '".$datos[4]."' )";

        return $this->mysql->ShotSimple($query);

    }

    public function guardarMovContableEfectivoHaber($datos){
        $query = "INSERT INTO movimientos_contables (idkey_cuenta_contable, debe, haber, idkey_credito, idkey_cliente, observaciones, fecha, estatus, idkey_usuario) VALUES 
                ('403012205',  '0', '".$datos[0]."', '".$datos[1]."', '".$datos[2]."', '".$datos[3]."',CURRENT_TIMESTAMP(), '0', '".$datos[4]."' )";

        return $this->mysql->ShotSimple($query);

    }

    public function guardarMovContableBanco($datos){
        $query = "INSERT INTO movimientos_contables (idkey_cuenta_contable, debe, haber, idkey_credito, idkey_cliente, observaciones, fecha, estatus, idkey_usuario) VALUES 
                ('10201', '".$datos[0]."', '0', '".$datos[1]."', '".$datos[2]."', '".$datos[3]."',CURRENT_TIMESTAMP(), '0', '".$datos[4]."' )";

        return $this->mysql->ShotSimple($query);

    }

    public function guardarMovContableBancoHaber($datos){
        $query = "INSERT INTO movimientos_contables (idkey_cuenta_contable, debe, haber, idkey_credito, idkey_cliente, observaciones, fecha, estatus, idkey_usuario) VALUES 
                ('403012205',  '0', '".$datos[0]."', '".$datos[1]."', '".$datos[2]."', '".$datos[3]."',CURRENT_TIMESTAMP(), '0','".$datos[4]."' )";

        return $this->mysql->ShotSimple($query);

    }

    public function cargarSeguros() {
        $query = "SELECT sd.*, vc.nombre, vc.nombre_producto FROM seguros_deposito AS sd INNER JOIN view_creditos AS vc ON vc.idkey_credito = sd.idkey_credito ";

        return $this->mysql->getRows($query);

    }

    public function cargarCreditosGrupales(){

        $query = "SELECT * FROM view_clientes_grupo WHERE estatus = 1";

        return $this->mysql->getRows($query);

    }

    public function cargarCreditoGrupal($idkey){

        $query = "SELECT * FROM view_clientes_grupo WHERE estatus = 1 and idkey_credito = '$idkey[0]' and idkey_cliente = '$idkey[1]'";

        return $this->mysql->getRows($query);

    }

    public function cargarMaxSeguro($idkey_credito, $idkey_cliente) {

        $query = "SELECT SUM(debe)as total_debe, SUM(haber)as total_haber FROM `movimientos_contables` where idkey_credito = '$idkey_credito' and idkey_cliente = '$idkey_cliente' and estatus = 0 ";

        return $this->mysql->getRows($query);

    }

    public function cargarSeguroActual($idkey_credito, $idkey_cliente) {

        $query = "SELECT * FROM `seguros_deposito` where idkey_cliente = '$idkey_cliente' and idkey_credito = '$idkey_credito' ";

        return $this->mysql->getRows($query);
    }

    public function guardarRetiro($datos) {
        $query = "INSERT INTO seguros_retiro (monto, fecha_registro, observaciones, banco, folio, idkey_credito, idkey_cliente, idkey_seguro, idkey_usuario) VALUES 
                ('".$datos[0]."', CURRENT_TIMESTAMP(), '".$datos[1]."', '".$datos[2]."', '".$datos[3]."', '".$datos[4]."', '".$datos[5]."', '".$datos[6]."', '".$datos[7]."' )";

        return $this->mysql->ShotSimple($query);

    }

    public function updateSeguros($idkey) {
        $query = "UPDATE seguros_deposito SET estatus = '1' WHERE idkey = '".$idkey."' ";

        return $this->mysql->ShotSimple($query);

    }

    public function cargarCreditoGarantia($idkey) {
        $query = "SELECT * FROM view_creditos WHERE idkey_credito = $idkey ";

        return $this->mysql->getRows($query);
    }

    public function guardarGarantia($info){
        $query ="INSERT INTO garantias_deposito (monto, fecha_registros, fecha_desembolso, idkey_cliente, nombre, idkey_credito, tipo_credito, idkey_usuario) VALUES 
        ('".$info[0]."', CURRENT_TIMESTAMP(), '".$info[1]."', '".$info[2]."', '".$info[3]."', '".$info[4]."', '".$info[5]."', '".$info[6]."' )";

        return $this->mysql->ShotSimple($query);
    }

    public function cargarGarantias(){

        $query = "SELECT * FROM garantias_deposito";

        return $this->mysql->getRows($query);

    }

    public function cargarGarantia($idkey){
        $query = "SELECT * FROM garantias_deposito WHERE idkey = '".$idkey."' ";

        return $this->mysql->getRows($query);
    }

    public function guardarGarantiaRetiro($info){
        $query ="INSERT INTO garantias_retiro (monto, fecha_retiro, banco, folio, idkey_cliente, tipo_credito, idkey_credito, nombre_cliente, idkey_garantia, observaciones, idkey_usuario) VALUES 
        ('".$info[0]."', CURRENT_TIMESTAMP(), '".$info[1]."', '".$info[2]."', '".$info[3]."', '".$info[4]."', '".$info[5]."', '".$info[6]."', '".$info[7]."', '".$info[8]."', '".$info[9]."')";

        return $this->mysql->ShotSimple($query);
    }

    public function updategarantias($idkey) {
        $query = "UPDATE garantias_deposito SET estatus = '1' WHERE idkey = '".$idkey."' ";

        return $this->mysql->ShotSimple($query);
    }

    

    
}

?>

