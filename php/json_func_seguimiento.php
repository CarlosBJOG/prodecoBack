<?php

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $funcion = $_POST["funcion"]; // tipo de operación
    @session_start(); 
    $idkey_usuario = $_SESSION['idkey']; 
    require_once 'clases/conversor.php';

    //Conexión a la BD
    require_once "db.php";
    $oconns = new database();

    require_once 'clases/generador_tablas_amortizacion.php';

    function ultimo_pago_credito($idkey_credito){//Ultimo pago diferente de 0 amort dinámica
        $oconns = new database();
        $data = $oconns->getRows("select * from amortizaciones_dinamicas where pago<>0 and idkey_creditos = '".$idkey_credito."' order by no_pago desc ,fecha_valor desc limit 1");
        if($oconns->numberRows >0){
            $res["n"] = 1;
            $res["fecha_ultimo_pago"] = $data[0]["fecha_valor"];
            $res["no_ultimo_pago"] = $data[0]["no_pago"];
        }
        else
            $res["n"] = 0;
        return $res;
    }

    function ultimo_pago_credito1($idkey_credito){//Ultimo pago amort dinámica
        $oconns = new database();
        //Consultar última fila de la amortización dinámica
        $data = $oconns->getRows("select * from amortizaciones_dinamicas where idkey_creditos = '".$idkey_credito."' order by no_pago desc ,fecha_valor desc limit 1 ");//Para obtener el último pago realizado 
        if($oconns->numberRows >0){
            $res["n"] = 1;
            $res["saldo_insoluto"] = $data[0]["saldo_insoluto"];
            $res["no_ultimo_pago"] = $data[0]["no_pago"];
            $res["interes_acumulado"] = $data[0]["interes_acumulado"];
        }
        else
            $res["n"] = 0;
        return $res;
    }

    function consulta_pago_credito($idkey_credito, $no_pago){//Siguiente pago amort estática
        $oconns = new database();
        $data = $oconns->getRows("select * from amortizaciones where pago = ".$no_pago." and idkey_creditos = '".$idkey_credito."'");
        if($oconns->numberRows >0){
            $res["n"] = 1;
            $res["idkey"] = $data[0]["idkey"];
            $res["fecha_pago"] = $data[0]["fecha_pago"];
            $res["cantidad_pagar"] = $data[0]["total"];
            $res["saldo_insoluto"] = $data[0]["saldo_insoluto"];
            $res["capital"] = $data[0]["renta"];
        }
        else
            $res["n"] = 0;
        return $res;
    }

    function calcular_interes_periodo($interes_anual, $frecuencia, $iva){
        $interes_periodo =0;
        if($frecuencia==1)//Semanal
            $interes_periodo = ($interes_anual/360)*7/100*$iva;
        else if($frecuencia==2)//Quincenal
            $interes_periodo = ($interes_anual/360)*15/100*$iva;
        else if($frecuencia==3)//Mensual
            $interes_periodo = ($interes_anual/12)/100*$iva;

        //Queda pendiente lo de pago único

        return $interes_periodo;
    }

    function calcular_interes_diario($saldo_insoluto, $interes_periodo, $frecuencia, $iva){
        $interes_diario=0;
        if($frecuencia==1)//Semanal
            $interes_diario = ($saldo_insoluto*$interes_periodo/7)/$iva;
        else if($frecuencia==2)//Quincenal
            $interes_diario = ($saldo_insoluto*$interes_periodo/15)/$iva;
        else if($frecuencia==3)//Mensual
            $interes_diario = ($saldo_insoluto*$interes_periodo/30)/$iva;

        //Queda pendiente lo de pago único

        return $interes_diario;
    }

    function calcular_interes_diario_afavor($capital, $interes_periodo, $frecuencia){
        $interes_diario_afavor=0;
        if($frecuencia==1)//Semanal
            $interes_diario_afavor = $capital*$interes_periodo/7;
        else if($frecuencia==2)//Quincenal
            $interes_diario_afavor = $capital*$interes_periodo/15;
        else if($frecuencia==3)//Mensual
            $interes_diario_afavor = $capital*$interes_periodo/30;

        //Queda pendiente lo de pago único

        return $interes_diario_afavor;
    }

    function calcular_pago_monto_cero($saldo_insoluto, $interes_anual, $frecuencia, $iva, $interes_acumulado){
        $interes_periodo = calcular_interes_periodo($interes_anual, $frecuencia, $iva);
        //$interes_diario = calcular_interes_diario($saldo_insoluto, $interes_periodo, $frecuencia, $iva);

        $res["interes"] = $saldo_insoluto * $interes_periodo /$iva;
        $res["iva_monto"] = $res["interes"] * ($iva-1);
        $res["monto"] = $res["interes"] + $res["iva_monto"];
        $res["amortizacion"] = 0;
        $res["interes_acumulado"] = $res["interes"] + $interes_acumulado;
        $res["saldo_insoluto"] = $saldo_insoluto + $res["interes"];
        $res["pago_int_moratorio"] = 0;
        $res["iva_int_moratorio"] = 0;
        $res["saldo_afavor"] =0;
        return $res;
    }

    function calcular_pago_normal($pago, $saldo_insoluto, $interes_anual, $frecuencia, $iva, $interes_acumulado){
        $interes_periodo = calcular_interes_periodo($interes_anual, $frecuencia, $iva);
        $res["interes_periodo"] = $interes_periodo;
        $res["interes"] = $saldo_insoluto * $interes_periodo /$iva;
        $res["iva_monto"] = $res["interes"] * ($iva-1);
        $res["monto"] = $res["interes"] + $res["iva_monto"];
        $iva_interes_acum = $interes_acumulado * ($iva-1);
        $amortizacion = $pago - $res["monto"] - $interes_acumulado - $iva_interes_acum;
        if($amortizacion < 0){
            $res["interes_acumulado"] = ($amortizacion *(-1))-$res["iva_monto"];
            $res["amortizacion"] = 0;
            $pago_intereses = $interes_acumulado + $iva_interes_acum;
            if($pago < $pago_intereses){
                $res["pago_int_moratorio"] = $pago/$iva;
                $res["iva_int_moratorio"] = $pago - $res["pago_int_moratorio"] ;
            }
            else{
                $res["pago_int_moratorio"] = $interes_acumulado;
                $res["iva_int_moratorio"] = $iva_interes_acum;
            }
        }
        else {
            $res["interes_acumulado"] =0;
            $res["amortizacion"] = $amortizacion;
            $res["pago_int_moratorio"] = $interes_acumulado;
            $res["iva_int_moratorio"] = $iva_interes_acum;
        }
        $res["saldo_insoluto"] = $saldo_insoluto - $res["amortizacion"] + $res["interes_acumulado"];
        $res["saldo_afavor"] =0;
        return $res;
    }

    function calcular_pago_dias_mora($pago, $saldo_insoluto, $interes_anual, $frecuencia, $iva, $interes_acumulado, $dias_mora){
        $interes_periodo = calcular_interes_periodo($interes_anual, $frecuencia, $iva);
        $interes_diario = calcular_interes_diario($saldo_insoluto, $interes_periodo, $frecuencia, $iva);
        $res["interes_diario"]=$interes_diario;
        $res["interes"] = $interes_diario * $dias_mora;
        $res["iva_monto"] = $res["interes"] * ($iva-1);
        $res["monto"] = $res["interes"] + $res["iva_monto"];

        $iva_interes_acum = $interes_acumulado * ($iva-1);
        $amortizacion = $pago - $res["monto"] - $interes_acumulado - $iva_interes_acum;
        if($amortizacion < 0){
            $res["interes_acumulado"] = ($amortizacion *(-1))-$res["iva_monto"];
            $res["amortizacion"] = 0;
            $pago_intereses = $interes_acumulado + $iva_interes_acum;
            if($pago < $pago_intereses){
                $res["pago_int_moratorio"] = $pago/$iva;
                $res["iva_int_moratorio"] = $pago - $res["pago_int_moratorio"] ;
            }
            else{
                $res["pago_int_moratorio"] = $interes_acumulado;
                $res["iva_int_moratorio"] = $iva_interes_acum;
            }
        }
        else {
            $res["interes_acumulado"] =0;
            $res["amortizacion"] = $amortizacion;
            $res["pago_int_moratorio"] = $interes_acumulado;
            $res["iva_int_moratorio"] = $iva_interes_acum;
        }
        $res["saldo_insoluto"] = $saldo_insoluto - $res["amortizacion"] + $res["interes_acumulado"];
        $res["saldo_afavor"] =0;
        return $res;
    }

    function calcular_pago_dias_adelanto($pago, $saldo_insoluto, $interes_anual, $frecuencia, $iva, $interes_acumulado, $dias_adelantados, $capital_estatico){
        $res = calcular_pago_normal($pago, $saldo_insoluto, $interes_anual, $frecuencia, $iva, $interes_acumulado);
        //Calculo el saldo a favor y recalculo el saldo insoluto y la amortización
        $res["saldo_afavor"] = calcular_interes_diario_afavor($capital_estatico, $res["interes_periodo"], $frecuencia) * $dias_adelantados;
        $res["amortizacion"] = $res["amortizacion"] + $res["saldo_afavor"];
        $res["saldo_insoluto"] = $res["saldo_insoluto"] - $res["saldo_afavor"];
        
        return $res;
    }

    
    switch($funcion){
      
        case "datatable_creditos_promotor":
            $data = $oconns->getRows("select vc.idkey_credito, vc.nombre, vc.nombre_producto as producto, vc.tipo_credito, vc.folio, vc.monto from  view_creditos vc where estatus=1");
            $response = array();
            if ($oconns->numberRows>0){
                foreach ($data as $item){
                    $idkey_credito = $item["idkey_credito"];

                    //Consultar último pago diferente de 0
                    $ultimo_pago = ultimo_pago_credito($idkey_credito);
                    if($ultimo_pago["n"] > 0){
                        $fecha_ultimo_pago = $ultimo_pago["fecha_ultimo_pago"];
                    }
                    else{
                        $fecha_ultimo_pago = "Ninguno";
                    }

                    //Consultar último pago para sacar el saldo insoluto
                    $ultimo_pago1 = ultimo_pago_credito1($idkey_credito);
                    if($ultimo_pago1["n"] > 0){
                        $saldo_insoluto = strval(number_format($ultimo_pago1["saldo_insoluto"],2));
                        $ultimo_pago_dinamica = $ultimo_pago1["no_ultimo_pago"];
                    }
                    else{
                        $ultimo_pago_dinamica = 0;
                        $saldo_insoluto = strval(number_format($item["monto"],2));//Monto total
                    }

                    //Consultar siguiente pago en amort estática
                    $sig_pago = consulta_pago_credito($idkey_credito, intval($ultimo_pago_dinamica)+1);
                    if($sig_pago["n"] > 0){
                        $fecha_pago_temp = $sig_pago["fecha_pago"];
                        //$temp = explode("-",$fecha_pago_temp);
                        //$fecha_pago = $temp[2]."-".$temp[1]."-".$temp[0];
                        $fecha_pago  = $fecha_pago_temp;
                        $cantidad_pagar =  strval(number_format($sig_pago["cantidad_pagar"],2));
                    }
                    else{
                        $fecha_pago = "Crédito vencido";
                        $cantidad_pagar =  "Crédito vencido";
                    }

                    

                    //Para calcular días transcurridos
                    $dias_transcurridos = $oconns->getSimple("select DATEDIFF('".$fecha_pago_temp."', NOW()) as dias_transcurridos;");

                    $nombre = '<span class="text-105 text-600"><a href="creditos_detalle_amortizacion.php?idkey_credito='.$item["idkey_credito"].'&tipo='.$item["tipo_credito"].'" class="text-dark-tp3">'.$item["nombre"].'</a></span>';
                    $cantidad_pagar =  '<a href="#" class="text-grey text-600" data-toggle="modal" data-target="#cantidad-pagar" onclick="datatable_cantidad_pagar('.$item["idkey_credito"].', \''.$item["nombre"].'\', '.(intval($ultimo_pago_dinamica)+1).')">$ '.$cantidad_pagar.'</a>';
                     $saldo_insoluto =  '<a href="#" class="text-grey text-600" data-toggle="modal" data-target="#saldo-insoluto" onclick="datatable_amort_dinamica('.$item["idkey_credito"].', \''.$item["nombre"].'\')">$ '.$saldo_insoluto.'</a>';

                    //Se consulta si necesita ser atendido
                    $alerta_revision ="";
                    $fv = $oconns->getRows("select fecha_valor from amortizaciones_dinamicas where idkey_creditos = '".$idkey_credito."' order by idkey desc limit 1");
                    if($oconns->numberRows>0){
                        $fr = $oconns->getSimple("select count(*) from amortizaciones where idkey_creditos = '".$idkey_credito."' and fecha_pago > '".$fv[0]["fecha_valor"]."' and fecha_pago <= NOW() ");
                        if($fr>0)
                            $alerta_revision ='<a href="#"><i class="fas fa-exclamation-triangle text-warning-m2 text-600 brc-warning-m3 " title="Alerta: existen pagos atrasados!"></i></a>';
                    }
                    else{
                        $fr = $oconns->getSimple("select count(*) from amortizaciones where idkey_creditos = '".$idkey_credito."' and fecha_pago <= NOW() ");
                        if($fr>0)
                            $alerta_revision ='<a href="#"><i class="fas fa-exclamation-triangle text-warning-m2 text-600 brc-warning-m3 " title="Alerta: existen pagos atrasados!"></i></a>';
                    }
                         
                    if($dias_transcurridos > 0)
                        $estatus = "<span class='badge badge-sm bgc-success-l2 text-success-d2 border-1 brc-success-m3'>En tiempo</span>";
                    else if($dias_transcurridos == 0)
                        $estatus = "<pre>".$alerta_revision." <span class='badge badge-sm bgc-warning-l2 text-warning-d2 border-1 brc-warning-m3'>Día de pago</span></pre>";
                    else
                        $estatus = "<pre>".$alerta_revision." <span class='badge badge-sm bgc-danger-l2 text-danger-d2 border-1 brc-danger-m3'>Atrasado</span></pre>";

                    //$temp = explode("-",$fecha_pago);
                    //$fecha_pago = $temp[2]."-".$temp[1]."-".$temp[0];
                    $jsonArrayObject = (array(
                        'folio' => $item["folio"],
                        'fecha_ultimo_pago' => $fecha_ultimo_pago,
                        'fecha_pago' => $fecha_pago, 
                        'nombre' => $nombre, 
                        'producto' => $item["producto"], 
                        'cantidad_pagar' => $cantidad_pagar, 
                        'saldo_insoluto' => $saldo_insoluto,
                        'estatus' => $estatus,
                        'dias_transcurridos' => $dias_transcurridos
                    ));
                    $response[] = $jsonArrayObject;
                }
            }
            echo json_encode($response);
        break;

        case "datatable_creditos_supervisor":
            $data = $oconns->getRows("select vc.folio, vc.idkey_credito, vc.nombre_producto, DATE_FORMAT(vc.fecha_creacion,'%Y-%m-%d') as fecha_creacion, vc.nombre, vc.monto, vc.desc_estatus, vc.estatus, u.usuario_nombre, vc.tipo_credito, vc.idkey_clientes, vc.estatus_pagos from view_creditos vc inner join usuarios u on (vc.idkey_usuario=u.idkey)");
            $response = array();
            if ($oconns->numberRows>0){
                foreach ($data as $item){ 
                  //Para los colores de status
                  $estatus = $item["estatus"];
                  if($estatus == 1)
                    $color = 'success';
                  else if($estatus == 2)
                    $color = 'primary';
                  else if($estatus == 3)
                    $color = 'danger';
                  else 
                    $color = 'warning';
                  $estatus = "<span class='badge badge-sm bgc-".$color."-l2 text-".$color."-d2 border-1 brc-".$color.
                    "-m3'>".$item["desc_estatus"]."</span>";

                   $nombre = '<span class="text-105 text-600"><a href="creditos_detalle_factores.php?idkey_credito='.$item["idkey_credito"].'&tipo='.$item["tipo_credito"].'&idkey_cliente='.$item["idkey_clientes"].'" class="text-dark-tp3">'.$item["nombre"].'</a></span>';


                   //Para calcular días transcurridos solo para créditos autorizados
                   //Para determinar acciones: Reestructuración
                   $dias_transcurridos = "";
                   $alerta = "";
                   $opciones ="";
                   if($item["estatus"]==1){
                        $ultimo_pago1 = ultimo_pago_credito1($item["idkey_credito"]);
                        if($ultimo_pago1["n"] > 0){
                            $ultimo_pago_dinamica = $ultimo_pago1["no_ultimo_pago"];
                            $saldo_insoluto = $ultimo_pago1["saldo_insoluto"];
                            //Opción para Reestructuración y Renovación solo si no debe intereses acumulados
                            $interes_acumulado = floatval($ultimo_pago1["interes_acumulado"]);
                            if($interes_acumulado == 0){
                                $opciones.= '<a href="#" data-toggle="modal" data-target="#modalCambios" class="btn radius-1 btn-sm btn-brc-tp btn-outline-default btn-h-outline-primary btn-a-outline-primary btn-text-primary" title="Reestructuración" onclick="cargar_formReestructuracion(\''.$item["idkey_credito"].'\',\''.number_format($saldo_insoluto,2).'\')"><i class="fas fa-eraser"></i></a>';

                                $opciones.= '<a href="#" data-toggle="modal" data-target="#modalCambios" class="btn radius-1 btn-sm btn-brc-tp btn-outline-success btn-h-outline-success btn-a-outline-success btn-text-success" title="Renovación" onclick="cargar_formRenovacion(\''.$item["idkey_credito"].'\',\''.number_format($saldo_insoluto,2).'\')"><i class="fas fa-clock"></i></a>';
                            }
                        }
                        else{
                            $ultimo_pago_dinamica = 0;
                            $saldo_insoluto = $item["monto"];
                        }
                        $sig_pago = consulta_pago_credito($item["idkey_credito"], intval($ultimo_pago_dinamica)+1);
                        if($sig_pago["n"]>0) $fecha_pago_temp = $sig_pago["fecha_pago"];
                        else $fecha_pago_temp = 0;
                        $dias_transcurridos = $oconns->getSimple("select DATEDIFF('".$fecha_pago_temp."', NOW()) as dias_transcurridos;");

                        //Para las opciones de Renovación: Que no esté en cartera vencida ni tenga adeudo de intereses
                        //if(($dias_transcurridos<21 || $dias_transcurridos=="") && )

                        //////////////////////////////////////////////////////////////////////////////////////////////

                        if($dias_transcurridos >= 0 || $dias_transcurridos == ""){
                            $dias_transcurridos = "";
                        }
                        else{
                            $dias_transcurridos = $dias_transcurridos * -1;
                            //Clasificación
                            if($dias_transcurridos > 21 && $dias_transcurridos < 90){
                                $alerta = "<span class='badge badge-sm bgc-warning-l2 text-warning-d2 border-1 brc-warning-m3'>Cartera vencida</span>";
                                $opciones = ''; //Se quitan las opciones
                            }
                            else if($dias_transcurridos >= 90){
                                $alerta = "<span class='badge badge-sm bgc-danger-l2 text-danger-d2 border-1 brc-danger-m3'>Cartera castigada</span>";
                                $opciones = ''; //Se quitan las opciones
                                //Aquí se da la opción de Condonar intereses si es que el estatus no se encuentra en esa categoría
                                if($item["estatus_pagos"] != 2)
                                    $opciones.= '<a href="#" data-toggle="modal" data-target="#modalCambios" class="btn radius-1 btn-sm btn-brc-tp btn-outline-warning btn-h-outline-warning btn-a-outline-warning btn-text-warning" title="Condonación de intereses" onclick="cargar_formCondonacion(\''.$item["idkey_credito"].'\',\''.number_format($saldo_insoluto,2).'\')"><i class="fas fa-magic"></i></a>';
                            }
                        }

                   }
                   //Para el estatus_pagos
                   if($item["estatus_pagos"] == "")
                        $estatus_pagos = "";
                    else{
                        $ep = $oconns->getRows("select nombre from creditos_estatus_pagos where idkey='".$item["estatus_pagos"]."'");
                        $estatus_pagos = "<span class='badge badge-sm bgc-danger-l2 text-danger-d2 border-1 brc-danger-m3'>".$ep[0]["nombre"]."</span>";
                    }
                    $jsonArrayObject = (array(
                        'folio' => $item["folio"], 
                        'producto' => $item["nombre_producto"], 
                        'fecha_creacion' => "<pre>".$item["fecha_creacion"]."</pre>", 
                        'promotor' => $item["usuario_nombre"], 
                        'cliente' => $nombre,
                        'monto' => "$".strval(number_format($item["monto"],2)),
                        'estatus' => $estatus,
                        'estatus_pagos' => $estatus_pagos."&nbsp;".$alerta,
                        'dias_transcurridos' => "<div class='text-danger'><b>".$dias_transcurridos."</b></div>",
                        'opciones' => "<pre>".$opciones."</pre>"
                    ));
                    $response[] = $jsonArrayObject;
                }
            }
            echo json_encode($response);
        break;

        case "datatable_creditos_condonacion":
            $data = $oconns->getRows("select vc.folio, vc.idkey_credito, vc.nombre_producto, DATE_FORMAT(vc.fecha_creacion,'%Y-%m-%d') as fecha_creacion, vc.nombre, vc.monto, vc.desc_estatus, vc.estatus, u.usuario_nombre, vc.tipo_credito, vc.idkey_clientes, vc.estatus_pagos from view_creditos vc inner join usuarios u on (vc.idkey_usuario=u.idkey)");
            $response = array();
            if ($oconns->numberRows>0){
                foreach ($data as $item){ 
                  //Para los colores de status
                  $estatus = $item["estatus"];
                  if($estatus == 1)
                    $color = 'success';
                  else if($estatus == 2)
                    $color = 'primary';
                  else if($estatus == 3)
                    $color = 'danger';
                  else 
                    $color = 'warning';
                  $estatus = "<span class='badge badge-sm bgc-".$color."-l2 text-".$color."-d2 border-1 brc-".$color.
                    "-m3'>".$item["desc_estatus"]."</span>";

                   $nombre = '<span class="text-105 text-600">'.$item["nombre"].'</span>';


                   //Para calcular días transcurridos solo para créditos autorizados
                   //Para determinar acciones: Reestructuración
                   $dias_transcurridos = "";
                   $alerta = "";
                   $opciones ="";
                   if($item["estatus"]==1){
                        $ultimo_pago1 = ultimo_pago_credito1($item["idkey_credito"]);
                        if($ultimo_pago1["n"] > 0){
                            $ultimo_pago_dinamica = $ultimo_pago1["no_ultimo_pago"];
                        }
                        else{
                            $ultimo_pago_dinamica = 0;
                            $saldo_insoluto = $item["monto"];
                        }
                        $sig_pago = consulta_pago_credito($item["idkey_credito"], intval($ultimo_pago_dinamica)+1);
                        if($sig_pago["n"]>0) $fecha_pago_temp = $sig_pago["fecha_pago"];
                        else $fecha_pago_temp = 0;
                        $dias_transcurridos = $oconns->getSimple("select DATEDIFF('".$fecha_pago_temp."', NOW()) as dias_transcurridos;");

                        //Para las opciones de Renovación: Que no esté en cartera vencida ni tenga adeudo de intereses
                        //if(($dias_transcurridos<21 || $dias_transcurridos=="") && )

                        //////////////////////////////////////////////////////////////////////////////////////////////

                        if($dias_transcurridos >= 0 || $dias_transcurridos == ""){
                            $dias_transcurridos = "";
                        }
                        else{
                            $dias_transcurridos = $dias_transcurridos * -1;
                            //Clasificación
                            if($dias_transcurridos >= 90){
                                $alerta = "<span class='badge badge-sm bgc-danger-l2 text-danger-d2 border-1 brc-danger-m3'>Cartera castigada</span>";
                                $opciones = ''; //Se quitan las opciones
                                //Aquí se da la opción de Condonar intereses si es que el estatus no se encuentra en esa categoría
                                if($item["estatus_pagos"] != 2){
                                    $opciones.= '<a href="#" data-toggle="modal" data-target="#modalCambios" class="btn radius-1 btn-sm btn-brc-tp btn-outline-warning btn-h-outline-warning btn-a-outline-warning btn-text-warning" title="Condonación de intereses" onclick="cargar_formCondonacion(\''.$item["idkey_credito"].'\',\''.number_format($saldo_insoluto,2).'\')"><i class="fas fa-magic"></i></a>';
                                    //Para el estatus_pagos
                                   if($item["estatus_pagos"] == "")
                                        $estatus_pagos = "";
                                    else{
                                        $ep = $oconns->getRows("select nombre from creditos_estatus_pagos where idkey='".$item["estatus_pagos"]."'");
                                        $estatus_pagos = "<span class='badge badge-sm bgc-danger-l2 text-danger-d2 border-1 brc-danger-m3'>".$ep[0]["nombre"]."</span>";
                                    }

                                    $jsonArrayObject = (array(
                                        'folio' => $item["folio"], 
                                        'producto' => $item["nombre_producto"], 
                                        'fecha_creacion' => "<pre>".$item["fecha_creacion"]."</pre>", 
                                        'promotor' => $item["usuario_nombre"], 
                                        'cliente' => $nombre,
                                        'monto' => "$".strval(number_format($item["monto"],2)),
                                        'estatus' => $estatus,
                                        'estatus_pagos' => $estatus_pagos."&nbsp;".$alerta,
                                        'dias_transcurridos' => "<div class='text-danger'><b>".$dias_transcurridos."</b></div>",
                                        'opciones' => "<pre>".$opciones."</pre>"
                                    ));
                                    $response[] = $jsonArrayObject;
                                }
                            }
                        }

                   }
                   
                }
            }
            echo json_encode($response);
        break;

        case "datatable_creditos_reestructuracion":
            $data = $oconns->getRows("select vc.folio, vc.idkey_credito, vc.nombre_producto, DATE_FORMAT(vc.fecha_creacion,'%Y-%m-%d') as fecha_creacion, vc.nombre, vc.monto, vc.desc_estatus, vc.estatus, u.usuario_nombre, vc.tipo_credito, vc.idkey_clientes, vc.estatus_pagos from view_creditos vc inner join usuarios u on (vc.idkey_usuario=u.idkey)");
            $response = array();
            if ($oconns->numberRows>0){
                foreach ($data as $item){ 
                  //Para los colores de status
                  $estatus = $item["estatus"];
                  if($estatus == 1)
                    $color = 'success';
                  else if($estatus == 2)
                    $color = 'primary';
                  else if($estatus == 3)
                    $color = 'danger';
                  else 
                    $color = 'warning';
                  $estatus = "<span class='badge badge-sm bgc-".$color."-l2 text-".$color."-d2 border-1 brc-".$color.
                    "-m3'>".$item["desc_estatus"]."</span>";

                   $nombre = '<span class="text-105 text-600">'.$item["nombre"].'</span>';


                   //Para calcular días transcurridos solo para créditos autorizados
                   //Para determinar acciones: Reestructuración
                   $dias_transcurridos = "";
                   $alerta = "";
                   $opciones ="";
                   if($item["estatus"]==1){
                        $ultimo_pago1 = ultimo_pago_credito1($item["idkey_credito"]);
                        if($ultimo_pago1["n"] > 0){
                            $ultimo_pago_dinamica = $ultimo_pago1["no_ultimo_pago"];
                            $saldo_insoluto = $ultimo_pago1["saldo_insoluto"];
                            //Opción para Reestructuración y Renovación solo si no debe intereses acumulados
                            $interes_acumulado = floatval($ultimo_pago1["interes_acumulado"]);
                            if($interes_acumulado == 0){
                                $opciones.= '<a href="#" data-toggle="modal" data-target="#modalCambios" class="btn radius-1 btn-sm btn-brc-tp btn-outline-default btn-h-outline-primary btn-a-outline-primary btn-text-primary" title="Reestructuración" onclick="cargar_formReestructuracion(\''.$item["idkey_credito"].'\',\''.number_format($saldo_insoluto,2).'\')"><i class="fas fa-eraser"></i></a>';

                                $sig_pago = consulta_pago_credito($item["idkey_credito"], intval($ultimo_pago_dinamica)+1);
                                if($sig_pago["n"]>0) $fecha_pago_temp = $sig_pago["fecha_pago"];
                                else $fecha_pago_temp = 0;
                                $dias_transcurridos = $oconns->getSimple("select DATEDIFF('".$fecha_pago_temp."', NOW()) as dias_transcurridos;");

                                if($item["estatus_pagos"] == "")
                                    $estatus_pagos = "";
                                else{
                                    $ep = $oconns->getRows("select nombre from creditos_estatus_pagos where idkey='".$item["estatus_pagos"]."'");
                                    $estatus_pagos = "<span class='badge badge-sm bgc-danger-l2 text-danger-d2 border-1 brc-danger-m3'>".$ep[0]["nombre"]."</span>";
                                }

                                if($dias_transcurridos >= 0 || $dias_transcurridos == "")
                                    $dias_transcurridos = "";
                                else
                                    $dias_transcurridos = $dias_transcurridos * -1;
                                $jsonArrayObject = (array(
                                    'folio' => $item["folio"], 
                                    'producto' => $item["nombre_producto"], 
                                    'fecha_creacion' => "<pre>".$item["fecha_creacion"]."</pre>", 
                                    'promotor' => $item["usuario_nombre"], 
                                    'cliente' => $nombre,
                                    'monto' => "$".strval(number_format($item["monto"],2)),
                                    'estatus' => $estatus,
                                    'estatus_pagos' => $estatus_pagos."&nbsp;".$alerta,
                                    'dias_transcurridos' => "<div class='text-danger'><b>".$dias_transcurridos."</b></div>",
                                    'opciones' => "<pre>".$opciones."</pre>"
                                ));
                                $response[] = $jsonArrayObject;
                            }
                        }
                        else{
                            $ultimo_pago_dinamica = 0;
                            $saldo_insoluto = $item["monto"];
                        }
                        
            

                   }
                   
                }
            }
            echo json_encode($response);
        break;

        case "datatable_creditos_renovacion":
            $data = $oconns->getRows("select vc.folio, vc.idkey_credito, vc.nombre_producto, DATE_FORMAT(vc.fecha_creacion,'%Y-%m-%d') as fecha_creacion, vc.nombre, vc.monto, vc.desc_estatus, vc.estatus, u.usuario_nombre, vc.tipo_credito, vc.idkey_clientes, vc.estatus_pagos from view_creditos vc inner join usuarios u on (vc.idkey_usuario=u.idkey)");
            $response = array();
            if ($oconns->numberRows>0){
                foreach ($data as $item){ 
                  //Para los colores de status
                  $estatus = $item["estatus"];
                  if($estatus == 1)
                    $color = 'success';
                  else if($estatus == 2)
                    $color = 'primary';
                  else if($estatus == 3)
                    $color = 'danger';
                  else 
                    $color = 'warning';
                  $estatus = "<span class='badge badge-sm bgc-".$color."-l2 text-".$color."-d2 border-1 brc-".$color.
                    "-m3'>".$item["desc_estatus"]."</span>";

                   $nombre = '<span class="text-105 text-600">'.$item["nombre"].'</span>';


                   //Para calcular días transcurridos solo para créditos autorizados
                   //Para determinar acciones: Reestructuración
                   $dias_transcurridos = "";
                   $alerta = "";
                   $opciones ="";
                   if($item["estatus"]==1){
                        $ultimo_pago1 = ultimo_pago_credito1($item["idkey_credito"]);
                        if($ultimo_pago1["n"] > 0){
                            $ultimo_pago_dinamica = $ultimo_pago1["no_ultimo_pago"];
                            $saldo_insoluto = $ultimo_pago1["saldo_insoluto"];
                            //Opción para Reestructuración y Renovación solo si no debe intereses acumulados
                            $interes_acumulado = floatval($ultimo_pago1["interes_acumulado"]);
                            if($interes_acumulado == 0){
                                $opciones.= '<a href="#" data-toggle="modal" data-target="#modalCambios" class="btn radius-1 btn-sm btn-brc-tp btn-outline-success btn-h-outline-success btn-a-outline-success btn-text-success" title="Renovación" onclick="cargar_formRenovacion(\''.$item["idkey_credito"].'\',\''.number_format($saldo_insoluto,2).'\')"><i class="fas fa-clock"></i></a>';

                                $sig_pago = consulta_pago_credito($item["idkey_credito"], intval($ultimo_pago_dinamica)+1);
                                if($sig_pago["n"]>0) $fecha_pago_temp = $sig_pago["fecha_pago"];
                                else $fecha_pago_temp = 0;
                                $dias_transcurridos = $oconns->getSimple("select DATEDIFF('".$fecha_pago_temp."', NOW()) as dias_transcurridos;");

                                if($item["estatus_pagos"] == "")
                                    $estatus_pagos = "";
                                else{
                                    $ep = $oconns->getRows("select nombre from creditos_estatus_pagos where idkey='".$item["estatus_pagos"]."'");
                                    $estatus_pagos = "<span class='badge badge-sm bgc-danger-l2 text-danger-d2 border-1 brc-danger-m3'>".$ep[0]["nombre"]."</span>";
                                }

                                if($dias_transcurridos >= 0 || $dias_transcurridos == "")
                                    $dias_transcurridos = "";
                                else
                                    $dias_transcurridos = $dias_transcurridos * -1;
                                $jsonArrayObject = (array(
                                    'folio' => $item["folio"], 
                                    'producto' => $item["nombre_producto"], 
                                    'fecha_creacion' => "<pre>".$item["fecha_creacion"]."</pre>", 
                                    'promotor' => $item["usuario_nombre"], 
                                    'cliente' => $nombre,
                                    'monto' => "$".strval(number_format($item["monto"],2)),
                                    'estatus' => $estatus,
                                    'estatus_pagos' => $estatus_pagos."&nbsp;".$alerta,
                                    'dias_transcurridos' => "<div class='text-danger'><b>".$dias_transcurridos."</b></div>",
                                    'opciones' => "<pre>".$opciones."</pre>"
                                ));
                                $response[] = $jsonArrayObject;
                            }
                        }
                        else{
                            $ultimo_pago_dinamica = 0;
                            $saldo_insoluto = $item["monto"];
                        }
                        
            

                   }
                   
                }
            }
            echo json_encode($response);
        break;

        case "datatable_creditos_castigo":
            $data = $oconns->getRows("select vc.folio, vc.idkey_credito, vc.nombre_producto, DATE_FORMAT(vc.fecha_creacion,'%Y-%m-%d') as fecha_creacion, vc.nombre, vc.monto, vc.desc_estatus, vc.estatus, u.usuario_nombre, vc.tipo_credito, vc.idkey_clientes, vc.estatus_pagos from view_creditos vc inner join usuarios u on (vc.idkey_usuario=u.idkey)");
            $response = array();
            if ($oconns->numberRows>0){
                foreach ($data as $item){ 
                  //Para los colores de status
                  $estatus = $item["estatus"];
                  if($estatus == 1)
                    $color = 'success';
                  else if($estatus == 2)
                    $color = 'primary';
                  else if($estatus == 3)
                    $color = 'danger';
                  else 
                    $color = 'warning';
                  $estatus = "<span class='badge badge-sm bgc-".$color."-l2 text-".$color."-d2 border-1 brc-".$color.
                    "-m3'>".$item["desc_estatus"]."</span>";

                   $nombre = '<span class="text-105 text-600">'.$item["nombre"].'</span>';


                   //Para calcular días transcurridos solo para créditos autorizados
                   //Para determinar acciones: Reestructuración
                   $dias_transcurridos = "";
                   $alerta = "";
                   $opciones ="";
                   if($item["estatus"]==1){
                        $ultimo_pago1 = ultimo_pago_credito1($item["idkey_credito"]);
                        if($ultimo_pago1["n"] > 0){
                            $ultimo_pago_dinamica = $ultimo_pago1["no_ultimo_pago"];
                        }
                        else{
                            $ultimo_pago_dinamica = 0;
                            $saldo_insoluto = $item["monto"];
                        }
                        $sig_pago = consulta_pago_credito($item["idkey_credito"], intval($ultimo_pago_dinamica)+1);
                        if($sig_pago["n"]>0) $fecha_pago_temp = $sig_pago["fecha_pago"];
                        else $fecha_pago_temp = 0;
                        $dias_transcurridos = $oconns->getSimple("select DATEDIFF('".$fecha_pago_temp."', NOW()) as dias_transcurridos;");

                        //Para las opciones de Renovación: Que no esté en cartera vencida ni tenga adeudo de intereses
                        //if(($dias_transcurridos<21 || $dias_transcurridos=="") && )

                        //////////////////////////////////////////////////////////////////////////////////////////////

                        if($dias_transcurridos >= 0 || $dias_transcurridos == ""){
                            $dias_transcurridos = "";
                        }
                        else{
                            $dias_transcurridos = $dias_transcurridos * -1;
                            //Clasificación
                            if($dias_transcurridos >= 90){
                                $alerta = "<span class='badge badge-sm bgc-danger-l2 text-danger-d2 border-1 brc-danger-m3'>Cartera castigada</span>";
                                $opciones = ''; //Se quitan las opciones
                                //Aquí se da la opción de Condonar intereses si es que el estatus no se encuentra en esa categoría
                                if($item["estatus_pagos"] != 2){
                                    $opciones.= '<a href="#" class="btn radius-1 btn-sm btn-brc-tp btn-outline-warning btn-h-outline-warning btn-a-outline-warning btn-text-warning" title="Cartera castigada" onclick="confirmar_cartera_castigada(\''.$item["idkey_credito"].'\')"><i class="fas fa-magic"></i></a>';
                                    //Para el estatus_pagos
                                   if($item["estatus_pagos"] == "")
                                        $estatus_pagos = "";
                                    else{
                                        $ep = $oconns->getRows("select nombre from creditos_estatus_pagos where idkey='".$item["estatus_pagos"]."'");
                                        $estatus_pagos = "<span class='badge badge-sm bgc-danger-l2 text-danger-d2 border-1 brc-danger-m3'>".$ep[0]["nombre"]."</span>";
                                    }

                                    $jsonArrayObject = (array(
                                        'folio' => $item["folio"], 
                                        'producto' => $item["nombre_producto"], 
                                        'fecha_creacion' => "<pre>".$item["fecha_creacion"]."</pre>", 
                                        'promotor' => $item["usuario_nombre"], 
                                        'cliente' => $nombre,
                                        'monto' => "$".strval(number_format($item["monto"],2)),
                                        'estatus' => $estatus,
                                        'estatus_pagos' => $estatus_pagos."&nbsp;".$alerta,
                                        'dias_transcurridos' => "<div class='text-danger'><b>".$dias_transcurridos."</b></div>",
                                        'opciones' => "<pre>".$opciones."</pre>"
                                    ));
                                    $response[] = $jsonArrayObject;
                                }
                            }
                        }

                   }
                   
                }
            }
            echo json_encode($response);
        break;


        case "datatable_amort_dinamica":
            $idkey_credito =$_POST["idkey_credito"];
            $data = $oconns->getRows("select *, DATE_FORMAT(fecha_valor,'%d/%m/%Y') as fecha_valor from amortizaciones_dinamicas where idkey_creditos='".$idkey_credito."' order by fecha_valor asc;");
            $response = array();
            if ($oconns->numberRows>0){

                foreach ($data as $item){ 
                    if($item["pago"] != "0")
                        $acciones = "<a class='btn radius-1 btn-sm btn-brc-tp btn-outline-default btn-h-outline-primary btn-a-outline-primary btn-text-primary' title='Imprimir ticket' href='../pdf/ticket_pago.php?idkey_pago=".$item["idkey"]."' target='_blank'><i class='fa fa-print'></i></a>";
                    else
                        $acciones = "";
                    $jsonArrayObject = (array(
                        'no_pago' => $item["no_pago"],
                        'fecha_valor' => $item["fecha_valor"],
                        'cantidad_pago' => $item["pago"], 
                        'interes' => "$".strval(number_format($item["interes"],2)),
                        'iva' => "$".strval(number_format($item["iva"],2)),
                        'monto' => "$".strval(number_format($item["monto"],2)),
                        'interes_acumulado' => "$".strval(number_format($item["interes_acumulado"],2)),
                        'pago_interes_moratorio' => "$".strval(number_format($item["pago_interes_moratorio"],2)),
                        'iva_interes_moratorio' => "$".strval(number_format($item["iva_interes_moratorio"],2)),
                        'amortizacion' => "$".strval(number_format($item["amortizacion"],2)),
                        'saldo_insoluto' => "$".strval(number_format($item["saldo_insoluto"],2)),
                        'dias' => $item["dias_transcurridos"],
                        'acciones' => $acciones
                        
                    ));
                    $response[] = $jsonArrayObject;
                }
            }
            echo json_encode($response);
        break;

        case "actualizar_factores":
            $idkey_cliente=$_POST["idkey_cliente"]; 
            $factores=$_POST["factores"]; 
            $response["error"] =0;
            $oconns->ShotSimple("update clientes_factores cf set cf.historial_interno = '".$factores[0]."', cf.vivienda ='".$factores[1]."', cf.arraigo_dom='".$factores[2]."', cf.arraigo_lab='".$factores[3]."', cf.ocupacion='".$factores[4]."', cf.edad='".$factores[5]."',cf.hipotecaria='".$factores[6]."', cf.bienes='".$factores[7]."', cf.mobiliaria='".$factores[8]."', cf.aval_historial='".$factores[9]."', cf.aval_capacidad='".$factores[10]."', cf.aval_solvencia='".$factores[11]."',  cf.buro = '".$factores[12]."', cf.exp_cred = '".$factores[13]."', cf.cap_pago = '".$factores[14]."', cf.ingresos = '".$factores[15]."',   cf.referencias='".$factores[16]."', cf.actividad='".$factores[17]."',  cf.veracidad='".$factores[18]."',   cf.gliquida='".$factores[19]."',  cf.solvencia='".$factores[20]."' where cf.idkey_clientes='$idkey_cliente'");
            echo json_encode($response);
           
        break;

        case "actualizar_estatus_credito":
            $idkey_credito=$_POST["idkey_credito"];
            $idkey_clientes=$_POST["idkey_clientes"];
            $tipo_credito=$_POST["tipo_credito"]; 
            $idkey_estatus=$_POST["idkey_estatus"]; 
            $observaciones=$_POST["observaciones"];
            $monto=floatval($_POST["monto_credito"]);
            $temp = explode("/", $_POST["fecha_desembolso"]);
            $fecha_desembolso= $temp[2]."-".$temp[1]."-".$temp[0];
            $idkey_tipo_desembolso=$_POST["tipo_desembolso"];
            $temp1 = explode("/", $_POST["fecha_pago"]);
            $fecha_pago1= $temp1[2]."-".$temp1[1]."-".$temp1[0];
            $plazo=$_POST["plazo_meses"];
            $prodeco=$_POST["prodeco"];
            $fondeadora=$_POST["fondeadora"];
            $gliquida=$_POST["gliquida"];

            $response["fecha_pago"]=$fecha_pago1;

            if($idkey_estatus==1)//Autorizado
                $fecha_entrega = date('Y-m-d');
            else 
                $fecha_entrega = '';
            $response["error"] =0;
            $response["fecha_entrega"] =$fecha_entrega;

            
            $oconns->ShotSimple("update creditos set estatus='".$idkey_estatus."', fecha_entrega='".$fecha_entrega."', observaciones='".$observaciones."', monto='$monto', fecha_desembolso='$fecha_desembolso', idkey_tipo_desembolso='$idkey_tipo_desembolso', primer_pago='$fecha_pago1', plazo='$plazo', porcentaje_prodeco='$prodeco', porcentaje_fondeadora='$fondeadora', gliquida='$gliquida' where idkey='".$idkey_credito."'");

            //Bitácora
            $data = $oconns->getRows("select nombre from creditos_estatus where idkey=$idkey_estatus");
            $oconns->ShotSimple("insert into bitacora_creditos(idkey_credito, idkey_usuario, descripcion) values ($idkey_credito, $idkey_usuario, 'Actualización de los datos del crédito. Cambio de estatus a ".$data[0]["nombre"]."')");

            //Si el status cambia a autorizado, se guarda la tabla de amortización 
            if($idkey_estatus==1){
                $data = $oconns->getRows("select tasa_interes, idkey_frecuencia, iva from creditos where idkey='$idkey_credito'");
                $tasa_interes = $data[0]["tasa_interes"];
                $idkey_frecuencia = $data[0]["idkey_frecuencia"];
                $iva = $data[0]["iva"];
                $tabla = gererar_tabla_amortizacion($tasa_interes, $plazo, $monto, $idkey_frecuencia, $iva, $fecha_pago1);
                $oconns->ShotSimple("delete from amortizaciones where idkey_creditos='$idkey_credito'");
                foreach ($tabla as $value) {
                    $temp = explode("-", $value['fecha_pago']);
                    $fecha_pago= $temp[2]."-".$temp[1]."-".$temp[0];
                    $temp1 = explode("-", $value['fecha_temp']);
                    $fecha_temp= $temp1[2]."-".$temp1[1]."-".$temp1[0];

                    $oconns->ShotSimple("insert into amortizaciones(pago, descripcion, fecha_pago, fecha_temp, intereses, iva, renta, total, saldo_insoluto, idkey_creditos) values ('".$value['no_pago']."', '".$value['no_pago']." de ".$value['npagos']."', '$fecha_pago', '$fecha_temp', '".$value['interes']."', '".$value['iva']."', '".$value['capital']."', '".$value['total']."', '".$value['nuevo_saldo']."', '$idkey_credito')");
                }
                $npagos = count($tabla);
                $oconns->ShotSimple("update creditos set numero_pagos='$npagos' where idkey='".$idkey_credito."'");
                /**
                //Si el tipo de desembolso es efectivo o caja se guarda en caja en tránsito
                if($idkey_tipo_desembolso==1)//Pendiente para revisar el cajero
                    $oconns->ShotSimple("insert into caja_transito(idkey_credito, idkey_estatus) values('$idkey_credito', 1)");**/
            }

            if($tipo_credito==2){//Si es grupal actualizo los montos
                $montos_clientes=$_POST["montos_socios"];
                foreach ($montos_clientes as $value) {
                    $monto_cliente = floatval($value["value"]);
                    $idkey_cli= $value["name"];
                    $por =($monto_cliente/$monto)*100;
                    $porcentaje_cliente = number_format($por, 2, '.', '');
                    if($idkey_estatus==1)
                        $tabla_ind = json_encode(gererar_tabla_amortizacion($tasa_interes, $plazo, $monto_cliente, $idkey_frecuencia, $iva, $fecha_pago1));
                    else $tabla_ind ="";
                    $oconns->ShotSimple("update grupos_clientes set porcentaje ='$porcentaje_cliente', monto='$monto_cliente', tabla_amortizacion='$tabla_ind' where idkey_grupo='$idkey_clientes' and idkey_clientes='$idkey_cli';");
                }
            }
            echo json_encode($response);
        break;


        case "datatable_cantidad_pagar":
            $idkey_credito =$_POST["idkey_credito"];
            $no_pago_actual =$_POST["no_pago_actual"];

            //Verifico que el estatus del crédito sea autorizado
            $estatus = $oconns->getSimple("select estatus from creditos where idkey=".$idkey_credito);
            if($estatus == 5){
                $response["estado_credito"] = 1;//El crédito está está finalizado
                echo json_encode($response);
                exit;
            }
            else if($estatus != 1){
                $response["estado_credito"] = 2;//El crédito no está autorizado
                echo json_encode($response);
                exit;
            }

            ///Consulto el pago actual de la tabla de amortización éstática
            $estatica = $oconns->getRows("select *, DATE_FORMAT(fecha_pago,'%d/%m/%Y') as fecha_pago from amortizaciones where idkey_creditos='".$idkey_credito."' and pago=".$no_pago_actual);
            $m = $oconns->numberRows;

            $tabla1 = "";
            $fecha_pago_siguiente="";
            if($m>0){
                $estado_credito = 3; //El crédito está correcto
                $fecha_pago_siguiente = $estatica[0]["fecha_pago"];
                $tabla1.= "<tr><td>".$estatica[0]["fecha_pago"]."</td><td>".$estatica[0]["pago"]."</td><td>$".strval(number_format($estatica[0]["intereses"],2))."</td><td>$".strval(number_format($estatica[0]["iva"],2))."</td><td>$".strval(number_format($estatica[0]["total"],2))."</td><td>$".strval(number_format($estatica[0]["saldo_insoluto"],2))."</td></tr>";
                $fecha_pago_actual = $estatica[0]["fecha_pago"];
            }
            else{
                $response["estado_credito"] = 0;//El crédito está vencido
                echo json_encode($response);
                exit;
                /*$tabla1.= "<tr><td colspan='6' class='text-center'><i>Crédito vencido</i></td></tr>";
                $fecha_pago_siguiente = "00-00-0000";
                $fecha_pago_actual = "00-00-0000";*/
            }
            
            //Consulta último movimiento amortización dinámica
            $pagos = $oconns->getRows("select *,  DATE_FORMAT(fecha_valor,'%d/%m/%Y') as fecha_valor from amortizaciones_dinamicas where idkey_creditos='".$idkey_credito."' order by no_pago desc ,fecha_valor desc");
            $n = $oconns->numberRows;
            $tabla2='';//Pagos atrasados
            if($n>0){
                if($pagos[0]["pago"]==0){//Si su último pago fue 0 busco todos los últimos pagos con esa cantidad
                    foreach ($pagos as $item){ 
                        if($item["pago"]!=0) break;
                        if($item["aprobado"]==0)
                            $estatus = "<span class='badge badge-sm bgc-danger-l2 text-danger-d2 border-1 brc-danger-m3'>No aprobado</span>";
                        else
                            $estatus = "<span class='badge badge-sm bgc-success-l2 text-success-d2 border-1 brc-success-m3'>Aprobado</span>";
                        $tabla2.= "<tr><td>".$item["no_pago"]."</td><td>".$item["fecha_valor"]."</td><td>$".strval(number_format($item["pago"],2))."</td><td>$".strval(number_format($item["interes"],2))."</td><td>$".strval(number_format($item["iva"],2))."</td><td>$".strval(number_format($item["monto"],2))."</td><td>$".strval(number_format($item["interes_acumulado"],2))."</td><td>$".strval(number_format($item["pago_interes_moratorio"],2))."</td><td>$".strval(number_format($item["iva_interes_moratorio"],2))."</td><td>$".strval(number_format($item["amortizacion"],2))."</td><td>$".strval(number_format($item["saldo_insoluto"],2))."</td><td>".$item["dias_transcurridos"]."</td><td>".$estatus."</td><td>--</td></tr>";
                    }
                }
                else{//Si no hay adeudo en el último pago
                    if($pagos[0]["aprobado"]==0)
                        $estatus = "<span class='badge badge-sm bgc-danger-l2 text-danger-d2 border-1 brc-danger-m3'>No aprobado</span>";
                    else
                        $estatus = "<span class='badge badge-sm bgc-success-l2 text-success-d2 border-1 brc-success-m3'>Aprobado</span>";
                   $tabla2.= "<tr><td>".$pagos[0]["no_pago"]."</td><td>".$pagos[0]["fecha_valor"]."</td><td>$".strval(number_format($pagos[0]["pago"],2))."</td><td>$".strval(number_format($pagos[0]["interes"],2))."</td><td>$".strval(number_format($pagos[0]["iva"],2))."</td><td>$".strval(number_format($pagos[0]["monto"],2))."</td><td>$".strval(number_format($pagos[0]["interes_acumulado"],2))."</td><td>$".strval(number_format($pagos[0]["pago_interes_moratorio"],2))."</td><td>$".strval(number_format($pagos[0]["iva_interes_moratorio"],2))."</td><td>$".strval(number_format($pagos[0]["amortizacion"],2))."</td><td>$".strval(number_format($pagos[0]["saldo_insoluto"],2))."</td><td>".$pagos[0]["dias_transcurridos"]."</td><td>".$estatus."</td><td><a class='btn radius-1 btn-sm btn-brc-tp btn-outline-default btn-h-outline-primary btn-a-outline-primary btn-text-primary' title='Imprimir ticket' href='../pdf/ticket_pago.php?idkey_pago=".$pagos[0]["idkey"]."' target='_blank'><i class='fa fa-print'></i></a></td></tr>";
                }
                
                $saldo_insoluto_dinamico= $pagos[0]["saldo_insoluto"];
                $interes_acumulado = $pagos[0]["interes_acumulado"];
                $monto_ultimo_pago = $pagos[0]["pago"];
                $no_ultimo_pago = $pagos[0]["no_pago"];
                $fecha_ultimo_pago = $pagos[0]["fecha_valor"];


                 //Para calcular el pago ideal
                if($no_pago_actual>1){
                    $estatica1 = $oconns->getRows("select saldo_insoluto, total from amortizaciones where idkey_creditos='".$idkey_credito."' and pago=".(intval($no_pago_actual)-1));
                    $pago_ideal=($pagos[0]["saldo_insoluto"] - $estatica1[0]["saldo_insoluto"])+ $estatica1[0]["total"];
                    //$iva = floatval($oconns->getSimple("select valor from iva limit 1;"));  
                    //$iva_interes_acum = $pagos[0]["interes_acumulado"]*($iva-1);
                    //$pago_ideal=($pagos[0]["saldo_insoluto"] - $estatica1[0]["saldo_insoluto"])+ $pagos[0]["monto"] +$iva_interes_acum;
                    //if($pago_ideal < $estatica1[0]["total"])  $pago_ideal = $estatica1[0]["total"];   
                }
                else if($m>0)
                    $pago_ideal=$estatica[0]["total"];
                else
                    $pago_ideal=0;

                //Retorno si el ultimo pago ya fue aprobado o no
                $response["aprobado"] = $pagos[0]["aprobado"];
            }
            else{
                $tabla2.= "<tr><td colspan='14' class='text-center'><i>No se han registrado pagos.</i></td></tr>";
                if($m>0)
                    $saldo_insoluto_dinamico=$estatica[0]["saldo_insoluto"];
                else
                    $saldo_insoluto_dinamico=0;
                $interes_acumulado = 0;
                $monto_ultimo_pago = 0;
                $no_ultimo_pago = 0;
                $fecha_ultimo_pago = '00/00/0000';
                if($m>0)
                    $pago_ideal=$estatica[0]["total"];
                else
                    $pago_ideal=0;

                $response["aprobado"] = 1;
            }
            $credito_datos1 = $oconns->getRows("select tasa_interes, idkey_frecuencia from creditos where idkey='".$idkey_credito."';");  
            $interes_1 = calcular_interes_periodo($credito_datos1[0]['tasa_interes'], $credito_datos1[0]['idkey_frecuencia'], 1.16);

            $response["tabla1"] = $tabla1;
            $response["tabla2"] = $tabla2;
            $response["fecha_pago_siguiente"]= $fecha_pago_siguiente;
            $response["pago_ideal"]= strval(number_format($pago_ideal,2));

            //Cargamos los datos finales
            $response["saldo_insoluto_dinamico"] = $saldo_insoluto_dinamico;
            $response["interes_acumulado"] = $interes_acumulado;
            $response["monto_ultimo_pago"] = $monto_ultimo_pago;
            $response["no_ultimo_pago"] = $no_ultimo_pago;
            $response["fecha_pago_actual"] = $fecha_pago_actual;
            $response["fecha_ultimo_pago"] = $fecha_ultimo_pago;
            $response["estado_credito"] = $estado_credito;
            echo json_encode($response);
            
        break;

        case "calcular_pago";
            $idkey_credito = $_POST["idkey_credito"];
            $referencia = $_POST["referencia"];
            $idkey_clasif_pago = $_POST["tipo_pago"];
            $monto_ultimo_pago = floatval($_POST["monto_ultimo_pago"]);
            $temp = explode("/",$_POST["fecha_pago_actual"]);
            $fecha_pago_actual = $temp[2]."-".$temp[1]."-".$temp[0];
            $temp = explode("/",$_POST["fecha_valor"]);
            $fecha_valor = $temp[2]."-".$temp[1]."-".$temp[0];
            $temp = explode("/",$_POST["fecha_ultimo_pago"]);
            $fecha_ultimo_pago = $temp[2]."-".$temp[1]."-".$temp[0];
            $pago_valor = floatval($_POST["pago_valor"]);
            $no_ultimo_pago = intval($_POST["no_ultimo_pago"]);
            $no_pago_actual = intval($_POST["no_ultimo_pago"]) +1;
            $interes_acumulado = floatval($_POST["interes_acumulado"]);
            $iva = floatval($oconns->getSimple("select valor from iva limit 1;"));  
            $credito_datos = $oconns->getRows("select tasa_interes, idkey_frecuencia, monto from creditos where idkey='".$idkey_credito."';");  
            $interes_anual = floatval($credito_datos[0]["tasa_interes"]);
            $frecuencia= $credito_datos[0]["idkey_frecuencia"];
            if($no_pago_actual==1) $saldo_insoluto = floatval($credito_datos[0]["monto"]);
            else $saldo_insoluto = floatval($_POST["saldo_insoluto_dinamico"]);
            //Si es cajero se aprueba en automático
            if($_SESSION["tipo_usuario"]==4) $aprobado=1;
            else $aprobado=0;
            //$interes_periodo = calcular_interes_periodo($interes_anual, $frecuencia, $iva);

            //1. Verifico que la fecha sea correcta///////////////////////////////////////////////////////////////////
            $f_valor= new DateTime($fecha_valor);
            $f_ult_pago= new DateTime($fecha_ultimo_pago);
            $f_pago_actual= new DateTime($fecha_pago_actual);
            //En pago 0 Validar que la fecha valor sea igual a la fecha pago actual
            if($pago_valor == 0 && ($f_valor != $f_pago_actual)){
                $response["error"]="La fecha del pago debe ser igual a ".$_POST["fecha_pago_actual"];
                echo json_encode($response);
                exit;
            }
            //Validar que la fecha esté en el rango
            else if(!(($f_valor>$f_ult_pago) && ($fecha_valor<=$fecha_pago_actual))){
                if($no_pago_actual==1)
                    $response["error"]="Fecha  de pago inválida. Debe ser ".$_POST["fecha_pago_actual"]." o anterior.";
                else
                    $response["error"]="Fecha  de pago inválida. Debe estar entre ".$_POST["fecha_ultimo_pago"]." y ".$_POST["fecha_pago_actual"];
                echo json_encode($response);
                exit;
            }
            else
                $response["error"]=0;
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////


            
            //CÁLCULOS DE LOS DÍAS///////////////////////////////////////////////////////////////////////////////////////
            $no_pago="";
            $dias_transc_pago_actual = $oconns->getSimple("select DATEDIFF('".$fecha_valor."','".$fecha_pago_actual."')  as dias_transcurridos;"); 
            if($no_pago_actual==1 || $monto_ultimo_pago!=0) 
                $dias_transc_ult_pago = 0;
            else
                $dias_transc_ult_pago = $oconns->getSimple("select DATEDIFF('".$fecha_valor."','".$fecha_ultimo_pago."')  as dias_transcurridos;");
            ////////////////////////////////////////////////////////////////////////////////////////////////////////////


            /****Caso pago_valor ==0: Se cobra el interés completo*****************************************************/
            if($pago_valor == 0){
                $res = calcular_pago_monto_cero($saldo_insoluto, $interes_anual, $frecuencia, $iva, $interes_acumulado);
                $no_pago = $no_pago_actual;
                $fecha_valor = $fecha_pago_actual;
                $dias_transcurridos = $dias_transc_ult_pago;
                $aprobado = 1;
            }
            else{
                /*****Caso pago en tiempo pago_monto>0 ***************************************************************************/
                if($dias_transc_pago_actual==0){
                    $res=calcular_pago_normal($pago_valor, $saldo_insoluto, $interes_anual, $frecuencia, $iva, $interes_acumulado);
                    $no_pago = $no_pago_actual;
                    $fecha_valor = $fecha_pago_actual;
                    $dias_transcurridos = $dias_transc_ult_pago;
                }
                /*****Caso pago con días de mora ***************************************************************************/
                else if($dias_transc_pago_actual<0 && $dias_transc_ult_pago>0){
                    $dias_transcurridos = $dias_transc_ult_pago;
                    $no_pago = $no_ultimo_pago;
                    $res=calcular_pago_dias_mora($pago_valor, $saldo_insoluto, $interes_anual, $frecuencia, $iva, $interes_acumulado, $dias_transcurridos);
                }
                /*****Caso pago con días de adelanto ***************************************************************************/
                else if($dias_transc_pago_actual<0 && $interes_acumulado==0){
                    $dias_transcurridos = $dias_transc_pago_actual; //Es negativo
                    $dias_adelantados = $dias_transc_pago_actual *(-1);
                    $no_pago = $no_pago_actual;
                    $est = consulta_pago_credito($idkey_credito, $no_pago);
                    $capital_estatico = $est["capital"];
                    $res=calcular_pago_dias_adelanto($pago_valor, $saldo_insoluto, $interes_anual, $frecuencia, $iva, $interes_acumulado, $dias_adelantados, $capital_estatico);
                }
                /*****Caso adelantado pero con adeudo y se cobra normal **********************************************************/
                else{
                    $res=calcular_pago_normal($pago_valor, $saldo_insoluto, $interes_anual, $frecuencia, $iva, $interes_acumulado);
                    $no_pago = $no_pago_actual;
                    $dias_transcurridos = $dias_transc_ult_pago;
                }

            }

            //Recopilar valores
            $pago_monto = $pago_valor;
            $interes = $res["interes"];
            $iva_monto = $res["iva_monto"];
            $monto = $res["monto"];
            $interes_acumulado = $res["interes_acumulado"];
            $pago_int_moratorio = $res["pago_int_moratorio"];
            $iva_int_moratorio = $res["iva_int_moratorio"];
            $amortizacion = $res["amortizacion"];
            $saldo_insoluto = $res["saldo_insoluto"];
            $saldo_afavor = $res["saldo_afavor"];

            //$tabla1="<tr><td>".$no_pago."</td><td>".$fecha_valor."</td><td>$".$pago_monto."</td><td>$".
                $interes."</td><td>$".$iva_monto."</td><td>$".$monto."</td><td>$".$interes_acumulado."</td><td>$".$pago_int_moratorio."</td><td>$".$iva_int_moratorio."</td><td>$".$amortizacion."</td><td>$".$saldo_insoluto."</td><td>".$dias_transcurridos."</td></tr>";
            //$response["tabla1"]=$tabla1;

            if($saldo_insoluto>=0){
                //insert en amortizaciones dinámicas
                $estatica1 = consulta_pago_credito($idkey_credito, $no_pago);
                $idkey_amortizacion = $estatica1["idkey"];
                $oconns->ShotSimple("insert into amortizaciones_dinamicas(no_pago, fecha_valor, pago, interes, iva, monto, interes_acumulado, saldo_afavor, pago_interes_moratorio, iva_interes_moratorio, amortizacion, saldo_insoluto, referencia, dias_transcurridos, idkey_clasif_pago, idkey_amortizacion, idkey_creditos, aprobado) values('$no_pago', '$fecha_valor', '$pago_monto', '$interes', '$iva_monto', '$monto', '$interes_acumulado', '$saldo_afavor', '$pago_int_moratorio', '$iva_int_moratorio', '$amortizacion', '$saldo_insoluto', '$referencia', '$dias_transcurridos', '$idkey_clasif_pago', '$idkey_amortizacion', '$idkey_credito', '$aprobado');");
                $idkey_amort_dinamica=$oconns->last_id;
                $response["idkey_credito"] = $idkey_credito;
                $response["no_sig_pago"] = $no_pago+1;

                //Bitácora
                $oconns->ShotSimple("insert into bitacora_creditos(idkey_credito, idkey_usuario, descripcion) values ($idkey_credito, $idkey_usuario, 'Pago a crédito no. ".$no_pago." con folio ".$idkey_amort_dinamica."')");

                // $response["soluto"]  = ($pago_monto + $saldo_insoluto);

                if($idkey_amort_dinamica != ""){
                    $response["error"]  = 0;
                    if(intval($saldo_insoluto)==0){//Actualizo el estatus del crédito a finalizado
                        $oconns->ShotSimple("update creditos set estatus=5 where idkey='$idkey_credito'");
                        //Bitácora
                        $oconns->ShotSimple("insert into bitacora_creditos(idkey_credito, idkey_usuario, descripcion) values ($idkey_credito, $idkey_usuario, 'Cambio de estatus a Finalizado')");
                    }
                }
                else
                    $response["error"]  = "Ha ocurrido un error inesperado. Inténtelo más tarde.";
            }
            else {
                $response["soluto"] = $pago_monto+ $saldo_insoluto;
                $response["error"]  = "El monto que pretende registrar excede el monto restante a pagar de ".($pago_monto+ $saldo_insoluto);

            }
            
            
            echo json_encode($response);
        break;

        //SECCIÓN DE CAJAS
        case "datatable_creditos_cajero":
            $data = $oconns->getRows("select vc.idkey_credito, vc.nombre, vc.nombre_producto as producto, vc.tipo_credito, vc.folio, vc.monto from  view_creditos vc where estatus=1");
            $response = array();
            if ($oconns->numberRows>0){
                foreach ($data as $item){
                    $idkey_credito = $item["idkey_credito"];

                    //Consultar último pago diferente de 0
                    $ultimo_pago = ultimo_pago_credito($idkey_credito);
                    if($ultimo_pago["n"] > 0){
                        $fecha_ultimo_pago = $ultimo_pago["fecha_ultimo_pago"];
                    }
                    else{
                        $fecha_ultimo_pago = "Ninguno";
                    }

                    //Consultar último pago para sacar el saldo insoluto
                    $ultimo_pago1 = ultimo_pago_credito1($idkey_credito);
                    if($ultimo_pago1["n"] > 0){
                        $saldo_insoluto = strval(number_format($ultimo_pago1["saldo_insoluto"],2));
                        $ultimo_pago_dinamica = $ultimo_pago1["no_ultimo_pago"];
                    }
                    else{
                        $ultimo_pago_dinamica = 0;
                        $saldo_insoluto = strval(number_format($item["monto"],2));//Monto total
                    }

                    //Consultar siguiente pago en amort estática
                    $sig_pago = consulta_pago_credito($idkey_credito, intval($ultimo_pago_dinamica)+1);
                    if($sig_pago["n"] > 0){
                        $fecha_pago_temp = $sig_pago["fecha_pago"];
                        //$temp = explode("-",$fecha_pago_temp);
                        //$fecha_pago = $temp[2]."-".$temp[1]."-".$temp[0];
                        $fecha_pago  = $fecha_pago_temp;
                        $cantidad_pagar =  strval(number_format($sig_pago["cantidad_pagar"],2));
                    }
                    else{
                        $fecha_pago = "Crédito vencido";
                        $cantidad_pagar =  "Crédito vencido";
                    }

                    

                    //Para calcular días transcurridos
                    $dias_transcurridos = $oconns->getSimple("select DATEDIFF('".$fecha_pago_temp."', NOW()) as dias_transcurridos;");

                    $cantidad_pagar =  '<a href="#" class="text-grey text-600" data-toggle="modal" data-target="#cantidad-pagar" onclick="datatable_cantidad_pagar('.$item["idkey_credito"].', \''.$item["nombre"].'\', '.(intval($ultimo_pago_dinamica)+1).')">$ '.$cantidad_pagar.'</a>';

                    
                    if($dias_transcurridos > 0)
                        $estatus = "<span class='badge badge-sm bgc-success-l2 text-success-d2 border-1 brc-success-m3'>En tiempo</span>";
                    else if($dias_transcurridos == 0)
                        $estatus = "<pre>".$alerta_revision." <span class='badge badge-sm bgc-warning-l2 text-warning-d2 border-1 brc-warning-m3'>Día de pago</span></pre>";
                    else
                        $estatus = "<pre><span class='badge badge-sm bgc-danger-l2 text-danger-d2 border-1 brc-danger-m3'>Atrasado</span></pre>";

                    //$temp = explode("-",$fecha_pago);
                    //$fecha_pago = $temp[2]."-".$temp[1]."-".$temp[0];
                    $jsonArrayObject = (array(
                        'folio' => $item["folio"],
                        'fecha_ultimo_pago' => $fecha_ultimo_pago,
                        'fecha_pago' => $fecha_pago, 
                        'nombre' => $item["nombre"], 
                        'producto' => $item["producto"], 
                        'cantidad_pagar' => $cantidad_pagar, 
                        'saldo_insoluto' => $saldo_insoluto,
                        'estatus' => $estatus,
                        'dias_transcurridos' => $dias_transcurridos,
                        'opciones' => '<a href="#" class="btn radius-1 btn-sm btn-brc-tp btn-outline-default btn-h-outline-warning btn-a-outline-warning btn-text-warning"><i class="fa fa-flag"></i></a>'
                    ));
                    $response[] = $jsonArrayObject;
                }
            }
            echo json_encode($response);
        break;

        case "guardar_reestructura_credito";
            $idkey_credito =$_POST["idkey_credito"];
            $data = $oconns->getRows("select tasa_interes, monto, iva, tipo_credito from creditos where idkey='$idkey_credito'");
             $response["con"]="select tasa_interes, monto, iva, tipo_credito from creditos where idkey='$idkey_credito'";
            if($oconns->numberRows>0){
                $folio = $_POST["folio"];
                $temp1 = explode("/", $_POST["fecha_registro"]);
                $fecha_registro= $temp1[2]."-".$temp1[1]."-".$temp1[0];
                $observaciones = $_POST["observaciones"];
                $tasa_interes = $data[0]["tasa_interes"];
                $plazo = $_POST["plazo_meses"];
                //Para obtener saldo insoluto y el número del último pago
                $ultimo_pago = ultimo_pago_credito1($idkey_credito);
                if($ultimo_pago["n"] > 0){
                    $monto = $ultimo_pago["saldo_insoluto"];
                    $no_ultimo_pago = $ultimo_pago["no_ultimo_pago"];
                }
                else{
                    $monto = $data[0]["monto"];
                    $no_ultimo_pago =0;
                }
                ////
                $idkey_frecuencia = $_POST["frecuencia"];
                $iva = $data[0]["iva"];
                $temp1 = explode("/", $_POST["fecha_pago1"]);
                $fecha_pago1= $temp1[2]."-".$temp1[1]."-".$temp1[0];
                $tabla = gererar_tabla_amortizacion($tasa_interes, $plazo, $monto, $idkey_frecuencia, $iva, $fecha_pago1);
                //Borramos para reemplazar
                $oconns->ShotSimple("delete from amortizaciones where idkey_creditos='$idkey_credito' and pago>".$no_ultimo_pago);
                foreach ($tabla as $value) {
                    $temp = explode("-", $value['fecha_pago']);
                    $fecha_pago= $temp[2]."-".$temp[1]."-".$temp[0];
                    $temp1 = explode("-", $value['fecha_temp']);
                    $fecha_temp= $temp1[2]."-".$temp1[1]."-".$temp1[0];

                    $no_pago = intval($value['no_pago'])+ intval($no_ultimo_pago);
                    $oconns->ShotSimple("insert into amortizaciones(pago, fecha_pago, fecha_temp, intereses, iva, renta, total, saldo_insoluto, idkey_creditos, descripcion) values ('".$no_pago."', '$fecha_pago', '$fecha_temp', '".$value['interes']."', '".$value['iva']."', '".$value['capital']."', '".$value['total']."', '".$value['nuevo_saldo']."', '$idkey_credito', 'Pago Reestructurado')");
                }
                //Insertamos en el registro de creditos reestructurados
                $oconns->ShotSimple("insert into creditos_reestructuracion(folio_autorizacion, fecha_registro, plazo_meses, idkey_frecuencia, monto, fecha_pago1, observaciones, idkey_credito, idkey_usuario) values ('$folio', '$fecha_registro', '$plazo', '$idkey_frecuencia', '$monto', '$fecha_pago1', '$observaciones', '$idkey_credito', '$idkey_usuario')");
                //actualizamos estatus_pagos
                $oconns->ShotSimple("update creditos set estatus_pagos = 1 where idkey ='$idkey_credito'");
                 //Bitácora
                $oconns->ShotSimple("insert into bitacora_creditos(idkey_credito, idkey_usuario, descripcion) values ($idkey_credito, $idkey_usuario, 'Reestructuración de crédito con folio $folio')");
                $response["error"]=0;
                $response["idkey_credito"]=$idkey_credito;
                $response["tipo"]=$data["0"]["tipo_credito"];
                $response["tabla"]=$tabla;
            }
            else
                $response["error"]=1;
            echo json_encode($response);
        break;

         case "guardar_condonacion_credito";
            $idkey_credito =$_POST["idkey_credito"];
            $data = $oconns->getRows("select  monto, tipo_credito from creditos where idkey='$idkey_credito'");
            if($oconns->numberRows>0){
                $folio = $_POST["folio"];
                $temp1 = explode("/", $_POST["fecha_registro"]);
                $fecha_registro= $temp1[2]."-".$temp1[1]."-".$temp1[0];
                $observaciones = $_POST["observaciones"];
                $plazo = $_POST["plazo_meses"];
                $idkey_frecuencia = $_POST["frecuencia"];
                $temp1 = explode("/", $_POST["fecha_pago1"]);
                $fecha_pago1= $temp1[2]."-".$temp1[1]."-".$temp1[0];
                //Para obtener saldo insoluto y el número del último pago
                $ultimo_pago = ultimo_pago_credito1($idkey_credito);
                if($ultimo_pago["n"] > 0){
                    $monto = $ultimo_pago["saldo_insoluto"];
                    $no_ultimo_pago = $ultimo_pago["no_ultimo_pago"];
                }
                else{
                    $monto = $data[0]["monto"];
                    $no_ultimo_pago =0;
                }
                ////
                $tabla = gererar_tabla_amortizacion_condonacion($plazo, $monto, $idkey_frecuencia, $fecha_pago1);
                
                //Borramos para reemplazar
                $oconns->ShotSimple("delete from amortizaciones where idkey_creditos='$idkey_credito' and pago>".$no_ultimo_pago);
                foreach ($tabla as $value) {
                    $temp = explode("-", $value['fecha_pago']);
                    $fecha_pago= $temp[2]."-".$temp[1]."-".$temp[0];
                    $temp1 = explode("-", $value['fecha_temp']);
                    $fecha_temp= $temp1[2]."-".$temp1[1]."-".$temp1[0];

                    $no_pago = intval($value['no_pago'])+ intval($no_ultimo_pago);
                    $oconns->ShotSimple("insert into amortizaciones(pago, fecha_pago, fecha_temp, intereses, iva, renta, total, saldo_insoluto, idkey_creditos, descripcion) values ('".$no_pago."', '$fecha_pago', '$fecha_temp', '".$value['interes']."', '".$value['iva']."', '".$value['capital']."', '".$value['total']."', '".$value['nuevo_saldo']."', '$idkey_credito', 'Pago Condonación Intereses')");
                }
                //Insertamos en el registro de creditos condonados
                $oconns->ShotSimple("insert into creditos_condonacion(folio_autorizacion, fecha_registro, plazo_meses, idkey_frecuencia, monto, fecha_pago1, observaciones, idkey_credito, idkey_usuario) values ('$folio', '$fecha_registro', '$plazo', '$idkey_frecuencia', '$monto', '$fecha_pago1', '$observaciones', '$idkey_credito', '$idkey_usuario')");
                //actualizamos estatus_pagos
                $oconns->ShotSimple("update creditos set estatus_pagos = 2 where idkey ='$idkey_credito'");
                 //Bitácora
                $oconns->ShotSimple("insert into bitacora_creditos(idkey_credito, idkey_usuario, descripcion) values ($idkey_credito, $idkey_usuario, 'Condonación de intereses de crédito con folio $folio')");
                
                $response["error"]=0;
                $response["idkey_credito"]=$idkey_credito;
                $response["tipo"]=$data["0"]["tipo_credito"];
                $response["tabla"]=$tabla;
            }
            else
                $response["error"]=1;
            
            echo json_encode($response);
        break;

        case "guardar_renovacion_credito";
            $idkey_credito =$_POST["idkey_credito"];
            $data = $oconns->getRows("select tasa_interes, monto, iva, tipo_credito from creditos where idkey='$idkey_credito'");
            if($oconns->numberRows>0){
                $folio = $_POST["folio"];
                $temp1 = explode("/", $_POST["fecha_registro"]);
                $fecha_registro= $temp1[2]."-".$temp1[1]."-".$temp1[0];
                $observaciones = $_POST["observaciones"];
                $tasa_interes = $data[0]["tasa_interes"];
                $plazo = $_POST["plazo_meses"];
                //Para obtener saldo insoluto y el número del último pago
                $ultimo_pago = ultimo_pago_credito1($idkey_credito);
                if($ultimo_pago["n"] > 0){
                    $monto = $ultimo_pago["saldo_insoluto"];
                    $no_ultimo_pago = $ultimo_pago["no_ultimo_pago"];
                }
                else{
                    $monto = $data[0]["monto"];
                    $no_ultimo_pago =0;
                }
                ////
                $idkey_frecuencia = $_POST["frecuencia"];
                $iva = $data[0]["iva"];
                $temp1 = explode("/", $_POST["fecha_pago1"]);
                $fecha_pago1= $temp1[2]."-".$temp1[1]."-".$temp1[0];
                $tabla = gererar_tabla_amortizacion($tasa_interes, $plazo, $monto, $idkey_frecuencia, $iva, $fecha_pago1);
                //Borramos para reemplazar
                $oconns->ShotSimple("delete from amortizaciones where idkey_creditos='$idkey_credito' and pago>".$no_ultimo_pago);
                foreach ($tabla as $value) {
                    $temp = explode("-", $value['fecha_pago']);
                    $fecha_pago= $temp[2]."-".$temp[1]."-".$temp[0];
                    $temp1 = explode("-", $value['fecha_temp']);
                    $fecha_temp= $temp1[2]."-".$temp1[1]."-".$temp1[0];

                    $no_pago = intval($value['no_pago'])+ intval($no_ultimo_pago);
                    $oconns->ShotSimple("insert into amortizaciones(pago, fecha_pago, fecha_temp, intereses, iva, renta, total, saldo_insoluto, idkey_creditos, descripcion) values ('".$no_pago."', '$fecha_pago', '$fecha_temp', '".$value['interes']."', '".$value['iva']."', '".$value['capital']."', '".$value['total']."', '".$value['nuevo_saldo']."', '$idkey_credito', 'Pago Renovado')");
                }
                //Insertamos en el registro de creditos renovados
                $oconns->ShotSimple("insert into creditos_renovacion(folio_autorizacion, fecha_registro, plazo_meses, idkey_frecuencia, monto, fecha_pago1, observaciones, idkey_credito, idkey_usuario) values ('$folio', '$fecha_registro', '$plazo', '$idkey_frecuencia', '$monto', '$fecha_pago1', '$observaciones', '$idkey_credito', '$idkey_usuario')");
                //actualizamos estatus_pagos
                $oconns->ShotSimple("update creditos set estatus_pagos = 3 where idkey ='$idkey_credito'");
                 //Bitácora
                $oconns->ShotSimple("insert into bitacora_creditos(idkey_credito, idkey_usuario, descripcion) values ($idkey_credito, $idkey_usuario, 'Renovación de crédito con folio $folio')");
                $response["error"]=0;
                $response["idkey_credito"]=$idkey_credito;
                $response["tipo"]=$data["0"]["tipo_credito"];
                $response["tabla"]=$tabla;
            }
            else
                $response["error"]=1;
            echo json_encode($response);
        break;
        
        case "descargarListaCreditos":
            $fechaInicio = $_POST["fechaInicio"];
            $fechaFin = $_POST["fechaFin"];

            $data = $oconns->getRows("SELECT  ac.descripcion, ac.fecha_pago, ac.fecha_temp, ac.total, vc.folio, vc.nombre, vc.nombre_producto FROM 
            amortizaciones_contrato AS ac INNER JOIN view_creditos AS vc ON vc.idkey_credito = ac.idkey_creditos WHERE fecha_pago BETWEEN '$fechaInicio' AND '$fechaFin' ");

            $rows = array();
            foreach($data as $value) {
                $jsonArrayObject = (array(
                    'descripcion' => $value["descripcion"], 
                    'fecha_pago' => $value["fecha_pago"], 
                    'fecha_temp' => $value["fecha_temp"], 
                    'folio' => $value["folio"], 
                    'nombre' => $value["nombre"], 
                    'nombre_producto' => $value["nombre_producto"], 
                    'total' => $value["total"]

                ));
                $rows[] = $jsonArrayObject;
            }

            echo json_encode($rows);
            break; 

    }
}



?>
