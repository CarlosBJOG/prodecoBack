<?php
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    require_once "../php/security.php";    
    require_once "../php/header_admin.php";    
    create_header();
    create_menu();
    begin_containers();
    @session_start();

?>

<div class="container container-plus pos-rel">

    

    <form id="form_empleados" name="form_empleados">
        <div class="row justify-content-sm-center justify-content-md-center justify-content-lg-center mt-5">
            <div class="col-sm-12 col-md-12 col-lg-10">                                        
                <div class="row">
                    <div class="mx-auto col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <h2 class="text-success p-4">Nuevo empleado</h4>
                        
                        </div>
                    </div>
                </div>
            
                
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


                <div class="row">
                    <div class="mx-auto col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group row" style="margin:0px; padding:0px;">
                            <div class="col-sm-12 col-md-6 col-lg-7" style="margin-bottom: 5px; margin-top: 10px;">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button id="btn_guardar" onclick="btnEmpleado();" class="btn btn-success btn-sm"><i class="fas fa-save"></i>&nbsp;Guardar</button>
                                        <button id="btn_cancelar" onclick="regresar();" class="btn btn-danger btn-sm"><i class="fas fa-ban"></i>&nbsp;Cancelar</button>                                                     
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
            </div>
        </div>
    </form>

<?php 
            require("../views/empleados/view_permisos.php");

?>

</div>
<!-- include common vendor scripts used in demo pages -->
<script type="text/javascript" src="../ace-admin/node_modules/jquery/dist/jquery.js"></script>
      <script type="text/javascript" src="../ace-admin/node_modules/popper.js/dist/umd/popper.js"></script>
      <script type="text/javascript" src="../ace-admin/node_modules/bootstrap/dist/js/bootstrap.js"></script>

      <!-- include Ace script -->
      <script type="text/javascript" src="../ace-admin/dist/js/ace.js"></script>

      <script type="text/javascript" src="../ace-admin/assets/js/demo.js"></script>

      <script type="text/javascript" src="../ace-admin/node_modules/bootbox/bootbox.all.js"></script>
      <script type="text/javascript" src="../ace-admin/node_modules/sweetalert2/dist/sweetalert2.all.js"></script>
      <script type="text/javascript" src="../ace-admin/node_modules/interactjs/dist/interact.js"></script>

      <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
     
      <script type="text/javascript" src="../js/jquery.validate.min.js"></script>
      <link rel="stylesheet" type="text/css" href="../styles/styles.css">
      <script src="../js/func_empleados.js"></script>
      

<?php end_containers(); ?>

    
<?php
create_footer();
?>

<script>
     $(document).ready(function(){
        jQuery.validator.setDefaults({
        debug: true,
        success: "valid"
        });
 
     });

     init();
   

</script>
  </body>
</html>
