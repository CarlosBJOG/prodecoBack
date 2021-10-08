<?php
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    require_once "../php/security.php";
    require_once "../php/header_cartera.php";
    require_once "../php/functions.php";
    
    create_header_forms();
    create_menu_cartera();
    begin_containers();
    
  ?>

    <div class="row justify-content-around mt-4">

        <div class="col-12 col-sm-12 col-lg-3 my-1 my-lg-0 px-sm-1 px-lg-0">
            <figure class="mx-auto text-center">
              <img src="../styles/cartera.jpg" width="300">
            </figure>
            <h1 class="text-grey-d2 pb-0 mb-3 mb-md-0 text-center">Cartera</h1>
            <hr>
            <p class="text-100 text-secondary text-center">
             <!-- -->
            </p>
        
             <!-- CARD VERDE -->
             <div class="col-12 my-1 px-sm-1 mt-5">
              <div class="pos-rel bgc-green-d2 py-2">
                <span class="opacity-4 position-rc mr-2 d-none">
                  <i class="mr-3 mt-n2 fa fa-dollar-sign text-dark-tp5 opacity-4 w-5 h-5 text-center pt-1 radius-round fa-5x"></i>
                </span>
                <div class="d-flex align-items-center">
                  <div class="pos-rel p-3 bgc-white-tp8 radius-round ml-3 mr-3 shadow-md">
                    <i class="pos-abs mt-n2px ml-n3px fa fa-user-circle-o  text-dark-tp5 opacity-4 w-5 h-5 text-center pt-1 radius-round text-170"></i>
                    <i class="pos-rel fa fa-user-circle-o  text-white w-5 h-5 text-center pt-1 radius-round text-170"></i>                   
                  </div>
                  <div class="text-white">
                    <div>
                      <span class="text-160 text-600" id="nClientes"></span> <!-- Almacena el no. de clientes por promotor-->
                      <i class="fa fa-arrow-up text-yellow-l4 ml-2"></i>
                    </div>
                    <div class="text-uppercase text-85 text-600 letter-spacing">
                      Clientes a tu cargo<br/>                   
                      <a href="#" id="descargarClientes"><i class="fa fa-file-excel-o text-white ml-3 text-120"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- FIN CARD VERDE-->


                  <!-- CARD MORADA -->
              <div class="col-12 my-1 px-sm-1 mt-3">
              <div class="bgc-purple-d1 py-2">
                <div class="d-flex align-items-center">
                  <div class="pos-rel p-3 bgc-white-tp8 radius-round ml-3 mr-3 shadow-md">
                    <i class="pos-abs mt-n1 fa fa-clipboard text-purple-d3 opacity-4 w-5 h-5 text-center pt-1 radius-round fa-2x"></i>
                    <i class="pos-rel fa fa-check text-white w-5 h-5 text-center pt-1 radius-round text-170"></i>
                  </div>
                  <div class="text-white">
                    <div>
                      <span class="text-160 text-600" id="nCreditos"></span> <!-- Almacena el no. de creditos aprobados por promotor-->
                      <i class="fa fa-plus text-white ml-1"></i>
                    </div>
                    <div class="text-uppercase text-85 text-600 letter-spacing">
                      Créditos aprobados<br/>
                
                      <a href="#" id="descargarCreditos"><i class="fa fa-file-excel-o text-white ml-3 text-120"></i></a>

                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- FIN CARD VERDE -->

      </div> <!-- Col-3 cartera-->


      <div class="col-12 col-lg-8">
        <div>
          <h4 class="font-light text-orange-d2">
            <span class="b-underline-4">Clientes</span>&nbsp;&nbsp;&nbsp;  
            <span><a href="cartera_creditos.php" class="text-orange-d2">Créditos</a></span>
          </h4>
          
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
            <table id="datatable" class="table table-bordered table-bordered-x text-dark-m2 text-95 brc-secondary-l1" >
              <thead class="text-dark-m3 bgc-grey-l4 text-uppercase text-85" >
                <tr>
                  <th class="border-0"><input type="checkbox" autocomplete="off" /></th>
                  <th class="border-0">No. de cliente</th>
                  <th class="border-0">Nombre</th>
                  <th class="border-0">Curp</th>
                  <th class="border-0">Fecha de alta</th>
                  <th class="border-0">Estatus</th>  
                  <!--<th class="border-0"># Créd.</th>-->
                  <th class="border-0"></th> 
                </tr>
              </thead>
              <tbody class="text-grey" id="bodytable">
              </tbody>
            </table>
          </div> <!--/ table-responsive-md -->

        </div> <!-- / row con tabla col-lg-8-->        
      </div> <!-- /PRINCIPAL-->

                   
<?php 
  require("../views/cartera_clientes/view_impr_clientes.php");
  require("../views/cartera_clientes/view_impr_creditos.php");

?>
            


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

      

<?php
  create_footer_forms();
?>
</div>

<!--Funciones para cargar datos-->
<script type="text/javascript" src="../js/funciones_cartera.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
    //Se cargan los datos iniciales
    cards();
    datatable_clientes();

    $('#descargarClientes').on('click', ()=> {
        descargarClientes();
    })

    $('#descargarCreditos').on('click', ()=> {
        descargarCreditos();
    })
	});
</script>

</body>
</html>
