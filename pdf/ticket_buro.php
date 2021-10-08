<?php 

require('./fpdf.php');
require ('../php/db.php');

$oconns = new database();

/*
$interes = round($interes, 2);
$iva = round($iva, 2);
$saldo_insoluto = round($saldo_insoluto, 2);*/
$idkey = $_GET['idkey'];
$query = "SELECT bc.idkey, bc.num_registros, bc.costo_unitario, bc.monto, bc.fecha_registro, us.usuario_nombre FROM buro_credito AS bc INNER JOIN 
           usuarios AS us ON us.idkey = bc.idkey_usuario WHERE bc.idkey = '$idkey'";
$data = $oconns->getRows($query);



if(empty($data)){
    echo "<script> alert('Ocurrio un error') </script>";

}else{
    $folio = $data[0]['idkey'];
    $fecha = $data[0]['fecha_registro'];
    $numero_consultas = $data[0]['num_registros'];
    $costo_unitario = $data[0]['costo_unitario'];
    $monto = (float) $data[0]['monto'];
    $usuario = $data[0]['usuario_nombre'];


}
$iva = $monto * 0.16;
$subtotal = $monto - $iva;




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

$pdf->Cell(50, 3,"Folio: ".$folio , 0, 1, 'L', 0);
$pdf->Cell(50, 3,utf8_decode('Fecha: '.$fecha), 0, 1, 'L', 0);

$pdf->Ln(3);

$pdf->Cell(50, 3,utf8_decode('Buró de Crédito'), 0, 1, 'L', 0);

$pdf->Ln(3);

$pdf->Cell(50, 3,utf8_decode("Gasto Buró de Crédito "), 0, 1, 'L', 0);

$pdf->Cell(5, 3,utf8_decode(''), 0, 0, 'L', 0);
$pdf->Cell(50, 3,utf8_decode("Número de consultas: ".$numero_consultas), 0, 1, 'L', 0);

$pdf->Cell(5, 3,utf8_decode(''), 0, 0, 'L', 0);
$pdf->Cell(50, 3,utf8_decode("Costo por consulta:$ ".$costo_unitario), 0, 1, 'L', 0);

$pdf->Cell(5, 3,utf8_decode(''), 0, 0, 'L', 0);
$pdf->Cell(50, 3,utf8_decode("Subtotal: $ ".$subtotal), 0, 1, 'L', 0);

$pdf->Cell(5, 3,utf8_decode(''), 0, 0, 'L', 0);
$pdf->Cell(50, 3,utf8_decode("IVA: $ ".$iva), 0, 1, 'L', 0);

$pdf->Cell(5, 3,utf8_decode(''), 0, 0, 'L', 0);
$pdf->Cell(50, 3,utf8_decode("Total: $ ".$monto), 0, 1, 'L', 0);


$pdf->Ln(5);

$pdf->Cell(5, 3,utf8_decode('____________________________________'), 0, 1, 'L', 0);
$pdf->Cell(50, 3,utf8_decode('      Promotor'), 0, 1, 'C', 0);

$pdf->Ln(5);

$pdf->Cell(50, 3,utf8_decode('Atendio'), 0, 1, 'C', 0);
$pdf->Cell(50, 3,utf8_decode( $usuario), 0, 1, 'C', 0);

$pdf->Ln(4);

$pdf->MultiCell(50, 3, utf8_decode("ESTE COMPROBANTE NO SERA VALIDO SIN FIRMA DEL REPRESENTANTE. \nCALLE SIN NOMBRE SN BARRA DE NAVIDAD, SANTA MARIA, COLOTEPEC, POCHM OAX. C.P. 70938 UNIDAD ESPECIALIZADA: QUEJASYSUGERENCIAS@PRODECO.MX TELEFONOS:\n954 58 21538 Y 58 21548 EXT 608 ENTIDAD."), 0, 'J', 0);


$pdf->Output();

 ?>