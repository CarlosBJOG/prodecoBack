
        <div class="card-body text-grey-d3">
              <!-- MODAL -->

            <form id="edit_cuentas" name="edit_cuentas" action="">
              <div class="modal fade modal-md" id="modal_cuentas" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable" role="document">
                  <div class="modal-content">

                    <div class="modal-header">
                      <h5 class="modal-title text-success" id="titulo">Editar Cuenta</h5>
                      <input  type="hidden" id="idkey_mueble" name="idkey_mueble"> 
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>

                    <div class="modal-body ace-scrollbar">
                      
                    <div id="">

                        <div class="row">

                          <div class="col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 8px; margin-top: 0px;">
                            <label class="col-form-label form-control-label text-success" style="margin-top: 0px;">Numero Cuenta</label>
                            <input type="number" name="num_cuenta" id="num_cuenta" class="form-control form-control-sm"   required>
                            <input type="" name="id_cta" id="id_cta" class="form-control form-control-sm" disabled="true" hidden>
                          </div>

                          
                          <div class="col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 8px; margin-top: 0px;">
                            <label class="col-form-label form-control-label text-success" style="margin-top: 0px;">Cuenta Acumulable</label>
                            <input type="number" name="cta_acumulable" id="cta_acumulable" class="form-control form-control-sm">
                            
                          </div>

                          <div class="col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 8px; margin-top: 0px;">
                            <label class="col-form-label form-control-label text-success" style="margin-top: 0px;">Nombre<span class="text-danger">*</span></label>
                            <input type="" name="nombre_cta" id="nombre_cta" class="form-control form-control-sm" >
                            
                          </div>

                          <div class="col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 8px; margin-top: 0px;">
                            <label class="col-form-label form-control-label text-success" style="margin-top: 0px;">Rubro<span class="text-danger">*</span></label>
                            <input type="" name="rubro" id="rubro" class="form-control form-control-sm"  >
                            
                          </div>

                          
                          <div class="col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 8px; margin-top: 0px;">
                            <label class="col-form-label form-control-label text-success" style="margin-top: 0px;">Tipo<span class="text-danger">*</span></label>
                            <input type="" name="tipo" id="tipo" class="form-control form-control-sm" >
                   
                          </div>

                          <div class="col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 8px; margin-top: 0px;">
                            <label class="col-form-label form-control-label text-success" style="margin-top: 0px;">Naturaleza<span class="text-danger">*</span></label>
                            <input type="" name="naturaleza" id="naturaleza" class="form-control form-control-sm"  >
                            
                          </div>

                          <div class="col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 8px; margin-top: 0px;">
                            <label class="col-form-label form-control-label text-success" style="margin-top: 0px;">Nivel<span class="text-danger">*</span></label>
                            <input type="number" name="nivel" id="nivel" class="form-control form-control-sm"  >
                            
                          </div>


                        </div>

                    </div>

                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" id="cerrar" data-dismiss="modal">Cerrar</button>
                      <button type="button" id="btnGuardar" class="btn btn-success" onclick="guardar_cambios()">Guardar Cambios</button>
                    </div>

                  </div>
                </div>
              </div>
            </form>
              
          </div> <!-- / class="collapse" -->
      </div> <!-- / Card Garantias -->
