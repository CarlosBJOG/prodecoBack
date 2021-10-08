<?php 

require('./fpdf.php');
require ('../php/clases/conversor.php');
require ('strfecha.php');
require ('../php/db.php');
@session_start();

$idkey_pago = $_GET["idkey_pago"];

$oconns = new database();
$datos = $oconns->getRows("SELECT no_pago, fecha_valor, pago, interes, iva, idkey_creditos, idkey_amortizacion, amortizacion, monto, pago_interes_moratorio, saldo_insoluto FROM amortizaciones_dinamicas WHERE idkey ='".$idkey_pago."'" );
if($oconns->numberRows==0){
	echo "<script>alert('Error de referencia del pago!!');</script>";
	exit;
}
$idkey_credito = $datos[0]["idkey_creditos"];
$folio = $datos[0]['idkey_amortizacion'];

$datos2 = $oconns->getRows("SELECT descripcion from amortizaciones where idkey = '".$folio."' ;");

$datos3 = $oconns->getRows("select nombre, nombre_producto from view_creditos where idkey_credito = '".$idkey_credito."';");

// var_dump($datos);
if ($oconns->numberRows>0){
	$nombre = $datos3[0]['nombre'];
	$nombre_producto = $datos3[0]['nombre_producto'];
	$no_pago = $datos[0]['no_pago'];
	$descripcion = $datos2[0]['descripcion'];
	$fecha_valor = $datos[0]['fecha_valor'];
	$pago = strval(number_format($datos[0]['pago'],2));
	$interes = strval(number_format($datos[0]['interes'],2));
	$iva = strval(number_format($datos[0]['iva'],2));
	$folio = $datos[0]['idkey_amortizacion'];
	$amortizacion = strval(number_format($datos[0]['amortizacion'],2));
	$monto = strval(number_format($datos[0]['monto'],2));
	$moratorio = strval(number_format($datos[0]['pago_interes_moratorio'],2));
	$saldo_insoluto = strval(number_format($datos[0]['saldo_insoluto'],2));
}
/*
$interes = round($interes, 2);
$iva = round($iva, 2);
$saldo_insoluto = round($saldo_insoluto, 2);*/


$pdf = new FPDF('P', 'mm', array(58, 150));
$pdf->SetMargins(3, 2 , 3);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',5);

$pdf->Ln(12);

$pdf->Image('logoprodeco.png', 20, 4, 15);

$pdf->Ln(1);

$pdf->MultiCell(50, 2.5, utf8_decode('PRODUCCION ECOTURISTICA COLOTEPE C S.C. DE R.S DE C.V. SOCIEDADES COOPERATIVAS DE PRODUCCION QUE OPTAN POR DIFERIR SUS INGRESOS '), 0, 'J', 0);

$pdf->Cell(50, 3,'RFC:PEC990606635', 0, 1, 'C', 0);
$pdf->SetFont('Arial','',7);

$pdf->Cell(50, 3,'Folio:'. $folio, 0, 1, 'L', 0);
$pdf->Cell(50, 3,utf8_decode("Fecha: $fecha_valor"), 0, 1, 'L', 0);
$pdf->Cell(50, 3,utf8_decode("Nombre: $nombre"), 0, 1, 'L', 0);
$pdf->Cell(50, 3,utf8_decode("Tipo de credito: $nombre_producto"), 0, 1, 'L', 0);

$pdf->Ln(3);

$pdf->Cell(50, 3,'Pago a prestamo', 0, 1, 'L', 0);

$pdf->Ln(3);

$pdf->Cell(50, 3,utf8_decode("Pago No.: $no_pago"), 0, 1, 'L', 0);

$pdf->Cell(5, 3,utf8_decode(''), 0, 0, 'L', 0);
$pdf->Cell(50, 3,utf8_decode("No de Amortizacion: $descripcion"), 0, 1, 'L', 0);

$pdf->Cell(5, 3,utf8_decode(''), 0, 0, 'L', 0);
$pdf->Cell(50, 3,utf8_decode("Amortizacion:".$amortizacion), 0, 1, 'L', 0);

$pdf->Cell(5, 3,utf8_decode(''), 0, 0, 'L', 0);
$pdf->Cell(20, 3,utf8_decode("Interes: $interes"), 0, 1, 'L', 0);

$pdf->Cell(5, 3,utf8_decode(''), 0, 0, 'L', 0);
$pdf->Cell(50, 3,utf8_decode("Int. Moratorio: $moratorio"), 0, 1, 'L', 0);

$pdf->Cell(5, 3,utf8_decode(''), 0, 0, 'L', 0);
$pdf->Cell(50, 3,utf8_decode("I.V.A.: $iva"), 0, 1, 'L', 0);

$pdf->Cell(5, 3,utf8_decode(''), 0, 0, 'L', 0);
$pdf->Cell(50, 3,utf8_decode("Pago: $pago"), 0, 1, 'L', 0);

$pdf->Cell(5, 3,utf8_decode(''), 0, 0, 'L', 0);
$pdf->Cell(50, 3,utf8_decode("Nuevo saldo: $saldo_insoluto"), 0, 1, 'L', 0);

$pdf->Ln(5);

$pdf->Cell(5, 3,utf8_decode('____________________________________'), 0, 1, 'L', 0);
$pdf->Cell(50, 3,utf8_decode('Cliente                      Promotor'), 0, 1, 'C', 0);

$pdf->Ln(5);

$pdf->Cell(50, 3,utf8_decode('Atendio'), 0, 1, 'C', 0);
$pdf->Cell(50, 3,utf8_decode($_SESSION["nombre"]." ".$_SESSION["apellido_p"]." ".$_SESSION["apellido_m"]), 0, 1, 'C', 0);

$pdf->Ln(2);

$pdf->MultiCell(50, 3, utf8_decode("ESTE COMPROBANTE NO SERA VALIDO SIN FIRMA DEL REPRESENTANTE. \nCALLE SIN NOMBRE SN BARRA DE NAVIDAD, SANTA MARIA, COLOTEPEC, POCHM OAX. C.P. 70938 UNIDAD ESPECIALIZADA: QUEJASYSUGERENCIAS@PRODECO.MX TELEFONOS: 954 58 21538 Y 58 21548 EXT 608 ENTIDAD."), 0, 'J', 0);


$pdf->Output();

 ?>