<?php
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    require_once "../php/security.php";
    require_once "../php/header_contabilidad.php";
    require_once "../php/functions.php";
    
    create_header();
    create_menu();
    begin_containers();
    
  ?>
    <div class="row justify-content-around mt-4">

      <div class="col-12 col-sm-12 col-lg-3 my-1 my-lg-0 px-sm-1 px-lg-0">
            <figure class="mx-auto text-center">
              <img src="../styles/ilustracion-cartera.png" width="300">
            </figure>
            <h1 class="text-grey-d2 pb-0 mb-3 mb-md-0 text-center">Contabilidad</h1>
             <hr>
            <p class="text-100 text-secondary text-center">
             <!-- -->
            </p>
      </div>

      

      <div class="col-9 col-lg-9" >
        <div>

          <div class="row">
            <div class="col-sm-8 col-md-8 col-lg-8">
              <h4 class="font-light text-orange-d2">
                <span><a href="colocacion.php" class="text-orange-d2">Colocación</a></span>&nbsp;&nbsp;&nbsp;
                <span class="b-underline-4">Pólizas Egreso</span> &nbsp;&nbsp;&nbsp;
              </h4>
            </div>
            <div class="col-sm-4 col-md-4 col-lg-4 text-right">
              <!--<button type="button" class="btn btn-success btn-sm"  id="btnPolDiario" onclick="cargar_poliza_diario()">
                  <i class="fa fa-file-pdf-o"></i>&nbsp;Generar Póliza Diario
              </button>&nbsp;-->
            </div>
          </div>
          
          <div class="row">
            <div class="mt-4 mx-md-2 border-t-1 brc-secondary-l1">
              <div id="table-header" class="d-none justify-content-between px-2 py-25 border-b-1 brc-secondary-l1">
                <div>
                  Resultados 
                  <span class="text-600 text-primary-d1">"Clientes"</span>
                  <small class="text-grey-m2">(Con columnas reordenables)</small>
                </div>
              </div>
            </div>


            <div class="table-responsive-lg"  style="min-width:100%; margin-bottom: 10px">
              <table id="datatable" class="table table-bordered table-bordered-x text-dark-m2 text-95 brc-secondary-l1" width="100%" >
                <thead class="text-dark-m3 bgc-grey-l4 text-uppercase text-85" >
                  <tr class="small">
                    <th class="border-0"><input type="checkbox" autocomplete="off" /></th>
                    <th class="border-0">No.</th>
                    <th class="border-0" width="20%">Fecha</th>
                    <th class="border-0" width="300px">Concepto</th>
                    <th class="border-0">Monto</th>
                     <th class="border-0">Tipo</th>
                    <th class="border-0" width="10%"></th>
                  </tr>
                </thead>
                <tbody class="text-grey" id="bodytable">
                </tbody>
              </table>
              <hr>
            </div> <!--/ table-responsive-md -->

            <div class="col-sm-12 col-md-12 col-lg-12" id="colocacionForm">
            </div>
          </div>

        </div> <!-- / row con tabla col-lg-8-->     
      </div> <!-- /PRINCIPAL-->
      <br>


<!---- MODAL-->

