<?php
//Control de accesos: solo administrador, cajero y contador, supe de cajas
if($_SESSION["tipo_usuario"] != "1" && $_SESSION["tipo_usuario"] != "4" && $_SESSION["tipo_usuario"] != "5" && $_SESSION["tipo_usuario"] != "6" && $_SESSION["tipo_usuario"] != "2"){
  echo "<script> 
      alert('Usted no tiene permisos para acceder a este apartado!'); 
      window.location.href='../home.php'; </script>";
  exit(0);
}

function create_header()
{
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  
  <title>Creditos Prodeco</title>
  
  
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
    
  <!-- include common vendor stylesheets -->
  <link rel="stylesheet" type="text/css" href="../ace-admin/node_modules/bootstrap/dist/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="../ace-admin/node_modules/@fortawesome/fontawesome-free/css/fontawesome.css">
  <link rel="stylesheet" type="text/css" href="../ace-admin/node_modules/@fortawesome/fontawesome-free/css/regular.css">
  <link rel="stylesheet" type="text/css" href="../ace-admin/node_modules/@fortawesome/fontawesome-free/css/brands.css">
  <link rel="stylesheet" type="text/css" href="../ace-admin/node_modules/@fortawesome/fontawesome-free/css/solid.css">
  
  <!-- include vendor stylesheets used in "Bootstrap Table" page. see "application/views/default/pages/partials/table-bootstrap/@vendor-stylesheets.hbs" -->
  <link rel="stylesheet" type="text/css" href="../ace-admin/node_modules/bootstrap-table/dist/bootstrap-table.css">

  <!-- include vendor stylesheets used in "More Form Elements" page. see "application/views/default/pages/partials/form-elements-2/@vendor-stylesheets.hbs" -->
  <link rel="stylesheet" type="text/css" href="../ace-admin/node_modules/bootstrap-select/dist/css/bootstrap-select.css">
  <link rel="stylesheet" type="text/css" href="../ace-admin/node_modules/select2/dist/css/select2.css">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="../ace-admin/node_modules/bootstrap-duallistbox/dist/bootstrap-duallistbox.css">

  
  <link rel="stylesheet" type="text/css" href="../ace-admin/node_modules/chosen-js/chosen.css">
  
  <!-- estilos para wizard form -->
  <link rel="stylesheet" type="text/css" href="../ace-admin/node_modules/smartwizard/dist/css/smart_wizard.min.css">
  <link rel="stylesheet" type="text/css" href="../ace-admin/node_modules/smartwizard/dist/css/smart_wizard_theme_circles.min.css">
  
  <!-- include common vendor scripts used in demo pages -->
  <script type="text/javascript" src="../ace-admin/node_modules/jquery/dist/jquery.js"></script>
  <script type="text/javascript" src="../ace-admin/node_modules/popper.js/dist/umd/popper.js"></script>
  <script type="text/javascript" src="../ace-admin/node_modules/bootstrap/dist/js/bootstrap.js"></script>

  <!-- DATE PICKER Y JS -->
  <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
  
  <!-- include vendor stylesheets used in "DataTables" page. see "application/views/default/pages/partials/table-datatables/@vendor-stylesheets.hbs" -->
  <link rel="stylesheet" type="text/css" href="../ace-admin/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css">
  <link rel="stylesheet" type="text/css" href="../ace-admin/node_modules/datatables.net-buttons-bs4/css/buttons.bootstrap4.css">
  
  <!-- Funciones JS -->
  <script src="../js/default.js"></script>
  
  <!-- include vendor scripts used in "Wizard & Validation" page. see "application/views/default/pages/partials/form-wizard/@vendor-scripts.hbs" -->
  <script type="text/javascript" src="../ace-admin/node_modules/smartwizard/dist/js/jquery.smartWizard.js"></script>
  <script type="text/javascript" src="../ace-admin/node_modules/jquery-validation/dist/jquery.validate.js"></script>
  <script type="text/javascript" src="../ace-admin/node_modules/inputmask/dist/jquery.inputmask.js"></script>

  <!-- include Ace script -->
  <script type="text/javascript" src="../ace-admin/dist/js/ace.js"></script>
  <script type="text/javascript" src="../ace-admin/assets/js/demo.js"></script>
  <!-- this is only for Ace's demo and you don't need it -->

  <!-- "Wizard & Validation" page script to enable its demo functionality -->
  <script type="text/javascript" src="../ace-admin/application/views/default/pages/partials/form-wizard/@page-script.js"></script>
  
  <!-- include vendor stylesheets used in "Form Elements" page. see "application/views/default/pages/partials/form-elements/@vendor-stylesheets.hbs" -->
  <link rel="stylesheet" type="text/css" href="../ace-admin/node_modules/nouislider/distribute/nouislider.min.css">
  <link rel="stylesheet" type="text/css" href="../ace-admin/node_modules/ion-rangeslider/css/ion.rangeSlider.min.css">
  <link rel="stylesheet" type="text/css" href="../ace-admin/node_modules/tiny-date-picker/tiny-date-picker.css">
  <link rel="stylesheet" type="text/css" href="../ace-admin/node_modules/tiny-date-picker/date-range-picker.css">
  <link rel="stylesheet" type="text/css" href="../ace-admin/node_modules/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css">
  <link rel="stylesheet" type="text/css" href="../ace-admin/dist/css/ace-font.css">
  <link rel="stylesheet" type="text/css" href="../ace-admin/dist/css/ace.css">
  <link rel="icon" type="image/png" href="../styles/favicon.png">
  <!-- "Landing Page 1" page styles specific to this page for demo purposes -->
  <link rel="stylesheet" type="text/css" href="../ace-admin/dist/css/ace-themes.css">
  <script src="../ace-admin/bootbox/bootbox.min.js"></script>

  <link rel="stylesheet" type="text/css" href="../styles/styles.css">
  
</head>
<body>
<?php


}
function create_menu()
{
?>

<?php $actual  = $_SERVER['REQUEST_URI']; ?>
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
                  <?php if($actual == "/prodeco/facturacion/facturacion.php"){ ?>
                    <li class="breadcrumb-item text-dark-tp5"> <a class="text-dark-tp3" href="index.php">Facturaci&oacute;n</a></li>
                  <?php }?>
                 
                </ol>
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

                  <div class="dropdown-menu dropdown-caret dropdown-menu-right brc-success-m4" style="text-transform: uppercase;">
                    <div class="d-none d-lg-block">
                      <div class="dropdown-header">
                      Bienvenido <?php echo $_SESSION['nombre']; ?>
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