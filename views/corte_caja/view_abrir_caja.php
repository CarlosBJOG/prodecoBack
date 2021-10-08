<div id="" class="collapse show" aria-labelledby="datosGarantias" data-parent="#nuevoClienteAlta4">
        <div class="card-body text-grey-d3">
              <!-- MODAL -->
            <form id="form_corte" name="form_corte" action="">
              <div class="modal fade modal-lg" id="modalCaja" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable" role="document">
                  <div class="modal-content">

                    <div class="modal-header">
                      <h5 class="modal-title text-success">Caja - Abrir Corte</h5>
                      <input  type="hidden" id="idkey_mueble" name="idkey_mueble"> 
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>

                    <div class="modal-body ace-scrollbar">
                      
                    <div id="form_mueble">

                        <div class="row">

                          <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 8px; margin-top: 0px;">
                            <label class="col-form-label form-control-label" style="margin-top: 0px;">Fecha</label>
                            <input type="text" name="fecha" id="fecha" class="form-control form-control-sm" disabled='true' required>
                          </div>

                          <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 8px; margin-top: 0px;">
                              <h6 class="text-danger mt-4 ml-2 mb-0">*<small class="text-secondary ">Ingresar el monto que se utilizar&aacute; como fondo para la caja</small> </h6>
                          </div>

                        
                        </div>

                        <div class="row">
                          <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 8px; margin-top: 0px;">
                            <label class="col-form-label form-control-label" >Hora</label>
                            <input type="" name="hora" id="hora" class="form-control form-control-sm" disabled='true' required>
                          </div>

                                 <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 8px; margin-top: 0px;">
                            <label class="col-form-label form-control-label" >Usuario</label>
                            <input type="" name="usuario" id="usuario" class="form-control form-control-sm" disabled='true' required>
                          </div>
                        </div>
                        
                        <div class="row">
                  
                          <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 8px; margin-top: 0px;">
                            <label class="col-form-label form-control-label" >Efectivo</label>
                            <input type="" name="efectivo" id="efectivo" class="form-control form-control-sm" disabled='true' required>
                          </div>    

                          <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 8px; margin-top: 0px;">
                            <label class="col-form-label form-control-label text-success" >Fondo (actual en caja)</label>
                            <input type="number" name="fondo" id="fondo" class="form-control form-control-sm" required>
                          </div>   
                     
                        </div>
                    </div>

                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" id="cerrar" data-dismiss="modal">Cerrar</button>
                      <button type="button" id="btnAbrircorte" onclick="ModuloCorte.abrir_corte()" class="btn btn-success">Abrir Corte</button>
                    </div>

                  </div>
                </div>
              </div>
            </form>
                    
                </div> <!-- / class="collapse" -->
            </div> <!-- / Card Garantias -->

   
   
   
   
   
   
   
    </div> <!-- /PRINCIPAL-->    