alertify.defaults.transition = "slide";
alertify.defaults.theme.ok = "btn btn-primary btn-sm";
alertify.defaults.theme.cancel = "btn btn-danger btn-sm";
alertify.defaults.theme.input = "form-control form-control-sm";


/*.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-*/
/*.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-*/
//Variables definidas para el ambiente

var request_ajax="";
/*.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-*/
//*.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-*/
//Funciones Ajax
function object_ajax()
{
	var dinamic_ajax=false;
	try {
		dinamic_ajax = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e)
	{
		try {
			dinamic_ajax = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (E) {
			dinamic_ajax = false;
			}
		}
	
	if (!dinamic_ajax && typeof XMLHttpRequest!='undefined') {
		dinamic_ajax = new XMLHttpRequest();
	}
	return dinamic_ajax;
}
/*.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-*/
/*.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-*/
function ajax_interface(url,objectDiv,values,methods)
    {
	var ajax=object_ajax();
	var DivInteface = document.getElementById(objectDiv);
	/*DivInteface.innerHTML="";*/

	if(methods.toUpperCase()=='POST')
	{
		ajax.open ('POST', url, true);
		ajax.onreadystatechange = function()
		{
			if (ajax.readyState==1)
			{
				DivInteface.innerHTML="Procesando...";
			}
			else if (ajax.readyState==4)
			{
				if(ajax.status==200)
				{
					document.getElementById(objectDiv).innerHTML=ajax.responseText; 
				}
				else if(ajax.status==404)
				{					
					DivInteface.innerHTML="Procesando...";
				}
				else
				{
					DivInteface.innerHTML= "Ajax_Error"+ajax.status;
				}
			}
		}
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax.send(values);
		return;
	}
	
	if (methods.toUpperCase()=='GET')
	{
		ajax.open ('GET', url, true);
		ajax.onreadystatechange = function()
		{
			if (ajax.readyState==1)
			{
				DivInteface.innerHTML="Procesando...";
			}
			else if (ajax.readyState==4)
			{
				if(ajax.status==200)
				{ 
					document.getElementById(objectDiv).innerHTML=ajax.responseText; 
				}
				else if(ajax.status==404)
				{
					DivInteface.innerHTML="Procesando...";
				}
				else
				{
					DivInteface.innerHTML = "Error:"+ajax.status;
				}
			}
		}
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax.send();
		return
	}
}

function ajax_processingdata(url,values,methods)
{

	var ajax=object_ajax();
	if(methods.toUpperCase()=='POST'){
	    ajax.open ('POST', url, false);
	    ajax.onreadystatechange = function(){
		if (ajax.readyState==4)
		    {
			if(ajax.status==200) { request_ajax=ajax.responseText; }
		    }
		}
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax.send(values);
		return;
	    }	

	if (methods.toUpperCase()=='GET')
	{
		ajax.open ('GET', url, false);
		ajax.onreadystatechange = function()
		{
			if (ajax.readyState==4)
			{
				if(ajax.status==200) { request_ajax=ajax.responseText; }
			}
		}
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax.send(null);
		return
	}
}


function ajax_interfaceToelement(url,objectDiv,values,methods)
{
	var ajax=object_ajax();
	var DivInteface = document.getElementById(objectDiv);
	/*DivInteface.innerHTML="";*/

	if(methods.toUpperCase()=='POST')
	{
		ajax.open ('POST', url, true);
		ajax.onreadystatechange = function()
		{
			if (ajax.readyState==1)
			{
			//	DivInteface.innerHTML="Procesando...";
			}
			else if (ajax.readyState==4)
			{
				if(ajax.status==200)
				{
					document.getElementById(objectDiv).value=ajax.responseText; 
				}
				else if(ajax.status==404)
				{					
				//	DivInteface.innerHTML="Procesando...";
				}
				else
				{
				//	DivInteface.innerHTML= "Ajax_Error"+ajax.status;
				}
			}
		}
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax.send(values);
		return;
	}
	
	if (methods.toUpperCase()=='GET')
	{
		ajax.open ('GET', url, true);
		ajax.onreadystatechange = function()
		{
			if (ajax.readyState==1)
			{
//				DivInteface.innerHTML="Procesando...";
			}
			else if (ajax.readyState==4)
			{
				if(ajax.status==200)
				{ 
					document.getElementById(objectDiv).value=ajax.responseText; 
				}
				else if(ajax.status==404)
				{
				//	DivInteface.innerHTML="Procesando...";
				}
				else
				{
			//		DivInteface.innerHTML = "Error:"+ajax.status;
				}
			}
		}
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax.send(null);
		return
	}
}




var checks;
	var resultados;

(function ( $ ) {

	$.fn.start_for_clients = function()
	{

    $("#nombre").inputFilter(function(value){ return /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s\t]*$/i.test(value);  });
    $("#domicilio").inputFilter(function(value){ return /^[0-9a-zA-ZáéíóúÁÉÍÓÚñÑ\s\t]*$/i.test(value);  });
    $("#exterior").inputFilter(function(value){ return /^[0-9a-zA-Z\t]*$/i.test(value);  });
    $("#interior").inputFilter(function(value){ return /^[0-9a-zA-Z\t]*$/i.test(value);  });
    $("#apellido_p").inputFilter(function(value){ return /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s\t]*$/i.test(value);  });
    $("#apellido_m").inputFilter(function(value){ return /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s\t]*$/i.test(value);  });
    $("#nacimiento").activeCalendary('#nacimiento');
    $("#rfc").inputFilter(function(value){ return /^[0-9a-zA-Z\t]*$/i.test(value);  });
    $("#curp").inputFilter(function(value){ return /^[0-9a-zA-Z\t]*$/i.test(value);  });
    
    $("#inicia_habitar").activeCalendary('#inicia_habitar');
    $("#vigencia").activeCalendary('#vigencia');
    $("#entrecalles").inputFilter(function(value){ return /^[0-9a-zA-ZáéíóúÁÉÍÓÚñÑ\s\t]*$/i.test(value);  });
    $("#referencia").inputFilter(function(value){ return /^[0-9a-zA-ZáéíóúÁÉÍÓÚñÑ\s\t]*$/i.test(value);  });
    $("#observaciones").inputFilter(function(value){ return /^[0-9a-zA-ZáéíóúÁÉÍÓÚñÑ\s\t]*$/i.test(value);  });

	};

	$.fn.producto_descripcion = function(param){

		

	};

	$.fn.getClients_to_credit = function(param){
		window.location="creditos_alta_1.php?id="+param;
	};

	$.fn.empleado_clearSecundary = function() {
            $('#nombre_f').val('');
            $('#apellido_p_f').val('');
            $('#apellido_m_f').val('');
            $('#edad_f').val('');
            $('#sexo_f').val('');
            $('#domicilio_f').val('');
            $('#estados_f').val('');
            $('#municipios_f').html("<option value='' selected></option>");
            $('#localidad_f').html("<option value='' selected></option>");
            $('#codigo_postal_f').html("<option value='' selected></option>");            
            $('#ine_f').val('');
            $('#rfc_f').val('');
            $('#telefono1_f').val('');
            $('#telefono2_f').val('');
            $('#telefono3_f').val('');
            $('#email_f').val('');
            $('#parentesco_f').val('');
            $('#tipo_direccion').val('1');
            $('#incompleto_f').show(1);
            $('#completo_f').hide();
	};

	$.fn.empleado_clearPrimary = function() {
            $('#nombre_m').val('');
            $('#apellido_p_m').val('');
            $('#apellido_m_m').val('');
            $('#edad_m').val('');
            $('#sexo_m').val('');
            $('#domicilio_m').val('');
            $('#estados_m').val('');
            $('#municipios_m').html("<option value='' selected></option>");
            $('#localidad_m').html("<option value='' selected></option>");
            $('#codigo_postal_m').html("<option value='' selected></option>");
            $('#departamentos_m').val('');
            $('#puestos_m').html("<option value='' selected></option>");
            $('#ine_m').val('');
            $('#rfc_m').val('');
            $('#telefono1_m').val('');
            $('#telefono2_m').val('');
            $('#telefono3_m').val('');
            $('#email_m').val('');
            $('#familiares').val('');
            $('#familiares_div').html('');
	};

	$.fn.loadDatas = function(){

            $('#nombre_m').val($('#get_nombre').val());
            $('#apellido_p_m').val($('#get_apellido_p').val());
            $('#apellido_m_m').val($('#get_apellido_m').val());
            $('#edad_m').val($('#get_edad').val());
            $('#sexo_m').val($('#get_idkey_sexo').val());

            $('#domicilio_m').val($('#get_domicilio').val());
            $('#estados_m').val($('#get_idkey_estados').val());

            $.ajax({type: "get",url:"../php/functions.php",data:"module=change_estadosTOmunicipios&param1="+$('#get_idkey_estados').val()+"&param2="+$('#get_idkey_estados').val(),success:function(resultdado){ $('#municipios_m').html(resultdado);  }     }); 
            $.ajax({type: "get",url:"../php/functions.php",data:"module=change_municipiosTOlocalidad&param1="+$('#get_idkey_municipios').val()+"&param2="+$('#get_idkey_localidad').val(),success:function(resultdado){ $('#localidad_m').html(resultdado);  }     }); 
            $.ajax({type: "get",url:"../php/functions.php",data:"module=change_localidadTOcodigo_postal&param1="+$('#get_idkey_localidad').val()+"&param2="+$('#get_idkey_codigo_postal').val(),success:function(resultdado){ $('#codigo_postal_m').html(resultdado);  }     }); 

            $('#ine_m').val($('#get_ine').val());
            $('#rfc_m').val($('#get_rfc').val());
            $('#telefono1_m').val($('#get_telefono1').val());
            $('#telefono2_m').val($('#get_telefono2').val());
            $('#telefono3_m').val($('#get_telefono3').val());


            $.ajax({type: "get",url:"../php/functions.php",data:"module=combo_departamentos&param1="+$('#get_idkey_departamentos').val(),success:function(resultdado){ $('#departamentos_m').html(resultdado);  }     }); 

            $.ajax({type: "get",url:"../php/functions.php",data:"module=combo_puestos&param1="+$('#get_idkey_departamentos').val()+"&param2="+$('#get_idkey_puestos').val(),success:function(resultdado){ $('#puestos_m').html(resultdado);  }     }); 




            $('#email_m').val($('#get_email').val());

            $('#familiares_div').load("../php/familiares_show.php?data="+escape($('#datas').val()   ));

            $("#familiares").val($('#datas').val());

	};

	$.fn.onchange_garantias_tipos = function(param1,param2){
		if (param1!="")
		{
			$(param2).html("");
			$.ajax({
				type: "get",
				url:"../php/functions.php",
				data:"module=change_garantias_tiposTOgarantias_categorias&param1="+param1+"&param2=",
				success:function(resultdado){ $(param2).html(resultdado);}
			});
		}
	};
	
	$.fn.onchange_empleador = function(param1,param2){
		if (param1!="")
		{
			$(param2).html("");
			$.ajax({
				type: "get",
				url:"../php/functions.php",
				data:"module=change_empleadorTOdomiclio_empleador&param1="+param1+"&param2=",
				success:function(resultdado){ $(param2).html(resultdado);}
			});
		}
	};
	
	$.fn.onchange_estados = function(param1,param2,param3,param4){
		if (param1!="")
		{
			$(param2).html("");
			$(param3).html("");
			$(param4).html("");
			$.ajax({
				type: "get",
				url:"../php/functions.php",
				data:"module=change_estadosTOmunicipios&param1="+param1+"&param2=",
				success:function(resultdado){ $(param2).html(resultdado);}
			});
		}
	};

	$.fn.onchange_municipios = function(param1,param2,param3){
		if (param1!="")
		{
			$(param2).html("");
			$(param3).html("");

			$.ajax({
				type: "get",
				url:"../php/functions.php",
				data:"module=change_municipiosTOlocalidad&param1="+param1+"&param2=",
				success:function(resultdado){ $(param2).html(resultdado);}
			});
		}
	};


	$.fn.onchange_localidad = function(param1,param2){
		if (param1!="")
		{
			$(param2).html("");
			$.ajax({
				type: "get",
				url:"../php/functions.php",
				data:"module=change_localidadTOcodigo_postal&param1="+param1+"&param2=",
				success:function(resultdado){ $(param2).html(resultdado);}
			});
		}
	};
	
	$.fn.onchange_departamentos = function(param1,param2){
		if (param1!="")
		{
			$(param2).html("");
			$.ajax({
				type: "get",
				url:"../php/functions.php",
				data:"module=change_departamentoTOpuesto&param1="+param1+"&param2=",
				success:function(resultdado){ $(param2).html(resultdado);}
			});
		}
	};

	$.fn.validate_generales_familiar  = function( options ) {
		var valor = false;

		if($("#nombre_f").val().length==0){ alert("Introduzca el nombre del familiar"); $("#nombre_f").focus(); } else if($("#apellido_p_f").val().length==0){ alert("Introduzca el apellido paterno del familiar"); $("#apellido_p_f").focus(); }else if($("#apellido_m_f").val().length==0){ alert("Introduzca el apellido paterno del familiar"); $("#apellido_m_f").focus(); } else if($("#edad_f").val().length==0) { alert("Introduzca la edad del familiar"); $("#edad_f").focus(); } else if($("#sexo_f").val()=="") { alert("Selecione el genero del familiar"); $("#sexo_f").focus(); } else if($("#parestesco_f").val()=="") { alert("Seleccione el parentesco del familiar"); $("#parestesco_f").focus(); } else if ($('#tipo_direccion').val()=="1") { 
			if($("#ine_f").val().length==0){ alert("Introduzca la clave INE,IFE del familiar"); $("#ine_f").focus(); } else if($("#rfc_f").val().length==0) { alert("Introduzca el RFC del familiar"); $("#rfc_f").focus();} else if($("#telefono1_f").val().length==0) { alert("Introduzca el Telefono Celular del familiar"); $("#telefono1_f").focus(); } else if($("#telefono2_f").val().length==0){ alert("Introduzca el Telefono de Casa del familiar"); $("#telefono2_f").focus(); } else if($("#telefono3_f").val().length==0){alert("Introduzca el Telefono de Oficina del familiar"); $("#telefono3_f").focus(); } else if($("#email_f").val().length==0){ alert("Seleccione los familiares del familiar"); $("#email_f").focus(); } else { valor = true; }
		} else { 


if($("#domicilio_f").val().length==0) { alert("Introduzca el domicilio del familiar"); $("#domicilio_f").focus(); } else if($("#estados_f").val()=="") {alert("Seleccione el estado al cual pertenece el familiar");$("#estados_f").focus(); } else if($("#municipios_f").val()=="") { alert("Selecione el municipio al cual pertenece el familiar"); $("#municipios_f").focus(); } else if($("#localidad_f").val().length==0) { alert("Seleccione la localidad a la cual pertenece el familiar"); $("#localidad_f").focus(); } else if($("#codigo_postal_f").val().length==0){ alert("Seleccione el Codigo Postal al cual pertenece el familiar");$("#codigo_postal_f").focus(); }else if($("#ine_f").val().length==0){ alert("Introduzca la clave INE,IFE del familiar"); $("#ine_f").focus(); } else if($("#rfc_f").val().length==0) { alert("Introduzca el RFC del familiar"); $("#rfc_f").focus();} else if($("#telefono1_f").val().length==0) { alert("Introduzca el Telefono Celular del familiar"); $("#telefono1_f").focus(); } else if($("#telefono2_f").val().length==0){ alert("Introduzca el Telefono de Casa del familiar"); $("#telefono2_f").focus(); } else if($("#telefono3_f").val().length==0){alert("Introduzca el Telefono de Oficina del familiar"); $("#telefono3_f").focus(); } else if($("#email_f").val().length==0){ alert("Seleccione los familiares del familiar"); $("#email_f").focus(); } else { valor = true; }
 }
 return valor;




	};

	$.fn.validate_generales_empleado  = function( options ) { 
		var valor = false; if($("#nombre_m").val().length==0){alert("Introduzca el nombre del empleado");$("#nombre_m").focus();}else if($("#apellido_p_m").val().length==0){ alert("Introduzca el apellido paterno del empleado"); $("#apellido_p_m").focus(); } else if($("#apellido_m_m").val().length==0) { alert("Introduzca el apellido paterno del empleado"); $("#apellido_m_m").focus(); } else if($("#edad_m").val().length==0) { alert("Introduzca la edad del empleado"); $("#edad_m").focus();} else if($("#sexo_m").val()=="") { alert("Selecione el genero del empleado"); $("#sexo_m").focus(); } else if($("#domicilio_m").val().length==0) { alert("Introduzca el domicilio del empleado"); $("#domicilio_m").focus(); } else if($("#estados_m").val()=="") { alert("Seleccione el estado al cual pertenece el empleado"); $("#estados_m").focus(); } else  if($("#municipios_m").val()=="") { alert("Selecione el municipio al cual pertenece el empleado"); $("#municipios_m").focus(); } else if($("#localidad_m").val().length==0) { alert("Seleccione la localidad a la cual pertenece el empleado"); $("#localidad_m").focus(); } else if($("#codigo_postal_m").val().length==0) { alert("Seleccione el Codigo Postal al cual pertenece el empleado"); $("#codigo_postal_m").focus(); } else if($("#ine_m").val().length==0) { alert("Introduzca la clave INE,IFE del empleado");  $("#ine_m").focus(); } else if($("#rfc_m").val().length==0) { alert("Introduzca el RFC del empleado"); $("#rfc_m").focus(); } else if($("#telefono1_m").val().length==0) { alert("Introduzca el Telefono Celular del empleado"); $("#telefono1_m").focus(); } else if($("#telefono2_m").val().length==0) { alert("Introduzca el Telefono de Casa del empleado"); $("#telefono2_m").focus(); } else if($("#telefono3_m").val().length==0) { alert("Introduzca el Telefono de Oficina del empleado"); $("#telefono3_m").focus(); } else  if($("#email_m").val().length==0) { alert("Introduzca el correo electronico del empleado"); $("#email_m").focus();  }
	 else 
	 	if($("#familiares").val().length==0) 
	 		{ 
	 			alert("Seleccione los familiares del empleado");
	 			$("#familiares").focus(); 
	 		} else if($("#departamentos_m").val()==0) { alert("Seleccione el departamento al cual pertenece el empleado"); $("#departamentos_m").focus(); } else if($("#puestos_m").val()==0){alert("Seleccione el puesto al cual pertenece el empleado"); $("#puestos_m").focus(); } else { valor = true;} return valor; };

 
    
    $.fn.activeCalendary = function ( options){

		$(options).daterangepicker(
                                    {
                                        singleDatePicker: true,
                                        showDropdowns: true,
                                        minYear: 1950,
                                        maxYear: 2100,
                                        "locale":
                                        {
                                            "format": "DD/MM/YYYY",
                                            "separator": " - ",
                                            "applyLabel": "Aplicar",
                                            "cancelLabel": "Cancelar",
                                            "fromLabel": "De",
                                            "toLabel": "Hasta",
                                            "customRangeLabel": "Personalizar",
                                            "daysOfWeek": ["Dom","Lun","Mar","Mie","Jue","Vie","Sab"],
                                            "monthNames": ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Deciembre"],
                                            "firstDay": 1
                                        }
                                    });

    };


	$.fn.inputFilter = function(inputFilter)
	{
    	return this.on("input keydown keyup mousedown mouseup select contextmenu drop",function()
    	{
			if (inputFilter(this.value))
			{
        		this.oldValue = this.value;
        		this.oldSelectionStart = this.selectionStart;
        		this.oldSelectionEnd = this.selectionEnd;
      		}
      		else if (this.hasOwnProperty("oldValue"))
      				{
        				this.value = this.oldValue;
        				this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
      				}
      			else 
      				{
        				this.value = "";
      				}
    	});
	};
	
	// ajax para fromularios relaciones
	$.fn.agregar_relaciones_cancel = function()
	{
		$('#div_relaciones').load("../php/show_interface_cliente.php?module=main_relaciones&param="+$('#idkey_cliente').val());
	};

	$.fn.agregar_relaciones = function()
	{
        if ($('#idkey_cliente').val()=="0")
        {
            alert("No se puede agregar relaciones hasta no guardar Datos Generales y Direcciones");
        }
        else
        {
	    $('#div_relaciones').load("../php/show_interface_cliente.php?module=create_fields_relaciones");
            $('#caja_busqueda').val('');
            $('#resultado_relaciones').html('');
            $('#caja_busqueda').focus();
            $('#modal_relaciones').modal('show');
        }
	};
	
	$.fn.editar_relaciones = function()
	{
        if ($('#idkey_cliente').val()=="0")
        {
            alert("No se puede agregar relaciones hasta no guardar Datos Generales y Direcciones");
        }
        else
        {
	    $('#div_relaciones').load("../php/show_interface_cliente.php?module=create_fields_relaciones&param="+$('#idkey_cliente').val());
        }
	};

	$.fn.addCliente_to_Relacion = function(param1,param2)
	{
		$('#addidkey_cliente').val(param1);
		$('#nombre_relacion').val(param2);
		$('#modal_relaciones').modal('toggle');
		$('#relaciones').focus();
	};

	$.fn.guardar_relacion = function()
	{
		if ($('#nombre_relacion').val().length==0)
		{
			alert("Debe de seleccionar un cliente para relacionar");
			$('#nombre_relacion').focus();
		}
		else
			if ($('#relaciones').val()=="")
			{
				alert("Debe de seleccionar la relacion que se tiene con dicho cliente");
				$('#relaciones').focus();
			}
			else
				if ($('#parentesco').val()=="")
				{
					alert("Debe de seleccionar el parentesco que se tiene con la persona seleccionada");
					$('#parentesco').focus();
				}
				else
				{

					$.ajax({
						type: "post",
						url:"../php/safe_general.php",
						data:"module=add_relacion_to_clients&idkey_cliente="+$('#idkey_cliente').val()+"&addidkey_cliente="+$('#addidkey_cliente').val()+"&relaciones="+$('#relaciones').val()+"&parentesco="+$('#parentesco').val()+"&nombre="+$('#nombre_relacion').val()+"&aval_hist="+$('#aval_hist').val()+"&aval_capacidad="+$('#aval_capacidad').val()+"&aval_solvencia="+$('#aval_solvencia').val()+"&porcentaje="+$('#porcentaje').val(),
						success:function(resultdado){ $.fn.agregar_relaciones_cancel();
						}
					});
				    }
				};


    // Generar reporte de cumplimiento By Moshe Ramz
    
    $.fn.generar_reporte = function()
	{
		$('#div_reporte').load("../php/show_interface_cliente.php?module=create_reporte&param="+$('#idkey_cliente').val());
	};
	
    //Factores de riesgo
 
    $.fn.factores_cancel = function()
	{
		$('#div_factores').load("../php/show_interface_cliente.php?module=main_factores&param="+$('#idkey_cliente').val());
	};
   $.fn.generar_factores = function()
	{
		$('#div_factores').load("../php/show_interface_cliente.php?module=create_factores&param="+$('#idkey_cliente').val());
	};

    // GARANTIAS MUEBLES
    $.fn.agregar_mueble_cancel = function()
	{
		$('#div_muebles').load("../php/show_interface_cliente.php?module=main_muebles&param="+$('#idkey_cliente').val());
	};
	
    $.fn.agregar_mueble = function()
	{
        if ($('#idkey_cliente').val()=="0")
	    {
		alert("No se puede agregar contactos hasta no guardar Datos Generales y Direcciones");
	    }
        else
	    {
		$('#div_muebles').load("../php/show_interface_cliente.php?module=create_fields_muebles&param="+$('#idkey_cliente').val());
	    }
	};
    //GARANTIAS INMUEBLES
    
    $.fn.agregar_inmueble_cancel = function()
	{
		$('#div_inmuebles').load("../php/show_interface_cliente.php?module=main_inmuebles&param="+$('#idkey_cliente').val());
	};
	
    $.fn.agregar_inmueble = function()
	{
        if ($('#idkey_cliente').val()=="0")
	    {
		alert("No se puede agregar contactos hasta no guardar Datos Generales y Direcciones");
	    }
        else
	    {
		$('#div_inmuebles').load("../php/show_interface_cliente.php?module=create_fields_inmuebles&param="+$('#idkey_cliente').val());
	    }
	};
	

    // Funciones contactos By Moshe Ramz
    
    $.fn.agregar_contactos_cancel = function()
	{
		$('#div_contactos').load("../php/show_interface_cliente.php?module=main_contacto&param="+$('#idkey_cliente').val());
	};

	$.fn.agregar_contacto = function()
	{
        if ($('#idkey_cliente').val()=="0")
	    {
		alert("No se puede agregar contactos hasta no guardar Datos Generales y Direcciones");
	    }
        else
	    {
		$('#div_contactos').load("../php/show_interface_cliente.php?module=create_fields_contacto");
	    }
	};
	
	$.fn.guardar_contacto = function()
	    {
		if (document.getElementById('idkey_cliente').value=="0")
		    {
			alert("Error no se puede agregar la informacion de contacto hasta que guarde los datos Generales y Domicilios");
			document.getElementById("nombre").focus();
		    }
		else
		    if (document.getElementById("contacto_descripcion").value.length==0)
			{
			    alert("Proporcione la descripcion de la informacion de contacto");
			    document.getElementById("contacto_descripcion").focus();
			}
		    else
			if (document.getElementById("contacto_telefono").value.length==0)
			    {
				alert("Proporcione el telefono de contacto del nuevo cliente");
				document.getElementById("contacto_telefono").focus();
			    }
			else
			    if (document.getElementById("contacto_email").value.length==0)
				{
				    alert("Proporcione el email de contacto del nuevo cliente");
				    document.getElementById("contacto_email").focus();
				}
			    else
				if (document.getElementById("contacto_prioridad").selectedIndex==0)
				    {
					alert("Debe de proporcionar la prioridad de contacto del nuevo cliente");
					document.getElementById("contacto_prioridad").focus();
				    }
				else
				    {
					$.ajax({
					    type: "post",
					    url:"../php/safe_general.php",
					    data:"module=clientes_contacto&idkey_cliente="+$('#idkey_cliente').val()+"&contacto_descripcion="+$('#contacto_descripcion').val()+"&contacto_telefono="+$('#contacto_telefono').val()+"&contacto_email="+$('#contacto_email').val()+"&contacto_prioridad="+$('#contacto_prioridad').val(),
					    //success:function(resultdado){ $.fn.agregar_contactos_cancel(); $(document).ready(function(){ $('#tab_siguiente').trigger('click'); }); }
					    success:function(resultdado){ $.fn.agregar_contactos_cancel(); }
					    });
				    }
				}
				
		// Funciones ingresos By Moshe Ramz
    
		$.fn.agregar_ingreso_cancel = function()
		    {
			    $('#div_ingresos').load("../php/show_interface_cliente.php?module=main_ingresos&param="+$('#idkey_cliente').val());
		    };

		$.fn.agregar_ingreso = function()
		    {
		    if ($('#idkey_cliente').val()=="0")
			{
			    alert("No se puede agregar ingresos hasta no guardar Datos Generales y Direcciones");
			}
		    else
			{
			    $('#div_ingresos').load("../php/show_interface_cliente.php?module=create_fields_ingresos");
			}
		    };
		$.fn.guardar_ingreso = function()
			{
			    if (document.getElementById('idkey_cliente').value=="0")
				{
				    alert("Error no se puede agregar la informacion de contacto hasta que guarde los datos Generales y Domicilios");
				    document.getElementById("nombre").focus();
				}
			    else
				if (document.getElementById("ingreso_tipo").selectedIndex==0)
				    {
					alert("Proporcione el tipo de ingreso");
					document.getElementById("ingreso_tipo").focus();
				    }
				else
				    if (document.getElementById("ingreso_frec").value.length==0)
					{
					    alert("Proporcione la Frecuencia de Cobro");
					    document.getElementById("ingreso_frec").focus();
					}
				    else
					if (document.getElementById("monto").value.length==0)
					    {
						alert("Proporcione el Monto de ingreso");
						document.getElementById("monto").focus();
					    }
					else
					    {
						principal = 0;
						if (document.getElementById("principal").checked==true) principal=1;
						$.ajax({
						
						type: "post",
						url:"../php/safe_general.php",
						data:"module=clientes_ingresos&idkey_cliente="+$('#idkey_cliente').val()+"&principal="+principal+"&ingreso_tipo="+$('#ingreso_tipo').val()+"&ingreso_frec="+$('#ingreso_frec').val()+"&monto="+$('#monto').val()+"&id_empleador="+$('#id_empleador').val()+"&f_inicio="+$('#f_inicio').val()+"&f_fin="+$('#f_fin').val()+"&profesion="+$('#profesion').val()+"&ocupacion="+$('#ocupacion').val()+"&jefe_directo="+$('#jefe_directo').val()+"&bajo_contrato="+$('#bajo_contrato').val()+"&ingreso_desc="+$('#ingreso_desc').val()+"&actividad_siti="+$('#actividad_siti').val()+"&domicilio_empleador="+$('#domicilio_empleador').val()+"&ingreso_comprobable="+$('#ingreso_comprobable').val(),
						//success:function(resultdado){ $.fn.agregar_ingreso_cancel(); $(document).ready(function(){ $('#egresos_head').trigger('click'); });
						success:function(resultdado){ $.fn.agregar_ingreso_cancel();}
						});
					    }
					};
						
		
		// Funciones egresos By Moshe Ramz
    
		$.fn.agregar_egreso_cancel = function()
		    {
			    $('#div_egresos').load("../php/show_interface_cliente.php?module=main_egresos&param="+$('#idkey_cliente').val());
		    };

		$.fn.agregar_egreso = function()
		    {
		    if ($('#idkey_cliente').val()=="0")
			{
			    alert("No se puede agregar ingresos hasta no guardar Datos Generales y Direcciones");
			}
		    else
			{
			    $('#div_egresos').load("../php/show_interface_cliente.php?module=create_fields_egresos");
			}
		    };
		$.fn.guardar_egreso = function()
			{
			    if (document.getElementById('idkey_cliente').value=="0")
				{
				    alert("Error no se puede agregar la informacion de contacto hasta que guarde los datos Generales y Domicilios");
				    document.getElementById("nombre").focus();
				}
			    else
				if (document.getElementById("tipo_egreso").selectedIndex==0)
				    {
					alert("Proporcione el tipo de Egreso");
					document.getElementById("tipo_egreso").focus();
				    }
				else
				    if (document.getElementById("frecuencia_egreso").value.length==0)
					{
					    alert("Proporcione la Frecuencia de Pago");
					    document.getElementById("frecuencia_egreso").focus();
					}
				    else
					if (document.getElementById("monto_egreso").value.length==0)
					    {
						alert("Proporcione el Monto de Pago");
						document.getElementById("monto_egreso").focus();
					    }
					else
					    {
						$.ajax({
						
						type: "post",
						url:"../php/safe_general.php",
						data:"module=clientes_egresos&idkey_cliente="+$('#idkey_cliente').val()+"&tipo_egreso="+$('#tipo_egreso').val()+"&frecuencia_egreso="+$('#frecuencia_egreso').val()+"&monto_egreso="+$('#monto_egreso').val()+"&inicio_egreso="+$('#inicio_egreso').val()+"&fin_egreso="+$('#fin_egreso').val()+"&descripcion_egreso="+$('#descripcion_egreso').val()+"&tipo_pago="+$('#tipo_pago').val(),
						success:function(resultdado){ $.fn.agregar_egreso_cancel(); }
						});
					    }
					};    
	}( jQuery ));


   function Left(str, n)
    {
        if (n <= 0)
            return "";
        else if (n > String(str).length)
          return str;
        else
          return String(str).substring(0,n);
    }
                        
    function Mid(str, start, len)
    {
        if (start < 0 || len < 0) return "";
        var iEnd, iLen = String(str).length;
        if (start + len > iLen)
            iEnd = iLen;
        else
          iEnd = start + len;
        return String(str).substring(start,iEnd);
    }
                        
    function Right(str, n)
    {
        if (n <= 0)
        return "";
      else if (n > String(str).length)
        return str;
      else {
        var iLen = String(str).length;
        return String(str).substring(iLen, iLen - n);
      }
    }




