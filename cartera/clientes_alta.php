<?php
error_reporting(0);
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    require_once "../php/security.php";
    require_once "../php/header_cartera.php";
    require_once "../php/functions.php";
    require_once "../php/funciones_cartera.php";
    require_once "../php/form_busqueda.php";
    require_once "../php/form_garantias.php";
    require_once "../php/db.php";


    
    create_header_forms();
    create_menu_cartera();
    begin_containers();
    
    ?>
    
<!-- MAIN CONTAINER --> 
<div class="page-content container">
  <div class="row">
    <div class="col-12">
      <div>
        <h2 class="text-success text-center pb-3" id="tituloformcli">
          Gestión de Cliente
        </h2>


        <!--Animación de carga-->
        <div id="animacion">
          <div class=" d-flex flex-column justify-content-between align-items-center">
            <div class="spinner-grow text-success mb-3" role="status">
                <span class="sr-only">Loading...</span>
            </div>
          </div>

        </div>
        

        <div class="card-toolbar ml-auto no-border pr-2" >
          <label>
            <span class="align-middle d-block d-sm-inline"></span>
            <input autocomplete="off" type="checkbox" id="id-validate" class="float-right text-secondary-l1 bgc-success ml-1 ace-switch ace-switch-times ace-switch-check align-middle radius-1" hidden />
          </label>
        </div>
      </div>


      <div class="card-body px-2">

        <div id="smartwizard-1" class="d-none">
          <ul >
            <li class="wizard-progressbar"></li>
            <li>
                <a href="#step-1">
                  <span class="step-title">1</span>
                  <span class="step-title-done">
                    <i class="fa fa-check text-success-m1"></i>
                  </span>
                </a>
                <!--<span class="step-description">Validation States</span>-->
            </li>
            <li>
              <a href="#step-2">
                <span class="step-title">2</span>
                <span class="step-title-done">
                  <i class="fa fa-check text-success-m1"></i>
                </span>
              </a>
              <!--<span class="step-description">Alerts</span>-->
            </li>
            <li>
              <a href="#step-3">
                <span class="step-title">3</span>
                <span class="step-title-done">
                  <i class="fa fa-check text-success-m1"></i>
                </span>
              </a>
              <!--<span class="step-description">Alerts</span>-->         
              </li>
              <li>
                <a href="#step-4">
                  <span class="step-title">4</span>
                  <span class="step-title-done">
                     <i class="fa fa-check text-success-m1"></i>
                  </span>
                </a>
                <!--<span class="step-description">Alerts</span>-->            
              </li>
               <li>
                <a href="#step-5">
                  <span class="step-title">5</span>
                  <span class="step-title-done">
                     <i class="fa fa-check text-success-m1"></i>
                  </span>
                </a>
                <!--<span class="step-description">Alerts</span>-->            
              </li>
              <!--
              <li>
                <a href="#step-6">
                  <span class="step-title">6</span>
                  <span class="step-title-done">
                     <i class="fa fa-check text-success-m1"></i>
                  </span>
                </a>           
              </li>-->
            </ul>


            <div class="container py-3 mt-4">


