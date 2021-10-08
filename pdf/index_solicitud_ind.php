<?php 

require('fpdf.php');
require ('../php/clases/conversor.php');
require ('strfecha.php');
require ('../php/db.php');


class myPDF extends FPDF{

	
	function header(){
		$this->fecha = date("d/m/Y");
		$this->Image('logoprodeco.png',90,4,20);
		$this->SetFont('Arial', 'B', 8);
		$this->Cell(200,5, '',0,1,'C', 0);
		$this->Cell(195, 8, 'PRODUCCION ECOTURISTICA COLOTEPEC SC. DE R.S DE C.V', 0, 1, 'C');
		$this->SetFillColor(10, 134, 0);
		$this->Cell(195,1, '',0,1,'C', 1);
		$this->SetFillColor(255, 0, 0);
		$this->Cell(195,1, '',0,1,'C', 1);
		$this->Cell(195,3, '',0,1,'C', 0);
		$this->SetFont('Arial', 'B', 10);
		$this->Cell(195,1, 'SOLICITUD UNICA DE CREDITO ',0,1,'C', 0);
		$this->Cell(95, 5, 'TIPO DE CREDITO: INDIVIDUAL', 0, 0, 'L');
		$this->Cell(100, 5, "FECHA DE SOLICITUD:{$this->fecha }", 0, 1, 'R');
	}
	function footer(){
		$this->SetY(-15);
		$this->SetFillColor(10, 134, 0);
		$this->Cell(195,1, '',0,1,'C', 1);
		$this->SetFillColor(255, 0, 0);
		$this->Cell(195,1, '',0,1,'C', 1);
		$this->setFont('Arial', '', 7);

		$this->Cell(70,3, "Calle Principal S/N",0,0,'L', 0);
		$this->Cell(60,3, 'RFC: PEC990606635',0,0,'C', 0);
		$this->Cell(60,3, 'Tels. De Oficina (01 954)',0,1,'R', 0);

		$this->Cell(70,3, 'Barra de Navidad, Santa Maria',0,0,'L', 0);
		$this->Cell(65,3, '',0,0,'R', 0);
		$this->Cell(60,3, '58 2 15 48 ** 58 2 15 38',0,1,'R', 0);

		$this->Cell(70,3, 'Colotepec, Pochula, Oax. C.P. 70934',0,0,'L', 0);
		$this->Cell(65,3,'Page'.$this->PageNo().'/{nb}', 0, 0, 'C');
		$this->Cell(60,3, 'Email: produccioncolotepec@gmail.com',0,1,'R', 0);
	}
}

$oconns = new database();
$idkey_credito = $_GET["idkey_credito"];
$idkey_cliente = $_GET["idkey_cliente"];

$datos = $oconns->getRows("select nombre, ocupacion, domicilio_parte1, domicilio_parte2, nombre_cp,  nombre_identificacion, no_identificacion, monto, tasa_interes, numero_pagos, DATE_FORMAT(fecha_creacion,'%d-%m-%Y %H:%i:%s') as fecha_creacion from view_contrato_individual where idkey_cliente=".$idkey_cliente." and idkey_credito='".$idkey_credito."';");
$datos3 = $oconns->getRows("select telefono from clientes_contacto where idkey_clientes=".$idkey_cliente.";");

$datos2 = $oconns->getRows("select vc.curp, vc.rfc, vc.edad, vc.sexo, vc.no_identificacion from view_clientes as vc where idkey_cliente=".$idkey_cliente.";");

$datos4 = $oconns->getRows("select it.nombre, ci.monto, ci.profesion,ci.inicio, ci.fin, ci.ocupacion, ci.domicilio_empleador from clientes_ingresos ci inner join ingresos_tipos it on (ci.id_tipo_ingreso = it.idkey) where ci.idkey_clientes = ".$idkey_cliente."  order by ci.fin desc limit 1;");

$datos5 = $oconns->getRows("select nombre from estado_civil WHERE idkey = (SELECT idkey_estado_civil FROM clientes_datos_adicionales where idkey_clientes = ".$idkey_cliente."); ");
$datos6 = $oconns->getRows("select nombre from nivel_academico WHERE idkey = (SELECT idkey_nivel_academico FROM clientes_datos_adicionales where idkey_clientes = ".$idkey_cliente."); ");

$datos7 = $oconns->getRows("select nombre_producto, finalidad, plazo, monto, tasa_interes, idkey_frecuencia  from view_creditos WHERE idkey_credito = ".$idkey_credito."; ");

$datos8 = $oconns->getRows("select nombre, idkey_parentesco, idkey from clientes_relaciones where idkey_clientes = ".$idkey_cliente." and idkey_relaciones = 2; ");
$n_avales = $oconns->numberRows;

$datos9 = $oconns->getRows("select valor_fiscal, valor_comercial, descripcion, idkey_garantia_tipo from garantias_inmueble where idkey_clientes = ".$idkey_cliente." ; ");
$n_inm = $oconns->numberRows;

$datos10 = $oconns->getRows("select nombre from regimen_fiscal where idkey = (SELECT idkey_regimen_fiscal FROM clientes_datos_adicionales where idkey_clientes = ".$idkey_cliente.");");

$datos11 = $oconns->getRows("select tv.value as value, tv.nombre from clientes_socio_economico cs inner join tipo_vivienda tv on (cs.idkey_tipo_vivienda = tv.idkey) where cs.idkey_clientes =".$idkey_cliente."; ");

