<?php

    
    //familiares.php


	$nombre_f=$_POST["nombre_f"];
	$apellido_p_f=$_POST["apellido_p_f"];
	$apellido_m_f=$_POST["apellido_m_f"];
	$edad_f=$_POST["edad_f"];
	$sexo_f=$_POST["sexo_f"];
	$parentesco=$_POST["parentesco"];
	$domicilio_f=$_POST["domicilio_f"];
	$estados_f=$_POST["estados_f"];
	$municipios_f=$_POST["municipios_f"];
	$localidad_f=$_POST["localidad_f"];
	$codigo_postal_f=$_POST["codigo_postal_f"];
	$tipo_direccion=$_POST["tipo_direccion"];
	$ine_f=$_POST["ine_f"];
	$rfc_f=$_POST["rfc_f"];
	$telefono1_f=$_POST["telefono1_f"];
	$telefono2_f=$_POST["telefono2_f"];
	$telefono3_f=$_POST["telefono3_f"];
	$email_f=$_POST["email_f"];
	$cumulo = $_POST["cumulo"];



	if ($tipo_direccion=="1")
	{
		$domicilio_f="";
		$estados_f="";
		$municipios_f="";
		$localidad_f="";
		$codigo_postal_f="";
	}

	if (strlen($cumulo)>0)
	{
		$bigs = explode("/",$cumulo);

		$papa1=0;
		$mama1=0;
		$papa2=0;
		$mama2=0;
		$pare=0;
		$hijo=0;
		$herm=0;






		for($i=0;$i<count($bigs);$i++)
		{
			$temp = explode("|",$bigs[$i]);
			if ($temp[5]=="1") $papa1++;
			if ($temp[5]=="2") $mama1++;
			if ($temp[5]=="3") $papa2++;
			if ($temp[5]=="4") $mama2++;	
			if ($temp[5]=="6") $pare++;
		
		}




																										//5				6				7	
		$final=$cumulo."/".$nombre_f."|".$apellido_p_f."|".$apellido_m_f."|".$edad_f."|".$sexo_f."|".$parentesco."|".$domicilio_f."|".$estados_f."|".$municipios_f."|".$localidad_f."|".$codigo_postal_f."|".$tipo_direccion."|".$ine_f."|".$rfc_f."|".$telefono1_f."|".$telefono2_f."|".$telefono3_f."|".$email_f;




		if (($papa1>1)&&($parentesco=="1")) $final="E1"."!".$cumulo;
		if (($mama1>1)&&($parentesco=="2")) $final="E2"."!".$cumulo;
		if (($papa2>1)&&($parentesco=="3")) $final="E3"."!".$cumulo;
		if (($mama1>1)&&($parentesco=="4")) $final="E4"."!".$cumulo;
		if (($pare>1)&&($parentesco=="5")) $final="E5"."!".$cumulo;
		

		$final = substr($final,0,strlen($final)-1);
		
		echo $final;


	}
	else
	{
		$cumulo = $nombre_f."|".$apellido_p_f."|".$apellido_m_f."|".$edad_f."|".$sexo_f."|".$parentesco."|".$domicilio_f."|".$estados_f."|".$municipios_f."|".$localidad_f."|".$codigo_postal_f."|".$tipo_direccion."|".$ine_f."|".$rfc_f."|".$telefono1_f."|".$telefono2_f."|".$telefono3_f."|".	$email_f."";
		echo $cumulo;
	}
	

  
    
?>