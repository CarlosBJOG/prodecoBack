var url_cont = '../php/json_func_contabilidad.php';

function datatable_colocacion(){
  //Se consultan todos los desembolsos en efectivo y en cheque
    var parametros = {
        "funcion" : "datatable_colocacion",
    };
    $.ajax({
        url: url_cont,
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

            $.each(response, function(i, response) {

              //Para alimentar el datatable
              table.fnAddData([
                response.checkbox,
                response.folio,
                response.nombre,
                response.fecha_desembolso,
                response.tipo_desembolso,
                response.estatus,
                response.tipo,
                response.monto,
                response.monto_solicitado,
                response.opciones
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

  function datatable_colocacion_egreso(){
    var parametros = {
        "funcion" : "datatable_colocacion_egreso",
    };
    $.ajax({
        url: url_cont,
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

            $.each(response, function(i, response) {
              //Para los colores de status
             
              //Para alimentar el datatable
              table.fnAddData([
                response.checkbox,
                response.no_poliza,
                response.fecha,
                response.concepto,
                response.monto,
                response.nombre_poliza,
                '<div><pre>'+response.botones+
                '<a href="#" class="btn radius-1 btn-sm btn-brc-tp btn-outline-default btn-h-outline-warning btn-a-outline-warning btn-text-warning"><i class="fa fa-flag"></i></a></pre></div>'
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


  function cargar_poliza_egreso(tipo_desembolso){
    if(tipo_desembolso==1){
      var nombre = 'cred_efectivo';
      var checked = $("#"+nombre+":checked").length;
      var nuevo_estatus_desembolso = 4; //en colocación
      var tipo_poliza_egreso = 1; //en efectivo
    }
    else if(tipo_desembolso==2){
      var nombre = 'cred_transferencia';
      var checked = $("#"+nombre+":checked").length;
      var nuevo_estatus_desembolso = 5; //desembolsado
      var tipo_poliza_egreso = 2; //transferencia
    }
    else if(tipo_desembolso==3){
      var nombre = 'cred_cheque';
      var checked = $("#"+nombre+":checked").length;
      var nuevo_estatus_desembolso = 4; //en colocación
      var tipo_poliza_egreso = 3; //cheque
    }

    if(tipo_desembolso==1 && checked==0)
      Swal.fire('Aviso','¡Debes seleccionar al menos un crédito  con desembolso en Efectivo para generar la póliza!','info');
    else if(tipo_desembolso==2 && checked!=1)
      Swal.fire('Aviso','¡Debes seleccionar un sólo crédito con desembolso de Transferencia para generar la póliza!','info');
    else if(tipo_desembolso==3 && checked!=1)
      Swal.fire('Aviso','¡Debes seleccionar un sólo crédito con desembolso de Cheque para generar la póliza!','info');
    else{
      //Reset del form
      $("#formPoliza")[0].reset();
      var validator = $("#formPoliza").validate();
      validator.resetForm();

      $("#modalPoliza").modal("show");
      var creds = new Array();
      $("input[name='"+nombre+"']:checked").each(function() {
          creds.push($(this).val());
      });

      $.ajax({
          url: url_cont,
          data: {
            funcion: 'cargar_poliza_egreso',
            creditos: creds
          },
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
              //$("input:checkbox").prop('disabled', true);
              $('#nuevo_estatus_desembolso').val(nuevo_estatus_desembolso);
              $('#tipo_poliza_egreso').val(tipo_poliza_egreso);
              $('#folios').html(response.folios);
              $('#montos').html(response.montos);
              $('#monto').val(response.monto_total);
              $('#debe1').val(response.monto_total);
              $('#debe2').val(0);
              $('#haber1').val(0);
              $('#haber2').val(response.monto_total);
              $('#fecha_poliza').val(response.fecha_poliza);
              $('#cuenta_contable1').html(response.cuentas);
              $('#cuenta_contable2').html(response.cuentas);
              swal.close();
          },
          error: function(data) {
            swal.close();
            alertify.error("Ha ocurrido un error inesperado. Inténtelo más tarde!");
            $('#colocacionForm').hide();
            console.log(data);
          }
      });
    }
  }

  function guardar_poliza_egreso(){
    $.ajax({   
     url: url_cont,   
     data: $("#formPoliza").serialize()+ '&funcion=guardar_poliza_egreso',                  
     type: "POST",                 
     dataType: "json",
     asycn: true,
     beforeSend: function () {
      Swal.fire({
          title: '¡Espere un momento!',
          html: 'Guardando...',
          allowOutsideClick: false,
          onBeforeOpen: () => {
              Swal.showLoading()
          },
      });
     },
     success: function(response){
      console.log(response);
      swal.close();
       if(response["error"]=='0'){  
          Swal.fire({
            type: 'success',
            icon: 'success',
            title: 'Póliza generada correctamente',
            confirmButtonText: 'Aceptar',
            text: 'Número de póliza: '+response.no_poliza,
            footer: '',
            showCloseButton: true
          })
          .then(function (result) {
              window.location = "../contabilidad/colocacion_detalle_poliza_egreso.php?idkey_poliza_egreso="+response.idkey_poliza_egreso;
         });
       } 
       else
          Swal.fire("¡Ha ocurrido un error inesperado! Inténtelo más tarde.", '', 'error');
      },
      error: function(data) {
        swal.close();
        alertify.error("Ha ocurrido un error inesperado. Inténtelo más tarde!");
        $('#colocacionForm').hide();
        console.log(data);
      }
    });
  }

  function cargar_datos_pdiario(idkey_poliza_egreso, monto, idkey_tipo_poliza){
    $("#formPDiario")[0].reset();
    var validator = $("#formPDiario").validate();
    validator.resetForm();

    $("#idkey_poliza_egreso").val(idkey_poliza_egreso);
    $("#monto").val(monto);
    $("#debe2").val(monto);
    $("#haber1").val(monto);
    $("#idkey_tipo_poliza").val(idkey_tipo_poliza);

  }

  function guardar_poliza_diario(){
    $.ajax({   
     url: url_cont,   
     data: $("#formPDiario").serialize()+ '&funcion=guardar_poliza_diario',                  
     type: "POST",                 
     dataType: "json",
     asycn: true,
     beforeSend: function () {
      Swal.fire({
          title: '¡Espere un momento!',
          html: 'Guardando...',
          allowOutsideClick: false,
          onBeforeOpen: () => {
              Swal.showLoading()
          },
      });
     },
     success: function(response){
      console.log(response);
      swal.close();
       if(response["error"]=='0'){  
          Swal.fire({
            type: 'success',
            icon: 'success',
            title: 'Póliza generada correctamente',
            confirmButtonText: 'Aceptar',
            text: 'Número de póliza: '+response.no_poliza,
            footer: '',
            showCloseButton: true
          })
          .then(function (result) {
              window.location = "../contabilidad/colocacion_detalle_poliza_egreso.php?idkey_poliza_egreso="+response.idkey_poliza_egreso;
         });
       } 
       else
          Swal.fire("¡Ha ocurrido un error inesperado! Inténtelo más tarde.", '', 'error');
      },
      error: function(data) {
        swal.close();
        alertify.error("Ha ocurrido un error inesperado. Inténtelo más tarde!");
        console.log(data);
      }
    });
  }

  function datatable_polizas(){
    var parametros = {
        "funcion" : "datatable_polizas",
    };
    $.ajax({
        url: url_cont,
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

            $.each(response, function(i, response) {

              //Para alimentar el datatable
              table.fnAddData([
                '<input type="checkbox" autocomplete="off"/>',
                response.folio,
                response.no_poliza,
                response.fecha,
                response.concepto,
                response.monto,
                response.tipo,
                response.nombre,
                response.opciones
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

  function guardar_poliza_general(){
    $.ajax({   
     url: url_cont,   
     data: $("#polizasForm").serialize()+ '&funcion=guardar_poliza_general',                  
     type: "POST",                 
     dataType: "json",
     asycn: true,
     beforeSend: function () {
      Swal.fire({
          title: '¡Espere un momento!',
          html: 'Guardando...',
          allowOutsideClick: false,
          onBeforeOpen: () => {
              Swal.showLoading()
          },
      });
     },
     success: function(response){
      console.log(response);
      swal.close();
       if(response["error"]=='0'){  
          Swal.fire({
            type: 'success',
            icon: 'success',
            title: 'Póliza guardada correctamente',
            confirmButtonText: 'Aceptar',
            text: 'Número de póliza: '+response.no_poliza,
            footer: '',
            showCloseButton: true
          })
          .then(function (result) {
              window.location = "../contabilidad/polizas.php";
         });
       } 
       else
          Swal.fire("¡Ha ocurrido un error inesperado! Inténtelo más tarde.", '', 'error');
      },
      error: function(data) {
        swal.close();
        alertify.error("Ha ocurrido un error inesperado. Inténtelo más tarde!");
        console.log(data);
      }
    });
  }

  function confirmar_cancelar_poliza(tipo, idkey, estatus_actual){
    //estatus_actual--> 0 está activa, 1 está cancelada
    var aviso = "";
    var estatus_nuevo = "";
    if(estatus_actual == 0){
      aviso ="¿Está seguro de cancelar esta Póliza de "+tipo;
      estatus_nuevo = 1;
    }
    else if(estatus_actual == 1){
      aviso ="¿Está seguro de activar esta Póliza de "+tipo;
      estatus_nuevo = 0;
    }
    Swal.fire({
        title: aviso,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Guardar',
        cancelButtonText: 'Cancelar'
        }).then(function (result) {
          if (result.value) 
            cambiar_estatus_poliza(tipo, idkey, estatus_nuevo);
          else{
            if (estatus_actual==0) $("#"+tipo+idkey).prop('checked', false);
            else $("#"+tipo+idkey).prop('checked', true);
            Swal.fire('Operación cancelada', '', 'error');
          }
    });
  }

  function cambiar_estatus_poliza(tipo, idkey, estatus_nuevo){

    $.ajax({   
     url: url_cont,   
     data: {
       funcion: "cambiar_estatus_poliza",
       tipo: tipo,
       idkey: idkey,
       estatus_nuevo: estatus_nuevo
     },                  
     type: "POST",                 
     dataType: "json",
     asycn: true,
     beforeSend: function () {
      Swal.fire({
          title: '¡Espere un momento!',
          html: 'Guardando...',
          allowOutsideClick: false,
          onBeforeOpen: () => {
              Swal.showLoading()
          },
      });
     },
     success: function(response){
      console.log(response);
      swal.close();
       if(response["error"]=='0'){  
          Swal.fire({
            type: 'success',
            icon: 'success',
            title: 'Estatus de póliza cambiado correctamente.',
            confirmButtonText: 'Aceptar',
            footer: '',
            showCloseButton: true
          })
          .then(function (result) {
              window.location = "../contabilidad/polizas.php";
         });
       } 
       else{
          Swal.fire("¡Ha ocurrido un error inesperado! Inténtelo más tarde.", '', 'error');
          if(estatus_nuevo==0) $("#"+tipo+idkey).prop('checked', true);
          else $("#"+tipo+idkey).prop('checked', false);
       }
      },
      error: function(data) {
        swal.close();
        alertify.error("Ha ocurrido un error inesperado. Inténtelo más tarde!");
        if(estatus_nuevo==0) $("#"+tipo+idkey).prop('checked', 1);
        else $("#"+tipo+idkey).prop('checked', 0);
        console.log(data);
      }
    });
  }

  function cargar_detalle_poliza(idkey_poliza, tipo){
    var parametros = {
        "funcion" : "datatable_movimientos_poliza",
        idkey_poliza: idkey_poliza,
        tipo : tipo
    };
    $.ajax({
        url: url_cont,
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
            //Refresh datatable
            var table = $("#tablaDetallePoliza").dataTable(); 
            table.fnClearTable();//Para borrar contenido de datatable y volver a cargar

            if(response["error"] == 0){
              //detalles generales
              $("#numero").html(response["no_poliza"]);
              $("#fecha").html(response["fecha"]);
              $("#concepto").html(response["concepto"]);
              $("#tipo").html(tipo);
              $("#periodo").html(response["periodo"]);
              $("#serie").html(response["serie"]);
              //movimientos
              var movimientos = response['movimientos'];
              $.each(movimientos, function(i, response) {
                //Para alimentar el datatable
                table.fnAddData([
                  response.cuenta_contable,
                  response.referencia,
                  response.debe,
                  response.haber,
                  response.descripcion
                ]);
              });
            }
            else alertify.error("Ha ocurrido un error inesperado. Inténtelo más tarde!");
            swal.close();
        },
        error: function(data) {
          swal.close();
          alertify.error("Ha ocurrido un error inesperado. Inténtelo más tarde!");
          console.log(data);
        }
    });

  }




 