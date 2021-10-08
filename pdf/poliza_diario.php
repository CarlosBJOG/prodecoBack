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
$idkey_poliza = $_GET["idkey_poliza_diario"];

$data = $oconns->getRows("select pe.fecha, pe.no_poliza, pe.concepto, pe.monto, serie, tipo from poliza_diario pe where idkey='$idkey_poliza'");
if($oconns->numberRows==0){
    echo "<script> alert('No se han encontrado datos coincidentes.'); window.location.href='index.php'; </script>";
    exit;
}
else{
     //Para los movimientos
    $data2 = $oconns->getRows("select m.idkey, m.idkey_cuenta_contable, m.referencia, m.debe, m.haber, m.descripcion, m.idkey_poliza, cc.nombre from poliza_diario_movimientos m INNER JOIN cuentas_contables cc ON (m.idkey_cuenta_contable = cc.no_cuenta)  WHERE m.idkey_poliza='$idkey_poliza'");
}


// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();

$pdf->AddPage();
 // Logo
 $pdf->Image('logoprodeco.png',10,8,33);
 // Arial bold 15
 $pdf->SetFont('Arial','B',8);
 // Movernos a la derecha
 $pdf->Cell(40);
 // Título
 $pdf->SetFont('Arial','B',8);
 $pdf->Cell(110,7,'PRODUCCION ECOTURISTICA COLOTEPEC SC. DE R.S. DE C.V', 0, 1, 'C');

 $pdf->SetFont('Arial','',6);
 $pdf->Cell(190,7,'PEC990606635', 0, 1, 'C');

 $pdf->Cell(190,3,'CALLE PRINCIPAL SN                                BARRA DE NAVIDAD', 0, 1, 'C');
 
 $pdf->Ln(1);

 $pdf->Cell(190,7,'_________________________________________________________________________________________________________________________________________________________', 0, 1, 'C');
 
 $pdf->SetFont('Arial','',8);
 $pdf->Cell(10,4,"", 0, 0, 'L');
 $pdf->Cell(90,4,"NO. POLIZA: ".$data[0]["no_poliza"], 0, 0, 'L');
 $pdf->Cell(50,4,"SERIE: ".$data[0]["serie"]." , TIPO: ".$data[0]["tipo"], 0,1, 'L');

 $pdf->Cell(10,4,"", 0, 0, 'L');
 $pdf->Cell(90,4,"FECHA POLIZA: ".$data[0]["fecha"], 0, 0, 'L');
 $pdf->Cell(50,4,"FECHA IMPRESION: ".date('Y-m-d H:i:s'), 0, 1, 'L');

 
 $pdf->Cell(10,4,"", 0, 0, 'L');
 $pdf->Cell(50,4,utf8_decode("CONCEPTO DE PÓLIZA: ".$data[0]["concepto"]), 0, 1, 'L');


  
 $pdf->Cell(10,4,"", 0, 0, 'L');
 $pdf->Cell(170,7,'___________________________________________________________________________________________________________________', 0, 1, 'C');
 
 $pdf->SetFont('Arial','B',8);

 $pdf->Cell(40,5,"CUENTA ", 0, 0, 'C');
 $pdf->Cell(30,5,"REFERENCIA ", 0, 0, 'C');
 $pdf->Cell(40,5,"NOMBRE CUENTA ", 0, 0, 'C');
 $pdf->Cell(40,5,"DEBE", 0, 0, 'C');
 $pdf->Cell(40,5,"HABER", 0, 1, 'C');

 $pdf->SetFont('Arial','B',6);

 $pdf->Ln(2);

$total_debe = 0;
$total_haber = 0;

 foreach ($data2 as $item){
     $pdf->Cell(40,4,$item["idkey_cuenta_contable"], 0, 0, 'C');
     $pdf->Cell(30,4,$item["referencia"], 0, 0, 'C');
     $pdf->Cell(40,4,$item["nombre"], 0, 0, 'C');
     $pdf->Cell(40,4,number_format($item["debe"],2), 0, 0, 'C');
     $pdf->Cell(40,4,number_format($item["haber"],2), 0, 1, 'C');

     $pdf->Ln(0);
     $total_debe = $total_debe + floatval($item["debe"]);
     $total_haber = $total_haber + floatval($item["haber"]);
 }

 $pdf->Ln(10);
 //sumas iguales
 $pdf->SetFont('Arial','B',9);
 $pdf->Cell(70,4,"", 0, 0, 'C');
 $pdf->Cell(40,5,"SUMAS IGUALES", 0, 0, 'C');
 $pdf->Cell(40,5,'$'.number_format($total_debe,2), 0, 0, 'C');
 $pdf->Cell(40,5,'$'.number_format($total_haber,2), 0, 1, 'C');
 

 $pdf->SetFont('Arial','B',8);
 $pdf->Ln(20);
 $pdf->Cell(10,4,"", 0, 0, 'L');

 $pdf->Cell(40,3,"________________________", 0, 0, 'C');
 $pdf->Cell(40,3,"________________________", 0, 1, 'C');


@session_start();
$nombre = $_SESSION["nombre"]." ".$_SESSION["apellido_p"]." ".$_SESSION["apellido_m"];   
 $pdf->Cell(50,5,utf8_decode($nombre), 0, 0, 'C');
 $pdf->Cell(30,5,utf8_decode("AUTORIZÓ"), 0, 1, 'C');



$pdf->Output();
?>
