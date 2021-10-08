<?php

    require_once('../php/db.php');
    
    
    function select_referencias($param)
    {

	$oconns = new database();
	$dats = $oconns->getRows("select * from fact_referencia order by value;");
	
	foreach ($dats as $items)
	{
	    if ($param==$items["value"])
	    {
		echo "<label>".$items["nombre"]."</label>";
	    }
	}
    }
    
     function select_clasificacion($param)
    {

	$oconns = new database();
	$dats = $oconns->getRows("select * from clasificacion_pagos;");
	
	foreach ($dats as $items)
	{
	    if ($param==$items["idkey"])
	    {
		echo "<option value='".$items["idkey"]."' selected>".$items["nombre"]."</option>";
	    }
	    else
		{
		    echo "<option value='".$items["idkey"]."'>".$items["nombre"]."</option>";
		}
	}
    }

    function select_veracidad($param)
    {

	$oconns = new database();
	$dats = $oconns->getRows("select * from fact_veracidad order by value;");
	
	foreach ($dats as $items)
	{
	    if ($param==$items["value"])
	    {
		echo "<label>".$items["nombre"]."</label>";
	    }
	}
    }
    
    function select_garantia($param)
    {

	$oconns = new database();
	$dats = $oconns->getRows("select * from fact_garantia_liq order by value;");
	
	foreach ($dats as $items)
	{
	    if ($param==$items["value"])
	    {
		echo "<label value='".$items["value"]."' selected>".$items["nombre"]."</label>";
	    }
	}
    }
    
    function select_conocimiento($param)
    {

	$oconns = new database();
	$dats = $oconns->getRows("select * from fact_conocimiento order by value;");
	
	foreach ($dats as $items)
	{
	    if ($param==$items["value"])
	    {
		echo "<label value='".$items["value"]."' selected>".$items["nombre"]."</label>";
	    }
	}
    }
    
    function select_capacidad_pago($param)
    {

	$oconns = new database();
	$dats = $oconns->getRows("select * from fact_capacidad_pago order by value;");
	
	foreach ($dats as $items)
	{
	    if ($param==$items["value"])
	    {
		echo "<label value='".$items["value"]."' selected>".$items["nombre"]."</label>";
	    }
	}
    }
    
    function select_solvencia($param)
    {

	$oconns = new database();
	$dats = $oconns->getRows("select * from fact_solvencia order by value;");
	
	foreach ($dats as $items)
	{
	    if ($param==$items["value"])
	    {
		echo "<label value='".$items["value"]."' selected>".$items["nombre"]."</label>";
	    }
	}
    }
    
    function select_exp_cred($param)
    {

	$oconns = new database();
	$dats = $oconns->getRows("select * from fact_exp_cred order by value;");
	
	foreach ($dats as $items)
	{
	    if ($param==$items["value"])
	    {
		echo "<label value='".$items["value"]."' selected>".$items["nombre"]."</label>";
	    }
	}
    }
    
    function select_hist_int($param)
    {

	$oconns = new database();
	$dats = $oconns->getRows("select * from fact_hist_int order by value;");
	
	foreach ($dats as $items)
	{
	    if ($param==$items["value"])
	    {
		echo "<label value='".$items["value"]."' selected>".$items["nombre"]."</label>";
	    }
	}
    }
    
    function select_buro($param)
    {

	$oconns = new database();
	$dats = $oconns->getRows("select * from fact_buro order by value;");
	
	foreach ($dats as $items)
	{
	    if ($param==$items["value"])
	    {
		echo "<label value='".$items["value"]."' selected>".$items["nombre"]."</label>";
	    }
	    else
		{
		    echo "<label value='".$items["value"]."'>".$items["nombre"]."</label>";
		}
	}
    }
    
    function select_bienes($param)
    {

	$oconns = new database();
	$dats = $oconns->getRows("select * from fact_bienes order by value;");
	
	foreach ($dats as $items)
	{
	    if ($param==$items["value"])
	    {
		echo "<label value='".$items["value"]."' selected>".$items["nombre"]."</label>";
	    }
	    else
		{
		    echo "<label value='".$items["value"]."'>".$items["nombre"]."</label>";
		}
	}
    }
    
    function select_comp_ingreso($param)
    {

	$oconns = new database();
	$dats = $oconns->getRows("select * from fact_comprobar_ingreso order by value;");
	
	foreach ($dats as $items)
	{
	    if ($param==$items["value"])
	    {
		echo "<label value='".$items["value"]."' selected>".$items["nombre"]."</label>";
	    }
	    else
		{
		    echo "<label value='".$items["value"]."'>".$items["nombre"]."</label>";
		}
	}
    }
    
    function select_tipo_vivienda($param)
    {

	$oconns = new database();
	$dats = $oconns->getRows("select * from tipo_vivienda order by value;");
	
	foreach ($dats as $items)
	{
	    if ($param==$items["value"])
	    {
		echo "<label value='".$items["value"]."' selected>".$items["nombre"]."</label>";
	    }
	    else
		{
		    echo "<label value='".$items["value"]."'>".$items["nombre"]."</label>";
		}
	}
    }
    
    function select_arraigo_dom($param)
    {

	$oconns = new database();
	$dats = $oconns->getRows("select * from fact_arraigo_dom order by value;");
	
	foreach ($dats as $items)
	{
	    if ($param==$items["value"])
	    {
		echo "<label value='".$items["value"]."' selected>".$items["nombre"]."</label>";
	    }
	    else
		{
		    echo "<label value='".$items["value"]."'>".$items["nombre"]."</label>";
		}
	}
    }
    
    function select_estatus($param)
    {

	$oconns = new database();
	$dats = $oconns->getRows("select * from creditos_estatus where idkey not in (5);");
	
	foreach ($dats as $items)
	{
	    if ($param==$items["idkey"])
	    {
		echo "<option value='".$items["idkey"]."' selected>".$items["nombre"]."</option>";
	    }
	    else
		{
		    echo "<option value='".$items["idkey"]."'>".$items["nombre"]."</option>";
		}
	}
    }
    
    ?>
    
  <?php 
  if ($_SERVER['REQUEST_METHOD'] === 'GET')
    {
        if (isset($_GET["module"]))
        {
            switch($_GET["module"])
            {
                
            }

        }
    }




?>
