<?php 
/*

$ia =72;
$plazo_mensual =12;
$monto_total =30000;
$frecuencia= 3;
$iva = 1.16;
$fecha ='19-10-2020';

$res = gererar_tabla_amortizacion($ia, $plazo_mensual, $monto_total, $frecuencia, $iva, $fecha);
$response['tabla'] = $res;

//$array = json_decode($res);
foreach ($res as $value) {
   echo $value['fecha_temp'] .": ". $value['fecha_pago']."<br>";
}
*/
class Generador_tablas{
		public $iva;
		public $ia;
		public $monto_total;
		public $plazo_mensual;
		public $numero_de_pago;
		public $numero_pagos_semanales;

	public function __construct($monto_total,$plazo_mensual, $ia , $iva){

		$this->iva =$iva;
		$this->ia = $ia;
		$this->monto_total = $monto_total;
		$this->plazo_mensual = $plazo_mensual;
		
		$this->numero_pagos_semanales = 0;
		$this->interes_semanal = 0;
	}

	//sacar numero de semanas a pagar en base a su plazo mensual
	public function setPagosSemanales(){
		if ($this->plazo_mensual == 6) {

			$this->numero_pagos_semanales = 24;

		}elseif ($this->plazo_mensual == 4) {

			$this->numero_pagos_semanales = 16;

		}elseif ($this->plazo_mensual == 8) {
			
			$this->numero_pagos_semanales = 32;
			# code...
		}elseif ($this->plazo_mensual == 10) {

			$this->numero_pagos_semanales = 40;
			# code...
		}elseif ($this->plazo_mensual == 12) {
			
			$this->numero_pagos_semanales = 52;

		}elseif ($this->plazo_mensual == 18) {
			
			$this->numero_pagos_semanales = 77;

		}else{
			$this->numero_pagos_semanales = round($this->plazo_mensual * (30/7));
		}

		
	}

	public function getPagosSemanales(){
		return $this->numero_pagos_semanales;
	}

	//generar interes semanal
	public function setInteSemanal(){
		$this->interes_semanal = (($this->ia/360)*(7/100)*$this->iva);
	}
	public function getInteSemanal(){
		return $this->interes_semanal;
	}

	//sacar numero de quincenas a pagar en base a su plazo mensual
	public function setPagosQuincenal(){
		$this->numero_pagos_quincenales = round($this->plazo_mensual * 2);
	}
	public function getPagosQuincenales(){
		return $this->numero_pagos_quincenales;
	}

	//generar interes quincenal
	public function setInteQuincenal(){
		$this->interes_quincenal = (($this->ia/360)*(15/100)*$this->iva);
	}
	public function getInteQuincenal(){
		return $this->interes_quincenal;
	}

    //sacar numero de meses a pagar en base a su plazo mensual
	public function setPagosMensual(){
		$this->numero_pagos_mensuales = $this->plazo_mensual;
	}
	public function getPagosMensual(){
		return $this->numero_pagos_mensuales;
	}

		//generar interes mensual
	public function setInteMensual(){
		$this->interes_mensual =($this->ia/12)/100*$this->iva ;

	}
	public function getInteMensual(){
		return $this->interes_mensual;
	}

	public function crearTabla ($interes_de_pagos,$iva_de_pagos,  $capital, $monto_total ,$total, $i, $fecha_pago,$fecha_temp, $total_pagos) {
	//RELLENADO DE CEROS

		$interes_semanal_de_pagosFORMAT = sprintf("%.02f",$interes_de_pagos);
		$iva_de_pagos_semanalesFORMAT = sprintf("%.02f",$iva_de_pagos );
		$capitalFORMAT = sprintf("%.02f", $capital);
		$monto_totalFORMAT =  sprintf("%.02f",$monto_total);
		$total_format = sprintf("%.02f",$total);

		$array_semanal = array('no_pago' => $i+1,
						'fecha_temp' => $fecha_temp,
						'fecha_pago' => $fecha_pago,
						'interes' => $interes_semanal_de_pagosFORMAT,
						'iva' => $iva_de_pagos_semanalesFORMAT,
						'capital' => $capitalFORMAT,
						'total' => $total_format,
						'nuevo_saldo' => $monto_totalFORMAT,
						'npagos' => $total_pagos);
		
		return $array_semanal;
	}

	public function interesFuncion($monto_total, $interes_semanal, $iva ){
		$interes_semanal_de_pagos = round($monto_total * ($interes_semanal/$iva), 2);
	
		return $interes_semanal_de_pagos;
	}

