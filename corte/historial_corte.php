<?php
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");

    require_once "../php/security.php";
    require_once "../php/header_corte_cajas.php";
    require_once "../php/db.php";
    
    create_header();
    create_menu();
    begin_containers();
    @session_start();
    
    ?>


<!-- MAIN CONTAINER --> 
<div class="page-content container container-plus px-md-4 px-xl-5">
        <div class="row mt-35">

            <div class="col-lg-4 col-12 pr-lg-0 mt-3 mt-lg-0">
                <figure class="mx-auto text-center">
                    <img src="../styles/corte_cajas.jpg" style="border-radius: 150px;" width="300">
                </figure>
                <h1 class="text-grey-d2 pb-0 mb-3 mb-md-0 text-center">Historial de cortes de Caja</h1>
                <hr>
                <h5 class="text-grey-d2 pb-0 mb-3 mb-md-0 text-center">Control del ingreso de dinero en efectivo.</h5>
            </div> <!--div class="col-lg-4-->

           

            <!--columna con tabla-->
            <div class="col-lg-8 col-12 pl-lg-0 pr-lg-2">

            <!-- titulo -->
            <h3 class="font-light text-orange-d2">
                <!-- <span class="b-underline-4"><a href="gastos_cobranza.php" class="font-light text-orange-d2" style="text-decoration: none;">Buró de Crédito</a> </span>&nbsp;&nbsp;&nbsp;  -->
                <span class="b-underline-4"><a  href="buro_credito.php" style="text-decoration: none;" class="font-light text-orange-d2">Historial &oacute; Registro de Cortes de Caja</a></span>
            </h3>
            <hr>
  
         
            <div class="container container-plus pos-rel">

            <div class="row justify-content-sm-center justify-content-md-center justify-content-lg-center mt-5">
                <div class="col-sm-12 col-lg-12">                                        
                    <div class="row">
                        <div class="mx-auto col-12">
                            <div class="card">
                        
                                <div class="card-body">


                                <div class="table-responsive-md" style="min-width:100%">
                                <table id="table_historial" class="table table-bordered table-bordered-x text-dark-m2 text-95 brc-secondary-l1" >
                                <thead class="text-dark-m3 bgc-grey-l4 text-uppercase text-85" >
                                    <tr class="small">
                                        <th class="border-0"><input type="checkbox" autocomplete="off" /></th>
                                        <th class="border-0">No. de Corte </th>
                                        <th class="border-0">Monto</th>
                                        <th class="border-0">Fondo</th>
                                        <th class="border-0">Fecha de Apertura</th>
                                        <th class="border-0">fecha de Cierre</th>
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

                </div>
            </div>

            </div>
    
     
      
        </div>


        
        <div class="form-group col-12" id="" >
            <?php  require("../views/corte_caja/view_abrir_caja.php"); ?>
            <?php require("../views/corte_caja/view_historial.php") ?>
        </div>

</div><!-- /.page-content -->
<?php end_containers(); ?>


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


      <script type="text/javascript" src="../js/jquery.validate.min.js"></script>
      <link rel="stylesheet" type="text/css" href="../styles/styles.css">
      <script src="../js/func_corte.js"></script>



    </div><!-- /.body-container -->



<?php
      create_footer();
?>
</div>
<script>
     $(document).ready(function(){
        jQuery.validator.setDefaults({
        debug: true,
        success: "valid"
        });       


        ModuloCorte.initHistorial();
        
 
     });

</script>

</body>
</html>
