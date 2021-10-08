<?php
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    require_once "../php/security.php";
    require_once "../php/header_seguimiento.php";
    //require_once "../php/functions.php";
    require_once "../php/db.php";
    
    create_header_seguimiento();
    create_menu_seguimiento();
    
    
    ?>


<!-- MAIN CONTAINER --> 
<div class="page-content container container-plus px-md-4 px-xl-5">

        <div class="row mt-35">

            <div class="col-lg-3 col-12 pr-lg-0 mt-3 mt-lg-0">

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
            <div class="col-lg-9 col-12 pl-lg-0 pr-lg-2">
        
            <div class="page-header pb-2 flex-column flex-sm-row align-items-start align-items-sm-center">
              <h4 class="font-light text-orange-d2">
                <span><a <?php if($_SESSION["tipo_usuario"]!='1' && $_SESSION["tipo_usuario"]!='3') echo "hidden"; ?> href="seguimiento-promotor.php" class="text-orange-d2">Seguimiento Promotor</a></span>&nbsp;&nbsp;&nbsp;&nbsp;
                <span class="b-underline-4">Seguimiento Supervisor</span>
                &nbsp;&nbsp;&nbsp;
                
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

              <div class="table-responsive-md">
                <table id="datatable1" class="table table-border-y text-dark-m2 text-95 border-y-1 brc-secondary-l1">
                  <thead class="text-secondary-m2 text-uppercase text-85">
                    <tr>
                      <th class="border-0">Folio</th>
                      <th class="border-0" >Producto</th>
                      <th class="border-0">Fecha</th>  
                      <th class="border-0">Promotor</th>  
                      <th class="border-0">Cliente</th> 
                      <th class="border-0">Monto</th>   
                      <th class="border-0">Estatus</th>
                      <th class="border-0">Estatus<br>Pagos</th>
                      <th class="border-0">Atraso</th> 
                      <th class="border-0">Acciones</th> 
                    </tr>
                  </thead>
                  <tbody class="small">
                       
                  </tbody>
                </table>
              </div> <!--/ table-responsive-md -->

            </div> <!-- / row con tabla col-lg-8--> 


        <!--MODAL PARA REESTRUCTURACIÓN, CONDONACIÓN Y RENOVACIÓN -->
        <?php require('../views/seguimiento/view_cambios_amortizacion.php');
           require('../views/seguimiento/view_impr_listaClientes.php'); ?>

        
        </div>

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

         <script type="text/javascript" src="../js/funciones_seguimiento.js"></script>
 
    </div><!-- /.body-container -->
  </body>

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

    datatable_creditos_supervisor();
    $.ajax({
    url: '../php/json_func_seguimiento.php',
    data: {"funcion" : "datatable_creditos_supervisor"},
    type: 'post',
    dataType: "json",
    beforeSend: function () {
            //animación de carga
        },
    success: function (response) {
           console.log(response);
    },
    error: function(data) {
        console.log(data);
      }
    });
});

</script>

<?php
    //require_once "../php/security.php";
    //require_once "../php/header_forms.php";
    create_footer_forms();
    ?>
</div>
</body>
</html>
