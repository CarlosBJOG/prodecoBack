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

// * * * * * * * * * * * * * * * * * * * * *  *
//      Simulacion de datos del credito
// * * * * * * * * * * * * * * * * * * * * *  *

$oconns = new database();
//$credito = $oconns->getRows("select * from view_creditos vc inner join amortizaciones a on a.idkey_creditos=vc.idkey_credito where vc.idkey_clientes=".$_GET["idkey_cliente"]." and folio='".$_GET["folio"]."';");
//$grupo = $oconns->getRows("select * from view_clientes_grupo where idkey_grupo=".$_GET["idkey_cliente"]." and folio='".$_GET["folio"]."';");
//$array_clientes = $oconns->getRows("SELECT view_contrato_grupal.*,ec.nombre as estadocivil FROM view_contrato_grupal inner join clientes_datos_adicionales cda on cda.idkey_clientes=view_contrato_grupal.idkey_cliente join estado_civil ec on ec.idkey=cda.idkey_estado_civil where idkey_grupo=".$_GET["idkey_cliente"]." and idkey_tipo_direccion=1;");

$idkey_credito = $_GET["idkey_credito"];
$data = $oconns->getRows("SELECT vg.idkey_credito, vg.folio, vg.idkey_clientes as idkey_grupo, vg.nombre as nombre_grupo, DATE_FORMAT(vg.fecha_desembolso,'%d-%m-%Y %H:%i:%s') as fecha_desembolso, vg.numero_pagos, vg.plazo, vg.monto, vg.tasa_interes, vg.primer_pago FROM view_cred_grupales vg WHERE vg.idkey_credito =".$idkey_credito);
$n = $oconns->numberRows;

$a = $oconns->getRows("select * from amortizaciones where idkey_creditos=".$idkey_credito." limit 1;");

if($n > 0){
    $nombre_grupo = $data[0]["nombre_grupo"];
    $cantidad = $data[0]["monto"];
    $resultado = convertir(strval($cantidad));
    $tasa_interes = $data[0]["tasa_interes"];
    $pagos = $data[0]["numero_pagos"];
    $fecha_desembolso = $data[0]["fecha_desembolso"];
    $fecha_credito = fechaCastellano($fecha_desembolso);
    $numero_contrato = $data[0]["folio"];

    //Consulta de los integrantes del crédito
    $data1 = $oconns->getRows("select vc.idkey_cliente, vcg.idkey_credito, vc.nombre, vc.nombre_identificacion, vc.no_identificacion, ec.nombre as estado_civil, CONCAT(vd.domicilio, ', No-Ext ', vd.exterior, ', No-Int ', vd.interior,', ', vd.nombre_loc,', ',vd.nombre_mpio,', ', vd.nombre_edo,', ',nombre_mpio) as domicilio from view_clientes vc  inner join grupos_clientes gc on (gc.idkey_clientes = vc.idkey_cliente)  inner join view_cred_grupales vcg on (vcg.idkey_clientes = gc.idkey_grupo) inner join clientes_datos_adicionales cda on (cda.idkey_clientes = gc.idkey_clientes) inner join estado_civil ec on (cda.idkey_estado_civil = ec.idkey ) inner join view_direcciones vd on (vd.idkey_cliente = gc.idkey_clientes) where vd.prioridad = 1 and vcg.idkey_credito=".$idkey_credito." order by gc.idkey asc");
    $m = $oconns->numberRows;
    if($m > 0){
        $representante_grupo = utf8_decode(mb_strtoupper($data1[0]["nombre"]));
        $str_identificacion = utf8_decode(mb_strtoupper($data1[0]["nombre_identificacion"])." CON NÚMERO ".$data1[0]["no_identificacion"]);

    }
    else
        exit;

}

if($n ==0 || $m == 0 ){
    exit;
}

// * * * * * * * * * * * * * * * * * * * * *  *



// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',8);
//$pdf->SetMargins(1.0, 1.0, 1.0);


// Encabezado

// Logo
$pdf->Image('logoprodeco.png',10,8,33);
// Arial bold 15
$pdf->SetFont('Arial','B',8);
// Movernos a la derecha
$pdf->Cell(40);
// Título
$pdf->Cell(110,7,utf8_decode('PRODUCCIÓN ECOTURÍSTICA COLOTEPEC SC. DE R.S. DE C.V'), 0, 0, 'C');
$pdf->Ln(8);
$pdf->Cell(40);

$pdf->Cell(110, 6, utf8_decode('CONTRATO DE CRÉDITO GRUPAL'), 0, 0, 'C');
$pdf->Ln(5);
$pdf->Cell(180, 6, "Contrato Grupo: " . strval($numero_contrato), 0, 0, 'R');
$pdf->Ln(10);



$str_grupo = "";

for ($i = 0; $i < $m; $i++) {
    $str_grupo = $str_grupo . utf8_decode($data1[$i]["nombre"]) . ", ";
}


$pdf->MultiCell(185, 4, utf8_decode('CONTRATO DE CRÉDITO QUE CELEBRAN POR UNA PARTE PRODUCCIÓN ECOTURÍSTICA COLOTEPEC SC. DE R.S. DE C.V A QUIEN EN LO SUCESIVO PARA LOS EFECTOS DEL PRESENTE CONTRATO SE LE DENOMINARÁ LA "ACREDITANTE ", REPRESENTADA EN ESTE ACTO POR EL C. ANGELICA CRUZ RAMOS Y POR OTRA LA(OS) C. ') . $str_grupo .  utf8_decode(' A QUIEN EN LO SUCESIVO PARA EFECTOS DEL PRESENTE CONTRATO SE DENOMINARÁ CONJUNTAMENTE "ACREDITADOS" E INDIVIDUALMENTE "ACREDITADO", QUIEN(ES) EN LO SUCESIVO PARA LOS MISMO EFECTOS SE DENOMINARÁ(N) COMO EL (LOS) OBLIGADO (S) SOLIDARIO (S), AL TENOR DE LAS SIGUIENTES DECLARACIONES Y CLAUSULAS:'));


$pdf->Ln(9);
$pdf->Cell(185,5,'DECLARACIONES',0,0,'C');
$pdf->Ln(7);
$pdf->Cell(185,5,utf8_decode('I. DECLARA LA ACREDITANTE, A TRAVÉS DE SU REPRESENTANTE LEGAL:'),0,0,'L');
$pdf->Ln(7);