function guardarGeneral()
{


    if (document.getElementById("nombre").value.length==0)
    {
        alert('Introduzca el nombre del cliente!');
        document.getElementById("nombre").focus();
    }
    else
        if (document.getElementById("apellido_p").value.length==0)
        {
            alert('Introduzca el apellido paterno del cliente!');
            document.getElementById("apellido_p").focus();
        }
        else
            if (document.getElementById("apellido_m").value.length==0)
            {
                alert('Introduzca el apellido materno del cliente!');
                document.getElementById("apellido_m").focus();
            }
            else
                if (document.getElementById("nacimiento").value.length==0)
                {
                    alert('Seleccione la fecha de nacimiento!');
                    document.getElementById("apellido_m").focus();
                }
                else
                    {
                        request_ajax="";
                        ajax_processingdata("../php/check_general.php?module=cliente_check_birtday&nacimiento="+document.getElementById('nacimiento').value,"","get")
                        if (request_ajax==-1)
                        {
                        	alert("La fecha de nacimiento es invalidad");
                        	document.getElementById("nacimiento").focus();
                        }
                        else
	                        if (request_ajax==0)
	                        {
	                            alert("La edad de cliente debe ser mayor de 18 años!");
	                            document.getElementById("nacimiento").focus();
	                        }
	                        else
	                        {
	                        	if (document.getElementById("genero").options[document.getElementById("genero").selectedIndex].value=="")
	                        	{
	                        		alert("Seleccione el genero del Cliente");
	                        		document.getElementById("genero").focus();
	                        	}
	                        	else
	                        		if (document.getElementById("rfc").value.length<13)
	                        		{
	                        			alert("Debe de proporcionar el RFC del Cliente");
	                        			document.getElementById("rfc").focus();
	                        		}
	                        		else
	                        			if (document.getElementById("curp").value.length<18)
	                        			{
		                        			alert("Debe de proporcionar el CURP del Cliente");
	    	                    			document.getElementById("curp").focus();
	                        			}
	                        			else
	                        				if (document.getElementById("domicilio").value.length==0)
	                        				{
			                        			alert("Introduzca la calle donde habita el cliente");
		    	                    			document.getElementById("domicilio").focus();
	                        				}
	                        				else
		                        				if (document.getElementById("exterior").value.length==0)
		                        				{
				                        			alert("Introduzca el numero exterior donde habita el cliente");
			    	                    			document.getElementById("exterior").focus();
		                        				}
		                        				else
			                        				if (document.getElementById("interior").value.length==0)
			                        				{
					                        			alert("Introduzca el numero interior donde habita el cliente");
			    		                    			document.getElementById("interior").focus();
		            	            				}
		            	            				/*else
														if (document.getElementById("codigo_postal").selectedIndex==0)
		                        						{
				                        					alert("Debe de seleccione el Estado,Ciudad,Localidad y Codigo postal de donde habita el cliente");
			    	                    					document.getElementById("estados").focus();
		                        						}*/
		                        						else
		                        						{

									                        request_ajax="";
	                        								ajax_processingdata("../php/check_general.php?module=cliente_check_habita&inicia_habitar="+document.getElementById('inicia_habitar').value,"","get");
	                        								if (request_ajax==0)
	                        								{
	                        									alert("La fecha cuando empezo a habitar en la direccion señalada debe ser menor a la actual");
	                        									document.getElementById('inicia_habitar').focus();
	                        								}
	                        								else
							                        			{
							                        				request_ajax="";
							                        				ajax_processingdata("../php/safe_general.php","module=clients_new&idkey_cliente="+document.getElementById("idkey_cliente").value+"&nombre="+document.getElementById("nombre").value+"&apellido_p="+document.getElementById("apellido_p").value+"&apellido_m="+document.getElementById("apellido_m").value+"&nacimiento="+document.getElementById("nacimiento").value+"&sexo="+document.getElementById("genero").options[document.getElementById("genero").selectedIndex].value+"&rfc="+document.getElementById("rfc").value+"&curp="+document.getElementById("curp").value+"&domicilio="+document.getElementById("domicilio").value+"&exterior="+document.getElementById("exterior").value+"&interior="+document.getElementById("interior").value+"&estados="+document.getElementById("estados").options[document.getElementById("estados").selectedIndex].value+"&municipios="+document.getElementById("municipios").options[document.getElementById("municipios").selectedIndex].value+"&localidad="+document.getElementById("localidad").options[document.getElementById("localidad").selectedIndex].value+"&codigo_postal="+document.getElementById("codigo_postal").options[document.getElementById("codigo_postal").selectedIndex].value+"&inicia_habitar="+document.getElementById("inicia_habitar").value+"&entrecalles="+document.getElementById("entrecalles").value+"&referencia="+document.getElementById("referencia").value+"&observaciones="+document.getElementById("observaciones").value+"&identificacion="+document.getElementById("identificacion").value+"&num_id="+document.getElementById("num_id").value+"&vigencia="+document.getElementById("vigencia").value+"&idkey_promotor="+document.getElementById("idkey_promotor").value,"post");

							                        				if (request_ajax==-1)
							                        				{
							                        					alert("No se puede actualizar los datos con un RFC que ya existe en la base de datos!");
							                        					document.getElementById("rfc").focus();
							                        				}
							                        				else
							                        					if (request_ajax==0)
							                        					{
							                        						alert("El RFC del nuevo cliente ya existe en la base de datos por favor verificar!");
							                        						document.getElementById("rfc").focus();
							                        					}
							                        					else
							                        					{
							                        						//document.getElementById("idkey_cliente").value=request_ajax;
							                        						alertify.notify('Datos guardados correctamente!', 'success', 5);
							                        						location.href="clientes_alta.php?idkey_cliente="+request_ajax.trim();
							                        					}
							                        			}
		                        						}
                        }
                    }    
}

