<!-- Búsqueda clientes -->
<?php function create_busqueda_cliente(){ ?>
	<div class="modal fade" id="modal_relaciones" tabindex="-1" role="dialog" aria-labelledby="modal_relacionesLabel" aria-hidden="true" data-keyboard="false" and data-backdrop="static">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header"><h5 class="modal-title" id="modal_relacionesLabel">Busqueda de Clientes</h5></div>
				<div class="modal-body">
					<div class="form-group row" style="margin:0px; padding:0px;">
						<div class="col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 12px; margin-top: 0px;">
							<label class="col-form-label form-control-label" style="margin-top: 0px;">Nombre del Cliente<span style="color:red;">*</span></label>
							<input class="form-control form-control-sm" type="text" value="" id="caja_busqueda" name="caja_busqueda">
						</div>
						</div>
							<div class="form-group row" style="margin:0px; padding:0px;">
							<div class="col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 12px; margin-top: 0px;">
							<div id="resultado_relaciones"></div>
						</div>
					</div>
				</div>
				<div class="modal-footer"><button type="button" class="btn btn-danger btn-sm" onclick="$.fn.agregar_relaciones_cancel();" data-dismiss="modal">Cancelar</button></div>
			</div>
		</div>
	</div>
<?php } ?>



