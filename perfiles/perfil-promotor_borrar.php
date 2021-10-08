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
              <div class="col-lg-7 col-12 pl-lg-0 pr-lg-2">
              <h4 class="text-secondary-d1 text-120 ml-1 text-orange-d2 b-underline-4 mb-4">Reporte del mes</h4>              
                <!-- Actuvidad del mes -->
                <div class="pos-rel bgc-success-tp1 py-1 text-white radius-2">
                  <div class="row text-center mt-4">
                      <div class="col-3">
                        <div class="px-1 pt-2">
                            <span class="text-150">8</span>
                            <br>
                            <span class="text-90">Nuevos clientes</span>
                        </div>

                      <div class="position-rc h-75 border-l-1 brc-secondary-l2"></div>
                      </div>

                      <div class="col-3">
                        <div class="px-1 pt-2">
                            <span class="text-150">5</span>
                            <br>
                            <span class="text-90">Créditos autorizados</span>
                        </div>

                      <div class="position-rc h-75 border-l-1 brc-secondary-l2"></div>
                      </div>

                      <div class="col-3">
                        <div class="px-1 pt-2">
                            <span class="text-150">57</span>
                            <br>
                            <span class="text-90">Actividades</span>
                        </div>
                      <div class="position-rc h-75 border-l-1 brc-secondary-l2"></div>
                      </div>

                      <div class="col-3">
                        <div class="px-1 pt-2">
                            <span class="text-150">34</span>
                            <br>
                            <span class="text-90">Registros por concluir</span>
                        </div>
                      </div>
                  </div>
                </div>
                <hr>
