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
      <h4 class="text-secondary-d1 text-120 ml-1 text-orange-d2 b-underline-4 mb-4">Detalle de crédito</h4>              
      <div class="bgc-white bo1rder-1 brc-success-l2 radius-1">
        <?php
          $idkey_cliente = "";
          $idkey_credito = "";
          if (isset($_GET["idkey_cliente"]))
            $idkey_cliente = $_GET["idkey_cliente"];
          if (isset($_GET["idkey_credito"]))
            $idkey_credito = $_GET["idkey_credito"];
        ?>
        <input hidden name='idkey_cliente' id='idkey_cliente' value='<?php echo $idkey_cliente;?>'>
        <input hidden name='idkey_credito' id='idkey_credito' value='<?php echo $idkey_credito;?>'>
        <input hidden name='folio' id='folio' value=''>
        <input hidden name='tipo_credito' id='tipo_credito' value=''>
        <table class="table table table-striped table-borderless mt-2" id="info_credito">
          <tbody>
            <tr>
              <td colspan="3"><h7 id="nombre" class="text-secondary-d1 text-100 px-3 px-lg-0"></h7>
              </td>
            </tr>
            <tr style="margin-bottom: 0px; margin-left: 20px" id="socios">
            </tr>
            <tr>
              <td><i class="fa fa-key text-orange-m3"></i></td>
              <td class="text-95 text-default-d3"><b>Folio</b></td>
              <td class="text-secondary-d2 text-wrap" id="folio1"></td>
            </tr>
            <tr>
              <td><i class="fa fa-suitcase text-orange-m3"></i></td>
              <td class="text-95 text-default-d3"><b>Producto</b></td>
              <td class="text-secondary-d2 text-wrap" id="producto"></td>
            </tr>
            <tr>
              <td><i class="fa fa-usd text-orange-m3"></i></td>
              <td class="text-95 text-default-d3"><b>Monto entregado</b></td>
              <td class="text-secondary-d2 text-wrap" id="monto"></td>
            </tr>
            <tr>
              <td><i class="fa fa-clock text-orange-m3"></i></td>
              <td class="text-95 text-default-d3"><b>Frecuencia de pago</b></td>
              <td class="text-secondary-d2 text-wrap" id="frecuencia"></td>
            </tr>
            <tr>
              <td><i class="fa fa-calendar-check text-orange-m3"></i></td>
              <td class="text-95 text-default-d3"><b>Plazo</b></td>
              <td class="text-secondary-d2 text-wrap" id="plazo"></td>
            </tr>
            <tr>
              <td><i class="fa fa-bars text-orange-m3"></i></td>
              <td class="text-95 text-default-d3"><b>Total de pagos</b></td>
              <td class="text-secondary-d2 text-wrap"><span id="no_pagos"></span></td>
            </tr>
            <!--
            <tr>
              <td><i class="fa fa-check-circle text-orange-m3"></i></td>
              <td class="text-95 text-default-d3"><b>Finalidad</b></td>
              <td class="text-secondary-d2 text-wrap" id="finalidad"></td>
            </tr>-->
            <tr>
              <td><i class="fa fa-calendar text-orange-m3"></i></td>
              <td class="text-95 text-default-d3"><b>Fecha de solicitud</b></td>
              <td class="text-secondary-d2 text-wrap" id="fecha_creacion"></td>
            </tr>
            <tr>
              <td><i class="fa fa-calendar text-orange-m3"></i></td>
              <td class="text-95 text-default-d3"><b>Estatus</b></td>
              <td class="text-secondary-d2 text-wrap" id="estatus"></td>
            </tr>
            <tr>
              <td colspan="3">
                <small class="text-default-d3"><b>Avance</b></small>
                <div id="progreso" class="progress mt-3"></div>
              </td>
            </tr>
          </tbody>
        </table>
        <div>
          <a href="#" id="link_detalle_credito">
  					<button id="genrerar_contrato" type="button" class="btn btn-success btn-sm">
  						<i class="fa fa-search"></i>&nbsp;Ver Detalles del crédito
  					</button>
          </a>
				</div>
      </div>
    </div>
    <div class="col-lg-8 col-12 pr-lg-0 mt-3 mt-lg-0" style="overflow-x: auto;">
      <div class="border-1 brc-grey-l1 bgc-white shadow-sm radius-2 pt-35 px-0 px-lg-4" style="min-width: 600px;">
        <div class="d-flex mb-4">
          <h4 class="text-secondary-d1 text-120 px-3 px-lg-0">Comportamiento de pagos</h4>
        </div>
        <div id="grafica_anuncios" class="text-center text-danger text-80"></div>
        <div id="graph-container"><canvas id="canvas" class="p-4"></canvas></div>

      </div>
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

      <script type="text/javascript" src="../ace-admin/node_modules/@fullcalendar/core/main.js"></script>
      <script type="text/javascript" src="../ace-admin/node_modules/@fullcalendar/daygrid/main.js"></script>
      <script type="text/javascript" src="../ace-admin/node_modules/@fullcalendar/timegrid/main.js"></script>


      <!-- include Ace script -->
      <script type="text/javascript" src="../ace-admin/dist/js/ace.js"></script>


      <script type="text/javascript" src="../ace-admin/assets/js/demo.js"></script>
      <!-- this is only for Ace's demo and you don't need it -->

      <!-- "Horizontal Menu" page script to enable its demo functionality -->
      <!--<script type="text/javascript" src="../ace-admin/application/views/default/pages/partials/horizontal-menu/@page-script.js"></script>-->
    </div><!-- /.body-container -->


<!--<script type="text/javascript" src="js/funciones_creditos.js"></script>-->
<script type="text/javascript" src="../js/funciones_cartera.js"></script>
<script type="text/javascript">

	$(document).ready(function(){
    var idkey_credito=$('#idkey_credito').val();
    detalle_credito(idkey_credito);
    progreso_credito(idkey_credito);//Si es mayor a 0 manda a graficar
	
  });
</script>

<?php
    create_footer_forms();
    ?>
</div>
</body>
</html>
