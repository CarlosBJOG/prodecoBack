<?php
		$oconns = new database(); 
		$param = $_GET["idkey_cliente"];
	 $oconns = new database(); 
	     $sec_general = $oconns->getRows("select *from view_clientes where idkey_cliente =".$param);
	     $sec_general1 = $oconns->getRows("select  concat('Calle: ',d.domicilio,' Int-',d.interior,' Ext-',d.exterior,' C.P: ', d.nombre_cp,' Municipio: ',d.nombre_mpio,' Estado: ',d.nombre_edo) as domicilio from view_direcciones d where idkey_cliente =".$param);
	    $laboral = $oconns->getRows("select TIMESTAMPDIFF(YEAR, ci.inicio, ci.fin) AS arraigo_laboral,ci.id_tipo_ingreso, it.nombre as tipo_ingreso from clientes_ingresos ci inner join ingresos_tipos it on it.idkey=".$param.";");
	    $comprobacion = $oconns->getRows("select * from clientes_ingresos where idkey_clientes=".$param.";");
	    $contar_mob = $oconns->getSimple("select count(idkey) from garantias_mueble where idkey_clientes=".$param.";");
	    $muebles = $oconns->getRows("select * from garantias_mueble where idkey_clientes=".$param.";");
	    $contar_inmu= $oconns->getSimple("select count(idkey) from garantias_inmueble where idkey_clientes=".$param.";");
	    $inmuebles = $oconns->getRows("select * from garantias_inmueble where idkey_clientes=".$param.";");
	    $contar_aval = $oconns->getRows("select count(idkey) from clientes_relaciones where idkey_relaciones=2 and idkey_clientes=".$param.";");
	    $avales = $oconns->getRows("select nombre,aval_hist,aval_capacidad,aval_solvencia from clientes_relaciones where idkey_relaciones=2 and idkey_clientes=".$param.";");
	?>


	<div class="card border-0 h-100 p-5">
				<h4 class="text-success-d1 text-150 px-3 px-lg-0">Registro Exitoso</h4>

				<!-- Datos generales -->
				<p class="font-bold text-dark">Identificador de Cliente:
				    <span class="text-95 text-grey font-normal"> <?php echo $param ?> </span>
				</p>
				<p class="font-bold text-dark">Fecha de Solicitud:
				    <span class="text-95 text-grey font-normal"> <?php echo date("Y-m-d"); ?> </span>
				</p>
						<!-- Datos generales del evaluado -->
				<div>
				    <p class="font-bold text-dark">
				    <label >Nombre:</label>
				    <span class="text-95 text-grey font-normal"><?php if(isset($sec_general[0]["nombre"])) echo $sec_general[0]["nombre"]; else echo "No se encontró"; ?></span>
				    </p>
				</div>
				<div>
				    <p class="font-bold text-dark">
				    <label>Fecha de Nacimiento: </label>
				    <span class="text-95 text-grey font-normal"><?php if(isset($sec_general[0]["fecha_nacimiento"])) echo $sec_general[0]["fecha_nacimiento"]; else echo "No se encontró"; ?></span></p>
				</div>
				<div>
				<p class="font-bold text-dark">
				    <label>RFC.: </label>
				    <span class="text-95 text-grey font-normal"><?php if(isset($sec_general[0]["rfc"])) echo $sec_general[0]["rfc"] ?></span></p>
				</div>
				<div>
				<p class="font-bold text-dark">
				    <label>CURP:</label>
				    <span class="text-95 text-grey font-normal"><?php if(isset($sec_general[0]["curp"])) echo $sec_general[0]["curp"]; else echo "No se encontró"; ?></span></p>
				</div>
				<div>
				    <p class="font-bold text-dark">
				    <label>Domiclio: </label>
				    <span class="text-95 text-grey font-normal">
					<?php if(isset($sec_general1[0]["domicilio"])) echo $sec_general1[0]["domicilio"]; else echo "No se encontró"; ?></span></p>
				</div>
			    
			    <!--fin Datos generales del evaluado -->
			    </div>