$pdf->SetFont('Arial','',8);
$pdf->MultiCell(185,3,utf8_decode('a) QUE ES UNA SOCIEDAD COOPERATIVA CONSTITUIDA DE CONFORMIDAD CON LAS LEYES DE LA REPÚBLICA MEXICANA, SEGÚN CONSTA EN LA ESCRITURA PÚBLICA SEIS MIL DOSCIENTOS VEINTE, VOLUMEN SETENTA Y OCHO, DE FECHA SIETE DE JUNIO DE MIL NOVECIENTOS NOVENTA Y NUEVE , OTORGADA ANTE LA FE DEL LICENCIADO ROMÁN RUIZ SILVA, EN ESE ENTONCES NOTARIO PÚBLICO NÚMERO CUARENTA Y SIETE DEL ESTADO DE OAXACA, CON RESIDENCIA OFICIAL EN PINOTEPA NACIONAL, OAXACA, DEBIDAMENTE INSCRITO SU PRIMER TESTIMONIO BAJO LA PARTIDA NUMERO VEINTIUNO, SECCIÓN COMERCIO DEL REGISTRO PÚBLICO DE LA PROPIEDAD DE POCHUTLA OAXACA, CON FECHA QUINCE DE JUNIO DE MIL NOVECIENTOS NOVENTA Y NUEVE.'),0,'J',false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('b) QUE ACTUALMENTE TIENE EL RÉGIMEN JURÍDICO DE SOCIEDAD COOPERATIVA DE PRODUCCIÓN DE SERVICIOS DE RESPONSABILIDAD SUPLEMENTADA DE CAPITAL VARIABLE, SEGÚN CONSTA EN LA ESCRITURA PÚBLICA NÚMERO 22,127 VEINTIDÓS MIL CIENTO VEINTISIETE, DE FECHA 23 DE NOVIEMBRE DE 2017, OTORGADA ANTE LA FE DEL LIC. ANTONIO SEVERINO RAMÍREZ LÓPEZ, NOTARIO PÚBLICO TITULAR NÚMERO 57 CINCUENTA Y SIETE CON SEDE EN LA CIUDAD DE PUERTO ESCONDIDO, OAXACA, E INSCRITA EL DÍA 24 DE NOVIEMBRE DE 2017, BAJO EL REGISTRO 243 DEL TOMO NÚMERO II (DOS) DE LA SECCIÓN COMERCIO QUE SE LLEVA EN LA OFICIALÍA REGISTRAL CON SEDE EN EL DISTRITO DE POCHUTLA, PERTENECIENTE AL INSTITUTO DE LA FUNCIÓN REGISTRAL DEL ESTADO DE OAXACA.'),0,'J',false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('c) QUE LA C. ANGELICA CRUZ RAMOS CUENTA CON FACULTADES SUFICIENTES PARA CELEBRAR EL PRESENTE CONTRATO Y OBLIGAR A EL ACRADITANTE EN LOS TERMINOS DEL MISMO, SEGÚN CONSTA EN LA ESCRITURA PÚBLICA NÚMERO 22,127 VEINTIDÓS MIL CIENTO VEINTISIETE, DE FECHA 23 DE NOVIEMBRE DE 2017, OTORGADA ANTE LA FE DEL LIC. ANTONIO SEVERINO RAMÍREZ LÓPEZ, NOTARIO PÚBLICO TITULAR NÚMERO 57 CINCUENTA Y SIETE CON SEDE EN LA CIUDAD DE PUERTO ESCONDIDO, OAXACA, E INSCRITA EL DÍA 24 DE NOVIEMBRE DE 2017, BAJO EL REGISTRO 243 DEL TOMO NÚMERO II (DOS) DE LA SECCIÓN COMERCIO QUE SE LLEVA EN LA OFICIALÍA REGISTRAL CON SEDE EN EL DISTRITO DE POCHUTLA, PERTENECIENTE AL INSTITUTO DE LA FUNCIÓN REGISTRAL DEL ESTADO DE OAXACA. MISMAS FACULTADES QUE NO LE HAN SIDO REVOCADAS, MODIFICADAS O EN FORMA ALGUNA.'),0,'J',false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('d) QUE TIENE SU DOMICILIO EN CALLE PRINCIPAL SIN NÚMERO, BARRA DE NAVIDAD, SANTA MARÍA COLOTEPEC, POCHUTLA, OAXACA, CÓDIGO POSTAL 70934.'),0,'J',false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('e) QUE CONFORME A SU OBJETO SOCIAL, ESTÁ INTERESADA EN OTORGAR A EL ACREDITADO UN CRÉDITO CUYA CANTIDAD, CARACTERÍSTICAS Y CONDICIONES SE SEÑALAN MÁS ADELANTE, TODA VEZ QUE LA INFORMACIÓN QUE ÉSTOS HAN PROPORCIONADO A LA ACREDITANTE LOS HACE APARECER COMO PERSONAS SOLVENTES MORAL Y ECONÓMICAMENTE Y POR LO TANTO SUJETOS DE CRÉDITO.'),0,'J',false);

$pdf->Ln(5);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(185,5,'II.- DECLARAN INDIVIDUALMENTE LOS ACREDITADOS POR SU PROPIO DERECHO:',0,0,'L');
$pdf->Ln(7);




$pdf->SetFont('Arial','',8);


for ($i = 0; $i < count($data1); $i++) {
    $idkey_cliente = $data1[$i]["idkey_cliente"];
    $ocupacion = $oconns->getSimple("select ocupacion from clientes_ingresos where principal =1 and idkey_clientes = ".$idkey_cliente." limit 1");
   
    $str1 = strval($i+1) . ") EL (LA) SEÑOR(A) " . mb_strtoupper($data1[$i]["nombre"]) . ", SER MEXICANO(A), MAYOR DE EDAD, DE ESTADO CIVIL " . mb_strtoupper($data1[$i]["estado_civil"]) . " DEDICADO(A) A " . mb_strtoupper($ocupacion) . ",  TIENE SU DOMICILIO PARTICULAR EN " . mb_strtoupper($data1[$i]["domicilio"]) . ", IDENTIFICÁNDOSE CON " . mb_strtoupper($data1[$i]["nombre_identificacion"]) . "CON NUMERO ".$data1[$i]["no_identificacion"].", LA CUAL SE ANEXA EN COPIA SIMPLE A ESTE CONTRATO.";
    $pdf->MultiCell(185,3,utf8_decode($str1),0,'J',false);
    $pdf->Ln(2);
}



$pdf->Ln(7);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(185,5,'III.- DECLARAN CONJUNTAMENTE TODOS LOS ACREDITADOS POR SU PROPIO DERECHO:',0,0,'L');


