<?php

require('fpdf.php');
require ('../php/clases/conversor.php');
require ('strfecha.php');
include "phpqrcode/qrlib.php";
require ('../php/db.php');


class PDF extends FPDF
{
// Cabecera de página
function Header()
{

}

// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,10, utf8_decode('Página ') .$this->PageNo() . '/{nb}',0,0,'C');
}
}

// * * * * * * * * * * * * * * * * * * * * *  *
//      Simulacion de datos del credito
// * * * * * * * * * * * * * * * * * * * * *  *

/*
$ClienteNo = '00120498-02';
$Nombre = 'MARTINEZ BALDERAS LEOVIGILDO MANUEL';
$SolicitudNo = '27815';
$NoPrestamo = '030179';
$TasaInteres = 1.5;
$FechaEntrega = '21/12/2018';
$Plazo = '76 cada 7 dias';
$Monto = 30000;
$TipoCredito = 'NOP CREDINOMINA PRODECO';*/
$TipoPlan = 'Pagos periodicos de capital e interes';
$oconns = new database();
$idkey_credito = $_GET["idkey_credito"];
$query = "SELECT vc.*, f.nombre as desc_frec, DATE_FORMAT(fecha_desembolso,'%d/%m/%Y') as fecha_desembolso, DATE_FORMAT(primer_pago,'%d/%m/%Y') as primer_pago, f.dias FROM view_creditos vc inner join frecuencia f on vc.idkey_frecuencia=f.idkey  where vc.idkey_credito=".$idkey_credito;
$data = $oconns->getRows($query);
if ($oconns->numberRows>0){
    $ClienteNo = $data[0]["idkey_clientes"];
    $Nombre = utf8_decode(mb_strtoupper($data[0]["nombre"]));
    $SolicitudNo = $idkey_credito;
    $NoPrestamo = $data[0]["folio"];
    $Monto = $data[0]["monto"];
    //$response['plazo'] = $data[0]["plazo"];
    $PlazoN = intval($data[0]["numero_pagos"]);
    $Plazo = utf8_decode($data[0]["numero_pagos"]." cada ".$data[0]["dias"]." días");
    $frecuencia = $data[0]["idkey_frecuencia"];

    //$response['finalidad'] = $finalidad;
    $TipoCredito = utf8_decode(mb_strtoupper($data[0]["nombre_producto"]));
    //$response['tipo_credito'] = $data[0]["tipo_credito"];
    $FechaEntrega = $data[0]["fecha_desembolso"];
    $TasaInteres = $data[0]["tasa_interes"];
  }
else{
  echo " <script> alert('No se encontraron los datos del credito.'); </script>";
  exit;
}


// Se consulta la tabla de amortizacion
$query = "SELECT idkey, pago, descripcion, DATE_FORMAT(fecha_temp,'%d/%m/%Y') as fecha_pago, intereses, iva, renta, total, saldo_insoluto, idkey_creditos from amortizaciones  where idkey_creditos=".$idkey_credito." order by pago asc";
$data1 = $oconns->getRows($query);
$m = $oconns->numberRows;

$rows_data = $m;
$rows_per_page = ceil($rows_data / 30);


// * * * * * * * * * * * * * * * * * * * * *  *
//          Genera imagen de codigo QR
// * * * * * * * * * * * * * * * * * * * * *  *

//set it to writable location, a place for temp generated PNG files
$PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;

//html PNG location prefix
$PNG_WEB_DIR = 'temp/';

//ofcourse we need rights to create temp dir
if (!file_exists($PNG_TEMP_DIR))
    mkdir($PNG_TEMP_DIR);
$filename = $PNG_TEMP_DIR.'qrcode.png';

//processing form input
$errorCorrectionLevel = 'M';
$matrixPointSize = 4;

QRcode::png($NoPrestamo, $filename, $errorCorrectionLevel, $matrixPointSize, 2);



// * * * * * * * * * * * * * * * * * * * * *  *
// Comienza encabezado del documento
// * * * * * * * * * * * * * * * * * * * * *  *

// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();




// Crea una pagina con encabezado para la TABLA
$iva_total =0;
$intereses_total =0;
$total_total =0;
$m = 0;

