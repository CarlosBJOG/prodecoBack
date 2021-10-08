<div class="row" style="overflow-x: auto;">
    <div class="col-12">
       <h5 class="font-light text-success-d2"> 
    <span><a class="text-success-d2">Garantías Inmuebles</a></span>
  </h5>
      <table id="tablaInmuebles" class="table table-bordered table-bordered-x table-hover text-dark-m2 small" width="100%">
        <thead class="text-dark-m3 bgc-grey-l4">
          <tr>
            <th>Categoría</th>
            <th>Valor Fiscal</th>
            <th>Valor Catastral</th>
            <th>Escrituras</th>
            <th>Registro</th>
            <th>Medidas</th>
            <th>Acciones</th>  
          </tr>
        </thead>

        <tbody></tbody>
      </table>
    </div><!-- /.col -->
  </div><!-- /.row -->
  <br>
  <div class="col-lg-12 text-right">
  <button type="button" id="agregar_inmueble" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalInmuebles"><i class="fas fa-address-book"></i> Agregar Inmuebles</button>
</div>

<!-- MODAL -->
<form id="inmuebles" name="inmuebles" action="">
  <div class="modal fade modal-lg" id="modalInmuebles" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-lg" role="document">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title text-success">Garantía Inmueble</h5>
          <input  type="hidden" id="idkey_inmueble" name="idkey_inmueble"> 
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body ace-scrollbar">
          
          <div id="form_inmueble" >
            <div class="row">
              <div class="col-sm-12 col-md-6 col-lg-6">
                <label class="col-form-label form-control-label" >Categoría<span style="color:red;">*</span></label>
                <select name="garantias_categorias1" id="garantias_categorias1" class="form-control form-control-sm" required>
                   <?php create_garantia_categoria_inmuebles(""); ?>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-6 col-lg-6">
                <label class="col-form-label form-control-label" >Valor Fiscal<span style="color:red;">*</span></label>
                <input type="text" name="valor_fiscal" id="valor_fiscal" class="form-control form-control-sm" required="">
              </div>                               
              <div class="col-sm-12 col-md-6 col-lg-6">
                <label class="col-form-label form-control-label" >Valor Catastral<span style="color:red;">*</span></label>
                <input type="text" name="valor_catastral" id="valor_catastral" name="valor_catastral" class="form-control form-control-sm" required="">
              </div>
                                         
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-12 col-lg-12">
                <label class="col-form-label form-control-label" >Número de Escritura</label>
                <input type="text" name="escritura" id="escritura" class="form-control form-control-sm">
              </div>  
            </div>
            <div class="row">  
              <div class="col-sm-12 col-md-6 col-lg-6">
                  <label class="col-form-label form-control-label" >Registro</label>
                  <input type="text" name="registro" id="registro" class="form-control form-control-sm">
              </div>                               
              <div class="col-sm-12 col-md-6 col-lg-6">
                <label class="col-form-label form-control-label" >Gravamen</label>
                <input type="text" name="gravamen" id="gravamen" class="form-control form-control-sm">
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-6 col-lg-6">
                <label class="col-form-label form-control-label" style="margin-top: 8pxpx;">Hipoteca</label>
                <input type="text" name="hipoteca" id="hipoteca" class="form-control form-control-sm">
              </div>
              <div class="col-sm-12 col-md-6 col-lg-6">
                <label class="col-form-label form-control-label" >Aforo</label>
                <select name="aforo" id="aforo" class="form-control form-control-sm">
                  <option value=""></option>
                  <option value="10">Aforo 2 a 1</option>
                  <option value="10.1">Aforo 1 a 1</option>
                  <option value="5">Aforo menor</option>
                  <option value="0.1">Inviable</option>
                </select>
              </div>
            </div>
  
            <div class="col-sm-12 col-md-12 col-lg-12">
              <label class="col-form-label form-control-label" >Descripción</label>
              <textarea  class="form-control" rows="3" id="inmueble_descripcion" name="inmueble_descripcion"></textarea>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-12">
              <label class="col-form-label form-control-label">Observaciones</label>
              <textarea  class="form-control" rows="3" id="inmueble_observaciones" name="inmueble_observaciones"></textarea>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-12" style="margin-bottom: 12px; margin-top: 0px;">
              <label class="col-form-label form-control-label">Medidas y Colindancias</label>
              <textarea  class="form-control" rows="3" id="inmueble_medidas" name="inmueble_medidas"></textarea>
            </div>
            
          </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" id="cerrarModal1" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success">Guardar Cambios</button>
        </div>

      </div>
    </div>
  </div>
</div>
</form>


<script type="text/javascript">

$(document).ready(function(){
  datatable_inmuebles();

   $("#inmuebles").validate({
      errorClass: 'text-error',  
      ignore: false,
      rules:{}
  });

  //Envío de formulario ****************************************************************************************
    $("#inmuebles" ).submit(function( event ) {
        if($("#inmuebles").valid()){

          $.ajax({
           url: '../php/json_func_cartera.php',
           type: 'POST',
           dataType: 'json',
           data: $("#inmuebles").serialize() + '&funcion=' + 'inmueble'+'&idkey_cliente='+ $("#idkey_cliente").val(),
           success: function(response){
             if(response["error"] == 0){
                alertify.success("Datos guardados correctamente");

                $("#inmuebles")[0].reset();

                //se cierra el modal
                $("#modalInmuebles").modal("toggle");
                $('.modal-backdrop').remove();


                //Refresh datatable
                var datatableI = $('#tablaInmuebles').DataTable();
                datatableI.ajax.reload();
             }
             else
                bootbox.alert('Error inesperado al guardar el inmueble. Inténtelo más tarde.');
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
   
  $('#agregar_inmueble').on('click', function (e) {
      //Se resetea el form cuando se cierra el modal
      $("#inmuebles")[0].reset();
      
      $('#aforo').val('');
      $('#idkey_inmueble').val('');

      var validator = $("#inmuebles").validate();
      validator.resetForm();
  });

});

</script>


