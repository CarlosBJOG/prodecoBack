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

    <div class="row justify-content-around mt-4">

        <div class="col-2 col-sm-2 col-lg-2 my-1 my-lg-0 px-sm-1 px-lg-0">
            <figure class="mx-auto text-center">
              <img src="../styles/quitar_pago.jpg" width="270">
            </figure>
            <h1 class="text-grey-d2 pb-0 mb-3 mb-md-0 text-center">Quitar Pago</h1>
            <hr>
             <h5 class="text-grey-d2 pb-0 mb-3 mb-md-0 text-center"></h5>
            <p class="text-100 text-secondary text-center">
             <!-- -->
            </p>

      </div> <!-- Col-3 cartera-->


        <div class="row col-9 col-lg-9" >
            <div class="container ">
            <h4 class="font-light text-orange-d2 b-underline-4"> 
            
                <span> <a href="quitar_pago.php" class="text-orange-d2">Quitar Pago</a></span> 
          </h4>
            <br>
            <form action="" name="formulario" id="formulario" method='POST' autocomplete="off">
               <div class="row">
                  <div class="form-group col">
                      <label for="" class="col-form-label form-control-label text-success-d1 text-100"> Buscar Cliente o Grupo(Num de credito)</label>
              
                        <input list="browser" name="buscar" id="buscar" class="form-control form-control-sm" onchange='seleccion()' required>
                        <datalist id='browser' >

                      </datalist>
                  </div>

                  <div class="form-group col">
                      <label for="" class="col-form-label form-control-label text-success-d1 text-100">Número de pago</label>
                      <input type="number" name="num_pago" disabled='true' class="form-control form-control-sm" id="num_pago" required>
                  </div>

                  <div class="form-group col">
                      <label for="" class="col-form-label form-control-label text-success-d1 text-100">Nombre</label>
                      <input type="text" name="nombre" class="form-control form-control-sm" id="nombre" required>
                  </div>
               </div><!--fin primerafila -->

              <br>

               <div class="row">

               <div class="form-group col">
                      <label for="" class="col-form-label form-control-label text-success-d1 text-100">Folio de Autorizacion</label>
                      <input type="text" name="folio" class="form-control form-control-sm" id="folio" required>
                  </div>
                  
                  <div class="form-group col-sm-12 col-md-4 col-lg-4">
                      <label class="col-form-label form-control-label text-success-d1 text-100" for="registro">Fecha registro</label>
                      <div class="input-group date" id="id-timepicker">
                          <div class="input-group-addon input-group-append">
                              <div class="input-group-text">
                                  <i class="fa fa-calendar"></i>
                              </div>
                          </div>
                          <input type="text" name="registro" class="form-control form-control-sm" id="registro" required>
                          <script>  $("#registro").activeCalendary('#registro'); </script>
                      </div>
                  </div>

                  <div class="form-group col-4">
                      <label for="" class="col-form-label form-control-label text-success-d1 text-100"> Monto a disminuir</label>
              
                        <input type='number' name="monto_disminuir" id="monto_disminuir"class="form-control form-control-sm" required >
                    
                  </div>

               </div><!--fin segunda fila -->  
               <br>  
                    <button id="btnGuardar" type="button" class="btn btn-success btn-sm float-right" >
                      <i class="fas fa-save "></i>&nbsp;Guardar
                    </button>
                    <button id="btnAplicar" type="button" class="btn btn-danger btn-sm float-right" style="margin-right: 2px;" onclick="cancelarform()">
                      <i class="fa fa-arrow-circle-left"></i>&nbsp;Volver
                  </button>

            </div>  
            </form>
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
    
      <script type="text/javascript" src="../ace-admin/node_modules/bootbox/bootbox.all.js"></script>
    <script type="text/javascript" src="../ace-admin/node_modules/sweetalert2/dist/sweetalert2.all.js"></script>
    <script type="text/javascript" src="../ace-admin/node_modules/interactjs/dist/interact.js"></script>

 <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script type="text/javascript" src="../js/default.js"></script>
    <script type="text/javascript" src="../js/jquery.validate.min.js"></script>
    <script src="../js/validate_rules.js"></script>
    <script src="../js/func_quitar_pago.js"></script>

<?php
 create_footer();
?>
</div>

<!--Funciones para cargar datos-->
<script type="text/javascript">
 
     $(document).ready(function(){
        jQuery.validator.setDefaults({
        debug: true,
        success: "valid"
        });
  
     });

    
</script>

</body>
</html>
