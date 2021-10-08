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
            <img src="../styles/corte_cajas.jpg" style="border-radius: 150px;" width="200">
                </figure>
        
                <hr>
                
                <p class="text-100 text-secondary text-center">
                <!-- -->
                </p>
            </div> <!--div class="col-lg-4-->

           
            <div class="col-lg-8 col-12 pl-lg-0 pr-lg-2">
                <!-- titulo -->
                <h4 class="font-light text-orange-d2">
                    <span class="b-underline-4"><a  href="buro_credito.php" style="text-decoration: none;" class="font-light text-orange-d2">Corte de cajas</a></span>
                </h4>

                <div class="card">
                                            <!--PASO 1 - DATOS FISCALES -->
                    <div class="card border-0">
                    <div class="card-header border-0 bg-transparent" id="">
                    <h6 class="font-light ">
                        <span ><a  href="buro_credito.php" style="text-decoration: none;" class="font-light text-secondary-d2">Informaci&oacute;n </a></span>
                    </h6>


                    </div>
                    <div id="formDatosGenerales" class="collapse show" aria-labelledby="datosGenerales" data-parent="#paso1Acordeon">
                        <div class="card-body text-grey-d3">
                        <div class="form-group " style="margin:0px; padding:0px;">
                                <div class="bgc-white px-1 bo1rder-1 brc-secondary-l2 radius-1">
                                    <table class="table table table-striped-info table-borderless">
                                    <tr>
                                        <td><i class="fa fa-user text-success-l1"></i></td>
                                        <td class="text-95 text-default-d3">No. Corte:</td>
                                        <td class="text-secondary-d2" id="corte"></td>
                                    </tr>
                                    <tr>
                                        <td><i class="fa fa-envelope text-blue-m3"></i></td>
                                        <td class="text-95 text-default-d3">Dinero en caja:</td>
                                        <td class="text-secondary-d2 text-wrap" id="efectivoCaja"></td>
                                    </tr>
                                    <tr>
                                        <input type="number" id="efectivoFloat" hidden>
                                        <input type="number" id="fondoFloat" hidden>
                                    </tr>
                                    <tr>
                                        <td><i class="fa fa-user text-success-l1"></i></td>
                                        <td class="text-95 text-default-d3">Fondo: </td>
                                        <td class="text-secondary-d2" id="fondo"></td>
                                    </tr>
                           

                                    </table>
                                </div>
                        </div>
                        <button type="button" class="btn btn-secondary" id="btnCerrar" onclick="ModuloCorte.confirmCerrar()" >Cerrar Corte</button>
                        </div>
                        
                    </div>  

                  
                    </div> <!-- /PASO 1 - DATOS GENERALES  -->
                </div>
            </div>


            <hr>
            <h4 class="font-light text-primary-d2">
                    <span class="b-underline-4"><a  href="buro_credito.php" style="text-decoration: none;" class="font-light text-secondary-d2">  <b>Tabla de Corte de Cajas</b>  </a></span>
            </h4>
            <hr>

            
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
                <table id="table_corte" class="table table-bordered table-bordered-x text-dark-m2 text-95 brc-secondary-l1" >
                <thead class="text-dark-m3 bgc-grey-l4 text-uppercase text-85" >
                    <tr class="small">
                    <th class="border-0"><input type="checkbox" autocomplete="off" /></th>
                    <th class="border-0">Id pago</th>
                    <th class="border-0">Monto</th>
                    <th class="border-0">fecha y hora</th>
                    
                    </tr>
                </thead>
                <tbody class="text-grey" id="bodytable">
                </tbody>
                </table>
            </div> <!--/ table-responsive-md -->
            <div class="form-group col-12" id="" >
            <?php  require("../views/corte_caja/view_cerrar_corte.php"); 
                   require("../views/corte_caja/view_confirmacion.php");  
             ?>
            
        </div>
        
      

            
        </div>
        <?php ?>

</div><!-- /.page-content -->
<?php end_containers(); ?>


<!-- include common vendor scripts used in demo pages -->
<script type="text/javascript" src="../ace-admin/node_modules/jquery/dist/jquery.js"></script>
      <script type="text/javascript" src="../ace-admin/node_modules/popper.js/dist/umd/popper.js"></script>
      <script type="text/javascript" src="../ace-admin/node_modules/bootstrap/dist/js/bootstrap.js"></script>

      <!-- include Ace script -->
      <script type="text/javascript" src="../ace-admin/dist/js/ace.js"></script>

      <script type="text/javascript" src="../ace-admin/assets/js/demo.js"></script>
      <!-- this is only for Ace's demo and you don't need it -->

      <!-- "DataTables" page script to enable its demo functionality -->
      <script type="text/javascript" src="../ace-admin/application/views/default/pages/partials/table-datatables/@page-script.js"></script>


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

      <script type="text/javascript" src="../ace-admin/node_modules/bootbox/bootbox.all.js"></script>
      <script type="text/javascript" src="../ace-admin/node_modules/sweetalert2/dist/sweetalert2.all.js"></script>
      <script type="text/javascript" src="../ace-admin/node_modules/interactjs/dist/interact.js"></script>

      <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
      <link rel="stylesheet" type="text/css" href="../styles/styles.css">
      <script type="text/javascript" src="../js/jquery.validate.min.js"></script>
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
        
        ModuloCorte.init_corte();
        
 
     });

</script>

</body>
</html>
