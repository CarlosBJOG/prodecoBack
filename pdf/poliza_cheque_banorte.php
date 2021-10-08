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
  $data = $oconns->getRows("select DATE_FORMAT(pe.fecha,'%d/%m/%Y') as fecha, pe.no_poliza, pe.concepto, pe.monto, pe.idkey_cuenta_contable1, referencia1, debe1, haber1, pe.idkey_cuenta_contable2, referencia2, debe2, haber2 
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
        $nombre = $_GET["nombre"];
        $monto = $data[0]["monto"];
        $debe1 = number_format($data[0]["debe1"],2);
        $haber1 = number_format($data[0]["haber1"],2);
        $debe2 = number_format($data[0]["debe2"],2);
        $haber2 = number_format($data[0]["haber2"],2);
      }
      $no_cuenta1 = $data[0]["idkey_cuenta_contable1"];
      $no_cuenta2= $data[0]["idkey_cuenta_contable2"];
      $nombre_cuenta1 = $oconns->getSimple("select nombre from cuentas_contables where no_cuenta='$no_cuenta1'");
      $nombre_cuenta2 = $oconns->getSimple("select nombre from cuentas_contables where no_cuenta='$no_cuenta2'");
  }
}
else{
  echo "<script> alert('No se han encontrado datos coincidentes.'); window.location.href='index.php'; </script>";
  exit;
}


//variables
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$temp = explode("/",$data[0]["fecha"]);
$fecha = $temp[0]." de ".$meses[intval($temp[1])-1]." de ".$temp[2];

$banco_cuenta = 'Banorte';
$num_cuenta = $_GET["cuenta"];
$num_cheque = $_GET["cheque"];
$concepto_pago = $data[0]["concepto"];
$num_poliza = $data[0]["no_poliza"];


$referencia1 = $data[0]["referencia1"];
$parcial1 = "";

$referencia2 = $data[0]["referencia2"];
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
//$pdf->Image('banorte.jpg', 10, 3, 165);
$pdf->Cell(49, 5,  utf8_decode(''), 0, 0, 'C');
$pdf->Cell(65, 5,  utf8_decode($fecha), 0, 0, 'C');
$pdf->Cell(65, 5,  utf8_decode(number_format($monto,2)), 0, 1, 'C');
$pdf->Ln(3);
$pdf->Cell(35, 5,  utf8_decode(''), 0, 0, 'C');

$pdf->Cell(60, 5,  utf8_decode($nombre), 0, 1, 'C');

$pdf->Ln(3);
$pdf->Cell(5, 5,  utf8_decode(''), 0, 0, 'C');

$pdf->Cell(150, 5,  utf8_decode("($numero_letra PESOS $centavos/100 M.N)"), 0, 1, 'C');

//banco
$pdf->Ln(29);
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
  //cuentas


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