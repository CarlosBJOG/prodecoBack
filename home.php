<?php
  require_once "php/security_home.php";    
  require_once "php/header_home.php";
  require_once "php/accesos_home.php";
  create_header();
  create_menu();
  begin_containers();


?>


<div class="container container-plus pos-rel">
  <div class="row">

  <?php if($_SESSION["tipo_usuario"] == "4" ) { ?>
      <div class="col-12 col-sm-12 col-lg-3 my-1 my-lg-0 px-sm-1 px-lg-0">
            <figure class="mx-auto text-center">
              <img src="./styles/ilustracion-cartera.png" width="300">
            </figure>
            <h1 class="text-grey-d2 pb-0 mb-3 mb-md-0 text-center">Cajas</h1>
             <hr>
             <h5 class="text-grey-d2 pb-0 mb-3 mb-md-0 text-center">Módulo de operaciones de ingreso y egreso de capital</h5>
            <p class="text-100 text-secondary text-center">
             <!-- -->
            </p>
      </div>
      
  <?php } else if($_SESSION["tipo_usuario"] == 5){ ?>

    <div class="col-12 col-sm-12 col-lg-3 my-1 my-lg-0 px-sm-1 px-lg-0">
            <figure class="mx-auto text-center">
              <img src="./styles/contabilidad.jpg" width="300">
            </figure>
            <h1 class="text-grey-d2 pb-0 mb-3 mb-md-0 text-center">Contabilidad</h1>
             <hr>
             <h5 class="text-grey-d2 pb-0 mb-3 mb-md-0 text-center">Módulo de Polizas, Facturacion y Balances.</h5>
            <p class="text-100 text-secondary text-center">
             <!-- -->
            </p>
      </div>

  <?php }else if ($_SESSION["tipo_usuario"] == 1){  ?>

    <div class="col-12 col-md-4">
      <div class="pos-rel d-flex flex-column py-3 px-lg-3 justify-content-center align-items-center">
        <div class="pos-rel mt-3">
            <img src="./styles/admin.jpg" width="300"  alt="prodeco" class="d-none d-lg-block">
        </div>
        <hr class="w-90 mx-auto border-dotted d-none d-lg-block">
        
      </div><!-- .d-flex -->
    </div><!-- .col -->

  <?php }else { ?>
    <div class="col-12 col-md-4">
      <div class="pos-rel d-flex flex-column py-3 px-lg-3 justify-content-center align-items-center">
        <div class="pos-rel mt-3">
            <img src="./styles/logo.png" width="300"  alt="prodeco" class="d-none d-lg-block">
        </div>
        <hr class="w-90 mx-auto border-dotted d-none d-lg-block">
        <img src="./styles/ilustracion-credito.png" width="300"  alt="prodeco" class="d-none d-lg-block">
        
      </div><!-- .d-flex -->
    </div><!-- .col -->
  <?php } ?>
  
  
    <div class="col-12 col-md-8 1bgc-default-l4  radius-1 pos-rel p-5 mt-n25">
        
        <div class="row mt-n25 pb-5">

          <div <?php echo $cartera; ?> class="col-12 col-md-4 mb-4 mt-sm-2" data-aos="fade-up" data-aos-delay="300">
            <div class="radius-2 shadow-1 py-4 px-4 h-100" style="background-color: <?php echo $_SESSION["color"]; ?>;">
              <a href="./cartera/" class="text-white" style="text-decoration:none">
                <div class="d-inline-block pos-rel text-center py-2 px-3 text-150">
                  <div class="brc-warning-l5 border-2 w-3 h-3 radius-round position-tl mt-2 ml-n1"></div>
                  <div class="brc-warning-l5 border-2 w-2 h-2 radius-round position-tr mt-n1 ml-n1"></div>
                  <div class="brc-warning-l5 border-2 w-4 h-4 radius-round position-br mb-2"></div>
                  <i class="fa fa-address-card fa-2x text-white pos-rel"></i>
                </div>
                <h3 class="text-white text-160 my-3">Cartera</h3>
                <p class="mt-n25">
                  Módulo de alta de clientes y créditos individual y grupal.
                </p>
              </a>
            </div>
          </div>

          <div <?php echo $seguimiento; ?> class="col-12 col-md-4 mb-4 mt-sm-2" data-aos="fade-up" data-aos-delay="450">
            <div class="radius-2 shadow-1 py-4 px-4 h-100" style="background-color: <?php echo $_SESSION["color"]; ?>;">
              <a href="seguimiento/index.php" class="text-white" style="text-decoration:none">
                <div class="d-inline-block pos-rel text-center p-2 text-150">
                  <div class="brc-warning-l5 border-2 w-3 h-3 radius-round position-tl mt-2 ml-n1"></div>
                  <div class="brc-warning-l5 border-2 w-2 h-2 radius-round position-tr mt-n1 ml-n1"></div>
                  <div class="brc-warning-l5 border-2 w-4 h-4 radius-round position-br mb-2"></div>

                  <i class="fa fa-cogs fa-2x text-white pos-rel"></i>
                </div>
                <h3 class="text-white text-160 my-3">Seguimiento</h3>
                <p class="mt-n25">Módulo de supervisión en la continuidad de los créditos.</p>
              </a>
            </div>
          </div>


          <div <?php echo $caja; ?> class="col-12 col-md-4 mb-4 mt-sm-2" data-aos="fade-up" data-aos-delay="600">
            <div class="radius-2 shadow-1 py-4 px-4 h-100" style="background-color: <?php echo $_SESSION["color"]; ?>;">
              <a href="caja/index.php" class="text-white" style="text-decoration:none">
                <div class="d-inline-block text-center p-2 text-150 pos-rel">
                  <div class="brc-warning-l5 border-2 w-3 h-3 radius-round position-tl mt-2 ml-n1"></div>
                  <div class="brc-warning-l5 border-2 w-2 h-2 radius-round position-tr mt-n1 ml-n1"></div>
                  <div class="brc-warning-l5 border-2 w-4 h-4 radius-round position-br mb-2"></div>
                  <i class="fa fa-cash-register fa-2x text-white pos-rel"></i>
                </div>
                <h3 class="text-white text-160 my-3">Cartera Vigente</h3>
                <p class="mt-n25"> Control de los procesos correspondientes a los créditos vigentes.</p>
              </a>
            </div>
          </div>


          <div <?php echo $ingresos; ?> class="col-12 col-md-4 mb-4 mt-sm-2" data-aos="fade-up" data-aos-delay="450">
            <div class="radius-2 shadow-1 py-4 px-4 h-100" style="background-color: <?php echo $_SESSION["color"]; ?>;">
              <a href="ingresos/index.php" class="text-white" style="text-decoration:none">
                <div class="d-inline-block pos-rel text-center p-2 text-150">
                  <div class="brc-warning-l5 border-2 w-3 h-3 radius-round position-tl mt-2 ml-n1"></div>
                  <div class="brc-warning-l5 border-2 w-2 h-2 radius-round position-tr mt-n1 ml-n1"></div>
                  <div class="brc-warning-l5 border-2 w-4 h-4 radius-round position-br mb-2"></div>

                  <i class="fa fa-plus fa-3x text-white pos-rel"></i>
                </div>
                <h3 class="text-white text-160 my-3">Ingresos Crédito</h3>
                <p class="mt-n25">Aplicación del ingreso de dinero.</p>
              </a>
            </div>
          </div>

          <div <?php echo $garantiasyseguros; ?> class="col-12 col-md-4 mb-4 mt-sm-2" data-aos="fade-up" data-aos-delay="450">
            <div class="radius-2 shadow-1 py-4 px-4 h-100" style="background-color: <?php echo $_SESSION["color"]; ?>;">
              <a href="garantiasyseguros/index.php" class="text-white" style="text-decoration:none">
                <div class="d-inline-block pos-rel text-center p-2 text-150">
                  <div class="brc-warning-l5 border-2 w-3 h-3 radius-round position-tl mt-2 ml-n1"></div>
                  <div class="brc-warning-l5 border-2 w-2 h-2 radius-round position-tr mt-n1 ml-n1"></div>
                  <div class="brc-warning-l5 border-2 w-4 h-4 radius-round position-br mb-2"></div>
                  <i><img src="./styles/masmenos.png" style="width: 80px;" alt=""></i>
                </div>     
                <h3 class="text-white text-160 my-3">Garantías y Seguros</h3>
                <p class="mt-n25">Ingresos y egresos de garantias y seguros.</p>
              </a>
            </div>
          </div>

          <div <?php echo $c_vencidos; ?> class="col-12 col-md-4 mb-4 mt-sm-2" data-aos="fade-up" data-aos-delay="450">
            <div class="radius-2 shadow-1 py-4 px-4 h-100" style="background-color: <?php echo $_SESSION["color"]; ?>;">
              <a href="c_vencidos/index.php" class="text-white" style="text-decoration:none">
                <div class="d-inline-block pos-rel text-center p-2 text-150">
                  <div class="brc-warning-l5 border-2 w-3 h-3 radius-round position-tl mt-2 ml-n1"></div>
                  <div class="brc-warning-l5 border-2 w-2 h-2 radius-round position-tr mt-n1 ml-n1"></div>
                  <div class="brc-warning-l5 border-2 w-4 h-4 radius-round position-br mb-2"></div>

                  <i class="fa fa-minus fa-3x text-white pos-rel"></i>
                </div>
                <h3 class="text-white text-160 my-3">Creditos Vencidos</h3>
                <p class="mt-n25">Renovacion, condonacion, reestructuracion y castigo de creditos.</p>
              </a>
            </div>
          </div>
 

          <div <?php echo $contabilidad; ?> class="col-12 col-md-4 mb-4 mt-sm-2" data-aos="fade-up" data-aos-delay="600">
            <div class="radius-2 shadow-1 py-4 px-4 h-100" style="background-color: <?php echo $_SESSION["color"]; ?>;">
              <a href="contabilidad/index.php" class="text-white" style="text-decoration:none">
                <div class="d-inline-block text-center p-2 text-150 pos-rel">
                  <div class="brc-warning-l5 border-2 w-3 h-3 radius-round position-tl mt-2 ml-n1"></div>
                  <div class="brc-warning-l5 border-2 w-2 h-2 radius-round position-tr mt-n1 ml-n1"></div>
                  <div class="brc-warning-l5 border-2 w-4 h-4 radius-round position-br mb-2"></div>
                  <i class="fa fa-money fa-2x text-white pos-rel"></i>
                </div>
                <h3 class="text-white text-160 my-3">P&oacute;lizas</h3>
                <p class="mt-n25">Créditos / General.</p>
              </a>
            </div>
          </div>

          <div <?php echo $balance; ?> class="col-12 col-md-4 mb-4 mt-sm-2" data-aos="fade-up" data-aos-delay="600">
            <div class="radius-2 shadow-1 py-4 px-4 h-100" style="background-color: <?php echo $_SESSION["color"]; ?>;">
              <a href="balance/index.php" class="text-white" style="text-decoration:none">
                <div class="d-inline-block text-center p-2 text-150 pos-rel">
                  <div class="brc-warning-l5 border-2 w-3 h-3 radius-round position-tl mt-2 ml-n1"></div>
                  <div class="brc-warning-l5 border-2 w-2 h-2 radius-round position-tr mt-n1 ml-n1"></div>
                  <div class="brc-warning-l5 border-2 w-4 h-4 radius-round position-br mb-2"></div>
                  <i class="fas fa-balance-scale-right fa-2x text-white pos-rel"></i>
                </div>
                <h3 class="text-white text-160 my-3">Balance</h3>
                <p class="mt-n25">.</p>
              </a>
            </div>
          </div>
         
          
          <div <?php echo $facturacion; ?> class="col-12 col-md-4 mb-4 mt-sm-2" data-aos="fade-up" data-aos-delay="600">
            <div class="radius-2 shadow-1 py-4 px-4 h-100" style="background-color: <?php echo $_SESSION["color"]; ?>;">
              <a href="facturacion/index.php" class="text-white" style="text-decoration:none">
                <div class="d-inline-block text-center p-2 text-150 pos-rel">
                  <div class="brc-warning-l5 border-2 w-3 h-3 radius-round position-tl mt-2 ml-n1"></div>
                  <div class="brc-warning-l5 border-2 w-2 h-2 radius-round position-tr mt-n1 ml-n1"></div>
                  <div class="brc-warning-l5 border-2 w-4 h-4 radius-round position-br mb-2"></div>
                  <i class="fas fa-file-alt fa-2x text-white pos-rel"></i>
                </div>
                <h3 class="text-white text-160 my-3">Facturación</h3>
                <p class="mt-n25">M&oacute;dulo de b&uacute;squeda de informaci&oacute;n de pagos y cr&eacute;ditos.</p>
              </a>
            </div>
          </div>

          <div <?php echo $cortes_caja; ?> class="col-12 col-md-4 mb-4 mt-sm-2" data-aos="fade-up" data-aos-delay="600">
            <div class="radius-2 shadow-1 py-4 px-4 h-100" style="background-color: <?php echo $_SESSION["color"]; ?>;">
              <a href="corte/corte_caja.php" class="text-white" style="text-decoration:none">
                <div class="d-inline-block text-center p-2 text-150 pos-rel">
                  <div class="brc-warning-l5 border-2 w-3 h-3 radius-round position-tl mt-2 ml-n1"></div>
                  <div class="brc-warning-l5 border-2 w-2 h-2 radius-round position-tr mt-n1 ml-n1"></div>
                  <div class="brc-warning-l5 border-2 w-4 h-4 radius-round position-br mb-2"></div>
                  <i class="fas fa-file-alt fa-2x text-white pos-rel"></i>
                </div>
                <h3 class="text-white text-160 my-3">Corte de Cajas</h3>
                <p class="mt-n25">Control del ingreso de dinero en efectivo.</p>
              </a>
            </div>
          </div>

          
          <div <?php echo $reportes; ?> class="col-12 col-md-4 mb-4 mt-sm-2" data-aos="fade-up" data-aos-delay="600">
            <div class="radius-2 shadow-1 py-4 px-4 h-100" style="background-color: <?php echo $_SESSION["color"]; ?>;">
              <a href="reportes/reportesGenerales.php" class="text-white" style="text-decoration:none">
                <div class="d-inline-block text-center p-2 text-150 pos-rel">
                  <div class="brc-warning-l5 border-2 w-3 h-3 radius-round position-tl mt-2 ml-n1"></div>
                  <div class="brc-warning-l5 border-2 w-2 h-2 radius-round position-tr mt-n1 ml-n1"></div>
                  <div class="brc-warning-l5 border-2 w-4 h-4 radius-round position-br mb-2"></div>
                  <i class="fas fa-id-card fa-2x text-white pos-rel"></i>
                </div>
                <h3 class="text-white text-160 my-3">Reportes</h3>
                <p class="mt-n25">Reportes de cartera general.</p>
              </a>
            </div>
          </div>
 
          
          <div <?php echo $administracion; ?> class="col-12 col-md-4 mb-4 mt-sm-2" data-aos="fade-up" data-aos-delay="600">
            <div class="radius-2 shadow-1 py-4 px-4 h-100" style="background-color: <?php echo $_SESSION["color"]; ?>;">
              <a href="admin/index.php" class="text-white" style="text-decoration:none">
                <div class="d-inline-block text-center p-2 text-150 pos-rel">
                  <div class="brc-warning-l5 border-2 w-3 h-3 radius-round position-tl mt-2 ml-n1"></div>
                  <div class="brc-warning-l5 border-2 w-2 h-2 radius-round position-tr mt-n1 ml-n1"></div>
                  <div class="brc-warning-l5 border-2 w-4 h-4 radius-round position-br mb-2"></div>
                  <i class="fa fa-wrench fa-2x text-white pos-rel"></i>
                </div>
                <h3 class="text-white text-160 my-3">Administración</h3>
                <p class="mt-n25">Módulo de administración del sistema.</p>
              </a>
            </div>
          </div>

        </div>
    </div>


  </div> <!-- row -->
</div>



<?php 
    end_containers();
?>

<?php
    create_footer();
?>

      <!-- include common vendor scripts used in demo pages -->
      <script type="text/javascript" src="./ace-admin/node_modules/jquery/dist/jquery.js"></script>
      <script type="text/javascript" src="./ace-admin/node_modules/popper.js/dist/umd/popper.js"></script>
      <script type="text/javascript" src="./ace-admin/node_modules/bootstrap/dist/js/bootstrap.js"></script>


      <!-- include Ace script -->
      <script type="text/javascript" src="./ace-admin/dist/js/ace.js"></script>


      <script type="text/javascript" src="./ace-admin/assets/js/demo.js"></script>
      <!-- this is only for Ace's demo and you don't need it -->

      <!-- "Horizontal Menu" page script to enable its demo functionality -->
      <script type="text/javascript" src="./ace-admin/application/views/default/pages/partials/horizontal-menu/@page-script.js"></script>
    </div><!-- /.body-container -->


  </body>
</html>
