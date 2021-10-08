//Funciones para Cartera que retorna un json de php/json_func_clientes
var url1 = '../php/json_func_seguimiento.php';

function datatable_creditos_promotor(){
    $('#tablaPagosProx').DataTable({
      "ajax": {
          "url": url1,
          "type": "POST",
          "dataSrc": "",
          "data" : {
            "funcion" : "datatable_creditos_promotor"
          }
      },
      "columns": [
          {data: "folio"},
          {data: "fecha_ultimo_pago"},
          {data: "fecha_pago"},
          {data: "nombre"},
          {data: "producto"},
          {data: "cantidad_pagar"},
          {data: "saldo_insoluto"},
          {data: "estatus"}
      ],
      "columnDefs": [
          {
              "targets": [ 1 ],
              "visible": false,
              "searchable": false,
              render: $.fn.dataTable.render.moment('YYYY/MM/DD', 'DD-MM-YYYY')
          }
      ],
      "bPaginate": true,
      "ordering": true,
      "searching": true,
      "bFilter": true,
      "bInfo": true
   });

}

function cargar_cantidad_pagar(idkey_credito){
  $.ajax({
      url: url1,
      data: {funcion: "cargar_cantidad_pagar", idkey_credito: idkey_credito},
      type: 'post',
      dataType: 'json',
      asycn: true,
      success: function (response) {
        if(response['error']==0){
          $("#filas_cant_pagar").html(response["filas_cant_pagar"]);
        }
      },
     error: function(data) {
        console.log(data);
      }
    });
}

function datatable_creditos_supervisor(){
    $('#datatable1').DataTable({
      "ajax": {
          "url": url1,
          "type": "POST",
          "dataSrc": "",
          "data" : {
            "funcion" : "datatable_creditos_supervisor"
          }
      },
      "columns": [
          {data: "folio"},
          {data: "producto"},
          {data: "fecha_creacion"},
          {data: "promotor"},
          {data: "cliente"},
          {data: "monto"},
          {data: "estatus"},
          {data: "estatus_pagos"},
          {data: "dias_transcurridos"},
          {data: "opciones"}
      ],
      "bPaginate": true,
      "ordering": true,
      "searching": true,
      "bFilter": true,
      "bInfo": true
   });
}

function datatable_creditos_condonacion(){
    $('#datatable1').DataTable({
      "ajax": {
          "url": url1,
          "type": "POST",
          "dataSrc": "",
          "data" : {
            "funcion" : "datatable_creditos_condonacion"
          }
      },
      "columns": [
          {data: "folio"},
          {data: "producto"},
          {data: "fecha_creacion"},
          {data: "promotor"},
          {data: "cliente"},
          {data: "monto"},
          {data: "estatus"},
          {data: "estatus_pagos"},
          {data: "dias_transcurridos"},
          {data: "opciones"}
      ],
      "bPaginate": true,
      "ordering": true,
      "searching": true,
      "bFilter": true,
      "bInfo": true
   });
}

function datatable_creditos_reestructuracion(){
    $('#datatable1').DataTable({
      "ajax": {
          "url": url1,
          "type": "POST",
          "dataSrc": "",
          "data" : {
            "funcion" : "datatable_creditos_reestructuracion"
          }
      },
      "columns": [
          {data: "folio"},
          {data: "producto"},
          {data: "fecha_creacion"},
          {data: "promotor"},
          {data: "cliente"},
          {data: "monto"},
          {data: "estatus"},
          {data: "estatus_pagos"},
          {data: "dias_transcurridos"},
          {data: "opciones"}
      ],
      "bPaginate": true,
      "ordering": true,
      "searching": true,
      "bFilter": true,
      "bInfo": true
   });
}

function datatable_creditos_renovacion(){
    $('#datatable1').DataTable({
      "ajax": {
          "url": url1,
          "type": "POST",
          "dataSrc": "",
          "data" : {
            "funcion" : "datatable_creditos_renovacion"
          }
      },
      "columns": [
          {data: "folio"},
          {data: "producto"},
          {data: "fecha_creacion"},
          {data: "promotor"},
          {data: "cliente"},
          {data: "monto"},
          {data: "estatus"},
          {data: "estatus_pagos"},
          {data: "dias_transcurridos"},
          {data: "opciones"}
      ],
      "bPaginate": true,
      "ordering": true,
      "searching": true,
      "bFilter": true,
      "bInfo": true
   });
}