	public function iva_dePagosFuncion($interes_semanal_de_pagos){

		$iva_de_pagos_semanales = round(($interes_semanal_de_pagos*0.16), 2);
		return $iva_de_pagos_semanales ;
	}

	public function capital_calculo ($monto_total, $interes_semanal, $total_pagos_semanales, $i, $interes_semanal_de_pagos,$iva ){

		$capital = round(($monto_total * ($interes_semanal / (1 - pow(1 + $interes_semanal, -$total_pagos_semanales + $i))) - $interes_semanal_de_pagos * $iva), 2);

		return $capital;
	}

	public function total_calculo($interes_semanal_de_pagos, $iva_de_pagos_semanales, $capital){
		$total = ($interes_semanal_de_pagos + $iva_de_pagos_semanales + $capital);

		return $total;
	}

	public function calculo_pagos_unicos($monto_total, $interes, $total_pagos){
		$monto_total = $monto_total * $interes * $total_pagos;
		return $monto_total;

	}

}

function gererar_tabla_amortizacion($ia, $plazo_mensual, $monto_total, $frecuencia, $iva, $fecha){
		//Variables
		$i = 0;
		$capital = 0; 
		$total = 0;
		$array_semanal = array();
		$array_semanal2 = array();
		$array_json = array();
		$array_json2 = array();
		$fecha_real = date($fecha);

		//fechas
		$fecha_real = strtotime($fecha_real);
		$dia = date("N", $fecha_real);
		$fecha_real = date("d-m-Y", $fecha_real);
		// $fecha_temp  = $fecha_real;
		$fecha_pago  = $fecha_real;

		if ($frecuencia == 1) {//Semanal
				//calculo semanal
			$tabla = new Generador_tablas($monto_total, $plazo_mensual, $ia, $iva);
			//generar pagos semanales
			$tabla->setPagosSemanales();
			$total_pagos = (int)$tabla->getPagosSemanales();

			//generar interes semanal
			$tabla->setInteSemanal();
			$interes = round($tabla->getInteSemanal(), 9);

			$interes_de_pagos = $tabla->interesFuncion($monto_total, $interes, $iva );
			$iva_de_pagos =$tabla->iva_dePagosFuncion($interes_de_pagos);	
			$capital =$tabla->capital_calculo($monto_total, $interes, $total_pagos, $i, $interes_de_pagos,$iva );
			$total = $tabla->total_calculo($interes_de_pagos, $iva_de_pagos, $capital);
			$m =1;
			$o = 0;
			for($i = 0; $i <$total_pagos; $i++){
				//
				$interes_de_pagos = $tabla->interesFuncion($monto_total, $interes, $iva );
				$iva_de_pagos= $tabla->iva_dePagosFuncion($interes_de_pagos);
				$capital = $tabla->capital_calculo($monto_total, $interes, $total_pagos, $i, $interes_de_pagos,$iva );
				$total = $total;
				$monto_total = round(($monto_total - $capital),2);

				// $fecha_temp = strtotime($fecha_temp."+ $o week");
				// $dia = date("N", $fecha_temp);
				// $fecha_temp = date("d-m-Y", $fecha_temp);
				$fecha_pago = strtotime($fecha_pago."+ $o week");
				$dia = date("N", $fecha_pago);
				$fecha_pago = date("d-m-Y", $fecha_pago);


				if($dia == 5){
					// $fecha_pago  = strtotime($fecha_temp."- 4 days");
					// $fecha_pago = date("d-m-Y", $fecha_pago);
					$fecha_temp  = strtotime($fecha_pago."- 4 days");
					$fecha_temp = date("d-m-Y", $fecha_temp);
			
				}
				if ($m == $total_pagos) {
					$monto_total = 0;
				}

				$array_semanal =  $tabla->crearTabla ($interes_de_pagos,$iva_de_pagos, $capital, $monto_total , $total, $i, $fecha_pago, $fecha_temp, $total_pagos);

				//$array_semanal2 =  $tabla->crearTabla ($interes_de_pagos,$iva_de_pagos, $capital, $monto_total , $total, $i, $fecha_nueva2);
				$m+=1;
				$o = 1;
				array_push($array_json, $array_semanal);

			}

		}


		if($frecuencia == 2) { //Quincenal
				//calculo quincenal
			$tabla = new Generador_tablas($monto_total, $plazo_mensual, $ia, $iva);
			//generar pagos quincenal
			$tabla->setPagosQuincenal();
			$total_pagos = (int)$tabla->getPagosQuincenales();

			//generar interes quincenal
			$tabla->setInteQuincenal();
			$interes =round ($tabla->getInteQuincenal(), 9);
			$interes_de_pagos = $tabla-> interesFuncion($monto_total, $interes, $iva );
			$iva_de_pagos = $tabla-> iva_dePagosFuncion($interes_de_pagos);	
			$capital = $tabla->capital_calculo($monto_total, $interes, $total_pagos, $i, $interes_de_pagos,$iva );
			$total = $tabla-> total_calculo($interes_de_pagos, $iva_de_pagos, $capital);
			$o = 0;
			$m = 1;
			for($i = 0; $i <$total_pagos; $i++){
			
				//
				$interes_de_pagos = $tabla->interesFuncion($monto_total, $interes, $iva );
				$iva_de_pagos= $tabla->iva_dePagosFuncion($interes_de_pagos);
				$capital =$tabla-> capital_calculo($monto_total, $interes, $total_pagos, $i, $interes_de_pagos,$iva );
				$total = $total;
				$monto_total = round(($monto_total - $capital),2);

				// $fecha_temp = strtotime($fecha_temp."+ $o days");
				// $dia = date("N", $fecha_temp);
				// $fecha_temp = date("d-m-Y", $fecha_temp);

				$fecha_pago = strtotime($fecha_pago."+ $o days");
				$dia = date("N", $fecha_pago);
				$fecha_pago = date("d-m-Y", $fecha_pago);

				if($dia == 5){
					// $fecha_pago  = strtotime($fecha_temp."+ 4 days");
					// $fecha_pago = date("d-m-Y", $fecha_pago);

					$fecha_temp  = strtotime($fecha_pago."- 4 days");
					$fecha_temp = date("d-m-Y", $fecha_temp);
				
				}
				if ($m == $total_pagos) {
						$monto_total = 0;
				}
				

				$array_semanal =  $tabla->crearTabla ($interes_de_pagos,$iva_de_pagos, $capital, $monto_total , $total, $i, $fecha_pago, $fecha_temp, $total_pagos);
				$o = 14;
				$m+=1;

				array_push($array_json, $array_semanal);
			}

		}

		else if($frecuencia == 3) {//mensual
				//calculo mensual
			$tabla = new Generador_tablas($monto_total, $plazo_mensual, $ia, $iva);
			//generar pagos mensual
			$tabla->setPagosMensual();
			$total_pagos = (int)$tabla-> getPagosMensual();

			//generar interes mensual
			$tabla->setInteMensual();
			$interes =round ($tabla->getInteMensual(), 9);
			
			$interes_de_pagos = $tabla->interesFuncion($monto_total, $interes, $iva );
			$iva_de_pagos = $tabla->iva_dePagosFuncion($interes_de_pagos);	
			$capital = $tabla->capital_calculo($monto_total, $interes, $total_pagos, $i, $interes_de_pagos,$iva );
			$total = $tabla->total_calculo($interes_de_pagos, $iva_de_pagos, $capital);
			$o = 0;
			$m =1;
			for($i = 0; $i <$total_pagos; $i++){
				$interes_de_pagos = $tabla->interesFuncion($monto_total, $interes, $iva );
				$iva_de_pagos= $tabla->iva_dePagosFuncion($interes_de_pagos);
				$capital = $tabla->capital_calculo($monto_total, $interes, $total_pagos, $i, $interes_de_pagos,$iva );
				$total = $total;
				$monto_total = round(($monto_total - $capital), 2);

				// $fecha_temp = strtotime($fecha_temp."+ $o days");
				// $dia = date("N", $fecha_temp);
				// $fecha_temp = date("d-m-Y", $fecha_temp);

				$fecha_pago = strtotime($fecha_pago."+ $o days");
				$dia = date("N", $fecha_pago);
				$fecha_pago = date("d-m-Y", $fecha_pago);

				if($dia == 5){
					// $fecha_pago  = strtotime($fecha_temp."+ 4 days");
					// $fecha_pago = date("d-m-Y", $fecha_pago);

					$fecha_temp  = strtotime($fecha_pago."- 4 days");
					$fecha_temp = date("d-m-Y", $fecha_temp);
				
				}
				
				if ($m == $total_pagos) {
					$monto_total = 0;
				}

				$array_semanal =  $tabla->crearTabla ($interes_de_pagos,$iva_de_pagos, $capital, $monto_total , $total, $i, $fecha_pago, $fecha_temp, $total_pagos);
				$m+=1;	
				$o = 28;
				array_push($array_json, $array_semanal);

			}

		}

		if ($frecuencia == 4) {//pago único

			$tabla = new Generador_tablas($monto_total, $plazo_mensual, $ia, $iva);


			$total_pagos2 = 1;
			
			$tabla->setPagosMensual();
			$total_pagos = (int)$tabla-> getPagosMensual();
			
			
			$tabla->setInteMensual();
			$interes =round ($tabla->getInteMensual(), 9);

			$interes_de_pagos = $monto_total*$interes / $iva*$plazo_mensual;

			$iva_de_pagos = $interes_de_pagos*0.16;	
			$capital = $monto_total;
			$total = $interes_de_pagos + $iva_de_pagos + $capital;
			$monto_total = $monto_total - $capital;

			$interes_semanal_de_pagosFORMAT = sprintf("%.02f",$interes_de_pagos);
			$iva_de_pagos_semanalesFORMAT = sprintf("%.02f",$iva_de_pagos );
			$capitalFORMAT = sprintf("%.02f", $capital);
			$monto_totalFORMAT =  sprintf("%.02f",$monto_total);
			$total_format = sprintf("%.02f",$total);

			$o = 0;
			// $fecha_temp = strtotime($fecha_temp."+ $o week");
			// $dia = date("N", $fecha_temp);
			// $fecha_temp = date("d-m-Y", $fecha_temp);

			$fecha_pago = strtotime($fecha_pago."+ $o days");
			$dia = date("N", $fecha_pago);
			$fecha_pago = date("d-m-Y", $fecha_pago);

			if($dia == 5){
				// $fecha_pago  = strtotime($fecha_temp."+ 4 days");
				// $fecha_pago = date("d-m-Y", $fecha_pago);

				$fecha_temp  = strtotime($fecha_pago."- 4 days");
				$fecha_temp = date("d-m-Y", $fecha_temp);
			
			}

			$array_semanal = array('no_pago' => $total_pagos2,
							'fecha_pago' => $fecha_pago,
							'fecha_temp' => $fecha_temp,
							'interes' => $interes_semanal_de_pagosFORMAT,
							'iva' => $iva_de_pagos_semanalesFORMAT,
							'capital' => $capitalFORMAT,
							'total' => $total_format,
							'nuevo_saldo' => $monto_totalFORMAT,
							'npagos' => 1);

			array_push($array_json, $array_semanal);
			$json = json_encode($array_json);

		}

		return  $array_json;
}

