<?php
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");

    require_once "../php/security.php";
    require_once "../php/header_facturacion.php";
    require_once "../php/functions.php";
    
    create_header();
    create_menu();
    begin_containers();
    @session_start();
    
    ?>



<div class="row justify-content-around mt-4">

<div class="col-2 col-sm-2 col-lg-2 my-1 my-lg-0 px-sm-1 px-lg-0">
    <figure class="mx-auto text-center">
      <img src="../styles/ilustracion-cartera.png" width="300">
    </figure>
    <h1 class="text-grey-d2 pb-0 mb-3 mb-md-0 text-center">Detalles de Cliente</h1>
    <hr>
    <h5 class="text-grey-d2 pb-0 mb-3 mb-md-0 text-center">Informacion del cliente </h5>
    <p class="text-100 text-secondary text-center">
     <!-- -->
    </p>

</div> <!-- Col-3 cartera-->


<div class="col-12 col-lg-9">

  <h5 class="font-light text-orange-d2"> 
    <span class="b-underline-4"><a  href="facturacion.php" style="text-decoration: none;" class="font-light text-orange-d2">Detalles de cliente</a></span> &nbsp;&nbsp;&nbsp;
 
  </h5>

 
        <table class="table">
        <thead>
            <tr>
                <th scope="col">Id Cliente</th>
                <th scope="col" id='nombre'>Nombre</th>
      
            </tr>
        </thead>
        <tbody>
            <tr>
           
                <th scope="col">Poducto</th>
                <td>Mark</td>
  
            </tr>
            <tr>
                <th scope="col">RFC</th>

                <td>Jacob</td>
   
            </tr>
            <tr>
                <th scope="col">Domicilio</th>
                <td colspan="2">Larry the Bird</td>

            </tr>
            <tr>
           
            <th scope="col">Telefono</th>
            <td>Mark</td>

            </tr>
            <tr>
                <th scope="col">E-mail</th>

                <td>Jacob</td>

            </tr>
            <tr>
                <th scope="col">Total de IVA</th>
                <td colspan="2">Larry the Bird</td>

            </tr>
            <tr>
           
            <th scope="col">Total de Interes</th>
            <td>Mark</td>

            </tr>
            <tr>
                <th scope="col">Total IVA moratorio</th>

                <td>Jacob</td>

            </tr>
            <tr>
                <th scope="col">Total interes moratorio</th>
                <td colspan="2">Larry the Bird</td>

            </tr>
        </tbody>
        </table>

  
          
            
          </div> <!-- /PRINCIPAL-->
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
      <script src="../js/func_facturacion.js"></script>

    </div><!-- /.body-container -->



<?php
   create_footer();
?>
</div>
<script>
     $(document).ready(function(){
          //datatable_gastos();
          const valores = window.location.search;
          const urlParams = new URLSearchParams(valores);
          var idkey_cliente = urlParams.get('idkey_cliente');
          var idkey_credito = urlParams.get('idkey_credito');
          var fecha_inicio = urlParams.get('fecha_inicio');
          var fecha_fin = urlParams.get('fecha_fin');

          cargar_datos(idkey_cliente, idkey_credito, fecha_inicio, fecha_fin);
          

     });

</script>

</body>
</html>
