<div class="row" style="overflow-x: auto;">
    <div class="col-12">

      <table id="tablaContactos" class="table table-bordered table-bordered-x table-hover text-dark-m2 small" width="100%">
        <thead class="text-dark-m3 bgc-grey-l4">
          <tr>
            <th class="border-0" >Descripción</th>
            <th class="border-0">Teléfono</th>
            <th class="border-0">Correo Electrónico</th>
            <th class="border-0">Prioridad</th>
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
  <button type="button" id="agregar_contacto" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalContactos"><i class="fas fa-address-book"></i> Agregar Contacto</button>
</div>


<script type="text/javascript">

$(document).ready(function(){
    datatable_contactos();

    $("#contactos").validate({
        errorClass: 'text-error',  
        ignore: false,
        rules: {}
    });
     

    //Envío de formulario ****************************************************************************************
    $( "#contactos" ).submit(function( event ) {
        if($("#contactos").valid()){

          $.ajax({
           url: '../php/json_func_cartera.php',
           type: 'POST',
           dataType: 'json',
           data: $("#contactos").serialize() + '&funcion=' + 'contacto'+'&idkey_cliente='+ $("#idkey_cliente").val(),
           success: function(response){
             console.log(response);
             if(response["error"] == 0){
                alertify.success("Datos guardados correctamente");

                $("#contactos")[0].reset();

                //se cierra el modal
                $("#modalContactos").modal("toggle");
                $('.modal-backdrop').remove();


                //Refresh datatable
                var datatableCont = $('#tablaContactos').DataTable();
                datatableCont.ajax.reload();
             }
             else
                bootbox.alert('Error inesperado al guardar el contacto. Inténtelo más tarde.');
           }
          });


        }
        else
          alertify.error("Algunos datos están incompletos o erróneos");
        event.preventDefault();//Detiene el envío del form y su recarga

    });//envío form*********************************************************************************************

    $('#agregar_contacto').on('click', function (e) {
      //Se resetea el form cuando se cierra el modal
      $("#contactos")[0].reset();

       $('#contacto_prioridad').val('');

      var validator = $("#contactos").validate();
      validator.resetForm();
    });

  });

</script>






            