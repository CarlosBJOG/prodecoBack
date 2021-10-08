<div id="" class="collapse show" aria-labelledby="datosGarantias" data-parent="#nuevoClienteAlta4">
        <div class="card-body text-grey-d3">
              <!-- MODAL -->
            <form id="formRetiro" name="formRetiro" action="">
              <div class="modal fade modal-lg" id="modalRetiro" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable" role="document">
                  <div class="modal-content">

                    <div class="modal-header">
                      <h5 class="modal-title text-success">Seguro Retiro<span id="titulo"></span></h5>
                      
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>

                    <div class="modal-body ace-scrollbar">
                      
                    <div id="">

                    <div class="row">
                          <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 8px; margin-top: 0px;">
                            <label class="col-form-label form-control-label" >Monto total de seguro</label>
                            <input type="text" name="montoTotal" id="montoTotal" class="form-control form-control-sm" disabled='true' required>
                          </div>

                          <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 8px; margin-top: 0px;" id=""> 
                            <label class="col-form-label form-control-label" >Seleccionar operación</label>
                            <select  name="operacion" id="operacion" class="form-control form-control-sm" required>
                                  <option selected>...</option>
                                  <option value="1">Efectivo</option>
                                  <option value="2">Transferencia ó Depósito</option>
                            </select>
                          </div>   

        
                        </div>

                        <div class="row" id="divDatosBanco">
                          <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 8px; margin-top: 0px;">
                            <label class="col-form-label form-control-label" >Ingresar Comprobante</label>
                            <input type="text" name="comprobante" id="comprobante" class="form-control form-control-sm" required>
                          </div>

                          <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 8px; margin-top: 0px;" id=""> 
                            <label class="col-form-label form-control-label" >Ingresar Banco</label>
                            <input type="text" name="banco" id="banco" class="form-control form-control-sm" required>
                          </div>   

        
                        </div>

                        <div class="row" >
                          <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 8px; margin-top: 0px;">
                            <label class="col-form-label form-control-label" >Ingresar Monto a Retirar</label>
                            <input type="number" name="retiro" id="retiro" class="form-control form-control-sm" required>
                          </div>

                          <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 8px; margin-top: 0px;">
                            <label class="col-form-label form-control-label" >Observaciones</label>
                            <input type="text" name="observaciones" id="observaciones" class="form-control form-control-sm" required>
                          </div>


        
                        </div>

                       
                    </div>

                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" id="cerrar" data-dismiss="modal">Cerrar</button>
                      <button type="button" id="btnRetirarSeguro" class="btn btn-success">Aplicar cobro</button>
                      <a class="btn btn-success" id="btnImprimirRetiro"  target="_blank" role="button">Imprimir</a>
                    </div>

                  </div>
                </div>
              </div>
            </form>
                    
                </div> <!-- / class="collapse" -->
            </div> <!-- / Card Garantias -->

   
   
   
   
   
   
   
    </div> <!-- /PRINCIPAL-->    