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

    if(isset($_SESSION['tipo_usuario'])){
      if(!$_SESSION['tipo_usuario'] == 2 ){
        header("Location ../home.php");
      }else{
        $oconns = new database();
        $datos = $oconns->getSimple("SELECT COUNT(idkey_usuario) FROM clientes WHERE idkey_usuario = '".$_SESSION['tipo_usuario']."'");
        $tabla = $oconns->getRows("SELECT nombre, nombre_producto, monto, fecha_creacion, estatus FROM view_creditos WHERE idkey_usuario='".$_SESSION['tipo_usuario']."' and estatus = 1 or estatus = 4 " );
        
        
        if(!$datos==0){
          $clientes_cargo = $datos;
        }else{
          $clientes_cargo = 0;
        }

      }
    }

?>

<hr class="mb-3 border-dotted" />
<h1 class="text-dark-m2">Perfil de promotor</h1>

<div class="sticky-nav-md">
  <div class="position-tr w-100 border-t-4 brc-blue-m2 radius-2 d-md-none"></div>

  <ul id="profile-tabs" class="nav nav-tabs-scroll is-scrollable nav-tabs nav-tabs-simple p-1px pl-25 bgc-grey-l4 border-1 brc-grey-l2 radius-t-2" role="tablist">
    <li class="nav-item">
      <a class="d-style nav-link active p-3 brc-blue" data-toggle="tab" href="#profile-tab-overview" role="tab" aria-controls="overview" aria-selected="true">
        <span class="d-n-active">Informacion</span>
        <span class="d-active text-dark-tp3">Informacion</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="d-style nav-link p-3 brc-blue" data-toggle="tab" href="#profile-tab-edit" role="tab" aria-controls="home" aria-selected="true">
        <span class="d-n-active">Editar Informacion <span class="text-danger">*</span></span>
        <span class="d-active text-dark-tp3">Editar Informacion</span>
      </a>
    </li>
  </ul>
</div>


<div class="tab-content px-0 tab-sliding border-1 flex-grow-1 radius-b-2 border-t-0 brc-grey-l2">
  <div class="tab-pane active show px-1 px-md-2 px-lg-3" id="profile-tab-overview">

    <div class="row mt-1">
      <div class="col-12 px-4">

        <div class="d-flex justify-content-center my-3 flex-wrap flex-equal">
          <div class="border-1 brc-grey-l1 px-3 py-2 rounded text-center mx-1 mb-1">
            <span class="text-170 text-blue"><?php echo $clientes_cargo;?></span>
            <br />
            <span class="text-90 text-dark-tp2">Clientes a cargo</span>
          </div>
          <?php
            $oconns = new database();
            $d = $oconns->getSimple("SELECT COUNT(*) FROM view_creditos WHERE idkey_usuario = '".$_SESSION['tipo_usuario']."' and estatus = 1") or die($oconns -> error);;
            if(!$datos==0){
              $creditos_aprobados= $d;
            }else{
              $creditos_aprobados = 0;
            }
          ?>
          <div class="border-1 brc-grey-l1 px-3 py-2 rounded text-center text-blue mx-1 mb-1">
            <span class="text-170"><?php echo $creditos_aprobados;?></span>
            <br />
   
            <span class="text-90 text-dark-tp2">Creditos aprobados</span>
          </div>
          <?php
            $oconns = new database();
            $d = $oconns->getSimple("SELECT COUNT(*) FROM view_creditos WHERE idkey_usuario = '".$_SESSION['tipo_usuario']."' and estatus = 4") or die($oconns -> error);;
            if(!$datos==0){
              $creditos_revision= $d;
            }else{
              $creditos_revision = 0;
            }
          ?>
          <div class="border-1 brc-grey-l1 px-3 py-2 rounded text-center text-blue mx-1 mb-1">
            <span class="text-170"><?php echo $creditos_revision ?></span>
            <br />
            <span class="text-90 text-dark-tp2">Creditos en revision</span>
          </div>


        </div>

      </div>
    </div>


  </div>
  <div class="tab-pane px-1 px-md-2 px-lg-3" id="profile-tab-edit">
    <h4 class="text-blue-d1 text-130 mt-3">Actualizar informacion de perfil</h4>
    <hr />

    <div class="row">
      <div class="col-12 col-md-10 offset-md-1 mt-3">

        <form class="text-grey-d1 text-95">
        <div class="form-group row">
              <div class="col-sm-3 col-form-label text-sm-right pr-0">
                  <label for="id-form-field-1" class="mb-0">Nombre</label>
                </div>

                <div class="col-sm-9">
                  <input type="text" class="form-control col-sm-8 col-md-6" id="id-form-field-1" />
                </div>

                
          </div>

          <div class="form-group row">
              <div class="col-sm-3 col-form-label text-sm-right pr-0">
                  <label for="email" class="mb-0">E-mail</label>
                </div>

                <div class="col-sm-9">
                  <input type="email" class="form-control col-sm-8 col-md-6" id="email" />
                </div>

                
          </div>

          <div class="form-group row">
              <div class="col-sm-3 col-form-label text-sm-right pr-0">
                  <label for="id-form-field-1" class="mb-0">Direccion</label>
                </div>

                <div class="col-sm-9">
                  <input type="text" class="form-control col-sm-8 col-md-6" id="id-form-field-1" />
                </div>

                
          </div>

          <div class="form-group row">
              <div class="col-sm-3 col-form-label text-sm-right pr-0">
                  <label for="telefono" class="mb-0">Telefono</label>
                </div>

                <div class="col-sm-9">
                  <input type="number" class="form-control col-sm-8 col-md-6" id="telefono" />
                </div>

                
          </div>


              

          <div class="col-12">
            <hr class="border-double" />

            <div class="form-group col-md-6 offset-md-3 mt-2">
              <button type="button" class="btn btn-warning btn-block btn-md btn-bold mt-2 mb-3 radius-2">
              Guardar Cambios
              </button>
            </div>
          </div>

        </form>

      </div>

    </div>

    
  </div>
