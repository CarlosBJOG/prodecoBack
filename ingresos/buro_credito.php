<?php
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");

    require_once "../php/security.php";
    require_once "../php/header_ingresos.php";
    require_once "../php/functions.php";
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
            <img src="../styles/buro.jpg" style=" border-radius:150px; " width="300">
                </figure>
                <h1 class="text-grey-d2 pb-0 mb-3 mb-md-0 text-center">Bur&oacute; de Crédito</h1>
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
                <div class="col-sm mt-3" <?php if($_SESSION["tipo_usuario"]!='1' && $_SESSION["tipo_usuario"]!='6' && $_SESSION["tipo_usuario"]!='4') echo "hidden"; ?>>
                    <h5 class="font-light text-orange-d2  " style="font-size: 3vh; margin: 1px;">
                        <span class="col"><a  href="buro_credito_cajero.php" style="text-decoration: none;" class="font-light text-orange-d2">Bur&oacute; de Cr&eacute;dito(cajero)</a></span>&nbsp;&nbsp;&nbsp;   
                    </h5>
                </div>
                <div class="col-sm mt-3">
                    <h5 class="font-light text-orange-d2  " style="font-size: 3vh; margin: 1px;">
                        <span class="b-underline-4 mt-2 col"><a  href="buro_credito.php" style="text-decoration: none;" class="font-light text-orange-d2 ">Bur&oacute; de Cr&eacute;dito(promotor)</a></span>&nbsp;&nbsp;&nbsp;
                    </h5>
                </div>
   
                </div>
               
            </div>


            <div class="card">

                <form action="" name="formBuro" id="formBuro" method='POST' autocomplete="off" class=" mt-5 md-5 mr-5 ml-5">
                    <div class="row">

                        <div class="form-group col-sm-12 col-md-6 col-lg-4">
                        <label for="" class="col-form-label form-control-label text-success-d1 text-100">Costo por consulta</label>
                        <input type="number" name="costo"  class="form-control form-control-sm" id="costo" value="15.00" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)" required>
                        </div>

                    <div class="form-group  col-sm-12 col-md-6 col-lg-4">
                            <label for="" class="col-form-label form-control-label text-success-d1 text-100">Numero de consultas</label>
                            <input type="number" name="num_consultas" value="0" class="form-control form-control-sm" id="num_consultas" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)" required>  
                    </div>

                

                    <div class="form-group  col-sm-12 col-md-6 col-lg-4">
                        <label for="" class="col-form-label form-control-label text-success-d1 text-100">Monto</label>
                        <input type="number" name="monto" class="form-control form-control-sm" id="monto" disabled = 'true' required>
                    </div>


                
                </div><!--fin primerafila -->

                <br>

                <div class="row">

                        <div class="form-group  col-sm-12 col-md-6 col-lg-4">
                        <label for="" class="col-form-label form-control-label text-success-d1 text-100">Concepto</label>
                        <input type="text" name="concepto" disabled='true' class="form-control form-control-sm" id="concepto" value="Consulta de bur&oacute; de cr&eacute;dito" required>
                        </div>
                    

                    <div class="form-group  col-sm-12 col-md-6 col-lg-6">
                            <label for="" class="col-form-label form-control-label text-success-d1 text-100">Observaciones</label>
                            <textarea  class="form-control form-control-sm "  name="observaciones" id="observaciones" rows="2" style="resize: none;" required ></textarea>
                        
                    </div>

                    </div><!--fin segunda fila -->  
                            <br>  
                            <button id="btnGuardar" type="button" class="btn btn-success btn-sm float-right md-2" >
                                <i class="fas fa-save "></i>&nbsp;Guardar
                            </button>
                    

                    </div>  
                </form>
            
            </div>
            </div> <!-- / row con tabla col-lg-8--> 
        </div>
        <br>

 
        <h3 class="text-primary-d2 pb-0 mb-3 mb-md-0 text-center ">Tabla de Registros</h3>
                <div class="row justify-content-sm-center justify-content-md-center justify-content-lg-center mt-1">
                    <div class="col-sm-12 col-lg-12">                                        
                        <div class="row">
                            <div class="mx-auto col-12">

                                    <div class="table-responsive-md" style="min-width:100%;">
                                    <table id="tablaPromotorBuro" class="table table-bordered table-bordered-x text-dark-m2 text-95 brc-secondary-l1" >
                                    <thead class="text-dark-m3 bgc-grey-l4 text-uppercase text-85">
                                        <tr class="small">
                                            <th class="border-0">ID-CONSULTA</th>
                                            <th class="border-0">No. DE REGISTROS</th>
                                            <th class="border-0">MONTO</th>
                                            <th class="border-0">
                                                FECHA DE REGISTRO
                                            </th>
                                            <th class="border-0">OBSERVACIONES</th>
                                            <th class="border-0">ESTATUS</th>
                                            <th class="border-0">IMPRIMIR</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-grey" id="bodytable">
                                
                                    </tbody>
                                    </table>
                                

                                    </div>
                                
                            </div>
                        </div>

                    </div>
                </div>

                <br>

  
        

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
        <script src="../js/func_buro.js"></script>

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
        buroModulo.init();
        buroModulo.promotorTabla();

     });

</script>

</body>
</html>
