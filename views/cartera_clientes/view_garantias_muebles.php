<div class="row" style="overflow-x: auto;">
    <div class="col-12">
       <h5 class="font-light text-success-d2"> 
        <span><a class="text-success-d2">Garantías Muebles</a></span>
      </h5>
      <table id="tablaMuebles" class="table table-bordered table-bordered-x table-hover text-dark-m2 small" width="100%">
        <thead class="text-dark-m3 bgc-grey-l4">
          <tr>
            <th class="border-0" >Categoría</th>
            <th class="border-0">Valor comercial</th>
            <th class="border-0">Modelo</th>
            <th class="border-0">Marca</th>
            <th class="border-0">Factura/ Referencia</th>
            <th class="border-0"><i class="far fa-clock text-110 text-success-d1"></i>Fecha Adq.</th>  
            <th class="border-0">Observaciones</th>  
            <th class="border-0">Acciones</th> 
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div><!-- /.col -->
  </div><!-- /.row -->
  <br>
  <div class="col-lg-12 text-right">
    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" id="agregar_mueble" data-target="#modalMuebles"><i class="fas fa-address-book"></i> Agregar Muebles</button>
  </div>

<!-- MODAL -->
<form id="muebles" name="muebles" action="">
  <div class="modal fade modal-lg" id="modalMuebles" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title text-success">Garantía Mueble</h5>
          <input  type="hidden" id="idkey_mueble" name="idkey_mueble"> 
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body ace-scrollbar">
          
        <div id="form_mueble">
            <div class="row">
              <div class="col-sm-12 col-md-6 col-lg-6">
                <label class="col-form-label form-control-label" >Categoria<span style="color:red;">*</span></label>
                <select name="garantias_categorias" id="garantias_categorias" class="form-control form-control-sm" required>
                  <?php create_garantia_categoria_muebles(""); ?>
                </select>
              </div>
              <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 8px; margin-top: 0px;">
                <label class="col-form-label form-control-label" style="margin-top: 0px;">Valor comercial<span style="color:red;">*</span></label>
                <input type="" name="valor_comercial" id="valor_comercial" class="form-control form-control-sm" required>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 8px; margin-top: 0px;">
                <label class="col-form-label form-control-label" >Marca<span style="color:red;">*</span></label>
                <input type="" name="marca" id="marca" class="form-control form-control-sm" required>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 8px; margin-top: 0px;">
                <label class="col-form-label form-control-label" >Modelo<span style="color:red;">*</span></label>
                <input type="" name="modelo" id="modelo" class="form-control form-control-sm" required>
              </div>                               
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 8px; margin-top: 0px;">
                <label class="col-form-label form-control-label" >Referencia o Factura<span style="color:red;">*</span></label>
                <input type="" name="referencia_factura" id="referencia_factura" class="form-control form-control-sm" required>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 8px; margin-top: 0px;">
                <label class="col-form-label form-control-label" >Fecha de Adquisición<span style="color:red;">*</span></label>
                <div class="input-group date" id="id-timepicker">
                  <div class="input-group-addon input-group-append">
                      <div class="input-group-text">
                         <i class="fa fa-calendar"></i>
                      </div>
                  </div>
                  <input type="text" name="fecha_adquisicion" id="fecha_adquisicion" class="form-control form-control-sm" required autocomplete="off">
                  <script> $("#fecha_adquisicion").activeCalendary('#fecha_adquisicion'); </script>
               </div>
              </div>
              <div class="col-sm-12 col-md-6 col-lg-6" style="margin-bottom: 8px; margin-top: 0px;">
                <label class="col-form-label form-control-label" >Cobertura<span style="color:red;">*</span></label>
                <select name="cobertura" id="cobertura" class="form-control form-control-sm" required>
                  <option value=""></option>
                  <option value="10">Mayor al 100%</option>
                  <option value="8">Igual al 100%</option>
                  <option value="5">Menor al 100%</option>
                </select>
              </div>
            </div>
            <div class="row">
             
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 12px; margin-top: 0px;">
                <label class="col-form-label form-control-label" style="margin-top: 0px;">Observaciones</label>
                <textarea  class="form-control" rows="4"  name="mueble_observaciones" id="mueble_observaciones"></textarea>
              </div>
            </div>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" id="cerrarModal2" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success">Guardar Cambios</button>
        </div>

      </div>
    </div>
  </div>
</form>



<script type="text/javascript">

$(document).ready(function(){
    datatable_muebles();

     $("#muebles").validate({
        errorClass: 'text-error',  
        ignore: false,
        rules:{fecha_adquisicion:{FechaAnterior: true}
        }
    });

    //Envío de formulario ****************************************************************************************
    $( "#muebles" ).submit(function( event ) {
        if($("#muebles").valid()){

          $.ajax({
           url: '../php/json_func_cartera.php',
           type: 'POST',
           dataType: 'json',
           data: $("#muebles").serialize() + '&funcion=' + 'mueble'+'&idkey_cliente='+ $("#idkey_cliente").val(),
           success: function(response){
             if(response["error"] == 0){
                alertify.success("Datos guardados correctamente");

                $("#muebles")[0].reset();

                //se cierra el modal
                $("#modalMuebles").modal("toggle");
                $('.modal-backdrop').remove();


                //Refresh datatable
                var datatableM = $('#tablaMuebles').DataTable();
                datatableM.ajax.reload();
             }
             else
                bootbox.alert('Error inesperado al guardar el mueble. Inténtelo más tarde.');
           }
          });


        }
        else
          alertify.error("Algunos datos están incompletos o erróneos");
        event.preventDefault();//Detiene el envío del form y su recarga

    });//envío form*********************************************************************************************

  
    $('#agregar_mueble').on('click', function (e) {
      //Se resetea el form cuando se cierra el modal
      $("#muebles")[0].reset();
      
      $('#cobertura').val('');

      $('#idkey_mueble').val('');


      var validator = $("#muebles").validate();
      validator.resetForm();
    });

  });

</script>






            