for($k=1; $k<=$rows_per_page; $k++)
{
  $t =0;


  $pdf->AddPage();
  $pdf->SetFont('Arial','B',8);


  // Encabezado

  // Logo
  $pdf->Image('logoprodeco.png',10,8,33);
  // Arial bold 15
  $pdf->SetFont('Arial','B',8);
  // Movernos a la derecha
  $pdf->Cell(40);
  // Título
  $pdf->Cell(110,7,'PRODUCCION ECOTURISTICA COLOTEPEC SC. DE R.S. DE C.V', 0, 0, 'C');
  $pdf->Ln(15);
  $pdf->Cell(40);

  $pdf->Cell(110, 6, utf8_decode('TABLA DE AMORTIZACIÓN DE CRÉDITO'), 0, 0, 'C');
  $pdf->Ln(5);

  if ($k==1)
    $pdf->Image($PNG_WEB_DIR.basename($filename),160,8,30);


  // Datos del CREDITO
  $pdf->Ln(10);
  $pdf->SetTextColor(0,  0, 0);
  $pdf->Ln(3);
  $pdf->SetFont('Arial','B', 8);
  $pdf->Cell(29, 3, 'Cliente No.:', 0, 0, 'L');
  $pdf->Cell(1);
  $pdf->SetFont('Arial','', 8);
  $pdf->Cell(70, 3, $ClienteNo.'  '.$Nombre, 0, 0, 'L');

  $pdf->Ln(4);
  $pdf->SetFont('Arial','B', 8);
  $pdf->Cell(29, 3, 'Solicitud No.:', 0, 0, 'L');
  $pdf->Cell(1);
  $pdf->SetFont('Arial','', 8);
  $pdf->Cell(30, 3, $SolicitudNo, 0, 0, 'L');
  $pdf->Cell(1);
  $pdf->SetFont('Arial','B', 8);
  $pdf->Cell(25, 3, utf8_decode('No. de préstamo:'), 0, 0, 'L');
  $pdf->Cell(1);
  $pdf->SetFont('Arial','', 8);
  $pdf->Cell(30, 3, $NoPrestamo, 0, 0, 'L');
  $pdf->Cell(1);
  $pdf->SetFont('Arial','B', 8);
  $pdf->Cell(25, 3, utf8_decode('Tasa de interés:'), 0, 0, 'L');
  $pdf->Cell(1);
  $pdf->SetFont('Arial','', 8);
  $pdf->Cell(30, 3, $TasaInteres, 0, 0, 'L');

  $pdf->Ln(4);
  $pdf->SetFont('Arial','B', 8);
  $pdf->Cell(29, 3, 'Fecha de entrega:', 0, 0, 'L');
  $pdf->Cell(1);
  $pdf->SetFont('Arial','', 8);
  $pdf->Cell(30, 3, $FechaEntrega, 0, 0, 'L');
  $pdf->Cell(1);
  $pdf->SetFont('Arial','B', 8);
  $pdf->Cell(25, 3, utf8_decode('Plazo:'), 0, 0, 'L');
  $pdf->Cell(1);
  $pdf->SetFont('Arial','', 8);
  $pdf->Cell(87, 3, $Plazo, 0, 0, 'L');

  $pdf->Ln(4);
  $pdf->SetFont('Arial','B', 8);
  $pdf->Cell(29, 3, utf8_decode('Monto préstamo:'), 0, 0, 'L');
  $pdf->Cell(1);
  $pdf->SetFont('Arial','', 8);
  $pdf->Cell(30, 3, '$'.strval(number_format($Monto, 2)), 0, 0, 'L');
  $pdf->Cell(1);
  $pdf->SetFont('Arial','B', 8);
  $pdf->Cell(25, 3, utf8_decode('Tipo de crédito:'), 0, 0, 'L');
  $pdf->Cell(1);
  $pdf->SetFont('Arial','', 8);
  $pdf->Cell(87, 3, $TipoCredito, 0, 0, 'L');

  $pdf->Ln(4);
  $pdf->SetFont('Arial','B', 8);
  $pdf->Cell(29, 3, utf8_decode('Tipo de plan:'), 0, 0, 'L');
  $pdf->Cell(1);
  $pdf->SetFont('Arial','', 8);
  $pdf->Cell(144, 3, $TipoPlan, 0, 0, 'L');
  $pdf->Ln(10);




  /*    Crea tabla    */

  $header = array('Fecha de pago', 'No. de pago', 'Importe', 'Intereses', 'IVA', 'Abono total', 'Nuevo saldo');

  $pdf->SetFont('Arial','',8);

  // Anchuras de las columnas
  $column_width = 27;

  // Cabeceras
  for($i=0; $i<count($header); $i++)
    $pdf->Cell($column_width, 5, $header[$i], 1, 0, 'C');
  $pdf->Ln();

  // primer renglon
  if ($k==1)
  {
    $first_line = array('', '', '', '', '', '', strval(number_format($Monto, 2)));

    for($i=0; $i<count($header); $i++)
      $pdf->Cell($column_width, 5, $first_line[$i], 'LR', 0, 'C');
    $pdf->Ln();
  }



  if ($k<$rows_per_page)
  {
    $rows_count = 30;
  }
  else {
    $rows_count = $rows_data - ($rows_per_page-1)*30;
  }

  // Datos
  
  //foreach ($data1 as $item){
  for($i=$m; $i<count($data1); $i++){
      $t= $t+1;
      $m= $m+1;
      $pdf->Cell($column_width, 5, $data1[$i]["fecha_pago"], 'LR', 0, 'C');
      $pdf->Cell($column_width, 5, $data1[$i]["descripcion"], 'LR', 0, 'C');
      $pdf->Cell($column_width, 5, strval(number_format($data1[$i]["renta"],2)), 'LR', 0, 'C');
      $pdf->Cell($column_width, 5, strval(number_format($data1[$i]["intereses"],2)), 'LR', 0, 'C');
      $pdf->Cell($column_width, 5, strval(number_format($data1[$i]["iva"], 2)), 'LR', 0, 'C');
      $pdf->Cell($column_width, 5, strval(number_format($data1[$i]["total"], 2)), 'LR', 0, 'C');
      $pdf->Cell($column_width, 5, strval(number_format($data1[$i]["saldo_insoluto"], 2)), 'LR', 0, 'C');
      $pdf->Ln();
      $intereses_total = $intereses_total + floatval($data1[$i]["intereses"]);
      $iva_total = $iva_total + floatval($data1[$i]["iva"]);
      $total_total = $total_total + floatval($data1[$i]["total"]);
      if($t==30)
        break;
  }

  // Línea de cierre
  $pdf->Cell(7*$column_width,0,'','T');
  $pdf->Ln();


  if ($k==$rows_per_page)
  {
    // Ultimo renglon
    // en footer se pueden escribir los totales
    $footer = array('', 'Totales', strval(number_format($Monto, 2)), strval(number_format($intereses_total, 2)), strval(number_format($iva_total, 2)), strval(number_format($total_total, 2)), '');

    for($i=0; $i<count($header); $i++)
      $pdf->Cell($column_width, 5, $footer[$i], 1, 0, 'C');
    $pdf->Ln();

    // Firma SOLICITANTE

    $pdf->Ln(12);
    $pdf->SetFont('Arial','', 8);
    $pdf->Cell(189, 3, 'ACEPTO DE CONFORMIDAD', 0, 0, 'C');
    $pdf->Ln(10);
    $pdf->Cell(189, 3, '_____________________________________________________', 0, 0, 'C');
    $pdf->Ln(5);
    $pdf->Cell(189, 3, $Nombre, 0, 0, 'C');
    $pdf->Ln(5);

    // Direccion Prodeco
    $pdf->Cell(189, 3, utf8_decode('CALLE PRINCIPAL S/N'), 0, 0, 'C');
    $pdf->Ln(3);
    $pdf->Cell(189, 3, utf8_decode('BARRA DE NAVIDAD, SANTA MARÍA'), 0, 0, 'C');
    $pdf->Ln(3);
    $pdf->Cell(189, 3, utf8_decode('COLOTEPEC, POCHULA, OAXACA. C.P. 70934'), 0, 0, 'C');
  }


}




$pdf->Output();
?>
