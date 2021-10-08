<?php 

require('./fpdf.php');
require ('../php/clases/conversor.php');
require ('strfecha.php');
require ('../php/db.php');
require_once '../php/clases/CifrasEnLetras.php';


$cifra = new CifrasEnLetras();

 
if (isset($_GET["idkey"])){
  $idkey_poliza_egreso = $_GET["idkey"];
  $oconns = new database();
  $data = $oconns->getRows("select DATE_FORMAT(pe.fecha,'%d/%m/%Y') as fecha, pe.no_poliza, pe.concepto, pe.monto
      from poliza_egreso pe where idkey='$idkey_poliza_egreso'");
  if($oconns->numberRows==0){
      echo "<script> alert('No se han encontrado datos coincidentes.'); window.location.href='index.php'; </script>";
      exit;
  }
  else{
      //Para comprobar si se trata de la poliza de un cliente de un crédito grupal
      if (isset($_GET["idkey_credito"])){
        $data3 = $oconns->getRows("select nombre, monto from view_clientes_grupo where idkey_credito='".$_GET["idkey_credito"]."'  and idkey_cliente='".$_GET["nombre"]."'");
        $nombre = $data3[0]["nombre"];
        $monto = $data3[0]["monto"];
        $debe1 = number_format($monto,2);
        $haber1 = number_format(0,2);
        $debe2 = number_format(0,2);
        $haber2 = number_format($monto,2);
      }
      else{
        $data4 = $oconns->getRows("select m.idkey, m.idkey_cuenta_contable, m.referencia, m.debe, m.haber, m.descripcion, m.idkey_poliza, cc.nombre from poliza_egreso_movimientos m INNER JOIN cuentas_contables cc ON (m.idkey_cuenta_contable = cc.no_cuenta)  WHERE m.idkey_poliza='$idkey_poliza_egreso'");
        $nombre = $_GET["nombre"];
        $monto = $data[0]["monto"];
        $debe1 = number_format($data4[0]["debe"],2);
        $haber1 = number_format($data4[0]["haber"],2);
        $debe2 = number_format($data4[1]["debe"],2);
        $haber2 = number_format($data4[1]["haber"],2);
        $no_cuenta1 = $data4[0]["idkey_cuenta_contable"];
        $no_cuenta2= $data4[1]["idkey_cuenta_contable"];
        $nombre_cuenta1 = $data4[0]["nombre"];
        $nombre_cuenta2 = $data4[1]["nombre"];
      }
  }
}
else{
  echo "<script> alert('No se han encontrado datos coincidentes.'); window.location.href='index.php'; </script>";
  //exit;
}


//variables
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$temp = explode("/",$data[0]["fecha"]);
$fecha = $temp[0]." de ".$meses[intval($temp[1])-1]." de ".$temp[2];

$banco_cuenta = 'BBVA';
$num_cuenta = $_GET["cuenta"];
$num_cheque = $_GET["cheque"];
$concepto_pago = $data[0]["concepto"];
$num_poliza = $data[0]["no_poliza"];


$referencia1 = $data4[0]["referencia"];
$parcial1 = "";


$referencia2 = $data4[1]["referencia"];
$parcial2 = "";

if(is_float($monto)){
    $centavos = explode(".",$monto);
    $numero_letra = $cifra->convertirCifrasEnLetras($centavos[0]);
    $centavos = $centavos[1];
  }else{
    $centavos = explode(".",$monto);
    $numero_letra = $cifra->convertirCifrasEnLetras($centavos[0]);
    $centavos = '00';
  }

$numero_letra = mb_strtoupper($numero_letra);

$pdf = new FPDF('L', 'mm', array(175, 215));

$pdf->SetMargins(0, 0 , 0, 0);
$pdf->SetAutoPageBreak(false);
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Arial','',8);

$pdf->Ln(25);

//$pdf->Image('cheque2.jpg', 0, 0, 215);
//$pdf->Image('bbva.jpg', 20, 3, 165);
$pdf->Cell(80, 5,  utf8_decode(''), 0, 0, 'C');
$pdf->Cell(95, 5,  utf8_decode($fecha), 0, 1, 'C');

$pdf->Ln(2);
$pdf->Cell(35, 5,  utf8_decode(''), 0, 0, 'C');

$pdf->Cell(90, 5,  utf8_decode($nombre), 0, 0, 'C');
$pdf->Cell(65, 5,  utf8_decode(number_format($monto,2)), 0, 1, 'C');

$pdf->Ln(3);
$pdf->Cell(5, 5,  utf8_decode(''), 0, 0, 'C');

$pdf->Cell(150, 5,  utf8_decode("($numero_letra PESOS $centavos/100 M.N)"), 0, 1, 'C');

//banco
$pdf->Ln(30);
$pdf->Cell(65, 5,  utf8_decode(''), 0, 0, 'C');
$pdf->Cell(43, 5,  utf8_decode($banco_cuenta), 0, 0, 'C');

//num de cuenta
$pdf->Cell(45, 5,  utf8_decode($num_cuenta), 0, 0, 'C');

//num de cheque
$pdf->Cell(50, 5,  utf8_decode($num_cheque), 0, 1, 'C');

//concepto de pago
$pdf->Ln(7);
$pdf->Cell(20, 5,  utf8_decode(''), 0, 0, 'C');
$pdf->MultiCell(120, 10,  utf8_decode($concepto_pago), 0, 'C');

$pdf->SetFont('Arial','',6);

$pdf->Ln(7);

  //cuentas contables 1
  $pdf->Cell(19, 4,  utf8_decode(''), 0, 0, 'C');
  //cuenta
  $pdf->Cell(15, 4,  utf8_decode($no_cuenta1), 0, 0,  'C');
  //subcuenta o referencia
  $pdf->Cell(15, 4,  utf8_decode($referencia1), 0, 0, 'C');
  //nombre de la cuenta
  $pdf->Cell(82, 4,  utf8_decode($nombre_cuenta1), 0, 0,  'C');
  //PARCIAL
  $pdf->Cell(25, 4,  utf8_decode($parcial1), 0, 0, 'C');
  //DEBE
  $pdf->Cell(25, 4,  utf8_decode($debe1), 0, 0, 'C');
  //HABER
  $pdf->Cell(25, 4,  utf8_decode($haber1), 0, 1, 'C');
  $pdf->Ln(5);


  //cuentas contables 2
  $pdf->Cell(19, 4,  utf8_decode(''), 0, 0, 'C');
  //cuenta
  $pdf->Cell(15, 4,  utf8_decode($no_cuenta2), 0, 0,  'C');
  //subcuenta o referencia
  $pdf->Cell(15, 4,  utf8_decode($referencia2), 0, 0, 'C');
  //nombre de la cuenta
  $pdf->Cell(82, 4,  utf8_decode($nombre_cuenta2), 0, 0,  'C');
  //PARCIAL
  $pdf->Cell(25, 4,  utf8_decode($parcial2), 0, 0, 'C');
  //DEBE
  $pdf->Cell(25, 4,  utf8_decode($debe2), 0, 0, 'C');
  //HABER
  $pdf->Cell(25, 4,  utf8_decode($haber2), 0, 1, 'C');
  

  $pdf->Ln(30);


//numero de poliza
$pdf->Ln(7);
$pdf->Cell(10, 5,  utf8_decode(''), 0, 0, 'C');
$pdf->Cell(178, 5,  utf8_decode($num_poliza), 0, 1, 'R');



$pdf->Output();

 ?>