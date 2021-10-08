<div id="" class="collapse show" aria-labelledby="datosGarantias" data-parent="#nuevoClienteAlta4">
        <div class="card-body text-grey-d3">
              <!-- MODAL -->
            <form id="form_corte" name="form_cerrarCorte" action="">
              <div class="modal fade modal-lg" id="modalCorte" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable" role="document">
                  <div class="modal-content">

                    <div class="modal-header">
                      <h5 class="modal-title text-success">Caja - Cerrar Corte</h5>
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
                            <input type="text" name="fecha" id="fecha_corte" class="form-control form-control-sm" disabled='true' required>
                          </div>

                          <div class="col-sm-12 col-md-6 col-lg-4" style="margin-bottom: 8px; margin-top: 0px;">
                            <label class="col-form-label form-control-label" style="margin-top: 0px;">N&uacute;mero de Corte</label>
                            <input type="text" name="fecha" id="num_corte" class="form-control form-control-sm" disabled='true' required>
                          </div>

                        
                        </div>

                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 8px; margin-top: 0px;">
                                <label class="col-form-label form-control-label" >Hora</label>
                                <input type="" name="hora" id="hora_corte" class="form-control form-control-sm" disabled='true' required>
                            </div>

                            <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 8px; margin-top: 0px;">
                            <label class="col-form-label form-control-label" >Fondo</label>
                            <input type="text" name="fondo" id="fondo_corte" class="form-control form-control-sm"  disabled='true' required>
                          </div>   
                             
                        </div>
                        
                        <div class="row">
                  
                          <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 8px; margin-top: 0px;">
                            <label class="col-form-label form-control-label" >Efectivo en caja</label>
                            <input type="" name="efectivo" id="efectivo_corte" class="form-control form-control-sm" disabled='true' required>
                          </div>    

                          <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 8px; margin-top: 0px;">
                            <label class="col-form-label form-control-label " >Total en Caja:</label>
                            <input type="text" name="fondo" id="total_corte" class="form-control form-control-sm"  disabled='true' required>
                          </div>   
                      
                          
                     
                        </div>

                          <div class="row">

                          <div class="col-sm-12 col-md-12 col-lg-6" style="margin-bottom: 8px; margin-top: 0px;">
                              <h6 class="text-danger mt-4 ml-2 mb-0">*<small class="text-secondary ">El monto debe coincidir con el efectivo en caja para poder continuar</small> </h6>
                          </div>

                          <div class="col-sm-12 col-md-12 col-lg-6" style="margin-bottom: 8px; margin-top: 0px;">
                              <h6 class="text-danger mt-4 ml-2 mb-0">*<small class="text-secondary ">Si no se indica el fondo a retirar se guardara el fondo actual</small> </h6>
                          </div>
                            
                        </div>

                        <div class="row">
                  
                          <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 8px; margin-top: 0px;">
                            <label class="col-form-label form-control-label text-success" >Ingresar Efectivo</label>
                            <input type="number" name="efectivo" id="efectivoIngresar" class="form-control form-control-sm" required>
                          </div>    

                          <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 8px; margin-top: 0px;">
                            <label class="col-form-label form-control-label text-success" >Ingresar Fondo</label>
                            <input type="number" name="fondo" id="fondoIngresar" class="form-control form-control-sm" required>
                          </div>   
                     
                        </div>
                    </div>

                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" id="cerrar" data-dismiss="modal">Cerrar</button>
                      <button type="button" id="btnCerrarCorte"  class="btn btn-primary">Cerrar Corte</button>
                    </div>

                  </div>
                </div>
              </div>
            </form>
                    
                </div> <!-- / class="collapse" -->
            </div> <!-- / Card Garantias -->

   
   
   
   
   
   
   
    </div> <!-- /PRINCIPAL-->    