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
//variables
$fecha = '17 al 20 de marzo de 2020';//formato de fecha 
$promotor = 'nombre prueba';
$compromiso = 100000;
$efectivo = 0;
$cheque = 0;
$transferencia = 0;
$notas = 'notas';
$fecha = '03/01/2021';
$total_compromiso = 100000;
$total_efectivo = 0;
$total_cheque = 0;
$total_transferencia = 0;
$porcentate_garliquida = 0;
$total_general  = 0;
$cuenta_bancaria = 'BANORTE PRUEBA';


// Creación del objeto de la clase heredada
$pdf = new PDF('L','mm','A4');
$pdf->AliasNbPages();

$pdf->AddPage();
$pdf->SetFont('Arial','B',8);

//cabecera
$pdf->Cell(15,4,"", 0, 0, 'L');
$pdf->Cell(240,5, utf8_decode('PRODUCCION ECOTURISTICA COLOTEPEC S.C. DE R.S. DE C.V.'), 1 ,1,'C');

//la fecha del rango de las polizas
$pdf->Cell(15,4,"", 0, 0, 'L');
$pdf->Cell(240,5, utf8_decode("PROYECCION DE LA COLOCACION DE CREDITOS $fecha"), 1 ,1,'C');

//cabecera de tabla
$pdf->Cell(15,4,"", 0, 0, 'L');
$pdf->SetFillColor(203,203,203);
$pdf->Cell(50,10, utf8_decode("PROMOTOR"), 1 ,0,'C',1);
$pdf->Cell(30,10, utf8_decode("COMPROMISO"), 1 ,0,'C',1);
$pdf->Cell(30,10, utf8_decode("EFECTIVO"), 1 ,0,'C',1);
$pdf->Cell(30,10, utf8_decode("CHEQUE"), 1 ,0,'C',1);
$pdf->Cell(30,10, utf8_decode("TRANSFERENCIA"), 1 ,0,'C',1);
$pdf->Cell(30,10, utf8_decode("NOTAS"), 1 ,0,'C',1);
$pdf->MultiCell(40, 5, utf8_decode("FECHA EN QUE SE UTILIZARA EL RECURSO"), 1, 'C', 1);
$pdf->SetFillColor(255,255,255);


$pdf->SetFont('Arial','',6);
$pdf->Cell(15,4,"", 0, 0, 'L');
$pdf->Cell(50,10, utf8_decode("COMITÉ DE CREDITO"), 1 ,0,'C',1);
$pdf->Cell(30,10, utf8_decode(""), 1 ,0,'C',1);
$pdf->Cell(30,10, utf8_decode(""), 1 ,0,'C',1);
$pdf->Cell(30,10, utf8_decode(""), 1 ,0,'C',1);
$pdf->Cell(30,10, utf8_decode(""), 1 ,0,'C',1);
$pdf->Cell(30,10, utf8_decode(""), 1 ,0,'C',1);
$pdf->Cell(40,10, utf8_decode(""), 1 ,1,'C',1);



//el ciclo esta de prueba, este se cambiara por el numero de clientes
for($i = 0; $i < 5; $i++){
    $pdf->Cell(15,4,"", 0, 0, 'L');
    $pdf->Cell(50,10, utf8_decode("$promotor"), 1 ,0,'C',1);
    $pdf->Cell(30,10, utf8_decode("$compromiso"), 1 ,0,'C',1);
    $pdf->Cell(30,10, utf8_decode("$efectivo"), 1 ,0,'C',1);
    $pdf->Cell(30,10, utf8_decode("$cheque"), 1 ,0,'C',1);
    $pdf->Cell(30,10, utf8_decode("$transferencia"), 1 ,0,'C',1);
    $pdf->Cell(30,10, utf8_decode("$notas"), 1 ,0,'C',1);
    $pdf->Cell(40,10, utf8_decode("$fecha"), 1 ,1,'C',1);

}



$pdf->Cell(15,4,"", 0, 0, 'L');
$pdf->Cell(50,10, utf8_decode(""), 0 ,0,'C',1);
$pdf->Cell(30,10, utf8_decode("$total_compromiso"), 1 ,0,'C',1);
$pdf->Cell(30,10, utf8_decode("$total_efectivo"), 1 ,0,'C',1);
$pdf->Cell(30,10, utf8_decode("$total_cheque"), 1 ,0,'C',1);
$pdf->Cell(30,10, utf8_decode("$total_transferencia"), 1 ,1,'C',1);

$pdf->Ln(5);
//ultima seccion 
$pdf->SetFont('Arial','B',10);
$pdf->Cell(55,4,"", 0, 0, 'L');
$pdf->Cell(40,5, utf8_decode("EFECTIVO:"), 0 ,0,'R',1);
$pdf->Cell(40,5, utf8_decode("$total_efectivo"), 0 ,1,'L',1);

$pdf->Cell(55,4,"", 0, 0, 'L');
$pdf->Cell(40,5, utf8_decode("$porcentate_garliquida% ADICIONAL"), 0 ,0,'R',1);
$pdf->Cell(40,5, utf8_decode("$total_efectivo"), 0 ,1,'L',1);

$pdf->Cell(55,4,"", 0, 0, 'L');
$pdf->Cell(40,5, utf8_decode("TOTAL:"), 0 ,0,'R',1);
$pdf->Cell(40,5, utf8_decode("$total_general"), 0 ,1,'L',1);

$pdf->Cell(55,4,"", 0, 0, 'L');
$pdf->Cell(40,5, utf8_decode("BOVEDA:"), 0 ,0,'R',1);
$pdf->Cell(40,5, utf8_decode("$ DINERO EN BOVEDA"), 0 ,1,'L',1);//es el dinero que se tomara de la boveda

$pdf->Cell(55,4,"", 0, 0, 'L');
$pdf->Cell(40,5, utf8_decode("CUENTA:"), 0 ,0,'R',1);
$pdf->Cell(40,5, utf8_decode("$cuenta_bancaria"), 0 ,1,'L',1);//la cuenta bancarai que proporcionara la cantidad restante







$pdf->Output();
?>