function datatable_creditos_castigo(){
    $('#datatable1').DataTable({
      "ajax": {
          "url": url1,
          "type": "POST",
          "dataSrc": "",
          "data" : {
            "funcion" : "datatable_creditos_castigo"
          }
      },
      "columns": [
          {data: "folio"},
          {data: "producto"},
          {data: "fecha_creacion"},
          {data: "promotor"},
          {data: "cliente"},
          {data: "monto"},
          {data: "estatus"},
          {data: "estatus_pagos"},
          {data: "dias_transcurridos"},
          {data: "opciones"}
      ],
      "bPaginate": true,
      "ordering": true,
      "searching": true,
      "bFilter": true,
      "bInfo": true
   });
}

function datatable_amort_dinamica(idkey_credito, nombre){
    $("#nombre_cliente").html(nombre);
    var datatable = $('#amortizacion-dinamica').DataTable();
    datatable.destroy();
    $('#amortizacion-dinamica').DataTable({
      "ajax": {
          "url": url1,
          "type": "POST",
          "dataSrc": "",
          "data" : {
            "funcion" : "datatable_amort_dinamica",
            "idkey_credito": idkey_credito
          }
      },
      "columns": [
          {data: "no_pago"},
          {data: "fecha_valor"},
          {data: "cantidad_pago"},
          {data: "interes"},
          {data: "iva"},
          {data: "monto"},
          {data: "interes_acumulado"},
          {data: "pago_interes_moratorio"},
          {data: "iva_interes_moratorio"},
          {data: "amortizacion"},
          {data: "saldo_insoluto"},
          {data: "dias"},
          {data: "acciones"}
      ],
      "order": [[ 0, 'asc' ]],
      "bPaginate": false,
      "ordering": true,
      "searching": false,
      "bFilter": false,
      "bInfo": false,
      'sDom': 't'
   });/*
   $.ajax({
      url: url1,
      data: {
        funcion: "datatable_amort_dinamica", 
        idkey_credito: idkey_credito
      },
      type: 'post',
      dataType: 'json',
      asycn: true,
      success: function (response) {
        
        
        console.log(response);
      },
     error: function(data) {
        console.log(data);
      }
  });*/
}

function cargar_factores_cliente(idkey_cliente, nombre){
  $('#idkey_cliente1').val(idkey_cliente);
  $('#nombre_cliente').html(nombre);
  $.ajax({
      url: "../php/json_func_cartera.php",
      data: {
        funcion: "cargar_factores_completos", 
        idkey_cliente: idkey_cliente
      },
      type: 'post',
      dataType: 'json',
      asycn: true,
      success: function (response) {
          $('#factoresDiv').show();
          $("#score").html(response["score"]);
          $("#factores").html(response["factores"]);
          calcular_score();
        
        console.log(response);
      },
     error: function(data) {
        console.log(data);
      }
  });
}

function actualizar_factores(idkey_cliente){
  var values = [];
  
  $.each($("input[name='factor_value']"), function(){
    if (this.checked) values.push(1);
    else values.push(0);
  });

  $.ajax({   
     url: url1, 
     data: {
      funcion: "actualizar_factores",
      idkey_cliente: idkey_cliente,
      factores: values
     },                  
     type: "POST",                 
     dataType: "json",
     success: function(response){
       console.log(response);
       if(response["error"]=='0')
          alertify.success("Datos guardados correctamente.");
       else
          alertify.error("Ha ocurrido un error inesperado. Inténtelo más tarde!");          
      },
     error: function(data) {
      console.log(data);
     }
    });
}

