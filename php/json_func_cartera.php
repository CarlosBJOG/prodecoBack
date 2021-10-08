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


    ///FUNCIONES
    function obtener_mpios($edo, $mpio){
        $oconns = new database();
        $data = $oconns->getRows("select * from municipios where idkey_estados =".$edo." order by nombre asc");
        $mpios = "";
        foreach ($data as $item){
            if (intval($mpio) == intval($item["idkey"]))
                $mpios= $mpios."<option value='".$item["idkey"]."' selected>".$item["nombre"]."</option>";
            else
                $mpios= $mpios."<option value='".$item["idkey"]."'>".$item["nombre"]."</option>";
        }
        return $mpios;
    }

    function obtener_localidades($mpio, $loc){
        $oconns = new database();
        $data = $oconns->getRows("select * from localidad where idkey_municipios =".$mpio." order by nombre asc");
        $locs = "";
        foreach ($data as $item){
            if (intval($loc) == intval($item["idkey"]))
                $locs= $locs."<option value='".$item["idkey"]."' selected>".$item["nombre"]."</option>";
            else
                $locs= $locs."<option value='".$item["idkey"]."'>".$item["nombre"]."</option>";
        }
        return $locs;
    }

    function obtener_cps($loc, $cp){
        $oconns = new database();
        $data = $oconns->getRows("select * from codigo_postal where idkey_localidad =".$loc." order by nombre asc");
        $cps = "";
        foreach ($data as $item){
            if (intval($cp) == intval($item["idkey"]))
                $cps= $cps."<option value='".$item["idkey"]."' selected>".$item["nombre"]."</option>";
            else
                $cps= $cps."<option value='".$item["idkey"]."'>".$item["nombre"]."</option>";
        }
        return $cps;
    }

    function consultar_progreso_credito($idkey_credito){
            $oconns = new database();
            /*
            $npagados = $oconns->getSimple("SELECT count(idkey) as pagados FROM amortizaciones_dinamicas where idkey_creditos=".$idkey_credito);
            $ntotal = $oconns->getRows("SELECT numero_pagos FROM view_creditos  where idkey_credito=".$idkey_credito);  
            if($oconns->numberRows>0){
                $progreso = (intval($npagados) / intval($ntotal[0]["numero_pagos"]))*100;
            }
            else $progreso = 0;
            */
            $monto_credito = $oconns->getRows("SELECT monto FROM creditos where idkey=".$idkey_credito);
            $n = $oconns->numberRows;
            $saldo_insoluto = $oconns->getRows("SELECT saldo_insoluto FROM amortizaciones_dinamicas where idkey_creditos=".$idkey_credito." order by idkey desc limit 1");
            $m = $oconns->numberRows;
            if($n>0 && $m>0)
                $progreso = (1-floatval($saldo_insoluto[0]["saldo_insoluto"]) / floatval($monto_credito[0]["monto"]))*100;
            else
                $progreso =0;
            return round($progreso,0);
    }

    function consultar_diasmora_credito($idkey_credito){
            $oconns = new database();
            $ndiasmora = $oconns->getSimple("SELECT sum(dias_transcurridos) as diasmora FROM amortizaciones_dinamicas where dias_transcurridos>0 and idkey_creditos=".$idkey_credito);
            return $ndiasmora;
    }
    /*function comprobar_perfil_completo_cliente($idkey_cliente){
            $oconns = new database();
            $perfil_completo = $oconns->getSimple("SELECT count(idkey_cliente) as perfil_completo FROM view_clientes_perfil where idkey_cliente=".$idkey_cliente);
            if($perfil_completo > 0)
                return true;
            else 
                return false;
    }*/

    function comprobar_porcentaje_cliente($idkey_cliente){
            $oconns = new database();
            $perfil_completo = $oconns->getSimple("SELECT count(idkey_cliente) as perfil_completo FROM view_clientes where porcentaje_perfil=1 and idkey_cliente=".$idkey_cliente);
            if($perfil_completo > 0)
                return true;
            else 
                return false;
    }

    function perfil_completo_cliente($idkey_cliente){
            $oconns = new database();
            $txt_error = "";//Flatantes en el perfil
            //Dirección principal

            $d = $oconns->getSimple("SELECT count(idkey_cliente) as ndir FROM view_direcciones where prioridad=1 and idkey_cliente=".$idkey_cliente);
            if($d == 0)
                $txt_error.="Dirección principal, ";
            /******
            //2 relaciones de tipo aval
            $r = $oconns->getSimple("SELECT count(idkey_clientes) as navales FROM clientes_relaciones where idkey_relaciones = 2 and idkey_clientes=".$idkey_cliente);
            if($r < 2)
                $txt_error.="2 relaciones de tipo Aval, ";
            ******/
            //1 contacto principal
            $c1 = $oconns->getSimple("SELECT count(idkey_clientes) as ncont FROM clientes_contacto where idkey_contacto_prioridad = 1 and idkey_clientes=".$idkey_cliente);
            if($c1 == 0)
                $txt_error.="1 Contacto principal, ";
            /*********
            //1 contacto secundario
            $c2 = $oconns->getSimple("SELECT count(idkey_clientes) as ncont FROM clientes_contacto where idkey_contacto_prioridad = 2 and idkey_clientes=".$idkey_cliente);
            if($c2 == 0)
                $txt_error.="1 Contacto secundario, ";
            ******/
            //datos adicionales
            $da = $oconns->getSimple("SELECT count(idkey_clientes) as nda FROM clientes_datos_adicionales where  idkey_clientes=".$idkey_cliente);
            if($da == 0)
                $txt_error.="Datos adicionales, ";
            //estudio socioeconómico
            $es = $oconns->getSimple("SELECT count(idkey_clientes) as nes FROM clientes_socio_economico where  idkey_clientes=".$idkey_cliente);
            if($es == 0)
                $txt_error.="Estudio socioeconómico, ";
            //1 garantía mueble
            $gm = $oconns->getSimple("SELECT count(idkey_clientes) as ngm FROM garantias_mueble where  idkey_clientes=".$idkey_cliente);
            if($gm == 0)
                $txt_error.="1 Garantía mueble, ";
            /************
            //1 garantía inmueble
            $gi = $oconns->getSimple("SELECT count(idkey_clientes) as ngi FROM garantias_inmueble where  idkey_clientes=".$idkey_cliente);
            if($gi == 0)
                $txt_error.="1 Garantía inmueble, ";
            *******/
            //1 ingreso
            $ing = $oconns->getSimple("SELECT count(idkey_clientes) as ning FROM clientes_ingresos where  principal=1 and idkey_clientes=".$idkey_cliente);
            if($ing == 0)
                $txt_error.="1 Ingreso principal, ";
             //1 egreso
            $eg = $oconns->getSimple("SELECT count(idkey_clientes) as neg FROM clientes_egresos where  idkey_clientes=".$idkey_cliente);
            if($eg == 0)
                $txt_error.="1 Egreso";
           
           return $txt_error;
    }

     function calcular_factores($idkey_cliente){
        $oconns = new database();
        //Historial crediticio interno (consultar en la base de datos los días de morosidad en el pago)
        $creditos = $oconns->getRows("select idkey_credito, 'Individual' as tipo from view_cred_individuales where idkey_clientes=".$idkey_cliente." UNION ALL SELECT cg.idkey_credito, 'Grupal' as tipo FROM view_cred_grupales cg inner join grupos_clientes gc on (gc.idkey_grupo=cg.idkey_clientes) where  gc.idkey_clientes=".$idkey_cliente.";");
        $response["creditos"] = "select idkey_credito, 'Individual' as tipo from view_cred_individuales where idkey_clientes=".$idkey_cliente." UNION ALL SELECT cg.idkey_credito, 'Grupal' as tipo FROM view_cred_grupales cg inner join grupos_clientes gc on (gc.idkey_grupo=cg.idkey_clientes) where  gc.idkey_clientes=".$idkey_cliente.";";
        if ($oconns->numberRows>0){
            $ndiasmora_total = 0;
            foreach ($creditos as $item){ 
                $idkey_credito = $item["idkey_credito"];
                $ndiasmora = intval(consultar_diasmora_credito($idkey_credito));
                $ndiasmora_total += $ndiasmora;
            }    
            $response["desc_historial_interno"] = $ndiasmora_total." días de mora";
            if($ndiasmora_total>= 0 && $ndiasmora_total<=30)
                $response["historial_interno"] = 50;
            else if($ndiasmora_total>= 31 && $ndiasmora_total<=60)
                $response["historial_interno"] = 30;
            else if($ndiasmora_total>= 61 && $ndiasmora_total<=90)
                $response["historial_interno"] = 25;
            else if($ndiasmora_total>= 91 && $ndiasmora_total<=120)
                $response["historial_interno"] = 15;
            else if($ndiasmora_total>= 121 && $ndiasmora_total<=180)
                $response["historial_interno"] =5;
            else 
                $response["historial_interno"] = 0;
        }
        else{
            $response["desc_historial_interno"] = "No se encontró";
            $response["historial_interno"] = 0;
        }

        //Tipo Vivienda
        $tipo_vivienda = $oconns->getRows("select tv.value as value, tv.nombre from clientes_socio_economico cs inner join tipo_vivienda tv on (cs.idkey_tipo_vivienda = tv.idkey) where cs.idkey_clientes =".$idkey_cliente);
        if ($oconns->numberRows>0){
            $response["tipo_vivienda"] = intval($tipo_vivienda[0]["value"]);
            $response["desc_tipo_vivienda"] = $tipo_vivienda[0]["nombre"];
        }
        else{
            $response["tipo_vivienda"] = 0;
            $response["desc_tipo_vivienda"] ="No se encontró";
        }

        //Arraigo domiciliario (domicilio principal, fecha de ocupación)
        $arraigo_domiciliario = $oconns->getRows("select TIMESTAMPDIFF(YEAR, fecha_habita, CURDATE()) AS anios from view_direcciones where prioridad=1 and idkey_cliente =".$idkey_cliente);
        if ($oconns->numberRows>0){
            $arraigo_dom = intval($arraigo_domiciliario[0]["anios"]);
            $response["desc_arraigo_domiciliario"] = $arraigo_dom." años de ocupación";
            if($arraigo_dom < 1)
                $response["arraigo_domiciliario"] = 5;
            else if($arraigo_dom >= 1 && $arraigo_dom <= 4)
                $response["arraigo_domiciliario"] = 8;
            else
                $response["arraigo_domiciliario"] = 10;
        }
        else{
            $response["arraigo_domiciliario"] = 0;
            $response["desc_arraigo_domiciliario"] ="No se encontró";
        }

        //Arraigo Laboral (ingresos, fecha de ingreso a su trabajo)
        //Ocupación (Obtener de los ingresos, tipo)
        $ingresos = $oconns->getRows("select TIMESTAMPDIFF(YEAR, ci.inicio, CURDATE()) AS arraigo_laboral, it.value as value_ocupacion, it.nombre  from clientes_ingresos ci inner join ingresos_tipos it on (ci.id_tipo_ingreso = it.idkey) where ci.idkey_clientes =".$idkey_cliente.' order by ci.fin desc limit 1');
        if ($oconns->numberRows>0){
            $arraigo_laboral = intval($ingresos[0]["arraigo_laboral"]);
            if($arraigo_laboral < 1 )
                $value_arraigo_laboral = 5;
            else if($arraigo_laboral >=1 && $arraigo_laboral<=3 )
                $value_arraigo_laboral = 10;
            else if($arraigo_laboral >3 && $arraigo_laboral<=5 )
                $value_arraigo_laboral = 15;
            else 
                $value_arraigo_laboral = 20;
                
            $response['arraigo_laboral'] = $value_arraigo_laboral; 
            $response['desc_arraigo_laboral'] = $arraigo_laboral." años de laborar";
            $response['ocupacion'] = intval($ingresos[0]["value_ocupacion"]);
            $response['desc_ocupacion'] = $ingresos[0]["nombre"];
        }
        else{
            $response['arraigo_laboral'] = 0; 
            $response['desc_arraigo_laboral'] ="No se encontró";
            $response['ocupacion'] = 0;
            $response['desc_ocupacion'] ="No se encontró";
        }

        //Edad(obtener de su registro)      
        $generales = $oconns->getRows("select edad from view_clientes where idkey_cliente =".$idkey_cliente);
        if ($oconns->numberRows>0){
            $edad = intval($generales[0]["edad"]);
            if($edad >=18 && $edad <=25 )
                $value_edad = 5;
            else if($edad >=26 && $edad <=50 )
                $value_edad = 10;
            else if($edad >=51 && $edad <=69 )
                $value_edad = 5;
            else
                $value_edad = 0;
            $response["edad"] = $value_edad;
            $response["desc_edad"] = $edad." años";
        }
        else{
            $response["edad"] = 0;
            $response["desc_edad"] = "No se encontró";
        }

        //Hipotecaria (obtener de bienes inmuebles) 
        //Bienes declarados (bienes inmuebles)                
        $hipo = $oconns->getRows("select aforo, escritura from garantias_inmueble where idkey_clientes =".$idkey_cliente." order by escritura desc limit 1");
        if ($oconns->numberRows>0){
            $response["hipotecaria"] = intval($hipo[0]['aforo']);
            ///Arreglar esto desde la BD
            if($response["hipotecaria"]==10)
                $response["desc_hipotecaria"] = "Aforo 2 a 1";
            else if($response["hipotecaria"]==5)
                $response["desc_hipotecaria"] = "Aforo menor";
            else
                $response["desc_hipotecaria"] = "Inviable";
            /////////////////////////////////////////////
            if($hipo[0]['escritura'] ==""){
                $response["bienes_declarados"] = 0;
                $response["desc_bienes_declarados"] = "Sin escrituras";
            }
            else{
                $response["bienes_declarados"] = 5;
                $response["desc_bienes_declarados"] = "Con escrituras";
            }
        }
        else{
            $response["hipotecaria"] = 0;
            $response["desc_hipotecaria"] ="No se encontró";
            $response["bienes_declarados"] = 0;
            $response["desc_bienes_declarados"] = "No se encontró";
        }

        //Mobiliaria (obtener de bienes muebles)   
        $mob = $oconns->getRows("select cobertura from garantias_mueble where idkey_clientes =".$idkey_cliente." order by idkey asc limit 1");
        if ($oconns->numberRows>0){
            $response["mobiliaria"] = intval($mob[0]['cobertura']);
            ///Arreglar en la BD
            if($response["mobiliaria"]== 10)
                $response["desc_mobiliaria"] = "Mayor al 100%";
            else if($response["mobiliaria"]== 8)
                $response["desc_mobiliaria"] = "Igual a 100%";
            else
                $response["desc_mobiliaria"] = "Menor al 100%";
        }
        else{
            $response["mobiliaria"] = 0;      
            $response["desc_mobiliaria"] ="No se encontró"; 
        }

        //Avales (obtener de la información de los avales en el registro del cliente) 3 avales máximo                  
        $avales = $oconns->getRows("select sum(aval_hist) as aval_hist,  sum(aval_capacidad) as aval_capacidad, sum(aval_solvencia) as aval_solvencia from clientes_relaciones where idkey_relaciones = 2 and idkey_clientes =".$idkey_cliente." order by idkey asc limit 3");
        if ($oconns->numberRows>0){
            $response["avales_historial"] = intval($avales[0]['aval_hist']);
            $response["desc_avales_historial"] = "Historial avales";
            $response["avales_capacidad"] = intval($avales[0]['aval_capacidad']);
            $response["desc_avales_capacidad"] = "Capacidad de pago avales";
            $response["avales_solvencia"] = intval($avales[0]['aval_solvencia']);
            $response["desc_avales_solvencia"] = "Solvencia avales";
        }
        else{
            $response["avales_historial"] = 0;
            $response["desc_avales_historial"] = "No se encontró";
            $response["avales_capacidad"] = 0;
            $response["desc_avales_capacidad"] = "No se encontró";
            $response["avales_solvencia"] = 0;
            $response["desc_avales_solvencia"] = "No se encontró";   
        }

        return $response;              
    }

    switch($funcion){
        case "cargar_factores_completos":
            $idkey_cliente = $_POST["idkey_cliente"];
            $res = calcular_factores($idkey_cliente);
            $filas ="";
            //Se cargan los factores que faltan de la BD
            $data = $oconns->getRows("select *, fb.nombre as desc_buro, fb.valor as valor_buro, fe.nombre as desc_exp, fe.valor as exp, fc.nombre as desc_cap, fc.valor as cap, fi.nombre as desc_ingreso, fi.valor as ingreso, fr.nombre as desc_ref, fr.valor as ref, fa.nombre as desc_act, fa.valor as act, fv.nombre as desc_veracidad, fv.valor as veracidad_valor, fg.nombre as desc_gliquida, fg.valor as gliquida_valor, fs.nombre as desc_solv, fs.valor as solvencia_valor  from clientes_factores f INNER join clientes_fact_buro fb on (f.idkey_buro=fb.idkey) inner join clientes_fact_exp_crediticia fe on (f.idkey_exp_crediticia=fe.idkey) inner join clientes_fact_cap_pago fc on (f.idkey_cap_pago=fc.idkey) INNER join clientes_fact_comp_ingresos fi on (f.idkey_comp_ingresos=fi.idkey) inner join clientes_fact_referencias fr on (f.idkey_referencias = fr.idkey) inner join clientes_fact_actividad fa on (f.idkey_actividad = fa.idkey) inner join clientes_fact_veracidad fv on (f.idkey_veracidad = fv.idkey) inner join clientes_fact_solvencia fs on (f.idkey_solvencia =fs.idkey) INNER join clientes_fact_gliquida fg on (f.idkey_gliquida=fg.idkey) where idkey_clientes= '$idkey_cliente';");
            if ($oconns->numberRows>0){
                if($data[0]["historial_interno"]==1) $checked = "checked";
                else $checked = "";
                $s = '<input type="checkbox" name="factor_value" class="ace-switch input-lg ace-switch-bars-h  ace-switch-check ace-switch-times text-grey-l2 bgc-success-d2 radius-2px" '.$checked.' value="'.$res["historial_interno"].'" max=50 onChange="calcular_score()">';
                $filas= "<tr><td width='15%'>".$s."</td><td>Historial interno</td><td>".$res["desc_historial_interno"]."</td><td>".$res["historial_interno"]."/50</td></tr>";
                if($data[0]["vivienda"]==1) $checked = "checked";
                else $checked = "";
                $s = '<input type="checkbox" name="factor_value" class="ace-switch input-lg ace-switch-bars-h  ace-switch-check ace-switch-times text-grey-l2 bgc-success-d2 radius-2px" '.$checked.' value="'.$res["tipo_vivienda"].'" onChange="calcular_score()" max=20>';
                $filas.= "<tr><td>".$s."</td><td>Tipo de vivienda</td><td>".$res["desc_tipo_vivienda"]."</td><td>".$res["tipo_vivienda"]."/20</td></tr>";
                if($data[0]["arraigo_dom"]==1) $checked = "checked";
                else $checked = "";
                $s = '<input type="checkbox" name="factor_value" class="ace-switch input-lg ace-switch-bars-h  ace-switch-check ace-switch-times text-grey-l2 bgc-success-d2 radius-2px" '.$checked.' value="'.$res["arraigo_domiciliario"].'" onChange="calcular_score()" max=10>';
                $filas.= "<tr><td>".$s."</td><td>Arraigo domiciliario</td><td>".$res["desc_arraigo_domiciliario"]."</td><td>".$res["arraigo_domiciliario"]."/10</td></tr>";
                if($data[0]["arraigo_lab"]==1) $checked = "checked";
                else $checked = "";
                $s = '<input type="checkbox" name="factor_value" class="ace-switch input-lg ace-switch-bars-h  ace-switch-check ace-switch-times text-grey-l2 bgc-success-d2 radius-2px" '.$checked.' value="'.$res["arraigo_laboral"].'" onChange="calcular_score()" max=20>';
                $filas.= "<tr><td>".$s."</td><td>Arraigo laboral</td><td>".$res["desc_arraigo_laboral"]."</td><td>".$res["arraigo_laboral"]."/20</td></tr>";
                if($data[0]["ocupacion"]==1) $checked = "checked";
                else $checked = "";
                $s = '<input type="checkbox" name="factor_value" class="ace-switch input-lg ace-switch-bars-h  ace-switch-check ace-switch-times text-grey-l2 bgc-success-d2 radius-2px" '.$checked.' value="'.$res["ocupacion"].'" onChange="calcular_score()" max=10>';
                $filas.= "<tr><td>".$s."</td><td>Ocupación</td><td>".$res["desc_ocupacion"]."</td><td>".$res["ocupacion"]."/10</td></tr>";
                if($data[0]["edad"]==1) $checked = "checked";
                else $checked = "";
                $s = '<input type="checkbox" name="factor_value" class="ace-switch input-lg ace-switch-bars-h  ace-switch-check ace-switch-times text-grey-l2 bgc-success-d2 radius-2px" '.$checked.' value="'.$res["edad"].'" onChange="calcular_score()" max=10>';
                $filas.= "<tr><td>".$s."</td><td>Edad</td><td>".$res["desc_edad"]."</td><td>".$res["edad"]."/10</td></tr>";
                if($data[0]["hipotecaria"]==1) $checked = "checked";
                else $checked = "";
                $s = '<input type="checkbox" name="factor_value" class="ace-switch input-lg ace-switch-bars-h  ace-switch-check ace-switch-times text-grey-l2 bgc-success-d2 radius-2px" '.$checked.' value="'.$res["hipotecaria"].'" onChange="calcular_score()" max=10>';
                $filas.= "<tr><td>".$s."</td><td>Hipotecaria</td><td>".$res["desc_hipotecaria"]."</td><td>".$res["hipotecaria"]."/10</td></tr>";
                if($data[0]["bienes"]==1) $checked = "checked";
                else $checked = "";
                $s = '<input type="checkbox" name="factor_value" class="ace-switch input-lg ace-switch-bars-h  ace-switch-check ace-switch-times text-grey-l2 bgc-success-d2 radius-2px" '.$checked.' value="'.$res["bienes_declarados"].'" onChange="calcular_score()" max=5>';
                $filas.= "<tr><td>".$s."</td><td>Bienes declarados</td><td>".$res["desc_bienes_declarados"]."</td><td>".$res["bienes_declarados"]."/5</td></tr>";
                if($data[0]["mobiliaria"]==1) $checked = "checked";
                else $checked = "";
                $s = '<input type="checkbox" name="factor_value" class="ace-switch input-lg ace-switch-bars-h  ace-switch-check ace-switch-times text-grey-l2 bgc-success-d2 radius-2px" '.$checked.' value="'.$res["mobiliaria"].'" onChange="calcular_score()" max=10>';
                $filas.= "<tr><td>".$s."</td><td>Mobiliaria</td><td>".$res["desc_mobiliaria"]."</td><td>".$res["mobiliaria"]."/10</td></tr>";
                if($data[0]["aval_historial"]==1) $checked = "checked";
                else $checked = "";
                $s = '<input type="checkbox" name="factor_value" class="ace-switch input-lg ace-switch-bars-h  ace-switch-check ace-switch-times text-grey-l2 bgc-success-d2 radius-2px" '.$checked.' value="'.$res["avales_historial"].'" onChange="calcular_score()" max=90>';
                $filas.= "<tr><td>".$s."</td><td>Avales</td><td>".$res["desc_avales_historial"]."</td><td>".$res["avales_historial"]."/90</td></tr>";
                if($data[0]["aval_capacidad"]==1) $checked = "checked";
                else $checked = "";
                $s = '<input type="checkbox" name="factor_value" class="ace-switch input-lg ace-switch-bars-h  ace-switch-check ace-switch-times text-grey-l2 bgc-success-d2 radius-2px" '.$checked.' value="'.$res["avales_capacidad"].'" onChange="calcular_score()" max=240>';
                $filas.= "<tr><td>".$s."</td><td>Avales</td><td>".$res["desc_avales_capacidad"]."</td><td>".$res["avales_capacidad"]."/240</td></tr>";
                if($data[0]["aval_solvencia"]==1) $checked = "checked";
                else $checked = "";
                $s = '<input type="checkbox" name="factor_value" class="ace-switch input-lg ace-switch-bars-h  ace-switch-check ace-switch-times text-grey-l2 bgc-success-d2 radius-2px" '.$checked.' value="'.$res["avales_solvencia"].'" onChange="calcular_score()" max=15>';
                $filas.= "<tr><td>".$s."</td><td>Avales</td><td>".$res["desc_avales_solvencia"]."</td><td>".$res["avales_solvencia"]."/15</td></tr>";
            
                $buro = intval($data[0]["valor_buro"]);
                if($data[0]["buro"]==1) $checked = "checked";
                else $checked = "";
                $s = '<input type="checkbox" name="factor_value" class="ace-switch input-lg ace-switch-bars-h  ace-switch-check ace-switch-times text-grey-l2 bgc-success-d2 radius-2px" '.$checked.' value="'.$buro.'" onChange="calcular_score()" max=30>';
                $filas.= "<tr><td>".$s."</td><td>Historial crediticio buró de crédito</td><td>".$data[0]["desc_buro"]."</td><td>".$buro."/30</td></tr>";
                $exp = intval($data[0]["exp"]);
                if($data[0]["exp_cred"]==1) $checked = "checked";
                else $checked = "";
                $s = '<input type="checkbox" name="factor_value" class="ace-switch input-lg ace-switch-bars-h  ace-switch-check ace-switch-times text-grey-l2 bgc-success-d2 radius-2px" '.$checked.' value="'.$exp.'" onChange="calcular_score()" max=20>';
                $filas.= "<tr><td>".$s."</td><td>Experiencia crediticia</td><td>".$data[0]["desc_exp"]."</td><td>".$exp."/20</td></tr>";
                $cap = intval($data[0]["cap"]);
                if($data[0]["cap_pago"]==1) $checked = "checked";
                else $checked = "";
                $s = '<input type="checkbox" name="factor_value" class="ace-switch input-lg ace-switch-bars-h  ace-switch-check ace-switch-times text-grey-l2 bgc-success-d2 radius-2px" '.$checked.' value="'.$cap.'" onChange="calcular_score()" max=80>';
                $filas.= "<tr><td>".$s."</td><td>Capacidad de pago</td><td>".$data[0]["desc_cap"]."</td><td>".$cap."/80</td></tr>";
                $ingreso = intval($data[0]["ingreso"]);
                if($data[0]["ingresos"]==1) $checked = "checked";
                else $checked = "";
                $s = '<input type="checkbox" name="factor_value" class="ace-switch input-lg ace-switch-bars-h  ace-switch-check ace-switch-times text-grey-l2 bgc-success-d2 radius-2px" '.$checked.' value="'.$ingreso.'" onChange="calcular_score()" max=20>';
                $filas.= "<tr><td>".$s."</td><td>Comprobación de ingresos</td><td>".$data[0]["desc_ingreso"]."</td><td>".$ingreso."/20</td></tr>";
                $ref = intval($data[0]["ref"]);
                if($data[0]["referencias"]==1) $checked = "checked";
                else $checked = "";
                $s = '<input type="checkbox" name="factor_value" class="ace-switch input-lg ace-switch-bars-h  ace-switch-check ace-switch-times text-grey-l2 bgc-success-d2 radius-2px" '.$checked.' value="'.$ref.'" onChange="calcular_score()" max=10>';
                $filas.= "<tr><td>".$s."</td><td>Referencias</td><td>".$data[0]["desc_ref"]."</td><td>".$ref."/10</td></tr>";
                $act = intval($data[0]["act"]);
                if($data[0]["actividad"]==1) $checked = "checked";
                else $checked = "";
                $s = '<input type="checkbox" name="factor_value" class="ace-switch input-lg ace-switch-bars-h  ace-switch-check ace-switch-times text-grey-l2 bgc-success-d2 radius-2px" '.$checked.' value="'.$act.'" onChange="calcular_score()" max=10>';
                $filas.= "<tr><td>".$s."</td><td>Conocimiento de la actividad</td><td>".$data[0]["desc_act"]."</td><td>".$act."/10</td></tr>";
                $veracidad = intval($data[0]["veracidad_valor"]);
                if($data[0]["veracidad"]==1) $checked = "checked";
                else $checked = "";
                $s = '<input type="checkbox" name="factor_value" class="ace-switch input-lg ace-switch-bars-h  ace-switch-check ace-switch-times text-grey-l2 bgc-success-d2 radius-2px" '.$checked.' value="'.$veracidad.'" onChange="calcular_score()" max=10>';
                $filas.= "<tr><td>".$s."</td><td>Veracidad</td><td>".$data[0]["desc_veracidad"]."</td><td>".$veracidad."/10</td></tr>";
                $gliquida = intval($data[0]["gliquida_valor"]);
                if($data[0]["gliquida"]==1) $checked = "checked";
                else $checked = "";
                $s = '<input type="checkbox" name="factor_value" class="ace-switch input-lg ace-switch-bars-h  ace-switch-check ace-switch-times text-grey-l2 bgc-success-d2 radius-2px" '.$checked.' value="'.$gliquida.'" onChange="calcular_score()" max=10>';
                $filas.= "<tr><td>".$s."</td><td>Garantía líquida</td><td>".$data[0]["desc_gliquida"]."</td><td>".$gliquida."/10</td></tr>";
                $solvencia = intval($data[0]["solvencia_valor"]);
                if($data[0]["solvencia"]==1) $checked = "checked";
                else $checked = "";
                $s = '<input type="checkbox" name="factor_value" class="ace-switch input-lg ace-switch-bars-h  ace-switch-check ace-switch-times text-grey-l2 bgc-success-d2 radius-2px" '.$checked.' value="'.$solvencia.'" onChange="calcular_score()" max=5>';
                $filas.= "<tr><td>".$s."</td><td>Solvencia</td><td>".$data[0]["desc_solv"]."</td><td>".$solvencia."/5</td></tr>";
            }
            else
                $filas.= "<tr><td colspan=4 class='text-center'><i>Perfil del cliente incompleto</i></td></tr>";
            $response["factores"] = $filas;
            $response["creditos"] = $res["creditos"];
            $response["con"]="select *, fb.nombre as desc_buro, fb.valor as valor_buro, fe.nombre as desc_exp, fe.valor as exp, fc.nombre as desc_cap, fc.valor as cap, fi.nombre as desc_ingreso, fi.valor as ingreso, fr.nombre as desc_ref, fr.valor as ref, fa.nombre as desc_act, fa.valor as act, fv.nombre as desc_veracidad, fv.valor as veracidad_valor, fg.nombre as desc_gliquida, fg.valor as gliquida_valor, fs.nombre as desc_solv, fs.valor as solvencia_valor  from clientes_factores f INNER join clientes_fact_buro fb on (f.idkey_buro=fb.idkey) inner join clientes_fact_exp_crediticia fe on (f.idkey_exp_crediticia=fe.idkey) inner join clientes_fact_cap_pago fc on (f.idkey_cap_pago=fc.idkey) INNER join clientes_fact_comp_ingresos fi on (f.idkey_comp_ingresos=fi.idkey) inner join clientes_fact_referencias fr on (f.idkey_referencias = fr.idkey) inner join clientes_fact_actividad fa on (f.idkey_actividad = fa.idkey) inner join clientes_fact_veracidad fv on (f.idkey_veracidad = fv.idkey) inner join clientes_fact_solvencia fs on (f.idkey_solvencia =fs.idkey) INNER join clientes_fact_gliquida fg on (f.idkey_gliquida=fg.idkey) where idkey_clientes= '$idkey_cliente';";
            $response["cliente"] = $idkey_cliente;
            echo json_encode($response);
        break;

        //Función que calcula el no. de clientes y el no. de creditos autorizados 
        case "ncli_ncre_promotor":
            $query1 = sprintf("select count(*) as no_clientes from view_clientes where idkey_usuario = $idkey_usuario;");
            $query2 = sprintf("select count(idkey_credito) as no_creditos from view_creditos where estatus = 1");
            $data1 = $oconns->getRows($query1);
            $data2 = $oconns->getRows($query2);
            $response["nClientes"] = $data1[0]["no_clientes"];
            $response["nCreditos"] = $data2[0]["no_creditos"];
            echo json_encode($response);
        break;

        case "consulta_clientes":
            $query = "select idkey_cliente, nombre, fecha_creacion,curp,rfc FROM view_clientes ";
            $data = $oconns->getRows($query);
            $rows = array();
            foreach ($data as $item){ 

                //Por cada cliente consulta número de creditos activos (individuales y grupales)
                $query1 = sprintf("select (select count(idkey_clientes) as cred_ind_activos FROM view_creditos WHERE estatus = 1 and idkey_clientes = %u) as cred_ind_activos",$item["idkey_cliente"]);//individuales
                $query2 = "select count(idkey_credito) as cred_grup_activos 
                    FROM view_creditos vc inner join grupos_nombre gn on (vc.idkey_clientes = gn.idkey) 
                    inner join grupos_clientes gc on (gc.idkey_grupo = gn.idkey) WHERE vc.estatus = 1 and gc.idkey_clientes = ".$item["idkey_cliente"];//grupales
                $data1 = $oconns->getRows($query1);
                $data2 = $oconns->getRows($query2);

                //Preparo el json de retorno
                $jsonArrayObject = (array(
                    'idkey_cliente' => $item["idkey_cliente"], 
                    'nombre' => $item["nombre"], 
                    'fecha_creacion' => $item["fecha_creacion"],
                    'ncreditos' => $data1[0]["cred_ind_activos"] + $data2[0]["cred_grup_activos"],
                    'curp' => $item["curp"]
                ));
                $rows[] = $jsonArrayObject;
            }

            echo json_encode($rows);
        break;

        case "consulta_creditos":
            $query = "select folio, idkey_credito, nombre, fecha_creacion as fecha_creacion, monto, desc_tipo, desc_estatus, estatus, idkey_clientes FROM view_creditos order by folio asc";
            $data = $oconns->getRows($query);
            $rows = array();
            foreach ($data as $item){ 
                $jsonArrayObject = (array(
                    'folio' => $item["folio"], 
                    'idkey_credito' => $item["idkey_credito"], 
                    'nombre' => $item["nombre"], 
                    'fecha_creacion' => $item["fecha_creacion"],
                    'estatus' => $item["estatus"],
                    'desc_estatus' => $item["desc_estatus"],
                    'tipo' => $item["desc_tipo"],
                    'monto' => $item["monto"],
                    'idkey_clientes' => $item["idkey_clientes"]
                ));
                $rows[] = $jsonArrayObject;
            }
            echo json_encode($rows);
        break;

        case "nuevo_cliente": //step1
            $curp = $_POST["curp"];
            $coincidencia = $oconns->getSimple("select count(idkey_cliente) from view_clientes where curp='".strtoupper($curp)."';");  
            if(intval($coincidencia) >0 )    
                $response["error"] = "El CURP indicado ya está en uso.";  
            else  {
                $response["error"] = 0;   

                //generales 
                $idkey_cliente = $_POST["idkey_cliente"];
                $nombre=$_POST["nombre"];
                $apellido_p=$_POST["apellido_p"];
                $apellido_m=$_POST["apellido_m"];

                $nacimiento = $_POST["nacimiento"];
                if(!empty($nacimiento)){
                    $temp = explode("/",$nacimiento);
                    $nacimiento = $temp[2]."-".$temp[1]."-".$temp[0];
                }
               

                $sexo=$_POST["sexo"];
                $rfc=$_POST["rfc"];
                $curp=$_POST["curp"];
                // domicilio principal
                $domicilio = preg_replace("/[\r\n|\n|\r]+/", PHP_EOL, $_POST["domicilio"]);
                $exterior=$_POST["exterior"];
                $interior=$_POST["interior"];
               
                $inicia_habitar = $_POST["inicia_habitar"];
                if(!empty($inicia_habitar)){
                    $temp = explode("/",$inicia_habitar);
                    $inicia_habitar = $temp[2]."-".$temp[1]."-".$temp[0];
                }

                $entrecalles=$_POST["entrecalles"];
                $referencia=$_POST["referencia"];
                $observaciones=$_POST["observaciones"];
                $estados=$_POST["estados"];
                $municipios=$_POST["municipios"];
                $localidad=$_POST["localidad"];
                $codigo_postal=$_POST["codigo_postal"];
                // identificaciones By Moshe Ramz
                $identif = $_POST["identificacion"];
                $num_id = $_POST["num_id"];

                $vigencia = $_POST["vigencia"];
                if(!empty($vigencia)){
                    $temp = explode("/",$vigencia);
                    $vigencia = $temp[2]."-".$temp[1]."-".$temp[0];
                }

                $prioridad = 1; //es el contacto principal
                $tipo_dir=$_POST["tipo_direccion"];

            
                //insert en generales
                $oconns->ShotSimple("insert into generales(nombre,apellido_p,apellido_m,fecha_nacimiento,idkey_sexo,rfc,curp) values('".$nombre."','".$apellido_p."','".$apellido_m."','".$nacimiento."','".$sexo."','".strtoupper($rfc)."','".strtoupper($curp)."');");
                $idkey_datos_generales=$oconns->last_id;
                
                //insert a clientes
                $oconns->ShotSimple("insert into clientes(idkey_generales,idkey_usuario, porcentaje_perfil) values ('".$idkey_datos_generales."','".$idkey_usuario."', 0.1);"); //10% de avance            
                $idkey_cliente_generado=$oconns->last_id;
                
                // insert a identificaciones
                $oconns->ShotSimple("insert into clientes_identificaciones(idkey_identificacion, numero, vigencia, idkey_clientes)values('".$identif."', '".$num_id."', '".$vigencia."', '".$idkey_cliente_generado."');");

                //insert a direcciones
                $oconns->ShotSimple("insert into direcciones(domicilio,exterior,interior,idkey_estados,idkey_municipios,idkey_localidad,idkey_codigo_postal,fecha_habita,entrecalles,referencia,observacion, idkey_cliente, prioridad, idkey_tipo_direccion) values('".
                    $domicilio."','".$exterior."','".$interior."','".$estados."','".$municipios."','".$localidad."','".$codigo_postal."','".$inicia_habitar."','".$entrecalles."','".$referencia."','".$observaciones."',".$idkey_cliente_generado.", ".$prioridad.",".$tipo_dir.");");
                $idkey_datos_direcciones=$oconns->last_id;
                

                $response["idkey_cliente"] =  $idkey_cliente_generado;

            }    
            
            echo json_encode($response);
        break;

        case "consulta_cliente_step1":
            $idkey_cliente = $_POST["idkey_cliente"];
            $query = "select idkey_cliente, nombre_pila as nombre,apellido_p, apellido_m, DATE_FORMAT(fecha_nacimiento,'%d/%m/%Y') as fecha_nacimiento,curp, rfc,idkey_sexo, idkey_tipo_identificacion, no_identificacion, DATE_FORMAT(vigencia_identificacion,'%d/%m/%Y') as vigencia_identificacion, porcentaje_perfil, DATE_FORMAT(fecha_creacion,'%d/%m/%Y') as fecha_creacion FROM view_clientes where idkey_cliente = ".$idkey_cliente;
            $data = $oconns->getRows($query);

            $rows = array();
            
            if($oconns->numberRows > 0) {
                $response['error'] = 0;

                //Consulta direccion principal
                $query2 = "select idkey_direccion, domicilio, interior, exterior,idkey_estado, idkey_mpio, idkey_localidad,idkey_cp, DATE_FORMAT(fecha_habita,'%d/%m/%Y') as fecha_habita, entrecalles, referencia, observacion, prioridad, idkey_tipo_direccion from view_direcciones where idkey_cliente=".$idkey_cliente." and prioridad = 1 ";
                $data2 = $oconns->getRows($query2);

                $response['idkey_cliente'] = $data[0]["idkey_cliente"];
                $response['nombre'] = $data[0]["nombre"];
                $response['apellido_p'] = $data[0]["apellido_p"]; 
                $response['apellido_m'] = $data[0]["apellido_m"]; 
                $response['fnac'] = $data[0]["fecha_nacimiento"];
                $response['sexo'] = $data[0]["idkey_sexo"];
                $response['fecha_creacion'] = $data[0]["fecha_creacion"];
                $response['curp'] = $data[0]["curp"];
                $response['rfc'] = $data[0]["rfc"];
                $response['idtipo_ide'] = $data[0]["idkey_tipo_identificacion"];
                $response['num_id'] = $data[0]["no_identificacion"];
                $response['vigencia'] = $data[0]["vigencia_identificacion"];
                $response['porcentaje_perfil'] = $data[0]["porcentaje_perfil"];

                $response['idkey_direccion'] = $data2[0]["idkey_direccion"]; 
                $response['domicilio'] = $data2[0]["domicilio"];
                $response['interior'] = $data2[0]["interior"];
                $response['exterior'] = $data2[0]["exterior"];
                $response['idkey_estado'] = $data2[0]["idkey_estado"];
                $response['idkey_mpio'] = $data2[0]["idkey_mpio"];
                $response['idkey_loc'] = $data2[0]["idkey_localidad"];
                $response['idkey_cp'] = $data2[0]["idkey_cp"];
                $response['fecha_habita'] = $data2[0]["fecha_habita"];
                $response['entrecalles'] = $data2[0]["entrecalles"];
                $response['referencia'] = $data2[0]["referencia"];
                $response['observacion'] = $data2[0]["observacion"];
                $response['prioridad'] = $data2[0]["prioridad"];
                $response['tipo_direccion'] = $data2[0]["idkey_tipo_direccion"];
                $response['mpios_edo']  = obtener_mpios($data2[0]["idkey_estado"], $data2[0]["idkey_mpio"]);
                $response['locs_mpio']  = obtener_localidades($data2[0]["idkey_mpio"], $data2[0]["idkey_localidad"]);
                $response['cps_loc']  = obtener_cps($data2[0]["idkey_localidad"], $data2[0]["idkey_cp"]);

            }
            else{
                $response['error'] = "Error: No se ha encontrado al cliente indicado";
            }
            
            echo json_encode($response);
        break;

        case "editar_cliente_step1": //step1
            $idkey_cliente = $_POST["idkey_cliente"];
            $curp = $_POST["curp"];
            $coincidencia = $oconns->getSimple("select count(idkey_cliente) from view_clientes where curp='".strtoupper($curp)."' and idkey_cliente != ".$idkey_cliente.";");  
            if(intval($coincidencia) >0 )    
                $response["error"] = "El CURP indicado ya está en uso.";  
            else  {
                $response["error"] = 0;   

                //generales 
                $nombre=$_POST["nombre"];
                $apellido_p=$_POST["apellido_p"];
                $apellido_m=$_POST["apellido_m"];

                $temp = explode("/",$_POST["nacimiento"]);
                $nacimiento = $temp[2]."-".$temp[1]."-".$temp[0];

                $sexo=$_POST["sexo"];
                $rfc=$_POST["rfc"];
                $curp=$_POST["curp"];
                // domicilio principal
                $domicilio = preg_replace("/[\r\n|\n|\r]+/", PHP_EOL, $_POST["domicilio"]);
                $exterior=$_POST["exterior"];
                $interior=$_POST["interior"];

                $temp = explode("/",$_POST["inicia_habitar"]);
                $inicia_habitar = $temp[2]."-".$temp[1]."-".$temp[0];

                $entrecalles=$_POST["entrecalles"];
                $referencia=$_POST["referencia"];
                $observaciones=$_POST["observaciones"];
                $estados=$_POST["estados"];
                $municipios=$_POST["municipios"];
                $localidad=$_POST["localidad"];
                $codigo_postal=$_POST["codigo_postal"];
                // identificaciones By Moshe Ramz
                $identif = $_POST["identificacion"];
                $num_id = $_POST["num_id"];

                $temp = explode("/",$_POST["vigencia"]);
                $vigencia = $temp[2]."-".$temp[1]."-".$temp[0];

                $prioridad = 1; //es el contacto principal
                $tipo_dir=$_POST["tipo_direccion"];

            
                //update en generales
                $oconns->ShotSimple("update generales ge, clientes cli, clientes_identificaciones ci, direcciones di set ge.nombre ='$nombre', ge.apellido_p = '$apellido_p', ge.apellido_m = '$apellido_m', ge.fecha_nacimiento = '$nacimiento', ge.idkey_sexo ='$sexo', ge.rfc = '$rfc', ge.curp = '$curp', ci.idkey_identificacion ='$identif', ci.numero = '$num_id', ci.vigencia ='$vigencia', di.domicilio ='$domicilio', di.interior='$interior', di.exterior='$exterior', di.idkey_estados='$estados', di.idkey_municipios='$municipios', di.idkey_localidad='$localidad', di.idkey_codigo_postal='$codigo_postal', di.fecha_habita='$inicia_habitar', di.entrecalles = '$entrecalles', di.referencia='$referencia',  di.observacion='$observaciones', di.idkey_tipo_direccion='$tipo_dir' where cli.idkey_generales = ge.idkey and ci.idkey_clientes = cli.idkey and di.idkey_cliente=cli.idkey and di.prioridad=1 and cli.idkey = '$idkey_cliente'");

            }    
            
            echo json_encode($response);
        break;

        case "cliente_datos_adic": //step2 inserción y act
         
            $idkey_cliente = $_POST["idkey_cliente"];
            $estado_civil = $_POST["estado_civil"];
            $nivel_academico = $_POST["nivel_academico"];
            if(isset($_POST["indigena"])) $indigena = 1; else $indigena = 0;
            if(isset($_POST["penales"])) $penales = 1; else $penales = 0;
            if(isset($_POST["politica"])) $politica = 1; else $politica = 0;
            $dependientes = $_POST["dependientes"];
            $regimen_fiscal=$_POST["regimen_fiscal"];

            

            $fecha_sat = $_POST["fecha_sat"];
            if(!empty($fecha_sat)){
               $temp = explode("/",$fecha_sat);
               $fecha_sat = $temp[2]."-".$temp[1]."-".$temp[0];
            }
             $response["fecha_sat"] = $fecha_sat;

            $email_facturacion=$_POST["email_facturacion"];
            $domicilio_fiscal=$_POST["domicilio_fiscal"];
            $fiel=$_POST["fiel"];
            $cedula=$_POST["cedula"];
            $id_cargo=$_POST["id_cargo"];


            $inicio_cargo = $_POST["inicio_cargo"];
            if($inicio_cargo != ""){
               $temp = explode("/",$inicio_cargo);
               $inicio_cargo = $temp[2]."-".$temp[1]."-".$temp[0];
            }
           

            $fin_cargo = $_POST["fin_cargo"];
            if(!empty($fin_cargo)){
               $temp = explode("/",$fin_cargo);
               $fin_cargo = $temp[2]."-".$temp[1]."-".$temp[0];
            }


            $response["error"] = 0;

            $coincidencia = $oconns->getSimple("select count(idkey) from clientes_datos_adicionales where idkey_clientes='".$idkey_cliente."';");
    
            //nuevos datos adicionales
            if($coincidencia == 0 )  {
                $oconns->ShotSimple("insert into clientes_datos_adicionales(idkey_estado_civil, idkey_nivel_academico, indigena, penales, politica, dependientes, idkey_clientes, idkey_regimen_fiscal, fecha_sat, correo_facturacion, domicilio_fiscal, fiel,cedula, id_cargo, inicio_cargo, fin_cargo) values ('".$estado_civil."','".$nivel_academico."','".$indigena."','".$penales."','".$politica."','".$dependientes."','".$idkey_cliente."','".$regimen_fiscal."','".$fecha_sat."','".$email_facturacion."','".$domicilio_fiscal."','".$fiel."','".$cedula."','".$id_cargo."','".$inicio_cargo."','".$fin_cargo."');");

            }  
            //actualización
            else {
                $oconns->ShotSimple("update clientes_datos_adicionales set 
                        idkey_estado_civil='".$estado_civil."',
                        idkey_nivel_academico='".$nivel_academico."',
                        indigena='".$indigena."',
                        penales='".$penales."',
                        politica='".$politica."',
                        dependientes='".$dependientes."',
                        idkey_regimen_fiscal='".$regimen_fiscal."',
                        fecha_sat='".$fecha_sat."',
                        correo_facturacion='".$email_facturacion."',
                        domicilio_fiscal='".$domicilio_fiscal."',
                        fiel='".$fiel."',
                        cedula='".$cedula."',
                        inicio_cargo='".$inicio_cargo."',
                        id_cargo='".$id_cargo."',
                        fin_cargo='".$fin_cargo."' where idkey_clientes='".$idkey_cliente."';");
            }    
            
            echo json_encode($response);
        break;

         case "consulta_cliente_step2":
            $idkey_cliente = $_POST["idkey_cliente"];
            $query = "select idkey_estado_civil, idkey_nivel_academico, indigena, penales, politica, dependientes, idkey_clientes, idkey_regimen_fiscal, DATE_FORMAT(fecha_sat,'%d/%m/%Y') as fecha_sat, correo_facturacion, domicilio_fiscal, fiel,cedula, id_cargo, DATE_FORMAT(inicio_cargo,'%d/%m/%Y') as inicio_cargo, DATE_FORMAT(fin_cargo,'%d/%m/%Y') as fin_cargo from clientes_datos_adicionales where idkey_clientes = ".$idkey_cliente;
            
            $data = $oconns->getRows($query);
            $response["n"] = count($data);
            
            if(intval(count($data)) > 0 ){
                $response['encontrado'] = "true";
                $response['idkey_estado_civil'] = $data[0]["idkey_estado_civil"];
                $response['idkey_nivel_academico'] = $data[0]["idkey_nivel_academico"];
                $response['indigena'] = $data[0]["indigena"]; 
                $response['penales'] = $data[0]["penales"];  
                $response['politica'] = $data[0]["politica"];  
                $response['dependientes'] = $data[0]["dependientes"];  
                $response['idkey_regimen_fiscal'] = $data[0]["idkey_regimen_fiscal"];  
                if($data[0]["fecha_sat"]=="00/00/0000")
                    $response['fecha_sat'] = '';
                else
                    $response['fecha_sat'] = $data[0]["fecha_sat"];
                $response['correo_facturacion'] = $data[0]["correo_facturacion"];  
                $response['domicilio_fiscal'] = $data[0]["domicilio_fiscal"];
                $response['fiel'] = $data[0]["fiel"]; 
                $response['cedula'] = $data[0]["cedula"]; 
                $response['id_cargo'] = $data[0]["id_cargo"];
                if($data[0]["inicio_cargo"]=="00/00/0000") 
                    $response['inicio_cargo'] = ''; 
                else 
                    $response['inicio_cargo'] = $data[0]["inicio_cargo"]; 
                if($data[0]["fin_cargo"]=="00/00/0000") 
                    $response['fin_cargo'] = '';
                else
                    $response['fin_cargo'] = $data[0]["fin_cargo"];
            }
            else
                $response['encontrado'] = "false";
            
            echo json_encode($response);
        break;

        case "cliente_socioeconomico": //step3 inserción y act

            $idkey_cliente = $_POST["idkey_cliente"];
            if(isset($_POST["agua"])) $agua = 1; else $agua = 0;
            if(isset($_POST["electri"])) $electri = 1; else $electri = 0;
            if(isset($_POST["telefono"])) $telefono = 1; else $telefono = 0;
            if(isset($_POST["ant_cable"])) $ant_cable = 1; else $ant_cable = 0;
            if(isset($_POST["drenaje"])) $drenaje = 1; else $drenaje = 0;

            //electros
            if(isset($_POST["estufa"])) $estufa = 1; else $estufa = 0;
            if(isset($_POST["lavadora"])) $lavadora = 1; else $lavadora = 0;
            if(isset($_POST["refri"])) $refri = 1; else $refri = 0;
            if(isset($_POST["tele"])) $tele = 1; else $tele = 0;
            if(isset($_POST["estereo"])) $estereo = 1; else $estereo = 0;
            if(isset($_POST["compu"])) $compu = 1; else $compu = 0;
            //habitaciones
            if(isset($_POST["sala"])) $sala = 1; else $sala = 0;
            if(isset($_POST["comedor"])) $comedor = 1; else $comedor = 0;
            if(isset($_POST["cocina"])) $cocina = 1; else $cocina = 0;
            if(isset($_POST["bano_p"])) $bano_p = 1; else $bano_p = 0;
            //Detalles
            $servicios_detalle=$_POST["servicios_detalle"];
            $electro_detalle=$_POST["electro_detalle"];
            $habitaciones_detalle=$_POST["habitaciones_detalle"];
            $vivienda_detalle=$_POST["vivienda_detalle"];
            $hacinamiento_detalle=$_POST["hacinamiento_detalle"];
            $techo_detalle=$_POST["techo_detalle"];
            $material_detalle=$_POST["material_detalle"];
            $piso_detalle=$_POST["piso_detalle"];
            //
            $residentes=$_POST["residentes"];
            $observaciones=$_POST["observaciones_socioeconomico"];
            $vivienda=$_POST["vivienda"];
            $hacinamiento=$_POST["hacinamiento"];
            $techo=$_POST["techo"];
            $material=$_POST["material"];
            $piso=$_POST["piso"];

            $response["error"] = 0;

            $coincidencia = $oconns->getSimple("select count(idkey) from clientes_socio_economico where idkey_clientes='".$idkey_cliente."';");
    
            $response["coincidencia"] = $coincidencia;
            //nuevo
            if($coincidencia == 0 )  {
                $oconns->ShotSimple("insert into clientes_socio_economico (servicios_agua, servicios_electricidad, servicios_telefono, servicios_drenaje, servicios_antena, servicios_detalle, idkey_tipo_vivienda,tipo_vivienda_detalle, idkey_material,  material_detalle,  electro_estufa, electro_lavadora, electro_refri,electro_tele, electro_estereo, electro_compu, electro_detalle, idkey_hacinamiento, hacinamiento_detalle, idkey_piso, piso_detalle, habitacion_sala, habitacion_comedor, habitacion_cocina, habitacion_bano, habitacion_detalle, residentes, idkey_techo, techo_detalle, observaciones, idkey_clientes) values
                    ('".$agua."','".$electri."','".$telefono."','".$drenaje."','".$ant_cable."','".$servicios_detalle."','".$vivienda."','".$vivienda_detalle."','".$material."','".$material_detalle."','".$estufa."','".$lavadora."','".$refri."','".$tele."','".$estereo."','".$compu."','".$electro_detalle."','".$hacinamiento."','".$hacinamiento_detalle."','".$piso."','".$piso_detalle."','".$sala."','".$comedor."','".$cocina."','".$bano_p."','".$habitaciones_detalle."','".$residentes."','".$techo."','".$techo_detalle."','".$observaciones."','".$idkey_cliente."');");

            }  
            //actualización
            else {
                
                 $oconns->ShotSimple("update clientes_socio_economico set servicios_agua='".$agua."', servicios_electricidad ='".$electri."', servicios_telefono='".$telefono."', servicios_drenaje='".$drenaje."', servicios_antena='".$ant_cable."', servicios_detalle='".$servicios_detalle."',  idkey_tipo_vivienda='".$vivienda."', tipo_vivienda_detalle='".$vivienda_detalle."', idkey_material='".$material."', material_detalle = '".$material_detalle."', electro_estufa ='".$estufa."', electro_lavadora='".$lavadora."', electro_refri ='".$refri."', electro_tele='".$tele."', electro_estereo='".$estereo."', electro_compu='".$compu."', electro_detalle='".$electro_detalle."', idkey_hacinamiento='".$hacinamiento."', hacinamiento_detalle='".$hacinamiento_detalle."', idkey_piso='".$piso."',  piso_detalle='".$piso_detalle."', habitacion_sala='".$sala."', habitacion_comedor='".$comedor."',  habitacion_cocina='".$cocina."', habitacion_bano='".$bano_p."',  habitacion_detalle='".$habitaciones_detalle."', residentes='".$residentes."', idkey_techo='".$techo."', techo_detalle='".$techo_detalle."', observaciones='".$observaciones."' where idkey_clientes='".$idkey_cliente."' ;");
               
            }    
            
            echo json_encode($response);
        break;

        case "consulta_cliente_step3":
            $idkey_cliente = $_POST["idkey_cliente"];
            
            $query = "select * from clientes_socio_economico where idkey_clientes = ".$idkey_cliente;
            
            $data = $oconns->getRows($query);
            $response["n"] = count($data);
            
            if(intval(count($data)) > 0 ){
                $response['encontrado'] = "true";

                $response['agua'] = $data[0]["servicios_agua"];
                $response['electri'] = $data[0]["servicios_electricidad"];
                $response['telefono'] = $data[0]["servicios_telefono"];
                $response['drenaje'] = $data[0]["servicios_drenaje"];
                $response['ant_cable'] = $data[0]["servicios_antena"];
                $response['servicios_detalle'] = $data[0]["servicios_detalle"];
                $response['vivienda'] = $data[0]["idkey_tipo_vivienda"];
                $response['vivienda_detalle'] = $data[0]["tipo_vivienda_detalle"];
                $response['material'] = $data[0]["idkey_material"];
                $response['material_detalle'] = $data[0]["material_detalle"];
                $response['estufa'] = $data[0]["electro_estufa"];
                $response['lavadora'] = $data[0]["electro_lavadora"];
                $response['refri'] = $data[0]["electro_refri"];
                $response['tele'] = $data[0]["electro_tele"];
                $response['estereo'] = $data[0]["electro_estereo"];
                $response['compu'] = $data[0]["electro_compu"];
                $response['electro_detalle'] = $data[0]["electro_detalle"];
                $response['hacinamiento'] = $data[0]["idkey_hacinamiento"];
                $response['hacinamiento_detalle'] = $data[0]["hacinamiento_detalle"];
                $response['piso'] = $data[0]["idkey_piso"];
                $response['piso_detalle'] = $data[0]["piso_detalle"];
                $response['sala'] = $data[0]["habitacion_sala"];
                $response['comedor'] = $data[0]["habitacion_comedor"];
                $response['cocina'] = $data[0]["habitacion_cocina"];
                $response['bano_p'] = $data[0]["habitacion_bano"];
                $response['habitaciones_detalle'] = $data[0]["habitacion_detalle"];
                $response['residentes'] = $data[0]["residentes"];
                $response['techo'] = $data[0]["idkey_techo"];
                $response['techo_detalle'] = $data[0]["techo_detalle"];
                $response['observaciones'] = $data[0]["observaciones"];
            }
            else
                $response['encontrado'] = "false";
            
            echo json_encode($response);
        break;

        case "borrar_mueble":
            if(isset($_POST['idkey_mueble'])){
                $idkey_mueble = $_POST["idkey_mueble"];
                $oconns = new database();
                
                $oconns->ShotSimple("delete from garantias_mueble where idkey='".$idkey_mueble."';");
                $response['error'] = 0;
            }
            else $response['error'] = 1;
            echo json_encode($response);
        break;

        case "borrar_inmueble":
            if(isset($_POST['idkey_inmueble'])){
                $idkey_inmueble = $_POST["idkey_inmueble"];
                $oconns = new database();
                
                $oconns->ShotSimple("delete from garantias_inmueble where idkey='".$idkey_inmueble."';");
                $response['error'] = 0;
            }
            else $response['error'] = 1;
            echo json_encode($response);
        break;

        case "datatable_domicilios":
            $oconns = new database();
            $idkey_cliente = $_POST["idkey_cliente"];
            $data = $oconns->getRows("select idkey_direccion, nombre_tipo_dir as tipo, DATE_FORMAT(fecha_habita,'%d/%m/%Y') as fecha_habita, observacion, concat('Calle ',d.domicilio,', Int. ',d.interior,' Ext. ',d.exterior,', C.P. ', d.nombre_cp,', Municipio ',d.nombre_mpio,', ',d.nombre_edo) as direccion from view_direcciones d where prioridad=0 and idkey_cliente =".$idkey_cliente." order by idkey_direccion asc");
            $response = array();
            if ($oconns->numberRows>0){
                foreach ($data as $item){ 
                    $idkey_direccion = $item["idkey_direccion"];
                    $acciones =  '<a href="#" class="btn radius-1 btn-sm btn-brc-tp btn-outline-default btn-h-outline-primary btn-a-outline-primary btn-text-primary" data-toggle="modal" data-target="#modalDirecciones" title="Editar" onclick="cargar_dir('.$idkey_direccion.')"><i class="fa fa-pencil-alt"></i></a>'.
                        '<a href="#" class="btn radius-1 btn-sm btn-brc-tp btn-outline-default btn-h-outline-danger btn-a-outline-danger btn-text-danger" title="Eliminar" onclick="eliminar_dir('.$idkey_direccion.')">
                         <i class="fa fa-trash-alt"></i></a>';
                    $jsonArrayObject = (array(
                        'tipo' => $item["tipo"], 
                        'fecha_habita' => $item["fecha_habita"], 
                        'observacion' => $item["observacion"],
                        'direccion' => $item["direccion"],
                        'acciones' => $acciones
                    ));
                    $response[] = $jsonArrayObject;
                }
            }
            echo json_encode($response);
        break;

        case "domicilio_adicional":
            $response["error"] = 0; 

            $idkey_cliente = $_POST["idkey_cliente"];
            $idkey_direccion = $_POST["idkey_direccion1"];

            $domicilio = preg_replace("/[\r\n|\n|\r]+/", PHP_EOL, $_POST["domicilio1"]);
            $exterior=$_POST["exterior1"];
            $interior=$_POST["interior1"];
           
            $inicia_habitar = $_POST["inicia_habitar1"];
            if(!empty($inicia_habitar)){
                $temp = explode("/",$inicia_habitar);
                $inicia_habitar = $temp[2]."-".$temp[1]."-".$temp[0];
            }

            $entrecalles=$_POST["entrecalles1"];
            $referencia=$_POST["referencia1"];
            $observaciones=$_POST["observaciones1"];
            $estados=$_POST["estados1"];
            $municipios=$_POST["municipios1"];
            $localidad=$_POST["localidad1"];
            $codigo_postal=$_POST["codigo_postal1"];
            $prioridad = 0; //Domic adicional
            $tipo_dir=$_POST["tipo_direccion1"];


            //Se averigua si se trata de una alta o una edición
            if($idkey_direccion != ""){
                $oconns->ShotSimple("update direcciones di set  di.domicilio ='$domicilio', di.interior='$interior', di.exterior='$exterior', di.idkey_estados='$estados', di.idkey_municipios='$municipios', di.idkey_localidad='$localidad', di.idkey_codigo_postal='$codigo_postal', di.fecha_habita='$inicia_habitar', di.entrecalles = '$entrecalles', di.referencia='$referencia',  di.observacion='$observaciones', di.idkey_tipo_direccion='$tipo_dir' where di.idkey = '$idkey_direccion'");
            }
            else {
                $oconns->ShotSimple("insert into direcciones(domicilio,exterior,interior,idkey_estados,idkey_municipios,idkey_localidad,idkey_codigo_postal,fecha_habita,entrecalles,referencia,observacion, idkey_cliente, prioridad, idkey_tipo_direccion) values('".
                $domicilio."','".$exterior."','".$interior."','".$estados."','".$municipios."','".$localidad."','".$codigo_postal."','".$inicia_habitar."','".$entrecalles."','".$referencia."','".$observaciones."',".$idkey_cliente.", ".$prioridad.",".$tipo_dir.");");
            
                $idkey_direccion=$oconns->last_id;
            }
            
            if($idkey_direccion != ""){
                $response["idkey_direccion"] =  $idkey_direccion;
                $response["error"] = 0;   
            }
            else $response["error"] = "Ha ocurrido un error inesperado. Inténtelo más tarde.";  
            
            echo json_encode($response);
        break;


        case "borrar_domicilio":
            if(isset($_POST['idkey_direccion'])){
                $idkey_direccion = $_POST["idkey_direccion"];
                $oconns->ShotSimple("delete from direcciones where idkey='".$idkey_direccion."';");
                $response['error'] = 0;
            }
            else $response['error'] = 1;
            echo json_encode($response);
        break;

        case "consulta_domicilio_adic":
            $idkey_direccion = $_POST["idkey_direccion"];

            $query = "select idkey_direccion, domicilio, interior, exterior,idkey_estado, idkey_mpio, idkey_localidad,idkey_cp, DATE_FORMAT(fecha_habita,'%d/%m/%Y') as fecha_habita, entrecalles, referencia, observacion, prioridad, idkey_tipo_direccion from view_direcciones where idkey_direccion=".$idkey_direccion; //aparecerá primero la de prioridad 1
            $data = $oconns->getRows($query);
           
            $rows = array();
            
            if($oconns->numberRows > 0) {
                $response['error'] = 0;
                $response['idkey_direccion'] = $data[0]["idkey_direccion"];
                $response['domicilio'] = $data[0]["domicilio"];
                $response['interior'] = $data[0]["interior"];
                $response['exterior'] = $data[0]["exterior"];
                $response['idkey_estado'] = $data[0]["idkey_estado"];
                $response['idkey_mpio'] = $data[0]["idkey_mpio"];
                $response['idkey_loc'] = $data[0]["idkey_localidad"];
                $response['idkey_cp'] = $data[0]["idkey_cp"];
                $response['fecha_habita'] = $data[0]["fecha_habita"];
                $response['entrecalles'] = $data[0]["entrecalles"];
                $response['referencia'] = $data[0]["referencia"];
                $response['observacion'] = $data[0]["observacion"];
                $response['prioridad'] = $data[0]["prioridad"];
                $response['tipo_direccion'] = $data[0]["idkey_tipo_direccion"];
                $response['mpios_edo']  = obtener_mpios($data[0]["idkey_estado"], $data[0]["idkey_mpio"]);
                $response['locs_mpio']  = obtener_localidades($data[0]["idkey_mpio"], $data[0]["idkey_localidad"]);
                $response['cps_loc']  = obtener_cps($data[0]["idkey_localidad"], $data[0]["idkey_cp"]);
            }
            else
                $response['error'] = "Error: No se ha encontrado el domicilio indicado";
            echo json_encode($response);
        break;

         case "cargar_dom_fiscales":
            $idkey_cliente = $_POST["idkey_cliente"];
            $data = $oconns->getRows("select concat('Calle ',d.domicilio,', Int. ',d.interior,' Ext. ',d.exterior,', C.P. ', d.nombre_cp,', Municipio ',d.nombre_mpio,', ',d.nombre_edo) as direccion from view_direcciones d where idkey_cliente = '".$idkey_cliente."';");
            $res ="";
            foreach ($data as $item){
                $res.= "<option value='".$item["direccion"]."'></option>";
            }
            $response['domicilios'] = $res;
            echo json_encode($response);
        break;

        case "datatable_ingresos":
            $idkey_cliente = $_POST["idkey_cliente"];
            $data = $oconns->getRows("select ci.*, it.nombre as tipo_i, f.nombre as frec, emp.nombre as empleador,TIMESTAMPDIFF(YEAR, inicio, fin) AS arraigo_laboral, inicio, fin from clientes_ingresos as ci inner join ingresos_tipos as it on it.idkey = ci.id_tipo_ingreso inner join frecuencia f on f.idkey = ci.id_frecuencia inner join ingresos_empleador emp on ci.id_empleador = emp.idkey where idkey_clientes=".$idkey_cliente." order by ci.idkey asc;");
            $response = array();
            if ($oconns->numberRows>0){
                foreach ($data as $item){ 
                    $idkey_ingreso = $item["idkey"];
                    $acciones =  '<a href="#" class="btn radius-1 btn-sm btn-brc-tp btn-outline-default btn-h-outline-primary btn-a-outline-primary btn-text-primary" data-toggle="modal" data-target="#modalIngresos" title="Editar" onclick="cargar_ingreso('.$idkey_ingreso.')"><i class="fa fa-pencil-alt"></i></a>'.
                        '<a href="#" class="btn radius-1 btn-sm btn-brc-tp btn-outline-default btn-h-outline-danger btn-a-outline-danger btn-text-danger" title="Eliminar" onclick="eliminar_ingreso('.$idkey_ingreso.')">
                         <i class="fa fa-trash-alt"></i></a>';
                    if($item["bajo_contrato"] == '1') $bajo_contrato = 'Sí'; else $bajo_contrato='No';

                    //Para cuando el empleo no tiene fecha de fin
                    if($item["arraigo_laboral"] ==""){
                        $temp = $oconns->getRows("select TIMESTAMPDIFF(YEAR, '".$item["inicio"]."', CURDATE()) AS arraigo_laboral");
                        $arraigo_laboral = $temp[0]["arraigo_laboral"];
                    }
                    else $arraigo_laboral =$item["arraigo_laboral"];
                    $jsonArrayObject = (array(
                        'empleador' => $item["empleador"], 
                        'tipo_ingreso' => $item["tipo_i"], 
                        'monto_ingreso' => $item["monto"],
                        'frecuencia_ingreso' => $item["frec"],
                        'bajo_contrato' => $bajo_contrato,
                        'arraigo_laboral' => $arraigo_laboral,
                        'acciones' => $acciones
                    ));
                    $response[] = $jsonArrayObject;
                }
            }
            echo json_encode($response);
        break;

        case "ingreso":
            $response["error"] = 0; 

            $idkey_cliente = $_POST["idkey_cliente"];
            $idkey_ingreso = $_POST["idkey_ingreso"];

            if(isset($_POST["principal"])) $principal = 1; else $principal = 0;
            $ingreso_tipo = $_POST["ingreso_tipo"];
            $ingreso_frec = $_POST["ingreso_frec"];
            $monto = $_POST["monto"];
            $empleador = $_POST["id_empleador"];
            $temp_1 = explode("/",$_POST["f_inicio"]);
            $fecha_inicio = $temp_1[2]."-".$temp_1[1]."-".$temp_1[0];
            if(isset($_POST["f_fin"])){
                if($_POST["f_fin"] != ""){
                    $temp_2 = explode("/",$_POST["f_fin"]);
                    $fecha_fin = $temp_2[2]."-".$temp_2[1]."-".$temp_2[0];
                }
                else $fecha_fin="";
            }
            else $fecha_fin="";
            $profesion = $_POST["profesion"];
            $ocupacion = $_POST["ocupacion"];
            $jefe_directo = $_POST["jefe_directo"];
            if(isset($_POST["bajo_contrato"])) $bajo_contrato = 1; else $bajo_contrato = 0;
            $ingreso_desc = $_POST["ingreso_desc"];
            $domicilio_empleador = $_POST["domicilio_empleador"];

            //selects opcionales
            if(isset($_POST["actividad_siti"])) $id_siti = $_POST["actividad_siti"];
            else $id_siti ="";
            if(isset($_POST["ingreso_comprobable"]))
                $ingreso_comprobable = $_POST["ingreso_comprobable"];
            else $ingreso_comprobable ="";

            //Se averigua si se trata de una alta o una edición
            if($idkey_ingreso != ""){
                $oconns->ShotSimple("update clientes_ingresos set principal='$principal', id_tipo_ingreso='$ingreso_tipo', id_frecuencia='$ingreso_frec', monto='$monto', id_empleador='$empleador', inicio='$fecha_inicio', fin='$fecha_fin', profesion='$profesion', ocupacion='$ocupacion', jefe_directo='$jefe_directo', bajo_contrato='$bajo_contrato', ingreso_desc= '$ingreso_desc', id_siti='$id_siti', comprobacion='$ingreso_comprobable', domicilio_empleador ='$domicilio_empleador' where idkey='$idkey_ingreso' ;");
            }
            else {
                $oconns->ShotSimple("insert into clientes_ingresos (principal, id_tipo_ingreso, id_frecuencia,monto, id_empleador, inicio,fin, profesion, ocupacion, jefe_directo,bajo_contrato,idkey_clientes,ingreso_desc,id_siti,domicilio_empleador,comprobacion) values ('$principal', '$ingreso_tipo','$ingreso_frec','$monto','$empleador','$fecha_inicio','$fecha_fin','$profesion','$ocupacion','$jefe_directo','$bajo_contrato','$idkey_cliente','$ingreso_desc','$id_siti','$domicilio_empleador','$ingreso_comprobable');"); 
            
                $idkey_ingreso=$oconns->last_id;
            }
            
            if($idkey_ingreso != ""){
                $response["idkey_ingreso"] =  $idkey_ingreso;
                $response["error"] = 0;   
            }
            else $response["error"] = "Ha ocurrido un error inesperado. Inténtelo más tarde.";  
            
            echo json_encode($response);
        break;

        case "consulta_ingreso":
            $idkey_ingreso = $_POST["idkey_ingreso"];
            $data = $oconns->getRows("select ci.*, DATE_FORMAT(inicio,'%d/%m/%Y') as f_inicio, DATE_FORMAT(fin,'%d/%m/%Y') as f_fin, it.nombre as tipo_i, f.nombre as frec, emp.nombre as empleador from clientes_ingresos as ci inner join ingresos_tipos as it on it.idkey = ci.id_tipo_ingreso inner join frecuencia f on f.idkey = ci.id_frecuencia inner join ingresos_empleador emp on ci.id_empleador = emp.idkey where ci.idkey=".$idkey_ingreso.";");
            if ($oconns->numberRows>0){
                $response['error'] = 0;
                
                $response['principal'] = $data[0]["principal"];
                $response['ingreso_tipo'] = $data[0]["id_tipo_ingreso"];
                $response['ingreso_frec'] = $data[0]["id_frecuencia"];
                $response['monto'] = $data[0]["monto"];
                $response['empleador'] = $data[0]["id_empleador"];
                $response['f_inicio'] = $data[0]["f_inicio"];
                if($data[0]["f_fin"] == "00/00/0000")
                    $response['f_fin'] = "";
                else $response['f_fin'] = $data[0]["f_fin"];
                $response['profesion'] = $data[0]["profesion"];
                $response['ocupacion'] = $data[0]["ocupacion"];
                $response['jefe_directo'] = $data[0]["jefe_directo"];
                $response['bajo_contrato'] = $data[0]["bajo_contrato"];
                $response['ingreso_desc'] = $data[0]["ingreso_desc"];
                $response['id_siti'] = $data[0]["id_siti"];

                /*
                $data1 = $oconns->getRows("select * from ingresos_domicilio_empleador where idkey_empleador='".$data[0]["id_empleador"]."';");
                $doms_empleador = "<option value=''></option>";
                foreach ($data1 as $items){            
                    if ($data[0]["id_comicilio_empleador"]==$items["idkey"])
                        $doms_empleador.= "<option value='".$items["idkey"]."' selected>".$items["domicilio"]."</option>";
                    else
                        $doms_empleador.= "<option value='".$items["idkey"]."'>".$items["domicilio"]."</option>";
                }

                $response['domicilio_empleador'] = $doms_empleador;*/
                $response['domicilio_empleador'] = $data[0]["domicilio_empleador"];
                $response['ingreso_comprobable'] = $data[0]["comprobacion"];
                
            }
            else $response['error'] = 1;
            echo json_encode($response);
        break;

        case "borrar_ingreso":
            if(isset($_POST['idkey_ingreso'])){
                $idkey_ingreso = $_POST["idkey_ingreso"];
                $oconns->ShotSimple("delete from clientes_ingresos where idkey='".$idkey_ingreso."';");
                $response['error'] = 0;
            }
            else $response['error'] = 1;
            echo json_encode($response);
        break;

        case "datatable_contactos":
            $idkey_cliente = $_POST["idkey_cliente"];
            $data = $oconns->getRows("select cc.idkey, cc.descripcion, cc.telefono, cc.email, cp.nombre as prioridad from clientes_contacto cc INNER JOIN contacto_prioridad cp on cp.idkey = cc.idkey_contacto_prioridad where cc.idkey_clientes=".$idkey_cliente.";");
            $response = array();
            if ($oconns->numberRows>0){
                foreach ($data as $item){ 
                    $idkey_contacto = $item["idkey"];
                    $acciones =  '<a href="#" class="btn radius-1 btn-sm btn-brc-tp btn-outline-default btn-h-outline-primary btn-a-outline-primary btn-text-primary" data-toggle="modal" data-target="#modalContactos" title="Editar" onclick="cargar_contacto('.$idkey_contacto.')"><i class="fa fa-pencil-alt"></i></a>'.
                        '<a href="#" class="btn radius-1 btn-sm btn-brc-tp btn-outline-default btn-h-outline-danger btn-a-outline-danger btn-text-danger" title="Eliminar" onclick="eliminar_contacto('.$idkey_contacto.')">
                         <i class="fa fa-trash-alt"></i></a>';
                    $jsonArrayObject = (array(
                        'descripcion' => $item["descripcion"], 
                        'telefono' => $item["telefono"], 
                        'email' => $item["email"],
                        'prioridad' => $item["prioridad"],
                        'acciones' => $acciones
                    ));
                    $response[] = $jsonArrayObject;
                }
            }
            echo json_encode($response);
        break;

        case "borrar_contacto":
            if(isset($_POST['idkey_contacto'])){
                $idkey_contacto = $_POST["idkey_contacto"];
                $oconns->ShotSimple("delete from clientes_contacto where idkey='".$idkey_contacto."';");
                $response['error'] = 0;
            }
            else $response['error'] = 1;
            echo json_encode($response);
        break;

        case "contacto":
            $response["error"] = 0; 

            $idkey_cliente = $_POST["idkey_cliente"];
            $idkey_contacto = $_POST["idkey_contacto"];

            $descripcion = $_POST["contacto_descripcion"];
            $telefono = $_POST["contacto_telefono"];
            $email = $_POST["contacto_email"];
            $prioridad = $_POST["contacto_prioridad"];

            //Se averigua si se trata de una alta o una edición
            if($idkey_contacto != ""){
                $oconns->ShotSimple("update clientes_contacto set descripcion='$descripcion', telefono='$telefono', email='$email', idkey_contacto_prioridad='$prioridad' where idkey='$idkey_contacto' ;");
            }
            else {
                $oconns->ShotSimple("insert into clientes_contacto (descripcion, telefono, email, idkey_contacto_prioridad, idkey_clientes) values ('$descripcion', '$telefono', '$email', '$prioridad', '$idkey_cliente');"); 
                 $response["insert"] = "insert into clientes_contactos (descripcion, telefono, email, idkey_contacto_prioridad) values ('$descripcion', '$telefono', '$email', '$prioridad');";   
            
                $idkey_contacto=$oconns->last_id;
            }
            
            if($idkey_contacto != ""){
                $response["idkey_contacto"] =  $idkey_contacto;
                $response["error"] = 0;   
            }
            else $response["error"] = "Ha ocurrido un error inesperado. Inténtelo más tarde.";  
            
            echo json_encode($response);
        break;

        case "consulta_contacto":
            $idkey_contacto = $_POST["idkey_contacto"];
            $data = $oconns->getRows("select descripcion, telefono, email, idkey_contacto_prioridad from clientes_contacto where idkey=".$idkey_contacto.";");
            if ($oconns->numberRows>0){
                $response['error'] = 0;
                $response['descripcion'] = $data[0]["descripcion"];
                $response['telefono'] = $data[0]["telefono"];
                $response['email'] = $data[0]["email"];
                $response['prioridad'] = $data[0]["idkey_contacto_prioridad"];
            }
            else $response['error'] = 1;
            echo json_encode($response);
        break;

        case "datatable_muebles":
            $idkey_cliente = $_POST["idkey_cliente"];
            $data = $oconns->getRows("select gc.idkey, gc.nombre as categoria, gm.idkey, gm.valor_comercial, gm.modelo, gm.marca, DATE_FORMAT(fecha_adquisicion,'%d/%m/%Y') as fecha_adquisicion, gm.referencia_factura,gm.observaciones, gm.cobertura from garantias_mueble gm inner join garantias_categorias gc on gc.idkey=gm.idkey_garantia_categoria where idkey_clientes=".$idkey_cliente.";");
            $response = array();
            if ($oconns->numberRows>0){
                foreach ($data as $item){ 
                    $idkey_mueble = $item["idkey"];
                    $acciones =  '<a href="#" class="btn radius-1 btn-sm btn-brc-tp btn-outline-default btn-h-outline-primary btn-a-outline-primary btn-text-primary" data-toggle="modal" data-target="#modalMuebles" title="Editar" onclick="cargar_mueble('.$idkey_mueble.')"><i class="fa fa-pencil-alt"></i></a>'.
                        '<a href="#" class="btn radius-1 btn-sm btn-brc-tp btn-outline-default btn-h-outline-danger btn-a-outline-danger btn-text-danger" title="Eliminar" onclick="eliminar_mueble('.$idkey_mueble.')">
                         <i class="fa fa-trash-alt"></i></a>';
                    $jsonArrayObject = (array(
                        'categoria' => $item["categoria"], 
                        'valor' => $item["valor_comercial"], 
                        'modelo' => $item["modelo"], 
                        'marca' => $item["marca"], 
                        'factura' => $item["referencia_factura"],
                        'fecha' => $item["fecha_adquisicion"],
                        'observaciones' => $item["observaciones"],   
                        'acciones' => $acciones
                    ));
                    $response[] = $jsonArrayObject;
                }
            }
            echo json_encode($response);
        break;

        case "consulta_mueble":
            $idkey_mueble = $_POST["idkey_mueble"];
            $data = $oconns->getRows("select valor_comercial, modelo, marca, DATE_FORMAT(fecha_adquisicion,'%d/%m/%Y') as fecha_adquisicion, referencia_factura, observaciones, idkey_garantia_categoria, cobertura from garantias_mueble where idkey=".$idkey_mueble.";");
            if ($oconns->numberRows>0){
                $response['error'] = 0;
                $response['categoria'] = $data[0]["idkey_garantia_categoria"];
                $response['valor'] = $data[0]["valor_comercial"];
                $response['marca'] = $data[0]["marca"];
                 $response['modelo'] = $data[0]["modelo"];
                $response['factura'] = $data[0]["referencia_factura"];
                $response['fecha'] = $data[0]["fecha_adquisicion"];
                $response['cobertura'] = $data[0]["cobertura"];
                $response['observaciones'] = $data[0]["observaciones"];
            }
            else $response['error'] = 1;
            echo json_encode($response);
        break;

        case "mueble": 
            $idkey_cliente = $_POST["idkey_cliente"];
            $idkey_mueble = $_POST["idkey_mueble"];
            $gc = $_POST["garantias_categorias"];
            $vc = $_POST["valor_comercial"];
            $modelo = $_POST["modelo"];
            $marca = $_POST["marca"];
            $temp = explode("/",$_POST["fecha_adquisicion"]);
            $fa = $temp[2]."-".$temp[1]."-".$temp[0];
            $rf = $_POST["referencia_factura"];
            $mo = $_POST["mueble_observaciones"];
            $cobertura = $_POST["cobertura"];

            //Se averigua si se trata de una alta o una edición
            if($idkey_mueble != ""){
                $oconns->ShotSimple("update garantias_mueble set valor_comercial='$vc', modelo='$modelo', marca='$marca', fecha_adquisicion='$fa', referencia_factura='$rf', observaciones='$mo', idkey_garantia_categoria='$gc', cobertura='$cobertura' where idkey='$idkey_mueble' ;");
            }
            else {
                $oconns->ShotSimple("insert into garantias_mueble(valor_comercial, modelo, marca,fecha_adquisicion, referencia_factura, observaciones, idkey_garantia_categoria,idkey_clientes,cobertura) values ('$vc','$modelo','$marca','$fa','$rf','$mo','$gc','$idkey_cliente','$cobertura')");

                $idkey_mueble = $oconns->last_id;
            }

            if($idkey_mueble !=""){
                $response["error"] = 0;
                $response["idkey_mueble"] = $idkey_mueble;
            }
            else 
                $response["error"] = 1;
            echo json_encode($response);
        break;

        case "datatable_inmuebles":
            $idkey_cliente = $_POST["idkey_cliente"];
            $data = $oconns->getRows("select gi.*,gc.nombre as categoria from garantias_inmueble gi inner join garantias_categorias gc on gc.idkey=gi.idkey_garantia_categoria where idkey_clientes=".$idkey_cliente.";");

            $response = array();
            if ($oconns->numberRows>0){
                foreach ($data as $item){ 
                    $idkey_inmueble = $item["idkey"];
                    $acciones =  '<a href="#" class="btn radius-1 btn-sm btn-brc-tp btn-outline-default btn-h-outline-primary btn-a-outline-primary btn-text-primary" data-toggle="modal" data-target="#modalInmuebles" title="Editar" onclick="cargar_inmueble('.$idkey_inmueble.')"><i class="fa fa-pencil-alt"></i></a>'.
                        '<a href="#" class="btn radius-1 btn-sm btn-brc-tp btn-outline-default btn-h-outline-danger btn-a-outline-danger btn-text-danger" title="Eliminar" onclick="eliminar_inmueble('.$idkey_inmueble.')">
                         <i class="fa fa-trash-alt"></i></a>';
                    if($item["escritura"] !="") 
                        $escrituras = "Con escrituras";  
                    else 
                        $escrituras = "Sin escrituras";

                    $jsonArrayObject = (array(
                        'categoria' => $item["categoria"], 
                        'valor_fiscal' => $item["valor_fiscal"], 
                        'valor_catastral' => $item["valor_catastral"], 
                        'escrituras' => $escrituras,
                        'registro' => $item["registro"],  
                        'medidas' => $item["medidas_colindacia"], 
                        'acciones' => $acciones
                    ));
                    $response[] = $jsonArrayObject;
                }
            }
            echo json_encode($response);
        break;

         case "inmueble": 
         
            $idkey_cliente = $_POST["idkey_cliente"];
            $idkey_inmueble = $_POST["idkey_inmueble"];

            $inmueble_medidas =  $_POST["inmueble_medidas"];
            $inmueble_observaciones =  $_POST["inmueble_observaciones"];
            $inmueble_descripcion =  $_POST["inmueble_descripcion"];
            $hipoteca =  $_POST["hipoteca"];
            $gravamen =  $_POST["gravamen"];
            $registro =  $_POST["registro"];
            $escritura =  $_POST["escritura"];
            $valor_catastral =  $_POST["valor_catastral"];
            $valor_fiscal =  $_POST["valor_fiscal"];
            $idkey_cliente =  $_POST["idkey_cliente"];
            if(isset($_POST["aforo"])) $aforo = $_POST["aforo"];  
            else $aforo ="";
            $garantia_categoria = $_POST["garantias_categorias1"];


            //Se averigua si se trata de una alta o una edición
            if($idkey_inmueble != ""){
                $oconns->ShotSimple("update garantias_inmueble set  valor_fiscal='$valor_fiscal', valor_catastral='$valor_catastral', escritura='$escritura', registro='$registro', medidas_colindacia='$inmueble_medidas', gravamen='$gravamen', hipoteca='$hipoteca', descripcion='$inmueble_descripcion', observaciones='$inmueble_observaciones', idkey_garantia_categoria='$garantia_categoria', aforo='$aforo'where idkey='$idkey_inmueble' ;");
            }
            else {
                $oconns->ShotSimple("insert into garantias_inmueble(valor_fiscal,valor_catastral,escritura,registro,medidas_colindacia,gravamen,hipoteca,descripcion,observaciones,idkey_clientes,idkey_garantia_categoria,aforo)values('".$valor_fiscal."','".$valor_catastral."','".$escritura."','".$registro."','".$inmueble_medidas."','".$gravamen."','".$hipoteca."','".$inmueble_descripcion."','".$inmueble_observaciones."','".$idkey_cliente."','".$garantia_categoria."','".$aforo."');");

                $idkey_inmueble = $oconns->last_id;
            }

            if($idkey_inmueble !=""){
                $response["error"] = 0;
                $response["idkey_inmueble"] = $idkey_inmueble;
            }
            else 
                $response["error"] = 1;
            echo json_encode($response);
        break;

        case "consulta_inmueble":
            $idkey_inmueble = $_POST["idkey_inmueble"];
            $data = $oconns->getRows("select  valor_fiscal, valor_catastral, escritura, registro, medidas_colindacia, gravamen, hipoteca, descripcion, observaciones, idkey_garantia_categoria, aforo from garantias_inmueble where idkey=".$idkey_inmueble.";");
            if ($oconns->numberRows>0){
                $response['error'] = 0;
                $response['categoria'] = $data[0]["idkey_garantia_categoria"];
                $response['valor_fiscal'] = $data[0]["valor_fiscal"];   
                $response['valor_catastral'] = $data[0]["valor_catastral"];         
                $response['escritura'] = $data[0]["escritura"];    
                $response['registro'] = $data[0]["registro"];
                $response['gravamen'] = $data[0]["gravamen"];
                $response['hipoteca'] = $data[0]["hipoteca"];
                $response['aforo'] = $data[0]["aforo"];
                $response['descripcion'] = $data[0]["descripcion"];
                $response['observaciones'] = $data[0]["observaciones"];
                $response['medidas'] = $data[0]["medidas_colindacia"];
            }
            else $response['error'] = 1;
            echo json_encode($response);
        break;

        case "datatable_egresos":
            $idkey_cliente = $_POST["idkey_cliente"];
            $data = $oconns->getRows("select ce.*, et.nombre as tipo_egreso, f.nombre as frecuencia from clientes_egresos ce inner join egresos_tipos et on ce.id_tipo_egreso = et.idkey inner join frecuencia f on f.idkey = ce.id_frecuencia where ce.idkey_clientes=".$idkey_cliente.";");

            $response = array();
            if ($oconns->numberRows>0){
                foreach ($data as $item){ 
                    $idkey_egreso = $item["idkey"];
                    $acciones =  '<a href="#" class="btn radius-1 btn-sm btn-brc-tp btn-outline-default btn-h-outline-primary btn-a-outline-primary btn-text-primary" data-toggle="modal" data-target="#modalEgresos" title="Editar" onclick="cargar_egreso('.$idkey_egreso.')"><i class="fa fa-pencil-alt"></i></a>'.
                        '<a href="#" class="btn radius-1 btn-sm btn-brc-tp btn-outline-default btn-h-outline-danger btn-a-outline-danger btn-text-danger" title="Eliminar" onclick="eliminar_egreso('.$idkey_egreso.')">
                         <i class="fa fa-trash-alt"></i></a>';
                    if($item["tipo_pago"]=="1") $tipo_pago = "Fijo"; else $tipo_pago = "No fijo";
                    $jsonArrayObject = (array(
                        'egreso' => $item["tipo_egreso"], 
                        'frecuencia' => $item["frecuencia"], 
                        'monto' => $item["monto"], 
                        'tipo_pago' => $tipo_pago, 
                        'acciones' => $acciones
                    ));
                    $response[] = $jsonArrayObject;
                }
            }
            echo json_encode($response);
        break;


        case "egreso":
            $idkey_cliente = $_POST["idkey_cliente"];
            $idkey_egreso = $_POST["idkey_egreso"];

            if(isset($_POST["tipo_pago"])) $tipo_pago = 1; else $tipo_pago = 0;
            $tipo_egreso = $_POST["tipo_egreso"];
            $frecuencia_egreso = $_POST["frecuencia_egreso"];
            $monto_egreso = $_POST["monto_egreso"];
            if(!empty($_POST["inicio_egreso"])){
                $temp_1 = explode("/",$_POST["inicio_egreso"]);
                $inicio_egreso = $temp_1[2]."-".$temp_1[1]."-".$temp_1[0];
            }
            else $inicio_egreso = "";
            if(!empty($_POST["fin_egreso"])){
                $temp_2 = explode("/",$_POST["fin_egreso"]);
                $fin_egreso = $temp_2[2]."-".$temp_2[1]."-".$temp_2[0];
            }
            else $fin_egreso = "";
            
            $descripcion = $_POST["descripcion_egreso"];

            //Se averigua si se trata de una alta o una edición
            if($idkey_egreso != ""){
                $oconns->ShotSimple("update clientes_egresos set id_tipo_egreso='$tipo_egreso', id_frecuencia='$frecuencia_egreso', monto='$monto_egreso', inicio='$inicio_egreso', fin='$fin_egreso', observaciones='$descripcion', tipo_pago='$tipo_pago' where idkey='$idkey_egreso' ;");
            }
            else {
                $oconns->ShotSimple("insert into clientes_egresos(id_tipo_egreso, id_frecuencia, monto, inicio, fin, observaciones, idkey_clientes, tipo_pago) values('$tipo_egreso', '$frecuencia_egreso', '$monto_egreso', '$inicio_egreso', '$fin_egreso', '$descripcion', '$idkey_cliente', '$tipo_pago');"); 
                $idkey_egreso=$oconns->last_id;
            }
            
            if($idkey_egreso != ""){
                $response["idkey_egreso"] =  $idkey_egreso;
                $response["error"] = 0;   
            }
            else $response["error"] = "Ha ocurrido un error inesperado. Inténtelo más tarde.";  
            
            echo json_encode($response);
        break;

        case "borrar_egreso":
            if(isset($_POST['idkey_egreso'])){
                $idkey_egreso = $_POST["idkey_egreso"];
                $oconns->ShotSimple("delete from clientes_egresos where idkey='".$idkey_egreso."';");
                $response['error'] = 0;
            }
            else $response['error'] = 1;
            echo json_encode($response);
        break;

        case "consulta_egreso":
            $idkey_egreso = $_POST["idkey_egreso"];
            $data = $oconns->getRows("select id_tipo_egreso, id_frecuencia, monto, DATE_FORMAT(inicio,'%d/%m/%Y') as inicio, DATE_FORMAT(fin,'%d/%m/%Y') as fin, observaciones, idkey_clientes, tipo_pago from clientes_egresos where idkey=".$idkey_egreso.";");
            if ($oconns->numberRows>0){
                $response['error'] = 0;
                $response['tipo_pago'] = $data[0]["tipo_pago"];
                $response['tipo_egreso'] = $data[0]["id_tipo_egreso"];
                $response['frecuencia_egreso'] = $data[0]["id_frecuencia"];
                $response['monto_egreso'] = $data[0]["monto"];
                if($data[0]["inicio"]=="00/00/0000") $response['inicio_egreso'] = '';
                else $response['inicio_egreso'] = $data[0]["inicio"];
                if($data[0]["fin"]=="00/00/0000") $response['fin_egreso'] = '';
                else $response['fin_egreso'] = $data[0]["fin"];
                $response['descripcion_egreso'] = $data[0]["observaciones"];
            }
            else $response['error'] = 1;
            echo json_encode($response);
        break;

        case "perfil_cliente":
            $idkey_cliente = $_POST["idkey_cliente"];
            $query = "select idkey_cliente, nombre_pila as nombre,apellido_p, apellido_m, DATE_FORMAT(fecha_nacimiento,'%d/%m/%Y') as fecha_nacimiento, curp, rfc,idkey_sexo, porcentaje_perfil, DATE_FORMAT(fecha_creacion,'%d/%m/%Y') as fecha_creacion FROM view_clientes where idkey_cliente = ".$idkey_cliente;
            $data = $oconns->getRows($query);
            if ($oconns->numberRows>0){
                $response['error'] = 0;
                $response['nombre'] = $data[0]["apellido_p"]." ".$data[0]["apellido_m"]." ".$data[0]["nombre"];
                $response['fecha_creacion'] = $data[0]["fecha_creacion"];
                $response['rfc'] = $data[0]["rfc"];
                $response['curp'] = $data[0]["curp"];
                //Para consultar los datos de contacto
                $data2 = $oconns->getRows("SELECT email, telefono FROM clientes_contacto  WHERE idkey_clientes=".$idkey_cliente);
                if ($oconns->numberRows>0){
                    if(empty($data2[0]["email"])) $response['email'] = "No especificado";
                    else $response['email'] = $data2[0]["email"];
                    $response['telefono'] = $data2[0]["telefono"];
                }
                else{
                    $response['email'] = "No se ha registrado";
                    $response['telefono'] = "No se ha registrado";
                }
            }
            else
                $response['error'] = "Error: No se encontró el cliente solicitado.";
            echo json_encode($response);
        break;

        case "detalle_credito":
            $idkey_credito = $_POST["idkey_credito"];
            $query = "SELECT vc.*, f.nombre as desc_frec, DATE_FORMAT(fecha_creacion,'%d/%m/%Y') as fecha_creacion, DATE_FORMAT(primer_pago,'%d/%m/%Y') as primer_pago, DATE_FORMAT(fecha_desembolso,'%d/%m/%Y') as fecha_desembolso, estatus_pagos FROM view_creditos vc inner join frecuencia f on vc.idkey_frecuencia=f.idkey  where vc.idkey_credito=".$idkey_credito;
            $data = $oconns->getRows($query);
            if ($oconns->numberRows>0){
                $response['error'] = 0;
                $response['nombre'] = $data[0]["nombre"];
                $response['folio'] = $data[0]["folio"];
                $response['monto'] = number_format($data[0]["monto"], 2);
                $response['monto_credito'] = $data[0]["monto"];
                $response['plazo'] = $data[0]["plazo"];
                $response['numero_pagos'] = $data[0]["numero_pagos"];
                $response['desc_frec'] = $data[0]["desc_frec"];
                if(empty($data[0]["finalidad"])) $finalidad = "No especificada"; else $finalidad = $data[0]["finalidad"];
                $response['finalidad'] = $finalidad;
                $response['desc_producto'] = $data[0]["nombre_producto"];
                $response['tipo_credito'] = $data[0]["tipo_credito"];
                $response['fecha_creacion'] = $data[0]["fecha_creacion"];
                $response['estatus'] = $data[0]["estatus"];
                $response['idkey_estatus'] = $data[0]["estatus"];
                $response['desc_estatus'] = $data[0]["desc_estatus"];
                $response['tasa_interes'] = $data[0]["tasa_interes"];
                $response['primer_pago'] = $data[0]["primer_pago"];
                $response['idkey_cliente'] = $data[0]["idkey_clientes"];
                $response['observaciones'] = $data[0]["observaciones"];
                $response['fecha_desembolso'] = $data[0]["fecha_desembolso"];
                $response['tipo_desembolso'] = $data[0]["tipo_desembolso"];
                $response['idkey_tipo_desembolso'] = $data[0]["idkey_tipo_desembolso"];
                $response['prodeco'] = $data[0]["porcentaje_prodeco"];
                $response['fondeadora'] = $data[0]["porcentaje_fondeadora"];
                $response['gliquida'] = $data[0]["gliquida"];

                if($data[0]['estatus_pagos']=='')
                    $response['estatus_pagos'] = "<span class='badge badge-sm bgc-success-l2 text-success-d2 border-1 brc-success-m3'>Sin observaciones</span>";
                else{
                    $ep = $oconns->getRows("select nombre from creditos_estatus_pagos where idkey='".$data[0]["estatus_pagos"]."'");
                    $response['estatus_pagos'] = "<span class='badge badge-sm bgc-warning-l2 text-warning-d2 border-1 brc-warning-m3'>".$ep[0]["nombre"]."</span>";
                }

                $socios = '';
                $socios_score = '';
                if($response['tipo_credito']==2){//Si es grupal consulto los socios
                    $socios = '<td colspan="3" style="margin-bottom: 0px;">';
                    $socios_score = '';
                    $idkey_grupo = $data[0]['idkey_clientes'];
                    $data1 = $oconns->getRows("select gc.*, vc.nombre, gc.monto from view_clientes vc  inner join grupos_clientes gc on gc.idkey_clientes = vc.idkey_cliente where idkey_grupo=".$idkey_grupo.";");
                    foreach ($data1 as $item){ 
                        $url = "../cartera/perfil-cliente.php?idkey_cliente=".$item["idkey_clientes"];
                        $socios .= '<div class="row"><div class="col-9">
                            <li class="list-unstyled"><i class="fa fa-caret-right text-success pr-2"></i>
                            <a href="'.$url.'" class="text-grey text-100">'.$item["nombre"].'</a>
                            </div><div class="col-3 text-right text-success">$ '.number_format($item["monto"], 2).'</div></div>';
                        $socios_score .= '<div class="row"><div class="col-7">
                            <li class="list-unstyled"><i class="fa fa-caret-right text-success pr-2"></i>
                            <a href="../cartera/clientes_alta.php?idkey_cliente='.$item["idkey_clientes"].'" class="text-grey text-100" target="_blank">'.$item["nombre"].'</a>
                            </div>
                            <div class="col-1">
                            <p class="text-600 text-grey">Monto<span style="color:red;">*</span></p>
                            </div>
                            <div class="col-2">
                            <input type="number" class="form-control montos_socios" name="'.$item["idkey_clientes"].'" placeholder="" onChange="calcular_monto()" min="1" id="monto_socio'.$item["idkey_clientes"].'" value="'.$item["monto"].'"></div>
                            <a href="#" onclick="cargar_factores_cliente(\''.$item["idkey_clientes"].'\', \''.$item["nombre"].'\')" class="col-2 text-right text-success">SCORE</a></div>';
                    }
                    $socios.='</td>';
                    $socios_score.='';
                }
                else{
                    $socios_score = '<div class="row"><div class="col-9">
                            <li class="list-unstyled"><i class="fa fa-caret-right text-success pr-2"></i>
                            <a href="../cartera/clientes_alta.php?idkey_cliente='.$data[0]["idkey_clientes"].'" class="text-grey text-100" target="_blank">'.$data[0]["nombre"].'</a>
                            </div><a href="#" onclick="cargar_factores_cliente(\''.$data[0]["idkey_clientes"].'\', \''.$data[0]["nombre"].'\')" class="col-3 text-right text-success">SCORE</a></div>';;
                }
                $response['socios'] = $socios;
                $response['socios_score'] = $socios_score;
            }
            else 
                $response['error'] = "Error: No se encontró el cliente solicitado.";
            echo json_encode($response);
        break;

        case "progreso_credito":
            $idkey_credito = $_POST["idkey_credito"];
            $progreso = consultar_progreso_credito($idkey_credito);
            if($progreso >0){
                $data = $oconns->getRows("select c.folio, a.fecha_valor as fecha_pago, DAY(fecha_valor) as dia from creditos c inner join amortizaciones_dinamicas a on (c.idkey=a.idkey_creditos) where a.idkey_creditos =".$idkey_credito." order by fecha_valor asc");
                $datas_graph =[];
                if ($oconns->numberRows>0){
                    $data_graph = array();
                    foreach ($data as $item1){ 
                       
                        $jsonArrayObject = (array(
                            'x' => $item1["fecha_pago"], 
                            'y' => $item1["dia"], 
                        ));
                        $data_graph[] = $jsonArrayObject;
                    }
                    $jsonArrayObject = (array(
                            'folio' => $data[0]["folio"], 
                            'data' => $data_graph, 
                    ));
                    $datas_graph[] = $jsonArrayObject;

                }
                $response["data"] = $datas_graph;
            }
            $response["error"]=0;
            $response["progreso"] = $progreso;
            echo json_encode($response);
        break;

        case "creditos_cliente":
            $idkey_cliente = $_POST["idkey_cliente"];
            //Solo creditos autorizados: status=1
            $data = $oconns->getRows("select idkey_credito, folio, 'Individual' as tipo, idkey_clientes, desc_estatus, estatus from view_cred_individuales where idkey_clientes=".$idkey_cliente." UNION ALL SELECT cg.idkey_credito, cg.folio, 'Grupal' as tipo, cg.idkey_clientes, desc_estatus, estatus FROM view_cred_grupales cg inner join grupos_clientes gc on (gc.idkey_grupo=cg.idkey_clientes) where  gc.idkey_clientes=".$idkey_cliente.";");

            $creditos = "";
            $datas_graph = array();

            if ($oconns->numberRows>0){
                $ndiasmora_total = 0;
                foreach ($data as $item){ 
                    $folio = $item["folio"];
                    $idkey_credito = $item["idkey_credito"];
                    $progreso = consultar_progreso_credito($idkey_credito);
                    $ndiasmora = intval(consultar_diasmora_credito($idkey_credito));
                    $ndiasmora_total += $ndiasmora;
                    $url ="perfil-credito.php?idkey_credito=".$item["idkey_credito"]."&idkey_cliente=".$item["idkey_clientes"];
                    $estatus = intval($item["estatus"]);
                    $color = '';
                    if($estatus == 1)
                        $color = 'success';
                    else if($estatus == 2)
                        $color = 'primary';
                    else if($estatus == 3 || $estatus == 5)
                        $color = 'danger';
                    else 
                        $color = 'warning';
                    $estatus_str = "<span class='badge badge-sm bgc-".$color."-l2 text-".$color."-d2 border-1 brc-".$color.
                        "-m3'>".$item["desc_estatus"]."</span>";
                    $creditos .= '<tr class="bgc-h-primary-l5">
                            <td class="text-dark-m1"><a href="'.$url.'">'.$item["folio"].'</a></td>
                            <td><span class="text-success-m1 font-bolder">'.$item["tipo"].'</span></td>
                            <td><span class="text-danger-m1 font-bolder">'.$ndiasmora.'</span></td>
                            <td><span class="text-success-m1 font-bolder">'.$estatus_str.'</span></td>
                            <td align="center">'.$progreso.'%</td>
                        </tr>';
        
                    //Para los datos de entrada de la gráfica
                    $data1 = $oconns->getRows("select fecha_valor as fecha_pago, DAY(fecha_valor) as dia from amortizaciones_dinamicas where idkey_creditos =".$idkey_credito." order by fecha_valor asc");
                     if ($oconns->numberRows>0){
                        $data_graph = array();
                        foreach ($data1 as $item1){ 
                           
                            $jsonArrayObject = (array(
                                'x' => $item1["fecha_pago"], 
                                'y' => $item1["dia"], 
                            ));
                            $data_graph[] = $jsonArrayObject;
                        }
                        $jsonArrayObject = (array(
                                'folio' => $folio, 
                                'data' => $data_graph, 
                        ));
                        $datas_graph[] = $jsonArrayObject;

                    }
                    $response["data"] = $datas_graph;
                }
                $response["creditos"] = $creditos;
                $response["ndiasmora_total"] = $ndiasmora_total;
                
            }
            else
                $response["creditos"] = "";
            echo json_encode($response);
        break;

        case "cargar_frecuencia_productos":
            $idkey_producto = $_POST["idkey_producto"];
            $data = $oconns->getRows("select distinct(pi.idkey_frecuencia), f.nombre from productos_intereses pi inner join frecuencia f on (pi.idkey_frecuencia=f.idkey) where pi.idkey_producto=".$idkey_producto." order by pi.idkey_frecuencia asc;");
            $n = $oconns->numberRows;
            $response["nfrec"] = $n;
            if ($n > 0){
                $frec = "<option value=''></option>";
                foreach ($data as $item)
                    $frec .= "<option value='".$item["idkey_frecuencia"]."'>".$item["nombre"]."</option>";
                $response['frecuencias'] = $frec;
            }
            else {//Si no hay intereses de este producto, se cargan todas las frecuencias
                $frec = "<option value=''></option>";
                $data1 = $oconns->getRows("select idkey, nombre from frecuencia order by idkey asc;");
                foreach ($data1 as $item1)
                    $frec .= "<option value='".$item1["idkey"]."'>".$item1["nombre"]."</option>";
                $response['frecuencias'] = $frec;
            }
            //Para los (montos, plazos) mínimos y máximos
            $data2 = $oconns->getRows("select plazo_minimo, plazo_maximo, monto_minimo, monto_maximo_inicial from productos where idkey=".$idkey_producto.";");
            $m = $oconns->numberRows;
            if($m >0){
                $response["plazo_min"] = $data2[0]["plazo_minimo"];
                $response["plazo_max"] = $data2[0]["plazo_maximo"];
                $response["monto_min"] = $data2[0]["monto_minimo"];
                $response["monto_max"] = $data2[0]["monto_maximo_inicial"];
            }

            echo json_encode($response);
        break;

        case "cargar_interes":
            $idkey_producto = $_POST["idkey_producto"];
            $idkey_frecuencia = $_POST["frecuencia_pago"];
            $pagos = $_POST["pagos"];

            $data = $oconns->getRows("select interes_anual, min_num_pagos, max_num_pagos from productos_intereses where idkey_producto=".$idkey_producto." and idkey_frecuencia =".$idkey_frecuencia.";");
            $n = $oconns->numberRows;
            $response['interes_anual'] = "";

            if ($n == 1)
                $response['interes_anual'] = $data[0]["interes_anual"];
            else if($n > 1){//Para cuando hay más de un interés por frecuencia de pago... comparamos por rangos de pagos
                foreach ($data as $item){
                    if($pagos >= $item["min_num_pagos"] && $pagos <= $item["max_num_pagos"]){
                        $response['interes_anual'] = $item["interes_anual"];
                        break;
                    }
                }
            }
            else $response['error'] = 1;

            //Para comprobar que no esté vacío
            if($response['interes_anual'] =="") $response['error'] = 1;
            else  $response['error'] = 0;

            echo json_encode($response);
        break;

        case "guardar_credito":
            $response["error"] = 0; 
            $tipo = $_POST["tipo"];
            $idkey_producto = $_POST["tipo_producto"];
            $idkey_frecuencia = $_POST["frecuencia_pago"];
            $plazo = $_POST["plazo_meses"];
            $monto = floatval($_POST["monto_credito"]);
            $numero_pagos = $_POST["numero_pagos"];
            $tasa_interes = $_POST["tasa_interes"];
            $temp = explode("/", $_POST["fecha_pago1"]);
            $fecha_pago1= $temp[2]."-".$temp[1]."-".$temp[0];
            $finalidad = $_POST["finalidad"];
            $iva = $_POST["iva"];
            $temp = explode("/", $_POST["fecha_desembolso"]);
            $fecha_desembolso = $temp[2]."-".$temp[1]."-".$temp[0];
            $tipo_desembolso = $_POST["tipo_desembolso"];
            $prodeco = $_POST["prodeco"];
            $fondeadora = $_POST["fondeadora"];
            $gliquida = $_POST["gliquida"];

            if($tipo == 1)
                $idkey_clientes = $_POST["idkey_cliente"];
            else{//Grupal- Creamos el grupo
                $nombre_grupo = $_POST["nombre_grupo"];
                $oconns->ShotSimple("insert into grupos_nombre(nombre, idkey_usuario) values ('$nombre_grupo', '$idkey_usuario');");
                $idkey_clientes=$oconns->last_id; 
                //para los montos de cada cliente
                $clientes_grupo=$_POST["duallistbox_demo1"]; 
                $montos_clientes=$_POST["montos_socios"]; 
                $puestos=$_POST["puesto"]; 
                foreach ($clientes_grupo as $cliente) {
                    $monto_cliente = floatval($montos_clientes[$cliente]);
                    $puesto = $puestos[$cliente];
                    $por =($monto_cliente/$monto)*100;
                    $porcentaje_cliente = number_format($por, 2, '.', '');
                    //$tabla_ind = json_encode(gererar_tabla_amortizacion($tasa_interes, $plazo, $monto_cliente, $idkey_frecuencia, $iva, $fecha_pago1));
                    $oconns->ShotSimple("insert into grupos_clientes(idkey_grupo, idkey_clientes,porcentaje, monto, puesto) values ('$idkey_clientes', '$cliente', '$porcentaje_cliente', '$monto_cliente', '$puesto');");
                    
                }
            }

            
            $oconns->ShotSimple("insert into creditos(idkey_clientes, idkey_productos, plazo, idkey_frecuencia, monto, tasa_interes, numero_pagos, primer_pago, finalidad, tipo_credito, iva, fecha_desembolso, idkey_tipo_desembolso, porcentaje_prodeco, porcentaje_fondeadora, gliquida) values('$idkey_clientes', '$idkey_producto', '$plazo', '$idkey_frecuencia', '$monto', '$tasa_interes', '$numero_pagos','$fecha_pago1','$finalidad','$tipo', '$iva', '$fecha_desembolso', '$tipo_desembolso', '$prodeco', '$fondeadora', '$gliquida');");
            $idkey_credito=$oconns->last_id; 
            if($idkey_credito != ""){
                $oconns->ShotSimple("update creditos set folio = concat(YEAR(CURDATE()),'/','$idkey_credito') where idkey= $idkey_credito");
                $response["idkey_credito"] =  $idkey_credito;
                $response["error"] = 0;   
                //Bitácora
                $oconns->ShotSimple("insert into bitacora_creditos(idkey_credito, idkey_usuario, descripcion) values ($idkey_credito, $idkey_usuario, 'Alta del crédito')");
            }
            else $response["error"] = 1;  
            
            echo json_encode($response);
        break;

         case "comprobar_perfil_completo_cliente":
            $response['perfil_completo'] = false;
            if(isset($_POST['idkey_cliente'])){
                $idkey_cliente = $_POST["idkey_cliente"];
                $perfil_completo = comprobar_porcentaje_cliente($idkey_cliente);
                $response['perfil_completo'] = $perfil_completo;
                $response['error'] = 0;

            }
            else $response['error'] = 1;
            echo json_encode($response);
        break;

        case 'perfil_completo_cliente':
            $idkey_cliente = $_POST["idkey_cliente"];
            $txt_error = perfil_completo_cliente($idkey_cliente);
            if($txt_error == "") 
                $response['error'] = 0;
            else
                $response['error'] = $txt_error;
            echo json_encode($response);
        break;

        case "consultar_iva":
            $data = $oconns->getRows("select valor from iva where idkey= 1;");
            if ($oconns->numberRows>0){
                $response['error'] = 0;
                $response['iva'] = $data[0]["valor"];
            }
            else $response['error'] = 1;
            echo json_encode($response);
        break;

        case "factores"://alta o modificac
            $response["error"] = 0; 

            $idkey_cliente = $_POST["idkey_cliente"];
            $idkey_factores = $_POST["idkey_factores"];
            $idkey_actividad = $_POST["conocimiento"];
            $idkey_buro = $_POST["historial_buro"];
            $idkey_cap = $_POST["capacidad_pago"];
            $idkey_comp_ing = $_POST["comprobacion_ingresos"];
            $idkey_exp = $_POST["experiencia_crediticia"];
            $idkey_gliquida = $_POST["garantia_liquida"];
            $idkey_ref = $_POST["referencias"];
            $idkey_solvencia = $_POST["solvencia"];
            $idkey_veracidad = $_POST["veracidad"];
            

            //Se averigua si se trata de una alta o una edición
            if($idkey_factores != ""){
                $oconns->ShotSimple("update clientes_factores set idkey_actividad = '$idkey_actividad', idkey_buro = '$idkey_buro', idkey_cap_pago='$idkey_cap', idkey_comp_ingresos='$idkey_comp_ing', idkey_exp_crediticia='$idkey_exp', idkey_gliquida='$idkey_gliquida', idkey_referencias='$idkey_ref', idkey_solvencia='$idkey_solvencia', idkey_veracidad='$idkey_veracidad', fecha_creacion= NOW() WHERE idkey='$idkey_factores' ;");
            }
            else {
                $oconns->ShotSimple("insert into clientes_factores(idkey_actividad,idkey_buro, idkey_cap_pago, idkey_comp_ingresos, idkey_exp_crediticia, idkey_gliquida, idkey_referencias, idkey_solvencia, idkey_veracidad, idkey_clientes, fecha_creacion) values ('$idkey_actividad', '$idkey_buro', '$idkey_cap', '$idkey_comp_ing', '$idkey_exp', '$idkey_gliquida', '$idkey_ref', '$idkey_solvencia', '$idkey_veracidad', '$idkey_cliente', NOW())"); 
            
                $idkey_factores=$oconns->last_id;
            }
            
            if($idkey_factores != ""){
                $response["idkey_factores"] =  $idkey_factores;
                $response["error"] = 0;   
                //actualizamos el porcentaje de perfil del cliente a 1
                $oconns->ShotSimple("update clientes set porcentaje_perfil= 1 WHERE idkey='$idkey_cliente' ;");
                //Cargamos los datos del reporte del cliente
                $data = $oconns->getRows("select vc.nombre, DATE_FORMAT(vc.fecha_nacimiento,'%d/%m/%Y') as fecha_nacimiento, vc.rfc, vc.curp, vd.direccion_completa from view_clientes vc inner join view_direcciones vd on (vc.idkey_cliente = vd.idkey_cliente) where vd.prioridad = 1 and vc.idkey_cliente =".$idkey_cliente.";");
                if($oconns->numberRows > 0){
                    $response['nombre'] = $data[0]['nombre'];
                    $response['fecha_nac'] = $data[0]['fecha_nacimiento'];
                    $response['rfc'] = $data[0]['rfc'];
                    $response['curp'] = $data[0]['curp'];
                    $response['direccion'] = $data[0]['direccion_completa'];
                }

            }
            else $response["error"] = "Ha ocurrido un error inesperado. Inténtelo más tarde.";  
            
            echo json_encode($response);
        break;

        case "cargar_factores":
            $idkey_cliente = $_POST["idkey_cliente"];
            $data = $oconns->getRows("select f.idkey, f.idkey_buro, f.idkey_exp_crediticia, f.idkey_cap_pago, f.idkey_comp_ingresos, f.idkey_referencias, f.idkey_actividad, f.idkey_veracidad, f.idkey_gliquida, f.idkey_solvencia from clientes_factores f where idkey_clientes= '$idkey_cliente';");
            if ($oconns->numberRows>0){
                $response['error'] = 0;
                $response['idkey_factores'] = $data[0]["idkey"];
                $response['idkey_buro'] = $data[0]["idkey_buro"];
                $response['idkey_exp_cred'] = $data[0]["idkey_exp_crediticia"];
                $response['idkey_cap_pago'] = $data[0]["idkey_cap_pago"];
                $response['idkey_comp_ing'] = $data[0]["idkey_comp_ingresos"];
                $response['idkey_ref'] = $data[0]["idkey_referencias"];
                $response['idkey_actividad'] = $data[0]["idkey_actividad"];
                $response['idkey_veracidad'] = $data[0]["idkey_veracidad"];
                $response['idkey_gliquida'] = $data[0]["idkey_gliquida"];
                $response['idkey_solvencia'] = $data[0]["idkey_solvencia"];
            }
            else $response['error'] = 1;
            echo json_encode($response);
        break;

        case "ver_amortizacion":
            $response['tabla'] ="";
            if (isset($_POST['interes']) && isset($_POST['plazo']) &&isset($_POST['frecuencia']) && isset($_POST['monto']) && isset($_POST['iva']) && isset($_POST['fecha'])) {

                $ia =(float) $_POST['interes'];
                $plazo_mensual = (float)  $_POST['plazo'];
                $monto_total = (float)  $_POST['monto'];
                $frecuencia = $_POST['frecuencia'];
                $iva = (float) $_POST['iva'];
                $temp = explode("/",$_POST['fecha']);
                $fecha = $temp[2]."-".$temp[1]."-".$temp[0];

                $response['tabla'] = gererar_tabla_amortizacion($ia, $plazo_mensual, $monto_total, $frecuencia, $iva, $fecha);

            }
            echo json_encode($response);
        break;

        case "checar_nombre_grupo":
            $nombre = $_POST["nombre"];
            $data = $oconns->getSimple("select count(nombre) from grupos_nombre where nombre = '$nombre';");
            if($data >0)
                echo 1;
            else
                echo 0;

        break;

        case "descargarClientes":
            $data = $oconns->getRows("SELECT nombre, fecha_creacion, idkey_cliente, curp, rfc FROM view_clientes WHERE idkey_usuario = $idkey_usuario ORDER BY fecha_creacion desc");
            $rows = array();
            foreach($data as $value) {
                $jsonArrayObject = (array(
                    'nombre' => $value["nombre"], 
                    'fecha' => $value["fecha_creacion"], 
                    'idkey' => $value["idkey_cliente"], 
                    'curp' => $value["curp"], 
                    'rfc' => $value["rfc"], 
     
                ));
                $rows[] = $jsonArrayObject;
            }
            
        

            echo json_encode($rows);
            break;

        case "descargarCreditos":
            $data = $oconns->getRows("SELECT folio, nombre, nombre_producto, monto, fecha_creacion FROM view_creditos WHERE estatus = 1");
            $rows = array();
            foreach($data as $value) {
                $jsonArrayObject = (array(
                    'folio' => $value["folio"], 
                    'nombre' => $value["nombre"], 
                    'nombre_producto' => $value["nombre_producto"], 
                    'monto' => $value["monto"], 
                    'fecha_creacion' => $value["fecha_creacion"], 
        
                ));
                $rows[] = $jsonArrayObject;
            }
            
        

            echo json_encode($rows);
            break;

    }
}



?>