//
function guardar_socio_economico(param)
{
    	if (param=="0")
	{
		alert("Error no se puede agregar la informacion de contacto hasta que guarde los datos Generales y Domicilios");
		document.getElementById("nombre").focus();
	}
	else
		if (document.getElementById("vivienda").selectedIndex==0)
		{
			alert("No ha seleccionado tipo de vivienda");
			document.getElementById("vivienda").focus();
		}
		else
			if (document.getElementById("material").selectedIndex==0)
			{
				alert("No ha seleccionado tipo de material");
				document.getElementById("material").focus();		
			}
			else
			if (document.getElementById("piso").selectedIndex=='')
			{
				alert("No ha seleccionado tipo de piso");
				document.getElementById("piso").focus();		
			}
			else
			if (document.getElementById("hacinamiento").selectedIndex==0)
			{
				alert("No ha seleccionado tipo de hacinamiento");
				document.getElementById("hacinamiento").focus();		
			}
			else
			if (document.getElementById("techo").selectedIndex==0)
			{
				alert("No ha seleccionado tipo de techo");
				document.getElementById("techo").focus();		
			}
			else
			if (document.getElementById("residentes").value.length==0)
			{
				alert("No ha indicado el total de residentes");
				document.getElementById("residentes").focus();		
			}
			else
			{
				//Servicios
				agua = 0;
				if (document.getElementById("servicio1").checked==true) agua=1;
				electri = 0;
				if (document.getElementById("servicio2").checked==true) electri=1;
				telefono = 0;
				if (document.getElementById("servicio3").checked==true) telefono=1;
				drenaje = 0;
				if (document.getElementById("servicio4").checked==true) drenaje=1;
				ant_cable = 0;
				if (document.getElementById("servicio5").checked==true) ant_cable=1;
				//electros
				estufa=0;
				if (document.getElementById("electro1").checked==true) estufa=1;
				lavadora=0;
				if (document.getElementById("electro2").checked==true) lavadora=1;
				refri=0;
				if (document.getElementById("electro3").checked==true) refri=1;
				tele = 0;
				if (document.getElementById("electro4").checked==true) tele=1;
				estereo=0;
				if (document.getElementById("electro5").checked==true) estereo=1;
				compu=0;
				if (document.getElementById("electro6").checked==true) compu=1;
				//habitaicones
				sala=0;
				if (document.getElementById("habit1").checked==true) sala=1;
				comedor=0;
				if (document.getElementById("habit2").checked==true) comedor=1;
				cocina=0;
				if (document.getElementById("habit3").checked==true) cocina=1;
				bano_p=0;
				if (document.getElementById("habit4").checked==true) bano_p=1;
				//Detalles
				servicios_detalle=document.getElementById("servicios_detalle").value;
				electro_detalle=document.getElementById("electro_detalle").value;
				habitaciones_detalle=document.getElementById("habitaciones_detalle").value;
				vivienda_detalle=document.getElementById("vivienda_detalle").value;
				hacinamiento_detalle=document.getElementById("hacinamiento_detalle").value;
				techo_detalle=document.getElementById("techo_detalle").value;
				material_detalle=document.getElementById("material_detalle").value;
				piso_detalle=document.getElementById("piso_detalle").value;
				//
				residentes=document.getElementById("residentes").value;
				observaciones=document.getElementById("observaciones_economico").value;
				vivienda=document.getElementById("vivienda").options[document.getElementById("vivienda").selectedIndex].value;
				hacinamiento=document.getElementById("hacinamiento").options[document.getElementById("hacinamiento").selectedIndex].value;
				techo=document.getElementById("techo").options[document.getElementById("techo").selectedIndex].value;
				material=document.getElementById("material").options[document.getElementById("material").selectedIndex].value;
				piso=document.getElementById("piso").options[document.getElementById("piso").selectedIndex].value;
				
				    
				request_ajax="";
				ajax_processingdata("../php/safe_general.php","idkey_cliente="+document.getElementById("idkey_cliente").value+
				"&module=guardar_socio_economico&agua="+agua+"&electri="+electri+"&telefono="+telefono+"&drejane="+drenaje+
				"&ant_cable="+ant_cable+"&estufa="+estufa+"&lavadora="+lavadora+"&refri="+refri+"&tele="+tele+"&estereo="+estereo+
				"&compu="+compu+"&sala="+sala+"&comedor="+comedor+"&cocina="+cocina+"&bano_p="+bano_p+"&servicios_detalle="+servicios_detalle+
				"&electro_detalle="+electro_detalle+"&habitaciones_detalle="+habitaciones_detalle+"&vivienda_detalle="+vivienda_detalle+
				"&hacinamiento_detalle="+hacinamiento_detalle+"&techo_detalle="+techo_detalle+"&material_detalle="+material_detalle+
				"&piso_detalle="+piso_detalle+"&observaciones="+observaciones+"&vivienda="+vivienda+"&hacinamiento="+hacinamiento+
				"&techo="+techo+"&material="+material+"&piso="+piso+"&residentes="+residentes,"post");
				alertify.notify("Datos guardados correctamente!");
				$(document).ready(function(){ $('#tab_siguiente').trigger('click'); });
	}
		       

	
}

