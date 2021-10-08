<?php


function create_header()
{
?>

<!-- ///////// -->
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
	
	
	<title>Créditos Prodeco</title>
	<!-- include common vendor stylesheets -->
	<link rel="stylesheet" type="text/css" href="../ace-admin/node_modules/bootstrap/dist/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="../ace-admin/node_modules/@fortawesome/fontawesome-free/css/fontawesome.css">
	<link rel="stylesheet" type="text/css" href="../ace-admin/node_modules/@fortawesome/fontawesome-free/css/regular.css">
	<link rel="stylesheet" type="text/css" href="../ace-admin/node_modules/@fortawesome/fontawesome-free/css/brands.css">
	<link rel="stylesheet" type="text/css" href="../ace-admin/node_modules/@fortawesome/fontawesome-free/css/solid.css">
	<!-- include vendor stylesheets used in "Landing Page 1" page. see "application/views/default/pages/partials/landing-page-1/@vendor-stylesheets.hbs" -->

	<link rel="stylesheet" type="text/css" href="../ace-admin/dist/css/ace-font.css">
	<link rel="stylesheet" type="text/css" href="../ace-admin/dist/css/ace.css">
	<link rel="icon" type="image/png" href="../styles/favicon.png"/>
	<!-- "Landing Page 1" page styles specific to this page for demo purposes -->
	<link rel="stylesheet" type="text/css" href="../ace-admin/dist/css/ace-themes.css">

  <!-- include vendor stylesheets used in "DataTables" page. see "application/views/default/pages/partials/table-datatables/@vendor-stylesheets.hbs" -->
  <link rel="stylesheet" type="text/css" href="../ace-admin/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css">
  <link rel="stylesheet" type="text/css" href="../ace-admin/node_modules/datatables.net-buttons-bs4/css/buttons.bootstrap4.css">
  
	

</head>
<body>
<!-- ///////// -->
<?php
}
function create_menu()
{
?>
<!-- ///////// -->
<?php $actual  = $_SERVER['REQUEST_URI']; ?>
<!-- ///////// -->
<div class="body-container">
      <div class="pos-abs" id="scroll-down"></div>
      <div class="pos-abs" id="scroll-up"></div>
      <header>
      <nav class="navbar navbar-sm navbar-fixed-sm navbar-expand-lg navbar-fixed" style="background-color: <?php echo $_SESSION["color"]; ?>20;">
        <div class="navbar-inner">
          <div class="container container-plus">

            <div class="navbar-intro justify-content-xl-start bg-transparent border-0 w-auto mr-lg-3">
              <a class="navbar-brand text-dark-tp3 text-180" href="../home.php">
                <img src="../styles/logo.png" width="140" height="50" alt="">
              </a><!-- /.navbar-brand -->
            </div><!-- /.navbar-intro -->

            <div class="navbar-content d-none d-xl-flex border-l-1 brc-grey-l3">
                <ol class="breadcrumb pl-2 ml-3">
                  <li class="breadcrumb-item"><a class="text-dark-tp3" href="../home.php">Inicio</a></li>
                  <li class="breadcrumb-item text-dark-tp5"> <a class="text-dark-tp3" href="index.php">Perfil</a></li>
                  <!-- <?php if($actual == "/prodeco/admin/empleados_busqueda.php"){ ?>
                    <li class="breadcrumb-item text-dark-tp5"> <a class="text-dark-tp3" href="#">Informaci&oacute;n de empleados</a></li>
                  <?php }else if($actual == "/prodeco/admin/alta_empleados.php"){ ?>
                    <li class="breadcrumb-item text-dark-tp5"> <a class="text-dark-tp3" href="#">Nuevo Empleado</a></li>
                    <?php }else if($actual == "/prodeco/admin/bitacoras_creditos.php"){?>
                      <li class="breadcrumb-item text-dark-tp5"> <a class="text-dark-tp3" href="#">Bit&aacute;coras Cr&eacute;ditos</a></li>
                      <?php } ?>
                     -->
                </ol>
            </div>

            <div class="d-inline-flex align-items-center input-floating-label brc-success-m1 px-lg-0">
            <!--<div class="page-tools mt-3 mt-sm-0 mb-sm-n1 align-self-end"></div>--><!-- Nueva caja de busqueda-->
                <!--<i class="fa fa-search text-success-d1 mr-n3"></i>
                <input type="text" class="form-control text-success-d2 border-none border-b-2 radius-0 shadow-none bgc-transparent pl-35 mr-1" placeholder="Búsqueda ...">-->
            </div>

            <!-- mobile #navbarMenu toggler button -->
            <button type="button" class="d-style mr-2 px-4 navbar-toggler btn btn-burger static collapsed d-flex d-lg-none" data-toggle="collapse" data-target="#navbarMenu" aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navbar menu">
           
        <!--   <button class="navbar-toggler ml-1 mr-2 px-1" type="button" data-toggle="collapse" data-target="#navbarMenu" aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navbar menu"> --> 
                <i class="fa fa-caret-down d-collapsed text-grey-m1 text-80"></i>
                <i class="fa fa-caret-up d-n-collapsed text-grey-m1 text-80"></i>
                <i class="fa fa-user text-orange-d1 ml-2"></i>
            </button>

            <div class="navbar-menu collapse navbar-collapse navbar-backdrop" id="navbarMenu">
              <div class="navbar-nav">
                <ul class="nav nav-compact has-active-border">
         


                  <li class="nav-item dropdown order-first order-lg-last dropdown-hover">
                  <a class="nav-link dropdown-toggle px-lg-2 ml-lg-3" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <img id="id-navbar-user-image" class="d-none d-lg-inline-block radius-3px mr-1 brc-grey-m2 border-1" src="../styles/<?php echo $_SESSION["imagen"]; ?>" height="42" alt="Jason's Photo">
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
                    <a class="dropdown-item btn btn-outline-grey btn-h-lighter-success btn-a-lighter-success" href="../perfiles/perfil.php">
                        <i class="fa fa-user text-success-m1 text-105 mr-1"></i>
                        Perfil
                    </a>
                    <a class="dropdown-item btn btn-outline-grey btn-h-lighter-secondary btn-a-lighter-secondary" href="../logout.php">
                      <i class="fa fa-power-off text-warning-d1 text-105 mr-1"></i>
                      Salir
                    </a>
                    </div>
                  </li><!-- /.nav-item:last -->

                </ul><!-- /.navbar-nav menu -->
              </div><!-- /.navbar-nav -->

            </div><!-- /.navbar-menu.navbar-collapse -->

          </div>
        </div><!-- /.navbar-inner -->
      </nav>
    </header>
<?php
}
function begin_containers()
{
?>


      <main role="main">
<div class="container">
  <div class="row">
    <div class="col-12">
      <div class="row justify-content-center">
        <div class="container py-3">
			
			<?php
			}
			function end_containers()
			{
			?>
      <!-- ///////// -->
			
		</div>
	</div>
</div>
<!--</div>-->
</main>
<!-- ///////// -->
<?php
}
?>
<!-- ///////// -->
<?php
function create_footer()
{
?>

          <footer class="footer d-none d-sm-block mt-0" style="background-color: <?php echo $_SESSION["color"]; ?>20;">
            <div class="footer-inner">
              <div class="pt-3 border-none border-t-3 brc-grey-l1">
                <span class="font-bolder text-100" style="color:<?php echo $_SESSION["color"]; ?>">PRODECO</span>
                <span class="text-muted"> &copy; 2020</span>
              </div>
            </div><!-- .footer-inner -->

            <div class="footer-tools">
              <a id="btn-scroll-up" href="#" class="btn-scroll-up btn btn-dark btn-smd mb-2 mr-2">
                <i class="fa fa-angle-double-up mx-1"></i>
              </a>
            </div>
          </footer>
<?php } ?>