<!------------------ PASO 1 -------------------->
        <div id="step-1" class="">  
          <form id="paso1form" name="paso1form" action="">  
          
            <?php 
              //Se inicializan las variables
              $idkey_cliente = "";

              //Para la búsqueda de clientes en las relaciones
              create_busqueda_cliente();

              if(isset($_GET["idkey_cliente"])){ 
                  $idkey_cliente = $_GET["idkey_cliente"]; 
                  $funcion = "editar_cliente_step1";
              }
              else
                  $funcion = "nuevo_cliente";
              ?>

            <input type='hidden' name='idkey_cliente' id='idkey_cliente' value='<?php echo $idkey_cliente; ?>'>

            <input type='hidden' name='funcion' id='funcion' value='<?php echo $funcion; ?>'>
            <input type='hidden' name='idkey_promotor' id='idkey_promotor' value='<?php echo $_SESSION['idkey']; ?>'>



            <div class="accordion" id="paso1Acordeon">

               <!--PASO 1 - DATOS GENERALES -->
              <div class="card border-0">
                <div class="card-header border-0 bg-transparent" id="datosGenerales">
                  <h2 class="card-title">
                    <a class="accordion-toggle bgc-success-l3 rounded-lg d-style" href="#formDatosGenerales" data-toggle="collapse" aria-expanded="true" aria-controls="formDatosGenerales">
                      <span class="v-n-collapsed h-100 position-tl border-l-3 brc-success-tp2"></span>
                      <span class="text-success-m1"><i class="fa fa-angle-right toggle-icon mr-1"></i>Datos Generales</span>
                    </a>
                  </h2>
                </div>
                <div id="formDatosGenerales" class="collapse show" aria-labelledby="datosGenerales" data-parent="#paso1Acordeon">
                    <div class="card-body text-grey-d3">
                      <div class="form-group row" style="margin:0px; padding:0px;">
                          <div class="col-sm-12 col-md-4 col-lg-4" style="margin-bottom: 12px; margin-top: 0px;">
                             <label class="col-form-label form-control-label text-success-d1 text-100" style="margin-top: 0px;">Nombre(s)<span style="color:red;">*</span></label>
                             <input class="form-control form-control-sm" type="text" value="" id="nombre" name="nombre">
                          </div>
                          <div class="col-sm-12 col-md-4 col-lg-4">
                             <label class="col-form-label form-control-label text-success-d1 text-100">Primer Apellido<span style="color:red;">*</span></label>
                             <input class="form-control form-control-sm" type="text" value="" id="apellido_p" name="apellido_p">
                          </div>
                          <div class="col-sm-12 col-md-4 col-lg-4">
                             <label class="col-form-label form-control-label text-success-d1 text-100">Segundo Apellido</label>
                             <input class="form-control form-control-sm" type="text" value="" id="apellido_m" name="apellido_m">
                          </div>
                      </div>
                      <div class="form-group row" style="margin:0px; padding:0px;">
                          <div class="col-sm-12 col-md-4 col-lg-3" style="margin-bottom: 12px; margin-top: 0px;">
                             <label class="col-form-label form-control-label mt-0 text-success-d1 text-100" for="nacimiento">Fecha de Nacimiento<span style="color:red;">*</span></label>
                             <div class="input-group date" id="id-timepicker">
                                <div class="input-group-addon input-group-append">
                                    <div class="input-group-text">
                                       <i class="fa fa-calendar"></i>
                                    </div>
                                </div>
                                <input type="text" name="nacimiento" class="form-control form-control-sm" id="nacimiento" autocomplete="off">
                                <script>  $("#nacimiento").activeCalendary('#nacimiento'); </script>
                             </div>
                          </div>
                          <div class="col-sm-12 col-md-3 col-lg-3">
                             <label class="col-form-label form-control-label text-success-d1 text-100">Género<span style="color:red;">*</span></label>
                             <select name="sexo" id="sexo" class="form-control form-control-sm">
                             <?php create_sexo(''); ?>
                             </select>
                          </div>
                          <div class="col-sm-12 col-md-3 col-lg-3">
                             <label class="col-form-label form-control-label text-success-d1 text-100">RFC<span style="color:red;">*</span></label>
                             <input class="form-control form-control-sm" type="text" value="" maxlength="13" id="rfc" name="rfc" onblur="this.value=this.value.toUpperCase();">
                          </div>
                          <div class="col-sm-12 col-md-3 col-lg-3" style="margin-bottom: 12px; margin-top: 0px;">
                             <label class="col-form-label form-control-label text-success-d1 text-100" style="margin-top: 0px;">CURP<span style="color:red;">*</span></label>
                             <input class="form-control form-control-sm" type="text" maxlength="18" value="" id="curp" name="curp" onblur="this.value=this.value.toUpperCase();">
                          </div>
                      </div>
                    </div>
                  </div>  
                </div> <!-- /PASO 1 - DATOS GENERALES  -->


                <!-- PASO 1 - IDENTIFICACIONES  -->
                <div class="card border-0">
                  <div class="card-header border-0 bg-transparent" id="identificaciones">
                    <h2 class="card-title">
                      <a class="accordion-toggle bgc-success-l3 collapsed rounded-lg d-style" href="#formIdentificaciones" data-toggle="collapse" aria-expanded="false" aria-controls="formIdentificaciones">
                         <span class="v-n-collapsed h-100 position-tl border-l-3 brc-success-tp2"></span>
                         <span class="text-success-m1"><i class="fa fa-angle-right toggle-icon mr-1"></i>Identificaciones</span>
                      </a>
                    </h2>
                  </div>
                  <div id="formIdentificaciones" class="collapse" aria-labelledby="identificaciones" data-parent="#paso1Acordeon">
                    <div class="card-body text-grey-d3">
                      <div class="form-group row" style="margin:0px; padding:0px;">
                        <div class="col-sm-12 col-md-4 col-lg-4" style="margin-bottom: 12px; margin-top: 0px;">
                          <label class="col-form-label form-control-label text-success-d1 text-100" style="margin-top: 0px;">
                            Identificación<span style="color:red;">*</span>
                          </label>
                          <select name="identificacion" id="identificacion" class="form-control form-control-sm">
                            <?php create_identificacion(''); ?>
                          </select>
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-4">
                          <label class="col-form-label form-control-label text-success-d1 text-100">Número<span style="color:red;">*</span></label>
                          <input class="form-control form-control-sm" type="text" value="" id="num_id" name="num_id">
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-4">
                          <label class="col-form-label form-control-label mt-0 text-success-d1 text-100">Vigencia<span style="color:red;">*</span></label>
                          <div class="input-group date" id="id-timepicker">
                            <div class="input-group-addon input-group-append">
                              <div class="input-group-text">
                                <i class="fa fa-calendar"></i>
                              </div>
                            </div>
                            <input type="text" class="form-control form-control-sm" id="vigencia"  name="vigencia" autocomplete="off" >
                            <script>  $("#vigencia").activeCalendary('#vigencia'); </script>
                          </div>
                        </div>
                      </div>
                    </div> <!-- / card-body -->
                  </div> <!-- / id="formIdentificaciones" class="collapse" -->
                </div> <!-- /PASO 1 - IDENTIFICACIONES  -->



                <!-- PASO 1 - DOMICILIO PRINCIPAL  -->
                <div class="card border-0">
                  <div class="card-header border-0 bg-transparent" id="domicilios">
                    <h2 class="card-title">
                      <a class="accordion-toggle bgc-success-l3 collapsed rounded-lg d-style" href="#formDomicilios" data-toggle="collapse" aria-expanded="false" aria-controls="formDomicilios">
                        <span class="v-n-collapsed h-100 position-tl border-l-3 brc-success-tp2"></span>
                        <span class="text-success-m1"><i class="fa fa-angle-right toggle-icon mr-1"></i>Domicilios</span>
                      </a>
                    </h2>
                  </div>

                  <div id="formDomicilios" class="collapse" aria-labelledby="domicilios" data-parent="#paso1Acordeon">
                    <div class="card-body text-grey-d3">

                      <!---***********Contenido del form Domicilio Principal -->
                      <h5 class="font-light text-success-d2"> 
                        <span><a class="text-success-d2">Principal</a></span>
                      </h5>
                      <div class="form-group row" style="margin:0px; padding:0px;">
                        <div class="col-sm-12 col-md-3 col-lg-3">
                             <label class="col-form-label form-control-label text-success-d1 text-100">Tipo<span style="color:red;">*</span></label>
                             <select name="tipo_direccion" id="tipo_direccion" class="form-control form-control-sm">
                             <?php create_tipo_direccion(''); ?>
                             </select>
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-5" style="margin-bottom: 12px; margin-top: 0px;">
                          <label class="col-form-label form-control-label mt-0 text-success-d1 text-100">Calle<span style="color:red;">*</span></label>
                          <input class="form-control form-control-sm" type="text" value="" id="domicilio" name="domicilio" required>
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-2">
                          <label class="col-form-label form-control-label text-success-d1 text-100">Exterior</label>
                          <input class="form-control form-control-sm" type="text" value="" id="exterior" name="exterior">
                         </div>
                         <div class="col-sm-12 col-md-4 col-lg-2">
                            <label class="col-form-label form-control-label text-success-d1 text-100">Interior<span style="color:red;">*</span></label>
                            <input class="form-control form-control-sm" type="text" value="" id="interior" name="interior">
                         </div>
                      </div>
                      <div class="form-group row" style="margin:0px; padding:0px;">
                         <div class="col-sm-12 col-md-4 col-lg-6" style="margin-bottom: 12px; margin-top: 0px;">
                            <label class="col-form-label form-control-label mt-0 text-success-d1 text-100">Estado<span style="color:red;">*</span></label>
                            <select name="estados" id="estados" class="form-control form-control-sm" style="width: 100%">
                            <?php create_estados(''); ?>
                            </select>
                         </div>
                         <div class="col-sm-12 col-md-4 col-lg-6" style="margin-bottom: 12px; margin-top: 0px;">
                            <label class="col-form-label mt-0 form-control-label text-success-d1 text-100">Ciudad/Alcadía<span style="color:red;">*</span></label>
                            <select name="municipios" id="municipios" class="form-control form-control-sm" style="width: 100%">
                            <?php create_municipios('', ''); ?>
                            </select>
                         </div>
                      </div>
                      <div class="form-group row" style="margin:0px; padding:0px;">
                        <div class="col-sm-12 col-md-4 col-lg-6" style="margin-bottom: 12px; margin-top: 0px;">
                            <label class="col-form-label form-control-label mt-0 form-control-label text-success-d1 text-100">Localidad<span style="color:red;">*</span></label>
                            <select name="localidad" id="localidad" class="form-control form-control-sm" style="width: 100%">
                            <?php create_localidad('', ''); ?>
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-3" style="margin-bottom: 12px; margin-top: 0px;">
                            <label class="col-form-label form-control-label mt-0 form-control-label text-success-d1 text-100">Código Postal<span style="color:red;">*</span></label>
                            <select name="codigo_postal" id="codigo_postal" class="form-control form-control-sm">
                            <?php create_cp('', ''); ?>
                            </select>
                        </div>
                        <script>
                          $('#estados').change(function(){ $('#estados').onchange_estados(  $('#estados').val(), '#municipios','#localidad','#codigo_postal'   );   }  );
                          $('#municipios').change(function(){ $('#municipios').onchange_municipios(  $('#municipios').val(),'#localidad','#codigo_postal'   );   }  );
                          $('#localidad').change(function(){ $('#localidad').onchange_localidad(  $('#localidad').val(),'#codigo_postal'   );   }  ); 
                        </script>
                        <div class="col-sm-12 col-md-4 col-lg-3" style="margin-bottom: 12px; margin-top: 0px;">
                            <label class="col-form-label form-control-label mt-0 text-success-d1 text-100">Empezó a habitar<span style="color:red;">*</span></label>
                            <div class="input-group date" id="id-timepicker">
                               <div class="input-group-addon input-group-append">
                               <div class="input-group-text">
                                  <i class="fa fa-calendar"></i>
                               </div>
                                </div>
                               <input type="text" class="form-control form-control-sm" id="inicia_habitar"  name="inicia_habitar" autocomplete="off" >
                               <script>  $("#inicia_habitar").activeCalendary('#inicia_habitar'); </script>
                            </div>
                            <!-- ESTE ES UN DATE PICKER -->
                        </div>
                      </div>
                      <div class="form-group row" style="margin:0px; padding:0px;">
                         <div class="col-sm-12 col-md-4 col-lg-4" style="margin-bottom: 12px; margin-top: 0px;">
                            <label class="col-form-label form-control-label mt-0 form-control-label text-success-d1 text-100">Entre Calles<span style="color:red;">*</span></label>
                            <textarea class="form-control" rows="5" id="entrecalles" name="entrecalles"></textarea>
                         </div>
                         <div class="col-sm-12 col-md-4 col-lg-4" style="margin-bottom: 12px; margin-top: 0px;">
                            <label class="col-form-label form-control-label mt-0 form-control-label text-success-d1 text-100">Referencia<span style="color:red;">*</span></label>
                            <textarea class="form-control" rows="5" id="referencia" name="referencia"></textarea>
                         </div>
                         <div class="col-sm-12 col-md-6 col-lg-4" style="margin-bottom: 12px; margin-top: 0px;">
                            <label class="col-form-label form-control-label mt-0 form-control-label text-success-d1 text-100">Vialidad<span style="color:red;">*</span></label>
                            <textarea class="form-control" rows="5" id="observaciones" name="observaciones"></textarea>
                         </div>
                      </div>
                      <!---//Contenido del form Domicilio Principal -->

                      <?php 
                      if(isset($_GET["idkey_cliente"]))
                         require("../views/cartera_clientes/view_domicilios.php"); 
                      ?>

                    </div> <!-- / card-body -->
                  </div> <!-- / id="formDomicilios" class="collapse" -->
                </div> <!-- /PASO 1 - DOMICILIO PRINCIPAL  -->



                <!-- RELACIONES -->
                <div class="card border-0" id="card_relaciones">
                   <div class="card-header border-0 bg-transparent" id="relaciones_reg">
                   <h2 class="card-title">
                      <a class="accordion-toggle bgc-success-l3 collapsed rounded-lg d-style" href="#formRelaciones" data-toggle="collapse" aria-expanded="false" aria-controls="formRelaciones">
                         <span class="v-n-collapsed h-100 position-tl border-l-3 brc-success-tp2"></span>
                         <span class="text-success-m1">
                         <i class="fa fa-angle-right toggle-icon mr-1"></i>
                            Relaciones
                      </span>
                      </a>
                   </h2>
                   </div>
                   <div id="formRelaciones" class="collapse" aria-labelledby="relaciones_reg" data-parent="#paso1Acordeon">
                   <div class="card-body text-grey-d3">
                      <div class="card-body" id="div_relaciones"></div>
                   </div> <!-- / card-body -->
                  </div> <!-- / id="formRelaciones" class="collapse" -->
                </div> <!-- / Card RELACIONES -->


                <!-- CONTACTOS -->
                <div class="card border-0" id="card_contactos">
                   <div class="card-header border-0 bg-transparent" id="contactos_clientes">
                   <h2 class="card-title">
                      <a class="accordion-toggle bgc-success-l3 collapsed rounded-lg d-style" href="#formContactos" data-toggle="collapse" aria-expanded="false" aria-controls="formContactos">
                         <span class="v-n-collapsed h-100 position-tl border-l-3 brc-success-tp2"></span>
                         <span class="text-success-m1">
                         <i class="fa fa-angle-right toggle-icon mr-1"></i>
                            Contactos
                      </span>
                      </a>
                   </h2>
                   </div>
                   <div id="formContactos" class="collapse" aria-labelledby="contactos_clientes" data-parent="#paso1Acordeon">
                   <div class="card-body text-grey-d3">


                      <div class="card-body" id="div_contactos">
                        <?php 
                        if(isset($_GET["idkey_cliente"]))
                           require("../views/cartera_clientes/view_contactos.php"); 
                        ?>
                      </div>
                   </div> <!-- / card-body -->
                  </div> <!-- / id="formRelaciones" class="collapse" -->
                </div> <!-- / Card Contactos -->
              

              <br>
              <div class="form-group row" style="margin:0px; padding:0px;">
                 <div class="col-sm-12 col-md-6 col-lg-7" style="margin-bottom: 12px; margin-top: 0px;">
                    <div class="row">
                       <div class="col-lg-3">
                          <button id="safe_general" type="submit" class="btn btn-success btn-sm">
                            <i class="fas fa-save"></i>&nbsp;Guardar
                          </button>
                       </div>
                    </div>
                 </div>
              </div>

            </div>

          </form>


          <!---- MODAL DE DIRECCIONES ADICIONALES-->

            <form id="direccionesAdic" name="direccionesAdic" action="">
              <div class="modal fade modal-lg" id="modalDirecciones" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-dialog-lg" role="document">
                  <div class="modal-content">

                    <div class="modal-header">
                      <h5 class="modal-title">Domicilio Adicional</h5>
                      <input  type="hidden" id="idkey_direccion1" name="idkey_direccion1"> 
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>

                    <div class="modal-body ace-scrollbar">
                      <div id="formDomiciliosAdic"  aria-labelledby="domiciliosAdic" >
                                
                          <!---***********Contenido del form Domicilios -->
                          <div class="form-group row" style="margin:0px; padding:0px;">
                            <div class="col-sm-12 col-md-3 col-lg-3">
                                 <label class="col-form-label form-control-label text-success-d1 text-100">Tipo<span style="color:red;">*</span></label>
                                 <select name="tipo_direccion1" id="tipo_direccion1" class="form-control form-control-sm" required>
                                 <?php create_tipo_direccion(''); ?>
                                 </select>
                            </div>
                            <div class="col-sm-12 col-md-4 col-lg-5" style="margin-bottom: 12px; margin-top: 0px;">
                              <label class="col-form-label form-control-label mt-0 text-success-d1 text-100">Calle<span style="color:red;">*</span></label>
                              <input class="form-control form-control-sm" type="text" value="" id="domicilio1" name="domicilio1" required> 
                            </div>
                            <div class="col-sm-12 col-md-4 col-lg-2">
                              <label class="col-form-label form-control-label text-success-d1 text-100">Exterior</label>
                              <input class="form-control form-control-sm" type="text" value="" id="exterior1" name="exterior1">
                             </div>
                             <div class="col-sm-12 col-md-4 col-lg-2">
                                <label class="col-form-label form-control-label text-success-d1 text-100">Interior<span style="color:red;">*</span></label>
                                <input class="form-control form-control-sm" type="text" value="" id="interior1" name="interior1" required>
                             </div>
                          </div>
                          <div class="form-group row" style="margin:0px; padding:0px;">
                             <div class="col-sm-12 col-md-4 col-lg-6" style="margin-bottom: 12px; margin-top: 0px;">
                                <label class="col-form-label form-control-label mt-0 text-success-d1 text-100">Estado<span style="color:red;">*</span></label>
                                <select name="estados1" id="estados1" class="form-control form-control-sm" style="width: 100%" required>
                                <?php create_estados(''); ?>
                                </select>
                             </div>
                             <div class="col-sm-12 col-md-4 col-lg-6" style="margin-bottom: 12px; margin-top: 0px;">
                                <label class="col-form-label mt-0 form-control-label text-success-d1 text-100">Ciudad/Alcadía<span style="color:red;">*</span></label>
                                <select name="municipios1" id="municipios1" class="form-control form-control-sm" required style="width: 100%" >
                                <?php create_municipios('', ''); ?>
                                </select>
                             </div>
                          </div>
                          <div class="form-group row" style="margin:0px; padding:0px;">
                            <div class="col-sm-12 col-md-4 col-lg-6" style="margin-bottom: 12px; margin-top: 0px;">
                                <label class="col-form-label form-control-label mt-0 form-control-label text-success-d1 text-100">Localidad<span style="color:red;">*</span></label>
                                <select name="localidad1" id="localidad1" class="form-control form-control-sm" required style="width: 100%" >
                                <?php create_localidad('', ''); ?>
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-4 col-lg-3" style="margin-bottom: 12px; margin-top: 0px;">
                                <label class="col-form-label form-control-label mt-0 form-control-label text-success-d1 text-100">Código Postal<span style="color:red;">*</span></label>
                                <select name="codigo_postal1" id="codigo_postal1" class="form-control form-control-sm" required>
                                <?php create_cp('', ''); ?>
                                </select>
                            </div>
                            <script>
                              $('#estados1').change(function(){ $('#estados1').onchange_estados(  $('#estados1').val(), '#municipios1','#localidad1','#codigo_postal1'   );   }  );
                              $('#municipios1').change(function(){ $('#municipios1').onchange_municipios(  $('#municipios1').val(),'#localidad1','#codigo_postal1'   );   }  );
                              $('#localidad1').change(function(){ $('#localidad1').onchange_localidad(  $('#localidad1').val(),'#codigo_postal1'   );   }  ); 
                            </script>
                            <div class="col-sm-12 col-md-4 col-lg-3" style="margin-bottom: 12px; margin-top: 0px;">
                                <label class="col-form-label form-control-label mt-0 text-success-d1 text-100">Empezó a habitar<span style="color:red;">*</span></label>
                                <div class="input-group date" id="id-timepicker">
                                   <div class="input-group-addon input-group-append">
                                   <div class="input-group-text">
                                      <i class="fa fa-calendar"></i>
                                   </div>
                                    </div>
                                   <input type="text" class="form-control form-control-sm" id="inicia_habitar1"  name="inicia_habitar1" required 
                                   autocomplete="off">
                                   <script>  $("#inicia_habitar1").activeCalendary('#inicia_habitar1'); </script>
                                </div>
                                <!-- ESTE ES UN DATE PICKER -->
                            </div>
                          </div>
                          <div class="form-group row" style="margin:0px; padding:0px;">
                             <div class="col-sm-12 col-md-4 col-lg-4" style="margin-bottom: 12px; margin-top: 0px;">
                                <label class="col-form-label form-control-label mt-0 form-control-label text-success-d1 text-100">Entre Calles<span style="color:red;">*</span></label>
                                <textarea class="form-control" rows="5" id="entrecalles1" name="entrecalles1" required></textarea>
                             </div>
                             <div class="col-sm-12 col-md-4 col-lg-4" style="margin-bottom: 12px; margin-top: 0px;">
                                <label class="col-form-label form-control-label mt-0 form-control-label text-success-d1 text-100">Referencia<span style="color:red;">*</span></label>
                                <textarea class="form-control" rows="5" id="referencia1" name="referencia1" required></textarea>
                             </div>
                             <div class="col-sm-12 col-md-6 col-lg-4" style="margin-bottom: 12px; margin-top: 0px;">
                                <label class="col-form-label form-control-label mt-0 form-control-label text-success-d1 text-100">Vialidad<span style="color:red;">*</span></label>
                                <textarea class="form-control" rows="5" id="observaciones1" name="observaciones1" required></textarea>
                             </div>
                          </div>
                          <!---//Contenido del form Domicilios Adicionales -->
                      </div> <!-- / id="formDomiciliosAdic" class="collapse" -->

                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                      <button type="submit" class="btn btn-success">Guardar Cambios</button>
                    </div>

                  </div>
                </div>
              </div>
            </div>
            </form>
          <!---//FIN DE MODAL DE DIRECCIONES -->

          <!-- MODAL CONTACTOS-->
          <form id="contactos" name="contactos" action="">
            <div class="modal fade modal-lg" id="modalContactos" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">

                  <div class="modal-header">
                    <h5 class="modal-title text-success">Contacto</h5>
                    <input  type="hidden" id="idkey_contacto" name="idkey_contacto"> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>

                  <div class="modal-body ace-scrollbar">

                  <div id="form_contacto">
                    <div class="card-body">
                        
                      <div class="form-group row" style="margin:0px; padding:0px;">
                        <div class="col-sm-12 col-md-12 col-lg-6" style="margin-bottom: 12px; margin-top: 0px;">
                          <label class="col-form-label form-control-label" style="margin-top: 0px;">Descripción<span style="color:red;">*</span></label>
                          <input type="text" class="form-control form-control-sm" id="contacto_descripcion" name="contacto_descripcion" required>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-6">
                          <label class="col-form-label form-control-label">Teléfono<span style="color:red;">*</span></label>
                          <input type="text" class="form-control form-control-sm" id="contacto_telefono" name="contacto_telefono" required>
                        </div>
                      </div>
                      <div class="form-group row" style="margin:0px; padding:0px;">
                        <div class="col-sm-12 col-md-12 col-lg-6" style="margin-bottom: 12px; margin-top: 0px;">
                          <label class="col-form-label form-control-label">Correo electrónico</label>
                          <input type="email" class="form-control form-control-sm" id="contacto_email" name="contacto_email">
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-6">
                          <label class="col-form-label form-control-label">Prioridad<span style="color:red;">*</span></label>
                          <select name="contacto_prioridad" id="contacto_prioridad" class="form-control form-control-sm" required>
                            <?php create_contacto_prioridad(''); ?>
                          </select>
                        </div>
                      </div>

                    </div>
                  </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="cerrarModalContacto" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Guardar Cambios</button>
                  </div>

                </div>
              </div>
            </div>
          </form>
          <!-- FIN MODAL CONTACTOS -->
          
  
        </div><!-- Step-1 -->
