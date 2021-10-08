<div class="row" style="overflow-x: auto;">
    <div class="col-12">

      <table id="tablaIngresos" class="table table-bordered table-bordered-x table-hover text-dark-m2 small" width="100%">
        <thead class="text-dark-m3 bgc-grey-l4">
          <tr>
            <th class="border-0" >Empleador</th>
            <th class="border-0">Tipo Ingreso</th>
            <th class="border-0">Monto</th>
            <th class="border-0">Frecuencia</th>
            <th class="border-0">Bajo Contrato</th>
            <th class="border-0">Arraigo Laboral</th>  
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
  <button type="button" id="agregar_ingreso" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalIngresos"><i class="fas fa-address-book"></i> Agregar Ingreso</button>
</div>

<!-- MODAL -->
<form id="ingresos" name="ingresos" action="">
  <div class="modal fade modal-lg" id="modalIngresos" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title text-success">Ingreso</h5>
          <input  type="hidden" id="idkey_ingreso" name="idkey_ingreso"> 
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body ace-scrollbar">

        <div id="form_ingreso">


          <div class="card-body">
              <div class="form-group row" >
                <div class="col-sm-12 col-md-1 col-lg-1" style="margin-bottom: 0px; margin-top: 0px;">
                  <input class="input-lg text-danger-m1 brc-on-checked brc-success brc-h-success-m1 border-2 electro1" type="checkbox" id="principal" name="principal">
                </div>
                <div class="col-sm-12 col-md-11 col-lg-11 text-success" style="margin-bottom: 0px; margin-top: 0px;">
                  Seleccione sólo si es el ingreso principal
                </div>
              </div>
              <div class="form-group row" >
                <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 5px; margin-top: 0px;">
                    <label class="col-form-label form-control-label" style="margin-top: 0px;">Tipo<span style="color:red;">*</span></label>
                    <select name="ingreso_tipo" id="ingreso_tipo" class="form-control form-control-sm" required="">

                      <?php create_tipo_ingreso(''); ?>

                    </select>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 5px; margin-top: 0px;">
                    <label class="col-form-label form-control-label" style="margin-top: 0px;">Frecuencia<span style="color:red;">*</span></label>
                    <select name="ingreso_frec" id="ingreso_frec" class="form-control form-control-sm" required="">

                      <?php create_frecuencia(''); ?>

                    </select>
                </div>
              </div>
              <div class="form-group row" >
                <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 5px; margin-top: 0px;">
                    <label class="col-form-label form-control-label" style="margin-top: 0px;">Monto<span style="color:red;">*</span></label>
                    <input type="text" name="monto" id="monto" class="form-control form-control-sm" required="">
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 5px; margin-top: 0px;">
                    <label class="col-form-label form-control-label" style="margin-top: 0px;">Empleador/Empresa<span style="color:red;">*</span></label>
                    <select id="id_empleador" name="id_empleador" class="form-control form-control-sm" required="">
                      
                      <?php create_empleador(''); ?>

                    </select>
                </div>
              </div>

              <div class="form-group row">
                <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 5px; margin-top: 0px;">
                  <label class="col-form-label form-control-label" style="margin-top: 0px;">Desde<span style="color:red;">*</span></label>
                  <div class="input-group date" id="id-timepicker">
                      <div class="input-group-addon input-group-append">
                          <div class="input-group-text">
                             <i class="fa fa-calendar"></i>
                          </div>
                      </div>
                      <input type="text" name="f_inicio" id="f_inicio" class="form-control form-control-sm" required="" autocomplete="off">
                      <script>  $("#f_inicio").activeCalendary('#f_inicio'); </script>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 5px; margin-top: 0px;">
                  <label class="col-form-label form-control-label" style="margin-top: 0px;">Hasta</label>
                  <div class="input-group date" id="id-timepicker">
                    <div class="input-group-addon input-group-append">
                      <div class="input-group-text">
                        <i class="fa fa-calendar"></i>
                      </div>
                    </div>
                    <input type="text" name="f_fin" id="f_fin" class="form-control form-control-sm" autocomplete="off">

                    <input class="input-lg text-success-m1 brc-on-checked brc-success brc-h-success-m1 border-2 electro1" style="margin-left: 5px; margin-top: 5px;" type="checkbox" id="fin_estatus" name="fin_estatus" checked="true" onclick="estatus_ffin()">
                    <script>  $("#f_fin").activeCalendary('#f_fin'); </script>
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 5px; margin-top: 0px;">
                    <label class="col-form-label form-control-label" style="margin-top: 0px;">Profesión<span style="color:red;">*</span></label>
                    <input type="text" name="profesion" id="profesion" class="form-control form-control-sm" required>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 5px; margin-top: 0px;">
                    <label class="col-form-label form-control-label" style="margin-top: 0px;">Ocupación/Puesto<span style="color:red;">*</span></label>
                    <input type="text" name="ocupacion" id="ocupacion" class="form-control form-control-sm" required="">
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 10px; margin-top: 0px;">
                    <label class="col-form-label form-control-label" style="margin-top: 0px;">Jefe Directo</label>
                    <select name="jefe_directo" id="jefe_directo"  class="form-control form-control-sm" style="width: 100%">
                        <?php 
                          $seleccion = "";
                          create_cargos_publicos($seleccion); 
                        ?>
                    </select>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-1 col-md-1 col-lg-1" style="margin-bottom: 5px;">
                  <input class="input-lg text-danger-m1 brc-on-checked brc-success brc-h-success-m1 border-2 electro1" type="checkbox" id="bajo_contrato" name="bajo_contrato">
                </div>
                <div class="col-sm-11 col-md-11 col-lg-11 text-success" style="margin-bottom: 5px; margin-top: 0px;">
                  Seleccione si está bajo contrato
                </div>
              </div>
              <div class="form-group row" >
                <div class="col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 12px; margin-top: 0px;">
                  <label class="col-form-label form-control-label" style="margin-top: 0px;">Actividad Económica SITI</label>
                  <select name="actividad_siti" id="actividad_siti" class="form-control form-control-sm" style="width: 100%">
                    <?php 
                      $seleccion = "";
                      create_cargos_publicos($seleccion); 
                    ?>
                  </select>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 12px; margin-top: 0px;">
                  <label class="col-form-label form-control-label" style="margin-top: 0px;">Comprobación de ingresos</label>
                  <select name="ingreso_comprobable" id="ingreso_comprobable" class="form-control form-control-sm">
                    <option value=""></option>
                    <option value="20">Total</option>
                    <option value="15">Parcial</option>
                    <option value="10">No comprobable</option>
                    </select>
                </div>
              </div>            
              <div class="form-group row">
                <div class="col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 5px; margin-top: 0px;">
                    <label class="col-form-label form-control-label" style="margin-top: 0px;">Domicilio Empresa/Empleador</label>
                    <input type="text" id="domicilio_empleador" name="domicilio_empleador" class="form-control form-control-sm" />
                </div>
                
              </div>
              <div class="form-group row">
                <div class="col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 12px; margin-top: 0px;">
                    <label class="col-form-label form-control-label" style="margin-top: 0px;">Descripción</label>
                    <textarea  class="form-control" rows="5" id="ingreso_desc" name="ingreso_desc"></textarea>
                </div>
              </div>
          </div>
            
        </div><!--div id=ingreso-->

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" id="cerrarModalIngresos" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success">Guardar Cambios</button>
        </div>

      </div>
    </div>
  </div>
</form>



<script type="text/javascript">

$(document).ready(function(){
    $('#jefe_directo').select2({
      dropdownParent: $('#modalIngresos')
    });

    $('#actividad_siti').select2({
      dropdownParent: $('#modalIngresos')
    });

    datatable_ingresos();

    $("#ingresos").validate({
        errorClass: 'text-error',  
        ignore: false,
        rules: {f_inicio: {FechaAnterior: true}}
    });
     

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






            