<?php
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");

    require_once "../php/security.php";
    require_once "../php/header_facturacion.php";
    require_once "../php/functions.php";
    
    create_header();
    create_menu();
    begin_containers();
    @session_start();
    
    ?>




<div class="row justify-content-around mt-4">

<div class="col-2 col-sm-2 col-lg-2 my-1 my-lg-0 px-sm-1 px-lg-0">
    <figure class="mx-auto text-center">
      <img src="../styles/facturacion.jpg" class="img-responsive " style="border-radius: 150px;" width="200">
    </figure>
    <h1 class="text-grey-d2 pb-0 mb-3 mb-md-0 text-center">Facturaci&oacute;n</h1>
    <hr>
    <h5 class="text-grey-d2 pb-0 mb-3 mb-md-0 text-center">Informaci&oacute;n de Facturaci&oacute;n</h5>
    <p class="text-100 text-secondary text-center">
     <!-- -->
    </p>

</div> <!-- Col-3 cartera-->


<div class="col-12 col-lg-9">

  <h5 class="font-light text-orange-d2"> 
    <span class="b-underline-4"><a  href="facturacion.php" style="text-decoration: none;" class="font-light text-orange-d2">Informaci&oacute;n de Pagos Generales</a></span> &nbsp;&nbsp;&nbsp;

  </h5>
      
      <!-- datos generales del empleado -->
      <div class="row mt-2">
          <div class="mx-auto col-sm-12 col-md-12 col-lg-12">
              <div class="card">
              <h6 class="text-danger mt-2 ml-2 mb-0">*<small class="text-secondary ">Ingresar fecha inicial y la fecha final del mes para realizar b&uacute;squeda</small> </h6>
                <form  action="" name="form_fact" id="form_fact" method='POST' autocomplete="off">

                  <div class="card-body">
                      <div class="form-group row" style="margin:0px; padding:0px;">
                          <div class="col-sm-12 col-md-4 col-lg-4" style="margin-bottom: 2px; margin-top: 0px;">
                            
                            <label class="col-form-label form-control-label text-success-d1 text-100" for="fecha_inicio">Fecha Inicio</label>
                            <div class="input-group date" id="id-timepicker">
                                <div class="input-group-addon input-group-append">
                                    <div class="input-group-text">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                </div>
                                <input type="text" name="fecha_inicio" class="form-control form-control-sm" id="fecha_inicio" required>
                                <script>  $("#fecha_inicio").activeCalendary('#fecha_inicio'); </script>
                            </div>

                          </div>                        
                          <div class="col-sm-12 col-md-4 col-lg-4" style="margin-bottom: 2px; margin-top: 0px;">
                                          
                              <label class="col-form-label form-control-label text-success-d1 text-100" for="fecha_fin">Fecha Final</label>
                              <div class="input-group date" id="id-timepicker">
                                  <div class="input-group-addon input-group-append">
                                      <div class="input-group-text">
                                          <i class="fa fa-calendar"></i>
                                      </div>
                                  </div>
                                  <input type="text" name="fecha_inicio" class="form-control form-control-sm" id="fecha_fin" required>
                                  <script>  $("#fecha_fin").activeCalendary('#fecha_fin'); </script>
                              </div>
                              
                          </div>
                          <div class="col-sm-12 col-md-4 col-lg-4" style="margin-bottom: 2px; margin-top: 0px;">
                          <button class="btn btn-warning btn-h-success btn-text-slide btn-bold-down btn-wide text-120 float-right" style="margin-top: 5%;" onclick="miModuloFacturacion.buscar()">
                              <span class="btn-text-1">
                                  BUSCAR
                              </span>
                              <span class="btn-text-2">
                                  PULSAR    
                              </span>
                          </button>
                          </div>
                      </div>

                  </div>
                
                </form>

              </div>
          </div>
      </div>

            <!-- datos generales del empleado -->
        <div class="row mt-2">
          <div class="mx-auto col-sm-12 col-md-12 col-lg-12">
              <div class="card">

              <h6 class="text-danger mt-2 ml-2 mb-0">*<small class="text-secondary " id="mensaje_busqueda"></small> </h6>
                    <div class="card-body">
                      <div class="table-responsive-md" style="min-width:100%">
                        <table id="datatable" class="table table-bordered table-bordered-x text-dark-m2 text-95 brc-secondary-l1" >
                          <thead class="text-dark-m3 bgc-grey-l4 text-uppercase text-85" >
                              <tr class="small">
                                  <th class="border-0"><input type="checkbox" autocomplete="off" /></th>
                                  <th class="border-0">ID-Cr&eacute;dito</th>
                                  <th class="border-0">Nombre Cliente</th>
                                  <th class="border-0">Nombre Producto</th>
                                  <th class="border-0">Monto</th>
                                  <th class="border-0">No. Pago</th>   
                                  <th class="border-0">Fecha Aprobación</th>
                                  <th class="border-0">Fecha Valor</th>
                                  <th class="border-0" >RFC</th>
                                  <th class="border-0" style="width:10%"></th>
                              </tr>
                          </thead>
                          <tbody class="text-grey" id="bodytable">
                          </tbody>
                        </table>
                      </div> <!--/ table-responsive-md -->
                    </div>
                      
              </div>
          </div>
      </div>
      <?php 
            require("../views/facturacion/view_facturacion.php");

?>
  
          
          
            
</div> <!-- /PRINCIPAL-->
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


      <script type="text/javascript" src="../ace-admin/node_modules/bootbox/bootbox.all.js"></script>
      <script type="text/javascript" src="../ace-admin/node_modules/sweetalert2/dist/sweetalert2.all.js"></script>
      <script type="text/javascript" src="../ace-admin/node_modules/interactjs/dist/interact.js"></script>

      <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
      <script type="text/javascript" src="../js/default.js"></script>
      <script type="text/javascript" src="../js/jquery.validate.min.js"></script>
      <script src="../js/func_facturacion.js"></script>

    </div><!-- /.body-container -->



<?php
   create_footer();
?>
</div>
<script>
     $(document).ready(function(){
          //datatable_gastos();
          jQuery.validator.setDefaults({
          debug: true,
          success: "valid"
        });
        $('.collapse').on('show.bs.collapse',function(){
            $('.collapse.in').collapse('toggle');
        });

     });

</script>

</body>
</html>