<!-- SEGUIMIENTO CREDITOS-->

        <div class="col-lg-12 col-12 pl-lg-0 pr-lg-2">
        
            <div class="page-header pb-2 flex-column flex-sm-row align-items-start align-items-sm-center">
              <h4 class="font-light text-orange-d2 b-underline-4 mr-5 pr-5">Creditos solicitados</h4>
              <div class="page-tools mt-3 mt-sm-0 mb-sm-n1"></div>
            </div>

            <div class="mt-4 mx-md-2 border-t-1 brc-secondary-l1">
              <div id="table-header" class="d-none justify-content-between px-2 py-25 border-b-1 brc-secondary-l1">
                <div>
                  Resultados <span class="text-600 text-primary-d1">"Clientes"</span>
                  <small class="text-grey-m2">(Con columnas reordenables)</small>
                </div>
              </div> 

              <div class="table-responsive-md">
                <table id="datatable" class="table table-border-y text-dark-m2 text-95 border-y-1 brc-secondary-l1">
                  <thead class="text-secondary-m2 text-uppercase text-85">
                    <tr>
                      <th class="border-0">Número crédito</th>                        
                      <th class="border-0">Fecha de pago</th>                      
                      <th class="border-0">Cliente</th>  
                      <th class="border-0">Producto</th> 
                      <th class="border-0">Cantidad a pagar</th>  
                      <th class="border-0">Saldo insoluto</th>                        
                      <th class="border-0">Estado</th>   
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                  $oconns = new database();
                  $datas = $oconns->getRows("select * from (select 'Individual' as tipo,clientes.idkey,concat(generales.nombre,' ',generales.apellido_p,' ',generales.apellido_m) as nombre,clientes.fecha_creacion,clientes.idkey_usuario,u.usuario_nombre,creditos.monto,creditos.idkey_productos,p.nombre as producto,creditos.idkey as credito_id,creditos.folio,creditos.tasa_interes,creditos.numero_pagos,creditos.plazo,creditos.idkey_frecuencia,f.nombre as frecuencia,creditos.primer_pago,creditos.finalidad,creditos.estatus from clientes left join creditos on creditos.idkey_clientes=clientes.idkey left join generales on generales.idkey=clientes.idkey_generales left join usuarios u on u.idkey=clientes.idkey_usuario inner join productos p on p.idkey=creditos.idkey_productos inner join frecuencia f on f.idkey=creditos.idkey_frecuencia UNION select 'Grupal' as tipo,gn.idkey,gn.nombre,gn.fecha_creacion,gn.idkey_usuario,u.usuario_nombre,creditos.monto,creditos.idkey_productos,p.nombre as producto,creditos.idkey as credito_id,creditos.folio,creditos.tasa_interes,creditos.numero_pagos,creditos.plazo,creditos.idkey_frecuencia,f.nombre as frecuencia,creditos.primer_pago,creditos.finalidad,creditos.estatus from grupos_nombre gn left join creditos on creditos.idkey_clientes = gn.idkey left join usuarios u on u.idkey=gn.idkey_usuario inner join productos p on p.idkey=creditos.idkey_productos inner join frecuencia f on f.idkey = creditos.idkey_frecuencia) tab1 where tab1.estatus=1;");
                  $now = date('Y-m-d');
                  foreach ($datas as $item){
                      $pago_actual = $oconns->getRows("SELECT *  FROM amortizaciones  WHERE fecha_pago > NOW() and idkey_creditos=".$item["credito_id"]." LIMIT 1;");
                  ?>
                    <tr class="d-style bgc-h-default-l4">
                        <td hidden><input type="text" id="credito_id" value="<?php echo $item["credito_id"] ?>"></td>
                        <td class="text-grey"><?php echo $item["folio"]; ?></td>
                        <td class="text-grey"><?php echo $pago_actual[0]["fecha_pago"]; ?></td>
                        <td>          
                        <span class="text-105 text-600"><a href="<?php echo "../seguimiento/detalle-credito-cliente.php?idkey_cliente=".$item["idkey"]."&credito_id=".$item["credito_id"]."&tipo=".$item["tipo"].""; ?>" class="text-dark-tp3"><?php echo $item["nombre"] ?></a></span>
                        </td>
                        <td><?php echo $item["producto"] ?></td>
                        <?php
                        //echo "select *,DATEDIFF(amortizaciones.fecha_pago, pagos.fecha_valor) as dias from amortizaciones left join pagos on amortizaciones.idkey = pagos.idkey_amortizaciones left join clasificacion_pagos cp on cp.idkey=pagos.idkey_clasificacion_pagos where amortizaciones.idkey_creditos=".$item["credito_id"].";"; 
                        $dias = $oconns->getRows("select fecha_pago,DATEDIFF(amortizaciones.fecha_pago, pagos.fecha_valor) as dias from amortizaciones inner join pagos on amortizaciones.idkey = pagos.idkey_amortizaciones left join clasificacion_pagos cp on cp.idkey=pagos.idkey_clasificacion_pagos where amortizaciones.idkey_creditos=".$item["credito_id"].";");
                        $f_pago = $dias[0]["fecha_pago"];
                        //$diff = $f_pago - $now;
                        if ($dias[0]["dias"]==0){
                        ?>
                        
                        <td><a type="button" onclick="setEventId(<?= $item["credito_id"]; ?>)" class="btn btn-success" data-toggle="modal" data-target="#cantidad-pagar" href="javascript:void(0)"><?php echo $pago_actual[0]["total"]; ?></a></td>
                        <td><a type="button" onclick="setEventId(<?= $item["credito_id"]; ?>)" class="btn btn-success" data-toggle="modal" data-target="#saldo-insoluto" href="javascript:void(0)"><?php echo $pago_actual[0]["saldo_insoluto"]; ?></a></td>
                        <td> <span class='badge badge-sm bgc-success-l2 text-success-d2 border-1 brc-success-m3'>En tiempo</span></td>
                        <?php }elseif($dias[0]["dias"]>=1){ ?>
                        
                        <td><a type="button" onclick="setEventId(<?= $item["credito_id"]; ?>)" class="btn btn-red" data-toggle="modal" data-target="#cantidad-pagar" href="javascript:void(0)"><?php echo $pago_actual[0]["total"]; ?></a></td>
                        <td><a type="button" onclick="setEventId(<?= $item["credito_id"]; ?>)" class="btn btn-red" data-toggle="modal" data-target="#saldo-insoluto" href="javascript:void(0)"><?php echo $pago_actual[0]["saldo_insoluto"]; ?></a></td>
                        <td> <span class='badge badge-sm bgc-red-l2 text-red-d2 border-1 brc-red-m3'>Atraso(<?php echo $dias[0]["dias"]; ?>)</span></td>
                        <?php } ?>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div> <!--/ table-responsive-md -->

            </div> <!-- / row con tabla col-lg-8--> 

            </div>
            <!-- MODAL CANTIDAD A PAGAR -->
            <div class="modal fade modal-fs" id="cantidad-pagar" tabindex="-1" role="dialog" aria-labelledby="cantidad-pagarLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content border-width-0 border-t-4 brc-success-m2 px-3">

                  <div class="modal-body">
                  <p class="text-success-d1 text-130 mt-3 text-center">CANTIDAD A PAGAR</P>
                    <p class="text-secondary-d1 text-100 font-bold text-center">
                      Nombre de cliente
                    </p>
                    <span hidden id="event_id"></span>
                    <div id="pago_vigente"></div>
                  </div>
                </div>
              </div>
            </div>
            <!-- / MODAL CANTIDAD A PAGAR -->
            <script>
                function setEventId(event_id){
                    document.querySelector("#event_id").innerHTML = event_id;
                    //var credito_id = $('#event_id').text();
                    //alert("fila_cantidad.php?credito_id="+credito_id);
                    //var modal = $(this)
                    //alert(modal);
                    
                }

               $('#cantidad-pagar').on('show.bs.modal', function (event) {
                  var button = $(event.relatedTarget) 
                  var id = $('#event_id').text();

                  var modal = $(this)
                    $.ajax({
                        url:'fila_cantidad.php',
                        method: 'post',
                        data:{credito_id:id},
                        //dataType:"JSON",
                        success:function(data)
                        {   
                            modal.find('#pago_vigente').html(data); 
                        }
                    })
                })
            </script>
            <!-- MODAL SALDO INSOLUTO -->
            <div class="modal fade modal-fs" id="saldo-insoluto" tabindex="-1" role="dialog" aria-labelledby="saldo-insolutoLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content border-width-0 border-t-4 brc-success-m2 px-3">
                  <div class="modal-body">
                    <p class="text-success-d1 text-130 mt-3 text-center">SALDO INSOLUTO</P>
                    <p class="text-secondary-d1 text-100 font-bold text-center">
                      Nombre de cliente
                    </p>
                    <div id="insolutos"></div>
                  </div>

                </div>
              </div>
            </div>
            <script>
                function setEventId(event_id){
                    document.querySelector("#event_id").innerHTML = event_id;
                    //var credito_id = $('#event_id').text();
                    //alert("fila_cantidad.php?credito_id="+credito_id);
                    //var modal = $(this)
                    //alert(modal);
                    
                }

               $('#saldo-insoluto').on('show.bs.modal', function (event) {
                  var button = $(event.relatedTarget) 
                  var id = $('#event_id').text();

                  var modal = $(this)
                    $.ajax({
                        url:'filas_insoluto.php',
                        method: 'post',
                        data:{credito_id:id},
                        //dataType:"JSON",
                        success:function(data)
                        {   
                            modal.find('#insolutos').html(data); 
                        }
                    })
                })
            </script>
            <!-- / MODAL SALDO INDOLUTO -->
            <!-- /SEGUIMIENTO CREDITOS-->

                 <div>
                    <canvas id="quickstats-chart" height="120" class="mt-lg-4 d-lg-none d-none"></canvas>
                  </div> 
             <!--   </div>  -->
              </div>

              <div class="col-lg-4 col-12 pr-lg-0 mt-3 mt-lg-0">
                <div class="border-1 brc-grey-l1 bgc-white shadow-sm radius-2 pt-35 px-0 px-lg-4">
                  <div class="d-flex mb-4">
                    <h4 class="text-secondary-d1 text-120 px-3 px-lg-0">Créditos activos</h4>
                  </div>

                  <div class="card border-0">
                    <div class="card-body px-0 px-sm-1 px-lg-0 border-t-1 brc-default-l2">
                      <table class="table brc-grey-l3 mb-2">
                        <thead class="bgc-transparent">
                          <tr class="border-0 bg-transparent">
                            <th class="border-0 text-secondary-m3">Nombre</th>
                            <th class="border-0 text-secondary-m3">Estatus</th>
                            <th class="border-0 text-secondary-m3">Progreso</th>
                          </tr>
                        </thead>

                        <tbody>
                          <tr class="bgc-h-default-l4 c-pointer">
                            <td class="text-dark-tp3 text-95">Karla Valdes Gutierrez</td>
                            <td>
                              <span class="badge text-80 border-l-3 brc-black-tp8 bgc-green text-white">Completo</span>
                            </td>
                            <td class="text-dark-m1" width="80">
                              <div class="align-self-center pos-rel text-success">
                                <canvas class="task-progress" height="50" width="80" data-percent="100"></canvas>
                                <span class="position-center text-80">100%</span>
                              </div>
                            </td>
                          </tr>
                          <tr class="bgc-h-default-l4 c-pointer">
                            <td class="text-95"><a href="perfil-cliente.php" class="text-dark-tp3">Rodrigo Alejandro Romero Carmona</a></td>
                            <td>
                              <span class="badge text-80 border-l-3 brc-black-tp8 bgc-blue text-white">En progreso</span>
                            </td>
                            <td class="text-dark-m1" width="80">
                              <div class="align-self-center pos-rel text-default">
                                <canvas class="task-progress" height="50" width="80" data-percent="70"></canvas>
                                <span class="position-center text-80">70%</span>
                              </div>
                            </td>
                          </tr>
                          <tr class="bgc-h-default-l4 c-pointer">
                            <td class="text-dark-tp3 text-95">Antonio Cabrera Contreras</td>
                            <td>
                              <span class="badge text-80 border-l-3 brc-black-tp7 bgc-warning text-white">Pago pendiente</span>
                            </td>
                            <td class="text-dark-m1" width="80">
                              <div class="align-self-center pos-rel text-default">
                                <canvas class="task-progress" height="50" width="80" data-percent="40"></canvas>
                                <span class="position-center text-80">40%</span>
                              </div>
                            </td>
                          </tr>
                          <tr class="bgc-h-default-l4 c-pointer">
                            <td class="text-dark-tp3 text-95">Enrique Arturo Ortiz De Luna</td>
                            <td>
                              <span class="badge text-80 border-l-3 brc-black-tp7 bgc-red text-white">Cancelado</span>
                            </td>
                            <td class="text-dark-m1" width="80">
                              <div class="align-self-center pos-rel text-default">
                                <canvas class="task-progress" height="50" width="80" data-percent="20"></canvas>
                                <span class="position-center text-80">20%</span>
                              </div>
                            </td>
                          </tr>
                          <tr class="bgc-h-default-l4 c-pointer">
                            <td class="text-dark-tp3 text-95">Herrod Chandler</td>
                            <td>
                              <span class="badge text-80 border-l-3 brc-black-tp8 bgc-green text-white">Completo</span>
                            </td>
                            <td class="text-dark-m1" width="80">
                              <div class="align-self-center pos-rel text-success">
                                <canvas class="task-progress" height="50" width="80" data-percent="100"></canvas>
                                <span class="position-center text-80">100%</span>
                              </div>
                            </td>
                          </tr>
                          <tr class="bgc-h-default-l4 c-pointer">
                            <td class="text-dark-tp3 text-95">Monica Garcia Chavez</td>
                            <td>
                              <span class="badge text-80 border-l-3 brc-black-tp8 bgc-blue text-white">En progreso</span>
                            </td>
                            <td class="text-dark-m1" width="80">
                              <div class="align-self-center pos-rel text-default">
                                <canvas class="task-progress" height="50" width="80" data-percent="50"></canvas>
                                <span class="position-center text-80">50%</span>
                              </div>
                            </td>
                          </tr>

                        </tbody>
                      </table>
                    </div>
                  </div>
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

<script>
    $(document).ready(function() 
    {
    <?php
        if (isset($_GET["idkey_cliente"]))
        {
        ?>
    $('#div_relaciones').load("../php/show_interface_cliente.php?module=main_relaciones&param=<?php echo $_GET["idkey_cliente"] ?>");

    <?php
        }
        else
        {
        ?>
    $.fn.start_for_clients();
    <?php
        }
        ?>
    });
    
    function buscar_datos(consulta){
    $.ajax({
    url: '../php/show_interface_cliente.php' ,
    type: 'POST' ,
    dataType: 'html',
    data: {module:"show_clientes", consulta: consulta, notocar: $('#idkey_cliente').val() },
    })
    .done(function(respuesta){
    $("#resultado_relaciones").html(respuesta);
    })
    .fail(function(){
    console.log("error");
    });
    }
    
    
    $(document).on('keyup','#caja_busqueda', function(){
    var valor = $(this).val();
    if (valor != "") {
    buscar_datos(valor);
    }else{
    buscar_datos();
    }
    });
    
</script>
<?php
    create_footer_forms();
    ?>
</div>
</body>
</html>
