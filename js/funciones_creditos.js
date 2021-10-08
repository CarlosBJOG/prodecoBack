//Funciones para Cartera que retorna un json de php/json_func_clientes
var url = 'php/json_func_creditos.php';

function display_credito_individual(idkey){
    var parametros = {
		"funcion" : "creditos_clientes_individual",
        "idkey_cliente": idkey,
    };
    
	$.ajax({
        url: url,
		data: parametros,
        type: 'post',
        dataType: 'json',
	beforeSend: function () {
            $('#cred_load').html('<tr><td colspan=7 style="text-align:center"><div  class="spinner-grow text-success" role="status"><span class="sr-only">Loading...</span></div></td></tr>');
        },
	success: function (response) {
	    console.log(response);
            var div = $("#cred_data"); 
            $.each(response, function(i, response){
              div.append([
	      '<a class="dropdown-item btn btn-outline-dark btn-h-info btn-a-info my-1 radius-2px" href="perfil-credito-ind.php?idkey_credito='+
	      response.idkey_credito+'&idkey_cliente='+response.idkey_cliente+'"><h3>'+response.folio+' - '+response.desc_tipo+'</h3></a>'
              ]);

            });
	}
    });
}

function display_credito_grupal(idkey){
    var parametros = {
		"funcion" : "creditos_clientes_grupal",
        "idkey_cliente": idkey,
    };
    
	$.ajax({
        url: url,
		data: parametros,
        type: 'post',
        dataType: 'json',
	beforeSend: function () {
            $('#cred_load').html('<tr><td colspan=7 style="text-align:center"><div  class="spinner-grow text-success" role="status"><span class="sr-only">Loading...</span></div></td></tr>');
        },
	success: function (response) {
	    console.log(response);
            var div = $("#cred_data"); 
            $.each(response, function(i, response){
              div.append([
	      '<a class="dropdown-item btn btn-outline-dark btn-h-info btn-a-info my-1 radius-2px" href="perfil-credito-grupo.php?idkey_credito='+
	      response.idkey_credito+'&idkey_cliente='+response.idkey_cliente+'"><h3>'+response.folio+' - '+response.desc_tipo+'</h3></a>'
              ]);

            });
	}
    });
}

function creditos_pago_progreso(credito){
    var parametros = {
		"funcion" : "creditos_pago_progreso",
		//"idkey_cliente":idkey,
		"idkey_credito":credito,
    };
    alert();
    
	$.ajax({
	    url: url,
	    data: parametros,
	    type: 'post',
	    dataType: 'json',
	    beforeSend: function () {//animación de carga
		},
	success: function (response) {
	    //alert(response.Pagos);
	    console.log(response);
	    var prog_db = Math.round(response.Pagos)
	    color = '';
	    if(prog_db == 0)
		color='danger';
	    else if(prog_db > 1.00 && prog_db < 20.00)
		color='warning';
	    else if(prog_db > 21.00 && prog_db < 49.00)
		color='primary';
	    else
		color='success';
		
            $("#progreso_individual").append(
	    '<div class="progress-bar bgc-'+color+' font-bolder" role="progressbar" style="width: '+prog_db+
		'%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">'+prog_db+'</div>'
	    );
		}
    });
}

function grafica_perfil_cliente(credito){
    var parametros = {
		"funcion" : "grafica_perfil_cliente",
		"idkey_cliente": idkey,
    };
    
	$.ajax({
        url: url,
		data: parametros,
        type: 'post',
        dataType: 'json',
	beforeSend: function () {
            $('#grafica_perfil').html('<tr><td colspan=7 style="text-align:center"><div  class="spinner-grow text-success" role="status"><span class="sr-only">Loading...</span></div></td></tr>');
        },
	success: function (response) {
	    console.log(response);
            var canvas = document.getElementById("chartCliente");
	    var ctx = canvas.getContext('2d'); 
            $.each(response, function(i, response){  
	    var data = {
	      labels: ["May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
	      datasets: [{
		  label: response.folio	,
		  fill: false,
		  lineTension: 0.1,
		  backgroundColor: "rgba(134, 189, 104, 0.3)",
		  borderColor: '#73bd73', // The main line color
		  borderCapStyle: 'square',
		  borderDash: [], // try [5, 15] for instance
		  borderDashOffset: 0.0,
		  borderJoinStyle: 'miter',
		  pointBorderColor: "#73bd73",
		  pointBackgroundColor: "white",
		  pointBorderWidth: 1,
		  pointHoverRadius: 8,
		  pointHoverBackgroundColor: "#fffa91",
		  pointHoverBorderColor: "#319e31",
		  pointHoverBorderWidth: 2,
		  pointRadius: 4,
		  pointHitRadius: 10,
		  data: [1, 15, 29, 12, 26, 10, 24, 7, 21],
		}
	      ]
	    };

	    // Notice the scaleLabel at the same level as Ticks
	    var options = {
	      scales: {
		    xAxes: [{
			    display: true,
			    scaleLabel: {
				display: true,
				labelString: 'Mes',
				fontSize: 20
			    }
			}],
		    yAxes: [{
			ticks: {
			    beginAtZero:true
			},
			scaleLabel: {
				display: true,
				labelString: 'Día de pago',
				fontSize: 20 
			    }
		    }]            
		    } , 
		    tooltips:{
			enabled: true,
			cornerRadius: 5,
			
			titleFontColor: '#fff',
			titleFontSize: 16,
			titleFontStyle: 'bold',

			bodyFontColor: '#fff',
			bodyFontSize: 14,
			fontFamily: 'Open Sans',
			
			backgroundColor: '#73bd73',
			
			xPadding: 10,
			yPadding: 10,
		    }  
	    };

	    // Chart declaration:
	    var myBarChart = new Chart(ctx, {
	      type: 'line',
	      data: data,
	      options: options
	    });
            });
	}
    });
}