$pdf->Ln(7);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(185, 3, utf8_decode('A) TENER LA CAPACIDAD JURÍDICA Y ECONÓMICA SUFICIENTE, ASÍ COMO LA SOLVENCIA MORAL PARA ASUMIR LAS OBLIGACIONES MATERIA DE ESTE CONTRATO Y CUMPLIRLAS EN LOS TÉRMINOS QUE MÁS ADELANTE SE PRECISAN.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185, 3, utf8_decode('B) QUE CON ANTERIORIDAD A LA FECHA DE FIRMA DEL PRESENTE CONTRATO, LA ACREDITANTE, LES HA INFORMADO Y EXPLICADO A CADA ACREDITADO, EL CONTENIDO DE CADA UNA DE LAS CLÁUSULAS QUE LO INTEGRAN, TALES COMO EL MONTO DE LOS PAGOS PARCIALES, LA FORMA Y PERIODICIDAD PARA LIQUIDARLOS, CARGAS FINANCIERAS, ACCESORIOS, EL DERECHO QUE TIENE A LIQUIDAR ANTICIPADAMENTE LA OPERACIÓN Y LAS CONDICIONES PARA ELLO, LOS INTERESES ORDINARIOS Y MORATORIOS, EN SU CASO, LA FORMA DE CALCULAR LOS MISMOS, GASTOS DE COBRANZA Y/O COMISIONES, Y DEMÁS GASTOS QUE SE ORIGINEN POR EL OTORGAMIENTO, ENTREGA, PAGO, COBRO Y/O RECUPERACIÓN DEL CRÉDITO Y SUS ACCESORIOS.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185, 3, utf8_decode('C) QUE CON ANTERIORIDAD A LA FIRMA DEL PRESENTE CONTRATO, CADA ACREDITADO HA SUSCRITO EL FORMATO DE AUTORIZACIÓN PARA SOLICITAR REPORTES DE CRÉDITO DE PERSONAS FÍSICAS, ANTE LAS SOCIEDADES DE INFORMACIÓN CREDITICIA QUE ESTIME CONVENIENTE LA ACREDITANTE.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185, 3,utf8_decode('D) QUE LIBREMENTE HAN CONSTITUIDO UN GRUPO DE PERSONAS (EN LO SUCESIVO EL "GRUPO") QUE DESEMPEÑAN UNA ACTIVIDAD PRODUCTIVA POR CUENTA PROPIA Y QUE EL CRÉDITO SOLICITADO SERÁ DESTINADO PARA EL DESARROLLO DE ACTIVIDADES PRODUCTIVAS, CON BASE EN LA SOLICITUD DE CRÉDITO SOLIDARIO PRESENTADA A LA ACREDITANTE, MISMA QUE HA SIDO ENTREGADA A LA ACREDITANTE Y HAN CONVENIDO EN DENOMINAR ') . utf8_decode($nombre_grupo) . utf8_decode(' (EN LO SUCESIVO EL "GRUPO").'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('E) QUE EL GRUPO CUENTA CON UN PRESIDENTE DE GRUPO: ') . $representante_grupo . utf8_decode(', EL CUAL SE ENCARGA DE LA ADMINISTRACIÓN DEL GRUPO, UN TESORERO Y UN SECRETARIO LOS CUALES REALIZARAN LAS FUNCIONES QUE ESTIPULEN EN EL REGLAMENTO INTERNO DEL GRUPO QUE ELLOS MISMOS ELABOREN, ADEMÁS DE CUMPLIR LO CONTENIDO EN ESTE CONTRATO.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('F) QUE LOS RECURSOS CON LOS CUALES HA DE PAGAR LOS SERVICIOS O PRODUCTOS RECIBIDOS, ASÍ COMO LAS OBLIGACIONES CONTRAÍDAS, HAN SIDO O SERÁN OBTENIDOS O GENERADOS A TRAVÉS DE UNA FUENTE DE ORIGEN LÍCITO. ASÍ MISMO QUE EL DESTINO DE LOS RECURSOS OBTENIDOS AL AMPARO DEL PRESENTE CONTRATO DE CRÉDITO SERÁ TAN SOLO PARA FINES PERMITIDOS POR LA LEY, Y QU NO SE ENCUENTRAN DENTRO DE LOS SUPUESTOS ESTABLECIDOS EN LOS ARTÍCULOS 139 Y 148 BIS Y 400 BIS DEL CÓDIGO PENAL FEDERAL.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('G) QUE SE LES INFORMÓ SOBRE EL COSTO ANUAL TOTAL ("CAT") DEL CRÉDITO QUE SE CONTRATA EN TÉRMINOS DEL PRESENTE CONTRATO. "CAT: EL COSTO ANUAL TOTAL DE FINANCIAMIENTO EXPRESADO EN TÉRMINOS PORCENTUALES ANUALES QUE, PARA FINES INFORMATIVOS Y DE COMPARACIÓN, INCORPORA LA TOTALIDAD DE LOS COSTOS Y GASTOS INHERENTES A LOS CRÉDITOS."'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('I) QUE LOS ACREDITADOS CONOCEN LAS PENAS EN LAS QUE INCURREN LAS PERSONAS QUE DECLARAN FALSAMENTE O HACIENDO CREER A ALGUIEN LA CAPACIDAD DE PAGO QUE NO SE TIENE CON EL OBJETO DE OBTENER UN CRÉDITO A SABIENDAS DE QUE NO VA A SER PAGADO O UN LUCRO INDEBIDO Y LAS SANCIONES DE CARÁCTER PENAL QUE TRAEN COMO CONSECUENCIA DICHA CONDUCTA ILÍCITA Y QUE PARA EFECTOS DEL PRESENTE CONTRATO ACTÚAN A NOMBRE Y POR CUENTA PROPIA.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('J) QUE LOS ACREDITADOS DECLARAN CONOCER QUE EL ORIGEN DEL RECURSO DEL CRÉDITO OTORGADO PUEDE SER PROPIO, ES DECIR, DE PRODECO, O DE UN FONDEO EXTERNO, ES DECIR, DE ENTIDADES GUBERNAMENTALES (FEDERALES, ESTATALES O MUNICIPALES), SIN QUE POR ESTE ÚLTIMO HECHO, DEBA ENTENDERSE QUE SON A FONDO PERDIDO, YA QUE PRODECO LOS RECIBE EN PRÉSTAMO. EN TODO CASO, EL ORIGEN DEL RECURSO, SE ESPECIFICARA EN EL "ANEXO ORIGEN DEL RECURSO", EL CUAL ES PARTE INTEGRANTE DEL PRESENTE CONTRATO POR LO QUE NUNCA PODRÁ INTERPRETARSE EN FORMA SEPARADA O AISLADA DE ESTE.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('K) QUE LA ACREDITANTE LES INFORMÓ QUE CUENTAN CON ASISTENCIA, ACCESOS Y FACILIDADES NECESARIAS PARA ATENDER LAS ACLARACIONES RELACIONADAS CON EL PRESENTE CONTRATO.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('L) QUE TODA LA INFORMACIÓN Y DATOS QUE PROPORCIONA PARA EL OTORGAMIENTO DEL CRÉDITO DE CONFORMIDAD CON LO PREVISTO EN EL PRESENTE CONTRATO ES CIERTA Y VERDADERA; ENCONTRÁNDOSE DENTRO DE DICHA INFORMACIÓN AQUELLA REFERENTE A SU IDENTIFICACIÓN, ESTADO CIVIL, DOMICILIO Y DEMÁS DATOS CONTENIDOS EN "LA SOLICITUD DE CRÉDITO" QUE CORREN AGREGADA AL PRESENTE CONTRATO DEBIDAMENTE FIRMADA POR LAS PARTES, Y ES PARTE INTEGRAL DEL MISMO, POR LO QUE NUNCA PODRÁN INTERPRETARSE EN FORMA AISLADA O SEPARADA A ESTE CONTRATO.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('M) QUE CON ANTERIORIDAD A LA FECHA DE FIRMA DEL PRESENTE CONTRATO, LA ACREDITANTE, LES HA INFORMADO Y EXPLICADO A CADA ACREDITADO, EL CONTENIDO DE CADA UNA DE LAS CLÁUSULAS QUE LO INTEGRAN, TALES COMO EL MONTO TOTAL A PAGAR EN EL CRÉDITO, EL MONTO Y NÚMERO DE LOS PAGO PARCIALES, LA FORMA Y PERIODICIDAD PARA LIQUIDARLOS, CARGAS FINANCIERAS, ACCESORIOS, EL DERECHO QUE TIENE A LIQUIDAR ANTICIPADAMENTE LA OPERACIÓN Y LAS CONDICIONES PARA ELLO, LOS INTERESES ORDINARIOS Y MORATORIOS, EN SU CASO, LA FORMA DE CALCULAR LOS MISMOS Y LOS MONTOS A PAGAR EN CADA PERIODO, GASTOS DE COBRANZA Y/O COMISIONES, Y DEMÁS TÉRMINOS Y CONDICIONES DEL CRÉDITO.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('N) QUE CON ANTERIORIDAD A LA CELEBRACIÓN DEL PRESENTE LA ACREDITANTE LE EXPLICÓ EL TRATAMIENTO QUE LE DARÁ A SUS DATOS PERSONALES MEDIANTE LA ENTREGA DE UN AVISO DE PRIVACIDAD, EN TÉRMINOS DE LA LEY FEDERAL DE PROTECCIÓN DE DATOS PERSONALES EN POSESIÓN DE LOS PARTICULARES, DONDE SE SEÑALA, ADEMÁS DEL TRATAMIENTO QUE SE LE DARÁN A SUS DATOS PERSONALES, LOS DERECHOS DE ACCESO, RECTIFICACIÓN, CANCELACIÓN U OPOSICIÓN CON LOS QUE CUENTA Y LA FORMA CÓMO LOS PUEDE HACER VALER.'), 0, 'J', false);



$pdf->Ln(4);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(185,5,'IV.TODAS LAS PARTES DECLARAN:',0,0,'L');