$ingresos = $oconns->getRows("select TIMESTAMPDIFF(YEAR, ci.inicio, CURDATE()) AS arraigo_laboral, it.value as value_ocupacion, it.nombre  from clientes_ingresos ci inner join ingresos_tipos it on (ci.id_tipo_ingreso = it.idkey) where ci.idkey_clientes =".$idkey_cliente.' order by ci.fin desc limit 1');

$datos12 = $oconns->getRows ("SELECT monto FROM clientes_egresos where idkey_clientes = ".$idkey_cliente."; ");

$datos14 = $oconns->getRows("SELECT valor_comercial, idkey_garantia_tipo from garantias_mueble where idkey_clientes = '".$idkey_cliente."' "); 
$datos15 = $oconns->getRows("select idkey_gliquida from clientes_factores where idkey_clientes = '".$idkey_cliente."';");


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
        
    $r1 = $value_arraigo_laboral; 
    $anios_laborales = $arraigo_laboral." años de laborar";
    $r3 = intval($ingresos[0]["value_ocupacion"]);
    $r4 = $ingresos[0]["nombre"];
}


   //Arraigo domiciliario (domicilio principal, fecha de ocupación)
$arraigo_domiciliario = $oconns->getRows("select TIMESTAMPDIFF(YEAR, fecha_habita, CURDATE()) AS anios from view_direcciones where prioridad=1 and idkey_cliente =".$idkey_cliente.";");
if ($oconns->numberRows>0){
    $arraigo_dom = intval($arraigo_domiciliario[0]["anios"]);
    $arraigo_dom = $arraigo_dom." años de ocupación";
    if($arraigo_dom < 1)
        $arraigo_dom = 5;
    else if($arraigo_dom >= 1 && $arraigo_dom <= 4)
        $arraigo_dom = 8;
    else
       $arraigo_dom = 10;
}

$antiguedad_vivienda = $arraigo_dom;

   function consultar_diasmora_credito($idkey_credito){

            $oconns = new database();
            $ndiasmora = $oconns->getSimple("SELECT sum(dias_transcurridos) as diasmora FROM amortizaciones_dinamicas where dias_transcurridos>0 and idkey_creditos=".$idkey_credito);

            return $ndiasmora;

    }

//Historial crediticio interno (consultar en la base de datos los días de morosidad en el pago)
$creditos = $oconns->getRows("select idkey_credito, 'Individual' as tipo from view_cred_individuales where idkey_clientes=".$idkey_cliente." UNION ALL SELECT cg.idkey_credito, 'Grupal' as tipo FROM view_cred_grupales cg inner join grupos_clientes gc on (gc.idkey_grupo=cg.idkey_clientes) where  gc.idkey_clientes=".$idkey_cliente.";");

if ($oconns->numberRows>0){

    $ndiasmora_total = 0;

    foreach ($creditos as $item){ 

        $idkey_credito = $idkey_credito;
        $ndiasmora = intval(consultar_diasmora_credito($idkey_credito));
        $ndiasmora_total += $ndiasmora;

    }    

    $ndiasmora_total= $ndiasmora_total." días de mora";

}


if($oconns->numberRows>0){

	$nombre = mb_strtoupper($datos[0]["nombre"]);
	$domicilio1 = mb_strtoupper($datos[0]["domicilio_parte1"]);
	$domicilio2 = mb_strtoupper($datos[0]["domicilio_parte2"]);
	$cp = mb_strtoupper($datos[0]["nombre_cp"]);
	$curp = mb_strtoupper($datos2[0]["curp"]);
	$rfc = mb_strtoupper($datos2[0]["rfc"]);
	$edad = mb_strtoupper($datos2[0]["edad"]);
	$sexo = mb_strtoupper($datos2[0]["sexo"]);
	$no_identificacion = mb_strtoupper($datos[0]["no_identificacion"]);
	$telefono = mb_strtoupper($datos3[0]["telefono"]);
	$profesion =  mb_strtoupper($datos4[0]["profesion"]);
	$fecha_inicio =  mb_strtoupper($datos4[0]["inicio"]);
	$fecha_fin =  mb_strtoupper($datos4[0]["fin"]);
	$ocupacion =  mb_strtoupper($datos4[0]["ocupacion"]);
	$ingresos =  mb_strtoupper($datos4[0]["monto"]);
	$ingreso_direccion = mb_strtoupper($datos4[0]["domicilio_empleador"]);
	$tipo =  mb_strtoupper($datos4[0]["nombre"]);
	$estado_civil =  mb_strtoupper($datos5[0]["nombre"]);
	$escolaridad = mb_strtoupper($datos6[0]["nombre"]);
	$nombre_producto = mb_strtoupper($datos7[0]["nombre_producto"]);
	$finalidad = mb_strtoupper($datos7[0]["finalidad"]);
	$plazo = mb_strtoupper($datos7[0]["plazo"]);
	$monto = mb_strtoupper($datos7[0]["monto"]);
	$tasa_interes = mb_strtoupper($datos7[0]["tasa_interes"]);
	$frecuencia = mb_strtoupper($datos7[0]["idkey_frecuencia"]);

	
	//Avales
	$no_cliente_aval1 = "";
	$nombre_aval1 = "";
	$id_conyuge = "";
	$nombre_relacion = "";
	$no_cliente_aval2 = "";
	$nombre_aval2 = "";
	if($n_avales>0){
		$no_cliente_aval1 = mb_strtoupper($datos8[0]["idkey"]);
		$nombre_aval1 = mb_strtoupper($datos8[0]["nombre"]);
		$id_conyuge = mb_strtoupper($datos8[0]["idkey_parentesco"]);
		$nombre_relacion = mb_strtoupper($datos8[0]["nombre"]);
		if($n_avales>1){
			$no_cliente_aval2 = mb_strtoupper($datos8[1]["idkey"]);
			$nombre_aval2 = mb_strtoupper($datos8[1]["nombre"]);
		}
	}

	//Garantía inmueble
	$valor_fiscal = "";
	$descripcion = "";
	$tipo_de_garantia = "";
	$valor_comercial = "";
	if($n_inm>0){
		$valor_fiscal = mb_strtoupper($datos9[0]["valor_fiscal"]);
		$descripcion = mb_strtoupper($datos9[0]["descripcion"]);
		$tipo_de_garantia = mb_strtoupper($datos9[0]["idkey_garantia_tipo"]);
		$valor_comercial = mb_strtoupper($datos9[0]["valor_comercial"]);
	}
	
	$regimen = mb_strtoupper($datos10[0]["nombre"]);
	$tipo_vivienda =  mb_strtoupper($datos11[0]["nombre"]);
	$egresos = mb_strtoupper($datos12[0]["monto"]);
	$valor_garantia2 = mb_strtoupper($datos14[0]["valor_comercial"]);
	$tipo_garantia2 = mb_strtoupper($datos14[0]["idkey_garantia_tipo"]);
	$g_liquida = mb_strtoupper($datos15[0]["idkey_gliquida"]);



}

