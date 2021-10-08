url = "../php/json_func_dacion.php" ;

function datatable_gastos(){
    var parametros = {
        "funcion" : "cargar_tabla",
    };
   
    $.ajax({
        url: url,
        data: parametros,
        type: 'post',
        dataType: 'json',
        asycn: true,
        beforeSend: function () {
            $('#bodytable').html('<tr><td colspan=7 style="text-align:center"><div  class="spinner-grow text-success" role="status"><span class="sr-only">Loading...</span></div></td></tr>');
        },
        success: function (response) {
            console.log(response);
            
            var table = $("#datatable").dataTable(); 

            $.each(response, function(i, response) {
              //Para los colores de status
              var color = '';
              if(response.fecha_valor == 'Ninguno'){
                console.log(response.desc_estatus);
              }
             if(response.desc_estatus == 1){
                  //autorizado
                color = 'success';
                var botones ='<a href="#" class="btn radius-1 btn-sm btn-brc-tp btn-outline-primary btn-h-outline-primary btn-a-outline-primary btn-text-primary" title="Aplicar dacion" onclick="aplicar_dacion( '+response.idkey+') "><i class="fas fa-hand-holding-usd"></i></a>';
            }else{
                var botones ='<a href="#" class="btn radius-1 btn-sm btn-brc-tp btn-outline-primary btn-h-outline-primary btn-a-outline-primary btn-text-primary" title="Aplicar pago"><i class="fas fa-hand-holding-usd"></i></a>';
            
            }
                // estatus = "<span class='badge badge-sm bgc-"+color+"-l2 text-"+color+"-d2 border-1 brc-"+color+"-m3'>"+response.desc_estatus+"</span>";

              table.fnAddData([
                '<input type="checkbox" name="" id="" autocomplete="off" value="'+response.idkey+'"/>',
                response.idkey,
                response.fecha_valor,
                response.nombre,
                response.producto,
                response.saldo_insoluto,
                response.estatus,
                '<div class="col text-center"><pre>'+botones+
                '</pre></div>'
              ]);
            });

            
        },
        error: function(data) {
          alertify.error("Ha ocurrido un error inesperado. Inténtelo más tarde!");
          console.log(data);
        }
    });
}

function init(){
    //ocultamos el form y mostramos la tabla 
    $('.tabla').show();
    $('#formulario').hide();
    $("#tabla_muebles").hide();
    $("#tabla_inmuebles").hide();
    
    
    //validacion de formulario
    var form = $('#formulario').hide();
    form.validate({errorClass: 'text-error'});
    $('#btnGuardar').click(function(){
        if(form.valid()){
         
            bootbox.confirm("Guardar datos?", function(result){

                var monto = parseFloat( $('#monto').val() );
                var adeudo = parseFloat( $('#num_pago').val());
                console.log(adeudo);
                if(monto > adeudo && monto > 0){
                    if(result){
                        //metodo ajax para cargar los datos en los inputs
                        var idkey_credito = $('#idkey_credito').val();
                        var monto = $('#monto').val();
                        var garantia = $('#garantia').val();
                        var fecha_registro = $('#registro').val();
                        array = [idkey_credito, monto, garantia, fecha_registro];

             
    
                         $.ajax({
                             url: url,
                             type: 'POST',
                             dataType: 'json',
                             data:  {funcion: 'guardar', array: array},
                             success: function(response){
                                 console.log(response);
                                 if(response['error'] == 0){
                                     alertify.success('Datos guardados correctamente');
                                     //location.href = "../home.php";
                                    
                                 }else if (response['error'] == 2) {
                                        alertify.error('El credito no tiene pagos registrados');

                                 }else if (response['error'] == 3) {
                                    alertify.error('Debes registrar minimo una garantia');

                                }else{
                                     alertify.error('Ocurrio un error');
                                    //  location.href = "../home.php";
                                 }
                            
                    
                             },
                             error: function(data){
                                 console.log(data);
                             }
                         });
                        
                        }
                }
                else{
                    alertify.error("El monto debe ser mayor al adeudo del credito");
                }
            });
                
        }else{
            bootbox.alert({
                size: "small",
                title: "Aviso!",
                message: "Faltan campos por completar",
                callback: function(){ /* your callback code */ }
            })
        }

    });

}

function aplicar_dacion(idkey){
    $('.tabla').hide();
    $('#formulario').show();

    var idkey = idkey;

    //metodo ajax
  $.ajax({
      url: url,
      type: 'POST',
      dataType: 'json',
      data:  {funcion: 'cargar_datos', idkey: idkey},
      success: function(response){
            
          $.each(response, function(i, response) {

             var saldo = response.saldo.replace(/ /g, "");

              //Para los colores de status
               $('#idkey_credito').val(response.idkey);
               $('#buscar').val(response.producto);
               $('#nombre').val(response.nombre);
               $('#num_pago').val(saldo);

          });
         

      },
      error: function(data){
          console.log(data);
      }
  });
   
}

//funcion cancelar formulario
function cancelarform(){
    
    $('#formulario').hide();
    $('.tabla').show();

    $("#formulario")[0].reset();
    $('#garantia').attr("disabled", false);

    $("#tabla_muebles").hide();
    $("#tabla_inmuebles").hide();
    actualizar_page();
    
}

function mostrar_tabla(){
    var opcion = $('#garantia').val();
    if(opcion == 5){
        $("#tabla_muebles").show();
        $("#tabla_inmuebles").hide();
        datatable_muebles()
       
    }else if (opcion == 6){
        $("#tabla_inmuebles").show();
        $("#tabla_muebles").hide();
        datatable_inmuebles()

    }
}