<!------------------ /////FIN PASO 1 -------------------->

         <div id="step-2">
          <form id="paso2form" action="">
          <!-- PASO 2 -->
          <!-- Datos Adicionales-->
          <div class="page-title">
            <h3 class="text-secondary-d2 text-success text-center pb-3">Datos Adicionales</h3>

            <!--  Campos de control-->
            <input type="hidden" id="idkey_datos_adic" name="idkey_datos_adic"><!--Guarda el id de datos adicionales si es que lo hay-->
           

          </div>
          <div class="accordion" id="nuevoClienteAlta2">

            <div class="card border-0">
               <div class="card-header border-0 bg-transparent" id="datosCiviles">
                  <h2 class="card-title">
                  <a class="accordion-toggle bgc-success-l3 rounded-lg d-style" href="#formDatosCiviles" data-toggle="collapse" aria-expanded="true" aria-controls="formDatosCiviles">
                     <span class="v-n-collapsed h-100 position-tl border-l-3 brc-success-tp2"></span>
                     <span class="text-success-m1">
                        <i class="fa fa-angle-right toggle-icon mr-1"></i>
                        Datos Civiles
                        </span>
                  </a>
                  </h2>
               </div>
               
               <div id="formDatosCiviles" class="collapse show" aria-labelledby="datosCiviles" data-parent="#nuevoClienteAlta2">
               <div class="card-body text-grey-d3">

               <div class="col-sm-12 col-md-6 col-lg-4" style="margin-bottom: 12px; margin-top: 0px;">
                  <label class="col-form-label form-control-label mt-0 text-success-d1 text-100">Estado Civil<span style="color:red;">*</span></label>
                  <select name="estado_civil" id="estado_civil" class="form-control ace-select no-border text-dark-tp2 bgc-grey-l4 bgc-h-success-l3 brc-grey-m4 brc-h-success-m2 border-1" required>
                      <?php 
                      $seleccion = "";
                      create_estado_civil($seleccion); ?>
                  </select>
              </div>

               </div> <!-- / card-body -->
               </div> <!-- / id="formIdentificaciones" class="collapse" -->
            </div> <!-- / Card identificaciones -->


            <div class="card border-0">
               <div class="card-header border-0 bg-transparent" id="datosPerfil">
                  <h2 class="card-title">
                  <a class="accordion-toggle bgc-success-l3 rounded-lg d-style" href="#formDatosPerfil" data-toggle="collapse" aria-expanded="true" aria-controls="formDatosPerfil">
                     <span class="v-n-collapsed h-100 position-tl border-l-3 brc-success-tp2"></span>
                     <span class="text-success-m1">
                        <i class="fa fa-angle-right toggle-icon mr-1"></i>
                        Datos de Perfil
                        </span>
                  </a>
                  </h2>
               </div>
               
               <div id="formDatosPerfil" class="collapse" aria-labelledby="datosPerfil" data-parent="#nuevoClienteAlta2">
               <div class="card-body text-grey-d3">
                  <div class="form-group row">
                      <div class="col-sm-12 col-md-6 col-lg-6">
                          <label class="col-form-label form-control-label mt-0 text-success-d1 text-100">Nivel Académico<span style="color:red;">*</span></label>
                          <select name="nivel_academico" id="nivel_academico" class="form-control ace-select no-border text-dark-tp2 bgc-grey-l4 bgc-h-success-l3 brc-grey-m4 brc-h-success-m2 border-1" required>
                          <?php 
                            $seleccion = "";
                            create_nivel_academico($seleccion); 
                            ?>
                          </select>
                      </div>
                      <div class="col-sm-12 col-md-6 col-lg-6">
                          <label class="col-form-label form-control-label mt-0 text-success-d1 text-100">Número de Dependientes<span style="color:red;">*</span></label>
                          <input type="number" class="form-control form-control-sm" value="" id="dependientes"  name="dependientes" required >
                              
                      </div>
                  </div>
                  <div class="form-group row mt-5">
                      <div class="col-sm-12 col-md-4 col-lg-4" style="margin-bottom: 12px; margin-top: 0px;">
                          <label class="radius-round ml-n2 pl-2 pr-1 pt-1 pb-2 bgc-h-success-l2">
                           <input type="checkbox" class="text-success" id="indigena" name="indigena">
                          </label>
                          <label for="indigena" class="mt-0 text-success-d1 text-100">Pertenece a una población indígena</label>
                      </div>
                      <div class="col-sm-12 col-md-4 col-lg-4" style="margin-bottom: 12px; margin-top: 0px;">
                          <label class="radius-round ml-n2 pl-2 pr-1 pt-1 pb-2 bgc-h-success-l2">
                           <input type="checkbox" class="text-success" id="penales" name="penales">
                              
                          </label>
                          <label for="penales" class="mt-0 text-success-d1 text-100">Tiene antecedentes penales</label>
                      </div>
                      <div class="col-sm-12 col-md-4 col-lg-4" style="margin-bottom: 12px; margin-top: 0px;">
                          <label class="radius-round ml-n2 pl-2 pr-1 pt-1 pb-2 bgc-h-success-l2">
                           <input type="checkbox" class="text-success" id="politica" name="politica">
                              
                          </label>
                          <label for="politica" class="mt-0 text-success-d1 text-100">¿Tiene alguna afiliación política?</label>
                      </div>
                  </div>
                  
               </div> <!-- / card-body -->
               </div> <!-- / id="formIdentificaciones" class="collapse" -->
            </div> <!-- / Card identificaciones -->


            <div class="card border-0">
               <div class="card-header border-0 bg-transparent" id="datosFiscales">
                  <h2 class="card-title">
                  <a class="accordion-toggle bgc-success-l3 rounded-lg d-style" href="#formDatosFiscales" data-toggle="collapse" aria-expanded="true" aria-controls="formDatosFiscales">
                     <span class="v-n-collapsed h-100 position-tl border-l-3 brc-success-tp2"></span>
                     <span class="text-success-m1">
                        <i class="fa fa-angle-right toggle-icon mr-1"></i>
                        Datos Fiscales
                        </span>
                  </a>
                  </h2>
               </div>
               
               <div id="formDatosFiscales" class="collapse" aria-labelledby="datosCiviles" data-parent="#nuevoClienteAlta2">
               <div class="card-body text-grey-d3">

                  <div class="form-group row" style="margin:0px; padding:0px;">
                      <div class="col-sm-12 col-md-4 col-lg-4" style="margin-bottom: 12px; margin-top: 0px;">
                          <label class="col-form-label form-control-label mt-0 text-success-d1 text-100">Régimen fiscal<span style="color:red;">*</span></label>
                          <select name="regimen_fiscal" id="regimen_fiscal" class="form-control form-control-sm" >
                          <?php 
                          $seleccion = "";
                          create_regimen_fiscal($seleccion); ?>
                          </select>
                      </div>
                      <div class="col-sm-12 col-md-4 col-lg-4" style="margin-bottom: 12px; margin-top: 0px;">
                          <label class="col-form-label form-control-label mt-0 text-success-d1 text-100">Fecha de alta ante el SAT</label>
                          <div class="input-group date" id="id-timepicker">
                            <div class="input-group-addon input-group-append">
                                <div class="input-group-text">
                                   <i class="fa fa-calendar"></i>
                                </div>
                            </div>
                            <input type="text" name="fecha_sat" class="form-control form-control-sm" id="fecha_sat" autocomplete="off">
                            <script>  $("#fecha_sat").activeCalendary('#fecha_sat'); </script>
                         </div>
                      </div>
                      <div class="col-sm-12 col-md-4 col-lg-4" style="margin-bottom: 12px; margin-top: 0px;">
                          <label class="col-form-label form-control-label mt-0 text-success-d1 text-100">Correo de facturación</label>
                          <div class="input-group">
                          <div class="input-group-addon input-group-append">
                                <div class="input-group-text">
                                   <i class="fa fa-at"></i>
                                </div>
                            </div>
                          <input class="form-control form-control-sm"  value="" name="email_facturacion" id="email_facturacion" type="email">
                        </div>
                      </div>
                  </div>

                  <div class="form-group row" style="margin:0px; padding:0px;">
                      <div class="col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 12px; margin-top: 0px;">
                          <label class="col-form-label form-control-label mt-0 text-success-d1 text-100">Domicilio fiscal</label>
                          <div class="input-group">
                            <input type="text" list="misdomicilios" name="domicilio_fiscal" class="form-control form-control-sm" id="domicilio_fiscal" autocomplete="off">
                            <datalist id="misdomicilios">
                            </datalist>
                         </div>
                      </div>
                  </div>
                  <div class="form-group row" style="margin:0px; padding:0px;">
                      <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 12px; margin-top: 0px;">
                          <label class="col-form-label form-control-label mt-0 text-success-d1 text-100">No. serie FIEL</label>
                          <input class=" form-control form-control-sm" type="text" value="" name="fiel" id="fiel">
                      </div>
                      <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 12px; margin-top: 0px;">
                          <label class="col-form-label form-control-label mt-0 text-success-d1 text-100">No. Cédula de identificación fiscal</label>
                          <input class=" form-control form-control-sm" type="text" value="" name="cedula" id="cedula">
                      </div>
                  </div>
               </div> <!-- / card-body -->
               </div> <!-- / id="formIdentificaciones" class="collapse" -->
            </div> <!-- / Card datos fiscales -->
            <!-- CARGOS PÚBLICOS -->
            <div class="card border-0">
               <div class="card-header border-0 bg-transparent" id="datosCargoPublico">
                  <h2 class="card-title">
                  <a class="accordion-toggle bgc-success-l3 rounded-lg d-style" href="#formdatosCargoPublico" data-toggle="collapse" aria-expanded="true" aria-controls="formdatosCargoPublico">
                     <span class="v-n-collapsed h-100 position-tl border-l-3 brc-success-tp2"></span>
                     <span class="text-success-m1">
                        <i class="fa fa-angle-right toggle-icon mr-1"></i>
                        Cargo público
                        </span>
                  </a>
                  </h2>
               </div>
               
               <div id="formdatosCargoPublico" class="collapse" aria-labelledby="datosCiviles" data-parent="#nuevoClienteAlta2">
               <div class="card-body text-grey-d3">

                  <div class="form-group row" style="margin:0px; padding:0px;">
                      <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 12px; margin-top: 0px;">
                          <label class="col-form-label form-control-label mt-0 text-success-d1 text-100">Cargo</label>
                          <select name="id_cargo" id="id_cargo"  class="form-control form-control-sm" style="width: 100%">
                          <?php 
                          $seleccion = "";
                          create_cargos_publicos($seleccion); ?>
                          </select>
                      </div>
                      <div class="col-sm-12 col-md-3 col-lg-3" style="margin-bottom: 12px; margin-top: 0px;">
                          <label class="col-form-label form-control-label mt-0 text-success-d1 text-100">Fecha de Inicio en el Cargo</label>
                          <div class="input-group date" id="id-timepicker">
                            <div class="input-group-addon input-group-append">
                                <div class="input-group-text">
                                   <i class="fa fa-calendar"></i>
                                </div>
                            </div>
                            <input type="text" name="inicio_cargo" class="form-control form-control-sm" id="inicio_cargo" autocomplete="off">
                            <script>  $("#inicio_cargo").activeCalendary('#inicio_cargo'); </script>
                         </div>
                      </div>
                      <div class="col-sm-12 col-md-3 col-lg-3" style="margin-bottom: 12px; margin-top: 0px;">
                          <label class="col-form-label form-control-label mt-0 text-success-d1 text-100">Fecha de Término en el Cargo</label>
                          <div class="input-group date" id="id-timepicker">
                            <div class="input-group-addon input-group-append">
                                <div class="input-group-text">
                                   <i class="fa fa-calendar"></i>
                                </div>
                            </div>
                            <input type="text" name="fin_cargo" class="form-control form-control-sm" id="fin_cargo" autocomplete="off">
                            <script>  $("#fin_cargo").activeCalendary('#fin_cargo'); </script>
                         </div>
                      </div>
    
                  </div>
               </div> <!-- / card-body -->
          </div> <!-- / id="formIdentificaciones" class="collapse" -->
          <hr>
          <div class="row">
             <div class="col-lg-3">
                <button id="safe_paso2" type="submit" class="btn btn-success btn-sm">
                  <i class="fas fa-save"></i>&nbsp;Guardar
                </button>
             </div>
          </div>
      </div> <!-- / Card identificaciones -->
      </div>
    </form>
  </div>
