<?php
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    require_once "../php/security.php";
    require_once "../php/header_seguimiento.php";
    require_once "../php/db.php";
    require_once "functions_seguimiento.php";
    require_once "../php/functions.php";
    require_once "../php/funciones_cartera.php";
    
    create_header_seguimiento();
    create_menu_seguimiento();
    begin_containers();
    
    ?>
<div class="page-content container container-plus px-md-4 px-xl-5">

<div>
    <canvas id="quickstats-chart" height="120" class="mt-lg-4 d-lg-none d-none"></canvas>
</div> 

<div class="text-grey">
    <div class="row m-4">
        <div class="card-header border-0 bg-transparent">
            <h4 class="text-success">Detalle del crédito</h4>            
        </div>
    </div>
    <?php
     if (isset($_GET["idkey_credito"]) && isset($_GET["tipo"]) && isset($_GET["idkey_cliente"])){
        $idkey_credito = $_GET["idkey_credito"];
        $idkey_cliente = $_GET["idkey_cliente"];
        $tipo = $_GET["tipo"];
    }
    else{
        echo "<script> alert('No se han encontrado datos coincidentes.'); window.location.href='index.php'; </script>";
    }
    ?>
    <input  hidden name='idkey_credito' id='idkey_credito' value="<?php echo $idkey_credito; ?>" >
    <input  hidden name='idkey_cliente' id='idkey_cliente' value='<?php echo $idkey_cliente;?>'>
    <input hidden name='tipo_credito' id='tipo_credito' value='<?php echo $tipo;?>'>
</div>

<div class="col-12 col-sm-12 mt-12 mt-sm-0 cards-container" id="card-container-2">
  <div class="card bgc-success brc-primary radius-0" id="card-2">
    <div class="card-header">
      <h5 class="card-title text-white font-light"><i class="fa fa-table mr-2px"></i>
        <b>Nombre:&nbsp;</b><span id="nombre"></span>
      </h5>
    </div>

    <div class="card-body p-0 bg-white">
      <table class="table table-striped table-hover mb-0 table-bordered">
        <thead class="thin-border-bottom">
          <tr>
            <tr style="margin-bottom: 0px; margin-left: 20px" id="socios"></tr>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td width="50%">
                <div class="row">
                    <div class="col-sm-4 col-md-4 col-lg-4 card-title"><b>Folio:</b></div>
                    <div class="col-sm-8 col-md-8 col-lg-8 text-grey" id="folio"></div>
                </div>
            </td>
            <td>
                <div class="row">
                    <div class="col-sm-4 col-md-4 col-lg-4 card-title"><b>Fecha de solicitud:</b></div>
                    <div class="col-sm-8 col-md-8 col-lg-8 text-grey" id="fecha_creacion"></div>
                </div>
            </td>
          </tr>
          <tr>
            <td>
                <div class="row">
                    <div class="col-sm-4 col-md-4 col-lg-4 card-title"><b>Tipo de producto:</b></div>
                    <div class="col-sm-8 col-md-8 col-lg-8 text-grey" id="producto"></div>
                </div>
            </td>
            <td>
                <div class="row">
                    <div class="col-sm-4 col-md-4 col-lg-4 card-title"><b>Monto de crédito:</b></div>
                    <div class="col-sm-8 col-md-8 col-lg-8 text-grey" id="monto"></div>
                </div>
            </td>
          </tr>
          <tr>
            <td>
                <div class="row">
                    <div class="col-sm-4 col-md-4 col-lg-4 card-title"><b>% PRODECO:</b></div>
                    <div class="col-sm-8 col-md-8 col-lg-8 text-grey" id="prodeco"></div>
                </div>
            </td>
            <td>
                <div class="row">
                    <div class="col-sm-4 col-md-4 col-lg-4 card-title"><b>% FONDEADORA:</b></div>
                    <div class="col-sm-8 col-md-8 col-lg-8 text-grey" id="fondeadora"></div>
                </div>
            </td>
          </tr>
          <tr>
            <td>
                <div class="row">
                    <div class="col-sm-4 col-md-4 col-lg-4 card-title"><b>Plazo en meses: </b></div>
                    <div class="col-sm-8 col-md-8 col-lg-8 text-grey" id="plazo"></div>
                </div>
            </td>
            <td>
                <div class="row">
                    <div class="col-sm-4 col-md-4 col-lg-4 card-title"><b>Frecuencia de pago:</b></div>
                    <div class="col-sm-8 col-md-8 col-lg-8 text-grey" id="frecuencia"></div>
                </div>
            </td>
          </tr>
          <tr>
            <td>
                <div class="row">
                    <div class="col-sm-4 col-md-4 col-lg-4 card-title"><b>Número de pagos:</b></div>
                    <div class="col-sm-8 col-md-8 col-lg-8 text-grey" id="no_pagos"></div>
                </div>
            </td>
            <td>
                <div class="row">
                    <div class="col-sm-4 col-md-4 col-lg-4 card-title"><b>Tasa de interés anual:</b></div>
                    <div class="col-sm-8 col-md-8 col-lg-8 text-grey" id="tasa_interes"></div>
                </div>
            </td>
          </tr>
          <tr>
            <td>
                <div class="row">
                    <div class="col-sm-4 col-md-4 col-lg-4 card-title"><b>Garantía líquida:</b></div>
                    <div class="col-sm-8 col-md-8 col-lg-8 text-grey" id="gliquida"></div>
                </div>
            </td>
            <td>
                <div class="row">
                    <div class="col-sm-4 col-md-4 col-lg-4 card-title"><b>Fecha de desembolso:</b></div>
                    <div class="col-sm-8 col-md-8 col-lg-8 text-grey" id="fecha_desembolso"></div>
                </div>
            </td>
          </tr>
          <tr>
            <td>
                <div class="row">
                    <div class="col-sm-4 col-md-4 col-lg-4 card-title"><b>Tipo desembolso:</b></div>
                    <div class="col-sm-8 col-md-8 col-lg-8 text-grey" id="tipo_desembolso"></div>
                </div>
            </td>
            <td>
                <div class="row">
                    <div class="col-sm-4 col-md-4 col-lg-4 card-title"><b>Fecha de primer pago:</b></div>
                    <div class="col-sm-8 col-md-8 col-lg-8 text-grey" id="primer_pago"></div>
                </div>
            </td>
          </tr>
          <tr>
            <td>
                <div class="row">
                    <div class="col-sm-4 col-md-4 col-lg-4 card-title"><b>Estatus:</b></div>
                    <div class="col-sm-8 col-md-8 col-lg-8 text-grey" id="estatus"></div>
                </div>
            </td>
            <td colspan="2">
                <div class="row">
                    <div class="col-sm-4 col-md-4 col-lg-4 card-title"><b>Finalidad:</b></div>
                    <div class="col-sm-8 col-md-8 col-lg-8 text-grey" id="finalidad"></div>
                </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

