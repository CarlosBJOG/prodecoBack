<?php
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    require_once "../php/security.php";
    require_once "../php/header_perfiles.php";

    
    create_header();
    create_menu();
    begin_containers();


?>

<hr class="mb-3 border-dotted" />
<body>
    <div class="body-container">

      <div class="main-container">


        <div role="main" class="main-content">
          <div class="d-none content-nav mb-1 bgc-grey-l4">
            <div class="d-flex justify-content-between align-items-center">
              <ol class="breadcrumb pl-2">
                <li class="breadcrumb-item active text-grey">
                  <i class="fa fa-home text-dark-m3 mr-1"></i>
                  <a class="text-blue" href="#">
                    Home
                  </a>
                </li>

                <li class="breadcrumb-item"><a class="text-blue" href="#">More Pages</a></li>
                <li class="breadcrumb-item active text-grey-d1">Profile</li>
              </ol>

              <div class="nav-search">
                <form class="form-search">
                  <span class="d-inline-flex align-items-center">
                           <input type="text" placeholder="Search ..." class="form-control pr-4 form-control-sm radius-1 brc-info-m2 text-grey" autocomplete="off" />
                           <i class="fa fa-search text-info-m1 ml-n4"></i>
                       </span>
                </form>
              </div><!-- /.nav-search -->
            </div>
          </div><!-- breadcrumbs -->

            <div class="row">
              <div class="col-12 col-md-4">
                <div class="pos-rel d-flex flex-column py-3 px-lg-3 justify-content-center align-items-center">
                  <!-- OR use something like > `border-1 brc-default-l3 bgc-blue-l4 radius-2` for above -->
                  <div class="d-none position-tl w-100 border-t-4 brc-blue-m2 radius-2"></div>


                  <div class="pos-rel">
                    <img src="../styles/default.png" class="radius-round bord1er-2 brc-warning-m1" />
                    <span class=" position-tr bgc-success p-1 radius-round border-2 brc-white mt-2px mr-2px"></span>
                  </div>

                  <div class="text-center mt-2">
                    <h5 class="text-120 text-secondary-d3" id="nombreUsuario">
                      
                    </h5>
                
                    <span class="badge bgc-warning-l2 badge-xs text-600 text-orange-d2 pb-2 radius-round border-1 brc-warning-m2" id="puesto"></span>
                  </div>

     

                  <hr class="w-90 mx-auto border-dotted" />

                <form action="../php/uploadFile.php" enctype="multipart/form-data" method="POST" id="formFoto">
                      <div class="text-center">

                   
                        <input type="file" class="form-control-file" name="foto" id="foto">

                        <input type="submit" name="enviar" value="Enviar" class="btn btn-primary" >
                      
                      </div>
                </form>
             

                  <hr class="w-90 mx-auto mb-1 border-dotted" />

                  <div class="mt-2 w-100 text-90 text-secondary radius-1 px-25 py-3" class="overviewWeekly">
               

                  </div>
                </div><!-- .d-flex -->

   
              </div><!-- .col -->



              <div class="col-12 col-md-8 1bgc-default-l4 pt-0 radius-1 d-flex flex-column pos-rel mt-2 mt-md-0">

                <div class="sticky-nav-md">
                  <div class="position-tr w-100 border-t-4 brc-blue-m2 radius-2 d-md-none"></div>

                  <ul id="profile-tabs" class="nav nav-tabs-scroll is-scrollable nav-tabs nav-tabs-simple p-1px pl-25 bgc-grey-l4 border-1 brc-grey-l2 radius-t-2" role="tablist">
                    <li class="nav-item">
                      <a class="d-style nav-link active p-3 brc-blue" data-toggle="tab" href="#profile-tab-overview" role="tab" aria-controls="overview" aria-selected="true">
                        <span class="d-n-active">Info. Personal</span>
                        <span class="d-active text-dark-tp3">Info. Personal</span>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="d-style nav-link p-3 brc-blue" data-toggle="tab" href="#profile-tab-activity" role="tab" aria-controls="home" aria-selected="true">
                        <span class="d-n-active actividad"></span>
                        <span class="d-active text-dark-tp3 actividad"></span>
                
                      </a>
                    </li>
                    <li class="nav-item"  hidden="true">
                      <a class="d-style nav-link p-3 brc-blue" data-toggle="tab" href="#profile-tab-timeline" role="tab" aria-controls="home" aria-selected="true">
                        <span class="d-n-active">Timeline</span>
                        <span class="d-active text-dark-tp3">Timeline</span>
                      </a>
                    </li>
                  
                  </ul>
                </div>


                <div class="tab-content px-0 tab-sliding border-1 flex-grow-1 radius-b-2 border-t-0 brc-grey-l2">
                  <div class="tab-pane active show px-1 px-md-2 px-lg-3" id="profile-tab-overview">

                    <div class="row mt-1">
                      
                    <!-- contenedor para mostrar informacion adicional de perfiles -->
                      <div class="col-12 px-4" id="headerOverview">

                 

                      </div>

                    </div>

                    <div class="row mt-2">
                      <div class="col-12 px-4 mb-3">

                        <h4 class="text-dark-m3 text-140">
                          <i class="fa fa-info text-blue-m2 mr-3px"></i>
                          Información Personal
                        </h4>
                        <hr class="w-100 mx-auto my-1 border-dotted" />


                        <div class="bgc-white px-1 bo1rder-1 brc-secondary-l2 radius-1">
                          <table class="table table table-striped-info table-borderless">
                            <tr>
                              <td><i class="fa fa-user text-success-l1"></i></td>
                              <td class="text-95 text-default-d3">Nombre Completo: </td>
                              <td class="text-secondary-d2" id="nombreCompleto" ></td>
                            </tr>
                            <tr>
                              <td><i class="far fa-address-book text-success-l1"></i></td>
                              <td class="text-95 text-default-d3">Edad: </td>
                              <td class="text-secondary-d2" id="edad" ></td>
                            </tr>
                            <tr>
                              <td><i class="fa fa-envelope text-blue-m3"></i></td>
                              <td class="text-95 text-default-d3">Email: </td>
                              <td class="text-secondary-d2 text-wrap" id="email" ></td>
                            </tr>
                            <tr>
                              <td><i class="fas fa-mobile-alt text-purple-m3"></i></td>
                              <td class="text-95 text-default-d3">Celular: </td>
                              <td class="text-secondary-d2" id="celular" ></td>
                            </tr>
                            <tr>
                              <td><i class="fas fa-phone-volume text-orange-m3"></i></td>
                              <td class="text-95 text-default-d3">Tel&eacute;fono de Casa: </td>
                              <td class="text-secondary-d2" id="telCasa" ></td>
                            </tr>
                            <tr>
                              <td><i class="far fa-address-card text-secondary-m3"></i></td>
                              <td class="text-95 text-default-d3">Direcci&oacute;n: </td>
                              <td class="text-secondary-d2" id="domicilio" ></td>
                            </tr>
                            <tr>
                              <td><i class="fas fa-calendar-week text-orange-m3"></i></td>
                              <td class="text-95 text-default-d3">Codigo Postal:  </td>
                              <td class="text-secondary-d2" id="cp" ></td>
                            </tr>
                            

                            <tr>
                              <td><i class="fas fa-calendar-week text-orange-m3"></i></td>
                              <td class="text-95 text-default-d3">Fecha de Registro de usuario: </td>
                              <td class="text-secondary-d2" id="fechaRegistro" ></td>
                            </tr>
                
                          </table>
                        </div>

                      </div>


                    </div>

                  </div>

                  <div class="tab-pane px-1 px-md-2 px-lg-3" id="profile-tab-activity">
                    <div>
                      <div class="d-flex m-3">
                        <h4 class="text-dark-tp4 text-130 p-0 m-0" id="tituloRegistros"></h4>

                      </div>

                      <hr class="border-dotted mx-3" />

                      <div class="px-lg-3 contenedorLista">
                     
                        <div class="mb-2 text-grey-m1 text-95 border-l-3 brc-success-m1 pl-3">
                          <div class="d-flex align-items-start">
             

                            <div class="mx-2">
                              <span class="font-bolder text-gray-d1 nombreCliente">
                                     
                                    </span>
                 
                            </div>

                          </div>
                        </div>
                        <hr class="brc-grey-l2" />
                        <div class="mb-2 text-grey-m1 text-95 border-l-3 brc-warning pl-3">
                          <div class="d-flex align-items-start">
 

                            <div class="mx-2">
                              <span class="font-bolder text-gray-d1 nombreCliente">
                                     
                                    </span>
                            
                            </div>


                          </div>
                        </div>
                        <hr class="brc-grey-l2" />
                        <div class="mb-2 text-grey-m1 text-95 border-l-3 brc-pink-m1 pl-3">
                          <div class="d-flex align-items-start">

                            <div class="mx-2">
                              <span class="font-bolder text-gray-d1 nombreCliente">
                                      
                                    </span>
                            
                            </div>

                          </div>
                        </div>
                        <hr class="brc-grey-l2" />
                        <div class="mb-2 text-grey-m1 text-95 border-l-3 brc-purple-m1 pl-3">
                          <div class="d-flex align-items-start">
         

                            <div class="mx-2">
                              <span class="font-bolder text-gray-d1 nombreCliente">
                                      
                                    </span>
                    
                            </div>

      
                          </div>
                        </div>
                        <hr class="brc-grey-l2" />
                        
                      </div>

                    </div>
                  </div>


                  <div class="tab-pane px-1 px-md-2 px-lg-3" id="profile-tab-timeline" >
                    <div class="px-1 px-lg-3 text-grey-m1 text-95">

                      <div class="mt-4 mb-2">
                        <span class="badge badge-info ml-n1">Today</span>
                      </div>

                      <div class="mt-1 pl-1 pos-rel">
                        <div class="position-tl h-90 border-l-2 brc-secondary-l1 ml-2 ml-lg-25 mt-2"></div>
                        <div class="row pos-rel">
                          <div class="position-tl mt-1 ml-25 w-2 h-2 bgc-white radius-round border-3 brc-success-m1"></div>

                          <div class="col-4 ml-4 col-lg-3 ml-lg-0 text-90 text-grey-m2 text-left text-lg-center">10:10 pm</div>
                          <div class="col-12 ml-4 col-lg-9 ml-lg-n4 pb-2 border-b-1 brc-grey-l4">
                            <i class="fa fa-bookmark text-success-m3 w-2 text-center mr-1"></i>
                            <a href="#" class="text-blue-d1 text-600">Alex</a> bookmarked your post

                          </div>
                        </div>
                        <div class="row pos-rel my-3">
                          <div class="position-tl mt-1 ml-25 w-2 h-2 bgc-white radius-round border-3 brc-blue-m1"></div>

                          <div class="col-4 ml-4 col-lg-3 ml-lg-0 text-90 text-grey-m2 text-left text-lg-center">9:35 pm</div>
                          <div class="col-12 ml-4 col-lg-9 ml-lg-n4 pb-2 border-b-1 brc-grey-l4">
                            <i class="fa fa-pen text-blue-m2 w-2 text-center mr-1"></i>
                            <a href="#" class="text-blue-d1 text-600">Susan</a> reviewed a product
                            <a href="#" class="text-blue">Read</a>
                          </div>
                        </div>
                        <div class="row pos-rel my-3">
                          <div class="position-tl mt-1 ml-25 w-2 h-2 bgc-white radius-round border-3 brc-purple-m1"></div>

                          <div class="col-4 ml-4 col-lg-3 ml-lg-0 text-90 text-grey-m2 text-left text-lg-center">4:19 pm</div>
                          <div class="col-12 ml-4 col-lg-9 ml-lg-n4 pb-2 border-b-1 brc-grey-l4">
                            <i class="fa fa-book text-purple w-2 text-center mr-1"></i>
                            <a href="#" class="text-blue-d1 text-600">John</a> started a new course
                            <a href="#" class="text-blue">Enroll</a>
                          </div>
                        </div>
                        <div class="row pos-rel my-3">
                          <div class="position-tl mt-1 ml-25 w-2 h-2 bgc-white radius-round border-3 brc-warning-m1"></div>

                          <div class="col-4 ml-4 col-lg-3 ml-lg-0 text-90 text-grey-m2 text-left text-lg-center">11:40 am</div>
                          <div class="col-12 ml-4 col-lg-9 ml-lg-n4 pb-2 border-b-1 brc-grey-l4">
                            <i class="fa fa-image text-warning w-2 text-center mr-1"></i>
                            <a href="#" class="text-blue-d1 text-600">Alex</a> posted a new photo
                            <a href="#" class="text-blue">View</a>
                          </div>
                        </div>
                        <div class="row pos-rel my-3">
                          <div class="position-tl mt-1 ml-25 w-2 h-2 bgc-white radius-round border-3 brc-pink-m1"></div>

                          <div class="col-4 ml-4 col-lg-3 ml-lg-0 text-90 text-grey-m2 text-left text-lg-center">9:00 am</div>
                          <div class="col-12 ml-4 col-lg-9 ml-lg-n4 pb-2 border-b-1 brc-grey-l4">
                            <i class="fa fa-user text-pink w-2 text-center mr-1"></i>
                            <a href="#" class="text-blue-d1 text-600">Max</a> became friends with you

                          </div>
                        </div>

                      </div>

                      <div class="mt-4 mb-2">
                        <span class="badge badge-secondary ml-n1">Yesterday</span>
                      </div>

                      <div class="mt-1 pl-1 pos-rel">
                        <div class="position-tl h-90 border-l-2 brc-secondary-l1 ml-2 ml-lg-25 mt-2"></div>
                        <div class="row pos-rel">
                          <div class="position-tl mt-1 ml-25 w-2 h-2 bgc-white radius-round border-3 brc-purple-m1"></div>

                          <div class="col-4 ml-4 col-lg-3 ml-lg-0 text-90 text-grey-m2 text-left text-lg-center">6:11 pm</div>
                          <div class="col-12 ml-4 col-lg-9 ml-lg-n4 pb-2 border-b-1 brc-grey-l4">
                            <i class="fa fa-microphone text-purple-m1 w-2 text-center mr-1"></i>
                            <a href="#" class="text-blue-d1 text-600">Freddie</a> sang a new song
                            <a href="#" class="text-blue">Listen</a>
                          </div>
                        </div>
                        <div class="row pos-rel my-3">
                          <div class="position-tl mt-1 ml-25 w-2 h-2 bgc-white radius-round border-3 brc-success-m1"></div>

                          <div class="col-4 ml-4 col-lg-3 ml-lg-0 text-90 text-grey-m2 text-left text-lg-center">5:35 pm</div>
                          <div class="col-12 ml-4 col-lg-9 ml-lg-n4 pb-2 border-b-1 brc-grey-l4">
                            <i class="fa fa-pen text-success-m3 w-2 text-center mr-1"></i>
                            <a href="#" class="text-blue-d1 text-600">Robin</a> read a new novel

                          </div>
                        </div>
                        <div class="row pos-rel my-3">
                          <div class="position-tl mt-1 ml-25 w-2 h-2 bgc-white radius-round border-3 brc-blue-m1"></div>

                          <div class="col-4 ml-4 col-lg-3 ml-lg-0 text-90 text-grey-m2 text-left text-lg-center">4:20 pm</div>
                          <div class="col-12 ml-4 col-lg-9 ml-lg-n4 pb-2 border-b-1 brc-grey-l4">
                            <i class="fa fa-graduation-cap text-blue-m1 w-2 text-center mr-1"></i>
                            <a href="#" class="text-blue-d1 text-600">Katy</a> finished a long course

                          </div>
                        </div>
             
                        <div class="row pos-rel my-3">
                          <div class="position-tl mt-1 ml-25 w-2 h-2 bgc-white radius-round border-3 brc-pink-m1"></div>

                          <div class="col-4 ml-4 col-lg-3 ml-lg-0 text-90 text-grey-m2 text-left text-lg-center">9:35 am</div>
                          <div class="col-12 ml-4 col-lg-9 ml-lg-n4 pb-2 border-b-1 brc-grey-l4">
                            <i class="fa fa-plane text-pink w-2 text-center mr-1"></i>
                            <a href="#" class="text-blue-d1 text-600">Melissa</a> is going on vacation

                          </div>
                        </div>

                      </div>
                    </div>
                  </div>

                </div>


              </div>
            </div>
          </div><!-- /.page-content -->


        </div><!-- /main -->


      </div><!-- /.main-container -->

    </div><!-- /.body-container -->
  </body>






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

      <script type="text/javascript" src="../ace-admin/node_modules/bootbox/bootbox.all.js"></script>
      <script type="text/javascript" src="../ace-admin/node_modules/sweetalert2/dist/sweetalert2.all.js"></script>


      <!-- include Ace script -->
      <script type="text/javascript" src="../ace-admin/dist/js/ace.js"></script>
    
      <!-- script -->
      <script src="../js/func_perfiles.js"></script>



   </div><!-- /.body-container -->
  </body>

<?php
    create_footer();
    ?>
</div>
</body>
</html>
