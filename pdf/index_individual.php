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

// Clientes

$oconns = new database();
$idkey_credito = $_GET["idkey_credito"];
$datos = $oconns->getRows("select nombre, ocupacion, domicilio, nombre_identificacion, no_identificacion, monto, tasa_interes, numero_pagos, DATE_FORMAT(fecha_desembolso,'%d-%m-%Y %H:%i:%s') as fecha_desembolso from view_contrato_individual where idkey_cliente=".$_GET["idkey_cliente"]." and idkey_credito='".$idkey_credito."';");
$n = $oconns->numberRows;

$datos2 = $oconns->getRows("select * from amortizaciones where idkey_creditos=".$idkey_credito." limit 1;");

$m = $oconns->numberRows;

if($n>0 && $m>0){
    $str_cliente = mb_strtoupper($datos[0]["nombre"]);
    $Str_puesto = mb_strtoupper($datos[0]["ocupacion"]);
    $str_domicilio = mb_strtoupper($datos[0]["domicilio"]);
    $str_identificacion = mb_strtoupper($datos[0]["nombre_identificacion"])." CON NUMERO ".$datos[0]["no_identificacion"];
    $cantidad = $datos[0]["monto"];
    $tasa_interes = $datos[0]["tasa_interes"];
    $plazo = $datos[0]["numero_pagos"];

    $resultado = convertir(strval($cantidad));
    $fecha_credito = $datos[0]["fecha_desembolso"];
    $mi_fecha = fechaCastellano($fecha_credito);

    $pagos = $datos2[0]["total"];
}
else{
  echo "<script> alert('El perfil de este cliente está incompleto. Favor de verificar!'); </script>";
  exit;
}

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
$pdf->Cell(130,10,utf8_decode('PRODUCCIÓN ECOTURÍSTICA COLOTEPEC SC. DE R.S. DE C.V'),0,0,'C');
$pdf->Ln(10);
$pdf->Cell(40);

$pdf->Cell(130,10,utf8_decode('CONTRATO DE OTORGAMIENTO DE CRÉDITO'),0,0,'C');
$pdf->Ln(15);

$pdf->MultiCell(185, 4, utf8_decode('CONTRATO DE CRÉDITO QUE CELEBRAN POR UNA PARTE PRODUCCIÓN ECOTURÍSTICA COLOTEPEC SC. DE R.S. DE C.V COMO ACREDITANTE, A QUIEN EN LO SUCESIVO PARA LOS EFECTOS DEL PRESENTE CONTRATO SE LE DENOMINARÁ LA "ACREDITANTE", REPRESENTADA EN ESTE ACTO POR EL C. ANGELICA CRUZ RAMOS ,Y COMO ACREDITADO EL (LA) '.$str_cliente.' A QUIEN EN LO SUCESIVO PARA EFECTOS DEL PRESENTE CONTRATO SE DENOMINARA EL "ACREDITADO",Y A EL/LOS C. ,A QUIEN(ES) EN LO SUCESIVO PARA LOS MISMO EFECTOS SE DENOMINARÁ(N) COMO EL OBLIGADO (S) SOLIDARIO (S), AL TENOR DE LAS SIGUIENTES DECLARACIONES Y CLÁUSULAS'));

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
$pdf->Cell(185,5,'II.-DECLARA EL ACREDITADO POR SU PROPIO DERECHO:',0,0,'L');
$pdf->Ln(7);

$pdf->SetFont('Arial','',8);
$pdf->MultiCell(185,3,utf8_decode('a) EL (LA) SEÑOR(A) ' .$str_cliente . utf8_decode(', SER MEXICANO(A), MAYOR DE EDAD, DE ESTADO CIVIL SOLTERO(A) , DEDICADO(A) ') . $Str_puesto . utf8_decode(', TIENE SU DOMICILIO PARTICULAR EN ') . $str_domicilio . ', IDENTIFICÁNDOSE CON ' . $str_identificacion .  utf8_decode(', LA CUAL SE ANEXA EN COPIA SIMPLE A ESTE CONTRATO.')),0,'J',false);

$pdf->Ln(2);
$pdf->MultiCell(185, 3, utf8_decode('b) QUE HA SOLICITADO DE MANERA INDIVIDUAL A LA ACREDITANTE EL OTORGAMIENTO DE UN CRÉDITO.'), 0, 'J', false);

$pdf->Ln(7);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(185,5,'III.- DECLARA EL/LOS OBLIGADO(S) SOLIDARIO(S) POR SU PROPIO DERECHO:',0,0,'L');

$pdf->Ln(7);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(185, 3, utf8_decode('b) QUE ES SU LIBRE DESEO, CONSTITUIRSE FRENTE A LA ACREDITANTE, COMO OBLIGADO(S) SOLIDARIO(S) DE EL ACREDITADO, RESPECTO DE LAS OBLIGACIONES PERSONALES ASUMIDAS POR ESTE, MEDIANTE EL PRESENTE CONTRATO. ASIMISMO, FIRMARÁ(N) COMO AVALE(S), DEL ACREDITADO, LOS PAGARÉS QUE DOCUMENTEN LAS DISPOSICIONES DE ESTE CRÉDITO.'), 0, 'J', false);

$pdf->Ln(7);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(185,5,'IV.- DECLARAN CONJUNTAMENTE EL ACREDITADO Y EL/LOS OBLIGADO(S) SOLIDARIO(S) POR SU PROPIO DERECHO:',0,0,'L');

