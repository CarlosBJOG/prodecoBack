<?php
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    require_once "../php/security.php";
    require_once "../php/header_balance.php";
    require_once "../php/functions.php";
    
    create_header();
    create_menu();
    begin_containers();
    @session_start()
    
    ?>



<div class="row justify-content-around mt-4">

<div class="col-2 col-sm-2 col-lg-2 my-1 my-lg-0 px-sm-1 px-lg-0">
    <figure class="mx-auto text-center">
      <img src="../styles/balance.png" style="border-radius: 150px;" width="280">
    </figure>
    <h1 class="text-grey-d2 pb-0 mb-3 mb-md-0 text-center">Balance</h1>
    <hr>
    <h5 class="text-grey-d2 pb-0 mb-3 mb-md-0 text-center"></h5>
    <p class="text-100 text-secondary text-center">
     <!-- -->
    </p>

</div> <!-- Col-3 cartera-->


<div class="col-12 col-lg-9">

  <h1 class="font-light text-orange-d2"> 
   <span  class="b-underline-4" ><a href="balance.php" style="text-decoration: none;" class="font-light text-orange-d2">Balance</a></span>&nbsp;&nbsp;&nbsp;
  </h1>

  <form action="" name="formulario" id="formulario" method='POST' autocomplete="off">
            <!-- //<label class="col-form-label form-control-label text-success-d1 text-100" for="registro">Ingresar fechas para obtejer registros</label> -->
               <div class="row">
                <div class="form-group col-sm-1 col-md-2 col-lg-3"></div>
                  
                  <div class="form-group col-sm-6 col-md-6 col-lg-3">
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

                  <div class="form-group col-sm-6 col-md-3 col-lg-3">
                      <label class="col-form-label form-control-label text-success-d1 text-100" for="fecha_fin">Fecha Fin</label>
                      <div class="input-group date" id="id-timepicker">
                          <div class="input-group-addon input-group-append">
                              <div class="input-group-text">
                                  <i class="fa fa-calendar"></i>
                              </div>
                          </div>
                          <input type="text" name="fecha_fin" class="form-control form-control-sm" id="fecha_fin" required>
                          <script>  $("#fecha_fin").activeCalendary('#fecha_fin'); </script>
                      </div>
                  </div>

                  <div class="form-group col-sm-4 col-md-4 col-lg-3 text-right">
                      <div class="btn-group" style="margin-top:30px">
                        <button  class="btn btn-success btn-md" type="button" onclick="consultar_balance()"><i class="fa fa-search mr-1"></i> Buscar</button>&nbsp;
                        <button  class="btn btn-warning btn-md" type="button" onclick="generar_pdfbalance()"><i class="fa fa-search mr-1"></i> PDF</button>
                      </div>
                  </div>        
              </div>


            </form>
  
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
                <th class="border-0">Folio Crédito</th>
                <th class="border-0">No. Cuenta</th>
                <th class="border-0">Descripción</th>
                <th class="border-0">Fecha</th>
                <th class="border-0">Debe</th>  
                <th class="border-0">Haber</th>  
                <th class="border-0"></th>
                
                </tr>
              </thead>
              <tbody class="text-grey" id="bodytable">
              </tbody>
      
            </table>
          </div> <!--/ table-responsive-md -->
          
            
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
      <!-- "Horizontal Menu" page script to enable its demo functionality -->
      <script type="text/javascript" src="../ace-admin/application/views/default/pages/partials/horizontal-menu/@page-script.js"></script>

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

<!--Funciones para cargar datos-->
<script type="text/javascript" src="../js/funciones_balance.js"></script>
<script type="text/javascript">
  $(document).ready(function(){

  });

  function consultar_balance(){
    var finicio = $("#fecha_inicio").val();
    var ffin = $("#fecha_fin").val();
    if(finicio=="" || ffin=="")
      alertify.error("¡Debes ingresar la fecha de inicio y la fecha de fin a consultar!");
    else
      datatable_balance(finicio, ffin);
  }

  function generar_pdfbalance(){
    var finicio = $("#fecha_inicio").val();
    var ffin = $("#fecha_fin").val();
    if(finicio=="" || ffin=="")
        alertify.error("¡Debes ingresar la fecha de inicio y la fecha de fin a consultar!");
    else{
      path = '../pdf/index_balance.php';
      redirectWindow = window.open(path+'?finicio='+finicio+'&ffin='+ffin, '_blank');
    }
  }
</script>

</body>
</html>
