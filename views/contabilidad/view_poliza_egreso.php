  <?php require_once "../../php/functions.php";?>
  <form id="formPolizaEgreso" name="formPolizaEgreso">
  <div class="card bgc-success brc-primary radius-0" id="card-2">
    <div class="card-header">
      <h5 class="card-title text-white font-light"><i class="fa fa-table mr-2px"></i>
        <b>Póliza de Egreso</b><span id="nombre"></span>
      </h5>
    </div>

    <div class="card-body p-0 bg-white">
      <table class="table table-striped table-hover mb-0 table-bordered">
        <tbody>
          <tr>
            <td width="50%" class="text-right">
                <div class="col-sm-12 col-md-12 col-lg-12 card-title"><b>Crédito</b></div>
                <div class="col-sm-12 col-md-12 col-lg-12 text-grey text-400" id="folios"></div>
            </td>
            <td>
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 card-title"><b>Monto solicitado</b></div>
                    <div class="col-sm-12 col-md-12 col-lg-12 text-grey text-400" id="montos"></div>
                </div>
            </td>
          </tr>
          <tr>
            <td colspan="2">
                <div class="row brc-grey-l1">
                    <div class="col-sm-12 col-md-6 col-lg-6">
                      <label class="col-form-label form-control-label mt-0 text-600 text-grey">Fecha de póliza<span style="color:red;">*</span></label>
                      <div class="input-group date" id="id-timepicker">
                        <div class="input-group-addon input-group-append">
                          <div class="input-group-text">
                            <i class="fa fa-calendar"></i>
                          </div>
                        </div>
                        <input type="text" class="form-control form-control-sm" id="fecha_poliza"  name="fecha_poliza" autocomplete="off" required>
                        <script> $('#fecha_poliza').activeCalendary('#fecha_poliza'); $('#fecha_poliza').val('<?php echo date('d/m/Y'); ?>');</script>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6">
                      <p class="text-600 text-grey">
                        <label >Monto</label><span style="color:red;">*</span>
                        <input type="text" class="form-control" id="monto" name = "monto" readonly="true">
                      </p>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-12">
                      <p class="text-600 text-grey">
                        <label >Concepto</label><span style="color:red;">*</span>
                        <input type="text" class="form-control" id="concepto" name = "concepto" required="">
                      </p>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="text-center text-success"><i>Cuenta Contable 1</i></td>
        </tr>
        <tr>
            <td colspan="2">
                <div class="row brc-grey-l1">

                    <div class="col-lg-6 col-sm-12 col-md-6">     
                        <p class="text-600 text-grey">
                        <label >Cuenta contable</label><span style="color:red;">*</span>
                        <select class="ace-select text-dark-m1 bgc-default-l5 bgc-h-warning-l3  brc-default-m3 brc-h-warning-m1" id="cuenta_contable1" name="cuenta_contable1" required>
                        </select>
                        </p>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6">
                      <p class="text-600 text-grey">
                        <label >Referencia</label><span style="color:red;">*</span>
                        <input type="text" class="form-control" id="referencia1" name = "referencia1" required="">
                      </p>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6">
                      <p class="text-600 text-grey">
                        <label >Debe</label><span style="color:red;">*</span>
                        <input type="number" class="form-control" id="debe1" name = "debe1" required="">
                      </p>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6">
                      <p class="text-600 text-grey">
                        <label >Haber</label><span style="color:red;">*</span>
                        <input type="number" class="form-control" id="haber1" name = "haber1" required="" value="0">
                      </p>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="text-center text-success"><i>Cuenta Contable 2</i></td>
        </tr>
        <tr>
            <td colspan="2">
                <div class="row brc-grey-l1">

                    <div class="col-lg-6 col-sm-12 col-md-6">     
                        <p class="text-600 text-grey">
                        <label >Cuenta contable</label><span style="color:red;">*</span>
                        <select class="ace-select text-dark-m1 bgc-default-l5 bgc-h-warning-l3  brc-default-m3 brc-h-warning-m1" id="cuenta_contable2" name="cuenta_contable2" required>
                        </select>
                        </p>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6">
                      <p class="text-600 text-grey">
                        <label >Referencia</label><span style="color:red;">*</span>
                        <input type="text" class="form-control" id="referencia2" name = "referencia2" required="">
                      </p>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6">
                      <p class="text-600 text-grey">
                        <label >Debe</label><span style="color:red;">*</span>
                        <input type="number" class="form-control" id="debe2" name = "debe2" required="" value="0">
                      </p>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6">
                      <p class="text-600 text-grey">
                        <label >Haber</label><span style="color:red;">*</span>
                        <input type="number" class="form-control" id="haber2" name = "haber2" required="">
                      </p>
                    </div>
                    <div class="col-lg-12 col-sm-12 col-md-12 mb-3 text-right">
                        <button type="submit" class="btn btn-success" id="btnGuardarStatus" >Guardar Póliza</button>
                    </div>
                </div>

            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</form>



<script type="text/javascript">
$(document).ready(function(){
    $('#cuenta_contable1').select2();
    $('#cuenta_contable2').select2();
    $( "#formPolizaEgreso").validate({errorClass: 'text-error'});
    /////Envío del form
    $( "#formPolizaEgreso").submit(function( event ) {
        if($("#formPolizaEgreso").valid())
            guardar_poliza_egreso();
        else
            alertify.error("Algunos datos están incompletos o erróneos");
        event.preventDefault();
    });

  });
</script>

