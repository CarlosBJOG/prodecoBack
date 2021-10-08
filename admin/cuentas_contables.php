<?php


    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    require_once "../php/security.php";    
    require_once "../php/header_admin.php";
 


    create_header();
    create_menu();
    begin_containers();
?>

<div class="container container-plus pos-rel">

        <div class="row justify-content-sm-center justify-content-md-center justify-content-lg-center mt-5">
            <div class="col-sm-12 col-lg-12">                                        
                <div class="row">
                    <div class="mx-auto col-12">
                        <div class="card">
                        <div class="container">
                            <div class="row justify-content-start">
                                <div class="col-6">
                                    <h2 class="text-success p-4">Lista de Cuentas Contables</h4>
                                </div>
                                <div class="col-6 ">
                                    <button class="btn btn-warning btn-h-success btn-text-slide btn-bold-down btn-wide text-120 float-right" style="margin-top: 5%;" onclick="agregar_cuenta()">
                                        <span class="btn-text-1">
                                            Agregar Cuenta
                                        </span>
                                            <span class="btn-text-2">
                                                Presiona
                                        </span>
                                    </button>
                                </div>
                            
                            </div>
                            </div>

      
                            <div class="card-body">
             


                            <div class="table-responsive-md" style="min-width:100%">
                            <table id="datatable" class="table table-bordered table-bordered-x text-dark-m2 text-95 brc-secondary-l1" >
                            <thead class="text-dark-m3 bgc-grey-l4 text-uppercase text-85" >
                                <tr class="medium">
                                    <th class="border-0"><input type="checkbox" autocomplete="off" /></th>
                                    <th class="border-0">No de cuenta </th>
                                    <th class="border-0">Cuenta Acumulable</th>
                                    <th class="border-0">Nombre</th>
                                    <th class="border-0">Rubro</th>
                                    <th class="border-0">Tipo</th>   
                                    <th class="border-0">Naturaleza</th>
                                    <th class="border-0">Nivel</th>
                
                                    <th class="border-0" ></th>
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

<?php 
            require("../views/cta_contables/view_cta_contables.php");

?>



                        

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
        <script src="../js/func_ctaContables.js"></script>



<?php
create_footer();
?>
<script>
     $(document).ready(function(){
        jQuery.validator.setDefaults({
        debug: true,
        success: "valid"
        });

        cargar_tabla();


     });







</script>

</body>
</html>