<hr>

<div id="socios_score"></div>

 <!--FACTORES-->
 <form name="factoresForm" id="factoresForm">
<div class="row justify-content-center" id="factoresDiv">
    <div class="col-lg-8 col-sm-12 col-md-12 pr-lg-0 mt-3 mt-lg-0 pl-5">
        <div class="card-body p-3 px-sm-1 px-lg-0">
            <!-- Insert tabla factores -->
            <div id="div_factores">
                <div class="h-100 bg-white pt-0 radius-1 shadow-sm mx-auto">
                    <div class="card-body p-3 px-sm-1 px-lg-0 brc-default-l2">
                        <table class="table brc-grey-l3 table-striped mb-2">
                            <thead class="bgc-white-l4 border-t-3 border-t-3 w-100 brc-success-tp2 radius-t-2">
                                <th colspan="4" class="text-center text-blue">
                                    <span id="nombre_cliente"></span>
                                    <input hidden type="text" name="idkey_cliente1" id="idkey_cliente1">
                                </th>
                            </thead>
                            <thead class="bgc-green-l4 border-t-3 border-t-3 w-100 brc-success-tp2 radius-t-2">
                                <th></th>
                                <th>Característica</th>
                                <th>Descripción</th>
                                <th>Calificación</th>
                            </thead>
                            <tbody id="factores" class="text-grey border-t-3 w-100 brc-success-tp2 radius-t-2">
                            </tbody>
                        </table>
                    </div><!-- / h-100 bg-white -->
                </div>
            </div>
        </div> <!-- Col-lg-8 -->
    </div>
        
    <div class="col-lg-4 col-sm-12 col-md-12 mt-3 mt-lg-0 p-4">
        <h5 class="bgc-purple-tp1 text-white lighter-2 py-2 pl-4 mb-2 border-0 text-center">SCORE</h5>
        <div id="progress-chart" class="bg-white p-2 brc-purple-m4 border-2 pos-rel">
            <div class="d-flex flex-column">
              <div class="align-self-center pos-rel text-blue">
                    <canvas id="graph_score" height="200" width="200"></canvas>
                    <span class="position-center text-120" id="score"></span>
              </div>
              <div class="d-flex text-center">
                <div class="flex-grow-1 mb-3">
                  <div class="text-nowrap text-120 text-secondary-d2" id="desc_score"></div>
                </div>
              </div>
            </div>                 
        </div>
        <div class="col-lg-12 col-sm-12 col-md-12 mt-3 mt-lg-0 p-4 text-center" align="">
            <button type="submit" class="btn btn-success" id="btnScore">Guardar Score</button>
        </div>
    </div>
