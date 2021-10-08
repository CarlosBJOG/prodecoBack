<?php
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    require_once "../php/security.php";
    require_once "../php/header_cartera.php";
    require_once "../php/functions.php";
    require_once "../php/db.php";
    
    create_header_forms();
    create_menu_cartera();
    begin_containers();
    
    ?>


<!-- MAIN CONTAINER --> 
<div class="page-content container container-plus px-md-4 px-xl-5">

  <div class="row mt-35">
    <div class="col-lg-4 col-12 pl-lg-0 pr-lg-2">
      <h4 class="text-secondary-d1 text-120 ml-1 text-orange-d2 b-underline-4 mb-4">Detalle de cliente</h4>              
      <div class="bgc-white bo1rder-1 brc-success-l2 radius-1" style="overflow-x: auto;">
        <?php
          $idkey_cliente = "";
          if(isset($_GET["idkey_cliente"])) 
            $idkey_cliente = $_GET["idkey_cliente"];
        ?>
        <input type="hidden" name='idkey_cliente' id='idkey_cliente' value='<?php echo $idkey_cliente;?>'>
          
        <table class="table table table-striped table-borderless mt-2" style="overflow-x: auto;" id="tabla_datos_cliente">
          <tbody>
		        <tr>
              <td colspan="3"><h7 id="nombre" class="text-secondary-d1 text-100 px-3 px-lg-0"></h7></td>
            </tr>
            <tr>
              <td><i class="fa fa-key text-orange-m3"></i></td>
              <td class="text-95 text-default-d3"><b>No. de cliente</b></td>
              <td class="text-secondary-d2 text-wrap"><?php echo $idkey_cliente; ?></td>
            </tr>
            <tr>
              <td><i class="far fa-user text-orange-m3"></i></td>
              <td class="text-95 text-default-d3"><b>RFC</b></td>
              <td class="text-secondary-d2 text-wrap" id="rfc"></td>
             </tr>
            <tr>
            <td><i class="fa fa-id-card-o text-orange-m3"></i></td>
              <td class="text-95 text-default-d3"><b>CURP</b></td>
              <td class="text-secondary-d2 text-wrap" id="curp"></td>
            </tr>
            <tr>
              <td><i class="fa fa-envelope text-orange-m3"></i></td>
              <td class="text-95 text-default-d3"><b>Email</b></td>
              <td class="text-secondary-d2 text-wrap" id="email"></td>
            </tr>
            <td><i class="fa fa-phone text-orange-m3"></i></td>
              <td class="text-95 text-default-d3"><b>Teléfono</b></td>
              <td class="text-secondary-d2 text-wrap" id="telefono"></td>
            </tr>
            <tr>
              <td><i class="fa fa-calendar text-orange-m3"></i></td>
              <td class="text-95 text-default-d3"><b>Fecha registro</b></td>
              <td class="text-secondary-d2 text-wrap" id="fecha_creacion"></td>
            </tr>
            <tr>
              <td><i class="fa fa-clock text-orange-m3"></i></td>
              <td class="text-95 text-default-d3"><b>Días mora total</b></td>
              <td class="text-danger-d2 text-wrap" id="ndiasmora_total"></td>
            </tr>
          </tbody>
        </table>
        <div id="cred_data"></div>

        <!-- Tabla de créditos activos-->
        <div class="col-lg-12 order-last order-lg-first" style="overflow-x: auto;">
          <div class="card border-0">
            <div class="card-header bg-transparent border-0 pl-1">
              <h5 class="card-title mb-2 mb-md-0 text-100">
                <span class="text-105">Créditos</span>
              </h5>

              <div class="card-toolbar align-self-center">
                <a href="#" data-action="toggle" class="card-toolbar-btn text-grey text-110"><i class="fa fa-chevron-up"></i></a>
              </div>
            </div>
            <div class="card-body p-0 border-t-2 brc-default-l2 collapse show" style="">
              <table class="table brc-secondary-l4 small">
                <thead class="border-0 ">
                  <tr class="border-0 bg-transparent text-dark-tp4 te1xt-95">
                    <th class="border-0 font-normal text-alert"><b>Folio</b></th>
                    <th class="border-0 font-normal"><b>Tipo</b></th>
                    <th class="border-0 font-normal"><b>Días mora</b></th>
                    <th class="border-0 font-normal"><b>Estatus</b></th>
                    <th class="border-0 font-normal"><b>Progreso</b></th>
                  </tr>
                </thead>
                <tbody id="creditos">
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <!-- //tabla de créditos activos-->


      </div>
      <hr class="w-100 mx-auto my-1 border-dotted mt-3">
      <p class="mt-3">
        <a href="<?php echo "clientes_alta.php?idkey_cliente=".$idkey_cliente.""; ?>">
          <button class="btn btn-outline-success btn-sm mb-2px" id="nuevo_credito">
            <i class="far fa-edit text-140 align-text-bottom mr-1"></i>Editar 
          </button>
        </a>
        <a href ="<?php echo "form-nuevocredito.php?idkey_cliente=".$idkey_cliente."&tipo=1"; ?>">
          <button class="btn btn-outline-success btn-sm mb-2px">
            <i class="fa fa-money text-140 align-text-bottom mr-1"></i> Nuevo crédito
          </button>
        </a>
        <button class="btn btn-danger btn-sm mb-2px">
          <i class="fa fa-exclamation-triangle text-110 text-white mr-1"></i> Reportar
        </button>
      </p>
    </div>
    <div class="col-lg-8 col-12 pr-lg-0 mt-3 mt-lg-0" style="overflow-x: auto;">
      <div class="border-1 brc-grey-l1 bgc-white shadow-sm radius-2 pt-35 px-0 px-lg-4" style="min-width: 600px;">
        <div class="d-flex mb-4">
          <h4 class="text-secondary-d1 text-120 px-3 px-lg-0">Comportamiento de pagos de los créditos</h4>
        </div>
        
        <div id="grafica_anuncios" class="text-center text-danger text-80"><i></i></div>
        <div id="graph-container"><canvas id="canvas" class="p-4"></canvas></div>
      </div>
    </div>
  </div>
            
