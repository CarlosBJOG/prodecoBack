<div class="row" style="overflow-x: auto;">
    <div class="col-12">

      <table id="tablaEgresos" class="table table-bordered table-bordered-x table-hover text-dark-m2 small" width="100%">
        <thead class="text-dark-m3 bgc-grey-l4">
          <tr>
            <th class="border-0">Tipo Egreso</th>
            <th class="border-0">Frecuencia</th>
            <th class="border-0">Monto</th>
            <th class="border-0">Tipo Pago</th>
            <th class="border-0">Acciones</th> 
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div><!-- /.col -->
  </div><!-- /.row -->
  <div class="col-lg-12 text-right">
  <br>
  <button type="button" id="agregar_egreso" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalEgresos"><i class="fas fa-address-book"></i> Agregar Egreso</button>
</div>

<!-- MODAL -->
<form id="egresos" name="egresos" action="">
  <div class="modal fade modal-lg" id="modalEgresos" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title text-success">Egreso</h5>
          <input  type="hidden" id="idkey_egreso" name="idkey_egreso"> 
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body ace-scrollbar">
        <div id="form_egreso">
          <div class="card-body">

            <div class="row" style="margin-bottom: 10px;">
              <div class="col-sm-6 col-md-1 col-lg-1">
                <input class="input-lg text-danger-m1 brc-on-checked brc-success brc-h-success-m1 border-2 electro1" type="checkbox" id="tipo_pago" name="tipo_pago">
              </div>
              <div class="col-sm-6 col-md-11 col-lg-11 text-success" style="margin-bottom: 0px; margin-top: 0px;">
                Seleccione si el monto de pago es fijo
              </div>
            </div>
            
            <div class="row" style="margin-bottom: 10px;">
              <div class="col-sm-12 col-md-6 col-lg-6">
                <label class="col-form-label form-control-label">Tipo<span style="color:red;">*</span></label>
                <select name="tipo_egreso" id="tipo_egreso" class="form-control form-control-sm" required>
                  <?php create_tipo_egreso(''); ?>
                </select>
              </div>
              <div class="col-sm-12 col-md-6 col-lg-6">
                <label class="col-form-label form-control-label" style="margin-top: 0px;">Frecuencia<span style="color:red;">*</span></label>
                <select name="frecuencia_egreso" id="frecuencia_egreso" class="form-control form-control-sm" required>
                  <?php create_frecuencia(); ?>
                </select>
              </div>
            </div>
            <div class="row" style="margin-bottom: 10px;">
              <div class="col-sm-12 col-md-12 col-lg-12">
                <label class="col-form-label form-control-label">Monto<span style="color:red;">*</span></label>
                <input type="" name="monto_egreso" id="monto_egreso" class="form-control form-control-sm" required>
              </div>
            </div>
            <div class="row" style="margin-bottom:10px;">
              <div class="col-sm-6 col-md-6 col-lg-6">
                <label class="col-form-label form-control-label" style="margin-top: 0px;">Desde</label>
                <div class="input-group date" id="id-timepicker">
                  <div class="input-group-addon input-group-append">
                    <div class="input-group-text">
                      <i class="fa fa-calendar"></i>
                    </div>
                  </div>
                  <input type="text" name="inicio_egreso" id="inicio_egreso" class="form-control form-control-sm" autocomplete="off">
                  <script>  $("#inicio_egreso").activeCalendary('#inicio_egreso'); </script>
                </div>
              </div>
              <div class="col-sm-6 col-md-6 col-lg-6">
                <label class="col-form-label form-control-label" style="margin-top: 0px;">Hasta</label>
                <div class="input-group date" id="id-timepicker">
                  <div class="input-group-addon input-group-append">
                    <div class="input-group-text">
                      <i class="fa fa-calendar"></i>
                    </div>
                  </div>
                   <input type="text" name="fin_egreso" id="fin_egreso" class="form-control form-control-sm" autocomplete="off">
                <script>  $("#fin_egreso").activeCalendary('#fin_egreso'); </script>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-12 col-lg-12">
                  <label class="col-form-label form-control-label">Descripción</label>
                  <textarea  class="form-control" rows="5" id="descripcion_egreso" name="descripcion_egreso"></textarea>
              </div>
            </div>

          </div>
        </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" id="cerrarModalEgresos" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success">Guardar Cambios</button>
        </div>

      </div>
    </div>
  </div>
</form>



<script type="text/javascript">

$(document).ready(function(){
    datatable_egresos();

    $("#egresos").validate({
        errorClass: 'text-error',  
        ignore: false,
        rules: {inicio_egreso: {FechaAnterior: true}}
    });
     

    //Envío de formulario ****************************************************************************************
    $( "#egresos" ).submit(function( event ) {
        if($("#egresos").valid()){

          $.ajax({
           url: '../php/json_func_cartera.php',
           type: 'POST',
           dataType: 'json',
           data: $("#egresos").serialize() + '&funcion=' + 'egreso'+'&idkey_cliente='+ $("#idkey_cliente").val(),
           success: function(response){
             console.log(response);
             if(response["error"] == 0){
                alertify.success("Datos guardados correctamente");

                $("#egresos")[0].reset();

                //se cierra el modal
                $("#modalEgresos").modal("toggle");
                $('.modal-backdrop').remove();


                //Refresh datatable
                var datatableE = $('#tablaEgresos').DataTable();
                datatableE.ajax.reload();
             }
             else
                bootbox.alert('Error inesperado al guardar el egreso. Inténtelo más tarde.');
           },
           error: function(data) {
              console.log(data);
            }
          });


        }
        else
          alertify.error("Algunos datos están incompletos o erróneos");
        event.preventDefault();//Detiene el envío del form y su recarga

    });//envío form*********************************************************************************************

    $('#agregar_egreso').on('click', function (e) {
      //Se resetea el form cuando se cierra el modal
      $("#egresos")[0].reset();
      $('#tipo_egreso').val('');
      $('#frecuencia_egreso').val('');
      $('#idkey_egreso').val('');
      var validator = $("#egresos").validate();
      validator.resetForm();
    });

  });

</script>






            