if ($g_liquida == 1) {
	$g_liquida = "MAYOR";
}else{
	$g_liquida = "NECESARIA";
}


if ($id_conyuge == 4) {
	$nombre_relacion = $nombre_relacion;
}else{
	$nombre_relacion = "No aplica";
}


if ($frecuencia == 1) {
	$frecuencia = 'SEMANAL';
}elseif ($frecuencia == 2) {
	$frecuencia = 'QUINCENAL';
}elseif ($frecuencia == 3) {
	$frecuencia = 'MENSUAL';
}

if ($tipo_de_garantia == 6 ) {
	$tipo_de_garantia = 'INMUEBLE';
}
if ($tipo_garantia2 == 5) {
	$tipo_garantia2 = 'MUEBLE';
}

if ($finalidad == '') {
	$finalidad = "N/A";
}


$date1 = new DateTime($fecha_inicio);
$date2 = new DateTime($fecha_fin);
$diff = $date1->diff($date2);
// will output 2 days
$antiguedad = $diff->y ;

// $datos3 = $oconns->getRows("select telefono from clientes_contacto where idkey_clientes=".$idkey_cliente.";");
// if($oconns->numberRows>0){
// 	$telefono = mb_strtoupper($datos3[0]["telefono"]);
// }

$pdf = new myPDF();
$pdf->AliasNbPages();
$pdf->AddPage('P', 'A4', 0);

//tamañno de fuente

$pdf->SetFont('Arial', 'B', 10);

//cuerpo de cabecera

$pdf->SetTextColor(255,255,255);
$pdf->Cell(195,4, 'DATOS DEL SOLICITANTE',0,1,'C', 1);
$pdf->Cell(100,1,'',0,1,'L',0);

//datos del solicitante
//fila 1
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(23,4,'Nombre:',0,0,'L',0);

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(112,4,utf8_decode($nombre),0,0,'L',0);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(27,4,'No. Cliente:',0,0,'L',0);

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(45,4,utf8_decode($idkey_cliente),0,1,'L',0);

//fila 2
$pdf->SetFont('Arial', 'B',9);
$pdf->Cell(23,4,'Domicilio:',0,0,'L',0);

$pdf->SetFont('Arial', '',6);
$pdf->Cell(112,4,utf8_decode($domicilio1),0,0,'L',0);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(27,4,'RFC:',0,0,'L',0);

$pdf->SetFont('Arial', '',6);
$pdf->Cell(45,4,utf8_decode($rfc),0,1,'L',0);

//fila 3
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(23,4,'Ciudad:',0,0,'L',0);

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(112,4,utf8_decode($domicilio2),0,0,'L',0);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(27,4,'CURP:',0,0,'L',0);

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(45,4,utf8_decode($curp),0,1,'L',0);

//fila 4 x3
$pdf->SetFont('Arial', 'B',9);
$pdf->Cell(23,4,'Telefono:',0,0,'L',0);

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(40,4,utf8_decode($telefono),0,0,'L',0);

$pdf->SetFont('Arial', 'B',9);
$pdf->Cell(10,4,'C.P.:',0,0,'L',0);

$pdf->SetFont('Arial', '',6);
$pdf->Cell(62,4,utf8_decode($cp),0,0,'L',0);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(27,4,'Clave de elector:',0,0,'L',0);

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(45,4,utf8_decode($no_identificacion),0,1,'L',0);

//fila 5 x3
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(23,4,'Escolaridad:',0,0,'L',0);

$pdf->SetFont('Arial', '',6);
$pdf->Cell(40,4,utf8_decode($escolaridad),0,0,'L',0);

$pdf->SetFont('Arial', 'B',9);
$pdf->Cell(15,4,utf8_decode('Género: '),0,0,'L',0);

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(57,4,utf8_decode($sexo),0,0,'L',0);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(27,4,'Edad: ',0,0,'L',0);

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(45,4,utf8_decode($edad),0,1,'L',0);

//fila 6 x3
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(23,4,'Estado civil:',0,0,'L',0);

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(40,4,utf8_decode($estado_civil),0,0,'L',0);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(17,4,utf8_decode('Regimen: '),0,0,'L',0);

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(55,4,utf8_decode($regimen),0,0,'L',0);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(28,4,'Nombre conyuge: ',0,0,'L',0);

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(45,4,utf8_decode($nombre_relacion),0,1,'L',0);

$pdf->Cell(100,1,'',0,1,'L',0);

