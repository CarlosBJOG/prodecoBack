<?php
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    require_once "../php/security.php";
    require_once "../php/header_cvencidos.php";
    //require_once "../php/functions.php";
    require_once "../php/db.php";
    
    create_header();
    create_menu();
    begin_containers();
    
    
    ?>


<!-- MAIN CONTAINER --> 
<div class="page-content container container-plus px-md-4 px-xl-5">

        <div class="row mt-35">

            <div class="col-lg-3 col-12 pr-lg-0 mt-3 mt-lg-0">

            <figure class="mx-auto text-center">
              <img src="../styles/castigo.jpg" width="300">
            </figure>
            <h1 class="text-grey-d2 pb-0 mb-3 mb-md-0 text-center">
             Castigo de cr&eacute;dito
            </h1>
            <hr>
           
            </div> <!--div class="col-lg-4-->


            <!--columna con tabla-->
            <div class="col-lg-9 col-12 pl-lg-0 pr-lg-2">
        
            <div class="page-header pb-2 flex-column flex-sm-row align-items-start align-items-sm-center">
              <h4 class="font-light text-orange-d2">
                <span class="b-underline-4">Castigo de crédito</span>
                &nbsp;&nbsp;&nbsp;
                
              </h4>

              <div class="page-tools mt-3 mt-sm-0 mb-sm-n1"></div>
            </div>

            <div class="mt-4 mx-md-2 border-t-1 brc-secondary-l1">
              <div id="table-header" class="d-none justify-content-between px-2 py-25 border-b-1 brc-secondary-l1">
                <div>
                  Resultados <span class="text-600 text-primary-d1">"Clientes"</span>
                  <small class="text-grey-m2">(Con columnas reordenables)</small>
                </div>
              </div> 

              <div class="table-responsive-md">
                <table id="datatable1" class="table table-border-y text-dark-m2 text-95 border-y-1 brc-secondary-l1">
                  <thead class="text-secondary-m2 text-uppercase text-85">
                    <tr>
                      <th class="border-0">Folio</th>
                      <th class="border-0" >Producto</th>
                      <th class="border-0">Fecha</th>  
                      <th class="border-0">Promotor</th>  
                      <th class="border-0">Cliente</th> 
                      <th class="border-0">Monto</th>   
                      <th class="border-0">Estatus</th>
                      <th class="border-0">Estatus<br>Pagos</th>
                      <th class="border-0">Atraso</th> 
                      <th class="border-0">Acciones</th> 
                    </tr>
                  </thead>
                  <tbody class="small">
                       
                  </tbody>
                </table>
              </div> <!--/ table-responsive-md -->

            </div> <!-- / row con tabla col-lg-8--> 


        <!--MODAL PARA REESTRUCTURACIÓN, CONDONACIÓN Y RENOVACIÓN -->
        <?php require('../views/seguimiento/view_cambios_amortizacion.php'); ?>

        
        </div>

    </div>



</div><!-- /.page-content -->
<?php end_containers(); ?>


        <!-- include common vendor scripts used in demo pages -->
        <script type="text/javascript" src="../ace-admin/node_modules/jquery/dist/jquery.js"></script>
        <script type="text/javascript" src="../ace-admin/node_modules/popper.js/dist/umd/popper.js"></script>
        <script type="text/javascript" src="../ace-admin/node_modules/bootstrap/dist/js/bootstrap.js"></script>

        <!-- include vendor scripts used in "Horizontal Menu" page. see "application/views/default/pages/partials/horizontal-menu/@vendor-scripts.hbs" -->
        <script type="text/javascript" src="../ace-admin/node_modules/chart.js/dist/Chart.js"></script>

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

         <script type="text/javascript" src="../js/funciones_seguimiento.js"></script>
 
    </div><!-- /.body-container -->
  </body>


<script type="text/javascript">
$(document).ready(function(){
    datatable_creditos_castigo();
});

</script>

<?php
    //require_once "../php/security.php";
    //require_once "../php/header_forms.php";
    create_footer();
    ?>
</div>
</body>
</html>
