<?php 

require('./fpdf.php');
require ('../php/db.php');
@session_start(); 
$idkey_usuario = $_SESSION['usuario_nombre']; 
$oconns = new database();
/*
$interes = round($interes, 2);
$iva = round($iva, 2);
$saldo_insoluto = round($saldo_insoluto, 2);*/

$idkey = $_GET['idkey'];
$idkey_credito = $_GET['credito'];

if($idkey_credito === '0'){

    $datos = $oconns->getRows("SELECT gc.idkey, gc.idkey_credito, gc.fecha_registro, gc.monto, vc.nombre, vc.nombre_producto FROM gastos_cobranza AS gc INNER JOIN view_creditos as vc ON vc.idkey_credito = gc.idkey_credito WHERE gc.idkey = '$idkey' ORDER BY gc.fecha_registro DESC LIMIT 1 ");
}else{
    $datos = $oconns->getRows("SELECT gc.idkey, gc.idkey_credito, gc.fecha_registro, gc.monto, vc.nombre, vc.nombre_producto FROM gastos_cobranza AS gc INNER JOIN view_creditos as vc ON vc.idkey_credito = gc.idkey_credito WHERE gc.idkey_credito = '$idkey_credito' ORDER BY gc.fecha_registro DESC LIMIT 1 ");
}

if(count($datos) > 0){
    $folio =mb_strtoupper($datos[0]['idkey_credito']);
    $fecha =mb_strtoupper($datos[0]['fecha_registro']);
    $tipo_credito = mb_strtoupper($datos[0]['nombre_producto']);
    $nombre = mb_strtoupper($datos[0]['nombre']);
    $monto = mb_strtoupper($datos[0]['monto']);
}



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

$pdf->Cell(50, 3,"Folio: $folio", 0, 1, 'L', 0);
$pdf->Cell(50, 3,utf8_decode("Fecha: $fecha"), 0, 1, 'L', 0);

$pdf->Ln(3);

$pdf->Cell(50, 3,'Gastos cobranza', 0, 1, 'L', 0);

$pdf->Ln(3);

$pdf->Cell(50, 3,utf8_decode("Crédito: ".$tipo_credito), 0, 1, 'L', 0);

$pdf->Cell(5, 3,utf8_decode(''), 0, 0, 'L', 0);
$pdf->Cell(50, 3,utf8_decode("Nombre: ".$nombre), 0, 1, 'L', 0);

$pdf->Cell(5, 3,utf8_decode(''), 0, 0, 'L', 0);
$pdf->Cell(50, 3,utf8_decode("Monto: $ $monto"), 0, 1, 'L', 0);


$pdf->Ln(5);

$pdf->Cell(5, 3,utf8_decode('____________________________________'), 0, 1, 'L', 0);
$pdf->Cell(50, 3,utf8_decode('Cliente                      Promotor'), 0, 1, 'C', 0);

$pdf->Ln(5);

$pdf->Cell(50, 3,utf8_decode('Atendio'), 0, 1, 'C', 0);
$pdf->Cell(50, 3,utf8_decode($idkey_usuario ), 0, 1, 'C', 0);

$pdf->Ln(4);

$pdf->MultiCell(50, 3, utf8_decode("ESTE COMPROBANTE NO SERA VALIDO SIN FIRMA DEL REPRESENTANTE. \nCALLE SIN NOMBRE SN BARRA DE NAVIDAD, SANTA MARIA, COLOTEPEC, POCHM OAX. C.P. 70938 UNIDAD ESPECIALIZADA: QUEJASYSUGERENCIAS@PRODECO.MX TELEFONOS:\n954 58 21538 Y 58 21548 EXT 608 ENTIDAD."), 0, 'J', 0);


$pdf->Output();

 ?>