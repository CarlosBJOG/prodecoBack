<?php

include('../php/db.php');
//if (isset($_GET['credito_id'])) {
$credito_id = $_POST['credito_id'];
//echo "select * from amortizaciones a left join pagos p on p.idkey_amortizaciones=a.idkey where a.fecha_pago > NOW() and a.idkey_creditos=". $credito_id .";";
$oconns = new database();

$datas = $oconns->getRows("select a.*,p.referencia,p.monto,p.monto,p.fecha_valor,p.idkey_clasificacion_pagos,p.idkey_amortizaciones,saldo_insoluto_2 from amortizaciones a left join pagos p on p.idkey_amortizaciones=a.idkey where a.fecha_pago >= NOW() and a.idkey_creditos=". $credito_id ." LIMIT 1;"); 

?>
<input hidden type="text" value="<?php echo $credito_id ?>" />
<table class="table table-bordered table-hover mt-2">
    <thead class="bgc-success-m2 text-white">
        <tr class="font-bold text-100">
            <td width="15%">Fecha de pago</td>
            <td>Núm. de pago</td>
            <td>Interés</td>
            <td>IVA</td>
            <td>Cantidad</td>
            <td>Saldo insoluto</td>
            <td></td>
            <!--<td>Fecha valor</td>
            <td>Monto</td>
            <td>Días transcurridos</td>-->
        </tr>
    </thead>
    <tbody>
<?php foreach($datas as $item){ 
    $fila_id = $item["idkey"];
    ?>
        <tr>
            <td><?php echo $item["fecha_pago"];?></td>
            <td><?php echo $item["pago"]; ?></td>
            <td><?php echo $item["intereses"]; ?></td>
            <td><?php echo $item["iva"]; ?></td>
            <td><?php echo $item["total"]; ?></td>
            <td><?php echo $item["saldo_insoluto"]; ?></td>
            <td><a href="<?php echo "../seguimiento/registrar-pago.php?credito_id=".$credito_id."&fila_id=".$fila_id; ?>"</a>Registrar Pago</a></td>
            <!--<td><?php echo $item["fecha_valor"]; ?></td>
            <td><?php echo $item[""]; ?></td>
            <td><?php echo $item["dias"]; ?></td>-->
        </tr>
<?php } ?>
    </tbody>
</table>
<?php //} ?>
