<?php

include('../php/db.php');
//if (isset($_GET['credito_id'])) {
$credito_id = $_POST['credito_id'];
//echo "select *,DATEDIFF(a.fecha_pago, p.fecha_valor) as dias from amortizaciones a inner join pagos p on p.idkey_amortizaciones=a.idkey where a.idkey_creditos=". $credito_id .";";
//echo "select * from amortizaciones a left join pagos p on p.idkey_amortizaciones=a.idkey where a.fecha_pago > NOW() and a.idkey_creditos=". $credito_id .";";
$oconns = new database();

$datas = $oconns->getRows("select *,DATEDIFF(a.fecha_pago, p.fecha_valor) as dias from amortizaciones a inner join pagos p on p.idkey_amortizaciones=a.idkey where a.idkey_creditos=". $credito_id .";"); ?>
<table class="table table-bordered table-hover mt-2">
    <thead class="bgc-success-m2 text-white">
        <tr class="font-bold text-100">
            <td width="15%">Fecha de pago</td>
            <td>Núm. de pago</td>
            <td>Interés</td>
            <td>IVA</td>
            <td>Cantidad</td>
            <td>Saldo insoluto</td>
            <td>Fecha valor</td>
            <td>Monto</td>
            <td>Días transcurridos</td>
            <td>Saldo sinsoluto</td>
        </tr>
    </thead>
    <tbody>
<?php foreach($datas as $item){ ?>
        <tr>
            <td><?php echo $item["fecha_pago"];?></td>
            <td><?php echo $item["pago"]; ?></td>
            <td><?php echo $item["intereses"]; ?></td>
            <td><?php echo $item["iva"]; ?></td>
            <td><?php echo $item["total"]; ?></td>
            <td><?php echo $item["saldo_insoluto"]; ?></td>
            <td><?php echo $item["fecha_valor"]; ?></td>
            <td><?php echo $item["monto"]; ?></td>
            <td><?php echo $item["dias"]; ?></td>
            <td><?php if($item["saldo_insoluto_2"]==0){
                    $saldo_insoluto = $item["saldo_insoluto"];
                }else{
                    $saldo_insoluto = $item["saldo_insoluto_2"];
                }
                    echo $saldo_insoluto; ?>
            </td>
        </tr>
<?php } ?>
    </tbody>
</table>
<?php //} ?>