</div> <!-- / row -->
</form>
<br>

<div class="row border-t-1 brc-grey-l1 py-3">
    <div class="col-sm-12 col-md-4 col-lg-4">
      <p class="text-600 text-grey">
        <label >Plazo en meses</label><span style="color:red;">*</span>
        <input type="number" class="form-control" id="plazo_meses" name = "plazo_meses" placeholder="" onChange="calcular_npagos();" min="" max="" required>
      </p>
    </div>
    <div class="col-sm-12 col-md-4 col-lg-4">
      <p class="text-600 text-grey">
        <label>Monto de crédito</label><span style="color:red;">*</span>
        <input type="number" class="form-control" id="monto_credito" name="monto_credito" placeholder="$"  min="" max="" required <?php if($tipo==2) echo "readonly='true'";?>>
      </p>
    </div>

    <div class="col-sm-12 col-md-4 col-lg-4">
      <p class="text-600 text-grey">
        <label >% PRODECO</label><span style="color:red;">*</span>
        <input type="number" class="form-control" id="prodeco1" name = "prodeco1" min="0" max="100" placeholder=""  required>
      </p>
    </div>
    <div class="col-sm-12 col-md-4 col-lg-4">
      <p class="text-600 text-grey">
        <label>% FONDEADORA</label><span style="color:red;">*</span>
        <input type="number" class="form-control" id="fondeadora1" name="fondeadora1" min="0" max="100" placeholder=""  required>
      </p>
    </div>

    <div class="col-sm-12 col-md-4 col-lg-4">
      <p class="text-600 text-grey">
        <label >Garantía Líquida</label><span style="color:red;">*</span>
        <input type="number" class="form-control" id="gliquida1" name="gliquida1" placeholder="%"  required="true" min="0" value="5" max="100">
      </p>                
    </div>

    <div class="col-sm-12 col-md-4 col-lg-4">
      <label class="col-form-label form-control-label mt-0 text-600 text-grey">Fecha de desembolso<span style="color:red;">*</span></label>
      <div class="input-group date" id="id-timepicker">
        <div class="input-group-addon input-group-append">
          <div class="input-group-text">
            <i class="fa fa-calendar"></i>
          </div>
        </div>
        <input type="text" class="form-control form-control-sm" id="fecha_desembolso1"  name="fecha_desembolso1" autocomplete="off" required>
        <script> $('#fecha_desembolso1').activeCalendary('#fecha_desembolso1'); </script>
      </div>
    </div>
    <div class="col-sm-12 col-md-4 col-lg-4">
      <p class="text-600 text-grey">
        <label for="tipo-producto">Tipo de desembolso</label><span style="color:red;">*</span>
        <select class="ace-select text-dark-m1 bgc-default-l5 bgc-h-warning-l3  brc-default-m3 brc-h-warning-m1" id="tipo_desembolso1" name="tipo_desembolso1" required>
          <?php create_tipo_desembolso(); ?>
        </select>
      </p>
    </div>

    <div class="col-sm-12 col-md-4 col-lg-4">
      <label class="col-form-label form-control-label mt-0 text-600 text-grey">Fecha de primer pago<span style="color:red;">*</span></label>
      <div class="input-group date" id="id-timepicker">
        <div class="input-group-addon input-group-append">
          <div class="input-group-text">
            <i class="fa fa-calendar"></i>
          </div>
        </div>
        <input type="text" class="form-control form-control-sm" id="fecha_pago1"  name="fecha_pago1" autocomplete="off" required>
        <script> $('#fecha_pago1').activeCalendary('#fecha_pago1'); </script>
      </div>
    </div>

    <div class="col-lg-4 col-sm-12 col-md-4">     
        <p class="text-600 text-grey">
        <label for="tipo-producto">Determinación de crédito</label>
        <select class="ace-select text-dark-m1 bgc-default-l5 bgc-h-warning-l3  brc-default-m3 brc-h-warning-m1" id="idkey_estatus">
            <?php select_estatus(''); ?>
        </select>
        </p>
    </div>
    <div class=" col-lg-11 col-sm-12 col-md-11 mb-3">            
        <label for="tipo-producto" class="text-600 text-grey">Observaciones</label>
        <p class="text-secondary-m2 text-105">
        <textarea class="form-control" id="observaciones" maxlength="200"></textarea>        
        </p>            
    </div>
    <div class="col-lg-1 col-sm-12 col-md-5 mb-3" style="margin-top: 35px;">
        <button type="button" class="btn btn-success" id="btnGuardarStatus" onclick="actualizar_estatus_credito('<?php echo $idkey_credito; ?>')">Guardar</button>
    </div>
