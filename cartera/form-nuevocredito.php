<?php
  header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
  header("Cache-Control: post-check=0, pre-check=0", false);
  header("Pragma: no-cache");
  require_once "../php/security.php";
  require_once "../php/header_cartera.php";
  require_once "../php/functions.php";
  require_once "../php/funciones_cartera.php";
  require_once "../php/db.php";

  create_header_forms();
  create_menu_cartera();
  begin_containers();

  $idkey_cliente = "";
  $tipo = "";
  if(isset($_GET["idkey_cliente"]))
    $idkey_cliente = $_GET["idkey_cliente"];
  if(isset($_GET["tipo"]))
    $tipo = $_GET["tipo"];
  else
    echo"<script> alert('Error de referencia del tipo de credito!!!'); window.location.href='index.php'; </script>";

?>


<form name="nuevoCred" id="nuevoCred" method="POST" action="">
  <div class="row m-4">
    <div class="col-12 col-md-10">
      <div class="card-header border-0 bg-transparent">
        <h4 class="text-success">Nuevo Crédito</h4>            
      </div>
    </div>    
  </div>

  <!--Animación de carga-->
  <div id="animacion">
    <div class=" d-flex flex-column justify-content-between align-items-center">
      <div class="spinner-grow text-success mb-3" role="status">
          <span class="sr-only">Loading...</span>
      </div>
    </div>
  </div>

  <hr/>  
  <input hidden name='idkey_cliente' id='idkey_cliente' value='<?php echo $idkey_cliente;?>'>
  <input hidden name='tipo' id='tipo' value='<?php echo $tipo; ?>'>

<?php 
if($tipo == 1){//Le exijo 1 garantía inmueble
  $oconns = new database();
  $gi = $oconns->getSimple("SELECT count(idkey_clientes) as ngi FROM garantias_inmueble where  idkey_clientes=".$idkey_cliente);
  if($gi == 0){
    echo"<script> alert('Es necesario dar de alta al menos una Garant\u00CDa Inmueble en el perfil del Cliente para cr\u00E9ditos individuales!!!'); window.location.href='../cartera'; </script>";
    exit;
  }
}

