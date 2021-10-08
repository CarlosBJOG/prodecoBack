var url = "../php/json_func_facturacion.php";

function init(){
    //validacion de formulario
    
    var form = $('#formulario');
    form.validate({errorClass: 'text-error'});
    $('#btnregistros').click(function(){
        if(form.valid()){
            var fecha_inicio = $('#fecha_inicio').val();
            var fecha_fin = $('#fecha_fin').val();

            bootbox.confirm("Guardar datos?", function(result){
                if(result){

                    $.ajax({
                        url: url,
                        type: 'POST',
                        dataType: 'json',
                        data:  {
                            funcion: 'cargar',
                            fecha_inicio: fecha_inicio,
                            fecha_fin:fecha_fin
                         
                        },
                        success: function(response){

                            console.log(response);
                            var table = $("#datatable").dataTable(); 
                            $.each(response, function(i, response) {
                                //Para los colores de status
                                console.log(response.rfc);
                                if(response.rfc == 'SIN RFC'){
                                    console.log(response.rfc);
                                }else{
                                    table.fnAddData([
                                        '<input type="checkbox" name="" id="" autocomplete="off" value="'+response.idkey_credito+'"/>',
                                        response.idkey_credito,
                                        '<a  href="../cartera/perfil-cliente.php?idkey_cliente='+response.idkey+'" style="text-decoration: none;" class="font-light text-secondary ">'+response.nombre+'</a>',
                                        response.nombre_producto,
                                        response.fecha_valor,
                                        response.iva,
                                        response.interes,
                                        response.iva_moratorio,
                                        response.pago_interes_moratorio,
                                        response.rfc
                               
                                      ]);
                                }
                              
                              });
                
                        },
                        error: function(data){
                            console.log(data);
                        }
                    });
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

init();