$pdf->Ln(5);
$pdf->SetFont('Arial','',8);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('a) QUE EN EL PRESENTE CONTRATO NO PRIVA ERROR, DOLO, MALA FE, VIOLENCIA O CUALQUIER VICIO DEL CONSENTIMIENTO QUE PUDIERA INVALIDARLO O ANULARLO POR LO QUE RENUNCIAN EXPRESAMENTE Y NO SE RESERVAN DERECHOS O ACCIONES QUE HACER VALER DENTRO O FUERA DE JUICIO, QUE LA LEY ESTABLEZCA A SU FAVOR POR TALES CONCEPTOS.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('b) QUE SE RECONOCEN MUTUAMENTE LA PERSONALIDAD Y FACULTADES LEGALES CON LAS QUE COMPARECEN A LA FIRMA DEL PRESENTE CONTRATO.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('c) QUE CON LA FIRMA DEL PRESENTE CONTRATO SABEN Y LES CONSTA QUE NO SE VIOLAN LEYES, REGLAMENTOS, DISPOSICIONES O NORMA LEGAL ALGUNA, NI ACUERDO O ESTATUTO SOCIAL ALGUNO, POR LO QUE ACEPTAN EN SUS TERMINOS EL PRESENTE CONTRATO Y SUS CONSECUENCIAS.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('CONFORMES LAS PARTES CON LAS DECLARACIONES QUE ANTECEDEN, ES SU VOLUNTAD EL SUJETAR EL PRESENTE CONTRATO AL CONTENIDO DE LAS SIGUIENTES:'), 0, 'J', false);








$pdf->Ln(7);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(185,5,'CLAUSULAS',0,0,'C');
$pdf->Ln(7);



$pdf->MultiCell(185,3,utf8_decode('PRIMERA. APERTURA DE CRÉDITO Y DISTRIBUCIÓN DE MONTOS.'), 0, 'J', false);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(185,3,utf8_decode('LA ACREDITANTE en este acto otorga un Crédito Grupal, en forma de Crédito Solidario, a cada uno de LOS ACREDITADOS, quienes disponen del mismo en lo individual en las cantidades que se describen en la Solicitud de Crédito del Grupo Solidario.
El importe total del crédito que LA ACREDITANTE otorga a LOS ACREDITADOS en su conjunto es la cantidad de $ ') . strval(number_format($cantidad, 2)) . utf8_decode(',(el "crédito"), mismo que se reembolsara en parcialidades , las cuales no superaran un plazo máximo de semanales. Dicho monto dispuesto generara un interés ordinario a razón de una tasa del ') . strval($tasa_interes) . utf8_decode(' mensual sobre saldos insolutos, condiciones que deberán observarse el momento de que disponga del crédito y de conformidad con las clausulas contenidas en el presente instrumento.
Dentro del monto del crédito dispuesto las partes acuerdan que no quedaran comprendidos en él los intereses, comisiones, impuestos, gastos y demás accesorios originados con motivo del otorgamiento, entrega, pago o recuperación del crédito que LOS ACREDITADOS deben cubrir. En el monto dispuesto correspondiente a cada uno de los Créditos individuales no quedan incluidas comisiones, cargos y demás gastos que se originen con motivo del mismo.
Como requisito indispensable para la entrega del crédito antes señalado, LOS ACREDITADOS se obliga solidariamente a dejar en garantía liquida el 5% (cinco por ciento) del monto autorizado;lo que para este efecto, cada integrante del grupo, cubrirá este porcentaje respecto a su porción individual del credito, previamente a la recepción de dicho crédito o en su defecto dicho porsentaje será descontado de monto a recibir. En caso de falta del crédito en tiempo y forma de acuerdo a la tabla de amortizaciones Grupal e Individual, LA ACREDITANTE podrá cubrir el o los pagos de mora, con la garantía liquida hasta aplicar la totalidad de esta; lo anterior sin mediar mayor autorización por parte de LOS ACREDITADOS, que la que da en este mismo acto, firmado de conformidad.
'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('Forman parte integrante del presente Contrato, los anexos que se enuncian a continuación, los cuáles se adjuntan al mismo:'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('Anexo A. Solicitud de Crédito del Grupo Solidario;
Anexo B. Solicitud Individual de Crédito;
Anexo C. Tabla de Amortizaciones Grupal;
Anexo D. Tabla de Amortizaciones Individual.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(185,3,utf8_decode('SEGUNDA. FORMA DE ENTREGA DEL CRÉDITO.'), 0, 'J', false);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(185,3,utf8_decode('LA ACREDITANTE entrega en este acto a cada uno de LOS ACREDITADOS en una sola exhibición los montos mencionados en la cláusula anterior, dicha entrega podrá ser mediante: cheque nominativo, dinero en efectivo o depósito en cuenta de depósito que LOS ACREDITADOS tengan operante en LA ACREDITANTE, en su caso, por concepto del importe dispuesto del Crédito, y LOS ACREDITADOS en este acto otorgan a LA ACREDITANTE de manera individual y con respecto a los importes recibidos por cada uno de ellos, el recibo más amplio que en derecho proceda.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('La firma de los acreditados en la póliza del cheque, la firma del presente contrato en caso de que el desembolso se haya realizado en efectivo, o bien el comprobante de depósito a cuenta de LOS ACREDITADOS hará las veces de comprobante de disposición de la suma otorgada en crédito.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('LOS ACREDITADOS serán responsables del mal uso que se haga de cualquier monto que reciban en virtud del presente Contrato.'), 0, 'J', false);


$pdf->Ln(2);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(185,3,utf8_decode('TERCERA. OBLIGACION DE PAGO Y TASA DE INTERES ORDINARIA.'), 0, 'J', false);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(185,3,utf8_decode('Cada uno de LOS ACREDITADOS se obliga a pagar a LA ACREDITANTE la cantidad individual recibida, más los intereses ordinarios según lo estipulado en la cláusula primera y la cláusula quinta del presente contrato.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('Dicha tasa de intereses ordinarios se calculará aplicando el porcentaje designado al monto dispuesto, considerando los días efectivamente transcurridos desde la disposición del crédito o fecha de pago del último interés ordinario cobrado y hasta la fecha de vencimiento del periodo designado para su cobro.'), 0, 'J', false);


$pdf->Ln(2);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(185,3,utf8_decode('CUARTA. OBLIGACION SOLIDARIA.'), 0, 'J', false);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(185,3,utf8_decode('Sin perjuicio de lo señalado en la cláusula tercera de este Contrato, cada uno de LOS ACREDITADOS constituye una obligación personal y solidaria respecto de las obligaciones asumidas por los demás ACREDITADOS, manifestando expresamente que no cesará su obligación sino hasta en tanto LA ACREDITANTE haya recibido la totalidad de las cantidades que LOS ACREDITADOS en su conjunto se obligan a pagar. En virtud de lo anterior, LOS ACREDITADOS en este acto se obligan de manera solidaria y personal a pagar a LA ACREDITANTE, el importe total del Crédito Grupal y los intereses ordinarios que se indican en este Contrato, así como los intereses moratorios, gastos de cobranza y/o comisiones, que en su caso se generen.
'), 0, 'J', false);


$pdf->Ln(2);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(185,3,utf8_decode('QUINTA. FORMA DE PAGO.'), 0, 'J', false);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(185,3,utf8_decode('LOS ACREDITADOS se obligan solidariamente a pagar a LA ACREDITANTE la cantidad dispuesta del importe del Crédito más los intereses ordinarios correspondientes, mediante ') . strval($pagos) . utf8_decode(' pagos consecutivos parciales por la cantidad de $ ') .  strval(number_format($cantidad, 2)) . utf8_decode(' cada uno de ellos, con vencimiento en las fechas indicadas en la tabla de amortizaciones grupal que se indica en la cláusula primera del presente contrato, con depósitos en cualquiera de las siguientes cuentas bancarias: cuenta número 0191667350 o 0839599043 en Grupo Financiero Banorte, S.A.B. de C.V. (BANORTE), cuenta número 0191050052 en Grupo Financiero BBVA Bancomer Sociedad Anónima (BANCOMER), cuenta número 0252559653 en Banco del Ahorro Nacional y Servicios Financieros, S.N.C., Institución de Banca de Desarrollo (BANSEFI) , todas a nombre de PRODUCCION ECOTURISTICA COLOTEPEC SC. DE R.S. DE C.V , o bien en el domicilio de LA ACREDITANTE ubicado en: EN CALLE PRINCIPAL SIN NÚMERO, BARRA DE NAVIDAD, SANTA MARÍA COLOTEPEC, POCHUTLA, OAXACA, CÓDIGO POSTAL 70934.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('En virtud de la solidaridad acordada entre los ACREDITADOS, los pagos que realice cada uno de ellos, por las cantidades que individualmente les corresponden, no los libera de la obligación de pago señalada en el párrafo anterior. Por lo que en el supuesto de que la totalidad del monto adeudado establecido en el párrafo que antecede no sea liquidada en los términos establecidos, la totalidad del saldo no pagado del Crédito se dará por vencido de conformidad con lo establecido en el siguiente párrafo.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('Cada uno de LOS ACREDITADOS se obliga a suscribir, en favor de LA ACREDITANTE un pagaré por el monto efectivamente dispuesto individualmente del Crédito, mismo que incluirá una tabla de amortizaciones individual que señalará los montos y las fechas de vencimiento de cada uno de los pagos parciales que les correspondan, el cual le será devuelto una vez que LA ACREDITANTE reciba el pago del total de los montos adeudados en virtud del presente Contrato. En caso de no hacerse el pago puntual de alguna exhibición parcial, se generará el vencimiento anticipado de los pagos pendientes más el pago de los intereses moratorios, gastos de cobranza y/o comisiones, que en su caso se generen, hasta en tanto se realice el pago total del Crédito. En el pagaré que suscriba cada ACREDITADO se constituirán como avales todos LOS ACREDITADOS del GRUPO, esto es, sin perjuicio de la obligación solidaria contraída en el presente Contrato, por el monto total del Crédito y el debido cumplimiento de la obligación de pago de cada uno de LOS ACREDITADOS.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('LOS ACREDITADOS entienden y aceptan que en caso de vencimiento anticipado del presente Contrato por la falta de uno o más pagos conforme a lo dispuesto en el presente Contrato, quedará a elección de LA ACREDITANTE demandar a LOS ACREDITADOS por la vía Ejecutiva Mercantil, o en su caso por la vía Ordinaria Mercantil. En caso de que la fecha en que deba realizarse el pago correspondiente sea un día inhábil LOS ACREDITADOS deberán efectuar el pago correspondiente el día hábil inmediato siguiente. Para los efectos de esta cláusula, un día hábil significa un día en el que los bancos del Distrito Federal (Instituciones de Crédito) se encuentren abiertos al público en general para la realización de operaciones bancarias normales, y los días en que LA ACREDITANTE se encuentre autorizada para realizar operaciones con el público en general.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('LOS ACREDITADOS convienen en pagar la totalidad de los gastos, derechos e impuestos en vigor, así como los que en el futuro pudieran establecerse por cualquier autoridad, respecto a la ejecución y cumplimiento del presente Contrato, por lo que desde ahora se conviene en que LA ACREDITANTE no deberá efectuar erogación alguna por ninguno de los conceptos señalados. Si por cualquier causa LA ACREDITANTE pagara alguna cantidad derivada de lo estipulado en esta cláusula, LOS ACREDITADOS deberán reintegrársela en cuanto se los solicite LA ACREDITANTE. En el caso de que los mencionados gastos, derechos o impuestos, sufran algún aumento en sus respectivos importes, LOS ACREDITADOS se obligan a depositar de inmediato ante LA ACREDITANTE la diferencia respectiva.'), 0, 'J', false);


$pdf->Ln(2);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(185,3,utf8_decode('SEXTA. VIGENCIA DEL CONTRATO.'), 0, 'J', false);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(185,3,utf8_decode('La vigencia del presente contrato será la definida por el plazo para el pago del crédito, pero no cesaran sus efectos en tanto el crédito o cualquier cantidad adeudada permanezcan insoluta. No obstante lo anterior, cualquiera de las partes podrá manifestar a la otra su voluntad de darlo por terminado en forma anticipada en términos de la cláusula décima primera.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('LA ACREDITANTE se reserva el derecho denunciar el presente Contrato, mediante simple comunicación escrita dirigida a LOS ACREDITADOS, en este supuesto de que LA ACREDITANTE denuncie el crédito, se tendrá por vencido anticipadamente el plazo pactado del Crédito, por lo que LOS ACREDITADOS deberán restituir de inmediato a LA ACREDITANTE el importe total de la suma que hayan dispuesto y cualquier otra cantidad adeudada derivada de este Contrato.'), 0, 'J', false);


$pdf->Ln(2);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(185,3,utf8_decode('SÉPTIMA. ESTADO DE CUENTA.'), 0, 'J', false);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(185,3,utf8_decode('Mediante el presente Contrato, LOS ACREDITADOS instruyen expresamente a LA ACREDITANTE para que ésta expida el estado de cuenta de LOS ACREDITADOS solamente al momento en que éstos se los soliciten en las oficinas en las que se otorgó el Crédito.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('De tal forma, LOS ACREDITADOS podrán solicitar la consulta de saldos, transacciones, movimientos y su estado de cuenta, en las oficinas de LA ACREDITANTE dentro de los horarios de atención al público.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('En el estado de cuenta correspondiente se indicarán, entre otros aspectos: las cantidades cargadas y abonadas, con sus respectivas fechas, así como los datos necesarios para realizar el cálculo de los intereses a pagar, así como cualquier otro movimiento.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('LOS ACREDITADOS podrán objetar en las sucursales de LA ACREDITANTE el estado de cuenta dentro de los 30 (treinta) días naturales contados a partir de la fecha en que el estado de cuenta quedó a su disposición, una vez que lo requirió en la sucursal.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('El estado de cuenta certificado por el contador público autorizado para tal efecto por LA ACREDITANTE hará fe, salvo prueba en contrario, en el juicio respectivo para la fijación del saldo resultante a cargo de LOS ACREDITADOS.'), 0, 'J', false);


$pdf->Ln(2);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(185,3,utf8_decode('OCTAVA. SUPLENCIA EN CASO DE NO SABER FIRMAR.'), 0, 'J', false);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(185,3,utf8_decode('En caso de que EL ACREDITADO o EL(LOS) OBLIGADO(S) SOLIDARIO(S) no sepan leer y/o escribir, deberá firmar otra persona a su ruego este Contrato y los pagarés que se derivan de la disposición del Crédito, agregando su nombre y asentando junto a su firma la leyenda "a ruego de" y el nombre de EL ACREDITADO y /o EL (LOS) OBLIGADO(S) SOLIDARIO(S), que no sepa(n) leer y/o escribir deberá(n) imprimir su huella digital. En ese caso EL ACREDITADO acepta y acuerda que la firma hecha por encargo y la impresión de la huella digital de EL ACREDITADO o EL (LOS) OBLIGADO(S) SOLIDARIO(S) surtirá los mismos efectos legales que si éste hubiera estampado su firma personalmente, y por lo tanto, quien firme a ruego asume la responsabilidad de enterar y explicar a EL ACREDITADO o EL (LOS) OBLIGADO(S) SOLIDARIO(S) que no sepa(n) leer y/o escribir respecto de todos sus derechos y obligaciones bajo este Contrato.'), 0, 'J', false);


$pdf->Ln(2);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(185,3,utf8_decode('NOVENA. COMPROBANTE DE DEPÓSITO Y PAGOS ANTICIPADOS.'), 0, 'J', false);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(185,3,utf8_decode('El comprobante de depósito realizado a las cuentas bancarias mencionadas en la cláusula quinta del presente contrato, servirán para acreditar el cumplimiento de las obligaciones de LOS ACREDITADOS respecto a cada uno de los pagos parciales.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('En caso de que LOS ACREDITADOS quisieran realizar anticipadamente el pago del importe total del Crédito, lo podrán hacer sin penalización alguna.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('LOS ACREDITADOS, podrán efectuar en cualquier tiempo, pagos anticipados y serán aplicados a cubrir el ó lo (s) vencimiento (s) inmediato (s) siguiente (s) de acuerdo con lo previsto en la cláusula décima tercera.'), 0, 'J', false);

//$pdf->AddPage();

$pdf->Ln(2);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(185,3,utf8_decode('DÉCIMA. OBLIGACIONES DEL GRUPO Y LOS ACREDITADOS.'), 0, 'J', false);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(185,3,utf8_decode('en su calidad de integrantes del GRUPO se obligan a que el GRUPO cumpla los siguientes lineamientos:
1. El GRUPO deberá sesionar de manera Semanal o Catorcenal.
2. Mientras no se designen las obligaciones del Tesorero del GRUPO en el reglamento interno que los integrantes del grupo deberán realizar y presentar a LA ACREDITANTE, El Presidente del GRUPO tendrá la obligación de controlar y recabar los pagos de todos LOS ACREDITADOS, mismos que deberá registrar y, depositar como pago por cuenta de éstos a LA ACREDITANTE conforme a lo dispuesto en la cláusula quinta del presente Contrato. En caso de que alguno de LOS ACREDITADOS se atrase, los demás ACREDITADOS deberán cubrir dicho faltante a efecto de realizar el pago correspondiente a LA ACREDITANTE en los términos pactados.
3. El Presidente del GRUPO deberá hacer entrega de la ficha de depósito al representante de LA ACREDITANTE y mostrar dicho comprobante al GRUPO en la siguiente reunión, en el entendido que dicho representante tiene prohibido recibir dinero en efectivo y tan solo puede recibir el comprobante respectivo de pago.
4. Los ACREDITADOS se obligan a proporcionar en cualquier momento, durante la vigencia del Crédito, la información que les sea requerida por LA ACREDITANTE.
5.- Cumplir con todas y cada una de las obligaciones contraídas en el presente contrato.
'), 0, 'J', false);


$pdf->Ln(2);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(185,3,utf8_decode('DÉCIMA PRIMERA. CAUSAS DE VENCIMIENTO ANTICIPADO.'), 0, 'J', false);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(185,3,utf8_decode('LA ACREDITANTE se reserva la facultad de dar por vencido anticipadamente el presente Contrato y exigir el pago de la totalidad del Crédito y sus intereses, sin necesidad de requisito o trámite previo alguno, cuando LOS ACREDITADOS incumplan cualquiera de las obligaciones contraídas en este Contrato, adicionalmente de los casos previstos en la legislación aplicable, así como cualquiera de los siguientes supuestos:
1. Cualquiera de los acreditados deje de pagar puntualmente cualquiera de las cantidades del Crédito o sus accesorios de conformidad con lo previsto en el presente Contrato.
2. Cualquiera de LOS ACREDITADOS contrate adeudos, o realice venta, enajenación o donación de sus bienes muebles o inmuebles que lo coloquen en estado de insolvencia después del otorgamiento del Crédito, sin el consentimiento previo y por escrito de LA ACREDITANTE.
3. Cualquiera de LOS ACREDITADOS haya proporcionado información falsa para el otorgamiento del Crédito.
4. El GRUPO deje de sesionar periódicamente en las fechas establecidas por LOS ACREDITADOS, o como resultado de un caso fortuito o de fuerza mayor.
5. En caso de que se incumpla con cualquiera de las obligaciones contenidas en el presente instrumento.
6. Cuando LOS ACREDITADOS dejen de invertir parcial o totalmente el importe del Crédito en los conceptos para los cuales fue solicitado el financiamiento.
7. Cuando LOS ACREDITADOS no efectúen totalmente las inversiones correspondientes.
8. Si LOS ACREDITADOS, son emplazados a huelga, demandados, o sus bienes embargados, son concursados o declarados en quiebra, intervenidos en sus negocios o caja por terceros o autoridades cualquiera que sea su naturaleza, o se vea afectado en sus negocios, oficinas, fábricas o cualquier domicilio en que se encuentren sus establecimientos u oficinas, tiendas o sucursales;
9. Por cualquier otra causa que se establezca en las reglas de operación de LA ACREDITANTE, sus estatutos o en disposición legal aplicable.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('No obstante el vencimiento anticipado, el presente contrato seguirá produciendo los efectos legales correspondientes entre las partes, hasta que LOS ACREDITADOS hayan cumplido con todas y cada una de sus obligaciones contraídas al amparo del mismo, en la forma y términos pactados.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('El vencimiento anticipado tendrá como consecuencia, hacer exigible el pago inmediato del capital no pagado y los intereses ordinarios y moratorios, gastos de cobranza y/o comisiones y demás accesorios, que en su caso se hayan generado, a cargo de LOS ACREDITADOS.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('LOS ACREDITADOS podrán solicitar, en todo momento, la terminación anticipada o cancelación del presente Contrato, bastando para ello la presentación de una solicitud en cualquier sucursal de LA ACREDITANTE, debiendo cubrir, en su caso y en los términos pactados en el mismo, el monto total del adeudo, incluyendo todos los accesorios financieros que se hubieren generado a la fecha en que se solicite la terminación.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('En caso de que LOS ACREDITADOS soliciten la terminación anticipada del presente Contrato y no tengan adeudos pendientes a dicha fecha, LA ACREDITANTE dará por terminado el mismo el día hábil siguiente a la fecha en que fue recibida la solicitud de terminación correspondiente. En caso de que existan adeudos pendientes al momento de recibir la solicitud de terminación anticipada, LA ACREDITANTE, a más tardar el día hábil siguiente a la fecha de recepción de la solicitud de terminación, comunicará a LOS ACREDITADOS el importe de los adeudos pendientes y dentro de los 15 (quince) días hábiles siguientes contados a partir de la fecha de recepción de la solicitud de terminación pondrá a su disposición dicho dato, en la sucursal elegida por LOS ACREDITADOS y una vez liquidados los adeudos se dará por terminado el Contrato.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('LA ACREDITANTE entregará, en su caso, el saldo, en la fecha en que se dé por terminado la operación. LA ACREDITANTE pondrá a disposición de LOS ACREDITADOS, dentro de 15 (quince) días hábiles contados a partir de la fecha en que se hubiera realizado el pago de los adeudos, el estado de cuenta en el que conste el fin de la relación contractual y la inexistencia de adeudos derivados exclusivamente de dicha relación.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('LOS ACREDITADOS podrán solicitar conjuntamente por escrito la terminación del presente Contrato, por conducto de otra Entidad Financiera, la cual deberá abrir una cuenta a nombre del Grupo y remitir los documentos originales a LA ACREDITANTE, en los que conste la manifestación de la voluntad de dar por terminada la relación contractual con LA ACREDITANTE. La Entidad Financiera liquidará el adeudo de LOS ACREDITADOS convirtiéndose en acreedora del mismo por el importe correspondiente, y llevará a cabo los trámites respectivos, bajo su responsabilidad y sin cobro de comisión alguna por tales gestiones.'), 0, 'J', false);



$pdf->Ln(2);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(185,3,utf8_decode('DÉCIMA SEGUNDA. OTRAS OBLIGACIONES DE LOS ACREDITADOS.'), 0, 'J', false);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(185,3,utf8_decode('Además de las obligaciones contenidas en el presente instrumento, durante la vigencia del presente Contrato, LOS ACREDITADOS deberán:
1. Dar aviso por escrito de su cambio de domicilio, notificando dicha circunstancia al Presidente del Grupo y a LA ACREDITANTE con por lo menos 30 (treinta) días naturales de anterioridad a la fecha en que el cambio de domicilio suceda.
2. Informar a LA ACREDITANTE de cualquier situación que pueda causar el vencimiento anticipado del Contrato.
3. Permitir el acceso a sus domicilios, propiedades y negocios al personal de LA ACREDITANTE y/o aquellas personas que LA ACREDITANTE determine, representantes de la Institución u Organismo que haya intervenido en el financiamiento. Así como proporcionar los documentos y /o información que le soliciten en relación al Crédito que LA ACREDITANTE le haya otorgado.
4. Manejar racionalmente los recursos naturales y preservar el medio ambiente, acatando las medidas y acciones dictadas por las autoridades competentes.
5. LOS ACREDITADOS deberán informar oportunamente a LA ACREDITANTE cualquier acto o hecho que pueda afectar la recuperación del financiamiento.
6. En su caso, cuando sea aplicable y de acuerdo a las políticas vigentes de LA ACREDITANTE, LOS ACREDITADOS deberán contratar la cobertura para la administración del riesgo.'), 0, 'J', false);


$pdf->Ln(2);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(185,3,utf8_decode('DÉCIMA TERCERA. APLICACION Y DISTRIBUCION DE PAGOS.'), 0, 'J', false);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(185,3,utf8_decode('El orden de prelación en la aplicación del pago de cantidades adeudadas hechas por LOS ACREDITADOS será el siguiente:
a) Impuesto al Valor Agregado sobre intereses moratorios, si se causa;
b) Intereses moratorios, si se causan;
c) Impuesto al Valor Agregado sobre otros gastos, entre los que se incluyen gastos de cobranza y comisiones, si se causan;
d) Otros gastos derivados del presente Contrato, entre los que se incluyen gastos de cobranza y comisiones, si se causan;
e) Impuesto al Valor Agregado sobre intereses ordinarios, si se causa
f) Intereses ordinarios;
g) Capital vencido; y
h) Capital vigente.'), 0, 'J', false);



$pdf->Ln(2);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(185,3,utf8_decode('DÉCIMA CUARTA. CESIÓN DE DERECHOS DEL CONTRATO.'), 0, 'J', false);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(185,3,utf8_decode('LOS ACREDITADOS autorizan expresamente a LA ACREDITANTE para transmitir, endosar, ceder, descontar o en cualquier otra forma negociar parcial o totalmente el presente Contrato y los pagarés que se deriven del mismo, aún antes de su vencimiento, manifestando también LOS ACREDITADOS su voluntad de reconocer a las personas a las que se les transmitan los derechos antes mencionados, los mismos derechos que corresponden a LA ACREDITANTE al amparo del presente instrumento.'), 0, 'J', false);


$pdf->Ln(2);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(185,3,utf8_decode('DÉCIMA QUINTA. OBLIGACIONES EN CASO DE FALLECIMIENTO DEL ACREDITADO.'), 0, 'J', false);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(185,3,utf8_decode('En caso de fallecimiento de alguno de LOS ACREDITADOS, LOS ACREDITADOS se obligan desde este momento a cubrir de manera solidaria el adeudo correspondiente del fallecido, subsistiendo en todo momento las obligaciones generadas por todos y cada uno de LOS ACREDITADOS en el presente acuerdo de voluntades, así como de los documentos suscritos en garantía y relacionados en la cláusula quinta de este Contrato. La protección señalada en la presente cláusula no es ni podrá considerarse como un seguro, en términos de lo dispuesto por la Ley sobre el Contrato de Seguro.'), 0, 'J', false);


$pdf->Ln(2);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(185,3,utf8_decode('DÉCIMA SEXTA. MODIFICACIONES AL CONTRATO.'), 0, 'J', false);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(185,3,utf8_decode('LA ACREDITANTE deberá notificar a LOS ACREDITADOS las modificaciones que se pretendan hacer a este Contrato o a cualquiera de sus anexos, con al menos 30 (treinta) días naturales de anticipación a la fecha de entrada en vigor de dichas modificaciones. LOS ACREDITADOS instruyen expresamente a LA ACREDITANTE para que cualquier modificación que se pretenda llevar a cabo al presente Contrato o a sus anexos, se les notifique mediante la entrega de un aviso por escrito en el domicilio del Presidente del Grupo identificado en la declaración III, inciso e) del presente Contrato, dándose por notificados todos LOS ACREDITADOS. En este acto el Presidente del Grupo, una vez que reciba la notificación de parte de LA ACREDITADA, se obliga a notificar a los demás ACREDITADOS, con la finalidad de que tengan conocimiento de las modificaciones que se pretendan llevar a cabo al Contrato, liberando a LA ACREDITANTE de cualquier reclamación o responsabilidad derivada de su falta o retraso en la notificación señalada.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('En caso de que LOS ACREDITADOS no estén de acuerdo con las modificaciones propuestas, podrán solicitar la terminación del Contrato dentro de los 15 (quince) días naturales posteriores al aviso señalado en el párrafo anterior, sin responsabilidad ni comisión alguna a su cargo; debiendo LOS ACREDITADOS cubrir el monto del Crédito, así como los adeudos que se hubieren generado a la fecha en que soliciten dar por terminado el Contrato.
Una vez transcurrido el plazo señalado en el párrafo que antecede, sin que LA ACREDITANTE haya recibido comunicación alguna por parte de LOS ACREDITADOS, se tendrán por aceptadas las modificaciones del Contrato. Asimismo, LA ACREDITANTE deberá notificar a LOS ACREDITADOS con por lo menos 15 (quince) días naturales de anticipación, los incrementos en cualquiera de las comisiones que, en su caso LA ACREDITANTE cobre en virtud de la contratación del Crédito, así como, las nuevas comisiones que se pretendan cobrar. Dicha notificación se llevará en los mismos términos señalados en el primer párrafo de la presente cláusula, así como, el Presidente del Grupo tendrá la obligación de notificar a los demás ACREDITADOS en los mismos términos de lo señalado en el primer párrafo de esta cláusula.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('LOS ACREDITADOS tendrán derecho de dar por terminado el presente Contrato, en caso de no estar de acuerdo con los nuevos montos de las comisiones o con la nueva comisión que se pretenda cobrar. En este caso LA ACREDITANTE no le cobrará cantidad adicional por este hecho, con excepción de los adeudos que ya se hubieren generado a la fecha en que LOS ACREDITADOS soliciten dar por terminado el presente Contrato.'), 0, 'J', false);


$pdf->Ln(2);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(185,3,utf8_decode('DÉCIMA SÉPTIMA. EJECUTIVIDAD DEL CONTRATO.'), 0, 'J', false);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(185,3,utf8_decode('Convienen las partes que el presente Contrato junto con el estado de cuenta certificado por el contador de LA ACREDITANTE, hará fe, salvo prueba en contrario, en el juicio respectivo para la aplicación del saldo resultante a cargo de LOS ACREDITADOS y en consecuencia será título ejecutivo mercantil, sin necesidad de reconocimiento de firma y ni de otro requisito en términos de la legislación aplicable.'), 0, 'J', false);


$pdf->Ln(2);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(185,3,utf8_decode('DÉCIMA OCTAVA. DOMICILIOS PARA OIR Y RECIBIR NOTIFICACIONES.'), 0, 'J', false);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(185,3,utf8_decode('Para efectos del presente Contrato, cada una de las partes señala como su domicilio convencional para recibir toda clase de notificaciones relacionadas con el presente Contrato, los manifestados en el capítulo de declaraciones del presente Contrato. Cualquier aviso, comunicación o entrega de documentación requerida conforme al presente Contrato deberá hacerse por escrito y deberá entregarse personalmente o a través de cualquier tipo de mensajería que permita acuse de recibo, porte pagado, en el domicilio del Presidente del Grupo. Los avisos se consideran realizados cuando sean recibidos por el Presidente del Grupo hasta en tanto las partes no notifiquen por escrito un cambio de domicilio, los avisos, notificaciones y demás diligencias judiciales y extrajudiciales que se hagan en los domicilios indicados surtirán plenamente sus efectos.'), 0, 'J', false);


$pdf->Ln(2);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(185,3,utf8_decode('DÉCIMA NOVENA. SUSTITUCIÓN Y REVOCACION DE ACUERDOS PREVIOS.'), 0, 'J', false);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(185,3,utf8_decode('El presente Contrato y sus anexos, constituyen el acuerdo total entre las partes, en consecuencia sustituyen y revocan todos los acuerdos previos, verbales o escritos, que se opongan de cualquier manera al mismo.'), 0, 'J', false);


$pdf->Ln(2);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(185,3,utf8_decode('VIGÉSIMA. PUBLICIDAD.'), 0, 'J', false);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(185,3,utf8_decode('Mediante la firma del presente Contrato, LOS ACREDITADOS autorizan expresamente a LA ACREDITANTE para contactarlos directamente o por vía telefónica en su lugar de trabajo, en un horario de las 9:00 horas a las 19:00 horas, o bien, para que le envíe
a su domicilio o lugar de trabajo publicidad relativa a productos o servicios que LA ACREDITANTE ofrece al público en general; así mismo, autoriza a LA ACREDITANTE para que utilice sus datos personales para fines publicitarios o de mercadotecnia.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(185,3,utf8_decode('VIGÉSIMA PRIMERA. JURISDICCIÓN Y COMPETENCIA.'), 0, 'J', false);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(185,3,utf8_decode('Para la interpretación o cumplimiento del presente Contrato, las partes se someten expresamente a la jurisdicción de los tribunales de la Ciudad de Puerto Escondido, Oaxaca renunciando desde este momento, a cualquier fuero que en razón de sus domicilios presentes o futuros pudiera corresponderles.'), 0, 'J', false);


$pdf->Ln(2);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(185,3,utf8_decode('VIGÉSIMA SEGUNDA. CONSULTAS, ACLARACIONES E INCONFORMIDADES.'), 0, 'J', false);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(185,3,utf8_decode('Servicio de atención al público en consultas y aclaraciones. Para cualquier solicitud, consulta y aclaración relacionadas con el Crédito contratado, LOS ACREDITADOS podrán solicitar el apoyo del Gerente de sucursal o del personal a su cargo en la sucursal en la que LOS ACREDITADOS hayan recibido su Crédito.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('En el supuesto de que LOS ACREDITADOS no estén de acuerdo con alguno de los movimientos que aparezcan en el estado de cuenta, podrán presentar una solicitud de aclaración dentro del plazo de 30 (treinta) días naturales contados a partir de la fecha en que el estado de cuenta quedó a su disposición o, en su caso, de la realización de la operación. La solicitud respectiva deberá presentarse, por escrito, ante el Gerente de la Cooperativa. LA ACREDITANTE estará obligada a acusar recibo de dicha solicitud.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('LOS ACREDITADOS deberán realizar el pago bajo protesta de cuya aclaración solicita, así como el de cualquier otra cantidad relacionada con dicho pago, hasta en tanto se resuelva la aclaración conforme al procedimiento que se señala a continuación.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('Una vez que LA ACREDITANTE reciba la solicitud de aclaración, tendrá un plazo máximo de 30 (treinta) días naturales contados a partir de la recepción de la solicitud, para entregar a LOS ACREDITADOS el dictamen correspondiente, así como un informe detallado en el que se respondan todos los hechos contenidos en la solicitud presentada por LOS ACREDITADOS. LA ACREDITANTE formulará el dictamen e informe antes referidos por escrito. Si resultare un saldo a favor de LOS ACREDITADOS, este será abonado al siguiente pago que deban realizar, si ya no existieren más pagos por realizar, dicha cantidad se les devolverá.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('Dentro del plazo de 10 (diez) días naturales contados a partir de la entrega del dictamen, LA ACREDITANTE estará obligada a poner a disposición de LOS ACREDITADOS en la sucursal en la que radica la cuenta, el expediente generado con motivo de la solicitud.'), 0, 'J', false);


$pdf->Ln(2);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(185,3,utf8_decode('VIGÉSIMA TERCERA. PROTECCIÓN DE DATOS PERSONALES.'), 0, 'J', false);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(185,3,utf8_decode('Conforme a la Ley Federal de Protección de Datos Personales en Posesión de los Particulares, LA ACREDITANTE, previamente a la celebración del presente contrato, solicitó datos personales de LOS ACREDITADOS con la finalidad de identificarlos y poder celebrar el presente contrato de crédito, informarles sobre el estatus del mismo, ceder o vender el mismo, realizar requerimientos de pago, así como para ofrecerles los diferentes productos y/o servicios que LA ACREDITANTE tiene a su disposición. LA ACREDITANTE protegerá y mantendrá los datos personales de LOS ACREDITADOS por el tiempo razonablemente necesario, tomando en cuenta las disposiciones legales aplicables y sólo compartirá y/o transferirá dicha información con otra(s) entidad(es),
cuando LOS ACREDITADOS contraten otro producto y/o servicio a través de LA ACREDITANTE, o para la cesión y/o venta del presente contrato, o bien, cuando así se requiera por disposición legal.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('LOS ACREDITADOS podrá ejercer en todo momento ante LA ACREDITANTE, sus derechos de acceso, rectificación, cancelación en oposición en el tratamiento de sus datos personales, en caso de que legalmente sea procedente, conforme a los lineamientos y requisitos que marca la Ley Federal de Protección de Datos Personales en Posesión de los Particulares, presentándose en la sucursal que le corresponda contactando a su Asesor de Crédito o al personal que pudiera apoyar dicho requerimiento.'), 0, 'J', false);


$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('Por último señala LA ACREDITANTE que el Aviso de Privacidad y cualquier cambio y/o modificación total o parcial del mismo puede ser consultado directamente en el domicilio de LA ACREDITANTE.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('LEÍDO Y COMPRENDIDO EL PRESENTE CONTRATO, ENTERADAS LAS PARTES QUE INTERVIENEN DE SU CONTENIDO, ALCANCES, CONSECUENCIAS LEGALES Y ECONÓMICAS, LO FIRMAN DE CONFORMIDAD A LOS ') .$fecha_credito. utf8_decode(', EN CALLE PRINCIPAL SN BARRA DE NAVIDAD , Y EN ESTE ACTO SE HACE ENTREGA AL PRESIDENTE DEL GRUPO, DE UN DUPLICADO DE ESTE CONTRATO, DE ESTE INSTRUMENTO Y SUS RESPECTIVOS ANEXOS.'), 0, 'J', false);


$pdf->AddPage();

$pdf->SetFont('Arial','B',8);
$pdf->Cell(185,10,'EL ACREDITANTE:',0,0,'C');
$pdf->Ln(10);
$pdf->Cell(185,10,utf8_decode('PRODUCCION ECOTURISTICA COLOTEPEC SC. DE R.S. DE C.V'),0,0,'C');
$pdf->Ln(25);
$pdf->Line(75, 45, 130, 45);
$pdf->Cell(185,10,utf8_decode('C.ANGELICA CRUZ RAMOS'),0,0,'C');
$pdf->Ln(5);
$pdf->Cell(185,10,utf8_decode('REPRESENTANTE LEGAL'),0,0,'C');

$pdf->Ln(15);
$pdf->Cell(185,10,utf8_decode('"LOS ACRÉDITADOS Y OBLIGADOS SOLIDARIOS ENTRE SI"'),0,0,'C');
$pdf->Ln(20);


for ($i = 0; $i < $m; $i++) {
    $pdf->Line(50, 91 + $i*28, 80, 91 + $i*28);
    $pdf->Cell(15);
    $pdf->Cell(185, 10, "Firma: ", 0, 0, 'L');
    $pdf->Ln(4);
    $pdf->Cell(15);
    $pdf->Cell(150, 10, "Nombre: " .  utf8_decode( mb_strtoupper($data1[$i]["nombre"])), 0, 0, 'L');
    $pdf->Ln(7);
    $pdf->Cell(15);
    $pdf->MultiCell(160, 3, "Domicilio: " .  utf8_decode( mb_strtoupper($data1[$i]["domicilio"])), 0, 'J', false);
    $pdf->Ln(20);
}






$pdf->Output();
?>