<!------------------ /////FIN PASO 2-------------------->

  <div id="step-3">
    <form id="paso3form" name="paso3form" action=""> 
      <!-- PASO 3 -->
      <!-- Estudio socio económico -->
       <!--  Campos de control-->
      <input type="hidden" id="idkey_socioeconomico" name="idkey_socioeconomico">

      <div class="page-title">
          <h3 class="text-secondary-d2 text-center text-success pb-3">Estudio Socio-económico</h3>
      </div>

      <div class="card-body text-grey-d3">
          <div class="form-group row" style="margin:0px; padding:0px;">
          </div>
          <div class="form-group row card-body">
              <div class="col-sm-12 col-md-4 col-lg-4 mb-4">
                  <div class="font-bolder text-orange-d2 mb-2">
                  <label class="col-form-label form-control-label">Servicios<span style="color:red;">*</span></label>
                  </div>
                  <div class="form-check">
                      <label class=" text-uppercase text-95 text-secondary" for="defaultCheck1">
                       <input class="input-lg text-danger-m1 brc-on-checked brc-success brc-h-success-m1 border-2 servicio1" type="checkbox" value="" id="agua" name="agua" >
                      Agua potable
                      </label>
                  </div>  
                  <div class="form-check">
                      <label class=" text-uppercase text-95 text-secondary" for="defaultCheck2">
                       <input class="input-lg text-danger-m1 brc-on-checked brc-success brc-h-success-m1 border-2 servicio1" type="checkbox" value="" id="electri" name="electri">       
                      Electricidad
                      </label>
                  </div>
                  <div class="form-check">
                      <label class=" text-uppercase text-95 text-secondary" for="defaultCheck3">
                       <input class="input-lg text-danger-m1 brc-on-checked brc-success brc-h-success-m1 border-2 servicio1" type="checkbox" value="" id="telefono" name="telefono">
                      Teléfono
                      </label>
                  </div>
                  <div class="form-check">
                      <label class=" text-uppercase text-95 text-secondary" for="defaultCheck3">
                       <input class="input-lg text-danger-m1 brc-on-checked brc-success brc-h-success-m1 border-2 servicio1" type="checkbox" value="" id="drenaje" name="drenaje">
                      Drenaje
                      </label>
                  </div>
                  <div class="form-check">
                      <label class=" text-uppercase text-95 text-secondary" for="defaultCheck4">
                       <input class="input-lg text-danger-m1 brc-on-checked brc-success brc-h-success-m1 border-2 servicio1" type="checkbox" value="" id="ant_cable" name="ant_cable">
                      Antena / Cable
                      </label>
                  </div>
                  <div class="col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 12px; margin-top: 0px;">
                      &nbsp;&nbsp;
                  </div>
                  <div class="col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 12px; margin-top: 0px;">
                      <label class="col-form-label form-control-label small text-secondary">Detalle</label>
                      <textarea class="form-control" maxlength="100" id="servicios_detalle" name="servicios_detalle"></textarea>
                  </div>
                  
              </div>

              <div class="col-sm-12 col-md-4 col-lg-4 mb-4">
                  <div class="font-bolder text-orange-d2 mb-2">
                  <label class="col-form-label form-control-label">Electrodomésticos<span style="color:red;">*</span></label> 
                  </div>
                  <div class="form-check">
                      <label class=" text-uppercase text-95 text-secondary" for="defaultCheck1">
                       <input class="input-lg text-danger-m1 brc-on-checked brc-success brc-h-success-m1 border-2 electro1" type="checkbox" value="" id="estufa" name="estufa">
                      Estufa
                      </label>
                  </div>  
                  <div class="form-check">
                      <label class=" text-uppercase text-95 text-secondary" for="defaultCheck2">
                          <input class="input-lg text-danger-m1 brc-on-checked brc-success brc-h-success-m1 border-2 electro1" type="checkbox" value="" id="lavadora" name="lavadora">   
                      Lavadora
                      </label>
                  </div>
                  <div class="form-check">
                      <label class=" text-uppercase text-95 text-secondary" for="defaultCheck3">
                          <input class="input-lg text-danger-m1 brc-on-checked brc-success brc-h-success-m1 border-2 electro1" type="checkbox" value="" id="refri" name="refri">
                      Refrigerador
                      </label>
                  </div>
                  <div class="form-check">
                      <label class=" text-uppercase text-95 text-secondary" for="defaultCheck3">
                          <input class="input-lg text-danger-m1 brc-on-checked brc-success brc-h-success-m1 border-2 electro1" type="checkbox" value="" id="tele" name="tele">                      
                      Televisión
                      </label>
                  </div>
                  <div class="form-check">
                      <label class=" text-uppercase text-95 text-secondary" for="defaultCheck4">
                          <input class="input-lg text-danger-m1 brc-on-checked brc-success brc-h-success-m1 border-2 electro1" type="checkbox" value="" id="estereo" name="estereo">
                      Estéreo
                      </label>
                  </div>
                  <div class="form-check">
                      <label class=" text-uppercase text-95 text-secondary" for="defaultCheck4">
                          <input class="input-lg text-danger-m1 brc-on-checked brc-success brc-h-success-m1 border-2 electro1" type="checkbox" value="" id="compu" name="compu">
                      Computadora
                      </label>
                  </div>
                  <div class="col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 12px; margin-top: 0px;">
                      <label class="col-form-label form-control-label small text-secondary">Detalle</label>
                      <textarea class="form-control" maxlength="100" id="electro_detalle" name="electro_detalle"></textarea>
                  </div>
              </div>

              <div class="col-sm-12 col-md-4 col-lg-4 mb-4">
                  <div class="font-bolder text-orange-d2 mb-2">
                  <label class="col-form-label form-control-label">Habitaciones/Recámaras<span style="color:red;">*</span></label>  
                  </div>
                  <div class="form-check">
                      <label class=" text-uppercase text-95 text-secondary" for="defaultCheck1">
                          <input class="input-lg text-danger-m1 brc-on-checked brc-success brc-h-success-m1 border-2 habitacion1" type="checkbox" value="" id="sala"  name="sala">
                      Sala
                      </label>
                  </div>  
                  <div class="form-check">
                      <label class=" text-uppercase text-95 text-secondary" for="defaultCheck2">
                          <input class="input-lg text-danger-m1 brc-on-checked brc-success brc-h-success-m1 border-2 habitacion1" type="checkbox" value="" id="comedor" name="comedor">
                      Comedor
                      </label>
                  </div>
                  <div class="form-check">
                      <label class=" text-uppercase text-95 text-secondary" for="defaultCheck3">
                          <input class="input-lg text-danger-m1 brc-on-checked brc-success brc-h-success-m1 border-2 habitacion1" type="checkbox" value="" id="cocina" name="cocina">
                      Cocina
                      </label>
                  </div>
                  <div class="form-check">
                      <label class=" text-uppercase text-95 text-secondary" for="defaultCheck3">
                          <input class="input-lg text-danger-m1 brc-on-checked brc-success brc-h-success-m1 border-2 habitacion1" type="checkbox" value="" id="bano_p" name="bano_p">
                      Baño privado
                      </label>
                  </div>
                  <div class="col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 12px; margin-top: 0px;">
                      &nbsp;&nbsp;
                  </div>
                  <div class="col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 10px; margin-top: 0px;">
                      &nbsp;&nbsp;
                  </div>
                  <div class="col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 12px; margin-top: 0px;">
                      <label class="col-form-label form-control-label small text-secondary">Núm. Habitaciones</label>
                      <textarea class="form-control" maxlength="10" id="habitaciones_detalle" name="habitaciones_detalle"></textarea>
                  </div>
              </div>
          </div> <!-- /form-group row -->
          <hr class="no-padding no-margin">
          <!-- Tipo vivienda -->
          <div class="form-group row card-body">
              <div class="col-sm-12 col-md-4 col-lg-4 mb-4">
                  <div class="font-bolder text-orange-d2 mb-2">
                      <label class="col-form-label form-control-label">Tipo Vivienda<span style="color:red;">*</span></label> 
                  </div>
                  <select class="form-control form-control-sm" id="vivienda" name="vivienda" required>
                      <?php 
                      $seleccion = "";
                      create_tipo_vivienda($seleccion) ?>
                  </select>
                  <div class="col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 12px; margin-top: 0px;">
                      <label class="col-form-label form-control-label small text-secondary">Detalle</label>
                      <textarea class="form-control" maxlength="100" id="vivienda_detalle" name="vivienda_detalle"></textarea>
                  </div>
              </div>
              <div class="col-sm-12 col-md-4 col-lg-4 mb-4">
                  <div class="font-bolder text-orange-d2 mb-2">
                  <label class="col-form-label form-control-label">Hacinamiento<span style="color:red;">*</span></label>
                  </div>
                  <select class="form-control form-control-sm" id="hacinamiento" name="hacinamiento" required>
                      <?php 
                      $seleccion = "";
                      create_tipo_hacinamiento($seleccion) ?>
                  </select>
                  <div class="col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 12px; margin-top: 0px;">
                      <label class="col-form-label form-control-label small text-secondary">Detalle</label>
                      <textarea class="form-control" maxlength="100" id="hacinamiento_detalle" name="hacinamiento_detalle"></textarea>
                  </div>
              </div>                                    
              <div class="col-sm-12 col-md-4 col-lg-4 mb-4">
                  <div class="font-bolder text-orange-d2 mb-2">
                  <label class="col-form-label form-control-label">Techo<span style="color:red;">*</span></label>
                  </div>
                  <select class="form-control form-control-sm" id="techo" name="techo" required>
                      <?php 
                      $seleccion = "";
                      create_tipo_techo($seleccion) ?>
                  </select>
                  <div class="col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 12px; margin-top: 0px;">
                      <label class="col-form-label form-control-label small text-secondary">Detalle</label>
                      <textarea class="form-control" maxlength="100" id="techo_detalle" name="techo_detalle"></textarea>
                  </div>
              </div>
          </div>
          <hr>
          <div class="form-group row card-body">
              <div class="col-sm-12 col-md-4 col-lg-4 mb-4">
                  <div class="font-bolder text-orange-d2 mb-2">
                  <label class="col-form-label form-control-label">Material<span style="color:red;">*</span></label>
                  </div>
                  <select class="form-control form-control-sm" id="material" name="material" required>
                     <?php 
                      $seleccion = "";
                      create_tipo_material($seleccion) ?>
                  </select>
                  
                  <div class="col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 12px; margin-top: 0px;">
                      <label class="col-form-label form-control-label small text-secondary">Detalle</label>
                      <textarea class="form-control" maxlength="100" id="material_detalle" name="material_detalle"></textarea>
                  </div>
              </div>
              <div class="col-sm-12 col-md-4 col-lg-4 mb-4">
                  <div class="font-bolder text-orange-d2 mb-2">
                  <label class="col-form-label form-control-label">Piso<span style="color:red;">*</span></label>
                  </div>
                  <select class="form-control form-control-sm" id="piso" name="piso" required>
                      <?php 
                      $seleccion ="";
                      create_tipo_piso($seleccion) ?>
                  </select>
                  <div class="col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 12px; margin-top: 0px;">
                      <label class="col-form-label form-control-label small text-secondary">Detalle</label>
                      <textarea class="form-control" maxlength="100" id="piso_detalle" name="piso_detalle"></textarea>
                  </div>
              </div>
              <div class="col-sm-12 col-md-4 col-lg-4 mb-4">
              <div class="font-bolder text-orange-d2 mb-2">
                  <label class="col-form-label form-control-label">Residentes<span style="color:red;">*</span></label>
                  <input type="number" class="form-control" id="residentes" value="" name="residentes" required>
                  <p class="small text-secondary mb-0">Total de personas que viven en el domicilio</p>
                  </div>
              </div>
          </div><!-- /form-group row -->
          <hr class="no-padding no-margin">
          <div class="form-group row card-body">
              
              <div class="col-sm-12 col-md-12 col-lg-12 mb-4">
                  <div class="font-bolder text-orange-d2 mb-2">
                  <label class="col-form-label form-control-label">Observaciones<span style="color:red;">*</span></label>
                  <textarea class="form-control" maxlength="100" id="observaciones_socioeconomico" name="observaciones_socioeconomico" required></textarea>
                  </div>
              </div>
          </div>
          <div class="col-lg-12 mb-4">
              <button id="socioeconomico" type="submit" name="socioeconomico" class="btn btn-success btn-sm"><i class="fas fa-save"></i>&nbsp;Guardar</button>
          </div>  

      </div> <!-- / card-body -->
    </form>
  </div>
