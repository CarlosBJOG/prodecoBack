<?php
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");

    require_once "../php/security.php";
    require_once "../php/header_seguimiento.php";
    create_header_seguimiento();
    create_menu_seguimiento();
    
    @session_start();
    
    ?>




<div class="row justify-content-around mt-4">

<div class="col-lg-2 col-12 pr-lg-0 mt-3 mt-lg-0">
    <figure class="mx-auto text-center">
      <img src="../styles/facturacion.jpg" class="img-responsive " style="border-radius: 150px;" width="200">
    </figure>
    <h1 class="text-grey-d2 pb-0 mb-3 mb-md-0 text-center">Reportes</h1>
    <hr>
    <h5 class="text-grey-d2 pb-0 mb-3 mb-md-0 text-center">Reportes de cartera general.</h5>
    <p class="text-100 text-secondary text-center">
     <!-- -->
    </p>

</div> <!-- Col-3 cartera-->


<div class="col-lg-9 col-12 pr-lg-0 mt-3 mt-lg-0">


    <div class="row my-2">
        
        <!-- inicio card-->
        <div class="col-11 col-sm-6 col-lg-5 ml-3 mt-3">
            <div class="pos-rel py-4 radius-2 c-pointer" style="background-color: <?php echo $_SESSION["color"]; ?>;">
            <a id="reporteGeneral" class="text-white" style="text-decoration:none">
            <span class="opacity-4 position-rc mr-2 d-none">
                <i class="mr-3 mt-n2 fas fa-file-download text-dark-tp5 opacity-4 w-5 h-5 text-center pt-1 radius-round fa-5x"></i>
                </span>
            <div class="d-flex align-items-center">
                <div class="pos-rel p-3 bgc-white-tp8 radius-round ml-3 mr-3 shadow-md">
                <i class="pos-abs mt-n2px ml-n3px fas fa-file-download text-dark-tp5 opacity-4 w-5 h-5 text-center pt-1 radius-round text-170"></i>
                <i class="pos-rel fas fa-file-download text-white w-5 h-5 text-center pt-1 radius-round text-170"></i>
                </div>

                <div class="text-white pl-4 text-uppercase text-130 text-600 letter-spacing">
                    Reportes Cartera General
                </div> 
            </div>
            </a>
            </div>
        </div>
        <!--fin-->

        <!-- inicio card-->
        <div class="col-11 col-sm-6 col-lg-5 ml-3 mt-3">
            <div class="pos-rel py-4 radius-2 c-pointer" style="background-color: <?php echo $_SESSION["color"]; ?>;">
                <a id="reportesAutorizados" class="text-white" style="text-decoration:none">
                <span class="opacity-4 position-rc mr-2 d-none">
                    <i class="mr-3 mt-n2 fas fa-file-download text-dark-tp5 opacity-4 w-5 h-5 text-center pt-1 radius-round fa-5x"></i>
                </span>
                <div class="d-flex align-items-center">
                    <div class="pos-rel p-3 bgc-white-tp8 radius-round ml-3 mr-3 shadow-md">
                    <i class="pos-abs mt-n2px ml-n3px fas fa-file-download text-dark-tp5 opacity-4 w-5 h-5 text-center pt-1 radius-round text-170"></i>
                    <i class="pos-rel fas fa-file-download text-white w-5 h-5 text-center pt-1 radius-round text-170"></i>
                </div>

                <div class="text-white pl-4 text-uppercase text-130 text-600 letter-spacing">
                    Reportes Cr&eacute;ditos Autorizados
                </div> 
                </div>
                </a>
            </div>
        </div>
        <!--fin-->

    </div>

    
    <div class="row my-2">
        
        <!-- inicio card-->
        <div class="col-11 col-sm-6 col-lg-5 ml-3 mt-3">
            <div class="pos-rel py-4 radius-2 c-pointer" style="background-color: <?php echo $_SESSION["color"]; ?>;">
            <a id="reportesAtrasados" class="text-white" style="text-decoration:none">
            <span class="opacity-4 position-rc mr-2 d-none">
                <i class="mr-3 mt-n2 fas fa-file-download text-dark-tp5 opacity-4 w-5 h-5 text-center pt-1 radius-round fa-5x"></i>
                </span>
            <div class="d-flex align-items-center">
                <div class="pos-rel p-3 bgc-white-tp8 radius-round ml-3 mr-3 shadow-md">
                <i class="pos-abs mt-n2px ml-n3px fas fa-file-download text-dark-tp5 opacity-4 w-5 h-5 text-center pt-1 radius-round text-170"></i>
                <i class="pos-rel fas fa-file-download text-white w-5 h-5 text-center pt-1 radius-round text-170"></i>
                </div>

                <div class="text-white pl-4 text-uppercase text-130 text-600 letter-spacing">
                    Reportes Cr&eacute;ditos Atrasados
                </div> 
            </div>
            </a>
            </div>
        </div>
        <!--fin-->

        <!-- inicio card-->
        <div class="col-11 col-sm-6 col-lg-5 ml-3 mt-3">
            <div class="pos-rel py-4 radius-2 c-pointer" style="background-color: <?php echo $_SESSION["color"]; ?>;">
                <a id="reportesPagos" class="text-white" style="text-decoration:none">
                <span class="opacity-4 position-rc mr-2 d-none">
                    <i class="mr-3 mt-n2 fas fa-file-download text-dark-tp5 opacity-4 w-5 h-5 text-center pt-1 radius-round fa-5x"></i>
                </span>
                <div class="d-flex align-items-center">
                    <div class="pos-rel p-3 bgc-white-tp8 radius-round ml-3 mr-3 shadow-md">
                    <i class="pos-abs mt-n2px ml-n3px fas fa-file-download text-dark-tp5 opacity-4 w-5 h-5 text-center pt-1 radius-round text-170"></i>
                    <i class="pos-rel fas fa-file-download text-white w-5 h-5 text-center pt-1 radius-round text-170"></i>
                </div>

                <div class="text-white pl-4 text-uppercase text-130 text-600 letter-spacing">
                    Reportes Pagos Registrados
                </div> 
                </div>
                </a>
            </div>
        </div>
        <!--fin-->

    </div>
                 
</div> <!-- /PRINCIPAL-->

<?php
    require("../views/reportes/view_reportes.php");
?>

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


      <script type="text/javascript" src="../ace-admin/node_modules/bootbox/bootbox.all.js"></script>
      <script type="text/javascript" src="../ace-admin/node_modules/sweetalert2/dist/sweetalert2.all.js"></script>
      <script type="text/javascript" src="../ace-admin/node_modules/interactjs/dist/interact.js"></script>

      <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
      <script type="text/javascript" src="../js/default.js"></script>
      <script type="text/javascript" src="../js/jquery.validate.min.js"></script>
      <script src="../js/func_reportes.js"></script>


    </div><!-- /.body-container -->



<?php
   create_footer_forms();
?>
</div>
<script>
     $(document).ready(function(){
          //datatable_gastos();
          jQuery.validator.setDefaults({
          debug: true,
          success: "valid"
        });

        moduloReportes.initReportes();
     });

</script>

</body>
</html>
