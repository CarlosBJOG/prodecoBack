<?php 

require('fpdf.php');
require ('../php/clases/conversor.php');
require ('strfecha.php');
require ('../php/db.php');


$oconns = new database();
$idkey_credito = $_GET["idkey_credito"];
$idkey_grupo = $_GET["idkey_grupo"];

$datos1  = $oconns->getRows("select nombre_grupo, nombre, idkey_cliente, monto, tasa_interes from view_clientes_grupo where idkey_credito =".$idkey_credito.";");
$datos2  = $oconns->getRows("select  monto, porcentaje, tabla_amortizacion, idkey_clientes from grupos_clientes where idkey_grupo =".$idkey_grupo.";");
 $idkey_cliente_1 = $datos2[0]['idkey_clientes'];
// $idkey_cliente_2 = $datos2[1]['idkey_clientes'];
// $idkey_cliente_3 = $datos2[2]['idkey_clientes'];

// $datos3 = $oconns->getRows("SELECT curp FROM view_clientes WHERE idkey_cliente = $idkey_cliente_1 ");
// $datos4 = $oconns->getRows("SELECT curp FROM view_clientes WHERE idkey_cliente = $idkey_cliente_2 ");
// $datos5 = $oconns->getRows("SELECT curp FROM view_clientes WHERE idkey_cliente = $idkey_cliente_3 ");
$datos6 = $oconns->getRows("SELECT nombre_loc FROM view_direcciones WHERE idkey_cliente = $idkey_cliente_1");
$datos7 = $oconns->getRows("SELECT plazo, monto FROM view_cred_grupales WHERE idkey_credito = $idkey_credito");
$datos8 = $oconns->getRows("SELECT iva FROM creditos where idkey = $idkey_credito");




if($oconns->numberRows>0){

	$nombre_grupo= mb_strtoupper($datos1[0]["nombre_grupo"]);
	// $nombre_1 = mb_strtoupper($datos1[0]["nombre"]);
	// $nombre_2 = mb_strtoupper($datos1[1]["nombre"]);
	// $nombre_3 = mb_strtoupper($datos1[2]["nombre"]);
	$tasa_interes = mb_strtoupper($datos1[0]["tasa_interes"]);
	$monto_total = mb_strtoupper($datos7[0]["monto"]);
	// $monto_1 = mb_strtoupper($datos2[0]["monto"]);
	// $monto_2 = mb_strtoupper($datos2[1]["monto"]);
	// $monto_3 = mb_strtoupper($datos2[2]["monto"]);
	// $curp_1 = mb_strtoupper($datos3[0]["curp"]);
	// $curp_2 = mb_strtoupper($datos4[0]["curp"]);
	// $curp_3 = mb_strtoupper($datos5[0]["curp"]); 
	 $amortizacion = mb_strtoupper($datos2[0]["tabla_amortizacion"]); 
	 $localidad = mb_strtoupper($datos6[0]['nombre_loc']);
	 $plazo = mb_strtoupper($datos7[0]['plazo']);
	 $iva = mb_strtoupper($datos8[0]['iva']);

}

//var_dump(json_decode($amortizacion));
$numero_integrantes = sizeof($datos1);
$tasa_interes_mensual = $tasa_interes / 12;


$pdf=new FPDF('L','mm','A4');
$pdf->AddPage();

$pdf->SetFont('Arial','B',10);

$pdf->SetFillColor(161,161,161);
$pdf->SetTextColor(255,255,255);
$pdf->Cell(70,4, 'SOLICITUD DE CREDITO GRUPAL',1,0,'C', 1);
$pdf->Cell(70,4,utf8_decode($nombre_grupo),1,0,'R',1);
$pdf->Cell(70,4,'CICLO',1,0,'R',1);
$pdf->Cell(70,4,'16',1,1,'R',1);

$pdf->Ln(5);
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(160,4, 'FECHA Y HORA:',0,0,'R', 1);
$pdf->Cell(80,4,'______________________________________',0,1,'R',1);

$pdf->Ln(5);

$pdf->Cell(160,4, 'LOCALIDAD:',0,0,'R', 1);
$pdf->Cell(80,4,'______________________________________',0,1,'R',1);

$pdf->Ln(5);