function actualizar_estatus_credito(idkey_credito){
  if($('#idkey_estatus').val()=="" || $('#monto_credito').val()=="" || $('#fecha_desembolso1').val()==""
    || $('#tipo_desembolso1').val()=="" || $('#fecha_pago1').val() =="" || $('#plazo_meses').val()=="")
    alertify.error("Debes llenar todos los campo obligatorios!");
  else if (validarViernes($('#fecha_pago1').val()) == false)
    alertify.error("¡La fecha del primer pago debe ser Viernes!");  
  else{
    $.ajax({   
       url: url1, 
       data: {
        funcion: "actualizar_estatus_credito",
        idkey_credito: idkey_credito,
        idkey_clientes: $('#idkey_cliente').val(),
        tipo_credito: $('#tipo_credito').val(),
        idkey_estatus: $('#idkey_estatus').val(),
        observaciones: $('#observaciones').val(),
        monto_credito: $('#monto_credito').val(),
        fecha_desembolso: $('#fecha_desembolso1').val(),
        tipo_desembolso: $('#tipo_desembolso1').val(),
        fecha_pago: $('#fecha_pago1').val(),
        plazo_meses: $('#plazo_meses').val(),
        prodeco: $('#prodeco1').val(),
        fondeadora: $('#fondeadora1').val(),
        gliquida: $('#gliquida1').val(),
        montos_socios: $(".montos_socios").serializeArray()
       },                  
       type: "POST",                 
       dataType: "json",
       success: function(response){
         console.log(response);
         if(response["error"]=='0'){
            detalle_credito_general(idkey_credito);
            alertify.success("Datos guardados correctamente.");
         }
         else
            alertify.error("Ha ocurrido un error inesperado. Inténtelo más tarde!");          
        },
       error: function(data) {
        console.log(data);
       }
    });
  }
}

function datatable_cantidad_pagar(idkey_credito, nombre, no_pago_actual){
  $("#registrarPago").trigger("reset");
  $('#nombre_cliente1').html(nombre);
  $('#idkey_credito').val(idkey_credito);
  $('#btnGuardarPago').prop('disabled', false);
  $.ajax({
      url: url1,
      data: {
        funcion: "datatable_cantidad_pagar", 
        idkey_credito: idkey_credito,
        no_pago_actual: no_pago_actual
      },
      type: 'post',
      dataType: 'json',
      asycn: true,
      success: function (response) {
        $('#filas_cant_pagar').html(response["tabla1"]);
        $('#filas_ultimo_pago').html(response["tabla2"]);
        if(response["estado_credito"] == 0){
          $('#registrarPago').hide();
          alert("El cr\u00E9dito est\u00E1 vencido!");
          window.location.href="index.php";
        }
        else if(response["estado_credito"] == 1){
          $('#registrarPago').hide();
          alert("El cr\u00E9dito ha Finalizado!!!");
          window.location.href="index.php";
        }
        else if(response["estado_credito"] == 2){
          $('#registrarPago').hide();
          alert("El cr\u00E9dito no est\u00E1 autorizado!!!");
          window.location.href="index.php";
        }
        else if(response["aprobado"]==0){
          $('#btnGuardarPago').prop('disabled', true);
          alertify.alert("Aviso","¡No se puede registrar un pago nuevo hasta que el último esté aprobado!");
        }
        else{
          $('#area_pagos').show();
          $('#pago_ideal').val(response["pago_ideal"]);
          //$('#soluto').val(response["soluto"]);

          $('#saldo_insoluto_dinamico').val(response["saldo_insoluto_dinamico"]);
          $('#interes_acumulado').val(response["interes_acumulado"]);
          $('#monto_ultimo_pago').val(response["monto_ultimo_pago"]);
          $('#no_ultimo_pago').val(response["no_ultimo_pago"]);
          $('#fecha_pago_actual').val(response["fecha_pago_actual"]);
          $('#fecha_ultimo_pago').val(response["fecha_ultimo_pago"]);
          $('#fecha_valor').attr('max', response['fecha_pago_siguiente']);
        }
        console.log(response);
      },
     error: function(data) {
        console.log(data);
      }
  });

  //Llenamos los campos iniciales de los detalles del créditc
  /*$.ajax({
      url: url1,
      data: {
        funcion: "cargar_detalles_credito", 
        idkey_credito: idkey_credito
      },
      type: 'post',
      dataType: 'json',
      asycn: true,
      success: function (response) {
        $('#filas_cant_pagar').html(response["tabla1"]);
        $('#filas_ultimo_pago').html(response["tabla2"]);
        $('#fecha_valor').attr('max', response['fecha_pago_siguiente']);
        console.log(response);
      },
     error: function(data) {
        console.log(data);
      }
  });*/

}