<!----------------------------//FIN PASO 3-->

    <div id="step-4" >
        <!-- PASO 4 -->
        <div class="accordion" id="nuevoClienteAlta4">
            <!--<div class="card border-0">-->
            <div class="card-header border-0 bg-transparent" id="datosGarantias">
                <h2 class="card-title">
                    <a class="accordion-toggle bgc-success-l3 rounded-lg d-style" href="#formdatosGarantias" data-toggle="collapse" aria-expanded="true" aria-controls="formdatosGarantias">
                        <span class="v-n-collapsed h-100 position-tl border-l-3 brc-success-tp2"></span>
                        <span class="text-success-m1">
                        <i class="fa fa-angle-right toggle-icon mr-1"></i>
                        Bienes/Garantias
                        </span>
                    </a>
                </h2>
            </div>
                 
            <div id="formdatosGarantias" class="collapse show" aria-labelledby="datosGarantias" data-parent="#nuevoClienteAlta4">
                <div class="card-body text-grey-d3">
                <!-- formularios garantias MUBELES-->

                      
                <?php 
                if(isset($_GET["idkey_cliente"]))
                   require("../views/cartera_clientes/view_garantias_muebles.php"); 
                ?>

                    
                  
                    
                </div> <!-- / class="collapse" -->
            </div> <!-- / Card Garantias -->

            <div id="formdatosGarantias" class="collapse show" aria-labelledby="datosGarantias" data-parent="#nuevoClienteAlta4">
                <div class="card-body text-grey-d3">
                <!-- formularios garantias MUBELES-->
                      
                <?php 
                if(isset($_GET["idkey_cliente"]))
                  require("../views/cartera_clientes/view_garantias_inmuebles.php"); 
                ?>
                    
                </div> <!-- / class="collapse" -->
            </div> <!-- / Card Garantias -->
            
            <!--INGRESOS -->
            <div class="card border-0">
                <div class="card-header border-0 bg-transparent" id="datosIngresos">
                <h2 class="card-title">
                    <a class="accordion-toggle bgc-success-l3 rounded-lg d-style" href="#formdatosIngresos" data-toggle="collapse" aria-expanded="true" aria-controls="formdatosIngresos" id="ingresos_head">
                        <span class="v-n-collapsed h-100 position-tl border-l-3 brc-success-tp2"></span>
                        <span class="text-success-m1">
                            <i class="fa fa-angle-right toggle-icon mr-1"></i>
                            Ingresos
                        </span>
                    </a>
                </h2>
                </div>

                 
                <div id="formdatosIngresos" class="collapse" aria-labelledby="datosIngresos" data-parent="#nuevoClienteAlta4">
                <div class="card-body text-grey-d3">
                    <!-- insert formularios ingresos -->
                    <div id="div_ingresos">
                      
                      <?php 
                      if(isset($_GET["idkey_cliente"]))
                         require("../views/cartera_clientes/view_ingresos.php"); 
                      ?>

                    </div>
                </div> <!-- / card-body -->
                </div> <!-- / id="formIdentificaciones" class="collapse" -->
            </div> <!-- / Card identificaciones -->
            <!--EGRESOS -->
            <div class="card border-0">
                <div class="card-header border-0 bg-transparent" id="datosEgresos">
                <h2 class="card-title">
                    <a class="accordion-toggle bgc-success-l3 rounded-lg d-style" href="#formdatosEgresos" data-toggle="collapse" aria-expanded="true" aria-controls="formdatosEgresos" id="egresos_head">
                    <span class="v-n-collapsed h-100 position-tl border-l-3 brc-success-tp2"></span>
                    <span class="text-success-m1">
                        <i class="fa fa-angle-right toggle-icon mr-1"></i>
                        Egresos
                    </span>
                    </a>
                </h2>
                </div>
                     
                <div id="formdatosEgresos" class="collapse" aria-labelledby="datosCiviles" data-parent="#nuevoClienteAlta4">
                <div class="card-body text-grey-d3">
                    <div id="div_egresos">
                      <?php 
                      if(isset($_GET["idkey_cliente"]))
                         require("../views/cartera_clientes/view_egresos.php"); 
                      ?>
                    </div>
                </div> <!-- / card-body -->
                </div> <!-- / id="formIdentificaciones" class="collapse" -->
            </div> <!-- / Card identificaciones -->
            </div>
        <!--</div>-->
        
    </div>