//
function guardar_datos_adicionales(param)
{
	if (param=="0")
	{
		alert("Error no se puede agregar la informacion de contacto hasta que guarde los datos Generales y Domicilios");
		document.getElementById("nombre").focus();
	}
	else
		/*if (document.getElementById("estado_civil").selectedIndex==0)
		{
			alert("Debe de seleccionar el estado civil del nuevo cliente");
			document.getElementById("estado_civil").focus();
		}
		else*/
			if (document.getElementById("nivel_academico").selectedIndex==0)
			{
				alert("Debe de seleccionar el nivel academico del nuevo cliente");
				document.getElementById("nivel_academico").focus();		
			}
			else
			
			{

				indigena=0;
				penales=0;
				politica=0;
				regimen_fiscal="";
				fecha_sat="";
				dependientes=0;
				if (document.getElementById("indigena").checked==true) indigena=1;
				if (document.getElementById("penales").checked==true) penales=1;
				if (document.getElementById("politica").checked==true) politica=1;
				regimen_fiscal=document.getElementById("regimen_fiscal").options[document.getElementById("regimen_fiscal").selectedIndex].value;
				fecha_sat=document.getElementById("fecha_sat").value;
				email_facturacion=document.getElementById("email_facturacion").value;
				domicilio_fiscal=document.getElementById("domicilio_fiscal").value;
				fiel=document.getElementById("fiel").value;
				cedula=document.getElementById("cedula").value;
				dependientes=document.getElementById("dependientes").value;
				id_cargo=document.getElementById("id_cargo").options[document.getElementById("id_cargo").selectedIndex].value;
				inicio_cargo=document.getElementById("inicio_cargo").value;
				fin_cargo = document.getElementById("fin_cargo").value;
				    
				request_ajax="";
				ajax_processingdata("../php/safe_general.php","idkey_cliente="+document.getElementById("idkey_cliente").value+"&module=clientes_datos_adicionales&estado_civil="+document.getElementById("estado_civil").options[document.getElementById("estado_civil").selectedIndex].value+"&nivel_academico="+document.getElementById("nivel_academico").options[document.getElementById("nivel_academico").selectedIndex].value+"&indigena="+indigena+"&penales="+penales+"&politica="+politica+"&dependientes="+dependientes+"&regimen_fiscal="+regimen_fiscal+"&fecha_sat="+fecha_sat+"&email_facturacion="+email_facturacion+"&domicilio_fiscal="+domicilio_fiscal+"&fiel="+fiel+"&cedula="+cedula+"&id_cargo="+id_cargo+"&inicio_cargo="+inicio_cargo+"&fin_cargo="+fin_cargo,"post");
				alertify.notify("Datos guardados correctamente!");
				$(document).ready(function(){ $('#tab_siguiente').trigger('click'); });
	}
}


