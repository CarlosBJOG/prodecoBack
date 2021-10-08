<?php
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    require_once "../php/security.php";
    require_once "../php/header_ingresos.php";
    require_once "../php/functions.php";
    
    create_header();
    create_menu();
    begin_containers();
    
  ?>

    <div class="row justify-content-around mt-4">

        <div class="col-2 col-sm-2 col-lg-2 my-1 my-lg-0 px-sm-1 px-lg-0">
            <figure class="mx-auto text-center">
              <img src="../styles/dacion.jpg" width="270">
            </figure>
            <h1 class="text-grey-d2 pb-0 mb-3 mb-md-0 text-center">Daci&oacute;n de pago</h1>
            <hr>
            <h5 class="text-grey-d2 pb-0 mb-3 mb-md-0 text-center"></h5>
            <p class="text-100 text-secondary text-center">
             <!-- -->
            </p>

      </div> <!-- Col-3 cartera-->


        <div class="row col-9 col-lg-9" >
            <div class="container ">
            <h4 class="font-light text-orange-d2 b-underline-4"> 
            
              <span> <a href="quitar_pago.php" class="text-orange-d2">Dación de Pago</a></span> 
          </h4>
            <br>
            
            <div class="tabla">
           

            <div class="mt-4 mx-md-2 border-t-1 brc-secondary-l1">
              <div id="table-header" class="d-none justify-content-between px-2 py-25 border-b-1 brc-secondary-l1">
                <div>
                  Resultados 
                  <span class="text-600 text-primary-d1">"Clientes"</span>
                  <small class="text-grey-m2">(Con columnas reordenables)</small>
                </div>
              </div>
            </div>

            <div class="table-responsive-md" style="min-width:100%">
              <table id="datatable" class="table table-bordered table-bordered-x text-dark-m2 text-95 brc-secondary-l1" >
                <thead class="text-dark-m3 bgc-grey-l4 text-uppercase text-85" >
                  <tr class="small">
                  <th class="border-0"><input type="checkbox" autocomplete="off" /></th>
                  <th class="border-0">ID credito</th>
                  <th class="border-0">Fecha último pago</th>
                  <th class="border-0">Cliente</th>
                  <th class="border-0">Producto</th>
                  <th class="border-0">Saldo insoluto</th>  
                  <th class="border-0">Estatus</th>
                  <th class="border-0" style="width:10%">Aplicar dación</th>
                  </tr>
                </thead>
                <tbody class="text-grey" id="bodytable">
                </tbody>
              </table>
            </div> <!--/ table-responsive-md -->
            </div>

            <form action="" name="formulario" id="formulario" method='POST' autocomplete="off">
               <div class="row">
                  <div class="form-group col">
                      <label for="" class="col-form-label form-control-label text-success-d1 text-100">Producto</label>
              
                        <input type="text" name="buscar" id="buscar" class="form-control form-control-sm" required>
                        
                  </div>

                  <div class="form-group col">
                      <label for="" class="col-form-label form-control-label text-success-d1 text-100">Nombre</label>
                      <input type="hidden" name="idkey_credito" class="form-control form-control-sm" id="idkey_credito" required>
                      <input type="text" name="nombre" class="form-control form-control-sm" id="nombre" required>
                  </div>

                  <div class="form-group col">
                      <label for="" class="col-form-label form-control-label text-success-d1 text-100">Adeudo</label>
                      <input type="number" name="num_pago" disabled='true' class="form-control form-control-sm" id="num_pago" required>
                  </div>
               </div>

              <br>

               <div class="row">

                    <div class="form-group col-4">
                      <label for="" class="col-form-label form-control-label text-success-d1 text-100">Tipo de Garantia</label>
                      <select name="garantia" id="garantia" class="form-control form-control-sm" onchange="mostrar_tabla()" required>
                          <option value="" selected></option>
                          <option value="5">MUEBLES</option>
                          <option value="6">INMUEBLES</option>
                      </select>
                    </div>

                    <div class="form-group col-4">
                      <label for="" class="col-form-label form-control-label text-success-d1 text-100">Monto</label>
                      <input type="text" name="monto" class="form-control form-control-sm" id="monto" required>
                    </div>
                  
                    <div class="form-group col-sm-12 col-md-4 col-lg-4">
                        <label class="col-form-label form-control-label text-success-d1 text-100" for="registro">Fecha registro</label>
                        <div class="input-group date" id="id-timepicker">
                            <div class="input-group-addon input-group-append">
                                <div class="input-group-text">
                                    <i class="fa fa-calendar"></i>
                                </div>
                            </div>
                            <input type="text" name="registro" class="form-control form-control-sm" id="registro" required>
                            <script>  $("#registro").activeCalendary('#registro'); </script>
                        </div>
                    </div>

                    <div class="form-group col-12" id="tabla_muebles" >
                       <?php require("../views/ingresos/view_dacion_pago.php"); ?>
                    </div>

                    <div class="form-group col-12" id="tabla_inmuebles">
                       <?php require("../views/ingresos/view_dacion_inmueble.php"); ?>
                    </div>
                   

               </div> 
               <br>  
                    <button id="btnGuardar" type="button" class="btn btn-success btn-sm float-right" >
                      <i class="fas fa-save "></i>&nbsp;Guardar
                    </button>
                    <button id="btnAplicar" type="button" class="btn btn-danger btn-sm float-right" style="margin-right: 2px;" onclick="cancelarform()">
                      <i class="fa fa-arrow-circle-left"></i>&nbsp;Volver
                    </button>
            </div>  
              
          </form>
        </div> <!-- / row con tabla col-lg-8-->  
        
         
        <div id="formdatosGarantias" class="collapse show" aria-labelledby="datosGarantias" data-parent="#nuevoClienteAlta4">
                <div class="card-body text-grey-d3">
              <!-- MODAL -->
            <form id="muebles" name="muebles" action="">
              <div class="modal fade modal-lg" id="modalMuebles" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable" role="document">
                  <div class="modal-content">

                    <div class="modal-header">
                      <h5 class="modal-title text-success">Garantía Mueble</h5>
                      <input  type="hidden" id="idkey_mueble" name="idkey_mueble"> 
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>

                    <div class="modal-body ace-scrollbar">
                      
                    <div id="form_mueble">
                        <div class="row">
                          <div class="col-sm-12 col-md-6 col-lg-6">
                            <label class="col-form-label form-control-label" >Categoria<span style="color:red;">*</span></label>
                            <select name="garantias_categorias" id="garantias_categorias" class="form-control form-control-sm" required>
                              <?php create_garantia_categoria_muebles(""); ?>
                            </select>
                          </div>
                          <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 8px; margin-top: 0px;">
                            <label class="col-form-label form-control-label" style="margin-top: 0px;">Valor comercial<span style="color:red;">*</span></label>
                            <input type="" name="valor_comercial" id="valor_comercial" class="form-control form-control-sm" required>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 8px; margin-top: 0px;">
                            <label class="col-form-label form-control-label" >Marca<span style="color:red;">*</span></label>
                            <input type="" name="marca" id="marca" class="form-control form-control-sm" required>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 8px; margin-top: 0px;">
                            <label class="col-form-label form-control-label" >Modelo<span style="color:red;">*</span></label>
                            <input type="" name="modelo" id="modelo" class="form-control form-control-sm" required>
                          </div>                               
                        </div>
                        <div class="row">
                          <div class="col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 8px; margin-top: 0px;">
                            <label class="col-form-label form-control-label" >Referencia o Factura<span style="color:red;">*</span></label>
                            <input type="" name="referencia_factura" id="referencia_factura" class="form-control form-control-sm" required>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 8px; margin-top: 0px;">
                            <label class="col-form-label form-control-label" >Fecha de Adquisición<span style="color:red;">*</span></label>
                            <div class="input-group date" id="id-timepicker">
                              <div class="input-group-addon input-group-append">
                                  <div class="input-group-text">
                                    <i class="fa fa-calendar"></i>
                                  </div>
                              </div>
                              <input type="text" name="fecha_adquisicion" id="fecha_adquisicion" class="form-control form-control-sm" required autocomplete="off">
                              <script> $("#fecha_adquisicion").activeCalendary('#fecha_adquisicion'); </script>
                          </div>
                          </div>
                          <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 8px; margin-top: 0px;">
                            <label class="col-form-label form-control-label" >Cobertura<span style="color:red;">*</span></label>
                            <select name="cobertura" id="cobertura" class="form-control form-control-sm" required>
                              <option value=""></option>
                              <option value="10">Mayor al 100%</option>
                              <option value="8">Igual al 100%</option>
                              <option value="5">Menor al 100%</option>
                            </select>
                          </div>
                        </div>
                        <div class="row">
                        
                        </div>
                        <div class="row">
                          <div class="col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 12px; margin-top: 0px;">
                            <label class="col-form-label form-control-label" style="margin-top: 0px;">Observaciones</label>
                            <textarea  class="form-control" rows="4"  name="mueble_observaciones" id="mueble_observaciones"></textarea>
                          </div>
                        </div>
                      </div>

                    </div>

                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" id="cerrarModal2" data-dismiss="modal">Cancelar</button>
                      <button type="button" id="btnModal" class="btn btn-success">Guardar Cambios</button>
                    </div>

                  </div>
                </div>
              </div>
            </form>
                    
                </div> <!-- / class="collapse" -->
            </div> <!-- / Card Garantias -->

   
   
   
   
   
   
   
    </div> <!-- /PRINCIPAL-->

    <!-- MODAL -->