$pdf->Cell(50,4, 'PRODUCCION ECOTURISTICA DE COLOTEPC S.C. DE R.S. DE C.V.
PRESENTE.:',0,0,'L', 1);

$pdf->Ln(10);

$pdf->SetFont('Arial','',9);
$pdf->MultiCell(250, 5, utf8_decode('Por medio de la presente, y con el debido respeto, los integrantes del grupo solidario que se indica, hemos acordado por unanimidad realizar la siguiente solicitud de crédito a fecto de porder financiar nuestras actividades productivas comerciales, las cuales bajo protesta de decir la verdad son totalmente legales y viables. Por lo que en este sentido, de ser aprobada la presente solicitud, el Grupo se compromete en forma solidaria a cumplir totalmente con el pago del 100% del monto solicitado, incluido los intereses acordados, de todas y cada una de los integrantes, para lo cuál firmará un pagaré a PRODECO Como testimonio y deacuerdo con los términos del préstamo, detallamos y firmamos nuestra solicitud.'), 0, 'J', 0);

$pdf->Ln(10);

$pdf->SetFont('Arial','',8);
$pdf->Cell(110,4, '',0,0,'R', 1);
$pdf->Cell(50,5, 'NOMBRE DEL GRUPO: ',1,0,'L', 1);
$pdf->Cell(60,5, utf8_decode($nombre_grupo),1,0,'L', 1);
$pdf->Cell(30,5, utf8_decode('AMORTIZACIONES'),1,0,'L', 1);
$pdf->Cell(30,5, utf8_decode(''),1,1,'L', 1);

$pdf->Cell(110,4, '',0,0,'R', 1);
$pdf->Cell(50,5, 'LOCALIDAD: ',1,0,'L', 1);
$pdf->Cell(60,5, utf8_decode($localidad),1,0,'L', 1);
$pdf->Cell(30,5, utf8_decode('TASA (MENSUAL)'),1,0,'L', 1);
$pdf->Cell(30,5, utf8_decode($tasa_interes_mensual.'%'),1,1,'L', 1);


$pdf->Cell(110,4, '',0,0,'R', 1);
$pdf->Cell(50,5, 'NUMERO DE INTEGRANTES: ',1,0,'L', 1);
$pdf->Cell(60,5, utf8_decode($numero_integrantes),1,0,'L', 1);
$pdf->Cell(30,5, utf8_decode('INTERES'),1,0,'L', 1);
$pdf->Cell(30,5, utf8_decode($tasa_interes),1,1,'L', 1);


$pdf->Cell(110,4, '',0,0,'R', 1);
$pdf->Cell(50,5, 'MONTO GRUPAL SOLICITADO: ',1,0,'L', 1);
$pdf->Cell(60,5, utf8_decode(round($monto_total, 2)),1,0,'L', 1);
$pdf->Cell(30,5, utf8_decode('IVA'),1,0,'L', 1);
$pdf->Cell(30,5, utf8_decode($iva),1,1,'L', 1);


$pdf->Cell(110,4, '',0,0,'R', 1);
$pdf->Cell(50,5, 'PLAZO(MENSUAL): ',1,0,'L', 1);
$pdf->Cell(60,5, utf8_decode($plazo),1,0,'L', 1);
$pdf->Cell(30,5, utf8_decode('CUOTA SEMANAL'),1,0,'L', 1);
$pdf->Cell(30,5, utf8_decode(''),1,1,'L', 1);

$pdf->Ln(10);


$pdf->SetFillColor(0,0,0);
$pdf->SetTextColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(280,10, 'DATOS DE LA SOLICITUD GRUPAL',1,1,'C', 1);

$pdf->SetFillColor(112, 209, 255);
$pdf->SetTextColor(0, 0, 0);

$pdf->Cell(50,10, 'NOMBRE',1,0,'L', 1);
$pdf->Cell(50,10, 'No. Cliente',1,0,'L', 1);
$pdf->Cell(50,10, 'MONTO SOLICITADO',1,0,'L', 1);
$pdf->Cell(90,10, 'ACTIVIDAD A FINANCIAR',1,0,'L', 1);
$pdf->Cell(40,10, 'FIRMA',1,1,'L', 1);



$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',8);
foreach ($datos1 as $dato) {

	$pdf->Cell(50,10, utf8_decode(mb_strtoupper($dato['nombre'])),1,0,'L', 1);
	$pdf->Cell(50,10, utf8_decode(mb_strtoupper($dato['idkey_cliente'])),1,0,'L', 1);
	$pdf->Cell(50,10, utf8_decode(mb_strtoupper($dato['monto'])),1,0,'L', 1);
	$pdf->Cell(90,10, utf8_decode('N/A'),1,0,'L', 1);
	$pdf->Cell(40,10, utf8_decode('_______________________'),1,1,'L', 1);

}
// $pdf->SetFillColor(255,255,255);
// $pdf->SetFont('Arial','B',9);
// $pdf->Cell(50,10, utf8_decode($nombre_1),1,0,'L', 1);
// $pdf->Cell(50,10, utf8_decode($curp_1),1,0,'L', 1);
// $pdf->Cell(50,10, utf8_decode('$ '.$monto_1),1,0,'L', 1);
// $pdf->Cell(90,10, '',1,0,'L', 1);
// $pdf->Cell(40,10, '____________________',1,1,'L', 1);

// $pdf->SetFillColor(112, 209, 255);

// $pdf->Cell(50,10, utf8_decode($nombre_2),1,0,'L', 1);
// $pdf->Cell(50,10, utf8_decode($curp_2),1,0,'L', 1);
// $pdf->Cell(50,10, utf8_decode('$ '.$monto_2),1,0,'L', 1);
// $pdf->Cell(90,10, '',1,0,'L', 1);
// $pdf->Cell(40,10, '____________________',1,1,'L', 1);

// $pdf->SetFillColor(255,255,255);

// $pdf->Cell(50,10, utf8_decode($nombre_3),1,0,'L', 1);
// $pdf->Cell(50,10, utf8_decode($curp_3),1,0,'L', 1);
// $pdf->Cell(50,10, utf8_decode('$ '.$monto_3),1,0,'L', 1);
// $pdf->Cell(90,10, '',1,0,'L', 1);
// $pdf->Cell(40,10, '____________________',1,1,'L', 1);


$pdf->Output();





 ?>