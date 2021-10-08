<?php

//modelo de la tabla categoria
require "db.php";


class BuroModelo {
   
    public $mysql;
    //constructor de clase 
    public function __construct(){
        $this->mysql = new database();
    }

    public function guardar_datos($totalRegistros, $costoUnitario, $monto, $idkey_usuario, $observaciones){
        $query = "INSERT INTO buro_credito (num_registros, costo_unitario, monto, fecha_registro, idkey_usuario, observaciones, estatus, desc_estatus) 
        values ('$totalRegistros', '$costoUnitario', '$monto', CURRENT_TIMESTAMP(), '$idkey_usuario', '$observaciones', '0', 'Pendiente')";

        return $this->mysql->ShotSimple($query);

    }
       //implementar un metodo para listar los registrosd
    public function listar(){

        $sql = "SELECT * FROM buro_credito";

        return $this->mysql->getRows($sql);

    }

    public function aprobar_pago($idkey, $idkey_usuario){

        $query = " UPDATE buro_credito SET fecha_alta= CURRENT_TIMESTAMP(), estatus= '1', desc_estatus= 'Aplicado', idkey_usuario= '$idkey_usuario'  WHERE idkey = '$idkey'";

        return $this->mysql->ShotSimple($query);
    }

    public function imprimir($idkey){
        $query = "SELECT idkey, num_registros, costo_unitario, monto, fecha_alta FROM buro_credito WHERE idkey = '$idkey'";

        return $this->mysql->getRows($query);
        
    }
    
}

?>