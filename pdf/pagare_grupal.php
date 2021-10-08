<?php

require('fpdf.php');
require ('../php/clases/conversor.php');
require ('strfecha.php');
include "phpqrcode/qrlib.php";
require ('../php/db.php');

class PDF extends FPDF{
  // Cabecera de página
  function Header()
  {

  }
  // Pie de página
  function Footer(){
      // Posición: a 1,5 cm del final
      $this->SetY(-15);
      // Arial italic 8
      $this->SetFont('Arial','I',8);
      // Número de página
      $this->Cell(0,10, utf8_decode('Página ') .$this->PageNo() . '/{nb}',0,0,'C');
  }
}

$oconns = new database();
$idkey_credito = $_GET["idkey_credito"];
$query = "select vc.monto,vcg.nombre, vcg.idkey_cliente, vcg.nombre_grupo, vcg.monto, vcg.idkey_credito, vd.nombre_edo, vd.nombre_mpio, vd.nombre_loc, vd.nombre_cp from view_clientes_grupo as vcg INNER JOIN view_direcciones as vd INNER JOIN view_creditos as vc on vcg.idkey_cliente = vd.idkey_cliente and vc.idkey_credito = $idkey_credito WHERE vd.prioridad = 1 and vcg.idkey_credito = $idkey_credito";

$data = $oconns->getRows($query);
if ($oconns->numberRows>0){
  $Monto = utf8_decode(mb_strtoupper($data[0][0]));
  $nombre = utf8_decode(mb_strtoupper($data[0][1]));
  $nombre_grupo = utf8_decode(mb_strtoupper($data[0][3]));
  $id_credito_grupal = utf8_decode(mb_strtoupper($data[0][5]));

}
else{
  echo " <script> alert('No se encontraron los datos del credito.'); </script>";
  exit;
}

//numero de pagare de la bd(pendiente ya que no existen pagares en la bd)
$pagare = 1;

//numero de contrato (pendiente ya que no hay contratos en la bd);
$contrato = 1;
//convertimos cantidad a letras
require_once '../php/clases/CifrasEnLetras.php';

$cifra = new CifrasEnLetras();

if(is_float($Monto)){
  $centavos = explode(".",$Monto);
  $numero_letra = $cifra->convertirCifrasEnLetras($centavos[0]);
  $centavos = $centavos[1];
}else{
  $centavos = explode(".",$Monto);
  $numero_letra = $cifra->convertirCifrasEnLetras($centavos[0]);
  $centavos = '00';
}

// Se consulta la tabla de amortizacion
$query = "SELECT idkey, pago, descripcion, DATE_FORMAT(fecha_pago,'%d/%m/%Y') as fecha_pago, intereses, iva, renta, total, saldo_insoluto, idkey_creditos from amortizaciones  where idkey_creditos=".$idkey_credito." order by pago asc";
$data1 = $oconns->getRows($query);
$m = $oconns->numberRows;

$rows_data = $m;
$rows_per_page = ceil($rows_data / 30);