function seleccion(){
    var opcion = $('#garantia').val();
    if(opcion == 5){
        $("#modalMuebles").modal("show");
            //Se resetea el form cuando se cierra el modal
        $("#muebles")[0].reset();
        $('#cobertura').val('');
        var validator = $("#muebles").validate();
        validator.resetForm();
        
           //validacion de formulario
        var form = $('#muebles').show();
        form.validate({errorClass: 'text-error'});
        //btnModal
        $('#btnModal').click(function(){
            if(form.valid()){
                    var idkey_credito = $('#idkey_credito').val();
                    var categoria = $('#garantias_categorias').val();
                    var valor_comercial = $('#valor_comercial').val();
                    var marca = $('#marca').val();
                    var modelo = $('#modelo').val();
                    var ref_o_fact = $('#referencia_factura').val();
                    var fecha_ad = $('#fecha_adquisicion').val();
                    var cobertura = $('#cobertura').val();
                    var observaciones = $('#mueble_observaciones').val();

                    array = [idkey_credito, categoria, valor_comercial, marca, modelo, ref_o_fact, fecha_ad, cobertura, observaciones];
                   
                    $.ajax({
                        url: url,
                        type: 'POST',
                        dataType: 'json',
                        data:  {funcion: 'guardar_garantia', array: array},
                        beforeSend: function () {
                            $('#btnModal').attr('disabled', true);
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
                            
                           if(response['error'] == 0){
                                alertify.success("Garantia guardada");
                                $('#tablaMuebles').DataTable().ajax.reload();
                                
                           }

                           swal.close();
                        
                           
                  
                        },
                        error: function(data){
                            console.log(data);
                        }
                    });


                   //se cierra el modal
                   $("#modalMuebles").modal("toggle");
                   $('.modal-backdrop').remove();
                   
            }else{
                alertify.error("Algunos datos están incompletos o erróneos");
                
            }
        });

    }else if(opcion == 6){
        $("#modalInmuebles").modal("show");

        //Se resetea el form cuando se cierra el modal
        $("#inmuebles")[0].reset();
        var validator = $("#inmuebles").validate();
        validator.resetForm();
        
        //validacion de formulario
        var form = $('#inmuebles').show();
        form.validate({errorClass: 'text-error'});
        var btn = $('#btnGuardarinmueble');
        
        $('#btnGuardarinmueble').click(function(e){
           e.preventDefault();
          
            if(form.valid()){
                //alert('hola');
                    var idkey_credito = $('#idkey_credito').val();
                    var categoria = $('#garantias_categorias1').val();
                    var valor_fiscal = $('#valor_fiscal').val();
                    var valor_catastral = $('#valor_catastral').val();
                    var num_escritura = $('#escritura').val();
                    var registro = $('#registro').val();
                    var gravamen = $('#gravamen').val();
                    var hipoteca = $('#hipoteca').val();
                    var aforo = $('#aforo').val();
                    var descripcion = $('#inmueble_descripcion').val();
                    var observaciones = $('#inmueble_observaciones').val();
                    var medidas = $('#inmueble_medidas').val();

                    array = [idkey_credito, categoria, valor_fiscal, valor_catastral, num_escritura, registro, gravamen, hipoteca, aforo, descripcion, observaciones, medidas];
                   
                    $.ajax({
                        url: url,
                        type: 'POST',
                        dataType: 'json',
                        data:  {funcion: 'guardar_garantia_inmueble', array: array},
                        beforeSend: function () {
                            btn.attr('disabled', true);
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
                         

                           if(response['error'] == 0){
                                alertify.success("Garantia guardada");
                                $('#tablaInmuebles').DataTable().ajax.reload();
                                    
                           }
                           swal.close();
                  
                        },
                        error: function(data){
                            console.log(data);
                        }
                    });


                      //se cierra el modal
                $("#modalInmuebles").modal("toggle");
                $('.modal-backdrop').remove();
            }else{
                alertify.error("Algunos datos están incompletos o erróneos");
                
            }
        });


    }else{

    }
}

function datatable_inmuebles(){
 //   var idkey = $("#idkey_credito").val();
    var table = $('#tablaInmuebles').DataTable();
    table.destroy();
    
    $('#tablaInmuebles').DataTable({
        "ajax": {
            "url": url,
            "type": "POST",
            "dataSrc": "",
            "data" : {
              "idkey_credito" : $("#idkey_credito").val(),
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

function datatable_muebles(){

    var table = $('#tablaMuebles').DataTable();
    table.destroy();
    $('#tablaMuebles').DataTable({
        "ajax": {
            "url": url,
            "type": "POST",
            "dataSrc": "",
            "data" : {
              "idkey_credito" : $("#idkey_credito").val(),
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

function eliminar_mueble(idkey){
    // Confirm box
    bootbox.confirm("¿Está seguro que desea eliminar esta garantía mueble?", function(result) {

        if(result){

            $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: { funcion:'borrar_mueble', idkey_mueble:idkey },
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

function eliminar_inmueble(idkey){
        // Confirm box
        bootbox.confirm("¿Está seguro que desea eliminar inmueble?", function(result) {

            if(result){
    
                $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: { funcion:'borrar_inmueble', idkey_mueble:idkey },
                success: function(response){
                    if(response["error"] == 0){
                    alertify.success("Mueble borrado con éxito.");
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



function actualizar_page(){
    location.reload(true);
}
init()