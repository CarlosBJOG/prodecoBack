<?php
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    require_once "../php/security.php";
    require_once "../php/header_caja.php";
    require_once "../php/functions.php";
    
    create_header();
    create_menu();
    begin_containers();
    
  ?>
    <div class="row justify-content-around mt-4">

        <div class="col-2 col-sm-2 col-lg-2 my-1 my-lg-0 px-sm-1 px-lg-0">
            <figure class="mx-auto text-center">
              <img src="../styles/ilustracion-cartera.png" width="270">
            </figure>
            <h1 class="text-grey-d2 pb-0 mb-3 mb-md-0 text-center">Caja</h1>
            <hr>
            <p class="text-100 text-secondary text-center">
             <!-- -->
            </p>

      </div> <!-- Col-3 cartera-->


     
      <div class="row col-12 col-lg-9">
       
        <div>
        <h5 class="font-light text-orange-d2"> 
            <span><a <?php if($_SESSION["tipo_usuario"]!='1') echo "hidden"; ?> href="cartera_transito_sup.php" class="text-orange-d2">Cartera en tránsito (Supervisor)</a></span>&nbsp;&nbsp;&nbsp;&nbsp;
            <span><a href="cartera_transito_cajero.php"  class="font-light text-orange-d2"> Cartera en tránsito (Cajero)</a></span>&nbsp;&nbsp;&nbsp; 
            <span  class="b-underline-4" ><a href="gastos_caja.php" style="text-decoration: none;" class="font-light text-orange-d2">Gastos Cobranza</a></span>&nbsp;&nbsp;&nbsp;&nbsp; 
            <span><a href="credito_pago.php" class="text-orange-d2">Crédito Pago</a></span>
          </h5>
   
           
       
          <div class="mt-4 mx-md-2 border-t-1 brc-secondary-l1">
            <div id="table-header" class="d-none justify-content-between px-2 py-25 border-b-1 brc-secondary-l1">
              <div>
                Resultados 
                <span class="text-600 text-primary-d1">"Clientes"</span>
                <small class="text-grey-m2">(Con columnas reordenables)</small>
              </div>
            </div>
          </div>

          <!-- <form action="" name="form" id="form" method='POST' autocomplete="off" >
               <div class="row">
                  <div class="form-group col-sm-12 col-md-4 col-lg-4">           
                      <label class="col-form-label form-control-label text-success-d1 text-100" style="margin-top: 0px;">No. Credito<span style="color:red;">*</span></label>
                      <input class="form-control form-control-sm" type="text" id="num_credito" name="num_credito" disabled='true' required >
                      
                  </div>

                  <div class="form-group col-sm-12 col-md-4 col-lg-4">
                      <label for="" class="col-form-label form-control-label text-success-d1 text-100" style="margin-top: 0px;">Tipo de credito<span style="color:red;">*</span></label>
                      <input class="form-control form-control-sm" type="text" id="tipo_credito" name="tipo_credito" disabled='true' required >
                  </div>
                  

                  <div class="form-group col-sm-12 col-md-4 col-lg-4">
                      <label for="" class="col-form-label form-control-label text-success-d1 text-100" style="margin-top: 0px;">Nombre<span style="color:red;">*</span></label>
                      <input type="text" class="form-control form-control-sm" id="nombre" name="nombre" disabled='true' required >
                  </div>

               </div> fin primerafila

                <br>

               <div class="row">

                  <div class="form-group col-sm-12 col-md-4 col-lg-4">
                      <label for="" class="col-form-label form-control-label text-success-d1 text-100" style="margin-top: 0px;">Fecha registro<span style="color:red;">*</span></label>
                      <input type="text" class="form-control form-control-sm" name="fecha_registro" id="fecha_registro" disabled='true' required>
                  </div>

                  <div class="form-group col-sm-12 col-md-4 col-lg-4">
                      <label for="" class="col-form-label form-control-label text-success-d1 text-100" style="margin-top: 0px;">Monto<span style="color:red;">*</span></label>
                      <input type="text" class="form-control form-control-sm" name="monto" id="monto" placeholder="$1000.00" required>
                  </div>

                 

               </div>fin segunda fila 
               <br>  
                  
                  <button id="btnAplicar" type="button" class="btn btn-success btn-sm float-right" >
                      <i class="fas fa-save "></i>&nbsp;Actualizar
                  </button>

                  <button id="btnAplicar" type="button" class="btn btn-danger btn-sm float-right" style="margin-right: 2px;" onclick="cancelarform()">
                      <i class="fa fa-arrow-circle-left"></i>&nbsp;Cancelar
                  </button>
                  
              </div>  
            </form> -->
 
          <div class="row">
            <div class="mt-4 mx-md-2 border-t-1 brc-secondary-l1">
              <div id="table-header" class="d-none justify-content-between px-2 py-25 border-b-1 brc-secondary-l1">
                <div>
                  Resultados 
                  <span class="text-600 text-primary-d1">"Clientes"</span>
                  <small class="text-grey-m2">(Con columnas reordenables)</small>
                </div>
              </div>
            </div>


            <div class="table-responsive-md"  style="min-width:100%; margin-bottom: 10px" id="table_action">
              <table id="datatable" class="table table-bordered table-bordered-x text-dark-m2 text-95 brc-secondary-l1" >
                <thead class="text-dark-m3 bgc-grey-l4 text-uppercase text-85" >
                  <tr class="small">
                    <th class="border-0"><input type="checkbox" autocomplete="off" /></th>
                    <th class="border-0">ID Credito</th>
                    <th class="border-0" style="width:20%">Tipo Credito</th>
                    <th class="border-0">Nombre</th>
                    <th class="border-0">Fecha registro</th>
                    <th class="border-0">Fecha valor</th>  
                    <th class="border-0">Monto</th>  
                    <th class="border-0">Estatus</th>
                    <th class="border-0">Editar/Aplicar</th>
                  </tr>
                </thead>
                <tbody class="text-grey" id="bodytable">
                </tbody>
              </table>
              <hr>
            </div> <!--/ table-responsive-md -->

            <div class="col-sm-12 col-md-12 col-lg-12" id="colocacionForm">
            </div>
          </div>
          


        </div> <!-- / row con tabla col-lg-8-->     
      </div> <!-- /PRINCIPAL-->
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


  <?php
  create_footer();
?>
</div>

<!--Funciones para cargar datos-->
<script type="text/javascript" src="../js/func_gastos_cobranza.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
        jQuery.validator.setDefaults({
        debug: true,
        success: "valid"
        });
        $('#form').hide();
        
        datatable_gastos();

  });

</script>

</body>
</html>
