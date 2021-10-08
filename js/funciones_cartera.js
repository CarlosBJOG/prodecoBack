//Funciones para Cartera que retorna un json de php/json_func_clientes
var url = '../php/json_func_cartera.php';

function datatable_clientes(){
  var parametros = {
		"funcion" : "consulta_clientes",
    };
    
	$.ajax({
    url: url,
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

        //Si el # de creditos es 0 es inactivo sino es activo
        var ncred = response.ncreditos; //número de créditos aprobados
        var estatus = '';
        if(Number(ncred)>0) 
          estatus = "<span class='badge badge-sm bgc-success-l2 text-success-d2 border-1 brc-success-m3'>Activo</span>";
        else 
          estatus = "<span class='badge badge-sm bgc-danger-l2 text-danger-d2 border-1 brc-danger-m3'>Inactivo</span>";

        table.fnAddData([
          '<input type="checkbox" autocomplete="off" />',
          response.idkey_cliente,
          '<a href="perfil-cliente.php?idkey_cliente='+response.idkey_cliente+'" class="text-dark-tp3">'+response.nombre+'</a>',
          response.curp,
          response.fecha_creacion,
          estatus,
          '<a href="clientes_alta.php?idkey_cliente='+response.idkey_cliente+'" class="btn radius-1 btn-sm btn-brc-tp btn-outline-default btn-h-outline-primary btn-a-outline-primary btn-text-primary">'+
          '<i class="fa fa-pencil-alt"></i></a>'+
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

function datatable_creditos(){
    var parametros = {
        "funcion" : "consulta_creditos",
    };
    
    $.ajax({
        url: url,
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

              //Para los colores de status
              var color = '';
              if(response.estatus == 1)
                color = 'success';
              else if(response.estatus == 2)
                color = 'primary';
              else if(response.estatus == 3 || response.estatus == 5)
                color = 'danger';
              else 
                color = 'warning';
              estatus = "<span class='badge badge-sm bgc-"+color+"-l2 text-"+color+"-d2 border-1 brc-"+color+
                "-m3'>"+response.desc_estatus+"</span>";

              //Determina la url si se trata de ind o grupal
              var url= "perfil-credito.php?idkey_credito="+response.idkey_credito+"&idkey_cliente="+response.idkey_clientes;

              //Para alimentar el datatable
              table.fnAddData([
                '<input type="checkbox" autocomplete="off" />',
                response.folio,
                '<a href="'+url+'" class="text-dark-tp3">'+response.nombre+'</a>',
                response.fecha_creacion,
                estatus,
                response.tipo,
                response.monto,
                '<div><a href="#" class="btn radius-1 btn-sm btn-brc-tp btn-outline-default btn-h-outline-warning btn-a-outline-warning btn-text-warning"><i class="fa fa-flag"></i></a></div>'
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

  function cargar_cliente(){//step1
    var parametros = {
      "funcion" : "consulta_cliente_step1",
      "idkey_cliente" : $("#idkey_cliente").val()
      };

    $.ajax({
      url: url,
      data: parametros,
      type: 'post',
      dataType: 'json',
      asycn: true,
      beforeSend: function () {
        $("#animacion").show();
      },
      success: function (response) {
    
        if(response['error']==0){

          $("#nombre").val(response["nombre"]);
          $("#apellido_p").val(response["apellido_p"]);
          $("#apellido_m").val(response["apellido_m"]);
          $("#nacimiento").val(response["fnac"]);
          $("#sexo option[value='"+response["sexo"]+"']").attr("selected",true);
          $("#rfc").val(response["rfc"]);
          $("#curp").val(response["curp"]);
          $("#identificacion option[value='"+response["idtipo_ide"]+"']").attr("selected",true);
          $("#num_id").val(response["num_id"]);
          $("#vigencia").val(response["vigencia"]);
          $("#domicilio").val(response['domicilio']);
          $("#interior").val(response['interior']);
          $("#exterior").val(response['exterior']);
          $("#inicia_habitar").val(response['fecha_habita']);
          $("#entrecalles").val(response['entrecalles']);
          $("#referencia").val(response['referencia']);
          $("#observaciones").val(response['observacion']);
          //Selecciono el estado y lleno los demas select en cascada
          $("#estados option[value='"+response['idkey_estado']+"']").attr("selected",true);
          $("#tipo_direccion option[value='"+response['tipo_direccion']+"']").attr("selected",true);
          $("#municipios").html(response['mpios_edo']);
          $("#localidad").html(response['locs_mpio']);
          $("#codigo_postal").html(response['cps_loc']);

          //Ahora que se carguen los demás datos de los siguentes pasos
          cargar_cliente_step2();
          cargar_cliente_step3();

        }
        else{
          alert(response['error']);
          window.location.href="cartera_clientes.php";
        }

        $("#animacion").slideUp('slow');
      },
      error: function(data) {
        console.log(data);
      }
    });
  }

  function nuevo_cliente(){
    $.ajax({   
     url: url,   
     data: $("#paso1form").serialize(), //aquí ya viene incluida la funcion                    
     type: "POST",                 
     dataType: "json",
     asycn: true,
      beforeSend: function () {
        $("#animacion").show();
      },
     success: function(response){
       $("#animacion").slideUp('slow');
       if(response["error"]=='0'){  
          alertify.success("Datos guardados correctamente.");

          var url = "?idkey_cliente="+response["idkey_cliente"];

          //AceToaster en medio de la pantalla
          $.aceToaster.add({
            placement: 'center',
            body: "<p class='p-3 mb-0 text-center'>\
                        <span class='d-inline-block text-center mb-3 py-3 px-1 border-1 brc-success radius-round'>\
                            <i class='fa fa-check fa-2x w-6 text-success-m1 mx-2px'></i>\
                        </span><br />\
                        Ahora ya puedes agregar domicilios adicionales, relaciones y contactos.\
                    </p>\
                    <button data-dismiss='toast' class='btn btn-block btn-info radius-t-0 border-0' onclick='window.location.href=\""+url+"\"'>Continuar</button></div>",
            width: 360,
            delay: 3000,
            close: false,
            className: 'bgc-white-tp1 shadow ',
            bodyClass: 'border-0 p-0 text-dark-tp2',
            headerClass: 'd-none',
        });

        setTimeout(function() { window.location = "?idkey_cliente="+response["idkey_cliente"]; }, 3000); 
       } 
       else
          alertify.error(response["error"]);          
      }
    });
  }

  function editar_cliente_step1(){
    $.ajax({   
     url: url,   
     data: $("#paso1form").serialize(), //aquí ya viene incluida la funcion                    
     type: "POST",                 
     dataType: "json",
     success: function(response){
       console.log(response);
       if(response["error"]=='0'){  
        alertify.success("Datos actualizados correctamente.");
       } 
       else{ 
          alertify.error(response["error"]);
       }             
      }
    });
  }

//Esta función es tanto para nuevos datos adicionales o actualización
  function cliente_datos_adic(){

    $.ajax({   
     url: url, 
     data: $("#paso2form").serialize() + '&funcion=' + 'cliente_datos_adic'+'&idkey_cliente='+ $("#idkey_cliente").val(),                  
     type: "POST",                 
     dataType: "json",
     success: function(response){
       console.log(response);
       if(response["error"]=='0'){
          alertify.success("Datos guardados correctamente.");
          $("#idkey_datos_adic").val("true");
       }
       else
          alertify.error(response["error"]);          
      }
    });
  }

  function cargar_cliente_step2(){
    var parametros = {
      "funcion" : "consulta_cliente_step2",
      "idkey_cliente" : $("#idkey_cliente").val()
      };

    $.ajax({
      url: url,
      data: parametros,
      type: 'post',
      dataType: 'json',
      asycn: true,
      beforeSend: function () {
      },
      success: function (response) {
        $("#idkey_datos_adic").val(response['encontrado']);
        if(response['encontrado'] == "true"){
          $("#estado_civil option[value='"+response['idkey_estado_civil']+"']").attr("selected",true);
          $('#nivel_academico').val(response['idkey_nivel_academico']);
         
          if(response['indigena']=="1") $("#indigena").prop('checked', true);
          if(response['penales']=="1") $("#penales").prop('checked', true);
          if(response['politica']=="1") $("#politica").prop('checked', true);
         
          $('#dependientes').val(response['dependientes']);  
          $("#regimen_fiscal option[value='"+response['idkey_regimen_fiscal']+"']").attr("selected",true);
          $('#fecha_sat').val(response['fecha_sat']);
          $('#email_facturacion').val(response['correo_facturacion']);  
          $('#domicilio_fiscal').val(response['domicilio_fiscal']);
          $('#fiel').val(response['fiel']); 
          $('#cedula').val(response['cedula']); 
          $('#id_cargo').val(response['id_cargo']).trigger('change');//Forzar cambio select2
          $('#inicio_cargo').val(response['inicio_cargo']); 
          $('#fin_cargo').val(response['fin_cargo']);
        }
      }
    });
  }

  //Esta función es tanto para nuevos datos adicionales o actualización
  function cliente_socioeconomico(){

    $.ajax({   
     url: url, 
     data: $("#paso3form").serialize() + '&funcion=' + 'cliente_socioeconomico'+'&idkey_cliente='+ $("#idkey_cliente").val(),                  
     type: "POST",                 
     dataType: "json",
     success: function(response){
       console.log(response);
       if(response["error"]=='0'){
          alertify.success("Datos guardados correctamente.");
          //$("#idkey_datos_adic").val("true"); variable de control
       }
       else
          alertify.error(response["error"]);          
      }
    });
  }

  function cargar_cliente_step3(){
    var parametros = {
      "funcion" : "consulta_cliente_step3",
      "idkey_cliente" : $("#idkey_cliente").val()
      };

    $.ajax({
      url: url,
      data: parametros,
      type: 'post',
      dataType: 'json',
      asycn: true,
      beforeSend: function () {
      },
      success: function (response) {
        $("#idkey_socioeconomico").val(response['encontrado']);
        if(response['encontrado'] == "true"){

          if(response['agua']=="1") $("#agua").prop('checked', true);
          if(response['electri']=="1") $("#electri").prop('checked', true);
          if(response['telefono']=="1") $("#telefono").prop('checked', true);    
          if(response['drenaje']=="1") $("#drenaje").prop('checked', true);    
          if(response['ant_cable']=="1") $("#ant_cable").prop('checked', true);  
          if(response['estufa']=="1") $("#estufa").prop('checked', true);
          if(response['lavadora']=="1") $("#lavadora").prop('checked', true);
          if(response['refri']=="1") $("#refri").prop('checked', true);
          if(response['tele']=="1") $("#tele").prop('checked', true);
          if(response['estereo']=="1") $("#estereo").prop('checked', true);
          if(response['compu']=="1") $("#compu").prop('checked', true);
          if(response['sala']=="1") $("#sala").prop('checked', true);
          if(response['comedor']=="1") $("#comedor").prop('checked', true);
          if(response['cocina']=="1") $("#cocina").prop('checked', true);
          if(response['bano_p']=="1") $("#bano_p").prop('checked', true);
          $("#electro_detalle").val(response['electro_detalle']);
          $("#servicios_detalle").val(response['servicios_detalle']);
           $("#vivienda option[value='"+response['vivienda']+"']").attr("selected",true);
           $("#vivienda_detalle").val(response['vivienda_detalle']);
           $("#material option[value='"+response['material']+"']").attr("selected",true);
           $("#material_detalle").val(response['material_detalle']);
           $("#hacinamiento option[value='"+response['hacinamiento']+"']").attr("selected",true);
           $("#hacinamiento_detalle").val(response['hacinamiento_detalle']);
           $("#piso option[value='"+response['piso']+"']").attr("selected",true);
          $("#piso_detalle").val(response['piso_detalle']);
          $("#habitaciones_detalle").val(response['habitaciones_detalle']);
          $("#residentes").val(response['residentes']);
          $("#techo option[value='"+response['techo']+"']").attr("selected",true);
          $("#techo_detalle").val(response['techo_detalle']);
          $("#observaciones_socioeconomico").val(response['observaciones']);
        }
      }
    });
  }

  function datatable_direcciones(){
    $('#tablaDomicilios').DataTable({
      "ajax": {
          "url": url,
          "type": "POST",
          "dataSrc": "",
          "data" : {
            "idkey_cliente" : $("#idkey_cliente").val(),
            "funcion" : "datatable_domicilios"
          }
      },
      "columns": [
          {data: "tipo"},
          {data: "direccion"},
          {data: "fecha_habita"},
          {data: "observacion"},
          {data: "acciones"}
      ],
      "bPaginate": false,
      "ordering": true,
      "searching": false,
      "bFilter": false,
      "bInfo": false,
      'sDom': 't' 
   });
  }

  function eliminar_dir(idkey_direccion){
    // Confirm box
    bootbox.confirm("¿Está seguro que desea eliminar este domicilio?", function(result) {

      if(result){

        $.ajax({
         url: url,
         type: 'POST',
         dataType: 'json',
         data: { funcion:'borrar_domicilio', idkey_direccion:idkey_direccion },
         success: function(response){
           if(response["error"] == 0){
             alertify.success("Domicilio borrado con éxito.");
             //Refresh datatable
             var datatableDom = $('#tablaDomicilios').DataTable();
             datatableDom.ajax.reload();
             cargar_dom_fiscales();//Se actualizan los domicilios fiscales
           }
           else
              bootbox.alert('Error inesperado al eliminar el domicilio. Inténtelo más tarde.');
         }
        });

       }

    });
  }
 
 function cargar_dir(idkey_direccion){
  var validator = $("#direccionesAdic").validate();
  validator.resetForm();

  $.ajax({
   url: url,
   type: 'POST',
   dataType: 'json',
   data: { funcion:'consulta_domicilio_adic', idkey_direccion:idkey_direccion },
   success: function(response){
    console.log(response);
    
     if(response["error"] == 0){
        $("#idkey_direccion1").val(response['idkey_direccion']);
        $("#domicilio1").val(response['domicilio']);
        $("#interior1").val(response['interior']);
        $("#exterior1").val(response['exterior']);
        $("#inicia_habitar1").val(response['fecha_habita']);
        $("#entrecalles1").val(response['entrecalles']);
        $("#referencia1").val(response['referencia']);
        $("#observaciones1").val(response['observacion']);
        //Selecciono el estado y lleno los demas select en cascada
        $("#estados1").val(response['idkey_estado']);
        $("#tipo_direccion1").val(response['tipo_direccion']);
        $("#municipios1").html(response['mpios_edo']);
        $("#localidad1").html(response['locs_mpio']);
        $("#codigo_postal1").html(response['cps_loc']);
     }
     else
        bootbox.alert('Error inesperado al consultar el domicilio. Inténtelo más tarde.');
   }
  });

}

function cargar_dom_fiscales(){
    var parametros = {
    "funcion" : "cargar_dom_fiscales",
     "idkey_cliente" : $("#idkey_cliente").val()
    };
    
  $.ajax({
    url: url,
    data: parametros,
    type: 'post',
    dataType: "json",
    beforeSend: function () {
            //animación de carga
        },
    success: function (response) {
        $("#misdomicilios").html(response['domicilios']);
    }
    });
}

function datatable_ingresos(){
    $('#tablaIngresos').DataTable({
      "ajax": {
          "url": url,
          "type": "POST",
          "dataSrc": "",
          "data" : {
            "idkey_cliente" : $("#idkey_cliente").val(),
            "funcion" : "datatable_ingresos"
          }
      },
      "columns": [
          {data: "empleador"},
          {data: "tipo_ingreso"},
          {data: "monto_ingreso"},
          {data: "frecuencia_ingreso"},
          {data: "bajo_contrato"},
          {data: "arraigo_laboral"},
          {data: "acciones"}
      ],
      "bPaginate": false,
      "ordering": true,
      "searching": false,
      "bFilter": false,
      "bInfo": false,
      'sDom': 't' 
   });
  }

function cargar_ingreso(idkey_ingreso){
  var validator = $("#ingresos").validate();
  validator.resetForm();
  $('#f_fin').attr('disabled', false);
  $('#estatus_ffin').prop('checked', true);

  $.ajax({
   url: url,
   type: 'POST',
   dataType: 'json',
   data: { funcion:'consulta_ingreso', idkey_ingreso:idkey_ingreso },
   success: function(response){
    
    if(response["error"] == 0){
      $("#idkey_ingreso").val(idkey_ingreso);
      if(response['principal']=="1") $("#principal").prop('checked', true);
      $("#ingreso_tipo").val(response['ingreso_tipo']);
      $("#ingreso_frec").val(response['ingreso_frec']);
      $("#monto").val(response['monto']);
      $("#id_empleador").val(response['empleador']);
      $("#f_inicio").val(response['f_inicio']);
      $("#f_fin").val(response['f_fin']);
      $("#profesion").val(response['profesion']);
      $("#ocupacion").val(response['ocupacion']);
      //$("#jefe_directo").val(response['jefe_directo']);
      $('#jefe_directo').val(response['jefe_directo']).trigger('change');
      if(response['bajo_contrato']=="1") $("#bajo_contrato").prop('checked', true);
      $("#ingreso_desc").val(response['ingreso_desc']);
      $("#domicilio_empleador").val(response['domicilio_empleador']);
      //$("#actividad_siti").val(response['id_siti']);
      $('#actividad_siti').val(response['id_siti']).trigger('change');
      $("#ingreso_comprobable").val(response['ingreso_comprobable']);
    }
    else
      bootbox.alert('Error inesperado al consultar el ingreso. Inténtelo más tarde.');
   }
  });

}

function eliminar_ingreso(idkey_ingreso){
    // Confirm box
    bootbox.confirm("¿Está seguro que desea eliminar este ingreso?", function(result) {

      if(result){

        $.ajax({
         url: url,
         type: 'POST',
         dataType: 'json',
         data: { funcion:'borrar_ingreso', idkey_ingreso:idkey_ingreso },
         success: function(response){
           if(response["error"] == 0){
             alertify.success("Ingreso borrado con éxito.");
             //Refresh datatable
             var datatable = $('#tablaIngresos').DataTable();
             datatable.ajax.reload();
           }
           else
              bootbox.alert('Error inesperado al eliminar el ingreso. Inténtelo más tarde.');
         }
        });

       }

    });
  }

function comprobar_perfil_cliente(){
  var idkey_cliente = $("#idkey_cliente").val();
  $.ajax({   
     url: url,   
     data: {funcion: 'perfil_completo_cliente', idkey_cliente: idkey_cliente},                  
     type: "POST",                 
     dataType: "json",
     asycn: true,
      beforeSend: function () {
        $("#animacion").show();
      },
     success: function(response){
      console.log(response);
      $("#animacion").slideUp('slow');
      if(response["error"]==0){  
          $("#formFactores").show();
          $("#div-calcular-fact").hide();
          //Cargo los factores de la interfaz si es que existen
          cargar_factores(idkey_cliente);
      }
      else
          bootbox.alert("¡El perfil de este cliente está incompleto! Para proceder a completarlo debe proporcionar:\n"+response['error']);    
     },
     error: function(data) {
      console.log(data);
     }
  });
}

/*
function calcular_factores(){

    $("#formFactores").show();
    $("#div-calcular-fact").hide();

    $.ajax({
       url: url,
       type: 'POST',
       dataType: 'json',
       data: { funcion:'consultar_factores', "idkey_cliente" : $("#idkey_cliente").val() },
       success: function(response){
         console.log(response);
       }
    });
}*/

function datatable_contactos(){
    $('#tablaContactos').DataTable({
      "ajax": {
          "url": url,
          "type": "POST",
          "dataSrc": "",
          "data" : {
            "idkey_cliente" : $("#idkey_cliente").val(),
            "funcion" : "datatable_contactos"
          }
      },
      "columns": [
          {data: "descripcion"},
          {data: "telefono"},
          {data: "email"},
          {data: "prioridad"},
          {data: "acciones"}
      ],
      "bPaginate": false,
      "ordering": true,
      "searching": false,
      "bFilter": false,
      "bInfo": false,
      'sDom': 't' 
   });
}

function eliminar_contacto(idkey_contacto){
    // Confirm box
    bootbox.confirm("¿Está seguro que desea eliminar este contacto?", function(result) {

      if(result){

        $.ajax({
         url: url,
         type: 'POST',
         dataType: 'json',
         data: { funcion:'borrar_contacto', idkey_contacto:idkey_contacto },
         success: function(response){
           if(response["error"] == 0){
             alertify.success("Contacto borrado con éxito.");
             //Refresh datatable
             var datatable = $('#tablaContactos').DataTable();
             datatable.ajax.reload();
           }
           else
              bootbox.alert('Error inesperado al eliminar el contacto. Inténtelo más tarde.');
         }
        });

       }

    });
  }

function cargar_contacto(idkey_contacto){
  var validator = $("#contactos").validate();
  validator.resetForm();

  $.ajax({
   url: url,
   type: 'POST',
   dataType: 'json',
   data: { funcion:'consulta_contacto', idkey_contacto:idkey_contacto },
   success: function(response){
    if(response["error"] == 0){
      $("#idkey_contacto").val(idkey_contacto);
      $("#contacto_descripcion").val(response['descripcion']);
      $("#contacto_telefono").val(response['telefono']);
      $("#contacto_email").val(response['email']);
      $("#contacto_prioridad").val(response['prioridad']);
    }
    else
      bootbox.alert('Error inesperado al consultar el contacto. Inténtelo más tarde.');
   }
  });

}

function datatable_muebles(){
    $('#tablaMuebles').DataTable({
      "ajax": {
          "url": url,
          "type": "POST",
          "dataSrc": "",
          "data" : {
            "idkey_cliente" : $("#idkey_cliente").val(),
            "funcion" : "datatable_muebles"
          }
      },
      "columns": [
          {data: "categoria"},
          {data: "valor"},
          {data: "modelo"},
          {data: "marca"},
          {data: "factura"},
          {data: "fecha"},
          {data: "observaciones"},
          {data: "acciones"}
      ],
      "bPaginate": false,
      "ordering": true,
      "searching": false,
      "bFilter": false,
      "bInfo": false,
      'sDom': 't' 
   });
}

function eliminar_mueble(idkey_mueble){
    // Confirm box
    bootbox.confirm("¿Está seguro que desea eliminar esta garantía mueble?", function(result) {

      if(result){

        $.ajax({
         url: url,
         type: 'POST',
         dataType: 'json',
         data: { funcion:'borrar_mueble', idkey_mueble:idkey_mueble },
         success: function(response){
           if(response["error"] == 0){
             alertify.success("Mueble borrado con éxito.");
             //Refresh datatable
             var datatable = $('#tablaMuebles').DataTable();
             datatable.ajax.reload();
           }
           else
              bootbox.alert('Error inesperado al eliminar el mueble. Inténtelo más tarde.');
         }
        });

       }

    });
  }

function cargar_mueble(idkey_mueble){
  var validator = $("#muebles").validate();
  validator.resetForm();

  $.ajax({
   url: url,
   type: 'POST',
   dataType: 'json',
   data: { funcion:'consulta_mueble', idkey_mueble:idkey_mueble },
   success: function(response){
    if(response["error"] == 0){
      $("#idkey_mueble").val(idkey_mueble);
      $("#garantias_categorias").val(response['categoria']);
      $("#valor_comercial").val(response['valor']);
      $("#marca").val(response['marca']);
      $("#modelo").val(response['modelo']);
      $("#referencia_factura").val(response['factura']);
      $("#fecha_adquisicion").val(response['fecha']);
      $("#cobertura").val(response['cobertura']);
      $("#mueble_observaciones").val(response['observaciones']);
    }
    else
      bootbox.alert('Error inesperado al consultar el mueble. Inténtelo más tarde.');
   }
  });
}

function datatable_inmuebles(){
    $('#tablaInmuebles').DataTable({
      "ajax": {
          "url": url,
          "type": "POST",
          "dataSrc": "",
          "data" : {
            "idkey_cliente" : $("#idkey_cliente").val(),
            "funcion" : "datatable_inmuebles"
          }
      },
      "columns": [
          {data: "categoria"},
          {data: "valor_fiscal"},
          {data: "valor_catastral"},
          {data: "escrituras"},
          {data: "registro"},
          {data: "medidas"},
          {data: "acciones"}
      ],
      "bPaginate": false,
      "ordering": true,
      "searching": false,
      "bFilter": false,
      "bInfo": false,
      'sDom': 't' 
   });
}

function eliminar_inmueble(idkey_inmueble){
    // Confirm box
    bootbox.confirm("¿Está seguro que desea eliminar esta garantía inmueble?", function(result) {

      if(result){
        $.ajax({
         url: url,
         type: 'POST',
         dataType: 'json',
         data: { funcion:'borrar_inmueble', idkey_inmueble:idkey_inmueble },
         success: function(response){
           if(response["error"] == 0){
             alertify.success("Inmueble borrado con éxito.");
             //Refresh datatable
             var datatable = $('#tablaInmuebles').DataTable();
             datatable.ajax.reload();
           }
           else
              bootbox.alert('Error inesperado al eliminar el inmueble. Inténtelo más tarde.');
         }
        });

       }

    });
  }

function cargar_inmueble(idkey_inmueble){
  var validator = $("#inmuebles").validate();
  validator.resetForm();

  $.ajax({
   url: url,
   type: 'POST',
   dataType: 'json',
   data: { funcion:'consulta_inmueble', idkey_inmueble:idkey_inmueble },
   success: function(response){
    if(response["error"] == 0){
      $("#idkey_inmueble").val(idkey_inmueble);
      $("#garantias_categorias1").val(response['categoria']);
      $("#valor_fiscal").val(response['valor_fiscal']);
      $("#valor_catastral").val(response['valor_catastral']);
      $("#escritura").val(response['escritura']);
      $("#registro").val(response['registro']);
      $("#gravamen").val(response['gravamen']);
      $("#hipoteca").val(response['hipoteca']);
      $("#aforo").val(response['aforo']);
      $("#inmueble_descripcion").val(response['descripcion']);
      $("#inmueble_observaciones").val(response['observaciones']);
      $("#inmueble_medidas").val(response['medidas']);
    }
    else
      bootbox.alert('Error inesperado al consultar el inmueble. Inténtelo más tarde.');
   },
   error: function(data) {
        console.log(data);
      }
  });
}

function datatable_egresos(){
    $('#tablaEgresos').DataTable({
      "ajax": {
          "url": url,
          "type": "POST",
          "dataSrc": "",
          "data" : {
            "idkey_cliente" : $("#idkey_cliente").val(),
            "funcion" : "datatable_egresos"
          }
      },
      "columns": [
          {data: "egreso"},
          {data: "frecuencia"},
          {data: "monto"},
          {data: "tipo_pago"},
          {data: "acciones"}
      ],
      "bPaginate": false,
      "ordering": true,
      "searching": false,
      "bFilter": false,
      "bInfo": false,
      'sDom': 't' 
   });
}

function eliminar_egreso(idkey_egreso){
    // Confirm box
    bootbox.confirm("¿Está seguro que desea eliminar este egreso?", function(result) {

      if(result){
        $.ajax({
         url: url,
         type: 'POST',
         dataType: 'json',
         data: { funcion:'borrar_egreso', idkey_egreso:idkey_egreso },
         success: function(response){
           if(response["error"] == 0){
             alertify.success("Egreso borrado con éxito.");
             //Refresh datatable
             var datatable = $('#tablaEgresos').DataTable();
             datatable.ajax.reload();
           }
           else
              bootbox.alert('Error inesperado al eliminar el egreso. Inténtelo más tarde.');
         }
        });

       }

    });
  }

function cargar_egreso(idkey_egreso){
  var validator = $("#egresos").validate();
  validator.resetForm();

  $.ajax({
   url: url,
   type: 'POST',
   dataType: 'json',
   data: { funcion:'consulta_egreso', idkey_egreso:idkey_egreso },
   success: function(response){
    
    if(response["error"] == 0){
      $("#idkey_egreso").val(idkey_egreso);
      if(response['tipo_pago']=="1") $("#tipo_pago").prop('checked', true);
      $("#tipo_egreso").val(response['tipo_egreso']);
      $("#frecuencia_egreso").val(response['frecuencia_egreso']);
      $("#monto_egreso").val(response['monto_egreso']);
      $("#inicio_egreso").val(response['inicio_egreso']);
      $("#fin_egreso").val(response['fin_egreso']);
      $("#descripcion_egreso").val(response['descripcion_egreso']);
    }
    else
      bootbox.alert('Error inesperado al consultar el ingreso. Inténtelo más tarde.');
   }
  });

}

function ficha_cliente(){//perfil_cliente
    var parametros = {
      "funcion" : "perfil_cliente",
      "idkey_cliente" : $("#idkey_cliente").val()
      };

    $.ajax({
      url: url,
      data: parametros,
      type: 'post',
      dataType: 'json',
      asycn: true,
      success: function (response) {
        if(response['error']==0){
          $("#nombre").html(response["nombre"]);
          $("#rfc").html(response["rfc"]);
          $("#curp").html(response["curp"]);
          $("#fecha_creacion").html(response["fecha_creacion"]);
          $("#email").html(response["email"]);
          $("#telefono").html(response["telefono"]);
        }
        else{
          alert(response['error']);
          window.location.href="cartera_clientes.php";
        }
      },
     error: function(data) {
        console.log(data);
      }
    });
  }

function detalle_credito(idkey_credito){//Perfil credito
    var parametros = {
      "funcion" : "detalle_credito",
      "idkey_credito" : idkey_credito
      };

    $.ajax({
      url: url,
      data: parametros,
      type: 'post',
      dataType: 'json',
      asycn: true,
      success: function (response) {
        console.log(response);
        if(response['error']==0){
          $("#nombre").html(response["nombre"]);
          $("#folio_td").html(response["folio"]);
          $("#producto").html(response["desc_producto"]);
          $("#monto").html("$ "+response["monto"]);
          $("#frecuencia").html(response["desc_frec"]);
          $("#no_pagos").html(response["numero_pagos"]);
          $("#plazo").html(response["plazo"]);
          $("#finalidad").html(response["finalidad"]);
          $("#fecha_creacion").html(response["fecha_creacion"]);
          $("#folio").val(response["folio"]);
          $("#folio1").html(response["folio"]);
          $("#tipo_credito").val(response["tipo_credito"]);
          var link ="creditos_detalle.php?tipo="+response["tipo_credito"]+"&idkey_credito="+idkey_credito;
          $("#link_detalle_credito").attr('href',link);
          //Para los colores de status
          var color = '';
          if(response["estatus"] == 1)
            color = 'success';
          else if(response["estatus"] == 2)
            color = 'primary';
          else if(response["estatus"] == 3 || response["estatus"] == 5)
            color = 'danger';
          else 
            color = 'warning';
          $("#estatus").html("<span class='badge badge-sm bgc-"+color+"-l2 text-"+color+"-d2 border-1 brc-"+color+
            "-m3'>"+response["desc_estatus"]+"</span>");
          //Para los socios del crédito grupal
          $("#socios").html(response["socios"]);
        }
        else{
          alert(response['error']);
          window.location.href="cartera_clientes.php";
        }
      },
     error: function(data) {
        console.log(data);
      }
    });
  }

  function generar_contrato(){
    var idkey_cliente=$('#idkey_cliente').val();
    var idkey_credito=$('#idkey_credito').val();
    var tipo_credito =$('#tipo_credito').val();
    if(tipo_credito == 1){
      path = '../pdf/index_individual.php';
      redirectWindow = window.open('../pdf/index_individual.php?idkey_cliente='+idkey_cliente+'&idkey_credito='+idkey_credito, '_blank');
    }
    else{
      path = '../pdf/index_grupal.php';
      redirectWindow = window.open('../pdf/index_grupal.php?idkey_cliente='+idkey_cliente+'&idkey_credito='+idkey_credito, '_blank');
    }
      
    $.ajax({
      type: 'post',
      url: path,
      data:{
        idkey_cliente:$('#idkey_cliente').val(),
        folio:$('#folio_id').val()
      },
      success:function(data){
        redirectWindow.location;
      }
    });
  }

function progreso_credito(idkey_credito){
  $.ajax({
   url: url,
   type: 'POST',
   dataType: 'json',
   data: { funcion:'progreso_credito', idkey_credito:idkey_credito },
   success: function(response){
    console.log(response);
    if(response["error"] == 0){
      var color = '';
      var progreso =  Math.round(response["progreso"]);
      if(progreso == 0) 
        color='danger';
      else if(progreso > 1.00 && progreso < 20.00) color='warning';
      else if(progreso > 21.00 && progreso < 49.00) color='primary';
      else color='success';

      $("#progreso").append('<div class="progress-bar progress-bar-striped progress-bar-animated bgc-'+color+'"' +
        ' role="progressbar" aria-valuenow="'+progreso+'" aria-valuemin="0" aria-valuemax="100" style="width: '+progreso+'%">'+progreso+'%</div>');

      //Se manda a graficar si el progreso es mayor a 0
      if(progreso > 0)
        grafica_creditos(response.data);
      else{
        bootbox.alert('¡Aún no se han registrado pagos de este Crédito!');
        $("#grafica_anuncios").html("<i>No se han realizado pagos de este crédito</i>");
      }
    }
    
   },
    error: function(data) {
      console.log(data);
    }
  });
}


function creditos_cliente(){
  var idkey_cliente=$('#idkey_cliente').val();
  $.ajax({
     url: url,
     type: 'POST',
     dataType: 'json',
     data: { funcion:'creditos_cliente', idkey_cliente:idkey_cliente},
     success: function(response){
      console.log(response);
      if(response['creditos'].length >0){
        $("#creditos").html(response['creditos']);
        $("#ndiasmora_total").html(response['ndiasmora_total']);
        grafica_creditos(response.data);
      }
      else{
        $("#creditos").html("<tr align='center'><td colspan='3'><i>No se encontraron créditos.</i></td></tr>");
        $("#grafica_anuncios").html("<i>No se han realizado pagos de ningún crédito</i>");
        $("#ndiasmora_total").html("N/A");

      }
     },
     error: function(data) {
        console.log(data);
      }
  });

}

function random_rgba(trans) {
    var o = Math.round, r = Math.random, s = 255;
    return 'rgba(0,' + o(r()*s) + ',' + o(r()*s) + ',' + trans + ')';
}


function grafica_creditos(data){
  if(data.length>0){
      var data_graph = [];

      for (var i in data) {
          var item=[];
          for (var j in data[i].data) {
            item.push({x: data[i].data[j].x, y: data[i].data[j].y});
          }
          data_graph[i] = {
                label: "Crédito: "+data[i].folio,
                borderColor: random_rgba(1),
                backgroundColor: random_rgba(0.4),
                data: item
          };
      }

      var datasets = [];
      for (var i in data_graph) {
        datasets.push(data_graph[i]);
      }

      var config = {
          type: 'line',
          data: {datasets: datasets},
          options: {
            scales: {
              xAxes: [{
                type: "time",
                time: {
                  unit: 'month',
                  round: 'day',
                  displayFormats: {
                    day: 'MMM',
                    month: 'MMM-YY'
                  }
                },
                ticks: {
                  autoSkip: false
                },
                scaleLabel: {
                    display: true,
                    labelString: 'Mes',
                    fontSize: 20
                }
              }],
              yAxes: [{
                ticks: {
                  beginAtZero: true
                },
                scaleLabel: {
                  display: true,
                  labelString: 'Día de pago',
                  fontSize: 20 
                }
              }]
          }
        }
      }

      var ctx = document.getElementById("canvas").getContext("2d");
      window.myLine = new Chart(ctx, config);
  }
  else
    $("#grafica_anuncios").html("<i>No se han encontrado pagos.</i>");
}

function calcularPagos(plazo, frec){
  var pagos = 0;
  var meses = parseFloat(plazo);

  switch(frec){
    case '1': //semanal
      if (meses == 6) pagos = 24;
      else if (meses == 4) pagos = 16;
      else if (meses == 8) pagos = 32;
      else if (meses == 10) pagos = 40;
      else if (meses == 12) pagos = 52;
      else if (meses == 18) pagos = 77;
      else pagos = Math.round((meses*30)/7);
      break;
    case '2': //quincenal
      pagos = Math.round((meses*30)/15);
      break;
    case '3': //mensual
      pagos = meses;
      break;
    case '4': //pago único
      pagos = 1;
      break;
    default:
      pagos = 0;
  }
  return pagos;
}

function calcular_npagos(){ 
  var plazo=$("#plazo_meses").val();
  var frec=$("#frecuencia_pago").val();

  if(plazo!="" && frec!=""){
    var pagos = calcularPagos(plazo, frec);
    $("#numero_pagos").val(pagos);
  } 
  else
     $("#numero_pagos").val("");
}


function cargar_frecuencia(){
  var idkey_producto = $('#tipo_producto').val();
  if(idkey_producto == "")
    $("#frecuencia_pago").html("");
  else{

    $.ajax({
      url: url,
      type: 'POST',
      dataType: 'json',
      data: { funcion:'cargar_frecuencia_productos', idkey_producto:idkey_producto},
      success: function(response){
        //Reseteamos las validaciones del form
        var validator = $("#nuevoCred").validate();
        validator.resetForm();

        console.log(response);
        $("#frecuencia_pago").html(response['frecuencias']);
        $('#plazo_meses').attr('min', response['plazo_min']);
        $('#plazo_meses').attr('max', response['plazo_max']);
        $('#monto_credito').attr('min', response['monto_min']);
        $('#monto_credito').attr('max', response['monto_max']);

        if(response["nfrec"] == 0) //Si no se encontraron intereses se activa el campo
          $('#tasa_interes').attr('readonly', false);
        else
          $('#tasa_interes').attr('readonly', true);
      },
      error: function(data) {
        console.log(data);
      }
    });

  }
}

function cargar_interes(){
  var idkey_producto = $('#tipo_producto').val();
  var frecuencia_pago = $('#frecuencia_pago').val();
  var plazo_meses = $('#plazo_meses').val();

  if(idkey_producto != "" && frecuencia_pago != "" && plazo_meses != ""){
    var pagos = calcularPagos(plazo_meses, frecuencia_pago);

    $.ajax({
      url: url,
      type: 'POST',
      dataType: 'json',
      data: { 
        funcion:'cargar_interes', 
        idkey_producto:idkey_producto, 
        frecuencia_pago: frecuencia_pago, 
        pagos: pagos
      },
      success: function(response){
        console.log(response);
        $('#tasa_interes').val(response['interes_anual']);
      },
      error: function(data) {
        console.log(data);
      }
    });

  }
  else 
    $('#tasa_interes').val("");

}

function cargar_iva(){
    $.ajax({
      url: url,
      type: 'POST',
      dataType: 'json',
      data: { 
        funcion:'consultar_iva', 
      },
      success: function(response){
        console.log(response);
        if(response["error"]==0)
          $('#iva').val(response['iva']);
        else
          alertify.alert("No se encontró registrado el iva a aplicar en la base de datos.");
      },
      error: function(data) {
        console.log(data);
      }
    });
}

 function guardar_credito(){
    var idkey_cliente=$('#idkey_cliente').val();
    var tipo=$('#tipo').val();
    $.ajax({   
     url: url,   
     data: $("#nuevoCred").serialize()+ '&funcion=' + 'guardar_credito&tipo='+tipo,                  
     type: "POST",                 
     dataType: "json",
     asycn: true,
      beforeSend: function () {
        $("#animacion").show();
      },
     success: function(response){
      console.log(response);
       $("#animacion").slideUp('slow');
       if(response["error"]=='0'){  
          alert("Datos guardados correctamente.");
          window.location="creditos_detalle.php?tipo="+tipo+"&idkey_credito="+response["idkey_credito"];
       } 
       else
          alertify.error("¡Ha ocurrido un error inesperado! Inténtelo más tarde.");          
      }
    });
  }

function detalle_credito_general(idkey_credito){//Creditos_detalle
    var parametros = {
      "funcion" : "detalle_credito",
      "idkey_credito" : idkey_credito
      };

    $.ajax({
      url: url,
      data: parametros,
      type: 'post',
      dataType: 'json',
      asycn: true,
      success: function (response) {
        console.log(response);
        
        if(response['error']==0){
          $("#nombre").html(response["nombre"]);
          $("#folio").html(response["folio"]);
          $("#producto").html(response["desc_producto"]);
          $("#monto").html("$ "+response["monto"]);
          $("#frecuencia").html(response["desc_frec"]);
          $("#no_pagos").html(response["numero_pagos"]);
          $("#plazo").html(response["plazo"]);
          $("#finalidad").html(response["finalidad"]);
          $("#fecha_creacion").html(response["fecha_creacion"]);
          $("#tipo_credito").html(response["tipo_credito"]);
          $("#tasa_interes").html(response["tasa_interes"]+" %");
          $("#primer_pago").html(response["primer_pago"]);
          $("#finalidad").html(response["finalidad"]);
          $("#fecha_desembolso").html(response["fecha_desembolso"]);
          $("#tipo_desembolso").html(response["tipo_desembolso"]);
          $("#idkey_cliente").val(response["idkey_cliente"]);
          $("#prodeco").html(response["prodeco"]+" %");
          $("#fondeadora").html(response["fondeadora"]+" %");
          $("#prodeco1").val(response["prodeco"]);
          $("#fondeadora1").val(response["fondeadora"]);
          $("#gliquida").html(response["gliquida"]+" %");
          $("#gliquida1").val(response["gliquida"]);
          //Para los colores de status
          var color = '';
          if(response["estatus"] == 1)
            color = 'success';
          else if(response["estatus"] == 2)
            color = 'primary';
          else if(response["estatus"] == 3 || response["estatus"] == 5)
            color = 'danger';
          else 
            color = 'warning';
          $("#estatus").html("<span class='badge badge-sm bgc-"+color+"-l2 text-"+color+"-d2 border-1 brc-"+color+
            "-m3'>"+response["desc_estatus"]+"</span>");
          $("#estatus_pagos").html(response["estatus_pagos"]);
          //Para los socios del crédito grupal
          $("#socios").html(response["socios"]);
          $("#socios_score").html(response["socios_score"]);
          //campos a actualizar
          $("#idkey_estatus").val(response["idkey_estatus"]);
          $("#monto_credito").val(response["monto_credito"]);
          $("#plazo_meses").val(response["plazo"]);
          $("#fecha_desembolso1").val(response["fecha_desembolso"]);
          $("#tipo_desembolso1").val(response["idkey_tipo_desembolso"]);
          $("#fecha_pago1").val(response["primer_pago"]);

          if(response["idkey_estatus"]=='1' || response["idkey_estatus"]=='5'){//Si el crédito está autorizado o finalizado se desactiva el cambio de estatus
            $("#idkey_estatus").prop('disabled', true);
            $("#observaciones").prop('disabled', true);
            $("#monto_credito").prop('disabled', true);
            $("#plazo_meses").prop('disabled', true);
            $("#fecha_desembolso1").prop('disabled', true);
            $("#tipo_desembolso1").prop('disabled', true);
            $("#fecha_pago1").prop('disabled', true);
            $("#btnGuardarStatus").prop('disabled', true);
            $("#btnScore").prop('disabled', true);
            $("#prodeco1").prop('disabled', true);
            $("#fondeadora1").prop('disabled', true);
            $("#gliquida1").prop('disabled', true);
            $(".montos_socios").prop('disabled', true);
          }
          $("#observaciones").val(response["observaciones"]);
          //Para bloquear los botones de las amortizaciones y el contrato
          if(response["estatus"] == 2 || response["estatus"] == 3 || response["estatus"] == 4){
            $('#amortizacion1').attr("disabled", true);
            $('#amortizacion2').attr("disabled", true);
            $('#generar_contrato').attr("disabled", true);
            $('#generar_pagare').attr("disabled", true);
          }
        }
        else{
          alert(response['error']);
          window.location.href="../cartera/cartera_clientes.php";
        }
      },
     error: function(data) {
        console.log(data);
      }
    });
}

function generar_amortizacion(){
    var idkey_cliente=$('#idkey_cliente').val();
    var idkey_credito=$('#idkey_credito').val();
    var tipo_credito =$('#tipo_credito').val();
    if(tipo_credito == 1){
      path = '../pdf/index_tabla_amortizacion_ind.php';
      redirectWindow = window.open(path+'?idkey_cliente='+idkey_cliente+'&idkey_credito='+idkey_credito, '_blank');
    }
    else{
      path = '../pdf/index_tabla_amortizacion_grupal.php';
      redirectWindow = window.open(path+'?idkey_grupo='+idkey_cliente+'&idkey_credito='+idkey_credito, '_blank');
    }
    redirectWindow.location;
}

function generar_amortizacion_cliente(){
    var idkey_cliente=$('#idkey_cliente').val();
    var idkey_credito=$('#idkey_credito').val();
    var tipo_credito =$('#tipo_credito').val();
    if(tipo_credito == 1){
      path = '../pdf/index_tabla_amortizacion_ind_cliente.php';
      redirectWindow = window.open(path+'?idkey_cliente='+idkey_cliente+'&idkey_credito='+idkey_credito, '_blank');
    }
    else{
      path = '../pdf/index_tabla_amortizacion_grupal_clientes.php';
      redirectWindow = window.open(path+'?idkey_grupo='+idkey_cliente+'&idkey_credito='+idkey_credito, '_blank');
    }
    redirectWindow.location;
}

function generar_pagare(){
    var idkey_credito=$('#idkey_credito').val();
    var tipo_credito =$('#tipo_credito').val();
    if(tipo_credito == 1){
      path = '../pdf/pagare_ind.php';
      redirectWindow = window.open(path+'?idkey_credito='+idkey_credito, '_blank');
    }
    else{
      path = '../pdf/pagare_grupal.php';
      redirectWindow = window.open(path+'?idkey_credito='+idkey_credito, '_blank');
    }
    redirectWindow.location;
}

function comprobar_perfil_completo(idkey_cliente){
    $.ajax({   
     url: url,   
     data: {funcion: 'comprobar_perfil_completo_cliente', idkey_cliente: idkey_cliente},                  
     type: "POST",                 
     dataType: "json",
     asycn: true,
      beforeSend: function () {
        $("#animacion").show();
      },
     success: function(response){
      console.log(response);
       $("#animacion").slideUp('slow');
       if(response["perfil_completo"]==false){  
          alert("El perfil de este cliente está incompleto. No se puede proceder al alta del credito.");    
          window.location.href="index.php";
        } 
      },
      error: function(data) {
        console.log(data);
      }
    });
  }

function ver_amortizacion(id_campo_monto, titulo){
  var monto_credito = $(id_campo_monto).val();
  var tipo_producto = $('#tipo_producto').val();
  var frecuencia_pago = $('#frecuencia_pago').val();
  var plazo_meses = $('#plazo_meses').val();
  var iva = $('#iva').val();
  var numero_pagos = $('#numero_pagos').val();
  var tasa_interes = $('#tasa_interes').val();
  var fecha_pago1 = $('#fecha_pago1').val();

  if(tipo_producto=="" || frecuencia_pago=="" || plazo_meses=="" || monto_credito=="" || iva=="" || numero_pagos=="" || tasa_interes=="" || fecha_pago1=="")
     bootbox.alert("¡Para ver la tabla de amortización debes llenar todos los campos!");
  else if (validarViernes(fecha_pago1) == false)
    bootbox.alert("¡La fecha del primer pago debe ser Viernes!");
  else{
    var parametros = {
      "funcion": "ver_amortizacion",
      "frecuencia" : frecuencia_pago,
      "plazo": plazo_meses,
      "monto": monto_credito,
      "iva" : iva,
      "interes": tasa_interes,
      "fecha": fecha_pago1
    };
    $.ajax({   
       url: url,   
       data: parametros,                  
       type: "POST",                 
       dataType: "json",
       asycn: true,
       beforeSend: function () {
          $("#animacion").show();
       },
       success: function(response){
        console.log(response);

         $("#animacion").slideUp('slow');
         
         if(response['tabla'].length >0){

          var tabla = '<h5 class="text-purple-d2 mb-3">Tabla de Amortización '+titulo+'</h5><table class="table table-bordered text-dark-m1" width="100%"><thead><tr class="bgc-success-l3">'+
            '<th>Fecha Pago</th><th>Fecha Temporal</th><th>No. de Pago</th><th>Importe</th><th>Intereses</th><th>IVA</th><th>Abono Total</th><th>Nuevo Saldo</th></thead><tbody>';

          $.each(response['tabla'], function(i, response) {
             //var fecha = response.fecha.replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3/$2/$1');
            tabla += '<tr><td>'+response.fecha_pago+'</td>';
            tabla += '<td>'+response.fecha_temp+'</td>';
            tabla +='<td>'+response.no_pago+'</td>';
            tabla +='<td>'+response.capital+'</td>';
            tabla +='<td>'+response.interes+'</td>';
            tabla +='<td>'+response.iva+'</td>';
            tabla +='<td>'+response.total+'</td>';
            tabla +='<td>'+response.nuevo_saldo+'</td></tr>';
          });

          tabla +='</tbody></table>';
          $("#tabla").html(tabla);

         }
       },
      error: function(data) {
        console.log(data);
      }
    });
   }

}

function cargar_factores(idkey_cliente){
  $.ajax({   
     url: url,   
     data: {funcion: 'cargar_factores', idkey_cliente: idkey_cliente},                  
     type: "POST",                 
     dataType: "json",
     asycn: true,
      beforeSend: function () {
        $("#animacion").show();
      },
     success: function(response){
      console.log(response);
       $("#animacion").slideUp('slow');
       if(response["error"]==0){  
          $("#idkey_factores").val(response['idkey_factores']);
          $("#conocimiento").val(response['idkey_actividad']);
          $("#historial_buro").val(response['idkey_buro']);
          $("#capacidad_pago").val(response['idkey_cap_pago']);
          $("#comprobacion_ingresos").val(response['idkey_comp_ing']);
          $("#experiencia_crediticia").val(response['idkey_exp_cred']);
          $("#garantia_liquida").val(response['idkey_gliquida']);
          $("#referencias").val(response['idkey_ref']);
          $("#solvencia").val(response['idkey_solvencia']);
          $("#veracidad").val(response['idkey_veracidad']);
        } 
      },
      error: function(data) {
        console.log(data);
      }
  });
}

function generar_solicitud(){
  var idkey_cliente=$('#idkey_cliente').val();
  var idkey_credito=$('#idkey_credito').val();
  var tipo_credito =$('#tipo_credito').val();
  if(tipo_credito == 1){
    path = '../pdf/index_solicitud_ind.php';
    redirectWindow = window.open(path+'?idkey_cliente='+idkey_cliente+'&idkey_credito='+idkey_credito, '_blank');
  }
  else{
    path = '../pdf/index_solicitud_grupal.php';
    redirectWindow = window.open(path+'?idkey_grupo='+idkey_cliente+'&idkey_credito='+idkey_credito, '_blank');
  }
  redirectWindow.location;
      
}

function calcular_monto(){
    var montos_socios=0;
    $('input.montos_socios').each(function() {
      if($(this).val() != "")
        montos_socios += parseFloat($(this).val()); 
    });
    $("#monto_credito").val(montos_socios);
  }

//funcion para mostrar las cards  

const cards = async () => {
 
  try {
      const {nClientes, nCreditos} = await datosAsync('ncli_ncre_promotor');
      $("#nClientes").html(nClientes);
      $("#nCreditos").html(nCreditos);
    
  }catch(e) {
    throw new Error("Error al cargar los datos ")
  }

}

//funcion para descargar los clientes
const descargarClientes = async () => {
  $('#modalClientes').modal("show");

  let table = $('#tableImprClientes').DataTable();
  table.clear().draw();

table = $('#tableImprClientes').DataTable({
  "destroy":true,
  dom: 'Bfrtip',
  buttons: [
      'copy', 'csv', 'excel', 'pdf', 'print'
  ],

});

try {
  const datos = await datosAsync("descargarClientes");
  datos.forEach( ({nombre, fecha, idkey, curp, rfc}) => {
    table.row.add([
      nombre, fecha, idkey, curp, rfc
    ]).draw(false);
  })
  swal.close();
  
}catch(e) {
  swal.close();
  table.row.add([
    '','','','',''
  ]).draw(false);
  throw new Error("Error al cargar los datos")

}

}

const descargarCreditos = async () => {
  $('#modalCreditos').modal("show");
  let table = $('#tableImprCreditos').DataTable();
  table.clear().draw();

  table = $('#tableImprCreditos').DataTable({
    "destroy":true,
    dom: 'Bfrtip',
    buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
    ],

  });

  try {
    const datos = await datosAsync("descargarCreditos");
    datos.forEach( ({folio, nombre, nombre_producto, monto, fecha_creacion}) => {
      table.row.add([
        folio, nombre, nombre_producto, format_currency(parseFloat(monto)), fecha_creacion
      ]).draw(false);
    })
    swal.close();
    
  }catch(e) {
    swal.close();
    table.row.add([
      '','','','',''
    ]).draw(false);
    throw new Error("Error al cargar los datos")

  }
}

//funcion para formatear a moneda mxn
const format_currency = (cantidad) => new Intl.NumberFormat('MXN', {style: 'currency',currency: 'MXN', minimumFractionDigits: 2}).format(cantidad);
  
//AJAX ASYNC PARA CONECTAR A PHP 

const datosAsync = async (funcion) => $.ajax({url , type: 'POST',async: true, dataType: 'json', data: {funcion}, beforeSend: () => { 
Swal.fire({ title: '¡Espere un momento!', html: 'Cargando...', allowOutsideClick: false, onBeforeOpen: () => { Swal.showLoading() } }); } });


// function cards(){
//     var parametros = {
// 		"funcion" : "ncli_ncre_promotor",
//     };
  
// 	$.ajax({
//     url: url,
// 		data: parametros,
//     type: 'post',
//     dataType: "json",
// 		beforeSend: function () {
//             //animación de carga
//         },
// 		success: function (response) {
//             $("#nClientes").html(response['nClientes']);
//             $("#nCreditos").html(response['nCreditos']);
// 		}
//     });
// }
