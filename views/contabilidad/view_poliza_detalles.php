<div class="row" style="overflow-x: auto;">

<!-- MODAL -->
<form id="detalle" name="detalle" action="">
  <div class="modal fade modal-lg" id="modalDetallesPolizas" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title text-success">Detalle de Póliza</h5>
          <input  type="hidden" id="idkey_poliza" name="idkey_poliza"> 
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body ace-scrollbar">

            <div class="card-body">

                <table class="table table table-striped table-borderless mt-2" style="overflow-x: auto;" id="tabla_datos_cliente">
                  <tbody>
                    <tr>
                      <td width="60px">
                        <i class="eva eva-hash-outline text-120 radius-round bgc-warning-l4 text-orange-d1 p-2 border-2 brc-warning-m3"></i>
                      </td>
                      <td class="text-100 text-default-d3" width="130px"><b>Número</b></td>
                      <td class="text-secondary-d2 text-wrap" id="numero"></td>
                    </tr>
                    <tr>
                      <td>
                        <i class="eva eva-calendar-outline text-120 radius-round bgc-warning-l4 text-orange-d1 p-2 border-2 brc-warning-m3"></i>
                      </td>
                      <td class="text-100 text-default-d3"><b>Fecha</b></td>
                      <td class="text-secondary-d2 text-wrap" id="fecha"></td>
                     </tr>
                    <tr>
                    <td>
                      <i class="eva eva-info-outline text-120 radius-round bgc-warning-l4 text-orange-d1 p-2 border-2 brc-warning-m3"></i>
                    </td>
                      <td class="text-100 text-default-d3"><b>Concepto</b></td>
                      <td class="text-secondary-d2 text-wrap" id="concepto"></td>
                    </tr>
                    <tr>
                      <td>
                        <i class="eva eva-expand-outline text-120 radius-round bgc-warning-l4 text-orange-d1 p-2 border-2 brc-warning-m3"></i>
                      </td>
                      <td class="text-100 text-default-d3"><b>Tipo</b></td>
                      <td class="text-secondary-d2 text-wrap" id="tipo"></td>
                    </tr>
                    <tr>
                      <td>
                        <i class="eva eva-clock-outline text-120 radius-round bgc-warning-l4 text-orange-d1 p-2 border-2 brc-warning-m3"></i>
                      </td>
                      <td class="text-100 text-default-d3"><b>Periodo</b></td>
                      <td class="text-secondary-d2 text-wrap" id="periodo"></td>
                    </tr>
                    <tr>
                      <td>
                        <i class="eva eva-copy-outline text-120 radius-round bgc-warning-l4 text-orange-d1 p-2 border-2 brc-warning-m3"></i>
                      </td>
                      <td class="text-100 text-default-d3"><b>Serie</b></td>
                      <td class="text-secondary-d2 text-wrap" id="serie"></td>
                    </tr>
                  </tbody>
                </table>

                <div class="row" style="overflow-x: auto;">
                  <div class="col-12 col-sm-12 col-md-12 col-lg-12">

                    <table id="tablaDetallePoliza" class="table table-bordered  table-hover text-dark-m2 small" width="100%">
                      <thead class="text-dark-m3 bgc-grey-l4">
                        <tr>
                          <th class="border-1">Cuenta Contable</th>
                          <th class="border-1">Referencia</th>
                          <th class="border-1">Debe</th>
                          <th class="border-1">Haber</th>
                          <th class="border-1">Descripción</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </div><!-- /.col -->
                </div><!-- /.row -->
              
            </div>

        
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="cerrarModalIngresos" data-dismiss="modal">Cancelar</button>
          </div>

      </div>
    </div>
  </div>
</form>



<script type="text/javascript">

$(document).ready(function(){

    //Envío de formulario ****************************************************************************************
    $( "#ingresos" ).submit(function( event ) {
        if($("#ingresos").valid()){

          $.ajax({
           url: '../php/json_func_cartera.php',
           type: 'POST',
           dataType: 'json',
           data: $("#ingresos").serialize() + '&funcion=' + 'ingreso'+'&idkey_cliente='+ $("#idkey_cliente").val(),
           success: function(response){
             console.log(response);
             if(response["error"] == 0){
                alertify.success("Datos guardados correctamente");

                $("#ingresos")[0].reset();

                //se cierra el modal
                $("#modalIngresos").modal("toggle");
                $('.modal-backdrop').remove();


                //Refresh datatable
                var datatableIng = $('#tablaIngresos').DataTable();
                datatableIng.ajax.reload();
             }
             else
                bootbox.alert('Error inesperado al guardar el ingreso. Inténtelo más tarde.');
           },
            error: function(data) {
              alertify.error("Ha ocurrido un error inesperado. Inténtelo más tarde!");
              console.log(data);
            }
          });


        }
        else
          alertify.error("Algunos datos están incompletos o erróneos");
        event.preventDefault();//Detiene el envío del form y su recarga

    });//envío form*********************************************************************************************

    $('#agregar_ingreso').on('click', function (e) {
      //Se resetea el form cuando se cierra el modal
      $("#ingresos")[0].reset();
      
      $('#ingreso_tipo').prop('selectedIndex',0);
      $('#ingreso_frec').prop('selectedIndex',0);
      $('#id_empleador').prop('selectedIndex',0);
      $('#actividad_siti').prop('selectedIndex',0);
      $('#ingreso_comprobable').prop('selectedIndex',0);
      $('#domicilio_empleador').html('');
      $('#estatus_ffin').prop('checked', true);
      $('#f_fin').attr('disabled', false);
      $('#idkey_ingreso').val("");

      var validator = $("#ingresos").validate();
      validator.resetForm();
    });

  });

function estatus_ffin(){
  if ($('#fin_estatus').is(":checked"))
    $('#f_fin').attr('disabled', false);
  else{
    $('#f_fin').attr('disabled', true);
    $('#f_fin').val("");
  }
}

</script>






            