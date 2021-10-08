<?php

require('fpdf.php');
require ('../php/clases/conversor.php');
require ('strfecha.php');
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




$oconns = new database();
$temp = explode("/",$_GET["finicio"]);
$fecha_inicio = $temp[2]."-".$temp[1]."-".$temp[0];
$temp = explode("/",$_GET["ffin"]);
$fecha_fin = $temp[2]."-".$temp[1]."-".$temp[0];
$query1 = "select mc.idkey, mc.idkey_cuenta_contable, mc.debe, mc.haber, mc.idkey_credito, mc.observaciones, mc.fecha, mc.idkey_usuario, cc.nombre FROM movimientos_contables mc INNER JOIN cuentas_contables cc ON mc.idkey_cuenta_contable = cc.no_cuenta WHERE mc.fecha BETWEEN '".$fecha_inicio." 00:00:00' AND '".$fecha_fin." 23:59:59'";

$data1 = $oconns->getRows($query1);
$m = $oconns->numberRows;

if ($m==0){
  echo " <script> alert('No se encontraron datos coincidentes con esas fechas.".$m."'); </script>";
  exit;
}


$rows_data = $m;
$rows_per_page = ceil($rows_data / 30);


// * * * * * * * * * * * * * * * * * * * * *  *
// Comienza encabezado del documento
// * * * * * * * * * * * * * * * * * * * * *  *

// Creación del objeto de la clase heredada
$pdf = new PDF();
//$pdf=new FPDF('L','mm','A4');

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

  $pdf->SetFont('Arial','B',12);
  $pdf->Cell(110, 6, utf8_decode('BALANCE GENERAL DEL '.$fecha_inicio.' AL '.$fecha_fin), 0, 0, 'C');
  $pdf->Ln(5);
  $pdf->Ln(10);


  /******** Datos
  $ClienteNo = '00120498-02';
$Nombre = 'MARTINEZ BALDERAS LEOVIGILDO MANUEL';
$SolicitudNo = '27815';
$NoPrestamo = '030179';
$TasaInteres = 1.5;
$FechaEntrega = '21/12/2018';
$Plazo = '76 cada 7 dias';
$Monto = 30000;
$TipoCredito = 'NOP CREDINOMINA PRODECO';
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
  $pdf->Cell(144, 3, "hhhhhh", 0, 0, 'L');
  $pdf->Ln(10);

*/


  /*    Crea tabla    */

  $header = array(utf8_decode('Folio de Crédito'), 'No. de cuenta', utf8_decode('Descripción'), 'Fecha','Debe', 'Haber');

  $pdf->SetFont('Arial','',8);

  // Anchuras de las columnas
  $column_width = 27;

  // Cabeceras
  for($i=0; $i<count($header); $i++){
    if($i==2)
      $pdf->Cell($column_width*2, 5, $header[$i], 1, 0, 'C');
    else
     $pdf->Cell($column_width, 5, $header[$i], 1, 0, 'C');
  }
  $pdf->Ln();

  



  if ($k<$rows_per_page)
  {
    $rows_count = 30;
  }
  else {
    $rows_count = $rows_data - ($rows_per_page-1)*30;
  }

  // Datos
  $total_debe = 0;
  $total_haber =0;
  //foreach ($data1 as $item){
  for($i=$m; $i<count($data1); $i++){
      $t= $t+1;
      $m= $m+1;
      //para obtener folio de crédito si lo hay
      $folio = "No aplica";
      if($data1[$i]["idkey_credito"] != ""){
        $data2 = $oconns->getRows("select folio FROM  creditos WHERE idkey='".$data1[$i]["idkey_credito"]."'");
        $folio = $data2[0]["folio"];
      }
      $pdf->Cell($column_width, 5, $folio, 'LR', 0, 'C');
      $pdf->Cell($column_width, 5, $data1[$i]["idkey_cuenta_contable"], 'LR', 0, 'C');
      $pdf->Cell($column_width*2, 5, utf8_decode($data1[$i]["nombre"]), 'LR', 0, 'C');
      $pdf->Cell($column_width, 5, $data1[$i]["fecha"], 'LR', 0, 'C');
      $pdf->Cell($column_width, 5, strval(number_format($data1[$i]["debe"],2)), 'LR', 0, 'C');
      $pdf->Cell($column_width, 5, strval(number_format($data1[$i]["haber"],2)), 'LR', 0, 'C');
      $pdf->Ln();
      $total_debe = $total_debe + floatval($data1[$i]["debe"]);
      $total_haber = $total_haber + floatval($data1[$i]["haber"]);
      if($t==30)
        break;
  }

  // Línea de cierre
  $pdf->Cell(6*$column_width,0,'','T');
  $pdf->Ln();


  if ($k==$rows_per_page)
  {
    // Ultimo renglon
    // en footer se pueden escribir los totales
    $footer = array('', '','','Totales', '$'.strval(number_format($total_debe, 2)), '$'.strval(number_format($total_haber, 2)));

    for($i=0; $i<count($header); $i++){
      if($i==2)
        $pdf->Cell($column_width*2, 5, $footer[$i], 1, 0, 'C');
      else
      $pdf->Cell($column_width, 5, $footer[$i], 1, 0, 'C');
    }
    $pdf->Ln();

    // Firma SOLICITANTE

/*
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
    */
  }


}




$pdf->Output();
?>
