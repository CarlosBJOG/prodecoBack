var url_balance = '../php/json_func_balance.php';

function datatable_balance(finicio, ffin){
    var parametros = {
        "funcion" : "datatable_balance",
        fecha_inicio: finicio,
        fecha_fin : ffin
    };
    $.ajax({
        url: url_balance,
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

            var table = $("#datatable").dataTable(); 

            table.fnClearTable();//Para borrar contenido de datatable y volver a cargar

            $.each(response, function(i, response) {
              //Para alimentar el datatable
              table.fnAddData([
                '<input type="checkbox" autocomplete="off" />',
                response.folio,
                response.no_cuenta,
                response.nombre_cuenta,
                response.fecha,
                response.debe,
                response.haber,
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