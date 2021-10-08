<?php 

	require_once "db.php";
	require_once "functions.php";

	function create_fields_mueble(){ ?>
	<input type='hidden' name='idkey_cliente' id='idkey_cliente' value='<?php echo $_GET["idkey_cliente"];?>'>
	<div id="form_mueble">
		<div class="row text-center">
			<div class="col-sm-12 col-md-3 col-lg-4" style="margin-bottom: 12px; margin-top: 0px;">
				<label class="col-form-label form-control-label" style="margin-top: 0px;">Valor comercial<span style="color:red;">*</span></label>
				<input type="" name="" id="valor_comercial" class="form-control form-control-sm">
			</div>
			<div class="col-sm-12 col-md-3 col-lg-4">
				<label class="col-form-label form-control-label" >Marca<span style="color:red;">*</span></label>
				<input type="" name="" id="marca" class="form-control form-control-sm">
			</div>
			<div class="col-sm-12 col-md-3 col-lg-4">
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
				</div>
			</div>
		</div>
	</div>
	</div>
	<!-- INMUEBLE-->
	<input type='hidden' name='idkey_cliente' id='idkey_cliente' value='<?php echo $_GET["idkey_cliente"];?>'>
	<div id="form_inmueble" >
		<div class="row">
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
			<div class="col-sm-12 col-md-3 col-lg-3">
				<label class="col-form-label form-control-label" >Escritura<span style="color:red;">*</span></label>
				<input type="" name="" id="escritura" class="form-control form-control-sm" placeholder="Num. Escritura">
			</div>                               
		</div>
		<div class="row">
			<div class="col-sm-12 col-md-3 col-lg-3">
				<label class="col-form-label form-control-label" >Registro<span style="color:red;">*</span></label>
				<input type="" name="" id="registro" class="form-control form-control-sm">
			</div>                               
			<div class="col-sm-12 col-md-3 col-lg-3">
				<label class="col-form-label form-control-label" >Gravamen<span style="color:red;">*</span></label>
				<input type="" name="" id="gravamen" class="form-control form-control-sm">
			</div>
			<div class="col-sm-12 col-md-3 col-lg-3">
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
				</div>
			</div>
		</div>
	</div>

 <?php } ?>
 
<?php function create_table_mueble($param)
	    { ?>
		<div>HOLA</div>
		<?php } ?>
 
<?php function main_mueble($param)
	    { ?>
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
				<button type="button" onclick="$.fn.agregar_mueble();" class="btn btn-info btn-sm">
				    <i class="fas fa-address-book"></i> Agregar
				</button>
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
		case "show_muebles":
            	{
            		create_table_muebles($_POST["param"]);
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
				case "main_muebles":
            	{
            		main_muebles($_GET["param"]);
            		break;
            	}
            }
        }
    }

?>


