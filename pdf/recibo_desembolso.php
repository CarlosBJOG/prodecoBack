<?php 

require('./fpdf.php');
require ('../php/clases/conversor.php');
require ('strfecha.php');
require ('../php/db.php');
@session_start();

$idkey_credito = $_GET["idkey_credito"];

$oconns = new database();
$datos = $oconns->getRows("select vc.folio, vc.nombre, vc.fecha_entrega, vc.desc_tipo, vc.tipo_desembolso, vc.tipo_credito, vc.fecha_desembolso, vc.nombre_producto from view_creditos vc WHERE idkey_credito ='".$idkey_credito."'" );
if($oconns->numberRows==0){
	echo "<script>alert('Error de referencia de cr\u00E9dito!!');</script>";
	exit;
}

$folio = $datos[0]['folio'];
$nombre = $datos[0]['nombre'];
$fecha_desembolso = $datos[0]['fecha_desembolso'];
$nombre_producto = $datos[0]['nombre_producto'];
$tipo_desembolso = $datos[0]['tipo_desembolso'];


//$datos2 = $oconns->getRows("SELECT descripcion from amortizaciones where idkey = '".$folio."' ;");

// var_dump($datos);
if ($oconns->numberRows>0){
	$no_pago = "1";
	$descripcion = "1";
	$pago = "1";
	$interes = "1";//strval(number_format($datos[0]['interes'],2));
	$iva = "1";
	$amortizacion = "1";
	$monto = "1";
	$moratorio = "1";
	$saldo_insoluto = "1";
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

$pdf->MultiCell(50, 2.5, utf8_decode('PRODUCCION ECOTURISTICA COLOTEPE C S.C. DE R.S DE C.V. SOCIEDADES COOPERATIVAS DE PRODUCCION QUE OPTAN POR DIFERIR SUS EGRESOS '), 0, 'J', 0);

$pdf->Cell(50, 3,'RFC:PEC990606635', 0, 1, 'C', 0);
$pdf->SetFont('Arial','',7);

$pdf->Cell(50, 3,'Folio:'. $folio, 0, 1, 'L', 0);
$pdf->Cell(50, 3,utf8_decode("Fecha: ".date('Y-m-d h:i:s')), 0, 1, 'L', 0);
$pdf->Cell(50, 3,utf8_decode("Nombre: $nombre"), 0, 1, 'L', 0);
$pdf->Cell(50, 3,utf8_decode("Tipo de credito: $nombre_producto"), 0, 1, 'L', 0);

$pdf->Ln(3);

$pdf->Cell(50, 3,utf8_decode('Desembolso a crédito'), 0, 1, 'L', 0);

$pdf->Ln(3);

$pdf->Cell(5, 3,utf8_decode(''), 0, 0, 'L', 0);
$pdf->Cell(50, 3,utf8_decode("Tipo desembolso: $tipo_desembolso"), 0, 1, 'L', 0);
$pdf->Cell(5, 3,utf8_decode(''), 0, 0, 'L', 0);
$pdf->Cell(50, 3,utf8_decode("Fecha desembolso: $fecha_desembolso"), 0, 1, 'L', 0);

$pdf->Ln(10);

$pdf->Cell(5, 3,utf8_decode('____________________________________'), 0, 1, 'L', 0);
$pdf->Cell(50, 3,utf8_decode('Cliente                      Cajero'), 0, 1, 'C', 0);

$pdf->Ln(5);

$pdf->Cell(50, 3,utf8_decode('Atendió'), 0, 1, 'C', 0);
$pdf->Cell(50, 3,utf8_decode($_SESSION["nombre"]." ".$_SESSION["apellido_p"]." ".$_SESSION["apellido_m"]), 0, 1, 'C', 0);

$pdf->Ln(4);

$pdf->MultiCell(50, 3, utf8_decode("ESTE COMPROBANTE NO SERA VALIDO SIN FIRMA DEL REPRESENTANTE. \nCALLE SIN NOMBRE SN BARRA DE NAVIDAD, SANTA MARIA, COLOTEPEC, POCHM OAX. C.P. 70938 UNIDAD ESPECIALIZADA: QUEJASYSUGERENCIAS@PRODECO.MX TELEFONOS:\n954 58 21538 Y 58 21548 EXT 608 ENTIDAD."), 0, 'J', 0);


$pdf->Output();

 ?>