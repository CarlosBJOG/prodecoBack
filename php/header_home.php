<?php

function create_header()
{
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>        
	<link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
	<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/v4-shims.css">
	<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
	<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
	<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css"/>
	
	
	<title>Creditos Prodeco</title>
	<!-- include common vendor stylesheets -->
	<link rel="stylesheet" type="text/css" href="./ace-admin/node_modules/bootstrap/dist/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="./ace-admin/node_modules/@fortawesome/fontawesome-free/css/fontawesome.css">
	<link rel="stylesheet" type="text/css" href="./ace-admin/node_modules/@fortawesome/fontawesome-free/css/regular.css">
	<link rel="stylesheet" type="text/css" href="./ace-admin/node_modules/@fortawesome/fontawesome-free/css/brands.css">
	<link rel="stylesheet" type="text/css" href="./ace-admin/node_modules/@fortawesome/fontawesome-free/css/solid.css">
	<!-- include vendor stylesheets used in "Landing Page 1" page. see "application/views/default/pages/partials/landing-page-1/@vendor-stylesheets.hbs" -->

	<link rel="stylesheet" type="text/css" href="./ace-admin/dist/css/ace-font.css">
	<link rel="stylesheet" type="text/css" href="./ace-admin/dist/css/ace.css">
	<link rel="icon" type="image/png" href="./styles/favicon.png"/>
	<!-- "Landing Page 1" page styles specific to this page for demo purposes -->
	<link rel="stylesheet" type="text/css" href="./ace-admin/dist/css/ace-themes.css">
</head>
<body>
<?php
}
function create_menu()
{
?>
<div class="body-container">
      <div class="pos-abs" id="scroll-down"></div>
      <div class="pos-abs" id="scroll-up"></div>
<header>
<!-- <div class="body-container"> -->
<nav class="navbar navbar-sm navbar-fixed-sm navbar-expand-lg navbar-fixed" style="background-color: <?php echo $_SESSION["color"]; ?>20;">
<!--<nav class="navbar navbar-expand-lg navbar-white2">-->
        <div class="navbar-inner brc-grey-l3">
          <div class="container">

            <div class="navbar-intro justify-content-xl-start bg-transparent border-0 w-auto mr-lg-3">
              <a class="navbar-brand text-dark-tp3 text-180" href="home.php">
              <img src="./styles/logo.png" width="140" height="50" alt="">
              </a>
            </div> <!-- /.navbar-intro -->
            <!-- /.navbar-intro -->


            <!-- mobile #navbarMenu toggler button -->
            <button type="button" class="d-style mr-2 px-4 navbar-toggler btn btn-burger static collapsed d-flex d-lg-none" data-toggle="collapse" data-target="#navbarMenu" aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navbar menu">
              <i class="fa fa-caret-down d-collapsed text-grey-m1 text-80"></i>
              <i class="fa fa-caret-up d-n-collapsed text-grey-m1 text-80"></i>
              <i class="fa fa-user text-orange-d1 ml-2"></i>
            </button>
            <!-- mobile navbar toggler button -->
            
            <div class="navbar-menu collapse navbar-collapse navbar-backdrop" id="navbarMenu">
              <div class="navbar-nav">
              <ul class="nav nav-compact has-active-border">


                  <li class="nav-item dropdown order-first order-lg-last dropdown-hover">
                  <a class="nav-link dropdown-toggle px-lg-2 ml-lg-3" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <img id="id-navbar-user-image" class="d-none d-lg-inline-block radius-3px mr-1 brc-grey-m2 border-1" src="./styles/<?php echo $_SESSION["imagen"]; ?>" height="42" alt="Jason's Photo">
                    <span class="d-inline-block d-lg-none">Bienvenido! <?php echo $_SESSION['usuario_nombre']; ?> </span><!-- show only on mobile -->
                    <i class="caret fa fa-ellipsis-v d-none d-xl-block"></i>
                    <i class="caret fa fa-angle-left d-block d-lg-none"></i>
                  </a>

                  <div class="dropdown-menu dropdown-caret dropdown-menu-right brc-success-m4">
                    <div class="d-none d-lg-block">
                      <div class="dropdown-header">
                      Bienvenido <?php echo $_SESSION['usuario_nombre']; ?>
                      </div>
                      <div class="dropdown-divider"></div>
                    </div>
                    <a class="dropdown-item btn btn-outline-grey btn-h-lighter-success btn-a-lighter-success" href="./perfiles/perfil.php">
                        <i class="fa fa-user text-success-m1 text-105 mr-1"></i>
                        Perfil
                    </a>
                    <a class="dropdown-item btn btn-outline-grey btn-h-lighter-secondary btn-a-lighter-secondary" href="logout.php">
                      <i class="fa fa-power-off text-warning-d1 text-105 mr-1"></i>
                      Salir
                    </a>
                    </div>
                  </li><!-- /.nav-item:last -->
                  <!--Fin de Acceso Logueado-->
                </ul>
              </div> <!-- / navbar-nav -->
            </div> <!-- / navbar-menu -->
          </div> <!-- /container -->
        </div> <!-- /navbar-inner -->
      </nav>
    </header>
<?php
}
function begin_containers()
{
?>
<main role="main">
<!--<div class="container">-->
<div class="row">
	<div class="col-12">
		<div class="row justify-content-center">
			
			<?php
			}
			function end_containers()
			{
			?>
			
		</div>
	</div>
</div>
<!--</div>-->
</main>
<?php
}
?>

