<div id="formdatosGarantias" class="collapse show" aria-labelledby="datosGarantias" data-parent="#nuevoClienteAlta4">
        <div class="card-body text-grey-d3">
              <!-- MODAL -->

            <form id="edit_usuario" name="edit_usuario" action="">
              <div class="modal fade modal-lg" id="modal_edit_usuario" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable" role="document">
                  <div class="modal-content">

                    <div class="modal-header">
                      <h5 class="modal-title text-success">Editar Usuario</h5>
                    
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>

                    <div class="modal-body ace-scrollbar">
                      
                    <div id="form_mueble">
                    <form id="form_empleados" name="form_empleados">
                       
                            <div class="col-sm-12 col-md-12 col-lg-12">                                        
                            
                                <!-- datos generales del empleado -->
                                <div class="row mt-2">
                                    <div class="mx-auto col-sm-12 col-md-12 col-lg-12">
                                        <div class="card">
                                            <div class="card-header"><h6 class="mb-0">Datos generales</h6></div>
                                            <div class="card-body">
                                                <div class="form-group row" style="margin:0px; padding:0px;">
                                                    <div class="col-sm-12 col-md-4 col-lg-4" style="margin-bottom: 2px; margin-top: 0px;">
                                                        <label class="col-form-label form-control-label">Nombre(s) <span style="color:red;">*</span></label>
                                                        <input type="text" class="form-control form-control-sm" name="nombre" id="nombre" required>
                                                        <input type="text"  name="idkey_usuario" id="idkey_usuario" hidden>
                                                    </div>                        
                                                    <div class="col-sm-12 col-md-4 col-lg-4" style="margin-bottom: 2px; margin-top: 0px;">
                                                        <label class="col-form-label form-control-label">Apellido Paterno <span style="color:red;">*</span></label>
                                                        <input type="text" class="form-control form-control-sm" name="apellido_p" id="apellido_p" required>
                                                    </div>
                                                    <div class="col-sm-12 col-md-4 col-lg-4" style="margin-bottom: 2px; margin-top: 0px;">
                                                        <label class="col-form-label form-control-label">Apellido Materno <span style="color:red;">*</span></label>
                                                        <input type="text" class="form-control form-control-sm" name="apellido_m" id="apellido_m" required>
                                                    </div>
                                                </div>

                                                <div class="form-group row" id="temp-sexo" style="margin:0px; padding:0px;">
                                                    <div class="col-sm-12 col-md-4 col-lg-2" style="margin-bottom: 2px; margin-top: 0px;">
                                                        <label class="col-form-label form-control-label">Edad <span style="color:red;">*</span></label>
                                                        <input maxlength="2" type="number" class="form-control form-control-sm" name="edad" id="edad" required>
                                                    </div>

                                                    <!-- <template id="template-sexo"> -->

                                                        <div class="col-sm-12 col-md-4 col-lg-3" style="margin-bottom: 2px; margin-top: 0px;">
                                                            <label class="col-form-label form-control-label">Sexo <span style="color:red;">*</span></label>
                                                            <select name="sexo" id="sexo" class="form-control form-control-sm" required>
                                                                    <!-- <option value="0">...</option> -->
                                                            </select>
                                                        </div>
                                                    <!-- </template> -->
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- direccion del empleado -->
                                <div class="row mt-2">
                                    <div class="mx-auto col-sm-12 col-md-12 col-lg-12">
                                        <div class="card">
                                            <div class="card-header"><h6 class="mb-0">Direcci&oacute;n</h6></div>
                                            <div class="card-body">
                                                <div class="form-group row" style="margin:0px; padding:0px;">
                                                    <div class="col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 2px; margin-top: 0px;">
                                                        <label class="col-form-label form-control-label">Domicilio <span style="color:red;">*</span></label>
                                                        <input type="text" class="form-control form-control-sm" name="domicilio" id="domicilio" required>
                                                    </div>                        
                                            
                                                </div>

                                                <div class="form-group row" style="margin:0px; padding:0px;">
                                                    <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 2px; margin-top: 0px;">
                                                        <label class="col-form-label form-control-label">Estado <span style="color:red;">*</span></label>
                                                        <select id="estado" name="estado" class="form-control form-control-sm" required>
                                                            <option value="0" selected>...</option>
                                                    
                                                        </select>
                                                    </div>

                                                    <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 2px; margin-top: 0px;">
                                                        <label class="col-form-label form-control-label">Ciudad/Delegaci&oacute;n <span style="color:red;">*</span></label>
                                                        <select name="ciudad" id="ciudad" class="form-control form-control-sm" required>
                                                            <option value="0" selected>...</option>
                                                    
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group row" style="margin:0px; padding:0px;">
                                                    <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 2px; margin-top: 0px;">
                                                        <label class="col-form-label form-control-label">Localidad <span style="color:red;">*</span></label>
                                                        <select name="localidad" id="localidad" class="form-control form-control-sm" required>
                                                            <option value="">...</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 2px; margin-top: 0px;">
                                                        <label class="col-form-label form-control-label">C&oacute;digo Postal <span style="color:red;">*</span></label>
                                                        <select name="cp" id="cp" class="form-control form-control-sm" required>
                                                            <option value="">...</option>
                                                    
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Datos Oficiales -->
                                <div class="row mt-2">
                                    <div class="mx-auto col-sm-12 col-md-12 col-lg-12">
                                        <div class="card">
                                            <div class="card-header"><h6 class="mb-0">Datos Oficiales</h6></div>
                                                <div class="card-body">

                                                <div class="form-group row" style="margin:0px; padding:0px;">
                                                    <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 2px; margin-top: 0px;">
                                                        <label class="col-form-label form-control-label">INE <span style="color:red;">*</span></label>
                                                        <input type="text" class="form-control form-control-sm" name="ine" id="ine" style="text-transform:uppercase" required>
                                                    </div>

                                                    <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 2px; margin-top: 0px;">
                                                        <label class="col-form-label form-control-label">RFC<span style="color:red;">*</span></label>
                                                        <input type="text" class="form-control form-control-sm" name="rfc" id="rfc" onblur="validar_rfc()" style="text-transform:uppercase" required>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                    <!-- Contacto -->
                                <div class="row mt-2">
                                    <div class="mx-auto col-sm-12 col-md-12 col-lg-12">
                                        <div class="card">
                                            <div class="card-header"><h6 class="mb-0">Contacto</h6></div>
                                                <div class="card-body">

                                                <div class="form-group row" style="margin:0px; padding:0px;">
                                                    <div class="col-sm-12 col-md-4 col-lg-4" style="margin-bottom: 2px; margin-top: 0px;">
                                                        <label class="col-form-label form-control-label">Telefono Celular <span style="color:red;">*</span></label>
                                                        <input type="text" class="form-control form-control-sm" name="num_celular" id="num_celular" required>
                                                    </div>

                                                    <div class="col-sm-12 col-md-4 col-lg-4" style="margin-bottom: 2px; margin-top: 0px;">
                                                        <label class="col-form-label form-control-label">Telefono Casa<span style="color:red;">*</span></label>
                                                        <input type="number" class="form-control form-control-sm" name="num_casa" id="num_casa" required>
                                                    </div>

                                                    <div class="col-sm-12 col-md-4 col-lg-4" style="margin-bottom: 2px; margin-top: 0px;">
                                                        <label class="col-form-label form-control-label">Telefono Oficina</label>
                                                        <input type="number" class="form-control form-control-sm" name="num_oficina" id="num_oficina" required>
                                                    </div>
                                                </div>

                                                <div class="form-group row" style="margin:0px; padding:0px;">
                                                    <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 2px; margin-top: 0px;">
                                                        <label class="col-form-label form-control-label">E-mail <span style="color:red;">*</span></label>
                                                        <input type="email" class="form-control form-control-sm" name="email" id="email" required>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                            </div>
                        </div>
                    </form>


                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" id="cerrar" data-dismiss="modal">Cerrar</button>
                      <button type="button" id="btnEdit_usuario" class="btn btn-success" onclick="guardar_edit_usuario();" >Guardar</button>
                    </div>

                  </div>
                </div>
              </div>
            </form>
                    
                </div> <!-- / class="collapse" -->
            </div> <!-- / Card Garantias -->

    </div> <!-- /PRINCIPAL-->    