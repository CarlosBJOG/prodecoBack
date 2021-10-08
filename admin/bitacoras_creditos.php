<?php
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    require_once "../php/security.php";
    require_once "../php/header_admin.php";
    require_once "../php/functions.php";
    
    create_header();
    create_menu();
    begin_containers();
    @session_start();
    
  ?>

    <div class="row justify-content-around mt-4">

        <div class="col-2 col-sm-2 col-lg-2 my-1 my-lg-0 px-sm-1 px-lg-0">
            <figure class="mx-auto text-center">
              <img src="../styles/ilustracion-admin.png" width="300">
            </figure>
            <h1 class="text-grey-d2 pb-0 mb-3 mb-md-0 text-center">Bit&aacute;coras Cr&eacute;ditos</h1>
            <hr>
            <p class="text-100 text-secondary text-center">
             <!-- -->
            </p>

      </div> <!-- Col-3 cartera-->


      <div class="col-12 col-lg-9">
        <div>


          <div class="row">
            <div class="col-sm-8 col-md-8 col-lg-8">
              <h5 class="font-light text-orange-d2">
                <span class="b-underline-4">Bitácoras Créditos</span>&nbsp;&nbsp;&nbsp;&nbsp; 
                <!--<span><a href="cartera_transito_cajero.php" class="text-orange-d2">Cartera en tránsito (Cajero)</a></span>-->
              </h5>
            </div>
            <div class="col-sm-4 col-md-4 col-lg-4 text-right">
                <div class="input-group">
                  <input type="text" id="folio_credito" class="form-control form-control-md" id="form-field-mask-1" inputmode="text" placeholder="Folio crédito">
                  <div class="input-group-append">
                    <button class="btn btn-success" type="button" onclick="buscar_bitacora_credito()"><i class="fa fa-search mr-1"></i> Buscar</button>
                  </div>
                </div>
            </div>
          </div>


          
          
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
                  <th class="border-0" width="10%"><input type="checkbox" autocomplete="off" /></th>
                  <th class="border-0" width="10%">Folio</th>
                  <th class="border-0">Fecha</th>
                  <th class="border-0">Descripción</th>
                  <th class="border-0">Usuario</th>
                  <th class="border-0"></th>
                </tr>
              </thead>
              <tbody class="text-grey" id="bodytable">
              </tbody>
            </table>
          </div> <!--/ table-responsive-md -->

        </div> <!-- / row con tabla col-lg-8-->        
      </div> <!-- /PRINCIPAL-->

</div>

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


<?php
  create_footer();
?>
</div>

<!--Funciones para cargar datos-->
<script type="text/javascript" src="../js/funciones_admin.js"></script>
<script type="text/javascript">
	$(document).ready(function(){

	});

  function buscar_bitacora_credito(){
    var folio_credito = $("#folio_credito").val();
    if(folio_credito=="")
      alertify.error("¡Debes indicar el folio del crédito!");
    else
      datatable_bitacoras_creditos(folio_credito);
  }
</script>

</body>
</html>
