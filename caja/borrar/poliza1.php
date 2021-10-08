<?php
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    require_once "../php/security.php";
    require_once "../php/header_caja.php";
    require_once "../php/functions.php";
    require_once "../php/db.php";
    
    create_header();
    create_menu();
    begin_containers();
    
    
    ?>


<!-- MAIN CONTAINER --> 
<div class="page-content container container-plus px-md-4 px-xl-5">
    <div class="row justify-content-around">
     <!--   <div class="col-12">-->
        <div class="col-sm-12 col-lg-3 my-1 my-lg-0 px-sm-1 px-lg-0">
            <figure class="mx-auto text-center">
              <img src="../styles/ilustracion-cartera.png" width="200">
            </figure>
            <h1 class="text-grey-d2 pb-0 mb-3 mb-md-0 text-center">
             Caja
            </h1>
            <hr>
            
        </div>
    </div> <!-- row 1-->
 
     <!-- Poliza num 1 -->
    <h2 class="text-grey-d2 pb-0 mb-3 mb-md-0 text-left">
        Poliza de Solicitud de Dinero
    </h2>
    <hr>
    <form action="" method="POST">
        <div class="card-body text-grey-d3">
            <div class="form-group row" style="margin:10px; padding-left:80px;">

                <div class="col-sm-12 col-md-4 col-lg-4" style="margin-bottom: 12px; margin-top: 0px;">
                    <label class="col-form-label form-control-label text-success-d1 text-100" style="margin-top: 0px;">No. de Solicitud</label>
                    <input class="form-control form-control-sm" type="text" value="" id="numero_solicitud" placeholder="Ej. 202010" name="numero_solicitud">
                </div>

                <div class="col-sm-12 col-md-4 col-lg-3" style="margin-bottom: 12px; margin-top: 0px;">
                    <label class="col-form-label form-control-label mt-0 text-success-d1 text-100" for="nacimiento">Fecha</label>
                    <div class="input-group date" id="id-timepicker">
                        <div class="input-group-addon input-group-append">
                            <div class="input-group-text">
                                <i class="fa fa-calendar"></i>
                            </div>
                        </div>
                        <input type="date" name="nacimiento" class="form-control form-control-sm" id="fecha" autocomplete="off">
                    </div>
                </div>

                <div class="col-sm-12 col-md-4 col-lg-4">
                    <label class="col-form-label form-control-label text-success-d1 text-100">Mes</label>
                    <input class="form-control form-control-sm" type="text" value="" placeholder="Ej. 1" id="mes" name="mes">
                </div>

            </div>

            <div class="form-group row" style="margin:10px; padding-left:80px;">

                <div class="col-sm-12 col-md-3 col-lg-4">
                    <label class="col-form-label text-success-d1 text-100">Origen</label>
                    
                    <select name="origen" id="origen" class="form-control form-control-sm">
                
                    </select> 
                </div>

                <div class="col-sm-12 col-md-3 col-lg-3 ">
                    <label class="col-form-label form-control-label text-success-d1 text-100 ">Monto Solicitado</label>
                    <input class="form-control form-control-sm" type="number" value=""  id="monto" placeholder="$1 000.00" name="monto">
                </div>



            </div>

            <hr />
           
            <div class="mt-4 mt-lg-2 col-lg-11 col-lg-4 " style="margin:10px; padding-left:80px;">
                <h4 class="text-grey-d2 pb-0 mb-3 mb-md-0 text-left">
                    Descripcion General
                </h4>
                    <hr class="d-lg-none" />
                    <div>
                    <table class="table table-striped-success table-borderless text-dark-m1"  id="responsive-table">
                        <thead>
                        <tr class="bgc-success-m1 text-white">
                            <th>Nombre del cliente</th>
                            <th>Cantidad</th>
                            <th>Agregar cuenta de banco</th>
                            <th>comentarios</th>
                        </tr>
                        </thead>
                        <tbody class="bgc-success-m1">
                        <tr>
                            <td>David Romero Vargas</td>
                            <td>$ 20 000</td>
                            <td><select name="sexo" id="sexo" class="form-control form-control-sm col-lg-8"></td>
                            <td><input class="form-control form-control-sm" type="text" value="" id="mes" name="mes"></td>
                        </tr>
                    
                        </tbody>
                        <tfoot class="bgc-success-m1">

                        <tr>
                        <th></th>
                        <th>Total</th>
                        
                        <th>$</th>
                        <th></th>
                        </tr>

                        </tfoot>
                    </table>

                    </div>
                </div>

                <div class="col-12">
                    <hr class="border-double" />
                    <div class="form-group col-md-3 offset-md-8 mt-2">
                        <button type="submit" id="guardar" class="btn btn-warning btn-block btn-md btn-bold mt-2 mb-3 radius-2">
                             Guardar Cambios
                        </button>
                    </div>
                </div>

        </div>
    </form>
 
    



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

        <script type="text/javascript" src="../ace-admin/node_modules/select2/dist/js/select2.js"></script>
        <script type="text/javascript" src="../ace-admin/node_modules/chosen-js/chosen.jquery.js"></script>
        <!-- include Ace script -->
        <script type="text/javascript" src="../ace-admin/dist/js/ace.js"></script>


        <script type="text/javascript" src="../ace-admin/assets/js/demo.js"></script>
        <!-- this is only for Ace's demo and you don't need it -->

        <!-- "DataTables" page script to enable its demo functionality -->
        <script type="text/javascript" src="../ace-admin/application/views/default/pages/partials/table-datatables/@page-script.js"></script>
        <!-- "Horizontal Menu" page script to enable its demo functionality -->
        <script type="text/javascript" src="../ace-admin/application/views/default/pages/partials/horizontal-menu/@page-script.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

  <?php
    create_footer();
    ?>
</div><!-- /.body-container -->

</body>
</html>
