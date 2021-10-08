<!---- MODAL CAMBIOS DE CRÉDITO-->
<?php require_once "../php/funciones_cartera.php";?>
  <form id="formCambios" name="formCambios" action="">
    <div class="modal fade modal-lg" id="modalCambios" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-lg" role="document">
        <div class="modal-content">

          <div class="modal-header">
            <h5 class="modal-title text-success" id="titulo"></h5>
            <input hidden id="idkey_credito" name="idkey_credito"> 
            <input  hidden id="idkey_tipo_cambio" name="idkey_tipo_cambio"> 
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body ace-scrollbar">
            <div id="formRees"  aria-labelledby="Reestructuracion" >
                      
                <!---***********Contenido -->
                <div class="form-group row" style="margin:0px; padding:0px;">


                  <div class="row border-t-0 brc-grey-l1 py-3">
                    <div class="col-sm-12 col-md-6 col-lg-6">
                      <p class="text-600 text-grey">
                        <label >Folio de Autorización</label><span style="color:red;">*</span>
                        <input type="text" class="form-control" id="folio" name = "folio" placeholder="" required>
                      </p>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6">
                      <label class="col-form-label form-control-label mt-0 text-600 text-grey">Fecha de Registro<span style="color:red;">*</span></label>
                      <div class="input-group date" id="id-timepicker">
                        <div class="input-group-addon input-group-append">
                          <div class="input-group-text">
                            <i class="fa fa-calendar"></i>
                          </div>
                        </div>
                        <input type="text" class="form-control form-control-sm" id="fecha_registro"  name="fecha_registro" autocomplete="off" required>
                        <script> $('#fecha_registro').activeCalendary('#fecha_registro'); </script>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6">
                      <p class="text-600 text-grey">
                        <label >Plazo en meses</label><span style="color:red;">*</span>
                        <input type="number" class="form-control" id="plazo_meses" name = "plazo_meses"  required>
                      </p>
                    </div>
                    <div class="col-lg-6 col-sm-12 col-md-6">     
                        <p class="text-600 text-grey">
                        <label for="tipo-producto">Frecuencia</label><span style="color:red;">*</span>
                        <select class="ace-select text-dark-m1 bgc-default-l5 bgc-h-warning-l3  brc-default-m3 brc-h-warning-m1" id="frecuencia" name="frecuencia" required>
                            <?php consulta_frecuencia_cred(); ?>
                        </select>
                        </p>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6">
                      <label class="col-form-label form-control-label mt-0 text-600 text-grey">Fecha de primer pago<span style="color:red;">*</span></label>
                      <div class="input-group date" id="id-timepicker">
                        <div class="input-group-addon input-group-append">
                          <div class="input-group-text">
                            <i class="fa fa-calendar"></i>
                          </div>
                        </div>
                        <input type="text" class="form-control form-control-sm" id="fecha_pago1"  name="fecha_pago1" autocomplete="off" required>
                        <script> $('#fecha_pago1').activeCalendary('#fecha_pago1'); </script>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6">
                      <p class="text-600 text-grey">
                        <label>Saldo insoluto</label>
                        <input type="text" readonly class="form-control" id="saldo_insoluto" name="saldo_insoluto" >
                      </p>
                    </div>
                    <div class=" col-lg-12 col-sm-12 col-md-12 mb-3">            
                        <label for="tipo-producto" class="text-600 text-grey">Observaciones</label>
                        <p class="text-secondary-m2 text-105">
                        <textarea class="form-control" id="observaciones" name="observaciones" maxlength="200"></textarea>        
                        </p>            
                    </div>
                </div>



              </div>
              <!--Fin de contenido-->

            </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-success">Guardar Cambios</button>
          </div>

        </div>
      </div>
    </div>
  </div>
  </form>
<!---//FIN DE MODAL DE DIRECCIONES -->


<script type="text/javascript">

$(document).ready(function(){

  $("#formCambios").validate({
      errorClass: 'text-error',  
      ignore: false,
      rules:{fecha_pago1:{FechaViernes: true, FechaPosterior: true}}
  });

  //Envío de formulario ****************************************************************************************
  $("#formCambios" ).submit(function( event ) {
      if($("#formCambios").valid()){
        guardar_cambios_pagos_credito();
      }
      event.preventDefault();
    });

});
</script>