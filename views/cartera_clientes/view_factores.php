<div id="div-calcular-fact">
	<button onclick="comprobar_perfil_cliente();" id="btnCalcularFact" class="btn btn-success  radius-1 border-b-2 d-inline-flex align-items-center pl-2px py-2px btn-bold">
		<span class="bgc-white-tp9 shadow-sm radius-2px h-4 px-25 pt-1 mr-25 border-1">
			<i class="fa fa-check text-white-tp2 text-110 mt-3px"></i>
			Ver/Llenar Información Adicional
		</span>
		
	</button>
</div>

<form name="formFactores" id="formFactores">
	<input  type="hidden" id="idkey_factores" name="idkey_factores"> 
    <div class="row justify-content-md-center">
		<div class="col-lg-8 col-12 pr-lg-0 mt-3 mt-lg-0 p-3">
	    	<div class="h-100 bg-white pt-0 radius-1 shadow-sm mx-auto">
				<div class="border-t-3 w-100 brc-success-tp2 radius-t-2"></div>
		  		<div class="card-body p-3 px-sm-1 px-lg-0 brc-default-l2">
					<table class="table brc-grey-l3 table-striped mb-2" >
						<thead class="text-success">
							<th style="min-width:150px">Característica</th>
							<th style="min-width:200px">Descripción</th>
						</thead>
						<tbody>
							<tr>
							    <td>Historial Crediticio Buró de Crédito</td>
							    <td>
									<select id="historial_buro" name="historial_buro"class="ace-select text-dark-m1 bgc-default-l5 bgc-h-warning-l3  brc-default-m3 brc-h-warning-m1">
									    <?php create_fburo(); ?>
									</select>
							    </td>
							</tr>
							<tr>
							    <td>Experiencia Crediticia</td>
							    <td>
								    <select id="experiencia_crediticia" name="experiencia_crediticia" class="ace-select text-dark-m1 bgc-default-l5 bgc-h-warning-l3  brc-default-m3 brc-h-warning-m1">
									    <?php create_fexp_crediticia(); ?>
									</select>
							    </td>
							</tr>
							<tr>
							    <td>Capacidad de Pago</td>
							    <td>
									<select id="capacidad_pago" name="capacidad_pago" class="ace-select text-dark-m1 bgc-default-l5 bgc-h-warning-l3  brc-default-m3 brc-h-warning-m1">
									    <?php create_fcap_pago(); ?>
									</select>
							    </td>
							</tr>
							<tr>
							    <td>Comprobación de Ingresos</td>
							    <td>
									<select id="comprobacion_ingresos" name="comprobacion_ingresos" class="ace-select text-dark-m1 bgc-default-l5 bgc-h-warning-l3  brc-default-m3 brc-h-warning-m1">
										<?php create_fcomp_ingresos(); ?>
									</select>
							    </td>
							</tr>
							<tr>
							    <td>Referencias</td>
							    <td>
									<select id="referencias" name="referencias" class="ace-select text-dark-m1 bgc-default-l5 bgc-h-warning-l3  brc-default-m3 brc-h-warning-m1">
									    <?php create_freferencias(); ?>
									</select>
							    </td>
							</tr>
							<tr>
							    <td>Conocimiento de la Actividad</td>
							    <td>
									<select id="conocimiento" name="conocimiento" class="ace-select text-dark-m1 bgc-default-l5 bgc-h-warning-l3  brc-default-m3 brc-h-warning-m1">
									    <?php create_factividad(); ?>
									</select>
							    </td>
							</tr>
							<tr>
							    <td>Veracidad</td>
							    <td>
									<select id="veracidad" name="veracidad" class="ace-select text-dark-m1 bgc-default-l5 bgc-h-warning-l3  brc-default-m3 brc-h-warning-m1">
									    <?php create_fveracidad(); ?>
									</select>
							    </td>
							</tr>
							<tr>
							    <td>Garantía Líquida</td>
							    <td>
									<select id="garantia_liquida" name="garantia_liquida" class="ace-select text-dark-m1 bgc-default-l5 bgc-h-warning-l3  brc-default-m3 brc-h-warning-m1">
									    <?php create_fgliquida(); ?>
									</select>
							    </td>
							</tr>
							<tr>
							    <td>Solvencia</td>
							    <td>
								<select id="solvencia" name="solvencia" class="ace-select text-dark-m1 bgc-default-l5 bgc-h-warning-l3  brc-default-m3 brc-h-warning-m1">
								    <?php create_fsolvencia(); ?>
								</select>
							    </td>
							</tr>
						</tbody>
					</table>
					<hr>
					<div class="form-group row" style="margin:0px; padding:0px;">
		                 <div class="col-sm-12 col-md-6 col-lg-7" style="margin-bottom: 12px; margin-top: 10px;">
		                    <div class="row">
		                       <div class="col-lg-4">
		                          <button id="guardar_factores" type="submit" class="btn btn-success btn-sm">
		                            <i class="fas fa-save"></i>&nbsp;Guardar
		                          </button>
		                       </div>
		                    </div>
		                 </div>
		            </div>
				</div> <!-- / card-body -->
			</div> <!-- / card border-0 -->
		</div><!-- / h-100 bg-white -->
	</div> <!-- Col-lg-8 -->