else if($tipo==2){
  $socios = consulta_socios();
  echo'
  <div class="col-12">       
    <div class="form-group row p-3">
        <label class="col-form-label form-control-label text-grey text-600">Nombre del grupo<span style="color:red;">*</span></label>
        <input class="form-control form-control-sm" type="text" onkeyup="this.value = this.value.toUpperCase();" id="nombre_grupo" name="nombre_grupo" required>
        <span id="nombre_estatus"></span>
        <p><img src="styles/816.gif" id="loaderIcon" style="display:none" /></p>
    </div>
    <div class="form-group row">
        <div class="col-sm-3 col-form-label">
          <p class="text-600 text-grey">Selecciona los clientes del Grupo <span style="color:red;">*</span></p>
        </div>
        <div class="col-sm-9">
          <select multiple="multiple" size="10" name="duallistbox_demo1[]"  class="DualList" id="socios" required>
            '.$socios.'
          </select>                                   
        </div> 
    </div>   
    <div class="container" align="center">
      <div class="col-10 col-md-10 mt-3 mt-md-0">
        <div class="card border-0">
          <div class="card-header bgc-green-d2">
            <h3 class="card-title text-130 text-white">Montos por cada cliente del Grupo</h3>
          </div>
          <div class="card-body bgc-white border-1 border-t-0 brc-success-m3" id="clientes_grupo">
          </div>
        </div>
      </div>
    </div>
    <hr>

  </div>';
}
?>

  <div class="row col-md-12 col-lg-12 border-l-1 brc-secondary-l1 pl-8">
    <div class="col-sm-12 col-md-6 col-lg-6">
      <p class="text-600 text-grey">
        <label for="tipo-producto">Tipo de producto</label><span style="color:red;">*</span>
        <select class="ace-select text-dark-m1 bgc-default-l5 bgc-h-warning-l3  brc-default-m3 brc-h-warning-m1" id="tipo_producto" name="tipo_producto" required>
          <?php create_productos($tipo); ?>
        </select>
      </p>
    </div>
    <div class="col-sm-12 col-md-6 col-lg-6">
      <p class="text-600 text-grey">
        <label for="frecuencia-pago">Frecuencia de pago</label><span style="color:red;">*</span>
        <select class="ace-select text-dark-m1 bgc-default-l5 bgc-h-warning-l3  brc-default-m3 brc-h-warning-m1" name="frecuencia_pago" id="frecuencia_pago"  required>
          <?php //create_frecuencia(); ?>
        </select>
      </p>
    </div>
    <div class="col-sm-12 col-md-3 col-lg-3">
      <p class="text-600 text-grey">
        <label >Plazo en meses</label><span style="color:red;">*</span>
        <input type="number" class="form-control" id="plazo_meses" name = "plazo_meses" placeholder="" onChange="calcular_npagos();" min="" max="" required>
      </p>
    </div>
    <div class="col-sm-12 col-md-3 col-lg-3">
      <p class="text-600 text-grey">
        <label>Monto de crédito</label><span style="color:red;">*</span>
        <input type="number" class="form-control" id="monto_credito" name="monto_credito" placeholder="$"  min="" max="" required <?php if($tipo==2) echo "readonly='true'";?>>
      </p>
    </div>
    <div class="col-sm-12 col-md-3 col-lg-3">
      <p class="text-600 text-grey">
        <label >% PRODECO</label><span style="color:red;">*</span>
        <input type="number" class="form-control" id="prodeco" name = "prodeco" min="0" max="100" placeholder=""  required>
      </p>
    </div>
    <div class="col-sm-12 col-md-3 col-lg-3">
      <p class="text-600 text-grey">
        <label>% FONDEADORA</label><span style="color:red;">*</span>
        <input type="number" class="form-control" id="fondeadora" name="fondeadora" min="0" max="100" placeholder=""  required>
      </p>
    </div>
    <div class="col-sm-12 col-md-3 col-lg-3" >
      <p class="text-600 text-grey">
        <label>IVA</label><span style="color:red;">*</span>
        <input type="text" class="form-control" id="iva" name="iva" readonly required="true">
      </p>
    </div>
    <div class="col-sm-12 col-md-3 col-lg-3" >
      <p class="text-600 text-grey">
        <label>Número de pagos</label><span style="color:red;">*</span>
        <input type="text" class="form-control" id="numero_pagos" name="numero_pagos" readonly required="true">
      </p>
    </div>
    <div class="col-sm-12 col-md-3 col-lg-3">
      <p class="text-600 text-grey">
        <label >Tasa de interés anual</label><span style="color:red;">*</span>
        <input type="number" class="form-control" id="tasa_interes" name="tasa_interes" placeholder="%" readonly="true" required="true">
      </p>                
    </div>
    <div class="col-sm-12 col-md-3 col-lg-3">
      <p class="text-600 text-grey">
        <label >Garantía Líquida</label><span style="color:red;">*</span>
        <input type="number" class="form-control" id="gliquida" name="gliquida" placeholder="%"  required="true" min="0" value="5" max="100">
      </p>                
    </div>
    <div class="col-sm-12 col-md-6 col-lg-6">
      <label class="col-form-label form-control-label mt-0 text-600 text-grey">Fecha de desembolso<span style="color:red;">*</span></label>
      <div class="input-group date" id="id-timepicker">
        <div class="input-group-addon input-group-append">
          <div class="input-group-text">
            <i class="fa fa-calendar"></i>
          </div>
        </div>
        <input type="text" class="form-control form-control-sm" id="fecha_desembolso"  name="fecha_desembolso" autocomplete="off" required>
        <script> $('#fecha_desembolso').activeCalendary('#fecha_desembolso'); </script>
      </div>
    </div>
    <div class="col-sm-12 col-md-6 col-lg-6">
      <p class="text-600 text-grey">
        <label for="tipo-producto">Tipo de desembolso</label><span style="color:red;">*</span>
        <select class="ace-select text-dark-m1 bgc-default-l5 bgc-h-warning-l3  brc-default-m3 brc-h-warning-m1" id="tipo_desembolso" name="tipo_desembolso" required>
          <?php create_tipo_desembolso(); ?>
        </select>
      </p>
    </div>
    <div class="col-sm-12 col-md-6 col-lg-6">
      <label class="col-form-label form-control-label mt-0 text-600 text-grey">Fecha de primer pago<span style="color:red;">*</span></label>
      <div class="input-group date" id="id-timepicker">
        <div class="input-group-addon input-group-append">
          <div class="input-group-text">
            <i class="fa fa-calendar"></i>
          </div>
        </div>
        <input type="text" class="form-control form-control-sm" id="fecha_pago1"  name="fecha_pago1" id="fecha_pago1" autocomplete="off" required>
        <script> $('#fecha_pago1').activeCalendary('#fecha_pago1'); </script>
      </div>
    </div>
    <div class="col-sm-12 col-md-6 col-lg-6">
      <p class="text-600 text-grey">
        <label >Finalidad</label>
        <textarea class="form-control" rows="3" id="finalidad" name="finalidad"></textarea>
      </p>
    </div>
  </div>

  <div class="row border-t-1 brc-grey-l1 py-3 justify-content-end">
    <div class="col-sm-12 col-md-5 order-lg-last">
      <button class="btn btn-warning" type="button" onclick="ver_amortizacion('#monto_credito', ' del crédito')">
          <i class="fa fa-table"></i>&nbsp;Ver tabla de Amortización
      </button>
      <button class="btn btn-success" type="submit">
         <i class="fa fa-save mr-1"></i>Guardar
      </button>
      <button class="btn btn-secondary btn-sm ml-3" type="reset">
        <i class="fa fa-undo mr-1"></i>Limpiar
      </button>
    </div>
  </div>
  <hr>
  <div class="col-sm-12 col-md-12 col-lg-12">
    <div class class="table-responsive-md" id="tabla"></div>
  </div>