// Guardar garantias Muebles By Moshe Ramz
    function guardar_garantia_mueble(param)
	{
	    if (param=="0")
	{
		alert("Error no se puede agregar la informacion de contacto hasta que guarde los datos Generales y Domicilios");
		document.getElementById("nombre").focus();
	}
	else
	    if (document.getElementById("garantias_categorias").selectedIndex==0)
	    {
		    alert("Debe especificar categoria de la garantia");
		    document.getElementById("garantias_categorias").focus();		
	    }
	    else
		if  (document.getElementById("valor_comercial").value.length==0)
		    {
			alert("Debe especificar valor comercial");
			document.getElementById("valor_comercial").focus();		
		    }
		else
		    if  (document.getElementById("marca").value.length==0)
		    {
			alert("Debe especificar Marca");
			document.getElementById("marca").focus();		
		    }
		    else
			if  (document.getElementById("modelo").value.length==0)
			    {
				alert("Debe especificar Modelo");
			    document.getElementById("modelo").focus();		
			    }
			else
			    if  (document.getElementById("referencia_factura").value.length==0)
			    {
				alert("Debe especificar La Referencia o Número de factura");
				document.getElementById("referencia_factura").focus();		
			    }
			    else
			    {
				garantia_categoria = document.getElementById("garantias_categorias").options[document.getElementById("garantias_categorias").selectedIndex].value;
				//garantia_tipo = document.getElementById("garantias_tipos").options[document.getElementById("garantias_tipos").selectedIndex].value;
				mueble_observaciones = document.getElementById("mueble_observaciones").value;
				referencia_factura = document.getElementById("referencia_factura").value;
				fecha_adquisicion = document.getElementById("fecha_adquisicion").value;
				marca = document.getElementById("marca").value;
				modelo = document.getElementById("modelo").value;
				valor_comercial = document.getElementById("valor_comercial").value;
				cobertura = document.getElementById("cobertura").options[document.getElementById("cobertura").selectedIndex].value;

				request_ajax="";
				ajax_processingdata("../php/safe_general.php","idkey_cliente="+document.getElementById("idkey_cliente").value+"&module=cliente_mueble&valor_comercial="+valor_comercial+"&modelo="+modelo+"&marca="+marca+"&fecha_adquisicion="+fecha_adquisicion+"&referencia_factura="+referencia_factura+"&mueble_observaciones="+mueble_observaciones+"&garantias_categorias="+garantia_categoria+"&cobertura="+cobertura,"post");
				alertify.notify("Datos guardados correctamente! Continúe con la captura");
				$(document).ready(function(){$.fn.agregar_mueble_cancel(); });
				
				
				
			    }
			}
	//Actualiza estatus credito
	function actualizar_credito()
	{
	    if ($('#estatus_id').val().length==0)
	    {
		alert("Debe seleccionar nuevos estatus de credito");
		$('#estatus_id').focus();
	    }
	    else   
	    {
	    
	    $.ajax({
	    type: "post",
	    url:"../php/safe_general.php",
	    data:{module:"actualizar_credito",
		idkey_cliente:$('#idkey_cliente').val(),
		idkey_credito:$('#idkey_credito').val(),
		observacion:$('#razon_estatus').val(),
		estatus_id:$('#estatus_id').val()
		},
	    success:function(data){ }
		});
	    }
	}
	
	//Guardar factores

	function guardar_factores()
	{
	    if ($('#referencias').val().length==''){
		alert("Debe Seleccionar alguna de las siguientes opciones");
		document.getElementById("tipo_producto").focus();
		}
	    else
		{
		$.ajax({
		type: "post",
		url:"../php/safe_general.php",
		data:{module:"guardar_factores",
		    idkey_cliente:$('#idkey_cliente').val(),
		    referencias:$('#referencias').val(),
		    veracidad:$('#veracidad').val(),
		    garantia_liquida:$('#garantia_liquida').val(),
		    conocimiento:$('#conocimiento').val(),
		    capacidad_pago:$('#capacidad_pago').val(),
		    solvencia:$('#solvencia').val(),
		    experiencia_crediticia:$('#experiencia_crediticia').val(),
		    historial_interno:$('#historial_interno').val(),
		    historial_buro:$('#historial_buro').val(),
		    bienes_declarados:$('#bienes_declarados').val(),
		    cobertura:$('#cobertura').val(),
		    aforo:$('#aforo').val(),
		    edad:$('#edad').val(),
		    ocupacion:$('#ocupacion').val(),
		    arraigo_laboral:$('#arraigo_laboral').val(),
		    arraigo_domiciliario:$('#arraigo_domiciliario').val(),
		    tipo_vivienda:$('#tipo_vivienda').val(),
		    comprobante:$('#comprobante').val()
		    },
		success:function(data){ 
		    $('#tab_siguiente').trigger('click'); 
		    alertify.notify("Datos guardados correctamente! Continúe con la captura");
		    }
		
		});
	    }
	};
	
	//Guardar grupo from dual list

	function guardar_grupo()
	{
		if ($('#nombre_grupo').val()=="")
		{
			alert("Debe de sasignar un nombre al grupo");
			$('#nombre_grupo').focus();
		}
		else
		    {
			var clientes = new Array();//storing the selected values inside an array
			$('#duallist :selected').each(function(i, selected) {
			    clientes[i] = $(selected).val();
			});
			
			request_ajax="";
			$.ajax({
			type: "post",
			url:"../php/safe_general.php",
			data:{module:"guardar_grupo",
			    nombre_grupo:$('#nombre_grupo').val(),
			    promotor:$('#idkey_promotor').val(),
			    clientes:clientes
			    },
			success:function(data){ location.href="form-creargrupo.php?idkey_cliente="+$.trim(data); }
		});
	    }
	}
	function actualizar_grupo()
	{
	    var clientes = new Array();//storing the selected values inside an array
	    $('#duallist :selected').each(function(i, selected) {
		clientes[i] = $(selected).val();
	    });
	    idkey_cliente=$('#idkey_cliente').val();
	    $.ajax({
	    type: "post",
	    url:"../php/safe_general.php",
	    data:{module:"actualizar_grupo",
		idkey_cliente:$('#idkey_cliente').val(),
		clientes:clientes
		},
	    success:function(data){
		//alert(data);
		location.href="form-creargrupo.php?idkey_cliente="+idkey_cliente;
		}
	    });
	}
	//Actualiza los porcentajes de cadaa socio en un grupo definido
	function actualizar_socios()
	{	
	    
            selects = $("[name^='porcentaje']");
	    var post_settings = [];
	    selects.each(function(i,select) {    
		var obj = {
		  'idkey_socio': $(select).attr('id'),
		  'porcentaje': $(select).val()
		}
		post_settings.push(obj);
	      });
	      //alert(post_settings);
	    
	    request_ajax="";
	    idkey_cliente = $('#idkey_cliente').val();
	    $.ajax({
	    type: "post",
	    url:"../php/safe_general.php",
	    data:{module:"actualizar_socios",
		idkey_cliente:$('#idkey_cliente').val(),
		post_settings
		},
	    success:function(data){ location.href="form-creargrupo.php?idkey_cliente="+idkey_cliente;}
		});
	};
	
	//Guardar credito

	function guardar_credito()
	{
	if ($('#tipo_producto').val().length==0)
	{
		alert("Debe selecionar un producto");
		$('#nombre_grupo').focus();
	}
	else
	    {
		idkey_cliente=$('#idkey_cliente').val();
		tipo_credito=$('#tipo_credito').val();
		folio=$('#folio').val();
		$.ajax({
		type: "post",
		url:"../php/safe_general.php",
		data:{module:"guardar_credito",
		    idkey_cliente:$('#idkey_cliente').val(),
		    folio:$('#folio').val(),
		    producto:$('#tipo_producto').val(),
		    monto:$('#monto_credito').val(),
		    plazo:$('#plazo_meses').val(),
		    frecuencia:$('#frecuencia_pago').val(),
		    pagos:$('#numero_pagos').val(),
		    interes:$('#tasa_interes').val(),
		    pago_1:$('#fecha_pago1').val(),
		    finalidad:$('#finalidad').val(),
		    tipo_credito:$('#tipo_credito').val()
		    },
		success:function(data){ 
		    //Falta incluir idkey_cliente para recupera informaicón
		    window.location="nuevo_credito-enviado.php?idkey_cliente="+idkey_cliente+"&tipo="+tipo_credito+"&folio="+folio;
		    }
		});
	    }
	};
	
	
	
