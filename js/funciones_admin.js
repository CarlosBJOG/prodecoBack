var url_admin = '../php/json_func_admin.php';

function datatable_bitacoras_creditos(folio_credito){
    var parametros = {
        "funcion" : "datatable_bitacoras_creditos",
        folio: folio_credito
    };
    $.ajax({
        url: url_admin,
        data: parametros,
        type: 'post',
        dataType: 'json',
        asycn: true,
        beforeSend: function () {
          Swal.fire({
              title: '¡Espere un momento!',
              html: 'Cargando...',
              allowOutsideClick: false,
              onBeforeOpen: () => {
                  Swal.showLoading()
              },
          });
        },
        success: function (response) {
            console.log(response);
            var table = $("#datatable").dataTable(); 
            table.fnClearTable();//Para borrar contenido de datatable y volver a cargar

            $.each(response, function(i, response) {
              //Para alimentar el datatable
              table.fnAddData([
                '<input type="checkbox" autocomplete="off" />',
                response.folio,
                response.fecha,
                response.descripcion,
                response.usuario,
                '<a href="#" class="btn radius-1 btn-sm btn-brc-tp btn-outline-default btn-h-outline-warning btn-a-outline-warning btn-text-warning"><i class="fa fa-flag"></i></a>'
              ]);
            });
            swal.close();
        },
        error: function(data) {
           swal.close();
          alertify.error("Ha ocurrido un error inesperado. Inténtelo más tarde!");
          console.log(data);
        }
    });
  }