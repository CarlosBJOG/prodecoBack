

<?php
	require_once "db.php";
	require_once "functions.php";
	
	//show_interface_cliente.php
	
	// Funciones agregadas By Moshe Ramz
	function form_nuevo_credito(){?>
	    <form>
		<div class="row m-4">
		    <div class="col-12 col-md-10">
			<div class="card-header border-0 bg-transparent">
			    <h2 class="text-success">Nuevo crédito</h2>            
			</div>
		    </div>
		    
		</div>
		<hr/>  
		 <div class="row col-md-12 col-lg-12 border-l-1 brc-secondary-l1 pl-8">
		     <div class="col-sm-12 col-md-6 col-lg-6">
			<p class="text-600 text-grey">
			<label for="tipo-producto">Tipo de producto</label>
			<select class="ace-select text-dark-m1 bgc-default-l5 bgc-h-warning-l3  brc-default-m3 brc-h-warning-m1" id="tipo_producto" name="tipo_producto">
			    <?php create_productos(); ?>
			</select>
			</p>
		    </div>
		    <div class="col-sm-12 col-md-6 col-lg-6">
			<p class="text-600 text-grey">
			<label >Monto de crédito</label>
			<input type="number" class="form-control" id="monto_credito" name="monto_credito" placeholder="$" onkeypress="return event.charCode >= 48" min="1"></p>
		    </div>

		    <div class="col-sm-12 col-md-6 col-lg-6">
			<p class="text-600 text-grey">
			<label >Plazo en meses</label>
			<input type="number" class="form-control" id="plazo_meses" name = "plazo_meses" placeholder="" onChange="calcPagos();" onkeypress="return event.charCode >= 48" min="1"></p>
		    </div>
		    <div class="col-sm-12 col-md-6 col-lg-6">
			<p class="text-600 text-grey">
			<label for="frecuencia-pago">Frecuencia de pago</label>
			<select class="ace-select text-dark-m1 bgc-default-l5 bgc-h-warning-l3  brc-default-m3 brc-h-warning-m1" name="frecuencia_pago" id="frecuencia_pago" onChange="calcPagos();">
			    <?php create_frecuencia(); ?>
			</select>
			</p>
		    </div>

		    <div class="col-sm-12 col-md-6 col-lg-6" >
			<p class="text-600 text-grey">
			<label>Número de pagos</label>
			<input type="number" class="form-control" id="numero_pagos" name="numero_pagos" readonly>
			<!--<input type="number" class="form-control" id="numero_pagos" placeholder=""></p>-->
		    </div>
		    <div class="col-sm-12 col-md-6 col-lg-6">
			<p class="text-600 text-grey">
			<label >Tasa de interés anual</label>
			<input type="number" class="form-control" id="tasa_interes" name="tasa_interes" placeholder="%" readonly></p>                
		    </div>

		    <div class="col-sm-12 col-md-6 col-lg-6">
			<label class="col-form-label form-control-label mt-0 text-600 text-grey">Fecha de primer pago<span style="color:red;">*</span></label>
			<div class="input-group date" id="id-timepicker">
			    <input type="text" class="form-control form-control-sm" id="fecha_pago1"  name="fecha_pago1" >
			    <div class="input-group-addon input-group-append">
				<div class="input-group-text">
				<i class="fa fa-calendar"></i>
				</div>
			    </div>
			</div>
		    </div>
		    <div class="col-sm-12 col-md-6 col-lg-6">
			<p class="text-600 text-grey">
			<label >Finalidad</label>
			<textarea class="form-control" rows="3" id="finalidad"></textarea></p>
		    </div>
		    <!--<div class="col-sm-12 col-md-4 col-lg-4">
			    <p class="text-600 text-grey">
			    <label for="fondeo">Fondeo</label>
			    <select class="ace-select text-dark-m1 bgc-default-l5 bgc-h-warning-l3  brc-default-m3 brc-h-warning-m1" id="fondeo">
				<?php create_fondeo(); ?>
			    </select>
			    </p>
			</div>
			<div class="col-sm-12 col-md-4 col-lg-4">
			    <p class="text-600 text-grey">
			    <label class="col-form-label form-control-label">Condiciones de pago</label>
			    <select class="ace-select text-dark-m1 bgc-default-l5 bgc-h-warning-l3  brc-default-m3 brc-h-warning-m1" id="condiciones">
				<?php create_condiciones_pago(); ?>
			    </select>
			</div>
		    </div>-->
		</div>
		<div class="row border-t-1 brc-grey-l1 py-3 justify-content-end">

		    <div class="col-sm-12 col-md-5 order-lg-last">
			<button class="btn btn-warning btn-sm" type="button" onclick="$.fn.crear_amortizacion();">
			    <i class="fa -plus"></i>
			    Amortización
			</button>
			<button class="btn btn-success" type="button" onclick="guardar_credito();">
			   <i class="fa fa-save mr-1"></i>
			   Guardar
			</button>
			<button class="btn btn-secondary btn-sm ml-3" type="reset">
			<i class="fa fa-undo mr-1"></i>
			Limpiar
			</button>
		    </div>
		</div>
	    </form>
	    <script src="./js/default.js"></script>
	    <script> $('#fecha_pago1').activeCalendary('#fecha_pago1'); </script>
	
	<?php } ?>
	<?php 
	// Generar amortizaciones
	function create_amortizacion($param1,$param2,$param3,$param4,$param5){
	$producto = $param1;
	$plazo = $param2;
	$monto = $param3;
	//$iva = $_POST["iva"];
	$iva = 1.16;
	$temp = explode('/', $param4);
	$fecha_inicio = $temp[2].'-'.$temp[1].'-'.$temp[0];
	$frecuencia = $param5;
	
	require '../php/MyPaydateCalculator.php';
	
	function truncate($val, $f="0")
	    {
		if(($p = strpos($val, '.')) !== false) {
		    $val = floatval(substr($val, 0, $p + 1 + $f));
		}
		return $val;
	    }

	
	
	$semanales=array(3,4);
	//Credi-Negocio
	if($producto==1){
		if($frecuencia==1){
			$frecStr='WEEKLY';
			if($plazo >= 16 && $plazo <=52){
				$interes=0.01407466667;
				}
		elseif($plazo >= 53 && $plazo <=154) {
				$interes=0.014616;
				}
			}
	elseif($frecuencia==2){
		$frecStr='BIWEEKLY';
		if($plazo >= 8 && $plazo <=24){
			$interes=0.03248;
			}
		elseif($plazo >= 25 && $plazo <=72) {
				$interes=0.03364;
				}
		}
	elseif($frecuencia==3){
		$frecStr='MONTHLY';
		if($plazo >= 4 && $plazo <=12){
			$interes=0.0696;
			}
		elseif($plazo >= 13 && $plazo <=36) {
				$interes=0.07192;
				}
			}
		}
	//Credi-nómina consumo
	elseif($producto==6){
		if($frecuencia==1){
			$frecStr='WEEKLY';
			$interes=0.002954777777778;
			}
		elseif($frecuencia==2){
			$frecStr='BIWEEKLY';
			$interes=0.006331666666667;
			}
		else{
			$frecStr='MONTHLY';
			$interes=0.012663333333333;
			}
		}
	// Credi-grupo / Micro-grup
	elseif(in_array($producto,$semanales)){
		$frecStr='WEEKLY';
		$interes=0.01645653333;
		}
	//Credi-Nómina Moto
	elseif($producto==7){
		if($frecuencia==1){
			$frecStr='WEEKLY';
			$interes=0.002954777777778;
			}
		elseif($frecuencia==2){
			$frecStr='BIWEEKLY';
			$interes=0.006331666666667;
			}
		elseif($frecuencia==3){
			$frecStr='MONTHLY';
			$interes=0.012663333333333;
			}
		}
	
	
	/*echo "interes=".$interes."<br>";
	echo "plazo=".$plazo."<br>";
	echo "monto=".$monto."<br>";
	echo "iva=".$iva."<br>";
	echo "Fecha inicio=".$fecha_inicio."<br>";
	echo "Frecuencia=".$frecStr."<br>";*/
	?>
	<hr>
	<table class="table brc-grey-l3 table-striped mb-2" border="1">
		<thead>
			<tr>
				<th>Pago</th>
				<th>Fecha de Pago</th>
				<th>Inteses</th>
				<th>iva</th>
				<th>Capital</th>
				<th>Total</th>
				<th>Saldo insoluto</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td colspan="6"></td>
				<td><?php echo $monto ?></td>
			</tr>
	<?php
		
	for ($z=1; $z<=$plazo; $z++)
	{

		$campoa = ($interes*1.0)*$monto/1.16; // Interés "I"
		$campoa1 =round($campoa,2);
		$campob= $campoa*0.16; // Ivan del Interés
		$campob1 =round($campob,2);

		$campoc=$monto*($interes/(1-pow(1+$interes,($plazo*-1)+($z-1))))-$campoa*1.16; //$z = no_pago actual
		$campoc1 =round($campoc,2);		

		$campod=$campoa+$campob+$campoc;
		$campod1 =round($campod,2);		
		$campoe=$monto-$campoc;
		$campoe1 =abs (round($campoe,2));
		$monto=$monto-$campoc;			
		
		$calc = new MyPaydateCalculator();

		$paydateModel = $frecStr; // Replace this value to any of these MONTHLY, BIWEEKLY, WEEKLY
		$paydateOne = $fecha_inicio; // If today is weekend or a holiday, please define date manually for a week day for testing. ie; '2016-07-05'
		$numberOfPaydates = $plazo; // number of pay dates
		
		$PayDates = $calc->calculateNextPaydates($paydateModel, $paydateOne, $numberOfPaydates);
		//print_r($PayDates);

	?>
		<tr>
			<td><?php echo $z." / ".$plazo; ?></td>
			<td><?php echo date("Y-m-d",strtotime($PayDates[$z]." -  14 days")); ;?></td>
			<td><?php echo $campoa1; ?></td>
			<td><?php echo $campob1; ?></td>
			<td><?php echo $campoc1; ?></td>
			<td><?php echo $campod1; ?></td>
			<td><?php echo $campoe1; ?></td>
		</tr>
		<?php }	?>
		</tbody>
	</table>	    	    
	    <?php }
	
	function main_factores($param)
	{ ?>
	      <hr>
	      <div>
		<button onclick="$.fn.generar_factores();" class="btn btn-success  radius-1 border-b-2 d-inline-flex align-items-center pl-2px py-2px btn-bold">
		   <span class="bgc-white-tp9 shadow-sm radius-2px h-4 px-25 pt-1 mr-25 border-1">
		    <i class="fa fa-check text-white-tp2 text-110 mt-3px"></i>
		   </span>
		   Obtener Factores
		</button>
	      </div>
	<?php } ?>
	
	<?php function main_reporte($param)
	{ ?>
	      <hr>
	      <div>
		<button onclick="$.fn.generar_reporte();" class="btn btn-success  radius-1 border-b-2 d-inline-flex align-items-center pl-2px py-2px btn-bold">
		   <span class="bgc-white-tp9 shadow-sm radius-2px h-4 px-25 pt-1 mr-25 border-1">
		    <i class="fa fa-check text-white-tp2 text-110 mt-3px"></i>
		   </span>
		   Generar Reporte
		</button>
	      </div>
	<?php } ?>
	
	<?php function create_reporte($param)
	{
	    $oconns = new database(); 
	     $sec_general = $oconns->getRows("select *from view_clientes where idkey_cliente =".$param);
	    $sec_general1 = $oconns->getRows("select c.idkey,c.fecha_creacion,concat(g.nombre,' ',g.apellido_p,' ', g.apellido_m) as nombre,g.rfc,g.fecha_nacimiento,TIMESTAMPDIFF(YEAR, g.fecha_nacimiento, CURDATE()) AS edad,g.curp,identificacion.nombre as identif, ci.numero,ci.vigencia,concat(d.domicilio,' Int-',d.interior,' Ext-',d.exterior,' C.P: ', cp.nombre) as domicilio,TIMESTAMPDIFF(YEAR, d.fecha_habita, CURDATE()) AS arraigo_domiciliario, concat('Estado: ', e.nombre,' Ciudad/Alcaldía: ', m.nombre, l.nombre ) as domicilio2 from clientes c inner join generales g on c.idkey_generales = g.idkey inner join clientes_identificaciones ci on c.idkey = ci.idkey_clientes inner join identificacion on identificacion.idkey = ci.idkey_identificacion inner join direcciones d on d.idkey = g.idkey_direcciones inner join codigo_postal cp on cp.idkey = d.idkey_codigo_postal inner join estados e on e.idkey = d.idkey_estados inner join municipios m on m.idkey = d.idkey_municipios inner join localidad l on l.idkey = d.idkey_localidad where c.idkey=".$param.";");
	    $laboral = $oconns->getRows("select TIMESTAMPDIFF(YEAR, ci.inicio, ci.fin) AS arraigo_laboral,ci.id_tipo_ingreso, it.nombre as tipo_ingreso from clientes_ingresos ci inner join ingresos_tipos it on it.idkey=".$param.";");
	    $comprobacion = $oconns->getRows("select * from clientes_ingresos where idkey_clientes=".$param.";");
	    $contar_mob = $oconns->getSimple("select count(idkey) from garantias_mueble where idkey_clientes=".$param.";");
	    $muebles = $oconns->getRows("select * from garantias_mueble where idkey_clientes=".$param.";");
	    $contar_inmu= $oconns->getSimple("select count(idkey) from garantias_inmueble where idkey_clientes=".$param.";");
	    $inmuebles = $oconns->getRows("select * from garantias_inmueble where idkey_clientes=".$param.";");
	    $contar_aval = $oconns->getRows("select count(idkey) from clientes_relaciones where idkey_relaciones=2 and idkey_clientes=".$param.";");
	    $avales = $oconns->getRows("select nombre,aval_hist,aval_capacidad,aval_solvencia from clientes_relaciones where idkey_relaciones=2 and idkey_clientes=".$param.";");
	?>
	<!-- Display reporte completo -->
	<div id="info_generales">    
	    <!-- Semaforo cumplimiento -->
	    <div class="row justify-content-md-center">
		<div class="col-lg-12 col-12 pr-lg-0 mt-3 mt-lg-0 p-3">
		    <div class="h-100 bg-white pt-0 radius-1 shadow-sm mx-auto">
			<div class="border-t-3 w-100 brc-success-tp2 radius-t-2"></div>
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
					<?php if(isset($sec_general[0]["domicilio"])) echo $sec_general[0]["domicilio"].' '.$sec_general[0]["domicilio2"]; else echo "No se encontró"; ?></span></p>
				</div>
			    
			    <!--fin Datos generales del evaluado -->
			    </div>

			    
	</div>
	<?php
	 } ?>
	 
		<?php function create_factores($param)
	{
	    $oconns = new database();   
	    /*$sec_general = $oconns->getRows("select c.idkey,c.fecha_creacion,concat(g.nombre,' ',g.apellido_p,' ', g.apellido_m) as nombre,g.rfc,g.fecha_nacimiento,TIMESTAMPDIFF(YEAR, g.fecha_nacimiento, CURDATE()) AS edad,g.curp,identificacion.nombre as identif, ci.numero,ci.vigencia,concat(d.domicilio,' Int-',d.interior,' Ext-',d.exterior,' C.P: ', cp.nombre) as domicilio,TIMESTAMPDIFF(YEAR, d.fecha_habita, CURDATE()) AS arraigo_domiciliario, concat('Estado: ', e.nombre,' Ciudad/Alcaldía: ', m.nombre, l.nombre ) as domicilio2 from clientes c inner join generales g on c.idkey_generales = g.idkey inner join clientes_identificaciones ci on c.idkey = ci.idkey_clientes inner join identificacion on identificacion.idkey = ci.idkey_identificacion inner join direcciones d on d.idkey = g.idkey_direcciones inner join codigo_postal cp on cp.idkey = d.idkey_codigo_postal inner join estados e on e.idkey = d.idkey_estados inner join municipios m on m.idkey = d.idkey_municipios inner join localidad l on l.idkey = d.idkey_localidad where c.idkey=".$param.";");*/
	    $sec_general = $oconns->getRows("select vc.idkey_cliente as idkey, vc.fecha_creacion, vc.nombre, vc.rfc,vc.fecha_nacimiento, vc.edad, vc.curp,vc.nombre_identificacion as identif,vc.no_identificacion as numero, vc.vigencia_identificacion as vigencia, concat(vd.domicilio,' Int-',vd.interior,' Ext-',vd.exterior,' C.P: ', vd.nombre_cp) as domicilio, TIMESTAMPDIFF(YEAR, vd.fecha_habita, CURDATE()) AS arraigo_domiciliario, concat('Estado: ', vd.nombre_edo,' Ciudad/Alcaldía: ', vd.nombre_mpio,vd.nombre_loc ) as domicilio2  from view_clientes vc inner join view_direcciones vd on (vc.idkey_cliente=vd.idkey_cliente) where vd.prioridad = 1 and vd.idkey_cliente=".$param.";");
	    $laboral = $oconns->getRows("select TIMESTAMPDIFF(YEAR, ci.inicio, ci.fin) AS arraigo_laboral,ci.id_tipo_ingreso, it.nombre as tipo_ingreso from clientes_ingresos ci inner join ingresos_tipos it on it.idkey=ci.id_tipo_ingreso where idkey_clientes=".$param.";");
	    $nlaboral =  $oconns->numberRows;

	    $comprobacion = $oconns->getRows("select * from clientes_ingresos where idkey_clientes=".$param.";");
	    $contar_mob = $oconns->getSimple("select count(idkey) from garantias_mueble where idkey_clientes=".$param.";");
	    $muebles = $oconns->getRows("select * from garantias_mueble where idkey_clientes=".$param.";");
	    $contar_inmu= $oconns->getSimple("select count(idkey) from garantias_inmueble where idkey_clientes=".$param.";");
	    $inmuebles = $oconns->getRows("select * from garantias_inmueble where idkey_clientes=".$param.";");
	    $contar_aval = $oconns->getRows("select count(idkey) from clientes_relaciones where idkey_relaciones=2 and idkey_clientes=".$param.";");
	    $avales = $oconns->getRows("select idkey,nombre,aval_hist,aval_capacidad,aval_solvencia from clientes_relaciones where idkey_relaciones=2 and idkey_clientes=".$param.";");
	    $vivienda = $oconns->getRows("select cse.idkey_tipo_vivienda,tv.nombre as tipo_vivienda from clientes_socio_economico cse inner join tipo_vivienda tv on tv.idkey=cse.idkey_tipo_vivienda where idkey_clientes=".$param.";");
	    //echo "select c.idkey,c.fecha_creacion,concat(g.nombre,' ',g.apellido_p,' ', g.apellido_m) as nombre,g.rfc,g.fecha_nacimiento,TIMESTAMPDIFF(YEAR, g.fecha_nacimiento, CURDATE()) AS edad,g.curp,identificacion.nombre as identif, ci.numero,ci.vigencia,concat(d.domicilio,' Int-',d.interior,' Ext-',d.exterior,' C.P: ', cp.nombre) as domicilio,TIMESTAMPDIFF(YEAR, d.fecha_habita, CURDATE()) AS arraigo_domiciliario, concat('Estado: ', e.nombre,' Ciudad/Alcaldía: ', m.nombre, l.nombre ) as domicilio2 from clientes c inner join generales g on c.idkey_generales = g.idkey inner join clientes_identificaciones ci on c.idkey = ci.idkey_clientes inner join identificacion on identificacion.idkey = ci.idkey_identificacion inner join direcciones d on d.idkey = g.idkey_direcciones inner join codigo_postal cp on cp.idkey = d.idkey_codigo_postal inner join estados e on e.idkey = d.idkey_estados inner join municipios m on m.idkey = d.idkey_municipios inner join localidad l on l.idkey = d.idkey_localidad where c.idkey=".$param.";";
	?>
	<!-- Display reporte completo -->
	<!--<div id="info_generales"> -->
	    <!-- Semaforo cumplimiento -->
	    <div class="row justify-content-md-center">
		<div class="col-lg-12 col-12 pr-lg-0 mt-3 mt-lg-0 p-3">
		    <div class="h-100 bg-white pt-0 radius-1 shadow-sm mx-auto">
			<div class="border-t-3 w-100 brc-success-tp2 radius-t-2"></div>
			    

			    <div class="card-body p-3 px-sm-1 px-lg-0 brc-default-l2">
				<table class="table brc-grey-l3 table-striped mb-2">
				    <thead>
					<th>Característica</th>
					<th>Descripción</th>
					<th>Calificación</th>
				    </thead>
				    <tbody>
					<tr>
					    <td>Referencias</td>
					    <td>
						<select id="referencias" class="ace-select text-dark-m1 bgc-default-l5 bgc-h-warning-l3  brc-default-m3 brc-h-warning-m1">
						    <option value="" selected>Seleccione ...</option>
						    <option value="10">Buenas</option>
						    <option value="0">Malas</option>
						</select>
					    </td>
					    <td><span class="badge btn-default badge-lg arrowed ml-n1">Sin coincidencias</span></td>
					</tr>
					<tr>
					    <td>Veracidad</td>
					    <td>
						<select id="veracidad" class="ace-select text-dark-m1 bgc-default-l5 bgc-h-warning-l3  brc-default-m3 brc-h-warning-m1">
						    <option value="">Seleccione ...</option>
						    <option value="10"> Información consistente </option>
						    <option value="0">Información inconsistente </option>
						</select>
					    </td>
					    <td><span class="badge btn-default badge-lg arrowed ml-n1">Sin coincidencias</span></td>
					</tr>
					<tr>
					    <td>Garantia Liquida</td>
					    <td>
						<select id="garantia_liquida" class="ace-select text-dark-m1 bgc-default-l5 bgc-h-warning-l3  brc-default-m3 brc-h-warning-m1">
						    <option value="">Seleccione ...</option>
						    <option value="10">Necesaria</option>
						    <option value="5">Mayor</option>
						</select>
					    </td>
					    <td><span class="badge btn-default badge-lg arrowed ml-n1">Sin coincidencias</span></td>
					</tr>
					<tr>
					    <td>Conocimiento de la actividad</td>
					    <td>
						<select id="conocimiento" class="ace-select text-dark-m1 bgc-default-l5 bgc-h-warning-l3  brc-default-m3 brc-h-warning-m1">
						    <option value="">Seleccione ...</option>
						    <option value="10">Avanzado</option>
						    <option value="5">Básico</option>
						    <option value="0">Núlo</option>
						</select>
					    </td>
					    <td><span class="badge btn-default badge-lg arrowed ml-n1">Sin coincidencias</span></td>
					</tr>
					<tr>
					    <td>Capacidad de Pago</td>
					    <td>
						<select id="capacidad_pago" class="ace-select text-dark-m1 bgc-default-l5 bgc-h-warning-l3  brc-default-m3 brc-h-warning-m1">
						    <option value="">Seleccione ...</option>
						    <option value="80">Excelente</option>
						    <option value="60">Buena</option>
						    <option value="40">Regular</option>
						    <option value="20">Mala </option>
						</select>
					    </td>
					    <td><span class="badge btn-default badge-lg arrowed ml-n1">Sin coincidencias</span></td>
					</tr>
					<tr>
					    <td>Solvencia</td>
					    <td>
						<select id="solvencia" class="ace-select text-dark-m1 bgc-default-l5 bgc-h-warning-l3  brc-default-m3 brc-h-warning-m1">
						    <option value="">Seleccione ...</option>
						    <option value="5">Buena</option>
						    <option value="3">Mala </option>
						    <option value="0">Regular</option>
						</select>
					    </td>
					    <td><span class="badge btn-default badge-lg arrowed ml-n1">Sin coincidencias</span></td>
					</tr>
					<tr>
					    <td>Experiencia Crediticia</td>
					    <td>
						 <select id="experiencia_crediticia" class="ace-select text-dark-m1 bgc-default-l5 bgc-h-warning-l3  brc-default-m3 brc-h-warning-m1">
						    <option value="">Seleccione ...</option>
						    <option value="20">Igual a 12 meses o mayor             </option>
						    <option value="15">Menor a 12 meses </option>
						    <option value="10">Sin antecedentes</option>
						</select>
					    </td>
					    <td><span class="badge btn-default badge-lg arrowed ml-n1">Sin coincidencias</span></td>
					</tr>
					<tr>
					    <td>Hisotrial interno</td>
					    <td>
						<select id="historial_interno" class="ace-select text-dark-m1 bgc-default-l5 bgc-h-warning-l3  brc-default-m3 brc-h-warning-m1">
						    <option value="">Seleccione ...</option>
						    <option value="50"> 1 - 30 días mora </option>
						    <option value="30"> 31 - 60 días mora </option>
						    <option value="25"> 61 - 90 días mora </option>
						    <option value="15"> 91 - 120 días mora</option>
						    <option value="5"> 121 - 180 días mora</option>
						    <option value="0"> 180 o mas días mora</option>
						    <option value="30"> Sin Historial</option>
						</select>
					    </td>
					    <td><span class="badge btn-default badge-lg arrowed ml-n1">Sin coincidencias</span></td>
					</tr>
					<tr>
					    <td>Buró de crédito</td>
					    <td>
						<select id="historial_buro" class="ace-select text-dark-m1 bgc-default-l5 bgc-h-warning-l3  brc-default-m3 brc-h-warning-m1">
						    <option value="">Seleccione ...</option>
						    <option value="30"> MOP 1-2</option>
						    <option value="25"> MOP 3-4 </option>
						    <option value="15"> MOP 5-6-7 </option>
						    <option value="5">  MOP  9 - 96 - 97 </option>
						</select>
					    </td>
					    <td><span class="badge btn-default badge-lg arrowed ml-n1">Sin coincidencias</span></td>
					</tr>
					<tr>
					    <td>Bienes declarados</td>
					    <td>
						<select id="bienes_declarados" class="ace-select text-dark-m1 bgc-default-l5 bgc-h-warning-l3  brc-default-m3 brc-h-warning-m1">
						    <option value="">Seleccione ...</option>
						    <option value="5">Con Escritura</option>
						    <option value="0">Sín Escritura</option>
						</select>
					    </td>
					    <td><span class="badge btn-default badge-lg arrowed ml-n1">Sin coincidencias</span></td>
					</tr>
					<?php
					if ($contar_mob > 0)
					    {
						foreach($muebles as $mueble){ 
						    ?><tr>
							<td>Mobiliaria</td>
							<?php if ($mueble["cobertura"]==5) {?>
							<td ><input readonly id="cobertura" value="<?php echo $mueble["cobertura"];?>"></td>
							<td>Menor al 100%</td>
							<td><span class="badge btn-danger badge-lg arrowed ml-n1">Inaceptable</span></td>
							<?php } ?>
							<?php if ($mueble["cobertura"]==8) {?>
							<td><input readonly id="cobertura" value="<?php echo $mueble["cobertura"];?>"></td>
							<td>Igual al 100%</td>
							<td><span class="badge btn-yellow badge-lg arrowed ml-n1">Aceptable</span></td>
							<?php } ?>
							<?php if ($mueble["cobertura"]==10) {?>
							<td ><input readonly id="cobertura" value="<?php echo $mueble["cobertura"];?>"></td>
							<td>Mayor al 100%</td>
							<td><span class="badge btn-success badge-lg arrowed ml-n1">Excelente</span></td>
							<?php } ?>
						    </tr>
						<?php 
						}
					    }
					
					if ($contar_inmu > 0)
					    {
						foreach($inmuebles as $inmue){ 
						    ?><tr>
							<td>Hipotecaria</td>
							<td ><input readonly id="hipotecaria" value="<?php echo $inmue["aforo"];?>"></td>
							<?php if ($inmue["aforo"]==0) {?>
							<td>Inviable</td>
							<td><span class="badge btn-brown badge-lg arrowed ml-n1">No recomendable</span></td>
							<?php } ?>
							<?php if ($inmue["aforo"]==5) {?>
							<td>Aforo menor</td>
							<td><span class="badge btn-yellow badge-lg arrowed ml-n1">Aceptable</span></td>
							<?php } ?>
							<?php if ($inmue["aforo"]==10) {?>
							<td>Aforo 1 a 1 / Aforo 2 a 1</td>
							<td><span class="badge btn-success badge-lg arrowed ml-n1">Excelente</span></td>
							<?php } ?>
							<!--<td><span class="badge btn-secondary badge-lg arrowed ml-n1">Sin registro</span></td>-->
						    </tr>
						<?php 
						}
					    }
					?>
					<tr >
					    <td >Edad</td>
					    <?php 
					    $edad = $sec_general[0]["edad"];
					    if ($edad  > 26 && $edad < 50){
						?>
					    <td><input  readonly id="edad" value="<?php echo $edad;?>"></td>
					    <td><?php echo $edad.' Años' ?></td>
					    <td><span class="badge btn-success badge-lg arrowed ml-n1">Excelente</span></td>
					    <?php }
					    elseif ($edad  > 51 && $edad < 69){
						?>
					    <td ><input readonly id="edad" value="<?php echo $edad;?>"></td>
					    <td><?php echo $edad.' Años' ?></td>
					    <td><span class="badge btn-warning badge-lg arrowed ml-n1">Bueno</span></td>
					    <?php }
					    elseif ($edad  > 18 && $edad < 25){
						?>
					    <td ><input readonly id="edad" value="<?php echo $edad;?>"></td>
					    <td><?php echo $edad.' Años' ?></td>
					    <td><span class="badge btn-warning badge-lg arrowed ml-n1">Bueno</span></td>
					    <?php }
					    elseif($edad  > 18 && $edad < 25){
						?>
					    <td ><input readonly id="edad" value="<?php echo $edad;?>"></td>
					    <td><span class="badge btn-brown badge-lg arrowed ml-n1">No recomendable</span></td>
					    <?php } ?>
					</tr>
					
					    <?php 
					    if($nlaboral>0){
					    $valor_10 = array(1,2,3);
					    $x = $laboral[0]["id_tipo_ingreso"];
					    $tipo = $laboral[0]["tipo_ingreso"];
					    if(in_array($x, $valor_10))
						{ 
						    foreach ($laboral as $lab){?>
						    <tr>
							<td>Ocupación</td>
							<td><input readonly id="ocupacion" value="10"></td>
							<td><?php echo $lab["tipo_ingreso"]; ?></td>
							<td><span class="badge btn-success badge-lg arrowed ml-n1">Excelente</span></td>
						    </tr>
						 <?php }
						 }
					    else
						{ ?>
						<tr>
						    <td>Ocupación</td>
						    <td hidden><input readonly id="ocupacion" value="0"></td>
						    <td><?php echo $lab["tipo_ingreso"]; ?></td>
						    <td><span class="badge btn-brown badge-lg arrowed ml-n1">No recomendable</span></td>
						</tr>
						  
						  
					    <?php } 
					    }  ?>
					
					<tr hidden>
					    <td>Arraigo Laboral</td>
					    <?php
					    $edad_laboral = $laboral[0]["arraigo_laboral"];
					    if ($edad_laboral < 1 ){
					    ?>
					    <td hidden><input readonly id="arraigo_laboral" value="5"></td>				    
					    <td><?php echo $edad_laboral.' Año(s)'; ?></td>
					    <td><span class="badge btn-brown badge-lg arrowed ml-n1">No recomendable</span></td>
					    <?php } 
					    elseif ($edad_laboral >= 1 && $edad_laboral < 3 ){
					    ?>   	
					    <td hidden><input readonly id="arraigo_laboral" value="10"></td>
					    <td><?php echo $edad_laboral.' Año(s)'; ?></td>
					    <td><span class="badge btn-yellow badge-lg arrowed ml-n1">Aceptable</span></td>
					    <?php }
					    elseif ($edad_laboral >= 3 && $edad_laboral < 5 ){
					    ?>   
					    <td hidden><input readonly id="arraigo_laboral" value="15"></td>				    				    
					    <td><?php echo $edad_laboral.' Año(s)'; ?></td>
					    <td><span class="badge btn-warning badge-lg arrowed ml-n1">Bueno</span></td>
					    <?php }
					    elseif ($edad_laboral >= 5 ){
					    ?>   
					    <td hidden><input readonly id="arraigo_laboral" value="20"></td>				    				    
					    <td><?php echo $edad_laboral.' Año(s)'; ?></td>
					    <td><span class="badge btn-success badge-lg arrowed ml-n1">Excelente</span></td>
					    <?php }?>
					</tr>
					<tr hidden>
					    <td>Arraigo domiciliario</td>
					    <?php
					    $edad_vivienda = $sec_general[0]["arraigo_domiciliario"];
					    if ($edad_vivienda < 1 ){
					    ?>   				    
					    <td hidden><input readonly id="arraigo_domiciliario" value="5"></td>
					    <td><?php echo $edad_vivienda.' Año(s)'; ?></td>
					    <td><span class="badge btn-brown badge-lg arrowed ml-n1">No recomendable</span></td>
					    <?php } 
					    elseif ($edad_vivienda >= 1 && $edad_vivienda < 3 ){
					    ?>   
					    <td hidden><input readonly id="arraigo_domiciliario" value="8"></td>				    
					    <td><?php echo $edad_vivienda.' Año(s)'; ?></td>
					    <td><span class="badge btn-yellow badge-lg arrowed ml-n1">Aceptable</span></td>
					    <?php }
					    elseif ($edad_vivienda >= 4 ){
					    ?>   
					    <td hidden><input readonly id="arraigo_domiciliario" value="10"></td>
					    <td><?php echo $edad_vivienda.' Año(s)'; ?></td>
					    <td><span class="badge btn-success badge-lg arrowed ml-n1">Excelente</span></td>
					    <?php }
					    elseif ($edad_vivienda == 0 ){
					    ?>   
					    <td hidden><input readonly id="arraigo_domiciliario" value="2"></td>
					    <td><?php echo $edad_vivienda.' Año(s)'; ?></td>
					    <td><span class="badge btn-danger badge-lg arrowed ml-n1">Inaceptable</span></td>
					    <?php }?>
					</tr>
					<tr hidden>
					    <?php if ($vivienda[0]["idkey_tipo_vivienda"]==2){ ?>
					    <td>Tipo vivienda</td>
					    <td hidden><input readonly id="tipo_vivienda" value="20"></td>
					    <td><?php echo $vivienda[0]["tipo_vivienda"]; ?></td>
					    <td><span class="badge btn-success badge-lg arrowed ml-n1">Excelente</span></td>
					    <?php } ?>
					    <?php if ($vivienda[0]["idkey_tipo_vivienda"]==3){ ?>
					    <td>Tipo vivienda</td>
					    <td hidden><input readonly id="tipo_vivienda" value="15"></td>
					    <td><?php echo $vivienda[0]["tipo_vivienda"]; ?></td>
					    <td><span class="badge btn-warning badge-lg arrowed ml-n1">Bueno</span></td>
					    <?php } ?>
					    <?php if ($vivienda[0]["idkey_tipo_vivienda"]==1){ ?>
					    <td>Tipo vivienda</td>
					    <td hidden><input readonly id="tipo_vivienda" value="10"></td>
					    <td><?php echo $vivienda[0]["tipo_vivienda"]; ?></td>
					    <td><span class="badge btn-yellow badge-lg arrowed ml-n1">Aceptable</span></td>
					    <?php } ?>
					    <?php if ($vivienda[0]["idkey_tipo_vivienda"]==5){ ?>
					    <td>Tipo vivienda</td>
					    <td hidden><input readonly id="tipo_vivienda" value="5"></td>
					    <td><?php echo $vivienda[0]["tipo_vivienda"]; ?></td>
					    <td><span class="badge btn-brown badge-lg arrowed ml-n1">No recomendable</span></td>
					    <?php } ?>
					</tr>
					
					<?php foreach($comprobacion as $comprobante){  ?>
					<tr hidden>
					    <td>Comprobación de Ingresos</td>
					    <td hidden><input readonly id="comprobante" value="<?php echo $comprobante["comprobacion"]; ?>"></td>
					    <?php if ($comprobante["comprobacion"] == 20){ ?>
						    <td>Total</td>
						    <td><span class="badge btn-success badge-lg arrowed ml-n1">Excelente</span></td>
						<?php } elseif ($comprobante["comprobacion"]==15){ ?>
						    <td>Parcial</td>
						    <td><span class="badge btn-yellow badge-lg arrowed ml-n1">Aceptable</span></td>
						<?php } elseif (($comprobante["comprobacion"]==5)){ ?>
						    <td>No comprobable</td>
						    <td><span class="badge btn-brown badge-lg arrowed ml-n1">No recomendable</span></td>
						<?php } ?>
					</tr>
					<?php } ?>
				    </tbody>
				</table>
				<div class="col-md-3 order-lg-last">
                
				    <button class="btn btn-success" type="button" onclick="guardar_factores();">
					<i class="fa fa-save mr-1"></i>
					Guardar
				    </button>
				    <button class="btn btn-warning" type="button" onclick="$.fn.factores_cancel();">
					<i class="fa fa-save mr-1"></i>
					Recargar
				    </button>
				</div>
			    </div> <!-- / card-body -->
			</div> <!-- / card border-0 -->
		    </div><!-- / h-100 bg-white -->
		</div> <!-- Col-lg-8 -->
	    </div> <!-- / row -->
	    <!-- fin semaforo cumplimieto -->
	<!--</div>-->
	
	<?php } ?>
	 
	<?php function create_avales($param){
	    $oconns = new database();   
	    $contar_aval = $oconns->getRows("select count(idkey) from clientes_relaciones where idkey_relaciones=2 and idkey_clientes=".$param.";");
	    $avales = $oconns->getRows("select idkey,nombre,aval_hist,aval_capacidad,aval_solvencia from clientes_relaciones where idkey_relaciones=2 and idkey_clientes=".$param.";");
	     if ($contar_aval > 0){?>
	    <table class="table brc-grey-l3 table-striped mb-2">
		<thead>
		    <tr>
			<th colspan="4" class="text-center">Información de Avales</th>
		    </tr>
		    <tr>	
			<th>Nombre</th>
			<th>Historial Crediticio</th>
			<th>Capacidad de Pago</th>
			<th>Solvencia</th>
		    </tr>
		</thead>
		<tbody>
		    <?php
		    
			    foreach($avales as $aval){ 
			    ?>
			    <tr>
				<input hidden value="<?php echo $aval["idkey"]; ?>" id="idkey_aval"/>
				<td><?php echo $aval["nombre"];?></td>
				<?php if ($aval["aval_hist"]==30){ ?>
				<td><span class="badge btn-success badge-lg arrowed ml-n1">Excelente</span></td>
				<?php } 
				 if ($aval["aval_hist"]==25){ ?>
				<td><span class="badge btn-warning badge-lg arrowed ml-n1">Bueno</span></td>
				<?php } 
				if ($aval["aval_hist"]==15){ ?>
				<td><span class="badge btn-yellow badge-lg arrowed ml-n1">Aceptable</span></td>
				<?php } 
				if ($aval["aval_hist"]==5){ ?>
				<td><span class="badge btn-brown badge-lg arrowed ml-n1">No recomendable</span></td>
				<?php } 
				if ($aval["aval_hist"]==0){ ?>
				
				<?php } 
				////Capacidad de pago del aval
				if ($aval["aval_capacidad"]==80){ ?>
				<td><span class="badge btn-success badge-lg arrowed ml-n1">Excelente</span></td>
				<?php } 
				 if ($aval["aval_capacidad"]==60){ ?>
				<td><span class="badge btn-warning badge-lg arrowed ml-n1">Bueno</span></td>
				<?php } 
				if ($aval["aval_capcidad"]==40){ ?>
				<td><span class="badge btn-yellow badge-lg arrowed ml-n1">Aceptable</span></td>
				<?php } 
				if ($aval["aval_capacidad"]==20){ ?>
				<td><span class="badge btn-brown badge-lg arrowed ml-n1">No recomendable</span></td>
				<?php } 
				///Solvencia
				if ($aval["aval_solvencia"]==5){ ?>
				<td><span class="badge btn-warning badge-lg arrowed ml-n1">Bueno</span></td>
				<?php } 
				if ($aval["aval_solvencia"]==3){ ?>
				<td><span class="badge btn-yellow badge-lg arrowed ml-n1">Aceptable</span></td>
				<?php } 
				if ($aval["aval_solvencia"]==0){ ?>
				<td><span class="badge btn-danger badge-lg arrowed ml-n1">Inaceptable</span></td>
				<?php } ?>
				
				
			</tr>    
			    <?php 
			    }
			?>
		</tbody>
	    </table>
	    
	    <?php } else {?>
		<div id="div_relaciones"></div>
		<script>$('#div_relaciones').load("../php/show_interface_cliente.php?module=main_relaciones&param=<?php echo $_GET["idkey_cliente"] ?>");</script>
	    <?php } ?>
	<?php } ?>
	 
	<?php function create_table_contacto($param)
	{
		$oconns = new database();
		$datas = $oconns->getRows("select clientes_contacto.idkey,clientes_contacto.descripcion, clientes_contacto.telefono, clientes_contacto.email, contacto_prioridad.nombre as prioridad from clientes_contacto INNER JOIN contacto_prioridad on contacto_prioridad.idkey = clientes_contacto.idkey_contacto_prioridad where clientes_contacto.idkey_clientes=".$param.";");
		?>
		
		<div class="table-responsive-md">
		    <table class="table table-bordered table-bordered-x table-hover text-dark-m2 small">
			<thead class="text-dark-m3 bgc-grey-l4">
			    <tr>
				<th scope="col" width="40%">Descripción</th>
				<th scope="col">Teléfono</th>
				<th scope="col">Correo Electrónico</th>
				<th scope="col" align="center">Prioridad</th>
				<!--<th scope="col" width="5%" align="center">Actualizar</th>-->
				<th scope="col" width="5%" align="center">Acciones</th>   
			    </tr>
			</thead>
			<tbody>
			<?php if ($oconns->numberRows==0){ ?>
			    <tr>
				<td colspan='5'>No se han encontrado datos por el momento</td>
			    </tr>
			<?php } 
			    else 
			    {
				foreach ($datas as $items) {
			?>
			    <tr>
				<td scope="row"><?php echo $items["descripcion"]; ?></td>
				<td><?php echo $items["telefono"]; ?></td>
				<td><?php echo $items["email"]; ?></td>
				<td><?php echo $items["prioridad"]; ?></td>
				<!--<td align="center"><i class="fas fa-user-edit"></i></td>-->
				<td align="center">
					<a href="#" class="btn radius-1 btn-sm btn-brc-tp btn-outline-default btn-h-outline-danger btn-a-outline-danger btn-text-danger" title="Eliminar" id='delcontacto_<?php echo $items["idkey"] ?>' data-id='<?php echo $items["idkey"] ?>'> <i class="fa fa-trash-alt"></i></a>
				</td>
			    </tr>
			<script>$(document).ready(function(){

			  // Delete 
			  $('#delcontacto_<?php echo $items["idkey"] ?>').click(function(){
			    var el = this;
			  
			    // Delete id
			    var deleteid = $(this).data('id');
			 
			    // Confirm box
			    bootbox.confirm("¿Realmente desea eliminar este contacto?", function(result) {
			 
			       if(result){
				 // AJAX Request
				 $.ajax({
				   url: '../php/delete.php',
				   type: 'POST',
				   data: { module:'borrar_contacto',
				       id:deleteid },
				   success: function(response){
				   	alertify.success("Contacto eliminado exitosamente");
				     // Removing row from HTML Table
				     if(response == 1){
					$(el).closest('tr').css('background','tomato');
					$(el).closest('tr').fadeOut(800,function(){
					   $(this).remove();
					});
				     }else{
					bootbox.alert('Record not deleted.');
				     }

				   }
				 });
			       }
			 
			    });
			 
			  });
			});
			</script>
			<?php 
				}
			    }
			?>
			</tbody>
		    </table>
		</div>
<?php } ?>
	
    <?php function create_fields_contacto(){ ?>
		    
                    <div class="card-body">
			<div class="form-group row" style="margin:0px; padding:0px;">
			    <div class="col-sm-12 col-md-4 col-lg-8" style="margin-bottom: 12px; margin-top: 0px;">
				<label class="col-form-label form-control-label" style="margin-top: 0px;">Descripcion<span style="color:red;">*</span></label>
				<input class="form-control form-control-sm" type="text" value="" id="contacto_descripcion">
			    </div>
			    <div class="col-sm-12 col-md-4 col-lg-4">
				<label class="col-form-label form-control-label">Tel&eacute;fono<span style="color:red;">*</span></label>
				<input class="form-control form-control-sm" type="text" value="" id="contacto_telefono" name="telefono">
			    </div>
			</div>
			<div class="form-group row" style="margin:0px; padding:0px;">
			    <div class="col-sm-12 col-md-4 col-lg-8" style="margin-bottom: 12px; margin-top: 0px;">
			    <label class="col-form-label form-control-label">E-mail</label>
			    <input class="form-control form-control-sm" type="text" value="" id="contacto_email" name="contacto_email">
			</div>
			<div class="col-sm-12 col-md-4 col-lg-4">
			    <label class="col-form-label form-control-label">Prioridad<span style="color:red;">*</span></label>
			    <select name="contacto_prioridad" id="contacto_prioridad" class="form-control form-control-sm">
			    <?php create_contacto_prioridad(''); ?>
			    </select>
			</div>
			</div>
			<div class="form-group row" style="margin:0px; padding:0px;">
			    <div class="col-sm-12 col-md-6 col-lg-7" style="margin-bottom: 12px; margin-top: 0px;">
				<div class="row">
				    <div class="col-lg-12">
					<td>
					    <button type="button" class="btn btn-success btn-sm" onclick="$.fn.guardar_contacto();" id="safe_general" data-dismiss="modal">Guardar</button>
					</td>
					<td>
					    <button type="button" class="btn btn-danger btn-sm" onclick="$.fn.agregar_contactos_cancel();" data-dismiss="modal">Cancelar</button>
					</td>
				    </div>
				</div>
				
			    </div>
			</div>
		    </div>

	<?php } ?>
	
	<?php function main_contacto($param){ ?>
		<div class="form-group row" style="margin:0px; padding:0px;">
			<div class="col-sm-12 col-md-4 col-lg-12" style="margin-bottom: 12px; margin-top: 0px;" id="tabla_contacto">
				<?php create_table_contacto($param); ?>
			</div>                                
		</div>
		<div class="form-group row" style="margin:0px; padding:0px;">
		    <div class="col-sm-12 col-md-6 col-lg-12" style="margin-bottom: 12px; margin-top: 0px;">
			<div class="row">
			    <div class="col-8">
				
			    </div>
			    <div class="col-lg-4 text-right">
				<button type="button" onclick="$.fn.agregar_contacto();" class="btn btn-info btn-sm">
				    <i class="fas fa-address-book"></i> Agregar
				</button>
			    </div>
			</div>
		    </div>
		</div>
		<?php } ?>
		
		
		<!-- GARANTIA MUEBLE -->
	<?php 
	function create_table_muebles($param)
	{
		$oconns = new database();
		$datas = $oconns->getRows("select gc.nombre as categoria,garantias_mueble.idkey,garantias_mueble.valor_comercial,garantias_mueble.modelo,garantias_mueble.marca,garantias_mueble.fecha_adquisicion,garantias_mueble.referencia_factura,garantias_mueble.observaciones,garantias_mueble.cobertura from garantias_mueble inner join garantias_categorias gc on gc.idkey=garantias_mueble.idkey_garantia_categoria where idkey_clientes=".$param.";");
		?>
		
		<div class="table-responsive-md">
		    <table class="table table-bordered table-striped text-dark-m1">
			<thead>
			    <tr class="bgc-success-m1 text-white">
				<th colspan="8">GARANTIAS MUEBLES</th>
			    </tr>
			    <tr class="bgc-success-m1 text-white">
				<th>Categoría</th>
				<th>valor comercial</th>
				<th>Modelo</th>
				<th>Marca</th>
				<th>Factura/Referencia</th>
				<th>Fecha Aqd.</th>
				<th>Observaciones</th>
				<!--<th>Actualizar</th>-->
				<th>Eliminar</th>  
			    </tr>
			</thead>
			<tbody>
			<?php if ($oconns->numberRows==0){ ?>
			    <tr>
				<td colspan='8'>No se han encontrado datos por el momento</td>
			    </tr>
			<?php } 
			    else 
			    {
				foreach ($datas as $items) {
			?>
			    <tr>
				<td><?php echo $items["categoria"]; ?></td>
				<td><?php echo $items["valor_comercial"]; ?></td>
				<td><?php echo $items["modelo"]; ?></td>
				<td><?php echo $items["marca"]; ?></td>
				<td><?php echo $items["referencia_factura"]; ?></td>
				<td><?php echo $items["fecha_adquisicion"]; ?></td>
				<td><?php echo $items["observaciones"]; ?></td>
				<!--<td align="center"><i class="fas fa-user-edit"></i></td>-->
				<td align="center">
				    <button class='delete2 btn btn-danger' id='del_<?php echo $items["idkey"] ?>' data-id='<?php echo $items["idkey"] ?>' >Eliminar</button>
				</td>
			    </tr>
			<script>$(document).ready(function(){

			  // Delete 
			  $('.delete2').click(function(){
			    var el = this;
			  
			    // Delete id
			    var deleteid = $(this).data('id');
			 
			    // Confirm box
			    bootbox.confirm("Esta seguro de eliminar este ítem?", function(result) {
			 
			       if(result){
				 // AJAX Request
				 $.ajax({
				   url: 'php/delete.php',
				   type: 'POST',
				   data: { module:'borrar_mueble',
				       id:deleteid },
				   success: function(response){

				     // Removing row from HTML Table
				     if(response == 1){
					$(el).closest('tr').css('background','tomato');
					$(el).closest('tr').fadeOut(800,function(){
					   $(this).remove();
					});
				     }else{
					bootbox.alert('Record not deleted.');
				     }

				   }
				 });
			       }
			 
			    });
			 
			  });
			});
			</script>
			<?php }}?>
			</tbody>
		    </table>
		</div>
	<?php } ?>
	
	<?php function create_fields_muebles(){ ?>
	    <input type='hidden' name='idkey_cliente' id='idkey_cliente' value='<?php echo $_GET["idkey_cliente"];?>'>
	<div id="form_mueble">
		<div class="row text-center">
			<div class="col-sm-12 col-md-3 col-lg-3">
				<label class="col-form-label form-control-label" >Categoria<span style="color:red;">*</span></label>
				<select name="garantias_categorias" id="garantias_categorias" class="form-control form-control-sm">
					 <?php create_garantia_categoria_muebles(); ?>
				</select>
			</div>
			<div class="col-sm-12 col-md-3 col-lg-3" style="margin-bottom: 12px; margin-top: 0px;">
				<label class="col-form-label form-control-label" style="margin-top: 0px;">Valor comercial<span style="color:red;">*</span></label>
				<input type="" name="" id="valor_comercial" class="form-control form-control-sm">
			</div>
			<div class="col-sm-12 col-md-3 col-lg-3">
				<label class="col-form-label form-control-label" >Marca<span style="color:red;">*</span></label>
				<input type="" name="" id="marca" class="form-control form-control-sm">
			</div>
			<div class="col-sm-12 col-md-3 col-lg-3">
				<label class="col-form-label form-control-label" >Modelo<span style="color:red;">*</span></label>
				<input type="" name="" id="modelo" class="form-control form-control-sm">
			</div>                               
		</div>
		<div class="row">
			<div class="col-sm-12 col-md-4 col-lg-4">
				<label class="col-form-label form-control-label" >Fecha de Adquisición<span style="color:red;">*</span></label>
				<input type="" name="" id="fecha_adquisicion" class="form-control form-control-sm">
				<script>     $("#fecha_sat").activeCalendary('#fecha_adquisicion'); </script>
			</div>
			<div class="col-sm-12 col-md-4 col-lg-4">
				<label class="col-form-label form-control-label" >Referencia o Factura<span style="color:red;">*</span></label>
				<input type="" name="" id="referencia_factura" class="form-control form-control-sm">
			</div>
			<div class="col-sm-12 col-md-4 col-lg-4">
				<label class="col-form-label form-control-label" >Cobertura<span style="color:red;">*</span></label>
				<select name="cobertura" id="cobertura" class="form-control form-control-sm">
					<option value="">Seleccionar...</option>
					<option value="10">Mayor al 100%</option>
					<option value="8">Igual al 100%</option>
					<option value="5">Menor al 100%</option>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 12px; margin-top: 0px;">
				<label class="col-form-label form-control-label" style="margin-top: 0px;">Observaciones</label>
				<textarea  class="form-control" rows="5" id="mueble_observaciones"></textarea>
			</div>
		</div>
		<div class="form-group row" style="margin:0px; padding:0px;">
		<div class="col-sm-12 col-md-6 col-lg-7" style="margin-bottom: 12px; margin-top: 0px;">
			<div class="row">
				<div class="col-lg-12">
					<button onclick="guardar_garantia_mueble(document.getElementById('idkey_cliente').value.trim());" id="safe_general" type="button" class="btn btn-success btn-sm"><i class="fas fa-save"></i> Guardar</button>
					<button class="btn btn-danger btn-sm" onclick="$.fn.agregar_mueble_cancel();"><i class="fas fa-ban"></i>Cancelar</button>
				</div>
			</div>
		</div>
	</div>
	</div>

	<?php } ?>
	
	<?php function main_muebles($param){ ?>
		<div class="form-group row" style="margin:0px; padding:0px;">
			<div class="col-sm-12 col-md-4 col-lg-12" style="margin-bottom: 12px; margin-top: 0px;" id="tabla_contacto">
				<?php create_table_muebles($param); ?>
			</div>                                
		</div>
		<div class="form-group row" style="margin:0px; padding:0px;">
		    <div class="col-sm-12 col-md-6 col-lg-12" style="margin-bottom: 12px; margin-top: 0px;">
			<div class="row">
			    <div class="col-8">
				    
			    </div>
			    <div class="col-lg-4 text-right">
				    <button type="button" onclick="$.fn.agregar_mueble();" class="btn btn-info btn-sm"><i class="fas fa-address-book"></i> Agregar Muebles</button>
			    </div>
			</div>
		    </div>
		</div>
		<?php } ?>

		<!-- GARANTIA INMUEBLE -->
	<?php 
	function create_table_inmuebles($param)
	{
		$oconns = new database();
		$datas = $oconns->getRows("select gi.*,gc.nombre as categoria from garantias_inmueble gi inner join garantias_categorias gc on gc.idkey=gi.idkey_garantia_categoria where idkey_clientes=".$param.";");
		?>
		
		<div class="table-responsive-md">
		    <table class="table table-bordered table-striped text-dark-m1">
			<thead>
			    <tr class="bgc-success-m1 text-white">
				<th colspan="8">GARANTIAS INMUEBLES</th>
			    </tr>
			    <tr class="bgc-success-m1 text-white">
				<th>Categoría</th>
				<th>valor Comercial</th>
				<th>valor Fiscal</th>
				<th>Valos Catastral</th>
				<th>Escrituras</th>
				<th>Registro</th>
				<th>Medidas</th>
				<!--<th>Actualizar</th>-->
				<th>Eliminar</th>  
			    </tr>
			</thead>
			<tbody>
			<?php if ($oconns->numberRows==0){ ?>
			    <tr>
				<td colspan='8'>No se han encontrado datos por el momento</td>
			    </tr>
			<?php } 
			    else 
			    {
				foreach ($datas as $items) {
			?>
			    <tr>
				<td><?php echo $items["categoria"]; ?></td>
				<td><?php echo $items["valor_comercial"]; ?></td>
				<td><?php echo $items["valor_fiscal"]; ?></td>
				<td><?php echo $items["valor_catastral"]; ?></td>
				<td><?php if(isset($items["escritura"])){echo "Presento Escritura";} else {echo "Sin escrituras";} ?></td>
				<td><?php echo $items["registro"]; ?></td>
				<td><?php echo $items["medidas_colindacia"]; ?></td>
				<!--<td align="center"><i class="fas fa-user-edit"></i></td>-->
				<td align="center">
				    <button class='delete3 btn btn-danger' id='del_<?php echo $items["idkey"] ?>' data-id='<?php echo $items["idkey"] ?>' >Eliminar</button>
				</td>
			    </tr>
			<script>$(document).ready(function(){

			  // Delete 
			  $('.delete3').click(function(){
			    var el = this;
			  
			    // Delete id
			    var deleteid = $(this).data('id');
			 
			    // Confirm box
			    bootbox.confirm("Esta seguro de eliminar este ítem?", function(result) {
			 
			       if(result){
				 // AJAX Request
				 $.ajax({
				   url: 'php/delete.php',
				   type: 'POST',
				   data: { module:'borrar_mueble',
				       id:deleteid },
				   success: function(response){

				     // Removing row from HTML Table
				     if(response == 1){
					$(el).closest('tr').css('background','tomato');
					$(el).closest('tr').fadeOut(800,function(){
					   $(this).remove();
					});
				     }else{
					bootbox.alert('Record not deleted.');
				     }

				   }
				 });
			       }
			 
			    });
			 
			  });
			});
			</script>
			<?php }}?>
			</tbody>
		    </table>
		</div>
	<?php } ?>
	
	<?php function create_fields_inmuebles(){ ?>
	<input type='hidden' name='idkey_cliente' id='idkey_cliente' value='<?php echo $_GET["idkey_cliente"];?>'>
	<div id="form_inmueble" >
		<div class="row">
			<div class="col-sm-12 col-md-3 col-lg-3">
				<label class="col-form-label form-control-label" >Categoria<span style="color:red;">*</span></label>
				<select name="garantias_categorias" id="garantias_categorias" class="form-control form-control-sm">
					 <?php create_garantia_categoria_inmuebles(); ?>
				</select>
			</div>
			<div class="col-sm-12 col-md-3 col-lg-3" style="margin-bottom: 12px; margin-top: 0px;">
				<label class="col-form-label form-control-label" style="margin-top: 0px;">Valor comercial<span style="color:red;">*</span></label>
				<input type="" name="" id="valor_comercial_2" class="form-control form-control-sm">
			</div>
			<div class="col-sm-12 col-md-3 col-lg-3">
				<label class="col-form-label form-control-label" >Valor Fiscal<span style="color:red;">*</span></label>
				<input type="" name="" id="valor_fiscal" class="form-control form-control-sm">
			</div>                               
			<div class="col-sm-12 col-md-3 col-lg-3">
				<label class="col-form-label form-control-label" >Valor Catastral<span style="color:red;">*</span></label>
				<input type="" name="" id="valor_catastral" class="form-control form-control-sm">
			</div>
			                           
		</div>
		<div class="row">
			<div class="col-sm-12 col-md-3 col-lg-2">
				<label class="col-form-label form-control-label" >Escritura<span style="color:red;">*</span></label>
				<input type="" name="" id="escritura" class="form-control form-control-sm" placeholder="Num. Escritura">
			</div>    
			<div class="col-sm-12 col-md-3 col-lg-2">
				<label class="col-form-label form-control-label" >Registro<span style="color:red;">*</span></label>
				<input type="" name="" id="registro" class="form-control form-control-sm">
			</div>                               
			<div class="col-sm-12 col-md-3 col-lg-2">
				<label class="col-form-label form-control-label" >Gravamen<span style="color:red;">*</span></label>
				<input type="" name="" id="gravamen" class="form-control form-control-sm">
			</div>
			<div class="col-sm-12 col-md-3 col-lg-2">
				<label class="col-form-label form-control-label" >Hipoteca<span style="color:red;">*</span></label>
				<input type="" name="" id="hipoteca" class="form-control form-control-sm">
			</div>
			<div class="col-sm-12 col-md-2 col-lg-2">
				<label class="col-form-label form-control-label" >Aforo</label>
				<select name="aforo" id="aforo" class="form-control form-control-sm">
					<option value="">Seleccionar...</option>
					<option value="10">Aforo 2 a 1</option>
					<option value="10">Aforo 1 a 1</option>
					<option value="5">Aforo menor</option>
					<option value="0">Inviable</option>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12 col-md-4 col-lg-4">
				<label class="col-form-label form-control-label" style="margin-top: 0px;">Descripción</label>
				<textarea  class="form-control" rows="5" id="inmueble_descripcion"></textarea>
			</div>
			<div class="col-sm-12 col-md-4 col-lg-4">
				<label class="col-form-label form-control-label" style="margin-top: 0px;">Observaciones</label>
				<textarea  class="form-control" rows="5" id="inmueble_observaciones"></textarea>
			</div>
			<div class="col-sm-12 col-md-4 col-lg-4">
				<label class="col-form-label form-control-label" style="margin-top: 0px;">Medidas y Colindancias</label>
				<textarea  class="form-control" rows="5" id="inmueble_medidas"></textarea>
			</div>
		</div>
		<div class="col-sm-12 col-md-6 col-lg-7" style="margin-bottom: 12px; margin-top: 0px;">
			<div class="row">
				<div class="col-lg-12">
					<button onclick="guardar_garantia_inmueble(document.getElementById('idkey_cliente').value.trim());" id="safe_general" type="button" class="btn btn-success btn-sm"><i class="fas fa-save"></i> Guardar</button>
					<button class="btn btn-danger btn-sm" onclick="$.fn.agregar_inmueble_cancel();"><i class="fas fa-ban"></i>Cancelar</button>
				</div>
			</div>
		</div>
	</div>
    
	<?php } ?>
	
	<?php function main_inmuebles($param){ ?>
		<div class="form-group row" style="margin:0px; padding:0px;">
			<div class="col-sm-12 col-md-4 col-lg-12" style="margin-bottom: 12px; margin-top: 0px;" id="tabla_contacto">
				<?php create_table_inmuebles($param); ?>
			</div>                                
		</div>
		<div class="form-group row" style="margin:0px; padding:0px;">
		    <div class="col-sm-12 col-md-6 col-lg-12" style="margin-bottom: 12px; margin-top: 0px;">
			<div class="row">
			    <div class="col-8">
				    
			    </div>
			    <div class="col-lg-4 text-right">
				    <button type="button" onclick="$.fn.agregar_inmueble();" class="btn btn-info btn-sm"><i class="fas fa-address-book"></i> Agregar Inmuebles</button>
			    </div>
			</div>
		    </div>
		</div>
		<?php } ?>

	<!-- Ingresos -->
	<?php 
	function create_table_ingresos($param)
	{
		$oconns = new database();
		$datas = $oconns->getRows("select ci.*, it.nombre as tipo_i, f.nombre as frec, emp.nombre as empleador,TIMESTAMPDIFF(YEAR, inicio, CURDATE()) AS arraigo_laboral 
						from clientes_ingresos as ci 
						inner join ingresos_tipos as it on it.idkey = ci.id_tipo_ingreso 
						inner join frecuencia f on f.idkey = ci.id_frecuencia 
						inner join ingresos_empleador emp on ci.id_empleador = emp.idkey
						where idkey_clientes=".$param.";");
		?>
		
		<div class="table-responsive-md">
		    <table class="table table-bordered table-striped text-dark-m1">
			<thead>
			    <tr class="bgc-success-m1 text-white">
				<th scope="col" width="40%">Empleador</th>
				<th scope="col" width="40%">Tipo Ingreso</th>
				<th scope="col">Monto</th>
				<th scope="col">Frecuencia</th>
				<th scope="col">Bajo Contrato</th>
				<th scope="col">Arraigo Laboral</th>
				<!--<th scope="col" width="5%" align="center">Actualizar</th>-->
				<th scope="col" width="5%" align="center">Eliminar</th>   
			    </tr>
			</thead>
			<tbody>
			<?php if ($oconns->numberRows==0){ ?>
			    <tr>
				<td colspan='7'>No se han encontrado datos por el momento</td>
			    </tr>
			<?php } 
			    else 
			    {
				foreach ($datas as $items) {
			?>
			    <tr>
				<td><?php echo $items["empleador"]; ?></td>
				<td><?php echo $items["tipo_i"]; ?></td>
				<td><?php echo $items["monto"]; ?></td>
				<td><?php echo $items["frec"]; ?></td>
				<td><?php echo $items["bajo_contrato"]; ?></td>
				<td><?php echo $items["arraigo_laboral"]; ?></td>
				<!--<td align="center"><i class="fas fa-user-edit"></i></td>-->
				<td align="center">
				    <button class='delete4 btn btn-danger' id='del_<?php echo $items["idkey"] ?>' data-id='<?php echo $items["idkey"] ?>' >Eliminar</button>
				</td>
			    </tr>
			<script>$(document).ready(function(){

			  // Delete 
			  $('.delete4').click(function(){
			    var el = this;
			  
			    // Delete id
			    var deleteid = $(this).data('id');
			 
			    // Confirm box
			    bootbox.confirm("Esta seguro de eliminar este ítem?", function(result) {
			 
			       if(result){
				 // AJAX Request
				 $.ajax({
				   url: 'php/delete.php',
				   type: 'POST',
				   data: { module:'borrar_ingreso',
				       id:deleteid },
				   success: function(response){

				     // Removing row from HTML Table
				     if(response == 1){
					$(el).closest('tr').css('background','tomato');
					$(el).closest('tr').fadeOut(800,function(){
					   $(this).remove();
					});
				     }else{
					bootbox.alert('Record not deleted.');
				     }

				   }
				 });
			       }
			 
			    });
			 
			  });
			});
			</script>
			<?php }}?>
			</tbody>
		    </table>
		</div>
	<?php } ?>
	
	<?php function create_fields_ingresos(){ ?>
			<div class="card-body">
			    <div class="form-group row" >
				<div class="col-sm-12 col-md-3 col-lg-3" style="margin-bottom: 12px; margin-top: 35px;">
				    Seleccione sólo si es el ingreso principal
				    <div class="form-check" >
					<input class="form-check-input" type="radio" value="" id="principal" name="principal">
					<label class="form-check-label" for="principal">Sí</label>
				    </div>
				</div>
				<div class="col-sm-12 col-md-3 col-lg-3" style="margin-bottom: 12px; margin-top: 0px;">
				    <label class="col-form-label form-control-label" style="margin-top: 0px;">Tipo<span style="color:red;">*</span></label>
				    <select name="ingreso_tipo" id="ingreso_tipo" class="form-control form-control-sm">
					<?php create_tipo_ingreso(''); ?>
				    </select>
				</div>
				<div class="col-sm-12 col-md-3 col-lg-3" style="margin-bottom: 12px; margin-top: 0px;">
				    <label class="col-form-label form-control-label" style="margin-top: 0px;">Frecuencia<span style="color:red;">*</span></label>
				    <select name="" id="ingreso_frec" class="form-control form-control-sm">
					<?php create_frecuencia(''); ?>
				    </select>
				</div>
				<div class="col-sm-12 col-md-3 col-lg-3" style="margin-bottom: 12px; margin-top: 0px;">
				    <label class="col-form-label form-control-label" style="margin-top: 0px;">Monto<span style="color:red;">*</span></label>
				    <input type="" name="" id="monto" class="form-control form-control-sm">
				</div>
			    </div>
			    <div class="form-group row" style="margin:0px; padding:0px;" id="empleadores">
				<div class="col-sm-12 col-md-3 col-lg-6" style="margin-bottom: 12px; margin-top: 0px;">
				    <label class="col-form-label form-control-label" style="margin-top: 0px;">Empleador/Empresa<span style="color:red;">*</span></label>
				    <select id="id_empleador" class="form-control form-control-sm">
					<?php create_empleador(''); ?>
				    </select>
				    <script>
					$(document).ready(function(){ 
					  // Initialize select2
					  $("#id_empleador").select2();
					});
				    </script>
				</div>
				<div class="col-sm-12 col-md-3 col-lg-3" style="margin-bottom: 12px; margin-top: 0px;">
				    <label class="col-form-label form-control-label" style="margin-top: 0px;">Desde<span style="color:red;">*</span></label>
				    <input type="" name="f_inicio" id="f_inicio" class="form-control form-control-sm">
				</div>
				<div class="col-sm-12 col-md-3 col-lg-3" style="margin-bottom: 12px; margin-top: 0px;">
				    <label class="col-form-label form-control-label" style="margin-top: 0px;">Hasta<span style="color:red;">*</span></label>
				    <input type="" name="f_fin" id="f_fin" class="form-control form-control-sm">
				</div>
			    </div>
			    <script>
				$("#f_inicio").activeCalendary('#f_inicio');
				$("#f_fin").activeCalendary('#f_fin');
			    </script>
			    <div class="form-group row" style="margin:0px; padding:0px;">
				<div class="col-sm-12 col-md-3 col-lg-3" style="margin-bottom: 12px; margin-top: 0px;">
				    <label class="col-form-label form-control-label" style="margin-top: 0px;">Profesion<span style="color:red;">*</span></label>
				    <input type="" name="" id="profesion" class="form-control form-control-sm">
				</div>
				<div class="col-sm-12 col-md-3 col-lg-3" style="margin-bottom: 12px; margin-top: 0px;">
				    <label class="col-form-label form-control-label" style="margin-top: 0px;">Ocupacion/Puesto<span style="color:red;">*</span></label>
				    <input type="" name="" id="ocupacion" class="form-control form-control-sm">
				</div>
				<div class="col-sm-12 col-md-3 col-lg-3" style="margin-bottom: 12px; margin-top: 0px;">
				    <label class="col-form-label form-control-label" style="margin-top: 0px;">Jefe Directo<span style="color:red;">*</span></label>
				    <input type="" name="" id="jefe_directo" class="form-control form-control-sm">
				</div>
				<div class="col-sm-12 col-md-3 col-lg-3" style="margin-bottom: 12px; margin-top: 35px;">
				    Bajo Contrato
				    <div class="form-check" >
					<input class="form-check-input" type="radio" value="1" id="bajo_contrato" name="bajo_contrato">
					<label class="form-check-label" for="bajo_contrato">Sí</label>
				    </div>
				</div>
			    </div>
			    
			    <div class="form-group row" style="margin:0px; padding:0px;">
				<div class="col-sm-12 col-md-3 col-lg-4" style="margin-bottom: 12px; margin-top: 0px;">
				    <label class="col-form-label form-control-label" style="margin-top: 0px;">Domicilio Empresa/Empleador<span style="color:red;">*</span></label>
				    <select id="domicilio_empleador" class="form-control form-control-sm">
					<?php create_domicilio_empleador('',''); ?>
				    </select>
				</div>
				<script>
				    $('#id_empleador').change(function(){ $('#id_empleador').onchange_empleador(  $('#id_empleador').val(),'#domicilio_empleador'   );   }  );
				</script>
				<div class="col-sm-12 col-md-3 col-lg-4" style="margin-bottom: 12px; margin-top: 0px;">
				    <label class="col-form-label form-control-label" style="margin-top: 0px;">Actividad Economica SITI<span style="color:red;">*</span></label>
				    <select name="" id="actividad_siti" class="form-control form-control-sm">
					<?php create_actividades_siti(''); ?>
				    </select>
				    <script>
					$(document).ready(function(){ 
					  // Initialize select2
					  $("#actividad_siti").select2();
					});
				    </script>
				</div>
				<div class="col-sm-12 col-md-3 col-lg-4" style="margin-bottom: 12px; margin-top: 0px;">
				    <label class="col-form-label form-control-label" style="margin-top: 0px;">Comprobación de ingresos<span style="color:red;">*</span></label>
				    <select name="ingreso_comprobable" id="ingreso_comprobable" class="form-control form-control-sm">
					<option value="">Seleccione ...</option>
					<option value="20">Total</option>
					<option value="15">Parcial</option>
					<option value="10">No comprobable</option>
				    </select>
				</div>
			    </div>
			    <div class="form-group row" style="margin:0px; padding:0px;">
				<div class="col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 12px; margin-top: 0px;">
				    <label class="col-form-label form-control-label" style="margin-top: 0px;">Descripcion</label>
				    <textarea  class="form-control" rows="5" id="ingreso_desc"></textarea>
				</div>
			    </div>
			    <div class="col-lg-12">
				<td>
				    <button type="button" class="btn btn-success btn-sm" onclick="$.fn.guardar_ingreso();" id="safe_general" data-dismiss="modal">Guardar</button>
				</td>
				<td>
				    <button type="button" class="btn btn-danger btn-sm" onclick="$.fn.agregar_ingreso_cancel();" data-dismiss="modal">Cancelar</button>
				</td>
			    </div>
			</div>

	<?php } ?>
	<?php function main_ingresos($param){ ?>
		<div class="form-group row" style="margin:0px; padding:0px;">
			<div class="col-sm-12 col-md-4 col-lg-12" style="margin-bottom: 12px; margin-top: 0px;" id="tabla_contacto">
				<?php create_table_ingresos($param); ?>
			</div>                                
		</div>
		<div class="form-group row" style="margin:0px; padding:0px;">
		    <div class="col-sm-12 col-md-6 col-lg-12" style="margin-bottom: 12px; margin-top: 0px;">
			<div class="row">
			    <div class="col-8">
				    
			    </div>
			    <div class="col-lg-4 text-right">
				    <button type="button" onclick="$.fn.agregar_ingreso();" class="btn btn-info btn-sm"><i class="fas fa-address-book"></i> Agregar</button>
			    </div>
			</div>
		    </div>
		</div>
		<?php } ?>
		
	<?php function create_table_egresos($param){ 
		$oconns = new database();
		$datas = $oconns->getRows("select ce.*, et.nombre as tipo_egreso, f.nombre as frecuencia from clientes_egresos ce inner join egresos_tipos et on ce.id_tipo_egreso = et.idkey inner join frecuencia f on f.idkey = ce.id_frecuencia where ce.idkey_clientes=".$param.";");
		?>
		
		<div class="table-responsive-md">
		    <table class="table table-bordered table-bordered-x table-hover text-dark-m2 small">
			<thead class="text-dark-m3 bgc-grey-l4">
			    <tr>
				<th scope="col">Egreso</th>
				<th scope="col" >Frecuencia</th>
				<th scope="col">Monto</th>
				<th scope="col">Tipo Pago</th>
				<!--<th scope="col" width="5%" align="center">Actualizar</th>-->
				<th scope="col" width="5%" align="center">Acciones</th>   
			    </tr>
			</thead>
			<tbody>
			<?php if ($oconns->numberRows==0){ ?>
			    <tr>
				<td colspan='6'>No se han encontrado datos por el momento</td>
			    </tr>
			<?php } 
			    else 
			    {
				foreach ($datas as $items) {
			?>
			    <tr>
				<td><?php echo $items["tipo_egreso"]; ?></td>
				<td><?php echo $items["frecuencia"]; ?></td>
				<td><?php echo $items["monto"]; ?></td>
				<td><?php echo $items["tipo_egreso"]; ?></td>
				<!--<td align="center"><i class="fas fa-user-edit"></i></td>-->
				<td align="center">
					<a href="#" class="btn radius-1 btn-sm btn-brc-tp btn-outline-default btn-h-outline-danger btn-a-outline-danger btn-text-danger delete_egreso delete5" id='delegreso_<?php echo $items["idkey"] ?>' data-id='<?php echo $items["idkey"] ?>'>
                      <i class="fa fa-trash-alt"></i>
                    </a>
				    
				</td>
			    </tr>
			<script>$(document).ready(function(){

			  // Delete 
			  $('#delegreso_<?php echo $items["idkey"] ?>').click(function(){
			    var el = this;
			  
			    // Delete id
			    var deleteid = $(this).data('id');
			 
			    // Confirm box
			    bootbox.confirm("¿Está seguro que deasea eliminar este egreso?", function(result) {
			 
			       if(result){
				 // AJAX Request
				 $.ajax({
				   url: 'php/delete.php',
				   type: 'POST',
				   data: { module:'borrar_egreso',
				       id:deleteid },
				   success: function(response){

				     // Removing row from HTML Table
				     if(response == 1){
				     	alertify.success("Egreso eliminado exitosamente");
					$(el).closest('tr').css('background','tomato');
					$(el).closest('tr').fadeOut(800,function(){
					   $(this).remove();
					});
				     }else{
					bootbox.alert('Record not deleted.');
				     }

				   }
				 });
			       }
			 
			    });
			 
			  });
			});
			</script>
			<?php }}?>
			</tbody>
		    </table>
		</div>
<?php } ?>
	
    <?php function create_fields_egresos(){ ?>
	    <div class="card-body" id="">
		<div class="form-group row" style="margin:0px; padding:0px;">
		    
		</div>
		<div class="form-group row" style="margin:0px; padding:0px;">
		    <div class="col-sm-12 col-md-6 col-lg-4" style="margin-bottom: 12px; margin-top: 0px;">
			<label class="col-form-label form-control-label" style="margin-top: 0px;">Tipo<span style="color:red;">*</span></label>
			<select name="" id="tipo_egreso" class="form-control form-control-sm">
			    <?php create_tipo_egreso(''); ?>
			</select>
		    </div>
		    <div class="col-sm-12 col-md-6 col-lg-4" style="margin-bottom: 12px; margin-top: 0px;">
			<label class="col-form-label form-control-label" style="margin-top: 0px;">Frecuencia<span style="color:red;">*</span></label>
			<select name="" id="frecuencia_egreso" class="form-control form-control-sm">
			    <?php create_frecuencia(); ?>
			</select>
		    </div>
		    <div class="col-sm-12 col-md-6 col-lg-4" style="margin-bottom: 12px; margin-top: 0px;">
			<label class="col-form-label form-control-label" style="margin-top: 0px;">Monto<span style="color:red;">*</span></label>
			<input type="" name="" id="monto_egreso" class="form-control form-control-sm">
		    </div>
		</div>
		<div class="form-group row" style="margin:0px; padding:0px;">
		    <div class="col-sm-12 col-md-6 col-lg-2" style="margin-bottom: 12px; margin-top: 0px;">
			<label class="col-form-label form-control-label" style="margin-top: 0px;">Desde<span style="color:red;">*</span></label>
			<input type="" name="" id="inicio_egreso" class="form-control form-control-sm">
			<script>  $("#fecha_sat").activeCalendary('#inicio_egreso'); </script>
		    </div>
		    <div class="col-sm-12 col-md-6 col-lg-2" style="margin-bottom: 12px; margin-top: 0px;">
			<label class="col-form-label form-control-label" style="margin-top: 0px;">Hasta<span style="color:red;">*</span></label>
			<input type="" name="" id="fin_egreso" class="form-control form-control-sm">
			<script>  $("#fecha_sat").activeCalendary('#fin_egreso'); </script>
		    </div>
		    <div class="col-sm-12 col-md-6 col-lg-5" style="margin-bottom: 12px; margin-top: 0px;">
			<label class="col-form-label form-control-label" style="margin-top: 0px;">Descripcion<span style="color:red;">*</span></label>
			<textarea class="form-control form-control-sm" id="descripcion_egreso"></textarea>
		    </div>
		    <div class="col-sm-12 col-md-6 col-lg-3" style="margin-bottom: 12px; margin-top: 30px;">
			<div class="form-check" >
			    <input class="form-check-input" type="radio" value="1" id="tipo_pago">
			    <label class="form-check-label">Seleccione si el monto de pago es fijo</label>
			</div>
		    </div>
		</div>
		<div class="col-sm-12 col-md-6 col-lg-7" style="margin-bottom: 12px; margin-top: 0px;">
		    <div class="row">
			<div class="col-lg-12">
			    <td>
				<button type="button" class="btn btn-success btn-sm" onclick="$.fn.guardar_egreso();" id="safe_general" data-dismiss="modal">Guardar</button>
			    </td>
			    <td>
				<button type="button" class="btn btn-danger btn-sm" onclick="$.fn.agregar_egreso_cancel();" data-dismiss="modal">Cancelar</button>
			    </td>
			</div>
		    </div>			    
		</div>

		<div class="row">
		    <!--<div class="mx-auto col-sm-12 col-md-12 col-lg-12">
			<div >
			    <div class="card-body">-->
				<?php if (isset($_GET["idkey"]))
				    { ?>
				<!--<div class="form-group row" style="margin:0px; padding:0px;">
				    <div class="col-sm-12 col-md-6 col-lg-4" style="margin-bottom: 12px; margin-top: 0px;">
					<label class="col-form-label form-control-label" style="margin-top: 0px;">Motivo de la Modificacion<span style="color:red;">*</span></label>
					<select name="" id="" class="form-control form-control-sm">
					    <option value=""></option>
					    <option value="">Adicion de datos</option>
					</select>
				    </div>
				    <div class="col-sm-12 col-md-6 col-lg-8" style="margin-bottom: 12px; margin-top: 0px;">
					<label class="col-form-label form-control-label" style="margin-top: 0px;">Motivo de la Modificacion<span style="color:red;">*</span></label>
					<textarea class="form-control" rows="5" id="comment"></textarea>
				    </div>
				</div>-->
				<?php
				    } ?>
				<!--<div class="form-group row" style="margin:0px; padding:0px;">
				    <div class="col-sm-12 col-md-6 col-lg-7" style="margin-bottom: 12px; margin-top: 0px;">
					<div class="row">
					    <div class="col-lg-12">
						<button onclick="" id="safe_general" type="button" class="btn btn-success btn-sm"><i class="fas fa-save"></i> Guardar</button>
					    </div>
					</div>
				    </div>
				</div>-->
			   </div>
			</div>
		    </div>
		</div>
	    </div>

	<?php } ?>
	
	<?php function main_egresos($param)
	    { ?>
		<div class="form-group row" style="margin:0px; padding:0px;">
			<div class="col-sm-12 col-md-4 col-lg-12" style="margin-bottom: 12px; margin-top: 0px;" id="tabla_contacto">
				<?php create_table_egresos($param); ?>
			</div>                                
		</div>
		<div class="form-group row" style="margin:0px; padding:0px;">
		    <div class="col-sm-12 col-md-6 col-lg-12" style="margin-bottom: 12px; margin-top: 0px;">
			<div class="row">
			    <div class="col-8">
				    
			    </div>
			    <div class="col-lg-4 text-right">
				    <button type="button" onclick="$.fn.agregar_egreso();" class="btn btn-info btn-sm"><i class="fas fa-address-book"></i> Agregar</button>
			    </div>
			</div>
		    </div>
		</div>
		<?php } ?>
    
	<!-- FIN By Moshe Ramz -->
	<?php function create_table_relaciones($param)
	{
	    $oconns = new database();
	    $datas = $oconns->getRows("select clientes_relaciones.idkey, clientes_relaciones.idkey_relaciones, clientes_relaciones.idkey_clientes, clientes_relaciones.nombre,relaciones.nombre as relaciones,parentesco.nombre as parentesco, porcentaje, aval_hist_desc, aval_capacidad_desc, aval_solvencia_desc, idkey_cliente_rel  from clientes_relaciones,relaciones,parentesco where idkey_clientes=".$param." and clientes_relaciones.idkey_relaciones=relaciones.idkey and clientes_relaciones.idkey_parentesco=parentesco.idkey;");
	    ?>
		<div class="table-responsive-md">
			<table id="simple-table" class="table table-bordered table-bordered-x table-hover text-dark-m2 small" width="100%">
				<thead class="text-dark-m3 bgc-grey-l4">
					<tr>
					    <th class="text-center pr-0">
                          <span class="d-md-none"><i class="fa fa-plus text-sm"></i></span>
                          <span class="d-none d-md-inline-block">Detalles</span>
                        </th>
						<th scope="col" width="40%">Nombre</th>
						<th scope="col">Relación</th>
						<th scope="col">Parentesco</th>
						<!--<th scope="col" width="5%" align="center">Act.</th>-->
						<th scope="col" width="5%" align="center">Acciones</th>
					</tr>
				</thead>
				<tbody>


		<?php
		if ($oconns->numberRows==0)
		{
		?>
				<tr>
					<td colspan='5'>No se han encontrado datos por el momento</td>
				</tr>
		<?php
		}
		else
		{
			foreach ($datas as $items) {
				

		?>					
					<tr>
					    <td class='text-center pr-0'>
	                        <div class="action-buttons">
	                          <a href="#" data-toggle="collapse" id="detail-<?php echo $items["idkey"]; ?>" data-target="#table-detail-<?php echo $items["idkey"]; ?>" class="text-success text-110 px-2" title="Show Details"><i class="fa fa-angle-double-down"></i> <span class="sr-only">Details</span></a>
	                        </div>
                        </td>
						<td scope="row"><?php echo $items["nombre"]; ?></td>
						<td><?php echo $items["relaciones"]; ?></td>
						<td><?php echo $items["parentesco"]; ?></td>
						<!--<td align="center"><i class="fas fa-user-edit"></i></a></td>-->
						<td align="center">
							<a href="#" class="btn radius-1 btn-sm btn-brc-tp btn-outline-default btn-h-outline-danger btn-a-outline-danger btn-text-danger" title="Eliminar" id='del_<?php echo $items["idkey"] ?>' data-id='<?php echo $items["idkey"] ?>'> <i class="fa fa-trash-alt"></i></a>
						</td>
					</tr>
					<tr class="border-0 detail-row bgc-white">
                      <td colspan="5" class="p-0 border-none">
                        <div class="table-detail collapse" id="table-detail-<?php echo $items["idkey"]; ?>">
                          <div class="row">
                            <div class="col-12 col-md-10 offset-md-1 p-4">
                              <div class="alert bgc-grey-l4 border-none border-l-4 brc-success-m1 radius-0 mb-0">
                                <h4 class="text-success-m2">Detalles de la relación</h4>
                                <h6>
	                                <ul>
	                                	<li><b class="text-success">Nombre:&nbsp;</b><?php echo $items["nombre"]; ?></li>
	                                	<li><b class="text-success">Relación:&nbsp;</b><?php echo $items["relaciones"]; ?></li>
	                                	<li><b class="text-success">Parentesco:&nbsp;</b><?php echo $items["parentesco"]; ?></li>
	                                	<?php
	                                		if($items["idkey_relaciones"] == "1")//Es beneficiario
	                                			echo '<li><b class="text-success">Porcentaje:&nbsp;</b>'.$items["porcentaje"].'%</li>';
	                                		else if($items["idkey_relaciones"] == "2"){//es aval
	                                			echo '<li><b class="text-success">Historial aval:&nbsp;</b>'.$items["aval_hist_desc"].'</li>';
	                                			echo '<li><b class="text-success">Capacidad de pago:&nbsp;</b>'.$items["aval_capacidad_desc"].'</li>';
	                                			echo '<li><b class="text-success">Solvencia:&nbsp;</b>'.$items["aval_solvencia_desc"].'</li>';
	                                		}
	                                		
	                                	?>
	                                </ul>
	                            </h6>
                              </div>
                            </div>
                          </div>
                        </div>
                      </td>
                    </tr>
					<script>$(document).ready(function(){

					  // Delete 
					  $('#del_<?php echo $items["idkey"] ?>').click(function(){
					    var el = this;
					  
					    // Delete id
					    var deleteid = $(this).data('id');
					 
					    // Confirm box
					    bootbox.confirm("¿Está seguro que desea eliminar esta relación?", function(result) {
					 
					       if(result){
						 // AJAX Request
						 $.ajax({
						   url: '../php/delete.php',
						   type: 'POST',
						   data: { module:'borrar_relacion',
						       id:deleteid },
						   success: function(response){
						   	 alertify.success("Relación eliminada exitosamente");
						     // Removing row from HTML Table
						     if(response == 1){
							$(el).closest('tr').css('background','tomato');
							$(el).closest('tr').fadeOut(800,function(){
							   $(this).remove();
							});
						     }else{
							bootbox.alert('Record not deleted.');
						     }

						   }
						 });
					       }
					 
					    });
					 
					  });
					  //Para ocultar o mostrar los detalles
					  $('#detail-<?php echo $items["idkey"];?>').on('click', function () {
					    $('#table-detail-<?php echo $items["idkey"]; ?>').toggle('slide');
					});

				});
					</script>
				    <?php
					    }
				    }
				    ?>
				</tbody>
			</table>
		</div>
	    <?php } ?>

	<?php function create_clientes($param,$param2)
	{
		$oconns = new database();

		
	$datas = $oconns->getRows("select idkey_cliente as idkey, concat(nombre_pila,' ', apellido_p,' ',  apellido_m) as nombre, UPPER(rfc) as rfc from view_clientes where  (nombre_pila like '%".$param."%' or apellido_p like '%".$param."%' or apellido_m like '%".$param."%') and idkey_cliente<>".$param2.";");

		if ($oconns->numberRows==0)
		{
			?>
		<div class="table-responsive">
			<table class="table">
				<thead class="thead-dark">
					<tr>
						<th scope="col">Informaci&oacute;n</th>
	
					</tr>
				</thead>
				<tbody>
					<tr>
						<td align="center">No se han encontrado clientes que coinciden</td>
					</tr>
				</tbody>
			</table>
		</div>

			<?php
		}
		else
		{
		?>

		<div class="table-responsive">
			<table class="table">
				<thead class="thead-dark">
					<tr>
						<th scope="col" width="75%">Nombre</th>
						<th scope="col" width="25%">RFC</th>
					</tr>
				</thead>
				<tbody>


			<?php foreach ($datas as $items) { ?>
			    		<tr>
						<th scope="row" style="padding-top:10px; padding-bottom: 0px; margin:0px;"><a href="#" onclick="$.fn.addCliente_to_Relacion('<?php echo $items["idkey"];?>','<?php echo $items["nombre"];?>');"><?php echo $items["nombre"];?></a></th>
						<td align="center"><?php echo $items["rfc"];?></td>
					</tr>
			<?php } ?>
				</tbody>
			</table>
		</div>
		<?php }
		} ?>


	<?php function create_fields_relaciones(){ ?>
		    <input type="hidden" name="addidkey_cliente" id="addidkey_cliente" value="">
                    <div class="form-group row" style="margin:0px; padding:0px;">
                        <div class="col-sm-12 col-md-12 col-lg-4" style="margin-bottom: 12px; margin-top: 0px;">
                            <label class="col-form-label form-control-label" style="margin-top: 0px;">Nombre<span style="color:red;">*</span></label>
                            <input class="form-control form-control-sm" type="text" value="" id="nombre_relacion" disabled>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-4" style="margin-bottom: 12px; margin-top: 0px;">
                            <label class="col-form-label form-control-label" style="margin-top: 0px;">Relaci&oacute;n<span style="color:red;">*</span></label>
                            <select name="relaciones" id="relaciones" class="form-control form-control-sm">
                            	<?php create_tipos_relaciones(''); ?>
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-4" style="margin-bottom: 12px; margin-top: 0px;">
                            <label class="col-form-label form-control-label" style="margin-top: 0px;">Parentesco<span style="color:red;">*</span></label>
                            <select name="parentesco" id="parentesco" class="form-control form-control-sm">
                            	<?php create_parentesco(''); ?>
                            </select>
                        </div>
                    </div>
		    <div id="div_aval" class="row">
			<div class="col-sm-12 col-md-12 col-lg-4" style="margin-bottom: 12px; margin-top: 0px;" >
			    <label class="col-form-label form-control-label" style="margin-top: 0px;">Historial Aval<span style="color:red;">*</span></label>
			    <select id="aval_hist" class="form-control form-control-sm">
				<option value=""></option>
				<option value="30">Historial SIC MOP 1-2</option>
				<option value="25">Historial SIC MOP 3-4</option>
				<option value="15">Historial SIC MOP 5-7</option>
				<option value="5">Historial SIC MOP 9-96-97</option>
				<option value="0">Historial SIC MOP 99</option>
				<option value="5">Historial SIC Sin historial</option>
			    </select>
			</div>
			<div class="col-sm-12 col-md-12 col-lg-4" style="margin-bottom: 12px; margin-top: 0px;" >
			    <label class="col-form-label form-control-label" style="margin-top: 0px;">Capacidad de Pago<span style="color:red;">*</span></label>
			    <select id="aval_capacidad" class="form-control form-control-sm">
				<option value=""></option>
				<option value="80">Capacidad de pago Excelente</option>
				<option value="60">Capacidad de pago Buena</option>
				<option value="40">Capacidad de pago Regular</option>
				<option value="20">Capacidad de pago Mala</option>
			    </select>
			</div>
			<div class="col-sm-12 col-md-12 col-lg-4" style="margin-bottom: 12px; margin-top: 0px;" >
			    <label class="col-form-label form-control-label" style="margin-top: 0px;">Solvencia<span style="color:red;">*</span></label>
			    <select id="aval_solvencia" class="form-control form-control-sm">
				<option value=""></option>
				<option value="5">Solvencia Buena</option>
				<option value="3">Solvencia Regular</option>
				<option value="0">Solvencia Mala</option>
			    </select>
			</div>
		    </div>
		    <div id="div_porcentaje" class="row">
			    <div class="col-sm-12 col-md-6 col-lg-4" style="margin-bottom: 12px; margin-top: 0px;">
				<label class="col-form-label form-control-label" style="margin-top: 0px;">Porcentaje %<span style="color:red;">*</span></label>
				<input type="" name="" id="porcentaje" class="form-control form-control-sm">
			    </div>
			</div>
		    <script>
			    //show & hide para avales
			    $("#div_aval").hide();
			    $("#div_porcentaje").hide();
			    //show & hide para avales    
			    $('#relaciones').on('change', function() {
				    if ( this.value == '2'){
					    $("#div_aval").show();
					    $("#div_porcentaje").hide();
					}
					else if ( this.value == '1'){
					    $("#div_aval").hide();
					    $("#div_porcentaje").show();
					}
					else{
						$("#div_aval").hide();
						$("#div_porcentaje").hide();
					}
			    });
			</script>

                    <div class="form-group row" style="margin:0px; padding:0px;">
                        <div class="col-sm-12 col-md-12 col-lg-12 text-right" style="margin-bottom: 12px; margin-top: 0px;">
                        	<button type="button" class="btn btn-success btn-sm" onclick="$.fn.guardar_relacion();"><i class="fas fa-save"></i>&nbsp;Guardar</button>
						<button type="button" class="btn btn-danger btn-sm" onclick="$.fn.agregar_relaciones_cancel();"><i class="fas fa-ban"></i>Cancelar</button>
                        </div>
                    </div>

	<?php } ?>


	<?php function main_relaciones($param)
	{
	    ?>
		<div class="form-group row" style="margin:0px; padding:0px;">
			<div class="col-sm-12 col-md-4 col-lg-12" style="margin-bottom: 12px; margin-top: 0px;" id="tabla_relaciones">
				<?php create_table_relaciones($param); ?>
			</div>                                
		</div>
		<div class="form-group row" style="margin:0px; padding:0px;">
			<div class="col-sm-12 col-md-6 col-lg-12" style="margin-bottom: 12px; margin-top: 0px;">
				<div class="row">
					<div class="col-lg-12 text-right">
						<a class="btn btn-primary btn-sm text-white" href="../cartera/clientes_alta.php" target="_blank"><i class="fas fa-plus"></i> Alta de Contacto</a>
						<button type="button" onclick="$.fn.agregar_relaciones();" class="btn btn-info btn-sm"><i class="fas fa-address-book"></i> Agregar Relación</button>
					</div>
				</div>
			</div>
		</div>

<?php } ?>
    
    
    
    <?php
    
if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        if (isset($_POST["module"]))
        {
            switch($_POST["module"])
            {
		case "show_egresos":
            	{
            		create_table_egresos($_POST["param"]);
            		break;
            	}
		case "show_ingresos":
            	{
            		create_table_ingresos($_POST["param"]);
            		break;
            	}
		case "show_contactos":
            	{
            		create_table_contacto($_POST["param"]);
            		break;
            	}
		
            	case "show_relaciones":
            	{
            		create_table_relaciones($_POST["param"]);
            		break;
            	}

            	case "show_clientes":
            	{
            		if (isset($_POST["consulta"]))
            		{
            		create_clientes($_POST["consulta"],$_POST["notocar"]);
            		}
            		break;
            	}

            }
        }
    }
    else
    {
        if (isset($_GET["module"]))
        {
            switch($_GET["module"])
            {
		case "create_amortizacion":
		{
		    create_amortizacion($_GET["producto"],$_GET["plazo"],$_GET["monto"],$_GET["fecha_inicio"],$_GET["frecuencia"]);
		    break;
		}
		case "main_egresos":
            	{
            		main_egresos($_GET["param"]);
            		break;
            	}
		case "main_ingresos":
            	{
            		main_ingresos($_GET["param"]);
            		break;
            	}
		case "main_reporte":
            	{
            		main_reporte($_GET["param"]);
            		break;
            	}
		case "main_contacto":
            	{
            		main_contacto($_GET["param"]);
            		break;
            	}
		case "create_fields_egresos":
            	{
            		create_fields_egresos();
            		break;
            	}
		case "create_fields_ingresos":
            	{
            		create_fields_ingresos();
            		break;
            	}
            	case "create_fields_contacto":
            	{
            		create_fields_contacto();
            		break;
            	}
		case "create_reporte":
            	{
            		create_reporte($_GET["param"]);
            		break;
            	}
		case "main_factores":
            	{
            		main_factores($_GET["param"]);
            		break;
            	}
		case "form_nuevo_credito":
		{
		    form_nuevo_credito($_GET["param"]);
		    break;
		}
		case "create_factores":
            	{
            		create_factores($_GET["param"]);
            		break;
            	}
		case "create_avales":
            	{
            		create_avales($_GET["param"]);
            		break;
            	}
            	case "main_relaciones":
            	{
            		main_relaciones($_GET["param"]);
            		break;
            	}

            	case "create_fields_relaciones":
            	{
            		create_fields_relaciones();
            		break;
            	}
		case "main_muebles":
            	{
            		main_muebles($_GET["param"]);
            		break;
            	}
		case "create_fields_muebles":
            	{
            		create_fields_muebles();
            		break;
            	}
		case "main_inmuebles":
            	{
            		main_inmuebles($_GET["param"]);
            		break;
            	}
		case "create_fields_inmuebles":
            	{
            		create_fields_inmuebles();
            		break;
            	}
            }

        }

    }

?>
