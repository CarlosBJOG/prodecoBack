<?php 
require('fpdf.php');
require ('../php/clases/conversor.php');
require ('strfecha.php');
include "phpqrcode/qrlib.php";
require ('../php/db.php');

class myPDF extends FPDF{

	
	function header(){
		$this->fecha = date("d/m/Y");
		$this->Image('logoprodeco.png',10,4,30);
		$this->SetFont('Arial', 'B', 12);
		$this->Cell(200,5, '',0,1,'C', 0);
		$this->Cell(195, 8, 'PRODUCCION ECOTURISTICA COLOTEPEC SC. DE R.S DE C.V', 0, 1, 'C');
		$this->SetFillColor(10, 134, 0);
		$this->Cell(195,1, '',0,1,'C', 1);
		$this->SetFillColor(255, 0, 0);
		$this->Cell(195,1, '',0,1,'C', 1);
		$this->Cell(195,3, '',0,1,'C', 0);
		$this->SetFont('Arial', 'B', 10);
    $this->Cell(95, 10, 'BARRA DE NAVIDAD', 0, 0, 'L');
    $this->Cell(90, 10, utf8_decode("Fecha de impresión:{$this->fecha }"), 0, 1, 'R');
		$this->Cell(195,7, utf8_decode('TABLA DE AMORTIZACION GRUPAL'),0,1,'C', 0);
		
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
$query = "SELECT vc.*, f.nombre as desc_frec, DATE_FORMAT(fecha_desembolso,'%d/%m/%Y') as fecha_desembolso, DATE_FORMAT(primer_pago,'%d/%m/%Y') as primer_pago, f.dias FROM view_creditos vc inner join frecuencia f on vc.idkey_frecuencia=f.idkey  where vc.idkey_credito=".$idkey_credito;
$data = $oconns->getRows($query);
if ($oconns->numberRows>0){
    $numero_prestamo = $data[0]["folio"];
    $nombre_grupo = utf8_decode(mb_strtoupper($data[0]["nombre"]));
    $idkey_grupo = $data[0]["idkey_clientes"];
    $tipo_credito = utf8_decode(mb_strtoupper($data[0]["nombre_producto"]));
    $fecha_desembolso = $data[0]["fecha_desembolso"];
    $monto = strval(number_format($data[0]["monto"],2));
    $tasa_interes = $data[0]["tasa_interes"]."%";
    $frecuencia = utf8_decode(mb_strtoupper($data[0]["desc_frec"]));
    $npagos = intval($data[0]["numero_pagos"]);

    $idkey_usuario = $data[0]["idkey_usuario"];
    $asesor = utf8_decode(mb_strtoupper($oconns->getSimple("select CONCAT(g.nombre, ' ', g.apellido_p, ' ',  g.apellido_m) as asesor from usuarios u INNER JOIN empleados e on ( u.idkey_empleados = e.idkey) INNER JOIN generales g on (e.idkey_generales=g.idkey) where u.idkey=".$idkey_usuario)));

    //Datos de los clientes del crédito
    $clientes = $oconns->getRows("select gc.idkey_grupo, gc.idkey_clientes,gc.porcentaje,  vc.nombre, gc.monto from view_clientes vc  inner join grupos_clientes gc on gc.idkey_clientes = vc.idkey_cliente where idkey_grupo=".$idkey_grupo);
    $ncli = $oconns->numberRows;
    if($ncli >0){

    }
    

    //$response['finalidad'] = $finalidad;
    
    //$response['tipo_credito'] = $data[0]["tipo_credito"];
    
    
  }
else{
  echo " <script> alert('No se encontraron los datos del credito.'); </script>";
  exit;
}
$Nombre = 'MARTINEZ BALDERAS LEOVIGILDO MANUEL';



$dir = 'temp/';

if (!file_exists($dir)) {
  mkdir($dir);
}

$filename = $dir.$idkey_credito.'.png';

$tam = 10;
$level = 'M';
$framesize = 3;
$contenido = $numero_prestamo;

QRcode::png($contenido, $filename, $level, $tam, $framesize);

// Se consulta la tabla de amortizacion
$query = "SELECT idkey, pago, descripcion, DATE_FORMAT(fecha_pago,'%d/%m/%Y') as fecha_pago, intereses, iva, renta, total, saldo_insoluto, idkey_creditos from amortizaciones  where idkey_creditos=".$idkey_credito." order by pago asc";
$data1 = $oconns->getRows($query);
$na = $oconns->numberRows;
$max = 28 - intval($ncli);

// Esta informacion se puede saber a partir del plazo
$rows_data = $na;
$rows_per_page = ceil($rows_data / $max);



$pdf = new myPDF();
$pdf->AliasNbPages();

// Crea una pagina con encabezado para la TABLA
$contador = 1;
$iva_total =0;
$intereses_total =0;
$total_total =0;
$m = 0;
for($k=1; $k<=$rows_per_page; $k++)
{
  $t =0;

  $pdf->AddPage();

  $pdf->Image($filename,160,55,30);

  // Datos del CREDITO
  $pdf->SetTextColor(0,  0, 0);
  $pdf->Ln(3);
  $pdf->SetFont('Arial','B', 8);
  $pdf->Cell(35, 3, 'NOMBRE DEL GRUPO:', 0, 0, 'L');
  $pdf->Cell(1);
  $pdf->SetFont('Arial','', 8);
  $pdf->Cell(70, 3, utf8_decode($nombre_grupo."-".$idkey_grupo), 0, 0, 'L');

  $pdf->Ln(4);
  $pdf->SetFont('Arial','B', 8);
  $pdf->Cell(35, 3, 'TIPO DE PRESTAMO:', 0, 0, 'L');
  $pdf->Cell(1);
  $pdf->SetFont('Arial','', 8);
  $pdf->Cell(70, 3,utf8_decode($tipo_credito), 0, 0, 'L');
  $pdf->SetFont('Arial','B', 10);
  $pdf->Cell(62, 0, utf8_decode('Código de préstamo '), 0, 0, 'R');

  $pdf->Ln(4);
  $pdf->SetFont('Arial','B', 8);
  $pdf->Cell(35, 3, 'ASESORES: ', 0, 0, 'L');
  $pdf->Cell(1);
  $pdf->SetFont('Arial','', 8);
  $pdf->Cell(30, 3, utf8_decode($asesor), 0, 0, 'L');
  $pdf->Cell(1);
  $pdf->SetFont('Arial','B', 10);
  $pdf->Cell(81, 2, utf8_decode($numero_prestamo), 0, 0, 'R');
  $pdf->Cell(1);

  $pdf->Ln(4);
  $pdf->SetFont('Arial','B', 8);
  $pdf->Cell(35, 3, utf8_decode('NO. DE PARTICIPANTES:'), 0, 0, 'L');
  $pdf->Cell(1);
  $pdf->SetFont('Arial','', 8);
  $pdf->Cell(40, 3, utf8_decode($ncli), 0, 0, 'L');
  $pdf->Cell(1);
  $pdf->SetFont('Arial','B', 8);
  $pdf->Cell(55, 3, utf8_decode('FECHA DE DESEEMBOLSO: '), 0, 0, 'R');
  $pdf->Cell(1);
  $pdf->SetFont('Arial','', 8);
  $pdf->Cell(30, 3,utf8_decode($fecha_desembolso), 0, 0, 'L');

  $pdf->Ln(4);
  $pdf->SetFont('Arial','B', 8);
  $pdf->Cell(35, 3, utf8_decode('MONTO:'), 0, 0, 'L');
  $pdf->Cell(1);
  $pdf->SetFont('Arial','', 8);
  $pdf->Cell(40, 3, $monto, 0, 0, 'L');
  $pdf->Cell(1);
  $pdf->SetFont('Arial','B', 8);
  $pdf->Cell(40, 3, utf8_decode(' '), 0, 0, 'L');
  $pdf->Cell(1);
  $pdf->SetFont('Arial','', 8);
  $pdf->Cell(30, 3,utf8_decode(''), 0, 0, 'L');

  $pdf->Ln(4);
  $pdf->SetFont('Arial','B', 8);
  $pdf->Cell(35, 3, utf8_decode('TASA DE INTERES:'), 0, 0, 'L');
  $pdf->Cell(1);
  $pdf->SetFont('Arial','', 8);
  $pdf->Cell(40, 3, utf8_decode($tasa_interes), 0, 0, 'L');
  $pdf->Cell(1);


  $pdf->Ln(4);
  $pdf->SetFont('Arial','B', 8);
  $pdf->Cell(35, 3, utf8_decode('TIPO DE PLAN:'), 0, 0, 'L');
  $pdf->Cell(1);
  $pdf->SetFont('Arial','', 8);
  $pdf->Cell(40, 3, utf8_decode('PRINCIPAL NIVELADO'), 0, 0, 'L');
  $pdf->Cell(1);

  $pdf->Ln(4);
  $pdf->SetFont('Arial','B', 8);
  $pdf->Cell(35, 3, utf8_decode('TIPO DE PLAZO:'), 0, 0, 'L');
  $pdf->Cell(1);
  $pdf->SetFont('Arial','', 8);
  $pdf->Cell(40, 3, utf8_decode($frecuencia), 0, 0, 'L');
  $pdf->Cell(1);

  $pdf->Ln(4);
  $pdf->SetFont('Arial','B', 8);
  $pdf->Cell(35, 3, utf8_decode('CUOTAS:'), 0, 0, 'L');
  $pdf->Cell(1);
  $pdf->SetFont('Arial','', 8);
  $pdf->Cell(40, 3, utf8_decode($npagos), 0, 0, 'L');
  $pdf->Cell(1);

  $pdf->Ln(4);
  $pdf->SetFont('Arial','B', 8);
  $pdf->Cell(195, 3, utf8_decode('INTEGRANDES DEL GRUPO'), 0, 0, 'C');
  $pdf->Cell(1);

  $pdf->Ln(4);
  $pdf->SetFont('Arial','B', 8);
  $pdf->Cell(55, 3, utf8_decode('NOMBRE Y APELLIDOS:'), 0, 0, 'L');

  $pdf->Cell(45, 3, utf8_decode('COD.CLIENTE'), 0, 0, 'L');

  $pdf->Cell(45, 3, utf8_decode('MONTO '), 0, 0, 'L');

  $pdf->Cell(45, 3,utf8_decode('PORCENTAJE'), 0, 0, 'L');


  $pdf->Ln(4);
  $pdf->SetFont('Arial','', 8);
  foreach ($clientes as $item){
    $pdf->Cell(55, 3, utf8_decode(mb_strtoupper($item["nombre"])), 0, 0, 'L');

    $pdf->Cell(45, 3, utf8_decode(mb_strtoupper($item["idkey_clientes"])), 0, 0, 'L');

    $pdf->Cell(45, 3, "$".strval(number_format($item["monto"],2)), 0, 0, 'L');

    $pdf->Cell(45, 3,strval(number_format($item["porcentaje"],2))."%", 0, 0, 'L');

    $pdf->Ln(4);
  }

  $pdf->Cell(125, 3, utf8_decode('_________________'), 0, 0, 'R');

  $pdf->Ln(4);

  $pdf->Cell(115, 3, utf8_decode("$".$monto), 0, 0, 'R');



  $pdf->Ln(5);

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
  if ($k==1){
    $first_line = array('', '', '', '', '', '', $monto);

    for($i=0; $i<count($header); $i++)
      $pdf->Cell($column_width, 5, $first_line[$i], 'LR', 0, 'C');
      $pdf->Ln();
  }



  if ($k<$rows_per_page)
  {
    $rows_count = $max;
  }
  else {
    $rows_count = $rows_data - ($rows_per_page-1)*$max;
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
      if($t==$max)
        break;
  }
  /*
  for($i=0; $i<$rows_count; $i++){


      $pdf->Cell($column_width, 5, '28/12/2018', 'LR', 0, 'C');
      $pdf->Cell($column_width, 5, "$contador de $rows_data", 'LR', 0, 'C');
      $pdf->Cell($column_width, 5, '337.76', 'LR', 0, 'C');
      $pdf->Cell($column_width, 5, '105.00', 'LR', 0, 'C');
      $pdf->Cell($column_width, 5, '16.80', 'LR', 0, 'C');
      $pdf->Cell($column_width, 5, '459.56', 'LR', 0, 'C');
      $pdf->Cell($column_width, 5, '29,662.24', 'LR', 0, 'C');
      $pdf->Ln();
      $contador++;
      
  }*/

  // Línea de cierre
  $pdf->Cell(7*$column_width,0,'','T');
  $pdf->Ln();


  if ($k==$rows_per_page)
  {
    // Ultimo renglon
    // en footer se pueden escribir los totales
    //$footer = array('', 'Totales', '30,000.00', '4,246.87', '679.49', '34,926.36', '');
    $footer = array('', 'Totales', $monto, strval(number_format($intereses_total, 2)), strval(number_format($iva_total, 2)), strval(number_format($total_total, 2)), '');

    for($i=0; $i<count($header); $i++)
      $pdf->Cell($column_width, 5, $footer[$i], 1, 0, 'C');


    // Firma SOLICITANTE

    $pdf->Ln(10);
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