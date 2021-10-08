<?php

    require_once "../php/security.php";    
    require_once "../php/header_admin.php";
    create_header();
    create_menu();
    begin_containers();
?>


<div class="container container-plus pos-rel">
              <div class="row">
                
                <div class="col-12 col-md-4">
                  <div class="pos-rel d-flex flex-column py-3 px-lg-3 justify-content-center align-items-center">
                    <div class="pos-rel mt-3">
                    <figure class="mx-auto text-center">
                    <img src="../styles/administracion.jpg" style=" border-radius:150px; " width="250">
                    </figure>
                        <h1 class="text-grey-d2 pb-0 mb-3 mb-md-0 text-center">
                            Administrador
                        </h1>
                        <hr>
                    </div>
                    <hr class="w-90 mx-auto border-dotted d-none d-lg-block">
                   
                  </div><!-- .d-flex -->
  
                  
                </div><!-- .col -->
  
  
  
                <div class="col-12 col-md-8 1bgc-default-l4  radius-1 pos-rel p-5 mt-n25">

                    <div class="row my-2">
            

                        <!-- inicio card-->
                        <div class="col-12 col-sm-6 col-lg-6 my-1 px-sm-1 mt-3">
                            <div class="pos-rel py-4 radius-2 c-pointer" style="background-color: <?php echo $_SESSION["color"]; ?>;">
                            <a href="empleados_busqueda.php" class="text-white" style="text-decoration:none">
                            <span class="opacity-4 position-rc mr-2 d-none">
                                <i class="mr-3 mt-n2 fa fa-search text-dark-tp5 opacity-4 w-5 h-5 text-center pt-1 radius-round fa-5x"></i>
                                </span>
                            <div class="d-flex align-items-center">
                                <div class="pos-rel p-3 bgc-white-tp8 radius-round ml-3 mr-3 shadow-md">
                                <i class="pos-abs mt-n2px ml-n3px fa fa-search text-dark-tp5 opacity-4 w-5 h-5 text-center pt-1 radius-round text-170"></i>
                                <i class="pos-rel fa fa-search text-white w-5 h-5 text-center pt-1 radius-round text-170"></i>
                                </div>

                                <div class="text-white pl-4 text-uppercase text-130 text-600 letter-spacing">
                                    Informaci&oacute;n de empleados
                                </div> 
                            </div>
                            </a>
                            </div>
                        </div>
                        <!--fin-->

                                    <!-- inicio card-->
                                    <div class="col-12 col-sm-6 col-lg-6 my-1 px-sm-1 mt-3">
                            <div class="pos-rel py-4 radius-2 c-pointer" style="background-color: <?php echo $_SESSION["color"]; ?>;">
                            <a href="alta_empleados.php" class="text-white" style="text-decoration:none">
                            <span class="opacity-4 position-rc mr-2 d-none">
                                <i class="mr-3 mt-n2 fa fa-user-circle-o text-dark-tp5 opacity-4 w-5 h-5 text-center pt-1 radius-round fa-5x"></i>
                                </span>
                            <div class="d-flex align-items-center">
                                <div class="pos-rel p-3 bgc-white-tp8 radius-round ml-3 mr-3 shadow-md">
                                <i class="pos-abs mt-n2px ml-n3px fa fa-user-circle-o text-dark-tp5 opacity-4 w-5 h-5 text-center pt-1 radius-round text-170"></i>
                                <i class="pos-rel fa fa-user-circle-o text-white w-5 h-5 text-center pt-1 radius-round text-170"></i>
                                </div>

                                <div class="text-white pl-4 text-uppercase text-130 text-600 letter-spacing">
                                Alta de Empleado
                                </div> 
                            </div>
                            </a>
                            </div>
                        </div>
                        <!--fin-->
          
                    </div>

                    <div class="row my-2 ">
            
          
                    </div>

                    <div class="row my-2 ">
            
                         <!-- inicio card-->
                        <div class="col-12 col-sm-6 col-lg-6 my-1 px-sm-1 mt-3">
                            <div class="pos-rel py-4 radius-2 c-pointer" style="background-color: <?php echo $_SESSION["color"]; ?>;">
                            <a href="bitacoras_creditos.php" class="text-white" style="text-decoration:none">
                            <span class="opacity-4 position-rc mr-2 d-none">
                                <i class="mr-3 mt-n2    far fa-clipboard text-dark-tp5 opacity-4 w-5 h-5 text-center pt-1 radius-round fa-5x"></i>
                                </span>
                            <div class="d-flex align-items-center">
                                <div class="pos-rel p-3 bgc-white-tp8 radius-round ml-3 mr-3 shadow-md">
                                <i class="pos-abs mt-n2px ml-n3px   far fa-clipboard text-dark-tp5 opacity-4 w-5 h-5 text-center pt-1 radius-round text-170"></i>
                                <i class="pos-rel   far fa-clipboard text-white w-5 h-5 text-center pt-1 radius-round text-170"></i>
                                </div>

                                <div class="text-white pl-4 text-uppercase text-130 text-600 letter-spacing">
                                Bitácoras
                                </div> 
                            </div>
                            </a>
                            </div>
                        </div>
                        <!--fin-->

                               <!-- inicio card-->
                               <div class="col-12 col-sm-6 col-lg-6 my-1 px-sm-1 mt-3">
                            <div class="pos-rel py-4 radius-2 c-pointer" style="background-color: <?php echo $_SESSION["color"]; ?>;">
                            <a href="cuentas_contables.php" class="text-white" style="text-decoration:none">
                            <span class="opacity-4 position-rc mr-2 d-none">
                                <i class="mr-3 mt-n2 far fa-folder-open text-dark-tp5 opacity-4 w-5 h-5 text-center pt-1 radius-round fa-5x"></i>
                                </span>
                            <div class="d-flex align-items-center">
                                <div class="pos-rel p-3 bgc-white-tp8 radius-round ml-3 mr-3 shadow-md">
                                <i class="pos-abs mt-n2px ml-n3px far fa-folder-open text-dark-tp5 opacity-4 w-5 h-5 text-center pt-1 radius-round text-170"></i>
                                <i class="pos-rel far fa-folder-open text-white w-5 h-5 text-center pt-1 radius-round text-170"></i>
                                </div>

                                <div class="text-white pl-4 text-uppercase text-130 text-600 letter-spacing">
                                    Cuentas Contables
                                </div> 
                            </div>
                            </a>
                            </div>
                        </div>
                        <!--fin-->
          
                    </div>
                    


  
  
                </div>


              </div> <!-- row -->
        </div>



<?php 
    end_containers();
?>

<?php

    //require_once "../php/security.php";    
    //require_once "../php/interfaces.php";
    create_footer();
?>

      <!-- include common vendor scripts used in demo pages -->
      <script type="text/javascript" src="../ace-admin/node_modules/jquery/dist/jquery.js"></script>
      <script type="text/javascript" src="../ace-admin/node_modules/popper.js/dist/umd/popper.js"></script>
      <script type="text/javascript" src="../ace-admin/node_modules/bootstrap/dist/js/bootstrap.js"></script>


      <!-- include Ace script -->
      <script type="text/javascript" src="../ace-admin/dist/js/ace.js"></script>


      <script type="text/javascript" src="../ace-admin/assets/js/demo.js"></script>
      <!-- this is only for Ace's demo and you don't need it -->

      <!-- "Horizontal Menu" page script to enable its demo functionality -->
      <script type="text/javascript" src="../ace-admin/application/views/default/pages/partials/horizontal-menu/@page-script.js"></script>
    </div><!-- /.body-container -->


  </body>
</html>
