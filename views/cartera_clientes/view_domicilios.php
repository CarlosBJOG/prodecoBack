<hr>
<div class="row" style="overflow-x: auto;">
    <div class="col-12">
       <h5 class="font-light text-success-d2"> 
    <span><a class="text-success-d2">Domicilios Adicionales</a></span>
  </h5>
      <table id="tablaDomicilios" class="table table-bordered table-bordered-x table-hover text-dark-m2 small datatable" width="100%">
        <thead class="text-dark-m3 bgc-grey-l4">
          <tr>
            <th>Tipo</th>
            <th>Dirección</th>
            <th>Empezó a habitar</th>
            <th>Vialidad</th>
            <th>Acciones</th>  
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div><!-- /.col -->
  </div><!-- /.row -->
  <br>
  <div class="col-lg-12 text-right">
  <button type="button" class="btn btn-info btn-sm" data-toggle="modal" id="agregar_dom" data-target="#modalDirecciones"><i class="fas fa-address-book"></i> Agregar Domicilio</button>
</div>




<script type="text/javascript">

$(document).ready(function(){

  datatable_direcciones();

  $("#direccionesAdic").validate({
      errorClass: 'text-error',  
      ignore: false,
      rules:{inicia_habitar1:{FechaAnterior: true}}
  });

  //Envío de formulario ****************************************************************************************
  $("#direccionesAdic" ).submit(function( event ) {
      if($("#direccionesAdic").valid()){
        
        $.ajax({
         url: '../php/json_func_cartera.php',
         type: 'POST',
         dataType: 'json',
         data: $("#direccionesAdic").serialize() + '&funcion=' + 'domicilio_adicional'+'&idkey_cliente='+ $("#idkey_cliente").val(),
         success: function(response){
           
           if(response["error"] == 0){
              alertify.success("Datos guardados correctamente");

              $("#direccionesAdic")[0].reset();

              //se cierra el modal
              $('#modalDirecciones').modal("toggle");
              $('.modal-backdrop').remove(); 

              //Refresh datatable
              var datatableDom = $('#tablaDomicilios').DataTable();
              datatableDom.ajax.reload();
              cargar_dom_fiscales();//Se actualizan los domicilios fiscales
           }
           else
              bootbox.alert('Error inesperado al guardar el domicilio. Inténtelo más tarde.');
         }
        });
      }
      else
        alertify.error("Algunos datos están incompletos o erróneos");
      event.preventDefault();//Detiene el envío del form y su recarga

  });//envío form*********************************************************************************************


  $('#agregar_dom').on('click', function (e) {
    //Se resetea el form cuando se cierra el modal
    $("#direccionesAdic")[0].reset();
    $('#tipo_direccion1').val('');
    $('#estados1').val('');
    $('#municipios1').html('');
    $('#localidad1').html('');
    $('#codigo_postal1').html('');

     var validator = $("#direccionesAdic").validate();
    validator.resetForm();
   
  });

});
</script>


