<div id="formdatosGarantias" class="collapse show" aria-labelledby="datosGarantias" data-parent="#nuevoClienteAlta4">
        <div class="card-body text-grey-d3">
              <!-- MODAL -->

            <form id="edit_fam" name="edit_fam" action="">
              <div class="modal fade modal-lg" id="modal_familiar_edit" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable" role="document">
                  <div class="modal-content">

                    <div class="modal-header">
                      <h5 class="modal-title text-success">Editar Familiar</h5>
                    
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>

                    <div class="modal-body ace-scrollbar">
                      
                    <div id="form_mueble">
                       
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
                                                        <input type="text" class="form-control form-control-sm" name="nombre3" id="nombre3" required>
                                                        <input type="text"  name="idkey_usuario3" id="idkey_usuario3" hidden>
                                                    </div>                        
                                                    <div class="col-sm-12 col-md-4 col-lg-4" style="margin-bottom: 2px; margin-top: 0px;">
                                                        <label class="col-form-label form-control-label">Apellido Paterno <span style="color:red;">*</span></label>
                                                        <input type="text" class="form-control form-control-sm" name="apellido_p3" id="apellido_p3" required>
                                                    </div>
                                                    <div class="col-sm-12 col-md-4 col-lg-4" style="margin-bottom: 2px; margin-top: 0px;">
                                                        <label class="col-form-label form-control-label">Apellido Materno <span style="color:red;">*</span></label>
                                                        <input type="text" class="form-control form-control-sm" name="apellido_m3" id="apellido_m3" required>
                                                    </div>
                                                </div>

                                                <div class="form-group row" id="temp-sexo" style="margin:0px; padding:0px;">
                                                    <div class="col-sm-12 col-md-4 col-lg-2" style="margin-bottom: 2px; margin-top: 0px;">
                                                        <label class="col-form-label form-control-label">Edad <span style="color:red;">*</span></label>
                                                        <input maxlength="2" type="number" class="form-control form-control-sm" name="edad3" id="edad3" required>
                                                    </div>

                                                    <!-- <template id="template-sexo"> -->

                                                        <div class="col-sm-12 col-md-4 col-lg-3" style="margin-bottom: 2px; margin-top: 0px;">
                                                            <label class="col-form-label form-control-label">Sexo <span style="color:red;">*</span></label>
                                                            <select name="sexo3" id="sexo3" class="form-control form-control-sm" required>
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
                                                        <input type="text" class="form-control form-control-sm" name="domicilio3" id="domicilio3" required>
                                                    </div>                        
                                            
                                                </div>

                                                <div class="form-group row" style="margin:0px; padding:0px;">
                                                    <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 2px; margin-top: 0px;">
                                                        <label class="col-form-label form-control-label">Estado <span style="color:red;">*</span></label>
                                                        <select id="estado3" name="estado3" class="form-control form-control-sm" required>
                                                            <option value="0" selected>...</option>
                                                    
                                                        </select>
                                                    </div>

                                                    <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 2px; margin-top: 0px;">
                                                        <label class="col-form-label form-control-label">Ciudad/Delegaci&oacute;n <span style="color:red;">*</span></label>
                                                        <select name="ciudad3" id="ciudad3" class="form-control form-control-sm" required>
                                                            <option value="0" selected>...</option>
                                                    
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group row" style="margin:0px; padding:0px;">
                                                    <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 2px; margin-top: 0px;">
                                                        <label class="col-form-label form-control-label">Localidad <span style="color:red;">*</span></label>
                                                        <select name="localidad3" id="localidad3" class="form-control form-control-sm" required>
                                                            <option value="">...</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 2px; margin-top: 0px;">
                                                        <label class="col-form-label form-control-label">C&oacute;digo Postal <span style="color:red;">*</span></label>
                                                        <select name="cp3" id="cp3" class="form-control form-control-sm" required>
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
                                                        <input type="text" class="form-control form-control-sm" name="ine3" id="ine3" style="text-transform:uppercase" required>
                                                    </div>

                                                    <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 2px; margin-top: 0px;">
                                                        <label class="col-form-label form-control-label">Parentesco<span style="color:red;">*</span></label>
                                                        <select name="parentesco3" id="parentesco3" class="form-control form-control-sm" required>
                                                            <option value="">...</option>
                                                    
                                                        </select>
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
                                                        <input type="number" class="form-control form-control-sm" name="num_celular3" id="num_celular3" required>
                                                    </div>

                                                    <div class="col-sm-12 col-md-4 col-lg-4" style="margin-bottom: 2px; margin-top: 0px;">
                                                        <label class="col-form-label form-control-label">Telefono Casa<span style="color:red;">*</span></label>
                                                        <input type="number" class="form-control form-control-sm" name="num_casa3" id="num_casa3" required>
                                                    </div>

                                                    <div class="col-sm-12 col-md-4 col-lg-4" style="margin-bottom: 2px; margin-top: 0px;">
                                                        <label class="col-form-label form-control-label">E-mail <span style="color:red;">*</span></label>
                                                        <input type="email" class="form-control form-control-sm" name="email3" id="email3" required>
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
                      <button type="button" id="btnEdit_fam" class="btn btn-success" onclick="guardar_edit_fam();" >Guardar Cambios</button>
                    </div>

                  </div>
                </div>
              </div>
            </form>
                    
                </div> <!-- / class="collapse" -->
            </div> <!-- / Card Garantias -->

    </div> <!-- /PRINCIPAL-->    