//Actividad econocmica
$pdf->SetTextColor(255,255,255);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(195,4, 'ACTIVIDAD ECONOMICA',0,1,'C', 1);

$pdf->Cell(100,1,'',0,1,'L',0);

$pdf->SetTextColor(0,0,0);
//fila1
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(23,4,'Tipo:',0,0,'L',0);

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(100,4,utf8_decode($tipo),0,1,'L',0);

//fila2
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(23,4,utf8_decode('Antigüedad:'),0,0,'L',0);

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(120,4,utf8_decode($antiguedad." AÑO(S)"),0,1,'L',0);

//fila3
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(23,4,'Empresa:',0,0,'L',0);

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(120,4,utf8_decode($profesion),0,1,'L',0);

//fila4
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(23,4,utf8_decode('Ocupación'),0,0,'L',0);

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(120,4,utf8_decode($ocupacion),0,1,'L',0);

//fila5
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(23,4,'Domicilio:',0,0,'L',0);

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(120,4,utf8_decode($ingreso_direccion),0,1,'L',0);

//fila6
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(23,4,'Telefono:',0,0,'L',0);

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(120,4,utf8_decode($telefono),0,1,'L',0);

$pdf->Cell(100,1,'',0,1,'L',0);

//Datos econocmica
$pdf->SetTextColor(255,255,255);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(195,4, 'DATOS ECONOMICOS',0,1,'C', 1);

$pdf->Cell(100,1,'',0,1,'L',0);

$pdf->SetTextColor(0,0,0);

//fila 1
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(30,4,'Vivienda:',0,0,'L',0);

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(60,4,utf8_decode($tipo_vivienda),0,0,'L',0);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(40,4,utf8_decode('Antigüedad: '),0,0,'L',0);

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(55,4,utf8_decode($antiguedad_vivienda." AÑO(S)"),0,1,'L',0);

//fila 2
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(30,4,'Ingresos:',0,0,'L',0);

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(60,4,utf8_decode($ingresos),0,0,'L',0);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(40,4,utf8_decode('Valor de propiedades: '),0,0,'L',0);

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(55,4,utf8_decode($valor_comercial),0,1,'L',0);

//fila 3
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(30,4,'Gastos:',0,0,'L',0);

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(60,4,utf8_decode($egresos),0,0,'L',0);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(40,4,utf8_decode('Antigüedad: '),0,0,'L',0);

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(55,4,utf8_decode($anios_laborales),0,1,'L',0);

$pdf->Cell(100,1,'',0,1,'L',0);

//Datos del credito
$pdf->SetTextColor(255,255,255);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(195,4, 'DATOS DEL CREDITO',0,1,'C', 1);

$pdf->Cell(100,1,'',0,1,'L',0);
$pdf->SetTextColor(0,0,0);
//fila 1
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(50,4,'Prestamo:',0,0,'L',0);

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(70,4,utf8_decode($nombre_producto),0,1,'L',0);

//fila 2
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(50,4,'Finalidad:',0,0,'L',0);

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(70,4,utf8_decode($finalidad),0,0,'L',0);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(40,4,utf8_decode('Cantidad solicitada: '),0,0,'L',0);

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(35,4,utf8_decode($monto),0,1,'L',0);

//fila 3
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(50,4,'Plazo:',0,0,'L',0);

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(70,4,utf8_decode($plazo),0,0,'L',0);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(40,4,utf8_decode('Modalidad de pago: '),0,0,'L',0);

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(35,4,utf8_decode($frecuencia),0,1,'L',0);

//fila 4
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(50,4,'Tipo de respaldo de credito:',0,0,'L',0);

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(70,4,utf8_decode('N/A'),0,0,'L',0);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(40,4,utf8_decode('Tasa normal: '),0,0,'L',0);

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(35,4,utf8_decode($tasa_interes),0,1,'L',0);

$pdf->Cell(100,1,'',0,1,'L',0);

//Datos econocmica
$pdf->SetTextColor(255,255,255);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(195,4, 'GARANTIAS OFRECIDAS',0,1,'C', 1);

$pdf->Cell(100,1,'',0,1,'L',0);
$pdf->SetTextColor(0,0,0);
//fila 1
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(30,4,utf8_decode('Garantía líquida: '),0,0,'L',0);

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(70,4,utf8_decode($g_liquida),0,0,'L',0);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(40,4,utf8_decode('Tipo de garantía: '),0,0,'L',0);

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(55,4,utf8_decode($tipo_de_garantia),0,1,'L',0);

//fila 2
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(30,4,utf8_decode('Tipo de garantía: '),0,0,'L',0);

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(70,4,utf8_decode($tipo_garantia2),0,0,'L',0);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(40,4,utf8_decode('Total: '),0,0,'L',0);

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(55,4,utf8_decode($valor_fiscal),0,1,'L',0);

//fila3
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(30,4,utf8_decode('Valor comercial: '),0,0,'L',0);

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(165,4,utf8_decode($valor_garantia2),0,1,'L',0);


$pdf->Cell(100,1,'',0,1,'L',0);

//reporte interno

$pdf->SetFillColor(161,161,161);
$pdf->SetTextColor(225, 225, 225);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(195,4, 'HISTORIAL DE PRODECO (REPORTE INTERNO)',1,1,'L', 1);

$pdf->Cell(100,1,'',0,1,'L',0);
$pdf->SetTextColor(0,0,0);

//fila1
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(30,4,'No ciclo :',0,0,'L',0);

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(40,4,utf8_decode(''),0,0,'L',0);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(13,4,utf8_decode('Años: '),0,0,'L',0);

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(37,4,utf8_decode(''),0,0,'L',0);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(30,4,'Promotor:',0,0,'L',0);

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(45,4,utf8_decode(''),0,1,'L',0);


