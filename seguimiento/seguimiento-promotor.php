<?php
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");

    require_once "../php/security.php";
    require_once "../php/header_seguimiento.php";
    require_once "../php/functions.php";
    require_once "functions_seguimiento.php";
    require_once "../php/db.php";
    
    create_header_seguimiento();
    create_menu_seguimiento();
    begin_containers();
    @session_start();
    
    ?>


<!-- MAIN CONTAINER --> 
<div class="page-content container container-plus px-md-4 px-xl-5">

        <div class="row mt-35">

            <div class="col-lg-4 col-12 pr-lg-0 mt-3 mt-lg-0">

            <figure class="mx-auto text-center">
              <img src="../styles/ilustracion-seguimiento.png" width="300">
            </figure>
            <h1 class="text-grey-d2 pb-0 mb-3 mb-md-0 text-center">
             Seguimiento
            </h1>
            <hr>
            <p class="text-100 text-secondary text-center">Módulo de supervisión en la continuidad de créditos.</p>
            <h4 class="font-light text-orange-d2 b-underline-4 mr-5 pr-5">Lista de clientes a visitar</h4>
            <p class="text-100 text-600 pt-3">Ingresar el rango de fechas para la b&uacute;squeda.</p>
            <form action="#" id="formListClientes">

              <label for="form-field-select-11" class="text-80 text-orange-d2">Ingresar Fecha Inicio:</label>
                  <div class="row">
                      <div class="col-lg-9 col-md-12 col-sm-12">   

                        <div class="input-group date" id="id-timepicker">
                            <div class="input-group-addon input-group-append">
                                    <div class="input-group-text">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                </div>
                                <input type="text" name="fecha_inicio" class="form-control form-control-sm" id="fecha_inicio" required>
                                <script>  $("#fecha_inicio").activeCalendary('#fecha_inicio'); </script>
                            </div>
                        </div>

                  </div> <!-- row botón descarga reporte-->
                  <label for="form-field-select-11" class="text-80 text-orange-d2">Ingresar Fecha Final:</label>
                  <div class="row">
                      <div class="col-lg-9 col-md-12 col-sm-12">   

                        <div class="input-group date" id="id-timepicker">
                            <div class="input-group-addon input-group-append">
                                    <div class="input-group-text">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                </div>
                                <input type="text" name="fecha_fin" class="form-control form-control-sm" id="fecha_fin" required>
                                <script>  $("#fecha_fin").activeCalendary('#fecha_fin'); </script>
                            </div>
                        </div>

                  </div> <!-- row botón descarga reporte-->
                  <button type="button" class="btn btn-outline-success mt-3" id="btnClientes" onclick="imprVistClientes()">Buscar Clientes</button>
            </form>

            </div> <!--div class="col-lg-4-->


            <!--columna con tabla-->
            <div class="col-lg-8 col-12 pl-lg-0 pr-lg-2">
        
            <div class="page-header pb-2 flex-column flex-sm-row align-items-start align-items-sm-center">
              <h4 class="font-light text-orange-d2">
                <span class="b-underline-4">Seguimiento Promotor</span>&nbsp;&nbsp;&nbsp;  
                <span><a <?php if($_SESSION["tipo_usuario"]!='1' && $_SESSION["tipo_usuario"]!='3') echo "hidden"; ?> href="seguimiento-supervisor.php" class="text-orange-d2">Seguimiento Supervisor</a></span>&nbsp;&nbsp;&nbsp;
                
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


            </div> <!-- / row con tabla col-lg-8--> 


            <div class="row" style="overflow-x:auto;">
              <div class="col-12">
                <table id="tablaPagosProx" class="table table-bordered table-bordered-x table-hover text-dark-m2 small" width="100%">
                  <thead class="text-dark-m3 bgc-grey-l4">
                    <tr>
                      <th class="border-0">Folio</th>
                      <th class="border-0">Fecha último pago</th>
                      <th class="border-0">Fecha de pago</th>                      
                      <th class="border-0">Cliente</th>  
                      <th class="border-0">Producto</th> 
                      <th class="border-0">Cantidad a pagar</th>  
                      <th class="border-0">Saldo insoluto</th>                        
                      <th class="border-0">Estado</th>   
                    </tr>
                  </thead>
                  <tbody></tbody>
                </table>
              </div><!-- /.col -->
            </div><!-- /.row -->


            </div>
          
          <!--MODAL CANTIDAD A PAGAR-->
            <?php require('../views/seguimiento/view_efectuar_pago.php');
             require('../views/seguimiento/view_impr_listaClientes.php');?>

            <!-- MODAL SALDO INSOLUTO -->
            <div class="modal fade modal-fs" id="saldo-insoluto" tabindex="-1" role="dialog" aria-labelledby="saldo-insolutoLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content border-width-0 border-t-4 brc-success-m2 px-3">

                  <div class="modal-body">
                    <p class="text-success-d1 text-130 mt-3 text-center">SALDO INSOLUTO</P>
                    <p class="text-secondary-d1 text-100 font-bold text-center" id="nombre_cliente">
                    
                    </p>
                    <table class="table table-bordered table-bordered-x table-hover text-dark-m2 small" id="amortizacion-dinamica" width="100%">
                      <thead class="text-dark-m3 bgc-success-l4">
                          <tr class="font-bold text-100">
                              <tr class="font-bold text-100">
                             <td>#</td>
                            <td width="15%">Fecha valor</td>
                             <td>Pago</td>
                            <td>Interés</td>
                            <td>IVA</td>
                            <td>Monto</td>
                            <td>Interes<br> acumulado</td>
                            <td>Pago interés<br> moratorio</td>
                            <td>Iva interés<br> moratorio</td>
                            <td>Amortización</td>
                            <td>Saldo<br> insoluto</td>
                            <td>Días<br> transc.</td>
                            <td>Acciones</td>
                          </tr>
                      </thead>
                      <tbody>
                      </tbody>
                  </table>
                  </div>

                </div>
              </div>
            </div>
            <!-- / MODAL SALDO INDOLUTO -->

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



        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.13/dataRender/datetime.js"></script>

        <script type="text/javascript" src="../js/funciones_seguimiento.js"></script>
        <!-- Para validar los campos de los forms-->
        <script type="text/javascript" src="../js/jquery.validate.min.js"></script>
        <script src="../js/validate_rules.js"></script>

    </div><!-- /.body-container -->
  </body>

  <script>
$(function () {
  $('[data-toggle="popover"]').popover()
})
  </script>

  <script>
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        datasets: [{
            label: 'Solicitudes por mes',
            data: [12, 19, 3, 5, 2, 3, 8, 9, 5, 20, 13, 10],
            backgroundColor: "rgba(134, 189, 104, 0.3)",
            borderColor: '#73bd73', // The main line color
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
</script>


<script type="text/javascript">

$(document).ready(function(){
    datatable_creditos_promotor();
    jQuery.validator.setDefaults({
      debug: true,
      success: "valid"
    });
  });
</script>

<?php
    require_once "../php/security.php";
    require_once "../php/header_seguimiento.php";
    create_footer_forms();
    ?>
</div>
</body>
</html>
