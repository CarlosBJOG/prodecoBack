<div id="formdatosGarantias" class="collapse show" aria-labelledby="datosGarantias" data-parent="#nuevoClienteAlta4">
        <div class="card-body text-grey-d3">
              <!-- MODAL -->

            <form id="add_fam" name="add_fam" action="">
              <div class="modal fade modal-lg" id="modal_familiar" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable" role="document">
                  <div class="modal-content">

                    <div class="modal-header">
                      <h5 class="modal-title text-success">Registrar Familiar</h5>
                    
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
                                                        <input type="text" class="form-control form-control-sm" name="nombre2" id="nombre2" required>
                                                        <input type="text"  name="idkey_usuario2" id="idkey_usuario2" hidden>
                                                    </div>                        
                                                    <div class="col-sm-12 col-md-4 col-lg-4" style="margin-bottom: 2px; margin-top: 0px;">
                                                        <label class="col-form-label form-control-label">Apellido Paterno <span style="color:red;">*</span></label>
                                                        <input type="text" class="form-control form-control-sm" name="apellido_p2" id="apellido_p2" required>
                                                    </div>
                                                    <div class="col-sm-12 col-md-4 col-lg-4" style="margin-bottom: 2px; margin-top: 0px;">
                                                        <label class="col-form-label form-control-label">Apellido Materno <span style="color:red;">*</span></label>
                                                        <input type="text" class="form-control form-control-sm" name="apellido_m2" id="apellido_m2" required>
                                                    </div>
                                                </div>

                                                <div class="form-group row" id="temp-sexo" style="margin:0px; padding:0px;">
                                                    <div class="col-sm-12 col-md-4 col-lg-2" style="margin-bottom: 2px; margin-top: 0px;">
                                                        <label class="col-form-label form-control-label">Edad <span style="color:red;">*</span></label>
                                                        <input maxlength="2" type="number" class="form-control form-control-sm" name="edad2" id="edad2" required>
                                                    </div>

                                                    <!-- <template id="template-sexo"> -->

                                                        <div class="col-sm-12 col-md-4 col-lg-3" style="margin-bottom: 2px; margin-top: 0px;">
                                                            <label class="col-form-label form-control-label">Sexo <span style="color:red;">*</span></label>
                                                            <select name="sexo2s" id="sexo2" class="form-control form-control-sm" required>
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
                                                        <input type="text" class="form-control form-control-sm" name="domicilio2" id="domicilio2" required>
                                                    </div>                        
                                            
                                                </div>

                                                <div class="form-group row" style="margin:0px; padding:0px;">
                                                    <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 2px; margin-top: 0px;">
                                                        <label class="col-form-label form-control-label">Estado <span style="color:red;">*</span></label>
                                                        <select id="estado2" name="estado2" class="form-control form-control-sm" required>
                                                            <option value="0" selected>...</option>
                                                    
                                                        </select>
                                                    </div>

                                                    <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 2px; margin-top: 0px;">
                                                        <label class="col-form-label form-control-label">Ciudad/Delegaci&oacute;n <span style="color:red;">*</span></label>
                                                        <select name="ciudad2" id="ciudad2" class="form-control form-control-sm" required>
                                                            <option value="0" selected>...</option>
                                                    
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group row" style="margin:0px; padding:0px;">
                                                    <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 2px; margin-top: 0px;">
                                                        <label class="col-form-label form-control-label">Localidad <span style="color:red;">*</span></label>
                                                        <select name="localidad2" id="localidad2" class="form-control form-control-sm" required>
                                                            <option value="">...</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 2px; margin-top: 0px;">
                                                        <label class="col-form-label form-control-label">C&oacute;digo Postal <span style="color:red;">*</span></label>
                                                        <select name="cp2" id="cp2" class="form-control form-control-sm" required>
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
                                                        <input type="text" class="form-control form-control-sm" name="ine2" id="ine2" style="text-transform:uppercase" required>
                                                    </div>

                                                    <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 2px; margin-top: 0px;">
                                                        <label class="col-form-label form-control-label">Parentesco<span style="color:red;">*</span></label>
                                                        <select name="parentesco" id="parentesco" class="form-control form-control-sm" required>
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
                                                        <input type="number" class="form-control form-control-sm" name="num_celular2" id="num_celular2" required>
                                                    </div>

                                                    <div class="col-sm-12 col-md-4 col-lg-4" style="margin-bottom: 2px; margin-top: 0px;">
                                                        <label class="col-form-label form-control-label">Telefono Casa<span style="color:red;">*</span></label>
                                                        <input type="number" class="form-control form-control-sm" name="num_casa2" id="num_casa2" required>
                                                    </div>

                                                    <div class="col-sm-12 col-md-4 col-lg-4" style="margin-bottom: 2px; margin-top: 0px;">
                                                        <label class="col-form-label form-control-label">E-mail <span style="color:red;">*</span></label>
                                                        <input type="email" class="form-control form-control-sm" name="email2" id="email2" required>
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
                      <button type="button" id="btnEdit_usuario" class="btn btn-success" onclick="guardar_familiar();" >Guardar</button>
                    </div>

                  </div>
                </div>
              </div>
            </form>
                    
                </div> <!-- / class="collapse" -->
            </div> <!-- / Card Garantias -->

    </div> <!-- /PRINCIPAL-->    