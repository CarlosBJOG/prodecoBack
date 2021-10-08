<?php 
require_once "db.php";
$oconns = new database();
$datas = $oconns->getRows("select * from clientes");

 foreach ($datas as $item)
    echo $item["idkey"]."--";


echo " vista ";

$idkey_cliente = 2;
$query = sprintf("select 
            (select count(idkey_clientes) as cred_ind_activos FROM view_creditos WHERE estatus = 1 and idkey_clientes = %u) +
            (select count(idkey_credito) as cred_grup_activos FROM view_creditos vc inner join grupos_nombre gn 
                on (vc.idkey_clientes = gn.idkey) inner join grupos_clientes gc on (gc.idkey_grupo = gn.idkey)
                WHERE vc.estatus = 1 and gc.idkey_clientes =%u) as ncreditos ",$idkey_cliente, $idkey_cliente);
         $data = $oconns->getRows($query);
         echo $data[0]["ncreditos"]


//////////////////////////////
         /*
$conn = mysqli_connect("localhost", "root", "", "creditos");
$query = "SELECT * FROM view_clientes ";

$result = mysqli_query($conn, $query);


    while($row = mysqli_fetch_assoc($result))
    {
        echo $row["nombre"]."<br>";
    }

mysqli_close();*/


?>