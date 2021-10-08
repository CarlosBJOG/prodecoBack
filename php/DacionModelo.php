<?php

//modelo de la tabla categoria
require_once "db.php";



class DacionModelo {
   
    public $mysql;
    //constructor de clase 
    public function __construct(){
        
        $this->mysql = new database();
    }

    //implementar un metodo para listar los registrosd
    public function listar(){

        $sql = "select vc.idkey_credito, vc.nombre, vc.nombre_producto as producto, vc.tipo_credito, vc.folio, vc.monto, vc.estatus from  view_creditos vc where estatus=1";

        return $this->mysql->getRows($sql);

    }

    public function cargar_usuario($idkey_credito){

        $query = "select idkey_credito, nombre, nombre_producto, monto from view_creditos where idkey_credito = '".$idkey_credito."' ";
        
        return $this->mysql->getRows($query);

    }

    public function guardar_datos( $tipo_garantia, $idkey_credito, $monto, $fecha_registro, $tipo_usuario){

        $query = "INSERT INTO dacion_pago (tipo_garantia, idkey_credito, monto, fecha_registro, tipo_usuario) 
        values ('$tipo_garantia', '$idkey_credito', '$monto', '$fecha_registro', '$tipo_usuario') ";

        return $this->mysql->ShotSimple($query);

    }

    public function guardar_mueble($categoria, $valor_comercial, $marca, $modelo_garantia, $ref_factura, $fecha_ad, $cobertura, $observaciones, $idkey_credito, $idkey_usuario){
        $query = "INSERT INTO dacion_mueble (categoria, valor_comercial, marca, modelo, ref_o_fact, fecha_adquisicion, cobertura, observaciones, idkey_credito, idkey_usuario) 
        values ('$categoria', '$valor_comercial', '$marca', '$modelo_garantia', '$ref_factura', '$fecha_ad', '$cobertura', '$observaciones', '$idkey_credito', '$idkey_usuario') ";

        return $this->mysql->ShotSimple($query);
       

    }

    public function guardar_inmueble($categoria, $valor_fiscal, $valor_catastral, $num_escritura, $registro, $gravamen, $hipoteca, $aforo, $descripcion, $observaciones, $medidas, $idkey_credito, $idkey_usuario){
        $query = "INSERT INTO dacion_inmueble (categoria, valor_fiscal, valor_catastral, numero_escritura, registro, gravamen, hipoteca, aforo, descripcion, observaciones, medidas, idkey_credito, idkey_usuario) 
        values ('$categoria', '$valor_fiscal', '$valor_catastral', '$num_escritura', '$registro', '$gravamen', '$hipoteca', '$aforo', '$descripcion', '$observaciones', '$medidas', '$idkey_credito', '$idkey_usuario') ";

        return $this->mysql->ShotSimple($query);
       

    }
    public function cargar_inmueble($idkey_credito){
        $query = "select di.idkey, di.valor_fiscal, di.valor_catastral, di.numero_escritura, di.registro, di.medidas, di.observaciones ,gc.nombre as categoria from dacion_inmueble di inner join garantias_categorias gc on gc.idkey=di.categoria where di.idkey_credito='".$idkey_credito."'";
        
        return $this->mysql->getRows($query);
    }   

    public function cargar_mueble($idkey_credito){
        $query = "select dm.idkey, dm.valor_comercial, dm.modelo,dm.marca, dm.ref_o_fact, dm.fecha_adquisicion, dm.observaciones ,gc.nombre as categoria from dacion_mueble dm inner join garantias_categorias gc on gc.idkey=dm.categoria where dm.idkey_credito='".$idkey_credito."' ";
        
        return $this->mysql->getRows($query);
    }  

    public function actualizar_pago($idkey_credito, $no_pago){
        $query = "UPDATE amortizaciones_dinamicas SET saldo_insoluto= '0', dacion_estatus = '1' WHERE idkey_creditos = '$idkey_credito' and no_pago = '$no_pago' ";

        return $this->mysql->ShotSimple($query);
     }

    public function obtener_pago($idkey_credito){
         $query =  "select no_pago from amortizaciones_dinamicas where idkey_creditos = '".$idkey_credito."' order by no_pago desc ,fecha_valor desc limit 1 ";

         return  $this->mysql->getRows($query);
     }


    public function cambiar_estatus($idkey_credito){
        $query = "UPDATE creditos SET estatus= 5 WHERE idkey = '$idkey_credito' ";

        return $this->mysql->ShotSimple($query);
     }

     public function eliminar_mueble($idkey_mueble){
         $query = "delete from dacion_mueble where idkey='".$idkey_mueble."';";

         return $this->mysql->ShotSimple($query);

     }

     public function eliminar_inmueble($idkey_mueble){
        $query = "delete from dacion_inmueble where idkey='".$idkey_mueble."';";

        return $this->mysql->ShotSimple($query);

    }

    public function comprobar_mueble($idkey_credito){
        $query = "select * from dacion_mueble where idkey_credito = '".$idkey_credito."'";
        
        return  $this->mysql->getRows($query);

    }
    public function comprobar_inmueble($idkey_credito){
        $query = "select * from dacion_inmueble where idkey_credito = '".$idkey_credito."'";
        
        return  $this->mysql->getRows($query);

    }

}

?>