$pdf->Ln(7);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(185, 3, utf8_decode('A) TENER LA CAPACIDAD JURÍDICA Y ECONÓMICA SUFICIENTE, ASÍ COMO LA SOLVENCIA MORAL PARA ASUMIR LAS OBLIGACIONES MATERIA DE ESTE CONTRATO Y CUMPLIRLAS EN LOS TÉRMINOS QUE MÁS ADELANTE SE PRECISAN.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185, 3, utf8_decode('B) QUE CON ANTERIORIDAD A LA FECHA DE FIRMA DEL PRESENTE CONTRATO, LA ACREDITANTE, LES HA INFORMADO Y EXPLICADO A CADA ACREDITADO, EL CONTENIDO DE CADA UNA DE LAS CLÁUSULAS QUE LO INTEGRAN, TALES COMO EL MONTO DE LOS PAGOS PARCIALES, LA FORMA Y PERIODICIDAD PARA LIQUIDARLOS, CARGAS FINANCIERAS, ACCESORIOS, EL DERECHO QUE TIENE A LIQUIDAR ANTICIPADAMENTE LA OPERACIÓN Y LAS CONDICIONES PARA ELLO, LOS INTERESES ORDINARIOS Y MORATORIOS, EN SU CASO, LA FORMA DE CALCULAR LOS MISMOS, GASTOS DE COBRANZA Y/O COMISIONES, Y DEMÁS GASTOS QUE SE ORIGINEN POR EL OTORGAMIENTO, ENTREGA, PAGO, COBRO Y/O RECUPERACIÓN DEL CRÉDITO Y SUS ACCESORIOS.'), 0, 'J', false);


// New page
//$pdf->AddPage();

$pdf->MultiCell(185, 3, utf8_decode('C) QUE CON ANTERIORIDAD A LA FIRMA DEL PRESENTE CONTRATO, HAN SUSCRITO EL FORMATO DE AUTORIZACIÓN PARA SOLICITAR REPORTES DE CRÉDITO DE PERSONAS FÍSICAS, ANTE LAS SOCIEDADES DE INFORMACIÓN CREDITICIA QUE ESTIME CONVENIENTE LA ACREDITANTE.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185, 3,utf8_decode('D) QUE LOS RECURSOS CON LOS CUALES HA DE PAGAR LOS SERVICIOS O PRODUCTOS RECIBIDOS, ASÍ COMO LAS OBLIGACIONES CONTRAÍDAS, HAN SIDO O SERÁN OBTENIDOS O GENERADOS A TRAVÉS DE UNA FUENTE DE ORIGEN LÍCITO. ASÍ MISMO QUE EL DESTINO DE LOS RECURSOS OBTENIDOS AL AMPARO DEL PRESENTE CONTRATO DE CRÉDITO SERÁ TAN SOLO PARA FINES PERMITIDOS POR LA LEY, Y QUE NO SE ENCUENTRAN DENTRO DE LOS SUPUESTOS ESTABLECIDOS EN LOS ARTÍCULOS 139 Y 148 BIS Y 400 BIS DEL CÓDIGO PENAL FEDERAL.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('E) QUE SE LES INFORMÓ SOBRE EL COSTO ANUAL TOTAL ("CAT") DEL CRÉDITO QUE SE CONTRATA EN TÉRMINOS DEL PRESENTE CONTRATO. "CAT: EL COSTO ANUAL TOTAL DE FINANCIAMIENTO EXPRESADO EN TÉRMINOS PORCENTUALES ANUALES QUE, PARA FINES INFORMATIVOS Y DE COMPARACIÓN, INCORPORA LA TOTALIDAD DE LOS COSTOS Y GASTOS INHERENTES A LOS CRÉDITOS."'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('F) QUE CONOCEN LAS PENAS EN LAS QUE INCURREN LAS PERSONAS QUE DECLARAN FALSAMENTE O HACIENDO CREER A ALGUIEN LA CAPACIDAD DE PAGO QUE NO SE TIENE CON EL OBJETO DE OBTENER UN CRÉDITO A SABIENDAS DE QUE NO VA A SER PAGADO O UN LUCRO INDEBIDO Y LAS SANCIONES DE CARÁCTER PENAL QUE TRAEN COMO CONSECUENCIA DICHA CONDUCTA ILÍCITA Y QUE PARA EFECTOS DEL PRESENTE CONTRATO ACTÚAN A NOMBRE Y POR CUENTA PROPIA.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('G) QUE DECLARAN CONOCER QUE EL ORIGEN DEL RECURSO DEL CRÉDITO OTORGADO PUEDE SER PROPIO, ES DECIR, DE PRODECO, O DE UN FONDEO EXTERNO, ES DECIR, DE ENTIDADES GUBERNAMENTALES (FEDERALES, ESTATALES O MUNICIPALES), SIN QUE POR ESTE ÚLTIMO HECHO, DEBA ENTENDERSE QUE SON A FONDO PERDIDO, YA QUE PRODECO LOS RECIBE EN PRÉSTAMO. EN TODO CASO, EL ORIGEN DEL RECURSO, SE ESPECIFICARA EN EL "ANEXO ORIGEN DEL RECURSO", EL CUAL ES PARTE INTEGRANTE DEL PRESENTE CONTRATO POR LO QUE NUNCA PODRÁ INTERPRETARSE EN FORMA SEPARADA O AISLADA DE ESTE.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('H) QUE LA ACREDITANTE LES INFORMÓ QUE CUENTAN CON ASISTENCIA, ACCESOS Y FACILIDADES NECESARIAS PARA ATENDER LAS ACLARACIONESRELACIONADAS CON EL PRESENTE CONTRATO.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('I) QUE TODA LA INFORMACIÓN Y DATOS QUE PROPORCIONA PARA EL OTORGAMIENTO DEL CRÉDITO DE CONFORMIDAD CON LO PREVISTO EN EL PRESENTE CONTRATO ES CIERTA Y VERDADERA; ENCONTRÁNDOSE DENTRO DE DICHA INFORMACIÓN AQUELLA REFERENTE A SU IDENTIFICACIÓN, ESTADO CIVIL, DOMICILIO Y DEMÁS DATOS CONTENIDOS EN "LA SOLICITUD DE CRÉDITO" QUE CORREN AGREGADA AL PRESENTE CONTRATO DEBIDAMENTE FIRMADA POR LAS PARTES, Y ES PARTE INTEGRAL DEL MISMO, POR LO QUE NUNCA PODRÁN INTERPRETARSE EN FORMA AISLADA O SEPARADA A ESTE CONTRATO.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('J) QUE CON ANTERIORIDAD A LA FECHA DE FIRMA DEL PRESENTE CONTRATO, LA ACREDITANTE, LES HA INFORMADO Y EXPLICADO A CADA ACREDITADO, EL CONTENIDO DE CADA UNA DE LAS CLÁUSULAS QUE LO INTEGRAN, TALES COMO EL MONTO TOTAL A PAGAR EN EL CRÉDITO, EL MONTO Y NÚMERO DE LOS PAGO PARCIALES, LA FORMA Y PERIODICIDAD PARA LIQUIDARLOS, CARGAS FINANCIERAS, ACCESORIOS, EL DERECHO QUE TIENE A LIQUIDAR ANTICIPADAMENTE LA OPERACIÓN Y LAS CONDICIONES PARA ELLO, LOS INTERESES ORDINARIOS Y MORATORIOS, EN SU CASO, LA FORMA DE CALCULAR LOS MISMOS Y LOS MONTOS A PAGAR EN CADA PERIODO, GASTOS DE COBRANZA Y/O COMISIONES, Y DEMÁS TÉRMINOS Y CONDICIONES DEL CRÉDITO.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('K) QUE CON ANTERIORIDAD A LA CELEBRACIÓN DEL PRESENTE LA ACREDITANTE LE EXPLICÓ EL TRATAMIENTO QUE LE DARÁ A SUS DATOS PERSONALES MEDIANTE LA ENTREGA DE UN AVISO DE PRIVACIDAD, EN TÉRMINOS DE LA LEY FEDERAL DE PROTECCIÓN DE DATOS PERSONALES EN POSESIÓN DE LOS PARTICULARES, DONDE SE SEÑALA, ADEMÁS DEL TRATAMIENTO QUE SE LE DARÁN A SUS DATOS PERSONALES, LOS DERECHOS DE ACCESO, RECTIFICACIÓN, CANCELACIÓN U OPOSICIÓN CON LOS QUE CUENTA Y LA FORMA CÓMO LOS PUEDE HACER VALER.'), 0, 'J', false);

$pdf->Ln(4);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(185,5,'V.TODAS LAS PARTES DECLARAN:',0,0,'L');

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
$pdf->MultiCell(185,3,utf8_decode('LA ACREDITANTE en este acto otorga una Crédito Individual, en la forma de Crédito Solidario, a EL ACREDITADO, quien podrá disponer del mismo en los términos del presente contrato.
El importe total del crédito que LA ACREDITANTE otorga a EL ACREDITADO es la cantidad de $') . strval(number_format($cantidad, 2)) . ' ('  . $resultado . utf8_decode(') (el "crédito"), mismo que se reembolsara en parcialidades semanales sin exceder el plazo máximo de 76 SEMANAS. Dicho monto dispuesto generara un interés ordinario a razón de una tasa del ') . strval($tasa_interes) .  utf8_decode(' mensual sobre saldos insolutos, condiciones que deberán observarse al momento de que disponga del crédito y de conformidad con las clausulas contenidas en el presente instrumento.
Dentro del monto del crédito dispuesto las partes acuerdan que no quedaran comprendidos en él los intereses, comisiones, impuestos, gastos y demás accesorios originados con motivo del otorgamiento, entrega, pago o recuperación del crédito que EL ACREDITADO debe cubrir.
Como requisito indispensable para la entrega del crédito antes señalado, EL ACREDITADO se obliga a dejar en garantía liquida el 5% (cinco por ciento) del monto autorizado;lo que deberá realizarse previamente a la recepción de dicho crédito o en su defecto dicho porsentaje será descontado de monto a recibir. En caso de falta del crédito en tiempo y forma de acuerdo a la tabla de amortizaciones individual, LA ACREDITANTE podrá cubrir el o los pagos de mora, con la garantía liquida hasta aplicar la totalidad de esta; lo anterior sin mediar mayor autorización por parte de EL ACREDITADO, que la que da en este mismo acto, firmado de conformidad.
Forman parte integrante del presente Contrato, los anexos que se enuncian a continuación, los cuáles se adjuntan al mismo:
Anexo A. Solicitud individual de Crédito.
Anexo B. Tabla de Amortizaciones Individual.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(185,3,utf8_decode('SEGUNDA. FORMA DE ENTREGA DEL CRÉDITO.'), 0, 'J', false);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(185,3,utf8_decode('LA ACREDITANTE entrega en este acto a EL ACREDITADO en una sola exhibición el monto mencionado en la cláusula anterior, dicha entrega podrá ser mediante: cheque nominativo, dinero en efectivo o depósito en cuenta de depósito que EL ACREDITADO tengan operante en LA ACREDITANTE, en su caso, por concepto del importe dispuesto del Crédito, y EL ACREDITADO en este acto otorgan a LA ACREDITANTE y con respecto al importe recibido, el recibo más amplio que en derecho proceda.
La firma de EL ACREDITADO en la póliza del cheque, la firma del presente contrato en caso de que el desembolso se haya realizado en efectivo, o bien el comprobante de depósito a cuenta de EL ACREDITADO hará las veces de comprobante de disposición de la suma otorgada en crédito. EL ACREDITADO será responsable del mal uso que se haga de cualquier monto que reciban en virtud del presente Contrato.'), 0, 'J', false);


$pdf->Ln(2);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(185,3,utf8_decode('TERCERA. OBLIGACION DE PAGO Y TASA DE INTERES ORDINARIA.'), 0, 'J', false);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(185,3,utf8_decode('EL ACREDITADO se obliga a pagar a LA ACREDITANTE la cantidad recibida, más los intereses ordinarios según lo estipulado en la cláusula primera y la cláusula quinta del presente contrato.
Dicha tasa de intereses ordinarios se calculará aplicando el porcentaje designado al monto dispuesto, considerando los días efectivamente transcurridos desde la disposición del crédito o fecha de pago del último interés ordinario cobrado y hasta la fecha de vencimiento del periodo designado para su cobro.'), 0, 'J', false);


$pdf->Ln(2);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(185,3,utf8_decode('CUARTA. OBLIGACION SOLIDARIA.'), 0, 'J', false);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(185,3,utf8_decode('Sin perjuicio de lo señalado en la cláusula tercera de este Contrato, EL (LOS) OBLIGADO(S) SOLIDARIO(S) se constituye(n) en este acto como deudor(es) solidario(s) ante LA ACREDITANTE, renunciando a los beneficios de orden excusión y división contenidos en los artículos 2814, 2815, 2818, 2820, 2823, 2826, y 2834, así como a los beneficios que le otorgan los artículos 2837, 2844, 2845, 2846, 2847, 2848, y 2849, del Código Civil Federal y artículos correlativos a los Códigos Civiles del Distrito Federal y Estados de la República Mexicana. EL (LOS) OBLIGADO(S) SOLIDARIO(S) bajo protesta de decir verdad manifiesta(n) que, durante la vigencia del presente contrato, o hasta que LA ACREDITANTE reciba el pago de todas las cantidades que conforme al presente contrato le adeude EL ACREDITADO, respalda(n) la obligación solidaria que asume(n) en este contrato.'), 0, 'J', false);


$pdf->Ln(2);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(185,3,utf8_decode('QUINTA. FORMA DE PAGO.'), 0, 'J', false);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(185,3,utf8_decode('EL ACREDITADO se obliga a pagar a LA ACREDITANTE la cantidad dispuesta del importe del Crédito más los intereses ordinarios correspondientes, mediante ') . strval($plazo) . utf8_decode(' pagos consecutivos parciales por la cantidad de $') . strval($pagos) . utf8_decode(' cada uno de ellos, con vencimiento en las fechas indicadas en la tabla de amortizaciones que se indica en la presente cláusula mediante depósitos en cualquiera de las siguientes cuentas bancarias: cuenta número 0191667350 o 0839599043 en Grupo Financiero Banorte, S.A.B. de C.V. (BANORTE), cuenta número 0191050052 en Grupo Financiero BBVA Bancomer Sociedad Anónima (BANCOMER), cuenta número 0252559653 en Banco del Ahorro Nacional y Servicios Financieros, S.N.C., Institución de Banca de Desarrollo (BANSEFI), todas a nombre de PRODUCCION ECOTURISTICA COLOTEPEC SC. DE R.S. DE C.V , o bien en el domicilio de LA CREDITANTE ubicado en: EN CALLE PRINCIPAL SIN NÚMERO, BARRA DE NAVIDAD, SANTA MARÍA COLOTEPEC, POCHUTLA, OAXACA, CÓDIGO POSTAL 70934.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('En el supuesto de que la totalidad del monto adeudado establecido en el párrafo que antecede no sea liquidada en los términos establecidos, la totalidad del saldo no pagado del Crédito se dará por vencido de conformidad con lo establecido en el siguiente párrafo.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('EL ACREDITADO se obliga a suscribir, en favor de LA ACREDITANTE un pagaré por el monto efectivamente dispuesto del Crédito, mismo que incluirá una tabla de amortizaciones que señalará los montos y las fechas de vencimiento de cada uno de los pagos parciales que le corresponda, el cual le será devuelto una vez que LA ACREDITANTE reciba el pago del total de los montos adeudados en virtud del presente Contrato. En caso de no hacerse el pago puntual de alguna exhibición parcial, se generará el vencimiento anticipado de los pagos pendientes más el pago de los intereses moratorios, gastos de cobranza y/o comisiones, que en su caso se generen, hasta en tanto se realice el pago total del Crédito. En el pagaré que suscriba EL ACREDITADO se constituirá(n) como avale(s) EL (LOS) OBLIGADO(S) SOLIDARIO(S), esto es, sin perjuicio de la obligación solidaria contraída en el presente Contrato, por el monto total del Crédito y el debido cumplimiento de la obligación de pago de EL ACREDITADO.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('EL ACREDITADO entiende y acepta que en caso de vencimiento anticipado del presente Contrato por la falta de uno o más pagos conforme a lo dispuesto en el presente Contrato, quedará a elección de LA ACREDITANTE demandarlo por la vía Ejecutiva Mercantil, o en su caso por la vía Ordinaria Mercantil. En caso de que la fecha en que deba realizarse el pago correspondiente sea un día inhábil EL ACREDITADO deberá efectuar el pago correspondiente el día hábil inmediato siguiente. Para los efectos de esta cláusula, un día hábil significa un día en el que los bancos del Distrito Federal (Instituciones de Crédito) se encuentren abiertos al público en general para la realización de operaciones bancarias normales, y los días en que LA ACREDITANTE se encuentre autorizada para realizar operaciones con el público en general.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('EL ACREDITADO convienen en pagar la totalidad de los gastos, derechos e impuestos en vigor, así como los que en el futuro pudieran establecerse por cualquier autoridad, respecto a la ejecución y cumplimiento del presente Contrato, por lo que desde ahora se conviene en que LA ACREDITANTE no deberá efectuar erogación alguna por ninguno de los conceptos señalados. Si por cualquier causa LA ACREDITANTE pagara alguna cantidad derivada de lo estipulado en esta cláusula, EL ACREDITADO deberá reintegrársela en cuanto se los solicite LA ACREDITANTE. En el caso de que los mencionados gastos, derechos o impuestos, sufran algún aumento en sus respectivos importes, EL ACREDITADO se obliga a depositar de inmediato ante LA ACREDITANTE la diferencia respectiva.'), 0, 'J', false);


$pdf->Ln(2);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(185,3,utf8_decode('SEXTA. VIGENCIA DEL CONTRATO.'), 0, 'J', false);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(185,3,utf8_decode('La vigencia del presente contrato será la definida por el plazo para el pago del crédito, pero no cesaran sus efectos en tanto el crédito o cualquier cantidad adeudada permanezca insoluta. No obstante lo anterior, cualquiera de las partes podrá manifestar a la otra su voluntad de darlo por terminado en forma anticipada en términos de la cláusula décima primera.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('LA ACREDITANTE se reserva el derecho denunciar el presente Contrato, mediante simple comunicación escrita dirigida a EL ACREDITADO, en este supuesto de que LA ACREDITANTE denuncie el crédito, se tendrá por vencido anticipadamente el plazo pactado del Crédito, por lo que EL ACREDITADO deberá restituir de inmediato a LA ACREDITANTE el importe total de la suma que hayan dispuesto y cualquier otra cantidad adeudada derivada de este Contrato.'), 0, 'J', false);


$pdf->Ln(2);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(185,3,utf8_decode('SÉPTIMA. ESTADO DE CUENTA.'), 0, 'J', false);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(185,3,utf8_decode('Mediante el presente Contrato, EL ACREDITADO instruye expresamente a LA ACREDITANTE para que ésta expida el estado de cuenta de EL ACREDITADO solamente al momento en que éste se lo solicite en la sucursal en la que se les otorgó el Crédito. De tal forma, EL ACREDITADO podrán solicitar la consulta de saldos, transacciones, movimientos y su estado de cuenta, en las oficinas de LA ACREDITANTE dentro de los horarios de atención al público.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('En el estado de cuenta correspondiente se indicarán, entre otros aspectos: las cantidades cargadas y abonadas, con sus respectivas fechas, así como los datos necesarios para realizar el cálculo de los intereses a pagar, así como cualquier otro movimiento.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('EL ACREDITADO podrá objetar en las sucursales de LA ACREDITANTE el estado de cuenta dentro de los 30 (treinta) días naturales contados a partir de la fecha en que el estado de cuenta quedó a su disposición, una vez que lo requirió en la sucursal.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('El estado de cuenta certificado por el contador público autorizado para tal efecto por LA ACREDITANTE hará fe, salvo prueba en contrario, en el juicio respectivo para la fijación del saldo resultante a cargo de EL ACREDITADO.'), 0, 'J', false);


$pdf->Ln(2);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(185,3,utf8_decode('OCTAVA. SUPLENCIA EN CASO DE NO SABER FIRMAR.'), 0, 'J', false);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(185,3,utf8_decode('En caso de que EL ACREDITADO o EL(LOS) OBLIGADO(S) SOLIDARIO(S) no sepan leer y/o escribir, deberá firmar otra persona a su ruego este Contrato y los pagarés que se derivan de la disposición del Crédito, agregando su nombre y asentando junto a su firma la leyenda "a ruego de" y el nombre de EL ACREDITADO y /o EL (LOS) OBLIGADO(S) SOLIDARIO(S), que no sepa(n) leer y/o escribir deberá(n) imprimir su huella digital. En ese caso EL ACREDITADO acepta y acuerda que la firma hecha por encargo y la impresión de la huella digital de EL ACREDITADO o EL (LOS) OBLIGADO(S) SOLIDARIO(S) surtirá los mismos efectos legales que si éste hubiera estampado su firma personalmente, y por lo tanto, quien firme a ruego asume la responsabilidad de enterar y explicar a EL ACREDITADO o EL (LOS) OBLIGADO(S) SOLIDARIO(S) que no sepa(n) leer y/o escribir respecto de todos sus derechos y obligaciones bajo este Contrato.'), 0, 'J', false);


$pdf->Ln(2);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(185,3,utf8_decode('NOVENA. COMPROBANTE DE DEPÓSITO.'), 0, 'J', false);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(185,3,utf8_decode('El comprobante de depósito realizado a las cuentas bancarias mencionadas en la cláusula quinta del presente contrato, servirán para acreditar el cumplimiento de las obligaciones de EL ACREDITADO respecto a cada uno de los pagos parciales.'), 0, 'J', false);

//$pdf->AddPage();

$pdf->Ln(2);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(185,3,utf8_decode('DÉCIMA. PAGOS ANTICIPADOS.'), 0, 'J', false);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(185,3,utf8_decode('En caso de que EL ACREDITADO quisiera realizar anticipadamente el pago del importe total del Crédito, lo podrá hacer sin penalización alguna.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('El ACREDITADO podrá efectuar en cualquier tiempo, pagos anticipados y serán aplicados a cubrir el ó los vencimiento(s) inmediato(s) siguiente(s) de acuerdo con lo previsto en la cláusula décima tercera.'), 0, 'J', false);



$pdf->Ln(2);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(185,3,utf8_decode('DÉCIMA PRIMERA. CAUSAS DE VENCIMIENTO ANTICIPADO.'), 0, 'J', false);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(185,3,utf8_decode('LA ACREDITANTE se reserva la facultad de dar por vencido anticipadamente el presente Contrato y exigir el pago de la totalidad del Crédito y sus intereses, sin necesidad de requisito o trámite previo alguno, cuando EL ACREDITADO incumpla cualquiera de las obligaciones contraídas en este Contrato, adicionalmente de los casos previstos en la legislación aplicable, así como cualquiera de los siguientes supuestos:'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('1. EL ACREDITADO deje de pagar puntualmente cualquiera de las cantidades del Crédito o sus accesorios de conformidad con lo previsto en el presente Contrato.
2. EL ACREDITADO o EL (LOS) OBLIGADO(S) SOLIDARIO(S) contrate adeudos, o realice venta, enajenación o donación de sus bienes muebles o inmuebles que lo coloquen en estado de insolvencia después del otorgamiento del Crédito, sin el consentimiento previo y por escrito de LA ACREDITANTE.
3. EL ACREDITADO o EL (LOS) OBLIGADO(S) SOLIDARIO(S) haya proporcionado información falsa para el otorgamiento del Crédito.
4. En caso de que se incumpla con cualquiera de las obligaciones contenidas en el presente instrumento.
5. EL ACREDITADO deje de invertir parcial o totalmente el importe del Crédito en los conceptos para los cuales fue solicitado el financiamiento o no efectúe totalmente las inversiones correspondientes.
6. Si EL ACREDITADO o EL (LOS) OBLIGADO(S) SOLIDARIO(S), es emplazados a huelga, demandados, o sus bienes embargados, son concursados o declarados en quiebra, intervenidos en sus negocios o caja por terceros o autoridades cualquiera que sea su naturaleza, o se vea afectado en sus negocios, oficinas, fábricas o cualquier domicilio en que se encuentren sus establecimientos u oficinas, tiendas o sucursales;
7. Por cualquier otra causa que se establezca en las reglas de operación de LA ACREDITANTE, sus estatutos o en disposición legal aplicable.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('No obstante el vencimiento anticipado, el presente contrato seguirá produciendo los efectos legales correspondientes entre las partes, hasta que EL ACREDITADO o EL (LOS) OBLIGADO(S) SOLIDARIO(S) y LA ACREDITANTE hayan cumplido con todas y cada una de sus obligaciones contraídas al amparo del mismo, en la forma y términos pactados.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('El vencimiento anticipado tendrá como consecuencia, hacer exigible el pago inmediato del capital no pagado y los intereses ordinarios y moratorios, gastos de cobranza y/o comisiones y demás accesorios, que en su caso se hayan generado, a cargo de EL ACREDITADO.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('EL ACREDITADO podrán solicitar, en todo momento, la terminación anticipada o cancelación del presente Contrato, bastando para ello la presentación de una solicitud en cualquier sucursal de LA ACREDITANTE, debiendo cubrir, en su caso y en los términos pactados en el mismo, el monto total del adeudo, incluyendo todos los accesorios financieros que se hubiera generado a la fecha en que se solicite la terminación.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('En caso de que EL ACREDITADO solicite la terminación anticipada del presente Contrato y no tenga adeudos pendientes a dicha fecha, LA ACREDITANTE dará por terminado el mismo el día hábil siguiente a la fecha en que fue recibida la solicitud de terminación correspondiente. En caso de que existan adeudos pendientes al momento de recibir la solicitud de terminación anticipada, LA ACREDITANTE, a más tardar el día hábil siguiente a la fecha de recepción de la solicitud de terminación, comunicará a EL ACREDITADO el importe de los adeudos pendientes y dentro de los 15 (quince) días hábiles siguientes contados a partir de la fecha de recepción de la solicitud de terminación pondrá a su disposición dicho dato, en el domicilio de LA ACREDITANTE y una vez liquidados los adeudos se dará por terminado el Contrato.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('LA ACREDITANTE entregará, en su caso, el saldo en la fecha en que se dé por terminado la operación. LA ACREDITANTE pondrá a disposición de EL ACREDITADO, dentro de 15 (quince) días hábiles contados a partir de la fecha en que se hubiera realizado el pago de los adeudos, el estado de cuenta en el que conste el fin de la relación contractual y la inexistencia de adeudos derivados exclusivamente de dicha relación.'), 0, 'J', false);



$pdf->Ln(2);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(185,3,utf8_decode('DÉCIMA SEGUNDA. OTRAS OBLIGACIONES DE EL ACREDITADO Y EL (LOS) OBLIGADO(S) SOLIDARIO(S).'), 0, 'J', false);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(185,3,utf8_decode('Además de las obligaciones contenidas en el presente instrumento, durante la vigencia del presente Contrato, deberán:'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('1. Dar aviso por escrito de su cambio de domicilio, notificando dicha circunstancia a LA ACREDITANTE con por lo menos 30 (treinta) días naturales de anterioridad a la fecha en que el cambio de domicilio suceda.
2. Informar a LA ACREDITANTE de cualquier situación que pueda causar el vencimiento anticipado del Contrato.
3. Permitir el acceso a sus domicilios, propiedades y negocios al personal de LA ACREDITANTE y/o aquellas personas que LA ACREDITANTE determine, y/o representantes de LA ACREDITANTE. Así como proporcionar los documentos y /o información que le soliciten en relación al Crédito que LA ACREDITANTE le haya otorgado.
4. Manejar racionalmente los recursos naturales y preservar el medio ambiente, acatando las medidas y acciones dictadas por las autoridades competentes.
5. EL ACREDITADO deberán informar oportunamente a LA ACREDITANTE cualquier acto o hecho que pueda afectar la recuperación del financiamiento.
6. En su caso, cuando sea aplicable y de acuerdo a las políticas vigentes de LA ACREDITANTE, deberán contratar la cobertura para la administración del riesgo.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(185,3,utf8_decode('DÉCIMA TERCERA. APLICACION Y DISTRIBUCION DE PAGOS.'), 0, 'J', false);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(185,3,utf8_decode('1. El orden de prelación en la aplicación del pago de cantidades adeudadas hechas por EL ACREDITADO será el siguiente:'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('a) Impuesto al Valor Agregado sobre intereses moratorios, si se causa;
b) Intereses moratorios, si se causan;
c) Impuesto al Valor Agregado sobre otros gastos, entre los que se incluyen gastos de cobranza y comisiones;
d) Otros gastos derivados del presente Contrato, entre los que se incluyen gastos de cobranza y comisiones;
e) Impuesto al Valor Agregado sobre intereses ordinarios, si se causa
f) Intereses ordinarios;
g) Capital vencido; y
h) Capital vigente.'), 0, 'J', false);


$pdf->Ln(2);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(185,3,utf8_decode('DÉCIMA CUARTA. CESIÓN DE DERECHOS DEL CONTRATO.'), 0, 'J', false);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(185,3,utf8_decode('EL ACREDITADO Y EL (LOS) OBLIGADO(S) SOLIDARIO(S) autorizan expresamente a LA ACREDITANTE para transmitir, endosar, ceder, descontar o en cualquier otra forma negociar parcial o totalmente el presente Contrato y los pagarés que se deriven del mismo, aún antes de su vencimiento, manifestando también EL ACREDITADO Y EL (LOS) OBLIGADO(S) SOLIDARIO(S) su voluntad de reconocer a las personas a las que se les transmitan los derechos antes mencionados, los mismos derechos que corresponden a LA ACREDITANTE al amparo del presente instrumento.'), 0, 'J', false);


$pdf->Ln(2);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(185,3,utf8_decode('DÉCIMA QUINTA. OBLIGACIONES EN CASO DE FALLECIMIENTO DEL ACREDITADO.'), 0, 'J', false);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(185,3,utf8_decode('En caso de fallecimiento de alguno de EL ACREDITADO, EL (LOS) OBLIGADO(S) SOLIDARIO(S) se obliga(n) desde este momento a cubrir de manera solidaria el adeudo correspondiente del fallecido, subsistiendo en todo momento las obligaciones generadas por EL ACREDITADO en el presente acuerdo de voluntades, así como de los documentos suscritos en garantía y relacionados en la cláusula quinta de este Contrato. La protección señalada en la presente cláusula no es ni podrá considerarse como un seguro, en términos de lo dispuesto por la Ley sobre el Contrato de Seguro.'), 0, 'J', false);


$pdf->Ln(2);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(185,3,utf8_decode('DÉCIMA SEXTA. MODIFICACIONES AL CONTRATO.'), 0, 'J', false);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(185,3,utf8_decode('LA ACREDITANTE deberá notificar a EL ACREDITADO las modificaciones que se pretendan hacer a este Contrato o a cualquiera de sus anexos, con al menos 30 (treinta) días naturales de anticipación a la fecha de entrada en vigor de dichas modificaciones. EL ACREDITADO instruye expresamente a LA ACREDITANTE para que cualquier modificación que se pretenda llevar a cabo al presente Contrato o a sus anexos, se les notifique mediante la entrega de un aviso por escrito en su domicilio identificado en la declaración II. Inciso a) del presente Contrato, con la finalidad de que tenga conocimiento de las modificaciones que se pretendan llevar a cabo al Contrato, liberando a LA ACREDITANTE de cualquier reclamación o responsabilidad derivada de su falta o retraso en la notificación señalada.'), 0, 'J', false);


$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('En caso de que EL ACREDITADO no esté de acuerdo con las modificaciones propuestas, podrá solicitar la terminación del Contrato dentro de los 15 (quince) días naturales posteriores al aviso señalado en el párrafo anterior, sin responsabilidad ni comisión alguna a su cargo; debiendo EL ACREDITADO cubrir el monto del Crédito, así como los adeudos que se hubieren generado a la fecha en que soliciten dar por terminado el Contrato. Una vez transcurrido el plazo señalado en el párrafo que antecede, sin que LA ACREDITANTE haya recibido comunicación alguna por parte de EL ACREDITADO, se tendrán por aceptadas las modificaciones del Contrato. Asimismo, LA ACREDITANTE deberá notificar a EL ACREDITADO con por lo menos 15 (quince) días naturales de anticipación, los incrementos en cualquiera de las comisiones que, en su caso LA ACREDITANTE cobre en virtud de la contratación del Crédito, así como, las nuevas comisiones que se pretendan cobrar. Dicha notificación se llevará en los mismos términos señalados en el primer párrafo de la presente cláusula.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('EL ACREDITADO tendrá derecho de dar por terminado el presente Contrato, en caso de no estar de acuerdo con los nuevos montos de las comisiones o con la nueva comisión que se pretenda cobrar. En este caso LA ACREDITANTE no le cobrará cantidad adicional por este hecho, con excepción de los adeudos que ya se hubieren generado a la fecha en que EL ACREDITADO solicite dar por terminado el presente Contrato.'), 0, 'J', false);


$pdf->Ln(2);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(185,3,utf8_decode('DÉCIMA SÉPTIMA. EJECUTIVIDAD DEL CONTRATO.'), 0, 'J', false);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(185,3,utf8_decode('Convienen las partes que el presente Contrato junto con el estado de cuenta certificado por el contador de LA ACREDITANTE, hará fe, salvo prueba en contrario, en el juicio respectivo para la aplicación del saldo resultante a cargo de EL ACREDITADO y en consecuencia será título ejecutivo mercantil, sin necesidad de reconocimiento de firma y ni de otro requisito en términos de la legislación aplicable.'), 0, 'J', false);


$pdf->Ln(2);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(185,3,utf8_decode('DÉCIMA OCTAVA. DOMICILIOS PARA OIR Y RECIBIR NOTIFICACIONES.'), 0, 'J', false);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(185,3,utf8_decode('Para efectos del presente Contrato, cada una de las partes señala como su domicilio convencional para recibir toda clase de notificaciones relacionadas con el presente Contrato, los manifestados en el capítulo de declaraciones del presente Contrato. Cualquier aviso, comunicación o entrega de documentación requerida conforme al presente Contrato deberá hacerse por escrito y deberá entregarse personalmente o a través de cualquier tipo de mensajería que permita acuse de recibo, porte pagado, en el domicilio antes citado. Los avisos realizados en el domicilio de las partes, se consideran realizados hasta en tanto las partes no notifiquen por escrito un cambio de domicilio, los avisos, notificaciones y demás diligencias judiciales y extrajudiciales que se hagan en los domicilios indicados surtirán plenamente sus efectos.'), 0, 'J', false);


$pdf->Ln(2);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(185,3,utf8_decode('DÉCIMA NOVENA. SUSTITUCIÓN Y REVOCACION DE ACUERDOS PREVIOS.'), 0, 'J', false);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(185,3,utf8_decode('El presente Contrato y sus anexos, constituyen el acuerdo total entre las partes, en consecuencia sustituyen y revocan todos los acuerdos previos, verbales o escritos, que se opongan de cualquier manera al mismo.'), 0, 'J', false);


$pdf->Ln(2);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(185,3,utf8_decode('VIGÉSIMA. PUBLICIDAD.'), 0, 'J', false);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(185,3,utf8_decode('Mediante la firma del presente Contrato, EL ACREDITADO y EL (LOS) OBLIGADO(S) SOLIDARIO(S) autorizan expresamente a LA ACREDITANTE para contactarlos directamente o por vía telefónica en su lugar de trabajo, en un horario de las 9:00 horas a las 19:00 horas, o bien, para que le envíe a su domicilio o lugar de trabajo publicidad relativa a productos o servicios que LA ACREDITANTE ofrece al público en general; así mismo, autoriza a LA ACREDITANTE para que utilice sus datos personales para fines publicitarios o de mercadotecnia.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(185,3,utf8_decode('VIGÉSIMA PRIMERA. JURISDICCIÓN Y COMPETENCIA.'), 0, 'J', false);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(185,3,utf8_decode('Para la interpretación o cumplimiento del presente Contrato, las partes se someten expresamente a la jurisdicción de los tribunales de la Ciudad de Puerto Escondido, Oaxaca renunciando desde este momento, a cualquier fuero que en razón de sus domicilios presentes o futuros pudiera corresponderles.'), 0, 'J', false);


$pdf->Ln(2);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(185,3,utf8_decode('VIGÉSIMA SEGUNDA. CONSULTAS, ACLARACIONES E INCONFORMIDADES.'), 0, 'J', false);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(185,3,utf8_decode('Servicio de atención al público en consultas y aclaraciones. Para cualquier solicitud, consulta y aclaración relacionadas con el Crédito contratado, EL ACREDITADO podrá solicitar el apoyo del Gerente de Sucursal o del personal en el domicilio de LA ACREDITANTE.'), 0, 'J', false);


$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('En el supuesto de que EL ACREDITADO no esté de acuerdo con alguno de los movimientos que aparezcan en el estado de cuenta, podrán presentar una solicitud de aclaración dentro del plazo de 30 (treinta) días naturales contados a partir de la fecha en que el estado de cuenta quedó a su disposición o, en su caso, de la realización de la operación. La solicitud respectiva deberá presentarse, por escrito, ante el Gerente de la Cooperativa. LA ACREDITANTE estará obligada a acusar recibo de dicha solicitud.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('EL ACREDITADO deberá realizar el pago bajo protesta de cuya aclaración solicita, así como el de cualquier otra cantidad relacionada con dicho pago, hasta en tanto se resuelva la aclaración conforme al procedimiento que se señala a continuación.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('Una vez que LA ACREDITANTE reciba la solicitud de aclaración, tendrá un plazo máximo de 30 (treinta) días naturales contados a partir de la recepción de la solicitud, para entregar a EL ACREDITADO el dictamen correspondiente, así como un informe detallado en el que se respondan todos los hechos contenidos en la solicitud presentada por EL ACREDITADO. LA ACREDITANTE formulará el dictamen e informe antes referidos por escrito. Si resultare un saldo a favor de EL ACREDITADO, este será abonado al siguiente pago que deba realizar, si ya no existieren más pagos por realizar, dicha cantidad se les devolverá.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('Dentro del plazo de 10 (diez) días naturales contados a partir de la entrega del dictamen, LA ACREDITANTE estará obligada a poner a disposición de EL ACREDITADO en el domicilio de LA ACREDITANTE, el expediente generado con motivo de la solicitud.'), 0, 'J', false);


$pdf->Ln(2);
$pdf->SetFont('Arial','B',8);
$pdf->MultiCell(185,3,utf8_decode('VIGÉSIMA TERCERA. PROTECCIÓN DE DATOS PERSONALES.'), 0, 'J', false);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(185,3,utf8_decode('Conforme a la Ley Federal de Protección de Datos Personales en Posesión de los Particulares, LA ACREDITANTE, previamente a la celebración del presente contrato, solicitó datos personales de EL ACREDITADO y EL (LOS) OBLIGADO(S) SOLIDARIO(S) con la finalidad de identificarlos y poder celebrar el presente contrato de crédito, informarles sobre el estatus del mismo, ceder o vender el mismo, realizar requerimientos de pago, así como para ofrecerles los diferentes productos y/o servicios que LA ACREDITANTE tiene a su disposición. LA ACREDITANTE protegerá y mantendrá los datos personales de EL ACREDITADO Y EL (LOS) OBLIGADO(S) SOLIDARIO(S) por el tiempo razonablemente necesario, tomando en cuenta las disposiciones legales aplicables y sólo compartirá y/o transferirá dicha información con otra(s) entidad(es), cuando EL ACREDITADO contrate otro producto y/o servicio a través de LA ACREDITANTE, o para la cesión y/o venta del presente contrato, o bien, cuando así se requiera por disposición legal.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('EL ACREDITADO podrá ejercer en todo momento ante LA ACREDITANTE, sus derechos de acceso, rectificación, cancelación en oposición en el tratamiento de sus datos personales, en caso de que legalmente sea procedente, conforme a los lineamientos y requisitos que marca la Ley Federal de Protección de Datos Personales en Posesión de los Particulares, presentándose en el domicilio de la ACREDITANTE contactando a su Asesor de Crédito o al personal que pudiera apoyar dicho requerimiento.'), 0, 'J', false);


$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('Por último señala LA ACREDITANTE que el Aviso de Privacidad y cualquier cambio y/o modificación total o parcial del mismo puede ser consultado directamente en el domicilio de LA ACREDITANTE.'), 0, 'J', false);

$pdf->Ln(2);
$pdf->MultiCell(185,3,utf8_decode('LEÍDO Y COMPRENDIDO EL PRESENTE CONTRATO, ENTERADAS LAS PARTES QUE INTERVIENEN DE SU CONTENIDO, ALCANCES, CONSECUENCIAS LEGALES Y ECONÓMICAS, LO FIRMAN DE CONFORMIDAD')  . $mi_fecha . utf8_decode(', EN CALLE PRINCIPAL SN BARRA DE NAVIDAD , Y EN ESTE ACTO SE HACE ENTREGA A EL ACREDITADO, DE UN DUPLICADO DE ESTE CONTRATO, DE ESTE INSTRUMENTO Y SUS RESPECTIVOS ANEXOS.'), 0, 'J', false);


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

$pdf->Ln(30);
$pdf->Cell(185,10,'EL ACREDITADO',0,0,'C');
$pdf->Ln(25);
$pdf->Line(75, 105, 130, 105);
$pdf->Cell(185,10,utf8_decode($str_cliente),0,0,'C');

$pdf->Ln(25);
$pdf->Cell(185,10,'EL (LOS) OBLIGADOS SOLIDARIOS AVALES:',0,0,'C');
$pdf->Ln(25);
$pdf->Line(75, 155, 130, 155);




$pdf->Output();
?>