<!--------------------FIN PASO 4------------------------------------>

<!--------------------FIN PASO 5------------------------------------>
    <div id="step-5" class="text-center">
      <div class="page-title">
          <h3 class="text-secondary-d2 text-center text-success pb-3">Información Adicional</h3>
      </div>
      <div id="div_factores" style="overflow-x: auto;">
        <?php
        if(isset($_GET["idkey_cliente"]))
          require("../views/cartera_clientes/view_factores.php");
        ?>
      </div>
    </div>

<!--
    <div id="step-6" class="text-center">
      <div class="container-bg ">
        <div class="container">
          <div class="row pt-4">
            <div class="col-12 col-lg-10 col-xl-8 mx-auto">
              <div class="d-flex flex-column align-items-center flex-md-row align-items-md-start">
                <div class="flex-grow-1 text-dark-tp3 mt-4 mt-md-0 ml-md-2">
                  <div data-aos="fade-up" class="aos-init aos-animate">
                    <input type='hidden' name='idkey_cliente' id='idkey_cliente' value='<?php echo $_GET["idkey_cliente"];?>'>
                    <div class="alert bgc-yellow-l4 brc-success-l2 border-1 pl-3" role="alert">
                      <div id="div_reporte">
                        <?php/*
                        if(isset($_GET["idkey_cliente"]))
                          require("views/cartera_clientes/view_reporte.php");*/
                        ?>
                      </div>
                    </div>                                                    
                  </div>
                </div>
              </div>
            </div>
            <div></div>
          </div>
        </div>
      </div>
    </div>