</form>

<div class="form-group row" style="margin:0px; padding:0px;" id="reporte">
	<div class="col-sm-12 col-md-12 col-lg-12 h-100 bg-gray pt-0 radius-1 shadow-sm mx-auto" style="margin-bottom: 12px; margin-top: 10px;">
	<?php
    if(isset($_GET["idkey_cliente"]))
      require("../views/cartera_clientes/view_reporte.php");
    ?>
    </div>               
</div>

<script type="text/javascript">

$(document).ready(function(){
	$("#formFactores").hide();
	$('#tab_finalizar').attr("disabled", true); //Deshabilita el botón siguiente
	$("#reporte").hide();

	$("#formFactores").validate({
      errorClass: 'text-error',  
      ignore: false,
      rules:{}
  	});

	//Envío de formulario ****************************************************************************************
	$("#formFactores" ).submit(function( event ) {
		if($("#formFactores").valid()){
			bootbox.confirm("¿Está seguro que desea enviar ahora la información adicional y completar el perfil?", function(result) {
				if(result){
					$.ajax({
			           url: '../php/json_func_cartera.php',
			           type: 'POST',
			           dataType: 'json',
			           data: $("#formFactores").serialize() + '&funcion=' + 'factores'+'&idkey_cliente='+ $("#idkey_cliente").val()+'&idkey_factores='+ $("#idkey_factores").val(),
			           success: function(response){
			             console.log(response);
			             if(response['error']==0){
			             	alertify.success("Datos guardados correctamente.");
			             	$('#tab_finalizar').attr("disabled", false); 
			             	$("#formFactores").hide(); 
			             	//Cargamos los datos del reporte
			             	$("#f_nombre").html(response['nombre']);
			             	$("#f_nacimiento").html(response['fecha_nac']);
			             	$("#f_rfc").html(response['rfc']);
			             	$("#f_curp").html(response['curp']);
			             	$("#f_domicilio").html(response['direccion']);
							$("#reporte").show();
			             }
			             else
			             	alertify.error("Ha ocurrido un error inesperado! Inténtelo más tarde...");
			           },
			           error: function(data) {
			           		alertify.error("Ha ocurrido un error inesperado! Inténtelo más tarde...");
					        console.log(data);
					    }
			        });
			    }
				/*
			    if(result){
			    	alertify.success("Datos guardados correctamente.");
			    	$('#tab_finalizar').attr("disabled", false); 
					$("#formFactores").hide();
					$("#reporte").show();
			    }*/
			});
		}
	    
	    else
	    	alertify.error("Llena todos los campos.");
	  	event.preventDefault();//Detiene el envío del form y su recarga

	});//envío form*********************************************************************************************

	

});

</script>
		    