<form id="inmuebles" name="inmuebles" action="">
  <div class="modal fade modal-lg" id="modalInmuebles" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-lg" role="document">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title tecxt-success">Garantía Inmueble</h5>
          <input  type="hidden" id="idkey_inmueble" name="idkey_inmueble"> 
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body ace-scrollbar">
          
          <div id="form_inmueble" >
            <div class="row">
              <div class="col-sm-12 col-md-6 col-lg-6">
                <label class="col-form-label form-control-label" >Categoría<span style="color:red;">*</span></label>
                <select name="garantias_categorias1" id="garantias_categorias1" class="form-control form-control-sm" required>
                   <?php create_garantia_categoria_inmuebles(""); ?>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-6 col-lg-6">
                <label class="col-form-label form-control-label" >Valor Fiscal<span style="color:red;">*</span></label>
                <input type="text" name="valor_fiscal" id="valor_fiscal" class="form-control form-control-sm" required="">
              </div>                               
              <div class="col-sm-12 col-md-6 col-lg-6">
                <label class="col-form-label form-control-label" >Valor Catastral<span style="color:red;">*</span></label>
                <input type="text" name="valor_catastral" id="valor_catastral" name="valor_catastral" class="form-control form-control-sm" required="">
              </div>
                                         
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-12 col-lg-12">
                <label class="col-form-label form-control-label" >Número de Escritura</label>
                <input type="text" name="escritura" id="escritura" class="form-control form-control-sm">
              </div>  
            </div>
            <div class="row">  
              <div class="col-sm-12 col-md-6 col-lg-6">
                  <label class="col-form-label form-control-label" >Registro</label>
                  <input type="text" name="registro" id="registro" class="form-control form-control-sm">
              </div>                               
              <div class="col-sm-12 col-md-6 col-lg-6">
                <label class="col-form-label form-control-label" >Gravamen</label>
                <input type="text" name="gravamen" id="gravamen" class="form-control form-control-sm">
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-6 col-lg-6">
                <label class="col-form-label form-control-label" style="margin-top: 8pxpx;">Hipoteca</label>
                <input type="text" name="hipoteca" id="hipoteca" class="form-control form-control-sm">
              </div>
              <div class="col-sm-12 col-md-6 col-lg-6">
                <label class="col-form-label form-control-label" >Aforo</label>
                <select name="aforo" id="aforo" class="form-control form-control-sm">
                  <option value=""></option>
                  <option value="10">Aforo 2 a 1</option>
                  <option value="10.1">Aforo 1 a 1</option>
                  <option value="5">Aforo menor</option>
                  <option value="0.1">Inviable</option>
                </select>
              </div>
            </div>
  
            <div class="col-sm-12 col-md-12 col-lg-12">
              <label class="col-form-label form-control-label" >Descripción</label>
              <textarea  class="form-control" rows="3" id="inmueble_descripcion" name="inmueble_descripcion"></textarea>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-12">
              <label class="col-form-label form-control-label">Observaciones</label>
              <textarea  class="form-control" rows="3" id="inmueble_observaciones" name="inmueble_observaciones"></textarea>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 12px; margin-top: 0px;">
              <label class="col-form-label form-control-label">Medidas y Colindancias</label>
              <textarea  class="form-control" rows="3" id="inmueble_medidas" name="inmueble_medidas"></textarea>
            </div>
            
          </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" id="cerrarModal1" data-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-success" id="btnGuardarinmueble">Guardar Cambios</button>
        </div>

      </div>
    </div>
  </div>