-->
<!--------------- FIN DE TODOS LOS PASOS -->
      
    </div>
  </div>
</div><!-- /.page-content -->

<?php end_containers(); ?>
<!-- Para validar los campos de los forms-->
<script src="../js/validate_rules.js"></script>
<!--Funciones para proceso de datos-->
<script type="text/javascript" src="../js/funciones_cartera.js"></script>

<!--Datatables-->
<script type="text/javascript" src="../ace-admin/node_modules/datatables/media/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="../ace-admin/node_modules/datatables.net-bs4/js/dataTables.bootstrap4.js"></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


<script>
  $(document).ready(function() {

    <?php
      if (isset($_GET["idkey_cliente"])){
        ?>
        $('#div_relaciones').load("../php/show_interface_cliente.php?module=main_relaciones&param=<?php echo $_GET["idkey_cliente"] ?>");
        <?php
      }
    ?>

    //Caja de búsqueda de clientes en relaciones
    $(document).on('keyup','#caja_busqueda', function(){
      var valor = $(this).val();
      if (valor != "") 
          buscar_datos(valor);
      else
          buscar_datos();
    });

  }); 

  //Función para búsqueda de clientes en relaciones
  function buscar_datos(consulta){
      $.ajax({
        url: '../php/show_interface_cliente.php' ,
        type: 'POST' ,
        dataType: 'html',
        data: {module:"show_clientes", consulta: consulta, notocar: $('#idkey_cliente').val() },
      }).done(function(respuesta){
          $("#resultado_relaciones").html(respuesta);
      }).fail(function(){
        console.log("error");
      });
  }
    
    