</form>


<?php end_containers(); ?>
  <!-- include common vendor scripts used in demo pages -->
  <script type="text/javascript" src="../ace-admin/node_modules/jquery/dist/jquery.js"></script>
  <script type="text/javascript" src="../ace-admin/node_modules/popper.js/dist/umd/popper.js"></script>
  <script type="text/javascript" src="../ace-admin/node_modules/bootstrap/dist/js/bootstrap.js"></script>

  <!-- include vendor scripts used in "More Form Elements" page. see "application/views/default/pages/partials/form-elements-2/@vendor-scripts.hbs" -->
  <script type="text/javascript" src="../ace-admin/node_modules/bootstrap-star-rating/js/star-rating.js"></script>

  <script type="text/javascript" src="../ace-admin/node_modules/typeahead.js/dist/typeahead.bundle.js"></script>

  <script type="text/javascript" src="../ace-admin/node_modules/bootstrap-select/dist/js/bootstrap-select.js"></script>
  <script type="text/javascript" src="../ace-admin/node_modules/bootstrap-duallistbox/dist/jquery.bootstrap-duallistbox.js"></script>


  <script type="text/javascript" src="../ace-admin/node_modules/select2/dist/js/select2.js"></script>
  <script type="text/javascript" src="../ace-admin/node_modules/chosen-js/chosen.jquery.js"></script>
  
    
  <!-- include Ace script -->
  <script type="text/javascript" src="../ace-admin/dist/js/ace.js"></script>
  <script type="text/javascript" src="../ace-admin/assets/js/demo.js"></script>

  <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

  <script type="text/javascript" src="../ace-admin/node_modules/select2/dist/js/select2.js"></script>
  <script type="text/javascript" src="../ace-admin/node_modules/chosen-js/chosen.jquery.js"></script>
    
    
      
      <!-- include Ace script -->
      <script type="text/javascript" src="../ace-admin/dist/js/ace.js"></script>


      <script type="text/javascript" src="../ace-admin/assets/js/demo.js"></script>
      <!-- this is only for Ace's demo and you don't need it -->

      
      <!-- "Horizontal Menu" page script to enable its demo functionality -->
      <script type="text/javascript" src="../ace-admin/application/views/default/pages/partials/horizontal-menu/@page-script.js"></script>

      <!-- "More Form Elements" page script to enable its demo functionality -->
      <script type="text/javascript" src="../ace-admin/application/views/default/pages/partials/form-elements-2/@page-script.js"></script>


  <script src="../js/default.js"></script>
  <!-- Para validar los campos de los forms-->
  <script type="text/javascript" src="../js/jquery.validate.min.js"></script>
  <script src="../js/validate_rules.js"></script>
  <script src="../js/funciones_cartera.js"></script>

  <script>
  $(document).ready(function(){
    var idkey_cliente=$('#idkey_cliente').val();
    var tipo=$('#tipo').val();
    if(tipo == 1)
      comprobar_perfil_completo(idkey_cliente);
    else
      $("#animacion").slideUp();

    $("#nuevoCred").validate({
      errorClass: 'text-error',  
      ignore: false,
      rules: {
        fecha_pago1: {FechaViernes: true, FechaPosterior: false},
        nombre_grupo: {NombreGrupo: true}
      }
    });

    cargar_iva();

    $("#tipo_producto").change(function() {
      cargar_frecuencia();
      cargar_interes();
    });

    $("#frecuencia_pago").change(function() {
      calcular_npagos();
      cargar_interes();
    });

    $("#plazo_meses").change(function() {
      calcular_npagos();
      cargar_interes();
    });

      //Envío de formulario ****************************************************************************************
    $( "#nuevoCred" ).submit(function( event ) {

        if($("#nuevoCred").valid()){
          var prodeco = parseFloat($("#prodeco").val());
          var fondeadora = parseFloat($("#fondeadora").val());
          if((prodeco + fondeadora) != 100)
            alertify.error("La suma de los porcentajes de PRODECO y FONDEADORA debe dar 100.");
          else
            guardar_credito();
      
        }
        else
          alertify.error("Algunos datos están incompletos o erróneos");
        event.preventDefault();//Detiene el envío del form y su recarga

    });//envío form*********************************************************************************************

    $('#socios').on('change', function() {
      $("#clientes_grupo").html('');
      $("#monto_credito").val("");

        var clientes = new Array();
        var nombres_clientes = new Array();
        var n = 0;
      
        $('#socios :selected').each(function(i, selected) {
            clientes[i] = $(selected).val();
            nombres_clientes[i] = $(selected).text();
            var puestos='<select class="ace-select text-dark-m1 bgc-default-l5 bgc-h-warning-l3  brc-default-m3 brc-h-warning-m1" id="puesto'+i+'" name="puesto['+clientes[i]+']"><option value=""></option><option value="1">Presidente</option><option value="2">Secretario</option><option value="3">Tesorero</option></select>';
            $("#clientes_grupo").append('<div class="form-group row" id="clientes_grupo"><div class="col-sm-4 col-md-4 col-lg-4" align="right"><label>'+nombres_clientes[i]+'</label></div><div class="col-sm-3 col-md-3 col-lg-3"><input type="number" class="form-control montos_socios" name="montos_socios['+clientes[i]+']" placeholder="" required onChange="calcular_monto()" min="1" id="monto_socio'+i+'"><span class="text-success"><small><i>Monto</i></small></span><span style="color:red;">*</span></div><div class="col-sm-3 col-md-3 col-lg-3">'+puestos+'<span class="text-success"><small><i>Puesto</i></small></div><div class="col-sm-2 col-md-2 col-lg-2"><button class="btn btn-success" type="button" onclick="ver_amortizacion(\'#monto_socio'+i+'\', \' del cliente '+nombres_clientes[i]+' \')" >Amortización</button></div></div>');
            n+=1;

        });
        if(n<3){
          $("#clientes_grupo").html("");
        }
    })


  });

  </script>

<?php
    create_footer_forms();
    ?>
</div>
</body>
</html>