</div>
</form>
      <br>




<?php end_containers(); ?>
<!-- include common vendor scripts used in demo pages -->
      <script type="text/javascript" src="../ace-admin/node_modules/jquery/dist/jquery.js"></script>
      <script type="text/javascript" src="../ace-admin/node_modules/popper.js/dist/umd/popper.js"></script>
      <script type="text/javascript" src="../ace-admin/node_modules/bootstrap/dist/js/bootstrap.js"></script>


      <!-- include vendor scripts used in "DataTables" page. see "application/views/default/pages/partials/table-datatables/@vendor-scripts.hbs" -->
      <script type="text/javascript" src="../ace-admin/node_modules/datatables/media/js/jquery.dataTables.js"></script>
      <script type="text/javascript" src="../ace-admin/node_modules/datatables.net-bs4/js/dataTables.bootstrap4.js"></script>
      <script type="text/javascript" src="../ace-admin/node_modules/datatables.net-colreorder/js/dataTables.colReorder.js"></script>
      <script type="text/javascript" src="../ace-admin/node_modules/datatables.net-select/js/dataTables.select.js"></script>


      <script type="text/javascript" src="../ace-admin/node_modules/datatables.net-buttons/js/dataTables.buttons.js"></script>
      <script type="text/javascript" src="../ace-admin/node_modules/datatables.net-buttons-bs4/js/buttons.bootstrap4.js"></script>
      <script type="text/javascript" src="../ace-admin/node_modules/datatables.net-buttons/js/buttons.html5.js"></script>
      <script type="text/javascript" src="../ace-admin/node_modules/datatables.net-buttons/js/buttons.print.js"></script>
      <script type="text/javascript" src="../ace-admin/node_modules/datatables.net-buttons/js/buttons.colVis.js"></script>

      <!-- include Ace script -->
      <script type="text/javascript" src="../ace-admin/dist/js/ace.js"></script>


      <script type="text/javascript" src="../ace-admin/assets/js/demo.js"></script>
      <!-- this is only for Ace's demo and you don't need it -->

      <!-- "DataTables" page script to enable its demo functionality -->
      <script type="text/javascript" src="../ace-admin/application/views/default/pages/partials/table-datatables/@page-script.js"></script>
      <!-- "Horizontal Menu" page script to enable its demo functionality -->
      <script type="text/javascript" src="../ace-admin/application/views/default/pages/partials/horizontal-menu/@page-script.js"></script>


      <script type="text/javascript" src="../ace-admin/node_modules/bootbox/bootbox.all.js"></script>
    <script type="text/javascript" src="../ace-admin/node_modules/sweetalert2/dist/sweetalert2.all.js"></script>
    <script type="text/javascript" src="../ace-admin/node_modules/interactjs/dist/interact.js"></script>

 <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script type="text/javascript" src="../js/default.js"></script>
    <script type="text/javascript" src="../js/jquery.validate.min.js"></script>
    <script src="../js/validate_rules.js"></script>
    <script type="text/javascript" src="../js/funciones_dacion.js"></script>
    

<?php
 create_footer();
?>
</div>


<!--Funciones para cargar datos-->
<script type="text/javascript">

$(document).ready(function(){
    
  jQuery.validator.setDefaults({
        debug: true,
        success: "valid"
        });
  
      datatable_gastos();

    $("#muebles").validate({
        errorClass: 'text-error',  
        ignore: false,
        rules:{fecha_adquisicion:{FechaAnterior: true}
        }
    });

    $("#inmuebles").validate({
        errorClass: 'text-error',  
        ignore: false,
        rules:{fecha_adquisicion:{FechaAnterior: true}
        }
    });


  
  //   $('#agregar_mueble').on('click', function (e) {
  //     //Se resetea el form cuando se cierrab el modal
  //     $("#muebles")[0].reset();
      
  //     $('#cobertura').val('');

  //     var validator = $("#muebles").validate();
  //     validator.resetForm();
  //   });


  

  });
</script>


</body>
</html>