<?php
function create_footer()
{
  require "php/accesos_home.php";
?>
<footer>
            <div class="footer h-auto text-light" style="background-color: <?php echo $_SESSION["color"]; ?>;">
              <div class="footer-inner py-45">
                <div class="container container-plus" data-aos="fade">
                  <div class="row">
                    <div class="col-12 col-lg-5">
                      <img src="./styles/logo.png" width="140" height="50" alt="">
                      
                      <p class="text-100 mt-2">
                      PRODECO es una Sociedad autónoma, constituida <br/>de acuerdo a las leyes civiles mexicanas.
                      </p>

                    </div>

                    <div class="col-12 col-lg-7 mt-5 mt-lg-0">
                      <div class="row text-center text-lg-left">
                   

                        <div class="col-3">
                          <h6 class="text-light-tp2 text-95 text-600 mb-3">SERVICIOS</h6>
                          <div>
                            <div>
                              <a <?php echo $cartera; ?> href="cartera/index.php" class="text-white-tp4">
                              Cartera</a>
                            </div>
                            <div>
                              <a <?php echo $seguimiento; ?> href="seguimiento/index.php" class="text-white-tp4">Seguimiento</a>
                            </div>
                            <div>
                              <a <?php echo $caja; ?> href="caja/index.php" class="text-white-tp4">Caja</a>
                            </div>
                            <div>
                              <a <?php echo $facturacion; ?> href="#" class="text-white-tp4">Facturación</a>
                            </div>
                            <div>
                              <a <?php echo $contabilidad; ?> href="contabilidad/index.php" class="text-white-tp4">Contabilidad</a>
                            </div>
                            <div>
                              <a <?php echo $administracion; ?> href="admin/index.php" class="text-white-tp4">Administración</a>
                            </div>
                          </div>
                        </div>

                        <div class="col-5">
                          <h6 class="text-light-tp2 text-95 text-600 mb-3">CONTACTO</h6>
                          <div>
                            <span class="text-white-tp4">contacto@prodeco.mx<br />
                            Tel: (954) 688 4079, 688 4088<br />
                            <span class="text-80">Calle Principal SN, Barra de Navidad
                            Santa Maria Colotepec, Pochutla, Oaxaca C.P. 70938</span> </span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        <!--FIN FOOTER-->

        <!--INICIO SUBFOOTER-->
            <div class="text-center py-4 border-t-1 brc-default-l3" style="background-color: <?php echo $_SESSION["color"]; ?>20;">
                <span class="text-dark-tp3">
                    2020 &copy; <span class="text-lg" style="color:<?php echo $_SESSION["color"]; ?>">Prodeco</span>
                 </span>
            </div>
        <!--INICIO SUBFOOTER-->    
        
        </footer>
        
      <script type="text/javascript" src="./ace-admin/node_modules/jquery/dist/jquery.js"></script>
      <script type="text/javascript" src="./ace-admin/node_modules/popper.js/dist/umd/popper.js"></script>
      <script type="text/javascript" src="./ace-admin/node_modules/bootstrap/dist/js/bootstrap.js"></script>


      <!-- include vendor scripts used in "Landing Page 1" page. see "application/views/default/pages/partials/landing-page-1/@vendor-scripts.hbs" -->
      <script type="text/javascript" src="./ace-admin/node_modules/aos/dist/aos.js"></script>
      <script type="text/javascript" src="./ace-admin/node_modules/holderjs/holder.js"></script>

      <!-- include Ace script -->
      <script type="text/javascript" src="./ace-admin/dist/js/ace.js"></script>


      <script type="text/javascript" src="./ace-admin/assets/js/demo.js"></script>
      <!-- this is only for Ace's demo and you don't need it -->
      <!-- "Horizontal Menu" page script to enable its demo functionality -->
      <script type="text/javascript" src="./ace-admin/application/views/default/pages/partials/horizontal-menu/@page-script.js"></script>
      
      <!-- "Landing Page 1" page script to enable its demo functionality -->
      <script type="text/javascript" src="./ace-admin/application/views/default/pages/partials/landing-page-1/@page-script.js"></script>
        <?php
} ?>
