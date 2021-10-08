<div id="formdatosGarantias" class="collapse show" aria-labelledby="datosGarantias" data-parent="#nuevoClienteAlta4">
        <div class="card-body text-grey-d3">
              <!-- MODAL -->

            <form id="permisos" name="permisos" action="">
              <div class="modal fade modal-md" id="modalPermisos" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable" role="document">
                  <div class="modal-content">

                    <div class="modal-header">
                      <h5 class="modal-title text-success">Otorgar Permisos</h5>
                      <input  type="hidden" id="idkey_mueble" name="idkey_mueble"> 
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>

                    <div class="modal-body ace-scrollbar">
                      
                    <div id="form_mueble">

                        <div class="row">

                          <div class="col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 8px; margin-top: 0px;">
                            <label class="col-form-label form-control-label text-success" style="margin-top: 0px;">Nombre de Usuario</label>
                            <input type="" name="username" id="username" class="form-control form-control-sm" placeholder="Ingresa tu usuario" required>
                            <input type="" name="id" id="id" class="form-control form-control-sm"  hidden>
                          </div>


                        </div>

                        <div class="row">
                          <div class="col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 8px; margin-top: 0px;">
                            <label class="col-form-label form-control-label text-success" >Ingresar Contraseña</label>
                            <input type="" name="password" id="password" class="form-control form-control-sm" placeholder="Ingresa tu contraseña" required>
                          </div>
                        
                        </div>
                        
                        <div class="row">
                          <div class="col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 8px; margin-top: 0px;">
                            <label class="col-form-label form-control-label text-success">Asignar Permiso</label>
                            <select id="licence" name="licence" class="form-control form-control-sm" required>
                                <option value="0" selected>...</option>
                                    
                            </select>
                          </div>
                      
                        </div>


                    </div>

                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" id="cerrar" data-dismiss="modal">Cerrar</button>
                      <button type="button" id="btnGuardar_permiso" class="btn btn-success" onclick="guardar_permiso();">Guardar</button>
                    </div>

                  </div>
                </div>
              </div>
            </form>
                    
                </div> <!-- / class="collapse" -->
            </div> <!-- / Card Garantias -->

    </div> <!-- /PRINCIPAL-->    