function calcular_pago(){
  $.ajax({   
     url: url1, 
     data: $("#registrarPago").serialize() + '&funcion=' + 'calcular_pago',                  
     type: "POST",                 
     dataType: "json",
     beforeSend: function () {
        Swal.fire({
              title: '¡Espere un momento!',
              html: 'Cargando...',
              allowOutsideClick: false,
              onBeforeOpen: () => {
                  Swal.showLoading()
              },
          });
        $("#btnGuardarPago").prop('disabled', true);
     },
     success: function(response){
      swal.close();
      $("#btnGuardarPago").prop('disabled', false);
      $('#soluto').val(response["soluto"]);
      if(response["error"] ==0){
         Swal.fire({
          type: 'success',
          icon: 'success',
          title: 'Aviso',
          confirmButtonText: 'Aceptar',
          text: 'Pago registrado correctamente.',
          footer: '',
          showCloseButton: true
        })
        .then(function (result) {
          //////
        });
        $('#soluto').val(response['soluto']);
        var nombre = $("#nombre_cliente1").text();
        datatable_cantidad_pagar( response["idkey_credito"],  nombre,  response["no_sig_pago"]);
        
      }
      else
        alertify.error(response["error"]);
       console.log(response);
               
      },
      error: function(data) {
        swal.close();
        console.log(data);
      }
    });
}

function verificar_pago(){
  var pago_valor = $("#pago_valor").val();
  if(pago_valor=='0')
    $("#fecha_valor").val($("#fecha_pago_actual").val());
}

function cargar_formReestructuracion(idkey_credito, saldo_insoluto){//Reestructuracion
  //Se resetea el form
  $("#formCambios")[0].reset();
  var validator = $("#formCambios").validate();
  validator.resetForm();
  //Lleno los valores
  $("#idkey_credito").val(idkey_credito);
  $("#saldo_insoluto").val(saldo_insoluto);
  $("#titulo").html("Reestructuración de Crédito");
  $("#idkey_tipo_cambio").val(1);
}

function cargar_formCondonacion(idkey_credito, saldo_insoluto){
  //Se resetea el form
  $("#formCambios")[0].reset();
  var validator = $("#formCambios").validate();
  validator.resetForm();
  //Lleno los valores
  $("#idkey_credito").val(idkey_credito);
  $("#saldo_insoluto").val(saldo_insoluto);
  $("#titulo").html("Condonación de Crédito");
  $("#idkey_tipo_cambio").val(2);
}

function cargar_formRenovacion(idkey_credito, saldo_insoluto){
  //Se resetea el form
  $("#formCambios")[0].reset();
  var validator = $("#formCambios").validate();
  validator.resetForm();
  //Lleno los valores
  $("#idkey_credito").val(idkey_credito);
  $("#saldo_insoluto").val(saldo_insoluto);
  $("#titulo").html("Renovación de Crédito");
  $("#idkey_tipo_cambio").val(3);
}