// Guardar garantias inmuebles By Moshe Ramz

    function guardar_garantia_inmueble(param)
	{
	    if (param=="0")
	{
		alert("Error no se puede agregar la informacion de contacto hasta que guarde los datos Generales y Domicilios");
		document.getElementById("nombre").focus();
	}
	else		
	    if (document.getElementById("garantias_categorias").selectedIndex==0)
	    {
		    alert("Debe especificar categoria de la garantia");
		    document.getElementById("garantias_categorias").focus();		
	    }
	    else
		if  (document.getElementById("valor_comercial_2").value.length==0)
		    {
			alert("Debe especificar valor comercial");
			document.getElementById("valor_comercial_2").focus();		
		    }
		else
		    if  (document.getElementById("hipoteca").value.length==0)
		    {
			alert("Debe especificar Marca");
			document.getElementById("hipoteca").focus();		
		    }
		    else
			if  (document.getElementById("escritura").value.length==0)
			    {
				alert("Debe especificar Modelo");
			    document.getElementById("escritura").focus();		
			    }
			else
			    if  (document.getElementById("valor_fiscal").value.length==0)
			    {
				alert("Debe especificar La Referencia o Número de factura");
				document.getElementById("valor_fiscal").focus();		
			    }
			    else
			    {
				garantia_categoria = document.getElementById("garantias_categorias").options[document.getElementById("garantias_categorias").selectedIndex].value;
				//garantia_tipo = document.getElementById("garantias_tipos").options[document.getElementById("garantias_tipos").selectedIndex].value;
				inmueble_observaciones = document.getElementById("inmueble_observaciones").value;
				inmueble_descripcion = document.getElementById("inmueble_descripcion").value;
				hipoteca = document.getElementById("hipoteca").value;
				gravamen = document.getElementById("gravamen").value;
				inmueble_medidas = document.getElementById("inmueble_medidas").value;
				registro = document.getElementById("registro").value;
				escritura = document.getElementById("escritura").value;
				valor_catastral = document.getElementById("valor_catastral").value;
				valor_fiscal = document.getElementById("valor_fiscal").value;
				valor_comercial = document.getElementById("valor_comercial_2").value;
				aforo = document.getElementById("aforo").options[document.getElementById("aforo").selectedIndex].value;
				
				//if (document.getElementById("con_escritura").checked==true) con_escritura=1;

				request_ajax="";
				ajax_processingdata("../php/safe_general.php","idkey_cliente="+document.getElementById("idkey_cliente").value+"&module=cliente_inmueble&valor_comercial_2="+valor_comercial+"&valor_fiscal="+valor_fiscal+"&valor_catastral="+valor_catastral+"&escritura="+escritura+"&registro="+registro+"&inmueble_medidas="+inmueble_medidas+"&gravamen="+gravamen+"&hipoteca="+hipoteca+"&inmueble_descripcion="+inmueble_descripcion+"&inmueble_observaciones="+inmueble_observaciones+"&garantias_categorias="+garantia_categoria+"&aforo="+aforo,"post");
				alertify.notify("Datos guardados correctamente! Continúe con la captura");
				$(document).ready(function(){$.fn.agregar_inmueble_cancel(); });
			    }
			}