</div><!-- /.page-content -->

<?php end_containers(); ?>
	<script type="text/javascript" src="../js/funciones_creditos.js"></script>
  <script type="text/javascript" src="../js/funciones_cartera.js"></script>
	<script type="text/javascript">
		var idkey = $('#idkey_cliente').val();
		
		$(document).ready(function(){
			
			display_credito_individual(idkey); // Creditos indivuduales acivos
			display_credito_grupal(idkey); // Ceditos grupales
			//datos_perfil_cliente(idkey);//Datoscliente
			
		});
	</script>


	<script>$('#div_reporte').load("../php/show_interface_cliente.php?module=main_semaforo&param=<?php echo $_GET["idkey_cliente"] ?>");</script>
	<script type="text/javascript" src="../ace-admin/node_modules/jquery/dist/jquery.js"></script>
	<script type="text/javascript" src="../ace-admin/node_modules/popper.js/dist/umd/popper.js"></script>
	<script type="text/javascript" src="../ace-admin/node_modules/bootstrap/dist/js/bootstrap.js"></script>


	<!-- include vendor scripts used in "Horizontal Menu" page. see "application/views/default/pages/partials/horizontal-menu/@vendor-scripts.hbs" -->
	<script type="text/javascript" src="../ace-admin/node_modules/chart.js/dist/Chart.js"></script>

	<script type="text/javascript" src="../ace-admin/node_modules/@fullcalendar/core/main.js"></script>
	<script type="text/javascript" src="../ace-admin/node_modules/@fullcalendar/daygrid/main.js"></script>
	<script type="text/javascript" src="../ace-admin/node_modules/@fullcalendar/timegrid/main.js"></script>


	<!-- include Ace script -->
	<script type="text/javascript" src="../ace-admin/dist/js/ace.js"></script>


	<script type="text/javascript" src="../ace-admin/assets/js/demo.js"></script>
	<!-- this is only for Ace's demo and you don't need it -->

	<!-- "Horizontal Menu" page script to enable its demo functionality -->
	<script type="text/javascript" src="../ace-admin/application/views/default/pages/partials/horizontal-menu/@page-script.js"></script>
</div><!-- /.body-container -->



<script>
$(document).ready(function() {
  ficha_cliente();
  creditos_cliente();

});
    
    
</script>
<?php
  create_footer_forms();
?>
</div>
</body>
</html>
