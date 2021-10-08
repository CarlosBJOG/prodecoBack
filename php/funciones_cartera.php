<?php

require_once('db.php');

//Factores

function create_fburo(){
	$oconns = new database();
	$data = $oconns->getRows("select * from clientes_fact_buro order by idkey asc;");
	foreach ($data as $item)
	    echo "<option value='".$item["idkey"]."'>".$item["nombre"]."</option>";
	      
}

function create_fexp_crediticia(){
	$oconns = new database();
	$data = $oconns->getRows("select * from clientes_fact_exp_crediticia order by idkey asc;");
	foreach ($data as $item)
	    echo "<option value='".$item["idkey"]."'>".$item["nombre"]."</option>";
}

function create_fcap_pago(){
	$oconns = new database();
	$data = $oconns->getRows("select * from clientes_fact_cap_pago order by idkey asc;");
	foreach ($data as $item)
	    echo "<option value='".$item["idkey"]."'>".$item["nombre"]."</option>";
}

function create_fcomp_ingresos(){
	$oconns = new database();
	$data = $oconns->getRows("select * from clientes_fact_comp_ingresos order by idkey asc;");
	foreach ($data as $item)
	    echo "<option value='".$item["idkey"]."'>".$item["nombre"]."</option>";
}

function create_freferencias(){
	$oconns = new database();
	$data = $oconns->getRows("select * from clientes_fact_referencias order by idkey asc;");
	foreach ($data as $item)
	    echo "<option value='".$item["idkey"]."'>".$item["nombre"]."</option>";
}

function create_factividad(){
	$oconns = new database();
	$data = $oconns->getRows("select * from clientes_fact_actividad order by idkey asc;");
	foreach ($data as $item)
	    echo "<option value='".$item["idkey"]."'>".$item["nombre"]."</option>";
}

function create_fveracidad(){
	$oconns = new database();
	$data = $oconns->getRows("select * from clientes_fact_veracidad order by idkey asc;");
	foreach ($data as $item)
	    echo "<option value='".$item["idkey"]."'>".$item["nombre"]."</option>";
}

function create_fgliquida(){
	$oconns = new database();
	$data = $oconns->getRows("select * from clientes_fact_gliquida order by idkey asc;");
	foreach ($data as $item)
	    echo "<option value='".$item["idkey"]."'>".$item["nombre"]."</option>";
}

function create_fsolvencia(){
	$oconns = new database();
	$data = $oconns->getRows("select * from clientes_fact_solvencia order by idkey asc;");
	foreach ($data as $item)
	    echo "<option value='".$item["idkey"]."'>".$item["nombre"]."</option>";
}

//Créditos

function consulta_socios(){
	$oconns = new database();
    $data = $oconns->getRows("select idkey_cliente, nombre from view_clientes where porcentaje_perfil = 1 order by idkey_cliente asc;");
    $socios ="";
    foreach ($data as $items)
        $socios.= "<option value='".$items["idkey_cliente"]."'>".$items["idkey_cliente"]."-".$items["nombre"]."</option>";
    return $socios;
}

function consulta_frecuencia_cred(){
	$oconns = new database();
    $data = $oconns->getRows("select idkey, nombre from frecuencia  order by idkey asc;");
    echo "<option value=''></option>";
    foreach ($data as $items)
        echo "<option value='".$items["idkey"]."'>".$items["nombre"]."</option>";
}

	    
	   