//fila2
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(62,4,'CICLOS EN QUE INCURRIO EN MORA :',0,0,'L',0);

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(10,4,utf8_decode(''),0,0,'L',0);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(35,4,utf8_decode('MAX DIAS DE MORA: '),0,0,'L',0);

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(10,4,utf8_decode(''),0,0,'L',0);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(65,4,'DIAS DE MORA EN EL CICLO ANTERIOR:',0,0,'L',0);

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(13,4,utf8_decode(''),0,1,'L',0);

$pdf->Cell(100,1,'',0,1,'L',0);

//AVALES
$pdf->SetFillColor(0,0,0);
$pdf->SetTextColor(255,255,255);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(195,4, 'AVALES',0,1,'C', 1);

$pdf->Cell(100,1,'',0,1,'L',0);
$pdf->SetTextColor(0,0,0);


//fila 1
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(40,4,'No cliente:',0,0,'L',0);

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(60,4,utf8_decode($no_cliente_aval1),0,0,'L',0);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(35,4,'No. cliente:',0,0,'L',0);

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(60,4,utf8_decode($no_cliente_aval2),0,1,'L',0);

//fila 2
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(40,4,'Nombre:',0,0,'L',0);

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(60,4,utf8_decode($nombre_aval1),0,0,'L',0);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(35,4,'Nombre: ',0,0,'L',0);

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(60,4,utf8_decode($nombre_aval2),0,1,'L',0);

//fila 3
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(40,4,'CURP:',0,0,'L',0);

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(60,4,utf8_decode(''),0,0,'L',0);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(35,4,'CURP:',0,0,'L',0);

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(60,4,utf8_decode(''),0,1,'L',0);

//fila 4
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(40,4,'Clave de elector:',0,0,'L',0);

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(60,4,utf8_decode(''),0,0,'L',0);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(35,4,'Clave de elector:',0,0,'L',0);

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(60,4,utf8_decode(''),0,1,'L',0);

//fila 5
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(40,4,utf8_decode('Dirección:'),0,0,'L',0);

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(60,4,utf8_decode(''),0,0,'L',0);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(35,4,utf8_decode('Dirección:'),0,0,'L',0);

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(60,4,utf8_decode(''),0,1,'L',0);

//fila 6
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(40,4,'Ciudad:',0,0,'L',0);

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(60,4,utf8_decode(''),0,0,'L',0);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(35,4,'Ciudad',0,0,'L',0);

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(60,4,utf8_decode(''),0,1,'L',0);

//fila 1
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(40,4,'Estado:',0,0,'L',0);

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(60,4,utf8_decode(''),0,0,'L',0);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(35,4,'Estado:',0,0,'L',0);

$pdf->SetFont('Arial', '', 6);
$pdf->Cell(60,4,utf8_decode(''),0,1,'L',0);

$pdf->Cell(60,4,utf8_decode(''),0,1,'L',0);

//firmas
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(40,4,'Firma:',0,0,'L',0);

$pdf->SetFont('Arial', '', 10);
$pdf->Cell(60,4,utf8_decode('______________________'),0,0,'L',0);


$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(40,4,'Firma :',0,'L',0);

$pdf->SetFont('Arial', '', 10);
$pdf->Cell(60,4,utf8_decode('______________________'),0,1,'L',0);
$pdf->Cell(40,4,'',0,0,'L',0);
$pdf->Cell(40,5,'Solidario',0,0,'C',0);
$pdf->Cell(60,4,'',0,0,'L',0);
$pdf->Cell(40,5,'Aval',0,0,'C',0);



$pdf->Cell(60,4,utf8_decode(''),0,1,'L',0);
//AVALES
$pdf->SetFillColor(0,0,0);
$pdf->SetTextColor(255,255,255);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(95,4, 'CROQUIS DEL DOMICILIO',0,0,'L', 1);
$pdf->Cell(100,4, 'CROQUIS DEL NEGOCIO',0,0,'L', 1);

$pdf->Cell(100,1,'',0,1,'L',0);
$pdf->SetTextColor(0,0,0);

//croquis
$pdf->Image('croquis.jpeg',6,220,200);
$pdf->AddPage('P', 'A4', 0);

$pdf->Cell(100,1,'',0,1,'L',0);

//VISTO BUENDO DEL AREA OPERATIVA

$pdf->SetTextColor(255,255,255);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(195,4, 'VISTO BUENO DEL AREA OPERATIVA',0,1,'C', 1);

$pdf->Cell(100,1,'',0,1,'L',0);
$pdf->SetTextColor(0,0,0);

$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(195, 3, utf8_decode('DESPUÉS DE HABER REVISADO, TANTO EL EXPEDIENTE DE CRÉDITO, COMO LA SOLICITUD DE CREDITO, PRESENTADA POR EL ASESOR DE SERVICIOS FINANCIEROS; EN TERMINOS DEL MANUAL DE CRÉDITO Y REGLAMENTO DEL COMITÉ DE CRÉDITO, ESTA AREA OPERATIVA HA DECIDIDO:'), 0, 'J', 0);

$pdf->Ln(5);
$pdf->Cell(195,10,'________________________________________',0,1,'C',0);

$pdf->Ln(2);