function guardar_cambios_pagos_credito(){
  var tipo_cambio = $("#idkey_tipo_cambio").val();
  var funcion = "";
  var desc = "";
  if(tipo_cambio==1){//Reestructuración
    funcion = "guardar_reestructura_credito";
    desc = "Reestructuración";
  }
  else if(tipo_cambio==2){//Condonación
    funcion = "guardar_condonacion_credito";
    desc = "Condonación";
  }
  else if(tipo_cambio==3){//Renovación
    funcion = "guardar_renovacion_credito";
    desc = "Renovación";
  }
  else{
    alertify.error("Ha ocurrido un error inesperado. Inténtelo más tarde!");
    return false;
  }

  $.ajax({
      url: url1,
      data: $("#formCambios").serialize() + '&funcion=' + funcion,
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
        swal.close();
        console.log(response);
        if(response['error']==0){
          Swal.fire({
            type: 'success',
            icon: 'success',
            title: desc+' de crédito guardada correctamente',
            confirmButtonText: 'Aceptar',
            text: '',
            footer: '',
            showCloseButton: true
          })
          .then(function (result) {
              window.location = "../seguimiento/creditos_detalle_amortizacion.php?idkey_credito="+response.idkey_credito+"&tipo="+response.tipo;
         });
        }
        else{
          alertify.error("Ha ocurrido un error inesperado. Inténtelo más tarde!");
          console.log(data);
        }
      },
     error: function(data) {
        swal.close();
        alertify.error("Ha ocurrido un error inesperado. Inténtelo más tarde!");
        console.log(data);
      }
  });
}

 function confirmar_cartera_castigada(idkey){
    Swal.fire({
        title: "¿Está seguro de cambiar a Cartera Castigada el crédito "+idkey+"?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Guardar',
        cancelButtonText: 'Cancelar'
        }).then(function (result) {
          if (result.value) {}
            //cambiar_estatus_poliza(tipo, idkey, estatus_nuevo);
          
          else{
            Swal.fire('Operación cancelada', '', 'error');
          }
    });
  }

   //funcion para parsear la fecha
   const invertirFechaParse = (fechainicio, fechafin) => {

    fechainicio = fechainicio.split('/').reverse();
    fechainicio = fechainicio[0]+','+fechainicio[1]+','+fechainicio[fechainicio.length - 1];
    fechainicio = Date.parse(fechainicio);

    fechafin = fechafin.split('/').reverse();
    fechafin = fechafin[0]+','+fechafin[1]+','+fechafin[fechafin.length - 1];
    fechafin = Date.parse(fechafin);

    return {
      fechainicio,
      fechafin
    }
  }

  const invertirFecha = (fechini, fechfin) => {
      fechini = fechini.split('/').reverse();
      fechini = fechini[0]+'-'+fechini[1]+'-'+fechini[fechini.length - 1];

      fechfin = fechfin.split('/').reverse();
      fechfin = fechfin[0]+'-'+fechfin[1]+'-'+fechfin[fechfin.length - 1];

      return {
        fechini,
        fechfin,
      }

  }


  //funcion para imprimir lista de clientes
  const imprVistClientes = () => {
      let form = $('#formListClientes');
      let fechaInicio = $('#fecha_inicio');
      let fechaFin = $('#fecha_fin');
      form.validate({errorClass: 'text-error'});        
      if(form.valid()){

        const {fechainicio, fechafin} = invertirFechaParse(fechaInicio.val(), fechaFin.val());

        if( fechainicio > fechafin ){
          return alertSweet("La fecha inicial no puede ser mayor a la final", 'warning');
        }else if(fechainicio === fechafin){
          return alertSweet("Las fechas no pueden ser iguales", 'warning');
        }

        imprListaClientes(fechaInicio.val(), fechaFin.val());

      }
  } 

  const imprListaClientes = async (fechainicio, fechafin) => {

      const {fechini, fechfin} = invertirFecha(fechainicio, fechafin);
      $('#modalListaCreditos').modal("show");
      let table = $('#tableImprListaCreditos').DataTable({
        "destroy":true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
    
      });

      try {
        const datos = await datosAsync2("descargarListaCreditos", fechini, fechfin);
        datos.forEach( ({descripcion, fecha_pago, fecha_temp, folio, nombre, nombre_producto, total}) => {
            table.row.add([
              descripcion, fecha_pago, fecha_temp, total, folio, nombre, nombre_producto 
            ]).draw(false);
        })
        console.log(datos);
        swal.close();
        
      }catch(e) {
        swal.close();
        table.row.add([
          '','','','','','',''
        ]).draw(false);
        throw new Error("Error al cargar los datos")

      }


  }

      //funcion para mostrar un alert con la libreria sweet
  const alertSweet = ( title = '', icon = 'success' ) => Swal.fire({
    title,
    text: "",
    confirmButtonColor: '#3085d6',
    icon,
    confirmButtonText: '¡Entendido!'
  });


//AJAX ASYNC PARA CONECTAR A PHP 

const datosAsync2 = async (funcion, fechaInicio, fechaFin) => $.ajax({url: url1 , type: 'POST',async: true, dataType: 'json', data: {funcion, fechaInicio, fechaFin}, beforeSend: () => { 
  Swal.fire({ title: '¡Espere un momento!', html: 'Cargando...', allowOutsideClick: false, onBeforeOpen: () => { Swal.showLoading() } }); } });

