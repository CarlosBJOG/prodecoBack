<div id="" class="collapse show" aria-labelledby="datosGarantias" data-parent="#nuevoClienteAlta4">
        <div class="card-body text-grey-d3">
              <!-- MODAL -->
            <form id="formSeguros" name="formSeguros" action="">
              <div class="modal fade modal-lg" id="modalSeguros" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable" role="document">
                  <div class="modal-content">

                    <div class="modal-header">
                      <h5 class="modal-title text-success">Seguro Depósito<span id="titulo"></span></h5>
                      <input  type="hidden" id="idkey_mueble" name="idkey_mueble"> 
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>

                    <div class="modal-body ace-scrollbar">
                      
                    <div id="form_mueble">

                        <div class="row">
                          <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 8px; margin-top: 0px;" id=""> 
                            <label class="col-form-label form-control-label" >Seleccionar operación</label>
                            <select  name="operacion" id="operacion" class="form-control form-control-sm" required>
                                  <option selected>...</option>
                                  <option value="1">Efectivo</option>
                                  <option value="2">Transferencia ó Depósito</option>
                            </select>
                          </div>            

                          <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 8px; margin-top: 0px;" id="divFolio" >
                            <label class="col-form-label form-control-label" style="margin-top: 0px;">Ingresar Folio o Comprobante de Pago</label>
                            <input type="text" name="comprobantePago" id="comprobantePago" class="form-control form-control-sm" required>
                          </div>
                          


                        </div>

                        <div class="row">

                          <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 8px; margin-top: 0px;" id="divOperacion" >
                            <label class="col-form-label form-control-label" style="margin-top: 0px;">Ingresar nombre del banco</label>
                            <input type="text" name="banco" id="banco" class="form-control form-control-sm" required>
                          </div>

                          </div>

                        <div class="row">

                          <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 8px; margin-top: 0px;">
                            <label class="col-form-label form-control-label" style="margin-top: 0px;">Ingresar Monto</label>
                            <input type="number" name="monto" id="monto" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)" class="form-control form-control-sm" required>
                          </div>

                          <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 8px; margin-top: 0px;">
                            <label class="col-form-label form-control-label" >Concepto</label>
                            <input type="text" name="concepto" id="concepto" value="Seguro Depósito" class="form-control form-control-sm" disabled='true' required>
                          </div>            
                        
                        </div>

                        <div class="row">
                          <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 8px; margin-top: 0px;">
                            <label class="col-form-label form-control-label" >Credito</label>
                            <input type="text" name="credito" id="credito" class="form-control form-control-sm" disabled='true' required>
                          </div>

                                 <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 8px; margin-top: 0px;">
                            <label class="col-form-label form-control-label" >Nombre de Cliente</label>
                            <input type="text" name="cliente" id="cliente" class="form-control form-control-sm" disabled='true' required>
                            <input type="text" name="idcliente" id="idcliente" class="form-control form-control-sm" hidden >
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 8px; margin-top: 0px;">
                            <label class="col-form-label form-control-label" >Observaciones</label>
                            <input type="text" name="observaciones" id="observaciones" class="form-control form-control-sm" required>
                          </div>

        
                        </div>

                       
                    </div>

                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" id="cerrar" data-dismiss="modal">Cerrar</button>
                      <button type="button" id="btnaplicarSeguro" class="btn btn-success">Aplicar cobro</button>
                      <a class="btn btn-success" id="btnImprimirCobranza"  target="_blank" role="button">Imprimir</a>
                    </div>

                  </div>
                </div>
              </div>
            </form>
                    
                </div> <!-- / class="collapse" -->
            </div> <!-- / Card Garantias -->

   
   
   
   
   
   
   
    </div> <!-- /PRINCIPAL-->    