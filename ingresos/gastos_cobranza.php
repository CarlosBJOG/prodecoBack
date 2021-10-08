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
<!-- MAIN CONTAINER --> 
<div class="page-content container container-plus px-md-4 px-xl-5">
        <div class="row mt-35">

            <div class="col-lg-4 col-12 pr-lg-0 mt-3 mt-lg-0">
            <figure class="mx-auto text-center">
            <img src="../styles/cobranza.jpg" style=" border-radius:150px; " width="300">
                </figure>
                <h1 class="text-grey-d2 pb-0 mb-3 mb-md-0 text-center">Gastos Cobranza</h1>
                <hr>
                <h5 class="text-grey-d2 pb-0 mb-3 mb-md-0 text-center"></h5>
                <p class="text-100 text-secondary text-center">
                <!-- -->
                </p>
            </div> <!--div class="col-lg-4-->

           

            <!--columna con tabla-->
            <div class="col-lg-8 col-12 pl-lg-0 pr-lg-2">

            <!-- titulo -->
            <div class="container">
            <div class="row">

                <div class="col-sm mt-3" <?php if($_SESSION["tipo_usuario"]!='1' && $_SESSION["tipo_usuario"]!='4'  && $_SESSION["tipo_usuario"]!='6') echo "hidden"; ?>>
                    <h5 class="font-light text-orange-d2  " style="font-size: 4vh; margin: 1px;" >
                        <span class="b-underline-4 mt-2 col"><a  href="gastos_caja.php" style="text-decoration: none;" class="font-light text-orange-d2 ">Gastos Cobranza (cajero)</a></span>&nbsp;&nbsp;&nbsp;
                    </h5>
                </div>
                <div class="col-sm mt-3">
                    <h5 class="font-light text-orange-d2  " style="font-size: 4vh; margin: 1px;">
                        <span class="col"><a <?php if($_SESSION["tipo_usuario"]!='1' && $_SESSION["tipo_usuario"]!='2'  && $_SESSION["tipo_usuario"]!='6') echo "hidden"; ?> href="gastos_cobranza.php" style="text-decoration: none;" class="font-light text-orange-d2">Gastos Cobranza (Promotor)</a></span>&nbsp;&nbsp;&nbsp; 
                    </h5>
                </div>
                </div>
               
            </div>
            <hr>
            <div class="container">
                <div class="row">
                    <div class="col-sm">
                        <a href="#"  style="text-decoration: none;" id="tabCreditos"><h5 class="text-secondary-d2 pb-0 mb-3 mb-md-0 text-center mt-3" >Tabla de Cr&eacute;ditos</h5></a>
                    </div>
                    <div class="col-sm">
                        <a href="#"  style="text-decoration: none;" id="reimpresion"><h5 class="text-secondary-d2 pb-0 mb-3 mb-md-0 text-center mt-3">Reimprimir Comprobantes</h5></a>
                    </div>
                </div>
            </div>
       
        
            <div class="row justify-content-sm-center justify-content-md-center justify-content-lg-center mt-1" id="divTablaCobranza">
                <div class="col-sm-12 col-lg-12">                                        
                    <div class="row">
                        <div class="mx-auto col-12">

                            <div class="table-responsive-md" style="min-width:100%;">
                                <table id="tablaCobranza" class="table table-bordered table-bordered-x text-dark-m2 text-95 brc-secondary-l1" >
                                    <thead class="text-dark-m3 bgc-grey-l4 text-uppercase text-85">
                                        <tr class="medium text-center">
                                            <th class="border-0 ">FOLIO</th>
                                            <th class="border-0">NOMBRE</th>
                                            <th class="border-0">PRODUCTO</th>
                                            <th class="border-0" >GASTO DE COBRANZA</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-grey text-center" id="bodytable">
                                
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-sm-center justify-content-md-center justify-content-lg-center mt-1" id="divTablaTicket" >
                <div class="col-sm-12 col-lg-12">                                        
                    <div class="row">
                        <div class="mx-auto col-12">

                            <div class="table-responsive-md" style="min-width:100%;">
                                <table id="tablaComprobantes" class="table table-bordered table-bordered-x text-dark-m2 text-95 brc-secondary-l1" >
                                    <thead class="text-dark-m3 bgc-grey-l4 text-uppercase text-85">
                                        <tr class="medium text-center">
                                            <th class="border-0 ">ID-CREDITO</th>
                                            <th class="border-0">FECHA DE REGISTRO</th>
                                            <th class="border-0">MONTO</th>
                                            <th class="border-0" >FOLIO</th>
                                            <th class="border-0" >BANCO</th>
                                            <th class="border-0" >DESCRIPCION</th>
                                            <th class="border-0" >IMPRIMIR</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-grey text-center" id="bodytable">
                                
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            

                <br>


            </div> <!-- / row con tabla col-lg-8--> 
        </div>
        <br>

 
    <?php
        require("../views/ingresos/view_cobranza.php");
    ?>

  
        

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
      <script type="text/javascript" src="../js/default.js"></script>
      <script type="text/javascript" src="../js/jquery.validate.min.js"></script>
      <script src="../js/validate_rules.js"></script>


<?php
  create_footer();
?>
</div>

<!--Funciones para cargar datos-->
<script type="text/javascript" src="../js/func_cobranza.js"></script>
<script>   
     $(document).ready(function(){
        jQuery.validator.setDefaults({
        debug: true,
        success: "valid"
        });
        
        moduloCobranza.initPromotor();
     });

     
</script>

</body>
</html>