</script>
<?php
    create_footer_forms();
?>

  
  <script>

    $(document).ready(function() {
      
      //Selects con búsqueda
      $('#municipios').select2();
      $('#municipios1').select2({
        dropdownParent: $('#modalDirecciones')
      });

      $('#id_cargo').select2();

     
      $("#animacion").hide(); //Por default animación de carga oculta
      
     //$("#smartwizard-1").smartWizard("goToStep", 3); //Para ir a cierto paso
      
      //Se comprueba si se trata de una actualización y si es así se cargan los datos y si no sólo se desactiva el botón de siguiente
      if($("#idkey_cliente").val() != ""){
        cargar_cliente();
        //$('#smartwizard-1').smartWizard("stepState", [4,5,6], "disable"); //Desactiva todos los pasos siguientes
        cargar_dom_fiscales();//Se precargan los domicilios fiscales
      }
      //Si es nuevo se desactiva el botón siguiente y se ocultan las direcciones adicionales, relaciones y contactos  del paso 1
      else{
        //$('#id-validate').trigger('click');//Deshabilita la navegación
        $('#smartwizard-1').smartWizard("stepState", [1,2,3,4,5,6], "disable"); //Desactiva todos los pasos siguientes
        $('#tab_siguiente').attr("disabled", true); //Deshabilita el botón siguiente
        $('#card_diradic').hide();
        $('#card_relaciones').hide();
        $('#card_contactos').hide();
      }

      //Envío de formulario PASO 1****************************************************************************************
      $( "#paso1form" ).submit(function( event ) {
        //Validamos el formulario y se decide si se trata de un cliente nuevo o actualización mediante el input funcion
        //Solo termino las validaciones de fecha

        if($("#paso1form").valid()){

          //nuevo cliente input hidden funcion = 'nuevo_cliente'
          if($("#funcion").val() == "nuevo_cliente")
             nuevo_cliente();
          else if ($("#funcion").val() == "editar_cliente_step1"){
            editar_cliente_step1();
            cargar_dom_fiscales();//Se actualizan los domicilios fiscales
          }
        }
        else
          alertify.error("Algunos datos están incompletos o erróneos");
        event.preventDefault();//Detiene el envío del form y su recarga

      });//envío form*********************************************************************************************

       //Envío de formulario PASO 2****************************************************************************************
      $( "#paso2form" ).submit(function( event ) {
        if($("#paso2form").valid()){
          //actualiza o agrega
          cliente_datos_adic();
        }
        else
          alertify.error("Algunos datos están incompletos o erróneos");
        event.preventDefault();//Detiene el envío del form y su recarga

      });//envío form*********************************************************************************************

       //Envío de formulario PASO 3****************************************************************************************
      $( "#paso3form" ).submit(function( event ) {
        if($("#paso3form").valid()){
          //actualiza o agrega
          cliente_socioeconomico();
        }
        else
          alertify.error("Algunos datos están incompletos o erróneos");
        event.preventDefault();//Detiene el envío del form y su recarga

      });//envío form*********************************************************************************************


    });

</script>
</div>
</body>
</html>

