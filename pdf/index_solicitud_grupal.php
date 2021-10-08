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
//fecha y hora seleccionada (pendiente debido a que sera del formulario);
$fecha_hora= '';

$oconns = new database();
$idkey_credito = $_GET["idkey_credito"];

// Se consulta la tabla de amortizacion
$query = "SELECT nombre, monto, numero_pagos, tasa_interes, plazo, finalidad from view_cred_grupales where idkey_credito = $idkey_credito";
$data1 = $oconns->getRows($query);
if ($oconns->numberRows>0){
    $nombre_grupo =utf8_decode(mb_strtoupper($data1[0]['nombre'])); 
    $monto_total =utf8_decode(mb_strtoupper($data1[0]['monto']));
    $total_pagos =utf8_decode(mb_strtoupper($data1[0]['numero_pagos'])); 
    $tasa_interes =utf8_decode(mb_strtoupper($data1[0]['tasa_interes']));
    $plazo = utf8_decode(mb_strtoupper($data1[0]['plazo'])) ;
    $finalidad = utf8_decode(mb_strtoupper($data1[0]['finalidad'])) ;

  }
else{
  echo " <script> alert('No se encontraron los datos del credito.'); </script>";
  exit;
}
//tasa de interes mensual
$tasa_interes = $tasa_interes/12;

//total de integrantes
// Se consulta la tabla de amortizacion
$query = "SELECT COUNT(*) as integrantes FROM view_clientes_grupo where idkey_credito = $idkey_credito";
$data = $oconns->getRows($query);
if ($oconns->numberRows>0){
    $integrantes =utf8_decode($data[0]['integrantes']); 
  }
else{
  echo " <script> alert('No se encontraron los datos del credito.'); </script>";
  exit;
}


// Creación del objeto de la clase heredada
$pdf = new PDF('L','mm','A4');
$pdf->AliasNbPages();

$pdf->AddPage();
$pdf->SetFont('Arial','B',8);
//header
$pdf->SetFillColor(0,0,0);
$pdf->SetTextColor(255,255,255);
$pdf->Cell(60,5,'SOLICITUD DE CREDITO GRUPAL', 0, 0, 'C',1);

$pdf->SetFillColor(255,245,178);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(90,5,'', 0, 0, 'C',1);

$pdf->SetFillColor(0,0,0);
$pdf->SetTextColor(255,255,255);
$pdf->Cell(60,5,'CICLO', 0, 0, 'C',1);

$pdf->SetFillColor(255,245,178);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(65,5,'', 0, 1, 'C',1);



//campos de fecha y hora
$pdf->Ln(5);

$pdf->Cell(130, 5, '', 0, 0, 'C' );
$pdf->Cell(25, 3, "FECHA Y HORA: ", 0, 0, 'L' );
$pdf->SetFillColor(255,245,178);
$pdf->Cell(120, 4, $fecha_hora, 0, 1, 'C' ,1);
$pdf->Cell(276, 0, "____________________________________________________________________________", 0, 1, 'R' );

$pdf->Ln(3);

$pdf->Cell(130, 5, '', 0, 0, 'C' );
$pdf->Cell(25, 5, "LOCALIDAD: ", 0, 0, 'L' );
$pdf->SetFillColor(255,245,178);
$pdf->Cell(120, 4, '', 0, 1, 'C' ,1);
$pdf->Cell(276, 0, "____________________________________________________________________________", 0, 1, 'R' );

//subtitulo

$pdf->Ln(3);
$pdf->Cell(100, 5, "PRODUCCION ECOTURISTICA COLOTEPEC S.C. DE R.S. DE C.V", 0, 1, 'L');
$pdf->Cell(100, 5, "PRESENTE:", 0, 1, 'L');

$pdf->Ln(3);

$pdf->SetFont('Arial','',8);
$pdf->MultiCell(275, 3, utf8_decode('Por medio de la presente, y con el debido respeto, los integrantes del grupo solidario que se indica, hemos acordado por unanimidad realizar la siguiente solicitud de crédito a efecto de poder financiar nuestras actividades productivas comerciales, las cuales bajo protesta de decir verdad son totalmente legales y viables. Por lo que en este sentido, de ser aprobada la presente solicitud, el Grupo se compromete en forma solidaria a cumplir totalmente con el pago del 100% del monto solicitado, incluidos los intereses acordados, de todas y cada una de los integrantes, para lo cuál firmará un pagaré a PRODECO.'), 0, 'J', 0);


$pdf->Ln(3);
$pdf->Cell(100, 5, utf8_decode("Como testimonio y de acuerdo con los términos del préstamo, detallamos y firmamos nuestra solicitud."), 0, 1, 'L');

