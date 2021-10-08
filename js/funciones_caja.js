var url_caja = '../php/json_func_caja.php';
var url_seg = '../php/json_func_seguimiento.php';
const url_garantias = '../php/json_func_garantias.php';
function datatable_caja_transito(){
    var parametros = {
        "funcion" : "consultar_caja_transito",
    };
    $.ajax({
        url: url_caja,
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
                '<input type="checkbox" autocomplete="off" />',
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


  function datatable_caja_transito_cajero(){
    var parametros = {
        "funcion" : "consultar_caja_transito_cajero",
    };
    $.ajax({
        url: url_caja,
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

              //Para alimentar el datatable
              table.fnAddData([
                '<input type="checkbox" autocomplete="off" />',
                response.folio,
                response.nombre,
                response.fecha_desembolso,
                response.tipo_desembolso,
                response.estatus,
                response.tipo,
                response.monto,
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



  function confirmar_estatus_caja(idkey_estatus, idkey_credito, monto){
    //alertify.success(idkey_estatus+" "+idkey_caja_transito);
    var monto_solicitado = 0;
    if(idkey_estatus==2){//En tránsito
      Swal.fire({
        title: '¿Está seguro de cambiar el estatus a En tránsito?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Guardar',
        cancelButtonText: 'Cancelar'
        }).then(function (result) {
          if (result.value) 
            cambiar_estatus_caja(idkey_estatus, idkey_credito, monto_solicitado);
          else
            Swal.fire('Operación cancelada', '', 'error');
        });
    }
    else if(idkey_estatus==3){//Solicitado
      Swal.fire({
          title: "Monto solicitado",
          input: "number",
          showCancelButton: true,
          confirmButtonText: "Guardar",
          cancelButtonText: "Cancelar",
          inputAttributes: {
              min: 1,
              max: 100,
          },
          inputValidator: (value) => {
              if (value > parseFloat(monto)) {
                  return 'La cantidad ingresada supera al monto del crédito de $'+monto;
              }
          }
        })
        .then(resultado => {
            if (resultado.value) {
              monto_solicitado = resultado.value;
              cambiar_estatus_caja(idkey_estatus, idkey_credito, monto_solicitado);
            }
            else
              Swal.fire('Operación cancelada', '', 'error');
      });

    }
  }

function cambiar_estatus_caja(idkey_estatus, idkey_credito, monto_solicitado){
  $.ajax({
   url: url_caja,
   type: 'POST',
   dataType: 'json',
   data: { 
    funcion:'cambiar_estatus_caja', 
    idkey_estatus:idkey_estatus,
    idkey_credito: idkey_credito,
    monto_solicitado: monto_solicitado
   },
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
   success: function(response){
    console.log(response);
    swal.close();
    if(response["error"] == 0){
      Swal.fire({
        type: 'success',
        icon: 'success',
        title: 'Aviso',
        confirmButtonText: 'Aceptar',
        text: 'Estatus actualizado correctamente.',
        footer: '',
        showCloseButton: true
      })
      .then(function (result) {
          window.location = "../caja/cartera_transito_sup.php";
      });
    }
    else
      bootbox.alert('Ha ocurrido un error inesperado. Inténtelo más tarde.');
   },
   error: function(data) {
      swal.close();
      console.log(data);
      bootbox.alert('Ha ocurrido un error inesperado. Inténtelo más tarde.');
    }
  });
}

function confirmar_estatus_caja_cajero(idkey_estatus, idkey_credito){
  if(idkey_estatus==2)
    var estatus_nuevo = "En tránsito";
  else if(idkey_estatus==5)
    var estatus_nuevo = "Desembolsado";
   
  Swal.fire({
    title: '¿Está seguro de cambiar el estatus a '+estatus_nuevo+'?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Guardar',
    cancelButtonText: 'Cancelar'
    }).then(function (result) {
      if (result.value) 
        cambiar_estatus_caja_cajero(idkey_estatus, idkey_credito);
      else
        Swal.fire('Operación cancelada', '', 'error');
    });
}

function cambiar_estatus_caja_cajero(idkey_estatus, idkey_credito){
  generarGarantia(idkey_estatus, idkey_credito);
  
  $.ajax({
   url: url_caja,
   type: 'POST',
   dataType: 'json',
   data: { 
    funcion:'cambiar_estatus_caja_cajero', 
    idkey_estatus:idkey_estatus,
    idkey_credito: idkey_credito
   },
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
   success: function(response){
    console.log(response);
    swal.close();
    if(response["error"] == 0){
      Swal.fire({
        type: 'success',
        icon: 'success',
        title: 'Aviso',
        confirmButtonText: 'Aceptar',
        text: 'Estatus actualizado correctamente.',
        footer: '',
        showCloseButton: true
      })
      .then(function (result) {
          
          window.location = "../caja/cartera_transito_cajero.php";
      });
    }
    else
      bootbox.alert('Ha ocurrido un error inesperado. Inténtelo más tarde.');
   },
   error: function(data) {
      swal.close();
      console.log(data);
      bootbox.alert('Ha ocurrido un error inesperado. Inténtelo más tarde.');
    }
  });
}

function datatable_credito_pago(){
    var parametros = {
        "funcion" : "datatable_credito_pago",
    };
    $.ajax({
        url: url_caja,
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

              //Para alimentar el datatable
              table.fnAddData([
                '<input type="checkbox" autocomplete="off" />',
                response.folio,
                response.idkey_pago,
                response.nombre,
                response.fecha_valor,
                response.monto,
                response.tipo,
                response.referencia,
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

function confirmar_aplicar_pago(idkey_pago, folio){
  Swal.fire({
    title: '¿Está seguro de aplicar el pago al crédito con folio '+folio+'?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Guardar',
    cancelButtonText: 'Cancelar'
    }).then(function (result) {
      if (result.value) 
        aplicar_pago(idkey_pago);
      else
        Swal.fire('Operación cancelada', '', 'error');
    });
}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////// Cambio de funcion para cajas //////////////////////////////////////////////////////////////////////

const aplicar_pago = async  (idkey_pago) => {
  try{
    const {error} = await loadUpdate('aplicar_pago', idkey_pago);
    if (error == 0){
      Swal.fire({
        type: 'success',
        icon: 'success',
        title: 'Aviso',
        confirmButtonText: 'Aceptar',
        text: 'Pago aplicado correctamente.',
        footer: '',
        showCloseButton: true
      }).then((result) => {
        if(result.value){
          load_pagos(idkey_pago);

        }
      })
    }
  }catch(err) {
    swal.close();
    alertify.error("Ocurrió un error inesperado. Inténtelo más tarde");
  }
}

const load_pagos = async (idkey_pago) => {

  try{

    const [{fecha_aprobacion, pago, idkey_usuario}] = await loadUpdate('loadPago', idkey_pago);
    let datos = [pago, fecha_aprobacion, idkey_usuario, idkey_pago];
    const {error} = await savePago(datos);
    if (error === 0) window.location = "../caja/credito_pago.php";
    swal.close();
  }catch(err) {
    swal.close();
    alertify.error("Ocurrió un error inesperado. Inténtelo más tarde");
  }
}

const generarGarantia = async (tipoMovimiento, idkeyCredito) => {
    if(tipoMovimiento === 5 || tipoMovimiento === '5'){

      const [{idkey_clientes, idkey_credito, nombre_producto, nombre, monto, fecha_desembolso}] = await peticionAjax('cargarCreditoGarantia', idkeyCredito);
     
      let maxMonto = parseFloat(monto) * .05;
      let info = [maxMonto, fecha_desembolso, idkey_clientes, nombre, idkey_credito, nombre_producto];
      const error = await peticionAjax('guardarGarantia', info);
      swal.close();
    
    }
}

//promesas
const loadUpdate = async (funcion, idkey_pago) => $.ajax({url: url_caja, type: 'POST',async: true, dataType: 'json', data: {funcion, idkey_pago,}, beforeSend: () => { 
        Swal.fire({ title: '¡Espere un momento!', html: 'Cargando...', allowOutsideClick: false, onBeforeOpen: () => { Swal.showLoading() } }); } });

const savePago = async (datos) => $.ajax({url: url_caja, type: 'POST',async: true, dataType: 'json', data: {funcion: 'savePago', datos, }, beforeSend: () => { 
  Swal.fire({ title: '¡Espere un momento!', html: 'Cargando...', allowOutsideClick: false, onBeforeOpen: () => { Swal.showLoading() } }); } });

  //promesas
  const peticionAjax = async (funcion, datos ='') => $.ajax({url: url_garantias , type: 'POST',async: true, dataType: 'json', data: {funcion, datos}, beforeSend: () => { 
    Swal.fire({ title: '¡Espere un momento!', html: 'Cargando...', allowOutsideClick: false, onBeforeOpen: () => { Swal.showLoading() } }); } });


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ///////////////////////////////////////// Fin de cambios //////////////////////////////////////////////////////////////////////

// function aplicar_pago(idkey_pago){
//   $.ajax({
//    url: url_caja,
//    type: 'POST',
//    dataType: 'json',
//    data: { 
//     funcion:'aplicar_pago', 
//     idkey_pago:idkey_pago
//    },
//    beforeSend: function () {
//       Swal.fire({
//           title: '¡Espere un momento!',
//           html: 'Cargando...',
//           allowOutsideClick: false,
//           onBeforeOpen: () => {
//               Swal.showLoading()
//           },
//       });
//     },
//    success: function(response){
//     console.log(response);
//     swal.close();
//     if(response["error"] == 0){
//       Swal.fire({
//         type: 'success',
//         icon: 'success',
//         title: 'Aviso',
//         confirmButtonText: 'Aceptar',
//         text: 'Pago aplicado correctamente.',
//         footer: '',
//         showCloseButton: true
//       })
//       .then(function (result) {
//           window.location = "../caja/credito_pago.php";
//       });
//     }
//     else
//       bootbox.alert('Ha ocurrido un error inesperado. Inténtelo más tarde.');
//    },
//    error: function(data) {
//       swal.close();
//       console.log(data);
//       bootbox.alert('Ha ocurrido un error inesperado. Inténtelo más tarde.');
//     }
//   });
// }

function datatable_creditos_cajero(){
    var parametros = {
        "funcion" : "datatable_creditos_cajero",
    };
    $.ajax({
        url: url_seg,
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
              //Para alimentar el datatable
              table.fnAddData([
                '<input type="checkbox" autocomplete="off" />',
                response.folio,
                response.fecha_ultimo_pago,
                response.fecha_pago,
                response.nombre,
                response.producto,
                response.cantidad_pagar,
                response.saldo_insoluto,
                response.estatus,
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