$pdf->MultiCell(195, 3, utf8_decode('DE PRE-AUTORIZARSE LA SOLICITUD, SERÁ SOMETIDA A ANÁLISIS DEL COMITÉ DE CRÉDITO A EFECTO DE QUE DECIDA SI SE AUTORIZA DEFINITIVAMENTE, SE RECHAZA O SE DEVUELVE PARA ACLARACIÓN. EN CASO DE AUTORIZARSE DEFINITIVAMENTE, SOLO EL COMITÉ DE CRÉDITO, PUEDE SEÑALAR LAS CARACTERÍSTICAS Y MODALIDADES DE OTORGAMIENTO DEFINITIVO.
'), 0, 'J', 0);

$pdf->Ln(2);

$pdf->Cell(195, 10, utf8_decode('BARRA DE NAVIDAD, SANTA MARIA COLOTEPEC, OAX. A LOS 2 DÍAS DEL MES DE MARZO DE 2020
'), 0,1, 'R');

$pdf->Ln(2);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(96, 10, 'REVISARON', 0, 0, 'L');
$pdf->Cell(96, 10, 'VISTO BUENO', 0, 1, 'L');
$pdf->Ln(5);
$pdf->Cell(96, 10, 'SUPERVISORES DE OPERACIONES', 0, 0, 'L');
$pdf->Cell(96, 10, 'GERENTE DE OPERACIONES/GENERAL', 0, 1, 'L');


//FUNCIONES PUBLICAS DESTACADAS
$pdf->SetTextColor(255,255,255);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(195,4, "FUNCIONES PUBLICAS DESTACADAS (PEP'S)",0,1,'C', 1);

$pdf->Cell(100,1,'',0,1,'L',0);
$pdf->SetTextColor(0,0,0);

//datos de funciones publicas
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(170,4,utf8_decode("¿Desempeña o ha desempeñado funciones publicas destacadas en un país extranjero o en territorio nacional?"),0,0,'L', 0);
$pdf->Cell(25, 4, 'NO (__)', 0, 1, 'L');

$pdf->SetFont('Arial', '', 9);
$pdf->Cell(170,4,utf8_decode("En caso de que la respuesta sea afirmativa, especificar lo siguiente: "),0,1,'L', 0);
$pdf->Ln(2);

$pdf->Cell(60, 3, utf8_decode("País/Ciudad:{} "), 0, 0, 'L');
$pdf->Cell(60, 3, utf8_decode("Cargo/Puesto:{}"), 0, 0, 'L');
$pdf->Cell(60, 3, utf8_decode("Periodo:{}"), 0, 1, 'L');

$pdf->Ln(3);

$pdf->SetFont('Arial', 'B', 9);
$pdf->MultiCell(170,4,utf8_decode("Su conyuge/concubina(o) ¿Desempeña o ha desempeñado funciones públicas destacadas en un país extranjero o en territorio nacional?"),0,'L', 0);
$pdf->Cell(184, 1, 'NO (__)', 0, 1, 'R');
$pdf->Ln(1);

$pdf->SetFont('Arial', '', 9);
$pdf->Cell(170,4,utf8_decode("En caso de que la respuesta sea afirmativa, especificar lo siguiente: "),0,1,'L', 0);

$pdf->Ln(2);

$pdf->Cell(60, 3, utf8_decode("País/Ciudad: "), 0, 0, 'L');
$pdf->Cell(60, 3, utf8_decode("Cargo/Puesto:"), 0, 0, 'L');
$pdf->Cell(60, 3, utf8_decode("Periodo:"), 0, 1, 'L');

$pdf->Ln(3);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(170,3,utf8_decode("De las siguientes personas, señale si alguna Desempeña o ha desempeñado funciones públicas destacadas en"),0,1,'L', 0);
$pdf->Cell(165,3,utf8_decode("un país extranjero o en territorio nacional."),0,0,'L', 0);
$pdf->Cell(30, 4, 'SI (__)   NO (__)', 0, 1, 'L');
$pdf->Ln(1);

$pdf->Cell(46, 4, 'Padre(s)', 0, 0, 'L');
$pdf->Cell(46, 4, 'Hijo(s)', 0, 0, 'L');
$pdf->Cell(46, 4, 'Suegro(s)', 0, 0, 'L');
$pdf->Cell(46, 4, 'Yerno/Nuera', 0, 1, 'L');
$pdf->Ln(1);

$pdf->Cell(46, 4, 'Abuelos', 0, 0, 'L');
$pdf->Cell(46, 4, 'Nietos', 0, 0, 'L');
$pdf->Cell(46, 4, 'Hermanos', 0, 0, 'L');
$pdf->Cell(46, 4, utf8_decode('Cuñados'), 0, 1, 'L');

$pdf->SetFont('Arial', '', 9);

$pdf->Cell(170, 4, utf8_decode('Especificar lo siguiente:'), 0, 1, 'L');
$pdf->Cell(170, 4, utf8_decode("Nombre completo: "), 0, 1, 'L');

$pdf->Cell(60, 3, utf8_decode("País/Ciudad: "), 0, 0, 'L');
$pdf->Cell(60, 3, utf8_decode("Cargo/Puesto:"), 0, 0, 'L');
$pdf->Cell(60, 3, utf8_decode("Periodo:"), 0, 1, 'L');

$pdf->Ln(1);


//OPERACIONES
$pdf->SetTextColor(255,255,255);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(195,4, "OPERACIONES",0,1,'C', 1);

$pdf->Ln(3);
$pdf->SetFont('Arial', '', 9);
$pdf->SetTextColor(0,0,0);

$pdf->Cell(150, 4, utf8_decode("Operación a realizar: "), 0, 1, 'L');

$pdf->Cell(90, 4, utf8_decode("Monto de operaciones de: "), 0, 0, 'L');
$pdf->Cell(90, 4, utf8_decode("Frecuencia: "), 0, 1, 'L');
$pdf->Ln(1);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(150, 4, utf8_decode("Origen y destino de los recursos involucrados para la celebración de las operaciones: "), 0, 1, 'L');

$pdf->SetFont('Arial', '', 9);

$pdf->Cell(45, 3, utf8_decode("Origen: "), 0, 0, 'L');
$pdf->Cell(45, 3, utf8_decode("Nacional: "), 0, 0, 'L');
$pdf->Cell(45, 3, utf8_decode("Extranjero: "), 0, 0, 'L');
$pdf->Cell(45, 3, utf8_decode("especifica orígen: "), 0, 1, 'L');

$pdf->Ln(2);

$pdf->Cell(45, 3, utf8_decode("Origen: "), 0, 0, 'L');
$pdf->Cell(45, 3, utf8_decode("Nacional: "), 0, 0, 'L');
$pdf->Cell(45, 3, utf8_decode("Extranjero: "), 0, 0, 'L');
$pdf->Cell(45, 3, utf8_decode("especifica orígen: "), 0, 1, 'L');
$pdf->Ln(1);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(150, 4, utf8_decode("¿Tiene relación con algún socio de PRODECO? "), 0, 0, 'L');
$pdf->Cell(45, 4, utf8_decode("SI (__)    NO(__)"), 0, 1, 'L');
$pdf->Ln(2);

$pdf->SetFont('Arial', '', 9);
$pdf->Cell(45, 3, utf8_decode("Tipo: "), 0, 1, 'L');
$pdf->Ln(1);
$pdf->Cell(100, 3, utf8_decode("Nombre completo: "), 0, 1, 'L');
$pdf->Ln(1);

$pdf->Cell(100, 3, utf8_decode("Conoce la existencia de algún beneficiario: "), 0, 0, 'L');
$pdf->Cell(95, 3, utf8_decode("SI (__)    NO(__)"), 0, 1, 'L');
$pdf->Ln(1);

$pdf->Cell(100, 3, utf8_decode("Conoce la existencia del algún proveedor de recursos: "), 0, 0, 'L');
$pdf->Cell(95, 3, utf8_decode("SI (__)    NO(__)"), 0, 1, 'L');
$pdf->Ln(1);

$pdf->Cell(100, 3, utf8_decode("Conoce la existencia de algún propietario legal: "), 0, 0, 'L');
$pdf->Cell(95, 3, utf8_decode("SI (__)    NO(__)"), 0, 1, 'L');

//firmas

$pdf->Ln(15);

$pdf->Cell(97, 4, utf8_decode($nombre), 0, 0, 'C');
$pdf->Cell(97, 4, utf8_decode('JUAN SANCHEZ MARTINEZ'), 0, 1, 'C');

$pdf->Cell(97, 1, utf8_decode('________________________________________________'), 0, 0, 'C');
$pdf->Cell(97, 1, utf8_decode('________________________________________________'), 0, 1, 'C');

$pdf->Ln(2);

$pdf->Cell(97, 4, utf8_decode('FIRMAL DEL SOLICITANTE'), 0, 0, 'C');
$pdf->Cell(97, 4, utf8_decode('FIRMA DEL ASESOR DE SERVICIOS FINANCIEROS
'), 0, 1, 'C');

$pdf->AddPage('P', 'A4', 0);

$pdf->SetTextColor(255,255,255);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(195,4, "* DECLARACIONES",0,1,'C', 1);

$pdf->Ln(3);
$pdf->SetFont('Arial', '', 8);
$pdf->SetTextColor(0,0,0);

$pdf->Cell(195, 4, utf8_decode("* Yo $nombre , entrevistado, en este acto declaro que actuó"),0,1,'L');

$pdf->MultiCell(195, 5, utf8_decode('A nombre y por cuenta: _____________________________________________________________________; (de ser el caso) El tercero es una persona:_____________________, que responde al nombre de_____________________________________ ______________________________________________________________________________________________________
'), 0, 'J', 0);

$pdf->Ln(2);

$pdf->MultiCell(195, 5, utf8_decode('*B. Igualmente, declaro que el origen y procedencia de los fondos que por cuenta propia o en representación habré de operar u opero, proceden de actividades lícitas. Asimismo manifiesto que los datos y documentación proporcionada en este acto son verídicos, entre ellos mis datos de identificación y los de mi Representado(o) y/o Beneficiario y/o Proveedor de recursos y/o Propietario real, de ser el caso. Presento original y otorgo copia fotostática de los documentos de identificación y autorizo a que se corrobore esta información de estimarse conveniente. Autorizo expresamente para utilizar la presente información a PRODUCCION ECOTURISTICA COLOTEPEC SC. DE R.S. DE C.V, al contratar cualquier producto o servicio financiero con ella, o con motivo de la relación que se mantiene o llegue a mantener con la misma. La autorización que se otorga implica la aceptación para que esta información se utilice por terceros distintos a PRODUCCIÓN ECOTURISTICA COLOTEPEC S.C. DE R.S. DE C.V., con la finalidad de cumplirse con las obligaciones estipuladas en las operaciones contratadas. Declaro que ni yo ni terceros operamos, con mi consentimiento o el de mi representante y/o representada en los productos, cuentas, contrato o servicios donde actuo y opero; con recursos provenientes de actividades ilícitas y asimismo manifiesto que no se realizaron operaciones destinadas a favorecer actividades ilícitas'), 0, 'J', 0);

$pdf->Ln(2);

$pdf->MultiCell(195, 5, utf8_decode('*C. Así mismo, autorizo a PRODUCCION ECOTURISTICA COLOTEPEC SC. DE R.S. DE C.V, para que lleve a cabo investigaciones y monitoreo periódico sobre mi (y el de mi representada) comportamiento crediticio en las sociedades que estime conveniente. Declaro que conozco la naturaleza y alcance de la información que solicitará, del uso que se le dará y de que ésta podrá realizar consultas periódicas de mi historial crediticio; consintiendo en que esta autorización se encontrará vigente por un periodo de tres años contados a partir de la fecha de firma del presente documento, y en su caso, durante el tiempo que se mantenga la relación contractual.'), 0, 'J', 0);

$pdf->Ln(2);

$pdf->MultiCell(195, 5, utf8_decode('*D. Igualmente, declaro, de ser una persona fisica, y actualmente si (__) no (__) me encuentro dado de alta ante las autoridades fiscales, con el Registro Federal de Contribuyente:________________________.'), 0, 'J', 0);

$pdf->Ln(2);

$pdf->MultiCell(195, 5, utf8_decode('*E. Igualmente, declaro, de ser el caso, que PRODUCCION ECOTURISTICA COLOTEPEC SC. DE R.S. DE C.V, ha invitado (a mí y a mi representada) a darnos de alta ante las autoridades fiscales, y tramitar el Registro Federal de Contribuyente.'), 0, 'J', 0);

$pdf->Ln(2);

$pdf->MultiCell(195, 5, utf8_decode('*F. Y por último, declaro que con anterioridad a la celebración del presente, PRODUCCION ECOTURISTICA COLOTEPEC SC. DE R.S. DE C.V, me explicó el tratamiento que le dará a mis datos personales.'), 0, 'J', 0);

$pdf->Ln(2);
$pdf->SetFont('Arial', 'B', 8);
$pdf->MultiCell(195, 4, utf8_decode('*Para efectos de la celebración de esta entrevista, a)_________________________________________________________________________ entrega a la PRODUCCION ECOTURISTICA COLOTEPEC SC. DE R.S. DE C.V, DOCUEMTOS de, b)___________________________________ en mi calidad de, c)____________________________________________________________________________________________________ que se indica a continuación. SEÑALE CON UNA X EL DOCUMENTO QUE ENTREGA.'), 0, 'J', 0);

$pdf->Ln(2);
$pdf->SetFont('Arial', '', 8);

$pdf->MultiCell(195, 4, utf8_decode('1) Identificación personal. Emitida por autoridades competentes y vigentes a la fecha de su presentación, y en donde conste fotografía, domicilio y firma del portador.'), 0, 'J', 0);

$pdf->Ln(1);

$pdf->Cell(10, 4, '', 0,0,'C');
$pdf->Cell(5, 4, '', 1,0,'C');

$pdf->Cell(5, 4, '', 0,0,'C');
$pdf->Cell(50, 4, 'Credeencial para votar', 0,1,'L');

$pdf->Ln(1);

$pdf->Cell(10, 4, '', 0,0,'C');
$pdf->Cell(5, 4, '', 1,0,'C');

$pdf->Cell(5, 4, '', 0,0,'C');
$pdf->Cell(100, 4, 'Otro:______________________________________________________________________________', 0,1,'L');

$pdf->Ln(1);
$pdf->MultiCell(195, 4, utf8_decode('2) Constancia de la Clave Única del Registro de Población (CURP), cuando cuenten con ella.'), 0, 'J', 0);

$pdf->Ln(1);

$pdf->Cell(10, 4, '', 0,0,'C');
$pdf->Cell(5, 4, '', 1,1,'C');

$pdf->Ln(1);
$pdf->MultiCell(195, 4, utf8_decode('3) Cédula de identificación Fiscal, cuando cuente con ella.'), 0, 'J', 0);

$pdf->Ln(1);

$pdf->Cell(10, 4, '', 0,0,'C');
$pdf->Cell(5, 4, '', 1,1,'C');


$pdf->Ln(1);

$pdf->MultiCell(195, 4, utf8_decode('4) Comprobante de domicilio particular y/o de residencia permanente y / o de correspondencia, con antigüedad no mayor a tres meses contados a partir de su fecha de emisión; excepto: contrato de arrendamiento, inscripción ante el Registro Federal de Contribuyentes y testimonio o copia certificada que acredite que el cliente es legitimo propietario del inmueble que señalo como domicilio actual y permanente.'), 0, 'J', 0);

$pdf->Ln(1);

$pdf->Cell(10, 4, '', 0,0,'C');
$pdf->Cell(5, 4, '', 1,0,'C');

$pdf->Cell(5, 4, '', 0,0,'C');
$pdf->Cell(50, 4, utf8_decode("Suministro de energía eléctrica"), 0,1,'L');

$pdf->Ln(1);

$pdf->Cell(10, 4, '', 0,0,'C');
$pdf->Cell(5, 4, '', 1,0,'C');

$pdf->Cell(5, 4, '', 0,0,'C');
$pdf->Cell(100, 4, 'Otro:______________________________________________________________________________', 0,1,'L');

$pdf->Ln(9);
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(97, 3, utf8_decode($nombre), 0, 0, 'C');
$pdf->Cell(97, 3, utf8_decode('JUAN SANCHEZ MARTINEZ'), 0, 1, 'C');

$pdf->Cell(97, 1, utf8_decode('________________________________________________'), 0, 0, 'C');
$pdf->Cell(97, 1, utf8_decode('________________________________________________'), 0, 1, 'C');

$pdf->Ln(2);

$pdf->Cell(97, 3, utf8_decode('FIRMAL DEL SOLICITANTE'), 0, 0, 'C');
$pdf->Cell(97, 3, utf8_decode('FIRMA DEL ASESOR DE SERVICIOS FINANCIEROS
'), 0, 1, 'C');



$pdf->Output();




 ?>