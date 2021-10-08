var url = "../php/json_func_corte.php";

function mostrar_modal(){
    $("#modalMuebles").modal("show");
}

function abrir_corte(){
    
    location.href = "../corte/corte_actual.php";
}

function datatable_corte(){
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
            var table = $("#datatable").dataTable(); 
            console.log(response);
            $.each(response, function(i, response) {
    
                var botones ='<a href="../pdf/ticket_buro.php?idkey='+response.idkey+' " class="btn radius-1 btn-sm btn-brc-tp btn-outline-default btn-h-outline-purple btn-a-outline-purple btn-text-purple" title="Imprimir Recibo" target="_blank"><i class="fas fa-receipt"></i></a>';
                
              table.fnAddData([
                '<input type="checkbox" name="" id="" autocomplete="off" value="'+response.idkey+'"/>',
                response.idkey,
                response.monto,
                response.fecha
                ,
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
    $.ajax({
        url:url,
        data: {funcion:'cargar_select'},
        type:'post',
        dataType: 'json',
        async: true,
        beforeSend: function(){

        },
        success: function(response){
            $.each(response, function(key, value){
                $('#num_caja').append("<option value="+value+"> "+value+" </option>");
            });
            
            
        },
        error: function(data){
            alertify.error("Ha ocurrido un error inesperado. Inténtelo más tarde!");
            console.log(data);
        }

    });

    $('#num_caja').append(no_cajas);
}

function seleccion(){
    var valor = $('#num_caja').val();
    console.log(valor);
    $.ajax({
        url:url,
        data: { funcion: 'cargar_corte', valor:valor},
        type: 'post',
        dataType: 'json',
        async: true,
        beforeSend: function(){

        },
        success: function(response){
            console.log(response);
            $.each(response, function(key, value){

                console.log(response.fecha_actual);

                $('#fecha').val(response.fecha_actual);
                $('#corte').val(response.num_caja);
                $('#hora').val(response.hora);
                $('#efectivo').val(response.saldo_actual);
                $('#usuario').val(response.usuario);

            });
        },
        error: function(data){
            console.log(data);
        }  
    });

}


init();