<form id="formPDiario" name="formPDiario" action="">
  <div class="modal fade modal-lg" id="modalPDiario" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-lg" role="document">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title text-success">Póliza Diario</h5>
          <input hidden type="text" name="idkey_poliza_egreso" id="idkey_poliza_egreso">
          <input hidden type="text" name="idkey_tipo_poliza" id="idkey_tipo_poliza">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body ace-scrollbar">
          <div id="formPolizaDiario"  aria-labelledby="formPDiario" >
                    
              <!---***********Contenido del form-->
              <div class="row brc-grey-l1">
                    <div class="col-sm-12 col-md-6 col-lg-6">
                      <label class="col-form-label form-control-label mt-0 text-600 text-grey">Fecha de póliza<span style="color:red;">*</span></label>
                      <div class="input-group date" id="id-timepicker">
                        <div class="input-group-addon input-group-append">
                          <div class="input-group-text">
                            <i class="fa fa-calendar"></i>
                          </div>
                        </div>
                        <input type="text" class="form-control form-control-sm" id="fecha_poliza"  name="fecha_poliza" autocomplete="off" required>
                        <script> $('#fecha_poliza').activeCalendary('#fecha_poliza'); $('#fecha_poliza').val('<?php echo date('d/m/Y'); ?>');</script>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6">
                      <p class="text-600 text-grey">
                        <label >Monto</label><span style="color:red;">*</span>
                        <input type="text" class="form-control" id="monto" name = "monto" readonly="true">
                      </p>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4">
                      <p class="text-600 text-grey">
                        <label >Periodo</label><span style="color:red;">*</span>
                        <input type="number" class="form-control" id="periodo" name = "periodo">
                      </p>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4">
                      <p class="text-600 text-grey">
                        <label >Serie</label><span style="color:red;">*</span>
                        <input type="text" class="form-control" id="serie" name = "serie">
                      </p>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4">
                      <p class="text-600 text-grey">
                        <label >Tipo</label><span style="color:red;">*</span>
                        <input type="text" class="form-control" id="tipo" name = "tipo">
                      </p>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-12">
                      <p class="text-600 text-grey">
                        <label >Concepto</label><span style="color:red;">*</span>
                        <input type="text" class="form-control" id="concepto" name = "concepto" required="">
                      </p>
                    </div>
                  </div>


                  <div class="card col-sm-12 col-md-12 col-lg-12">
                    <div class="card-header">
                      <span class="text-blue text-110">Cuenta Contable 1</span>
                    </div>

                    <div class="card-body row">
                      <div class="col-lg-6 col-sm-12 col-md-6">     
                          <p class="text-600 text-grey">
                          <label >Cuenta contable</label><span style="color:red;">*</span>
                          <select class="ace-select text-dark-m1 bgc-default-l5 bgc-h-warning-l3  brc-default-m3 brc-h-warning-m1" id="cuenta_contable1" name="cuenta_contable1" required style="width: 100%" >
                            <?php
                            $oconns = new database();
                            $dats = $oconns->getRows("select no_cuenta, nombre from cuentas_contables order by no_cuenta asc;");
                            echo "<option></option>";
                            foreach ($dats as $items)
                                echo "<option value='".$items["no_cuenta"]."'>".$items["no_cuenta"]." - ".$items["nombre"]."</option>";
                                ?>
                          </select>
                          </p>
                      </div>
                      <div class="col-sm-12 col-md-6 col-lg-6">
                        <p class="text-600 text-grey">
                          <label >Referencia</label><span style="color:red;">*</span>
                          <input type="text" class="form-control" id="referencia1" name = "referencia1" required="">
                        </p>
                      </div>
                      <div class="col-sm-12 col-md-6 col-lg-6">
                        <p class="text-600 text-grey">
                          <label >Debe</label><span style="color:red;">*</span>
                          <input type="number" class="form-control" id="debe1" name = "debe1" required=""  value="0">
                        </p>
                      </div>
                      <div class="col-sm-12 col-md-6 col-lg-6">
                        <p class="text-600 text-grey">
                          <label >Haber</label><span style="color:red;">*</span>
                          <input type="number" class="form-control" id="haber1" name = "haber1" required="">
                        </p>
                      </div>
                    </div>
                  </div>


                  <div class="card col-sm-12 col-md-12 col-lg-12">
                    <div class="card-header">
                      <span class="text-blue text-110">Cuenta Contable 2</span>
                    </div>

                    <div class="card-body row">
                    <div class="col-lg-6 col-sm-12 col-md-6">     
                        <p class="text-600 text-grey">
                        <label >Cuenta contable</label><span style="color:red;">*</span>
                        <select class="ace-select text-dark-m1 bgc-default-l5 bgc-h-warning-l3  brc-default-m3 brc-h-warning-m1" id="cuenta_contable2" name="cuenta_contable2" required style="width: 100%">
                          <?php 
                          echo "<option></option>";
                            foreach ($dats as $items)
                                echo "<option value='".$items["no_cuenta"]."'>".$items["no_cuenta"]." - ".$items["nombre"]."</option>";
                          ?>
                        </select>
                        </p>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6">
                      <p class="text-600 text-grey">
                        <label >Referencia</label><span style="color:red;">*</span>
                        <input type="text" class="form-control" id="referencia2" name = "referencia2" required="">
                      </p>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6">
                      <p class="text-600 text-grey">
                        <label >Debe</label><span style="color:red;">*</span>
                        <input type="number" class="form-control" id="debe2" name = "debe2" required="" >
                      </p>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6">
                      <p class="text-600 text-grey">
                        <label >Haber</label><span style="color:red;">*</span>
                        <input type="number" class="form-control" id="haber2" name = "haber2" required="" value="0">
                      </p>
                    </div>
                  </div>
                

                  </div>
              <!---//Contenido del form -->
          </div> <!-- / id="formPCheque" class="collapse" -->

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success" id="btnGenerarPoliza">Guardar</button>
        </div>

      </div>
    </div>
  </div>
</div>
</form>
<!---//FIN DE MODAL-->



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

 <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script type="text/javascript" src="../js/default.js"></script>
    <script type="text/javascript" src="../js/jquery.validate.min.js"></script>
  <script src="../js/validate_rules.js"></script>


<?php
  create_footer_forms();
?>
</div>

<!--Funciones para cargar datos-->
<script type="text/javascript" src="../js/funciones_contabilidad.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
    datatable_colocacion_egreso();
     $('#cuenta_contable1').select2();
    $('#cuenta_contable2').select2();
    $( "#formPDiario").validate({errorClass: 'text-error'});
    /////Envío del form
    $( "#formPDiario").submit(function( event ) {
        if($("#formPDiario").valid())
            guardar_poliza_diario();
        else
            alertify.error("Algunos datos están incompletos o erróneos");
        event.preventDefault();
    });

  });
</script>
</script>

</body>
</html>