</div>

<div class="row">
              <div class="col-12">
                <table id="simple-table" class="table table-bordered table-bordered-x table-hover text-dark-m2">
                  <thead class="text-dark-m3 bgc-grey-l4">
                    <tr>
                      <th class="text-center pr-0">
                        <label>
                          <input type="checkbox" class="align-bottom" autocomplete="off" />
                        </label>
                      </th>
                      <th class="text-center pr-0">
                      
                      </th>
                      <th>Cliente</th>
                      <th>Tipo de credito</th>
                      <th class="d-none d-sm-table-cell">Monto</th>
                      <th class='d-none d-sm-table-cell'><i class="far fa-clock text-110 text-success-d1"></i>Fecha de Creacion</th>
                      <th class="d-none d-sm-table-cell">Estatus</th>
                      <th></th>
                    </tr>
                  </thead>

                  <tbody>
                    <?php foreach($tabla as $valor) { ?>

                    <tr class="bgc-h-default-l3 d-style">
                      <td class='text-center pr-0 pos-rel'>
                        <div class="position-tl h-100 ml-n1px border-l-4 brc-info-m1 v-hover"></div>
                        <div class="position-tl h-100 ml-n1px border-l-4 brc-success-m1 v-active"></div>

                        <label>
                          <input type="checkbox" class="align-middle" autocomplete="off" />
                        </label>
                      </td>
                      <td class='text-center pr-0'>
                     
                      </td>

                      <td><a href='#' class='text-blue-d2'><?php echo $valor['nombre']?></a></td>
                      <td><?php echo $valor['nombre_producto']?></td>
                      <td class='d-none d-sm-table-cell'>$<?php echo $valor['monto']?></td>
                      <td class='d-none d-sm-table-cell'><?php echo $valor['fecha_creacion']?></td>
                      <?php if($valor['estatus'] == 1){ ?>
                        <td class='d-none d-sm-table-cell'>
                          <span class='badge badge-sm bgc-success-l2 text-success-d2 border-1 brc-success-m3'>Activo</span>
                    
                        </td>
                        <td>

                      <?php } else {?>

                        <td class='d-none d-sm-table-cell'>
                        <span class='badge badge-sm bgc-warning-l2 text-orange-d3 border-1 brc-warning-m2'>En revision</span>
                    
                        </td>
                        <td>
                        
                      <?php }?>

                        <div class='d-none d-lg-flex text-muted'>
                          
                        </div>

                        <div class='dropdown d-inline-block d-lg-none dd-backdrop dd-backdrop-none-md'>
                          <a href='#' class='btn btn-outline-warning btn-xs radius-round dropdown-toggle' data-toggle="dropdown"><i class="fa fa-cog text-110"></i></a>
                          <div class="dropdown-menu dd-slide-up dd-slide-none-md">
                            <div class="dropdown-inner">
                              </div>
                          </div>
                        </div>

                      </td>
                    </tr>

                    <?php } ?>
                  </tbody>

                  <!-- <tfoot class="text-dark-m3 bgc-grey-l4">
                    <tr>
                      <th colspan="2" class="pr-0 border-0"></th>
                      <th colspan="2" class="pr-0 font-normal border-0">
                        Total
                      </th>
                      <th class='d-none d-sm-table-cell border-0'></th>
                      <th class='d-none d-sm-table-cell border-0'></th>
                      <th class='d-none d-sm-table-cell border-0'></th>
                      <th colspan="1" class="border-0">
                        $1,000
                      </th>
                    </tr>
                  </tfoot> -->
                </table>
              </div><!-- /.col -->
            </div>





<?php end_containers(); ?>


      <!-- include common vendor scripts used in demo pages -->
      <script type="text/javascript" src="../ace-admin/node_modules/jquery/dist/jquery.js"></script>
      <script type="text/javascript" src="../ace-admin/node_modules/popper.js/dist/umd/popper.js"></script>
      <script type="text/javascript" src="../ace-admin/node_modules/bootstrap/dist/js/bootstrap.js"></script>


      <!-- include vendor scripts used in "Horizontal Menu" page. see "application/views/default/pages/partials/horizontal-menu/@vendor-scripts.hbs" -->
      <script type="text/javascript" src="../ace-admin/node_modules/chart.js/dist/Chart.js"></script>

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

      <script type="text/javascript" src="../ace-admin/node_modules/@fullcalendar/core/main.js"></script>
      <script type="text/javascript" src="../ace-admin/node_modules/@fullcalendar/daygrid/main.js"></script>
      <script type="text/javascript" src="../ace-admin/node_modules/@fullcalendar/timegrid/main.js"></script>


      <!-- include Ace script -->
      <script type="text/javascript" src="../ace-admin/dist/js/ace.js"></script>


      <script type="text/javascript" src="../ace-admin/assets/js/demo.js"></script>
      <!-- this is only for Ace's demo and you don't need it -->

      <!-- "DataTables" page script to enable its demo functionality -->
      <script type="text/javascript" src="../ace-admin/application/views/default/pages/partials/table-datatables/@page-script.js"></script>
      <!-- "Horizontal Menu" page script to enable its demo functionality -->
      <script type="text/javascript" src="../ace-admin/application/views/default/pages/partials/horizontal-menu/@page-script.js"></script>
    </div><!-- /.body-container -->
  </body>

<?php
    create_footer_forms();
    ?>
</div>
</body>
</html>