$pdf->Ln(4);

//datos de la solicitud grupal
$pdf->Cell(140, 5, '', 0, 0, 'C' );
$pdf->Cell(60, 5, "NOMBRE DEL GRUPO: ", 1, 0, 'L' );
$pdf->SetFillColor(255,245,178);
$pdf->Cell(75, 5, "$nombre_grupo", 1, 1, 'C' ,1);

$pdf->Cell(140, 5, '', 0, 0, 'C' );
$pdf->Cell(60, 5, "NUM DE INTEGRANTES:", 1, 0, 'L' );
$pdf->SetFillColor(255,245,178);
$pdf->Cell(75, 5, "$integrantes", 1, 1, 'C' ,1);

$pdf->Cell(140, 5, '', 0, 0, 'C' );
$pdf->Cell(60, 5, "MONTO GRUPAL SOLICITAD:", 1, 0, 'L' );
$pdf->SetFillColor(255,245,178);
$pdf->Cell(75, 5, "$$monto_total", 1, 1, 'C' ,1);

$pdf->SetFont('Arial','B',14);
$pdf->Cell(140, 5, 'DATOS DE LA SOLICITUD GRUPAL', 0, 0, 'C' );
$pdf->SetFont('Arial','',8);
$pdf->Cell(60, 5, "NUMERO DE AMORTIZACIONES: ", 1, 0, 'L' );
$pdf->SetFillColor(255,245,178);
$pdf->Cell(75, 5, "$total_pagos", 1, 1, 'C' ,1);

$pdf->Cell(140, 5, '', 0, 0, 'C' );
$pdf->Cell(60, 5, "TASA (MENSUAL): ", 1, 0, 'L' );
$pdf->SetFillColor(255,245,178);
$pdf->Cell(75, 5, "$tasa_interes%", 1, 1, 'C' ,1);

$pdf->Cell(140, 5, '', 0, 0, 'C' );
$pdf->Cell(60, 5, "PLAZO (MESES): ", 1, 0, 'L' );
$pdf->SetFillColor(255,245,178);
$pdf->Cell(75, 5, "$plazo MESES", 1, 1, 'C' ,1);

//mensaje de solicitud 
$pdf->SetFillColor(203,203,203);
$pdf->SetFont('Arial','B',6);

$pdf->MultiCell(275, 3, utf8_decode('*L@S INTEGRANTES DEL GRUPO DECLARAMOS QUE SABEMOS, QUE LOS MONTOS SEÑALADOS SON APROXIMADOS Y PODRÁN VARIAR (AUMENTAR O DISMINUIR) SEGÚN LA FECHA DE DISPERSIÓN, POR LO QUE DE SER AUTORIZADO LA PRESENTE SOLICITUD NOS COMPROMETEMOS INEXCUSABLEMENTE A LIQUIDAR EL CRÉDITO CONFORME A LOS MONTOS Y PLAZOS AUTORIZADOS.'), 1, 'J', 1);

$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',8);

//cabecera de tabla
$pdf->Cell(55, 8, "NOMBRE", 1, 0, 'C' );
$pdf->Cell(50, 8, "CURP", 1, 0, 'C' );
$pdf->Cell(50, 8, "MONTO SOLCITADO", 1, 0, 'C' );
$pdf->Cell(60, 8, "ACTIVIDAD A FINANCIAR", 1, 0, 'C' );
$pdf->Cell(60, 8, "FIRMA", 1, 1, 'C' );


//datos de clientes grupo
$query = "select vcg.nombre, vcg.monto, vc.curp from view_clientes_grupo as vcg INNER JOIN view_clientes as vc on vcg.idkey_cliente = vc.idkey_cliente where vcg.idkey_credito = $idkey_credito";
$data_cliente = $oconns->getRows($query);

if ($oconns->numberRows>0){

    foreach($data_cliente as $item){
        $pdf->SetFillColor(255,245,178);
        $pdf->Cell(55, 8,utf8_decode(mb_strtoupper($item['nombre'])) , 1, 0, 'C',1);
        $pdf->Cell(50, 8, utf8_decode(mb_strtoupper($item['curp'])), 1, 0, 'C', 1 );
        $pdf->Cell(50, 8,"$".utf8_decode(mb_strtoupper($item['monto'])), 1, 0, 'C', 1 );
        $pdf->Cell(60, 8, "$finalidad", 1, 0, 'C', 1 );
        $pdf->Cell(60, 8, "", 1, 1, 'C',1 );
    }
  
}
else{
  echo " <script> alert('No se encontraron los datos del credito.'); </script>";
  exit;
}


$pdf->Output();
?>
