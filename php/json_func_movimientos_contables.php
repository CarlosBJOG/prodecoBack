<?php
    //Conexión a la BD
    require_once "db.php";

    //****Movimientos contables para desembolsos*******////////
    /*
    1: efectivo
    2: transferencia
    3: cheque
    *****/
    /**Estatus
            1: pendiente
            2: en tránsito
            3: solicitado
            4: pendiente de aplicar
            5: desembolsado
            6: recibido*/
            //movcont_desembolso(150, 2, 0, 2);

    function movcont_desembolso($idkey_credito, $idkey_estatus, $monto_solicitado, $idkey_usuario){
        $oconns = new database();
        $data = $oconns->getRows("select idkey_tipo_desembolso, monto from creditos where idkey=$idkey_credito");
        $tipo_desembolso = $data[0]["idkey_tipo_desembolso"];
        $monto = $data[0]["monto"];
        $insert = false;

        //En efectivo --> En tránsito
        if($tipo_desembolso==1 && $idkey_estatus==2){
            $idkey_cuenta_contable1 = 1010102;
            $idkey_cuenta_contable2 = 10102;
            $debe1 = $monto;
            $debe2 = 0;
            $haber1 = 0;
            $haber2 = $monto;
            $insert = true;
        }
        //En efectivo --> Desembolsado
        else if($tipo_desembolso==1 && $idkey_estatus==5){
            $idkey_cuenta_contable1 = 1010102;
            $idkey_cuenta_contable2 = 10501;
            $debe1 = 0;
            $debe2 = $monto;
            $haber1 = $monto;
            $haber2 = 0;
            $insert = true;
        }
        
        if($insert==true) 
            $oconns->ShotSimple("insert into movimientos_contables(idkey_cuenta_contable, debe, haber, idkey_credito, idkey_usuario) values ('$idkey_cuenta_contable1', '$debe1', '$haber1', '$idkey_credito', '$idkey_usuario'), ('$idkey_cuenta_contable2', '$debe2', '$haber2', '$idkey_credito', '$idkey_usuario')");
    }

    function movcont_desembolso_poliza_egreso($idkey_poliza_egreso, $tipo_desembolso, $idkey_estatus, $monto, $idkey_usuario){
        $oconns = new database();
        //En efectivo --> Pendiente de aplicar
        if($tipo_desembolso==1 && $idkey_estatus==4){
            $idkey_cuenta_contable1 = 10102;
            $idkey_cuenta_contable2 = 10201;
            $debe1 = $monto;
            $debe2 = 0;
            $haber1 = 0;
            $haber2 = $monto;

            $oconns->ShotSimple("insert into movimientos_contables(idkey_cuenta_contable, debe, haber, idkey_usuario) values ('$idkey_cuenta_contable1', '$debe1', '$haber1', '$idkey_usuario'), ('$idkey_cuenta_contable2', '$debe2', '$haber2', '$idkey_usuario')");
            return "insert into movimientos_contables(idkey_cuenta_contable, debe, haber, idkey_usuario) values ('$idkey_cuenta_contable1', '$debe1', '$haber1', '$idkey_usuario'), ('$idkey_cuenta_contable2', '$debe2', '$haber2', '$idkey_usuario')";
        }
    }

    function movcont_desembolso_poliza_diario($idkey_poliza_diario, $tipo_desembolso, $idkey_estatus, $monto, $idkey_usuario){
        $oconns = new database();
        //En efectivo --> En tránsito
        if($tipo_desembolso==1 && $idkey_estatus==2){
            $idkey_cuenta_contable1 = 1010102;
            $idkey_cuenta_contable2 = 10102;
            $debe1 = $monto;
            $debe2 = 0;
            $haber1 = 0;
            $haber2 = $monto;

            $oconns->ShotSimple("insert into movimientos_contables(idkey_cuenta_contable, debe, haber, idkey_usuario) values ('$idkey_cuenta_contable1', '$debe1', '$haber1', '$idkey_usuario'), ('$idkey_cuenta_contable2', '$debe2', '$haber2', '$idkey_usuario')");
            return "insert into movimientos_contables(idkey_cuenta_contable, debe, haber, idkey_usuario) values ('$idkey_cuenta_contable1', '$debe1', '$haber1', '$idkey_usuario'), ('$idkey_cuenta_contable2', '$debe2', '$haber2', '$idkey_usuario')";
        }
    }
    
?>
