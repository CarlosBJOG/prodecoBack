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

$data = $oconns->getRows("select pe.fecha, pe.no_poliza, pe.concepto, pe.monto, pe.idkey_cuenta_contable1, referencia1, debe1, haber1, pe.idkey_cuenta_contable2, referencia2, debe2, haber2 from poliza_diario pe where idkey='$idkey_poliza'");
if($oconns->numberRows==0){
    echo "<script> alert('No se han encontrado datos coincidentes.'); window.location.href='index.php'; </script>";
    exit;
}
else{
    $no_cuenta1 = $data[0]["idkey_cuenta_contable1"];
    $no_cuenta2= $data[0]["idkey_cuenta_contable2"];
    $nombre_cuenta1 = $oconns->getSimple("select nombre from cuentas_contables where no_cuenta='$no_cuenta1'");
    $nombre_cuenta2 = $oconns->getSimple("select nombre from cuentas_contables where no_cuenta='$no_cuenta2'");
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
 $pdf->Cell(50,4,"SERIE: A8 , TIPO: E", 0,1, 'L');

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

 $pdf->Cell(40,4,$no_cuenta1, 0, 0, 'C');
 $pdf->Cell(30,4,$data[0]["referencia1"], 0, 0, 'C');
 $pdf->Cell(40,4,$nombre_cuenta1, 0, 0, 'C');
 $pdf->Cell(40,4,number_format($data[0]["debe1"],2), 0, 0, 'C');
 $pdf->Cell(40,4,number_format($data[0]["haber1"],2), 0, 1, 'C');

 $pdf->Ln(0);

 $pdf->Cell(40,4,$no_cuenta2, 0, 0, 'C');
 $pdf->Cell(30,4,$data[0]["referencia2"], 0, 0, 'C');
 $pdf->Cell(40,4,$nombre_cuenta2, 0, 0, 'C');
 $pdf->Cell(40,4,number_format($data[0]["debe2"],2), 0, 0, 'C');
 $pdf->Cell(40,4,number_format($data[0]["haber2"],2), 0, 1, 'C');

 $pdf->Ln(170);
 //sumas iguales
 $pdf->Cell(70,4,"", 0, 0, 'C');
 $pdf->Cell(40,5,"SUMAS IGUALES", 0, 0, 'C');
 $pdf->Cell(40,5,number_format($data[0]["debe2"],2), 0, 0, 'C');
 $pdf->Cell(40,5,number_format($data[0]["haber1"],2), 0, 1, 'C');
 

 
 $pdf->Ln(15);
 $pdf->Cell(10,4,"", 0, 0, 'L');

 $pdf->Cell(40,3,"_________________________", 0, 0, 'L');
 $pdf->Cell(40,3,"________________________", 0, 1, 'L');


@session_start();
$nombre = $_SESSION["nombre"]." ".$_SESSION["apellido_p"]." ".$_SESSION["apellido_m"];   
 $pdf->Cell(50,5,utf8_decode($nombre), 0, 0, 'C');
 $pdf->Cell(30,5,utf8_decode("AUTORIZÓ"), 0, 1, 'C');



$pdf->Output();
?>