//processing form input
$errorCorrectionLevel = 'M';
$matrixPointSize = 4;

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
  
  $date = date('d-m-Y');
  $pdf->Cell(100, 5, utf8_decode('PAGARÉ'), 0, 0, 'C');
  $pdf->SetFont('Arial','',5);
  $pdf->Cell(10,5,"BARRA DE NAVIDAD OAXACA,Fecha: $date", 0, 1, 'C');
  $pdf->Cell(114,3,"", 0, 0, 'L');
  $pdf->Cell(43,3,"GRUPO: $nombre_grupo ", 0, 0, 'L');
  $pdf->Cell(40,3,"CREDITO GRUPAL: $id_credito_grupal", 0, 1, 'L');
  $pdf->SetFont('Arial','',6);
  $pdf->MultiCell(189, 4, utf8_decode("Por el presente PAGARE declaro (amos), debo(emos) y pagare(mos) INCONDICIONALMENTE este pagare a la orden de PRODUCCION ECOTURISTICA COLOTEPEC SC. DE R.S. DE C.V,mediante deposito realizado en cualquiera de las siguientes cuentas bancarias: cuenta numero 0191667350 o 0839599043 en Grupo Financiero Banorte, S.A.B. de C.V. (BANORTE), cuenta numero 0191050052 en Grupo Financiero BBVA Bancomer Sociedad Anonima (BANCOMER), cuenta numero 0252559653 en Banco del Ahorro Nacional y Servicios Financieros, S.N.C., Institucion de Banca de Desarrollo (BANSEFI), todas a nombre de PRODUCCION ECOTURISTICA COLOTEPEC SC. DE R.S. DE C.V,o bien en su domicilio ubicado en: EN CALLE PRINCIPAL SIN NUMERO, BARRA DE NAVIDAD, SANTA MARIA COLOTEPEC, POCHUTLA, OAXACA, CODIGO POSTAL 70934.. La cantidad de $$Monto (($numero_letra pesos M.N.) $centavos/100 M.N.), valor recibido en este acto a mi (nuestra) entera satisfacción. Cantidad que deberá ser cubierta según la tabla de amortizaciones que a continuación se presenta:
  "), 0, 'J', 0);

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

    $pdf->Ln(5);
    $pdf->SetFont('Arial','', 6);
    $pdf->MultiCell(189, 3, utf8_decode("Este pagare causara intereses ordinarios a la tasa del 1.50 % mensual a partir de suscripción, se amortizara en los términos pactados con antelación y las amortizaciones están sujetas a la condición de que, al no pagarse cualesquiera de ellas a su vencimiento. Serán exigibles todas las que le sigan en número, además de las ya vencidas de conformidad con el Articulo 79 de la Ley General de Títulos y Operaciones de Crédito, desde las fechas de amortizaciones y hasta el día de su liquidación, causaran intereses moratorios a la tasa del 0.00 % Mensual, pagadero juntamente con el principal, podrá ser presentado para su pago en cualquier tiempo a partir de la fecha de suscripción , los intereses se causaran sobre el capital insoluto de conformidad con el Articulo 152 inciso I,II,III,IV de la ley General de Títulos y Operaciones de Crédito. En caso de existir controversia sobre este pagara, las partes se someten expresamente a la jurisdicción de los tribunales de la Ciudad de Puerto Escondido, Oaxaca renunciando desde este momento, a cualquier fuero que en razón de sus domicilios presentes o futuros pudiera corresponderles. "), 0, 'J', 0);

    $pdf->Ln(2);

    $pdf->SetFont('Arial','B', 7);
    $pdf->Cell(80, 3, '', 0, 0, 'L');
    $pdf->Cell(30, 5, utf8_decode("OBLIGADOS SOLIDARIOS:"), 0, 1, 'L');
    $pdf->SetFont('Arial','', 6);

    for($i = 0; $i<count($data); $i++){
      $nombres = $data[$i][1];
      $estado = $data[$i][6];
      $nombre_mpio = $data[$i][7];
      $localidad = $data[$i][8];
      $cp = $data[$i][9];
      
      $pdf->Cell(30, 4, 'FIRMA:________________________', 0, 1, 'L');
      $pdf->Cell(30, 4,'NOMBRE: '.utf8_decode(mb_strtoupper($nombres)), 0, 1, 'L');
      $pdf->Cell(30, 4,'DOMICILIO: '.utf8_decode(mb_strtoupper($estado.' '.$nombre_mpio.' '.$localidad.' '.$cp)), 0, 1, 'L');
      $pdf->Ln(1);

    }
    $fecha = date('d/m/Y');
    $pdf->Ln(30);
    $pdf->SetFont('Arial','B', 7);
    $pdf->Cell(150, 4, "CONTRATO NO. $contrato", 0, 1, 'R');
    $pdf->Ln(5);
    $pdf->SetFont('Arial','', 7);
    $pdf->MultiCell(189, 6, utf8_decode("Endoso en garantía a favor de Financiera Nacional de Desarrollo Agropecuario, Rural, Forestal y Pesquero. Pagaré número $pagare, correspondiente al crédito del grupo ($nombre_grupo), por un importe de $$Monto (($numero_letra pesos M.N.) $centavos/100 M.N.). Calle principal de la población de Barra de Navidad, Colotepec, Pochutla, Oaxaca. $fecha."), 0, 'J', 0);

    $pdf->Cell(185, 4, 'FIRMA', 0, 1, 'C');
    $pdf->Ln(5);
    $pdf->Cell(185, 4, '________________________________', 0, 1, 'C');
    $pdf->MultiCell(189, 6, utf8_decode("PRODUCCION ECOTURISTICA COLOTEPEC SC. DE R.S. DE C.V
    C.ANGELICA CRUZ RAMOS
    Representante Legal"), 0, 'C', 0);

 

    // Direccion Prodeco

  }


}




$pdf->Output();
?>