</div>
<br>    
        
<?php end_containers(); ?>


      <!-- include common vendor scripts used in demo pages -->
      <script type="text/javascript" src="../ace-admin/node_modules/jquery/dist/jquery.js"></script>
      <script type="text/javascript" src="../ace-admin/node_modules/popper.js/dist/umd/popper.js"></script>
      <script type="text/javascript" src="../ace-admin/node_modules/bootstrap/dist/js/bootstrap.js"></script>


      <!-- include vendor scripts used in "Horizontal Menu" page. see "application/views/default/pages/partials/horizontal-menu/@vendor-scripts.hbs" -->
      <script type="text/javascript" src="../ace-admin/node_modules/chart.js/dist/Chart.js"></script>


      <!-- include Ace script -->
      <script type="text/javascript" src="../ace-admin/dist/js/ace.js"></script>


      <script type="text/javascript" src="../ace-admin/assets/js/demo.js"></script>
      <!-- this is only for Ace's demo and you don't need it -->

      <!-- "DataTables" page script to enable its demo functionality -->
      <script type="text/javascript" src="../ace-admin/application/views/default/pages/partials/table-datatables/@page-script.js"></script>
      <!-- "Horizontal Menu" page script to enable its demo functionality -->
      <script type="text/javascript" src="../ace-admin/application/views/default/pages/partials/horizontal-menu/@page-script.js"></script>

 <!-- Para validar los campos de los forms-->
  <script type="text/javascript" src="../js/jquery.validate.min.js"></script>
  <script src="../js/validate_rules.js"></script>
<script type="text/javascript" src="../js/funciones_cartera.js"></script>
<script type="text/javascript" src="../js/funciones_seguimiento.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $('#factoresDiv').hide();
    var idkey_credito=$('#idkey_credito').val();
    var idkey_cliente=$('#idkey_cliente').val();
    var tipo_credito=$('#tipo_credito').val();
    detalle_credito_general(idkey_credito);
    
    /////Envío del form
    $( "#factoresForm" ).submit(function( event ) {
        event.preventDefault();
        var idkey_cliente1=$('#idkey_cliente1').val();
        actualizar_factores(idkey_cliente1);
    });

  });
     
  function calcular_score(){
    var score=0;
    var max =0;
    $('input[name="factor_value"]').each(function() {
      if($(this).val() != "" && $(this).prop('checked')){
        score += parseFloat($(this).val()); 
        max += parseFloat($(this).attr('max')); 
      }
    });
    if(max ==0) var porcentaje =0;
    else var porcentaje = parseInt((score/max)*100);
    $("#score").html(porcentaje+"%");
    $("#desc_score").html(score+"/"+max);
    graficar_porcentaje('graph_score', porcentaje, "Score");
  }

  function graficar_porcentaje(graph_id, porcentaje, desc){
    var ctx = document.getElementById(graph_id);
    var color = "";
    if(porcentaje>=80)
        color= "#66CC33";
    else if(porcentaje>=60 && porcentaje<80)
        color ="#FFCC33";
    else if(porcentaje>=40 && porcentaje<60)
        color = "#FF9933";
    else
        color = "#FF3300";
    var data = {
      labels: [
        desc,
        ""
      ],
      datasets: [
        {
          data: [porcentaje, 100-porcentaje],
          backgroundColor: [
            color,
            "#AAAAAA"
          ]
        }]
    };
    var myChart = new Chart(ctx, {
      type: 'doughnut',
      data: data,
      options: {
        responsive: true,
        legend: {
          display: false
        },
        cutoutPercentage: 80,
        tooltips: {
            filter: function(item, data) {
            var label = data.labels[item.index];
            if (label) return item;
          }
        }
      }
    });

  }

    
</script>
<?php
    //require_once "php/security.php";
    //require_once "php/header_forms.php";
    create_footer_forms();
    ?>
</div>
</body>
</html>
