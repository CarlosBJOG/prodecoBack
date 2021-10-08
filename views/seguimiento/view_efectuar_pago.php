<?php require_once "../seguimiento/functions_seguimiento.php";?>
<!-- MODAL CANTIDAD A PAGAR -->
<form name="registrarPago" id="registrarPago">
  <?php
@session_start();
if($_SESSION["tipo_usuario"]==4){//Si es cajero
  $select = "disabled";
  $tipo_pago = 1;
}
else{
  $select = "";
  $tipo_pago = "";
}
?>
  <div class="modal fade modal-fs" id="cantidad-pagar" tabindex="-1" role="dialog" aria-labelledby="cantidad-pagarLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
      <div class="modal-content border-width-0 border-t-4 brc-success-m2 px-3">

            <div class="modal-header">
              <p class="text-success-d1 text-130 mt-3 text-center">CANTIDAD A PAGAR</P>
                <button type="button" class="close" data-dismiss="modal" id="btnCerrar"><span aria-hidden="true" >×</span><span class="sr-only">Cerrar</span></button>
            </div>
        <div class="modal-body">

          <p class="text-secondary-d1 text-100 font-bold text-center" id="nombre_cliente1"></p>

          <!--Animación de carga
          <div id="animacion">
            <div class=" d-flex flex-column justify-content-between align-items-center">
              <div class="spinner-grow text-success mb-3" role="status">
                  <span class="sr-only">Loading...</span>
              </div>
            </div>
          </div>-->

          <span id="area_pagos">
            <p hidden>
              <input type="text" id="idkey_credito"  name="idkey_credito">
              <input type="text" id="saldo_insoluto_dinamico"  name="saldo_insoluto_dinamico">
              <input type="text" id="interes_acumulado"  name="interes_acumulado">
              <input type="text" id="monto_ultimo_pago"  name="monto_ultimo_pago">
              <input type="text" id="no_ultimo_pago"  name="no_ultimo_pago">
              <input type="text" id="fecha_pago_actual"  name="fecha_pago_actual">
              <input type="text" id="fecha_ultimo_pago"  name="fecha_ultimo_pago">
            </p>

            <div class="row border-t-1 brc-grey-l1 py-3">
              <div class="col-sm-4 col-md-4">     
                <label for="tipo-producto">Monto pago ideal</label>
                <input type="text" class="form-control" id="pago_ideal"  name="pago_ideal" disabled="true">
              </div>
              <div class="col-sm-4 col-md-4">     
                <label for="tipo-producto">Tipo de Pago<span style="color:red;">*</span></label>
                <select <?php echo $select; ?> class="ace-select text-dark-m1 bgc-default-l5 bgc-h-warning-l3  brc-default-m3 brc-h-warning-m1" id="tipo_pago" name="tipo_pago" required="true">
                    <option value=""></option>
                    <?php select_clasificacion($tipo_pago); ?>
                </select>

              </div>
              <div class="col-sm-4 col-md-4 mb-2">
                <label class="col-form-label form-control-label mt-0 text-600 text-grey">Fecha de Pago<span style="color:red;">*</span></label>
                <div class="input-group date" id="id-timepicker">
                  <div class="input-group-addon input-group-append">
                    <div class="input-group-text">
                      <i class="fa fa-calendar"></i>
                    </div>
                  </div>
                  <input type="text" class="form-control form-control-sm" id="fecha_valor"  name="fecha_valor" autocomplete="off" required max="" onchange="verificar_pago()">
                  <script> $('#fecha_valor').activeCalendary('#fecha_valor'); </script>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-4 col-md-4 mb-2">            
                  <label for="tipo-producto" class="text-600 text-grey">Referencia/# transacción</label>
                  <p class="text-secondary-m2 text-105">
                  <input class="form-control" id="referencia"  name="referencia" >
                  </p>            
              </div>
              <div class="col-sm-4 col-md-4 mb-2">            
                  <label for="tipo-producto" class="text-600 text-grey">Cantidad Pagada<span style="color:red;">*</span></label>
                  <p class="text-secondary-m2 text-105">
                  <input class="form-control" id="pago_valor" name="pago_valor" type="number" required="true" 
                  onchange="verificar_pago()">
                  </p>            
              </div>
              <div class="col-sm-4 col-md-4 mb-2">            
                <label for="tipo-producto" class="text-600 text-grey">Cantidad (Ajuste de pagos finales)</label>
                <p class="text-secondary-m2 text-105">
                <input class="form-control" id="soluto" name="soluto"  type="text" disabled="true" required="true" >
                </p>            
              </div>
              <div class="col-sm-3 col-md-3 mb-1" style="margin-top: 35px;"> 
                  <button  type="submit" class="btn btn-success btn-sm" id="btnGuardarPago">
                    <i class="fa fa-send-o"></i>&nbsp;Guardar
                  </button>
              </div>
          </div>
           <span class="text-danger small"><i><b>Nota:</b> Si se registra un pago con días de atraso se debe agregar primero un pago con $0 primero en la fecha que corresponde al pago.</i></span>
           <hr>

          <!--<table class="table table-bordered table-bordered-x table-hover text-dark-m2 small" id="tablaAmortNueva">
              <thead class="text-dark-m3 bgc-success-l4">
                <tr class="font-bold text-100 text-center">
                  <td colspan="12">Pago</td>
                </tr>
                <tr class="font-bold text-100">
                     <td>#</td>
                    <td width="15%">Fecha valor</td>
                     <td>Pago</td>
                    <td>Interés</td>
                    <td>IVA</td>
                    <td>Monto</td>
                    <td>Interes acumulado</td>
                    <td>Pago interés moratorio</td>
                    <td>Iva interés moratorio</td>
                    <td>Amortización</td>
                    <td>Saldo insoluto</td>
                    <td>Días transcurridos</td>
                </tr>
              </thead>
              <tbody id="amortizacion_nueva">
              </tbody>
            </table>-->
          </span>

          <table class="table table-bordered table-bordered-x table-hover text-dark-m2 small">
            <thead class="text-dark-m3 bgc-success-l4">
              <tr class="font-bold text-100 text-center">
                <td colspan="6">Pago actual: tabla de amortización estática</td>
              </tr>
              <tr class="font-bold text-100">
                  <td width="15%">Fecha de pago</td>
                  <td>Núm. de pago</td>
                  <td>Interés</td>
                  <td>IVA</td>
                  <td>Cantidad</td>
                  <td>Saldo insoluto</td>
              </tr>
            </thead>
            <tbody id="filas_cant_pagar">
            </tbody>
          </table>

          <table class="table table-bordered table-bordered-x table-hover text-dark-m2 small">
            <thead class="text-dark-m3 bgc-success-l4">
              <tr class="font-bold text-100 text-center">
                <td colspan="14">Último pago: tabla de amortización dinámica</td>
              </tr>
              <tr class="font-bold text-100">
                  <tr class="font-bold text-100">
                   <td>#</td>
                  <td width="15%">Fecha valor</td>
                   <td>Pago</td>
                  <td>Interés</td>
                  <td>IVA</td>
                  <td>Monto</td>
                  <td>Interes<br> acumulado</td>
                  <td>Pago interés<br> moratorio</td>
                  <td>Iva interés<br> moratorio</td>
                  <td>Amortización</td>
                  <td>Saldo<br> insoluto</td>
                  <td>Días<br> transc.</td>
                  <td>Estatus</td>
                  <td>Acciones</td>
              </tr>
            </thead>
            <tbody id="filas_ultimo_pago">
            </tbody>
          </table>

      </div>
      </div>
    </div>
  </div>
</form>
<!-- / MODAL CANTIDAD A PAGAR -->

<script type="text/javascript">
$(document).ready(function(){
  $('select.readonly option:not(:selected)').attr('disabled',true);

   $("#animacion").hide();
  $("#registrarPago").validate({
      errorClass: 'text-error',  
      ignore: false,
      rules: {
        fecha_valor: {"FechaAnterior": true}
      }
    });

  $("#registrarPago").submit(function( event ) {
      if($("#registrarPago").valid()){
        $('select').removeAttr('disabled');
        calcular_pago();
      }
      event.preventDefault();
    });
});
</script>