function gererar_tabla_amortizacion_condonacion($plazo_mensual, $monto_total, $frecuencia, $fecha){
		//Variables
		$i = 0;
		$capital = 0; 
		$total = 0;
		$array_semanal = array();
		$array_semanal2 = array();
		$array_json = array();
		$array_json2 = array();
		$fecha_real = date($fecha);

		//fechas
		$fecha_real = strtotime($fecha_real);
		$dia = date("N", $fecha_real);
		$fecha_real = date("d-m-Y", $fecha_real);
		// $fecha_temp  = $fecha_real;
		$fecha_pago  = $fecha_real;

		if ($frecuencia == 1) {//Semanal
				//calculo semanal
			$tabla = new Generador_tablas($monto_total, $plazo_mensual, 0, 0);
			//generar pagos semanales
			$tabla->setPagosSemanales();
			$total_pagos = (int)$tabla->getPagosSemanales();

			//generar interes semanal
			$tabla->setInteSemanal();
			//$interes = round($tabla->getInteSemanal(), 9);

			//$interes_de_pagos = $tabla->interesFuncion($monto_total, $interes, $iva );
			//$iva_de_pagos =$tabla->iva_dePagosFuncion($interes_de_pagos);	
			//$capital =$tabla->capital_calculo($monto_total, $interes, $total_pagos, $i, $interes_de_pagos,$iva );
			$capital = $monto_total / $total_pagos;
			$total = $capital;
			$m =1;
			$o = 0;
			for($i = 0; $i <$total_pagos; $i++){
				$total = $total;
				$monto_total = round(($monto_total - $capital),2);

				$fecha_pago = strtotime($fecha_pago."+ $o week");
				$dia = date("N", $fecha_pago);
				$fecha_pago = date("d-m-Y", $fecha_pago);


				if($dia == 5){
					// $fecha_pago  = strtotime($fecha_temp."- 4 days");
					// $fecha_pago = date("d-m-Y", $fecha_pago);
					$fecha_temp  = strtotime($fecha_pago."- 4 days");
					$fecha_temp = date("d-m-Y", $fecha_temp);
			
				}
				if ($m == $total_pagos) {
					$monto_total = 0;
				}

				$array_semanal =  $tabla->crearTabla (0,0, $capital, $monto_total , $total, $i, $fecha_pago, $fecha_temp, $total_pagos);

				$m+=1;
				$o = 1;
				array_push($array_json, $array_semanal);

			}

		}


		if($frecuencia == 2) { //Quincenal
				//calculo quincenal
			$tabla = new Generador_tablas($monto_total, $plazo_mensual, 0,0 );
			//generar pagos quincenal
			$tabla->setPagosQuincenal();
			$total_pagos = (int)$tabla->getPagosQuincenales();

			//generar interes quincenal
			$tabla->setInteQuincenal();
			$capital = $monto_total / $total_pagos;
			$total = $capital;
			$o = 0;
			$m = 1;
			for($i = 0; $i <$total_pagos; $i++){
			
				$total = $total;
				$monto_total = round(($monto_total - $capital),2);

				$fecha_pago = strtotime($fecha_pago."+ $o days");
				$dia = date("N", $fecha_pago);
				$fecha_pago = date("d-m-Y", $fecha_pago);

				if($dia == 5){
					$fecha_temp  = strtotime($fecha_pago."- 4 days");
					$fecha_temp = date("d-m-Y", $fecha_temp);
				
				}
				if ($m == $total_pagos) {
						$monto_total = 0;
				}
				

				$array_semanal =  $tabla->crearTabla (0,0, $capital, $monto_total , $total, $i, $fecha_pago, $fecha_temp, $total_pagos);
				$o = 14;
				$m+=1;

				array_push($array_json, $array_semanal);
			}

		}

		else if($frecuencia == 3) {//mensual
				//calculo mensual
			$tabla = new Generador_tablas($monto_total, $plazo_mensual, 0, 0);
			//generar pagos mensual
			$tabla->setPagosMensual();
			$total_pagos = (int)$tabla-> getPagosMensual();
			
			$capital = $monto_total / $total_pagos;
			$total = $capital;
			$o = 0;
			$m =1;
			for($i = 0; $i <$total_pagos; $i++){
				$monto_total = round(($monto_total - $capital), 2);

				$fecha_pago = strtotime($fecha_pago."+ $o days");
				$dia = date("N", $fecha_pago);
				$fecha_pago = date("d-m-Y", $fecha_pago);

				if($dia == 5){
					$fecha_temp  = strtotime($fecha_pago."- 4 days");
					$fecha_temp = date("d-m-Y", $fecha_temp);
				}
				
				if ($m == $total_pagos) {
					$monto_total = 0;
				}

				$array_semanal =  $tabla->crearTabla (0,0, $capital, $monto_total , $total, $i, $fecha_pago, $fecha_temp, $total_pagos);
				$m+=1;	
				$o = 28;
				array_push($array_json, $array_semanal);

			}

		}

		if ($frecuencia == 4) {//pago único

			$tabla = new Generador_tablas($monto_total, $plazo_mensual, 0,0);


			$total_pagos2 = 1;
			
			$tabla->setPagosMensual();
			$total_pagos = (int)$tabla-> getPagosMensual();
			

			$capital = $monto_total;
			$total = $capital;
			$monto_total = $monto_total - $capital;

			
			$capitalFORMAT = sprintf("%.02f", $capital);
			$monto_totalFORMAT =  sprintf("%.02f",$monto_total);
			$total_format = sprintf("%.02f",$total);

			$o = 0;

			$fecha_pago = strtotime($fecha_pago."+ $o days");
			$dia = date("N", $fecha_pago);
			$fecha_pago = date("d-m-Y", $fecha_pago);

			if($dia == 5){

				$fecha_temp  = strtotime($fecha_pago."- 4 days");
				$fecha_temp = date("d-m-Y", $fecha_temp);
			
			}

			$array_semanal = array('no_pago' => $total_pagos2,
							'fecha_pago' => $fecha_pago,
							'fecha_temp' => $fecha_temp,
							'interes' => 0,
							'iva' => 0,
							'capital' => $capitalFORMAT,
							'total' => $total_format,
							'nuevo_saldo' => $monto_totalFORMAT,
							'npagos' => 1);

			array_push($array_json, $array_semanal);
			$json = json_encode($array_json);

		}

		return  $array_json;
}



// $fecha_real = date("11-12-2020");
// $ia = 62.40;
// $plazo_mensual =6;
// $monto_total = 50000;
// $frecuencia = 1;
// $iva = 1.16;
// //fechas

// $tabla = gererar_tabla_amortizacion($ia, $plazo_mensual, $monto_total, $frecuencia, $iva, $fecha_real);
// var_dump($tabla);
 ?>